@extends('layouts.base')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
                    @if (session('message'))
                    <div class="alert alert-{{ session('status') }} alert-dismissible" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="text-center">
                        <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
                    </div>

                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}">
                            @error('title')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea rows="5" name="body" class="form-control" @error('body') is-invalid
                                @enderror>{{ old('body') }}</textarea>
                            @error('body')
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
                                @error('image')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid
                                @enderror">
                            @error('password')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

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
                                <p class="text-lgray">{{ date( 'd-m-Y', strtotime($post->created_at)) }}
                                    <br />
                                    <span class="small">{{ date( 'H:i', strtotime($post->created_at)) }}</span>
                                </p>
                            </div>
                        </div>
                        <h4 class="mb-20">{{ $post->name }}</h4>
                        <p>{!! nl2br($post->body) !!}</p>
                        <div class="img-box my-10">
                            <img class="img-responsive img-post"
                                src=" {{ $post->image == null ? 'https://empowher.org/wp-content/uploads/2021/03/image-placeholder-350x350-1.png' : asset('storage/img/'.$post->image) }}"
                                alt="image">
                        </div>

                        <form class="form-inline mt-50" action="{{ route('pass.validate') }}" method="POST">
                            @csrf
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="hidden" name="id" value="{{ $post->id }}">

                                @if (!is_null($post->password))
                                <label for="inputPassword2" class="sr-only">Password</label>
                                <input type="password" name="passVerify" class="form-control" id="inputPassword2"
                                    placeholder="Password">
                                @endif
                            </div>
                            <button type="submit" name="editBtn" class="btn btn-default mb-2"><i
                                    class="fa fa-pencil p-3"></i></button>

                            <button type="submit" name="deleteBtn" class="btn btn-danger">
                                <i class="fa fa-trash p-3"></i>
                            </button>
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

@if (session('editPass') || $errors->hasAny('nameUpdate', 'titleUpdate', 'bodyUpdate', 'imageUpdate', 'passwordUpdate'))
<div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
            </div>
            <form action="{{ route('post.update', session('getPost')->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    {{-- <input type="hidden" name="id" value="{{ session('getPost')->id ?? session('error') }}"> --}}

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="nameUpdate" class="form-control"
                            value="{{ old('nameUpdate') ?? session('getPost')->name }}">
                        @error('nameUpdate')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="titleUpdate" class="form-control"
                            value="{{ session('getPost')->title ?? old('titleUpdate') }}">
                        @error('titleUpdate')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Body</label>
                        <textarea rows="5" name="bodyUpdate"
                            class="form-control">{{ session('getPost')->body ?? old('bodyUpdate') }}</textarea>
                        @error('bodyUpdate')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <img class="img-responsive" alt="image" src="{{ session('getPost')->image == null ?
                            'https://empowher.org/wp-content/uploads/2021/03/image-placeholder-350x350-1.png' :
                            asset('storage/img/'.session('getPost')->image) }}">
                        </div>
                        <div class="col-md-8 pl-0">
                            <div class="form-group">
                                <label>Choose image from your computer :</label>
                                <div class="input-group">
                                    <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file"
                                                name="imageUpdate" multiple>
                                        </span>
                                    </span>
                                    @error('imageUpdate')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="isDeleted" type="checkbox">Delete image
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="passwordUpdate" class="form-control">
                        @error('passwordUpdate')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if (session('deletePass'))
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete <strong class="text-capitalize text-success">{{ session('getPost')->title
                        }}?</strong>
                </p>
            </div>
            <div class="modal-footer d-inline">
                <form action="{{ route('post.destroy', session('getPost')->id) }}" method="POST">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
<script>
    // Input type file
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles  = input.get(0).files ? input.get(0).files.length : 1,
        label     = input.val().replace(/\\/g, '/').replace(/.*\//, '');

        input.trigger('fileselect', [numFiles, label]);
    });
    
    $(document).ready(function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }
        });
    });

    // Modal
    $(document).ready(function(){
        $("#editModal").modal('show');
        $("#deleteModal").modal('show');
    });
</script>
@endsection