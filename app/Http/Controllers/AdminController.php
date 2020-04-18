<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['check.permission']);

        // $this->middleware('auth');
    }



    // catch all route under /app
    public function app()
    {
        return view('app', [
            'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email', 'avatar', 'role']) : null // check() is temporary
        ]);
    }
}
