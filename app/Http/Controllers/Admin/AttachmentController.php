<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    //文件资源类管理
    //图片上传
    public function uploadImg(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 2;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //图片名称
            $name = $file -> getClientOriginalName();
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            $size = $file->getClientSize();
            if ($size > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $save_path = date('Y-m-d');
        $save_name = time()."_".uniqid().".".$file->getClientOriginalExtension();
        $newFile = $save_path."/".$save_name;
        $disk = Storage::disk('public');  //保存
        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        $url = '/uploads/image/'.$newFile;
        if($res){
            //保存资源到数据库
            $mark = $request->get('mark',false); //资源类型
            if($mark == 'public'){ //公共图片库 无指定绑定 多用途
                $attachment_id =  Attachment::insertGetId([
                    'name' => $name,
                    'save_name' => $save_name,
                    'save_path' => $save_path,
                    'size' => $size,
                    'type' => 'image',
                    'ext' => $ext,
                    'enable' => 1,
                    'url' => $url,
                    'mark' => 'public'
                ]);
            }else{  //其他图片
                $attachment_id =  Attachment::addsave($name,$save_name,$save_path,$size,'image',$ext,$url);
            }
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $newFile,
                //'url'   => $url = Storage::url($newFile)
                'url'   => $attachment_id //返回图片id用于绑定等
            ];

        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);

    }
    //多图片上传 一次一张
    public function uploadImgs(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 2;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //图片名称
            $name = $file -> getClientOriginalName();
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            $size = $file->getClientSize();
            if ($size > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $save_path = date('Y-m-d');
        $save_name = time()."_".uniqid().".".$file->getClientOriginalExtension();
        $newFile = $save_path."/".$save_name;
        $disk = Storage::disk('public');
        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        $url = '/uploads/image/'.$newFile;
        if($res){
            //保存资源数据库字段
            $type = $request->get('type'); //资源类型
            $attachment_id =  Attachment::addsave($name,$save_name,$save_path,$size,'image',$ext,$url);
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $newFile,
                'url'   => $url,
                'id'   => $attachment_id
            ];

        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);

    }
    //图片删除
    public function deleteImg($id)
    {
        $res = Attachment::deleteImg($id);
        if($res){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'数据有误']);
        }
    }
    //视频上传
    public function uploadVideo(Request $request)
    {
        //上传文件最大大小,单位M
        $maxSize = 50;
        //支持的上传类型
        $allowed_extensions = ["rm", "rmvb", "mpeg1","mov","mtv","dat","wmv","avi","3gp","amv","dmv","flv","mp4"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //文件名称
            $name = $file -> getClientOriginalName();
            //检测文件类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的文件";
                return response()->json($data);
            }
            //检测文件大小
            $size = $file->getClientSize();
            if ($size > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }
        $save_path = date('Y-m-d');
        $save_name = time()."_".uniqid().".".$file->getClientOriginalExtension();
        $newFile = $save_path."/".$save_name;
        $disk = Storage::disk('oss');
        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        if($res){
            //保存资源数据库字段
            $type = $request->get('type'); //资源类型
            $attachment_id =  Attachment::addsave($name,$save_name,$save_path,$size,'video',$ext,Storage::url($newFile));
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $newFile,
                'url'   => $url =$disk->url($newFile)
            ];

        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);

    }

    public function index()
    {
        return view('admin.attachment.index');
    }
    public  function data(Request $request)
    {

        $model = Attachment::query();
        //类型搜索
        if ($request->get('mark')){
            $model = $model->where('mark','like','%'.$request->get('mark').'%');
        }
        //绑定id搜索
        if ($request->get('for_id')){
            $model = $model->where('for_id',$request->get('for_id'));
        }
        //id搜索
        if ($request->get('id')){
            $model = $model->where('id',$request->get('id'));
        }

        $res = $model->where('enable',1)
            ->whereNotIn('mark',['order_voucher','driver','passport'])
            ->orderBy('id','desc')
            ->paginate($request->get('limit',20))->toArray();
        if($res['data']){
            foreach ($res['data'] as $k=>$v){
                $res['data'][$k]['url'] = getImage($v);
            }
        }
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
}