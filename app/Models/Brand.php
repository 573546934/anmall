<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //品牌机构
    protected $table = 'brand';
    protected $fillable = ['company_name','logo','company_type','city','sort','bgm'];

    /*机构logo*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','logo')->select('id','url');
    }
    /*机构bgm*/
    public function bgms()
    {
        return $this->hasOne('App\Models\Attachment','id','bgm')->select('id','url');
    }
    //关联
    public function recommend()
    {
        return $this->hasMany('App\Models\Recommend','for_id','id')
            ->where('for_mark','brand');
    }
    //关联项目
    public function articles()
    {
        return $this->hasMany('App\Models\Recommend','for_id','id')
            ->with('article')
            ->where('for_mark','brand');
    }
}
