<?php

namespace App\Helper;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Support\Facades\DB;
use App\Helper\MyFuncs;

class SelectBox {

  public static function get_user_list_v1($role_id, $created_by)
  { 
    $condition = "";
    if($role_id > 0){
      $condition = $condition." and `role_id` = $role_id ";
    }
    if($created_by > 0){
      $condition = $condition." and `created_by` = $created_by ";
    }
    $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, concat(`name`, ' - ', `email`, ' - ', `mobile`) as `opt_text` from `admins`where `status` = 1 $condition Order By `name`;"));
    return $result_rs;
  }

  public static function get_district_access_list_v1()
  { 
    $user_id = MyFuncs::getUserId();
    $role_id = MyFuncs::getUserRoleId();

    if($role_id == 1){
      $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, concat(`code`, ' - ', `name_e`) as `opt_text` from `districts` order by `code`;"));  
    }elseif($role_id == 2){
      $result_rs = DB::select(DB::raw("SELECT `dst`.`id` as `opt_id`, concat(`dst`.`code`, ' - ', `dst`.`name_e`) as `opt_text` from `user_district_assigns` `uda` inner join `districts` `dst` on `dst`.`id` = `uda`.`district_id` where `uda`.`status` = 1 and `uda`.`user_id` = $user_id order by `dst`.`code`;"));
    }elseif($role_id == 3){
      $result_rs = DB::select(DB::raw("SELECT `dst`.`id` as `opt_id`, concat(`dst`.`code`, ' - ', `dst`.`name_e`) as `opt_text` from `user_tehsil_assigns` `uda` inner join `districts` `dst` on `dst`.`id` = `uda`.`district_id` where `uda`.`status` = 1 and `uda`.`user_id` = $user_id order by `dst`.`code`;"));
    }elseif($role_id == 4){
      $result_rs = DB::select(DB::raw("SELECT `dst`.`id` as `opt_id`, concat(`dst`.`code`, ' - ', `dst`.`name_e`) as `opt_text` from `user_village_assigns` `uda` inner join `districts` `dst` on `dst`.`id` = `uda`.`district_id` where `uda`.`status` = 1 and `uda`.`user_id` = $user_id order by `dst`.`code`;"));
    }
    return $result_rs;
  }

  public static function get_block_access_list_v1($d_id)  //1- Block, 2 - MC, 0-Both
  { 
    $user_id = MyFuncs::getUserId();
    $role_id = MyFuncs::getUserRoleId();
    
    if($role_id == 1){
      $result_rs = DB::select(DB::raw("SELECT `bl`.`id` as `opt_id`, concat(`bl`.`code`, ' - ', `bl`.`name_e`) as `opt_text` from `tehsils` `bl` where `bl`.`districts_id` = $d_id order by `bl`.`code`;"));  
    }elseif($role_id == 2){
      $result_rs = DB::select(DB::raw("SELECT `bl`.`id` as `opt_id`, concat(`bl`.`code`, ' - ', `bl`.`name_e`) as `opt_text` from `tehsils` `bl` where `bl`.`districts_id` = $d_id order by `bl`.`code`;"));
    }elseif($role_id == 3){
      $result_rs = DB::select(DB::raw("SELECT `bl`.`id` as `opt_id`, concat(`bl`.`code`, ' - ', `bl`.`name_e`) as `opt_text` from `user_tehsil_assigns` `uba` inner join `tehsils` `bl` on `uba`.`tehsil_id` = `bl`.`id` where `uba`.`district_id` = $d_id and `uba`.`user_id` = $user_id and `status` = 1 order by `bl`.`code`;"));
    }elseif($role_id == 4){
      $result_rs = DB::select(DB::raw("SELECT `bl`.`id` as `opt_id`, concat(`bl`.`code`, ' - ', `bl`.`name_e`) as `opt_text` from `user_village_assigns` `uba` inner join `tehsils` `bl` on `uba`.`tehsil_id` = `bl`.`id` where `uba`.`district_id` = $d_id and `uba`.`user_id` = $user_id and `status` = 1 order by `bl`.`code`;"));
    }
    return $result_rs;
  }

  public static function get_village_access_list_v1($bl_id) 
  { 
    $user_id = MyFuncs::getUserId();
    $role_id = MyFuncs::getUserRoleId();
    
    if($role_id <= 3){
      $result_rs = DB::select(DB::raw("SELECT `vil`.`id` as `opt_id`, concat(`vil`.`name_e`, ' - ', `vil`.`code`) as `opt_text` from `villages` `vil` where `vil`.`tehsil_id` = $bl_id order by `vil`.`name_e`;"));  
    }elseif($role_id == 4){
      $result_rs = DB::select(DB::raw("SELECT `vil`.`id` as `opt_id`, concat(`vil`.`name_e`, ' - ', `vil`.`code`) as `opt_text` from `villages` `vil` where `vil`.`tehsil_id` = $bl_id and `vil`.`id` in (select `uva`.`village_id` from `user_village_assigns` `uva` where `uva`.`user_id` = $user_id and `uva`.`tehsil_id` = $bl_id and `uva`.`status` = 1) order by `vil`.`name_e`;"));
    }
    return $result_rs;
  }

  public static function get_schemes_access_list_v1() 
  { 
    $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, `scheme_name_e` as `opt_text` from `schemes` Order by `scheme_name_e`;"));
    return $result_rs;
  }

  public static function get_schemeAwardInfo_access_list_v1($scheme_id) 
  { 
    $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, concat(`award_no`, ' (', date_format(`award_date`, '%d-%m-%Y'), ')') as `opt_text` from `scheme_award_info` where `scheme_id` = $scheme_id order by `award_no`;"));
    return $result_rs;
  }

  public static function get_awardDetail_access_list_v1($scheme_award_info_id) 
  { 
    $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, concat(`khewat_no`, ' - ', `khata_no`, ' - ', `khasra_no`) as `opt_text` from `award_detail` where `scheme_award_info_id` = $scheme_award_info_id order by `khewat_no`, `khata_no`, `khasra_no`;"));
    return $result_rs;
  }

  public static function get_awardBeneficiaryDetail_access_list_v1($award_detail_id) 
  { 
    $result_rs = DB::select(DB::raw("SELECT `id` as `opt_id`, concat(`name_1_e`) as `opt_text` from `award_beneficiary_detail` where `award_detail_id` = $award_detail_id order by `name_1_e`;"));
    return $result_rs;
  }

}