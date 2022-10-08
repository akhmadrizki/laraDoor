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
        $posts = Post::latest()->paginate(2);

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

            return redirect()->route('admin.index');
        }

        flash('Data berhasil dihapus')->success();

        return redirect()->back();
    }
}
