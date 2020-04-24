<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['phone','name','password','avatar','remember_token','open_id','union_id','friend_id','identity','address','role'];

    //返回登录信息
    public static function getWxInfo($member){
        return [
            'mid'=>$member->id,
            'nickname'=>$member->nickname,
            'identity'=>$member->identity,
        ];
    }

    /*修改资料*/
    public static function updateInfo($mid,$data)
    {
        return static :: where('id',$mid)->update($data);
    }
    /*资方*/
    public function management()
    {
        return $this->hasOne('App\Models\Management','mid','id');
    }


}
