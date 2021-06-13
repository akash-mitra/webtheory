<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageCommentRequest;
use App\Page;
use App\PageComment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Traits\SpamProtection;

class PageCommentController extends Controller
{
    use SpamProtection;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission'])->only(['destroy']);
    }

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

   /**
    * Remove the specified page comment from storage.
    *
    * @param PageComment $pageComment
    * @return JsonResponse
    * @throws Exception
    */
    public function destroy(PageComment $pageComment): JsonResponse
    {
        $pageComment->delete();

        return response()->json('success', 204);
    }
}
