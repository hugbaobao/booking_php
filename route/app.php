<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


// 微信号管理统计
Route::group('weixin', function () {
    Route::rule('cjlv', 'weixinct/changelevel');
})->allowCrossDomain()->middleware(\app\middleware\compareToken::class);



// 单图上传
Route::group('uploadimg', function () {
    Route::rule('ulo', 'UploadImg/upload');
    Route::rule('ularr', 'UploadImg/arrupload');
    Route::rule('del', 'UploadImg/del_png');
})->allowCrossDomain();


// 账号
Route::group('admin', function () {
    Route::rule('rgs', 'AdminCt/register');
    Route::rule('login', 'AdminCt/Login');
    Route::rule('list', 'AdminCt/getuser');
    Route::rule('del', 'AdminCt/deleteuser');
})->allowCrossDomain();


// 房间预定
Route::group('room', function () {
    Route::rule('get', 'RoomCt/getRoom');  //wx
    Route::rule('add', 'RoomCt/bannerAdd');
    Route::rule('page', 'RoomCt/updatePage');
    Route::rule('img', 'RoomCt/updateImg');
    Route::rule('tog', 'RoomCt/changeSingle');
})->allowCrossDomain();


// 首页
Route::group('home', function () {
    // 6个按钮
    Route::rule('get', 'HomeCt/getSwitch');
    Route::rule('update', 'HomeCt/updateSwitch');
    Route::rule('img', 'HomeCt/updateImg');
    // 上轮播图 
    Route::rule('btget', 'HomeCt/topGet'); //wx
    Route::rule('btcs', 'HomeCt/topChangeSingle');
    Route::rule('btadd', 'HomeCt/topAdd');
    Route::rule('btupp', 'HomeCt/topUpdatePage');
    Route::rule('btupi', 'HomeCt/topUpdateImg');
    // 下轮播图
    Route::rule('btmget', 'HomeCt/btmGet');
    Route::rule('btmcs', 'HomeCt/btmChangeSingle');
    Route::rule('btmadd', 'HomeCt/btmAdd');
    Route::rule('btmupp', 'HomeCt/btmUpdatePage');
    Route::rule('btmupi', 'HomeCt/btmUpdateImg');
    // 封面
    Route::rule('cpath', 'HomeCt/coverUpdate');
    Route::rule('cimg', 'HomeCt/coverImg');
})->allowCrossDomain();

// 用户
Route::group('user', function () {
    Route::rule('get', 'UserCt/getUser');
    Route::rule('byid', 'UserCt/getUserByOpenid'); // wx
    Route::rule('add', 'UserCt/addUser'); // wx
    Route::rule('update', 'UserCt/updateUser'); // wx
    Route::rule('idcard', 'UserCt/saveIdcard'); // wx
    Route::rule('vip', 'UserCt/changeVip'); // wx
})->allowCrossDomain();

// 商品
Route::group('shop', function () {
    Route::rule('sum', 'ShopCt/getCount');
    Route::rule('get', 'ShopCt/getShop');
    Route::rule('status', 'ShopCt/changeStatus');
    Route::rule('del', 'ShopCt/deleteShop');
    Route::rule('add', 'ShopCt/addShop');
    Route::rule('edit', 'ShopCt/editShop');
    Route::rule('shops', 'ShopCt/getShopRoom'); // wx
    Route::rule('type', 'ShopCt/getShopType'); // wx
    Route::rule('new', 'ShopCt/getShopTime'); // wx
    Route::rule('typage', 'ShopCt/getShopTypePage'); // wx
    Route::rule('search', 'ShopCt/getShopName'); // wx
    Route::rule('raw', 'ShopCt/changeCount'); // wx
})->allowCrossDomain();

// 杂项图片类
Route::group('png', function () {
    Route::rule('get', 'PngCt/getPng'); // wx
    Route::rule('edit', 'PngCt/editPng');
})->allowCrossDomain();

// 旅行攻略
// 杂项图片类
Route::group('art', function () {
    Route::rule('add', 'ArttripCt/addArttrip'); // wx
    Route::rule('get', 'ArttripCt/getArttrip'); // wx
    Route::rule('id', 'ArttripCt/getbyId'); // wx
    Route::rule('zan', 'ArttripCt/addZan'); // wx
    Route::rule('examine', 'ArttripCt/getArttripPage');
    Route::rule('state', 'ArttripCt/changeState');
})->allowCrossDomain();
// 评论
Route::group('ping', function () {
    Route::rule('add', 'CommentCt/addComment'); // wx
})->allowCrossDomain();

Route::group('center', function () {
    Route::rule('add', 'CenterCt/addArttrip'); // wx
    Route::rule('get', 'CenterCt/getArttrip'); // wx
    Route::rule('id', 'CenterCt/getbyId'); // wx
    Route::rule('zan', 'CenterCt/addZan'); // wx
    Route::rule('examine', 'CenterCt/getArttripPage');
    Route::rule('state', 'CenterCt/changeState');
})->allowCrossDomain();
// 评论
Route::group('pingc', function () {
    Route::rule('add', 'CommentcenCt/addComment'); // wx
})->allowCrossDomain();


// 订单
Route::group('car', function () {
    Route::rule('add', 'CarCt/addCar'); // wx
    Route::rule('get', 'CarCt/getCar'); // wx
    Route::rule('id', 'CarCt/deleteCar'); // wx
    Route::rule('page', 'CarCt/getPage');
    Route::rule('state', 'CarCt/changeStatus');
    Route::rule('pay', 'CarCt/changePay');  // wx
    Route::rule('topay', 'CarCt/changeStatusByIds');  // wx
    Route::rule('all', 'CarCt/changePayByIds');  // wx
})->allowCrossDomain();

// 酒店订单
Route::group('order', function () {
    Route::rule('add', 'OrderCt/addOrder'); // wx
    Route::rule('page', 'OrderCt/getPage');
    Route::rule('byid', 'OrderCt/getOrderByOpenid'); // wx
    Route::rule('ifzhu', 'OrderCt/changeIfzhu'); // wx
    Route::rule('addfee', 'OrderCt/changePrice'); // wx
})->allowCrossDomain();


// 优惠券
Route::group('coupon', function () {
    Route::rule('get', 'CouponCt/getCoupon');
    Route::rule('add', 'CouponCt/addCoupon');
    Route::rule('del', 'CouponCt/deleteCoupon');
    Route::rule('all', 'CouponCt/getCouponAll'); // wx
})->allowCrossDomain();

// 获取个人积分
Route::group('integral', function () {
    Route::rule('get', 'IntegralCt/getIntegralByOpenid');
})->allowCrossDomain();


// 优惠券表
Route::group('receivel', function () {
    Route::rule('add', 'ReceiveCt/addReceive');  // wx
    Route::rule('all', 'ReceiveCt/getReceiveByUid');  // wx
    Route::rule('use', 'ReceiveCt/changeReceive');  // wx
})->allowCrossDomain();
