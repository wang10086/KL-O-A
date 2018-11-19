<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {

    //首页显示
    public function Approval_Index(){

        $approval_table                 = 'approval_flie';
        $approval                       = $this->approval_table($approval_table);
        $this->approval                 = $approval['approval'];
        $this->pages                    = $approval['pages'];
        $this->display();
    }

    /**
     * Approval_list 文件夹 文档列表
     *$file_id 文档 id
     */
    public function Approval_list(){
        $arr                            = array("11", "55", "77", "32","38","1","12","13");
        if(in_array($_SESSION['userid'],$arr)){
        }else{
            $where['account_id']        = $_SESSION['userid'];
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
                $this->error('数据错误!请重新打开！');//最后一次错误
            }
        }
        $approval_table                 = 'approval_flie_url';
        $approval                       = $this->approval_table($approval_table,$where);
        $this->file_id                  = $id;
        $this->approval                 = $approval['approval']; //文件信息 -- 文件夹信息
        $this->pages                    = $approval['pages'];//分页
        $this->display();
    }

    // 查询列表详情
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

    //编辑文件
    public function Approval_Upload(){
        $fileid                     = trim(I('id'));
        $key                        = D('Approval')->Arrangement($fileid);
        $this->userkey 		        = json_encode($key['key']);
        $this->file                 = $key['flie'];
        $this->display();
    }
    //文件首次上传
    public function file_upload(){
        $file['createtime']         = time();
        $file['file_id']            = trim($_POST['file_id']);
        $file['file_url']           = trim($_POST['file_md_name']);
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
    //文件详情
    public function Approval_Update(){
        $id['id']                   = (int)trim($_GET['id']);
        if(is_numeric($id['id'])){
            $approval_r[1]          = D('Approval')->Approval_details($id);//确定有一个[加一个随意数]
            $this->approval         = D('Approval')->query_table($approval_r,1);
        }else{
            $this->error('数据错误！请重新打开页面！');
        }
        $this->display();
    }

 }
