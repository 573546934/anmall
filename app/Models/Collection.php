<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
    //收藏
    protected $table = 'collection';
    protected $fillable = ['mid','mark','bind_id'];

    //添加收藏
    public static function addOne($data)
    {
        return static::create($data);
    }
    //取消收藏
    public static function del($where)
    {
        return static :: where($where)->delete();
    }

    //获取我的收藏项目
    public static function myCollectionArticle($mid,$limit = 10)
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
