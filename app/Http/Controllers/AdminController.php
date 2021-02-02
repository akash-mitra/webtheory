<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'check.permission']);
    }

    public function app()
    {
        return view('app', [
            'authUser' => Auth::user()->only(['id', 'name', 'email', 'avatar', 'role']),
        ]);
    }
}
