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
        $title              = trim(I('title'));
        $user               = trim(I('uname'));
        $where              = array();
        if ($title) $where['file_name'] = array('like','%'.$title.'%');
        if ($user) $where['create_user_name'] = array('like','%'.$user.'%');

        //分页
        $pagecount		    = M('approval')->where($where)->count();
        $page			    = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $list               = M('approval')->where($where)->limit($page->firstRow , $page->listRows)->order($this->orders('id'))->select();

        $this->list         = $list;
        $this->file_status  = C('FILE_STATUS');
        $this->display();
    }

    //上传文件
    public function file_upload(){
        $this->title('上传文件');
        $id                         = I('id',0);
        if ($id){
            $db                     = M('approval');
            $file_db                = M('approval_files');
            $list                   = $db->find($id);
            if ($list['status'] != 0){ $this->error('禁止编辑'); }
            $annex_ids              = $list['file_annex_ids'] ? explode(',',$list['file_annex_ids']) : '';
            $audit_uids             = $list['audit_uids'] ? explode(',',$list['audit_uids']) : '';
            $file                   = $file_db -> where(array('id'=>$list['file_id']))->find();
            $annex_files            = $file_db -> where(array('id'=>array('in',$annex_ids)))->select();
            $audit_users            = M('account')->where(array('id'=>array('in',$audit_uids)))->field('id,nickname')->select();
            $this->list             = $list;
            $this->file             = $file; //主文件
            $this->annex_files      = $annex_files; //附件
            $this->audit_users      = $audit_users;
        }
        $this->userkey              = get_username();
        $this->display();
    }

    public function public_upload_file ()
    {
        $db                         = M('approval_files');
        $upload                     = new Upload(C('UPLOAD_FILE_CFG'));
        $info                       = $upload->upload();
        $att                        = array();
        $rs                         = array();

        if ($info) {
            foreach ($info as $row) {
                $rs['rs'] = 'ok';
                $rs['fileurl'] = $upload->rootPath . $row['savepath'] . $row['savename'];

                $att['filesize']    = $row['size'] ? $row['size'] : 0;
                $att['fileext']     = $row['ext'] ? $row['ext'] : 0;
                $att['filename']    = $row['name'] ? $row['name'] : 0;
                $att['filepath']    = $rs['fileurl'] ? $rs['fileurl'] : '00001';
                $att['fileType']    = I('fileType') ? I('fileType') : 9;
                $att['userid']      = session('userid')?session('userid'):0;
                $att['uploadtime']  = time();
                $att['uploadip']    = get_client_ip();
                $att['hashcode']    = $row['md5'];
                $aid                = $db->add($att);
                $rs['aid']          = $aid;
                break;
            }
            echo json_encode($rs);

        } else {
            $rs['rs']               = 'err';
            $rs['msg']              = '上传失败';
            echo json_encode($rs);
        }
    }

    public function public_save(){
        $saveType                   = I('saveType');
        $num                        = 0;
        if (isset($_POST['dosubmint']) && $saveType){
            //保存上传审核文件基本信息
            if ($saveType == 1){
                $db                         = M('approval');
                $id                         = I('id',0);
                $info                       = I('info');
                $data                       = I('data');
                $newname                    = I('newname'); //主文件
                $fileid                     = I('fileid');
                $newname_annex              = I('newname_annex'); //附件
                $fileid_annex               = I('fileid_annex');
                $audit_uids                 = implode(',',array_column($data,'audit_uids'));
                $day                        = trim($info['day']) ? intval($info['day']) : 0;
                $newname_all                = $this->get_newFileName_arr($newname,$newname_annex);
                $this->save_file_new_name($newname_all); //保存文件信息

                if (!$audit_uids){
                    $msg                    = '审核人员不能为空';
                    $this->returnFunction($num,$msg);
                    //$this->error('审核人员不能为空');
                }
                if ($day < 1){
                    $msg                    = '文件流转时间填写错误';
                    $this->returnFunction($num,$msg);
                    //$this->error('文件流转时间填写错误');
                }
                if (!$fileid){
                    $msg                    = '主文件不能为空';
                    $this->returnFunction($num,$msg);
                    //$this->error('主文件不能为空');
                }
                if (count($fileid) > 1){
                    $msg                    = '主文件数量只能是一个';
                    $this->returnFunction($num,$msg);
                    //$this->error('主文件数量只能是一个');
                }
                $save                       = array();
                $save['file_name']          = implode(',',$newname);
                $save['file_id']            = implode(',',I('fileid'));
                $save['file_annex_ids']     = $fileid_annex ? implode(',',$fileid_annex) : '';
                $save['sfile_id']           = '';
                $save['sfile_annex_ids']    = '';
                $save['content']            = trim($info['content']);
                $save['day']                = $day ? $day : 3;
                $save['plan_time']          = strtotime(getAfterWorkDay($save['day']));
                $save['audit_uids']         = $audit_uids;
                $save['create_user']        = $info['create_user'];
                $save['create_user_name']   = $info['create_user_name'];
                $save['status']             = 0; //未提交
                if ($id){
                    $res                    = $db->where(array('id'=>$id))->save($save);
                }else{
                    $save['create_time']    = NOW_TIME;
                    $res                    = $db->add($save);
                }

                if ($res){
                    $num++ ;
                    $msg                    = '保存成功';
                }else{
                    $msg                    = '保存失败';
                }
                $this->returnFunction($num,$msg);
            }

            //保存提交审核信息
            if ($saveType == 2){
                $id                         = I('id');
                if (!$id){ $this->error('请先保存数据'); }
                $db                         = M('approval');
                $list                       = $db->find($id);
                $data                       = array();
                $data['status']             = 1; //已提交
                $res                        = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $read                               = array();
                    $read['type']                       = P::UNREAD_AUDIT_FILE;
                    $read['req_id']                     = $id;
                    $read['userids']                    = $list['audit_uids'];
                    $read['create_time']                = NOW_TIME;
                    $read['read_type']                  = 0;
                    M('unread')->add($read);
                    $this->success('提交成功',U('Approval/index'));
                }else{
                    $this->error('提交审核失败');
                }
            }
        }
    }

    private function returnFunction($num,$msg){
        $returnMsg['num']       = $num;
        $returnMsg['msg']       = $msg;
        $this->ajaxReturn($returnMsg);
    }

    private function get_newFileName_arr($arr1,$arr2){
        $arr                    = array();
        foreach ($arr1 as $k=>$v){
            $arr[$k]            = $v;
        }
        foreach ($arr2 as $k2=>$v2){
            $arr[$k2]           = $v2;
        }
        return $arr;
    }

    private function save_file_new_name($newname_all){
        $db                     = M('approval_files');
        foreach ($newname_all as $k=>$v){
            $data               = array();
            $data['newFileName']= $v;
            $db->where(array('id'=>$k))->save($data);
        }
    }

    public function file_detail(){
        $this->title('文件详情');
        $id                                 = I('id');
        if (!$id){ $this->error('获取数据失败'); }

        $this->display();
    }
}










