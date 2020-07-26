<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Page;
use App\PageComment;
use App\User;
use Cache;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['check.permission']);
        $this->middleware('auth');
    }

    public function pagesCount()
    {
        $count = Cache::rememberForever('pages.count', function () {
            return Page::count();
        });

        return $count;
    }

    public function usersCount()
    {
        $count = Cache::rememberForever('users.count', function () {
            return User::count();
        });

        return $count;
    }

    public function topComments()
    {
        $comments = PageComment::with(['page', 'user'])
            ->whereNull('parent_id')
            ->latest()
            ->take(10)
            ->get();

        return response()->json($comments);
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');

        return response()->json('Saved', 200);
    }
}
