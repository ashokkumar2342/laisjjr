<div class="col-lg-12 text-right">
    @if ($scheme_award_info_id > 0)
        <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.addform', Crypt::encrypt(0)) }}'+'?scheme_award_info={{Crypt::encrypt($scheme_award_info_id)}}')">Add Award Land Detail</button>
    @endif
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
                        <th>Mustil No.</th>
                        <th>Khasra No.</th>
                        <th>Unit</th>
                        <th>Area</th>
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
                                <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.addform', Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>

                                <button type="button" class="btn btn-sm btn-danger" select-triger="scheme_award_select_box" success-popup="true" onclick="if (confirm('Are you sure you want to delete this record?')){callAjax(this,'{{ route('admin.master.award.detail.delete', Crypt::encrypt($value->id)) }}') } else{console_Log('cancel') }">Delete</button>
                            @endif
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{ $value->khewat_no }}</td>
                        <td>{{ $value->khata_no }}</td>
                        <td>{{ $value->mustil_no }}</td>
                        <td>{{ $value->khasra_no }}</td>
                        <td>{{ $value->unit==1?'Kanal Marla':'Bigha Biswa'}}</td>
                        <td>{{ $value->kanal }} - {{ $value->marla }} - {{ $value->sirsai }}</td>
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