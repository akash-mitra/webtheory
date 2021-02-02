<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\FormResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomFormRequest;
use App\Traits\CustomEmailSetup;
use App\Traits\SpamProtection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function header;

class FormController extends Controller
{
    use CustomEmailSetup;
    use SpamProtection;

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
     * @return Response
     */
    public function index()
    {
        return response()->json(Form::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
     * @param Form $form
     * @return Response
     */
    public function show(Form $form)
    {
        return response()->json($form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Form $form
     * @return Response
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
     * @param Form $form
     * @return Response
     */
    public function destroy(Form $form)
    {
        if ($form->hasResponses()) {
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
     * @param Form $form
     * @return Response
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
     * @param FormResponse $formResponse
     * @return Response
     */
    public function formResponse(FormResponse $formResponse)
    {
        // $formResponse->load('form');
        return response()->json($formResponse);
    }

    /**
     * Store a response to a form.
     *
     * @param Request $request
     * @return Response
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

    /**
     * Download the responses under a form.
     *
     * @param Form $form
     * @return Response
     */
    public function formResponsesDownload(Form $form)
    {
        $formHeader[0] = 'Response#';

        $formFields = json_decode($form->fields);
        foreach($formFields as $field) {
            array_push($formHeader, $field->name);
        }

        if ($form->captcha)
            array_push($formHeader, 'SCORE');

        array_push($formHeader, 'RECEIVE TIMESTAMP');
        array_push($formHeader, 'FROM IP');

        $formResponses = FormResponse::where('form_id', $form->id)
            ->latest()
            ->get();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $form->name . '_responses.csv');
        $output = fopen(storage_path('/app/' . $form->name . '_responses.csv'), 'w');

        fputcsv($output, $formHeader);

        foreach ($formResponses as $formResponse) {
            $feedback = [];
            $feedback[0] = $formResponse->id;

            $formFields = json_decode($form->fields);
            $responses = json_decode($formResponse->responses, true);

            foreach($formFields as $field) {
                $fieldName = $field->name;
                if (array_key_exists($fieldName, $responses))
                    array_push($feedback, $responses[$fieldName]);
                else
                    array_push($feedback, null);
            }

            if ($form->captcha) {
                if (array_key_exists('score', $responses))
                    array_push($feedback, $responses['score']);
                else
                    array_push($feedback, null);
            }


            array_push($feedback, $formResponse->created_at);
            array_push($feedback, $formResponse->ip);

            fputcsv($output, $feedback);
        }

        fclose($output);

        return response()->download(storage_path('/app/' . $form->name . '_responses.csv'));
    }
}
