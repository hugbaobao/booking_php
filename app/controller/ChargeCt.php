<?php

namespace app\controller;

use app\BaseController;
use app\model\Charge;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class ChargeCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }
}
