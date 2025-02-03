<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.file.addform', Crypt::encrypt(0)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val()+'&award_detail='+$('#award_detail_select_box').val())">Add Award Detail File</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Sr.No.</th>                
                        <th>File</th>
                        <th>File Description</th>
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
                        <td>
                            @if($value->file_path!="")
                                <a type="button" onclick="callPopupLarge(this, '{{ route('admin.common.pdf.popup', Crypt::encrypt($value->file_path)) }}')" style="color:blue;">View</a>
                            @endif
                        </td>
                        <td>{{ $value->file_description }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.file.addform', Crypt::encrypt($value->id)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val()+'&award_detail='+$('#award_detail_select_box').val())"><i class="fa fa-edit"></i> Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>