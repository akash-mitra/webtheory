<?php

namespace App;

use Exception;
use ZipArchive;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    protected $fillable = ['name', 'description', 'type', 'active', 'parameters', 'media_url', 'user_id'];

    protected $appends = ['files'];


    /**
     * Returns a list of templates from repository that can be imported
     * or installed.
     */
    public static function getFromRepo()
    {
        $templateFiles = Storage::disk('repo')->allDirectories('templates');

        return array_map(function ($templateFileName) {

            $templateName = Str::after($templateFileName, 'templates/');

            return self::getTemplateInfoFromFile($templateName);

        }, $templateFiles);
    }



    /**
     * Reads template info file if present and returns the data in an array
     */
    private static function getTemplateInfoFromFile($name, $disk = 'repo')
    {
        $info = [
            'name' => $name,
            'description' => 'No description is available for this template.',
            'version' => 0,
            'media_url' => 'https://source.unsplash.com/random',
            'parameters' => (object)[]
        ];

        $path = '';

        if ($disk === 'repo') {
            $path = "templates/{$name}/.info";
        }

        if ($disk === 'templates') {
            $path = "{$name}/.info";
        }

        if(Storage::disk($disk)->exists($path))
        {
            $fileData = json_decode(Storage::disk($disk)->get($path), true);

            $info = array_replace_recursive($info, $fileData);
        }

        return (object) $info;
    }



    public static function createNewTemplate (array $attributes = [])
    {
        $template = auth()->user()->templates()->create($attributes);

        Storage::disk('templates')->makeDirectory($attributes['name']);

        return $template;
    }



    public function addFile ($name, $code)
    {
        // if the file already exists, delete the file!
        $this->deleteFile($name);

        Storage::disk('templates')->put($this->name . '/' . $name, $code);

        if($this->active)
        {
            // if this is an active template,
            // we need to update the file in active views directory as well
            // if the file already exists, delete the file!
            if (Storage::disk('active')->exists($name))
            {
                Storage::disk('active')->delete($name);
            }

            Storage::disk('active')->put($name, $code);
        }
    }



    public function deleteFile($name)
    {
        if (Storage::disk('templates')->exists($this->name . '/' . $name))
        {
            return Storage::disk('templates')->delete($this->name . '/' . $name);
        }
    }



    public function updateTemplate (array $attributes = [])
    {
        $oldName = $this->name;

        $this->fill($attributes)->save();

        if($oldName != $this->name)
        {
            Storage::disk('templates')->move($oldName, $this->name);
        }

        $this->clearTemplateParametersCache();
    }



    public function activate ()
    {

        //clean the contents from active directory
        self::cleanActive();

        // Copy all the files to the active view directory.
        $this->copyToActive();

        // activate the database
        Template::query()->update(['active' => false]);

        $this->active = true;

        $this->save();

        // delete cache for template paramters
        $this->clearTemplateParametersCache();
    }



    public function copyToActive()
    {
        $files = Storage::disk('templates')->files($this->name);

        foreach($files as $file)
        {
            // copy only .php and .info files to active folder
            if (! in_array(strtolower (pathinfo($file, PATHINFO_EXTENSION)),['info', 'php'])) {
                continue;
            }

            if(Storage::disk('active')->exists(basename($file))) {
                Storage::disk('active')->delete(basename($file));
            }

            // Then copy the file.
            Storage::disk('active')->writeStream(
                basename($file),
                Storage::disk('templates')->readStream($file)
            );
        }
    }



    public static function cleanActive()
    {
        return Storage::delete(Storage::disk('active')->files());
    }




    public function getFilesAttribute()
    {
        $files = Storage::disk('templates')->files($this->name);

        return array_map(function ($file) {

            $fileName = basename($file);

            return [
                'name' => $fileName,
                'updated' => \Carbon\Carbon::createFromTimestamp(
                    Storage::disk('templates')->lastModified($file)
                )->format('d M, Y. H:m'),
                'size' => round(Storage::disk('templates')->size($file) / 1024, 1),
                'identity' => base64_encode($fileName)
            ];

        }, $files);
    }



    public function deleteTemplate()
    {
        Storage::disk('templates')->deleteDirectory($this->name);

        $this->delete();
    }



    public function duplicate($saveAs)
    {
        self::createNewTemplate([
            'name' => $saveAs,
            'description' => $this->description,
            'media_url' => $this->media_url,
            'parameters' => $this->parameters,
            'active' => false,
        ]);

        array_map(function ($file) use ($saveAs) {

            Storage::disk('templates')->copy($file, $saveAs . '/' . basename($file));

        }, Storage::disk('templates')->files($this->name));
    }



    public static function import($from, $name)
    {
        $fromTemplate = self::getTemplateInfoFromFile($from);

        $template = self::createNewTemplate([
            'name' => $name,
            'description' => $fromTemplate->description,
            'media_url' => $fromTemplate->media_url,
            'parameters' => json_encode($fromTemplate->parameters),
            'active' => false,
        ]);

        // copy files to template

        self::copyFromRepoToTemplate($from, $name);

        return $template;
    }



    public static function copyFromRepoToTemplate($from, $name)
    {
        $files = Storage::disk('repo')->allFiles('templates/' . $from);

        foreach($files as $file)
        {
            // copy only .php, .info and assets files to template folder
            if (! in_array(strtolower (pathinfo($file, PATHINFO_EXTENSION)),[
                'info',
                'php',
                'js',
                'css'
            ])) {
                continue;
            }

            if(Storage::disk('templates')->exists($name . '/' . basename($file))) {
                Storage::disk('templates')->delete($name . '/' . basename($file));
            }

            // Then copy the file.
            Storage::disk('templates')->writeStream(
                $name . '/' . basename($file),
                Storage::disk('repo')->readStream($file)
            );
        }
    }


    public function download()
    {
        $zipFile = Str::slug($this->name) . '.zip';

        $zipper = new ZipArchive();
        $zipper->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        array_map(function ($file) use ($zipper){

            return $zipper->addFile(
                Storage::disk('templates')->path($file),
                basename($file)
            );

        }, Storage::disk('templates')->allFiles($this->name));

        $zipper->close();

        return response()->download($zipFile)->deleteFileAfterSend();
    }



    public static function createFromUpload($name, $file)
    {
        $template = null;

        try {

            // create the template
            $template = Template::createNewTemplate(['name' => $name]);

            // save the zip file as 'bundle.zip' in the template folder
            Storage::disk('templates')->putFileAs($template->name, $file, 'bundle.zip');

            // // delete the original uploaded zip file from the public folder
            // Storage::delete($file);

            // unzip the bundle.zip
            self::unzipTemplateBundle($template->name);

            // delete the original bundle.zip file
            Storage::disk('templates')->delete($template->name . '/bundle.zip');

            // check if there is a .info file in the extract
            $info = self::getTemplateInfoFromFile($template->name, 'templates');
            $template->description = $info->description;
            $template->media_url = $info->media_url;
            $template->parameters = json_encode($info->parameters);
            $template->save();

            return $template;

        } catch(Exception $e) {

            // if there is any error, anywhere above,
            // we will revert back all the changes.

            // revert database
            if ($template) {
                $template->delete();
            }

            // revert storage
            if (Storage::disk('templates')->exists($name))
            {
                Storage::disk('templates')->deleteDirectory($name);
            }

            throw $e;
        }
    }


    private static function unzipTemplateBundle($templateName)
    {
        $path = Storage::disk('templates')->path($templateName);
        $zip = new ZipArchive();
        $files = [];

        if ($zip->open($path . '/bundle.zip') === TRUE) {

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);

                if(substr($filename, 0, 9) === "__MACOSX/") {
                    continue;
                }

                if(in_array(basename($filename), ['.DS_Store', '', ' ', null])) {
                    continue;
                }

                if (! in_array(
                    strtolower (pathinfo($filename, PATHINFO_EXTENSION)),
                    ['bmp', 'css', 'gif', 'htm', 'html', 'ico', 'info', 'jpeg', 'jpg', 'js', 'pdf', 'php', 'png', 'ts', 'txt', 'vue'])
                ) {
                    continue;
                }

                array_push($files, $filename);

                if($fileData = $zip->getFromName($filename)) {

                    Storage::disk('templates')->put($templateName . '/' . basename($filename), $fileData);
                }
            }
            $zip->close();

        }

        return $files;
    }


    public static function clearTemplateParametersCache()
    {
        Cache::forget('template.parameters');
    }

}
