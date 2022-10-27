<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\UploadFileException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostStoreRequest;
use App\Http\Requests\Api\Post\PostUpdateRequest;
use App\Http\Resources\Api\User\Post\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return PostResource::collection($posts);
    }

    public function store(PostStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $post = new Post($request->safe(['name', 'title', 'body', 'password', 'image']));

            if (Auth::user()) {
                $post->user_id = Auth::user()->id;
                $post->name    = Auth::user()->name;
            }

            $post->save();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = "Data failed to create 😭";

            if ($error instanceof UploadFileException) {
                $message = $error->getMessage();
            }

            return response()->json([
                'message' => $message,
            ]);
        }

        return response()->json([
            'statusCode' => 200,
            'message'    => "Post successfully created",
        ], 200);
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {
            $secret = $post->secret($request->passVerify);

            Gate::authorize('update', [$post, $secret]);

            $post->fill($request->safe(['name', 'title', 'body', 'image']));

            if ($request->has('deleteImage')) {
                $post->image = null;
            }

            $post->save();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = 'Update failed';

            if ($error instanceof AuthorizationException) {
                $message = $error->getMessage();
            }

            if ($error instanceof ModelNotFoundException) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Post not found',
                ], 404);
            }

            return response()->json([
                'message' => $message,
            ]);
        }

        return response()->json([
            'statusCode' => 200,
            'message'    => "Post successfully updated",
        ], 200);
    }

    public function destroy(Request $request, $post)
    {
        DB::beginTransaction();

        try {

            $post = Post::findOrFail($post);

            $secret = $post->secret($request->passVerify);

            Gate::authorize('delete', [$post, $secret]);

            $post->delete();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = 'Delete failed';

            if ($error instanceof AuthorizationException) {
                $message = $error->getMessage();
            }

            if ($error instanceof ModelNotFoundException) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Post not found',
                ], 404);
            }

            return response()->json([
                'message' => $message,
            ]);
        }

        return response()->json([], 204);
    }
}
