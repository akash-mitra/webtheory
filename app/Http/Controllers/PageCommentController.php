<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PageCommentRequest;
use App\Page;
use App\PageComment;

class PageCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Page::with('comments.user')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageCommentRequest $request)
    {
        $pagecomment = new PageComment([
            'parent_id' => $request->parent_id,
            'reference_id' => $request->reference_id,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);
        $pagecomment->save();

        return response()->json($pagecomment);
    }

    /**
     * Display the specified resource.
     *
     * @param  PageComment  $pagecomment
     * @return \Illuminate\Http\Response
     */
    public function show(PageComment $pagecomment)
    {
        return response()->json($pagecomment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PageComment  $pagecomment
     * @return \Illuminate\Http\Response
     */
    public function update(PageCommentRequest $request, PageComment $pagecomment)
    {
        $pagecomment->fill(request(['body']))->save();

        return response()->json($pagecomment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PageComment  $pagecomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageComment $pagecomment)
    {
        $pagecomment->delete();
        
        return response()->json("success", 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PageComment  $pagecomment
     * @return \Illuminate\Http\Response
     */
    public function like(Request $request, PageComment $pagecomment)
    {
        $pagecomment->increment('likes');

        return response()->json($pagecomment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PageComment  $pagecomment
     * @return \Illuminate\Http\Response
     */
    public function dislike(Request $request, PageComment $pagecomment)
    {
        $pagecomment->increment('dislikes');

        return response()->json($pagecomment);
    }
}
