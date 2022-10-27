<?php

namespace App\Http\Resources\Api\User\Post;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Model\Post $resource
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $post = $this->resource;

        return [
            'id'         => $post->id,
            'name'       => (string) $post->name,
            'title'      => $post->title,
            'body'       => $post->body,
            'image'      => $post->hasFile() ? $post->getImageAsset() : null,
            'created_at' => $post->created_at,
            'user_id'    => $post->user_id,
        ];
    }
}
