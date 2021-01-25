<?php

namespace App\Http\Controllers\Api;

use App\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Menu::with('menuable')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::invalidateCache();

        $menu = new Menu([
            'title' => $request->title,
            'alias' => $request->alias,
            'parent_id' => $request->parent_id,
            'sequence_num' => $request->sequence_num,
            'menuable_id' => $request->menuable_id,
            'menuable_type' => $request->menuable_type == 'pages' ? 'App\Page' : 'App\Category',
            'home' => $request->home,
        ]);
        $menu->save();

        return response()->json($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param  Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $menu->load('menuable');
        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        Menu::invalidateCache();

        $menu
            ->fill(request(['title', 'alias', 'parent_id', 'sequence_num', 'home']))
            ->save();

        return response()->json($menu);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
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
