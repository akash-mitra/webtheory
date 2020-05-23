<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Media;
use App\Http\Requests\MediaRequest;
use Illuminate\Http\UploadedFile;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return response()->json(Media::with('author')->get());

        $media = Media::query();

        /**
         * This builds a "like" query based on the query string.
         * It breaks the query string in individual words and
         * tries to match any of those words in image name.
         */
        $query = $request->input('query');

        if (! empty($query))
        {
            $queryArray = explode(" ", $query);
            // a false where statement so that "or" condition below works
            $media->where('id', 0);

            foreach($queryArray as $q) {
                if (! empty($q)) $media->orWhere('name', 'like', '%' . $q . '%');
            }
        }

        return $media->latest()->paginate(100);
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
                "file" => $media
            ];
        } else {
            return [
                "success" => 0,
                "file" => [ 'id' => null, 'path' => null, 'url' => null ]
            ];
        }
    }

    public function uploadurl(Request $request)
    {
        if ($request->has('url')) {
            $url = $request->url;

            // $arrContextOptions = [
            //     "ssl" => [
            //         "verify_peer"=>false,
            //         "verify_peer_name"=>false,
            //     ],
            // ];
            // $urlcontent = file_get_contents($url, false, stream_context_create($arrContextOptions));

            $tempfile = tmpfile();
            $tempfilepath = (string) stream_get_meta_data($tempfile)['uri'];

            $urlcontent = file_get_contents($url);
            file_put_contents($tempfilepath, $urlcontent);
            $uploadedFile = new UploadedFile($tempfilepath, 'test');

            $media =  Media::store($uploadedFile);
            return [
                "success" => 1,
                "file" => $media
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

        return response()->json($media, 204);
    }
}
