<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // catch all route under /app 
    public function app()
    {
        // Auth::loginUsingId(1);

        // Auth::logout();

        return view('app', [
            'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email', 'avatar', 'role']) : null // check() is temporary
        ]);
    }
}
