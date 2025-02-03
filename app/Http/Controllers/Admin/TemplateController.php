<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index()
    {
        return view('temp_1.index');
    }

    public function search()
    {
        return view('temp_1.search');
    }

    public function searchResult(Request $request)
    { 
        $rules=[
            'registration_no' => 'required',
            // 'dob' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
        $response =array();
        $response['status']=1;          
        $response["data"] = view('temp_1.search_result')->render();
        return $response;
    }
}
