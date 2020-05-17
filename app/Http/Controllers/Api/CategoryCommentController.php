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
    
    public function index(Category $category)
    {
        $comments = $category->directComments()
            ->with(['user', 'replies.user'])
            ->latest('updated_at')
            ->paginate(5);

        return response()->json($comments);
    }

    public function store(Category $category, CategoryCommentRequest $request)
    {
        $comment = $category->comments()->create([
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
        ]);

        if($comment->isReply())
        {
            $comment->parent()->touch();
        }

        return response()->json($comment);
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
