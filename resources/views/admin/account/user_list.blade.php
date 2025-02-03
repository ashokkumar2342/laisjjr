@extends('admin.layout.base')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Users List</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right"> 
                </ol>
            </div>
        </div> 
        <div class="card card-info"> 
            <div class="card-body"> 
                <div class="col-lg-12">
                    <fieldset class="fieldset_border"> 
                        <div class="table-responsive"> 
                            <table id="example" class="table table-bordered table-striped table-hover control-label">
                                <thead style="background-color: #6c757d;color: #fff">
                                    <tr>
                                        <th>Sr. No.</th> 
                                        <th>Name</th>
                                        <th>Mobile No.</th>
                                        <th>Email Id</th>
                                        <th>Role</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $srno = 1; 
                                    @endphp
                                    @foreach($user_list as $rs_val) 
                                        <tr class="{{ $rs_val->status==1?'bg-success':'bg-danger' }}">
                                            <td>{{ $srno ++ }}</td> 
                                            <td>{{ $rs_val->name }}</td>
                                            <td>{{ $rs_val->mobile }}</td>
                                            <td>{{ $rs_val->email }}</td>
                                            <td>{{ $rs_val->role_name }}</td> 
                                            <td> 
                                                <button type="button" onclick="callPopupLarge(this,'{{ route('admin.account.user.edit', Crypt::encrypt($rs_val->id)) }}')" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button> 

                                                <a type="button" class="btn btn-sm btn-{{ $rs_val->status==1?'danger':'success' }}" href="{{ route('admin.account.user.status', Crypt::encrypt($rs_val->id)) }}" onclick="return confirm('Are you sure you want to change status?');">{{ $rs_val->status==1?'Deactivate':'Active' }}</a> 
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
          "buttons": ["excel", "copy", "csv", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
      });
    </script>
@endpush
