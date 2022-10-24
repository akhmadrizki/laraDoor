<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return response()->json($posts, 200);
    }

    public function store(Request $request)
    {
        # code...
    }

    public function update(Request $request, Post $post)
    {
        DB::beginTransaction();

        try {
            Gate::authorize('update', [$post, $request->input('secret')]);

            $validator = Validator::make($request->all(), [
                'name'  => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 422,
                    'message'    => $validator->errors()
                ], 422);
            }

            $post->fill($request->safe(['name', 'title', 'body', 'image']));

            // $post->deleteImage = $validated['deleteImage'] ?? false;
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

            return response()->json([
                'message' => $message,
            ]);
        }

        return response()->json([
            'statusCode' => 200,
            'message'      => "Post successfully updated",
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

        return response()->json([
            'statusCode' => 200,
            'message'      => "Post successfully deleted",
        ], 200);
    }
}
