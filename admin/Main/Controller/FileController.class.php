<?php
namespace Main\Controller;
use Think\Controller;
use Think\Upload;
use Sys\P;

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
    
}