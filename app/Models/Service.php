<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    protected $table = 'service';
    protected $fillable = ['mid','id_img_pos','id_img_rev','company_name','scale','company_city','reg_capital','company_web','type','company_license',
        'description','business','introduction', 'name','sex','phone','city','company_nickname','job','card','status',
        'logo','bgm'];

    static public $business = [
        [
            'business_name'=> '交易服务(选填)',
            'business'=>[
                ['business_name'=>'法律服务'],
                ['business_name'=>'财务顾问'],
                ['business_name'=>'评估咨询'],
                ['business_name'=>'税务筹划'],
                ['business_name'=>'市场调研'],
                ['business_name'=>'营销策划'],
                ['business_name'=>'战略咨询'],
                ['business_name'=>'投资顾问'],
            ]
        ], [
            'business_name'=> '运营管理(选填)',
            'business'=>[
                ['business_name'=>'资产管理'],
                ['business_name'=>'物业管理'],
                ['business_name'=>'运营管理'],
                ['business_name'=>'建筑工程'],
                ['business_name'=>'更新改造'],
                ['business_name'=>'工程管理'],
                ['business_name'=>'设施管理'],
                ['business_name'=>'不良资产处置'],
                ['business_name'=>'招商租赁'],
                ['business_name'=>'规划设计'],
                ['business_name'=>'智能科技'],
                ['business_name'=>'装修设计'],
                ['business_name'=>'产业综合服务'],
                ['business_name'=>'项目代建'],
            ]
        ], [
            'business_name'=> '金融服务(选填)',
            'business'=>[
                ['business_name'=>'融资租赁'],
                ['business_name'=>'投融资服务'],
                ['business_name'=>'保险'],
                ['business_name'=>'担保'],
                ['business_name'=>'证券'],
                ['business_name'=>'保理'],
                ['business_name'=>'银行'],
                ['business_name'=>'投资银行'],
                ['business_name'=>'私募基金'],
            ]
        ],
    ];

    /*服务商申请资料保存*/
    public static function addOne($data)
    {
        $data['created_at'] = date('Y-m-d h:i:s');
        return static :: insertGetId($data);
    }

    /*修改状态*/
    public static function up($ids,$data)
    {
        $is_service = $data['status'] == 1 ? 1 : 0;
        foreach ($ids as $id){
            $mid = static :: where('id',$id)->value('mid');
            Member::where('id',$mid)->update(['is_service'=>$is_service]);
        }
        return static :: whereIn('id',$ids)->update($data);
    }

    //获取项目需要筛选的所有城市
    public static function getCitys()
    {
        $data = static :: select('company_city as name',DB::raw('count(*) as num'))
            ->orderBy('num','desc')
            ->groupBy('name')
            ->get()
            ->toArray();
        return array_values(array_filter($data));
    }

    /*获取主营业务*/
    public static function getBusiness()
    {
        return  self :: $business;
    }

    /*营业执照*/
    public function license()
    {
        return $this->hasOne('App\Models\Attachment','id','company_license')->select('id','url');
    }
    /*名片*/
    public function cardimg()
    {
        return $this->hasOne('App\Models\Attachment','id','card')->select('id','url');
    }
    /*用户*/
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')
            ->select('id','avatar','name','nickname','phone');
    }
    /*logo*/
    public function logoimg()
    {
        return $this->hasOne('App\Models\Attachment','id','logo')->select('id','url');
    }
    /*bgm*/
    public function bgmimg()
    {
        return $this->hasOne('App\Models\Attachment','id','bgm')->select('id','url');
    }
    /*案列*/
    public function service_case()
    {
        return $this->hasMany('App\Models\ServiceCase','service_id','id')->with('img');
    }
    /*身份证正*/
    public function id_pos()
    {
        return $this->hasOne('App\Models\Attachment','id','id_img_pos')->select('id','url');
    }
    /*身份证反*/
    public function id_rev()
    {
        return $this->hasOne('App\Models\Attachment','id','id_img_rev')->select('id','url');
    }

}
