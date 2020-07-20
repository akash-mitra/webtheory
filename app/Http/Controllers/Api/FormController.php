<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Form;
use App\FormResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CustomFormRequest;
use App\Traits\BotScanner;
use App\Traits\SetMailConfig;
use App\Mail\FormResponseNotification;

class FormController extends Controller
{
    use SetMailConfig;
    use BotScanner;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission'])->except(['storeResponse']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Form::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomFormRequest $request)
    {
        $form = new Form([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'captcha' => $request->captcha,
            'fields' => $request->fields,
        ]);
        $form->save();

        return response()->json($form);
    }

    /**
     * Display the specified resource.
     *
     * @param  Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        return response()->json($form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(CustomFormRequest $request, Form $form)
    {
        // if ($form->hasFormResponses()) {
        //     return response()->json(
        //         [
        //             'message' => 'Unable to update the form',
        //             'errors' => [
        //                 'name' => ['This form has responses.'],
        //             ],
        //         ],
        //         422
        //     );
        // }

        $form->fill(request(['name', 'description', 'status', 'captcha', 'fields']))->save();

        return response()->json($form);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        if ($form->hasFormResponses()) {
            return response()->json(
                [
                    'message' => 'Unable to delete the form',
                    'errors' => [
                        'name' => ['This form has responses.'],
                    ],
                ],
                422
            );
        }

        $form->delete();

        return response()->json('success', 204);
    }

    /**
     * Display the responses under a form.
     *
     * @param  Form  $form
     * @return \Illuminate\Http\Response
     */
    public function formResponses(Form $form)
    {
        return response()->json(
            FormResponse::where('form_id', $form->id)
                ->latest()
                ->paginate(10)
        );
    }

    /**
     * Display the form response.
     *
     * @param  FormResponse  $formResponse
     * @return \Illuminate\Http\Response
     */
    public function formResponse(FormResponse $formResponse)
    {
        // $formResponse->load('form');
        return response()->json($formResponse);
    }

    /**
     * Store a response to a form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResponse(Request $request, Form $form)
    {
        $data = $request->only($form->currentFields());

        // if we are enabling captcha, then perform captcha check
        if ($form->captcha) {
            $score = $this->preventBotSubmission();
            $data['score'] = $score;
        }

        // validate according to user given validation rules
        $request->validate($form->fieldValidationRules());

        // store the response
        $formResponse = new FormResponse([
            'form_id' => $form->id,
            'ip' => $request->ip(),
            'responses' => json_encode($data),
        ]);

        $formResponse->save();

        $formResponse->email();

        $request->session()->flash('success', 'Your data has been saved successfully');

        return back();
    }
}
