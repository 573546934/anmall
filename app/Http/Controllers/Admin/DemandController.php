<?php

namespace App\Http\Controllers\Admin;

use App\Models\Demand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemandController extends Controller
{
    //需求列表
    public function index()
    {
        return view('admin.demand.index');
    }

    public function data(Request $request)
    {

        $model = Demand::query();
        if ($request->get('telname')){
            $model = $model->where('telname','like','%'.$request->get('name').'%');
        }
        if ($request->get('type')){
            $model = $model->where('type',$request->get('name'));
        }
        $res = $model ->orderByRaw("FIELD(status,'0','1','-1')")
            ->orderBy('created_at','desc')
            ->with(['member'])
            ->paginate($request->get('limit',30))->toArray();
        $res['data'] = Demand::formatList($res['data']);
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
    //审核通过
    public function by(Request $request)
    {
        $ids = $request->get('ids');
        $res = Demand::up($ids,['status'=>1]);
        if ($res){
            return response(['code'=>0,'msg'=>'审核通过成功']);
        }else{
            return response(['code'=>1,'msg'=>'审核通过失败']);
        }
    }
    //审核不通过
    public function refuse(Request $request)
    {
        $ids = $request->get('ids');
        $reason = $request->get('reason');
        $res = Demand::up($ids,['status'=>-1,'reason'=>$reason]);
        if ($res){
            return response(['code'=>0,'msg'=>'审核不通过成功']);
        }else{
            return response(['code'=>1,'msg'=>'审核不通过失败']);
        }
    }
    //删除
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        Demand::whereIn('id',$ids)->delete();
        /*foreach (Partner::whereIn('id',$ids)->get() as $model){
            //删除数据
            $model->delete();
        }*/
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
