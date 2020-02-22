<?php

namespace App\Http\Controllers\Api;

use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Template::get());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = Auth::id();
        $template = Template::create($request->input());
        $template->createBladeFile($request->code);

        return $template;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        $template['code'] = $template->getBladeFile();

        return response()->json($template);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        $template->fill(request(['name', 'description', 'type', 'media_url', 'parameters']))->save();

        Cache::forget('templates.' . $request->input('type'));

        $code = $request->code;
        $template->updateBladeFile($code);

        return response()->json($template);
    }



    public function activate(Template $template)
    {

        Template::where('type', $template->type)->update(['active' => false]);

        $template->active = true;
        $template->save();

        Cache::forget('templates.' . $template->type);

        $template->loadBladeFile();

        return response()->json($template);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return response()->json("success", 204);
    }
}
