<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $fillable = ['nickname','name','email','position','city','capital','website','logo','type','label','description'];

    /*资方申请资料保存*/
    /*资方申请单案列*/
    public function caseList()
    {
        return $this->hasMany('App\Models\CaseList','management_id','id');
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
