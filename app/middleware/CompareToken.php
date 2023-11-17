<?php

namespace app\middleware;

use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class CompareToken
{
    public function handle($request, \Closure $next)
    {
        // 浏览器跨域验证排除
        if($request->method() === 'OPTIONS'){
            return $next($request);
        }
        // 获取请求头header中的authorization（token值）
        $token = request()->header('Authorization');
        // 去除token值中的bearer+空格标识
        $token = str_replace('Bearer ', '', $token);
        // return response($token);
        if (!$token) {
            // abort终止操作，返回结果
            abort(json(['message' => 'token缺失，请重新登录', 'code' => 600], $httpCode = 600));
        }
        // key必须与生成token值得字符串相同
        $key = 'aslfjhasgjgja';
        // $kid = 'mykidforchatgpt';
        try {
            JWT::$leeway = 60; //当前时间减去60，把时间留点余地用于后面的操作
            $decoded = JWT::decode($token, new Key($key, 'HS256')); //HS256方式，这里要和签发的时候对应
            //$decoded = JWT::decode($token, $key, array('HS256'); //HS256方式，这里要和签发的时候对应
            // 解析过程中如果出现不对的情况就利用下方catch方法，利用jwt解析问题返回错误信息

        } catch (\Firebase\JWT\SignatureInvalidException $e) { // token不正确
            abort(json(['message' => 'token不正确，请重新登录', 'code' => 601], $httpCode = 601));
        } catch (\Firebase\JWT\BeforeValidException $e) { // token过了之前设置的两天期限
            abort(json(['message' => 'token已过期，请重新登录', 'code' => 602], $httpCode = 602));
        } catch (\Firebase\JWT\ExpiredException $e) { // token过期
            abort(json(['message' => 'token已过期，请重新登录', 'code' => 603], $httpCode = 603));
        } catch (Exception $e) { //其他错误
            //abort(json(['message' => '未知错误，请重新登录', 'code' => 604, 'data' => $e->getMessage()], $httpCode = 604));
            abort(json(['message' => '未知错误，请重新登录', 'code' => 604, 'data' => $request->method()], $httpCode = 604));
        }

        // 转到下一个中间件
        return $next($request);
    }
}
