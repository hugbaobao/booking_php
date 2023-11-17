<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class UserCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 获取用户
    public function getUser()
    {
        $data = User::select();
        return ressend(200, '获取成功', $data);
    }

    // 根据openid获取用户
    public function getUserByOpenid()
    {
        $openid = request()->param('openid');
        $data = User::where('openid', $openid)->with(['Receive' => function ($query) {
            $query->with('Coupon');
        }])->find();
        return ressend(200, '获取成功', $data);
    }

    // 新增用户
    public function addUser()
    {
        $data = request()->param();
        $data['openid'] = $data['openid'];
        $data['phone'] = $data['phone'];
        $data['name'] = '微信用户';
        $data['creattime'] = date('Y-m-d');
        $res = User::create($data);
        if ($res) {
            return ressend(200, '新增成功', $res);
        } else {
            return ressend(400, '新增失败');
        }
    }

    // 修改用户信息
    public function updateUser()
    {
        $openid = request()->param('openid');
        $data = request()->param('data');
        $user = User::where('openid', $openid)->find();
        $user->address = $data['address'];
        $user->phone = $data['phone'];
        $user->name = $data['name'];
        $user->sex = $data['sex'];
        $res = $user->save();
        if ($res) {
            return ressend(200, '修改成功', $res);
        } else {
            return ressend(400, '修改失败');
        }
    }

    // 保存idcard和idcardtype两个字段内容
    public function saveIdcard()
    {
        $openid = request()->param('openid');
        $data = request()->param('data');
        $user = User::where('openid', $openid)->find();
        $user->idcard = $data['idcard'];
        $user->idcardtype = $data['idcardtype'];
        $user->name = $data['name'];
        $res = $user->save();
        if ($res) {
            return ressend(200, '修改成功', $res);
        } else {
            return ressend(400, '修改失败');
        }
    }

    // 修改会员状态
    public function changeVip()
    {
        $openid = request()->param('openid');
        $sum = 50;
        $user = User::where('openid', $openid)->find();
        $user->vip = 1;
        $user->integral = $user->integral + $sum;
        $res = $user->save();
        if ($res) {
            // 积分增加50
            $user->Integral()->save([
                'uid' => $openid,
                'name' => '会员注册赠送',
                'count' => $sum,
                'creattime' => date('Y-m-d H:i:s'),
                'type' => 0
            ]);
            return ressend(200, '修改成功', $res);
        } else {
            return ressend(400, '修改失败');
        }
    }
}
