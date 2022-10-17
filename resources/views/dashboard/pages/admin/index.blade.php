@extends('dashboard.base')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="mb-5">
            Dashboard
            <small>Control panel</small>
        </h1>

        @include('flash::message')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.col-xs-12 -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h1 class="font-18 m-0">Timedoor Challenge - Level 9</h1>
                    </div>

                    <div class="box-body">
                        <div class="bordered-box mb-20">
                            <form action="{{ route('admin.index') }}" method="GET" class="form" role="form">
                                <table class="table table-no-border mb-0">
                                    <tbody>
                                        <tr>
                                            <td width="80"><b>Title</b></td>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <input type="text" name="title" value="{{ request('title') }}"
                                                        class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Body</b></td>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <input type="text" name="body" value="{{ request('body') }}"
                                                        class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-search">
                                    <tbody>
                                        <tr>
                                            <td width="80"><b>Image</b></td>
                                            <td width="60">
                                                <label class="radio-inline">
                                                    <input type="radio" name="image" value="with" id="inlineRadio1" {{
                                                        request()->query('image') == 'with' ? 'checked' : '' }}>
                                                    with
                                                </label>
                                            </td>
                                            <td width="80">
                                                <label class="radio-inline">
                                                    <input type="radio" name="image" value="without" id="inlineRadio2"
                                                        {{ request()->query('image') == 'without' ? 'checked' : '' }}>
                                                    without
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="image" value="unspecified"
                                                        id="inlineRadio3" {{ request()->query('image') == 'unspecified'
                                                    || request()->query('image') == '' ? 'checked' : '' }}>
                                                    unspecified
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80"><b>Status</b></td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="on" id="inlineRadio1" {{
                                                        request()->query('status') == 'on' ? 'checked' : '' }}> on
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="delete" id="inlineRadio2"
                                                        {{ request()->query('status') == 'delete' ? 'checked' : '' }}>
                                                    delete
                                                </label>
                                            </td>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="unspecified"
                                                        id="inlineRadio3" {{ request()->query('status') == 'unspecified'
                                                    || request()->query('status') == '' ? 'checked' : '' }}>
                                                    unspecified
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="submit" class="btn btn-default mt-10">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th width="200">Image</th>
                                    <th>Date</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($posts as $post)
                                <tr @if($post->trashed()) class="bg-gray-light" @endif>
                                    <td>
                                        @if (!$post->trashed())
                                        <input class="clickBox" value="{{ $post->id }}" type="checkbox">
                                        @endif
                                        &nbsp;
                                    </td>
                                    <td class="postId">{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="pre-line">{{ ($post->body) }}</td>
                                    <td>
                                        @if (!is_null($post->getImageAsset()))
                                        <img class="image-table" src="{{ $post->getImageAsset() }}">

                                        <button type="button" data-toggle="modal" data-id="{{ $post->id }}"
                                            data-target="#deleteImagePostModal" class="btn btn-danger ml-10 btn-img"
                                            rel="tooltip" title="Delete Image">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        {{$post->created_at->format('Y/m/d')}}<br>
                                        <span class="small">{{$post->created_at->format('H:i')}}</span>
                                    </td>
                                    <td>
                                        @if (!$post->trashed())
                                        <button type="button" data-toggle="modal" data-target="#deletePostModal"
                                            data-id="{{ $post->id }}" class="btn btn-danger" rel="tooltip"
                                            title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        @else
                                        <button type="button" data-toggle="modal" data-target="#restorePostModal"
                                            data-id="{{ $post->id }}" class="btn btn-default" rel="tooltip"
                                            title="Recover">
                                            <i class="fa fa-repeat"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-info"><b>Oppss post is empty</b></td>
                                </tr>

                                @endforelse

                            </tbody>
                        </table>

                        <button type="button" data-toggle="modal" data-target="#deleteMultiplePost"
                            class="btn btn-default mt-5 dissapire" id="btnCheckbox" rel="tooltip" title="Delete">
                            Delete Checked Items
                        </button>

                        <div class="text-center">
                            {{ $posts->onEachSide(5)->links() }}
                        </div>
                    </div>

                </div>
            </div><!-- /.col-xs-12 -->
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('modal')

@include('dashboard.utils.modal.delete-post')
@include('dashboard.utils.modal.restore-post')
@include('dashboard.utils.modal.delete-post-image')
@include('dashboard.utils.modal.delete-multiple-post')

@endsection