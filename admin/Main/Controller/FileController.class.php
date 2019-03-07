<?php
namespace Main\Controller;
use Think\Controller;
use Think\Upload;
use Sys\P;
ulib('Page');
use Sys\Page;

class FileController extends Controller {
    public function index ()
    {
        die();
    }
    
    /*
    public function upload_img ()
    {
        $upload = new Upload(C('UPLOAD_IMG_CFG'));
        $info = $upload->upload();
        $rs = array();
        if ($info) {
            
            foreach ($info as $row) {
                $rs['rs'] = 'ok';
                $rs['picurl'] = $upload->rootPath . $row['savepath'] . $row['savename'];
                $rs['thumb']  = thumb($rs['picurl'], C('DEFAULT_THUMB_W'), C('DEFAULT_THUMB_H'));
                break;
            }
            echo json_encode($rs);
            
        } else {
            $rs['rs']  = 'err';
            $rs['msg'] = '上传失败';
            echo json_encode($rs);
        }
    }
    */
    
    public function upload_file ()
    {
        $db = M('attachment');
        $upload = new Upload(C('UPLOAD_FILE_CFG'));
        $info = $upload->upload();
        $att = array();
        $rs = array();

        if ($info) {
            foreach ($info as $row) {
                $rs['rs'] = 'ok';
                $rs['fileurl'] = $upload->rootPath . $row['savepath'] . $row['savename'];
                if (in_array( strtolower($row['ext']), array('jpg','jpeg','png','gif','bmp','svg'))) {
                   // $rs['thumb']   = thumb($rs['fileurl'], C('DEFAULT_THUMB_W'), C('DEFAULT_THUMB_H'));
                    $att['isimage'] = 1;
                } else {
                    $att['isimage'] = 0;
                }
                
                $att['filesize']    = $row['size'];
                $att['fileext']     = $row['ext'];
                $att['filename']    = $row['name'];
                $att['filepath']    = $rs['fileurl'];
                $att['catid']       = I('catid');
                $att['userid']      = session('userid');
                $att['uploadtime']  = time();
                $att['uploadip']    = get_client_ip();
                $att['rel_id']      = 0;
                $att['hashcode']    = $row['md5'];
                
                $aid = $db->add($att);
                $rs['aid'] = $aid;
                $rs['aaa'] = M()->getlastsql();
                
                break;
            }
            
            echo json_encode($rs);
    
        } else {
            $rs['rs']  = 'err';
            $rs['msg'] = '上传失败';
            echo json_encode($rs);
        }
    }
    
    public function upload_file_ck ()
    {
        if (!isset($_GET['CKEditorFuncNum'])) {
            die();
        }
        
        $db = M('attachment');
        $upload = new Upload(C('UPLOAD_FILE_CFG'));
        $info = $upload->upload();
        $att = array();
        $rs = array();
    
        if ($info) {
            foreach ($info as $row) {
                $rs['rs'] = 'ok';
                $rs['fileurl'] = $upload->rootPath . $row['savepath'] . $row['savename'];
                if (in_array( strtolower($row['ext']), array('jpg','jpeg','png','gif','bmp','svg'))) {
                    // $rs['thumb']   = thumb($rs['fileurl'], C('DEFAULT_THUMB_W'), C('DEFAULT_THUMB_H'));
                    $att['isimage'] = 1;
                } else {
                    $att['isimage'] = 0;
                }
    
                $att['filesize']    = $row['size'];
                $att['fileext']     = $row['ext'];
                $att['filename']    = $row['name'];
                $att['filepath']    = $rs['fileurl'];
                $att['catid']       = I('catid');
                $att['userid']      = session('userid');
                $att['uploadtime']  = time();
                $att['uploadip']    = get_client_ip();
                $att['rel_id']      = 0;
                $att['hashcode']    = $row['md5'];
    
                $aid = $db->add($att);
                $rs['aid'] = $aid;
    
                break;
            }
    
            $path = $rs['fileurl'];
            $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
            
            die("<script type=\"text/javascript\">
					    window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ",'" . $path . "','');
                        </script>");
    
        } else {
            die("<script type=\"text/javascript\">alert('". $upload->getErrorMsg() ."');</script>");
        }
    }

    //公司管理手册
    public function company(){

        $db = M('files');

        //定义配置
        $this->type            = array('0'=>'文件夹','1'=>'文档');

        //取参
        $this->pid             = I('pid',0);

        //查询条件
        $where = array();
        $where['pid']          = $this->pid;

        //权限识别
        /*
        if (C('RBAC_SUPER_ADMIN') != cookie('userid')){

            $userid = cookie('userid');
            $roleid = cookie('roleid');

            $where['_string'] = ' (auth_group like "%'.$roleid.'%")  OR ( auth_user like "%'.$userid.'")   OR ( est_user_id = '.$userid.') ';

        }
        */

        //获取上级目录级别
        if($this->pid){
            $upfile = $db->find($this->pid);
            if(!$upfile || $upfile['file_type']){
                $this->error('目录不存在');
                die();
            }
            if($upfile)   $this->level = $upfile['level']+1;
        }else{
            $this->level  = 1;
        }

        $datalist = $db->where($where)->order('file_type desc')->select();
        foreach($datalist as $k=>$v){
            $datalist[$k]['file_type']	 = $this->type[$v['file_type']];
            if($v['file_type']==0){
                $datalist[$k]['url']         = U('Files/index',array('pid'=>$v['id']));
                $datalist[$k]['target']      = '';
            }else{
                $datalist[$k]['url']         = $v['file_path'];
                $datalist[$k]['target']      = 'target="_blank"';
            }
        }

        $this->datalist = $datalist;

        //文件路径
        $this->dir_path = array();
        if($this->pid) $this->dir_path = file_dir($this->pid);


        $this->display('Files/company');
    }

    //岗位作业指导书
    public function instruction(){

        $department         = I('department');
        $posts              = I('posts');
        $this->dep          = $department;
        $this->post         = $posts;

        $db                 = M('files');
        if (cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){
            $where          = array();
            if($department){
                $department         = '['.$department.']';
                $where['department']= array('like',"%$department%");
            }
            if ($posts){
                $posts              = '['.$posts.']';
                $where['posts']     = array('like',"%$posts%");
            }

        }else{
            $where              = array();
            $department         = '['.cookie('department').']';
            $where['department']= array('like',"%$department%");
            $posts              = '['.cookie('posts').']';
            $where['posts']     = array('like',"%$posts%");
        }
        //部门职责
        $where['file_tag']      = 1;
        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->zhize_pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->zhize            = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('est_time desc')->select();
        //岗位说明
        $where['file_tag']      = 2;
        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->shuoming_pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->shuoming         = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('est_time desc')->select();
        //相关规程
        $where['file_tag']      = 3;
        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->guicheng_pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->guicheng         = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('est_time desc')->select();
        //相关制度
        $where['file_tag']      = 4;
        $pagecount = $db->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->zhidu_pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->zhidu            = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order('est_time desc')->select();

        $this->departments      = M('salary_department')->getField('id,department',true);           //部门
        $this->posts            = M('posts')->where(array('post_name'=>array('neq','')))->select(); //岗位

        $this->display('Files/instruction');
    }
    
}