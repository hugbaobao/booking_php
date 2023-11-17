<?php

namespace app\controller;

use app\BaseController;
use app\model\Admin;
use League\Flysystem\Cached\Storage\PhpRedis;
use think\facade\Db;
use \Firebase\JWT\JWT;

class AdminCt extends BaseController
{
    public function index()
    {
        return 'user_Admin';
    }

    function setToken($password)
    {
        $key = 'aslfjhasgjgja';
        // $kid = 'mykidforchatgpt';
        $token = array(
            "iss" => $key,        //签发者 可以为空
            "aud" => '',          //面象的用户，可以为空
            "iat" => time(),      //签发时间
            "nbf" => time(),    //在什么时候jwt开始生效  （这里表示签发后立即生效）
            "exp" => time() + 1 * 60 * 60 * 48, //token 过期时间两天
            "data" => [           //加入password，后期同样使用password进行比对
                'password' => $password,
            ]
        );

        $jwt = JWT::encode($token, $key, 'HS256');  //根据参数生成了 token
        //$jwt = JWT::encode($token, $key, "HS256", $kid);  //根据参数生成了 token
        return $jwt;
    }


    // 注册
    public function register()
    {
        // $user = request()->param('form');
        $user = request()->param();
        if ($user['username'] === '' || $user['password'] === '') {
            return ressend(201, '用户名和密码不可为空！');
        }
        $exist = Admin::where('username', $user['username'])->find();
        if (isset($exist)) {
            return ressend(202, '该用户名已被占用！');
        }
        // 密码加密
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $data = [
            'username'     =>    $user['username'],
            'password'     =>    $user['password'],
            // 'header'       =>    $user['header'],
            // 'power'        =>    $user['power']
        ];
        $sql = new Admin();
        $sql->save($data);
        return ressend(200, '成功');
    }

    // 登录
    public function Login()
    {
        // $user = request()->param('form');
        $user = request()->param();
        // return json($user);
        $exist = Admin::where('username', $user['username'])->find();
        if ($exist == null) {
            return ressend(201, '账号不存在！');
        }
        if (password_verify($user['password'], $exist['password'])) {
            $Token = $this->setToken($exist['id']);
            $data = [
                'Token'    =>     $Token,
                'idCode'   =>     $exist['id'],
                'name'     =>     $exist['username'],
                'avator'   =>     $exist['header'],
                'pover'    =>     $exist['pover']
            ];
            return ressend(200, '登录成功！', $data);
        }
        return ressend(202, '密码错误！');
    }

    //改密
    public function changepassword()
    {
        $user = request()->param('form');
        $exist = Admin::where('username', $user['username'])->where('id', '<>', $user['id'])->find();
        if (isset($exist)) {
            return ressend(201, '该用户名已被占用！');
        }
        $sql = Admin::find($user['id']);
        // 密码加密
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $sql->username     =    $user['username'];
        $sql->password     =    $user['password'];
        $sql->header       =    $user['imageUrl'];
        $sql->power        =    $user['power'];

        $sql->save();
        return ressend(200, '成功');
    }

    // 查
    public function getuser()
    {
        $users = Admin::field('id,username')->select();
        // 将password字段解密传回
        // foreach ($users as $key => $user) {
        //     $users[$key]['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        // }
        return ressend(200, '获取成功！', $users);
    }

    // 删除账号
    public function deleteuser()
    {
        $id = request()->param('id');
        $sql = Admin::find($id);
        $sql->delete();
        return ressend(200, '删除成功！');
    }
}
