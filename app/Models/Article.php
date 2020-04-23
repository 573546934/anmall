<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['category_id','title','keywords','description','content','thumb','click','business_district','total_area','format'
    ,'renovation','rented_area','elevator','plot_ratio','parking_lot','delivery_time','price_range','property_fee','payment_method'
    ,'aboveground','underground','storey_height','clear_height','address','remarks'
        ,'status','attributes','location','project','area','offer','point','debt','phone'];

    //项目所属分类
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    //与标签多对多关联
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','article_tag','article_id','tag_id');
    }

    /*项目主图*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','thumb');
    }
    /*项目多图*/
    public function map()
    {
        return $this->hasMany('App\Models\Attachment', 'for_id', 'id')
            ->where('mark','article');
    }


}
