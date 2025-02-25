<!DOCTYPE html>
<html>
    <head>
    	<style>
        	@page { footer: html_otherpagesfooter; 
        		header: html_otherpageheader;
        	}  
        </style>
    </head>
    <body>
    	<htmlpagefooter name="otherpagesfooter" style="display:none">
    		<div style="text-align:right;">
    			Page No. {PAGENO} of {nbpg}
    		</div>
    	</htmlpagefooter>
    	<htmlpageheader name="otherpageheader" style="display:none">
            <table style="border-collapse: collapse; width: 100%;background-color:#001f3f;color:#fff">
                <tbody>
                    <tr>
                        <td style="text-align: center;"><b>Scheme:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->scheme_name_e}}</span></b></td>
                        <td style="text-align: center;"><b>Scheme/Award Village:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->tehsil_name}}, {{@$rs_pageheader[0]->vil_name}}, {{@$rs_pageheader[0]->award_no}},  {{@$rs_pageheader[0]->date_of_award}}, {{@$rs_pageheader[0]->year}}</span></td>
                        <td style="text-align: center;"><b>Unit:: <span style="color:#29ef29;">{{@$rs_pageheader[0]->unit}}</span></b></td>
                    </tr>
                </tbody>
            </table> 
        </htmlpageheader>
        <table style="border-collapse: collapse; width: 100%; height: 39px;" border="1">
            @php
                $srno = 1;
            @endphp
            <tbody>
                @foreach ($rs_result as $rs_val)
                @php
                    $rs_mustil_khasra_detail = DB::select(DB::raw("SELECT `mustil_no`, `khasra_no`, `kanal`, `marla`, `sirsai` from `award_mustil_khasra_detail` where `award_land_detail_id` = $rs_val->id and `status` = 0 order by `id`;"));
                @endphp
                    <tr>
                        <td style="width: 10%;vertical-align:middle;" rowspan="2" align="center">{{$srno++}}</td>
                        <td style="width: 90%;height: 40px;">
                            <table style="border-collapse: collapse; width: 100%;" border="1">
                                <tbody>
                                    <tr>
                                        <td style="width: 28%;"> &nbsp; Khewat No.: <b>{{$rs_val->khewat_no}}</b>, Khata No.: <b>{{$rs_val->khata_no}}</b></td>
                                        <td style="width: 44%;">
                                            <table style="border-collapse: collapse; width: 100%; height: 54px;text-align: center" border="1">
                                                <thead>
                                                    <tr>
                                                        <th>Mustil//Khasra</th>
                                                        <th>Rakba</th>
                                                        <th>Kanal/Marla</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rs_mustil_khasra_detail as $rs_mustil_val)
                                                    <tr>
                                                        <td>{{$rs_mustil_val->mustil_no}}//{{$rs_mustil_val->khasra_no}}</td>
                                                        <td>{{$rs_mustil_val->kanal}}-{{$rs_mustil_val->marla}}-{{$rs_mustil_val->sirsai}}</td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="width: 28%;"> &nbsp; Land Value: <b>{{$rs_val->value_sep}}</b></td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 90%;" style="border-top: none;">
                            @php
                                $rs_records = DB::select(DB::raw("SELECT `abd`.`name_complete_l`, concat(`abd`.`hissa_numerator`,'/',`abd`.`hissa_denominator`) as `hissa`, `abd`.`value_txt` from `award_beneficiary_detail` `abd` where `award_detail_id` = $rs_val->id order by `abd`.`id`;"));
                            @endphp
                            <table style="border-collapse: collapse; width: 100%;" border="1">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Sr. No.</th>
                                        <th style="width: 50%;">Name</th>
                                        <th style="width: 20%;">Hissa</th>
                                        <th style="width: 20%;">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $b_srno = 1;
                                    @endphp
                                    @foreach ($rs_records as $rs_val_rec)
                                        <tr>
                                            <td style="height: 30px;padding-left: 5px;text-align:center;">{{$b_srno++}}</td>
                                            <td style="padding-left: 5px;">{{$rs_val_rec->name_complete_l}}</td>
                                            <td style="text-align: center;">{{$rs_val_rec->hissa}}</td>
                                            <td style="text-align: right;padding-right: 5px;">{{$rs_val_rec->value_txt}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none;">&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
	</body>
</html>
