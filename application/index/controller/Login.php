<?php
namespace app\index\controller;
use app\common\lib\Util;
use app\commmon\lib\Redis;
use app\common\lib\redis\Predis;
class Login{
	
	public function index(){
		$phoneNum = intval($_GET['phone_num ']);
		$Code = intval($_GET['code']);
		if(empty($phoneNum)||empty($Code)){
			return Util::show(config('code.error'),'phone or code is error');
		}
	     try {
	     	$redisCode = Predis::getInstance()->get(Redis::smsKey($phoneNum));
	     } catch (Exception $e) {
	     	echo $e->getMessage();
	     }
	     if($Code==$redisCode){
	     	$data = [
               'user'=>$phoneNum,
               'srcKey'=>md5(Redis::userkey($phoneNum)),
               'time'=>time(),
               'isLogin'=>true,
	     	];
	     	Predis::getInstance()->set(Redis::userKey($phoneNum),$data);
	     	return Util::show(config('code.success','ok',$data));
	     }else{
	     	return Utile::show(config('code.error','login error'));
	     }
	}




}?>