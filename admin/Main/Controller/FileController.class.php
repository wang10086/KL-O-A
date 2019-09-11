<?php
namespace Main\Controller;
use Think\Controller;
use Think\Upload;
use Sys\P;
ulib('Page');
use Sys\Page;

class FileController extends BasepubController {
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
                $att['userid']      = session('userid')?session('userid'):0;
                $att['uploadtime']  = time();
                $att['uploadip']    = get_client_ip();
                $att['rel_id']      = 0;
                $att['hashcode']    = $row['md5'];
                
                $aid = $db->add($att);
                $rs['aid'] = $aid;

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

    //公司通用
    public function companyFile(){
        $this->title('公司通用文件');
        $db                             = M('files');
        $file_type                      = C('FILE_TAG')[1];
        $pin                            = I('pin',0);
        $department                     = I('department',0);
        $posts                          = I('posts',0);
        $fileName                       = trim(I('fileName'));
        $fileTags                       = $this->get_file_tag();
        $file_tags                      = array_keys($file_type);

        $where                          = array();
        $where['file_type']             = 1; //文件
        $where['file_tag']              = $pin ? $pin : array('in',$file_tags);
        if ($fileName) $where['file_name']  = array('like','%'.$fileName.'%');
        if (cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){
            $department                     = $department ? '['.$department.']' : '['.session('department').']';
            $posts                          = $posts ? '['.$posts.']' : '['.session('posts').']';
            $where['_string']               = "(department like '%$department%') OR ( posts like '%$posts%')";
        }else{
            $department                     = '['.session('department').']';
            $posts                          = '['.session('posts').']';
            $where['_string']               = "(department like '%$department%') OR ( posts like '%$posts%')";
        }

        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('est_time'))->select();

        $this->lists                    = $lists;
        $this->departments              = M('salary_department')->getField('id,department',true);
        $this->department               = $department;
        $this->posts                    = $posts;
        $this->pin                      = $pin;
        $this->fileTags                 = $fileTags;
        $this->file_type                = $file_type;
        $this->display('Files/companyFile');
    }

    //部门通用
    public function departmentFile(){
        $this->title('部门通用文件');
        $db                             = M('files');
        $file_type                      = C('FILE_TAG')[2];
        $pin                            = I('pin',0);
        $department                     = I('department',0);
        $posts                          = I('posts',0);
        $fileName                       = trim(I('fileName'));
        $fileTags                       = $this->get_file_tag();
        $file_tags                      = array_keys($file_type);

        $where                          = array();
        $where['file_type']             = 1; //文件
        $where['file_tag']              = $pin ? $pin : array('in',$file_tags);
        if ($fileName) $where['file_name']  = array('like','%'.$fileName.'%');
        if (cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){
            $department                     = $department ? '['.$department.']' : '['.session('department').']';
            $where['department']            = array('like','%'.$department.'%');
            //$posts                          = $posts ? '['.$posts.']' : '['.session('posts').']';
            //$where['posts']                 = array('like','%'.$posts.'%');
        }else{
            $department                     = '['.session('department').']';
            $where['department']            = array('like','%'.$department.'%');
            //$posts                          = '['.session('posts').']';
            //$where['posts']                 = array('like','%'.$posts.'%');
        }

        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('est_time'))->select();

        $this->lists                    = $lists;
        $this->departments              = M('salary_department')->getField('id,department',true);
        $this->department               = $department;
        $this->posts                    = $posts;
        $this->pin                      = $pin;
        $this->fileTags                 = $fileTags;
        $this->file_type                = $file_type;
        $this->display('Files/departmentFile');
    }

    //岗位专用
    public function postFile(){
        $this->title('岗位专用文件');
        $db                             = M('files');
        $file_type                      = C('FILE_TAG')[3];
        $pin                            = I('pin',0);
        $department                     = I('department',0);
        $posts                          = I('posts',0);
        $fileName                       = trim(I('fileName'));
        $fileTags                       = $this->get_file_tag();
        $file_tags                      = array_keys($file_type);

        $where                          = array();
        $where['file_type']             = 1; //文件
        $where['file_tag']              = $pin ? $pin : array('in',$file_tags);
        if ($fileName) $where['file_name']  = array('like','%'.$fileName.'%');
        if (cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){
            //$department                     = $department ? '['.$department.']' : '['.session('department').']';
            //$where['department']            = array('like','%'.$department.'%');
            $posts                          = $posts ? '['.$posts.']' : '['.session('posts').']';
            $where['posts']                 = array('like','%'.$posts.'%');
        }else{
            //$department                     = '['.session('department').']';
            //$where['department']            = array('like','%'.$department.'%');
            $posts                          = '['.session('posts').']';
            $where['posts']                 = array('like','%'.$posts.'%');
        }

        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('est_time'))->select();

        $this->lists                    = $lists;
        $this->departments              = M('salary_department')->getField('id,department',true);
        $this->department               = $department;
        $this->posts                    = $posts;
        $this->pin                      = $pin;
        $this->fileTags                 = $fileTags;
        $this->file_type                = $file_type;
        $this->display('Files/postFile');
    }

    public function get_file_tag(){
        $file_tag               = C('FILE_TAG');
        $new_array              = $file_tag[1] + $file_tag[2] + $file_tag[3];
        return $new_array;
    }

    public function exportTest(){
        $db                     = M('files');
        $lists                  = $db->where(array('file_type'=>1))->field('file_name,est_time')->order('est_time asc')->select();
        $data                   = array();
        foreach ($lists as $k=>$v){
            $data[$k]['file_name']  = trim($v['file_name']);
            $data[$k]['create_time']= date('Y-m-d H:i:s',$v['est_time']);
        }
        $title                  = array('文件名称','上传时间');
        exportexcel($data,$title,'文件信息');
    }
    
}