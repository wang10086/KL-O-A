<?php
/**
 * Date: 2019/06/10
 * Time: 18:42
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class SaleModel extends Model{

    /**
     * 获取当前周期内所有结算审核通过的团(以审核时间为准)
     * @param $beginTime
     * @param $endTime
     */
    public function get_all_settlement_lists($beginTime,$endTime){
        $where                  = array();
        $where['s.audit_status']= 1;
        $where['l.req_type']    = 801;
        $where['l.audit_time']  = array('between', "$beginTime,$endTime");

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,l.req_uid,l.req_uname';

        $lists                  = M()->table('__OP_SETTLEMENT__ as s')->field($field)->join('__OP__ as o on s.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = s.id', 'LEFT')->where($where)->select();
        return $lists;
    }

    /**
     * 求每个计调的最低毛利率(以结算为准)
     * @param $operator 计调列表
     * @param $settlements 所有的已结算类表
     */
    public function get_gross($operator,$settlements){
        $data                       = array();
        foreach ($operator as $k=>$v){
            $info                   = $this->get_jd_gross($k,$v,$settlements);
            $data[$v]               = $info;
        }
        return $data;
    }

    /**
     * 获取计调个人分业务类型毛利率
     * @param $uid 用户ID
     * @param $uname 用户名
     * @param $settlement 公司所有已结算信息
     */
    public function get_jd_gross($uid,$uname,$settlements){
        $kinds                          = M('project_kind')->getField('id,name',true);
        $sum_shouru                     = 0;
        $sum_maoli                      = 0;
        $sum_opids                      = '';
        $sum_group_ids                  = '';
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $kk=>$vv){
            $shouru                     = 0;
            $maoli                      = 0;
            $opids                      = '';
            $group_ids                  = '';
            $num                        = 0;
            foreach ($settlements as $key => $value) {
                if ($value['req_uid'] == $uid) {
                    if ($value['kind'] == $kk){
                        //单个业务类型合计
                        $shouru         += $value['shouru'];
                        $maoli          += $value['maoli'];
                        $opids[]        = $value['op_id'];
                        $group_ids[]    = $value['group_id'];
                        $num++;

                        //总合计
                        $sum_shouru     += $value['shouru'];
                        $sum_maoli      += $value['maoli'];
                        $sum_opids[]    = $value['op_id'];
                        $sum_group_ids[]= $value['group_id'];
                        $sum_num++;
                    }
                }
            }

            if ($num){
                $info                   = array();
                $info['jd']             = $uname;
                $info['kind_id']        = $kk;
                $info['kind']           = $vv;
                $info['num']            = $num;
                $info['shouru']         = $shouru;
                $info['maoli']          = $maoli;
                $info['maolilv']        = (round($maoli/$shouru,4)*100).'%';
                $info['opids']          = $opids?implode(',',$opids):'';
                $info['group_ids']      = $group_ids?implode(',',$group_ids):'';
                $rowspan++;
                $data['info'][]         = $info;
            }
        }

        $data['rowspan']                = $rowspan;
        $data['合计']['jd']             = $uname;
        $data['合计']['kind']           = '合计';
        $data['合计']['num']            = $sum_num;
        $data['合计']['shouru']         = $sum_shouru;
        $data['合计']['maoli']          = $sum_maoli;
        $data['合计']['maolilv']        = (round($sum_maoli/$sum_shouru,4)*100).'%';
        $data['合计']['opids']          = implode(',', $sum_opids);
        $data['合计']['group_ids']      = implode(',', $sum_group_ids);
        return $data;
    }
}