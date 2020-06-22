<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    //关联推荐
    protected $table = 'recommend';
    protected $fillable = ['for_id','for_mark','item_id','item_mark'];
    public $timestamps = false;
    //增加单个项目关联
    public static function addArticle($for_id,$for_mark,$item_id){
        return static :: Insert([
            'for_id'=>$for_id,
            'for_mark'=>$for_mark,
            'item_id'=>$item_id,
            'item_mark'=>'article',
        ]);
    }
    //添加多个项目关联
    public static function addArticles($item_ids,$for_id,$for_mark)
    {
        $recArr = [];
        //新绑定行程数据整理
        foreach ($item_ids as $item_id){
            $recArr[] = [
                'for_id'=>$for_id,
                'for_mark'=>$for_mark,
                'item_id'=>$item_id,
                'item_mark'=>'article',
            ];
        }
        return static::Insert($recArr);
    }
    //删除 绑定项目
    public static function delArticle($for_id,$for_mark)
    {
        return static :: where('for_id',$for_id)->where('for_mark',$for_mark)->where('item_mark','article')->delete();
    }
    //关联附表 --项目
    public function article()
    {
        return $this->hasOne('App\Models\Article','id','item_id')
            ->with('img','category','tags');
    }

}
