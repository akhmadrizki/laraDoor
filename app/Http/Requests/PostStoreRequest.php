<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:10|max:32',
            'body'  => 'required|string|min:10|max:200',
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
            'title.required' => "Sorry the title can't be null",
            'title.min'      => 'Your title must be 10 to 32 characters long',
            'title.max'      => 'Your title must be 10 to 32 characters long',

            'body.required' => "Sorry the body can't be null",
            'body.min'      => 'Your body must be 10 to 200 characters long',
            'body.max'      => 'Your body must be 10 to 200 characters long',
        ];
    }
}
