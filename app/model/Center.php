<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 旅行攻略
class Center extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_center';
    // 设置表名
    protected $name = 'center';
    // 设置主键
    protected $id = 'id';

    // json字段
    protected $json = ['img'];

    // 属于User表的附表
    public function User()
    {
        return $this->belongsTo(User::class, 'uid', 'openid');
    }
    public function Commentcen()
    {
        return $this->hasMany(Commentcen::class, 'uid', 'id');
    }
}
