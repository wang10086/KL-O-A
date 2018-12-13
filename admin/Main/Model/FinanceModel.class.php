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

}