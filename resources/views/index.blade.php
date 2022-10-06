@extends('layouts.base')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
                    @include('flash::message')

                    <div class="text-center">
                        <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
                    </div>

                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>

                            @auth
                            <input type="text" name="name" disabled class="form-control"
                                value="{{ Auth::user()->name }}">
                            @endauth

                            @guest

                            <input type="text" name="name" class="form-control"
                                value="{{ $errors->storePost->isNotEmpty() ? old('name') : '' }}">
                            @error('name', 'storePost')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            @endguest
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ $errors->storePost->isNotEmpty() ? old('title') : '' }}">
                            @error('title', 'storePost')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea rows="5" name="body"
                                class="form-control">{{ $errors->storePost->isNotEmpty() ? old('body') : '' }}</textarea>
                            @error('body', 'storePost')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Choose image from your computer :</label>
                            <div class="input-group">
                                <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file" name="image"
                                            multiple>
                                    </span>
                                </span>
                            </div>
                            @error('image', 'storePost')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @guest
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control @error('password', 'storePassword') is-invalid
                                @enderror">
                            @error('password', 'storePost')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endguest

                        <div class="text-center mt-30 mb-30">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <hr>

                    @forelse ($posts as $post)
                    <div class="post">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h2 class="mb-5 text-green"><b>{{ $post->title }}</b></h2>
                            </div>
                            <div class="pull-right text-right">
                                <p class="text-lgray">{{$post->created_at->format('d-m-Y')}}
                                    <br />
                                    <span class="small">{{$post->created_at->format('H:i')}}</span>
                                </p>
                            </div>
                        </div>
                        <h4 class="mb-20">
                            {{ blank($post->name) ? 'no name' : $post->name }}
                            <span class="text-id">{{ $post->user_id ? '-' .$post->user_id : '' }}</span>
                        </h4>
                        <p class="pre-line">{{ ($post->body) }}</p>

                        @if (!is_null($post->getImageAsset()))
                        <div class="img-box my-10">
                            <img class="img-responsive img-post" src="{{ $post->getImageAsset() }}" alt="image">
                        </div>
                        @endif

                        <form class="form-inline mt-50" method="POST">
                            @csrf

                            @auth
                            @if (Auth::user()->id === $post->user_id)
                            <button type="submit" name="editBtn"
                                formaction="{{ route('post.verify-password', ['post' => $post->id, 'method' => 'update']) }}"
                                class="btn btn-default mb-2"><i class="fa fa-pencil p-3"></i></button>

                            <button type="submit" name="deleteBtn"
                                formaction="{{ route('post.verify-password', ['post' => $post->id, 'method' => 'delete']) }}"
                                class="btn btn-danger">
                                <i class="fa fa-trash p-3"></i>
                            </button>
                            @endif
                            @endauth

                            @guest
                            @if ($post->user_id === null)
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="password" name="passVerify" class="form-control" id="inputPassword2"
                                    placeholder="Password">
                            </div>

                            <button type="submit" name="editBtn"
                                formaction="{{ route('post.verify-password', ['post' => $post->id, 'method' => 'update']) }}"
                                class="btn btn-default mb-2"><i class="fa fa-pencil p-3"></i></button>

                            <button type="submit" name="deleteBtn"
                                formaction="{{ route('post.verify-password', ['post' => $post->id, 'method' => 'delete']) }}"
                                class="btn btn-danger">
                                <i class="fa fa-trash p-3"></i>
                            </button>
                            @endif


                            @endguest

                        </form>
                    </div>

                    @empty

                    <h3 class="text-center text-green">No Post</h3>
                    <img src="{{ asset('img/empty.png') }}" width="100%" alt="empty image">
                    @endforelse

                    <div class="text-center">
                        {{ $posts->onEachSide(5)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('modal')

@include('utils.modal.edit', ['post' => session('getPost')])
@include('utils.modal.delete', ['post' => session('getPost')])

@endsection