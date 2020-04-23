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
        $member_token =$request->header('member-token');
        if (empty($member_token)){
            $result = array(
                'message' => "无权限"
            );
            return response($result,404);
        }
        $m = Redis::get('member_token_cache:wechat:'.$member_token);
        if (!$m || empty($m)){
            $result = array(
                'message' => "无权限"
            );
            return response($result,404);
        }
        return $next($request);
    }
}
