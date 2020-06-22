<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //修改用户资料
    public function updateInfo(Request $request)
    {
        $mid = $request->get('mid_params');
        $data = $request->only('phone','name','sex','city','id_number','avatar','nickname');
        $res = Member::updateInfo($mid,$data);
        if($res){
            return response(['message'=>'修改成功']);
        }else{
            return response(['message'=>'修改失败'],400);
        }
    }
    //获取用户信息
    public function member(Request $request)
    {
        $mid = $request->get('mid_params');
        $data = Member::getOne($mid);
        return apiResult($data,'获取',$data);
    }

    //分享我的名片
    public function myCard(Request $request)
    {
        $mid = $request->get('mid_params');
        $data = Member::getMyCard($mid);
        return response(['data'=>$data]);
    }

    //获取我的用户
    public function myUsers(Request $request)
    {
        $mid = $request->get('mid_params');
        $data = Member::getMyUsers($mid,$request->get('limit',10));
        return apiResult(1,'获取用户列表',$data);
    }

}