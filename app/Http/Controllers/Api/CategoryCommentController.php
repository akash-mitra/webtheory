<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryCommentRequest;
use App\Category;
use App\CategoryComment;

class CategoryCommentController extends Controller
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
        return response()->json(Category::with('comments.user')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCommentRequest $request)
    {
        $categorycomment = new CategoryComment([
            'parent_id' => $request->parent_id,
            'reference_id' => $request->reference_id,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);
        $categorycomment->save();

        return response()->json($categorycomment);
    }

    /**
     * Display the specified resource.
     *
     * @param  CategoryComment  $categorycomment
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryComment $categorycomment)
    {
        return response()->json($categorycomment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CategoryComment  $categorycomment
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryCommentRequest $request, CategoryComment $categorycomment)
    {
        $categorycomment->fill(request(['body']))->save();

        return response()->json($categorycomment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CategoryComment  $categorycomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryComment $categorycomment)
    {
        $categorycomment->delete();
        
        return response()->json("success", 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CategoryComment  $categorycomment
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, CategoryComment $categorycomment)
    {
        $categorycomment->increment('likes');

        return response()->json($categorycomment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CategoryComment  $categorycomment
     * @return \Illuminate\Http\Response
     */
    public function dislike(Request $request, CategoryComment $categorycomment)
    {
        $categorycomment->increment('dislikes');

        return response()->json($categorycomment);
    }
}
