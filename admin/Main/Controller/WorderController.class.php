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
            $attr                   = I('attr');

            $roleid                 = $info['exe_dept_id'];
            $userid                 = $info['exe_user_id'];
            if (!$roleid && !$userid){
                $this->error("工单受理组不能为空!");
            }
            //执行人部门名称
            $info['exe_dept_name']  = M('role')->where("id = '$roleid'")->getfield('role_name');
            $info['exe_user_name']  = M('account')->where("id = '$userid'")->getfield('nickname');
            $res = M('worder')->add($info);
            if ($res){
                //保存附件信息
                save_res(P::WORDER_INI,$res,$attr);

                //发送信息
                $uid     = cookie('userid');
                $title   = '您有来自['.$info['ini_dept_name'].'--'.$info['ini_user_name'].']的工单待执行!';
                $content = '';
                $url     = U('worder/my_worder',array('id'=>$info['exe_user_id']));
                $user    = '['.$info['exe_user_id'].']';
                send_msg($uid,$title,$content,$url,$user,'');
                $this->success("发起工单成功!");
            }else{
                $this->error('保存失败!');
            }

        }else{
            $this->title('发起工单');
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
        $pin                        = I('pin')?I('pin'):0;

        $where                      = array();

        if ($worder_title)          $where['w.worder_title']        = array('like','%'.$worder_title.'%');
        if ($worder_content)        $where['w.worder_content']      = array('like','%'.$worder_content.'%');
        if ($pin==1)			        $where['o.create_user']		    = cookie('userid');

        //分页
        $pagecount		= $db->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        foreach($lists as $k=>$v){
            //判断工单类型
            if($v['worder_type']==0) $lists[$k]['type'] = '维修工单';
            if($v['worder_type']==1) $lists[$k]['type'] = '管理工单';
            if($v['worder_type']==2) $lists[$k]['type'] = '质量工单';

            //判断工单状态
            if($v['status']==0)     $lists[$k]['sta'] = '未响应';
            if($v['status']==1)     $lists[$k]['sta'] = '执行部门已响应';
            if($v['status']==2)     $lists[$k]['sta'] = '执行部门已确认完成';
            if($v['status']==3)     $lists[$k]['sta'] = '发起人已确认完成';
            if($v['status']==-1)    $lists[$k]['sta'] = '拒绝或无效工单';
        }
        $this->lists    = $lists;
        $this->pin      = $pin;
        $this->display();
    }

    //执行工单
    public function exe_worder(){
        if (isset($_POST['dosubmint'])){
            $id                             = I('id');
            $ini_user_id                    = I('ini_user_id');
            $info['exe_complete_content']   = I('exe_complete_content');  //审核意见
            $refuse                         = I('refuse');
            $info['status']                 = $refuse?$refuse:2; //执行部门确认完成
            $info['complete_time']          = NOW_TIME;
            $attr                           = I('attr');
            $res = M('worder')->where("id = '$id'")->save($info);
            if ($res){
                //保存上传附件
                save_res(P::WORDER_INI,$res,$attr);

                //向工单发起人推送消息
                $uid     = cookie('userid');
                $exe_dept_name = $_SESSION['rolename'];
                $exe_user_name = $_SESSION['nickname'];
                $title   = '您有来自['.$exe_dept_name.'--'.$exe_user_name.']的工单执行反馈!';
                $content = '';
                $url     = U('worder/my_worder',array('id'=>$_SESSION['userid']));
                $user    = '['.$ini_user_id.']';
                send_msg($uid,$title,$content,$url,$user,'');
                $this->success("执行成功!",U('Worder/worder_list'));
            }else{
                $this->error("执行失败!");
            }
        }else{
            $this->title('执行工单');
            $id                 = I('id');
            $data               = M('worder')->where("id = '$id'")->find();
            //判断工单类型
            if($data['worder_type']==0) $data['type'] = '维修工单';
            if($data['worder_type']==1) $data['type'] = '管理工单';
            if($data['worder_type']==2) $data['type'] = '质量工单';
            $this->data         = $data;
            $this->id           = $id;
            $this->display();
        }
    }

    //我的工单
    public function my_worder(){
        if (isset($_POST['dosubmint'])){

        }else{
            $userid                 = cookie('userid');
            $where                  = array();
            $where['ini_user_id']   = $userid;  //我申请的工单
            //$where['exe_user_id']   = $userid;  //我执行的工单
            $lists                  = M('worder')->where("ini_user_id = '$userid' or exe_user_id = '$userid'")->select();
            foreach($lists as $k=>$v){
                //判断工单类型
                if($v['worder_type']==0) $lists[$k]['type'] = '维修工单';
                if($v['worder_type']==1) $lists[$k]['type'] = '管理工单';
                if($v['worder_type']==2) $lists[$k]['type'] = '质量工单';

                //判断工单状态
                if($v['status']==0)     $lists[$k]['sta'] = '未响应';
                if($v['status']==1)     $lists[$k]['sta'] = '执行部门已响应';
                if($v['status']==2)     $lists[$k]['sta'] = '执行部门已确认完成';
                if($v['status']==3)     $lists[$k]['sta'] = '发起人已确认完成';
                if($v['status']==-1)    $lists[$k]['sta'] = '拒绝或无效工单';
            }
            $this->lists            = $lists;
            $pin                    = I('pin')?I('pin'):1;
            $this->pin              = $pin;
            $this->display();
        }
    }

    public function del_worder(){

        $id = I('id');
        $res = M('worder')->where("id = '$id'")->delete();
        if($res){
            $this->success('删除工单成功!');
        }else{
            $this->error('删除数据失败!');
        }
    }
}