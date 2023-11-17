<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 小程序商品模型
class Shop extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_shop';
    // 设置表名
    protected $name = 'shop';
    // 设置主键
    protected $id = 'id';

    // 模型获取器
    public function getRoomAttr($value)
    {
        $room  = [0 => false, 1 => true];
        return $room[$value];
    }
    public function getHometopAttr($value)
    {
        $hometop  = [0 => false, 1 => true];
        return $hometop[$value];
    }
    public function getHomebtmAttr($value)
    {
        $homebtm  = [0 => false, 1 => true];
        return $homebtm[$value];
    }
    public function getXianAttr($value)
    {
        $xian  = [0 => false, 1 => true];
        return $xian[$value];
    }


    public function Car()
    {
        return $this->hasMany(Car::class, 'goodsid', 'id');
    }
}
