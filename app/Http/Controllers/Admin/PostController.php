<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function destroy(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->delete();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            flash('Failed to delete data')->error();

            return redirect()->back();
        }

        flash('Data successfully deleted')->success();

        return redirect()->back();
    }

    public function restore(string $post)
    {
        DB::beginTransaction();

        try {
            $trash = Post::onlyTrashed()->findOrFail($post);

            $trash->restore();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            flash('Failed to restore data')->error();

            return redirect()->back();
        }

        flash('Data successfully restored')->success();

        return redirect()->back();
    }
}
