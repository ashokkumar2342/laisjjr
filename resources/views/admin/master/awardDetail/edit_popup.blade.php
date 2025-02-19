<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close_1" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.award.detail.update.popup', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close_1,btn_edit_{{$award_land_detail_id}}" select-triger="scheme_award_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="land_award_rec_id" value="{{Crypt::encrypt(@$award_land_detail_id)}}">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Mustil No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="mustil_no" class="form-control" maxlength="10" required value="{{@$rs_mustil_khsra_rakba[0]->mustil_no}}"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Khasra No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khasra_no" class="form-control" maxlength="10" required value="{{@$rs_mustil_khsra_rakba[0]->khasra_no}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label1">{{$unit==1?'Kanal':'Bigha'}}</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="kanal" class="form-control" maxlength="5" required value="{{@$rs_mustil_khsra_rakba[0]->kanal}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label2">{{$unit==1?'Marla':'Biswa'}}</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="marla" class="form-control" maxlength="5" required value="{{@$rs_mustil_khsra_rakba[0]->marla}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label3">{{$unit==1?'Sarsai':'Biswansi'}}</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="sirsai" class="form-control" maxlength="5" required value="{{@$rs_mustil_khsra_rakba[0]->sirsai}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                    </div>                        
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-xs btn-success form-control">{{ @$rec_id>0? 'Update' : 'Submit' }}</button>
                    <button type="button" class="btn btn-xs btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


