<?php
$http = new Swoole\Http\Server("0.0.0.0",8811);

$http->set([
    'document_root'=>"/swoole_live/zbj/public/static",
    'enable_static_handler'=>true,
      'worker_num'=>5,
]);


$http->on('WorkerStart',function(swoole_server $server, $worker_id){

//定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

require __DIR__ . '/../thinkphp/base.php';
});


$http->on('request',function($request,$response){
     $response->cookie("singwa","xssss",time()+1800);
     $response->end("sss".json_encode($request->get));
});

$http->start();



?>