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

        $posts = match ($image) {
            'without' => $posts->whereNull('image'),
            'with' => $posts->whereNotNull('image'),
            default => $posts,
        };

        $posts = match ($status) {
            'on' => $posts->withoutTrashed(),
            'delete' => $posts->onlyTrashed(),
            default => $posts->withTrashed(),
        };

        $posts = $posts->paginate(2)->withQueryString();

        return view('dashboard.pages.admin.index', compact('posts'));
    }
}
