<?php

namespace App\Http\Controllers\Admin;

use App\Models\LiveCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.live_category.index');
    }

    public function data(Request $request)
    {
        $res = LiveCategory::where('parent_id',$request->get('parent_id',0))->orderBy('id','desc')->orderBy('sort','desc')->paginate($request->get('limit',30))->toArray();
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
        $categorys = $this->tree(LiveCategory::get()->toArray());
        return view('admin.live_category.create',compact('categorys'));
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
            'name'  => 'required|string',
            'sort'  => 'required|numeric',
            'parent_id' => 'required|numeric'
        ]);
        if (LiveCategory::create($request->all())){
            return redirect(route('admin.live_category'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.live_category'))->with(['status'=>'系统错误']);
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
        $category = LiveCategory::findOrFail($id);
        $categorys = $this->tree(LiveCategory::get()->toArray());
        return view('admin.live_category.edit',compact('category','categorys'));
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
            'name'  => 'required|string',
            'sort'  => 'required|numeric',
            'parent_id' => 'required|numeric'
        ]);
        $category = LiveCategory::findOrFail($id);
        if ($category->update($request->all())){
            return redirect(route('admin.live_category'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.live_category'))->withErrors(['status'=>'系统错误']);
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
        $category = LiveCategory::with(['childs','articles'])->find($ids);
        if (!$category){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if (!$category->childs->isEmpty() || !$category->articles->isEmpty()){
            return response()->json(['code'=>1,'msg'=>'该分类下有子分类或者文章，不能删除']);
        }
        if ($category->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
