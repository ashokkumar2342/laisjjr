@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>District Assign</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <form action="{{ route('admin.account.district.assign.store') }}" no-reset="true" method="post" class="add_form" select-triger="user_id,">
                    {{ csrf_field() }} 
                    <div class="row"> 
                        <div class="col-lg-12 form-group"> 
                            <label>Users</label>
                            <select class="form-control select2" select2="true" name="user" id="user_id" data-table-new-without-pagination="ajax_data_table"  onchange="callAjax(this,'{{route('admin.account.district.assign.table')}}','select_box')" > 
                                <option disabled selected>Select User</option>
                                @foreach ($users as $val_rec)
                                <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>
                                @endforeach  
                            </select> 
                        </div> 
                        <div class="col-lg-12" id="select_box"> 
                        </div>
                    </div> 
                </form>           
            </div> 
        </div>
    </div>
</section>
@endsection 

