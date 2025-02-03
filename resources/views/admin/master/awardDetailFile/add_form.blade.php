<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.award.detail.file.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="award_detail_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="scheme_id" value="{{Crypt::encrypt($scheme_id)}}">
                    <input type="hidden" name="scheme_award_info_id" value="{{Crypt::encrypt($scheme_award_info_id)}}">
                    <input type="hidden" name="award_detail_id" value="{{Crypt::encrypt($award_detail_id)}}">
                    
                    <div class="form-group">
                        <label>File (Only: PDF)(file size 100KB)</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="file" name="file" class="form-control" accept=".pdf"> 
                    </div>
                    <div class="form-group">
                        <label>File Description</label>
                        <textarea name="discription" class="form-control" placeholder="Enter discription" maxlength="250"></textarea>
                    </div>              
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">{{ @$rec_id>0? 'Update' : 'Submit' }}</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

