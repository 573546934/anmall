<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Recommend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    //品牌机构
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brand.index');
    }

    public function data(Request $request)
    {
        $model = Brand::query();
        if ($request->get('company_name')){
            $model = $model->where('company_name','like','%'.$request->get('company_name').'%');
        }
        $res = $model
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->with('img')
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
        $articles = Article::getArticleNames(); //绑定可推荐名称ID
        return view('admin.brand.create',compact('articles'));
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
            'sort'  => 'required|numeric',
        ]);
        $data = $request->only('company_name','logo','company_type','city','sort','bgm');
        //绑定项目
        $rec = $request->input('recommend','');
        $brand = new Brand($data);
        $brand->save();  //保存
        $for_id = $brand->id;
        //保存关联推荐
        if(!empty($rec)){
            foreach ($rec as $v){
                Recommend::addArticle($for_id,'brand',$v);
            }
        }
        return redirect(route('admin.brand'))->with(['status'=>'添加完成']);
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
        $articles = Article::getArticleNames(); //绑定可推荐文章名称ID
        $brand = Brand::with('img','bgms')->findOrFail($id);
        $brand->articles = $brand->recommend->where('item_mark','article')->pluck('item_id','id')->toArray();
        unset( $brand->recommend);
        return view('admin.brand.edit',compact('brand','articles'));
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
            'sort'  => 'required|numeric',
        ]);
        $data = $request->only('company_name','logo','company_type','city','sort','bgm');
        if($request->has('recommend') && !empty($request->get('recommend'))){  //如有推荐项目 --更新
            Recommend::delArticle($id,'brand'); //删除原有绑定
            Recommend::addArticles($request->get('recommend'),$id,'brand');  //绑定新项目
        }
        $brand = Brand::find($id);
        if ($brand->update($data)){
            return redirect(route('admin.brand'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.brand'))->withErrors(['status'=>'系统错误']);
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
        if (Brand::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
