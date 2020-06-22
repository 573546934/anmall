<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    //收藏
    protected $table = 'report';
    protected $fillable = ['mid','mark','bind_id'];

    public static function addOne($data)
    {
        return static::create($data);
    }

    //获取我的收藏项目
    public static function myReportArticle($mid,$limit = 10)
    {
        $ids = static :: where(['mid'=>$mid,'mark'=>'article'])
            ->orderBy('id','desc')->pluck('bind_id')->toArray();
        $idstr = implode(",", $ids);
        return Article::whereIn('id',$ids)
            ->with('tags','img')
            ->select('id','title','thumb','city','country','international','examine_status','description','remarks')
            ->orderBy(DB::raw('FIND_IN_SET(id, "' . $idstr . '"' . ")"))
            ->paginate($limit);
    }

    //关联项目
    public function article()
    {
        return $this->hasMany('App\Models\Article','id','bind_id')
            ->with('tags','img')
            ->select('id','title','thumb','city','country');
    }
}
