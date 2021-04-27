<?php
declare (strict_types = 1);

namespace app\utils;


use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

class JwtUtil
{
    /**
     * 证书签发
     * @param int $uid 用户id
     * @param string $role_key 角色组key
     * @return string
     */
    public static function issue($uid, $role_key)
    {
        $key = 'test';         // 签名密钥
        $time = time();    // 签发时间
        $token = [
            'iss' => '',   // 签发者
            'aud' => '',   // 接收方
            'iat' => $time, // 签发时间
            'nbf' => $time, // 签名生效时间
            'exp' => $time + 7200, // 签名有效时间（3600 * x）x小时
            'data' => [     // 用户信息
                'uid' => $uid,  // 用户ID
                'role' => $role_key  // 用户角色组key
            ]
        ];
        $jwt = JWT::encode($token, $key);  // 根据token签发证书
        return $jwt;
    }

    /**
     * 解析签名，按issue中的token格式返回
     * @param $key
     * @param $jwt
     * @return \think\response\Json
     */
    public static function verification($key, $jwt)
    {
        try {
            JWT::$leeway = 60;  // 当前时间减去60， 时间回旋余地
            $jwt = JWT::decode($jwt, $key, ['HS256']);  // 解析证书
            return success($jwt, 'success', 20000);
        } catch (SignatureInvalidException $e) {   // 签名不正确
            return error($e->getMessage());
        } catch (BeforeValidException $e) {        // 当前签名还不能使用，和签发时生效时间对应
            return error($e->getMessage());
        } catch (ExpiredException $e) {            // 签名已过期
            return error($e->getMessage());
        } catch (\Exception $e) {                  // 其他错误
            return error($e->getMessage());
        }
    }
}
