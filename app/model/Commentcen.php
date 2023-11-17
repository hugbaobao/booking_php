<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 旅行攻略
class Commentcen extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_commentcen';
    // 设置表名
    protected $name = 'commentcen';
    // 设置主键
    protected $id = 'id';


    public function Center()
    {
        return $this->belongsTo(Center::class, 'uid', 'id');
    }
}
