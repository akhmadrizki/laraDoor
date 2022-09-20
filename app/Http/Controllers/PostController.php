<?php

namespace App\Http\Controllers;

use App\Exceptions\UploadFileException;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $fieldData = ['name', 'title', 'body', 'image', 'password'];

        return view('index', compact('posts', 'fieldData'));
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
            Post::create($request->safe(['name', 'title', 'body', 'password', 'image']));

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $message = "Data gagal ditambahkan 😭";

            if ($error instanceof UploadFileException) {
                $message = $error->getMessage();
            }

            // $error->getMessage()
            return redirect()->route('post.index')->with('message', $message);
        }

        return redirect()->route('post.index')->with([
            'message' => 'Data berhasil ditambahkan',
            'status'  => 'success',
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {
            $validated = $request->safe(['name', 'title', 'body', 'deleteImage', 'image']);

            $post->name  = $validated['name'];
            $post->title = $validated['title'];
            $post->body  = $validated['body'];
            $post->image = $validated['image'] ?? null;
            $post->deleteImage = $validated['deleteImage'] ?? false;

            $post->save();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            // throw $error;
            // $error->getMessage()
            return redirect()->route('post.index')->with('message', $error->getMessage());
        }

        return redirect()->back()->with([
            'message' => 'Data berhasil diupdate',
            'status'  => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->delete();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            return redirect()->route('post.index')->with('message', $error->getMessage());
        }

        return redirect()->back()->with([
            'message' => 'Data berhasil dihapus',
            'status' => 'success',
        ]);
    }

    public function passValidation(Request $request)
    {
        $getPost = Post::findOrFail($request->id);

        $cekPassword = Hash::check($request->passVerify, $getPost->password);

        if ($request->passVerify != null && $getPost->password == null) {
            return redirect()->back()->with([
                'message' => 'The passwords you entered do not match. Please try again.',
                'status'  => 'danger',
            ]);
        }

        if ($getPost->password != null && !$cekPassword) {
            return redirect()->back()->with([
                'message' => 'The passwords you entered do not match. Please try again.',
                'status'  => 'danger',
            ]);
        }

        if ($request->has('editBtn')) {
            return redirect()->back()->with([
                'getPost'  => $getPost,
                'editPass' => 'Show',
                'status'   => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'getPost'  => $getPost,
                'deletePass' => 'Show',
                'status'   => 'success',
            ]);
        }
    }
}
