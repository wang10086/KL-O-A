<?php
/**
 * Date: 2018/12/13
 * Time: 16:13
 */

namespace Main\Model;


use Think\Model;
use Sys\P;

class InspectModel extends Model{

    //获取每一项指标的平均分 未评分人员全部按照50%
    public function get_average_data($info,$unscore_userids=''){
        $get_score_AA                   = 0; //得分
        $get_score_BB                   = 0;
        $get_score_CC                   = 0;
        $get_score_DD                   = 0;
        $get_score_EE                   = 0;
        $sum_score_AA                   = 0; //总分
        $sum_score_BB                   = 0;
        $sum_score_CC                   = 0;
        $sum_score_DD                   = 0;
        $sum_score_EE                   = 0;
        $get_score_total                = 0; //合计得分
        $sum_score_total                = 0; //合计总分
        foreach ($info as $k=>$v){ //已评分部分
            $get_score_AA               += $v['AA'];
            $get_score_BB               += $v['BB'];
            $get_score_CC               += $v['CC'];
            $get_score_DD               += $v['DD'];
            $get_score_EE               += $v['EE'];
            if($v['AA']){ $sum_score_AA += 5; $sum_score_total+= 5; }
            if($v['BB']){ $sum_score_BB += 5; $sum_score_total+= 5; }
            if($v['CC']){ $sum_score_CC += 5; $sum_score_total+= 5; }
            if($v['DD']){ $sum_score_DD += 5; $sum_score_total+= 5; }
            if($v['EE']){ $sum_score_EE += 5; $sum_score_total+= 5; }
            $get_score_total            += $v['AA'] + $v['BB'] + $v['CC'] + $v['DD'] + $v['EE'];
        }

        foreach ($unscore_userids as $kk=>$vv){ //未评分部分,每项只得50%分数
            if ($get_score_AA){ $get_score_AA += 2.5; $get_score_total += 2.5; } //得分
            if ($get_score_BB){ $get_score_BB += 2.5; $get_score_total += 2.5; }
            if ($get_score_CC){ $get_score_CC += 2.5; $get_score_total += 2.5; }
            if ($get_score_DD){ $get_score_DD += 2.5; $get_score_total += 2.5; }
            if ($get_score_EE){ $get_score_EE += 2.5; $get_score_total += 2.5; }
            if ($sum_score_AA){ $sum_score_AA += 5;   $sum_score_total += 5; } //总分
            if ($sum_score_BB){ $sum_score_BB += 5;   $sum_score_total += 5; }
            if ($sum_score_CC){ $sum_score_CC += 5;   $sum_score_total += 5; }
            if ($sum_score_DD){ $sum_score_DD += 5;   $sum_score_total += 5; }
            if ($sum_score_EE){ $sum_score_EE += 5;   $sum_score_total += 5; }
        }

        $data                           = array();
        $data['average_AA']             = $get_score_AA/$sum_score_AA?(round($get_score_AA/$sum_score_AA,2)*100).'%':'';
        $data['average_BB']             = $get_score_BB/$sum_score_BB?(round($get_score_BB/$sum_score_BB,2)*100).'%':'';
        $data['average_CC']             = $get_score_CC/$sum_score_CC?(round($get_score_CC/$sum_score_CC,2)*100).'%':'';
        $data['average_DD']             = $get_score_DD/$sum_score_DD?(round($get_score_DD/$sum_score_DD,2)*100).'%':'';
        $data['average_EE']             = $get_score_EE/$sum_score_EE?(round($get_score_EE/$sum_score_EE,2)*100).'%':'';
        $data['sum_average']            = round($get_score_total/$sum_score_total,2)?(round($get_score_total/$sum_score_total,2)*100).'%':'50%';
        $data['score_account_name']     = implode(',',array_column($info,'input_username'));
        return $data;
    }

    //不合格处理率
    public function get_unqualify_data($startTime,$endTime){
        /*
         * '单项顾客满意度' => string '少于三星或低于60分；10个工作日处理完成' (length=55)
  '项目顾客满意度' => string '低于90%；10个工作日处理完成' (length=38)
  '顾客有效投诉' => string '是指外部顾客对公司的有效投诉；10个工作日处理完成' (length=71)
  '安全责任事故' => string '是指发生人身伤亡或财产损失在2000元以上的责任事故；10个工作日处理完成' (length=99)
  '公司内部有效投诉' => string '是指公司员工对他人或他部门的有效投诉；5个工作日处理完成' (length=82)
  '品质检查' => string '安全品控部品质检查、公司组织的专项检查和各级领导发现的不合格项目；5个工作日处理完成' (length=124)
         * */
        $quota                          = get_timely(2); //1=>不合格处理率
        $quota                          = array_column($quota,'content','title');
        $data1                          = get_reimbursement_data($startTime,$endTime,'单项顾客满意度',$quota['单项顾客满意度']);
        $data2                          = get_reimbursement_data($startTime,$endTime,'项目顾客满意度',$quota['项目顾客满意度']);
        $data3                          = get_reimbursement_data($startTime,$endTime,'顾客有效投诉',$quota['顾客有效投诉']);
        $data4                          = get_reimbursement_data($startTime,$endTime,'安全责任事故',$quota['安全责任事故']);
        $data5                          = get_reimbursement_data($startTime,$endTime,'公司内部有效投诉',$quota['公司内部有效投诉']);
        $data6                          = get_reimbursement_data($startTime,$endTime,'品质检查',$quota['品质检查']);

        $data[]                         = $data1;
        $data[]                         = $data2;
        $data[]                         = $data3;
        $data[]                         = $data4;
        $data[]                         = $data5;
        $data[]                         = $data6;
        return $data;
    }

    //获取合计不合格处理率
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

}