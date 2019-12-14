<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        // $this->middleware(['auth']);
    }
    
    /**
     * Display a listing of the categories.
     */
    public function categories()
    {
        $categories = Category::withTrashed()->get()->sortBy('id');

        $categories = array_map(function ($category) {
            return [
                "key" => $category['id'],
                "value" => $category['name'],
                "trashed" => $category['deleted_at'] === null ? 'N' : 'Y'
            ];
        }, $categories->toArray());
        
        return response()->json($categories); 
    }

    /**
     * Display a listing of the authors.
     */
    public function authors()
    {
        $authors = User::where('is_admin', true)->orWhere('is_author', true)->withTrashed()->get()->sortBy('id');

        $authors = array_map(function ($author) {
            return [
                "key" => $author['id'],
                "value" => $author['name'],
                "trashed" => $author['deleted_at'] === null ? 'N' : 'Y'
            ];
        }, $authors->toArray());
        
        return response()->json($authors); 
    }
    
}
