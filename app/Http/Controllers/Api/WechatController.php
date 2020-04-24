<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Member;
class WechatController extends Controller
{
	private function sessionUrl($jscode){
		return "https://api.weixin.qq.com/sns/jscode2session?appid=".env('WECHAT_XCX_APPID')."&secret=".env('WECHAT_XCX_APPSECRET')."&js_code=".$jscode."&grant_type=authorization_code";
	}
	//用户登录返回token
	public function getOpenid(Request $request){
		$jscode = $request->code;
		$guideId = $request->guideId;
		$friendId = $request->friendId;
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
			if(isset($wxSession['unionid'])){
				$newMember['union_id'] = $wxSession['unionid'];
			}
			$member = new Member($newMember);

		}else if(isset($wxSession['unionid']) && !$member->union_id){
			// 用户没有union_id
			Member::where('open_id',$wxSession['openid'])->update(['union_id'=>$wxSession['unionid']]);
		}
        Redis::setex('member_token_cache:wechat:'.$memberToken,10800,$member->id);
        //返回信息
		$result = array(
			'memberToken'=>$memberToken,
			'member'=>Member::getWxInfo($member),
		);
		return response($result);
	}

}