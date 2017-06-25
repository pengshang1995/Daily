<?php
/**
 * Created by PhpStorm.
 * User: PS
 * Date: 2017/6/21
 * Time: 14:38
 */
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class TagController extends Controller{
    public function tagList(){
        $map['uid']=$_SESSION['user']['id'];
        $data=M('tag')->where($map)->order('createTime asc')->select();
        foreach ($data as $k =>$v) {
            $mapDaily=array(
                'type'=>$v['id'],
                'uid'=>$_SESSION['user']['id']
            );
            $data[$k]['count']=M('daily')->where($mapDaily)->count();
        }
        $Res['data']=$data;
        $Res['state']=0;
        $this->ajaxReturn($Res);
    }

    public function addTag(){
        $data['tag']=I('tag');
        $data['uid']=$_SESSION['user']['id'];
        $tags=M('tag')->where($data)->find();
        if(empty($tags)){
            $data['createTime']=time();
            $res=M('tag')->add($data);
            if($res){
                $Res['state']=0;
            }else{
                $Res['state']=1;
            }
        }else{
            $Res['state']=1;
        }

        $this->ajaxReturn($Res);
    }

    public function deleteTag(){
        $map['tag']=I('tag');
        $map['uid']=$_SESSION['user']['id'];
        $tag=M('tag')->where($map)->find();
        $mapDaily['type']=$tag['id'];
        $mapDaily['uid']=$_SESSION['user']['id'];
        M('daily')->where($mapDaily)->delete();
        $res=M('tag')->where($map)->delete();
        if($res){
            $Res['state']=0;
        }else{
            $Res['state']=1;
        }
        $this->ajaxReturn($Res);
    }
}