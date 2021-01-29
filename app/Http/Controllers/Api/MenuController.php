<?php

namespace App\Http\Controllers\Api;

use App\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Menu::with('menuable')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return JsonResponse
     */
    public function store(MenuRequest $request): JsonResponse
    {
        Menu::invalidateCache();

        $menu = new Menu([
            'title' => $request->input('title'),
            'alias' => $request->input('alias'),
            'parent_id' => $request->input('parent_id'),
            'sequence_num' => $request->input('sequence_num'),
            'menuable_id' => $request->input('menuable_id'),
            'menuable_type' => $request->input('menuable_type'),
            'home' => $request->input('home'),
        ]);
        $menu->save();

        return response()->json($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param Menu $menu
     * @return JsonResponse
     */
    public function show(Menu $menu): JsonResponse
    {
        $menu->load('menuable');
        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param Menu $menu
     * @return JsonResponse
     */
    public function update(MenuRequest $request, Menu $menu): JsonResponse
    {
        Menu::invalidateCache();

        $menu
            ->fill($request->only(['title', 'alias', 'parent_id', 'sequence_num', 'menuable_id', 'menuable_type', 'home']))
            ->save();

        return response()->json($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu): JsonResponse
    {
        if ($menu->hasContent()) {
            return response()->json(
                [
                    'message' => 'Unable to delete the menu',
                    'errors' => [
                        'name' => ['This menu is not empty.'],
                    ],
                ],
                422
            );
        }

        Menu::invalidateCache();

        $menu->delete();

        return response()->json('success', 204);
    }
}
