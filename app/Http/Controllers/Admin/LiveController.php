<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use App\Models\Live;
use App\Models\LiveCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分类
        $categorys = LiveCategory::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        return view('admin.live.index',compact('categorys'));
    }

    public function data(Request $request)
    {

        $model = Live::query();
        if ($request->get('category_id')){
            $model = $model->where('category_id',$request->get('category_id'));
        }
        if ($request->get('title')){
            $model = $model->where('title','like','%'.$request->get('title').'%');
        }
        $res = $model->orderBy('created_at','desc')->with(['category','img'])
            ->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //分类
        $categorys = LiveCategory::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        return view('admin.live.create',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['category_id','title','subtitle','author','keywords','description','content','click','thumb','sort','live_time']);
        $live = Live::create($data);
        //更新对应资源表
        if($live->thumb){
            Attachment::where('id',$live->thumb)->update(['mark'=>'live','enable'=>1]);
        }
        return redirect(route('admin.live'))->with(['status'=>'添加成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $live = Live::with('img')->findOrFail($id);
        if (!$live){
            return redirect(route('admin.live'))->withErrors(['status'=>'新闻不存在']);
        }
        //分类
        $categorys = LiveCategory::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        return view('admin.live.edit',compact('live','categorys'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $live = Live::with('img')->findOrFail($id);
        $data = $request->only(['category_id','title','subtitle','author','keywords','description','content','click','thumb','sort','live_time']);
        if($live->thumb != $data['thumb']) {
            //删除老图
            if($live->thumb > 0){
                Attachment::deleteImg($live->thumb);
            }
            Attachment::where('id',$data['thumb'])->update(['mark'=>'live','enable'=>1]);
        }
        if ($live->update($data)){
            return redirect(route('admin.live'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.live'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        foreach (Live::whereIn('id',$ids)->get() as $model){
            //清除中间表数据
            if($model->thumb){
                Attachment::deleteImg($model->thumb);
            }
            //删除项目
            $model->delete();
        }
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }

}
