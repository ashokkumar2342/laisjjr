<?php

namespace App\Http\Controllers\Admin;
use App\Helper\MyFuncs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    
    public function index()
    {
        $user_id = MyFuncs::getUserId();
        $rs_fetch = DB::select(DB::raw("SELECT `id` from `admins` where `id` = $user_id and `password_expire_on` <= curdate();"));
        if(count($rs_fetch) > 0){
            return redirect()->route('admin.account.change.password');
        }
        return view('admin.dashboard.dashboard');
    }
}
