<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Template;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    /**
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'available' => Template::getFromRepo(),
            'installed' => Template::orderBy('active', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100', 'regex:/^[\pL0-9\s\-_]+$/u', 'unique:templates'],
        ]);

        Template::createNewTemplate(
            $request->only(['name', 'description', 'media_url', 'active', 'parameters'])
        );
    }

    /**
     * @param Template $template
     * @param Request $request
     */
    public function update(Template $template, Request $request)
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

    public function show(Template $template): Template
    {
        return $template;
    }

    public function destroy(Template $template)
    {
        if ($template->active) {
            return response(
                [
                    'message' => 'Delete Failed.',
                    'errors' => [
                        'active' => ['An active template can not be deleted.'],
                    ],
                ],
                422
            );
        }

        $template->deleteTemplate();

        return response()->json('success', 204);
    }

    /**
     * @param Template $template
     * @param Request $request
     */
    public function duplicate(Template $template, Request $request)
    {
        $request->validate([
            'save_as' => ['required', 'max:100', 'regex:/^[\pL0-9\s\-_]+$/u', 'unique:templates,name'],
        ]);

        $template->duplicate($request->input('save_as'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function import(Request $request)
    {
        $request->validate([
            'from' => ['required'],
            'name' => ['required', 'max:100', 'regex:/^[\pL0-9\s\-_]+$/u', 'unique:templates'],
        ]);

        return Template::import($request->input('from'), $request->input('name'));
    }

    /**
     * @param Template $template
     * @param Request $request
     * @throws FileNotFoundException
     */
    public function add(Template $template, Request $request)
    {
        $template->addFile($request->input('name'), $request->input('code'));
    }

    /**
     * @param Template $template
     * @param Request $request
     * @throws FileNotFoundException
     */
    public function remove(Template $template, Request $request)
    {
        $name = base64_decode($request->input('name'));

        $template->deleteFile($name);
    }

    /**
     * @param Template $template
     * @param string $file
     * @return Application|ResponseFactory|Response
     * @throws FileNotFoundException
     */
    public function get(Template $template, string $file)
    {
        $path = $template->name . '/' . base64_decode($file);

        if (!Storage::disk('templates')->exists($path)) {
            return response(
                [
                    'status' => 'Given file is not available.',
                ],
                404
            );
        }

        $contents = Storage::disk('templates')->get($path);

        return response($contents, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * @param Template $template
     * @return BinaryFileResponse
     */
    public function download(Template $template): BinaryFileResponse
    {
        return $template->download();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws FileNotFoundException
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'file',
            'name' => ['required', 'max:100', 'regex:/^[\pL0-9\s\-_.]+$/u', 'unique:templates'],
        ]);

        return Template::createFromUpload($request->input('name'), $request->file('file'));
    }
}
