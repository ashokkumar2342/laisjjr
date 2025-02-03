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
    public function reportIndex()
    {
        try {
            return view('admin.report.index');       
        } catch (\Exception $e) {
            $e_method = "user_access_index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function reportResult(Request $request)
    {
        try {
            $rs_result = DB::select(DB::raw("SELECT * from `award_detail`;"));
            $response = array();
            $response['status'] = 1;            
            $response['data'] =view('admin.report.result',compact('rs_result'))->render();
            return response()->json($response);           
        } catch (\Exception $e) {
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
            $rs_result = DB::select(DB::raw("SELECT * from `award_detail`;"));
            $html = view('admin.report.print', compact('rs_result'));
            $mpdf->WriteHTML($html); 
            $mpdf->Output();          
        } catch (Exception $e) {
            $e_method = "reportPrint";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}
