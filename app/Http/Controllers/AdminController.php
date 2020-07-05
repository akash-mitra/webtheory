<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        if (Auth::check()) {
            $this->middleware(['check.permission']);
        }
    }

    public function app()
    {
        if (Auth::check()) {
            return view('app', [
                'authUser' => Auth::user()->only(['id', 'name', 'email', 'avatar', 'role']),
            ]);
        } else {
            return redirect('/');
        }
    }
}
