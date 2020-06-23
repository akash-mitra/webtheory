<?php

namespace App;

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
    private static function getTemplateInfoFromFile($name)
    {
        $info = [
            'name' => $name,
            'description' => 'No description is available for this template.',
            'version' => 0,
            'media_url' => 'https://source.unsplash.com/random',
            'parameters' => (object)[]
        ];

        if(Storage::disk('repo')->exists("templates/{$name}/.info"))
        {
            $fileData = json_decode(Storage::disk('repo')->get("templates/{$name}/.info"), true);

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
        if (Storage::disk('templates')->exists($this->name . '/' . $name))
        {
            Storage::disk('templates')->delete($this->name . '/' . $name);
        }

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

        // Copy all the files to the view directory.

        array_map(function ($file) {

            // Exclude the hidden files starting with "."
            if(! Str::startsWith($file, '.'))
            {
                // Before copying, delete the file if it is already there.
                if(Storage::disk('active')->exists(basename($file)))
                {
                    Storage::disk('active')->delete(basename($file));
                }

                // Then copy the file.
                Storage::disk('active')->writeStream(
                    basename($file),
                    Storage::disk('templates')->readStream($file)
                );
            }

        }, Storage::disk('templates')->files($this->name));


        // activate the database

        Template::query()->update(['active' => false]);

        $this->active = true;

        $this->save();

        // delete cache for template paramters
        $this->clearTemplateParametersCache();
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

        array_map(function ($file) use ($name) {

            if(! Str::startsWith(basename($file), '.'))
            {
                Storage::disk('templates')->writeStream(
                    $name . '/' . basename($file),
                    Storage::disk('repo')->readStream($file)
                );
            }

        }, Storage::disk('repo')->allFiles('templates/' . $from));

        return $template;
    }


    public static function clearTemplateParametersCache()
    {
        Cache::forget('template.parameters');
    }

}
