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


}