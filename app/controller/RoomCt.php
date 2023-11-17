<?php

namespace app\controller;

use app\BaseController;
use app\model\Room;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class RoomCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }


    // 状态单值修改
    public function changeSingle()
    {
        $req = request()->param('state');
        $sql = Room::find(1);
        $sql->switch = $req;
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 新增图片
    public function bannerAdd()
    {
        $req = request()->param();
        $sql = Room::find(1);
        // 给数据库的banner项添加$req，$req是字典,banner项是一个数组
        $bannerData = (array)$sql->banner;
        array_push($bannerData, $req);
        $sql->banner = json_encode($bannerData);
        $result = $sql->save();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result
        ]);
    }

    // 查所有
    public function getRoom()
    {
        $sql = Room::find(1);
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql
        ]);
    }

    // 修改当前页page,删除当前页
    public function updatePage()
    {
        $req = request()->param();
        $sql = Room::find(1);
        $sql->banner = json_encode($req);
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新当前图片
    public function updateImg()
    {
        $req = request()->param();
        $sql = Room::find(1);
        $sql->banner = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            initPathStr($req['oldDress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }
}
