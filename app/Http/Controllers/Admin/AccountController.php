<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helper\MyFuncs;
use App\Helper\SelectBox;
use Session;
use Auth;
class AccountController extends Controller
{
    protected $e_controller = "AccountController";

    public function addNewUser()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(1);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $user_role = MyFuncs::getUserRoleId();
            $roles =DB::select(DB::raw("SELECT `id`, `name` from `roles` where `id`  > $user_role Order By `name`;"));
            return view('admin.account.add_new_user', compact('roles'));
        } catch (\Exception $e) {
            $e_method = "addNewUser";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(1);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rules=[
                'name' => 'required|string|min:3|max:50',             
                'role_id' => 'required',
                'mobile' => 'required|unique:admins|numeric|digits:10',
                'email' => 'required|max:100|email|unique:admins',
                'password' => 'required',
            ];

            $customMessages = [
                'name.required'=> 'Please Enter Name',
                'name.min'=> 'Name Should Be Minimum of 3 Characters',
                'name.max'=> 'Name Should Be Maximum of 50 Characters',
                'role_id.required'=> 'Please Select Role',
                'mobile.required'=> 'Please Enter Mobile No.',
                'mobile.numeric'=> 'Mobile No. Should Be In Digits Only',
                'mobile.digits'=> 'Mobile No. Should Be 10 Digits Long',
                'email.email'=> 'Email Id Not In Correct Format',
                'email.max'=> 'Email Should Be Maximum of 100 Characters',
                'password.required'=> 'Please Enter Password',
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
            $role_id = MyFuncs::getUserRoleId();
            $from_ip = MyFuncs::getIp();

            $name = substr(MyFuncs::removeSpacialChr($request->name), 0, 50);
            $new_role_id = intval(Crypt::decrypt($request->role_id));
            $mobile = substr(MyFuncs::removeSpacialChr($request->mobile), 0, 10);
            $email_id = substr(MyFuncs::removeSpacialChr($request->email), 0, 100);

            if($role_id >= $new_role_id){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);    
            }

            $account_id = 0;
            $email_available = MyFuncs::check_emailid_user($account_id, $email_id);
            if($email_available == 0){
                $response=['status'=>0,'msg'=>'Email Id Already Used By Other User'];
                return response()->json($response);
            }

            $mobile_available = MyFuncs::check_mobile_user($account_id, $mobile);
            if($mobile_available == 0){
                $response=['status'=>0,'msg'=>'Mobile No. Already Used By Other User'];
                return response()->json($response);
            }

            $key = Session::get('CryptoRandom');
            $iv = Session::get('CryptoRandomInfo');
            
            $data = hex2bin($request['password']);
            $decryptedpass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $password_strength = MyFuncs::check_password_strength($decryptedpass, 0);
            if($password_strength != ''){
                $response=['status'=>0,'msg'=>$password_strength];
                return response()->json($response);// response as json
            }        
            $password = bcrypt($decryptedpass);

            $for_district = 0;
            if($role_id == 4){
                $rs_fetch = DB::select(DB::raw("SELECT `district_id` from `user_district_assigns` where `user_id` = $user_id and `status` = 1 limit 1;"));
                if(count($rs_fetch)>0){
                    $for_district = $rs_fetch[0]->district_id;
                }
            }
            
            $accounts = DB::select(DB::raw("INSERT into `admins` (`name`, `role_id`, `email`, `password`, `mobile`, `created_by`, `for_district`) values ('$name', $new_role_id, '$email_id', '$password', '$mobile', $user_id, $for_district);"));

            $new_user_id = 0;
            $rs_fetch = DB::select(DB::raw("SELECT `id` from `admins` where `email` = '$email_id' limit 1;"));
            if(count($rs_fetch)>0){
                $new_user_id = $rs_fetch[0]->id;
            }

            $rs_update = DB::select(DB::raw("INSERT into `password_change_history` (`user_id`, `old_password`, `new_password`, `from_ip`, `log_time`, `log_type`) values ($new_user_id, '', '$password', '$from_ip', now(), 0);"));
            
            if($role_id == 4){
                if($new_role_id != 6){
                    $rs_assign_district = DB::select(DB::raw("INSERT into `user_district_assigns`(`user_id`, `district_id`, `status`) values ($new_user_id, $for_district, 1);"));
                }
            }
            $response=['status'=>1,'msg'=>'Account Created Successfully'];
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "store";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }   
    }

    public function userList()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(2);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $user_id = MyFuncs::getUserId();
            $role_id = 0;
            $user_list = DB::select(DB::raw("SELECT `a`.`id`, `a`.`name`, `a`.`email`, `a`.`mobile`, `a`.`status`, `r`.`name` as `role_name` from `admins` `a`Inner Join `roles` `r` on `a`.`role_id` = `r`.`id` where `a`.`created_by` = $user_id Order By `a`.`name`;"));
            return view('admin.account.user_list', compact('user_list'));
        } catch (\Exception $e) {
            $e_method = "userList";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function userEdit(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(2);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $user_role = MyFuncs::getUserRoleId();
            $roles =DB::select(DB::raw("SELECT `id`, `name` from `roles` where `id`  > $user_role Order By `name`;"));
            $accounts = DB::select(DB::raw("SELECT * from `admins` where `id` = $rec_id limit 1;")); 
            return view('admin.account.edit',compact('accounts','roles'));
        } catch (\Exception $e) {
            $e_method = "userEdit";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        } 
    }

    public function userUpdate(Request $request, $rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(2);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rules=[
                'name' => 'required|string|min:3|max:50',             
                'role_id' => 'required',
                'mobile' => 'required|numeric|digits:10|unique:admins,mobile,'.$rec_id,
            ];
            $customMessages = [
                'name.required'=> 'Please Enter Name',
                'name.min'=> 'Name Should Be Minimum of 3 Characters',
                'name.max'=> 'Name Should Be Maximum of 50 Characters',
                'role_id.required'=> 'Please Select Role',
                'mobile.required'=> 'Please Enter Mobile No.',
                'mobile.numeric'=> 'Mobile No. Should Be In Digits Only',
                'mobile.digits'=> 'Mobile No. Should Be 10 Digits Long',
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
            $role_id = MyFuncs::getUserRoleId();
            $from_ip = MyFuncs::getIp();

            $name = substr(MyFuncs::removeSpacialChr($request->name), 0, 50);
            $new_role_id = intval(Crypt::decrypt($request->role_id));
            $mobile = substr(MyFuncs::removeSpacialChr($request->mobile), 0, 10);
            $rs_update = DB::select(DB::raw("UPDATE `admins` set `name` = '$name', `role_id` = $new_role_id, `mobile` = '$mobile' where `id` = $rec_id limit 1;"));
            $response=['status'=>1,'msg'=>'Account Updated Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "userUpdate";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function userStatus($rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(2);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rec_id = intval(Crypt::decrypt($rec_id));
            $rs_fatch = DB::select(DB::raw("SELECT `status`, `email` from `admins` where `id` = $rec_id limit 1;"));
            $status = $rs_fatch[0]->status;
            $email_id = $rs_fatch[0]->email;

            if ($status == 1) {
                $l_status = 0;
                $message = 'Account Deactivated Successfully';
            }else{
                $email_available = MyFuncs::check_emailid_user($rec_id, $email_id);
                if($email_available == 0){
                    $response=['status'=>0,'msg'=>'Email Id Already Used By Other User'];
                    return response()->json($response);
                }
                $l_status = 1;
                $message = 'Account Activated Successfully';
            } 
            $accounts = DB::select(DB::raw("UPDATE `admins` set `status` = $l_status where `id` = $rec_id limit 1;"));

            return redirect()->back()->with(['class'=>'success','message'=>$message]);
        } catch (\Exception $e) {
            $e_method = "status";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function changePassword()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(3);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            return view('admin.account.change_password');
        } catch (\Exception $e) {
            $e_method = "changePassword";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
        
    }

    public function changePasswordStore(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(3);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            $rules=[
                'oldpassword'=> 'required',
                'password'=> 'required',
                'passwordconfirmation'=> 'required|same:password',
            ];
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }        
            $user=Auth::guard('admin')->user();
            $userid = $user->id; 

            $key = Session::get('CryptoRandom');
            $iv = Session::get('CryptoRandomInfo');
            
            $data = hex2bin($request['password']);
            $decryptedpass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $c_data = hex2bin($request['passwordconfirmation']);
            $c_decryptedpass = openssl_decrypt($c_data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $o_data = hex2bin($request['oldpassword']);
            $o_decryptedpass = openssl_decrypt($o_data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $password_strength = MyFuncs::check_password_strength($decryptedpass, $userid);
            if($password_strength != ''){
                $response=['status'=>0,'msg'=>$password_strength];
                return response()->json($response);// response as json
            }

            $from_ip = MyFuncs::getIp();

            if(password_verify($o_decryptedpass,$user->password)){
                if ($o_decryptedpass == $decryptedpass) {
                    $response=['status'=>0,'msg'=>'Old Password And New Password Cannot Be Same'];
                    return response()->json($response);
                }else{
                    $en_password = bcrypt($decryptedpass); 
                    DB::select(DB::raw("UPDATE `admins` set `password` = '$en_password', `password_expire_on` = date_add(curdate(), INTERVAL 15 DAY) where `id` = $userid limit 1;"));

                    DB::select(DB::raw("INSERT into `password_change_history` (`user_id`, `old_password`, `new_password`, `from_ip`, `log_time`, `log_type`) values ($userid, '', '$en_password', '$from_ip', now(), 1);"));

                    $response=['status'=>1,'msg'=>'Password Changed Successfully'];
                    return response()->json($response);// response as json 
                }
            }else{               
                $response=['status'=>0,'msg'=>'Old Password Is Not Correct'];
                return response()->json($response);// response as json
            }
        } catch (\Exception $e) {
            $e_method = "changePasswordStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }        
    }

    public function resetPassWord()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(4);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $userid = MyFuncs::getUserId();
            $role_id = MyFuncs::getUserRoleId();
            if($role_id == 1){
                $admins = DB::select(DB::raw("SELECT * from `admins` where `role_id` in (4, 9, 10, 11, 13) order by `email`;"));    
            }else{
                $admins = DB::select(DB::raw("SELECT * from `admins` where `created_by` = $userid order by `email`;"));
            }
            return view('admin.account.reset_password',compact('admins'));
        } catch (\Exception $e) {
            $e_method = "resetPassWord";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function resetPassWordChange(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(4);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);// response as json
            }
            if ($request->new_pass!=$request->con_pass) {
                $response=['status'=>0,'msg'=>'Password Not Match'];
                return response()->json($response);
            }

            $key = Session::get('CryptoRandom');
            $iv = Session::get('CryptoRandomInfo');
            
            $data = hex2bin($request['new_pass']);
            $l_new_pass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $c_data = hex2bin($request['con_pass']);
            $l_con_pass = openssl_decrypt($c_data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
            
            $reset_user_id = intval(Crypt::decrypt($request->email));
            
            $password_strength = MyFuncs::check_password_strength($l_new_pass, $reset_user_id);
            if($password_strength != ''){
                $response=['status'=>0,'msg'=>$password_strength];
                return response()->json($response);// response as json
            }

            $resetPassWordChange=bcrypt($l_new_pass);
            $from_ip = MyFuncs::getIp();

            $rs_update = DB::select(DB::raw("UPDATE `admins` set `password` = '$resetPassWordChange', `password_expire_on` = curdate() where `id` = '$reset_user_id' limit 1;"));

            $rs_update = DB::select(DB::raw("INSERT into `password_change_history` (`user_id`, `old_password`, `new_password`, `from_ip`, `log_time`, `log_type`) values ($reset_user_id, '', '$resetPassWordChange', '$from_ip', now(), 2);"));

            $response=['status'=>1,'msg'=>'Password Reset Successfully'];
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "resetPassWordChange";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        } 
    }

    Public function districtAssignIndex()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(5);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $user_id = MyFuncs::getUserId();
            $role_id = 2;
            $users = SelectBox::get_user_list_v1($role_id, $user_id); 
            return view('admin.account.assign.district.index',compact('users'));
        } catch (\Exception $e) {
            $e_method = "districtAssignIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function districtAssignTable(Request $request)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(5);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_district = SelectBox::get_district_access_list_v1();
            $r_user_id = intval(Crypt::decrypt($request->id));
            $re_records = DB::select(DB::raw("SELECT `uda`.`id`, `dis`.`name_e` from `user_district_assigns` `uda` inner join `districts` `dis` on `dis`.`id` = `uda`.`district_id` where `uda`.`status` = 1 and `uda`.`user_id` = $r_user_id;"));
            return view('admin.account.assign.district.table',compact('re_records', 'rs_district'));
        } catch (\Exception $e) {
            $e_method = "districtAssignTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function districtAssignStore(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(5);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            
            $rules=[
                'user' => 'required',  
                'district' => 'required', 
            ]; 
            $customMessages = [
                'user.required'=> 'Please Select User',
                'district.required'=> 'Please Select District',                
            ];
            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }
            $district_id = intval(Crypt::decrypt($request->district));
            $r_user_id = intval(Crypt::decrypt($request->user));

            $user_id = MyFuncs::getUserId();

            $rs_save = DB::select(DB::raw("call `up_save_assign_district` ($r_user_id, $district_id, $user_id);"));  
            $response['msg'] = $rs_save[0]->result;
            $response['status'] = $rs_save[0]->s_status;
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "districtAssignStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }  
    }

    public function districtAssignDelete($rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(5);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $assigned_id = intval(Crypt::decrypt($rec_id));
            $rs_delete = DB::select(DB::raw("UPDATE `user_district_assigns` set `status` = 0 where `id` = $assigned_id limit 1;"));
            $response['msg'] = 'District Removed Successfully';
            $response['status'] = 1;
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "DistrictsAssignDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function tehsilAssignIndex()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(6);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $user_id = MyFuncs::getUserId();
            $role_id = 3;
            $users = SelectBox::get_user_list_v1($role_id, $user_id); 
            return view('admin.account.assign.tehsil.index',compact('users'));

        } catch (\Exception $e) {
            $e_method = "tehsilAssignIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function tehsilAssignTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(6);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_district = SelectBox::get_district_access_list_v1();
            $r_user_id = intval(Crypt::decrypt($request->id));
            $re_records = DB::select(DB::raw("SELECT `uda`.`id`, `dis`.`name_e` from `user_tehsil_assigns` `uda` inner join `tehsils` `dis` on `dis`.`id` = `uda`.`tehsils_id` where `uda`.`status` = 1 and `uda`.`user_id` = $r_user_id;"));
            return view('admin.account.assign.tehsil.select_box',compact('re_records','rs_district')); 
        } catch (Exception $e) {
            $e_method = "tehsilAssignTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function tehsilAssignStore(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(6);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $rules=[
                'user' => 'required',  
                'district' => 'required', 
                'tehsil' => 'required', 
            ]; 
            $customMessages = [
                'user.required'=> 'Please Select User',
                'district.required'=> 'Please Select District',                
                'tehsil.required'=> 'Please Select Tehsil',
            ];
            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $district_id = intval(Crypt::decrypt($request->district));
            $tehsil_id = intval(Crypt::decrypt($request->tehsil));
            $r_user_id = intval(Crypt::decrypt($request->user));

            $permission_flag = MyFuncs::check_district_access($district_id);
            if($permission_flag == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }            

            $permission_flag = MyFuncs::check_block_access($tehsil_id);
            if($permission_flag == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }            

            $user_id = MyFuncs::getUserId();

            $rs_save = DB::select(DB::raw("call `up_save_assign_tehsil` ($r_user_id, $tehsil_id, $user_id);"));  
            $response['msg'] = $rs_save[0]->result;
            $response['status'] = $rs_save[0]->s_status;
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "tehsilAssignStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function tehsilAssignDelete($rec_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(6);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $assigned_id = intval(Crypt::decrypt($rec_id));
            $rs_delete = DB::select(DB::raw("UPDATE `user_tehsil_assigns` set `status` = 0 where `id` = $assigned_id limit 1;"));
            $response['msg'] = 'Tehsil Removed Successfully';
            $response['status'] = 1;
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "tehsilAssignDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function villageAssignIndex()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(7);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $user_id = MyFuncs::getUserId();
            $role_id = 4;
            $users = SelectBox::get_user_list_v1($role_id, $user_id); 
            return view('admin.account.assign.village.index',compact('users'));
        } catch (\Exception $e) {
            $e_method = "villageAssignIndex";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function villageAssignTable(Request $request)
    { 
        try {
            $permission_flag = MyFuncs::isPermission_route(7);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            
            $rs_district = SelectBox::get_district_access_list_v1();

            $r_user_id = intval(Crypt::decrypt($request->id));

            $rs_records = DB::select(DB::raw("SELECT `uda`.`id`, `dis`.`name_e` as `block_name`, `vil`.`name_e` as `vil_name` from `user_village_assigns` `uda` inner join `tehsils` `dis` on `dis`.`id` = `uda`.`tehsil_id` inner join `villages` `vil` on `vil`.`id` = `uda`.`village_id` where `uda`.`status` = 1 and `uda`.`user_id` = $r_user_id;"));

            return view('admin.account.assign.village.table',compact('rs_records','rs_district'));
        } catch (\Exception $e) {
            $e_method = "villageAssignTable";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    Public function villageAssignStore(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(7);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $rules=[
                'user' => 'required',  
                'district' => 'required', 
                'tehsil' => 'required',
                'village' => 'required', 
            ]; 
            $customMessages = [
                'user.required'=> 'Please Select User',
                'district.required'=> 'Please Select District',                
                'tehsil.required'=> 'Please Select Tehsil',
                'village.required'=> 'Please Select Village',
            ];
            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $district_id = intval(Crypt::decrypt($request->district));
            $tehsil_id = intval(Crypt::decrypt($request->tehsil));
            $village_id = intval(Crypt::decrypt($request->village));
            $r_user_id = intval(Crypt::decrypt($request->user));

            $permission_flag = MyFuncs::check_district_access($district_id);
            if($permission_flag == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }            

            $permission_flag = MyFuncs::check_block_access($tehsil_id);
            if($permission_flag == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }            

            $permission_flag = MyFuncs::check_village_access($village_id);
            if($permission_flag == 0){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }            

            $user_id = MyFuncs::getUserId();

            $rs_save = DB::select(DB::raw("call `up_save_assign_village` ($r_user_id, $village_id, $user_id);"));  
            $response['msg'] = $rs_save[0]->result;
            $response['status'] = $rs_save[0]->s_status;
            return response()->json($response);

        } catch (Exception $e) {
            $e_method = "villageAssignStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function villageAssignDelete($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(7);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $assigned_id = intval(Crypt::decrypt($id));
            $rs_delete = DB::select(DB::raw("UPDATE `user_village_assigns` set `status` = 0 where `id` = $assigned_id limit 1;"));
            $response['msg'] = 'Village Removed Successfully';
            $response['status'] = 1;
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "villageAssignDelete";
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
