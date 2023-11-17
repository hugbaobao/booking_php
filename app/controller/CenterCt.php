<?php

namespace app\controller;

use app\BaseController;
use app\model\Center;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class CenterCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 添加旅行攻略
    public function addArttrip()
    {
        $openid = request()->param('openid');
        $datas = request()->param('data');
        $data['uid'] = $openid;
        $data['createtime'] = date('Y-m-d');
        $data['img'] = json_encode($datas['img']);
        $data['title'] = $datas['title'];
        $data['content'] = $datas['content'];
        $data['state'] = 0;
        $data['zan'] = 0;
        $res = Center::create($data);
        if ($res) {
            return ressend(200, '新增成功', $res);
        } else {
            return ressend(400, '新增失败');
        }
    }

    // 获取最近3条，根据id desc获取，同时获取主表信息
    public function getArttrip()
    {
        $data = Center::where('state', 1)
            ->order('id', 'desc')
            ->limit(12)
            ->with('User')
            ->select();
        return ressend(200, '获取成功', $data);
    }

    // 根据id获取详情
    public function getbyId()
    {
        $id = request()->param('id');
        $data = Center::where('id', $id)->with('User')->with('Commentcen')->find();
        return ressend(200, '获取成功', $data);
    }

    // 赞加一
    public function addZan()
    {
        $id = request()->param('id');
        $data = Center::where('id', $id)->find();
        $data->zan = $data->zan + 1;
        $res = $data->save();
        if ($res) {
            return ressend(200, '点赞成功', $data);
        } else {
            return ressend(400, '点赞失败');
        }
    }

    // 获取分页数据，每页10条，附带总数量
    public function getArttripPage()
    {
        $page = request()->param('page');
        $data = Center::order('id', 'desc')
            ->order('state')
            ->page($page, 10)
            ->select();
        $count = Center::count();
        $res['data'] = $data;
        $res['count'] = $count;
        return ressend(200, '获取成功', $res);
    }

    // 状态改变state字段为状态
    public function changeState()
    {
        $id = request()->param('id');
        $state = request()->param('state');
        $data = Center::where('id', $id)->find();
        $data->state = $state;
        $res = $data->save();
        if ($res) {
            return ressend(200, '修改成功', $data);
        } else {
            return ressend(400, '修改失败');
        }
    }
}
