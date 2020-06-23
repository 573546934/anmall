<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLikes extends Model
{
    protected $table = 'article_likes';
    protected $fillable = ['mid','article_id','num','fid'];

    //统计访问量
    public static function addOne($mid,$aid,$fid = 0)
    {
        $model = static :: where(['mid'=>$mid,'article_id'=>$aid,'fid'=>$fid])->first();
        if ($model){
            return $model->increment('num');
        }else{
            return static :: create([
                'mid'=>$mid,
                'fid'=>$fid,
                'article_id'=>$aid,
                'num'=>1,
            ]);
        }
    }

    //获取项目关注统计数据
    public static function getAttentions($aid,$fid)
    {
        //总关注数
        $data['attentions'] = static :: where('article_id',$aid)->sum('num');
        //我的分享数
        $data['my_share'] = static :: where('article_id',$aid)->where('fid',$fid)->sum('num');
        //头像
        // $data['avatars'] = Member::getAvatars($fid);
        //获取关注人员头像
        $mids = static :: where('article_id',$aid)->groupBy('mid')->pluck('mid')->toArray();
        $data['avatars'] = Member::whereIn('id',$mids)->whereNotNull('avatar')->inRandomOrder()->orderBy('id','desc')->limit(10)->pluck('avatar')->toArray();

        return $data;
    }

    //访问用户
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid');
    }
    //分享用户
    public function friend()
    {
        return $this->hasOne('App\Models\Member','id','fid');
    }
    //项目
    public function article()
    {
        return $this->hasOne('App\Models\Article','id','article_id');
    }
}
