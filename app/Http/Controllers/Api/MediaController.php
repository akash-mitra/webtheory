<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Media;
use App\Http\Requests\MediaRequest;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Media::with('author')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(MediaRequest $request)
    {
        if ($request->file('image')->isValid()) {
            $uploadedFile = $request->file('image');
            $media =  Media::store($uploadedFile);
            return [
                "success" => 1,
                "file" => [ 'id' => $media['id'], 'path' => $media['path'], 'url' => $media['url'] ]
            ];
        } else {
            return [
                "success" => 0,
                "file" => [ 'id' => null, 'path' => null, 'url' => null ]
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        $media->load('author');
        return response()->json($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
     * @return \Illuminate\Http\Response
     */
    public function remove(Media $media)
    {
        Media::_destroy($media);
        
        return response()->json("success", 204);
    }
}
