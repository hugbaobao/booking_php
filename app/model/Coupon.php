<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 小程序用户模型
class Coupon extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_coupon';
    // 设置表名
    protected $name = 'coupon';
    // 设置主键
    protected $id = 'id';

    // 一对多关联
    public function Receive()
    {
        return $this->hasMany(Receive::class, 'code', 'id');
    }
}
