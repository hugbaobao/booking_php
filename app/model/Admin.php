<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 管理后台模型，管理员信息
class Admin extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_admin';
    // 设置表名
    protected $name = 'admin';
    // 设置主键
    protected $id = 'id';
}
