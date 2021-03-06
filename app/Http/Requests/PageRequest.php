<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:100'],
            'summary' => ['nullable', 'string', 'max:1048'],
            'metakey' => ['nullable', 'string', 'max:255'],
            'metadesc' => ['nullable', 'string', 'max:255'],
            'media_id' => ['nullable', 'integer', 'exists:media,id'],
            'status' => ['required', Rule::in(['Draft', 'Live'])],
            'access_plan' => ['nullable', 'string', 'max:255'],
            'contents' => ['nullable', 'array'],
            // 'contents.*.body_json' => ['required', 'array'],
            'contents.*.type' => ['required', 'string', 'max:255'],
            'contents.*.display_order' => ['required', 'integer'],
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
