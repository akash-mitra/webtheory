<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\CategoryComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCommentRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Parameter;
use App\Traits\SpamProtection;

class CategoryCommentController extends Controller
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

    public function index(Category $category): JsonResponse
    {
        $comments = $category
            ->directComments()
            ->with(['user', 'replies.user'])
            ->latest('updated_at')
            ->paginate(5);

        return response()->json($comments);
    }

    public function store(Category $category, CategoryCommentRequest $request): JsonResponse
    {
        $this->preventSpamIfCaptchaConfigured();

        $comment = $category->comments()->create([
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
     * Remove the specified resource from storage.
     *
     * @param CategoryComment $categoryComment
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(CategoryComment $categoryComment): JsonResponse
    {
        $categoryComment->delete();

        return response()->json('success', 204);
    }

    /**
     * Increment the number of likes for the comment.
     *
     * @param CategoryComment $categoryComment
     * @return JsonResponse
     */
    public function like(CategoryComment $categoryComment): JsonResponse
    {
        $categoryComment->increment('likes');

        return response()->json($categoryComment);
    }

    /**
     * Increment the number of dislikes for the comment.
     *
     * @param CategoryComment $categoryComment
     * @return JsonResponse
     */
    public function dislike(CategoryComment $categoryComment): JsonResponse
    {
        $categoryComment->increment('dislikes');

        return response()->json($categoryComment);
    }
}
