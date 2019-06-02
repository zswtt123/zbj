<?php

$http = new swoole_http_server("0.0.0.0",8811);

$http->set(
          [
            'enable_static_handler' =>true,
            'document_root'  =>  "/swoole_live/thinkphp/public/static",
            'worker_num'=>5,
           ]

);
$http->on('WorkerStart',function(swoole_server $server, $worker_id){

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

require __DIR__ . '/../thinkphp/base.php';
});


$http->on('request',function($request,$response){

      if(isset($request->server)){
        foreach($request->server as $k=>$v){
         $_SERVER[strtoupper($k)] = $v;
        }

      }


       if(isset($request->header)){
        foreach($request->header as $k=>$v){
         $_SERVER[strtoupper($k)] = $v;
        }

      }

       if(isset($request->get)){
        foreach($request->get as $k=>$v){
         $_GET[$k] = $v;
        }

      }


             if(isset($request->post)){
        foreach($request->post as $k=>$v){
         $_POST[$k] = $v;
        }

      }


      // 执行应用并响应
think\Container::get('app', [APP_PATH])
    ->run()
    ->send();




});


$http->start();












?>
