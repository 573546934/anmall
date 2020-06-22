<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    //意见反馈
    protected $table = 'opinion';
    protected $fillable = ['mid','score','content'];

    //用户
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')->select('id','name','nickname','phone');
    }
}
