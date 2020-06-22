<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //头条
    protected $table = 'news';
    protected $fillable = ['category_id','title','subtitle','author','keywords','description','content','click','thumb','sort'];


    //获取详情
    public static function getOne($id)
    {
        return static :: where('id',$id)
            ->with('img','category')
            ->first()->toArray();
    }
    //获取上一条数据()
    public static function getPrevious($id)
    {
        return static :: where('id','>',$id)->orderBy('id','desc')->select('id','title')->first();
    }
    //获取下一条数据()
    public static function getNext($id)
    {
        return static :: where('id','<',$id)->orderBy('id','desc')->select('id','title')->first();
    }

    //新闻所属分类
    public function category()
    {
        return $this->belongsTo('App\Models\NewsCategory')->select('id','name');
    }
    /*新闻主图*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','thumb')->select('id','url');
    }
    /*修改状态*/
    public static function up($id,$data)
    {
        return static :: where('id',$id)->update($data);
    }
}
