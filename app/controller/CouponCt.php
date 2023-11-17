<?php

namespace app\controller;

use app\BaseController;
use app\model\Coupon;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class CouponCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    public function getCoupon()
    {
        $page = request()->param('page');
        $data = Coupon::page($page, 20)->order('id', 'desc')->select();
        $count = Coupon::count();
        return ressend(200, '获取成功', [
            'data'   =>  $data,
            'count'  =>  $count
        ]);
    }

    // 获取所有优惠券
    public function getCouponAll()
    {
        $req = request()->param('arr');
        $data = Coupon::where('expiration', '>=', date('Y-m-d'))->whereNotIn('id', $req)->select();
        return ressend(200, '获取成功', $data);
    }

    // 添加
    public function addCoupon()
    {
        $data = request()->param();
        $shop = new Coupon();
        $shop->name = $data['name'];
        $shop->amount = $data['amount'];
        $shop->expiration = $data['expiration'];
        $result = $shop->save();
        return ressend(200, '添加成功', $result);
    }

    // 删除
    public function deleteCoupon()
    {
        $id = request()->param('id');
        $result = Coupon::where('id', $id)->delete();
        return ressend(200, '删除成功', $result);
    }
}
