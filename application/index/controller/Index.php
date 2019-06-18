<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
class Index
{
    public function index()
    {
    	//print_r($_GET);
        // return 'singwa-hello';
    }

    

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }


    public function sms(){
    	try{

    	}catch(\Exception $e){

    	}
    }





}
