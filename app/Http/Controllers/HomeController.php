<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::latest()->paginate(2);

        return view('index', compact('posts'));
        // if (Auth::check() && Auth::user()->role == 'user') {
        //     return redirect()->to('/post');
        // }

        // if (Auth::check() && Auth::user()->role == 'admin') {
        //     return redirect()->to('/admin');
        // }

        // return view('auth.login');
    }
}
