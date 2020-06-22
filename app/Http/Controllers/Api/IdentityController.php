<?php

namespace App\Http\Controllers\Api;

use App\Models\CaseList;
use App\Models\IdentityApplication;
use App\Models\Management;
use App\Models\Manager;
use App\Models\Owner;
use App\Models\PropertyOwner;
use App\Models\Service;
use App\Models\ServiceCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdentityController extends Controller
{
    //用户身份认证

    /**
     * 验证认证身份是否已提交
     *
     * */
    public function isIdentity(Request $request)
    {
        $mid = $request->get('mid_params');
        $type = $request->get('type');
        if ($type == 'manager'){
            if (Manager::where(['mid'=>$mid])->first()){
                return response(['message'=>'资料已提交，平台审核中']);
            }
        }else if($type == 'service'){
            if (Service::where(['mid'=>$mid])->first()){
                return response(['message'=>'资料已提交，平台审核中']);
            }
        }else if($type == 'propertyowner'){
            if (PropertyOwner::where(['mid'=>$mid])->first()){
                return response(['message'=>'资料已提交，平台审核中']);
            }
        }else if($type == 'owner'){
            if (Owner::where(['mid'=>$mid])->first()){
                return response(['message'=>'资料已提交，平台审核中']);
            }
        }
        return  apiResult(1,'');

    }
    /**
     * 申请认证经纪人
     * @name manager
     * @method post
     * @return json
     * */
    public function addManager(Request $request)
    {
        $mid = $request->get('mid_params');
        //经纪人
        $data = $request->only('name','email','id_num','id_img_pos','id_img_rev','sex','city','email','avatar','company_name','department','job','card');
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }

        if (Manager::where(['mid'=>$mid])->first()){
            return response(['message'=>'资料已提交，平台审核中'],400);
        }
        $data['mid'] = $mid;
        $res = Manager::addOne($data);
        return apiResult($res,'申请经纪人');
    }
    /**
     * 申请资方
     * @name owner
     * @method post
     * @param array data
     * @return json result
     * */
    public function addOwner(Request $request)
    {

        $data = $request->only('type','company_name','company_city','reg_capital','company_web','company_license','name','sex','phone','city','company_nickname','email','job','card');
        $mid = $request->get('mid_params');
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }
        /*if (Owner::where(['mid'=>$mid])->first()){
            return response(['message'=>'资料已提交，平台审核中'],400);
        }*/
        $data['mid'] = $mid;
        $res = Owner::addOne($data);
        return apiResult($res,'申请资方');

    }
    /**
     * 申请产权方
     * @name propertyowner
     * @method post
     * @param array data
     * @return json result
     * */
    public function addPropertyOwner(Request $request)
    {
        $data = $request->only('type','company_name','company_city','reg_capital','company_web','company_license','name','sex','phone','city','company_nickname','email','job','card'
            ,'team_name',' team_detail','team_img','features','features_img','awards','awards_img','logo');
        $mid = $request->get('mid_params');
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }
        /*if (PropertyOwner::where(['mid'=>$mid])->first()){
            return response(['message'=>'资料已提交，平台审核中'],400);
        }*/
        $data['mid'] = $mid;
        $res = PropertyOwner::addOne($data);
        return apiResult($res,'申请产权方');
    }
    /**
     * 申请服务商
     * @name service
     * @method post
     * @param array data
     * @return json result
     * */
    public function addService(Request $request)
    {
        $data = $request->only('company_name','scale','company_city','reg_capital','company_web','type','company_license',
            'description','business','introduction', 'name','sex','phone','city','company_nickname','job','card','logo','bgm');
        $mid = $request->get('mid_params');
        //身份证
        if ($request->get('id_img')){
            $id_img = $request->get('id_img');
            $data['id_img_pos'] = isset($id_img[0]) ? $id_img[0] : null;
            $data['id_img_rev'] = isset($id_img[1]) ? $id_img[1] : null;
        }
       /* if (Service::where(['mid'=>$mid])->first()){
            return response(['message'=>'资料已提交，平台审核中'],400);
        }*/
        $data['mid'] = $mid;
        $res = Service::addOne($data);
        //保存案例
        /*if ($res && $request->has('case')){
            $cases = $request->get('case');
            foreach ($cases as $case){
                $case['service_id'] = $res;
                ServiceCase::addOne($case);
            }
        }*/
        return apiResult($res,'申请服务商请求');
    }

    /*
     *  服务商主营业务
     * */
    public function getBusiness(Request $request)
    {
        $data = Service::getBusiness();
        return apiResult(1,'获取服务商主营业务',$data);
    }

    /*获取服务商列表*/
    public function getServices(Request $request)
    {
        $model = Service::with('logoimg');
        if ($request->has('company_city')){
            $model = $model->where('company_city','like','%'.$request->get('company_city'));
        }
        if ($request->has('business')){
            $model = $model->where('business','like','%'.$request->get('business'));
        }
        if ($request->has('company_name')){
            $model = $model->where('company_name','like','%'.$request->get('company_name'));
        }
        $data = $model -> select('id','company_name','company_city','logo','business','description')
        ->orderBy('created_at','desc')
        ->paginate($request->get('limit',10));
       /* $data['city_array'] = Service::getCitys();
        $data['business_array'] = Service::getBusiness();*/
        return apiResult(1,'获取服务商',$data);
    }
    /*获取服务商*/
    public function getService(Request $request)
    {
        $id = $request->get('id');
        $model = Service::with('logoimg','bgmimg','cardimg');
        $data = $model
            ->where('id',$id)
            ->first();
        return apiResult(1,'获取服务商',$data);
    }
    /*获取产权方列表*/
    public function getPropertyOwners(Request $request)
    {
        $model = PropertyOwner::with([/*'teamimg','featuresimg','awardsimg',*/'logoimg'])->where('status',1);
        if ($request->has('company_city')){
            $model = $model->where('company_city','like','%'.$request->get('company_city'));
        }
        if ($request->has('company_name')){
            $model = $model->where('company_name','like','%'.$request->get('company_name'));
        }
        $data = $model -> select('id','mid','company_name','company_city','phone','job','logo'
            /*,'team_name','team_detail','team_img','features','features_img','awards','awards_img'*/)
            ->orderBy('created_at','desc')
            ->paginate($request->get('limit',10));
        return apiResult(1,'获取产权方列表',$data);
    }
    /*获取产权方*/
    public function getPropertyOwner(Request $request)
    {
        $id = $request->get('id');
        $model = PropertyOwner::with(['teamimg','featuresimg','awardsimg','logoimg']);
        $data = $model
            ->where('id',$id)
            ->first();
        return apiResult(1,'获取产权方',$data);
    }


}
