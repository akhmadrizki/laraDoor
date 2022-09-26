<?php

namespace App\Http\Controllers;

use App\Exceptions\UploadFileException;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {

            if ($this->handleUpdateValidate($request->secrect) != $post) {
                throw new \Exception;
            }

            $validated = $request->safe(['name', 'title', 'body', 'deleteImage', 'image']);

            $post->fill($validated);

            $post->deleteImage = $validated['deleteImage'] ?? false;

            $post->save();

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            // throw $error;
            // $error->getMessage()
            flash('Gagal update')->error();
            return redirect()->route('post.index');
        }

        flash('Data berhasil diupdate')->success();
        return redirect()->back();
    }

    public function handleUpdateValidate($request)
    {
        $getData = Crypt::decryptString($request);

        return $getData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        DB::beginTransaction();

        try {
            if ($this->handleUpdateValidate($request->secrect) != $post->id) {
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

    public function passValidation(Request $request, Post $post)
    {
        $post->secrect = Crypt::encryptString($post->id);

        $update = Gate::inspect('update', [$post, $request]);
        $delete = Gate::inspect('delete', [$post, $request]);

        if ($request->has('editBtn')) {

            if ($update->denied()) {
                flash($update->message())->error();
                return redirect()->back();
            }

            return redirect()->back()->with([
                'getPost' => $post,
                'method'  => 'update',
            ]);
        }

        if ($delete->allowed()) {
            return redirect()->back()->with([
                'getPost' => $post,
                'method'  => 'delete',
            ]);
        }

        flash($delete->message())->error();
        return redirect()->back();
    }
}
