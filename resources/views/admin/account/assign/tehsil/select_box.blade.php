<div class="row"> 
    <div class="col-lg-4 form-group">
        <label for="exampleInputEmail1">District</label>
        <span class="fa fa-asterisk"></span>
        <select name="district" class="form-control select2" id="district_select_box" onchange="callAjax(this,'{{ route('admin.common.district.wise.tehsil') }}','block_select_box')" required>
            <option selected disabled>Select District</option>
            @foreach ($rs_district as $val_rec)
                <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>    
            @endforeach
        </select>
    </div>
    <div class="col-lg-4 form-group">
        <label for="exampleInputEmail1">Tehsil</label>
        <span class="fa fa-asterisk"></span>
        <select name="tehsil" class="form-control select2" id="block_select_box" required>
            <option selected disabled>Select Tehsil</option> 
        </select>
    </div>
    <div class="col-lg-4 form-group">
        <input type="submit" class="form-control btn btn-primary" value="Save" style="margin-top: 30px">
    </div>
    <div class="col-lg-12">
        <fieldset class="fieldset_border"> 
            <div class="table-responsive"> 
                <table id="ajax_data_table" class="table table-bordered table-striped table-hover control-label">
                    <thead style="background-color: #6c757d;color: #fff">
                        <tr>            
                            <th>Tehsil</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($re_records as $rs_val)
                            <tr>
                                <td>{{ $rs_val->name_e}}</td> 
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" select-triger="user_id" onclick="if (confirm('Are you Sure To Remove This Record')){callAjax(this,'{{ route('admin.account.tehsil.assign.delete',Crypt::encrypt($rs_val->id)) }}') } else{console_Log('cancel') }"><i class="fa fa-trash"></i> Remove</button>
                                </td> 
                            </tr> 
                        @endforeach
                    </tbody>
                </table> 
            </div>
        </fieldset>
    </div>
</div>