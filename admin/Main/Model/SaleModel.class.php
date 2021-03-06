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

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,s.untraffic_shouru,l.req_uid,l.req_uname';

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

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,s.untraffic_shouru,l.req_uid,l.req_uname';

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

        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,s.false_maoli,s.untraffic_shouru,l.req_uid,l.req_uname';

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
        $sum_untraffic_shouru           = 0;
        $sum_untraffic_low_gross        = 0;
        $sum_low_gross                  = 0;
        $sum_opids                      = array();
        $sum_group_ids                  = array();
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $kk=>$vv){
            $arr_kids                   = get_kids($kk);
            $shouru                     = 0;
            $maoli                      = 0;
            $low_gross                  = 0;
            $untraffic_shouru           = 0;
            $untraffic_low_gross        = 0;
            $opids                      = array();
            $group_ids                  = array();
            $num                        = 0;
            foreach ($settlements as $key => $value) {
                $op_untraffic_shouru    = (int)$value['untraffic_shouru'] ? $value['untraffic_shouru'] : $value['shouru'];
                if ($value['req_uid'] == $uid) {
                    if (in_array($value['kind'],$arr_kids)){
                        //单个业务类型合计
                        $shouru         += $value['shouru'];
                        $maoli          += (int)$value['false_maoli'] ? (int)$value['false_maoli'] : $value['maoli']; //单进院所项目取false_maoli值
                        $untraffic_shouru+= $op_untraffic_shouru;
                        $low_gross      += $value['shouru']*$gross_avg[$kk]['num'];
                        $untraffic_low_gross += $op_untraffic_shouru*$gross_avg[$kk]['num'];
                        $opids[]        = $value['op_id'];
                        $group_ids[]    = $value['group_id'];
                        $num++;

                        //总合计
                        $sum_shouru     += $value['shouru'];
                        $sum_maoli      += (int)$value['false_maoli'] ? (int)$value['false_maoli'] : $value['maoli'];
                        $sum_low_gross  += $value['shouru']*$gross_avg[$kk]['num'];
                        $sum_untraffic_shouru += $op_untraffic_shouru;
                        $sum_untraffic_low_gross += $op_untraffic_shouru*$gross_avg[$kk]['num'];
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
                $info['maolilv']        = $shouru ? (round($maoli/$shouru,4)*100).'%' : '0%';
                //$info['rate']           = $low_gross ? (round($maoli/$low_gross,4)*100).'%' : '0%';
                $info['untraffic_shouru']= $untraffic_shouru;
                $info['untraffic_maolilv'] = $untraffic_shouru ? (round($maoli/$untraffic_shouru,4)*100).'%' : '0%';
                $info['untraffic_rate'] = $untraffic_low_gross ? (round($maoli/$untraffic_low_gross,4)*100).'%' : '0%';
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
        $data['合计']['maolilv']        = $sum_shouru ? (round($sum_maoli/$sum_shouru,4)*100).'%' :'0%';
        //$data['合计']['rate']           = $sum_low_gross ? (round($sum_maoli/$sum_low_gross,4)*100).'%' :'0%';
        $data['合计']['untraffic_shouru']= $sum_untraffic_shouru;
        $data['合计']['untraffic_maolilv'] = $sum_untraffic_shouru ? (round($sum_maoli/$sum_untraffic_shouru,4)*100).'%' :'0%';
        $data['合计']['untraffic_rate'] = $sum_untraffic_low_gross ? (round($sum_maoli/$sum_untraffic_low_gross,4)*100).'%' :'0%';
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
        $sum_untraffic_shouru           = 0;
        $sum_untraffic_low_gross        = 0;
        $sum_opids                      = array();
        $sum_group_ids                  = array();
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $k=>$v){
            $arr_kids                   = get_kids($k);
            $shouru                     = 0;
            $maoli                      = 0;
            $untraffic_shouru           = 0;
            $untraffic_low_gross        = 0;
            $low_gross                  = 0;
            $opids                      = array();
            $group_ids                  = array();
            $num                        = 0;
            foreach ($settlement_lists as $key=>$value){
                $op_untraffic_shouru    = (int)$value['untraffic_shouru'] ? $value['untraffic_shouru'] : $value['shouru'];
                if (in_array($value['kind'],$arr_kids)){
                    //单个业务类型合计
                    $shouru         += $value['shouru'];
                    $maoli          += $value['maoli'];
                    $untraffic_shouru+= $op_untraffic_shouru;
                    $low_gross      += $value['shouru']*$gross_avg[$k]['num'];
                    $untraffic_low_gross += $value['untraffic_shouru']*$gross_avg[$k]['num'];
                    $opids[]        = $value['op_id'];
                    $group_ids[]    = $value['group_id'];
                    $num++;

                    //总合计
                    $sum_shouru     += $value['shouru'];
                    $sum_maoli      += $value['maoli'];
                    $sum_untraffic_shouru += $op_untraffic_shouru;
                    $sum_low_gross  += $value['shouru']*$gross_avg[$k]['num'];
                    $sum_untraffic_low_gross += $op_untraffic_shouru*$gross_avg[$k]['num'];
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
                //$info['rate']           = (round($maoli/$low_gross,4)*100).'%';
                $info['untraffic_shouru']= $untraffic_shouru;
                $info['untraffic_maolilv'] = $untraffic_shouru ? (round($maoli/$untraffic_shouru,4)*100).'%' : '0%';
                $info['untraffic_rate'] = $untraffic_low_gross ? (round($maoli/$untraffic_low_gross,4)*100).'%' : '0%';
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
        $data['合计']['maolilv']        = $sum_shouru ? (round($sum_maoli/$sum_shouru,4)*100).'%' : '0%';
        //$data['合计']['rate']           = $sum_low_gross ? (round($sum_maoli/$sum_low_gross,4)*100).'%' : '0%';
        $data['合计']['untraffic_shouru']= $sum_untraffic_shouru;
        $data['合计']['untraffic_maolilv'] = $sum_untraffic_shouru ? (round($sum_maoli/$sum_untraffic_shouru,4)*100).'%' : '0%';
        $data['合计']['untraffic_rate'] = $sum_untraffic_low_gross ? (round($sum_maoli/$sum_untraffic_low_gross,4)*100).'%' : '0%';
        $data['合计']['opids']          = implode(',', $sum_opids);
        $data['合计']['group_ids']      = implode(',', $sum_group_ids);
        return $data;
    }

    /**
     * 获取公司总的毛利相关数据
     //* @param $settlement_no_dj_lists //本周期内结算的团(不包含地接团)
     * @param $settlement_lists //本周期内结算的团(包含地接团)
     * @param $kinds 所有业务类型
     * @param $gross_avg 每种业务类型的最低毛利率
     */
    public function get_company_sum_gross($settlement_lists,$kinds,$gross_avg){
        $sum_shouru                     = 0;
        $sum_maoli                      = 0;
        $sum_untraffic_shouru           = 0;
        $sum_untraffic_low_gross        = 0;
        $sum_low_gross                  = 0;
        $sum_opids                      = array();
        $sum_group_ids                  = array();
        $sum_num                        = 0; //项目数
        $data                           = array();
        $rowspan                        = 1;
        foreach ($kinds as $k=>$v){
            $arr_kids                   = get_kids($k);
            $shouru                     = 0;
            $maoli                      = 0;
            $untraffic_shouru           = 0;
            $untraffic_low_gross        = 0;
            $low_gross                  = 0;
            $opids                      = array();
            $group_ids                  = array();
            $num                        = 0;

            foreach ($settlement_lists as $key=>$value){ //所有的结算数据(包含地接)
                $op_untraffic_shouru        = (int)$value['untraffic_shouru'] ? $value['untraffic_shouru'] : $value['shouru'];
                if (in_array($value['kind'],$arr_kids)){
                    //单个业务类型合计
                    $maoli                  += $value['maoli'];
                    $low_gross              += $value['shouru']*$gross_avg[$k]['num'];
                    $untraffic_low_gross    += $op_untraffic_shouru*$gross_avg[$k]['num'];
                    $opids[]                = $value['op_id'];
                    $group_ids[]            = $value['group_id'];
                    $num++;
                    $shouru                 += $value['shouru'];
                    $untraffic_shouru       += $op_untraffic_shouru;
                    $sum_shouru             += $value['shouru'];
                    $sum_untraffic_shouru   += $op_untraffic_shouru;


                    //总合计
                    $sum_maoli               += $value['maoli'];
                    $sum_low_gross           += $value['shouru']*$gross_avg[$k]['num'];
                    $sum_untraffic_low_gross += $op_untraffic_shouru*$gross_avg[$k]['num'];
                    $sum_opids[]             = $value['op_id'];
                    $sum_group_ids[]         = $value['group_id'];
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
                $info['maolilv']        = $shouru ? (round($maoli/$shouru,4)*100).'%' : '0%';
                $info['untraffic_shouru']= $untraffic_shouru;
                $info['untraffic_maolilv'] = $untraffic_shouru ? (round($maoli/$untraffic_shouru,4)*100).'%' : '0%';
                $info['untraffic_rate'] = $untraffic_low_gross ? (round($maoli/$untraffic_low_gross,4)*100).'%' : '0%';
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
        $data['合计']['maolilv']        = $sum_shouru ? (round($sum_maoli/$sum_shouru,4)*100).'%' : '0%';
        $data['合计']['untraffic_shouru']= $sum_untraffic_shouru;
        $data['合计']['untraffic_maolilv'] = $sum_untraffic_shouru ? (round($sum_maoli/$sum_untraffic_shouru,4)*100).'%' : '0%';
        $data['合计']['untraffic_rate'] = $sum_untraffic_low_gross ? (round($sum_maoli/$sum_untraffic_low_gross,4)*100).'%' : '0%';
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

    //获取计调的及时率
    public function get_timely_data($startTime,$endTime,$uid=''){
        $timely                         = get_timely(1); //1=>计调操作及时性
        //$timely                          = array_column($timely,'content','title');
        //$costacc_data                   = get_costacc_data($startTime,$endTime,$timely[0]['title'],$timely['0']['content'],$uid); //报价及时性
        $budget_data                    = get_budget_data($startTime,$endTime,$timely[0]['title'],$timely['0']['content'],$uid); //预算及时性
        $settlement_data                = get_settlement_data($startTime,$endTime,$timely[1]['title'],$timely['1']['content'],$uid); //结算及时性
        $reimbursement_data             = get_reimbursement_data($startTime,$endTime,$timely[2]['title'],$timely['2']['content'],$uid);

        //$data[]                         = $costacc_data;
        $data[]                         = $budget_data;
        $data[]                         = $settlement_data;
        $data[]                         = $reimbursement_data;
        return $data;
    }

    //获取计调及时率合计
    public function get_sum_timely($data){
        $sum_num                        = array_sum(array_column($data,'sum_num'));
        $ok_num                         = array_sum(array_column($data,'ok_num'));
        $average                        = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $info                           = array();
        $info['title']                  = '合计';
        $info['sum_num']                = $sum_num;
        $info['ok_num']                 = $ok_num;
        $info['average']                = $average;
        return $info;
    }

    //获取计调信息
    public function get_operator(){
        $jd_roles                       = array(29,31,38,42,116); //29=>计调专员 , 31=>计调操作经理,38=>京区业务中心计调主管 ,42=>南京计调专员, 116=>京区计调中心
        $where                          = array();
        $where['roleid']                = array('in',$jd_roles);
        $where['status']                = array('in',array(0,1));
        $where['nickname']              = array('not in',array('孟华华'));
        $operator                       = M('account')->where($where)->getField('id,nickname',true);
        return $operator;
    }

    //计调及时率详情
    public function get_timely_type($title,$startTime,$endTime,$uid=0,$group_id=''){
        $timely                         = get_timely(1); //1=>计调操作及时性
        $timely_column                  = array_column($timely,'content','title');
        switch ($title){
            /*case $timely[0]['title']: //报价及时性  bak_20200528
                $info                   = get_costacc_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;*/
            case $timely[0]['title']: //预算及时性
                $info                   = get_budget_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case $timely[1]['title']: //结算及时性
                $info                   = get_settlement_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case $timely[2]['title']: //报账及时性
                $info                   = get_reimbursement_data($startTime,$endTime,$title,$timely_column[$title],$uid,$group_id);
                $data                   = $info['sum_list'];
                break;
            /*default: //合计
                $data                   = $this->get_sum_timely_lists($startTime,$endTime,$uid='');*/
        }
        return $data;
    }

    //计调及时率详情页合计数据
    /*private function get_sum_timely_lists($startTime,$endTime,$uid=''){
        $data                           = $this->get_timely_data($startTime,$endTime,$uid='');
        $lists                          = array();
        foreach ($data as $v){
            $lists[$v['title']]         = $v['sum_list'];
        }
        return $lists;
    }*/

    /**
     * 各业务类型最低毛利率设置合理性
     * @param $kinds
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function get_kpi_profit_set($kinds,$startTime,$endTime){
       $gross_db                        = M('gross');
       $data                            = array();
       $settlement_no_dj_lists          = $this->get_no_dj_settlement_lists($startTime,$endTime); //排除地接团数据
       $settlement_djyxlx_lists         = get_settlement_list($startTime,$endTime,'','','',84); //84=>地接研学旅行团团数据
       $settlement_lists                = array_merge((array)$settlement_no_dj_lists,(array)$settlement_djyxlx_lists);
       $all_kinds_maoli                 = array_sum(array_column($settlement_lists,'maoli')); //所有的已结算毛利
       $sum_weight_score                = 0;
       foreach ($kinds as $k=>$v){
           $lists                       = array();
           $op_num                      = 0;
           $sum_shouru                  = 0;
           $sum_maoli                   = 0;
           foreach ($settlement_lists as $key=>$value){
               if ($value['kind'] == $v['id']){
                   $sum_shouru          += (int)$value['untraffic_shouru'] ? $value['untraffic_shouru'] : $value['shouru']; //不含大交通收入
                   $sum_maoli           += $value['maoli'];
                   $lists[]             = $value;
                   $op_num++;
               }
           }

           $gross_list                  = $gross_db->where(array('kind_id'=>$v['id']))->find();
           $gross                       = $gross_list['gross'] ? $gross_list['gross'] : 0;


           $data[$k]['kind_id']         = $v['id'];
           $data[$k]['kind_name']       = $v['name'];
           $data[$k]['gross']           = $gross;
           $data[$k]['op_num']          = $op_num;
           $data[$k]['sum_maoli']       = $sum_maoli;
           $data[$k]['sum_shouru']      = $sum_shouru;
           $data[$k]['maolilv']         = $sum_shouru ? (round($sum_maoli/$sum_shouru,4)*100).'%' : '0%';
           $deviation                   = $this->get_profit_deviation($data[$k]['gross'],$data[$k]['maolilv']);
           $data[$k]['deviation']       = $deviation; // 偏差
           $data[$k]['dev_score']       = $this->get_deviation_score($deviation,$v['id']); //偏差得分
           $data[$k]['weight']          = $all_kinds_maoli ? (round($sum_maoli/$all_kinds_maoli,4)*100).'%' : '0%';
           $data[$k]['weight_score']    = $this->get_weight_score($data[$k]['dev_score'],$data[$k]['weight']);
           $sum_weight_score            += $data[$k]['weight_score'];
       }
       $data['sum']['op_num']           = array_sum(array_column($data,'op_num'));
       $data['sum']['sum_maoli']        = array_sum(array_column($data,'sum_maoli'));
       $data['sum']['sum_shouru']       = array_sum(array_column($data,'sum_shouru'));
       $data['sum']['maolilv']          = $data['sum']['sum_shouru'] ? (round($data['sum']['sum_maoli']/$data['sum']['sum_shouru'],4)*100).'%' : '0%';
       $data['sum']['weight_score']     = $sum_weight_score;
      return $data;
    }

    //权重得分
    private function get_weight_score($score,$weight){
        $weight_float                   = (str_replace('%','',$weight))/100;
        $weight_score                   = round($score*$weight_float,2);
        return $weight_score;
    }

    /**
     * 偏差值得分
     * @param $target
     * @param $deviation 偏差
     * 偏差值在 ±10%以内得分为100分 , ±20%以外得分为0分 , 10%~20% 得分 = (2-(偏差/10%))*100分 , 偏差在 -10%~-20% 得分 = (2+(偏差/10%))*100分
     */
    private function get_deviation_score($deviation,$kind_id){
        $deviation_float                = (str_replace('%','',$deviation))/100;
        if ($kind_id == 3){ //其他,不考核
            $complete                   = 100;
        }else{
            if ($deviation_float >= -0.1 && $deviation_float <= 0.1){ // ±10%以内得分为100分
                $complete               = $deviation_float==0 ? 0 : 100;
            }elseif ($deviation_float > 0.2 || $deviation_float < -0.2){ // ±20%以外得分为0分
                $complete               = 0;
            }elseif ($deviation_float > 0.1 && $deviation_float <= 0.2){ //10%~20% 得分 = (2-(偏差/10%))*100分
                $complete               = (2-($deviation_float/0.1))*100;
            }elseif ($deviation_float < -0.1 && $deviation_float >= -0.2){ // 偏差在 -10%~-20% 得分 = (2+(偏差/10%))*100分
                $complete               = (2+($deviation_float/0.1))*100;
            }
        }

       return $complete;
    }

    /**
     * 偏差 = (实际 - 计划)/计划
     * @param $target
     * @param $really
     */
    private function get_profit_deviation($target , $really){
        $target_float                   = (str_replace('%','',$target))/100;
        $really_float                   = (str_replace('%','',$really))/100;
        $deviation                      = $target_float ? (round(($really_float - $target_float)/$target_float,4)*100).'%' : 0;
        return $deviation;
    }
}
