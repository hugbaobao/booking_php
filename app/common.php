<?php
// 应用公共文件
use GuzzleHttp\Client;

//   发起 GET 请求
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

//   发起 POST 请求
function postrequest($methods, $UrlSb, $data)
{

    $client = new Client([
        // 'base_uri'  =>  '47.96.27.188:8886',
        'timeout' => 6
    ]);

    $response = $client->request($methods, $UrlSb, $data);
    $code = $response->getStatusCode(); // 接口状态码200
    $reason  =  $response->getReasonPhrase(); //原因短语
    /*  $response -> getHeaderLine ( 'content-type' ); // '应用程序/json; charset=utf8'  */
    $body = $response->getBody(); // 获取接口内容
    $content = $body->getContents();
    return json([
        'code'     =>   $code,
        'reason'   =>   $reason,
        'body'     =>   $content
    ]);
}

// 定义api返回的数据格式
function ressend($status = 200, $message = '成功', $data = [])
{
    $result = [
        "code" => $status,
        "message" => $message,
        "data" => $data
    ];
    return json($result);
}


//递归删除目录内的文件，目录不删
function delFileByDir($dir) {
    $dh = opendir($dir);//读取文件目录
    while ($file = readdir($dh)) {
       if ($file != "." && $file != "..") {//去掉.和..这两步
 
          $fullpath = $dir . "/" . $file;//看目录下是不是文件
          if (is_dir($fullpath)) {//如果是目录的话
             delFileByDir($fullpath);//递归（从内往外删除）
          } else {
             unlink($fullpath);
          }
       }
    }
    closedir($dh);
 }

//  删除指定文件,大多情况下旧路径从数据库中取是最稳定的
function delFileByName($file) {
    $path=app()->getRootPath().'public'.$file;
    // $path=root_path().'public'.$file; //控制器中才可以使用
    if(!file_exists($path)){
        return false;
    }
    unlink($path);
}

// 根据上传文件配置决定，本配置只取/storage格式字符
function initPathStr($file) {
    $num = strpos($file, '/storage'); //boolean
    $old = substr($file, $num);
    delFileByName($old);
}
