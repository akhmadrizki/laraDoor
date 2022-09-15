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