<?php

namespace app\controller;

use app\BaseController;
use app\model\Commentcen;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class CommentcenCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 添加旅行攻略
    public function addComment()
    {
        $datas = request()->param();
        $data['uid'] = $datas['id'];
        $data['time'] = date('Y-m-d');
        $data['name'] = $datas['name'];
        $data['content'] = $datas['content'];
        $data['zan'] = 0;
        $res = Commentcen::create($data);
        if ($res) {
            return ressend(200, '新增成功', $res);
        } else {
            return ressend(400, '新增失败');
        }
    }

    // 获取最近3条，根据id desc获取，同时获取主表信息
    public function getArttrip()
    {
        $data = Commentcen::where('state', 1)
            ->order('id', 'desc')
            ->limit(3)
            ->with('User')
            ->select();
        return ressend(200, '获取成功', $data);
    }

    // 根据id获取详情
    public function getbyId()
    {
        $id = request()->param('id');
        $data = Commentcen::where('id', $id)->with('User')->find();
        return ressend(200, '获取成功', $data);
    }
}
