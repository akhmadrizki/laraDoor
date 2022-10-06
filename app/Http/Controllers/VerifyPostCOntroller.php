<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VerifyPostCOntroller extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Post $post, string $method)
    {
        // Validate only method update dan delete
        if (!in_array($method, ['update', 'delete'])) {
            flash("Sorry the method is not valid")->error();

            return redirect()->back();
        }

        $secret = $post->secret($request->passVerify);

        $gate = Gate::inspect($method, [$post, $secret]);

        if ($gate->denied()) {
            flash($gate->message())->error();

            return redirect()->back();
        }

        return redirect()->back()->with([
            'getPost' => $post,
            'method'  => $method,
            'secret'  => $secret,
        ]);
    }
}
