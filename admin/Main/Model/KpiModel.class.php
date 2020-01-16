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
        if ($userinfo['rank'] == '02' && !in_array($userid,array(41,42,43))){ //2队列  排除常规业务中心
            $num                = 1;
        }elseif (in_array($userinfo['postid'],array(76,95,100,101))){ //76=>计调部计调专员,95=>南京计调专员 , 100=>京区计调专员 , 101=>京区计调组长
            $num                = 2;
        }elseif ($userinfo['postid'] == 74){ //74=>计调部经理
            $num                = 3;
        }elseif (in_array($userinfo['postid'],array(77,94,45))){ // 77=>京区业务中心经理,94=>南京项目部经理,45=>武汉项目部副经理
            $num                = 4;
        }
        return $num;
    }

    //各激励机制数据
    public function get_encourage_data($encourage_type,$userid,$year,$month,$userinfo){
        if ($encourage_type == 1){ //业务 排除常规业务中心
            $data               = $this -> get_yw_encourage_data($userid,$year,$month,$userinfo);
        }elseif ($encourage_type == 2){ //计调专员
            $data               = $this -> get_jd_encourage_data($userid,$year,$month);
        }elseif ($encourage_type == 3) { //计调部经理
            $data = $this->get_jdjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type == 4) { // 部门经理 京区,南京,武汉
            $data = $this->get_ywbmjl_encourage_data($userid, $year, $month);
        }
        return $data;
    }

    //业务部门经理激励机制数据
    public function get_ywbmjl_encourage_data($userid, $year, $month){

    }


    //计调经理激励机制数据
    public function get_jdjl_encourage_data($userid,$year,$month){
        $quarter                        = get_quarter($month);
        //$year_cycle                     = get_year_cycle($year);
        $year_cycle                     = get_year_begin_to_this_quarter_end_cycle($year,$month); //获取年初累计到当季度末周期
        $quarter_cycle                  = getQuarterlyCicle($year,$month);  //当季度周期
        //$last_year_cycle                = get_year_cycle($year-1);          //去年周期
        $last_year_cycle                = get_year_begin_to_this_quarter_end_cycle($year-1,$month); //获取年初累计到当季度末周期
        $last_quarter_cycle             = getQuarterlyCicle($year-1,$month); //去年当季度周期
        //$grand_total_cycle              = get_year_begin_to_this_quarter_end_cycle($year,$month); //获取年初累计到当季度末周期

        $year_settlement_lists          = get_settlement_list($year_cycle['beginTime'],$year_cycle['endTime']);
        $quarter_settlement_lists       = get_settlement_list($quarter_cycle['begin_time'],$quarter_cycle['end_time']);
        $last_year_settlement_lists     = get_settlement_list($last_year_cycle['beginTime'],$last_year_cycle['endTime']);
        $last_quarter_settlement_lists  = get_settlement_list($last_quarter_cycle['begin_time'],$last_quarter_cycle['end_time']);

        $year_maoli                     = array_sum(array_column($year_settlement_lists,'maoli'));
        $quarter_maoli                  = array_sum(array_column($quarter_settlement_lists,'maoli'));
        $last_year_maoli                = array_sum(array_column($last_year_settlement_lists,'maoli'));
        $last_quarter_maoli             = array_sum(array_column($last_quarter_settlement_lists,'maoli'));

        //当季度操作团信息
        $op_data                        = $this -> get_jd_encourage_data($userid,$year,$month);

        $data                           = array();
        $data['quarter_maoli']          = $quarter_maoli; //季度毛利
        $data['last_quarter_maoli']     = $last_quarter_maoli; //去年季度毛利
        $data['quarter_maoli_up']       = $data['quarter_maoli'] - $data['last_quarter_maoli']; //季度毛利增长
        $data['year_maoli']             = $year_maoli;   //累计毛利
        $data['last_year_maoli']        = $last_year_maoli; //去年累计毛利
        $data['year_maoli_up']          = $data['year_maoli'] - $data['last_year_maoli']; //累计毛利增长
        $data['year_should_royalty_up'] = round($data['year_maoli_up'] * 0.005 , 2); //累计毛利增长奖金 = 累计增长业绩* 0.5%
        $data['year_royalty_payoff_up'] = $this -> get_payoff_quarterRoyalty($userid,$year,'AA_num'); //累计已发毛利增长奖金
        $data['quarter_should_royalty_up'] = $data['year_should_royalty_up'] - $data['year_royalty_payoff_up']; //当季度应发毛利增长奖金 = 累计毛利增长奖金 - 累计已发毛利增长奖金
        $data['quarter_maoli_op']       = $op_data['complete']; //当季度操作毛利
        $data['quarter_should_royalty_op'] = $op_data['quarter_should_royalty']; //当季度应发操作奖金
        $data['year_maoli_op']          = $op_data['sum_complete']; //累计操作毛利
        $data['year_should_royalty_op'] = $op_data['sum_should_royalty']; //累计应发操作奖金
        $data['year_royalty_payoff']    = $this -> get_payoff_quarterRoyalty($userid,$year,'BB_num');
        $data['quarter_should_royalty'] = $data['quarter_should_royalty_up'] + $data['quarter_should_royalty_op']; //当季应发奖金合计 = 当季应发毛利增长奖金 + 当季应发操作奖金

        $info                           = array();
        $info['account_id']             = $userid;
        $info['AA_tit']                 = "季度毛利增长奖金";
        $info['AA_num']                 = $quarter == 1 ? round($data['quarter_maoli_up'] * 0.005 , 2) : $data['quarter_should_royalty_up'];
        $info['BB_tit']                 = "季度应发操作奖金";
        $info['BB_num']                 = $quarter == 1 ? $data['quarter_should_royalty_op'] : $data['year_should_royalty_op'];
        $info['sum']                    = $info['AA_num'] + $info['BB_num'];
        $data['info']                   = $info;
        return $data;
    }

    /**
     * 获取累计已发毛利增长奖金
     * @param $uid
     * @param $year
     * @param $month
     */
    private function get_payoff_quarterRoyalty($uid, $year, $field){
        $db                             = M('salary_quartyRoyalty');
        $where                          = array();
        $where['account_id']            = $uid;
        $where['year']                  = $year;
        if (date('Y') == $year){
            $salary_months              = $this->get_salary_months($year);
            $salary_num                 = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['quarterRoyalty_months']),'account_id'=>$uid,'status'=>4))->field('id')->count();
            if ($salary_num){
                $quarters               = array();
                for ($i = 1; $i <= $salary_num; $i++){
                    $quarters[]         = $i;
                }
                $where['quarter']       = array('in' , $quarters);
                $data                   = $db->where($where)->sum($field);
            }
        }else{
            $data                       = $db->where($where)->sum($field);
        }
        $data                           = $data ? $data : 0;
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

        $info                   = array();
        $info['account_id']     = $userid;
        $info['sum']            = $data['quarter_should_royalty'];
        $data['info']           = $info;
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

        $partner_money          = get_partner_money($userinfo,$quarter_cycle['begin_time'],$quarter_cycle['end_time']); //当季度城市合伙人押金
        $sum_partner_money      = get_partner_money($userinfo,$yearBeginTime,$quarter_cycle['end_time']); //累计城市合伙人押金
        /*$sum_maoli              = $sum_maoli + $sum_partner_money; //累计毛利 + 累计城市合伙人
        $maoli                  = $maoli + $partner_money; //当季度毛利 + 当季度城市合伙人*/

        //业绩提成
        $royaltyData            = $this -> get_royalty_data($target , $sum_maoli , $sum_partner_money);

        //累计已发放提成	当季度发放提成
        $salary_months          = $this->get_salary_months($year);
        $sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('total');

        $data                   = array();
        $data['target']         = $target - $lastTarget; //当季度任务指标 = 累计任务指标 - 上季度任务指标
        $data['complete']       = $maoli; //当季度业绩
        $data['sum_target']     = $target; //累计目标值
        $data['sum_complete']   = $sum_maoli; //累计业绩
        $data['quarter_partner_money'] = $partner_money; //当季度城市合伙人押金
        $data['sum_partner_money'] = $sum_partner_money; //累计城市合伙人押金
        $data['royalty5']       = $royaltyData['royalty5']; //5%部分业绩提成
        $data['royalty20']      = $royaltyData['royalty20']; //20%部分业绩提成
        $data['royalty25']      = $royaltyData['royalty25']; //25%部分业绩提成
        $data['royalty40']      = $royaltyData['royalty40']; //40%部分业绩提成
        $data['royaltySum']     = $royaltyData['royaltySum']; //全部业绩提成
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发提成
        $data['quarter_should_royalty'] = $data['royaltySum'] - $data['sum_royalty_payoff']; //当季度应发提成 = 全部业绩提成 - 累计已发提成;

        $info                   = array();
        $info['account_id']     = $userid;
        $info['sum']            = $data['quarter_should_royalty'];
        $data['info']           = $info;
        return $data;
    }

    /**
     * 获取业务人员提成信息
     * 城市合伙人只提5%(可抵结算项目基数) 结算项目提成(100%内提取5%; 100%-150%=>20%; 150%-200%=>25%; 大于200%=>40%)
     * @param $target 目标值
     * @param $sum_maoli 累计项目毛利
     * @param $sum_partner_money 累计城市合伙人押金
     */
    private function get_royalty_data($target=0,$sum_maoli=0,$sum_partner_money=0){
        $royalty5               = 0; //5%提成部分
        $royalty20              = 0; //20%提成部分
        $royalty25              = 0; //25%提成部分
        $royalty40              = 0; //40%提成部分

        if (!$sum_partner_money){ //没有城市合伙人押金
            switch ($target){
                case $sum_maoli <= $target:
                    $royalty5           += $sum_maoli*0.05;
                    $royalty20          += 0;
                    $royalty25          += 0;
                    $royalty40          += 0;
                    break;
                case $sum_maoli > $target && $sum_maoli <= $target*1.5:
                    $royalty5           += $target*0.05;
                    $royalty20          += ($sum_maoli - $target)*0.2;
                    $royalty25          += 0;
                    $royalty40          += 0;
                    break;
                case $sum_maoli > $target*1.5 && $sum_maoli <= $target*2:
                    $royalty5           += $target*0.05;
                    $royalty20          += ($target*1.5 - $target)*0.2;
                    $royalty25          += ($sum_maoli - $target*1.5)*0.25;
                    $royalty40          += 0;
                    break;
                case $sum_maoli > $target*2:
                    $royalty5           += $target*0.05;
                    $royalty20          += ($target*1.5 - $target)*0.2;
                    $royalty25          += ($target*2.0 - $target*1.5)*0.25;
                    $royalty40          += ($sum_maoli - $target*2)*0.4;
                    break;
            }
        }else{
            $royalty5                   += $sum_partner_money*0.05;
            $money                      = $sum_partner_money + $sum_maoli; //城市合伙人押金 +　结算毛利
            switch ($target){ //城市合伙人押金小于目标值
                case $money <= $target:
                    $royalty5           += ($money - $sum_partner_money) * 0.05;
                    $royalty20          += 0;
                    $royalty25          += 0;
                    $royalty40          += 0;
                    break;
                case $money > $target && $money <= $target*1.5:
                    switch ($sum_partner_money){
                        case $sum_partner_money <= $target:
                            $royalty5           += ($target - $sum_partner_money) * 0.05;
                            $royalty20          += ($money - $target) * 0.2;
                            $royalty25          += 0;
                            $royalty40          += 0;
                            break;
                        case $sum_partner_money > $target:
                            $royalty5           += 0;
                            $royalty20          += ($money - $sum_partner_money) * 0.2;
                            $royalty25          += 0;
                            $royalty40          += 0;
                            break;
                    }
                    break;
                case $money > $target*1.5 && $money <= $target*2:
                    switch ($sum_partner_money){
                        case $sum_partner_money <= $target:
                            $royalty5           += ($target - $sum_partner_money) * 0.05;
                            $royalty20          += ($target*1.5 - $target) * 0.2;
                            $royalty25          += ($money - $target*1.5) * 0.25;
                            $royalty40          += 0;
                            break;
                        case $sum_partner_money > $target && $sum_partner_money <= $target*1.5:
                            $royalty5           += 0;
                            $royalty20          += ($target*1.5 - $sum_partner_money) * 0.2;
                            $royalty25          += ($money - $target*1.5) * 0.25;
                            $royalty40          += 0;
                            break;
                        case $sum_partner_money > $target*1.5:
                            $royalty5           += 0;
                            $royalty20          += 0;
                            $royalty25          += ($money - $sum_partner_money) * 0.25;
                            $royalty40          += 0;
                            break;
                    }
                    break;
                case $money > $target*2:
                    switch ($sum_partner_money){
                        case $sum_partner_money <= $target:
                            $royalty5           += ($target - $sum_partner_money) * 0.05;
                            $royalty20          += ($target*1.5 - $target) * 0.2;
                            $royalty25          += ($target*2.0 - $target*1.5) * 0.25;
                            $royalty40          += ($money - $target*2.0) * 0.4;
                            break;
                        case $sum_partner_money > $target && $sum_partner_money <= $target*1.5:
                            $royalty5           += 0;
                            $royalty20          += ($target*1.5 - $sum_partner_money) * 0.2;
                            $royalty25          += ($target*2.0 - $target*1.5) * 0.25;
                            $royalty40          += ($money - $target*2.0) * 0.4;
                            break;
                        case $sum_partner_money > $target*1.5 && $sum_partner_money <= $target*2.0:
                            $royalty5           += 0;
                            $royalty20          += 0;
                            $royalty25          += ($target*2.0 - $sum_partner_money) * 0.25;
                            $royalty40          += ($money - $target*2.0) * 0.4;
                            break;
                        case $sum_partner_money > $target*2.0:
                            $royalty5           += 0;
                            $royalty20          += 0;
                            $royalty25          += 0;
                            $royalty40          += ($money - $sum_partner_money) * 0.4;
                            break;
                    }
                    break;
            }
        }

        $data                       = array();
        $royaltySum                 = $royalty5 + $royalty20 + $royalty25 + $royalty40;
        $data['royalty5']           = $royalty5;
        $data['royalty20']          = $royalty20;
        $data['royalty25']          = $royalty25;
        $data['royalty40']          = $royalty40;
        $data['royaltySum']         = $royaltySum;
        return $data;
    }

    //发放业绩提成的月份
    private function get_salary_months($year){
        $year_arr               = array();
        $quarterRoyalty_arr     = array(); //累计发放季度提成月份

        //年度薪资月份信息
        for ($i=2; $i<=12; $i++){
            $mon                = strlen($i)<2 ? str_pad($i,2,'0',STR_PAD_LEFT) : $i;
            $year_arr[]         = $year.$mon;
            if (in_array($i,array(4,7,10))){
                $quarterRoyalty_arr[] = $year.$mon;
            }
        }
        $year_arr[]             = ($year+1).'01'; //一月份发上一年的提成
        $quarterRoyalty_arr[]   = ($year+1).'01';

        $data                       = array();
        $data['salary_year_months'] = $year_arr;
        $data['quarterRoyalty_months'] = $quarterRoyalty_arr;
        return $data;
    }

}
