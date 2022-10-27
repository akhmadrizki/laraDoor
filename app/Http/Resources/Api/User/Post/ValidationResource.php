<?php

namespace App\Http\Resources\Api\User\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class ValidationResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'error';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $err = [];

        foreach ($this->resource as $key => $value) {
            $err[] = [
                'key'     => $key,
                'message' => $value[0],
            ];
        }

        return [
            'code'    => 422,
            'title'   => 'Validation Error',
            'message' => 'The given data was invalid.',
            'errors'  => $err
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode(422);
    }
}
