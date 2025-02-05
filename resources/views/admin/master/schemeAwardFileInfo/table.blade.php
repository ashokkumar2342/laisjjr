<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.scheme.award.file.addform', Crypt::encrypt(0)) }}'+'?scheme_award_info={{Crypt::encrypt($scheme_award_info_id)}}')">Add Scheme Award File</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Sr. No.</th>
                        <th>Action</th>
                        <th>File</th>
                        <th>File Description</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sr_no = 1;
                    @endphp
                    @foreach($rs_records as $value)
                        <tr>
                            <td>{{ $sr_no++ }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.scheme.award.file.addform', Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>
                            </td>
                            <td>
                                @if($value->file_path!="")
                                    <a type="button" onclick="callPopupLarge(this, '{{ route('admin.common.pdf.popup', Crypt::encrypt($value->file_path)) }}')" style="color:blue;">View</a>
                                @endif
                            </td>
                            <td>{{ $value->file_description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>