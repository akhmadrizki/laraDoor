<?php

namespace App\Http\Controllers\Api\User\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostImageRequest;
use App\Http\Resources\Api\User\Post\PostResource;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostImageController extends Controller
{
    public function store(PostImageRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {
            $secret = $post->secret($request->passVerify);

            Gate::authorize('update', [$post, $secret]);

            $post->fill($request->safe(['image']));

            if ($request->has('deleteImage')) {
                $post->image = null;
            }

            $post->save();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            $message = 'Update failed';

            abort(500, $message);
        }

        return response()->json(status: 204);
    }
}
