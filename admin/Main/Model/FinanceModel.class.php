<?php
/**
 * Date: 2018/12/13
 * Time: 16:13
 */

namespace Main\Model;


use Think\Model;
use Sys\P;

class FinanceModel extends Model{

    //获取团计调信息
    public function get_jidiao($opid){
       $jd =  M('op_auth')->where(array('op_id'=>$opid))->getField('yusuan');
        return $jd;
    }

    public function get_jkd($lists){
        $costacc_ids    = array_column($lists,'costacc_id');
        $arr            = array();
        foreach ($costacc_ids as $v){
            $jkd_ids    = M('jiekuan_detail')->where(array('costacc_id'=>$v))->getField('jkd_id',true);
            $arr[]      = $jkd_ids;
        }

        $result         = array();
        foreach ($arr as $v){
            foreach ($v as $vv){
                $result[] = $vv;
            }
        }

        $ids            = implode(',',array_unique($result));
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

    /**
     * 从预算获取该团的信息,带至结算页面
     * @param $op           团信息
     * @param $is_zutuan    是否是内部地接 1=>是 0=>否
     * @return array
     */
    public function get_budget_costacc($op,$is_zutuan=0){
        $opid                       = $op['op_id'];
        $guide                      = M()->table('__GUIDE_PAY__ as p')->field('g.name,p.op_id,p.num,p.price,p.total,p.really_cost,p.remark')->join('left join __GUIDE__ as g on p.guide_id = g.id')->where(array('p.op_id'=>$opid))->select();
        $costa                      = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1,'type'=>array('not in',array(2,13))))->order('type')->select();  //排除专家辅导员和地接预算
        $op_supplier                = M()->table('__OP_SUPPLIER__ as s')->field('s.op_id,s.supplier_name as title,c.cost as unitcost,c.amount,c.total,c.cost_type as type,s.remark')->join('left join __OP_COST__ as c on c.link_id=s.id')->where(array('s.op_id'=>$opid,'c.op_id' => $opid))->select();

        $costacc                    = array();
        foreach ($guide as $k=>$v){
            $data['op_id']          = $v['op_id'];
            $data['title']          = $v['name'];
            $data['unitcost']       = $v['price'];
            $data['amount']         = $v['num'];
            //$data['total']          = intval($v['total']) ? $v['total'] : $v['really_cost'];
            $data['total']          = intval($v['really_cost']) ? $v['really_cost'] : $v['total'];
            $data['type']           = 2;
            $data['remark']         = $v['remark'];
            $costacc[]              = $data;
        }
        foreach ($costa as $v){
            $costacc[]              = $v;
        }
        foreach ($op_supplier as $v){
            $costacc[]              = $v;
        }

        if ($is_zutuan == 1 && $op['kind'] != 87){ //87=>排除单进院所,单进院所暂时未生成地接团
            $dijie_shouru           = $this->get_landAcquisitionAgency_money($op,P::REQ_TYPE_SETTLEMENT);   //801 获取地接结算收入
            $op_types               = array_column($costacc,'type');

            if (!in_array(13,$op_types)){
                $arr                = array();
                $arr['id']          = 0;
                $arr['op_id']       = $opid;
                $arr['title']       = '地接费用';
                $arr['unitcost']    = $dijie_shouru;
                $arr['amount']      = 1;
                $arr['total']       = $dijie_shouru;
                $arr['remark']      = '地接费用';
                $arr['type']        = 13;   //内部地接
                $arr['status']      = 0;
                $arr['del_status']  = 0;
                $arr['product_id']  = 0;

                $costacc[]          = $arr;
            }
        }
        return $costacc;
    }

    public function get_landAcquisitionAgency_money($op,$req_type){
        switch ($req_type){
            case 800:
                $db             = M('op_budget');
                break;
            case 801:
                $db             = M('op_settlement');
                break;
        }
        $where                  = array();
        $where['op_id']         = $op['dijie_opid'];
        $where['audit_status']  = 1;
        $money                  = $db->where($where)->getField('shouru');
        return $money;
    }

    /**
     * 保存回款计划
     * @param $payment
     * @param $opid
     * @param $shouru
     * @return int
     */
    public function save_money_back_plans($payment,$opid,$shouru){
        $db             = M('contract_pay');
        $cid            = M('contract')->where(array('op_id'=>$opid))->getField('id');
        $op             = M('op')->where(array('op_id'=>$opid))->find();
        $num            = 0;
        $ids            = array();
        if (is_array($payment)){
            foreach ($payment as $v){
                //保存数据
                $info = array();
                $info['cid']			= $cid?$cid:0;
                $info['no']			    = $v['no'];
                $info['pro_name']	    = $op['project'];
                $info['op_id']  		= $opid;
                $info['amount']		    = $v['amount'];
                $info['ratio']		    = $v['ratio'];
                $info['return_time']	= strtotime($v['return_time']);
                $info['remark']		    = $v['remarks'];
                $info['type']           = $v['type'];
                $info['company']        = $v['company'];
                $info['userid'] 		= cookie('userid');
                $info['payee']		    = $op['create_user'];
                $info['create_time']    = NOW_TIME;
                if ($v['pid']){
                    $res                = $db->where(array('id'=>$v['pid']))->save($info);
                    $ids[]              = $v['pid'];
                }else{
                    $res                = $db->add($info);
                    $ids[]              = $res;
                }
                if ($res) $num++;
            }

            if ($ids){ //删除相关数据
                $where                  = array();
                $where['op_id']         = $opid;
                $where['id']            = array('not in',$ids);
                $delres                 = $db->where($where)->delete();
                if ($delres) $num++;
            }
        }
        if ($num){
            $record                     = array();
            $record['op_id']            = $opid;
            $record['optype']           = 4;
            $record['explain']          = '编辑回款计划信息';
            //op_record($record);
        }
        return $num;
    }

    /**
     * 获取回款计划列表
     * @param $opid
     * @return mixed
     */
    public function get_money_back_lists($opid){
        $lists                          = M('contract_pay')->where(array('op_id'=>$opid))->select();
        foreach ($lists as $k=>$v){
            if ($v['status'] ==2){
                $lists[$k]['huikuan_stu']= "<span class='green'>已回款</span>";
            }elseif ($v['status'] ==1){
                $lists[$k]['huikuan_stu']= "<span class='blue'>回款中</span>";
            }else{
                $lists[$k]['huikuan_stu']= "<span class='red'>未回款</span>";
            }
        }
        return $lists;
    }

    /**
     * 判断所填写回款计划是否需要审核(审核页面使用)
     * @param $opid
     */
    public function get_backMoneyPlans($opid){
        //1、在业务实施前回款不小于70%；2、在业务实施结束后10个工作日收回全部尾款；
        $confirm_info                   = M('op_team_confirm')->where(array('op_id'=>$opid))->find();
        $pay_lists                      = M('contract_pay')->where(array('op_id'=>$opid))->select();
        if ($pay_lists){
            $count                          = count($pay_lists);
            $start_time                     = $confirm_info['dep_time']; //实施时间
            $end_time                       = $confirm_info['ret_time']; //结束时间
            $first_time                     = $pay_lists[0]['return_time']; //首次计划回款时间
            $return_time                    = $pay_lists[$count-1]['return_time']; //最后一次计划回款时间
            $after_ten_days                 = getAfterWorkDay(10,$end_time); //获取业务实施结束后十个工作日
            $after_ten_time                 = strtotime($after_ten_days);
            if ($first_time>$start_time || $return_time>$after_ten_time){
                $res                        = '-1'; //超时
            }else{
                $res                        = 0; //正常
            }
        }else{
            $res                            = '-1'; //无回款计划
        }

        return $res;
    }

    /**
     * 获取预算审核人id
     * @param $opid
     */
    public function get_budget_audit_uid($opid){
        $type                               = P::REQ_TYPE_BUDGET;
        $where                              = array();
        $where['l.req_type']                = $type;
        $where['b.op_id']                   = $opid;
        $field                              = '';
        $list                               = M()->table('__AUDIT_LOG__ as l')->join('__OP_BUDGET__ as b on b.id=l.req_id','left')->where($where)->find();
        $audit_uid                          = $list['audit_uid'];
        return $audit_uid;
    }

    //获取财务的及时率
    public function get_timely_data($startTime,$endTime,$uid=''){
        $timely                         = get_timely(5); //5=>财务操作及时性

        $huikuan_data                   = get_huikuan_sure_timely_data($startTime,$endTime,$timely[0]['title'],$timely['0']['content']); //回款确认及时性
        //$budget_data                    = get_budget_data($startTime,$endTime,$timely[1]['title'],$timely['1']['content'],$uid); //报销支付及时性
        //$settlement_data                = get_settlement_data($startTime,$endTime,$timely[2]['title'],$timely['2']['content'],$uid); //项目财务决算及时性

        $data[]                         = $huikuan_data;
        //$data[]                         = $budget_data;
        //$data[]                         = $settlement_data;

        return $data;
    }

    //获取财务及时率合计
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

    //计调及时率详情
    public function get_timely_type($title,$startTime,$endTime,$uid=0,$group_id=''){
        $timely                         = get_timely(5); //5=>财务工作及时性
        $timely_column                  = array_column($timely,'content','title');
        switch ($title){
            case $timely[0]['title']: //回款确认及时性
                $info                   = get_huikuan_sure_timely_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            /*case $timely[1]['title']: //报销支付及时性
                $info                   = get_budget_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case $timely[2]['title']: //项目财务决算及时性
                $info                   = get_settlement_data($startTime,$endTime,$title,$timely_column[$title],$uid);
                $data                   = $info['sum_list'];
                break;*/
        }
        return $data;
    }
}
