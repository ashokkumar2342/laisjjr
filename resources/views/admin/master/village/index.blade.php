@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Create Village</h3>
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
                <div class="col-lg-6 form-group">
                    <label for="exampleInputEmail1">District</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="district" class="form-control select2" id="district_select_box" onchange="callAjax(this,'{{ route('admin.common.district.wise.tehsil') }}','tehsil_select_box')" required>
                        <option selected disabled>Select District</option>
                        @foreach ($rs_district as $val_rec)
                        <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>    
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 form-group">
                    <label for="exampleInputEmail1">Tehsil</label>
                    <span class="fa fa-asterisk"></span>
                    <select name="tehsil" class="form-control select2" id="tehsil_select_box" data-table-new-without-pagination="ajax_data_table" onchange="callAjax(this,'{{ route('admin.master.village.table') }}','result_table')" required>
                        <option selected disabled>Select Tehsil</option> 
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

