<?php

namespace App\Http\Controllers\Api;

use App\Models\Live;
use App\Models\LiveCategory;
use App\Models\LiveMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveController extends Controller
{
    public function liveIndex(Request $request)
    {
        $cid = LiveCategory::where('name','like','%线上直播%')->value('id');
        $data = Live::where('category_id',$cid)
            ->with('img','category')
            ->withCount('member')
            ->orderBy('sort','desc')
            ->limit(3)
            ->get()->toArray();
        if(!empty($data)){
            $mid = $request->get('mid_params');
            foreach ( $data as $k => $v){
                $data[$k]['attention'] = LiveMember::where(['mid'=>$mid,'live_id'=>$v['id']])->first() ? 1 : 0;
            }
        }
        return apiResult(1,'直播首页数据',$data);
    }
    /*
     * 获取列表
     * */
    public function liveList(Request $request)
    {
        $where = [];
        //分类筛选
        if($request->has('category')){
            $category_id = LiveCategory::where('name','like','%'.$request->get('category').'%')->value('id') ? : 0;
            if ($category_id){
                $where['category_id'] = $category_id;
            }
        }
        $data = Live::where($where)
            ->with('category','img')
            ->withCount('member');
        if($request->has('title')){
            $data = $data -> where('title' , 'like', '%'.$request->get('title').'%');
        }
        $data = $data->select('id','category_id','title','subtitle','author','thumb','live_time','created_at','live_time')
            ->where('status','!=',-1)
            ->orderBy('sort','desc')
            ->orderBy('created_at','desc')
            ->orderBy('updated_at','desc')
            ->paginate($request->get('limit',10))->toArray();
        if(!empty($data['data'])){
            $mid = $request->get('mid_params');
            foreach ( $data['data'] as $k => $v){
                $data['data'][$k]['attention'] = LiveMember::where(['mid'=>$mid,'live_id'=>$v['id']])->first() ? 1 : 0;
            }
        }
        return apiResult(1,'获取直播列表',$data);
    }

    /*
     * 获取直播详情
     * */
    public function live(Request $request)
    {
        $id = $request->get('id');
        $data = Live::getOne($id);
        $data['created_at'] = dateToStr( $data['created_at']);
        return apiResult(1,'获取详情',$data);
    }
}
