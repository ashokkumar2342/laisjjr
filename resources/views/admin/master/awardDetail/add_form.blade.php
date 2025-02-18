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
                    @foreach ($rs_mustil_khsra_rakba as $element)
                        <div class="row" id="dilw">
                            <div class="col-md-12 form_sec_outer_task">
                                <div class="col-md-12 p-0">
                                    <div class="col-md-12 form_field_outer p-0">
                                        <div class="row form_field_outer_row border" style="border: solid #5f97cf;">
                                            <div class="col-lg-6 form-group">
                                                <label>Mustil No.</label>
                                                <span class="fa fa-asterisk"></span>
                                                <input type="text" name="mustil_no[]" class="form-control" maxlength="10" required value="{{@$element->mustil_no}}"> 
                                            </div>
                                            <div class="col-lg-6 form-group">
                                                <label>Khasra No.</label>
                                                <span class="fa fa-asterisk"></span>
                                                <input type="text" name="khasra_no[]" class="form-control" maxlength="10" required value="{{@$element->khasra_no}}"> 
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label id="label1">{{$unit==1?'Kanal':'Bigha'}}</label>
                                                <span class="fa fa-asterisk"></span>
                                                <input type="text" name="kanal[]" class="form-control" maxlength="5" required value="{{@$element->kanal}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label id="label2">{{$unit==1?'Marla':'Biswa'}}</label>
                                                <span class="fa fa-asterisk"></span>
                                                <input type="text" name="marla[]" class="form-control" maxlength="5" required value="{{@$element->marla}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label id="label3">{{$unit==1?'Sarsai':'Biswansi'}}</label>
                                                <span class="fa fa-asterisk"></span>
                                                <input type="text" name="sirsai[]" class="form-control" maxlength="5" required value="{{@$element->sirsai}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div>
                                            <div class="col-lg-12 form-group text-right form-group add_del_btn_outer">
                                                <button type="button" class="add_node_btn_frm_field btn btn-sm" title="Copy or clone this row">
                                                    <i class="fa fa-plus-circle text-success"></i>
                                                </button>
                                                <button type="button" class="remove_node_btn_frm_field btn btn-sm" disabled>
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

