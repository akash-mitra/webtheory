<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Media;
use App\Page;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'avatarfile' => ['sometimes', 'required', 'image'],
            'avatar_base64' => ['sometimes', 'required'],
        ]);

        $user = $request->user();

        if ($request->has('avatarfile')) {
            $uploadedFile = $request->file('avatarfile');

            $media = Media::store($uploadedFile, Str::slug($user->id), 'media/profiles', false);

            $user->avatar = $media->url;
        }

        if ($request->has('avatar_base64')) {
            $media = Media::storeFromBase64(
                $request->input('avatar_base64'),
                Str::slug($user->id),
                'media/profiles',
                false
            );

            $user->avatar = $media->url;
        }

        $user->fill(request(['name', 'about_me', 'gender', 'dob', 'profile', 'preferences']))->save();

        return response()->json($user);
    }

    public function pages($public)
    {
        $user = User::findByPublicId($public);

        return $user
            ->pages()
            ->where('status', 'Live')
            ->with(['media', 'category'])
            ->paginate(10);
    }

    /**
     * Comments made by the Auth User under categories or pages.
     *
     * @return JsonResponse
     */
    public function comments(): JsonResponse
    {
        $id = Auth::id();

        $categoryComments = Category::with('comments')
            ->whereHas('comments', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        $pageComments = Page::with('comments')
            ->whereHas('comments', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        return response()->json(['categories' => $categoryComments, 'pages' => $pageComments]);
    }
}
