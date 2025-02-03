<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="box-body"> 
                <div class="row">
                    @if (@$error_message == '')
                        <div class="col-lg-12 text-center">
                            <p class="text-danger" style="font-size: 20px;">500</p>
                            <p class="text-danger"><i class="fas fa-exclamation-triangle text-danger" style="font-size: 18px;"></i> Oops! Something went wrong.</p>
                            <p>
                            User have not permission for this page access.
                            </p>
                        </div>
                    @else
                        <div class="col-lg-12 text-center">
                            <p class="text-danger">{{@$error_message}}</p>
                        </div>
                    @endif
                </div>                 
            </div>
            <div class="modal-footer card-footer justify-content-between">
                <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


