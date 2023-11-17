<?php

namespace app\controller;

use app\BaseController;
use app\middleware\Check;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Validate;

class UploadImg
{
  // 上传单张普通图片
  public function upload()
  {
    $file = Request::file('img');

    // 验证规则
    $validate = Validate::rule([
      'file'     =>     'file|fileExt:jpg,png,gif'
    ]);
    // 验证规则
    $result = $validate->check([
      'file'     =>     $file
    ]);
    if ($result) {
      $info = Filesystem::disk('public')->putfile('header', $file);
      $info = str_replace('\\', '/', '/storage/' . $info);
      $response = [
        'errno'     =>     0,
        'data'      =>     [
          "url"     =>     $info, // 图片 src ，必须
          "alt"     =>     "", // 图片描述文字，非必须
          "href"    =>     ""  // 图片的链接，非必须
        ]
      ];
      return json($response);
    } else {
      $response = [
        'errno'     =>     1,
        'message'   =>     "上传失败"
      ];
      return json($response);
    }
  }

  // 上传图片列表
  public function arrupload()
  {
    $files = Request::file('filearr');
    var_dump($files);
    return;
    $infos = [];

    // 验证规则
    $validate = Validate::rule([
      'file'     =>     'fileArr|fileExt:jpg,png,gif'
    ]);
    foreach ($files as $file) {
      // 验证规则
      $result = $validate->check([
        'file'     =>     $file
      ]);
      if ($result) {
        $info = Filesystem::disk('public')->putfile('header', $file);
        $infos[] = str_replace('\\', '/', '/storage/' . $info);
      } else {
        dump($validate->getError());
      }
    };
    return json($infos);
  }

  public function unupload()
  {
    $path = request()->param('path');
    $result = unlink('uppic', $path);
    return json($result);
  }

  // 8.30add
  // 上传成功则删除原图
  public function del_png()
  {
    $paths = request()->param('file');
    $path = root_path() . 'runtime' . $paths;
    if (!file_exists($path)) {
      return ressend(404, '文件不存在！');
    }
    delFileByName($path);
    return ressend(200, '执行完毕');
  }
}
