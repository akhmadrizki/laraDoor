<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->withTrashed()->paginate(2);

        return view('dashboard.pages.admin.index', compact('posts'));
    }

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

    public function destroyImage(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->image = null;
            $post->save();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            flash('Failed to delete image')->error();

            return redirect()->back();
        }

        flash('Image successfully deleted')->success();

        return redirect()->back();
    }

    public function destroyMany(Request $request)
    {
        DB::beginTransaction();

        try {
            $delete = Post::whereIn('id', $request->ids);
            $delete->delete();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            flash("Failed to delete data's")->error();

            return redirect()->route('admin.index');
        }

        flash("Data's successfully deleted")->success();
    }

    public function restore($post)
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
