<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.addform', Crypt::encrypt(0)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val())">Add Award Detail</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Action</th>
                        <th>Sr.No.</th>                
                        <th>Khewat No.</th>
                        <th>Khata No.</th>
                        <th>Khasra No.</th>
                        <th>Unit</th>
                        <th>Kanal/Bigha</th>
                        <th>Marla/Biswa</th>
                        <th>Sirsai/Birsai</th>
                        <th>Value</th>
                        <th>Factor Value</th>
                        <th>Solatium Value</th>
                        <th>Additional Charge Value</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sr_no = 1;
                    @endphp
                    @foreach($rs_records as $value)
                    <tr>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.detail.addform', Crypt::encrypt($value->id)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val())"><i class="fa fa-edit"></i> Edit</button>
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{ $value->khewat_no }}</td>
                        <td>{{ $value->khata_no }}</td>
                        <td>{{ $value->khasra_no }}</td>
                        <td>{{ $value->unit==1?'Kanal Marla':'Bigha Biswa'}}</td>
                        <td>{{ $value->kanal }}</td>
                        <td>{{ $value->marla }}</td>
                        <td>{{ $value->sirsai }}</td>
                        <td>{{ $value->value }}</td>
                        <td>{{ $value->factor_value }}</td>
                        <td>{{ $value->solatium_value }}</td>
                        <td>{{ $value->additional_charge_value }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>