<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function create ()
    {
        $version = request('version');
        return view('backend.pages.editor' . $version);
    }
}
