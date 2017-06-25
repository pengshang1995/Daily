<?php
/**
 * Created by PhpStorm.
 * User: PS
 * Date: 2017/6/20
 * Time: 18:26
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function loginTest(){
        $username=I('username');
        $password=I('password');
        $map=array(
            'username'=>$username
        );
        $userData=M('users')->where($map)->find();
        if(!empty($userData)){
            if($userData['password']==$password){
                $res['data']=$userData;
                $res['state']=0;
            }
        }else{
            $res['state']=1;
        }
        $this->ajaxReturn($res);
    }

    public function tokenLogin(){
        $token=I('token');
        $map=array(
            'token'=>$token
        );
        $userData=M('users')->where($map)->find();
        if(!empty($userData)){
            $_SESSION['user']=$userData;
            $res['data']=$userData;
            $res['state']=0;
        }else{
            $res['state']=1;
        }
        $this->ajaxReturn($res);
    }
    public function region(){
        $data['username']=I('username');
        $data['password']=I('password');
        $data['token']=creatToken();
        $mapTwo['username']=$data['username'];
        $users=M('users')->where($mapTwo)->find();
        if(empty($users)){
            $res=M('users')->add($data);
            if($res){
                $tag['tag']="默认";
                $tag['uid']=$res;
                $tag['createTime']=time();
                M('tag')->add($tag);
                $map=array(
                    'id'=>$res
                );
                $dataRes['data']=M('users')->where($map)->find();
                $dataRes['state']=0;
            }
        }else{
            $dataRes['state']=1;
        }
        $this->ajaxReturn($dataRes);
    }
}