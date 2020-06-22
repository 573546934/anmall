<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DemandRequest;
use App\Models\Demand;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemandController extends Controller
{
    //需求控制器

    /*
     * 添加需求
     * */
    public function addDemand(DemandRequest $request)
    {
        $data = $request->only('type','telname','phone','country','city','price','area','assets_type','other','reason');
        $data['mid'] = $request->get('mid_params');
        $res = Demand::addOne($data);
        return apiResult($res,'发布成功,等待审核');
    }

    /*
     * 我的需求列表
     * */
    public function myDemands(Request $request)
    {
        $mid = $request->get('mid_params');
        $member = Member::getOne($mid);
        if ($member->type == 1){
            return apiResult(0,'请先完善资料');
        }
        $demands = Demand::where('mid',$mid);
        if($request->has('type')){
            $demands = $demands->where('type',$request->get('type'));
        }
        if($request->has('status')){
            $demands = $demands->where('status',$request->get('status'));
        }
        $demands = $demands->orderBy('updated_at','desc')->paginate($request->get('limit',10));
        $demands = Demand::formatList($demands);
        return apiResult(1,'获取需求列表',$demands);
    }

    /*
     * 需求列表
     * */
    public function demands(Request $request)
    {
        $demands = Demand::where('status',1);
        if($request->has('type') && !empty($request->get('type'))){
            $type = explode(',',$request->get('type'));
            $demands = $demands->whereIn('type',$type);
        }
        $demands = $demands->orderBy('updated_at','desc')->paginate($request->get('limit',10));
        $demands = Demand::formatList($demands);
        return apiResult(1,'获取需求列表',$demands);
    }
    /*
     * 需求详情
     * */
    public function demand(Request $request)
    {
        $id = $request->get('id');
        $demand = Demand::find($id);
        return apiResult($demand,'获取需求',$demand);
    }

    /*
     * 修改需求
     * */
    public function upDemand(Request $request)
    {
        $this->validate($request,[
            'id'=>'required',
            'type'   => 'required',
            'telname' => 'required',
            'phone'  => 'required',
        ]);
        $mid = $request->get('mid_params');
        $id = $request->get('id');
        $demand = Demand::where('mid',$mid)->where('id',$id)->first();
        if (!$demand){
            return apiResult(0,'需求不存在,修改需求');
        }
        $data = $request->only('type','telname','phone','country','city','price','area','assets_type','other');
        $data['status'] = 0;
        $res = $demand->update($data);
        return apiResult($res,'修改需求');
    }




}
