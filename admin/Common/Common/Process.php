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

/**
 * 完成
 * @param int $process_log_id
 * @param int $process_node_id
 * @param string $remark
 */
function save_process_ok($process_node_id=0,$remark=''){
    $db                          = M('process_log');
    $data                        = array();
    $data['audit_uid']           = cookie('userid');
    $data['audit_uname']         = cookie('nickname');
    $data['audit_time']          = NOW_TIME;
    $data['audit_remark']        = $remark;
    $data['del_status']          = '-1'; //已处理
    $where                       = array();
    $where['to_uid']             = cookie('userid');
    //if ($process_log_id)  $where['id']       = $process_log_id;
    if ($process_node_id) $where['pnode_id'] = $process_node_id;
    $db->where($where)->save($data);
}

//根据流程节点自动生成提示信息
function process_node_to_log(){
    $nodeLists          = M('process_node')->select();

    foreach ($nodeLists as $k=>$v){
        if (in_array($v['id'],array(6,7,12,13,15,16))){ //6=>提交业务季产品手册、业务季销售PPT、公司宣传手册; 12=>批准发布业务季产品手册、业务季销售PPT、公司宣传手册; 13=>审定培训PPT,15=>提交业务季宣传营销需求, 16=>制定业务季市场营销计划及预算
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
    $file_id                    = M('customer_files')->add($cust);

     $unread_type               = 4; //P::UNREAD_SALE_FILE; //未读的销售资料下载信息
     $unread_req_id             = $file_id;
     $to_uids                   = M('account')->where(array('status'=>0))->getField('id',true);
     $uids                      = implode(',',$to_uids);
     save_unread_msg($unread_type,$unread_req_id, $uids);
}


/**
 * 创建未读消息
 * @param $type   P::UNREAD_SALE_FILE
 * @param $req_id
 * @param $to_uids
 */
function save_unread_msg($type,$req_id,$to_uids){
    $read                       = array();
    $read['type']               = $type;
    $read['req_id']             = $req_id;
    $read['userids']            = $to_uids;
    $read['create_time']        = NOW_TIME;
    $read['read_type']          = 0;
    M('unread')->add($read);
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

//业务招标提示
function save_bid_data($title,$req_id,$uid){
    $manage_data                = get_manage_uid($uid);
    $to_uid                     = $manage_data['manager_id'];
    $to_uname                   = $manage_data['manager_name'];
    $process_node               = 19; //成立投标小组/编制投标工作方案
    $pro_status                 = 2; //事前提醒
    save_process_log($process_node,$pro_status,$title,$req_id,'',$to_uid,$to_uname);
}

//获取所有的流程
function get_process_data(){
    $db                         = M('process');
    $data                       = $db->where(array('status'=>array('neq','-1')))->select();
    return $data;
}

//提交审核状态
function get_submit_audit_status(){
    $arr                        = array(
        0                       => '未提交',
        1                       => '<span class="green">审核通过</span>',
        2                       => '<span class="red">审核不通过</span>',
        3                       => '<span class="yellow">已提交,未审核</span>'
    );
    return $arr;
}

//销售支持类型
function get_sale_type(){
    $arr                        = array(
        1                       => '销售出差',
        2                       => '协助销售',
        3                       => '邀请客户'
    );
    return $arr;
}

function get_process_node_data($id){
    $db                         = M('process_node');
    $data                       = $db->where(array('id'=>$id))->find();
    return $data;
}

//获取产品方案需求详细信息数据表
 function get_product_pro_need_tetail_db($kind){
    switch ($kind){
        case 60: //60=>科学课程
            $db         = M('product_pro_need_kxkc');
            break;
        case 82: //82=> 科学博物园
            $db         = M('product_pro_need_kxbwy');
            break;
        case 54: //54=> 研学旅行
            $db         = M('product_pro_need_yxlx');
            break;
        case 90: //90=> 背景提升
            $db         = M('product_pro_need_bjts');
            break;
        case 67: //67=> 实验室建设
            $db         = M('product_pro_need_sysjs');
            break;
        case 69: //69=> 科学快车
            $db         = M('product_pro_need_bus');
            break;
        case 56: //56=> 校园科技节
            $db         = M('product_pro_need_xykjj');
            break;
        case 61: //61=> 小课题
            $db         = M('product_pro_need_xkt');
            break;
        case 87: //87=> 单进院所
            $db         = M('product_pro_need_djys');
            break;
        case 64: //64=>专场讲座
            $db         = M('product_pro_need_zcjz');
            break;
        case 57: //57=>综合实践
            $db         = M('product_pro_need_zhsj');
            break;
        case 65: //65=>教师培训
            $db         = M('product_pro_need_jspx');
            break;
        default:
            $db         = '';
    }
    return $db;
}

//获取客户需求详情数据表
 function get_customer_need_tetail_db($kind){
    switch ($kind){
        case 60: //60=>科学课程
            $db         = M('op_customer_need_kxkc');
            break;
        case 82: //82=> 科学博物园
            $db         = M('op_customer_need_kxbwy');
            break;
        case 54: //54=> 研学旅行
            $db         = M('op_customer_need_yxlx');
            break;
        case 90: //90=> 背景提升
            $db         = M('op_customer_need_bjts');
            break;
        case 67: //67=> 实验室建设
            $db         = M('op_customer_need_sysjs');
            break;
        case 69: //69=> 科学快车
            $db         = M('op_customer_need_bus');
            break;
        case 56: //56=> 校园科技节
            $db         = M('op_customer_need_xykjj');
            break;
        case 61: //61=> 小课题
            $db         = M('op_customer_need_xkt');
            break;
        case 87: //87=> 单进院所
            $db         = M('op_customer_need_djys');
            break;
        case 64: //64=>专场讲座
            $db         = M('op_customer_need_zcjz');
            break;
        case 57: //57=>综合实践
            $db         = M('op_customer_need_zhsj');
            break;
        case 65: //65=>教师培训
            $db         = M('op_customer_need_jspx');
            break;
        default:
            $db         = '';
    }
    return $db;
}
