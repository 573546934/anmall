<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    //需求
    protected $table = 'demand';
    protected $fillable = ['id','mid','status','type','telname','phone','country','city','price','area','assets_type','other','reason'];

    /*
     * 添加数据
     * */
    public static function addOne($data)
    {
        return static :: create($data);
    }
    /*修改状态*/
    public static function up($ids,$data)
    {
        return static :: whereIn('id',$ids)->update($data);
    }
    /*
     * 需求表字段映射转换
     * */
    public static function formatList($data)
    {
        if (!empty($data)){
            foreach ($data as $k => $v){
                if (isset($v['type'])){
                    if ($v['area'] > 0){
                        $data[$k]['area'] = $v['area'].'㎡';
                    }
                    if ($v['area'] == 0){
                        $data[$k]['area'] = '面议';
                    }
                    if ($v['price'] == 0){
                        $data[$k]['price'] = '面议';
                    }
                    switch ($v['type']) {
                        case 'rent' :
                            $data[$k]['type_name'] = '出租';
                            if ($v['price'] > 0){
                                $data[$k]['price'] = $v['price'].'元/天/㎡';
                            }
                        break;
                        case 'tenant' :
                            $data[$k]['type_name'] = '求租';
                            if ($v['price'] > 0){
                                $data[$k]['price'] = $v['price'].'元/天/㎡';
                            }
                        break;
                        case 'buy' :
                            $data[$k]['type_name'] = '想买';
                            if ($v['price'] > 0){
                                $data[$k]['price'] = $v['price'].'万元';
                            }
                        break;
                        case 'sell' :
                            $data[$k]['type_name'] = '想卖';
                            if ($v['price'] > 0){
                                $data[$k]['price'] = $v['price'].'万元';
                            }
                        break;
                    }
                }
            }
        }
        return $data;
    }

    //用户
    public function member()
    {
        return $this->hasOne('App\Models\Member','id','mid')->select('id','name','nickname');
    }
}
