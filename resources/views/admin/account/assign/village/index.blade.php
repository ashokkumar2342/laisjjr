@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Village Assign</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body">
                <form action="{{ route('admin.account.village.assign.store') }}" no-reset="true" method="post" class="add_form" select-triger="user_id">
                    {{ csrf_field() }} 
                    <div class="row"> 
                        <div class="col-lg-12 form-group"> 
                            <label>Users</label>
                            <select name="user" id="user_id" class="form-control select2" select2="true"data-table-new-without-pagination="ajax_data_table" onchange="callAjax(this,'{{route('admin.account.village.assign.table')}}','select_box')" required>
                                <option selected disabled>Select User</option> 
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

