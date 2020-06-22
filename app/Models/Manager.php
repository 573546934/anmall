<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $table = 'manager';
    protected $fillable = ['mid','name','email','id_num','id_img_pos','id_img_rev','sex','city','email','avatar','company_name','department','job','card','status'];

    /*经纪人申请资料保存*/
    public static function addOne($data)
    {
        $data['created_at'] = date('Y-m-d h:i');
        return static :: insertGetId($data);
    }
    /*修改状态*/
    public static function up($ids,$data)
    {
        $status = $data['status'] == 1 ? 1 : 0;
        foreach ($ids as $id){
            $mid = static :: where('id',$id)->value('mid');
            Member::where('id',$mid)->update(['is_manager'=>$status]);
        }
        return static :: whereIn('id',$ids)->update($data);
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
    /*头像*/
    public function avatarimg()
    {
        return $this->hasOne('App\Models\Attachment','id','avatar')->select('id','url');
    }
    /*名片*/
    public function cardimg()
    {
        return $this->hasOne('App\Models\Attachment','id','card')->select('id','url');
    }
    /*用户*/
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')  ->select('id','avatar','name','nickname','phone');;
    }

}
