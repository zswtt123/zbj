<?php
namespace app\common\lib\task;
use app\common\lib\ali\Sms;
use app\common\lib\redis\Predis;
use app\common\lib\Redis;
class Task{
	public  function sendSms($data){

	   // $obj = new app\common\lib\ali\Sms();
       try {
         $response = $obj::sendSms($data['phone'],$data['code']);
          } catch (Exception $e) {
         
           return false;
         }

         if($response->Code==="OK"){
           Predis::getInstance()->set(Redis::smsKey($data['phone']),$data['code'],config('redis.out_time'));
         }else{
         	return fasle;
         }
        
         return true;

	}



}?>