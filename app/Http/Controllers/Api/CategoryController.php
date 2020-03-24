<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
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
    public function index()
    {
        return response()->json(Category::with('media', 'author')->get());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::invalidateCache();

        $category = new Category([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'metakey' => $request->metakey,
            'metadesc' => $request->metadesc,
            'media_id' => $request->media_id,
            'user_id' => Auth::id(),
        ]);
        $category->save();

        return response()->json($category);
    }



    /**
     * Display the specified resource.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load('media', 'author');
        return response()->json($category);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        Category::invalidateCache();

        $category->fill(request(['name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id']))->save();

        return response()->json($category);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::invalidateCache();

        $category->delete();

        return response()->json("success", 204);
    }



    /**
     * Display the pages under a category.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function pages(Category $category)
    {
        $category->load('pages.author');

        return response()->json($category);
    }

    /**
     * Display the comments under a category.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function comments(Category $category)
    {
        $category->load('comments.user', 'comments.subcomments');

        return response()->json($category);
    }
}
