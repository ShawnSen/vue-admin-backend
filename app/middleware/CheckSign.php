<?php
declare (strict_types = 1);

namespace app\middleware;

use app\utils\JwtUtil;

class CheckSign
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return \think\response\Json
     */
    public function handle($request, \Closure $next)
    {
        if (!in_array(request()->controller(), ['Login'])) { // 对登录控制器放行
            $token = request()->header('X-token');  // 前端请求携带的Token信息
            $jwt = JwtUtil::verification('test', $token); // 与签发的key一致
            if ($jwt->getData()['code'] == 20000) {
                $request->uid = $jwt->getData()['data']->data->uid; // 传入登录用户ID
                $request->role_key = $jwt->getData()['data']->data->role; // 传入登录用户角色组key
            } else {
                return $jwt;
            }
        }
        return $next($request);
    }
}
