<?php
namespace app\index\controoler;
use app\common\lib\ali\Sms;
class Send{
	
	public function index(){
     $phoneNum = intval($_GET['phone']);
     if(empty($phoneNum)){
     	return Util::show(config('code.error'),'error');
     }
     $code = rand(1000,9999);
     $taskdata = [
     'method'=>'sendSms',
     'data'=>[
     	'phone'=>$phoneNum,
        'code'=>$code,
      ]
     ];
     $_POST['http_server']->task($taskdata);
     return Util::show(config('code.success'),'ok');
     // try {
     // 	$response = Sms::sendSms($phoneNum,$code);
     // } catch (Exception $e) {
     // 	return Util::show(config('code.error'),'阿里大于内部异常');
     // }
     // if($response->Code==="OK"){

     // }
	}






}?>