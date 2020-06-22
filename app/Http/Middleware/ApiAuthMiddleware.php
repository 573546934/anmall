<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*$member_token =$request->header('member-token');
        if (empty($member_token)){
            $result = array(
                'message' => "无权限"
            );
            return response($result,404);
        }
        $m = Redis::get('member_token_cache:wechat:'.$member_token);
        if (!$m || empty($m)){
            $result = array(
                'message' => "登录超时!请重新登录"
            );
            return response($result,404);
        }
        $mid_params = ['mid_params'=>$m];*/
        $mid_params = ['mid_params'=>1];
        $request->attributes->add($mid_params);//添加参数 用户id //获取$mid = $request->get('mid_params');//中间件产生的参数
        return $next($request);
    }
}
