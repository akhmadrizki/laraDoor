@extends('dashboard.base')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
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
                    <form method="" action="">
                        <div class="box-body">
                            <div class="bordered-box mb-20">
                                <form class="form" role="form">
                                    <table class="table table-no-border mb-0">
                                        <tbody>
                                            <tr>
                                                <td width="80"><b>Title</b></td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Body</b></td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" class="form-control">
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
                                                        <input type="radio" name="imageOption" id="inlineRadio1"
                                                            value="option1"> with
                                                    </label>
                                                </td>
                                                <td width="80">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="imageOption" id="inlineRadio2"
                                                            value="option2"> without
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="imageOption" id="inlineRadio3"
                                                            value="option3" checked> unspecified
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="80"><b>Status</b></td>
                                                <td>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="statusOption" id="inlineRadio1"
                                                            value="option1"> on
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="statusOption" id="inlineRadio2"
                                                            value="option2"> delete
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="statusOption" id="inlineRadio3"
                                                            value="option3" checked> unspecified
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#" class="btn btn-default mt-10"><i
                                                            class="fa fa-search"></i> Search</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </form>

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
                                @foreach ($posts as $post)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="pre-line">{!! $post->body !!}</td>
                                    <td>
                                        @if (!is_null($post->getImageAsset()))
                                        <img class="img-prev" src="{{ $post->getImageAsset() }}">
                                        <a href="#" data-toggle="modal" data-target="#deleteModal-{{ $post->id }}"
                                            class="btn btn-danger ml-10 btn-img" rel="tooltip" title="Delete Image"><i
                                                class="fa fa-trash"></i></a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        {{$post->created_at->format('Y/m/d')}}<br>
                                        <span class="small">{{$post->created_at->format('H:i')}}</span>
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#deleteModal-{{ $post->id }}" class="btn btn-danger"
                                            rel="tooltip" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                                {{-- <tr class="bg-gray-light">
                                    <td>&nbsp;</td>
                                    <td>331</td>
                                    <td>Lorem Ipsum</td>
                                    <td>Lorem ipsum dolor sit amet, consectar bla bla bla...</td>
                                    <td>
                                        -
                                    </td>
                                    <td>2014/7/9<br><span class="small">13:59:00</span></td>
                                    <td><a href="#" class="btn btn-default" rel="tooltip" title="Recover"><i
                                                class="fa fa-repeat"></i></a></td>
                                </tr> --}}
                            </tbody>
                        </table>

                        <a href="#" class="btn btn-default mt-5" data-toggle="modal" data-target="#deleteModal">Delete
                            Checked Items</a>

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
@foreach ($posts as $post)
<div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete post <i>{{ $post->title }}</i>?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.destroy', $post->id) }}" method="POST">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('js')
<script>
    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
    });
        
    $("input[type=checkbox]").click(function() {
        if (!$(this).prop("checked")) {
            $("#selectAll").prop("checked", false);
        }
    });
</script>
@endpush