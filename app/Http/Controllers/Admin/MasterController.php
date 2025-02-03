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
            $rs_schemes = SelectBox::get_schemes_access_list_v1();
            $rs_district = SelectBox::get_district_access_list_v1(); 
            return view('admin.master.schemeAwardInfo.index',compact('rs_schemes', 'rs_district'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAwardTable(Request $request)
    { 
        try {
            $scheme_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT `sai`.`id`, `d`.`name_e` as `d_name`, `t`.`name_e` as `t_name`, `v`.`name_e` as `v_name`, `sai`.`award_no`, date_format(`sai`.`award_date`, '%d-%m-%Y') as `award_date`, `year` from `scheme_award_info` `sai` inner join `districts` `d` on `d`.`id` = `sai`.`district_id` inner join `tehsils` `t` on `t`.`id` = `sai`.`tehsil_id` inner join `villages` `v` on `v`.`id` = `sai`.`village_id` where `sai`.`scheme_id` =  $scheme_id limit 1;"));  
            return view('admin.master.schemeAwardInfo.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "schemeAwardTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }

    }

    public function schemeAwardAddForm(Request $request, $rec_id)
    { 
        try {
            if ($request->tehsil == 'null') {
                $error_message = 'Please Select Tehsil';
                return view('admin.common.error_popup', compact('error_message'));
            }
            if ($request->village == 'null') {
                $error_message = 'Please Select Village';
                return view('admin.common.error_popup', compact('error_message'));
            }
            if ($request->scheme == 'null') {
                $error_message = 'Please Select Scheme';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $district_id = intval(Crypt::decrypt($request->district));
            $tehsil_id = intval(Crypt::decrypt($request->tehsil));
            $village_id = intval(Crypt::decrypt($request->village));
            $scheme_id = intval(Crypt::decrypt($request->scheme));
            $rs_records = DB::select(DB::raw("SELECT `award_no`, date_format(`award_date`, '%d-%m-%Y') as `award_date`, `year` from `scheme_award_info` where `id` =  $rec_id limit 1;"));
            return view('admin.master.schemeAwardInfo.add_form',compact('rs_records', 'rec_id', 'district_id', 'tehsil_id', 'village_id', 'scheme_id'));
        } catch (Exception $e) {
            $e_method = "schemeAwardAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'district_id' => 'required',             
                'tehsil_id' => 'required',             
                'village_id' => 'required',             
                'scheme_id' => 'required',
                'award_no' => 'required',
                'award_date' => 'required',
                'year' => 'required',
            ];
            $customMessages = [
                'district_id.required'=> 'Something went wrong',
                'tehsil_id.required'=> 'Something went wrong',
                'village_id.required'=> 'Something went wrong',
                'scheme_id.required'=> 'Something went wrong',
                'award_no.required'=> 'Please Enter Award No.',
                'award_date.required'=> 'Please Enter Award Date',
                'year.required'=> 'Please Enter Year',
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
            $village_id = intval(Crypt::decrypt($request->village_id));
            $scheme_id = intval(Crypt::decrypt($request->scheme_id));
            $award_no = substr(MyFuncs::removeSpacialChr($request->award_no), 0, 10);
            $award_date = substr(MyFuncs::removeSpacialChr($request->award_date), 0, 10);
            $year = substr(MyFuncs::removeSpacialChr($request->year), 0, 10);
            $result_date = MyFuncs::check_valid_date($award_date);
            if($result_date[0] == 0){
                $response=array();
                $response['status']=0;
                $response['msg']='Award Date Not Valid';   
                return $response;
            }
            $award_date = $result_date[2];
            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `scheme_award_info` (`state_id`, `district_id`, `tehsil_id`, `village_id`, `scheme_id`, `award_no`, `award_date`, `year`) values ($state_id, $district_id, $tehsil_id, $village_id, $scheme_id, '$award_no', '$award_date', '$year');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `scheme_award_info` set `award_no` = '$award_no', `award_date` = '$award_date', `year` = '$year' where `id` = $rec_id limit 1;"));
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `scheme_award_info_file` where `scheme_award_info_id` =$scheme_award_info_id;"));  
            return view('admin.master.schemeAwardFileInfo.table',compact('rs_records'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardFileAddForm(Request $request, $rec_id)
    { 
        try {
            
            if ($request->scheme_award_info == 'null') {
                $error_message = 'Please Select Scheme Awerd';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $scheme_id = intval(Crypt::decrypt($request->scheme));
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            $rs_records = DB::select(DB::raw("SELECT `file_path`, `file_description` from `scheme_award_info_file` where `id` =  $rec_id limit 1;"));
            return view('admin.master.schemeAwardFileInfo.add_form',compact('rs_records', 'rec_id', 'scheme_id', 'scheme_award_info_id'));
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardFileStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_id' => 'required',
                'scheme_award_info_id' => 'required',
                'file' => 'nullable|mimes:pdf|max:100',
            ];
            $customMessages = [
                'scheme_id.required'=> 'Something went wrong',
                'scheme_award_info_id.required'=> 'Something went wrong',
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
            $discription = substr(MyFuncs::removeSpacialChr($request->discription), 0, 250);

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
        } catch (\Exception $e) {
            $e_method = "schemeAwardFileStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailIndex()
    { 
        try {
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->id));
            $rs_records = DB::select(DB::raw("SELECT * from `award_detail` where `scheme_award_info_id` =$scheme_award_info_id;"));  
            return view('admin.master.awardDetail.table',compact('rs_records'));
        } catch (\Exception $e) {
            $e_method = "awardDetailTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailAddForm(Request $request, $rec_id)
    { 
        try {
            
            if ($request->scheme_award_info == 'null') {
                $error_message = 'Please Select Scheme Awerd';
                return view('admin.common.error_popup', compact('error_message'));
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info));
            $rs_records = DB::select(DB::raw("SELECT * from `award_detail` where `id` =  $rec_id limit 1;"));
            return view('admin.master.awardDetail.add_form',compact('rs_records', 'rec_id', 'scheme_award_info_id'));
        } catch (Exception $e) {
            $e_method = "awardDetailAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_award_info_id' => 'required',
                'khewat_no' => 'required',
                'khata_no' => 'required',
                'khasra_no' => 'required',
                'unit' => 'required',
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
            $khasra_no = substr(MyFuncs::removeSpacialChr($request->khasra_no), 0, 10);
            $unit = intval($request->unit);
            $kanal = substr(MyFuncs::removeSpacialChr($request->kanal), 0, 4);
            $marla = substr(MyFuncs::removeSpacialChr($request->marla), 0, 4);
            $sirsai = substr(MyFuncs::removeSpacialChr($request->sirsai), 0, 4);
            $value = floatval(MyFuncs::removeSpacialChr($request->value));
            $factor_value = floatval(MyFuncs::removeSpacialChr($request->factor_value));
            $solatium_value = floatval(MyFuncs::removeSpacialChr($request->solatium_value));
            $additional_charge_value = floatval(MyFuncs::removeSpacialChr($request->additional_charge_value));

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `award_detail` (`scheme_award_info_id`, `khewat_no`, `khata_no`, `khasra_no`, `unit`, `kanal`, `marla`, `sirsai`, `value`, `factor_value`, `solatium_value`, `additional_charge_value`) values ('$scheme_award_info_id', '$khewat_no', '$khata_no', '$khasra_no', $unit, '$kanal', '$marla', '$sirsai', '$value', '$factor_value', '$solatium_value', '$additional_charge_value');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `award_detail` set `Khewat_no` = '$Khewat_no', `khata_no` = '$khata_no', `khasra_no` = '$khasra_no', `unit` = $unit, `kanal` = '$kanal', `marla` = '$marla', `sirsai` = '$sirsai', `value` = '$value', `factor_value` = '$factor_value', `solatium_value` = '$solatium_value', `additional_charge_value` = '$additional_charge_value' where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardDetailStore";
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
            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_detail` where `award_detail_id` =$award_detail_id;"));  
            return view('admin.master.awardBeneficiary.table',compact('rs_records'));
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryAddForm(Request $request, $rec_id)
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
            $rs_relation = DB::select(DB::raw("SELECT `id` as `opt_id`, `relation_e` as `opt_text` from `relation`;"));
            $rs_award_detail_file = DB::select(DB::raw("SELECT `id` as `opt_id`, `file_description` as `opt_text` from `award_detail_file`;"));
            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_detail` where `id` =  $rec_id limit 1;"));
            return view('admin.master.awardBeneficiary.add_form',compact('rs_relation', 'rs_award_detail_file', 'rs_records', 'rec_id', 'scheme_id', 'scheme_award_info_id', 'award_detail_id'));
        } catch (\Exception $e) {
            $e_method = "awardBeneficiaryAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardBeneficiaryStore(Request $request, $rec_id)
    {
        try {
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'scheme_award_info_id' => 'required',
                'award_detail_id' => 'required',                
            ];
            $customMessages = [
                'scheme_award_info_id.required'=> 'Something went wrong',
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
            $scheme_award_info_id = intval(Crypt::decrypt($request->scheme_award_info_id));
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

            if ($rec_id == 0) {
                $rs_save = DB::select(DB::raw("INSERT into `award_beneficiary_detail` (`scheme_award_info_id`, `award_detail_id`, `name_1_e`, `name_1_l`, `relation_1_id`, `name_2_e`, `name_2_l`, `relation_2_id`, `name_3_e`, `name_3_l`, `hissa_numerator`, `hissa_denominator`, `value`, `award_detail_file_id`, `page_no`) values ($scheme_award_info_id, $award_detail_id, '$name_1_e', '$name_1_l', '$relation_1_id', '$name_2_e', '$name_2_l', '$relation_2_id', '$name_3_e', '$name_3_l', '$hissa_numerator', '$hissa_denominator', '$value', '$award_detail_file_id', '$page_no');"));
                $response=['status'=>1,'msg'=>'Created Successfully'];
            }else{
                $rs_save = DB::select(DB::raw("UPDATE `award_beneficiary_detail` set `name_1_e` = '$name_1_e', `name_1_l` = '$name_1_l', `relation_1_id` = $relation_1_id, `name_2_e` = '$name_2_e', `name_2_l` = '$name_2_l', `relation_2_id` = $relation_2_id, `name_3_e` = '$name_3_e', `name_3_l` = '$name_3_l', `hissa_numerator` = '$hissa_numerator', `hissa_denominator` = '$hissa_denominator', `value` = '$value', `award_detail_file_id` = $award_detail_file_id, `page_no` = $page_no where `id` = $rec_id limit 1;"));
                $response=['status'=>1,'msg'=>'Updated Successfully'];
            }
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "awardBeneficiaryStore";
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
