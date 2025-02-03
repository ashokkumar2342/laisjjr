@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Create State</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <button type="button" class="btn btn-info btn-sm"  onclick="callPopupLarge(this,'{{ route('admin.master.state.addform', Crypt::encrypt(0)) }}')">Create New State</button>
                </ol>
            </div>
        </div> 
    </div>
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <fieldset class="fieldset_border">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="example">
                                <thead style="background-color: #6c757d;color: #fff">
                                    <tr>
                                        <th>Sr.No.</th>                
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Name Hindi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sr_no = 1;
                                    @endphp
                                    @foreach($rs_records as $value)
                                    <tr>
                                        <td>{{ $sr_no++ }}</td>
                                        <td>{{ $value->code }}</td>
                                        <td>{{ $value->name_e }}</td>
                                        <td>{{ $value->name_l }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" onclick="callPopupLarge(this,'{{ route('admin.master.state.addform',Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
            </div>                
        </div>
    </div> 
</section>
@endsection
@push('scripts')
<script>
    $(function () {
        $("#example").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["excel", "colvis"]
        }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush
