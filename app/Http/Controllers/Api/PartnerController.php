<?php

namespace App\Http\Controllers\Api;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    /*
     * 提交合伙人申请
     * */
    public function partner(Request $request)
    {
        $data = $request->only(['type','name','phone','contact_person','industry','email','wechat']);
        $data['mid'] = $request->get('mid_params');
        if(Partner::where('mid',$data['mid'])->first()){
            return response(['message'=>'您已提交过申请,请待管理员审核'],400);
        }
        $res = Partner::create($data);
        return apiResult($res,'提交');
    }
}
