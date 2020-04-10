<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Template extends Model
{
    protected $fillable = ['name', 'description', 'type', 'active', 'parameters', 'media_url', 'user_id'];

    protected $appends = ['files'];


    public static function createNewTemplate (array $attributes = [])
    {
        auth()->user()->templates()->create($attributes);

        Storage::disk('templates')->makeDirectory($attributes['name']);
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

        Storage::disk('templates')->move($oldName, $this->name);

    }



    public function activate ()
    {

        // Copy all the files to the view directory.

        array_map(function ($file) {

            // Do this operation for blade files only.
            if(Str::endsWith($file, 'blade.php'))
            {
                // Before copying, delete the file if it is already there.
                if(Storage::disk('active')->exists($file))
                {
                    Storage::disk('active')->delete($file);
                }

                // Then copy the file.
                Storage::disk('active')->writeStream(
                    basename($file),
                    Storage::disk('templates')->readStream($file)
                );
            }

        }, Storage::disk('templates')->files($this->name));


        // activate the database

        Template::update(['active' => 0]);

        $this->active = 1;

        $this->save();
    }




    public function getFilesAttribute()
    {
        $files = Storage::disk('templates')->files($this->name);

        return array_map(function ($file) {
            return [
                'name' => $file,
                'updated' => \Carbon\Carbon::createFromTimestamp(
                    Storage::disk('templates')->lastModified($file)
                ),
                'size' => Storage::disk('templates')->size($file)
            ];
        }, $files);
    }


    // public static function bladeFileName($id)
    // {
    //     return 'file-' . str_pad ($id, 6, "0", STR_PAD_LEFT);
    // }


    // public function createBladeFile($contents)
    // {
    //     $name = self::bladeFileName($this->id);
    //     Storage::disk('store')->put($name, $contents);
    // }


    // public function getBladeFile()
    // {
    //     $name = self::bladeFileName($this->id);

    //     if (Storage::disk('store')->exists($name)) {
    //         return Storage::disk('store')->get($name);
    //     }
    //     else {
    //         return '';
    //     }
    // }


    // public function deleteBladeFile()
    // {
    //     $name = self::bladeFileName($this->id);
    //     Storage::disk('store')->delete($name);
    // }


    // public function updateBladeFile($content)
    // {
    //     $name = self::bladeFileName($this->id);

    //     Storage::disk('store')->delete($name);
    //     Storage::disk('store')->put($name, $content);

    //     // after we change a blade file, if the blade file
    //     // is an active blade, i.e. currently in use,
    //     // then we will also need to reload it.
    //     if ($this->active) {
    //         $this->loadBladeFile();
    //     }

    // }


    // public function loadBladeFile()
    // {
    //     $targetBladeFileName = $this->type . '.blade.php';

    //     // take a temporary backup before replacing the target file
    //     if (Storage::disk('template')->exists($targetBladeFileName)) {
    //         Storage::disk('template')->move($targetBladeFileName, $targetBladeFileName . '.bkp');
    //     }

    //     $name = self::bladeFileName($this->id);

    //     // attempt to copy the file from local
    //     try {
    //         Storage::disk('template')->writeStream(
    //             $targetBladeFileName,
    //             Storage::disk('store')->readStream($name)
    //         );

    //         // delete the backup file after successful completion of above file copy
    //         Storage::disk('template')->delete($targetBladeFileName . '.bkp');

    //     } catch (\Exception $e) {
    //         // if unsuccessful, revert back the previous file
    //         Storage::disk('template')->move($targetBladeFileName . '.bkp', $targetBladeFileName);

    //         throw $e;
    //     }
    // }


}
