<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Page;
use App\PageContent;
use App\Parameter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Converters\ContentsConverter;
use App\Http\Requests\PageStatusRequest;
use Illuminate\Database\Eloquent\Builder;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission'])->except(['search']);

        if (Parameter::getKey('SEARCHABLE')) {
            config(['scout.driver' => 'algolia']);
            config(['scout.algolia.id' => Parameter::getKey('ALGOLIA_APP_ID')]);
            config(['scout.algolia.secret' => Parameter::getKey('ALGOLIA_SECRET')]);
        }
    }

    public function index(Request $request)
    {
        $pagesQuery = Page::query()->with('category', 'author', 'media');

        if ($request->input('type') === 'draft') {
            $pagesQuery->where('status', 'Draft');
        }

        return $this->queryPages($pagesQuery, $request);
    }

    private function queryPages($queryBuilder, $request)
    {
        $queryBuilder = $this->filterByQueryString(
            $queryBuilder,
            ['title', 'summary', 'category.name', 'author.name'],
            $request->input('query')
        );

        if ($request->user()->isAdmin()) {
            $queryBuilder->withTrashed();
        }

        return $queryBuilder->latest()->paginate(10);
    }

    // public function index(Request $request)
    // {
    //     $pages = Page::query()->with('category', 'author', 'media');

    //     /**
    //      * This builds a "like" query based on the query string.
    //      * It breaks the query string in individual words and
    //      * tries to match any of those words in image name.
    //      */
    //     $query = $request->input('query');

    //     if (! empty($query))
    //     {
    //         $queryArray = explode(" ", $query);
    //         // a false where statement so that "or" condition below works
    //         $pages->where('id', 0);

    //         foreach($queryArray as $q) {
    //             if (! empty($q)) {
    //                 $pages->orWhere('title', 'like', '%' . $q . '%');
    //                 $pages->orWhere('summary', 'like', '%' . $q . '%');
    //                 $pages->orWhereHas('category', function (Builder $query) use ($q) {
    //                     $query->where('name', 'like', '%' . $q . '%');
    //                 });
    //                 $pages->orWhereHas('author', function (Builder $query) use ($q) {
    //                     $query->where('name', 'like', '%' . $q . '%');
    //                 });
    //             }
    //         }
    //     }

    //     return $pages->latest()->paginate(2);
    // }

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
                'status' => $request->status,
                'access_plan' => $request->access_plan,
                'options' => $request->options,
            ]);

            $page->save();
            
            $content = $request->content;
            foreach($content as $pagecontent) {
                PageContent::addOrModify($page, $pagecontent);
            }
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
            $page
                ->fill(
                    request([
                        'category_id',
                        'title',
                        'summary',
                        'metakey',
                        'metadesc',
                        'media_id',
                        'status',
                        'access_plan',
                        'options',
                    ])
                )
                ->save();

            $content = $request->content;
            foreach($content as $pagecontent) {
                PageContent::addOrModify($page, $pagecontent);
            }
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

        $page
            ->fill([
                'status' => $request->status,
            ])
            ->save();

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

        return response()->json($page->load('author'));
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

        return response()->json('success', 204);
    }

    /**
     * Remove the specified page content from storage.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroyContent(PageContent $pagecontent)
    {
        Page::invalidateCache();

        $pagecontent->delete();

        return response()->json('success', 204);
    }

    /**
     * Enhances a query builder with additional conditions for
     * matching the query string with the list of columns.
     */
    private function filterByQueryString(Builder $queryBuilder, array $cols, $queryString)
    {
        if (!empty($queryString)) {
            $keywords = explode(' ', $queryString);

            $queryBuilder->where(function ($builder) use ($keywords, $cols) {
                foreach ($keywords as $keyword) {
                    if (!empty($keyword)) {
                        foreach ($cols as $col) {
                            if (Str::contains($col, '.')) {
                                $relation = explode('.', $col);
                                $builder->orWhereHas($relation[0], function (Builder $query) use (
                                    $relation,
                                    $keyword
                                ) {
                                    $query->where($relation[1], 'like', '%' . $keyword . '%');
                                });
                            } else {
                                $builder->orWhere($col, 'like', '%' . $keyword . '%');
                            }
                        }
                    }
                }
            });
        }
        return $queryBuilder;
    }

    public function search(Request $request)
    {
        return Page::search($request->get('query'))->paginate(10);
    }
}
