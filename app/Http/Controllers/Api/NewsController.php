<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /*
     * 获取列表
     * */
    public function newsList(Request $request)
    {
        $where = [];
        $where['status'] = 1;
        //分类筛选
        if($request->has('category')){
            $category_id = NewsCategory::where('name','like','%'.$request->get('category').'%')->value('id') ? : 0;
            if ($category_id){
                $where['category_id'] = $category_id;
            }
        }
        $data = News::where($where)
            ->with('category','img');
        if($request->has('title')){
            $data = $data -> where('title' , 'like', '%'.$request->get('title').'%');
        }
        $data = $data->select('id','category_id','title','subtitle','author','thumb','created_at')
            ->orderBy('sort','desc')
            ->orderBy('created_at','desc')
            ->orderBy('updated_at','desc')
            ->paginate($request->get('limit',10))->toArray();
        //发布时间转换
        if(!empty($data['data'])){
            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['created_at'] = dateToStr($v['created_at']);
            }
        }
        return apiResult(1,'获取新闻',$data);
    }

    /*
     * 获取文章详情
     * */
    public function news(Request $request)
    {
        $id = $request->get('id');
        $data = News::getOne($id);
        $data['created_at'] = dateToStr( $data['created_at']);
        $data['previous'] = News::getPrevious($id);
        $data['next'] = News::getNext($id);
        $data['recommend'] = Article::inRandomOrder()
            ->with('category','img')
            ->with('img','category','tags')
            ->select('id','mid','category_id','international','country','city','title','price','assets_type','investment_type','address',
                'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
                'storey_height','remarks',
                'total_area','plot_ratio','orientations','property_fee','payment_method',
                'sort','click','thumb','recommend_img','recommend','created_at','updated_at','examine_status','status', 'phone',
                'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
                ,'principal','collateral_type','litigation_execution')
            ->limit(2)->get();
        return apiResult(1,'获取详情',$data);
    }
}
