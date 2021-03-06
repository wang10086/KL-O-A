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
        $get_score_FF                   = 0;
        $sum_score_AA                   = 0; //总分
        $sum_score_BB                   = 0;
        $sum_score_CC                   = 0;
        $sum_score_DD                   = 0;
        $sum_score_EE                   = 0;
        $sum_score_FF                   = 0;
        $get_score_total                = 0; //合计得分
        $sum_score_total                = 0; //合计总分
        foreach ($info as $k=>$v){ //已评分部分
            $get_score_AA               += $v['AA'];
            $get_score_BB               += $v['BB'];
            $get_score_CC               += $v['CC'];
            $get_score_DD               += $v['DD'];
            $get_score_EE               += $v['EE'];
            $get_score_FF               += $v['FF'];
            if($v['AA']){ $sum_score_AA += 10; $sum_score_total+= 10; }
            if($v['BB']){ $sum_score_BB += 10; $sum_score_total+= 10; }
            if($v['CC']){ $sum_score_CC += 10; $sum_score_total+= 10; }
            if($v['DD']){ $sum_score_DD += 10; $sum_score_total+= 10; }
            if($v['EE']){ $sum_score_EE += 10; $sum_score_total+= 10; }
            if($v['FF']){ $sum_score_FF += 10; $sum_score_total+= 10; }
            $get_score_total            += $v['AA'] + $v['BB'] + $v['CC'] + $v['DD'] + $v['EE'] + $v['FF'];
        }

        foreach ($unscore_userids as $kk=>$vv){ //未评分部分,每项只得50%分数
            if ($get_score_AA){ $get_score_AA += 5; $get_score_total += 5; } //得分
            if ($get_score_BB){ $get_score_BB += 5; $get_score_total += 5; }
            if ($get_score_CC){ $get_score_CC += 5; $get_score_total += 5; }
            if ($get_score_DD){ $get_score_DD += 5; $get_score_total += 5; }
            if ($get_score_EE){ $get_score_EE += 5; $get_score_total += 5; }
            if ($get_score_FF){ $get_score_FF += 5; $get_score_total += 5; }
            if ($sum_score_AA){ $sum_score_AA += 10;   $sum_score_total += 10; } //总分
            if ($sum_score_BB){ $sum_score_BB += 10;   $sum_score_total += 10; }
            if ($sum_score_CC){ $sum_score_CC += 10;   $sum_score_total += 10; }
            if ($sum_score_DD){ $sum_score_DD += 10;   $sum_score_total += 10; }
            if ($sum_score_EE){ $sum_score_EE += 10;   $sum_score_total += 10; }
            if ($sum_score_FF){ $sum_score_FF += 10;   $sum_score_total += 10; }
        }

        $data                           = array();
        $data['average_AA']             = $sum_score_AA?(round($get_score_AA/$sum_score_AA,2)*100).'%':'';
        $data['average_BB']             = $sum_score_BB?(round($get_score_BB/$sum_score_BB,2)*100).'%':'';
        $data['average_CC']             = $sum_score_CC?(round($get_score_CC/$sum_score_CC,2)*100).'%':'';
        $data['average_DD']             = $sum_score_DD?(round($get_score_DD/$sum_score_DD,2)*100).'%':'';
        $data['average_EE']             = $sum_score_EE?(round($get_score_EE/$sum_score_EE,2)*100).'%':'';
        $data['average_FF']             = $sum_score_FF?(round($get_score_FF/$sum_score_FF,2)*100).'%':'';
        $data['sum_average']            = $sum_score_total?(round($get_score_total/$sum_score_total,2)*100).'%':'50%';
        $data['score_account_name']     = implode(',',array_column($info,'input_username'));
        return $data;
    }

    /**
     * 不合格处理率(公司) (优先算低于90%的团 , 然后少于3星或低于60分的团)
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function get_unqualify_data($startTime,$endTime){
        $quota                          = get_timely(2); //1=>不合格处理率
        $quota                          = array_column($quota,'content','title');
        $data1                          = get_unqualify_lg3_data($startTime,$endTime,'单项顾客满意度',$quota['单项顾客满意度']);
        $data2                          = get_unqualify_lg_90percent_data($startTime,$endTime,'项目顾客满意度',$quota['项目顾客满意度']);
        $data3                          = get_complaint_data($startTime,$endTime,'顾客有效投诉',$quota['顾客有效投诉']);
        $data4                          = get_safe_data($startTime,$endTime,'安全责任事故',$quota['安全责任事故']);
        $data5                          = get_company_complaint_data($startTime,$endTime,'公司内部有效投诉',$quota['公司内部有效投诉']);
        $data6                          = get_company_qaqc_data($startTime,$endTime,'品质检查',$quota['品质检查']);

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

    //获取团内的不合格处理详情
    public function get_op_unqualify_list($type,$startTime,$endTime){
        if ($type == 1){
            $op_lists                   = get_lg3_list($startTime,$endTime);
        }elseif ($type == 2){
            //$op_lists                   = get_lg_90percent_list($startTime,$endTime);
            $data                       = get_unqualify_lg_90percent_data($startTime,$endTime);
            $op_lists                   = $data['sum_list'];
        }

        foreach ($op_lists as $k=>$v){
            $where                      = array();
            $where['o.op_id']           = $v['op_id'];
            $field                      = 'o.op_id,o.group_id,o.project,o.create_user_name,u.mobile,u.time,q.id as qaqc_id,q.ex_user_name,q.ex_time,q.status';
            $list                       = M()->table('__OP__ as o')->join('__TCS_SCORE_USER__ as u on u.op_id=o.op_id','left')->join('__QAQC__ as q on q.op_id=o.op_id','left')->where($where)->field($field)->find();

            if ($list['qaqc_id'] && in_array($list['status'],array(1,2))){
                $op_lists[$k]['show_stu']= '<span class="green">已处理</span>';
            }else{
                $op_lists[$k]['show_stu']= '<span class="red">未处理</span>';
            }

            $op_lists[$k]['group_id']    = $list['group_id'];
            $op_lists[$k]['project']     = $list['project'];
            $op_lists[$k]['create_user'] = $list['create_user_name'];
            $op_lists[$k]['mobile']      = $list['mobile'];
            $op_lists[$k]['input_time']  = $v['input_time'];
            $op_lists[$k]['ex_user_name']= $list['ex_user_name'];
            $op_lists[$k]['ex_time']     = $list['ex_time'];
            $op_lists[$k]['status']      = $list['status'];
            $op_lists[$k]['qaqc_id']     = $list['qaqc_id'];
        }
        return $op_lists;
    }

    //获取非团的不合格处理详情
    public function get_nop_unqualify_list($ids=''){
        $where                          = array();
        $where['id']                    = array('in',$ids);
        $lists                          = M('qaqc')->where($where)->select();

        foreach ($lists as $k=>$v){
            if (in_array($v['status'],array(1,2))){
                $lists[$k]['show_stu']  = '<span class="green">已处理</span>';
            }else{
                $lists[$k]['show_stu']  = '<span class="red">未处理</span>';
            }
        }
        return $lists;
    }

    /**
     * 不合格处理率(员工)
     * @param $startTime
     * @param $endTime
     * @return array
     */
    public function get_unqualify_staff_data($yearMonth){
        $where                          = array();
        $where['u.month']               = $yearMonth;
        $where['u.status']              = 1; //审核通过
        $field                          = 'u.user_id,u.user_name,u.type,u.month,u.score,u.remark,q.id as qaqc_id,q.type as qaqc_type,q.ex_time';
        $lists                          = M()->table('__QAQC_USER__ as u')->join('__QAQC__ as q on q.id=u.qaqc_id','left')->where($where)->field($field)->select();
        $types                          = M('quota')->where(array('type'=>2))->getField('id,title,content',true);
        foreach ($lists as $k=>$v){
            $quota_id                   = $this->get_quota_id($v['qaqc_type']);
            foreach ($types as $key=>$value){
                if ($quota_id == $value['id']){
                    $lists[$k]['title'] = $value['title'];
                    $lists[$k]['content']= $value['content'];
                }
            }
            $sign                       = $v['type'] ==1 ? '+' : '-'; //1=>奖励, 0=>惩罚
            $lists[$k]['audit_res']     = $sign.$v['score'];
        }
        return $lists;
    }

    public function get_quota_id($type){
        switch ($type){
            case 1:
                $qid                    = 6;
                break;
            case 2:
                $qid                    = 7;
                break;
            case 3:
                $qid                    = 8;
                break;
            case 4:
                $qid                    = 9;
                break;
            case 5:
                $qid                    = 10;
                break;
            case 6:
                $qid                    = 11;
                break;
        }
        return $qid;
    }

    public function get_satisfaction_list($yearMonth,$pin=1){
        $db                             = M('satisfaction');
        $satisfaction_config_db         = M('satisfaction_config');
        $satisfaction_lists             = $db->where(array('monthly'=>$yearMonth,'kind'=>P::SCORE_KIND_ACCOUNT))->select(); //所有的已评分列表
        $should_users_lists             = $satisfaction_config_db->where(array('month'=>$yearMonth))->select(); //所有当月应评分信息
        //$user_lists                     = array_keys(C('SATISFACTION_USERS'));
        $user_lists                     = array_keys($this->get_satisfaction_user($pin));

        $lists                          = array();
        foreach ($user_lists as $k=>$v){
            $should_users               = array(); //应评分人员
            $input_userids              = array(); //已评价人员
            $unscore_userids            = array(); //未评价人员
            $info                       = array();

            foreach ($should_users_lists as $sk=>$sv){
                if ($sv['user_id']==$v){
                    $should_users[]     = $sv['score_user_id'];
                }
            }

            foreach ($satisfaction_lists as $key=>$value){
                if ($value['monthly']==$yearMonth && $value['account_id']==$v){
                    $info[]             = $value;
                    $input_userids[]    = $value['input_userid'];
                }
            }

            foreach ($should_users as $kk=>$vv){
                if (!in_array($vv,$input_userids)){
                    $unscore_userids[]  = $vv;
                }
            }
            $unscore_user_lists         = M('account')->where(array('id'=>array('in',$unscore_userids)))->getField('nickname',true);

            $average_data               = $this->get_average_data($info,$unscore_userids);
            $lists[$k]['monthly']       = $yearMonth;
            $lists[$k]['account_id']    = $v;
            $lists[$k]['account_name']  = M('account')->where(array('id'=>$v))->getField('nickname');
            $lists[$k]['average_AA']    = $average_data['average_AA'];
            $lists[$k]['average_BB']    = $average_data['average_BB'];
            $lists[$k]['average_CC']    = $average_data['average_CC'];
            $lists[$k]['average_DD']    = $average_data['average_DD'];
            $lists[$k]['average_EE']    = $average_data['average_EE'];
            $lists[$k]['average_FF']    = $average_data['average_FF'];
            $lists[$k]['sum_average']   = $average_data['sum_average'];
            $lists[$k]['score_accounts']= $average_data['score_account_name'];
            $lists[$k]['unscore_users'] = implode(',',$unscore_user_lists);
        }
        return $lists;
    }

    //获取内部满意度需评分人员
    public function get_satisfaction_user($type=0){
        $db                             = M('Satisfaction_user');
        if ($type){
            $data                       = $db->where(array('type'=>$type))->getField('account_id,account_name',true);
        }else{
            $data                       = $db->getField('account_id,account_name',true);
        }
        return $data;
    }

}
