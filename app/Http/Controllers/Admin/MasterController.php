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

class MasterController extends Controller
{
    protected $e_controller = "MasterController";

    public function stateIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(11);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT * from `states` Order by `name_e`;"));  
            return view('admin.master.state.index',compact('rs_records'));
        } catch (\Exception $e) {
            $e_method = "stateIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function stateAddForm($rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(11);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rs_records = DB::select(DB::raw("SELECT * from `states` where `id` = $rec_id Order by `name_e`;"));  
            return view('admin.master.state.add_form',compact('rs_records', 'rec_id'));
        } catch (\Exception $e) {
            $e_method = "stateAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function stateStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(11);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'code' => 'required|max:5|unique:states,code,'.$rec_id,             
                'name_e' => 'required|max:50|unique:states,name_e,'.$rec_id,            
                'name_l' => 'required|max:100',
            ];
            $customMessages = [
                'code.required'=> 'Please Enter Code',
                'code.max'=> 'Code Should Be Maximum of 5 Characters',

                'name_e.required'=> 'Please Enter Name',
                'name_e.max'=> 'Name Should Be Maximum of 50 Characters',

                'name_l.required'=> 'Please Enter Name Hindi',
                'name_l.max'=> 'Name Hindi Should Be Maximum of 100 Characters',
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

            $code = substr(MyFuncs::removeSpacialChr($request->code), 0, 5);
            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 50);
            $name_l = MyFuncs::removeSpacialChr($request->name_l);
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `states` (`code`, `name_e`, `name_l`) values ('$code', '$name_e', '$name_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `states` set `code` = '$code', `name_e` = '$name_e', `name_l` = '$name_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "stateStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function districtIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(12);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_states = DB::select(DB::raw("SELECT `id` as `opt_id`, `name_e` as `opt_text` from `states` Order by `name_e`;"));  
            return view('admin.master.district.index',compact('rs_states'));
        } catch (Exception $e) {
            $e_method = "districtIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function districtTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(12);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $state_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `districts` where `state_id` = $state_id Order by `name_e`;"));  
            return view('admin.master.district.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "districtTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function districtAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(12);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $state_id = intval(Crypt::decrypt($request->state_id));
            $rs_records = DB::select(DB::raw("SELECT * from `districts` where `id` = $rec_id limit 1;"));  
            return view('admin.master.district.add_form',compact('rs_records', 'rec_id', 'state_id'));
        } catch (Exception $e) {
            $e_method = "districtAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function districtStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(12);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'state_id' => 'required',             
                'code' => 'required|max:5|unique:districts,code,'.$rec_id,             
                'name_e' => 'required|max:50|unique:districts,name_e,'.$rec_id,            
                'name_l' => 'required|max:100',
            ];
            $customMessages = [
                'state_id.required'=> 'Something went wrong',
                'code.required'=> 'Please Enter Code',
                'code.max'=> 'Code Should Be Maximum of 5 Characters',

                'name_e.required'=> 'Please Enter Name',
                'name_e.max'=> 'Name Should Be Maximum of 50 Characters',

                'name_l.required'=> 'Please Enter Name Hindi',
                'name_l.max'=> 'Name Hindi Should Be Maximum of 100 Characters',
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
            $state_id = intval(Crypt::decrypt($request->state_id));
            $code = substr(MyFuncs::removeSpacialChr($request->code), 0, 5);
            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 50);
            $name_l = MyFuncs::removeSpacialChr($request->name_l);
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `districts` (`state_id`, `code`, `name_e`, `name_l`) values ($state_id, '$code', '$name_e', '$name_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `districts` set `code` = '$code', `name_e` = '$name_e', `name_l` = '$name_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "districtStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function tehsilIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(13);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_districts = DB::select(DB::raw("SELECT `id` as `opt_id`, `name_e` as `opt_text` from `districts` Order by `name_e`;"));  
            return view('admin.master.tehsil.index',compact('rs_districts'));
        } catch (Exception $e) {
            $e_method = "tehsilIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function tehsilTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(13);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $district_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `tehsils` where `districts_id` = $district_id Order by `name_e`;"));  
            return view('admin.master.tehsil.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "tehsilTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function tehsilAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(13);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $district_id = intval(Crypt::decrypt($request->district));
            $rs_records = DB::select(DB::raw("SELECT * from `tehsils` where `id` = $rec_id limit 1;"));  
            return view('admin.master.tehsil.add_form',compact('rs_records', 'rec_id', 'district_id'));
        } catch (Exception $e) {
            $e_method = "tehsilAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function tehsilStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(13);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'district_id' => 'required',             
                'code' => 'required|max:5|unique:tehsils,code,'.$rec_id,             
                'name_e' => 'required|max:50|unique:tehsils,name_e,'.$rec_id,            
                'name_l' => 'required|max:100',
            ];
            $customMessages = [
                'district_id.required'=> 'Something went wrong',
                'code.required'=> 'Please Enter Code',
                'code.max'=> 'Code Should Be Maximum of 5 Characters',

                'name_e.required'=> 'Please Enter Name',
                'name_e.max'=> 'Name Should Be Maximum of 50 Characters',

                'name_l.required'=> 'Please Enter Name Hindi',
                'name_l.max'=> 'Name Hindi Should Be Maximum of 100 Characters',
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
            $district_id = intval(Crypt::decrypt($request->district_id));
            $state_id = MyFuncs::getStateId_ByDistrict($district_id);
            $code = substr(MyFuncs::removeSpacialChr($request->code), 0, 5);
            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 50);
            $name_l = MyFuncs::removeSpacialChr($request->name_l);
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `tehsils` (`states_id`, `districts_id`, `code`, `name_e`, `name_l`) values ($state_id, $district_id, '$code', '$name_e', '$name_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `tehsils` set `code` = '$code', `name_e` = '$name_e', `name_l` = '$name_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "tehsilStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function villageIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(14);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_district = SelectBox::get_district_access_list_v1(); 
            return view('admin.master.village.index',compact('rs_district'));
        } catch (Exception $e) {
            $e_method = "villageIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function villageTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(14);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $tehsil_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `villages` where `tehsil_id` = $tehsil_id Order by `name_e`;"));  
            return view('admin.master.village.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "villageTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function villageAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(14);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            if ($request->tehsil == 'null') {
                $error_message = 'Please Select Tehsil';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $district_id = intval(Crypt::decrypt($request->district));
            $tehsil_id = intval(Crypt::decrypt($request->tehsil));
            $rs_records = DB::select(DB::raw("SELECT * from `villages` where `id` = $rec_id limit 1;"));  
            return view('admin.master.village.add_form',compact('rs_records', 'rec_id', 'district_id', 'tehsil_id'));
        } catch (Exception $e) {
            $e_method = "villageAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function villageStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(14);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'district_id' => 'required',             
                'tehsil_id' => 'required',             
                'code' => 'required|max:5|unique:villages,code,'.$rec_id,             
                'name_e' => 'required|max:50|unique:villages,name_e,'.$rec_id,            
                'name_l' => 'required|max:100',
            ];
            $customMessages = [
                'district_id.required'=> 'Something went wrong',
                'tehsil_id.required'=> 'Something went wrong',
                'code.required'=> 'Please Enter Code',
                'code.max'=> 'Code Should Be Maximum of 5 Characters',

                'name_e.required'=> 'Please Enter Name',
                'name_e.max'=> 'Name Should Be Maximum of 50 Characters',

                'name_l.required'=> 'Please Enter Name Hindi',
                'name_l.max'=> 'Name Hindi Should Be Maximum of 100 Characters',
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
            $district_id = intval(Crypt::decrypt($request->district_id));
            $state_id = MyFuncs::getStateId_ByDistrict($district_id);
            $tehsil_id = intval(Crypt::decrypt($request->tehsil_id));
            $code = substr(MyFuncs::removeSpacialChr($request->code), 0, 5);
            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 50);
            $name_l = MyFuncs::removeSpacialChr($request->name_l);
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `villages` (`states_id`, `districts_id`, `tehsil_id`, `code`, `name_e`, `name_l`) values ($state_id, $district_id, $tehsil_id, '$code', '$name_e', '$name_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `villages` set `states_id` = $state_id, `districts_id` = $district_id, `tehsil_id` = $tehsil_id, `code` = '$code', `name_e` = '$name_e', `name_l` = '$name_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "villageStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(15);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT * from `schemes` Order by `scheme_name_e`;"));  
            return view('admin.master.scheme.index',compact('rs_records'));
        } catch (\Exception $e) {
            $e_method = "schemeIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAddForm($rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(15);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rs_records = DB::select(DB::raw("SELECT * from `schemes` where `id` = $rec_id limit 1;"));  
            return view('admin.master.scheme.add_form',compact('rs_records', 'rec_id'));
        } catch (\Exception $e) {
            $e_method = "schemeAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(15);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'name_e' => 'required|max:50',            
                'name_l' => 'required|max:100',
            ];
            $customMessages = [
                'name_e.required'=> 'Please Enter Scheme Name',
                'name_e.max'=> 'Scheme Name Should Be Maximum of 50 Characters',

                'name_l.required'=> 'Please Enter Scheme Name Hindi',
                'name_l.max'=> 'Scheme Name Hindi Should Be Maximum of 100 Characters',
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

            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 50);
            $name_l = MyFuncs::removeSpacialChr($request->name_l);
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `schemes` (`scheme_name_e`, `scheme_name_l`) values ('$name_e', '$name_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `schemes` set `scheme_name_e` = '$name_e', `scheme_name_l` = '$name_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "schemeStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(16);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.schemeAwardInfo.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAwardTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(16);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $scheme_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT `sai`.`id`, `d`.`name_e` as `d_name`, `t`.`name_e` as `t_name`, `v`.`name_e` as `v_name`, `sai`.`award_no`, date_format(`sai`.`award_date`, '%d-%m-%Y') as `award_date`, `year`, case `area_unit` when 1 then 'Kanal-Marla' when 2 then 'Bigha-Biswa' else '' end as `unit` from `scheme_award_info` `sai` inner join `districts` `d` on `d`.`id` = `sai`.`district_id` inner join `tehsils` `t` on `t`.`id` = `sai`.`tehsil_id` inner join `villages` `v` on `v`.`id` = `sai`.`village_id` where `sai`.`scheme_id` =  $scheme_id order by `d`.`name_e`, `t`.`name_e`, `v`.`name_e`;"));  
            return view('admin.master.schemeAwardInfo.table',compact('rs_records', 'scheme_id'));
        } catch (Exception $e) {
            $e_method = "schemeAwardTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAwardAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(16);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rs_district = "";
            $scheme_id = "";
            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `id`, `scheme_id`, `district_id`, `tehsil_id`, `village_id`, `award_no`, date_format(`award_date`, '%d-%m-%Y') as `awd_date`, `year` from `scheme_award_info` where `id` = $rec_id limit 1;"));
                if(count($rs_fetch) == 0){
                    $error_message = 'Something Went Wrong';
                    return view('admin.common.error_popup', compact('error_message'));
                }
                $village_id = $rs_fetch[0]->village_id;
                $is_permission = MyFuncs::check_village_access($village_id);
                if($is_permission == 0){
                    $error_message = 'Something Went Wrong';
                    return view('admin.common.error_popup', compact('error_message'));    
                }
            }else{
                $rs_district = SelectBox::get_district_access_list_v1();
                $scheme_id = intval(Crypt::decrypt($request->scheme));
            }
            $rs_records = DB::select(DB::raw("SELECT `id`, `scheme_id`, `district_id`, `tehsil_id`, `village_id`, `award_no`, date_format(`award_date`, '%d-%m-%Y') as `awd_date`, `year`, `area_unit` from `scheme_award_info` where `id` = $rec_id limit 1;"));
            return view('admin.master.schemeAwardInfo.add_form',compact('rs_records', 'rec_id', 'rs_district', 'scheme_id'));
        } catch (Exception $e) {
            $e_method = "schemeAwardAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(16);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            if($rec_id == 0){
                $rules=[
                    'district' => 'required',
                    'tehsil' => 'required',
                    'village' => 'required',
                    'scheme_id' => 'required',
                    'unit' => 'required',
                ];
                $customMessages = [
                    'district.required'=> 'Please Select District',
                    'tehsil.required'=> 'Please Select Tehsil',
                    'village.required'=> 'Please Select Village',
                    'scheme_id.required'=> 'Something Went Wrong',
                    'unit.required'=> 'Please Select Unit',
                ];
                $validator = Validator::make($request->all(),$rules, $customMessages);
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]=$errors[0];
                    return response()->json($response);// response as json
                }    
            }
            
            $rules=[
                'award_no' => 'required',
                'award_date' => 'required',
                'year' => 'required',
                'unit' => 'required',
            ];
            $customMessages = [
                'award_no.required'=> 'Please Enter Award No.',
                'award_date.required'=> 'Please Enter Award Date',
                'year.required'=> 'Please Enter Jamabandi Year',
                'unit.required'=> 'Please Select Unit',
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
            
            if ($rec_id == 0) {
                $district_id = intval(Crypt::decrypt($request->district));
                $state_id = MyFuncs::getStateId_ByDistrict($district_id);
                $tehsil_id = intval(Crypt::decrypt($request->tehsil));
                $village_id = intval(Crypt::decrypt($request->village));
                $scheme_id = intval(Crypt::decrypt($request->scheme_id));
                if($scheme_id == 0){
                    $response=['status'=>0,'msg'=>'Please Select Scheme/Award'];
                    return response()->json($response);
                }
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `id`, `scheme_id`, `district_id`, `tehsil_id`, `village_id`, `award_no`, date_format(`award_date`, '%d-%m-%Y') as `awd_date`, `year` from `scheme_award_info` where `id` = $rec_id limit 1;"));
                if(count($rs_fetch) == 0){
                    $response=['status'=>0,'msg'=>'Something Went Wrong'];
                    return response()->json($response);
                }
                $village_id = $rs_fetch[0]->village_id;
            }

            $is_permission = MyFuncs::check_village_access($village_id);
            if($is_permission == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            
            $award_no = substr(MyFuncs::removeSpacialChr($request->award_no), 0, 10);
            $award_date = substr(MyFuncs::removeSpacialChr($request->award_date), 0, 10);
            $year = substr(MyFuncs::removeSpacialChr($request->year), 0, 10);
            $unit = intval($request->unit);
            $result_date = MyFuncs::check_valid_date($award_date);
            if($result_date[0] == 0){
                $response=array();
                $response['status']=0;
                $response['msg']='Award Date Not Valid';   
                return $response;
            }
            $award_date = $result_date[2];


            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `scheme_award_info` (`state_id`, `district_id`, `tehsil_id`, `village_id`, `scheme_id`, `award_no`, `award_date`, `year`, `area_unit`) values ($state_id, $district_id, $tehsil_id, $village_id, $scheme_id, '$award_no', '$award_date', '$year', '$unit');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `scheme_award_info` set `award_no` = '$award_no', `award_date` = '$award_date', `year` = '$year', `area_unit` = '$unit' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "schemeAwardStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardFileIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(17);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.schemeAwardFileInfo.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAwardFileTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(17);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $scheme_award_info_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `scheme_award_info_file` where `scheme_award_info_id` = $scheme_award_info_id;"));  
            return view('admin.master.schemeAwardFileInfo.table',compact('rs_records', 'scheme_award_info_id'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardFileAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(17);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $scheme_award_info_id = 0;
            if($rec_id == 0 ){
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            }
            $rs_records = DB::select(DB::raw("SELECT `file_path`, `file_description` from `scheme_award_info_file` where `id` =  $rec_id limit 1;"));
            return view('admin.master.schemeAwardFileInfo.add_form',compact('rs_records', 'rec_id', 'scheme_award_info_id'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardFileStore(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(17);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            if($rec_id == 0){
                $rules=[
                    'scheme_award_info_id' => 'required',
                ];
                $customMessages = [
                    'scheme_award_info_id.required'=> 'Something went wrong',
                ];
                $validator = Validator::make($request->all(),$rules, $customMessages);
                if ($validator->fails()) {
                    $errors = $validator->errors()->all();
                    $response=array();
                    $response["status"]=0;
                    $response["msg"]=$errors[0];
                    return response()->json($response);// response as json
                }    
            }
            $rules=[
                'discription' => 'required',
                'file' => 'nullable|mimes:pdf|max:100',
            ];
            $customMessages = [
                'discription.required'=> 'Please Enter File Description',
                'file.mimes'=> 'File/Attachment Accepted Only PDF',
                'file.max'=> 'File/Attachment Size Cannot Be More Then 100 KB',
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
            $discription = substr(MyFuncs::removeSpacialChr($request->discription), 0, 250);

            if($rec_id == 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_id` from `scheme_award_info` where `id` = $scheme_award_info_id limit 1;;"));
                if(count($rs_fetch) == 0){
                    $response=['status'=>0,'msg'=>'Something Went Wrong'];
                    return response()->json($response);
                }
                $scheme_id = $rs_fetch[0]->scheme_id;    
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_id` from `scheme_award_info_file` where `id` = $rec_id limit 1;;"));
                if(count($rs_fetch) == 0){
                    $response=['status'=>0,'msg'=>'Something Went Wrong'];
                    return response()->json($response);
                }
                $scheme_id = $rs_fetch[0]->scheme_id;   
            }
            

            $rs_fetch = DB::select(DB::raw("SELECT `file_path` from `scheme_award_info_file` where `id` = $rec_id limit 1;"));
            if (count($rs_fetch)>0) {
                $final_path_attachment = $rs_fetch[0]->file_path; 
            }else{
                $final_path_attachment = "";
            }
            
            if ($request->hasFile('file')){
                $attachment = $request->file;
                if($_FILES['file']['size'] > 100*1024) {
                    $response=['status'=>0,'msg'=>'File/Attachment Size cannot be more then 100 KB'];
                    return response()->json($response); 
                }elseif ($_FILES["file"]["type"]=='application/pdf') {
                    $filename = date('dmYHis').".pdf";

                }else{
                    $response=['status'=>0,'msg'=>'File/Attachment Accepted Only pdf'];
                    return response()->json($response);
                }
                $folder_path = "/document/schemeAwardInfo/".date('Y')."/".date('m')."/".$scheme_id."/";
                $final_path_attachment = $folder_path.'/'.$filename;
                $attachment->storeAs($folder_path,$filename);
            }

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `scheme_award_info_file` (`scheme_id`, `scheme_award_info_id`, `file_path`, `file_description`) values ($scheme_id, $scheme_award_info_id, '$final_path_attachment', '$discription');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `scheme_award_info_file` set `file_path` = '$final_path_attachment', `file_description` = '$discription' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "schemeAwardFileStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailIndex()
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.awardDetail.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "awardDetailIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function awardDetailTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $scheme_award_info_id = intval(Crypt::decrypt($request->id));
            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $scheme_award_info_id = 0;
            }
            $rs_records = DB::select(DB::raw("SELECT `ad`.`id`, `ad`.`khewat_no`, `ad`.`khata_no`, `ad`.`value_sep`, `ad`.`f_value_sep`, `ad`.`s_value_sep`, `ad`.`ac_value_sep`, `ad`.`t_value_sep`, `ad`.`status`, `uf_get_mustil_khasra_area_detail`(`ad`.`id`, 2) as `mustil_khasra_rakba` from `award_detail` `ad` where `scheme_award_info_id` = $scheme_award_info_id and `ad`.`status` < 3 order by `ad`.`id`;"));  

            $result_rs = DB::select(DB::raw("SELECT `sh`.`scheme_name_e`, `th`.`name_e` as `tehsil_name`, `vl`.`name_e` as `vil_name`, `sai`.`award_no`, date_format(`sai`.`award_date`, '%d-%m-%Y') as `date_of_award`, `sai`.`year`, case `sai`.`area_unit` when 1 then 'Kanal-Marla' when 2 then 'Bigha-Biswa' else '' end as `unit` from `scheme_award_info` `sai` inner join `schemes` `sh` on `sh`.`id` = `sai`.`scheme_id` inner join `tehsils` `th` on `th`.`id` = `sai`.`tehsil_id` inner join `villages` `vl` on `vl`.`id` = `sai`.`village_id` where `sai`.`id` = $scheme_award_info_id limit 1;"));
            return view('admin.master.awardDetail.table',compact('rs_records', 'scheme_award_info_id', 'result_rs'));
        } catch (Exception $e) {
            $e_method = "awardDetailTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailAddForm(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            if($rec_id == 0){
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }    
            }

            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $error_message = 'Something Went Wrong';
                return view('admin.common.error_popup', compact('error_message'));    
            }

            $rs_fetch = DB::select(DB::raw("SELECT `area_unit` from `scheme_award_info` where `id` =  $scheme_award_info_id limit 1;"));
            $unit = 1;
            if(count($rs_fetch) > 0){
                $unit = $rs_fetch[0]->area_unit;
            }
            
            $rs_records = DB::select(DB::raw("SELECT * from `award_detail` where `id` =  $rec_id limit 1;"));
            
            $rs_mustil_khsra_rakba = DB::select(DB::raw("SELECT * from `award_mustil_khasra_detail` where `award_land_detail_id` =  $rec_id and `status` = 0 ;"));
            if(count($rs_mustil_khsra_rakba) == 0){
                $rs_mustil_khsra_rakba = DB::select(DB::raw("SELECT 0 as `id`, '' as `mustil_no`, '' as `khasra_no`, '' as `kanal`, '' as `marla`, '' as `sirsai`;"));
            }
            return view('admin.master.awardDetail.add_form',compact('rs_records', 'rec_id', 'scheme_award_info_id', 'unit', 'rs_mustil_khsra_rakba'));
        } catch (Exception $e) {
            $e_method = "awardDetailAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailStore(Request $request, $rec_id)
    {
        try { 
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_award_info_id' => 'required',
                'khewat_no' => 'required',
                'khata_no' => 'required',
                'mustil_no' => 'required',
                'khasra_no' => 'required',
                'kanal' => 'required',
                'marla' => 'required',
                'sirsai' => 'required',
                'value' => 'required',
                'factor_value' => 'required',
                'solatium_value' => 'required',
                'additional_charge_value' => 'required',
            ];
            $customMessages = [
                'scheme_award_info_id.required'=> 'Something went wrong',
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
            $khewat_no = substr(MyFuncs::removeSpacialChr($request->khewat_no), 0, 10);
            $khata_no = substr(MyFuncs::removeSpacialChr($request->khata_no), 0, 10);
            $value = floatval(MyFuncs::removeSpacialChr($request->value));
            $factor_value = floatval(MyFuncs::removeSpacialChr($request->factor_value));
            $solatium_value = floatval(MyFuncs::removeSpacialChr($request->solatium_value));
            $additional_charge_value = floatval(MyFuncs::removeSpacialChr($request->additional_charge_value));
            $total_value = $value+$factor_value+$solatium_value+$additional_charge_value;

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
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

            $rs_save = DB::select(DB::raw("call `up_save_award_land_detail`($user_id, $rec_id, '$scheme_award_info_id', '$khewat_no', '$khata_no', '$value', '$factor_value', '$solatium_value', '$additional_charge_value', '$from_ip');"));
            

            if($rs_save[0]->s_status == 1){
                $land_award_rec_id = $rs_save[0]->rec_id;

                $rec_id = 0;
                $in_mustil_no = $request->mustil_no; 
                $in_khasra_no = $request->khasra_no; 
                $in_kanal = $request->kanal; 
                $in_marla = $request->marla; 
                $in_sirsai = $request->sirsai; 
                foreach ($request->mustil_no as $key => $value) {
                    $mustil_no = substr(MyFuncs::removeSpacialChr($in_mustil_no[$key]), 0, 10);
                    $khasra_no = substr(MyFuncs::removeSpacialChr($in_khasra_no[$key]), 0, 10);
                    $kanal = intval($in_kanal[$key]);
                    $marla = intval($in_marla[$key]);
                    $sirsai = intval($in_sirsai[$key]);
                    $rs_insert = DB::select(DB::raw("call `up_save_mustil_khsra_rakba`($user_id, $rec_id, $land_award_rec_id, '$mustil_no', '$khasra_no', $kanal, $marla, $sirsai, '$from_ip');"));
                }
            }            
            $response=['status'=>$rs_save[0]->s_status,'msg'=>$rs_save[0]->result];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardDetailStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailEdit(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            if($rec_id == 0){
                $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }    
            }

            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $error_message = 'Something Went Wrong';
                return view('admin.common.error_popup', compact('error_message'));    
            }

            $rs_fetch = DB::select(DB::raw("SELECT `area_unit` from `scheme_award_info` where `id` =  $scheme_award_info_id limit 1;"));
            $unit = 1;
            if(count($rs_fetch) > 0){
                $unit = $rs_fetch[0]->area_unit;
            }
            
            $rs_records = DB::select(DB::raw("SELECT * from `award_detail` where `id` =  $rec_id limit 1;"));
            
            $rs_mustil_khsra_rakba = DB::select(DB::raw("SELECT * from `award_mustil_khasra_detail` where `award_land_detail_id` =  $rec_id and `status` = 0 ;"));

            return view('admin.master.awardDetail.edit',compact('rs_records', 'rec_id', 'scheme_award_info_id', 'unit', 'rs_mustil_khsra_rakba'));
        } catch (Exception $e) {
            $e_method = "awardDetailEdit";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailUpdate(Request $request, $rec_id)
    {
        try { 
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_award_info_id' => 'required',
                'khewat_no' => 'required',
                'khata_no' => 'required',
                'value' => 'required',
                'factor_value' => 'required',
                'solatium_value' => 'required',
                'additional_charge_value' => 'required',
            ];
            $customMessages = [
                'scheme_award_info_id.required'=> 'Something went wrong',
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
            $khewat_no = substr(MyFuncs::removeSpacialChr($request->khewat_no), 0, 10);
            $khata_no = substr(MyFuncs::removeSpacialChr($request->khata_no), 0, 10);
            $value = floatval(MyFuncs::removeSpacialChr($request->value));
            $factor_value = floatval(MyFuncs::removeSpacialChr($request->factor_value));
            $solatium_value = floatval(MyFuncs::removeSpacialChr($request->solatium_value));
            $additional_charge_value = floatval(MyFuncs::removeSpacialChr($request->additional_charge_value));
            $total_value = $value+$factor_value+$solatium_value+$additional_charge_value;

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
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

            $rs_save = DB::select(DB::raw("call `up_save_award_land_detail`($user_id, $rec_id, '$scheme_award_info_id', '$khewat_no', '$khata_no', '$value', '$factor_value', '$solatium_value', '$additional_charge_value', '$from_ip');"));                      
            $response=['status'=>$rs_save[0]->s_status,'msg'=>$rs_save[0]->result];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardDetailUpdate";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailEditPopup(Request $request, $rec_id)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));

            if ($rec_id == 0) {
                $award_land_detail_id = intval(Crypt::decrypt($request->land_award_rec_id));
            }else{
                $rs_fetch = DB::select(DB::raw("SELECT `award_land_detail_id` from `award_mustil_khasra_detail` where `id` =  $rec_id limit 1;"));
                $award_land_detail_id = $rs_fetch[0]->award_land_detail_id;
            }
            
            $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $award_land_detail_id limit 1;"));
                $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
            
            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $error_message = 'Something Went Wrong';
                return view('admin.common.error_popup', compact('error_message'));    
            }

            $rs_fetch = DB::select(DB::raw("SELECT `area_unit` from `scheme_award_info` where `id` =  $scheme_award_info_id limit 1;"));
            $unit = 1;
            if(count($rs_fetch) > 0){
                $unit = $rs_fetch[0]->area_unit;
            }

            $rs_mustil_khsra_rakba = DB::select(DB::raw("SELECT * from `award_mustil_khasra_detail` where `id` =  $rec_id and `status` = 0 limit 1;"));

            return view('admin.master.awardDetail.edit_popup',compact('rec_id', 'unit', 'rs_mustil_khsra_rakba', 'award_land_detail_id'));
        } catch (Exception $e) {
            $e_method = "awardDetailEditPopup";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailUpdatePopup(Request $request, $rec_id)
    {
        try { 
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'land_award_rec_id' => 'required',
                'mustil_no' => 'required',
                'khasra_no' => 'required',
                'kanal' => 'required',
                'marla' => 'required',
                'sirsai' => 'required',
            ];
            $customMessages = [
                'land_award_rec_id.required'=> 'Something went wrong',
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
            $land_award_rec_id = intval(Crypt::decrypt($request->land_award_rec_id));
            $mustil_no = substr(MyFuncs::removeSpacialChr($request->mustil_no), 0, 10);
            $khasra_no = substr(MyFuncs::removeSpacialChr($request->khasra_no), 0, 10);
            $kanal = intval($request->kanal);
            $marla = intval($request->marla);
            $sirsai = intval($request->sirsai);

            $rs_insert = DB::select(DB::raw("call `up_save_mustil_khsra_rakba`($user_id, $rec_id, $land_award_rec_id, '$mustil_no', '$khasra_no', $kanal, $marla, $sirsai, '$from_ip');"));
                  
            $response=['status'=>1,'msg'=>'Save Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardDetailUpdatePopup";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailDelete($rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
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

            $rs_save = DB::select(DB::raw("call `up_delete_award_land_detail`($user_id, $rec_id, '$from_ip');"));
            $response=['status'=>$rs_save[0]->s_status,'msg'=>$rs_save[0]->result];
            return response()->json($response);   
        } catch (\Exception $e) {
            $e_method = "awardDetailDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailPopupDelete($rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `award_land_detail_id` from `award_mustil_khasra_detail` where `id` =  $rec_id limit 1;"));
                $award_land_detail_id = $rs_fetch[0]->award_land_detail_id;

                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $award_land_detail_id limit 1;"));
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

            $rs_delete = DB::select(DB::raw("DELETE from `award_mustil_khasra_detail` where `id` = $rec_id limit 1;"));
            $response=['status'=>1,'msg'=>'Deleted Successfully'];
            return response()->json($response);  
        } catch (\Exception $e) {
            $e_method = "awardDetailPopupDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryView($rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));

            if($rec_id > 0){
                $rs_fetch = DB::select(DB::raw("SELECT `scheme_award_info_id` from `award_detail` where `id` =  $rec_id limit 1;"));
                $scheme_award_info_id = 0;
                if(count($rs_fetch) > 0){
                    $scheme_award_info_id = $rs_fetch[0]->scheme_award_info_id;
                }
            }
            $is_permission = MyFuncs::check_scheme_info_village_access($scheme_award_info_id);
            if($is_permission == 0){
                $error_message = 'Something Went Wrong';
                return view('admin.common.error_popup', compact('error_message'));
            }

            $rs_beneficiary = DB::select(DB::raw("SELECT `abd`.`id`, `abd`.`name_complete_e`, `abd`.`name_complete_l`, `abd`.`hissa_numerator`, `abd`.`hissa_denominator`, `abd`.`value_txt`, `abd`.`page_no`, `adf`.`file_description`, `abd`.`status` from `award_beneficiary_detail` `abd` left join `award_detail_file` `adf` on `adf`.`id` = `abd`.`award_detail_file_id` where `award_detail_id` = $rec_id;"));   
            return view('admin.master.awardDetail.beneficiary_view',compact('rs_beneficiary'));
        } catch (\Exception $e) {
            $e_method = "awardDetailDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailFileIndex()
    { 
        try {
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.awardDetailFile.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "awardDetailFileIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailFileTable(Request $request)
    { 
        try {
            $award_detail_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `award_detail_file` where `award_detail` =$award_detail_id;"));  
            return view('admin.master.awardDetailFile.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "awardDetailFileTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailFileAddForm(Request $request, $rec_id)
    { 
        try {
            
            if ($request->scheme_award_info == 'null') {
                $error_message = 'Please Select Scheme Awerd';
                return view('admin.common.error_popup', compact('error_message'));
            }
            if ($request->award_detail == 'null') {
                $error_message = 'Please Select Awerd Detail';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $scheme_id = intval(Crypt::decrypt($request->scheme));
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            $award_detail_id = intval(Crypt::decrypt($request->award_detail));
            $rs_records = DB::select(DB::raw("SELECT `file_path`, `file_description` from `award_detail_file` where `id` =  $rec_id limit 1;"));
            return view('admin.master.awardDetailFile.add_form',compact('rs_records', 'rec_id', 'scheme_id', 'scheme_award_info_id', 'award_detail_id'));
        } catch (\Exception $e) {
            $e_method = "awardDetailFileAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailFileStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_id' => 'required',
                'scheme_award_info_id' => 'required',
                'award_detail_id' => 'required',
                'file' => 'nullable|mimes:pdf|max:100',
                
            ];
            $customMessages = [
                'scheme_id.required'=> 'Something went wrong',
                'scheme_award_info_id.required'=> 'Something went wrong',
                'award_detail_id.required'=> 'Something went wrong',
                'file.mimes'=> 'File/Attachment Accepted Only PDF',
                'file.max'=> 'File/Attachment Size Cannot Be More Then 100 KB',
                
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
            $scheme_id = intval(Crypt::decrypt($request->scheme_id));
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
            $award_detail_id = intval(Crypt::decrypt($request->award_detail_id));
            $discription = substr(MyFuncs::removeSpacialChr($request->discription), 0, 250);

            $rs_fetch = DB::select(DB::raw("SELECT `file_path` from `award_detail_file` where `id` = $rec_id limit 1;"));
            if (count($rs_fetch)>0) {
                $final_path_attachment = $rs_fetch[0]->file_path; 
            }else{
                $final_path_attachment = "";
            }
            
            if ($request->hasFile('file')){
                $attachment = $request->file;
                if($_FILES['file']['size'] > 100*1024) {
                    $response=['status'=>0,'msg'=>'File/Attachment Size cannot be more then 100 KB'];
                    return response()->json($response); 
                }elseif ($_FILES["file"]["type"]=='application/pdf') {
                    $filename = date('dmYHis').".pdf";

                }else{
                    $response=['status'=>0,'msg'=>'File/Attachment Accepted Only pdf'];
                    return response()->json($response);
                }
                $folder_path = "/document/schemeAwardInfo/".date('Y')."/".date('m')."/".$award_detail_id."/";
                $final_path_attachment = $folder_path.'/'.$filename;
                $attachment->storeAs($folder_path,$filename);
            }

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `award_detail_file` (`scheme_id`, `scheme_award_info_id`, `award_detail`, `file_path`, `file_description`) values ($scheme_id, $scheme_award_info_id, $award_detail_id, '$final_path_attachment', '$discription');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `award_detail_file` set `file_path` = '$final_path_attachment', `file_description` = '$discription' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "awardDetailFileStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function relationIndex()
    { 
        try {
            $rs_records = DB::select(DB::raw("SELECT * from `relation` Order by `relation_e`;"));  
            return view('admin.master.relation.index',compact('rs_records'));
        } catch (\Exception $e) {
            $e_method = "relationIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function relationAddForm($rec_id)
    { 
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rs_records = DB::select(DB::raw("SELECT * from `relation` where `id` = $rec_id limit 1;"));  
            return view('admin.master.relation.add_form',compact('rs_records', 'rec_id'));
        } catch (\Exception $e) {
            $e_method = "relationAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function relationStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'code' => 'required|max:5',            
                'code_l' => 'required|max:20',            
                'relation_e' => 'required|max:20',
                'relation_l' => 'required|max:50',
            ];
            $customMessages = [
                'code.required'=> 'Please Enter Code',
                'code.max'=> 'Code Should Be Maximum of 5 Characters',
                'code_l.required'=> 'Please Enter Code Hindi',
                'code_l.max'=> 'Code Hindi Should Be Maximum of 20 Characters',

                'relation_e.required'=> 'Please Enter Relation',
                'relation_e.max'=> 'Relation Name Should Be Maximum of 20 Characters',
                'relation_l.required'=> 'Please Enter Relation Name',
                'relation_l.max'=> 'Relation Name Should Be Maximum of 50 Characters',
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

            $code = substr(MyFuncs::removeSpacialChr($request->code), 0, 5);
            $code_l = MyFuncs::removeSpacialChr($request->code_l);
            $relation_e = substr(MyFuncs::removeSpacialChr($request->relation_e), 0, 20);
            $relation_l = MyFuncs::removeSpacialChr($request->relation_l);

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `relation` (`code`, `code_l`, `relation_e`, `relation_l`) values ('$code', '$code_l', '$relation_e', '$relation_l');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `relation` set `code` = '$code', `code_l` = '$code_l', `relation_e` = '$relation_e', `relation_l` = '$relation_l' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "relationStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryPaymentIndex()
    { 
        try {
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            return view('admin.master.awardBeneficiaryPayment.index',compact('rs_schemes'));
        } catch (\Exception $e) {
            $e_method = "awardBeneficiaryPaymentIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function awardBeneficiaryPaymentTable(Request $request)
    { 
        try {
            $award_beneficiary_detail_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_payment_detail` where `award_beneficiary_detail` = $award_beneficiary_detail_id;"));  
            return view('admin.master.awardBeneficiaryPayment.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryPaymentTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryPaymentAddForm(Request $request, $rec_id)
    { 
        try {
            
            if ($request->scheme_award_info == 'null') {
                $error_message = 'Please Select Scheme Awerd';
                return view('admin.common.error_popup', compact('error_message'));
            }
            if ($request->award_detail == 'null') {
                $error_message = 'Please Select Awerd Detail';
                return view('admin.common.error_popup', compact('error_message'));
            }
            if ($request->award_beneficiary_detail == 'null') {
                $error_message = 'Please Select Awerd Beneficiary Detail';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $scheme_id = intval(Crypt::decrypt($request->scheme));
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            $award_detail_id = intval(Crypt::decrypt($request->award_detail));
            $award_beneficiary_detail_id = intval(Crypt::decrypt($request->award_beneficiary_detail));
            $rs_relation = DB::select(DB::raw("SELECT `id` as `opt_id`, `relation_e` as `opt_text` from `relation`;"));
            $rs_award_detail_file = DB::select(DB::raw("SELECT `id` as `opt_id`, `file_description` as `opt_text` from `award_detail_file`;"));
            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_payment_detail` where `id` =  $rec_id limit 1;"));
            return view('admin.master.awardBeneficiaryPayment.add_form',compact('rs_relation', 'rs_award_detail_file', 'rs_records', 'rec_id', 'scheme_id', 'scheme_award_info_id', 'award_detail_id', 'award_beneficiary_detail_id'));
        } catch (\Exception $e) {
            $e_method = "awardBeneficiaryPaymentAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryPaymentStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_award_info_id' => 'required',
                'award_detail_id' => 'required',                
                'award_beneficiary_detail_id' => 'required',                
            ];
            $customMessages = [
                'scheme_award_info_id.required'=> 'Something went wrong',
                'award_detail_id.required'=> 'Something went wrong',
                'award_beneficiary_detail_id.required'=> 'Something went wrong',
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
            $award_detail_id = intval(Crypt::decrypt($request->award_detail_id));
            $award_beneficiary_detail_id = intval(Crypt::decrypt($request->award_beneficiary_detail_id));

            $cheque_rtgs_no = substr(MyFuncs::removeSpacialChr($request->cheque_rtgs_no), 0, 30);
            $cheque_rtgs_date = substr(MyFuncs::removeSpacialChr($request->cheque_rtgs_date), 0, 30);
            $bank_name = substr(MyFuncs::removeSpacialChr($request->bank_name), 0, 50);
            $bank_address = substr(MyFuncs::removeSpacialChr($request->bank_address), 0, 50);
            $ifsc_code = substr(MyFuncs::removeSpacialChr($request->ifsc_code), 0, 20);
            $account_no = substr(MyFuncs::removeSpacialChr($request->account_no), 0, 20);
            
            $value = floatval(MyFuncs::removeSpacialChr($request->value));
            $award_detail_file_id = intval(Crypt::decrypt($request->award_detail_file_id));
            $page_no = intval($request->page_no);

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `award_beneficiary_payment_detail` (`scheme_award_info_id`, `award_detail_id`, `award_beneficiary_detail`, `cheque_rtgs_no`, `cheque_rtgs_date`, `bank_name`, `bank_address`, `ifsc_code`, `account_no`, `value`, `award_detail_file_id`, `page_no`) values ($scheme_award_info_id, $award_detail_id, $award_beneficiary_detail_id, '$cheque_rtgs_no', '$cheque_rtgs_date', '$bank_name', '$bank_address', '$ifsc_code', '$account_no', '$value', '$award_detail_file_id', '$page_no');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `award_beneficiary_payment_detail` set `cheque_rtgs_no` = '$cheque_rtgs_no', `cheque_rtgs_date` = '$cheque_rtgs_date', `bank_name` = '$bank_name', `bank_address` = '$bank_address', `ifsc_code` = '$ifsc_code', `account_no` = '$account_no', `value` = '$value', `award_detail_file_id` = $award_detail_file_id, `page_no` = $page_no where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryPaymentStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function exception_handler()
    {
        try {

        } catch (\Exception $e) {
            $e_method = "imageShowPath";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

}
