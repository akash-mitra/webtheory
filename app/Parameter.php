<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Cache;

class Parameter
{
    public static function getKey(string $key)
    {
        return Cache::rememberForever('parameters.' . $key, function () use ($key) {
            return optional(
                DB::table('parameters')
                    ->where('key', $key)
                    ->first()
            )->value;
        });
    }

    public static function setKey(string $key, string $value)
    {
        Cache::forget('parameters.' . $key);

        DB::table('parameters')->updateOrInsert(['key' => $key], ['value' => $value]);

        return $value;
    }
}
