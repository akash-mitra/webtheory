<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'title')->ignore($this->menu),
            ], // 'alpha_dash',
            'alias' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer'],
            'sequence_num' => ['required', 'integer'],
            'menuable_id' => ['required', 'integer'],
            'menuable_type' => ['required', 'string', 'max:255'],
            'home' => ['required'], // , 'boolean'
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
