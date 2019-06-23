<?php
$http = new Swoole\Http\Server("0.0.0.0",8811);

$http->set([
    'document_root'=>"/swoole_live/zbj/public/static",
    'enable_static_handler'=>true,
      'worker_num'=>5,
]);

//定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

require __DIR__ . '/../thinkphp/base.php';
$http->on('WorkerStart',function(swoole_server $server, $worker_id){


});


$http->on('request',function($request,$response)
use($http){

	 $_GET=[];
       if(isset($request->get)){
        foreach($request->get as $k=>$v){
         $_GET[$k] = $v;
        }

      }

       $_POST=[];
       if(isset($request->post)){
        foreach($request->post as $k=>$v){
         $_POST[$k] = $v;
        }

      }

       $_SERVER=[];
       if(isset($request->server)){
        foreach($request->server as $k=>$v){
         $_SERVER[$k] = $v;
        }

      }

       
       if(isset($request->header)){
        foreach($request->header as $k=>$v){
         $_SERVER[strtoupper($k)] = $v;
        }

      }

	ob_start();
	try {
	think\Container::get('app', [APP_PATH])
    ->run()
    ->send();
	} catch (Exception $e) {
		//todo
	}
	echo "-action-".request()->action().PHP_EOL;
	$res = ob_get_contents();
	ob_end_clean();
	$response->end($res);
	//每次每个进程会被closed掉，但是不好
	 // $http->close();
    
});

$http->start();



?>