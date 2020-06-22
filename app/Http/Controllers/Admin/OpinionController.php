<?php

namespace App\Http\Controllers\Admin;

use App\Models\Opinion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OpinionController extends Controller
{
    //
    public function index()
    {
        return view('admin.opinion.index');
    }

    public function data(Request $request)
    {
        $model = Opinion::query();
        if ($request->get('content')){
            $model = $model->where('content','like','%'.$request->get('content').'%');
        }
        if ($request->get('mid')){
            $model = $model->where('mid',$request->get('mid'));
        }
        $res = $model ->orderBy('created_at','desc')->with(['member'])
            ->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
    //删除
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        Opinion::whereIn('id',$ids)->delete();
        /*foreach (Partner::whereIn('id',$ids)->get() as $model){
            //删除数据
            $model->delete();
        }*/
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
