<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;

class Home extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_home';
    // 设置表名
    protected $name = 'home';
    // 设置主键
    protected $id = 'id';
    // json字段
    protected $json = ['bannertop', 'bannerbtm', 'switch', 'coverone', 'covertwo'];

    // 模型获取器
    // 轮播图开关
    public function getClockTopAttr($value)
    {
        $clocktop = [0 => false, 1 => true];
        return $clocktop[$value];
    }
    public function getClockBtmAttr($value)
    {
        $Clockbtm = [0 => false, 1 => true];
        return $Clockbtm[$value];
    }
}
