<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Category;
use App\Media;
use App\Page;

class ProfileController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'avatarfile' => ['sometimes', 'required', 'image'],
            'avatar_base64' => ['sometimes', 'required'],
        ]);

        $user = $request->user();

        if ($request->has('avatarfile')) {

            $uploadedFile = $request->file('avatarfile');

            $media =  Media::store(
                $uploadedFile,
                Str::slug($user->id),
                'media/profiles',
                false
            );

            $user->avatar = $media->url;
        }

        if ($request->has('avatar_base64')) {

            $media = Media::storeFromBase64(
                $request->avatar_base64,
                Str::slug($user->id),
                'media/profiles',
                false
            );

            $user->avatar = $media->url;
        }


        $user->fill(request(['name', 'about_me', 'gender', 'dob', 'preferences']))
            ->save();

        return response()->json($user);
    }

    /**
     * Update the user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, User $user)
    {
        $user->fill(request(['role']))->save();

        return response()->json($user);
    }


    public function pages($public)
    {
        $user = User::findByPublicId($public);

        return $user->pages()->with(['media', 'category'])->paginate(4);
    }


    // public function comments(Page $page)
    // {
    //     $categorycomments = Category::with('comments')->whereHas('comments', function ($query) {
    //         $query->where('user_id', Auth::id());
    //     })->get();

    //     $pagecomments = Page::with('comments')->whereHas('comments', function ($query) {
    //         $query->where('user_id', Auth::id());
    //     })->get();

    //     return response()->json(["categories" => $categorycomments, "pages" => $pagecomments]);
    // }
}
