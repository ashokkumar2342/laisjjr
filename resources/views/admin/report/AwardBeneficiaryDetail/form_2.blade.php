<div class="col-lg-4 form-group">
    <label for="exampleInputEmail1">Scheme/Award</label>
    <span class="fa fa-asterisk"></span>
    <select name="scheme" class="form-control select2" id="scheme_select_box" onchange="callAjax(this,'{{ route('admin.common.scheme.wise.schemeAwardInfo') }}','scheme_award_select_box')" required>
        <option selected disabled>Select Scheme/Award</option>
        @foreach ($rs_schemes as $val_rec)
            <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>
        @endforeach
    </select>
</div>
<div class="col-lg-4 form-group">
    <label for="exampleInputEmail1">Scheme/Award Village</label>
    <span class="fa fa-asterisk"></span>
    <select name="scheme_award_info" class="form-control select2" id="scheme_award_select_box" onchange="callAjax(this,'{{ route('admin.common.schemeAwardInfoWiseAwardDetail') }}','award_detail_select_box')">
        <option selected disabled>Select Scheme/Award Village</option> 
    </select>
</div>
<div class="col-lg-4 form-group">
    <label for="exampleInputEmail1">Award Detail</label>
    <span class="fa fa-asterisk"></span>
    <select name="award_detail" class="form-control select2" id="award_detail_select_box">
        <option selected disabled>Select Award Detail</option> 
    </select>
</div>
<div class="col-lg-6 form-group">
    <button type="submit" class="form-control btn btn-success" style="margin-top: 30px;"><i class="fa fa-file-excel-o"></i> Show</button>
</div>
<div class="col-lg-6 form-group">
    <a type="button" target="_blank" id="print_btn" onclick="print_1(2)" class="form-control btn btn-warning" style="margin-top: 30px;"><i class="fa fa-print"></i> Print</a>
</div>