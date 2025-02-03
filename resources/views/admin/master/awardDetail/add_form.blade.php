<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.award.detail.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="scheme_award_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="scheme_award_info_id" value="{{Crypt::encrypt($scheme_award_info_id)}}">
                    <div class="row">
                        <div class="col-lg-4 form-group">
                            <label>Khewat No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khewat_no" class="form-control" maxlength="10" required value="{{@$rs_records[0]->khewat_no}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Khata No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khata_no" class="form-control" maxlength="10" required value="{{@$rs_records[0]->khata_no}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Khasra No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khasra_no" class="form-control" maxlength="10" required value="{{@$rs_records[0]->khasra_no}}"> 
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>Unit</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="unit" id="unit" class="form-control" onchange="changeLabel()">
                                <option value="1" {{@$rs_records[0]->unit==1?'selected':''}}>Kanal Marla</option>
                                <option value="2" {{@$rs_records[0]->unit==2?'selected':''}}>Bigha Biswa</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label1">Kanal</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="kanal" class="form-control" maxlength="5" required value="{{@$rs_records[0]->kanal}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label2">Marla</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="marla" class="form-control" maxlength="5" required value="{{@$rs_records[0]->marla}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label id="label3">Sirsai</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="sirsai" class="form-control" maxlength="5" required value="{{@$rs_records[0]->sirsai}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="value" class="form-control" maxlength="12" required value="{{@$rs_records[0]->value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Factor Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="factor_value" class="form-control" maxlength="12" required value="{{@$rs_records[0]->factor_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Solatium Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="solatium_value" class="form-control" maxlength="12" required value="{{@$rs_records[0]->solatium_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Additional Charge Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="additional_charge_value" class="form-control" maxlength="12" required value="{{@$rs_records[0]->additional_charge_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
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
<script>
        function changeLabel() {
            var selectedOption = document.getElementById("unit").value;
            var label1 = document.getElementById("label1");
            var label2 = document.getElementById("label2");
            var label3 = document.getElementById("label3");

            if (selectedOption == 1) {
                label1.textContent = "Kanal";
                label2.textContent = "Marla";
                label3.textContent = "Sirsai";
            }else if (selectedOption == 2) {
                label1.textContent = "Bigha";
                label2.textContent = "Biswa";
                label3.textContent = "Birsai";
            }
        }
    </script>

