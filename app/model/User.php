<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 小程序用户模型
class User extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_user';
    // 设置表名
    protected $name = 'user';
    // 设置主键
    protected $id = 'id';

    // 模型获取器
    public function getSexAttr($value)
    {
        $sex  = [0 => '女', 1 => '男'];
        return $sex[$value];
    }
    public function getVipAttr($value)
    {
        $vip  = [0 => false, 1 => true];
        return $vip[$value];
    }
    // 模型修改器
    public function setSexAttr($value)
    {
        $sex  = ['女' => 0, '男' => 1];
        return $sex[$value];
    }

    // 一对多关联
    public function Arttrip()
    {
        return $this->hasMany(Arttrip::class, 'uid', 'openid');
    }
    // 购物车
    public function Car()
    {
        return $this->hasMany(Car::class, 'uid', 'openid');
    }
    // 订单
    public function Shop()
    {
        return $this->hasMany(Shop::class, 'uid', 'openid');
    }
    // 优惠券
    public function Receive()
    {
        return $this->hasMany(Receive::class, 'uid', 'openid');
    }
    // 积分
    public function Integral()
    {
        return $this->hasMany(Integral::class, 'uid', 'openid');
    }
    // 充值
    public function Charge()
    {
        return $this->hasMany(Charge::class, 'uid', 'openid');
    }
}
