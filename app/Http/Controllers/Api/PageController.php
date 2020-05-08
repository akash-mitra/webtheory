<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Page;
use App\PageContent;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Http\Requests\PageStatusRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Converters\ContentsConverter;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission'])->except('comments');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::with('category', 'author', 'media')
            ->latest()
            ->get();

        return response()->json($pages);
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

        Page::invalidateCache();

        DB::transaction(function () use ($request, &$page) {

            $page = new Page([
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'summary' => $request->summary,
                'metakey' => $request->metakey,
                'metadesc' => $request->metadesc,
                'media_id' => $request->media_id,
                'status' => $request->status
            ]);

            $page->save();

            $converter = new ContentsConverter($request->body_json, $request->editor);

            $pagecontent = new PageContent([
                'body_json' => $request->body_json,
                'body_html' => $converter->getHtml(),
                'editor' => $request->editor,
            ]);

            $page->content()->save($pagecontent);
        });

        $page->load('content');

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
        $page->load('content', 'category', 'author', 'media');

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
        Page::invalidateCache();

        DB::transaction(function () use ($request, &$page) {

            $page->fill(request([
                'category_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status'
            ]))->save();

            $converter = new ContentsConverter($request->body_json, $request->editor);

            $page->content()->update([
                'body_json' => $request->body_json,
                'body_html' => $converter->getHtml(),
                'editor' => $request->editor,
            ]);
        });

        $page->load('content');

        return response()->json($page);
    }



    /**
     * Update the page status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(PageStatusRequest $request, Page $page)
    {
        Page::invalidateCache();

        $page->fill([
            'status' => $request->status
        ])->save();

        return response()->json($page);
    }



    /**
     * Update the page owner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function updateOwner(Request $request, Page $page)
    {
        Page::invalidateCache();

        $page->fill(request(['user_id']))->save();

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
        Page::invalidateCache();

        $page->delete();

        return response()->json("success", 204);
    }
}
