<?php

namespace App\Http\Controllers\Api;

use App\Models\CustomerService;
use App\Models\Member;
use App\Models\Opinion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerServiceController extends Controller
{
    //客户服务

    /*获取客服列表*/
    public function getCustomers(Request $request)
    {
        $data = CustomerService::with('img')->orderBy('score','desc')->get();
        return apiResult($data,'获取',$data);
    }

    /*获取客服详情*/
    public function getCustomer(Request $request)
    {
        $id = $request->get('id');
        $mid = $request->get('mid_params');
        $member = Member::find($mid);
        if ($id){
            $data = CustomerService::with('img')->find($id);
        }else{
            if ($member->is_senior_partner == 1){
                $data = CustomerService::with('img')->where('name','like','%专属%')->first();
            }else{
                $data = CustomerService::with('img')->where('name','not like','%专属%')->first();
            }
        }
        return apiResult($data,'获取',$data);
    }

    /*意见反馈*/
    public function opinion(Request $request)
    {
        $data = $request->only('score','content');
        $data['mid'] = $request->get('mid_params');
        $res = Opinion::create($data);
        return apiResult($res,'反馈');
    }
}
