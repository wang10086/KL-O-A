<?php
/**
 * Date: 2019/06/10
 * Time: 18:42
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class SupplierModel extends Model{

    public function get_supplier_chart($supplierKinds,$year,$month){
        $monthCycle                     = get_cycle($year.$month); //月份周期
        $yearToMonthCycle               = year_to_now_month($year,$month); //从年初到当前月份周期
        $month_sett_lists               = $this->get_cycle_settlement_lists($monthCycle['begintime'],$monthCycle['endtime']);
        $year_sett_lists                = $this->get_cycle_settlement_lists($yearToMonthCycle['beginTime'],$yearToMonthCycle['endTime']);
        $month_opids                    = array_unique(array_column($month_sett_lists,'op_id'));
        $year_opids                     = array_unique(array_column($year_sett_lists,'op_id'));

        $month_lists                    = $this->get_costacc_lists($month_opids);
        $year_lists                     = $this->get_costacc_lists($year_opids);
        foreach ($supplierKinds as $k=>$v){

        }
    }

    /**
     * 周期内结算审核通过的团信息
     * @param $beginTime
     * @param $endTime
     * @return mixed
     */
    public function get_cycle_settlement_lists($beginTime,$endTime){
        $where                          = array();
        $where['l.req_type']            = P::REQ_TYPE_SETTLEMENT;
        $where['l.dst_status']          = P::AUDIT_STATUS_PASS;
        $where['l.audit_time']          = array('between',array($beginTime,$endTime));
        $field                          = 's.*,l.audit_time';
        $lists                          = M()->table('__AUDIT_LOG__ as l')->join('__OP_SETTLEMENT__ as s on s.id=l.req_id','left')->where($where)->field($field)->select();
        return $lists;
    }

    /**
     * 求结算的详情列表信息
     * @param $opids
     * @return mixed
     */
    public function get_costacc_lists($opids){
        $where                          = array();
        $where['op_id']                 = array('in',$opids);
        $where['status']                = 2; //结算
        $lists                          = M('op_costacc')->where($where)->select();
        return $lists;
    }

}