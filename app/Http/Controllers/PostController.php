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
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(2);

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
    public function update(PostUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $getPost = Post::findOrFail($id);
            $validated = $request->safe(['nameUpdate', 'titleUpdate', 'bodyUpdate', 'deleteImage', 'imageUpdate']);

            // $fields = [
            //     'name'     => $validated['nameUpdate'],
            //     'title'    => $validated['titleUpdate'],
            //     'body'     => $validated['bodyUpdate'],
            // ];

            $getPost->name = $validated['nameUpdate'];
            $getPost->title = $validated['titleUpdate'];
            $getPost->body = $validated['bodyUpdate'];
            $getPost->image = $validated['imageUpdate'] ?? null;

            $getPost->deleteImage = $validated['deleteImage'] ?? false;

            // dd($getPost->deleteImage);

            // if ($request->has('isDeleted')) {
            //     Storage::delete('public/img/' . $getPost->image);
            //     $fields['image'] = null;
            // }

            // if ($request->hasFile('imageUpdate')) {
            //     $image = $request->file('imageUpdate');
            //     $fileName = time() . '.' . $image->getClientOriginalExtension();
            //     // $request->file('image')->storeAs('public/img', $fileName);

            //     Storage::putFileAs(
            //         'public/img',
            //         $image,
            //         $fileName
            //     );

            //     $fields['image'] = $fileName;
            // }

            $getPost->save();

            // Post::create($request->safe(['name', 'title', 'body', 'password', 'image']));

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();
            // throw $error;
            // $error->getMessage()
            return redirect()->route('post.index')->with('message', "Data gagal ditambahkan 😭");
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
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            $post->delete();
        } catch (Exception $error) {
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
