<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload ()
    {
        
        $uploadedFile = request()->file('image');
        
        $media =  Media::store ($uploadedFile);

        return [
            "success" => 1,
            "file" => [ "url" => $media['url'] ]
        ];
    }
}
