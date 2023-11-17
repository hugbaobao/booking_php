<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


class Integral extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_integral';
    // 设置表名
    protected $name = 'integral';
    // 设置主键
    protected $id = 'id';


    // 属于User表的附表
    public function User()
    {
        return $this->belongsTo(User::class, 'uid', 'openid');
    }
}
