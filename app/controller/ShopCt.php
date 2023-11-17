<?php

namespace app\controller;

use app\BaseController;
use app\model\Shop;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class ShopCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    // 获取总数量
    public function getCount()
    {
        $data = Shop::count();
        return ressend(200, '获取成功', $data);
    }

    // 获取用户
    public function getShop()
    {
        $page = request()->param('page');
        $data = Shop::page($page, 10)->order('id', 'desc')->select();
        return ressend(200, '获取成功', $data);
    }

    // 状态改变
    public function changeStatus()
    {
        $id = request()->param('id');
        $keys = request()->param('keys');
        $status = request()->param('status');
        $data = Shop::where('id', $id)->update([$keys => $status]);
        return ressend(200, '修改成功', $data);
    }

    // 删除商品
    public function deleteShop()
    {
        $id = request()->param('id');
        $data = Shop::where('id', $id)->with('Car')->find();
        $data->together(['Car'])->delete();
        return ressend(200, '删除成功', $data);
    }

    // 添加商品
    public function addShop()
    {
        $data = request()->param();
        $shop = new Shop();
        $shop->name = $data['name'];
        $shop->price = $data['price'];
        $shop->original = $data['original'];
        $shop->simple = json_encode($data['simple']);  // array
        $shop->words = $data['words'];
        $shop->cover = json_encode($data['cover']);  // array
        $shop->count = $data['count'];
        $shop->type = $data['type'];
        $shop->createtime = date('Y-m-d');
        $result = $shop->save();
        return ressend(200, '添加成功', $result);
    }

    // 编辑商品
    public function editShop()
    {
        $data = request()->param();
        $shop = Shop::find($data['id']);
        $shop->name = $data['name'];
        $shop->price = $data['price'];
        $shop->original = $data['original'];
        $shop->simple = json_encode($data['simple']);  // array
        $shop->words = $data['words'];
        $shop->cover = json_encode($data['cover']);  // array
        $shop->count = $data['count'];
        $shop->type = $data['type'];
        // $shop->createtime = date('Y-m-d');
        $result = $shop->save();
        return ressend(200, '添加成功', $result);
    }

    // 获取房间页展示
    public function getShopRoom()
    {
        $req = request()->param('keys');
        $data = Shop::where($req, 1)->order('id', 'desc')->select();
        return ressend(200, '获取成功', $data);
    }

    // 通过type获取商品
    // 1:hot,2:local,3:wear,4:home
    public function getShopType()
    {
        $req = request()->param('type');
        $data = Shop::where('type', $req)->where('count', '>', 0)->limit(0, 6)->order('id', 'desc')->select();
        return ressend(200, '获取成功', $data);
    }

    // 通过createtime字段，获取createtime距离今天小于30天的商品
    public function getShopTime()
    {
        $data = Shop::whereTime('createtime', 'between', [date('Y-m-d', strtotime('-30 day')), date('Y-m-d')])->where('count', '>', 0)->select();
        return ressend(200, '获取成功', $data);
    }

    // 通过type获取商品，每次获取20条，当page为1时，获取前20条，page为2时，获取21-40条，以此类推
    public function getShopTypePage()
    {
        $req = request()->param('type');
        $page = request()->param('page');
        $data = Shop::where('type', $req)->where('count', '>', 0)->limit(($page - 1), 20)->order('id', 'desc')->select();
        return ressend(200, '获取成功', $data);
    }

    // 根据商品的name字段，模糊查询商品
    public function getShopName()
    {
        $req = request()->param('name');
        $data = Shop::where('name', 'like', '%' . $req . '%')->where('count', '>', 0)->select();
        return ressend(200, '获取成功', $data);
    }

    // 修改库存
    public function changeCount()
    {
        $id = request()->param('id');
        $count = request()->param('count');
        $data = Shop::where('id', $id)->update(['count' => DB::raw('count - ' . $count)]);
        return ressend(200, '修改成功', $data);
    }
}
