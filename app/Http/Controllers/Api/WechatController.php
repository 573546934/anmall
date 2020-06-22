<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Models\Member;
class WechatController extends Controller
{
	private function sessionUrl($jscode){
		return "https://api.weixin.qq.com/sns/jscode2session?appid=".env('WECHAT_XCX_APPID')."&secret=".env('WECHAT_XCX_APPSECRET')."&js_code=".$jscode."&grant_type=authorization_code";
	}
	//用户登录返回token
	public function getOpenid(Request $request){
		$jscode = $request->get('code');
		$url = $this->sessionUrl($jscode);
		$wxSession = json_decode(file_get_contents($url),1);
		if(isset($wxSession['errcode']) && $wxSession['errcode'] > "0"){
			$result = array( 'message' => "登录失败".$wxSession['errcode'] );
            return response($result,400);
		}

		$memberToken = md5(time().$jscode);
		$member = Member::where('open_id',$wxSession['openid'])->first();
		if(!$member){
			//用户第一次进入小程序
            $friendId = $request->get('friendId',0);
            //$guideId = getGuideId($friendId,$request->get('guideId',0));
            $guideId = $request->get('guideId',0);
			$newMember = array(
				'open_id'=>$wxSession['openid'],
				'created_at'=>date("Y-m-d H:i:s"),
				'guide_id'=>$guideId,
				'friend_id'=>$friendId
			);
			if(isset($wxSession['unionid'])){
				$newMember['union_id'] = $wxSession['unionid'];
			}
			//$memberId = Member::insertGetId($newMember);
			$member = new Member($newMember);
			$member->save();
		}else if(isset($wxSession['unionid']) && !$member->union_id){
			// 用户没有union_id
			Member::where('open_id',$wxSession['openid'])->update(['union_id'=>$wxSession['unionid']]);
		}
        Redis::setex('member_token_cache:wechat:'.$memberToken,108000,$member->id);
        //返回信息
		$result = array(
			'memberToken'=>$memberToken,
			'member'=>Member::getOne($member->id),
			'message'=>'登录成功',
		);
		return response($result);
	}

	/*
	 * 获取推荐码
	 * */
	public function getQrCode(Request $request)
    {
        $mid = $request->get('mid_params');
        $member = Member::find($mid);
        if (empty($member->avatar_local) && !empty($member->avatar)){
            $avatar = $this->getAvatar($member->avatar,$mid);
        }else{
            $avatar = $member->avatar_local;
        }
        if (empty($avatar)){
            $avatar = '/images/user.png';
        }
        $guide_id = $member->guide_id ? : 0;
        $path = $request->get('path','pages/index/index');
        $id = $request->get('id',0);
        $qrcode = $this->getUnlimited($path,$id,$guide_id,$mid);
        $data['qrcode'] = '/'.$qrcode;
        $data['name'] = $member->name;
        $data['phone'] = $member->phone;
        $data['avatar'] = '/'.$avatar;
        $data['bgimg'] =   Advert::getBgm('名片背景');
        /*if (empty( $data['name'])||empty( $data['phone'])||empty( $data['avatar'])){
            return response(['message'=>'请先去个人中心完善资料!'],400);
        }*/
        return apiResult(1,'获取二维码',$data);
    }

    // 获取项目分享小程序码
    public function getShare(Request $request){
        $mid = $request->get('mid_params');
        $id = $request->get('id',1);
        $member = Member::find($mid);
        if (empty($member->avatar_local) && !empty($member->avatar)){
            $avatar = $this->getAvatar($member->avatar,$mid);
        }else{
            $avatar = $member->avatar_local;
        }
        if (empty($avatar)){
            $avatar = '/images/user.png';
        }
        $guide_id = $member->guide_id ? : 0;
        $path = $request->get('path','pages/index/index');
        $qrcode = $this->getUnlimited($path,$id,$guide_id,$mid);
        $data['qrcode'] = '/'.$qrcode;
        $data['name'] = $member->name;
        $data['phone'] = $member->phone;
        $data['avatar'] = '/'.$avatar;
        /*if (empty( $data['name'])||empty( $data['phone'])||empty( $data['avatar'])){
            return response(['message'=>'请先去个人中心完善资料!'],400);
        }*/
        return apiResult(1,'获取二维码',$data);
    }
    //删除本地二维码文件
    public function delQrcode(Request $request)
    {
        $path = $request->get('qrcode');
        $arr = explode('qrcode/',$path);
        $p = 'uploads/qrcode/'.$arr[1];
        @unlink($p);
        return apiResult(1,'删除图片');
    }
	//获取微信小程序凭证
    public function getToken(){
        $token = Cache::get('wechat_public_cache:token');
        if(!empty($token)){
            return $token;
        }else{
            $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_XCX_APPID')."&secret=".env('WECHAT_XCX_APPSECRET');
            $result = json_decode(file_get_contents($tokenUrl),1);
            Cache::put('wechat_public_cache:token', $result['access_token'], ($result['expires_in']/65));
            return $result['access_token'];
        }
    }

    //获取小程序二维码无限次数
    public function getUnlimited($path,$id,$guide_id,$mid)
    {
        $scene = 'id='.$id.'&friend_id='.$mid.'&guide_id='.$guide_id;
        $access_token = $this->getToken();
        $data['scene'] = $scene;
        $data['width'] = 280;
        $data['is_hyaline'] = true;
        if(!empty($path)){
            $data['page'] = $path;
        }
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;
        //POST参数
        $result = $this->httpRequest( $url, $data,"POST");
        //生成二维码
        $qrcode = 'uploads/qrcode/'.time().rand(1000,10000).'.png';
        file_put_contents($qrcode, $result);
        return $qrcode;
    }
    //获取分享专用二维码
    public function getwxcode($path,$id,$guide_id,$mid)
    {
        $postUrl = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$this->getToken();
        $d = array(
            'path'=>$path.'?id='.$id.'&guide_id='.intval($guide_id).'&friend_id='.$mid,
            'width'=>100,
            'line_color'=> array("r"=>0,"g"=>0,"b"=>0),
            'is_hyaline'=>true
        );
        $result = $this->httpRequest($postUrl,$d,'POST');
        //生成二维码
        $qrcode = 'uploads/qrcode/'.time().rand(1000,10000).'.png';
        file_put_contents($qrcode, $result);
        return $qrcode;
    }

    function httpRequest($url, $data='', $method='POST'){
        if(is_array($data)){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if($method=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /*微信头像保存本地*/
    public function getAvatar($url,$mid)
    {
        $img_file = file_get_contents($url);  $img_content= base64_encode($img_file);
        $type = 'png';//得到图片类型png?jpg?gif? $new_file = "./cs/cs.{$type}";
        $new_file = 'uploads/avatar/'.time().rand(1000,10000).'.png';
        if (file_put_contents($new_file, base64_decode($img_content)))
        {
            Member::where("id",$mid)->update(['avatar_local'=>$new_file]);
            return $new_file;
        }
        return '';
    }

}

