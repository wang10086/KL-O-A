<?php

/**
 * 保存待办事宜
 * @param $process_node
 * @param $pro_status
 * @param string $title
 * @param int $req_id
 * @param string $to_postids
 * @param string $to_uid
 * @param string $to_uname
 * @param string $year
 * @param string $timeType
 */
function save_process_log($process_node,$pro_status,$title='',$req_id=0,$to_postids='',$to_uid='0',$to_uname='',$year='',$timeType=0){
    $db                 = M('process_log');
    $node_list          = M('process_node')->field('processTypeId,processId')->where(array('id'=>$process_node))->find();

    $data               = array();
    $data['p_id']       = $node_list['processId'];
    $data['pnode_id']   = $process_node;
    $data['ptype_id']   = $node_list['processTypeId'];
    $data['title']      = $title;
    $data['req_id']     = $req_id;
    $data['req_uid']    = cookie('userid');
    $data['req_uname']  = cookie('nickname');
    $data['req_time']   = NOW_TIME;
    $data['to_postids'] = $to_postids;
    $data['to_uid']     = $to_uid;
    $data['to_uname']   = $to_uname;
    $data['pro_status'] = $pro_status;
    $data['year']       = $year;
    $data['timeType']   = $timeType;

    $where              = array();
    $where['pnode_id']  = $data['pnode_id'];
    $where['req_id']    = $data['req_id'];
    $where['pro_status']= array('neq','-1');
    $where['req_uid']   = $data['req_uid'];
    $where['to_postids']= $data['to_postids'];
    $where['to_uid']    = $data['to_uid'];

    /*$map                = array();
    $map['to_postids']  = $data['to_postids'];
    $map['to_uid']      = $data['to_uid'];
    $map['_logic']      = 'or';
    $where['_complex']  = $map;*/
    $list               = $db->where($where)->find();
    $res                = $list ? $db->where(array('id'=>$list['id']))->save($data) : $db->add($data);
}

//根据流程节点自动生成提示信息
function process_node_to_log(){
    $nodeLists          = M('process_node')->select();

    foreach ($nodeLists as $k=>$v){
        if (in_array($v['id'],array(6,12,13,7))){ //6=>提交业务季产品手册、业务季销售PPT、公司宣传手册; 12=>批准发布业务季产品手册、业务季销售PPT、公司宣传手册; 13=>审定培训PPT
            $timeLists  = M('process_node_time')->where(array('nodeId'=>$v['id']))->select();
            if ($timeLists){
                foreach ($timeLists as $kk=>$vv){
                    $st_month       = str_pad($vv['st_month'],2,'0',STR_PAD_LEFT);
                    $st_day         = str_pad($vv['st_day'],2,'0',STR_PAD_LEFT);
                    $et_month       = str_pad($vv['et_month'],2,'0',STR_PAD_LEFT);
                    $et_day         = str_pad($vv['et_day'],2,'0',STR_PAD_LEFT);
                    $time1          = strtotime(date('Y').$st_month.$st_day);
                    $time2          = strtotime(date('Y').$et_month.$et_day);
                    if ($time2 < $time1) $time2 = strtotime((date('Y')+1).$et_month.$et_day);
                    $year           = $time2 < $time1 ? date('Y')+1 : date('Y');
                    $files_data     = get_approval_process_files($v['processId'],$year,$vv['timeType']); //获取相关的文件审核信息

                    //提前提醒
                    if ($v['before_remind'] == 1){
                        $day                    = $v['day'] ? $v['day'] : 3;
                        $pro_status             = 2; //事前提醒
                        $st_time                = $time1 + $day*24*3600;
                        $et_time                = $time1;
                        $log_list               = get_process_log($v['processId'], $v['id'], $v['processTypeId'], $year, $vv['timeType'], $pro_status); //是否已生成记录
                        if (NOW_TIME > $st_time && NOW_TIME < $et_time && !$log_list){ //生成通知记录
                            save_process_log($v['id'],$pro_status,$v['title'],'','',$v['blame_uid'],$v['blame_name'],$year,$vv['timeType']);
                        }
                        if (((NOW_TIME > $et_time && $log_list) || $files_data['submit_res']) && $log_list['del_status'] != '-1'){ //
                            $data               = array();
                            $data['del_status'] = '-1';
                            $data['audit_time'] = NOW_TIME;
                            $data['audit_remark'] = '系统自动更改状态';
                            M('process_log')->where(array('id'=>$log_list['id']))->save($data);
                        }
                    }

                    //超时提醒
                    if ($v['after_remind'] == 1){
                        $pro_status             = 4; //超时提醒
                        $st_time                = $time1;
                        $et_time                = $time2;
                        $log_list               = get_process_log($v['processId'], $v['id'], $v['processTypeId'], $year, $vv['timeType'], $pro_status); //是否已生成记录
                        if (NOW_TIME > $st_time && NOW_TIME < $et_time && !$log_list){ //生成通知记录
                            save_process_log($v['id'],$pro_status,$v['title'],'','',$v['blame_uid'],$v['blame_name'],$year,$vv['timeType']);
                        }
                        if (((NOW_TIME > $et_time && $log_list) || $files_data['audit_res']) && $log_list['del_status'] != '-1'){ //
                            $data               = array();
                            $data['del_status'] = '-1';
                            $data['audit_time'] = NOW_TIME;
                            $data['audit_remark'] = '系统自动更改状态';
                            M('process_log')->where(array('id'=>$log_list['id']))->save($data);
                        }
                    }

                    //反馈给相关人员
                    if ($v['ok_feedback'] == 1 && $v['feedback_uids'] && $files_data['audit_res']){
                        $pro_status             = 1; //未读
                        $uids                   = explode(',',$v['feedback_uids']);
                        foreach ($uids as $uid){
                            $username           = username($uid);
                            //save_process_log($v['id'],$pro_status,$v['title'],'','',$uid,$username,$year,$vv['timeType']);
                        }
                    }
                }
            }
        }
    }
}

//获取相关流程的文件审核信息
function get_approval_process_files($processId, $year, $timeType){
    $typeList               = M('approval_file_type')->where(array('process_id'=>$processId,'pid'=>0))->find();
    $typeInfoList           = M('approval_file_type')->where(array('process_id'=>$processId,'pid'=>$typeList['id']))->select();
    $typeId                 = $typeList['id'];
    $typeInfoIds            = array_column($typeInfoList,'id');
    $should_num             = count($typeInfoList);
    $data                   = array();
    if ($typeInfoList){
        $where              = array();
        $where['type']      = $typeId;
        $where['typeInfo']  = array('in',$typeInfoIds);
        $where['year']      = $year;
        $where['timeType']  = $timeType;
        //$files              = M('approval')->where($where)->select();
        $files              = M('process_files')->where($where)->select();
        $submit_stu         = array(4,5); //4=>已提交总经理审核,5=>总经理审核通过
        $submit_num         = 0;
        $audit_num          = 0;
        foreach ($files as $v){
            if (in_array($v['status'],$submit_stu)) $submit_num++; //已提交之后的文件数量
            if ($v['status'] == 5) $submit_num++; //审核通过的文件数量
        }
        $data['submit_res'] = $submit_num >= $should_num ? 1 : 0;
        $data['audit_res']  = $audit_num >= $should_num ? 1 : 0;
    }
    return $data;
}

/**
 * @param $processId
 * @param $nodeId
 * @param $typeId
 * @param $year
 * @param $timeType //1寒假, 2春季, 3暑假, 4秋季
 * @param $pro_status //状态: 1=> 未读, 2=>事前提醒; 3=>反馈, 4=>超时提醒,5=>被督办 P::PROCESS_STU'
 */
function get_process_log($processId, $nodeId, $typeId, $year, $timeType, $pro_status){
    $where              = array();
    $where['p_id']      = $processId;
    $where['pnode_id']  = $nodeId;
    $where['ptype_id']  = $typeId;
    $where['year']      = $year;
    $where['timeType']  = $timeType;
    $where['pro_status']= $pro_status;
    $list               = M('process_log')->where($where)->find();
    return $list ? $list : '';
}

//直接保存文件至"文件管理->销售资料"文件夹
 function save_file_data($process_files_id){
    $field                      = 'p.*,a.filepath,a.filesize,a.fileext';
    $file_list                  = M()->table('__PROCESS_FILES__ as p')->join('__ATTACHMENT__ as a on a.id = p.atta_id','left')->field($field)->where(array('p.id' =>$process_files_id))->find();
    $atta_id                    = $file_list['atta_id'];
    if ($atta_id){ //保存至文件管理中文件夹
        $file                   = array();
        $file['file_name']      = $file_list['filename'];
        $file['file_type']      = 1; //文件
        $file['file_size']      = $file_list['filesize'];
        $file['file_ext']       = $file_list['fileext'];
        $file['file_path']      = $file_list['filepath'];
        $file['file_id']        = $atta_id;
        $file['est_time']       = NOW_TIME;
        $file['est_user']       = cookie('nickname');
        $file['est_user_id']    = cookie('userid');
        $file['pid']            = get_file_dir_pid($file_list['type']);
        $file['level']          = 2;
        M('files')->add($file);
    }

    //保存销售资料下载
    $cust                       = array();
    $cust['file_name']          = $file_list['filename'];
    $cust['file_size']          = $file_list['filesize'];
    $cust['file_path']          = $file_list['filepath'];
    $cust['file_id']            = $atta_id ;
    $cust['create_time']        = NOW_TIME;
    $cust['create_user']        = cookie('nickname');
    $cust['create_user_id']     = cookie('userid');
    $cust['type']               = get_cust_file_type($file_list['type']);
    M('customer_files')->add($cust);
}

function get_file_dir_pid($type){
    switch ($type){
        case 5:
            $pid                = 595; //销售资料
        break;
        case 10:
            $pid                = 11111; //业务季产品审定培训PPT
        break;
    }
    return $pid;
}

function get_cust_file_type($type){
    switch ($type){
        case 5:
            $fileType           = 1; //销售资料 P::FILE_DOWNLOAD
            break;
        case 10:
            $fileType           = 2; //业务季产品审定培训PPT
            break;
    }
    return $fileType;
}

//获取下载文件列表
function get_download_files($type){
    $db                         = M('customer_files');
    $lists                      = $db->where(array('type'=>$type))->order('id desc')->limit(5)->select(); //销售资料下载
    return $lists;
}
