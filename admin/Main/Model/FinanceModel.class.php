<?php
/**
 * Date: 2018/12/13
 * Time: 16:13
 */

namespace Main\Model;


use Think\Model;

class FinanceModel extends Model{

    public function get_jkd($lists){
        $costacc_ids    = array_column($lists,'costacc_id');
        $arr            = array();
        foreach ($costacc_ids as $v){
            $jkd_ids    = M('jiekuan_detail')->where(array('costacc_id'=>$v))->getField('jkd_id',true);
            $arr[]      = $jkd_ids;
        }
        $ids            = implode(',',array_unique(array_reduce($arr, 'array_merge', array())));
        return $ids;
    }

    /**
     * 获取操作记录
     * @param 编号
     */
    public function get_record($bill){
        $db             = M('jkbx_record');
        $lists          = $db->where(array('bill_id'=>$bill))->order('time DESC')->select();
        return $lists;
    }

    /**
     * 保存借款单审核结果
     * @param $jk_id
     * @param $result
     */
    public function save_jkd_audit($jk_id,$result){
        $audit                  = array();
        $audit['audit_status']  = $result;
        M('jiekuan')->where(array('id'=>$jk_id))->save($audit);
        M('jiekuan_detail')->where(array('jk_id'=>$jk_id))->save($audit);
    }

    /**
     * 保存报销单审核结果
     * @param $bx_id
     * @param $result
     */
    public function save_bxd_audit($bx_id,$result){
        $audit                  = array();
        $audit['audit_status']  = $result;
        M('baoxiao')->where(array('id'=>$bx_id))->save($audit);
        M('baoxiao_detail')->where(array('bx_id'=>$bx_id))->save($audit);
    }

    /**
     * 获取证明验收人相关信息
     * @param $lists
     * @return mixed
     */
    public function get_zmysr_id($lists){
        foreach ($lists as $k=>$v){
            $opid           = $v['op_id'];
            if ($opid){
                break;
            }
        }
        return $opid;
    }

}