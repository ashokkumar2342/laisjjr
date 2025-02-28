<!DOCTYPE html>
<html>
    <head>
        <style>
            @page { footer: html_otherpagesfooter; 
                header: html_otherpageheader;
                margin-top: 80;
                margin-left: 40;
                margin-right: 40;
            }  
        </style>
    </head>
    <body>
        <htmlpagefooter name="otherpagesfooter" style="display:none">
            <div style="text-align:right;">
                Page No. {PAGENO} of {nbpg}
            </div>
        </htmlpagefooter>
        <htmlpageheader name="otherpageheader" style="display:none;">
            <table style="border-collapse: collapse; width: 100%;background-color:#001f3f;color:#fff;">
                <tbody>
                    <tr>
                        <td style="text-align: center;"><b>Scheme:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->scheme_name_e}}</span></b></td>
                        <td style="text-align: center;"><b>Village:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->tehsil_name}}, {{@$rs_pageheader[0]->vil_name}}, {{@$rs_pageheader[0]->award_no}},  {{@$rs_pageheader[0]->date_of_award}}, {{@$rs_pageheader[0]->year}}</span></td>
                        <td style="text-align: center;"><b>Unit:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->unit}}</span></b></td>
                    </tr>
                </tbody>
            </table> 
        </htmlpageheader>

        @php
            $srno = 1;
        @endphp
        @foreach ($rs_result as $rs_val)
            @php
                $rs_mustil_khasra_detail = DB::select(DB::raw("SELECT `mustil_no`, `khasra_no`, `kanal`, `marla`, `sirsai` from `award_mustil_khasra_detail` where `award_land_detail_id` = $rs_val->id and `status` = 0 order by `id`;"));
            @endphp
            <table style="border-collapse: collapse; width: 100%; height: 39px;padding: 0;" border="1">
                <tbody>
                    <tr>
                        <td style="width: 5%;vertical-align:middle;" align="center">{{$srno++}}</td>
                        <td style="width: 95%;height: 40px;">
                            <table style="border-collapse: collapse; width: 100%;padding: 0;" border="1">
                                <tbody>
                                    <tr>
                                        <td style="border-top:0;border-left:0;border-bottom: 0;border-right: 0;">
                                            <table style="border-collapse: collapse; width: 100%; height: 54px;text-align: center;padding: 0;" border="1">
                                                <thead>
                                                    <tr>
                                                        <th style="border-top:0;border-left: 0;">खेवट/खाता सं.</th>
                                                        <th style="border-top:0;">भूमि मूल्य</th>
                                                        <th style="border-top:0;">कारक मूल्य</th>
                                                        <th style="border-top:0;">सॉलटियम शुल्क</th>
                                                        <th style="border-top:0;">अतिरिक्त शुल्क</th>
                                                        <th style="border-top:0;border-right: 0;">कुल मूल्य</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="border-bottom:0;border-left: 0;">{{$rs_val->khewat_no}}/{{$rs_val->khata_no}}</td>
                                                        <td style="border-bottom:0;">{{$rs_val->value_sep}}</td>
                                                        <td style="border-bottom:0;">{{$rs_val->f_value_sep}}</td>
                                                        <td style="border-bottom:0;">{{$rs_val->s_value_sep}}</td>
                                                        <td style="border-bottom:0;">{{$rs_val->ac_value_sep}}</td>
                                                        <td style="border-bottom:0;border-right: 0">{{$rs_val->t_value_sep}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-top:0;border-left:0;border-bottom: 0;border-right: 0;">
                                            <table style="border-collapse: collapse; width: 100%; height: 54px;text-align: center" border="1">
                                                <thead>
                                                    <tr>
                                                        <th style="border-top:0;border-left: 0;">मुस्तिल//खसरा</th>
                                                        <th style="border-top:0;">अर्जित रकबा कनाल-मरला</th>
                                                        <th style="border-top:0;border-right: 0">अर्जित रकबा मरले मे</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_marle = 0;
                                                    @endphp
                                                    @foreach ($rs_mustil_khasra_detail as $rs_mustil_val)
                                                        @php
                                                            $marle = $rs_mustil_val->kanal*20+$rs_mustil_val->marla;
                                                            $total_marle = $total_marle + $marle;
                                                        @endphp
                                                        <tr>
                                                            <td style="border-bottom:0;border-left: 0;">{{$rs_mustil_val->mustil_no}}//{{$rs_mustil_val->khasra_no}}</td>
                                                            <td style="border-bottom:0;">{{$rs_mustil_val->kanal}}-{{$rs_mustil_val->marla}}-{{$rs_mustil_val->sirsai}}</td>
                                                            <td style="border-bottom:0;border-right: 0">{{$marle}}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td style="border-bottom:0;border-left: 0;"><b>कित्ते - {{count($rs_mustil_khasra_detail)}}</b></td>
                                                        <td style="border-bottom:0;"><b>{{intdiv($total_marle, 20)}} - {{fmod($total_marle, 20)}}</b></td>
                                                        <td style="border-bottom:0;border-right: 0"><b>{{$total_marle}}</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="border-collapse: collapse; width: 100%; height: 39px;" border="1">
                <tbody>
                    <tr>
                        <td style="width: 5%;" style="border-top: none;">
                        <td style="width: 95%;" style="border-top: none;">
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
                        <td style="border: none;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
                    
                    
        @endforeach

        
    </body>
</html>
