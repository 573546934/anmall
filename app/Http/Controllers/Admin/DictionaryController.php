<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DictionaryController extends Controller
{
    //字典
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marks = Dictionary::getMarks();
        return view('admin.dictionary.index',compact('marks'));
    }

    public function data(Request $request)
    {
        $where = [];
        if($request->has('mark')){
            $where['mark'] = $request->get('mark');
        }
        $res = Dictionary::where($where)
            ->orderBy('id','desc')
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
        return view('admin.dictionary.create');
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
            'mark'  => 'required|string',
            'key'  => 'required|string',
            'value' => 'required|string'
        ]);
        if (Dictionary::create($request->all())){
            return redirect(route('admin.dictionary'))->with(['status'=>'添加完成']);
        }
        return redirect(route('admin.dictionary'))->with(['status'=>'系统错误']);
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
        $dictionary = Dictionary::findOrFail($id);
        return view('admin.dictionary.edit',compact('dictionary'));
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
            'mark'  => 'required|string',
            'key'  => 'required|string',
            'value' => 'required|string'
        ]);
        $category = Dictionary::findOrFail($id);
        if ($category->update($request->all())){
            return redirect(route('admin.dictionary'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.dictionary'))->withErrors(['status'=>'系统错误']);
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
        $category = Dictionary::find($ids);
        if (!$category){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if ($category->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

}
