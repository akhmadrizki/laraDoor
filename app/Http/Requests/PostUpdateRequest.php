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
            'passwordUpdate' => ['nullable', 'integer', 'min:4'],
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
}
