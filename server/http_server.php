<?php
$http = new swoole_http_server("0.0.0.0",8811);

$http->set([
    'document_root'=>"/home/work/hdtocs/swoole_mooc/thinkphp/public/static",
    'enable_static_handler'=>true,
]);

$http->on('request',function($request,$response){
     $response->cookie("singwa","xssss",time()+1800);
     $response->end("sss",json_encode($request->get));
});

$http->start();



?>