<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{

    protected $fillable = ['title','thumb','link','position_id','sort','description','content'];

    //获取指定位置广告
    public static function getList($name)
    {
        $positionId = Position::where('name','like','%'.$name.'%')->value('id');
        return static :: where('position_id',$positionId)->with('img')
            ->orderBy('sort','desc')
            ->get();
    }
    //获取指定位置文案-单个结果
    public static function getWa($name,$pid)
    {
        return static :: where('position_id',$pid)->where('title','like','%'.$name.'%')->with('img')->first();
    }
    //获取名片背景
    public static function getBgm($name)
    {
        $positionId = Position::where('name','like','%'.$name.'%')->value('id');
        return static :: where('position_id',$positionId)->with('img')
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    //广告所在的位置信息
    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }

    /*广告主图*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','thumb')->select('id','url');
    }

}
