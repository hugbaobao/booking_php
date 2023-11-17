<?php

namespace app\controller;

use app\BaseController;
use app\model\Order;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class OrderCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 添加订单
    public function addOrder()
    {
        $req = request()->param();
        $data['uid'] = $req['openid'];
        $data['orderid'] = $req['orderid'];
        $data['price'] = $req['price'];
        $data['name'] = $req['name'];
        $data['phone'] = $req['phone'];
        $data['idcardtype'] = $req['idcardtype'];
        $data['idcard'] = $req['idcard'];
        $data['addtime'] = date('Y-m-d', time());
        $data['state'] = 0;
        $res = Order::create($data);
        if ($res) {
            return ressend(200, '新增成功', $res);
        } else {
            return ressend(400, '新增失败');
        }
    }

    public function getPage()
    {
        $page = request()->param('page');
        $data = Order::page($page, 20)->order('id', 'desc')->select();
        $count = Order::count();
        return ressend(200, '获取成功', [
            'data'   =>  $data,
            'count'  =>  $count
        ]);
    }

    // 根据openid获取订单
    public function getOrderByOpenid()
    {
        $openid = request()->param('openid');
        $data = Order::where('uid', $openid)->order('id', 'desc')->select();
        return ressend(200, '获取成功', $data);
    }

    // 修改ifzhu字段状态
    public function changeIfzhu()
    {
        $id = request()->param('id');
        $data = Order::where('orderid', $id)->find();
        $data->ifzhu = 1;
        $data->save();
        return ressend(200, '修改成功', $data);
    }

    // 根据openid获取订单,修改price,在原基础上增加金额
    public function changePrice()
    {
        $req = request()->param();
        $data = Order::where('orderid', $req['openid'])->find();
        $data->price = $data->price + $req['price'];
        $data->save();
        return ressend(200, '修改成功', $data);
    }
}
