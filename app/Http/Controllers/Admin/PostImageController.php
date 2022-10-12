<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostImageController extends Controller
{
    public function destroy(Post $post)
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
}
