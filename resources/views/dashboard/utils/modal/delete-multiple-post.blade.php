<div class="modal fade" id="deleteMultiplePost" role="dialog">
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
                <form id="btnDelSelected" method="POST">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <input type="hidden" id="addValue" name="ids" value="">

                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>