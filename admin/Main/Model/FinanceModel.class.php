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
     * 判断该团是否已完成回款(按照合同金额)
     * @param $opid
     * @return int
     */
    public function check_money_back($opid){
        $huikuan_lists          = M('op_huikuan')->where(array('op_id'=>$opid,'audit_status'=>1))->select();
        $yihuikuan              = array_sum(array_column($huikuan_lists,'huikuan'));
        //合同金额
        $contract_amount        = M('contract')->where(array('op_id'=>$opid,'status'=>1))->getField('contract_amount');
        //地接团结算不受回款限制
        $dijie_opids            = array_filter(M('op')->getField('dijie_opid',true));
        //暂未排除未立合同的项目
        if ($yihuikuan >= $contract_amount || in_array($opid,$dijie_opids)){
            $money_back         = 1;    //已回款
        }else{
            $money_back         = 0;    //未回款
        }
        return $money_back;
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
            $data['total']          = $v['really_cost'];
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

        if ($is_zutuan == 1){
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


    public function get_money_back_lists($opid){
        $lists                          = M('contract_pay')->where(array('op_id'=>$opid))->select();
        foreach ($lists as $k=>$v){
            if ($v['status'] ==2){
                $lists[$k]['huikuan_stu']= "<span class='green'>已回款</span>";
            }elseif ($v['status'] ==2){
                $lists[$k]['huikuan_stu']= "<span class='blue'>回款中</span>";
            }else{
                $lists[$k]['huikuan_stu']= "<span class='red'>未回款</span>";
            }
        }
        return $lists;
    }
}