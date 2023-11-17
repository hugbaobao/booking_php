<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 小程序商品模型
class Png extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_png';
    // 设置表名
    protected $name = 'png';
    // 设置主键
    protected $id = 'id';
}
