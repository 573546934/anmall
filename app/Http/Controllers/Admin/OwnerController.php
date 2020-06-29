<?php

namespace App\Http\Controllers\Admin;

use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    //资方管理
    public function index()
    {
        return view('admin.owner.index');
    }

    public function data(Request $request)
    {
        $model = Owner::query();
        if ($request->get('company_name')){
            $model = $model->where('company_name','like','%'.$request->get('company_name').'%');
        }
        $res = $model ->orderByRaw("FIELD(status,'0','1','-1')")
            ->orderBy('created_at','desc')
            ->with(['member','license','cardimg','id_pos','id_rev','teamimg','featuresimg','awardsimg','logoimg'])
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
        return view('admin.owner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('type','company_name','company_city','reg_capital','company_web','company_license','name','sex','phone','city','company_nickname','email','job','card'
             ,'team_name',' team_detail','team_img','features','features_img','awards','awards_img','logo','id_img_pos','id_img_rev');
        $res = Owner::addOne($data);
        return redirect(route('admin.owner'))->with(['status'=>'添加完成']);
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
        $owner = Owner::with('license','teamimg','featuresimg','awardsimg','logoimg','id_pos','id_rev')->findOrFail($id);
        return view('admin.owner.edit',compact('owner'));
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
        $data = $request->only('type','company_name','company_city','reg_capital','company_web','company_license','name','sex','phone','city','company_nickname','email','job','card'
        ,'team_name',' team_detail','team_img','features','features_img','awards','awards_img','logo','id_img_pos','id_img_rev');  
        $owner = owner::find($id);
        if ($owner->update($data)){
            return redirect(route('admin.owner'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.owner'))->withErrors(['status'=>'系统错误']);
    }


    //审核通过
    public function by(Request $request)
    {
        $ids = $request->get('ids');
        $res = owner::up($ids,['status'=>1]);
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
        $res = owner::up($ids,['status'=>-1]);
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
        owner::whereIn('id',$ids)->delete();
        /*foreach (Partner::whereIn('id',$ids)->get() as $model){
            //删除数据
            $model->delete();
        }*/
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
