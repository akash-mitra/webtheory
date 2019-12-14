<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageContent;

class PageController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('category', 'author', 'media')->get();

        return view('page.index', compact('pages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $page->load('content', 'category', 'author', 'media');
        
        return view('page.show', compact('page'));
    }
}
