<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageCommentRequest;
use App\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Parameter;
use App\Traits\SpamProtection;

class PageCommentController extends Controller
{
    use SpamProtection;

    public function index(Page $page): JsonResponse
    {
        $comments = $page
            ->directComments()
            ->with(['user', 'replies.user'])
            ->latest('updated_at')
            ->paginate(5);

        return response()->json($comments);
    }

    public function store(Page $page, PageCommentRequest $request): JsonResponse
    {
        $this->preventSpamIfCaptchaConfigured();

        $comment = $page->comments()->create([
            'body' => $request->body,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
        ]);

        if ($comment->isReply()) {
            $comment->parent()->touch();
        }

        return response()->json($comment);
    }
}
