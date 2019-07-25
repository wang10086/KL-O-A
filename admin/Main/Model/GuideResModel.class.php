<?php
/**
 * Date: 2019/06/10
 * Time: 18:42
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class GuideResModel extends Model{

    //获取计调的及时率
    public function get_timely_data($startTime,$endTime,$uid=''){
        $timely                         = get_timely(1); //1=>计调操作及时性
        $timely                         = array_column($timely,'content','title');
        $costacc_data                   = get_costacc_data($startTime,$endTime,'及时性',$timely['及时性'],$uid);
        $budget_data                    = get_budget_data($startTime,$endTime,'及时性',$timely['及时性'],$uid);
        $settlement_data                = get_settlement_data($startTime,$endTime,'及时性',$timely['及时性'],$uid);
        $reimbursement_data             = get_reimbursement_data($startTime,$endTime,'及时性',$timely['及时性'],$uid);

        $data[]                         = $costacc_data;
        $data[]                         = $budget_data;
        $data[]                         = $settlement_data;
        $data[]                         = $reimbursement_data;
        return $data;
    }

    /*//获取计调及时率合计
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
        $jd_roles                       = array(29,31,42,116); //29=>计调专员 , 31=>计调操作经理 ,42=>南京计调专员, 116=>京区计调中心
        $where                          = array();
        $where['roleid']                = array('in',$jd_roles);
        $where['status']                = array('in',array(0,1));
        $where['nickname']              = array('not in',array('孟华华'));
        $operator                       = M('account')->where($where)->getField('id,nickname',true);
        return $operator;
    }

    //计调及时率详情
    public function get_timely_type($title,$startTime,$endTime,$uid=0){
        $timely                         = get_timely(1); //1=>计调操作及时性
        $timely                         = array_column($timely,'content','title');
        switch ($title){
            case '报价及时性':
                $info                   = get_costacc_data($startTime,$endTime,$title,$timely[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case '预算及时性':
                $info                   = get_budget_data($startTime,$endTime,$title,$timely[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case '结算及时性':
                $info                   = get_settlement_data($startTime,$endTime,$title,$timely[$title],$uid);
                $data                   = $info['sum_list'];
                break;
            case '报账及时性':
                $info                   = get_reimbursement_data($startTime,$endTime,$title,$timely[$title],$uid);
                $data                   = $info['sum_list'];
                break;
        }
        return $data;
    }*/


}