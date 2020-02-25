<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    protected $fillable = ['name', 'description', 'type', 'active', 'parameters', 'media_url', 'user_id'];



    public static function bladeFileName($id)
    {
        return 'file-' . str_pad ($id, 6, "0", STR_PAD_LEFT);
    }


    public function createBladeFile($contents)
    {
        $name = self::bladeFileName($this->id);
        Storage::disk('store')->put($name, $contents);
    }


    public function getBladeFile()
    {
        $name = self::bladeFileName($this->id);

        if (Storage::disk('store')->exists($name)) {
            return Storage::disk('store')->get($name);
        }
        else {
            return '';
        }
    }


    public function deleteBladeFile()
    {
        $name = self::bladeFileName($this->id);
        Storage::disk('store')->delete($name);
    }


    public function updateBladeFile($content)
    {
        $name = self::bladeFileName($this->id);

        Storage::disk('store')->delete($name);
        Storage::disk('store')->put($name, $content);

        // after we change a blade file, if the blade file
        // is an active blade, i.e. currently in use,
        // then we will also need to reload it.
        if ($this->active) {
            $this->loadBladeFile();
        }

    }


    public function loadBladeFile()
    {
        $targetBladeFileName = $this->type . '.blade.php';

        // take a temporary backup before replacing the target file
        if (Storage::disk('template')->exists($targetBladeFileName)) {
            Storage::disk('template')->move($targetBladeFileName, $targetBladeFileName . '.bkp');
        }

        $name = self::bladeFileName($this->id);

        // attempt to copy the file from local
        try {
            Storage::disk('template')->writeStream(
                $targetBladeFileName,
                Storage::disk('store')->readStream($name)
            );

            // delete the backup file after successful completion of above file copy
            Storage::disk('template')->delete($targetBladeFileName . '.bkp');

        } catch (\Exception $e) {
            // if unsuccessful, revert back the previous file
            Storage::disk('template')->move($targetBladeFileName . '.bkp', $targetBladeFileName);

            throw $e;
        }
    }


}
