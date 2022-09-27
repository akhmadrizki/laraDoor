<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'updatePost';

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
            'name'     => ['nullable', 'string', 'between:3,16'],
            'title'    => ['required', 'string', 'min:10', 'max:32'],
            'body'     => ['required', 'string', 'min:10', 'max:200'],
            'image'    => ['mimes:jpg,png,jpeg,gif', 'max:1000'],
            'password' => ['nullable', 'numeric', 'digits:4'],
            'deleteImage' => ['nullable'],
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
            // $post = Post::where('id', $this->post)->first();
            $post = $this->route('post');
            session()->flash('getPost', $post);
            session()->flash('method', 'update');
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
            'name.required'   => "Sorry the name can't be null",
            'name.between'    => 'Your name must be 3 to 16 characters long',

            'title.required'  => "Sorry the title can't be null",
            'title.min'       => 'Your title must be 10 to 32 characters long',
            'title.max'       => 'Your title must be 10 to 32 characters long',

            'body.required'   => "Sorry the body can't be null",
            'body.min'        => 'Your body must be 10 to 200 characters long',
            'body.max'        => 'Your body must be 10 to 200 characters long',

            'image.max'       => 'Your image is only valid 1MB or less',

            'password.digits' => 'Your password must be 4 digit number',
        ];
    }
}
