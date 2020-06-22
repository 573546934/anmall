<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owner';
    protected $fillable = ['mid','id_img_pos','id_img_rev','type','company_name','company_city','reg_capital','company_web','company_license','name','sex','phone','city','company_nickname','email','job','card','status','logo','bgm'];

    /*资方申请资料保存*/
    public static function addOne($data)
    {
        $data['created_at'] = date('Y-m-d h:i');
        return static :: insertGetId($data);
    }

    /*修改状态*/
    public static function up($ids,$data)
    {
        $is_owner = $data['status'] == 1 ? 1 : 0;
        foreach ($ids as $id){
            $mid = static :: where('id',$id)->value('mid');
            Member::where('id',$mid)->update(['is_owner'=>$is_owner]);
        }
        return static :: whereIn('id',$ids)->update($data);
    }


    /*营业执照*/
    public function license()
    {
        return $this->hasOne('App\Models\Attachment','id','avatar')->select('id','url');
    }
    /*名片*/
    public function cardimg()
    {
        return $this->hasOne('App\Models\Attachment','id','card')->select('id','url');
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
    /*用户*/
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')  ->select('id','avatar','name','nickname','phone');;
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
