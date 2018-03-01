<?php
/**
 * Date: 2018/2/26
 * Time: 11:07
 */

namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class WorderController extends BaseController{

    //发起工单
    public function new_worder(){
        if (isset($_POST['dosubmint'])){

            $info                   = I('info');
            $info['status']         = 0;
            $info['ini_user_id']    = $_SESSION['userid'];
            $info['ini_dept_id']    = $_SESSION['roleid'];
            $info['ini_dept_name']  = $_SESSION['rolename'];
            $info['create_time']    = NOW_TIME;
            $info['plan_complete_time'] = NOW_TIME+(3600*24*5);
            $roleid                 = $info['exe_dept_id'];
            $userid                 = $info['exe_user_id'];
            //执行人部门名称
            $info['exe_dept_name']  = M('role')->where("id = '$roleid'")->getfield('role_name');
            $info['exe_user_name']  = M('account')->where("id = '$userid'")->getfield('nickname');
            $res = M('worder')->add($info);
            if ($res){
                //保存附件信息
                $this->success("发起工单成功!");
            }else{
                $this->error('保存失败!');
            }

        }else{
            $this->group            =  get_roles();
            $this->worder_type      = C('WORDER_TYPE');
            $this->display('new_worder');
        }
    }

    //ajax获取每组用户信息
    public function member(){
        $id     = I('id');
        $users  = M('account')->where("roleid = '$id'")->select();
        $this->ajaxReturn($users,"JSON");
    }

    //管理工单(工单列表)
    public function worder_list(){
        $this->title('工单管理');
        $db                         = M('worder');
        $worder_title               = I('worder_title');
        $worder_content             = I('worder_content');

        $where                      = array();

        if ($worder_title)          $where['w.worder_title']        = array('like','%'.$worder_title.'%');
        if ($worder_content)        $where['w.worder_content']      = array('like','%'.$worder_content.'%');

        //分页
        $pagecount		= $db->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->lists    = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();

        $this->display();
    }
}