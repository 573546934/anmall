<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    //客服
    protected $table = 'customer_service';
    protected $fillable = ['score','name','position','phone','introduction','avatar'];

    //头像
    public function img()
    {
        return $this->hasOne('App\Models\Attachment','id','avatar')->select('id','url');
    }
}
