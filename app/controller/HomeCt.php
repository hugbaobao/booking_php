<?php

namespace app\controller;

use app\BaseController;
use app\model\Home;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class HomeCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // switch 
    // 查所有
    public function getSwitch()
    {
        $sql = Home::find(1);
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     (array)$sql['switch']
        ]);
    }

    // 修改当前页page,删除当前页
    public function updateSwitch()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->switch = json_encode($req);
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新当前图片
    public function UpdateImg()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->switch = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            initPathStr($req['olddress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }


    // 上轮播图
    // 查所有
    public function topGet()
    {
        $sql = Home::find(1);
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql
        ]);
    }

    // 状态单值修改
    public function topChangeSingle()
    {
        $req = request()->param('state');
        $sql = Home::find(1);
        $sql->clocktop = $req;
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 新增图片
    public function topAdd()
    {
        $req = request()->param();
        $sql = Home::find(1);
        // 给数据库的banner项添加$req，$req是字典,banner项是一个数组
        $bannerData = (array)$sql->bannertop;
        array_push($bannerData, $req);
        $sql->bannertop = json_encode($bannerData);
        $result = $sql->save();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result
        ]);
    }

    // 修改当前页page,删除当前页
    public function topUpdatePage()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->bannertop = json_encode($req);
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新当前图片
    public function topUpdateImg()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->bannertop = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            initPathStr($req['oldDress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 下轮播图
    // 查所有
    public function btmGet()
    {
        $sql = Home::find(1);
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $sql
        ]);
    }

    // 状态单值修改
    public function btmChangeSingle()
    {
        $req = request()->param('state');
        $sql = Home::find(1);
        $sql->clockbtm = $req;
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 新增图片
    public function btmAdd()
    {
        $req = request()->param();
        $sql = Home::find(1);
        // 给数据库的banner项添加$req，$req是字典,banner项是一个数组
        $bannerData = (array)$sql->bannerbtm;
        array_push($bannerData, $req);
        $sql->bannerbtm = json_encode($bannerData);
        $result = $sql->save();
        return json([
            'code'     =>     200,
            'msg'      =>     '获取成功！',
            'data'     =>     $result
        ]);
    }

    // 修改当前页page,删除当前页
    public function btmUpdatePage()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->bannerbtm = json_encode($req);
        $result = $sql->save();
        if ($result) {
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新当前图片
    public function btmUpdateImg()
    {
        $req = request()->param();
        $sql = Home::find(1);
        $sql->bannerbtm = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            initPathStr($req['oldDress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新首页封面路径
    public function coverUpdate()
    {
        $req = request()->param();
        $key = $req['key'];
        $sql = Home::find(1);
        $sql->$key = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            // initPathStr($req['oldDress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }

    // 更新封面图片
    public function coverImg()
    {
        $req = request()->param();
        $key = $req['key'];
        $sql = Home::find(1);
        $sql->$key = json_encode($req['data']);
        $result = $sql->save();
        if ($result) {
            // 删除旧图片
            initPathStr($req['olddress']);
            return ressend(200, '修改成功！');
        } else {
            return ressend(201, '修改失败！');
        }
    }
}
