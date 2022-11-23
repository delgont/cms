<?php

namespace Delgont\Cms\Http\Requests;

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
            'page_title' => 'required|unique:pages,page_title',
            'page_key' => ['nullable', 'unique:pages,page_key'],
            'extract_text' => 'nullable|min:3|max:200',
            'page_featured_image' => 'nullable|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'page_title.required' => 'Please Provide Page Title .........',
            'page_title.unique' => 'The Page with this title already exists .........',
        ];
    }
}
