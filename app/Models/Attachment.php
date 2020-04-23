<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OSS\Core\OssException;
use OSS\OssClient;

class Attachment extends Model
{
    //文件资源表
    protected $table = 'attachment';
    protected $fillable = ['for_id','name','save_name','save_path','size',
        'type','ext','enable'];
    //新增保存数据
    public  static function addsave($name,$save_name,$save_path,$size,$type,$ext,$url,$enable=0){
        return static::insertGetId([
            'name' => $name,
            'save_name' => $save_name,
            'save_path' => $save_path,
            'size' => $size,
            'type' => $type,
            'ext' => $ext,
            'enable' => $enable,
            'url' => $url,
        ]);
    }

    //删除图片文件和记录
    public  static function deleteImg($id){
         $att = static::find($id);
         if($att){
              $res = Storage::disk('public')->delete($att->save_path.'/'.$att->save_name);
             static::destroy($id);
                return $res;
         }else{
             return false;
         }
    }
    //删除多图
    public static function deleteImages($ids)
    {
        foreach ($ids as $id){
            static :: deleteImg($id);
        }

    }
    /*public  static function deleteImg($id){
        $image = static::find($id);
        if(!$image){
            return false;
        }
        $fileName = env('OSS_HOST','http://oss-southeast.gitgo.cn').'/'.$image->save_path.'/'.$image->save_name;
        $accessKeyId = env('ALIYUN_ACCESSKEYID','7QU2y13jlY0WeBCO');
        $accessKeySecret = env('ALIYUN_ACCESSKEYSECRET','gfWgqxPknqBV9IctNp52Qmc216YaLc');
        $bucket = env('ALIYUN_BUCKET','gitgo-main');
        $endpoint = env('ALIYUN_ENDPOINT','https://oss-ap-southeast-3.aliyuncs.com');
        try{
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $ossClient->deleteObject($bucket, $fileName);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return false;
        }
        $image->delete();
        return true;
    }*/
    //修改资源记录
    public static function updates($id,$data){
        return static::where('id',$id)
            ->update($data);
    }
    //链接推荐
    public function recommend()
    {
        return $this->hasMany('','','');
    }

    //更新图片
    public static function updel($older,$new,$mark)
    {
        if($older != $new)
        {
            //删除老图
            if($older > 0){
                Attachment::deleteImg($older);
            }
            //绑定新图
            Attachment::updates($new,['mark'=>$mark,'enable'=>1]);
        }
    }



}
