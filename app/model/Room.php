<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Room extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_room';
    // 设置表名
    protected $name = 'room';
    // 设置主键
    protected $id = 'id';
    // json字段
    protected $json = ['banner'];

    // 模型获取器
    // 轮播图开关
    public function getSwitchAttr($value)
    {
        $switch = [0 => false, 1 => true];
        return $switch[$value];
    }
}
