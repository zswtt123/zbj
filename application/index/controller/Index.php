<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
class Index
{
    public function index()
    {    
    // dump(1); 
    	//print_r($_GET);
        // return 'singwa-hello';
    }

    

    public function hello($name = 'ThinkPHP5')
    {
        dump(0);
        return 'hello,' . $name;
    }


    public function sms(){
    	try{

    	}catch(\Exception $e){

    	}
    }





}
