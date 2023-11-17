<?php

namespace app\controller;

use app\BaseController;
use app\model\Receive;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class ReceiveCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 领取优惠券
    public function addReceive()
    {
        $data = request()->param();
        $data['code'] = $data['code'];
        $data['count'] = 1;
        $data['uid'] = $data['openid'];
        $data['used'] = 0;
        $res = Receive::create($data);
        if ($res) {
            return ressend(200, '领取成功', $res);
        } else {
            return ressend(400, '领取失败');
        }
    }

    // 根据uid获取所有优惠券
    public function getReceiveByUid()
    {
        $uid = request()->param('openid');
        $data = Receive::where('uid', $uid)->with('Coupon')->select();
        return ressend(200, '获取成功', $data);
    }

    // 改变优惠券状态
    public function changeReceive()
    {
        $id = request()->param('id');
        $data = Receive::where('id', $id)->find();
        $data->used = 1;
        $data->save();
        return ressend(200, '修改成功', $data);
    }
}
