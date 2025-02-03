<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.scheme.award.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="scheme_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="district_id" value="{{Crypt::encrypt($district_id)}}"> 
                    <input type="hidden" name="tehsil_id" value="{{Crypt::encrypt($tehsil_id)}}"> 
                    <input type="hidden" name="village_id" value="{{Crypt::encrypt($village_id)}}">
                    <input type="hidden" name="scheme_id" value="{{Crypt::encrypt($scheme_id)}}">
                    
                    <div class="form-group">
                        <label>Award No.</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="award_no" class="form-control" placeholder="Enter Award No." maxlength="10" required value="{{ @$rs_records[0]->award_no }}"> 
                    </div>
                    <div class="form-group">
                        <label>Award Date (DD-MM-YYYY)</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="award_date" class="form-control" placeholder="DD-MM-YYYY" value="{{@$rs_records[0]->award_date}}" maxlength="10" minlength="10" required onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45) || (event.charCode == 47)'>
                    </div>
                    <div class="form-group">
                        <label>Year (YYYY-YYYY)</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="year" class="form-control" placeholder="DD-MM-YYYY" value="{{@$rs_records[0]->year}}" maxlength="10" required onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45) || (event.charCode == 47)'>
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

