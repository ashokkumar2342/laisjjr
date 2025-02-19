<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="max-height: 650px; overflow-y: auto;">
            <form action="{{ route('admin.master.award.detail.update', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="scheme_award_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="scheme_award_info_id" value="{{Crypt::encrypt($scheme_award_info_id)}}">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Khewat No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khewat_no" class="form-control" maxlength="10" required value="{{@$rs_records[0]->khewat_no}}"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Khata No.</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="khata_no" class="form-control" maxlength="10" required value="{{@$rs_records[0]->khata_no}}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Land Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="value" class="form-control" maxlength="12" required value="{{@$rs_records[0]->value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Factor Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="factor_value" class="form-control sum-input" maxlength="12" required value="{{@$rs_records[0]->factor_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Solatium Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="solatium_value" class="form-control sum-input" maxlength="12" required value="{{@$rs_records[0]->solatium_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Additional Charge Value</label>
                            <span class="fa fa-asterisk"></span>
                            <input type="text" name="additional_charge_value" class="form-control sum-input" maxlength="12" required value="{{@$rs_records[0]->additional_charge_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-12 form-group">
                            <p><strong>Total: <span id="total">{{@$rs_records[0]->t_value_sep}}</span></strong></p>
                        </div>
                    </div>
                    <div class="modal-footer card-footer justify-content-between">
                        <button type="submit" class="btn btn-sm btn-success form-control">{{ @$rec_id>0? 'Update' : 'Submit' }}</button>
                        <button type="button" class="btn btn-sm btn-danger form-control" data-dismiss="modal">Close</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default">
                                <div class="card-header bg-gray">
                                    <h4 class="card-title" >Mustil//Khasra (Rakba)</h4>
                                    <div class="card-tools">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                
                                                <button type="button" class="btn btn-info btn-xs" select2="true" onclick="callPopupLevel2(this,'{{ route('admin.master.award.detail.edit.popup', Crypt::encrypt(0)) }}'+'?land_award_rec_id={{Crypt::encrypt(@$rs_records[0]->id)}}')">Mustil//Khasra (Rakba)</button>
                                                
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body table-responsive"> 
                                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th>Action</th>                                                
                                                <th>Mustil No.</th>
                                                <th>Khasra No.</th>
                                                <th>{{$unit==1?'Kanal':'Bigha'}}</th>
                                                <th>{{$unit==1?'Marla':'Biswa'}}</th>
                                                <th>{{$unit==1?'Sarsai':'Biswansi'}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rs_mustil_khsra_rakba as $val_rs)
                                            <tr>
                                                <td class="text-nowrap">
                                                    <button type="button" class="btn btn-info btn-xs" select2="true" select-triger="unit" onclick="callPopupLevel2(this,'{{ route('admin.master.award.detail.edit.popup', Crypt::encrypt($val_rs->id)) }}')"><i class="fa fa-edit"></i> Edit</button>
                                                    
                                                    <button type="button" select-triger="scheme_award_select_box" class="btn btn-xs btn-danger" button-click="btn_edit_{{@$rs_records[0]->id}}" success-popup="true" onclick="if (confirm('Are you sure you want to delete this record?')){callAjax(this,'{{ route('admin.master.award.detail.popup.delete', Crypt::encrypt($val_rs->id)) }}') } else{console_Log('cancel') }">Delete</button>
                                                </td>
                                                <td>{{$val_rs->mustil_no}}</td>
                                                <td>{{$val_rs->khasra_no}}</td>
                                                <td>{{$val_rs->kanal}}</td>
                                                <td>{{$val_rs->marla}}</td>
                                                <td>{{$val_rs->sirsai}}</td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".sum-input").keyup(function () {
            let sum = 0;
            $(".sum-input").each(function () {
                sum += parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            });
            $("#total").text(sum);
        });
    });
</script>
<script>
///======Clone method
$(document).ready(function () {
    $("#dilw").on("click", ".add_node_btn_frm_field", function (e) {
        var index = $(e.target).closest(".form_field_outer").find(".form_field_outer_row").length + 1;
        var cloned_el = $(e.target).closest(".form_field_outer_row").clone(true);

        $(e.target).closest(".form_field_outer").last().append(cloned_el).find(".remove_node_btn_frm_field:not(:first)").prop("disabled", false);

        $(e.target).closest(".form_field_outer").find(".remove_node_btn_frm_field").first().prop("disabled", true);

        //change id
        $(e.target)
        .closest(".form_field_outer")
        .find(".form_field_outer_row")
        .last()
        .find("input[type='text']")
        .attr("id", "mobileb_no_" + index);

        $(e.target)
        .closest(".form_field_outer")
        .find(".form_field_outer_row")
        .last()
        .find("select")
        .attr("id", "no_type_" + index);

        console.log(cloned_el);
        //count++;
    });
});
</script>
<script>
    $(document).ready(function () {
        //===== delete the form fieed row
        $("#dilw").on("click", ".remove_node_btn_frm_field", function () {
            $(this).closest(".form_field_outer_row").remove();
            console.log("success");
        });
    });
</script>

