<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MultiplePostController extends Controller
{
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $convertArr = explode(',', $request->ids);
            $delete = Post::whereIn('id', $convertArr);

            $delete->get()->each->delete();

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();

            flash("Failed to delete data's")->error();

            return redirect()->route('admin.index');
        }

        flash("Data's successfully deleted")->success();
        return redirect()->back();
    }
}
