<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.scheme.award.file.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="scheme_award_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="scheme_award_info_id" value="{{Crypt::encrypt($scheme_award_info_id)}}">
                    
                    <div class="form-group">
                        <label>File (Only: PDF)(file size 100KB)</label>
                        <span class="fa fa-asterisk"></span>
                        {{-- @if(@$rs_records[0]->file_path!="")
                            <a type="button" onclick="callPopupLarge(this, '{{ route('admin.common.pdf.popup', Crypt::encrypt(@$rs_records[0]->file_path)) }}')" style="color:blue;">View</a>
                        @endif --}}
                        <input type="file" name="file" class="form-control" accept=".pdf"> 
                    </div>
                    <div class="form-group">
                        <label>File Description </label>
                        <input type="text" name="discription" class="form-control" placeholder="discription" maxlength="250" required value="{{ @$rs_records[0]->file_description }}">
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

