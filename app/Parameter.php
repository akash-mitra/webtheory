<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Cache;

class Parameter
{
    public static function getKey(String $key) {
        return Cache::rememberForever($key, function () use ($key) {
            $matched = DB::table('parameters')->where('key', $key)->first();
            if(!is_null($matched))
                return $matched->value;
            return null;
        });
    }

    public static function setKey(String $key, String $value) {
        Cache::forget($key);
        DB::table('parameters')->updateOrInsert(
            ['key' => $key],
            ['value' => $value]
        );
        return $value;
    }
}
