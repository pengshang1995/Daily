<?php
/**
 * Created by PhpStorm.
 * User: PS
 * Date: 2017/6/21
 * Time: 14:38
 */
namespace Home\Controller;
use Think\Controller;
class DailyController extends Controller{

    public function dailyList(){
        $map['uid']=$_SESSION['user']['id'];
        $tag=I('tag');
        $createDate=I('date');
        if(empty($tag)){
            $mapTag['tag']="默认";
            $mapTag['uid']=$_SESSION['user']['id'];
        }else{
            $mapTag['tag']=$tag;
            $mapTag['uid']=$_SESSION['user']['id'];
        }
        if(empty($createDate)){
           switch (date('w')){
               case 0:
                   $w="周天";
                   break;
               case 1:
                   $w="周一";
                   break;
               case 2:
                   $w="周二";
                   break;
               case 3:
                   $w="周三";
                   break;
               case 4:
                   $w="周四";
                   break;
               case 5:
                   $w="周五";
                   break;
               case 6:
                   $w="周六";
                   break;
           }
            $map['createDate']=date('y/m/d',time()).' '.$w;
        }else{
            $map['createDate']=$createDate;
        }
        $tag=M('tag')->where($mapTag)->find();
        $map['type']=$tag['id'];
        $data['data']=M('daily')->where($map)->order('time desc')->select();

        $mapCount=array(
            'uid'=>$_SESSION['user']['id']
        );
        $dataDaily=M('daily');
        $dataCount=$dataDaily->where($mapCount)->select();
        $countDay=$dataDaily->field($createDate)->where($mapCount)->count('distinct(createDate)');
        $count=count($dataCount);

        $data['str']="已连续记录".$countDay.'天（共'.$count.'篇)';
        if($count>0){
            $data['state']=0;
        }else{
            $data['state']=1;
        }
        $this->ajaxReturn($data);
    }

    public function dealDaily(){
        $id=I('id');
        $map['tag']=I('tag');
        $map['uid']=$_SESSION['user']['id'];
        $tag=M('tag')->where($map)->find();
        $data['type']=$tag['id'];
        $data['content']=I('content');
        $data['images']=I('images');
        $data['weather']=I('weather');
        $data['uid']=$_SESSION['user']['id'];
        if($id==0){
            $data['time']=time();
            $data['createTime']=I('createTime');
            $data['createDate']=I('createDate');
            $data['createYear']=date('Y',time());
            $res=M('daily')->add($data);
        }else{
            $mapDaily['id']=$id;
            $res=M('daily')->where($mapDaily)->save($data);
        }
        if($res!==false){
            $return['state']=0;
        }else{
            $return['state']=1;
        }
        $this->ajaxReturn($return);
    }

    public function imagesList(){
        $map['uid']=$_SESSION['user']['id'];
        $daily=M('daily')->field('time,images')->where($map)->order('time desc')->select();
        foreach ($daily as $k=>$v){
            $daily[$k]['time']=date('Y/m/d H:i',$v['time']);
        }
        $data['data']=$daily;
        if(empty($data['data'])){
            $data['state']=1;
        }else{
            $data['state']=0;
        }
        $this->ajaxReturn($data);
    }
    public function selectDaily(){
        $map['id']=I('id');
        $daily=M('daily')->where($map)->find();
        if(!empty($daily)){
            $data['data']=$daily;
            $data['state']=0;
        }else{
            $data['state']=1;
        }
        $this->ajaxReturn($data);
    }

    public function deleteDaily(){
        $map['id']=I('id');
        $res=M('daily')->where($map)->delete();
        if($res){
            $return['state']=0;
        }else{
            $return['state']=1;
        }
        $this->ajaxReturn($return);
    }

    public function upload(){
        $upload=new \Think\Upload();
        $upload->maxSize= 3145728 ;
        $upload->ext=array('jpg','png', 'jpeg');
        $info =$upload->upload();
        if (!$info) {
            $res['state']=1;
        } else {
            $res['data']=$info['image']['savepath']. $info['image']['savename'];
            $res['state']=0;
        }
        $this->ajaxReturn($res);
    }
}