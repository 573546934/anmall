<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $table = 'dictionary';
    protected $fillable = ['name','mark_name', 'key', 'value', 'mark'];

    //获取可以搜索的mark
    public static function getMarks()
    {
        return static :: select('mark','mark_name')
            ->groupBy('mark','mark_name')
            ->get()->toArray();
    }

    //获取对应键值对
    public static function keyValues($mark)
    {
        $data = static :: where('mark',$mark)
            ->get();
        $d = [];
        foreach ($data as $k=>$v){
            $d[] = [$v->key=>$v->value];
        }
        return $d;
    }

}
