<?php

namespace App\Http\Controllers\Api;

use App\Template;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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



    public function destroy(Template $template)
    {
        if($template->active) {
            return redirect()->back()->withErrors([
                'Unable to delete an active template.'
            ]);
        }

        $template->deleteTemplate();

        return response()->json("success", 204);
    }


    public function duplicate(Template $template, Request $request)
    {
        $request->validate([
            'save_as' => [
                'required',
                'max:100',
                'regex:/^[\pL0-9\s\-_]+$/u',
                'unique:templates'
            ]
        ]);

        return $template->duplicate($request->save_as);
    }



    public function add(Template $template, Request $request)
    {
        $template->addFile(
            $request->name,
            $request->code
        );
    }



    public function get(Template $template, String $file)
    {
        return Storage::disk('templates')->get($template->name . '/' . $file);
    }
}
