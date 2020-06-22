<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;;

class Live extends Model
{
    //直播
    protected $table = 'live';
    protected $fillable = ['category_id','title','subtitle','author','keywords','description','content','click','thumb','sort'];


    //获取详情
    public static function getOne($id)
    {
        return static :: where('id',$id)
            ->with('img','category')
            ->first()->toArray();
    }

    //直播所属分类
    public function category()
    {
        return $this->belongsTo('App\Models\LiveCategory')->select('id','name');
    }
    /*直播主图*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','thumb')->select('id','url');
    }
    /*预约人数*/
    public function member()
    {
        return $this->hasMany('App\Models\LiveMember','live_id','id');
    }
    /*自己是否预约*/
    public function me($mid)
    {
        return $this->hasMany('App\Models\LiveMember','live_id','id')
            ->where('mid',$mid);
    }

    /*修改状态*/
    public static function up($id,$data)
    {
        return static :: where('id',$id)->update($data);
    }
}
