<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $fillable = ['mid','category_id','international','country','city','title','price','assets_type','investment_type','address',
        'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
        'storey_height','remarks','explanation','assets_detail','land',
        'total_area','plot_ratio','volume_rate','orientations','property_fee','payment_method','district',
        'sort','content','click','thumb','recommend_img','recommend','created_at','updated_at','examine_status','status', 'phone',
        'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
        ,'principal','collateral_type','litigation_execution'
        ,'deal_price','deal_date','deal_type','commission'
        ,'graphic','analysis','process','problem','propertyowners_id','highlights','introduction'];

    static $selects = ['id','mid','category_id','international','country','city','title','price','assets_type','investment_type','address',
        'area','format','description','renovation','trade_type','elevator','parking_lot','floor','floor_area',
        'storey_height','remarks','explanation','land',
        'total_area','plot_ratio','volume_rate','orientations','property_fee','payment_method',
        'sort','click','thumb','recommend_img','recommend','created_at','updated_at','examine_status','status', 'phone',
        'accounting_date','loan_principal','loan_interest','mortgage_principal','households','project_ownership','included_date'
        ,'principal','collateral_type','litigation_execution','commission'
        ,'propertyowners_id'];

    //获取物业类型
    public static function assets_type(){
        return Dictionary::keyValues('assets_type');
    }
    public static function investment_type(){
        return Dictionary::keyValues('investment_type');
    }
    //添加一个项目
    public static function addOne($data)
    {
        $data['created_at'] = date('Y-m-d h:i');
        return static :: insertGetId($data);
    }

    //获取项目列表
    public static function getPage($where=[],$limit = 10)
    {
        return static :: where($where)
            ->with('img','category','tags')
            ->select(static::$selects)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->paginate($limit);
    }
    //获取我发布的项目列表
    public static function myArticles($where=[],$limit = 10)
    {
        return static :: where($where)
//            ->where('status','>',-1)
            ->with('img')
            ->select(static::$selects)
            ->orderBy('id','desc')
            ->paginate($limit);
    }

    //首页项目列表
    public static function getHome($where=[],$limit = 10)
    {
        $categorys = Category::where('is_index',1)
//                ->orderByRaw(DB::raw("FIELD(id, '4','6','7','5')"))
                ->orderBy('sort','desc')
                ->select('id','index_name','name','is_index')->get();
        $data = [];
        if ($categorys){
            foreach ($categorys as $k => $category){
                $data[$k]['category_name'] = $category->index_name;
                $data[$k]['category_id'] = $category->id;
                $data[$k]['list'] = static :: where($where)
//                    ->where('status','>',-1)
                    ->where('category_id',$category->id)
                    ->with('img','tags')
                    ->orderBy('sort','desc')
                    ->orderBy('id','desc')
                    ->select(static::$selects)
                    ->limit($limit)
                    ->get();
                $data[$k]['list'] = formatHome($data[$k]['list']);
            }
        }
        return $data;
    }

    //获取推荐项目
    public static function getRecommend()
    {
        $where['examine_status'] = 1;
        $where['recommend'] = 1;
        $data = Article:: where($where)
            ->with('re_img')
            ->select(static::$selects)
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->limit(10)
            ->get();
        return $data;
    }

    //获取项目详情
    public static function getOne($id)
    {
        $data = static :: where('id',$id)
            ->with('img','map','category','tags','propertyowners')
            ->first();
        if ($data){
            $data->area = $data->area . '㎡';
        }
        if($data->category_id == 4){
            $data->type = 'merchants';
        }elseif($data->category_id == 7) {
            $data->type = 'bad';
        }else{
            $data->type = 'init';
        }
        return $data;
    }
    //相似项目
    public static function likeArticle($id)
    {
        //相似类型
        $cid = static :: where('id',$id)->value('category_id');
        $articles =  static :: where('category_id',$cid)
            ->with('tags','img')
            ->select(static::$selects)
            ->orderBy('sort','desc')
            ->limit(2)
            ->get();
        return formatList($articles);
    }
    //获取上一条数据()
    public static function getPrevious($id)
    {
        return static :: where('id','>',$id)->orderBy('id','desc')->select('id','title')->first();
    }
    //获取下一条数据()
    public static function getNext($id)
    {
        return static :: where('id','<',$id)->orderBy('id','desc')->select('id','title')->first();
    }
    //获取项目需要筛选的所有城市
    public static function getCitys()
    {
        $data = static :: select('city as name',DB::raw('count(*) as num'))
            ->where('international',0)
            ->orderBy('num','desc')
            ->groupBy('name')
            ->get()
            ->toArray();
        return array_values(array_filter($data));
    }
    //获取项目所有国家
    public static function getCountry()
    {
        $data = static :: select('country as name',DB::raw('count(*) as num'))
            //->where('international',1)
            ->orderBy('num','desc')
            ->groupBy('name')
            ->get()
            ->toArray();
        return array_values(array_filter($data));
    }
    //获取项目名称对应ID数组
    public static function getArticleNames()
    {
        return static::pluck('title','id');
    }
    //获取项目所有商圈
    public static function getDistrict()
    {
        $data = static :: select('district as name',DB::raw('count(*) as num'))
            ->whereNotNull('district')
            ->orderBy('num','desc')
            ->groupBy('district')
            ->get()
            ->toArray();
        return array_values(array_filter($data));
    }
    //项目所属分类
    public function category()
    {
        return $this->belongsTo('App\Models\Category')->select('id','name');
    }

    //与标签多对多关联
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','article_tag','article_id','tag_id');
    }

    //用户绑定
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')
            ->select('id','name','nickname','phone');
    }

    /*项目主图*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','thumb')->select('id','url');
    }
    /*项目主图*/
    public function re_img()
    {
        return $this->hasOne('App\Models\Attachment','id','recommend_img')->select('id','url');
    }
    /*项目多图*/
    public function map()
    {
        return $this->hasMany('App\Models\Attachment', 'for_id', 'id')
            ->where('mark','article');
//            ->select('id','url');
    }

    /*项目资方*/
    public function owner()
    {
        return $this->hasMany('App\Models\PropertyOwner', 'id', 'owner_id')
            ->where('mark','article');
    }
    /*项目产权方*/
    public function propertyowners()
    {
        return $this->hasMany('App\Models\PropertyOwner', 'id', 'propertyowners_id')
            ->with(['teamimg','featuresimg','awardsimg','logoimg']);
    }
    /*项目品牌机构*/
    public function brand()
    {
        return $this->hasMany('App\Models\PropertyOwner', 'id', 'propertyowners_id')
            ->with(['teamimg','featuresimg','awardsimg','logoimg']);
    }

    /*修改状态*/
    public static function up($ids,$data)
    {
        return static :: whereIn('id',$ids)->update($data);
    }

}
