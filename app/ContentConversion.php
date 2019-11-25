<?php

namespace App;

class ContentConversion
{
    private static $body_json;
    private static $body_html;

    public static function getHtml(String $body_json)
    {
        self::$body_json = $body_json;
        self::$body_html = $body_json;
        
        return self::$body_html;
    }
}
