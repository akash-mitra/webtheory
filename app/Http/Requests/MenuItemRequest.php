<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            'menus' => ['nullable', 'array'],
            'menus.*.title' => ['required', 'string', 'max:255'], // ,'alpha_dash'
            'menus.*.alias' => ['nullable', 'string', 'max:255'],
            'menus.*.parent_id' => ['nullable', 'integer'],
            'menus.*.sequence_num' => ['required', 'integer'],
            'menus.*.menuable_id' => ['required', 'integer'],
            'menus.*.menuable_type' => ['required', 'string', 'max:255'],
            'menus.*.home' => ['required'], // , 'boolean'
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
