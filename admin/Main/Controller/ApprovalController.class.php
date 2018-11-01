<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {

    //首页显示
    public function Approval_Index(){
        $count                  = M('approval_flie')->count();
        $page                   = new Page($count,10);
        $pages                  = $page->show();
        $approval               = M('approval_flie')->limit("$page->firstRow","$page->listRows")->order('createtime desc')->select();
        $update                 = D('Approval')->approval_update_sql($approval);//循环更改文件数据
        $this->file             = $update;
        $this->pages            = $pages;
        $this->display();
    }

    //选择审批人
    public function Approval_Upload(){
        $arr                    = explode(",",$_COOKIE['xuequ_approval']);
        for($i=0;$i<(count($arr)/4);$i++){
            for($k=0;$k<5;$k++){
                $array[$i][$k]  = $arr[$i*4+$k];
            }
        }
        //   $upload->getError();最后一次错误;
        $this->personnel        = personnel();
        $this->cooki            = $array;
        $this->display();
    }

    //上传文件和审批人
    public function Approval_file(){
        $user_id                = $_POST['user_id'];
        $style                  = $_POST['style'];
        $approval               = D('Approval');
        if($style==""){
            $approve_id         = code_number($_POST['approve_id'],1);
            if($approve_id==0){
                $this->error('保存文档数据失败!');
            }
        }
        $judge                  = $approval->approval_upload('approval_flie',$user_id,$style,$approve_id);
        if($judge==1){
            $this->success('保存文档数据成功!');//最后一次错误
        }else{

            $this->error('保存文档数据失败!');//最后一次错误
        }
    }

    //文件详情
    public function Approval_Update(){

        $id = code_number(trim(I('id')),1);//文件id

        $file[0]                = D('Approval')->approval_update($id);
        $this->id               = $id;
        $approval_file          = D('Approval')->approval_update_sql($file);//循环更改文件数据
        $this-> url = $_SERVER['SERVER_NAME'].'/'.$approval_file[0]['file']['file_url'];

        $this->assign('approval_file',$approval_file);
        $this->display();
    }

 }
