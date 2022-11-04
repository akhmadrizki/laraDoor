<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostImageRequest extends FormRequest
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
            'image'    => ['nullable', 'mimes:jpg,png,jpeg,gif', 'max:1000'],
            'password' => ['nullable', 'numeric', 'digits:4'],
            'deleteImage' => ['nullable'],
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
            'image.max'       => 'Your image is only valid 1MB or less',
            'password.digits' => 'Your password must be 4 digit number',
        ];
    }
}
