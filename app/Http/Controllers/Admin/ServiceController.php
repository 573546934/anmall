<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    //服务商管理
    public function index()
    {
        return view('admin.service.index');
    }

    public function data(Request $request)
    {
        $model = Service::query();
        if ($request->get('company_name')){
            $model = $model->where('company_name','like','%'.$request->get('company_name').'%');
        }
        $res = $model ->orderByRaw("FIELD(status,'0','1','-1')")
            ->orderBy('created_at','desc')
            ->with(['member','license','cardimg','id_pos','id_rev'])
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
        $business = Service::$business;
        return view('admin.service.create',compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'company_name'  => 'required|string',
        ]);
        $data = $request->only('company_name','scale','company_city','reg_capital','company_web','type','company_license',
            'description','introduction', 'name','sex','phone','city','company_nickname','job','card','logo','bgm');
        $business = $request->get('business');   
        $str = ''; 
        if(!empty($business)){
            foreach ($business as $key => $value) {
                if($key == 0){
                    $str .= $value;
                }else{
                    $str .= ','.$value;
                }
            }
        }
        $data['business'] = $str;    
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }
        $res = Service::addOne($data);
        return redirect(route('admin.service'))->with(['status'=>'添加完成']);
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
        $business = Service::$business;
        $service = Service::with('cardimg','license')->findOrFail($id);
        $service->business = explode(',',$service->business);
        return view('admin.service.edit',compact('service','business'));
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
        $this->validate($request,[
            'company_name'  => 'required|string',
        ]);
        $data = $request->only('company_name','scale','company_city','reg_capital','company_web','type','company_license',
        'description','introduction', 'name','sex','phone','city','company_nickname','job','card','logo','bgm');
        $business = $request->get('business');   
        $str = ''; 
        if(!empty($business)){
            foreach ($business as $key => $value) {
                if($key == 0){
                    $str .= $value;
                }else{
                    $str .= ','.$value;
                }
            }
        }
        $data['business'] = $str;    
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }
        $service = Service::find($id);
        if ($service->update($data)){
            return redirect(route('admin.service'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.service'))->withErrors(['status'=>'系统错误']);
    }


    //审核通过
    public function by(Request $request)
    {
        $ids = $request->get('ids');
        $res = Service::up($ids,['status'=>1]);
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
        $res = Service::up($ids,['status'=>-1]);
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
        Service::whereIn('id',$ids)->delete();
        /*foreach (Partner::whereIn('id',$ids)->get() as $model){
            //删除数据
            $model->delete();
        }*/
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
