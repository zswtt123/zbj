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


$http->on('request',function($request,$response)
use($http){

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
	$http->close();
    
});

$http->start();



?>