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

                                @forelse ($posts as $post)
                                @if (is_null($post->deleted_at))
                                <tr>
                                    <td><input class="clickBox" value="{{ $post->id }}" type="checkbox"></td>
                                    <td class="postId">{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td class="pre-line">{!! $post->body !!}</td>
                                    <td>
                                        @if (!is_null($post->getImageAsset()))
                                        <img class="img-prev" src="{{ $post->getImageAsset() }}">
                                        {{-- <a href="#" data-toggle="modal" data-target="#deleteModal-{{ $post->id }}"
                                            class="btn btn-danger ml-10 btn-img" rel="tooltip" title="Delete Image"><i
                                                class="fa fa-trash"></i></a> --}}

                                        <button type="button" data-toggle="modal"
                                            data-target="#deleteModalImage-{{ $post->id }}"
                                            class="btn btn-danger ml-10 btn-img" rel="tooltip" title="Delete Image">
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
                                        <button type="button" data-toggle="modal"
                                            data-target="#deleteModal-{{ $post->id }}" class="btn btn-danger"
                                            rel="tooltip" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                @else
                                <tr class="bg-gray-light">
                                    <td>&nbsp;</td>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{!! $post->body !!}</td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        {{$post->created_at->format('Y/m/d')}}<br>
                                        <span class="small">{{$post->created_at->format('H:i')}}</span>
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal"
                                            data-target="#restoreModal-{{ $post->id }}" class="btn btn-default"
                                            rel="tooltip" title="Recover">
                                            <i class="fa fa-repeat"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endif

                                @empty
                                Oppss post is empty
                                @endforelse

                            </tbody>
                        </table>

                        <button type="button" data-toggle="modal" data-target="#deleteModalData"
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

<div class="modal fade" id="deleteModalImage-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Delete Image</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to delete this image?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.destroy-image', $post->id) }}" method="POST">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="restoreModal-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center">
                    <h4 class="modal-title" id="myModalLabel">Restore Data</h4>
                </div>
            </div>
            <div class="modal-body pad-20">
                <p>Are you sure want to restore post <i>{{ $post->title }}</i>?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.restore', $post->id) }}" method="POST">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Restore</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="deleteModalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                <p>Are you sure want to delete this item(s)?</p>
            </div>
            <div class="modal-footer">
                <form id="btnDelSelected" action="{{ route('admin.delete-selected') }}" method="POST">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
{{-- <script>
    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
    });
        
    $("input[type=checkbox]").click(function() {
        if (!$(this).prop("checked")) {
            $("#selectAll").prop("checked", false);
        }

    });

    $('#btnDelSelected').submit(function (event) {
        event.preventDefault();

        let getId = $('.clickBox:checked').map( function() {
         return this.value   
        }).get();

        $.ajax({
            // ambil value dari form url value action
            url: $(this).attr('action'),
            type: 'DELETE',
            data: {
                ids: getId,
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                window.location.reload();
                // console.log(data);
            },
            error: function (xhr, status, error) {
                window.location.reload();
                // console.log(error);
            }
        });

        // console.log(getId);
    });

</script> --}}
@endpush