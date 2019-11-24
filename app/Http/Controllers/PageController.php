<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests\PageRequest;
use App\Page;
use App\PageContent;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Page::with('category', 'author')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $page = null;
        DB::transaction(function () use ($request, &$page) {
            $page = new Page([
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'summary' => $request->summary,
                'metakey' => $request->metakey,
                'metadesc' => $request->metadesc,
                'status' => 'Draft'
            ]);
            $page->save();

            $pagecontent = new PageContent(['body' => $request->body]);
            $page->content()->save($pagecontent);
        });

        $page->load('content', 'category', 'author');

        return response()->json($page);
    }

    /**
     * Display the specified resource.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $page->load('content', 'category', 'author');
        
        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        DB::transaction(function () use ($request, &$page) {
            $page->fill(request(['category_id', 'title', 'summary', 'metakey', 'metadesc', 'status']))->save();
            $page->content()->update(['body' => $request->body]);
        });
        
        $page->load('content', 'category', 'author');
        
        return response()->json($page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        
        return response()->json("success", 204);
    }
}
