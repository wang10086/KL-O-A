<?php
namespace Main\Controller;
use Think\Controller;
use Think\Upload;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {
    protected $_pagetitle_ = '文件审批';

    public function index(){
        $this->title('文件列表');



        $this->displaY();
    }

    //上传文件
    public function upd_file(){
        $this->title('上传文件');
        if (isset($_POST['dosubmint'])){
            P($_POST);
        }else{

            $this->userkey              = get_username();
            $this->display();
        }
    }


    /**
     * Approval_upload_file 默认上传文件
     * upload 上传文件方法
     */
    public function Approval_upload_file()
    {
        $db                 = M('attachment');
        $upload             = new Upload(C('UPLOAD_FILE_CFG'));
        $info               = $upload->upload();
        $att                = array();
        $rs                 = array();
        if ($info) {
            foreach ($info as $row) {
                $rs['rs']       = 'ok';
                $rs['fileurl']  = $upload->rootPath . $row['savepath'] . $row['savename'];
                $rs['msg']      = '上传成功';
                break;
            }
            echo json_encode($rs);
        } else {
            $rs['rs']       = 'err';
            $rs['msg']      = '上传失败';
            echo json_encode($rs);
        }
    }

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
}










