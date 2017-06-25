<?php
// App接口公共控制器 AppController
namespace Api\Controller;
use Think\Controller\RestController;
class AppController extends RestController {
    // 自动加载的东西
    function _initialize() {
    }

    // 验证 客户端 token
    protected function checkAppToken($apptoken){
        // 引入 function.php 中定义的检测 apptoken 的函数
        if(checkingAppToken($apptoken)){
            return true;
        }else{
            $data['code'] = '404';
            $data['msg'] = 'apptoken无效';
            $data['data'] = null;
            $this -> response($data, 'json');
            exit();
        }
    }

    // 验证 用户 token
    protected function checkUserToken($usertoken){

    }

    // 各种验证 ……
}
?>