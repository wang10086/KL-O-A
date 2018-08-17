<?php
/**
 * Date: 2018/8/15
 * Time: 15:47
 */

namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

//员工心声
class StaffController extends Controller{

    public function index(){
        $db         = M('staff');

        //分页
        $pagecount  = $db->count();
        $page       = new Page($pagecount, 6);
        $this->pages= $pagecount>6 ? $page->show():'';

        $list       = M('staff')->limit($page->firstRow . ',' . $page->listRows)->order('send_time desc')->where(array('pid'=>array('eq',0)))->select();
        foreach ($list as $k=>$v){
            $list[$k]['content'] = htmlspecialchars_decode($v['content']);
        }

        $hot_tiezi  = $this->get_hot_tiezi(10);
        $this->hot_tiezi = $hot_tiezi;
        $this->list = $list;

        $this->display();
    }

    public function add(){

        if (isset($_POST['dosubmit']) && isset($_POST['token'])){
            $token          = I('token');
            if ($token == $_SESSION['token']){
                $info           = array();
                $info['content']= stripslashes(I('content'));
                $info['send_time']= NOW_TIME;
                $res = M('staff')->add($info);
                if ($res){
                    $this->success('发布成功',U('Staff/index'));
                }else{
                    $this->error('数据保存失败');
                }
            }else{

                $this->error('非法数据');
            }
        }else{
            $token = md5(uniqid(rand(), true));
            $_SESSION['token']  = $token;
            $this->token        = $token;

            $hot_tiezi  = $this->get_hot_tiezi(6);
            $this->hot_tiezi = $hot_tiezi;

            $this->display();
        }
    }

    public function get_hot_tiezi($a){
        $hot_tiezi  = M('staff')->where(array('pid'=>array('eq',0)))->order('good_num desc,send_time desc')->limit($a)->select();
        foreach ($hot_tiezi as $k=>$v){
            $hot_tiezi[$k]['content'] = htmlspecialchars_decode($v['content']);
        }
        return $hot_tiezi;
    }

    public function info(){
        $id             = I('id');
        $list           = M('staff')->where(array('id'=>$id))->find();
        $list['content']= htmlspecialchars_decode($list['content']);
        $this->list     = $list;

        $hot_tiezi      = $this->get_hot_tiezi(6);
        $this->hot_tiezi= $hot_tiezi;

        $this->display();
    }
}