<?php

namespace App\Http\Requests\Api\Post;

use App\Http\Resources\Api\User\Post\ValidationResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

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
            'name'     => ['nullable', 'string', 'between:3,16'],
            'title'    => ['required', 'string', 'min:10', 'max:32'],
            'body'     => ['required', 'string', 'min:10', 'max:200'],
            'image'    => ['mimes:jpg,png,jpeg,gif', 'max:1000'],
            'password' => ['nullable', 'numeric', 'digits:4'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {


        // throw new HttpResponseException(response()->json([
        //     'error' => [
        //         'code'    => 422,
        //         'title'   => 'Validation Error',
        //         'message' => 'The given data was invalid.',
        //         'errors'  => $err
        //     ]
        // ], 422));

        $response = new ValidationResource($validator->errors()->getMessages());

        throw (new ValidationException($validator, $response));
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
