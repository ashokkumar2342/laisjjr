<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">view</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 post-pg">
                    <iframe src="{{ route('admin.common.pdf.viewer',Crypt::encrypt($file_path)) }}"  width="100%" height="600"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

