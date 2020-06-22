<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class WechatPublicController extends Controller {
	//获取Token
	public function getToken(){
		$token = Cache::get('wechat_public_cache:token');
		if(!empty($token)){
			return $token;
		}else{
			$tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_PUBLIC_APPID')."&secret=".env('WECHAT_PUBLIC_APPSECRET');
			$result = json_decode(file_get_contents($tokenUrl),1);
			Cache::put('wechat_public_cache:token', $result['access_token'], ($result['expires_in']/65));
			return $result['access_token'];
		}
	}


	public function postData($url,$data){
		if(is_array($data)){
			$data = json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($data)
		));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}