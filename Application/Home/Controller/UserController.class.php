<?php
/**
 * Created by PhpStorm.
 * User: PS
 * Date: 2017/6/21
 * Time: 13:56
 */
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
    public function updateName(){
        $update['name']=I('name');
        $map['id']=$_SESSION['user']['id'];
        $res=M('users')->where($map)->save($update);
        if($res !=false){
            $returnData['state']=0;
        }else{
            $returnData['state']=1;
        }
        $this->ajaxReturn($returnData);
    }

    public function updateDesc(){
        $update['desc']=I('desc');
        $map['id']=$_SESSION['user']['id'];
        $res=M('users')->where($map)->save($update);
        if($res !=false){
            $returnData['state']=0;
        }else{
            $returnData['state']=1;
        }
        $this->ajaxReturn($returnData);
    }

    public function updatePassword(){
        $map['id']=$_SESSION['user']['id'];
        $update['password']=I('password');
        $res=M('users')->where($map)->save($update);
        if($res !=false){
            $returnData['state']=0;
        }else{
            $returnData['state']=1;
        }

        $this->ajaxReturn($returnData);
    }
}