<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Article;
use App\Models\ArticleLikes;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Member;
use App\Models\Report;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
   //项目
    /*获取项目分类*/
    public function categorys()
    {
        $data['category_id'] = Category::getCategorys();
        $data['assets_type'] = Article::assets_type();
        $data['investment_type'] = Article::investment_type();
        $data['city'] = Article::getCitys();
        $data['country'] = Article::getCountry();
        $data['district'] = Article::getDistrict();
        $a['sx'] = [
           'city'=> ['label'=>'城市','value'=>$data['city']],
            'country'=> ['label'=>'国家','value'=>$data['country']],
            'assets_type'=> ['label'=>'物业类型','value'=>$data['assets_type']],
            'investment_type'=> ['label'=>'资产方类型','value'=>$data['investment_type']],
            'district'=> ['label'=>'商圈','value'=>$data['district']],
            ];
        $a['category_id']=$data['category_id'];

        return apiResult(1,'获取',$a);
    }
    /*发布项目*/
    public function addArticle(Request $request)
    {
        $data = $request->only('category_id','country','city','title','price','assets_type','investment_type','address',
            'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
            'storey_height','remarks','explanation','land',
            'total_area','plot_ratio','orientations','property_fee','payment_method',
            'sort','content','click','thumb','recommend_img','recommend','created_at','updated_at','examine_status','status', 'phone',
            'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
            ,'principal','collateral_type','litigation_execution','commission');
        $data['mid'] = $request->get('mid_params');
        $res = Article::addOne($data);
        if($request->has('map')){
            Attachment::addMap($request->get('map'),$res,'article');
        }
        return apiResult($res,'发布',['id'=>$res]);
    }
    /*项目列表*/
    public function articles(Request $request)
    {
        $where = [];
        $where['examine_status'] = 1;
        if($request->has('category_id')){
            $where['category_id'] = $request->get('category_id');
        }
        if($request->has('international')){
            $where['international'] = $request->get('international');
        }
        if($request->has('country')){
            $where['country'] = $request->get('country');
        }
        if($request->has('city')){
            $where['city'] = $request->get('city');
        }
        if($request->has('assets_type')){
            $where['assets_type'] = $request->get('assets_type');
        }
        if($request->has('investment_type')){
            $where['investment_type'] = $request->get('investment_type');
        }
        if($request->has('format')){
            $where['format'] = $request->get('format');
        }
        $limit = $request->get('limit',10);
        $data = Article :: where($where);
        if($request->has('area_min')){
            $data = $data -> where('area', '>', $request->get('area_min'));
        }
        if($request->has('area_max')){
            $data = $data -> where('area' , '<', $request->get('area_max'));
        }
        if($request->has('district')){
            $data = $data -> where('district' , 'like', $request->get('district'));
        }
        if($request->has('title')){
            $data = $data -> where('title' , 'like', '%'.$request->get('title').'%');
        }
        $data = $data->with('img','category','tags')
            ->select(Article::$selects)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->paginate($limit);
        $data = formatList($data);
        return apiResult($data,'获取',$data);
    }
    /*推荐项目*/
    public function recommend_articles(Request $request)
    {
        $where = [];
        $where['examine_status'] = 1;
        $where['recommend'] = 1;
        $limit = $request->get('limit',20);
        $data = Article:: where($where)
            ->with('re_img')
            ->select(Article::$selects)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->paginate($limit);
        $data = formatList($data);
        return apiResult($data,'获取',$data);
    }
    /*我完成的项目列表*/
    public function myArticles(Request $request)
    {
        $where = [];
        $where['mid'] = $request->get('mid_params');
        $where['status'] = 1;
        //状态码筛选 0待审核 1通过 -1 未通过

        if($request->has('category_id')){
            $where['category_id'] = $request->get('category_id');
        }
        if($request->has('examine_status')){
            $where['examine_status'] = $request->get('examine_status');
        }
        $limit = $request->get('limit',10);
        $data = Article::myArticles($where,$limit);
        $data = formatList($data);
        return apiResult($data,'获取',$data);
    }
    /*提交完成项目申请*/
    public function completeArticle(Request $request)
    {
        $id = $request->get('id');
        $mid = $request->get('mid_params');
        $article = Article::find($id);
        if ($article && $article->mid > 0){
            return response(['message'=>'该项目已被申请完成']);
        }
        $data = $request->only('deal_price','deal_date','deal_type');
        $data['mid'] = $mid;
        $data['status'] = -1;
        $res = Article::up([$id],$data);
        return apiResult($res,'已申请,请等待审核');
    }
    /*获取项目所有未完成名称*/
    public function getUndoneArticle(Request $request)
    {
        $data = Article::where('status',0)->select('id','title')->get();
        return apiResult(1,'获取',$data);
    }
    /*我收藏的项目列表*/
    public function myAllArticles(Request $request)
    {
        $mid = $request->get('mid_params');
        $type = $request->get('type','collection');
        $limit = $request->get('limit',10);
        $data = [];
        if($type == 'collection') {
            $data = Collection::myCollectionArticle($mid, $limit);
            $data = formatList($data);
        }
        return apiResult($data,'获取',$data);
    }

    /*项目详情*/
    public function article(Request $request)
    {
        $mid = $request->get('mid_params');
        $member = Member::find($mid);
        $id = $request->get('id');
        //添加统计记录
        ArticleLikes::addOne($mid,$id,$request->get('friend_id',0));
        $article = Article::getOne($id);
        $article = formatOne($article);
        //如果有经纪人  则显示经纪人电话
        if(!empty($member->friend_id)) {
            $fp = Member::find($member->friend_id);
            if(!empty($fp) && $fp->is_manager == 1){
                $article->phone = $fp->phone;
            }
        }
        if (empty($article->phone)){
            $ad = Advert::getList('商务合作');
            if (isset($ad[0]->description)){
                $article->phone = $ad[0]->description;
            }
        }
        /*$article['previous'] = Article::getPrevious($id);
        $article['next'] = Article::getNext($id);*/
        //类似项目
        $article['likes'] = Article::likeArticle($id);
        //分享统计
        $article['attentions'] = ArticleLikes::getAttentions($id,$mid);
        //是否收藏
        $article['collection'] = Collection::where('mark','article')->where(['mid'=>$mid,'bind_id'=>$id])->first() ? 1 : 0;
        return apiResult($article,'获取',$article);
    }
}