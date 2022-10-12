<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::latest('id')->withTrashed()->paginate(2);

        return view('dashboard.pages.admin.index', compact('posts'));
    }
}
