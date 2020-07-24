<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Artisan;
use Exception;
use DB;
use App\PageComment;
use App\View;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
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

    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');

        return response()->json('Saved', 200);
    }
}
