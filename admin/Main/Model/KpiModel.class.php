<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class KpiModel extends Model
{

    //保存 月度/季度/半年度KPI信息
    public function addKpiInfo($year,$user,$cycle,$month=0,$quarter=0,$half_year=0,$yearCycle=0){
        if ($month)     $yearm  = $year.sprintf('%02s',$month);
        if ($quarter)   $yearm  = getQuarterMonths($quarter,$year);
        if ($half_year) $yearm  = getHalfYearMonths($half_year,$year);
        if ($yearCycle) $yearm  = getFullYearMonths($year);

        //获取用户信息
        $acc                    = M('account')->find($user);

        //判断月份是否存在
        $where                  = array();
        $where['month']         = $yearm;
        $where['user_id']       = $user;

        /*//删除以前的旧数据
        $delKpi                 = array();
        $delKpi['user_id']      = $acc['id'];
        $delKpi['year']         = $year;
        $delKpi['cycle']        = array('neq',$cycle);
        $delKpiIds              = '';
        for($a=$month;$a<13;$a++){
            if (strlen($a)<2) $a = str_pad($a,2,'0',STR_PAD_LEFT);
            $ym                 = $year.$a;
            $delKpi['month']    = array('like','%'.$ym.'%');
            $delKpiId           = M('kpi')->where($delKpi)->getField('id');
            $delKpiIds          = $delKpiIds.','.$delKpiId;
        }
        $arr_delKpiIds          = array_unique(array_filter(explode(',',$delKpiIds)));
        $arr                    = array();
        if ($arr_delKpiIds) $arr['id']  = array('in',$arr_delKpiIds);
        M('kpi')->where($arr)->delete();
        $delKpiMore             = array();
        $delKpiMore['kpi_id']   = array('in',$arr_delKpiIds);
        M('kpi_more')->where($delKpiMore)->delete();*/

        //查询这个月的KPI信息
        $kpi = M('kpi')->where($where)->find();

        //如果不存在新增
        if(!$kpi){
            //获取评分人信息
            $pfr = M('auth')->where(array('role_id'=>$acc['roleid']))->find();
            $info['ex_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
            $info['mk_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
            $info['user_id']        = $acc['id'];
            $info['user_name']      = $acc['nickname'];
            $info['role_id']        = $acc['roleid'];
            $info['status']         = 0;
            $info['year']           = $year;
            $info['month']          = $yearm;
            $info['create_time']    = time();
            $info['cycle']          = $cycle;
            $info['quarter']        = $quarter;
            $info['half_year']      = $half_year;
            $kpiid = M('kpi')->add($info);
        }else{
            $kpiid = $kpi['id'];
        }

        //获取考核指标信息
        $postid = $acc['postid'];
        $quto   = M()->table('__KPI_POST_QUOTA__ as r')->field('c.*')->join('__KPI_CONFIG__ as c on c.id = r.quotaid')->where(array('r.postid'=>$postid))->select();

        if($quto){
            foreach($quto as $k=>$v){

                //整理数据
                $data = array();
                $data['user_id']            = $user;
                $data['kpi_id']             = $kpiid;
                $data['year']               = $year;
                $data['month']              = $yearm;
                $data['quota_id']           = $v['id'];
                $data['quota_title']        = $v['quota_title'];
                $data['quota_content']      = $v['quota_content'];
                $data['weight']             = $v['weight'];
                $data['status']             = 0;
                $data['create_time']        = time();
                $data['cycle']              = $cycle;

                $where                      = array();
                $where['month']             = $yearm;
                $where['quota_id']          = $v['id'];
                $where['kpi_id']            = $kpiid;
                $more = M('kpi_more')->where($where)->find();

                if(!$more){
                    if ($month){ //月度周期
                        $zhouqi                 = set_month($yearm);
                        $zhouqi['begin_time']   = $zhouqi[0];
                        $zhouqi['end_time']     = $zhouqi[1];
                    }
                    if ($quarter){ //季度周期
                        $zhouqi                 = set_quarter($year,$quarter);
                    }
                    if ($half_year){ //半年度周期
                        $zhouqi                 = $this->set_half_year_cycle($year,$half_year);
                    }
                    if ($yearCycle){ //年度周期
                        $zhouqi                 = array();
                        $zhouqi['begin_time']   = strtotime(($year-1).'1226');
                        $zhouqi['end_time']     = strtotime($year.'1226');
                    }
                    $data['start_date']         = $zhouqi['begin_time'];
                    $data['end_date']           = $zhouqi['end_time'];
                    M('kpi_more')->add($data);
                }else{
                    M('kpi_more')->data($data)->where(array('id'=>$more['id']))->save();
                }
            }
        }

    }

    function set_half_year_cycle($year,$half_year){
        $data                       = array();
        switch ($half_year){
            case 1:
                $data['begin_time'] = strtotime(($year-1).'1226');
                $data['end_time']   = strtotime($year.'0626');
                break;
            case 2:
                $data['begin_time'] = strtotime($year.'0626');
                $data['end_time']   = strtotime($year.'1226');
        }
        return $data;
    }

    //获取KPI有"关键事项评价"考核的人员信息
    public function get_kpi_crux_username(){
        $userids                            = M('kpi_more')->where(array('year'=>date('Y'),'quota_id'=>216))->getField('user_id',true);
        $where                              = array();
        $where['status']                    = 0;
        $where['id']                        = array('in',$userids);
        $user                               = M('account')->where($where)->field('id,nickname')->select();
        $user_key                           = array();
        foreach($user as $k=>$v){
            $text                           = $v['nickname'];
            $user_key[$k]['id']             = $v['id'];
            $user_key[$k]['pinyin']         = strtopinyin($text);
            $user_key[$k]['text']           = $text;
        }
        return json_encode($user_key);
    }

    public function get_crux_info($id){
        $db                                 = M('kpi_crux');
        $list                               = $db->find($id);
        if ($list['cycle'] == 1){     $list['cycle_stu'] = '月度';  }
        elseif ($list['cycle'] == 2){ $list['cycle_stu'] = '季度';  }
        elseif ($list['cycle'] == 3){ $list['cycle_stu'] = '半年度';}
        elseif ($list['cycle'] == 4){ $list['cycle_stu'] = '年度';  }
        if (intval($list['score']) == 0 ){
            $list['score_stu'] = '<font color="#999">未评分</font>';
        } else {
            $list['score_stu'] = $list['score'].'%';
        }
        return $list;
    }

    //获取关键实行剩余权重信息
    public function get_upd_crux_remainder_weight($user_id,$month,$id=''){
        $db                                 = M('kpi_crux');
        $where                              = array();
        $where['user_id']                   = $user_id;
        $where['month']                     = $month;
        $sum_weight                         = $db->where($where)->sum('weight');
        if ($id){ //编辑
           $this_weight                     = $db->where(array('id'=>$id))->getField('weight');
            $sum_weight                     = $sum_weight - $this_weight;
        }
        $weight                             = 100 - $sum_weight;
        return $weight;
    }

    //保存kpi操作记录
    public function save_kpi_record($kpi_id,$remark){
        $data                  = array();
        $data['kpi_id']        = $kpi_id;
        $data['op_user_id']    = session('userid');
        $data['op_user_name']  = session('nickname');
        $data['op_time']       = time();
        $data['remarks']       = $remark;
        M('kpi_op_record')->add($data);
    }

    //激励机制
    public function get_encourage_type($userid){
        $userinfo               = M('account')->find($userid);
        $num                    = 0;
        if ($userinfo['rank'] == '02'){ //2队列
            $num                = 1;
        }elseif (in_array($userinfo['postid'],array(76,95,100,101))){ //76=>计调部计调专员,95=>南京计调专员 , 100=>京区计调专员 , 101=>京区计调组长
            $num                = 2;
        }elseif ($userinfo['postid'] == 74){ //74=>计调部经理
            $num                = 3;
        }
        return $num;
    }

    //各激励机制数据
    public function get_encourage_data($encourage_type,$userid,$year,$month,$userinfo){
        if ($encourage_type == 1){ //业务
            $data               = $this -> get_yw_encourage_data($userid,$year,$month,$userinfo);
        }elseif ($encourage_type == 2){ //计调专员
            $data               = $this -> get_jd_encourage_data($userid,$year,$month);
        }elseif ($encourage_type == 3){ //计调部经理
            $data               = '';
        }
        return $data;
    }

    //计调岗激励机制数据
    public function get_jd_encourage_data($userid,$year,$month){
        $year_cycle             = get_year_cycle($year);
        $quarter_cycle          = getQuarterlyCicle($year,$month); //当季度周期
        $year_settlement_lists  = get_settlement_list($year_cycle['beginTime'],$year_cycle['endTime'],'',$userid);
        $quarter_settlement_lists = get_settlement_list($quarter_cycle['begin_time'],$quarter_cycle['end_time'],'',$userid);

        //累计已发操作奖金
        $salary_months          = $this->get_salary_months($year);
        $sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('bonus');

        $data                   = array();
        $data['complete']       = $quarter_settlement_lists ? array_sum(array_column($quarter_settlement_lists,'maoli')) : 0; //当季度业绩
        $data['sum_complete']   = $year_settlement_lists ? array_sum(array_column($year_settlement_lists,'maoli')) : 0; //累计业绩
        $data['quarter_should_royalty'] = $data['complete'] * 0.01; //当季度应发操作奖金 = 当季度操作毛利 * 1%
        $data['sum_should_royalty']     = $data['sum_complete'] * 0.01; //累计应发操作奖金
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发操作奖金
        return $data;
    }

    //业务岗激励机制数据
    public function get_yw_encourage_data($userid,$year,$month,$userinfo){
        //任务系数
        $quarter                = get_quarter($month);
        $lastQuarterMonth       = $quarter == 1 ? getQuarterMonths($quarter,$year) : getQuarterMonths($quarter-1,$year); //上季度月份
        $quarterMonth           = getQuarterMonths($quarter,$year); //本季度月份
        $lastYearMonth          = substr($lastQuarterMonth,-6); //上季度最后一个月
        $endYearMonth           = substr($quarterMonth,-6); //本季度最后一个月
        $lastTarget             = $quarter == 1 ? 0 : M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>1,'month'=>$lastYearMonth))->getField('target'); //上季度累计任务系数
        $target                 = M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>1,'month'=>$endYearMonth))->getField('target'); //(本季度)累计任务系数

        //业绩
        $quarter_cycle          = getQuarterlyCicle($year,$month);
        $yearBeginTime          = get_year_settlement_start_time($year);
        $maoli                  = get_settlement_maoli($userid,$quarter_cycle['begin_time'],$quarter_cycle['end_time']); //当季度业绩
        $sum_maoli              = get_settlement_maoli($userid,$yearBeginTime,$quarter_cycle['end_time']); //累计业绩

        /*$partner_money          = get_partner_money($userinfo,$quarter_cycle['begin_time'],$quarter_cycle['end_time']); //当季度城市合伙人押金
        $sum_partner_money      = get_partner_money($userinfo,$yearBeginTime,$quarter_cycle['end_time']); //累计城市合伙人押金
        $sum_maoli              = $sum_maoli + $sum_partner_money; //累计毛利 + 累计城市合伙人
        $maoli                  = $maoli + $partner_money; //当季度毛利 + 当季度城市合伙人*/

        //提成 (100%内提取5%; 100%-150%=>20%; 150%-200%=>25%; 大于200%=>40%)
        $royalty5               = 0; //5%提成部分
        $royalty20              = 0; //20%提成部分
        $royalty25              = 0; //25%提成部分
        $royalty40              = 0; //40%提成部分
        $royaltySum             = 0; //全部提成
        if ($sum_maoli < $target){
            $royaltySum         += $sum_maoli*0.05;

            $royalty5           += $sum_maoli*0.05;
            $royalty20          += 0;
            $royalty25          += 0;
            $royalty40          += 0;
        }elseif ($sum_maoli > $target && $sum_maoli < $target*1.5){
            $royaltySum         += $target*0.05;
            $royaltySum         += ($sum_maoli - $target)*0.2;

            $royalty5           += $target*0.05;
            $royalty20          += ($sum_maoli - $target)*0.2;
            $royalty25          += 0;
            $royalty40          += 0;
        }elseif ($sum_maoli > $target*1.5 && $sum_maoli < $target*2){
            $royaltySum         += $target*0.05;
            $royaltySum         += ($target*1.5 - $target)*0.2;
            $royaltySum         += ($sum_maoli - $target*1.5)*0.25;

            $royalty5           += $target*0.05;
            $royalty20          += ($target*1.5 - $target)*0.2;
            $royalty25          += ($sum_maoli - $target*1.5)*0.25;
            $royalty40          += 0;
        }elseif ($sum_maoli > $target*2){
            $royaltySum         += $target*0.05;
            $royaltySum         += ($target*1.5 - $target)*0.2;
            $royaltySum         += ($target*2 - $target*1.5)*0.25;
            $royaltySum         += ($sum_maoli - $target*2)*0.4;

            $royalty5           += $target*0.05;
            $royalty20          += ($target*1.5 - $target)*0.2;
            $royalty25          += ($target*2.0 - $target*1.5)*0.25;
            $royalty40          += ($sum_maoli - $target*2)*0.4;
        }

        //累计已发放提成	当季度发放提成
        $salary_months          = $this->get_salary_months($year);
        $sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('total');

        $data                   = array();
        $data['target']         = $target - $lastTarget; //当季度任务指标 = 累计任务指标 - 上季度任务指标
        $data['complete']       = $maoli; //当季度业绩
        $data['sum_target']     = $target; //累计目标值
        $data['sum_complete']   = $sum_maoli; //累计业绩
        $data['royalty5']       = $royalty5; //5%部分业绩提成
        $data['royalty20']      = $royalty20; //20%部分业绩提成
        $data['royalty25']      = $royalty25; //25%部分业绩提成
        $data['royalty40']      = $royalty40; //40%部分业绩提成
        $data['royaltySum']     = $royaltySum; //全部业绩提成
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发提成
        $data['quarter_should_royalty'] = $data['royaltySum'] - $data['sum_royalty_payoff']; //当季度应发提成 = 全部业绩提成 - 累计已发提成;
        return $data;
    }

    //发放业绩提成的月份
    private function get_salary_months($year){
        $year_arr               = array();

        //年度薪资月份信息
        for ($i=2; $i<=12; $i++){
            $mon                = strlen($i)<2 ? str_pad($i,2,'0',STR_PAD_LEFT) : $i;
            $year_arr[]         = $year.$mon;
        }
        $year_arr[]             = ($year+1).'01'; //一月份发上一年的提成

        $data                       = array();
        $data['salary_year_months'] = $year_arr;
        return $data;
    }

}