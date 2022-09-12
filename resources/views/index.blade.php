@extends('layouts.base')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
                    <div class="text-center">
                        <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
                    </div>

                    <form action="{{ route('post.store') }}" method="POST">
                        @csrf
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
                        <div class="text-center mt-30 mb-30">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <hr>
                    @if (count($posts) == 0)
                    <h3 class="text-center text-green">No Post</h3>
                    <img src="{{ asset('img/empty.png') }}" width="100%" alt="empty image">
                    @else

                    @foreach ($posts as $post)
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
                        <p>{{ $post->body }}</p>
                    </div>
                    @endforeach
                    @endif

                    <div class="text-center">
                        {{ $posts->onEachSide(5)->links('vendor.pagination.default') }}
                    </div>
                    {{-- <div class="text-center mt-30">
                        <nav>
                            <ul class="pagination">
                                <li><a href="#">&laquo;</a></li>
                                <li><a href="#">&lsaquo;</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">&rsaquo;</a></li>
                                <li><a href="#">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</main>
@endsection