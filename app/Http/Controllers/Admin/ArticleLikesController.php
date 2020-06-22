<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleLikes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleLikesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //项目
        $articles = Article::getArticleNames();
        return view('admin.article_likes.index',compact('articles'));
    }

    public function data(Request $request)
    {

        $model = ArticleLikes::query();
        if ($request->get('article_id')){
            $model = $model->where('article_id',$request->get('article_id'));
        }
         if ($request->get('fid')){
            $model = $model->where('fid',$request->get('fid'));
        }
        $res = $model
            ->orderBy('updated_at','desc')
            ->with(['article','friend','member'])->paginate($request->get('limit',10))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
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
        if (ArticleLikes::destroy($ids)){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
