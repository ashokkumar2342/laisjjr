<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.award.beneficiary.payment.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="award_beneficiary_detail_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="scheme_id" value="{{Crypt::encrypt($scheme_id)}}">
                    <input type="hidden" name="scheme_award_info_id" value="{{Crypt::encrypt($scheme_award_info_id)}}">
                    <input type="hidden" name="award_detail_id" value="{{Crypt::encrypt($award_detail_id)}}">
                    <input type="hidden" name="award_beneficiary_detail_id" value="{{Crypt::encrypt($award_beneficiary_detail_id)}}">
                    <div class="row">
                        <div class="col-lg-4 form-group">
                            <label>Cheque/RTGS No.</label>
                            <input type="text" name="cheque_rtgs_no" class="form-control" maxlength="30" value="{{@$rs_records[0]->cheque_rtgs_no}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Cheque/RTGS Date</label>
                            <input type="text" name="cheque_rtgs_date" class="form-control" maxlength="30" value="{{@$rs_records[0]->cheque_rtgs_date}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" maxlength="50" value="{{@$rs_records[0]->bank_name}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Bank Address</label>
                            <input type="text" name="bank_address" class="form-control" maxlength="50" value="{{@$rs_records[0]->bank_address}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>IFSC Code</label>
                            <input type="text" name="ifsc_code" class="form-control" maxlength="20" value="{{@$rs_records[0]->ifsc_code}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Account No.</label>
                            <input type="text" name="account_no" class="form-control" maxlength="20" value="{{@$rs_records[0]->account_no}}"> 
                        </div>                        
                        <div class="col-lg-4 form-group">
                            <label>Value</label>
                            <input type="text" name="value" class="form-control" maxlength="10" value="{{@$rs_records[0]->value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Award Detail File</label>
                            <select name="award_detail_file_id" class="form-control select2">
                                <option selected {{ Crypt::encrypt(0) }}>Select Award Detail File</option>
                                @foreach ($rs_award_detail_file as $val_rec)
                                    <option value="{{ Crypt::encrypt($val_rec->opt_id) }}"{{$val_rec->opt_id==@$rs_records[0]->award_detail_file_id?'selected':''}}>{{ $val_rec->opt_text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Page No.</label>
                            <input type="text" name="page_no" class="form-control" maxlength="6" value="{{@$rs_records[0]->page_no}}"> 
                        </div>
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

