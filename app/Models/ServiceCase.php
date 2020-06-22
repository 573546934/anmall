<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCase extends Model
{
    //服务商案例
    protected $table = 'service_case';
    protected $fillable = ['service_id','img','description','title'];

    /*服务商案例保存*/
    public static function addOne($data)
    {
        $data['created_at'] = date('Y-m-d h:i');
        return static :: insertGetId($data);
    }
    /*图片*/
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','img')->select('id','url');
    }
}
