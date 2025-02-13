<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helper\MyFuncs;
use App\Helper\SelectBox;

class AwardBeneficiaryController extends Controller
{
    protected $e_controller = "AwardBeneficiaryController";

    public function awardBeneficiaryIndex()
    { 
        try {
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.awardBeneficiary.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "awardBeneficiaryIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function awardBeneficiaryTable(Request $request)
    { 
        try {
            $award_detail_id = intval(Crypt::decrypt($request->id));
            $rs_beneficiary = DB::select(DB::raw("SELECT `abd`.`id`, `abd`.`name_complete_e`, `abd`.`name_complete_l`, `abd`.`hissa_numerator`, `abd`.`hissa_denominator`, `abd`.`value_txt`, `abd`.`page_no`, `adf`.`file_description`, `abd`.`status` from `award_beneficiary_detail` `abd` left join `award_detail_file` `adf` on `adf`.`id` = `abd`.`award_detail_file_id` where `award_detail_id` = $award_detail_id and `status` < 3;"));

            $rs_scheme_detail = DB::select(DB::raw("SELECT `sh`.`scheme_name_e`, `th`.`name_e` as `tehsil_name`, `vl`.`name_e` as `vil_name`, `sai`.`award_no`, date_format(`sai`.`award_date`, '%d-%m-%Y') as `date_of_award`, `sai`.`year`, `ad`.`khasra_no`, `ad`.`khata_no`, `ad`.`mustil_no`, `ad`.`khasra_no`, `ad`.`total_value` from `award_detail` `ad` inner join `scheme_award_info` `sai` on `sai`.`id` = `ad`.`scheme_award_info_id` inner join `schemes` `sh` on `sh`.`id` = `sai`.`scheme_id` inner join `tehsils` `th` on `th`.`id` = `sai`.`tehsil_id` inner join `villages` `vl` on `vl`.`id` = `sai`.`village_id` where `ad`.`id` = $award_detail_id limit 1;"));  

            $rs_total_entered = DB::select(DB::raw("SELECT sum(`abd`.`hissa_numerator`/`abd`.`hissa_denominator`) as `hissa_added`, sum(`abd`.`value`) as `total_value_added`, count(*) as `total_rec` from `award_beneficiary_detail` `abd` where `abd`.`award_detail_id` = $award_detail_id and `status` <> 3;"));  
            return view('admin.master.awardBeneficiary.table',compact('rs_beneficiary', 'award_detail_id', 'rs_scheme_detail', 'rs_total_entered'));
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryAddForm(Request $request, $rec_id)
    { 
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            
            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id`, `award_detail_id` from `award_beneficiary_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                $award_detail_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                    $award_detail_id = $rs_fetch[0]->award_detail_id;
                }    
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    $error_message = 'Something Went Wrong';
                    return view('admin.common.error_popup', compact('error_message'));    
                }
            }else{
                $award_detail_id = intval(Crypt::decrypt($request->award_detail));
            }
            $rs_relation = DB::select(DB::raw("SELECT `id` as `opt_id`, `relation_e` as `opt_text` from `relation`;"));
            $rs_award_detail_file = DB::select(DB::raw("SELECT `id` as `opt_id`, `file_description` as `opt_text` from `scheme_award_info_file`;"));
            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_detail` where `id` =  $rec_id limit 1;"));
            return view('admin.master.awardBeneficiary.add_form',compact('rs_relation', 'rs_award_detail_file', 'rs_records', 'rec_id', 'award_detail_id'));
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'award_detail_id' => 'required',                
            ];
            $customMessages = [
                'award_detail_id.required'=> 'Something went wrong',
            ];
            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }
            $user_id = MyFuncs::getUserId();
            $from_ip = MyFuncs::getIp();
            $award_detail_id = intval(Crypt::decrypt($request->award_detail_id));

            $name_1_e = substr(MyFuncs::removeSpacialChr($request->name_1_e), 0, 50);
            $name_1_l = MyFuncs::removeSpacialChr($request->name_1_l);
            $relation_1_id = intval(Crypt::decrypt($request->relation_1_id));

            $name_2_e = substr(MyFuncs::removeSpacialChr($request->name_2_e), 0, 50);
            $name_2_l = MyFuncs::removeSpacialChr($request->name_2_l);
            $relation_2_id = intval(Crypt::decrypt($request->relation_2_id));

            $name_3_e = substr(MyFuncs::removeSpacialChr($request->name_3_e), 0, 50);
            $name_3_l = MyFuncs::removeSpacialChr($request->name_3_l);
            
            $hissa_numerator = intval(MyFuncs::removeSpacialChr($request->hissa_numerator));
            $hissa_denominator = intval(MyFuncs::removeSpacialChr($request->hissa_denominator));
            $value = floatval(MyFuncs::removeSpacialChr($request->value));

            $award_detail_file_id = intval(Crypt::decrypt($request->award_detail_file_id));
            $page_no = intval($request->page_no);

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_beneficiary_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }    
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    $response=['status'=>0,'msg'=>'Something Went Wrong'];
                    return response()->json($response);    
                }
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` = $award_detail_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }    
                $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
                if($is_permission == 0){
                    $response=['status'=>0,'msg'=>'Something Went Wrong'];
                    return response()->json($response);    
                }
            }

            $rs_save = DB::select(DB::raw("call `up_save_award_beneficiary_detail`($user_id, $rec_id, $scheme_award_info_id, $award_detail_id, '$name_1_e', '$name_1_l', $relation_1_id, '$name_2_e', '$name_2_l', $relation_2_id, '$name_3_e', '$name_3_l', $hissa_numerator, $hissa_denominator, $value, $award_detail_file_id, $page_no,'$from_ip');"));
            $response=['status'=>$rs_save[0]->s_status,'msg'=>$rs_save[0]->result];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryDelete($rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_beneficiary_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }
            }
            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $user_id = MyFuncs::getUserId();
            $from_ip = MyFuncs::getIp();

            // $rs_save = DB::select(DB::raw("call `up_delete_award_land_detail`($user_id, $rec_id, '$from_ip');"));
            $response=['status'=>$rs_save[0]->s_status,'msg'=>$rs_save[0]->result];
            return response()->json($response);   
        } catch (\Exception $e) {
            $e_method = "awardDetailDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}