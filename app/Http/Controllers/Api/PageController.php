<?php

namespace App\Http\Controllers\Api;

use App\Traits\SearchQueryFilter;
use DB;
use App\Page;
use App\PageContent;
use App\Parameter;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PageStatusRequest;
use Throwable;

class PageController extends Controller
{
    use SearchQueryFilter;

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

    /**
     * Display a listing of the pages, filtered by the given search query.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $queryBuilder = Page::query()->with('category', 'author', 'media');

        if ($request->input('type') === 'draft') {
            $queryBuilder->where('status', 'Draft');
        }

        if ($request->user()->isAdmin()) {
            $queryBuilder->withTrashed();
        }

        return $this->filterByKeywords($queryBuilder, $request->input('query'));
    }

    private function filterByKeywords($queryBuilder, $keywords): LengthAwarePaginator
    {
        return $this->applyQueryFilter(
            $queryBuilder,
            ['title', 'summary', 'category.name', 'author.name'],
            $keywords
        )->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(PageRequest $request): JsonResponse
    {
        $page = (object)[];

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

            foreach ($request->contents as $content) {
                PageContent::addOrModify($page, $content);
            }
        });

        $page->load('contents');

        return response()->json($page);
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function show(Page $page): JsonResponse
    {
        $page->load('contents', 'category', 'author', 'media');

        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param Page $page
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(PageRequest $request, Page $page): JsonResponse
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

            foreach ($request->contents as $content) {
                PageContent::addOrModify($page, $content);
            }
        });

        $page->load('contents');

        return response()->json($page);
    }

    /**
     * Update the page status.
     *
     * @param PageStatusRequest $request
     * @param Page $page
     * @return JsonResponse
     */
    public function updateStatus(PageStatusRequest $request, Page $page): JsonResponse
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
     * @param Request $request
     * @param Page $page
     * @return JsonResponse
     */
    public function updateOwner(Request $request, Page $page): JsonResponse
    {
        Page::invalidateCache();

        $page->fill($request->only(['user_id']))->save();

        return response()->json($page->load('author'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Page $page): JsonResponse
    {
        Page::invalidateCache();

        $page->delete();

        return response()->json('success', 204);
    }

    /**
     * Remove the specified page content from storage.
     *
     * @param PageContent $pageContent
     * @return JsonResponse
     * @throws Exception
     */
    public function destroyContent(PageContent $pageContent): JsonResponse
    {
        Page::invalidateCache();

        $pageContent->delete();

        return response()->json('success', 204);
    }


    /**
     * Laravel Scout search.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function search(Request $request): LengthAwarePaginator
    {
        return Page::search($request->get('query'))->paginate(10);
    }
}
