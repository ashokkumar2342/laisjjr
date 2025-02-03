<div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.payment.addform', Crypt::encrypt(0)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val()+'&award_detail='+$('#award_detail_select_box').val()+'&award_beneficiary_detail='+$('#award_beneficiary_detail_select_box').val())">Add Award Beneficiary Payment Detail</button>
</div>
<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="ajax_data_table">
                <thead style="background-color: #6c757d;color: #fff">
                    <tr>
                        <th>Action</th>
                        <th>Sr.No.</th>                
                        <th>cheque_rtgs_no</th>
                        <th>cheque_rtgs_date</th>
                        <th>bank_name</th>
                        <th>bank_address</th>
                        <th>ifsc_code</th>
                        <th>account_no</th>
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
                        <td>
                            <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.payment.addform', Crypt::encrypt($value->id)) }}'+'?scheme='+$('#scheme_select_box').val()+'&scheme_award_info='+$('#scheme_award_select_box').val()+'&award_detail='+$('#award_detail_select_box').val()+'&award_beneficiary_detail='+$('#award_beneficiary_detail_select_box').val())"><i class="fa fa-edit"></i> Edit</button>
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{$value->cheque_rtgs_no}}</td>
                        <td>{{$value->cheque_rtgs_date}}</td>
                        <td>{{$value->bank_name}}</td>
                        <td>{{$value->bank_address}}</td>
                        <td>{{$value->ifsc_code}}</td>
                        <td>{{$value->account_no}}</td>
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