<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\User;

class LovController extends Controller
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
     * Display a listing of the categories.
     */
    public function categories()
    {
        $categories = Cache::rememberForever('categories.lov', function () {

            return Category::withTrashed()->get()->sortBy('id')->map (function ($item) {
                return [
                    'key' => $item['id'],
                    'value' => $item['name'],
                    'trashed' => $item['deleted_at'] != null
                ];
            })->all();
        });

        return response()->json($categories);
    }



    /**
     * Display a listing of the authors.
     */
    public function authors()
    {
        $authors = User::where('role', 'admin')->orWhere('role', 'author')
            ->withTrashed()
            ->get()
            ->sortBy('id')
            ->map(function ($author) {
                return [
                    "key" => $author['id'],
                    "value" => $author['name'],
                    "trashed" => $author['deleted_at'] != null
                ];
            })->all();

        return response()->json($authors);
    }

}
