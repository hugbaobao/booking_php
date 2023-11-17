<?php

namespace app\controller;

use app\BaseController;
use app\model\Png;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class PngCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 获取
    public function getPng()
    {
        $data = Png::select();
        return ressend(200, '获取成功', $data);
    }


    // 修改图片
    public function editPng()
    {
        $req = request()->param();
        $shop = Png::find(1);
        $shop->{$req['key']} = $req['val'];
        $result = $shop->save();
        if ($result) {
            initPathStr($req['olddress']);
            return ressend(200, '修改成功', $result);
        } else {
            return ressend(201, '修改失败', $result);
        }
    }
}
