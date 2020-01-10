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
            if ($list['status'] != 0){ $this->error('文件流转期间禁止编辑'); }
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

        //P($list);
        $this->display();
    }

    public function public_upload_file (){
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

    /**
     * 判断是否是PDF格式
     * @param $arr
     * @return int
     */
    private function isPDF($arr){
        $num                    = 0;
        foreach ($arr as $v){
            if (!in_array($v,array('pdf','PDF'))){
                $num++;
            }
        }
        return $num;
    }

    private function get_audit_users($str_uids){
        $uids                               = $str_uids ? array_filter(explode(',',$str_uids)) : '';
        $users                              = M('account')->where(array('id'=>array('in',$uids)))->getField('id,nickname',true);
        $str_users                          = $users ? implode(',',$users) : '<font color="#999">暂无人员</font>';
        $data                               = array();
        $data['uids']                       = $users ? array_keys($users) : '';
        $data['str_users']                  = $str_users;
        $data['users']                      = $users;
        return $data;
    }

    //文件详情
    public function file_detail(){
        $this->title('文件详情');
        $id                                 = I('id');
        if (!$id){ $this->error('获取数据失败'); }
        $db                                 = M('approval');
        $file_db                            = M('approval_files');
        $list                               = $db->find($id);
        $department                         = M('salary_department')->find($list['create_user_department']);
        if (in_array($list['status'],array(4,5))){ //从终审文件取值
            $str_file_ids                   = $list['sfile_annex_ids'] ? $list['sfile_id'].','.$list['sfile_annex_ids'] : $list['sfile_id'];
            //$old_str_file_ids               = $list['file_annex_ids'] ? $list['file_id'].','.$list['file_annex_ids'] : $list['file_id']; //初审文件
        }else{ //从初审文件取值
            $str_file_ids                   = $list['file_annex_ids'] ? $list['file_id'].','.$list['file_annex_ids'] : $list['file_id'];
        }
        $file_ids                           = array_filter(explode(',',$str_file_ids));
        $file_list                          = $file_db->where(array('id'=>array('in',$file_ids)))->select();
        $all_users                          = $list['audit_uids'].','.$list['audited_uids'];
        /*if ($old_str_file_ids){
            $old_file_ids                   = array_filter(explode(',',$old_str_file_ids));
            $old_file_list                  = $file_db->where(array('id'=>array('in',$old_file_ids)))->select();
            $this->old_file_list            = $old_file_list;
        }*/

        $this->list                         = $list;
        $this->department                   = $department;
        $this->file_list                    = $file_list;
        $this->status                       = C('FILE_STATUS');
        $this->all_audit_users              = $this->get_audit_users($all_users); //全部人员信息
        $this->audit_users                  = $this->get_audit_users($list['audit_uids']); //未审核人员信息
        $this->audited_users                = $this->get_audit_users($list['audited_uids']); //已审核人员信息
        $this->display();
    }

    //文件审核
    public function file_audit(){
        $this->title('文件审核');
        $appid                              = I('appid');
        $file_id                            = I('fid');
        if (!$appid || !$file_id){ $this->error('获取数据失败'); }
        $db                                 = M('approval');
        $file_db                            = M('approval_files');
        $record_db                          = M('approval_record');
        $list                               = $db->find($appid);
        $department                         = M('salary_department')->find($list['create_user_department']);
        $file_list                          = $file_db->find($file_id);
        $record_list                        = $record_db->where(array('file_id'=>$file_id))->order('id asc')->select();
        $server_name                        = $_SERVER['SERVER_NAME'];
        $file_url                           = 'http://'.$server_name.'/'.$file_list['filepath'];

        $this->audit_uids                   = explode(',',$list['audit_uids']);
        $this->list                         = $list;
        $this->department                   = $department;
        $this->file_list                    = $file_list;
        $this->record_list                  = $record_list;
        $this->status                       = C('FILE_STATUS');
        $this->file_url                     = $file_url;

        $this->display();
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
                $file_ids                   = array_keys($newname_all);
                $fileext                    = M('approval_files')->where(array('id'=>array('in',$file_ids)))->getField('fileext',true); //文件类型
                $isNotPDF                   = $this->isPDF($fileext);

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
                if ($isNotPDF){
                    $msg                    = '请上传PDF格式文件';
                    $this->returnFunction($num,$msg);
                    //$this->error('请上传PDF格式文件');
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
                $save['type']               = $info['type'];
                $save['status']             = 0; //未提交
                if ($id){
                    $res                    = $db->where(array('id'=>$id))->save($save);
                }else{
                    $save['create_user_department'] = session('department');
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
                    $read                   = array();
                    $read['type']           = P::UNREAD_AUDIT_FILE;
                    $read['req_id']         = $id;
                    $read['userids']        = $list['audit_uids'];
                    $read['create_time']    = NOW_TIME;
                    $read['read_type']      = 0;
                    M('unread')->add($read);
                    $this->success('提交成功',U('Approval/index'));
                }else{
                    $this->error('提交审核失败');
                }
            }

            //保存审核信息
            if ($saveType == 3){
                $db                             = M('approval_record');
                $file_id                        = I('file_id');
                $appid                          = I('appid');
                $file_content                   = trim(I('file_content'));
                $suggest                        = trim(I('suggest'));
                $num                            = 0;

                if (!$file_id || !$appid){
                    $msg                        = '获取文件信息失败';
                    $this->returnFunction($num,$msg);
                }
                if (!$file_content){
                    $msg                        = '请输入原文件内容';
                    $this->returnFunction($num,$msg);
                }
                if (!$suggest){
                    $msg                        = '请输入您的修改意见';
                    $this->returnFunction($num,$msg);
                }

                $data                           = array();
                $data['file_id']                = $file_id;
                $data['file_content']           = $file_content;
                $data['suggest']                = $suggest;
                $data['create_user']            = cookie('userid');
                $data['create_user_name']       = cookie('nickname');
                $data['create_time']            = NOW_TIME;
                $res                            = $db->add($data);
                if ($res){
                    $num++;
                    $msg                        = '保存成功';
                }else{
                    $msg                        = '保存失败';
                }
                $this->returnFunction($num,$msg);
            }

            //修改审核记录
            if ($saveType == 4){
                $db                 = M('approval_record');
                $id                 = I('id');
                $file_content       = trim(I('file_content'));
                $suggest            = trim(I('suggest'));
                if (!$file_content){
                    $this->msg      = '原文件内容不能为空';
                    $this->display('audit_ok');
                }
                if (!$suggest){
                    $this->msg      = '修改意见不能为空';
                    $this->display('audit_ok');
                }

                $data               = array();
                $data['file_content']= $file_content;
                $data['suggest']    = $suggest;
                $res                = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $this->msg      = '修改成功';
                }else{
                    $this->msg      = '修改失败';
                }
                $this->display('audit_ok');
            }

            //保存上传终审文件信息
            if ($saveType == 5){
                $num                        = 0;
                $db                         = M('approval');
                $sure_uid                   = I('sure_uid');
                $id                         = I('id',0);
                $newname                    = I('newname'); //主文件
                $fileid                     = I('fileid');
                $newname_annex              = I('newname_annex'); //附件
                $fileid_annex               = I('fileid_annex');
                $newname_all                = $this->get_newFileName_arr($newname,$newname_annex);
                $this->save_file_new_name($newname_all); //保存文件信息
                $file_ids                   = array_keys($newname_all);
                $fileext                    = M('approval_files')->where(array('id'=>array('in',$file_ids)))->getField('fileext',true); //文件类型
                $isNotPDF                   = $this->isPDF($fileext);

                if (!$sure_uid){
                    $msg                    = '终审人员信息错误';
                    $this->returnFunction($num,$msg);
                }
                if (!$id){
                    $msg                    = '参数错误';
                    $this->returnFunction($num,$msg);
                }
                if ($isNotPDF){
                    $msg                    = '请上传PDF格式文件';
                    $this->returnFunction($num,$msg);
                }
                if (!$fileid){
                    $msg                    = '主文件不能为空';
                    $this->returnFunction($num,$msg);
                }
                if (count($fileid) > 1){
                    $msg                    = '主文件数量只能是一个';
                    $this->returnFunction($num,$msg);
                }

                $data                       = array();
                $data['sure_uid']           = $sure_uid;
                $data['sfile_id']           = implode(',',$fileid);
                $data['sfile_annex_ids']    = $fileid_annex ? implode(',',$fileid_annex) : '';
                $data['status']             = 4; //已提交总经理审核
                $res                        = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    //源文件审核内容带过来
                    $app_list               = $db->find($id);
                    if (($app_list['file_id'] != $app_list['sfile_id']) && $app_list['sfile_id']){ //主文件有作修改
                        $this->saveNewFileRecordLists($app_list['file_id'],$app_list['sfile_id']);
                    }

                    $num++;
                    $msg                    = '提交成功';

                    //菜单栏增加红点提示
                    $unread_db              = M('unread');
                    $unread_list            = $unread_db->where(array('type'=>P::UNREAD_AUDIT_FILE,'req_id'=>$id))->find();
                    $unread                 = array();
                    $unread['userids']      = $unread_list['userids'] ? $unread_list['userids'].','.$sure_uid : $sure_uid;
                    $unread['read_type']    = 0;
                    $unread_db->where(array('id'=>$unread_list['id']))->save($unread);
                }else{
                    $msg                    = '数据保存失败';
                }
                $this->returnFunction($num,$msg);
            }

            //保存最终审核信息
            if ($saveType == 6){
                $db                             = M('approval_record');
                $file_id                        = I('file_id');
                $appid                          = I('appid');
                $file_content                   = trim(I('file_content'));
                $suggest                        = trim(I('suggest'));
                $num                            = 0;

                if (!$file_id || !$appid){
                    $msg                        = '获取文件信息失败';
                    $this->returnFunction($num,$msg);
                }
                if (!$file_content){
                    $msg                        = '请输入原文件内容';
                    $this->returnFunction($num,$msg);
                }
                if (!$suggest){
                    $msg                        = '请输入您的修改意见';
                    $this->returnFunction($num,$msg);
                }

                $data                           = array();
                $data['file_id']                = $file_id;
                $data['file_content']           = $file_content;
                $data['suggest']                = $suggest;
                $data['create_user']            = cookie('userid');
                $data['create_user_name']       = cookie('nickname');
                $data['create_time']            = NOW_TIME;
                $res                            = $db->add($data);
                if ($res){
                    $num++;
                    $msg                        = '保存成功';
                }else{
                    $msg                        = '保存失败';
                }
                $this->returnFunction($num,$msg);
            }

            //最终审核完毕,提交审核
            if ($saveType == 7){
                $appid                      = I('appid');
                if (!$appid){ $this->error('数据错误'); }
                $db                         = M('approval');
                $data                       = array();
                $data['sure_time']          = NOW_TIME;
                $data['status']             = 5; //总经理审核通过
                $res                        = $db->where(array('id'=>$appid))->save($data);

                if ($res){
                    $list                   = $db->find($id);
                    //给发布者发送系统消息
                    $uid                    = cookie('userid');
                    $title                  = '关于文件流转终审结果的反馈!';
                    $content                = '文件名称：'.$list['file_name'];
                    $url                    = U('Approval/file_detail',array('id'=>$appid));
                    $user                   = '['.$list['create_user'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $this->read_res($appid,P::UNREAD_AUDIT_FILE); //更新提示红点
                    $this->success('保存成功');
                }else{
                    $this->error('提交数据失败');
                }
            }

            //提交初审结果
            if ($saveType == 8){
                $appid                      = I('appid');
                if (!$appid){ $this->error('数据错误'); }

                $this->save_approval_stu($appid,cookie('userid')); //更新审核人信息
                $this->read_res($appid,P::UNREAD_AUDIT_FILE); //更新提示红点
                $this->success('保存成功');
            }
        }
    }

    /**
     * 把源文件的审核结果带入新文件
     * @param $old_file_id
     * @param $new_file_id
     */
    private function saveNewFileRecordLists($old_file_id,$new_file_id){
        $db                                 = M('approval_record');
        $record_lists                       = $db->where(array('file_id'=>$old_file_id))->select();
        if ($record_lists){
            foreach ($record_lists as $v){
                $data                       = array();
                $data['file_id']            = $new_file_id;
                $data['file_content']       = trim($v['file_content']);
                $data['suggest']            = $v['suggest'];
                $data['create_user']        = $v['create_user'];
                $data['create_user_name']   = $v['create_user_name'];
                $data['create_time']        = $v['create_time'];
                $db->add($data);
            }
        }
    }

    /**
     * 更新审核人信息
     * @param $approval_id
     * @param $user_id
     */
    private function save_approval_stu($approval_id,$user_id){
        $db                                 = M('approval');
        $list                               = $db->find($approval_id);
        $audit_uids                         = array_filter(explode(',',$list['audit_uids']));
        $audited_uids                       = array_filter(explode(',',$list['audited_uids']));
        $new_audit_uids                     = array();
        foreach ($audit_uids as $v){
            if ($v != $user_id){
                $new_audit_uids[]           = $v;
            }else{
                if (!in_array($v,$audited_uids)){
                    $audited_uids[]         = $v;
                }
            }
        }
        $data                               = array();
        $data['audit_uids']                 = implode(',',$new_audit_uids);
        $data['audited_uids']               = implode(',',$audited_uids);
        if (!$data['audit_uids']){
            $data['audited_time']           = NOW_TIME;
        }
        if(!$data['audit_uids']){
            $data['status']                 = 3; //流转完成,已返回至发布者
            //给发布者发送系统消息
            $uid                            = cookie('userid');
            $title                          = '关于文件流转结果的反馈!';
            $content                        = '文件名称：'.$list['file_name'];
            $url                            = U('Approval/file_detail',array('id'=>$approval_id));
            $user                           = '['.$list['create_user'].']';
            send_msg($uid,$title,$content,$url,$user,'');
        }
        $db->where(array('id'=>$approval_id))->save($data);
    }

    //编辑审核记录
    public function edit_record(){
        $record_id                          = I('rid');
        $file_id                            = I('fid');
        $this->file                         = M('approval_files')->find($file_id);
        $this->record                       = M('approval_record')->find($record_id);

        $this->display();
    }

    //删除审核记录
    public function del_record(){
        $id                                 = I('id');
        $db                                 = M('approval_record');
        $res                                = $db->where(array('id'=>$id))->delete();
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除数据失败');
        }
    }

    //上传终审文件
    public function file_re_upload(){
        $this->title('上传文件');
        $id                         = I('id',0);
        if ($id){
            $db                     = M('approval');
            $file_db                = M('approval_files');
            $list                   = $db->find($id);
            if ($list['status'] != 3){ $this->error('非法操作'); }
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

    //最终审核
    public function file_re_audit(){
        $this->title('文件审核');
        $appid                              = I('appid');
        $file_id                            = I('fid');
        if (!$appid || !$file_id){ $this->error('获取数据失败'); }
        $db                                 = M('approval');
        $file_db                            = M('approval_files');
        $record_db                          = M('approval_record');
        $list                               = $db->find($appid);
        $department                         = M('salary_department')->find($list['create_user_department']);
        $file_list                          = $file_db->find($file_id);
        $record_list                        = $record_db->where(array('file_id'=>$file_id))->order('id asc')->select();
        $server_name                        = $_SERVER['SERVER_NAME'];
        $file_url                           = 'http://'.$server_name.'/'.$file_list['filepath'];

        $this->list                         = $list;
        $this->department                   = $department;
        $this->file_list                    = $file_list;
        $this->record_list                  = $record_list;
        $this->status                       = C('FILE_STATUS');
        $this->file_url                     = $file_url;

        $this->display();
    }

    //打印文件审批单(文件审核记录)
    public function print_file_audit_record(){
        $appid                              = I('appid');
        $file_id                            = I('fileid');
        if (!$appid || !$file_id){ $this->error('获取数据错误'); }
        $db                                 = M('approval');
        $file_db                            = M('approval_files');
        $record_db                          = M('approval_record');
        $list                               = $db->find($appid);
        $department                         = M('salary_department')->find($list['create_user_department']);
        $file_list                          = $file_db->find($file_id);
        $record_list                        = $record_db->where(array('file_id'=>$file_id))->order('id asc')->select();

        $this->list                         = $list;
        $this->department                   = $department;
        $this->file_list                    = $file_list;
        $this->record_list                  = $record_list;
        $this->status                       = C('FILE_STATUS');
        $this->display();
    }

    //删除文件
    public function file_del(){
        $id                                 = I('id');
        if (!$id){ $this->error('删除数据失败'); }
        $list                               = M('approval')->find($id);
        $file_ids                           = $this->get_file_ids($list);
        M('approval_record')->where(array('file_id'=>array('in',$file_ids)))->delete();
        M('approval_files')->where(array('id'=>array('in',$file_ids)))->delete();
        M('approval')->where(array('id'=>$id))->delete();
        M('unread')->where(array('type'=>P::UNREAD_AUDIT_FILE,'req_id'=>$id))->delete();
        $this->success('删除成功');
    }

    private function get_file_ids($list){
        $file_id                            = explode(',',$list['file_id']); //流转文件详情
        $file_annex_ids                     = explode(',',$list['file_annex_ids']); //流转附件ID信息
        $sfile_id                           = explode(',',$list['sfile_id']); //最终审核文件详情
        $sfile_annex_ids                    = explode(',',$list['sfile_annex_ids']); //最终审核附件ID信息
        $arr                                = array();
        foreach ($file_id as $k=>$v){
            if ($v){ $arr[]                 = $v; }
        }
        foreach ($file_annex_ids as $k=>$v){
            if ($v){ $arr[]                 = $v; }
        }
        foreach ($sfile_id as $k=>$v){
            if ($v){ $arr[]                 = $v; }
        }
        foreach ($sfile_annex_ids as $k=>$v){
            if ($v){ $arr[]                 = $v; }
        }
        $data                               = array_filter(array_unique($arr));
        return $data;
    }
}










