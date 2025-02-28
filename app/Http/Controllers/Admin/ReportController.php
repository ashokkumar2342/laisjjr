<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Helper\MyFuncs;
use App\Helper\SelectBox;
class ReportController extends Controller
{
    protected $e_controller = "ReportController";

    public function reportIndex()
    {
        try {
            // $permission_flag = MyFuncs::isPermission_route("71");
            // if(!$permission_flag){
            //     return view('admin.common.error');
            // }
            $role_id = MyFuncs::getUserRoleId();
            $report_type_id = 1;
            
            $reportTypes = DB::select(DB::raw("SELECT * from `report_types` where `report_for` = $role_id and `report_type_id` = $report_type_id order by `id`;"));
            return view('admin.report.index',compact('reportTypes'));       
        } catch (\Exception $e) {
            $e_method = "reportIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function formControlShow(Request $request)
    {
        try {
            $role_id = MyFuncs::getUserRoleId();
            $report_id = intval(Crypt::decrypt($request->id));
            $have_permission = MyFuncs::isPermission_reports($role_id, $report_id);
            if (! $have_permission){
                return "Not Permission";
            }
            if($report_id == 1){
                $rs_schemes = SelectBox::get_schemes_access_list_v1();
                return view('admin.report.AwardLandDetails.form_1', compact('rs_schemes'));
            }elseif($report_id == 2){
                $rs_schemes = SelectBox::get_schemes_access_list_v1();
                return view('admin.report.AwardBeneficiaryDetail.form_2', compact('rs_schemes'));
            }        
        } catch (Exception $e) {
            $e_method = "formControlShow";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function reportResult(Request $request)
    {
        try {
            $show_total_row = 0;
            $role_id = MyFuncs::getUserRoleId();
            $report_type = intval(Crypt::decrypt($request->report_type));
            if($report_type == 0){
                $response=array();
                $response["status"]=0;
                $response["msg"]='Please Select Report Type';
                return response()->json($response);  
            }
            $have_permission = MyFuncs::isPermission_reports($role_id, $report_type);
            if (! $have_permission){
                $response=array();
                $response["status"]=0;
                $response["msg"]='Not Permission';
                return response()->json($response);
            }
            
            if ($report_type == 1){
                $show_total_row = 1;
                if(empty($request->scheme_award_info)){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Please Select Scheme/Award Village';
                    return response()->json($response);
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Something went wrong';
                    return response()->json($response);
                }
                $rs_result = DB::select(DB::raw("SELECT `ad`.`khewat_no`, `ad`.`khata_no`, `ad`.`mustil_no`, `ad`.`khasra_no`, case when `ad`.`unit` = 1 then 'Kanal Marla' else 'Bigha Biswa' end as `unit`, concat(`ad`.`kanal`, ' - ' , `ad`.`marla`, ' - ' , `ad`.`sirsai`) as `area`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 order by `ad`.`id`;"));
                
                $rs_total = DB::select(DB::raw("SELECT ifnull(sum(`ad`.`kanal`),0) as `gt_kanal`, ifnull(sum(`ad`.`marla`),0) as `gt_marla`, ifnull(sum(`ad`.`sirsai`),0) as `gt_sarsai`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`value`),0)) as `gt_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`factor_value`),0)) as `gt_f_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`solatium_value`),0)) as `gt_s_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`additional_charge_value`),0)) as `gt_ac_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`total_value`),0)) as `gt_total_value`, count(*) as `total_rec` from `award_detail` `ad`  where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 ;"));

                $sarsai = 0;
                $marla = 0;
                $kanal = 0;
                $sarsai = $rs_total[0]->gt_sarsai;
                $marla = $rs_total[0]->gt_marla + intdiv($sarsai, 9);
                $sarsai = fmod($sarsai,9);

                $kanal = $rs_total[0]->gt_kanal + intdiv($marla, 20);
                $marla = fmod($marla,20);

                $total_area = $kanal." - ".$marla." - ".$sarsai;

                $tcols = 11;    //Column Caption, Column Width, Field Name, is Numeric, Last Row Values (Total), text-alignment (left, right, center, justify)
                $qcols = array(
                    array('Khewat No.',10, 'khewat_no', 0, '', 'left'),
                    array('Khata No.', 10, 'khata_no', 0, '', 'left'),
                    array('Mustil No.',10, 'mustil_no', 0, '', 'left'),
                    array('Khasra No.', 10, 'khasra_no', 0, '', 'left'),
                    array('Unit', 10, 'unit', 0, 'Total', 'left'),
                    array('Area', 10, 'area', 0, $total_area, 'right'),
                    array('Land Value', 10, 'value_sep', 0, $rs_total[0]->gt_value, 'right'),
                    array('Factor Value', 10, 'f_value_sep', 0, $rs_total[0]->gt_f_value, 'right'),
                    array('Solatium Value', 10, 's_value_sep', 0, $rs_total[0]->gt_s_value, 'right'),
                    array('Additional Charge Value', 10, 'ac_value_sep', 0, $rs_total[0]->gt_ac_value, 'right'),
                    array('Total Value', 10, 't_value_sep', 0, $rs_total[0]->gt_total_value, 'right'),
                );
            }elseif ($report_type == 2){
                if(empty($request->scheme_award_info)){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Please Select Scheme/Award Village';
                    return response()->json($response);
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Something went wrong';
                    return response()->json($response);
                }
                $rs_result = DB::select(DB::raw("SELECT `ad`.`id`, `ad`.`khewat_no`, `ad`.`khata_no`, `uf_get_mustil_khasra_area_detail`(`ad`.`id`, 1) as `mustil_khsra_rakba`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 order by `ad`.`id`;"));
                $response = array();
                $response['status'] = 1;            
                $response['data'] =view('admin.report.AwardBeneficiaryDetail.result', compact('rs_result', 'tcols', 'qcols', 'show_total_row'))->render();
                return response()->json($response);
            }

            $response = array();
            $response['status'] = 1;            
            $response['data'] =view('admin.report.result', compact('rs_result', 'tcols', 'qcols', 'show_total_row'))->render();
            return response()->json($response);           
        } catch (Exception $e) {
            $e_method = "show";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function reportPrint(Request $request)
    {
        try {
            $path=Storage_path('fonts/');
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir']; 
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata']; 
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>'A4-P',
                'fontDir' => array_merge($fontDirs, [
                    __DIR__ . $path,
                ]),
                'fontdata' => $fontData + [
                    'frutiger' => [
                        'R' => 'FreeSans.ttf',
                        'I' => 'FreeSansOblique.ttf',
                    ]
                ],
                'default_font' => 'freesans',
                'pagenumPrefix' => '',
                'pagenumSuffix' => '',
                'nbpgPrefix' => '',
                'nbpgSuffix' => ''
            ]);

            $show_total_row = 0;
            $role_id = MyFuncs::getUserRoleId();
            $report_type = intval(Crypt::decrypt($request->report_type));
            if($report_type == 0){
                $response=array();
                $response["status"]=0;
                $response["msg"]='Please Select Report Type';
                return response()->json($response);  
            }
            $have_permission = MyFuncs::isPermission_reports($role_id, $report_type);
            if (! $have_permission){
                $response=array();
                $response["status"]=0;
                $response["msg"]='Not Permission';
                return response()->json($response);
            }
            
            if ($report_type == 1){
                $report_header = "Award Land Detail";
                $show_total_row = 1;
                if($request->scheme_award_info == 'null'){
                    return 'Please Select Scheme/Award Village';
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    return 'Something went wrong';
                }
                $rs_result = DB::select(DB::raw("SELECT `ad`.`khewat_no`, `ad`.`khata_no`, `ad`.`mustil_no`, `ad`.`khasra_no`, case when `ad`.`unit` = 1 then 'Kanal Marla' else 'Bigha Biswa' end as `unit`, concat(`ad`.`kanal`, ' - ' , `ad`.`marla`, ' - ' , `ad`.`sirsai`) as `area`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 order by `ad`.`id`;"));
                
                $rs_total = DB::select(DB::raw("SELECT ifnull(sum(`ad`.`kanal`),0) as `gt_kanal`, ifnull(sum(`ad`.`marla`),0) as `gt_marla`, ifnull(sum(`ad`.`sirsai`),0) as `gt_sarsai`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`value`),0)) as `gt_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`factor_value`),0)) as `gt_f_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`solatium_value`),0)) as `gt_s_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`additional_charge_value`),0)) as `gt_ac_value`, `uf_convert_value_with_seperator`(ifnull(sum(`ad`.`total_value`),0)) as `gt_total_value`, count(*) as `total_rec` from `award_detail` `ad`  where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 ;"));

                $sarsai = 0;
                $marla = 0;
                $kanal = 0;
                $sarsai = $rs_total[0]->gt_sarsai;
                $marla = $rs_total[0]->gt_marla + intdiv($sarsai, 9);
                $sarsai = fmod($sarsai,9);

                $kanal = $rs_total[0]->gt_kanal + intdiv($marla, 20);
                $marla = fmod($marla,20);

                $total_area = $kanal." - ".$marla." - ".$sarsai;

                $tcols = 11;    //Column Caption, Column Width, Field Name, is Numeric, Last Row Values (Total), text-alignment (left, right, center, justify)
                $qcols = array(
                    array('Khewat No.',10, 'khewat_no', 0, '', 'left'),
                    array('Khata No.', 10, 'khata_no', 0, '', 'left'),
                    array('Mustil No.',10, 'mustil_no', 0, '', 'left'),
                    array('Khasra No.', 10, 'khasra_no', 0, '', 'left'),
                    array('Unit', 10, 'unit', 0, 'Total', 'left'),
                    array('Area', 10, 'area', 0, $total_area, 'right'),
                    array('Land Value', 10, 'value_sep', 0, $rs_total[0]->gt_value, 'right'),
                    array('Factor Value', 10, 'f_value_sep', 0, $rs_total[0]->gt_f_value, 'right'),
                    array('Solatium Value', 10, 's_value_sep', 0, $rs_total[0]->gt_s_value, 'right'),
                    array('Additional Charge Value', 10, 'ac_value_sep', 0, $rs_total[0]->gt_ac_value, 'right'),
                    array('Total Value', 10, 't_value_sep', 0, $rs_total[0]->gt_total_value, 'right'),
                );
                $html = view('admin.report.print', compact('rs_result', 'tcols', 'qcols', 'show_total_row', 'report_header'));
            }elseif ($report_type == 2){
                if($request->scheme_award_info == 'null'){
                    return 'Please Select Scheme/Award Village';
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    return 'Something went wrong';
                }
                $rs_pageheader = DB::select(DB::raw("SELECT `sh`.`scheme_name_e`, `th`.`name_e` as `tehsil_name`, `vl`.`name_e` as `vil_name`, `sai`.`award_no`, date_format(`sai`.`award_date`, '%d-%m-%Y') as `date_of_award`, `sai`.`year`, case `sai`.`area_unit` when 1 then 'Kanal-Marla' when 2 then 'Bigha-Biswa' else '' end as `unit` from `scheme_award_info` `sai` inner join `schemes` `sh` on `sh`.`id` = `sai`.`scheme_id` inner join `tehsils` `th` on `th`.`id` = `sai`.`tehsil_id` inner join `villages` `vl` on `vl`.`id` = `sai`.`village_id` where `sai`.`id` = $scheme_award_info_id limit 1;"));

                $rs_result = DB::select(DB::raw("SELECT `ad`.`id`, `ad`.`khewat_no`, `ad`.`khata_no`, `uf_get_mustil_khasra_area_detail`(`ad`.`id`, 1) as `mustil_khsra_rakba`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 order by `ad`.`id`;"));
                $html = view('admin.report.AwardBeneficiaryDetail.print', compact('rs_result', 'rs_pageheader'));
            }
            
            
            $mpdf->WriteHTML($html); 
            $mpdf->Output();          
        } catch (Exception $e) {
            $e_method = "reportPrint";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}
