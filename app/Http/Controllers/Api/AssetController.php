<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Asset;
use App\Traits\SearchQueryFilter;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AssetController extends Controller
{
    use SearchQueryFilter;

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
     * Display a listing of all the assets.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return $this->applyQueryFilter(
            Asset::query(),
            ['name'],
            $request->input('query')
        )->latest()->paginate(100);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AssetRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => ['required', 'file', 'max:25600'],
            ]);
            $uploadedFile = $request->file('image');
        } else {
            $request->validate([
                'file' => ['required', 'file', 'max:25600'],
            ]);
            $uploadedFile = $request->file('file');
        }
        
        if (! $request->hasFile('image') && ! $request->hasFile('file'))
            abort(400, 'Cannot Laaa');

        $asset = Asset::store($uploadedFile);

        return response()->json([
            'success' => 1,
            'file' => $asset,
        ]);
    }

    /**
     * Download an asset file from the given url.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function fetch(Request $request): JsonResponse
    {
        $request->validate([
            'url' => ['required', 'url']
        ]);

        $url = $request->input('url');

        // if the file URL is from the same website where this blog is hosted,
        // we can simply return the URL as no need to save the file again.
        if (parse_url($url, PHP_URL_HOST) === parse_url(url('/'), PHP_URL_HOST)) {
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $url,
                ],
            ]);
        }

        // FOR SPACES CDN
        if (parse_url($url, PHP_URL_HOST) === parse_url(Asset::pathToPublicUrl("dummy"), PHP_URL_HOST)) {
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $url,
                ],
            ]);
        }

        $asset = Asset::download($url);

        return response()->json([
            'success' => 1,
            'file' => $asset,
        ]);
    }

    /**
     * Return the specified file object.
     *
     * @param Asset $asset
     * @return JsonResponse
     */
    public function show(Asset $asset): JsonResponse
    {
        $asset->load('author');
        return response()->json($asset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Asset $asset
     * @return JsonResponse
     * @throws Exception
     */
    public function remove(Asset $asset): JsonResponse
    {
        $asset->delete();

        return response()->json($asset);
    }
}
