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

        $approval_table                 = 'approval_flie';
        $approval                       = $this->approval_table($approval_table);
        $this->approval                 = $approval['approval'];
        $this->pages                    = $approval['pages'];
        $this->display();
    }

    /**
     * Approval_list 文档列表 搜索文档
     * $file_id 文档 id
     */
    public function Approval_list(){
        $app                            = D('Approval');
        $where                          = $app->Jurisdiction();
        if($where==1){
            unset($where);
        }
        if(IS_POST){
            $file_name                  = trim($_POST['file_name']);
            $account_name               = trim($_POST['username']);
            $where['file_name']         = array('like',"%$file_name%");
            $where['account_name']      = array('like',"%$account_name%");
            $where                      = array_filter($where);
        }else{
            $id                         = trim($_GET['file_id']);
            if(is_numeric($id)){ //判断是否有传值
                $where['file_id']       = $id;
            }else{
                $this->error('数据错误!请重新打开！');
            }
        }
        $approval_table                 = 'approval_flie_url';
        $approval                       = $this->approval_table($approval_table,$where);
        $this->file_id                  = $id;
        $this->approval                 = $approval['approval']; //文件信息 -- 文件夹信息
        $this->pages                    = $approval['pages'];//分页
        $this->display();
    }

    /**
     * approval_table 查询列表详情
     * $approval_table 表名
     * $where 查询条件
     */
    public function approval_table($approval_table,$where){
        $where['type']              = 1;
        $count                      = M($approval_table)->where($where)->count();
        $page                       = new Page($count,10);
        $pages                      = $page->show();
        $approval                   = M($approval_table)->where($where)->limit("$page->firstRow","$page->listRows")->order('createtime desc')->select();
        $approval_w['approval']     = D('Approval')->query_table($approval);
        $approval_w['pages']        = $pages;
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
     * Approval_Update 文档详情
     * $id 文档id
     */
    public function Approval_Update(){
        $id['id']                   = (int)trim($_GET['id']);
        $query                      = D('Approval');
        if(is_numeric($id['id'])){
            $approval_r[1]          = $query->Approval_details($id);//确定有一个[加一个随意数]
            $approval               = $query->query_table($approval_r,1);
        }else{
            $this->error('数据错误！请重新打开页面！');
        }
        $this->approval             = $approval[1];//文档信息
        $where['post_name']         = array('like',"%经理%");
        $this->approver             = $query->Approver($where); //审批人员
        $sql['employee_member']     = array('like',"A%");
        $this->office               = $query->finaljudgment($sql,2); //审批人员

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
        //oa_approval_judgment
        $file['file_id']        = trim($_POST['file_id']);
        $file['file_url_id']    = trim($_POST['file_url_id']);
        $judgment               = $_POST['judgment'];
        $check                  = $_POST['check'];
        $query                  = D('Approval');
        $type                   = $query->add_judgment($file,$judgment,$check);
        if($type==1){
            $this->success('添加审批人成功！');
        }else{
            $this->error('添加审批人失败！请重新提交！');
        }
    }

 }










