<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {

    /**
     * Approval_Index 首页显示
     */
    public function Approval_Index(){

        $approval                       = $this->approval_table('approval_flie','',1);
        $app                            = D('Approval');
        $save                           = $app->datetime_approval();//改变到预定时间的文件
        $this->file_remind_number();
        $this->approval                 = $approval['approval'];
        $this->pages                    = $approval['pages'];
        $this->display();
    }


    /**
     * Approval_list 文档列表 搜索文档
     * $file_id 文档 id
     */
    public function Approval_list(){
        $app                                = D('Approval');
        $where                              = $app->Jurisdiction();
        if($where==1){
            unset($where);
        }elseif($where==2){
            $query['account_id']            = $_SESSION['userid'];
        }
        $userid                             = $_SESSION['userid'];
        $id                                 = trim(I('file_id'));
        if($where==2 && !empty($where)){//不是管理员
            if(IS_POST){//搜索
                $file_name                  = trim($_POST['file_name']);
                $account_name               = trim($_POST['username']);
                $query['file_name']         = array('like',"%$file_name%");
                $query['account_name']      = array('like',"%$account_name%");
                $query                      = array_filter($query);
                $stat                       = 2;
            }else{//普通人员
                if(is_numeric($id)){ //判断是否有传值
                    $wher['account_id']     = $userid;
                    $wher['pid_account_id'] = $userid;
                    $wher['file_id']        = trim(I('file_id'));
                    $stat                   = 2;
                }else{
                    $this->error('数据错误!请重新打开！');
                }
            }
        }else{
            if(empty($where) && $userid==13){//管理员
                $wher['account_id']             = $userid;
                $wher['pid_account_id']         = $userid;
                $wher['file_id']                = trim(I('file_id'));
                $stat                           = 3;
            }else{
                $wher['account_id']             = $userid;
                $wher['pid_account_id']         = $userid;
                $wher['file_id']                = trim(I('file_id'));
                $stat                           = 2;
            }
        }
        $approval                           = $this->approval_table('approval_flie_url',$wher,$stat);
        $this->file_id                      = $id;
        foreach($approval['approval'] as $key => $val){
            $approval['approval'][$key]['Approval']['pid_account_name'] = user_table($val['Approval']['pid_account_id'])['nickname'];
        }
        $this->approval                     = $approval['approval']; //文件信息 -- 文件夹信息
        $this->pages                        = $approval['pages'];//分页
        $this->display();
    }

    /**
     * Ajax_file_delete 删除选中的文件
     * $fileid 文件id
     */
    function file_delete(){
        $status                 = trim($_POST['status']);
        $fileid                 = trim($_POST['fileid']);
        $file_id                = array_filter(explode(',',$fileid));
        foreach($file_id as $key => $val){
            $save['type']       = 2;
            if($status==1){
                $approval_flie  = M('approval_flie')->where('id='.$val)->save($save);
            }elseif($status==2){
                $approval_flie  = M('approval_flie_url')->where('id='.$val)->save($save);
            }
        }
    }

    /**
     * approval_table 查询列表详情
     * $approval_table 表名
     * $where 查询条件
     */
    public function approval_table($approval_table,$where,$type){
        if($type==1){
            $where['type']                                = 1;
            $count                                        = M($approval_table)->where($where)->count();
            $page                                         = new Page($count,10);
            $pages                                        = $page->show();
            $approval                                     = M($approval_table)->where($where)->limit("$page->firstRow","$page->listRows")->order('createtime desc')->select();
        }elseif($type==2){
            $where['type']                                = 1;
            $count                                        = M($approval_table)->where($where)->count();
            $page                                         = new Page($count,10);
            $pages                                        = $page->show();
            $sql    = "SELECT * FROM `oa_approval_flie_url` WHERE `file_id` = ".$where['file_id']." AND ( `account_id` = ".$where['account_id']." OR `pid_account_id` = ".$where['account_id']." OR `status` > 2  ) AND `type` = 1 ORDER BY createtime desc LIMIT ".$page->firstRow.",".$page->listRows;
            $approval = M()->query($sql);
        }elseif($type==3){
            $where['type']                                = 1;
            $count                                        = M($approval_table)->where($where)->count();
            $page                                         = new Page($count,10);
            $pages                                        = $page->show();
            $sql    = "SELECT * FROM `oa_approval_flie_url` WHERE `file_id` = ".$where['file_id']." AND ( `account_id` = ".$where['account_id']." OR `pid_account_id` = ".$where['account_id']." OR `status` >= 2  ) AND `type` = 1 ORDER BY createtime desc LIMIT ".$page->firstRow.",".$page->listRows;
            $approval = M()->query($sql);
        }
        $approval_w['approval']                           = D('Approval')->query_table($approval);
        $approval_w['pages']                              = $pages;
        return $approval_w;
    }

    /**
     * Approval_Upload 编辑文件
     * $fileid 文件id
     */
    public function Approval_Upload(){
        $fileid                     = trim(I('id'));
        $key                        = D('Approval')->Arrangement($fileid);
        $this->userkey 		        = json_encode($key['key']);
        $this->file                 = $key['flie'];
        $this->display();
    }

    /**
     * file_upload 文件首次上传
     * file_id 文档id  file_url文档路径
     * file_name 文档名字 file_size 文档大小
     * type 文档类型 user_id 上级领导ID
     */
    public function file_upload(){
        $file['createtime']         = time();
        $file['file_id']            = trim($_POST['file_id']);
        $file['file_url']           = trim($_POST['file_url']);
        $file['file_name']          = trim($_POST['file_name']);
        $file['account_id']         = trim($_SESSION['userid']);
        $file['account_name']       = trim($_SESSION['name']);
        $file['file_size']          = trim($_POST['file_size']);
        $file['style']              = trim($_POST['type']);
        $file['pid_account_id']     = trim($_POST['user_id']);
        $add                        = D('Approval')->add_approval($file);
        if($add==1){
             $this->success('保存成功！');
        }else{
            $this->error('保存失败！请重新提交！');
        }
    }
    /**
     * create_file 创建文件
     * $file_name 文件名称 $file_date 审批天数
     * $status 1 新建 2 修改
     * $file_user 用户名称  $textarea 文件描述
     */
    function create_file(){
        $file['createtime']        = time();
        $file['account_id']        = $_SESSION['userid'];
        $file['account_name']      = trim($_POST['file_user']);
        $file['file_primary']      = trim($_POST['file_name']);
        $file['file_describe']     = trim($_POST['textarea']);
        $file['file_date']         = trim($_POST['file_date']);
        $file['category']          = trim($_POST['status']);
        $user                      = user_table($file['account_id']);
        $file                      = array_filter($file);
        if(empty($file['account_name'])){
            $this->error('数据错误！请重新提交！');die;
        }
        if(!empty($file['file_describe'])){
            $file['file_describe'] = htmlspecialchars($file['file_describe']);
        }
        $add                       = M('approval_flie')->add($file);
        if($add){
         $this->success('创建成功！');die;
        }else{
            $this->error('数据错误！请重新提交！');die;
        }
    }



    /**
     * Approval_Update 文档详情
     * $id 文档id
     */
    public function Approval_Update(){

        $id['id']                   = trim($_GET['id']);
        $query                      = D('Approval');
        if(is_numeric($id['id'])){
            $approval_r[1]          = $query->Approval_details($id);//确定有一个[加一个随意数]
            $approval               = $query->query_table($approval_r,1);
        }else{
            $this->error('数据错误！请重新打开页面！');die;
        }
        if(($_SESSION['userid']==13 || $_SESSION['userid']==1) && $approval_r[1]['type']==1 && $approval_r[1]['status']==2){
            $this ->status          = 2;
        }else{
            $this ->status          = 1;
        }
        $file_id['id']              = $approval_r[1]['file_id'];
        $file                       = M('approval_flie')->where($file_id)->find();//文件名称
        $this->file                 = $file;
        $this->department           = userinfo(user_table($file['account_id'])['departmentid'],2);
        $whe['id']                  = $approval_r[1]['id'];
        $whe['file_id']             = $approval_r[1]['file_id'];
        if($approval_r[1]['account_id']!==$_SESSION['userid']){
            $this->type             = 2;//判断不是上传文件本人
        }
        $this->judgmen              = $query->Approval_userinfo($whe);//审批人员显示
        $quer['file_url_id']        = $id['id'];
        $quer['file_id']            = $approval_r[1]['file_id'];
        $this->annotation           = M('approval_annotation')->where($quer)->select();//批注
        $this->approval             = $approval[1];//文档信息
        $where['post_name']         = array('like',"%经理%");
        $this->approver             = $query->Approver($where); //审批人员
        $sql['employee_member']     = array('like',"A%");
        $this->office               = $query->finaljudgment($sql,2); //审批人员
        $this->sercer               = $_SERVER['SERVER_NAME'].'/';

        $this->display();
    }

    /**
     * file_change 更改文件
     * file_url_id 文档id  file_id文件id
     * file_url 上传文档的url  file_name 上传的文件名称
     * file_size 上传文档的大小
     */
    public function file_change(){

        $where['file_id']           = trim($_POST['file_id']);
        $where['id']                = trim($_POST['file_url_id']);
        $file['modify_time']        = time();
        $file['modify_url']         = trim($_POST['file_url']);
        $file['modify_account_id']  = trim($_SESSION['userid']);
        $file['modify_name']        = trim($_SESSION['name']);
        $file['modify_filename']    = trim($_POST['file_name']);
        $file['modify_size']        = trim($_POST['file_size']);
        $save                       = D('Approval')->save_approval('approval_flie_url',$where,$file);
        if($save==1){
            $this->success('修改成功！');
        }elseif($save==2){
            $this->error('请修改自己的文档！');
        }else{
            $this->error('修改失败！请重新提交！');
        }
    }

    /**
     * add_final_judgment 添加终审和审批人员
     * check 审批人员id  judgment终审人员 id
     * file_id 文件id   file_url_id 文档id
     */
    public function add_final_judgment(){

        $file['file_id']        = trim($_POST['file_id']);
        $file['id']             = trim($_POST['file_url_id']);
        $judgment               = $_POST['judgment'];
        $check                  = $_POST['check'];
        $query                  = D('Approval');
        $type                   = $query->add_judgment($file,$judgment,$check);
        if($type==1){
            $this->success('添加审批人成功！');
        }elseif($type==2){
            $this->error('请不要重复提交！');
        }else{
            $this->error('添加审批人失败！请重新提交！');
        }
    }
    /**
     * add_annotation 提交批注
     */
    public function add_annotation(){
        $status                             = trim($_POST['status']);
        $comment                            = trim($_POST['comment']);
        $file['file_url_id']                = trim($_POST['file_url_id']);
        $file['file_id']                    = trim($_POST['file_id']);
        $query                              = D('Approval');
        $state                              = $query->add_file_annotation($file,$comment,$status);
        if($state==1){
            $this->success('添加数据成功！');
        }elseif($state==2){
            $this->error('添加数据失败！请重新添加！');
        }elseif($state==3){
            $this->error('添加数据不能为空!');
        }elseif($state==4){
            $this->success('驳回成功！');
        }elseif($state==5){
            $this->error('驳回失败!您的数据不完整！');
        }elseif($state==6){
            $this->error('提交失败!您没有权限！');
        }elseif($state==7){
            $this->error('数据已经驳回！请不要再次提交！');
        }
    }
}










