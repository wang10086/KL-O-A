<?php
/**
 * Date: 2019/06/10
 * Time: 18:42
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class GuideResModel extends Model{

    //获取计调的及时率(公司)
    public function get_timely_data($startTime,$endTime,$uid=''){
        $timely                         = get_timely(3); //3=>教务操作及时性
        $timely                         = array_column($timely,'content','title');
        $guide_sure_data                = get_guide_sure_data($startTime,$endTime,'专家/辅导员确认核实及时性',$timely['专家/辅导员确认核实及时性'],1);
        $guide_dispatch_data            = get_guide_dispatch_data($startTime,$endTime,'专家/辅导员调度安排及时性',$timely['专家/辅导员调度安排及时性'],2);
        $guide_train_data               = get_guide_train_data($startTime,$endTime,'专家/辅导员培训工作及时性',$timely['专家/辅导员培训工作及时性'],3);

        $data[]                         = $guide_sure_data;
        $data[]                         = $guide_dispatch_data;
        $data[]                         = $guide_train_data;
        return $data;
    }

    //获取计调的及时率(各教务)
    public function get_user_timely_data($startTime,$endTime,$uid=''){
        $timely                         = get_timely(3); //3=>教务操作及时性
        $timely                         = array_column($timely,'content','title');
        $guide_sure_data                = get_jw_sure_data($startTime,$endTime,'专家/辅导员确认核实及时性',$timely['专家/辅导员确认核实及时性'],$uid,1);
        $guide_dispatch_data            = get_jw_dispatch_data($startTime,$endTime,'专家/辅导员调度安排及时性',$timely['专家/辅导员调度安排及时性'],$uid,2);
        $guide_train_data               = get_jw_train_data($startTime,$endTime,'专家/辅导员培训工作及时性',$timely['专家/辅导员培训工作及时性'],$uid,3);

        $data[]                         = $guide_sure_data;
        $data[]                         = $guide_dispatch_data;
        $data[]                         = $guide_train_data;
        //P($data);die;
        return $data;
    }

    //计调及时率详情
    public function get_timely_type($title,$startTime,$endTime,$uid=0){
        $timely                         = get_timely(3); //1=>教务操作及时性
        $timely                         = array_column($timely,'content','title');
        switch ($title){
            case '专家/辅导员确认核实及时性':
                $type                   = 1;
                $info                   = get_jw_sure_data($startTime,$endTime,$title,$timely[$title],$uid,$type);
                break;
            case '专家/辅导员调度安排及时性':
                $type                   = 2;
                $info                   = get_jw_dispatch_data($startTime,$endTime,$title,$timely[$title],$uid,$type);
                break;
            case '专家/辅导员培训工作及时性':
                $type                   = 3;
                $info                   = get_jw_train_data($startTime,$endTime,$title,$timely[$title],$uid,$type);
                break;
        }
        return $info;
    }

    //获取教务及时率合计
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