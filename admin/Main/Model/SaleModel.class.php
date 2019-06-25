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
     * 获取当前周期内所有结算审核通过的团(以审核时间为准)(包含内部地接)
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
     * 获取当前周期内所有结算审核通过的团(以审核时间为准)(不包含内部地接)
     * @param $beginTime
     * @param $endTime
     */
    public function get_no_dj_settlement_lists($beginTime,$endTime){
        $dj_opids               = get_djopid();
        $where                  = array();
        $where['s.audit_status']= 1;
        $where['l.req_type']    = 801;
        $where['l.audit_time']  = array('between', "$beginTime,$endTime");
        $where['s.op_id']       = array('not in',$dj_opids);

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,l.req_uid,l.req_uname';

        $lists                  = M()->table('__OP_SETTLEMENT__ as s')->field($field)->join('__OP__ as o on s.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = s.id', 'LEFT')->where($where)->select();
        return $lists;
    }

    /**
     *  获取当前周期内所有结算审核通过的团(以审核时间为准)(包含内部地接,不包含其他和'南北极项目')
     * @param $beginTime
     * @param $endTime
     * @return mixed
     */
    public function get_special_settlement_lists($beginTime,$endTime){
        $where                  = array();
        $where['s.audit_status']= 1;
        $where['l.req_type']    = 801;
        $where['l.audit_time']  = array('between', "$beginTime,$endTime");
        $where['o.kind']        = array('not in',array(3,86));

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,l.req_uid,l.req_uname';

        $lists                  = M()->table('__OP_SETTLEMENT__ as s')->field($field)->join('__OP__ as o on s.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = s.id', 'LEFT')->where($where)->select();
        return $lists;
    }

    /**
     * 求每个计调的最低毛利率(以结算为准)
     * @param $operator 计调列表
     * @param $settlements 所有的已结算类表
     * @param $kinds 所有业务类型
     * @param $gross_avg 每种业务类型的最低毛利率
     *
     */
    public function get_gross($operator,$settlements,$kinds,$gross_avg){
        $data                       = array();
        foreach ($operator as $k=>$v){
            $info                   = $this->get_jd_gross($k,$v,$settlements,$kinds,$gross_avg);
            $data[$v]               = $info;
        }
        return $data;
    }

    /**
     * 获取计调个人分业务类型毛利率
     * @param $uid 用户ID
     * @param $uname 用户名
     * @param $settlement 公司所有已结算信息
     * @param $kinds 所有业务类型
     * @param $gross_avg 每种业务类型的最低毛利率
     */
    public function get_jd_gross($uid,$uname,$settlements,$kinds,$gross_avg){
        $sum_shouru                     = 0;
        $sum_maoli                      = 0;
        $sum_low_gross                  = 0;
        $sum_opids                      = '';
        $sum_group_ids                  = '';
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $kk=>$vv){
            $arr_kids                   = get_kids($kk);
            $shouru                     = 0;
            $maoli                      = 0;
            $low_gross                  = 0;
            $opids                      = '';
            $group_ids                  = '';
            $num                        = 0;
            foreach ($settlements as $key => $value) {
                if ($value['req_uid'] == $uid) {
                    if (in_array($value['kind'],$arr_kids)){
                        //单个业务类型合计
                        $shouru         += $value['shouru'];
                        $maoli          += $value['maoli'];
                        $low_gross      += $value['shouru']*$gross_avg[$kk]['num'];
                        $opids[]        = $value['op_id'];
                        $group_ids[]    = $value['group_id'];
                        $num++;

                        //总合计
                        $sum_shouru     += $value['shouru'];
                        $sum_maoli      += $value['maoli'];
                        $sum_low_gross  += $value['shouru']*$gross_avg[$kk]['num'];
                        $sum_opids[]    = $value['op_id'];
                        $sum_group_ids[]= $value['group_id'];
                        $sum_num++;
                    }
                }
            }

            if ($num){
                $info                   = array();
                $info['jd_id']          = $uid;
                $info['jd']             = $uname;
                $info['kind_id']        = $kk;
                $info['kind']           = $vv;
                $info['num']            = $num;
                $info['shouru']         = $shouru;
                $info['maoli']          = $maoli;
                $info['low_gross']      = $low_gross;
                $info['maolilv']        = (round($maoli/$shouru,4)*100).'%';
                $info['rate']           = (round($maoli/$low_gross,4)*100).'%';
                $info['opids']          = $opids?implode(',',$opids):'';
                $info['group_ids']      = $group_ids?implode(',',$group_ids):'';
                $rowspan++;
                $data['info'][]         = $info;
            }
        }

        $data['rowspan']                = $rowspan;
        $data['合计']['jd_id']          = $uid;
        $data['合计']['jd']             = $uname;
        $data['合计']['kind']           = '合计';
        $data['合计']['num']            = $sum_num;
        $data['合计']['shouru']         = $sum_shouru;
        $data['合计']['maoli']          = $sum_maoli;
        $data['合计']['low_gross']      = $sum_low_gross;
        $data['合计']['maolilv']        = (round($sum_maoli/$sum_shouru,4)*100).'%';
        $data['合计']['rate']           = (round($sum_maoli/$sum_low_gross,4)*100).'%';
        $data['合计']['opids']          = implode(',', $sum_opids);
        $data['合计']['group_ids']      = implode(',', $sum_group_ids);
        return $data;
    }

    /**
     * 获取公司总的毛利相关数据
     * @param $settlement_lists //本周期内结算的团
     * @param $kinds 所有业务类型
     * @param $gross_avg 每种业务类型的最低毛利率
     */
    public function get_sum_gross($settlement_lists,$kinds,$gross_avg){
        $sum_shouru                     = 0;
        $sum_maoli                      = 0;
        $sum_low_gross                  = 0;
        $sum_opids                      = '';
        $sum_group_ids                  = '';
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $k=>$v){
            $arr_kids                   = get_kids($k);
            $shouru                     = 0;
            $maoli                      = 0;
            $low_gross                  = 0;
            $opids                      = '';
            $group_ids                  = '';
            $num                        = 0;
            foreach ($settlement_lists as $key=>$value){
                if (in_array($value['kind'],$arr_kids)){
                    //单个业务类型合计
                    $shouru         += $value['shouru'];
                    $maoli          += $value['maoli'];
                    $low_gross      += $value['shouru']*$gross_avg[$k]['num'];
                    $opids[]        = $value['op_id'];
                    $group_ids[]    = $value['group_id'];
                    $num++;

                    //总合计
                    $sum_shouru     += $value['shouru'];
                    $sum_maoli      += $value['maoli'];
                    $sum_low_gross  += $value['shouru']*$gross_avg[$k]['num'];
                    $sum_opids[]    = $value['op_id'];
                    $sum_group_ids[]= $value['group_id'];
                    $sum_num++;
                }
            }
            if ($num){
                $info                   = array();
                $info['kind_id']        = $k;
                $info['kind']           = $v;
                $info['num']            = $num;
                $info['shouru']         = $shouru;
                $info['maoli']          = $maoli;
                $info['low_gross']      = $low_gross;
                $info['maolilv']        = (round($maoli/$shouru,4)*100).'%';
                $info['rate']           = (round($maoli/$low_gross,4)*100).'%';
                $info['opids']          = $opids?implode(',',$opids):'';
                $info['group_ids']      = $group_ids?implode(',',$group_ids):'';
                $rowspan++;
                $data['info'][]         = $info;
            }
        }
        $data['rowspan']                = $rowspan;
        $data['合计']['jd_id']          = '888888';
        $data['合计']['jd']             = '公司合计';
        $data['合计']['kind']           = '公司合计';
        $data['合计']['num']            = $sum_num;
        $data['合计']['shouru']         = $sum_shouru;
        $data['合计']['maoli']          = $sum_maoli;
        $data['合计']['low_gross']      = $sum_low_gross;
        $data['合计']['maolilv']        = (round($sum_maoli/$sum_shouru,4)*100).'%';
        $data['合计']['rate']           = (round($sum_maoli/$sum_low_gross,4)*100).'%';
        $data['合计']['opids']          = implode(',', $sum_opids);
        $data['合计']['group_ids']      = implode(',', $sum_group_ids);
        return $data;
    }

    /**
     * 获取公司总的毛利相关数据
     * @param $settlement_no_dj_lists //本周期内结算的团(不包含地接团)
     * @param $settlement_lists //本周期内结算的团(包含地接团)
     * @param $kinds 所有业务类型
     * @param $gross_avg 每种业务类型的最低毛利率
     */
    public function get_company_sum_gross($settlement_no_dj_lists,$settlement_lists,$kinds,$gross_avg){
        $sum_shouru                     = 0;
        $sum_maoli                      = 0;
        $sum_low_gross                  = 0;
        $sum_opids                      = '';
        $sum_group_ids                  = '';
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $k=>$v){
            $arr_kids                   = get_kids($k);
            $shouru                     = 0;
            $maoli                      = 0;
            $low_gross                  = 0;
            $opids                      = '';
            $group_ids                  = '';
            $num                        = 0;
            foreach ($settlement_no_dj_lists as $key=>$value){ //排除地接的
                if (in_array($value['kind'],$arr_kids)){
                    //单个业务类型合计
                    $shouru         += $value['shouru'];

                    //总合计
                    $sum_shouru     += $value['shouru'];
                }
            }


            foreach ($settlement_lists as $key=>$value){ //所有的结算数据(包含地接)
                if (in_array($value['kind'],$arr_kids)){
                    //单个业务类型合计
                    $maoli          += $value['maoli'];
                    $low_gross      += $value['shouru']*$gross_avg[$k]['num'];
                    $opids[]        = $value['op_id'];
                    $group_ids[]    = $value['group_id'];
                    $num++;
                    if ($k ==84){ //地接研学旅行
                        $shouru     += $value['shouru'];
                        //$sum_shouru += $value['shouru'];
                    }

                    //总合计
                    $sum_maoli      += $value['maoli'];
                    $sum_low_gross  += $value['shouru']*$gross_avg[$k]['num'];
                    $sum_opids[]    = $value['op_id'];
                    $sum_group_ids[]= $value['group_id'];
                    $sum_num++;
                }
            }

            if ($num){
                $info                   = array();
                $info['kind_id']        = $k;
                $info['kind']           = $v;
                $info['num']            = $num;
                $info['shouru']         = $shouru;
                $info['maoli']          = $maoli;
                $info['low_gross']      = $low_gross;
                $info['maolilv']        = (round($maoli/$shouru,4)*100).'%';
                $info['rate']           = (round($maoli/$low_gross,4)*100).'%';
                $info['opids']          = $opids?implode(',',$opids):'';
                $info['group_ids']      = $group_ids?implode(',',$group_ids):'';
                $rowspan++;
                $data['info'][]         = $info;
            }
        }

        $data['rowspan']                = $rowspan;
        $data['合计']['jd_id']          = '888888';
        $data['合计']['jd']             = '公司合计';
        $data['合计']['kind']           = '公司合计';
        $data['合计']['num']            = $sum_num; //总项目包含地接项目
        $data['合计']['shouru']         = $sum_shouru; //结算收入排除地接收入
        $data['合计']['maoli']          = $sum_maoli; //毛利包含地接毛利
        $data['合计']['low_gross']      = $sum_low_gross;
        $data['合计']['maolilv']        = (round($sum_maoli/$sum_shouru,4)*100).'%';
        $data['合计']['rate']           = (round($sum_maoli/$sum_low_gross,4)*100).'%';
        $data['合计']['opids']          = implode(',', $sum_opids);
        $data['合计']['group_ids']      = implode(',', $sum_group_ids);
        return $data;
    }


    /**
     * 获取所有的毛利率数据
     * @param $kinds
     * @param $startTime
     * @param $endTime
     */
    public function get_gross_avg($kinds,$startTime,$endTime){
        $db                             = M('gross');
        $data                           = array();
        foreach ($kinds as $k=>$v){
            $list                       = $db->where(array('kind_id'=>$k,'input_time'=>array('lt',$endTime)))->order('id desc')->find();
            $data[$k]['gross']          = $list['gross']?$list['gross']:0; //以百分号显示
            $data[$k]['kind']           = $list['kind']?$list['kind']:$v;
            $data[$k]['num']            = $list['gross']?(str_replace('%','',$list['gross']))/100:0; //以小数显示
        }
        return $data;
    }

    //
    public function get_timely(){
        $db                             = M('operator_timely');
        $where                          = array();
        $where['status']                = 0; //正常使用
        $list                           = $db->where($where)->select();
        foreach ($list as $k=>$v){
            $list[$k]['title']          = htmlspecialchars_decode($v['title']);
            $list[$k]['content']        = htmlspecialchars_decode($v['content']);
            $list[$k]['rules']          = htmlspecialchars_decode($v['rules']);
        }
        return $list;
    }

    //获取计调的及时率
    public function get_timely_data($startTime,$endTime,$uid=''){
        $timely                         = $this -> get_timely();
        $timely_tit                     = array_column($timely,'title');
        $costacc_data                   = get_costacc_data($startTime,$endTime,'报价及时性',$uid);
        $budget_data                    = get_budget_data($startTime,$endTime,'预算及时性',$uid);
        $settlement_data                = get_settlement_data($startTime,$endTime,'结算及时性',$uid);
    }
}