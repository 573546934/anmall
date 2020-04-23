<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Attachment;
use App\Models\Category;
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
            ->orderByRaw("FIELD(status,'init','sale','success')")
            ->orderBy('created_at','desc')
            ->with(['tags','category','img'])->paginate($request->get('limit',30))->toArray();
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
        return view('admin.article.create',compact('tags','categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('category_id','title','keywords','description','content','thumb','click','business_district','total_area','format'
            ,'renovation','rented_area','elevator','plot_ratio','parking_lot','delivery_time','price_range','property_fee','payment_method'
            ,'aboveground','underground','storey_height','clear_height','address','remarks'
            ,'status','attributes','location','project','area','offer','point','debt','phone');
        $article = Article::create($data);
        if ($article && !empty($request->get('tags')) ){
            $article->tags()->sync($request->get('tags'));
        }
        //更新对应资源表
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
        $article = Article::with('tags','img','map')->findOrFail($id);
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
        return view('admin.article.edit',compact('article','categorys','tags'));

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
        $data = $request->only('category_id','title','keywords','description','content','thumb','click','business_district','total_area','format'
            ,'renovation','rented_area','elevator','plot_ratio','parking_lot','delivery_time','price_range','property_fee','payment_method'
            ,'aboveground','underground','storey_height','clear_height','address','remarks'
            ,'status','attributes','location','project','area','offer','point','debt','phone');

        if($article->thumb != $data['thumb']) {
            //删除老图
            if($article->thumb > 0){
                Attachment::deleteImg($article->thumb);
            }
            Attachment::where('id',$data['thumb'])->update(['mark'=>'article','enable'=>1]);
        }
        //多图
        if ($request->has('map')){
            $map = $request->get('map');   //轮播图
            Attachment::whereIn('id',$map)->update(['for_id'=>$article->id,'mark'=>'article','enable'=>1]);

        }
        if ($article->update($data)){
            $article->tags()->sync($request->get('tags',[]));
            return redirect(route('admin.article'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.article'))->withErrors(['status'=>'系统错误']);
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
