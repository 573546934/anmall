<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    //合伙人列表
    public function index()
    {
        return view('admin.partner.index');
    }

    public function data(Request $request)
    {

        $model = Partner::query();
        if ($request->get('name')){
            $model = $model->where('name','like','%'.$request->get('name').'%');
        }
        $res = $model ->orderByRaw("FIELD(status,'0','1','-1')")->orderBy('created_at','desc')
            ->with(['member'])
            ->paginate($request->get('limit',30))->toArray();
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
        $res = Partner::up($ids,['status'=>1]);
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
        $res = Partner::up($ids,['status'=>-1]);
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
        Partner::whereIn('id',$ids)->delete();
        /*foreach (Partner::whereIn('id',$ids)->get() as $model){
            //删除数据
            $model->delete();
        }*/
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
