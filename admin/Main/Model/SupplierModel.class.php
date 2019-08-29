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
        $month_costacc_lists            = $this->get_costacc_lists($month_opids); //月度结算详情列表
        $year_costacc_lists             = $this->get_costacc_lists($year_opids);  //年度结算详情列表
        $month_expense_list             = $this->get_expense_lists($month_opids); //报销单详情信息
        $year_expense_list              = $this->get_expense_lists($year_opids);  //报销单详情信息
        $monthOpids                     = array();
        $yearOpids                      = array();
        $month_op_num                   = 0; //项目数
        $year_op_num                    = 0;
        $month_expense_title            = 0; //报销金额
        $year_expense_title             = 0; //报销金额
        $month_costacc_opids            = array();
        $year_costacc_opids             = array();
        $data                           = array();
        foreach ($supplierKinds as $k=>$v){
            $month_total                        = 0;
            $year_total                         = 0;
            foreach ($month_costacc_lists as $mk=>$mv){ //月度项目数 月度结算金额
                if ($mv['type']==$k){
                    if(!in_array($mv['op_id'],$month_costacc_opids)){
                        $month_costacc_opids[]  = $mv['op_id'];
                        $month_op_num++;
                    }
                    $month_total                += $mv['total'];
                }
            }

            foreach ($year_costacc_lists as $yk=>$yv){ //年度项目数 年度结算金额
                if ($yv['type']==$k){
                    if(!in_array($yv['op_id'],$year_costacc_opids)){
                        $year_costacc_opids[]   = $yv['op_id'];
                        $year_op_num++;
                    }
                    $year_total                 += $yv['total'];
                }
            }

            foreach ($month_expense_list as $mlk=>$mlv){
                //if($mlv[''])
            }

            $data[$k]['kid']            = $k;
            $data[$k]['kindName']       = $v;
            $data[$k]['month_op_num']   = $month_op_num;
            $data[$k]['year_op_num']    = $year_op_num;
            $data[$k]['month_total']    = $month_total;
            $data[$k]['year_total']     = $year_total;
        }
        $data                           = multi_array_sort($data,'year_total');
        return $data;
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

    /**
     * 报销单信息
     * @param $opids
     * @return mixed
     */
    public function get_expense_lists($opids){
        $where                          = array();
        $where['b.audit_status']        = 1;
        $where['d.op_id']               = array('in',$opids);
        $field                          = 'b.sum,b.sum_chinese,b.description,b.payee,b.bank_name,b.card_num,b.bx_user,d.*';
        $lists                          = M()->table('__BAOXIAO_DETAIL__ as d')->join('__BAOXIAO__ as b on b.id=d.bx_id','left')->where($where)->field($field)->select();
        return $lists;
    }

}