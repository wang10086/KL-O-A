<?php
/**
 * Date: 2018/12/4
 * Time: 11:14
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class ContractModel extends Model{
    /**
     * 获取某个时间段内预算审批通过的项目
     * @param $begintime
     * @param $endtime
     * @return mixed
     */
    public function get_budget_list($sale_user_id,$begintime,$endtime){
        $where                              = array(); //当月预算审核通过的项目
        $where['l.req_type']                = P::REQ_TYPE_BUDGET; //预算申请
        $where['b.audit_status']            = 1; //审批通过
        $where['l.audit_time']              = array('between',"$begintime,$endtime");
        $where['create_user']               = $sale_user_id;
        $field                              = 'l.audit_uid,audit_uname,audit_time,c.dep_time,c.ret_time,o.*';
        $lists                              = M()->table('__OP_BUDGET__ as b')->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')->join('__OP__ as o on o.op_id = b.op_id','left')->join('left join __OP_TEAM_CONFIRM__ as c on c.op_id=b.op_id')->field($field)->where($where)->select();
        return $lists;
    }

    /**
     * 获取个人在周期内出团的项目(应签合同的团)
     * @param $userid
     * @param $begintime
     * @param $endtime
     */
    public function get_user_op_list($userid='',$begintime,$endtime){
        $where 							    = array();
        if($userid) $where['o.create_user'] = $userid;
        $where['c.dep_time']			    = array('between',array($begintime,$endtime));
        $dj_op_ids                          = array_filter(M('op')->getField('dijie_opid',true));
        $where['o.op_id']                   = array('not in',$dj_op_ids);   //排除地接团
        $op_list	                        = M()->table('__OP__ as o')->field('o.*,c.dep_time,c.ret_time')->join('left join __OP_TEAM_CONFIRM__ as c on o.op_id=c.op_id')->where($where)->select();
        return $op_list;
    }
}