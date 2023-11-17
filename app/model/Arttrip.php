<?php

namespace app\model;

use PDO;
use think\db\Query;
use think\model;


// 旅行攻略
class Arttrip extends model
{
    // 设置库
    protected $connection = 'system';
    // 设置表
    protected $table = 'uni_arttrip';
    // 设置表名
    protected $name = 'arttrip';
    // 设置主键
    protected $id = 'id';

    // json字段
    protected $json = ['img'];

    // 属于User表的附表
    public function User()
    {
        return $this->belongsTo(User::class, 'uid', 'openid');
    }
    public function Comment()
    {
        return $this->hasMany(Comment::class, 'uid', 'id');
    }
}
