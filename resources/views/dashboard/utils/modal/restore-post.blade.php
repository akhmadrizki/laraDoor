<div class="modal fade" id="restorePostModal" tabindex="-1" role="dialog">
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
                <p>Are you sure want to restore post?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" id="form-restore">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Restore</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $('#restorePostModal').on('show.bs.modal', function (event) {
        let getId = $(event.relatedTarget).data('id');
        
        $("#form-restore").attr(
            'action',
            route('admin.post.restore', {post: getId}),
        );
    });

    $('#restorePostModal').on('hide.bs.modal', function(event) {
        $("#form-restore").attr(
            'action', '',
        );
    });
</script>
@endpush