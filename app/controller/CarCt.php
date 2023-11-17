<?php

namespace app\controller;

use app\BaseController;
use app\model\Car;
use app\model\Shop;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class CarCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 添加购物车商品
    public function addCar()
    {
        $req = request()->param();
        $data['uid'] = $req['openid'];
        $data['goodsid'] = $req['goodsid'];
        $data['count'] = 1;
        $data['state'] = 0;

        // 先根据uid和goodsid查询是否存在，存在则count+1，不存在则新增
        // $res = Car::where('uid', $data['uid'])->where('goodsid', $data['goodsid'])->find();
        // 当前用户购物车中是否存在该商品且未添加入订单
        $res = Car::where('uid', $data['uid'])->where('goodsid', $data['goodsid'])->where('state', 0)->find();
        if ($res) {
            $res->count = $res->count + 1;
            $res->save();
            return ressend(200, '新增成功', $res);
        } else {
            $res = Car::create($data);
            if ($res) {
                return ressend(200, '新增成功', $res);
            } else {
                return ressend(400, '新增失败');
            }
        }
    }

    // 根据uid获取所有商品列表
    public function getCar()
    {
        $openid = request()->param('openid');
        $data = Car::where('uid', $openid)->with('Shop')->select();
        return ressend(200, '获取成功', $data);
    }

    // 根据id删除商品
    public function deleteCar()
    {
        $id = request()->param('id');
        $res = Car::destroy($id);
        if ($res) {
            return ressend(200, '删除成功');
        } else {
            return ressend(400, '删除失败');
        }
    }

    // 获取分页数据
    public function getPage()
    {
        $page = request()->param('page');
        $data = Car::whereIn('state', [2, 3, 4])->page($page, 20)->order('id', 'desc')->with(['Shop', 'User'])->select();
        $count = Car::whereIn('state', [2, 3, 4])->count();
        return ressend(200, '获取成功', [
            'data'   =>  $data,
            'count'  =>  $count
        ]);
    }

    // 订单状态改变
    public function changeStatus()
    {
        $id = request()->param('id');
        $status = request()->param('status');
        $data = Car::where('id', $id)->update(['state' => $status]);
        return ressend(200, '修改成功', $data);
    }

    // 修改支付状态
    public function changePay()
    {
        $req = request()->param();
        $car = Car::where('id', $req['id'])->find();
        $car->state = $req['state'];
        $car->out_trade_no = $req['out_trade_no'];
        $car->paytime = date('Y-m-d H:i:s');
        $res = $car->save();
        return ressend(200, '修改成功', $res);
    }

    // 根据id列表批量将订单状态改为待支付
    public function changeStatusByIds()
    {
        $ids = request()->param('ids');
        $data = Car::whereIn('id', $ids)->update(['state' => 1]);
        $paycount = Car::whereIn('id', $ids)->column('count');
        Car::whereIn('id', $ids)->update(['paycount' => Db::raw('count')]);
        return ressend(200, '修改成功', $data);
    }

    // 批量修改支付状态并去库存
    public function changePayByIds()
    {
        $list = request()->param('lists');
        $outtrade = request()->param('outtrade');
        $ids = [];
        foreach ($list as $key => $value) {
            array_push($ids, $value['id']);
        }
        $data = Car::whereIn('id', $ids)->update(['state' => 2, 'out_trade_no' => $outtrade, 'paytime' => date('Y-m-d H:i:s')]);
        // 批量修改库存 
        foreach ($list as $key => $value) {
            // $shop = Shop::where('id', $value['Shop']['id'])->find();
            // $shop->count = $shop->count - $value['paycount'];
            // $shop->save();
            Car::where('id', $value['id'])->Shop()->update(['count' => Db::raw('count-' . $value['paycount'])]);
        }
        return ressend(200, '修改成功', $data);
    }
}
