<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Helper\MyFuncs;
use App\Helper\SelectBox;
class CommonController extends Controller
{   
    protected $e_controller = "CommonController";
    
    public function blankView()
    {
        return '';
    }
    
    public function ShowPdfFile($pdfFilePath)
    {
        try {
            $l_act_file_path = Crypt::decrypt($pdfFilePath);
            $storagePath = storage_path($l_act_file_path);
            if(file_exists($storagePath)){
                $mimeType = mime_content_type($storagePath);
                return response()->file($storagePath);
            }else{
                return view('error.fnf', compact('storagePath'));
            }          
        } catch (\Exception $e) {
            $e_method = "ShowPdfFile";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }            
    }

    public function pdfPopup($file_path)
    {
        try {
            $file_path = Crypt::decrypt($file_path);
            return view('admin.common.pdf_viewer', compact('file_path'));
        } catch (\Exception $e) {
            $e_method = "pdfPopup";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function pdfviewer($path)
    {   
        try {
            $path = Crypt::decrypt($path);
            $storagePath = Storage_path() . '/app'.$path;
            if(file_exists($storagePath)){
                $mimeType = mime_content_type($storagePath);
                return response()->file($storagePath);
            }else{
                return view('error.fnf', compact('storagePath'));
            }         
            $headers = array(
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; '
            );            
            return \Response::make(file_get_contents($storagePath), 200, $headers);
        } catch (\Exception $e) {
            $e_method = "pdfviewer";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }    
    }
    
    public function districtWiseTehsil(Request $request)
    {
        try {
            $d_id = intval(Crypt::decrypt($request->id));
            $user_id = MyFuncs::getUserId();
            $box_caption = "Tehsil";
            $show_disabled = 1;
            $rs_records = SelectBox::get_block_access_list_v1($d_id);
            return view('admin.common.select_box_v1',compact('rs_records', 'box_caption', 'show_disabled'));
        } catch (Exception $e) {
            $e_method = "districtWiseTehsil";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function tehsilWiseVillage(Request $request)
    {
        try {
            $b_id = intval(Crypt::decrypt($request->id));
            $is_permission = MyFuncs::check_block_access($b_id);
            if($is_permission == 0){
                $b_id = 0;
            }
            $box_caption = "Village";
            $show_disabled = 1;
            $rs_records = SelectBox::get_village_access_list_v1($b_id);

            return view('admin.common.select_box_v1',compact('rs_records', 'box_caption', 'show_disabled'));

        } catch (\Exception $e) {
            $e_method = "BlockWiseVillage";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeWiseSchemeAwardInfo(Request $request)
    {
        try {
            $scheme_id = intval(Crypt::decrypt($request->id));
            
            $box_caption = "Scheme/Award Village";
            $show_disabled = 1;
            $rs_records = SelectBox::get_schemeAwardInfo_access_list_v1($scheme_id);

            return view('admin.common.select_box_v1',compact('rs_records', 'box_caption', 'show_disabled'));

        } catch (Exception $e) {
            $e_method = "BlockWiseVillage";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function schemeAwardInfoWiseAwardDetail(Request $request)
    {
        try {
            $scheme_award_info_id = intval(Crypt::decrypt($request->id));
            
            $box_caption = "Award Detail";
            $show_disabled = 1;
            $rs_records = SelectBox::get_awardDetail_access_list_v1($scheme_award_info_id);

            return view('admin.common.select_box_v1',compact('rs_records', 'box_caption', 'show_disabled'));

        } catch (Exception $e) {
            $e_method = "BlockWiseVillage";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function awardDetailWiseAwardBeneficiaryDetail(Request $request)
    {
        try {
            $award_detail_id = intval(Crypt::decrypt($request->id));
            
            $box_caption = "Award Beneficiary Detail";
            $show_disabled = 1;
            $rs_records = SelectBox::get_awardBeneficiaryDetail_access_list_v1($award_detail_id);

            return view('admin.common.select_box_v1',compact('rs_records', 'box_caption', 'show_disabled'));

        } catch (Exception $e) {
            $e_method = "BlockWiseVillage";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function getTranslateData(Request $request)
    {
        try {
            $name_e = strtoupper(MyFuncs::removeSpacialChr($request['name_e']));

            if($name_e!='') {
                $rs_fetch = DB::select(DB::raw("SELECT distinct name_l from dictionary where name_e = '$name_e' limit 1;"));
                if (count($rs_fetch) > 0){
                    $name_h = $rs_fetch[0]->name_l; 
                }else{
                    $rs_fetch = DB::select(DB::raw("SELECT distinct name_l from dictionary where name_e = '$name_e' limit 1;"));
                    if (count($rs_fetch) > 0){
                        $name_h = $rs_fetch[0]->name_l; 
                    }
                } 
            }else {
                $name_h = ''; 
            }
            $str = $name_h;
            echo json_encode(array('st'=>1,'msg'=>$str));
        } catch (\Exception $e) {
            $e_method = "getTranslateData";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function getTraDataPop(Request $request)
    {
        try {
            $name_e = MyFuncs::removeSpacialChr($request->name_e);
            $fill_id = intval($request->fill_id);
            $rs_result = DB::select(DB::raw("SELECT * from `dictionary` where `name_e` = '$name_e';"));
            
            return view('admin.common.dictionary',compact('rs_result', 'name_e', 'fill_id'));   
        } catch (\Exception $e) {
            $e_method = "getTraDataPop";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function getTraDataPopUpdate(Request $request)
    {
        try {
            $dic_id = intval($request->dic_id);
            $rs_update = DB::select(DB::raw("UPDATE `dictionary` set `applied_times` = `applied_times` + 1 where `id` = $dic_id limit 1;"));   
        } catch (\Exception $e) {
            $e_method = "getTraDataPopUpdate";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}
