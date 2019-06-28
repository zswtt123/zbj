<?php
namespace app\admin\controller;
use app\common\lib\Util;
class Image{

	public function index(){
		// print_r($_FILES);die;
		$file = request()->file('file');
		$info = $file->move('../public/static/upload');
		if($info){
			$data = [
             'image'=>config('live.host')."/upload/".$info->getsaveName(),
			];


			return Util::show(config('code.success'),'ok',$data);
		}else{
            return Util::show(config('code.error'),'error');
		}
		print_r($info);
	}

}?>