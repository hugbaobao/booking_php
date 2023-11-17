<?php
/**
* 应用层全局缓存中间件 
* 
* @author 惆怅客 
* @since  2023-04-03
*/ 
namespace app\middleware;

use think\facade\Cache;
use think\Request;
use think\Response;

class CacheMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        // 拼接缓存key
        $cacheKey = 'page_cache_' . md5($request->url());

        // 如果缓存存在，直接返回缓存内容
        if (Cache::get($cacheKey)) {
            return Response::create(Cache::get($cacheKey))->header([
                'Cache-Control' => 'max-age=600',
                'from-cache'    => true
            ]);
        }

        // 执行下一个中间件或者请求
        $response = $next($request);

        // 缓存响应内容
        Cache::set($cacheKey, $response->getContent(), 10);
        // Cache::set($cacheKey, $response->getContent(), 3600*24);

        return $response;
    }
}