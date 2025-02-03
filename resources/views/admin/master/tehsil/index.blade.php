@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Create Tehsil</h3>
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
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">District</label>
                        <span class="fa fa-asterisk"></span>
                        <select name="district" class="form-control select2" id="district_select_box" data-table-new-without-pagination="ajax_data_table" onchange="callAjax(this,'{{ route('admin.master.tehsil.table') }}','result_table')">    
                            <option selected disabled>Select District</option>                                      
                            @foreach ($rs_districts as $rs_val)
                                <option value="{{ Crypt::encrypt($rs_val->opt_id) }}">{{ $rs_val->opt_text }}</option>
                            @endforeach
                        </select>
                    </div>
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

