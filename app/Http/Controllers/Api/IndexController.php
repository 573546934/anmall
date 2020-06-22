<?php

namespace App\Http\Controllers\Api;

use App\Models\Advert;
use App\Models\Article;
use App\Models\Collection;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 首页数据
     * @name  get home
     * @return json data
     * */
    public function home()
    {
        $data = [
            'ads' => Advert::getList('首页轮播'), //轮播图
            'navs' => Advert::getList('首页导航'), //导航图
            'demands' => [], //需求单 暂未确认内容
            'articles' => Article::getHome(),
            'recommend_articles' => Article::getRecommend(),
        ];
        return response(['data'=>$data]);
    }

    /*添加收藏*/
    public function addCollection(Request $request)
    {
        $data['mark'] = $request->get('mark');
        $data['bind_id'] = $request->get('id');
        $data['mid'] = $request->get('mid_params');
        $member = Member::getOne($data['mid']);
        if ($member->type == 1){
            return apiResult(0,'请先完善资料');
        }
        $re = Collection::where($data)->first();
        if ($re){
            //取消收藏
            $res = Collection::del($data);
            return apiResult($res,'收藏');
        }else{
            //添加收藏
            $res = Collection::addOne($data);
            return apiResult($res,'收藏');
        }
    }


}
