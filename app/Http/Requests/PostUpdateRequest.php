<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'nameUpdate'     => ['required', 'string', 'min:3', 'max:16'],
            'titleUpdate'    => ['required', 'string', 'min:10', 'max:32'],
            'bodyUpdate'     => ['required', 'string', 'min:10', 'max:200'],
            'imageUpdate'    => ['mimes:jpg,png,jpeg,gif', 'max:1000'],
            'deleteImage'    => ['nullable'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $post = Post::where('id', $this->post)->first();
            session()->flash('getPost', $post);
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nameUpdate.required'   => "Sorry the name can't be null",
            'nameUpdate.min'        => 'Your name must be 3 to 16 characters long',
            'nameUpdate.max'        => 'Your name must be 3 to 16 characters long',

            'titleUpdate.required'  => "Sorry the title can't be null",
            'titleUpdate.min'       => 'Your title must be 10 to 32 characters long',
            'titleUpdate.max'       => 'Your title must be 10 to 32 characters long',

            'bodyUpdate.required'   => "Sorry the body can't be null",
            'bodyUpdate.min'        => 'Your body must be 10 to 200 characters long',
            'bodyUpdate.max'        => 'Your body must be 10 to 200 characters long',

            'imageUpdate.max'       => 'Your image is only valid 1MB or less',
        ];
    }
}
