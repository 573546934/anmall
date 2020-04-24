<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
   //项目
    /*发布项目*/

    /*项目列表*/
    public function list(Request $request)
    {
        $where = [];
        $data = Article::getPage($where);
        $res = [
            'code'=>1,
            'message'=>'正在拉取数据',
            'count'=>$data->count,
            'data'=>$data
        ];
        return response($res);
    }
    /*我的项目列表*/
    public function
    /*项目详情*/

}