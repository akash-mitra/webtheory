<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Traits\SearchQueryFilter;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use SearchQueryFilter;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    /**
     * Display a listing of the categories filtered by given search query.
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $queryBuilder = Category::query()->with('media', 'author');

        return $this->applyQueryFilter(
            $queryBuilder, ['name'],
            $request->input('query')
        )->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        Category::invalidateCache();

        $category = new Category([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'description' => $request->input('description'),
            'metakey' => $request->input('metakey'),
            'metadesc' => $request->input('metadesc'),
            'media_id' => $request->input('media_id'),
            'user_id' => Auth::id(),
        ]);

        $category->save();

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        $category->load('media', 'author');

        return response()->json($category);
    }

    /**
     * Update the specified category in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        Category::invalidateCache();

        $category
            ->fill($request->only(['name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id']))
            ->save();

        return response()->json($category);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($category->hasContent()) {
            return response()->json(
                [
                    'message' => 'Unable to delete the category',
                    'errors' => [
                        'name' => ['This category is not empty.'],
                    ],
                ],
                422
            );
        }

        Category::invalidateCache();

        $category->delete();

        return response()->json('success', 204);
    }

    /**
     * Display the pages under a category.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function pages(Category $category): JsonResponse
    {
        $category->load('pages.author');

        return response()->json($category);
    }
}
