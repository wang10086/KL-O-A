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
        $judge                  = $approval->approval_upload('approval_flie',$user_id,$style);

        if($judge==1){
            $this->success('保存文档数据成功!');//最后一次错误
        }else{

            $this->error('保存文档数据失败!');//最后一次错误
        }
    }

    //文件详情
    public function Approval_Update(){

//        Vendor('PHPWord.PHPWord');//引入wordphp文件
//        $PHPWord = new \PHPWord();//初始化PHPWord对象

        $id = trim(I('id'));//文件id
        if(!is_numeric($id)){
            $this->error('您选择文件错误！请重新选择!', U('Approval/Approval_Index'));die;
        }
        $file[0]                = D('Approval')->approval_update($id);
        $this->id               = $id;
        $approval_file          = D('Approval')->approval_update_sql($file);//循环更改文件数据


//        $myfile = fopen($file[0]['file_url'], "rb") or die("Unable to open file!");
//        $file_r= fread($myfile,filesize($file[0]['file_url']));//
//        $content = mb_convert_encoding($file_r, "utf8", "auto");
//        fclose($content);


        $fh = fopen($file[0]['file_url'], "rb");
//仅读取前面的8个字节
        $head = fread($fh, 8);
        fclose($fh);

        print_r($fh);die;




        $this->assign('file_r',$content);
        $this->assign('approval_file',$approval_file);
        $this->display();
    }

 }