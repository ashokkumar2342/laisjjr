@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Award Detail File</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    
                </ol>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label for="exampleInputEmail1">Scheme</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="scheme" class="form-control select2" id="scheme_select_box" onchange="callAjax(this,'{{ route('admin.common.scheme.wise.schemeAwardInfo') }}','scheme_award_select_box')" required>
                        <option selected disabled>Select Scheme</option>
                        @foreach ($rs_schemes as $val_rec)
                            <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 form-group">
                    <label for="exampleInputEmail1">Scheme Award</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="scheme_award_info" class="form-control select2" id="scheme_award_select_box"  onchange="callAjax(this,'{{ route('admin.common.schemeAwardInfoWiseAwardDetail') }}','award_detail_select_box')" required>
                        <option selected disabled>Select Scheme Award</option> 
                    </select>
                </div>
                <div class="col-lg-4 form-group">
                    <label for="exampleInputEmail1">Award Detail</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="award_detail" class="form-control select2" id="award_detail_select_box" data-table-new-without-pagination="ajax_data_table" onchange="callAjax(this,'{{ route('admin.master.award.detail.file.table') }}','result_table')" required>
                        <option selected disabled>Select Award Detail</option> 
                    </select>
                </div>
            </div>             
        </div>
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div id="result_table"></div>
        </div>
    </div> 
</section>
@endsection
@push('scripts')
    
@endpush

