<div class="modal fade" id="deleteImagePostModal" role="dialog">
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
                <form action="{{ route('admin.destroy-image', ['id']) }}" method="POST" id="form-image">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $('#deleteImagePostModal').on('show.bs.modal', function (event) {
        let getId = $(event.relatedTarget).data('id');
        let url = $("#form-image").attr('action').replace('id', getId);
        $("#form-image").attr('action', url);
    })
</script>
@endpush