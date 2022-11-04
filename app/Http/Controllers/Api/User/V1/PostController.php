<?php

namespace App\Http\Controllers\Api\User\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostStoreRequest;
use App\Http\Requests\Api\Post\PostUpdateRequest;
use App\Http\Resources\Api\User\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UploadFileException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        return PostResource::make($post);
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
        } catch (\Exception $error) {
            DB::rollBack();

            $message = "Data failed to create 😭";

            if ($error instanceof UploadFileException) {
                $message = $error->getMessage();
            }

            abort(500, $message);
        }

        return PostResource::make($post);
    }

    /**
     * Undocumented function
     *
     * @param PostUpdateRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        DB::beginTransaction();

        $secret = $post->secret($request->passVerify);

        Gate::authorize('update', [$post, $secret]);

        try {
            $post->fill($request->safe(['name', 'title', 'body', 'image']));

            if ($request->has('deleteImage')) {
                $post->image = null;
            }

            $post->save();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            $message = 'Error oucured while update';

            abort(500, $message);
        }

        return PostResource::make($post);

        // return new PostResource($post);
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
        } catch (\Exception $error) {
            DB::rollBack();

            $message = 'Delete failed';

            abort(500, $message);
        }

        return response()->json([], 204);
    }
}
