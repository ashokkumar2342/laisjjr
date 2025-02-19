<div class="col-lg-12">                
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-3">
                            <b>Scheme:: <span style="color:green;">{{@$result_rs[0]->scheme_name_e}}</span></b> , 
                        </div>
                        <div class="col-lg-9">
                            <b>Scheme/Award Village:: <span style="color:green;">{{@$result_rs[0]->tehsil_name}}, {{@$result_rs[0]->vil_name}}, {{@$result_rs[0]->award_no}},  {{@$result_rs[0]->date_of_award}}, {{@$result_rs[0]->year}}, {{@$result_rs[0]->unit}}</span></b>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="btn-group table-responsive">
                        @if ($scheme_award_info_id > 0)
                            <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.addform', Crypt::encrypt(0)) }}'+'?scheme_award_info={{Crypt::encrypt($scheme_award_info_id)}}')">Add Award Land Detail</button>
                        @endif
                    </div>
                </div>
            </div>                
        </div>
    </div>                
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Action</th>
                        <th>Sr. No.</th>                
                        <th>Khewat No.</th>
                        <th>Khata No.</th>
                        <th>Mustil//Khasra (Rakba)</th>
                        <th>Land Value</th>
                        <th>Factor Value</th>
                        <th>Solatium Value</th>
                        <th>Additional Charge Value</th>
                        <th>Total Value</th>
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
                                <button type="button" class="btn btn-info btn-sm" id="btn_edit_{{$value->id}}" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.edit', Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>

                                <button type="button" class="btn btn-sm btn-danger" select-triger="scheme_award_select_box" success-popup="true" onclick="if (confirm('Are you sure you want to delete this record?')){callAjax(this,'{{ route('admin.master.award.detail.delete', Crypt::encrypt($value->id)) }}') } else{console_Log('cancel') }">Delete</button>
                            @endif
                            <button type="button" class="btn btn-info btn-sm" data-table-new-without-pagination_2="ajax_data_table" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.view', Crypt::encrypt($value->id)) }}')"><i class="fa fa-eye"></i> View Beneficiary</button>
                            <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.addform', Crypt::encrypt(0)) }}'+'?award_detail={{Crypt::encrypt($value->id)}}')">Add Beneficiary Detail</button>
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{ $value->khewat_no }}</td>
                        <td>{{ $value->khata_no }}</td>
                        <td>{!! $value->mustil_khasra_rakba !!}</td>
                        <td>{{ $value->value_sep }}</td>
                        <td>{{ $value->f_value_sep }}</td>
                        <td>{{ $value->s_value_sep }}</td>
                        <td>{{ $value->ac_value_sep }}</td>
                        <td>{{ $value->t_value_sep}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>