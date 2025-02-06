<div class="col-lg-12 text-left">
    <strong>{{@$result_rs[0]->opt_text}}</strong>
</div>
<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.addform', Crypt::encrypt(0)) }}'+'?award_detail={{Crypt::encrypt($award_detail_id)}}')">Add Award Beneficiary Detail</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Action</th>
                        <th>Sr.No.</th>                
                        <th>Name 1</th>
                        <th>Name 1 Hindi</th>
                        <th>Relation 1</th>
                        <th>Name 2</th>
                        <th>Name 2 Hindi</th>
                        <th>Relation 2</th>
                        <th>Name 3</th>
                        <th>Name 3 Hindi</th>
                        <th>Hissa</th>
                        <th>Value</th>
                        <th>Award Detail File</th>
                        <th>Page No.</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sr_no = 1;
                    @endphp
                    @foreach($rs_records as $value)
                    <tr>
                        <td class="text-nowrap">
                            @if ($value->status < 2)
                                <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.addform', Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>

                                <button type="button" class="btn btn-sm btn-danger" select-triger="award_detail_select_box" success-popup="true" onclick="if (confirm('Are you sure you want to delete this record?')){callAjax(this,'{{ route('admin.master.award.beneficiary.delete', Crypt::encrypt($value->id)) }}') } else{console_Log('cancel') }">Delete</button>
                            @endif
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{$value->name_1_e}}</td>
                        <td>{{$value->name_1_l}}</td>
                        <td>{{$value->relation_1_id}}</td>
                        <td>{{$value->name_2_e}}</td>
                        <td>{{$value->name_2_l}}</td>
                        <td>{{$value->relation_2_id}}</td>
                        <td>{{$value->name_3_e}}</td>
                        <td>{{$value->name_3_l}}</td>
                        <td>{{$value->hissa_numerator}}</td>
                        <td>{{$value->value}}</td>
                        <td>{{$value->award_detail_file_id}}</td>
                        <td>{{$value->page_no}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>