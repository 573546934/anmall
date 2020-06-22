<?php

namespace App\Http\Middleware;

use Closure;

class ApiMiddleware
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
        if ($request->header('api-token') != env('API_TOKEN')){
            $result = array(
                'message' => "接口不存在"
            );
            return response($result,401);
        }
        return $next($request);
    }
}
