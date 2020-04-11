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

            // Exclude the hidden files starting with "."
            if(! Str::startsWith($file, '.'))
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

}
