<?php
class Http{
	const  PORT = 8811;
    const  HOST = "0.0.0.0";
    public $http = null;
    public function __construct(){
    	$this->http = new Swoole\Http\Server(self::HOST,self::PORT);


    	$this->http->set([
        'document_root'=>"/swoole_live/zbj/public/static",
        'enable_static_handler'=>true,
        'worker_num'=>4,
        'task_worker_num'=>4,
       ]);

    	$this->http->on("workerstart",[$this,'onWorkerStart']);
    	$this->http->on("request",[$this,'onRequest']);
    	$this->http->on("task",[$this,'onTask']);
    	$this->http->on("finish",[$this,'onFinish']);
    	$this->http->on("close",[$this,'onClose']);
        $this->http->start();
    }


    public function onWorkerStart($server,$worker_id){
    //定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');

    // require __DIR__ . '/../thinkphp/base.php';
    // 找类，不然找不到
    require __DIR__ . '/../thinkphp/start.php';
    }

    public function onRequest($request,$response){
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
       $_POST['http_server'] = $this->http;

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

    }


    public function onTask($serv, $taskId, $workerId,$data){
    // print_r($data);
    // sleep(10);
    // return "on task finish";
    // 这个有应该要加个()吧
       $obj = new app\common\lib\task\Task;
       $method = $data['method'];
       $flag = $obj->$method($data['data']);
       // $obj = new app\common\lib\ali\Sms();
       // try {
       //   $response = $obj::sendSms($phoneNum,$code);
       // } catch (Exception $e) {
         // return Util::show(config('code.error'),'阿里大于内部异常');
     //     echo $e->getMessage();
     // }
     // print_r($response);
     return $flag;
    }
    
    
    public function onFinish($serv, $taskId,$data){
     echo "taskId:{$taskId}\n";
     echo "finish-data-success:{$data}\n";
    }

    public function onClose(swoole_server $server, int $fd){

    }


}

new http();
?>