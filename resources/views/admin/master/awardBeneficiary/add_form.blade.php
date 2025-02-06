<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="max-height: 650px; overflow-y: auto;">
            <form action="{{ route('admin.master.award.beneficiary.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="award_detail_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    <input type="hidden" name="award_detail_id" value="{{Crypt::encrypt($award_detail_id)}}">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Name 1</label>
                            <input type="text" name="name_1_e" id="name_1_e" class="form-control" maxlength="50" value="{{@$rs_records[0]->name_1_e}}" onblur="getTranslatedata()" placeholder="Enter Name"> 
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Name 1 Hindi</label>
                            <input type="text" name="name_1_l" id="name_1_l" class="form-control" maxlength="100" value="{{@$rs_records[0]->name_1_l}}" placeholder="Enter Name"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Relation 1</label>
                            <select name="relation_1_id" class="form-control select2">
                                <option selected value="{{ Crypt::encrypt(0) }}">Select Relation</option>
                                @foreach ($rs_relation as $val_rec)
                                    <option value="{{ Crypt::encrypt($val_rec->opt_id) }}"{{$val_rec->opt_id==@$rs_records[0]->relation_1_id?'selected':''}}>{{ $val_rec->opt_text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Name 2</label>
                            <input type="text" name="name_2_e" id="name_2_e" class="form-control" maxlength="50" value="{{@$rs_records[0]->name_2_e}}" onblur="getTranslatedata2()" placeholder="Enter Name"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Name 2 Hindi</label>
                            <input type="text" name="name_2_l" id="name_2_l" class="form-control" maxlength="100" value="{{@$rs_records[0]->name_2_l}}" placeholder="Enter Name"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Relation 2</label>
                            <select name="relation_2_id" class="form-control select2">
                                <option selected value="{{ Crypt::encrypt(0) }}">Select Relation</option>
                                @foreach ($rs_relation as $val_rec)
                                    <option value="{{ Crypt::encrypt($val_rec->opt_id) }}"{{$val_rec->opt_id==@$rs_records[0]->relation_2_id?'selected':''}}>{{ $val_rec->opt_text }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Name 3</label>
                            <input type="text" name="name_3_e" id="name_3_e" class="form-control" maxlength="50" value="{{@$rs_records[0]->name_3_e}}" onblur="getTranslatedata3()"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Name 3 Hindi</label>
                            <input type="text" name="name_3_l" id="name_3_l" class="form-control" maxlength="100" value="{{@$rs_records[0]->name_3_l}}"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Hissa</label>
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" name="hissa_numerator" class="form-control" maxlength="10" value="{{@$rs_records[0]->hissa_numerator}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                </div>
                                <div class="col-lg-1">
                                    /
                                </div>
                                <div class="col-lg-5 pull-left">
                                    <input type="text" name="hissa_denominator" class="form-control" maxlength="10" value="{{@$rs_records[0]->hissa_denominator}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Value</label>
                            <input type="text" name="value" class="form-control" maxlength="10" value="{{@$rs_records[0]->value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 46)"> 
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>Award Detail File</label>
                            <select name="award_detail_file_id" class="form-control select2">
                                <option selected value="{{ Crypt::encrypt(0) }}">Select Award Detail File</option>
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
<script>
    $("#name_1_l").keyup(function(event) {
        // alert(event.which);
        if(event.which == 113) {
            if ($("#name_1_e").val().length == 0) {
               alert('Please Enter Name 1');
            }else{
               callPopupLevel2(this,'{{ route('admin.common.getTraDataPop') }}'+'?name_e='+$('#name_1_e').val()+'&fill_id=1');   
            }
        }
    });

    $("#name_2_l").keyup(function(event) {
        // alert(event.which);
        if(event.which == 113) {
            if ($("#name_2_e").val().length == 0) {
               alert('Please Enter Name 2');
            }else{
               callPopupLevel2(this,'{{ route('admin.common.getTraDataPop') }}'+'?name_e='+$('#name_2_e').val()+'&fill_id=2');   
            }
        }
    });

    $("#name_3_l").keyup(function(event) {
        // alert(event.which);
        if(event.which == 113) {
            if ($("#name_3_e").val().length == 0) {
               alert('Please Enter Name 3');
            }else{
               callPopupLevel2(this,'{{ route('admin.common.getTraDataPop') }}'+'?name_e='+$('#name_3_e').val()+'&fill_id=3');   
            }
        }
    });
</script>

