<?php

namespace app\controller;

use app\BaseController;
use app\model\Integral;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class IntegralCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 根据openid获取用户积分
    public function getIntegralByOpenid()
    {
        $openid = request()->param('openid');
        $data = Integral::where('uid', $openid)->select();
        return ressend(200, '获取成功', $data);
    }
}
