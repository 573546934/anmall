<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';
    protected $fillable = ['name','sort','parent_id'];

    public static function getCategorys()
    {
        return static :: where('parent_id',0)->select('name','id')->get();
    }

    //子分类
    public function childs()
    {
        return $this->hasMany('App\Models\NewsCategory','parent_id','id');
    }

    //所有子类
    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    //分类下所有的新闻
    public function news()
    {
        return $this->hasMany('App\Models\News','category_id','id');
    }

}
