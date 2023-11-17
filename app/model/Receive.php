<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 旅行攻略
class Receive extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_receive';
    // 设置表名
    protected $name = 'receive';
    // 设置主键
    protected $id = 'id';


    // 属于User表的附表
    public function User()
    {
        return $this->belongsTo(User::class, 'uid', 'openid');
    }
    public function Coupon()
    {
        return $this->belongsTo(Coupon::class, 'code', 'id');
    }
}
