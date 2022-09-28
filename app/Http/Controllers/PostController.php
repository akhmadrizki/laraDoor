<?php

namespace App\Http\Controllers;

use App\Exceptions\UploadFileException;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts     = Post::latest()->paginate(2);

        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        DB::beginTransaction();

        try {

            // $cekVerif = Auth::user();
            if (Auth::user()) {
                if (blank(auth()->user()->email_verified_at)) {
                    return redirect()->route('verification.notice');
                }
                Post::create($request->safe(['name', 'title', 'body', 'password', 'image']));
            } else {
                Post::create($request->safe(['name', 'title', 'body', 'password', 'image']));
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = "Data gagal ditambahkan 😭";

            if ($error instanceof UploadFileException) {
                $message = $error->getMessage();
            }

            return redirect()->route('post.index')->with('message', $message);
        }

        flash('Data berhasil ditambahkan')->success();

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {

            if (!$post->hasValidSecret($request->input('secret'))) {
                throw new \Exception;
            }

            $validated = $request->safe(['name', 'title', 'body', 'deleteImage', 'image']);

            $post->fill($validated);

            $post->deleteImage = $validated['deleteImage'] ?? false;

            $post->save();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            flash('Gagal update')->error();
            return redirect()->route('post.index');
        }

        flash('Data berhasil diupdate')->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        DB::beginTransaction();

        try {

            if (!$post->hasValidSecret($request->input('secret'))) {
                throw new \Exception;
            }

            $post->delete();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            flash('Gagal delete')->error();

            return redirect()->route('post.index');
        }

        flash('Data berhasil dihapus')->success();

        return redirect()->back();
    }

    public function passValidation(Request $request, Post $post, string $method)
    {
        // Validate only method update dan delete
        if (!in_array($method, ['update', 'delete'])) {
            flash("Sorry the method not valid")->error();

            return redirect()->back();
        }

        $update = Gate::inspect($method, [$post, $request->passVerify]);

        if ($update->denied()) {
            flash($update->message())->error();

            return redirect()->back();
        }

        return redirect()->back()->with([
            'getPost' => $post,
            'method'  => $method,
        ]);
    }
}
