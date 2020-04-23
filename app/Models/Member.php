<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['phone','name','password','avatar','remember_token','open_id','union_id','friend_id','identity','address','role'];


}
