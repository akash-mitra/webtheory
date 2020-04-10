<?php

namespace App\Http\Controllers\Api;

use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class TemplateController extends Controller
{

    public function index()
    {
        return response()->json(Template::get());
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:100',
                'regex:/^[\pL0-9\s\-_]+$/u',
                'unique:templates'
            ],
        ]);

        Template::createNewTemplate($request->input());
    }



    public function add(Template $template, Request $request)
    {
        $template->addFile(
            $request->name,
            $request->code
        );
    }



    public function update (Template $template, Request $request)
    {
        $request->validate([
            'name' => [
                'sometimes',
                'required',
                'max:100',
                'regex:/^[\pL0-9\s\-_]+$/u',
                Rule::unique('templates')->ignore($template->id),
            ],
        ]);

        $template->updateTemplate($request->input());
    }



    public function activate(Template $template)
    {
        $template->activate();
    }




    public function show(Template $template)
    {
        return $template;
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
