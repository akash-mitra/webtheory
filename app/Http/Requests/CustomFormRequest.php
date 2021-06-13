<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Draft', 'Live'])],
            'captcha' => ['required', function ($attribute, $value, $fail) {
                $captcha_key = json_decode(\App\Parameter::getKey('captcha_service'));
                $captcha_site_key = $captcha_key ? $captcha_key->site_key : "";
                if ($value === true && $captcha_site_key == "") {
                    $fail('No Captcha Security Settings found.');
                }
            }],
            'fields' => ['required', 'array'],
            'fields.*.name' => ['required', 'alpha_dash', 'max:255'],
            'fields.*.type' => ['required', Rule::in(['text', 'email', 'textbox', 'radio', 'select', 'multiselect', 'checkbox'])],
            'fields.*.desc' => ['nullable', 'string', 'max:255'],
            'fields.*.placeholder' => ['nullable', 'string', 'max:255'],
            'fields.*.validation' => ['nullable', 'string', 'max:255'],
            'fields.*.default' => ['nullable', 'string', 'max:255'],
            'fields.*.options' => ['required_if:fields.*.type,radio,select,multiselect', 'array'],
            'fields.*.options.*' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
