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
        $judge                  = $approval->approval_upload('oa_approval_flie',$user_id,$style);

        if($judge==1){
            $this->success('保存文档数据成功!');//最后一次错误
        }else{
            $this->error('保存文档数据失败!');//最后一次错误
        }
    }

    //文件详情
    public function Approval_Update(){
        header("Content-Type: text/html; charset=gb2312");
        $id = trim(I('id'));//文件id
        if(!is_numeric($id)){
            $this->error('您选择文件错误！请重新选择!', U('Approval/Approval_Index'));die;
        }
        $file[0]                = D('Approval')->approval_update($id);
        $this->id               = $id;
        $approval_file          = D('Approval')->approval_update_sql($file);//循环更改文件数据
        $myfile = fopen($file[0]['file_url'], "r") or die("Unable to open file!");
        $file_r= fread($myfile,filesize($approval_file[0]['file']['file_url']));
        $givenText = iconv('gbk', 'utf-8', $file_r); // 注释掉上面行后添加这行
        $text = new PHPWord_Section_Text($givenText, $styleFont, $styleParagraph);
        $this->_elementCollection[] = $text;
        fclose($myfile);

//        $str = file_get_contents($approval_file[0]['file']['file_url']);

//        print_r(fclose($myfile));die;
        $this->assign('file_r',$replace);
        $this->assign('approval_file',$approval_file);
        $this->display();
    }

 }