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
 */
function save_process_log($process_node,$pro_status,$title='',$req_id=0,$to_postids='',$to_uid='0',$to_uname=''){
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