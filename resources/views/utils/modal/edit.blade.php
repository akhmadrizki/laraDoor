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
                            @if (!is_null(session('getPost')->image))
                            <img class="img-responsive" alt="image"
                                src="{{ asset('storage/img/'.session('getPost')->image) }}">
                            @endif
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
                                </div>
                                @error('imageUpdate')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if (!is_null(session('getPost')->image))
                            <div class="checkbox">
                                <label>
                                    <input name="deleteImage" value="true" type="checkbox">Delete image
                                </label>
                            </div>
                            @endif
                        </div>
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