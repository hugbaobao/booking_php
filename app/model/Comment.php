<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 旅行攻略
class Comment extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_comment';
    // 设置表名
    protected $name = 'comment';
    // 设置主键
    protected $id = 'id';


    public function Arttrip()
    {
        return $this->belongsTo(Arttrip::class, 'uid', 'id');
    }
}
