<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partner';
    protected $fillable = ['type','name','phone','contact_person','industry','email','wechat','mid','status'];

    /*保存申请*/
    public static function addOne($data)
    {
        return static :: create($data);
    }
    /*修改状态*/
    public static function up($ids,$data)
    {
        $is_partner = $data['status'] == 1 ? 1 : 0;
        foreach ($ids as $id){
            $mid = static :: where('id',$id)->value('mid');
            Member::where('id',$mid)->update(['is_partner'=>$is_partner]);
        }
        return static :: whereIn('id',$ids)->update($data);
    }

    //用户
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')
            ->select('id','name','nickname','avatar');
    }
}
