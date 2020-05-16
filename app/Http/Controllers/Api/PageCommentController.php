<?php

namespace App\Http\Controllers\Api;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PageCommentController extends Controller
{

    public function index(Page $page)
    {
        $comments = $page->directComments()
            ->with(['user', 'replies.user'])
            ->latest('updated_at')
            ->paginate(5);

        return response()->json($comments);
    }


    public function store(Page $page, Request $request)
    {
        $request->validate([
            'body' => ['required'],
            'parent_id' => ['nullable', 'exists:page_comments,id']
        ]);

        $comment = $page->comments()->create([
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
}
