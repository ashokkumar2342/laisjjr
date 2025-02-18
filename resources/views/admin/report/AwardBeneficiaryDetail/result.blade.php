<div class="col-lg-12">
    <fieldset class="fieldset_border">
        <div class="table-responsive"> 
            <table style="border-collapse: collapse; width: 100%; height: 39px;" border="1">
            @php
                $srno = 1;
            @endphp
            <tbody>
                @foreach ($rs_result as $rs_val)
                    <tr>
                        <td style="width: 10%;vertical-align:middle;" rowspan="2" align="center">{{$srno++}}</td>
                        <td style="width: 90%;height: 40px;border-bottom: none;">
                            Khewat No.: <b>{{$rs_val->khewat_no}}</b>, Khata No.: <b>{{$rs_val->khata_no}}</b>, Mustil//Khasra (Rakba): <b>{{$mustil_khsra_rakba}}</b>, Land Value: <b>{{$rs_val->value_sep}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 90%;" style="border-top: none;">
                            @php
                                $rs_records = DB::select(DB::raw("SELECT `abd`.`name_complete_l`, concat(`abd`.`hissa_numerator`,'/',`abd`.`hissa_denominator`) as `hissa`, `abd`.`value_txt` from `award_beneficiary_detail` `abd` where `award_detail_id` = $rs_val->id order by `abd`.`id`;"));
                            @endphp
                            <table style="border-collapse: collapse; width: 100%;" border="1">
                                <tbody>
                                    @php
                                        $b_srno = 1;
                                    @endphp
                                    @foreach ($rs_records as $rs_val_rec)
                                        <tr>
                                            <td style="width: 10%;height: 30px;padding-left: 5px;">{{$b_srno++}}</td>
                                            <td style="width: 30%;padding-left: 5px;">{{$rs_val_rec->name_complete_l}}</td>
                                            <td style="width: 30%;text-align: center;">{{$rs_val_rec->hissa}}</td>
                                            <td style="width: 30%;text-align: right;padding-right: 5px;">{{$rs_val_rec->value_txt}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;">&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </fieldset>
</div>