<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['phone','name','nickname','sex','city','id_number','password','avatar','avatar_local',
        'remember_token','open_id','union_id','friend_id','guide_id','identity','address','role'
        ,'is_partner','is_service','is_owner','is_propertyowner','is_manager'];

    //返回登录信息
    public static function getWxInfo($member){
        return [
            'mid'=>$member->id,
            'nickname'=>$member->nickname,
            'name'=>$member->name,
            'identity'=>$member->identity,
            'avatar'=>$member->avatar,
            'sex'=>$member->sex,
            'city'=>$member->city,
            'address'=>$member->address,
            'id_number'=>$member->id_number,
            'phone'=>$member->phone,
            'is_partner'=>$member->is_partner,
            'friend_id'=>$member->friend_id,
            'guide_id'=>$member->guide_id,
            'is_service'=>$member->is_service,
            'is_owner'=>$member->is_owner,
            'is_propertyowner'=>$member->is_propertyowner,
            'is_manager'=>$member->is_manager,
        ];
    }
    /*获取member*/
    public static function getOne($id)
    {
        $data = static::where('id',$id)
            ->select('id','phone','name','nickname','sex','city','id_number','avatar','friend_id','guide_id','identity','address','is_partner'
                ,'is_service','is_owner','is_propertyowner','is_manager')
            ->first();
        $data = static :: dataFormat($data);
        return $data;
    }
    /*获取我的用户列表*/
    public static function getMyUsers($mid,$limit)
    {
        return static :: where('friend_id',$mid)
            ->select('id','friend_id','name','phone','city','avatar')
            ->orderBy('id','desc')
            ->paginate($limit);
    }
    /*单条转换*/
    public static function dataFormat($data)
    {
        $identity_name = '';
        //$identity = '';
        $type = 1;
        if ($data->is_senior_partner == 1){
            $identity_name = '高级合伙人';
        }else{
            $vipcount = static :: where('friend_id',$data->id)->where('is_vip',1 )->count();
            $article = Article::where('mid',$data->id)->where('status',1)->count();
            if ($vipcount > 9 && $article > 0){
                $identity_name = '高级合伙人';
                $data->update(['is_senior_partner' => 1]);
                $type = 2;
            }else{
                //超级vip
                if ($data->is_vip == 1){
                    $identity_name = '超级vip';
                    $type = 2;
                }else{
                    $count = static :: where('friend_id',$data->id)->count();
                    if ($count > 9 && $article > 0){
                        $data->update(['is_vip' => 1]);
                        $identity_name = '超级vip';
                        $type = 2;
                    }
                }
            }
        }
       if ($data->is_service == 1){
           $identity_name .= ' 服务商';
           $type = 2;
       }
       if ($data->is_owner == 1){
           $identity_name .= ' 资方';
           $type = 2;
       }
       if ($data->is_propertyowner == 1){
           $identity_name .= ' 产权方';
           $type = 2;
       }
       if ($data->is_manager == 1){
            $identity_name .= '经纪人';
            $type = 3;
       }
       if (empty($identity_name)){
           if ($data->name && $data->phone && $data->phone ){
//               $identity_name .= '游客（已完善资料）';
               $identity_name .= '会员';
               $type = 2;
           }else{
               $identity_name .= '游客';
           }
       }
       $data->identity_name = $identity_name;
       $data->type = $type;
       return $data;
    }
    /*数组转换*/
    public static function datasFormat($data)
    {
        foreach ($data as $k => $v){
            $identity_name = '';
            $type = 1;
           if ($v['is_manager'] == 1){
               $identity_name .= '经纪人';
               $type = 3;
           }
           if ($v['is_service'] == 1){
               $identity_name .= ' 服务商';$type = 2;
           }
           if ($v['is_owner'] == 1){
               $identity_name .= ' 资方';$type = 2;
           }
           if ($v['is_propertyowner'] == 1){
               $identity_name .= ' 产权方';$type = 2;
           }
           if (empty($identity_name)){
               if ($v['name'] && $v['phone'] && $v['phone'] ){
                   $identity_name .= '会员';
                   $type = 2;
               }else{
                   $identity_name .= '游客';
               }
           }
            $data[$k]['identity_name'] = $identity_name;
            $data[$k]['type'] = $type;
        }
       return $data;
    }
    /*修改资料*/
    public static function updateInfo($mid,$data)
    {
        return static :: where('id',$mid)->update($data);
    }

    /*获取名片分享信息*/
    public static function getMyCard($mid)
    {
        return static :: where('id',$mid)
            ->select('phone','name','id')
            ->first();
    }
    /*获取随机头像*/
    public static function getRandomAvatars()
    {
        return static :: whereNotNull('avatar')->inRandomOrder()->limit(10)->pluck('avatar')->toArray();
    }
    /*获取头像*/
    public static function getAvatars($fid)
    {
        return static :: where('friend_id',$fid)->orderBy('id','desc')->limit(10)->pluck('avatar')->toArray();
    }

    /*资方*/
    public function management()
    {
        return $this->hasOne('App\Models\Management','mid','id');
    }
    /*团队*/
    public function guide()
    {
        return $this->hasOne('App\Models\Member','id','guide_id')
            ->select('id','name');

    }
    /*我的推荐人*/
    public function friend()
    {
        return $this->hasOne('App\Models\Member','id','friend_id')
            ->select('id','name','friend_id');
    }
    /*下一级人数*/
    public function friends()
    {
        return $this->hasMany('App\Models\Member','friend_id','id')
            ->select('id','friend_id','name');
    }


}
