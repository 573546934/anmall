<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityApplication extends Model
{
    protected $table = 'identity_application';
    protected $fillable = ['mid','status','identity'];

    //添加申请
    public static function addOne($data)
    {
        return static ::create($data);
    }
    //审批修改
    public static function upStatus($id,$status)
    {
        return static :: where('id',$id)->update('status',$status);
    }

    /*用户*/
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid');
    }

}
