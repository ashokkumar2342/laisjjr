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
            $show_total_row = 1;
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

                $tcols = 11;
                $qcols = array(
                    array('Khewat No.',10, 'khewat_no', 0, '', 'left'),
                    array('Khata No.', 10, 'khata_no', 0, '', 'left'),
                    array('Mustil No.',10, 'mustil_no', 0, '', 'left'),
                    array('Khasra No.', 10, 'khasra_no', 0, '', 'left'),
                    array('Unit', 10, 'unit', 0, '', 'left'),
                    array('Area', 10, 'area', 0, '', 'left'),
                    array('Land Value', 10, 'value_sep', 0, '', 'left'),
                    array('Factor Value', 10, 'f_value_sep', 0, '', 'left'),
                    array('Solatium Value', 10, 's_value_sep', 0, '', 'left'),
                    array('Additional Charge Value', 10, 'ac_value_sep', 0, '', 'left'),
                    array('Total Value', 10, 't_value_sep', 0, '', 'left'),
                );

                $counter = 0;
                while ($counter < $tcols ){
                    if($qcols[$counter][3] == 1){
                        $column_name = $qcols[$counter][2];

                        $temp_array = array_column($rs_result, $column_name);
                        $total_value = array_sum($temp_array);
                        $qcols[$counter][4] = number_format($total_value, 2, '.', '');

                    }
                    $counter = $counter+1;
                }
            }elseif ($report_type == 2){
                if(empty($request->scheme_award_info)){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Please Select Scheme/Award Village';
                    return response()->json($response);
                }
                if(empty($request->award_detail)){
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]='Please Select Award Detail';
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
                $award_detail_id = intval(Crypt::decrypt($request->award_detail));
                $rs_result = DB::select(DB::raw("SELECT `abd`.`name_complete_e`, `abd`.`name_complete_l`, concat(`abd`.`hissa_numerator`,'/',`abd`.`hissa_denominator`) as `hissa`, `abd`.`value_txt`, `abd`.`page_no`, `adf`.`file_description` from `award_beneficiary_detail` `abd` inner join `award_detail_file` `adf` on `adf`.`id` = `abd`.`award_detail_file_id` where `award_detail_id` = $award_detail_id order by `abd`.`id`;"));
                $tcols = 6;
                $qcols = array(
                    array('Name (E)',10, 'name_complete_e', 0, '', 'left'),
                    array('Name (H)', 10, 'name_complete_l', 0, '', 'left'),
                    array('Hissa',10, 'hissa', 0, '', 'left'),
                    array('Value', 10, 'value_txt', 0, '', 'left'),
                    array('Award Detail File', 10, 'file_description', 0, '', 'left'),
                    array('Page No.', 10, 'page_no', 0, '', 'left'),
                );
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
            $show_total_row = 1;
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
                if($request->scheme_award_info == 'null'){
                    return 'Please Select Scheme/Award Village';
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    return 'Something went wrong';
                }
                $rs_result = DB::select(DB::raw("SELECT `ad`.`khewat_no`, `ad`.`khata_no`, `ad`.`mustil_no`, `ad`.`khasra_no`, case when `ad`.`unit` = 1 then 'Kanal Marla' else 'Bigha Biswa' end as `unit`, concat(`ad`.`kanal`, ' - ' , `ad`.`marla`, ' - ' , `ad`.`sirsai`) as `area`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `status` < 2 order by `ad`.`id`;"));

                $tcols = 11;
                $qcols = array(
                    array('Khewat No.',10, 'khewat_no', 0, '', 'left'),
                    array('Khata No.', 10, 'khata_no', 0, '', 'left'),
                    array('Mustil No.',10, 'mustil_no', 0, '', 'left'),
                    array('Khasra No.', 10, 'khasra_no', 0, '', 'left'),
                    array('Unit', 10, 'unit', 0, '', 'left'),
                    array('Area', 10, 'area', 0, '', 'left'),
                    array('Land Value', 10, 'value_sep', 0, '', 'left'),
                    array('Factor Value', 10, 'f_value_sep', 0, '', 'left'),
                    array('Solatium Value', 10, 's_value_sep', 0, '', 'left'),
                    array('Additional Charge Value', 10, 'ac_value_sep', 0, '', 'left'),
                    array('Total Value', 10, 't_value_sep', 1, '', 'left'),
                );

                $counter = 0;
                while ($counter < $tcols ){
                    if($qcols[$counter][3] == 1){
                        $column_name = $qcols[$counter][2];

                        $temp_array = array_column($rs_result, $column_name);
                        $total_value = array_sum($temp_array);
                        $qcols[$counter][4] = number_format($total_value, 2, '.', '');

                    }
                    $counter = $counter+1;
                }
            }elseif ($report_type == 2){
                if($request->scheme_award_info == 'null'){
                    return 'Please Select Scheme/Award Village';
                }
                if($request->award_detail == 'null'){
                    return 'Please Select Award Detail';
                }
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    return 'Something went wrong';
                }
                $award_detail_id = intval(Crypt::decrypt($request->award_detail));
                $rs_result = DB::select(DB::raw("SELECT `abd`.`name_complete_e`, `abd`.`name_complete_l`, concat(`abd`.`hissa_numerator`,'/',`abd`.`hissa_denominator`) as `hissa`, `abd`.`value_txt`, `abd`.`page_no`, `adf`.`file_description` from `award_beneficiary_detail` `abd` inner join `award_detail_file` `adf` on `adf`.`id` = `abd`.`award_detail_file_id` where `award_detail_id` = $award_detail_id order by `abd`.`id`;"));
                $tcols = 6;
                $qcols = array(
                    array('Name (E)',10, 'name_complete_e', 0, '', 'left'),
                    array('Name (H)', 10, 'name_complete_l', 0, '', 'left'),
                    array('Hissa',10, 'hissa', 0, '', 'left'),
                    array('Value', 10, 'value_txt', 0, '', 'left'),
                    array('Award Detail File', 10, 'file_description', 0, '', 'left'),
                    array('Page No.', 10, 'page_no', 0, '', 'left'),
                );
            }
            $path=Storage_path('fonts/');
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir']; 
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata']; 
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' =>'A4-L',
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
            $html = view('admin.report.print', compact('rs_result', 'tcols', 'qcols', 'show_total_row'));
            $mpdf->WriteHTML($html); 
            $mpdf->Output();          
        } catch (Exception $e) {
            $e_method = "reportPrint";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}
