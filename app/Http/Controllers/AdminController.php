<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // catch all route under /app 
    public function app()
    {
        return view('app');
    }
}
