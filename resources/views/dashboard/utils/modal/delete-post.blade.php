<div class="modal fade" id="deletePostModal" role="dialog">
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
                <p>Are you sure want to delete post?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" id="form-action">
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
    $('#deletePostModal').on('show.bs.modal', function (event) {
        let getId = $(event.relatedTarget).data('id');

        $("#form-action").attr(
            'action',
            route('admin.post.destroy', {post: getId}),
        );
    });

    $('#deletePostModal').on('hide.bs.modal', function(event) {
        $("#form-action").attr(
            'action', '',
        );
    });
</script>
@endpush