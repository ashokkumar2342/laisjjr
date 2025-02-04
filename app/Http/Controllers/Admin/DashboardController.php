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
        $rs_fetch = DB::select(DB::raw("SELECT count(`id`) as `d_count` from `districts`"));
        $d_count = $rs_fetch[0]->d_count;
        $rs_fetch = DB::select(DB::raw("SELECT count(`id`) as `t_count` from `tehsils`"));
        $t_count = $rs_fetch[0]->t_count;
        $rs_fetch = DB::select(DB::raw("SELECT count(`id`) as `v_count` from `villages`"));
        $v_count = $rs_fetch[0]->v_count;
        
        return view('admin.dashboard.dashboard', compact('d_count', 't_count', 'v_count'));
    }
}
