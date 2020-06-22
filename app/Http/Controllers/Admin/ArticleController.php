<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\PropertyOwner;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //分类
        $categorys = Category::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        return view('admin.article.index',compact('categorys'));
    }

    public function data(Request $request)
    {

        $model = Article::query();
        if ($request->get('category_id')){
            $model = $model->where('category_id',$request->get('category_id'));
        }
        if ($request->get('title')){
            $model = $model->where('title','like','%'.$request->get('title').'%');
        }
        $res = $model
            ->orderByRaw("FIELD(examine_status,'0','1','-1')")
            ->orderBy('status','ace')
            //->orderBy('examine_status')
            ->orderBy('id','desc')
            ->with(['tags','category','img','member','propertyowners'])->paginate($request->get('limit',30))->toArray();
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
        $categorys = Category::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        //标签
        $tags = Tag::get();
        $assets_type = Article::assets_type();
        $investment_type = Article::investment_type();
        //产权方
        $propertyowners = PropertyOwner::where('status',1)->pluck('company_name','id');
        return view('admin.article.create',compact('tags','categorys','assets_type','investment_type','propertyowners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->only('category_id','country','city','title','price','assets_type','investment_type','address',
            'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
            'storey_height','remarks','explanation','total_area','plot_ratio','orientations','property_fee','payment_method','district',
            'sort','content','click','thumb','recommend_img','created_at','updated_at', 'phone',
            'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
            ,'principal','collateral_type','litigation_execution','assets_detail','land','commission'
        ,'graphic','analysis','process','problem','highlights','introduction','propertyowners_id');
        $data['examine_status'] = 1;
        $data['recommend'] = $request->get('recommend',0);
        $data['international'] = $request->get('country') != '中国' ? 0 : 1;
        $article = Article::create($data);
        if ($article && !empty($request->get('tags')) ){
            $article->tags()->sync($request->get('tags'));
        }
        //更新对应资源表
        if($article->recommend_img){
            Attachment::where('id',$article->recommend_img)->update(['mark'=>'recommend_img','enable'=>1]);
        }
        if($article->thumb){
            Attachment::where('id',$article->thumb)->update(['mark'=>'article','enable'=>1]);
        }
        //多图
        if ($request->has('map')){
            $map = $request->get('map');   //轮播图
            Attachment::whereIn('id',$map)->update(['for_id'=>$article->id,'mark'=>'article','enable'=>1]);

        }
        return redirect(route('admin.article'))->with(['status'=>'添加成功']);
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
        $article = Article::with('tags','img','re_img','map','category')->findOrFail($id);
        if (!$article){
            return redirect(route('admin.article'))->withErrors(['status'=>'项目不存在']);
        }
        //分类
        $categorys = Category::with('allChilds')->where('parent_id',0)->orderBy('sort','desc')->get();
        //标签
        $tags = Tag::get();
        foreach ($tags as $tag){
            $tag->checked = $article->tags->contains($tag) ? 'checked' : '';
        }
        $assets_type = Article::assets_type();
        $investment_type = Article::investment_type();
        //产权方
        $propertyowners = PropertyOwner::where('status',1)->select('company_name','id')->get();
        return view('admin.article.edit',compact('article','categorys','tags','assets_type','investment_type','propertyowners'));

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
        $article = Article::with('tags')->findOrFail($id);
        $data = $request->only('category_id','country','city','title','price','assets_type','investment_type','address',
            'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
            'storey_height','remarks','explanation','total_area','plot_ratio','orientations','property_fee','payment_method','district',
            'sort','content','click','thumb','recommend_img','created_at','updated_at', 'phone',
            'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
            ,'principal','collateral_type','litigation_execution','examine_status','assets_detail','land','commission'
            ,'graphic','analysis','process','problem','highlights','introduction','propertyowners_id');

        if($article->thumb != $data['thumb']) {
            //删除老图
            if($article->thumb > 0){
                Attachment::deleteImg($article->thumb);
            }
            Attachment::where('id',$data['thumb'])->update(['mark'=>'article','enable'=>1]);
        }
        $data['recommend'] = $request->get('recommend',0);
        if($article->recommend_img != $data['recommend_img']) {
            //删除老图
            if($article->recommend_img > 0){
                Attachment::deleteImg($article->recommend_img);
            }
            Attachment::where('id',$data['recommend_img'])->update(['mark'=>'recommend_img','enable'=>1]);
        }
        //多图
        if ($request->has('map')){
            $map = $request->get('map');   //轮播图
            Attachment::whereIn('id',$map)->update(['for_id'=>$article->id,'mark'=>'article','enable'=>1]);

        }
        if ($request->get('country') != '中国') {
            $data['international'] = 1;
        }
        if ($article->update($data)){
            $article->tags()->sync($request->get('tags',[]));
            return redirect(route('admin.article'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.article'))->withErrors(['status'=>'系统错误']);
    }
     //审核通过
    public function by(Request $request)
    {
        $ids = $request->get('ids');
        $res = Article::up($ids,['examine_status'=>1]);
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
        $res = Article::up($ids,['examine_status'=>-1]);
        if ($res){
            return response(['code'=>0,'msg'=>'审核不通过成功']);
        }else{
            return response(['code'=>1,'msg'=>'审核不通过失败']);
        }
    }
    //审核通过
    public function byStatus(Request $request)
    {
        $ids = $request->get('ids');
        $res = Article::up($ids,['status'=>1]);
        if ($res){
            return response(['code'=>0,'msg'=>'审核通过成功']);
        }else{
            return response(['code'=>1,'msg'=>'审核通过失败']);
        }
    }
  //审核不通过
    public function refuseStatus(Request $request)
    {
        $ids = $request->get('ids');
        $res = Article::up($ids,['status'=>0,'mid'=>0]);
        if ($res){
            return response(['code'=>0,'msg'=>'审核不通过成功']);
        }else{
            return response(['code'=>1,'msg'=>'审核不通过失败']);
        }
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
        foreach (Article::whereIn('id',$ids)->get() as $model){
            //清除中间表数据
            $model->tags()->sync([]);
            if($model->thumb){
                Attachment::deleteImg($model->thumb);
            }
             if($model->recommend_img){
                Attachment::deleteImg($model->recommend_img);
            }
            //处理多图
            $imgs = Attachment::where('for_id',$model->id)->whereIn('mark',['article'])->pluck('id')->toarray();
            if($imgs && !empty($imgs)){
                Attachment::deleteImages($imgs);
            }
            //删除项目
            $model->delete();
        }
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }

}
