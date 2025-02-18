<div class="col-lg-12">                
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <b>Scheme:: <span style="color:green;">{{@$rs_scheme_detail[0]->scheme_name_e}}</span></b>, &nbsp;<b>
                </div>
                <div class="col-lg-12">
                    <b>Scheme/Award:: <span style="color:green;">{{@$rs_scheme_detail[0]->tehsil_name}} - {{@$rs_scheme_detail[0]->vil_name}} - {{@$rs_scheme_detail[0]->award_no}} - {{@$rs_scheme_detail[0]->date_of_award}} - {{@$rs_scheme_detail[0]->year}}</span></b>
                </div>
            </div>                
        </div>
    </div>                
</div>
<div class="col-lg-12">                
    <div class="card card-info">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">                    
                    <b>Award Detail:: <span style="color:green;">{{@$rs_scheme_detail[0]->khewat_no}}, {{@$rs_scheme_detail[0]->khata_no}}, {{@$rs_scheme_detail[0]->mustil_khsra_rakba}}</span></b>, &nbsp;<b>Total Value:: <span style="color:green;">{{@$rs_scheme_detail[0]->total_value}}</span></b>
                </div>
                <div class="col-lg-12">
                    <b>Hissa Added:: <span style="color:green;">{{@$rs_total_entered[0]->hissa_added}}</span></b>, &nbsp;<b>Total Value Added:: <span style="color:green;">{{@$rs_total_entered[0]->total_value_added}}</span></b>
                </div>
                <div class="col-lg-12">
                    <b>Balance Hissa:: <span style="color:green;">{{1 - @$rs_total_entered[0]->hissa_added}}</span></b>, &nbsp;<b>Balanced Value :: <span style="color:green;">{{@$rs_scheme_detail[0]->total_value - @$rs_total_entered[0]->total_value_added}}</span></b>
                </div>
                <div class="col-lg-12 text-right">
                    <button type="button" class="btn btn-info btn-sm" select2="true" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.addform', Crypt::encrypt(0)) }}'+'?award_detail={{Crypt::encrypt($award_detail_id)}}')">Add Award Beneficiary Detail</button>
                    
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
                        <th>Name (E)</th>
                        <th>Name (H)</th>
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
                    @foreach($rs_beneficiary as $value)
                    <tr>
                        <td class="text-nowrap">
                            @if ($value->status < 2)
                                <button type="button" class="btn btn-info btn-sm" select2="true" select-triger="unit" onclick="callPopupLarge(this,'{{ route('admin.master.award.beneficiary.addform', Crypt::encrypt($value->id)) }}')"><i class="fa fa-edit"></i> Edit</button>

                                <button type="button" class="btn btn-sm btn-danger" select-triger="award_detail_select_box" success-popup="true" onclick="if (confirm('Are you sure you want to delete this record?')){callAjax(this,'{{ route('admin.master.award.beneficiary.delete', Crypt::encrypt($value->id)) }}') } else{console_Log('cancel') }">Delete</button>
                            @endif
                        </td>
                        <td>{{ $sr_no++ }}</td>
                        <td>{{$value->name_complete_e}}</td>
                        <td>{{$value->name_complete_l}}</td>
                        <td>{{$value->hissa_numerator}}/{{$value->hissa_denominator}}</td>
                        <td>{{$value->value_txt}}</td>
                        <td>{{$value->file_description}}</td>
                        <td>{{$value->page_no}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>