<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $title  = $request->query('title', '');
        $body   = $request->query('body', '');
        $image  = $request->query('image', 'unspecified');
        $status = $request->query('status', 'unspecified');

        $posts = Post::latest('id')
            ->where('title', 'LIKE', "%{$title}%")
            ->where('body', 'LIKE', "%{$body}%");

        if ($image == "without") {
            $posts = $posts->whereNull('image');
        } elseif ($image == "with") {
            $posts = $posts->whereNotNull('image');
        }

        if ($status == "on") {
            $posts = $posts->withTrashed(false);
        } elseif ($status == "delete") {
            $posts = $posts->onlyTrashed();
        }

        $posts = $posts->withTrashed()->paginate(2);

        return view('dashboard.pages.admin.index', compact('posts'));
    }
}
