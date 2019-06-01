<?php

$http = new swoole_http_server("0.0.0.0",8811);

$http->set(
          [
            'enable_static_handler' =>true,
            'document_root'  =>  "/swoole_live/thinkphp/public/static",
            'worker_num'=>5,
           ]

);

$http->on('request',function($request,$response){
      $response->cookie('singma','xssss',time()+1800);
     $response->end("sss".json_encode($request->get));

     echo "123";

});


$http->start();












?>
