<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm"  onclick="callPopupLarge(this,'{{ route('admin.master.tehsil.addform', Crypt::encrypt(0)) }}'+'?district='+$('#district_select_box').val())">Create New Tehsil</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
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
                            <button type="button" class="btn btn-info btn-sm" onclick="callPopupLarge(this,'{{ route('admin.master.tehsil.addform',Crypt::encrypt($value->id)) }}'+'?district='+$('#district_select_box').val())"><i class="fa fa-edit"></i> Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>