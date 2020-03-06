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
        }elseif (in_array($userinfo['postid'],array(29))) { // 29=>研发部产品经理
            $num = 5;
        }elseif (in_array($userinfo['postid'],array(66))) { // 66=>市场部经理
            $num = 6;
        }elseif (in_array($userinfo['postid'],array(79))) { // 79=>京区业务中心研发主管
            $num = 7;
        }elseif (in_array($userinfo['postid'],array(36))) { // 36=>研发部经理,秦鸣
            $num = 8;
        }elseif (in_array($userinfo['postid'],array(70))) { // 70=>资源管理部经理，李徵红
            $num = 9;
        }elseif (in_array($userinfo['postid'],array(85,1,88))) { // 85=>人资综合部部经理，王茜,1=>安全品控部经理,李岩,88=>财务部经理,程小平
            $num = 10;
        }elseif (in_array($userinfo['postid'],array(72))) { // 72=>资源管理部资源专员
            $num = 11;

        }elseif (in_array($userinfo['postid'],array(73))) { // 73=>老科学家演讲团教务专员
            $num = 12;

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
        }elseif ($encourage_type == 5) { // 研发部产品经理
            $data = $this->get_yfcpjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==6) { // 市场部经理
            $data = $this->get_scbjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==7) { //京区业务中心研发主管
            $data = $this->get_jqyfzg_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==8) { // 研发部经理
            $data = $this->get_yfbjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==9){ // 资源管理部经理
            $data = $this->get_zybjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==10){ // 人资综合部经理,安全品控部经理,财务部经理
            $data = $this->get_rzzhbjl_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==11){ // 资源管理部资源专员
            $data = $this->get_zybzy_encourage_data($userid, $year, $month);
        }elseif ($encourage_type ==12){ // 老科学家演讲团教务专员
            $data = $this->get_zybyjt_encourage_data($userid, $year, $month);
        }
        return $data;
    }

    //资源管理部   老科学家演讲团教务专员
    public function get_zybyjt_encourage_data($userid, $year, $month){
        $quarter                    = get_quarter($month);
        $quarter_cycle              = get_quarter_cycle_time($year,$quarter);
        $year_cycle                 = get_year_cycle($year);
        $gec_lists                  = $this->get_my_customer_gec($userid);
        $gec_data                   = array_column($gec_lists,'company_name');
        $otherWhere                 = array();
        $otherWhere['o.customer']   = array('in',$gec_data);
        $quarter_settlement_lists   = get_settlement_list($quarter_cycle['begin_time'],$quarter_cycle['end_time'],'','','','','',$otherWhere);
        $year_settlement_lists      = get_settlement_list($year_cycle['beginTime'],$quarter_cycle['end_time'],'','','','','',$otherWhere);

        //累计已发奖金
        $sum_royalty_salary         = $this->get_sum_royalty_salary($year,$userid);

        $data                       = array();
        $data['complete']           = $quarter_settlement_lists ? array_sum(array_column($quarter_settlement_lists,'maoli')) : 0; //转交客户当季度毛利
        $data['sum_complete']       = $year_settlement_lists ? array_sum(array_column($year_settlement_lists,'maoli')) : 0; //累计业绩
        $data['quarter_should_royalty'] = $data['complete'] * 0.02; //当季转交客户应发奖金 = 当季度毛利 * 2%
        $data['sum_should_royalty']     = $data['sum_complete'] * 0.02; //累计应发转交客户奖金
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发操作奖金

        $info                       = array();
        $info['account_id']         = $userid;
        $info['sum']                = $data['quarter_should_royalty'];
        $data['info']               = $info;
        return $data;
    }

    //获取某个人2年内招募的客户信息
    private function get_my_customer_gec($userid){
        $db                     = M('customer_gec');
        $time                   = strtotime('-2 year') - (90*24*2600);
        $where                  = array();
        $where['create_user_id']= $userid;
        $where['create_time']   = array('gt',$time);
        $lists                  = $db->where($where)->select();
        return $lists;
    }

    //资源管理部资源专员
    public function get_zybzy_encourage_data($userid, $year, $month){
        //任务系数
        $quarter                = get_quarter($month);
        $lastQuarterMonth       = $quarter == 1 ? getQuarterMonths($quarter,$year) : getQuarterMonths($quarter-1,$year); //上季度月份
        $quarterMonth           = getQuarterMonths($quarter,$year); //本季度月份
        $lastYearMonth          = substr($lastQuarterMonth,-6); //上季度最后一个月
        $endYearMonth           = substr($quarterMonth,-6); //本季度最后一个月
        $quota_id               = 238; //单进院所业务月度累计毛利额-资源专员
        $lastTarget             = $quarter == 1 ? 0 : M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>$quota_id,'month'=>$lastYearMonth))->getField('target'); //上季度累计任务系数
        $target                 = M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>$quota_id,'month'=>$endYearMonth))->getField('target'); //(本季度)累计任务系数

        //业绩
        $quarter_cycle          = getQuarterlyCicle($year,$month);
        $yearBeginTime          = get_year_settlement_start_time($year);
        $kindid                 = 87; //单进院所
        $maoli_list             = get_settlement_list($quarter_cycle['begin_time'],$quarter_cycle['end_time'],0,0,'',$kindid); //当季度业绩
        $sum_maoli_list         = get_settlement_list($yearBeginTime,$quarter_cycle['end_time'],0,0,'',$kindid); //累计业绩
        $maoli                  = array_sum(array_column($maoli_list,'maoli'));
        $sum_maoli              = array_sum(array_column($sum_maoli_list,'maoli'));

        //业绩提成
        $royaltyData            = $this -> get_zy_royalty_data($target , $sum_maoli);

        //业务岗累计已发放提成	当季度发放提成
        $salary_months          = $this->get_salary_months($year);
        $sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('total');

        $data                   = array();
        $data['target']         = $target - $lastTarget; //当季度任务指标 = 累计任务指标 - 上季度任务指标
        $data['complete']       = $maoli; //当季度业绩
        $data['sum_target']     = $target; //累计目标值
        $data['sum_complete']   = $sum_maoli; //累计业绩
        $data['royalty5']       = $royaltyData['royalty5']; //5%部分业绩提成
        $data['royalty10']      = $royaltyData['royalty10']; //10%部分业绩提成
        $data['royaltySum']     = $royaltyData['royaltySum']; //全部业绩提成
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发提成
        $data['quarter_should_royalty'] = $data['royaltySum'] - $data['sum_royalty_payoff']; //当季度应发提成 = 全部业绩提成 - 累计已发提成;

        $info                   = array();
        $info['account_id']     = $userid;
        $info['sum']            = $data['quarter_should_royalty'];
        $data['info']           = $info;
        return $data;

    }

    //资源专员提成
    private function get_zy_royalty_data($target , $sum_maoli){
        $royalty5               = 0; //5%提成部分
        $royalty10              = 0; //10%提成部分

        switch ($target){
            case $sum_maoli <= $target:
                $royalty5       += 0;
                $royalty10      += 0;
                break;
            case $sum_maoli > $target && $sum_maoli <= $target*2:
                $royalty5       += ($sum_maoli - $target)*0.05;
                $royalty10      += 0;
                break;
            case $sum_maoli > $target*2:
            $royalty5           += ($target*2 - $target)*0.05;
            $royalty10          += ($sum_maoli - $target*2)*0.1;
                break;
        }

        $data                       = array();
        $royaltySum                 = $royalty5 + $royalty10;
        $data['royalty5']           = $royalty5;
        $data['royalty10']          = $royalty10;
        $data['royaltySum']         = $royaltySum;
        return $data;
    }

    //人资综合部经理激励机制数据
    public function get_rzzhbjl_encourage_data($userid, $year, $month){
        $quarter                        = get_quarter($month);
        $thisYearTimeCycle              = get_year_begin_to_quarter_end_cycle($year,$quarter); //当年累计至当季度周期
        //$lastYearTimeCycle              = get_year_begin_to_quarter_end_cycle($year-1, $quarter); //上一年累计至当季度周期

        //毛利数据
        $maoliData                      = get_settlement_maoli_up_rate($year,$quarter);

        //机关部门累计人力成本
        $jiguan_users                   = get_jiguan_no_manager_users(); //机关部门人员信息(不包含总经办人员);
        $uids                           = array_column($jiguan_users,'id');
        $lastYearSalaryMonths           = get_sum_months($year-1,$month,2); //从年初累计月份
        $thisYearSalaryMonths           = get_sum_months($year,$month,2); //从年初累计月份
        $rbacMod                        = D('Rbac');
        $lastYearSalaryData             = $rbacMod->get_staff_data($lastYearSalaryMonths,'','',$uids);
        $thisYearSalaryData             = $rbacMod->get_staff_data($thisYearSalaryMonths,'','',$uids);
        $lastYearSalaryLists            = $lastYearSalaryData['list'];
        $thisYearSalaryLists            = $thisYearSalaryData['list'];

        $lastYearSalary_data            = $rbacMod->get_post_salary($lastYearSalaryLists);
        $thisYearSalary_data            = $rbacMod->get_post_salary($thisYearSalaryLists);
        //上一年
        //$lastYearPost_salary_sum        = $lastYearSalary_data['salary']; //岗位薪酬
        //$lastYearBonus_sum              = $lastYearSalary_data['bonus']; //奖金
        //$lastYearSubsidy_sum            = $lastYearSalary_data['subsidy']; //补助
        $lastYearInsurance_sum          = $lastYearSalary_data['insurance']; //公司五险一金
        //$lastYearSum                    = $lastYearSalary_data['sum']; //合计
        //当年
        //$thisYearPost_salary_sum        = $thisYearSalary_data['salary']; //岗位薪酬
        //$thisYearBonus_sum              = $thisYearSalary_data['bonus']; //奖金
        //$thisYearSubsidy_sum            = $thisYearSalary_data['subsidy']; //补助
        $thisYearInsurance_sum          = $thisYearSalary_data['insurance']; //公司五险一金
        //$thisYearSum                    = $thisYearSalary_data['sum']; //合计

        //机关奖金包
        $departmentid                   = M('account')->where(array('id'=>$userid))->getField('departmentid');
        $jiguan_bonus                   = $this->get_departmentBonus($thisYearTimeCycle['begin_time'],$thisYearTimeCycle['end_time'],$departmentid);
        $satisfaction_weight            = $this->get_jiguan_satisfaction_weight($userid,$year,$month,$quarter); //本部门经理内部满意度权重 = 本部门经理KPI中的内部满意度 / 所有机关部门经理KPI中的内部满意度之和 * 100%

        //本部门核定权重人数
        $departmentUsers                = get_department_posts_account($departmentid,1,1); //本部门人员
        $jiguan_uids                    = array_column($jiguan_users,'id');
        $jiguan_member_weight_users     = $this->get_uids_posts_account($jiguan_uids);
        $department_member_weight       = $this->get_member_weight($departmentUsers);
        $jiguan_member_weight           = $this->get_member_weight($jiguan_member_weight_users);
        $my_info                        = M()->table('__ACCOUNT__ as a')->join('__POSTS__ as p on p.id=a.postid','left')->where(array('a.id'=>$userid))->field('a.id,a.nickname,a.postid,p.post_name')->find();
        $my_member_weight               = $this->get_member_weight_det($my_info);

        //本部门季度累计已发奖励
        $department_sum_royalty_payoff  = $this->get_department_sum_royalty_salary($year,$departmentUsers); //获取本部门"部门季度累计已发奖励"

        $data                           = array();
        $data['lastYearProfit']         = $maoliData['last_year_data']['sum_maoli'];
        $data['thisYearProfit']         = $maoliData['this_year_data']['sum_maoli'];
        $data['profit_up_rate']         = $maoliData['up_rate'];
        $data['lastYearHrCost']         = $lastYearSalary_data['sum'];
        $data['thisYearHrCost']         = $thisYearSalary_data['sum'];
        $data['shouldHrCost']           = round($lastYearSalary_data['sum'] * (1 + ($maoliData['up_rate_float']/2)),2);  //当年度机关累计人力成本额度 = 上年机关累计发生人力成本 * (1 + 累计毛利增长比率/2)
        $data['Insurance_up_data']      = $thisYearInsurance_sum['sum'] - $lastYearInsurance_sum['sum']; //公司五险一金增量
        $data['jiguan_bonus']           = $jiguan_bonus; //机关奖金包
        $data['jiguan_sum_salary_bag']  = $data['shouldHrCost'] + $data['Insurance_up_data'] + $data['jiguan_bonus']; //当年机关季度累计薪酬包 = 当年度机关累计人力成本额度 + 机关五险一金增量 + 机关奖金包
        $data['totalSalaryBagLeftOver'] = $data['jiguan_sum_salary_bag'] - $data['thisYearHrCost']; //当年机关季度累计薪酬包结余 = 当年机关季度累计薪酬包 - 机关累计发生人力成本(当年)
        $data['satisfaction_weight']    = $satisfaction_weight['weigh_str']; //本部门经理内部满意度权重
        $data['member_weight']          = $department_member_weight; //本部门核定权重人数12
        $data['departmentSumEncourage'] = round(($data['totalSalaryBagLeftOver'] * $satisfaction_weight['weigh_floot'] * $data['member_weight'])/$jiguan_member_weight,2); //本部门季度累计奖励13 = (当年机关季度累计薪酬包结余 * 本部门经理内部满意度权重 * 本部门核定权重人数)/机关各部门所有权重人数
        $data['department_sum_royalty_payoff'] = $department_sum_royalty_payoff; //本部门季度累计已发奖励
        $data['department_should_royalty'] = $data['departmentSumEncourage'] - $data['department_sum_royalty_payoff'];
        $data['quarter_should_royalty'] = round(($data['department_should_royalty']/$data['member_weight']) * $my_member_weight,2);
        return $data;
    }

    //获取本部门"部门季度累计已发奖励"
    private function get_department_sum_royalty_salary($year,$users){
        $un_use_username                = C('UN_USE_MEMBER_WEIGHT_USER'); //不计入的人
        $sum_royalty_salary             = 0;
        foreach ($users as $v){
            if (!in_array($v['nickname'],$un_use_username)){
                //累计已发提成数据
                $royalty_salary         = $this->get_sum_royalty_salary($year,$v['id']);
                $sum_royalty_salary     += $royalty_salary;
            }
        }
        return $sum_royalty_salary;
    }

    //获取人员岗位信息
    private function get_uids_posts_account($uids){
        $where                                  = array();
        $where['a.id']                          = array('in',$uids);
        $where['a.status']                      = array('neq',2);
        $where['a.nickname']                    = array('notlike','%1%');
        $field                                  = 'a.id,a.nickname,a.postid,p.post_name';
        $lists                                  = M()->table('__ACCOUNT__ as a')->join('__POSTS__ as p on p.id=a.postid','left')->where($where)->field($field)->select();
        return $lists;
    }

    //获取本部门核定权重人数
    private function get_member_weight($users){
        $un_use_username                = C('UN_USE_MEMBER_WEIGHT_USER'); //不计入的人
        $weight                         = 0;
        foreach ($users as $k=>$v){
            if (!in_array($v['nickname'],$un_use_username)){
                $weight                 += $this->get_member_weight_det($v);
            }
        }
        return $weight;
    }

    //获取本部门核定权重人数  部门经理为3，副经理为2，主管为1.5，其他为1
    private function get_member_weight_det($info){
        //strstr() , strpos()
        if (strpos($info['post_name'],'经理') && !strpos($info['post_name'],'副经理' ) && !strpos($info['post_name'],'产品经理' )){
            $num = 3;
        } elseif (strpos($info['post_name'],'副经理')){
            $num = 2;
        } elseif (strpos($info['post_name'],'主管')){
            $num = '1.5';
        } else {
            $num = 1;
        }
        return $num;
    }

    /**
     * 获取本部门经理内部满意度权重(机关部门经理)
     * 本部门经理内部满意度权重 = 本部门经理KPI中的内部满意度 / 所有机关部门经理KPI中的内部满意度之和 * 100%
     * @param $userid
     * @param $year
     * @param $month
     * @return array
     */
    private function get_jiguan_satisfaction_weight($userid,$year,$month,$quarter){
        $manager_uids               = array(12,13,26,39,55,77,204); //机关部门经理 12=>秦鸣,13=>杜莹,26=>李岩,39=>孟华,55=>程小平,77=>王茜,204=>李徵红
        $yearMonths                 = get_quarter_yearMonths($year,$quarter);
        $inspectMod                 = D('inspect');
        $userscore                  = 0;
        $sumscore                   = 0;
        $sumLists                   = array();
        foreach ($yearMonths as $yearMonth){
            $lists                  = $inspectMod -> get_satisfaction_list($yearMonth,1);
            foreach ($lists as $v){
                if (in_array($v['account_id'],$manager_uids)){
                    if ($v['sum_average'] != '50%'){
                        $float_avg  = (str_replace('%','',$v['sum_average']))/100;
                        $sumscore   += $float_avg;
                        $sumLists[] = $v;
                        if ($v['account_id'] == $userid){
                            $userscore += $float_avg;
                        }
                    }
                }
            }
        }

        $weight                     = round($userscore/$sumscore,4);
        $data                       = array();
        $data['weigh_str']          = ($weight*100).'%';
        $data['weigh_floot']        = $weight;
        return $data;
    }

    //资源管理部经理激励机制数据
    public function get_zybjl_encourage_data($userid, $year, $month){
        $quarter                    = get_quarter($month);
        $thisYearTimeCycle          = get_year_begin_to_quarter_end_cycle($year,$quarter); //当年累计至当季度周期
        $lastYearTimeCycle          = get_year_begin_to_quarter_end_cycle($year-1, $quarter); //上一年累计至当季度周期

        //求本周所有结算的团
        $thisYearOpLists            = get_settlement_list($thisYearTimeCycle['begin_time'],$thisYearTimeCycle['end_time']);
        $lastYearOpLists            = get_settlement_list($lastYearTimeCycle['begin_time'],$lastYearTimeCycle['end_time']);
        $thisYearOpids              = array_column($thisYearOpLists,'op_id');
        $lastYearOpids              = array_column($lastYearOpLists,'op_id');

        //求本周期结算的团结算列表中包含"研究所台站"的项目
        $thisYearResSettLists       = $this->get_res_settlement_lists($thisYearOpids);
        $lastYearResSettLists       = $this->get_res_settlement_lists($lastYearOpids);
        $thisYearResSettOpids       = array_column($thisYearResSettLists,'op_id');
        $lastYearResSettOpids       = array_column($lastYearResSettLists,'op_id');

        $thisYearProfit             = $this->get_ok_sett_sum_maoli($thisYearOpLists,$thisYearResSettOpids);
        $lastYearProfit             = $this->get_ok_sett_sum_maoli($lastYearOpLists,$lastYearResSettOpids);

        //累计已发提成数据
        $sum_royalty_salary         = $this->get_sum_royalty_salary($year,$userid);

        $data                       = array();
        $data['lastYearProfit']     = $lastYearProfit;
        $data['thisYearProfit']     = $thisYearProfit;
        $data['profitUpData']       = $data['thisYearProfit'] - $data['lastYearProfit'];
        $data['sum_should_royalty'] = round($data['profitUpData'] * 0.01,2); //累计应发奖励
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发操作奖金
        $data['quarter_should_royalty'] = $data['sum_should_royalty'] - $data['sum_royalty_payoff'];

        $info                       = array();
        $info['account_id']         = $userid;
        $info['sum']                = $data['quarter_should_royalty'];
        $data['info']               = $info;
        return $data;
    }

    private function get_ok_sett_sum_maoli($sett_lists,$opids){
        $sum_maoli                  = 0;
        foreach ($sett_lists as $k=>$v){
            if (in_array($v['op_id'],$opids)){
                $sum_maoli          += $v['maoli'];
            }
        }
        return $sum_maoli;
    }

    //获取结算列表中包含"研究所台站"的项目
    private function get_res_settlement_lists($opids){
        $where                      = array();
        $where['status']            = 2; //结算
        $where['type']              = 6; //研究所台站
        $where['op_id']             = array('in',$opids);
        $lists                      = M('op_costacc')->where($where)->group('op_id')->select();
        return $lists;
    }

    //研发部经理激励机制数据
    public function get_yfbjl_encourage_data($userid, $year, $month){
        //研发部产品经理
        $postid                     = 29; //研发部产品经理
        $cpjls                      = M('account')->where(array('postid'=>$postid))->getField('id,nickname',true);

        $lastYearProfit             = 0; //去年累计毛利
        $thisYearProfit             = 0; //今年累计毛利
        foreach ($cpjls as $k => $v){
            $yfcpjl                 = $this->get_yfcpjl_encourage_data($k, $year, $month);
            $lastYearProfit         += $yfcpjl['lastYearProfit'];
            $thisYearProfit         += $yfcpjl['thisYearProfit'];
        }

        //累计已发提成数据
        $sum_royalty_salary         = $this->get_sum_royalty_salary($year,$userid);

        $data                       = array();
        $data['lastYearProfit']     = $lastYearProfit;
        $data['thisYearProfit']     = $thisYearProfit;
        $data['profitUpData']       = $data['thisYearProfit'] - $data['lastYearProfit'];
        $data['sum_should_royalty'] = round($data['profitUpData'] * 0.01,2); //累计应发奖励
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发操作奖金
        $data['quarter_should_royalty'] = $data['sum_should_royalty'] - $data['sum_royalty_payoff'];

        $info                       = array();
        $info['account_id']         = $userid;
        $info['sum']                = $data['quarter_should_royalty'];
        $data['info']               = $info;
        return $data;
    }

    //京区研发主管激励机制数据
    public function get_jqyfzg_encourage_data($userid, $year, $month){
        $department_encourage_data  = $this->get_ywbmjl_encourage_data($userid, $year, $month);
        $data                       = array();
        $data['department_royalty'] = $department_encourage_data['departmentBonus'];
        $data['quarter_should_royalty'] = round($department_encourage_data['departmentBonus']*0.1,2);
        $info                       = array();
        $info['account_id']         = $userid;
        $info['sum']                = $data['quarter_should_royalty'];
        $data['info']               = $info;
        return $data;
    }

    //市场部经理激励机制数据
    public function get_scbjl_encourage_data($userid, $year, $month){
        $quarter                    = get_quarter($month);
        $thisYearTimeCycle          = get_year_begin_to_quarter_end_cycle($year,$quarter); //当年累计至当季度周期
        $lastYearTimeCycle          = get_year_begin_to_quarter_end_cycle($year-1, $quarter); //上一年累计至当季度周期

        //科学快车
        $kindid                     = 69; //69 科学快车
        $kxkcdata                   = get_settlement_maoli_up_rate($year,$quarter,$kindid);

        //季度合伙人累计毛利
        $thisYearPartnerData        = $this->get_partner_profit($thisYearTimeCycle['begin_time'],$thisYearTimeCycle['end_time']);
        $lastYearPartnerData        = $this->get_partner_profit($lastYearTimeCycle['begin_time'],$lastYearTimeCycle['end_time']);

        //累计已发提成数据
        $sum_royalty_salary         = $this->get_sum_royalty_salary($year,$userid);

        $data                       = array();
        $data['thisYearKxkcSum']    = $kxkcdata['this_year_data']['sum_maoli'];
        $data['lastYearKxkcSum']    = $kxkcdata['last_year_data']['sum_maoli'];
        $data['kxkcUpData']         = $data['thisYearKxkcSum'] - $data['lastYearKxkcSum'];
        $data['kxkc_bonus']         = $data['kxkcUpData'] * 0.1;
        $data['thisYearPartnerSum'] = $thisYearPartnerData['sum_maoli'];
        $data['lastYearPartnerSum'] = $lastYearPartnerData['sum_maoli'];
        $data['partnerUpData']      = $data['thisYearPartnerSum'] - $data['lastYearPartnerSum'];
        $data['partner_bonus']      = round($data['partnerUpData'] * 0.01, 2);
        $data['sum_should_royalty'] = $data['kxkc_bonus'] + $data['partner_bonus']; //累计应发奖金
        $data['sum_royalty_payoff'] = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发奖金
        $data['quarter_should_royalty'] = $data['sum_should_royalty'] - $data['sum_royalty_payoff'];

        $info                       = array();
        $info['account_id']         = $userid;
        $info['sum']                = $data['quarter_should_royalty'];
        $data['info']               = $info;
        return $data;
    }

    //市场部经理城市合伙人累计毛利
    private function get_partner_profit($startTime,$endTime){
        $partners                   = M('customer_partner')->where(array('audit_stu'=>2,'del_stu'=>0))->getField('name',true); //所有审核通过的城市合伙人信息

        //求本周期结算的城市合伙人项目毛利
        $where                      = array();
        $where['b.audit_status']    = 1;
        $where['l.req_type']        = 801;
        $where['l.audit_time']      = array('between', "$startTime,$endTime");
        $where['o.customer']          = array('in',$partners);
        $field                      = 'o.op_id,o.project,o.group_id,o.create_user,o.create_user_name,o.destination,o.kind,o.standard,b.budget,b.shouru,b.maoli,b.untraffic_shouru,l.req_uid,l.req_uname,l.req_time,l.audit_time'; //获取所有该季度结算的团
        $op_settlement_list         = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        $data                       = array();
        $data['sum_maoli']          = $op_settlement_list ? array_sum(array_column($op_settlement_list,'maoli')) : 0;
        $data['op_lists']           = $op_settlement_list ? $op_settlement_list : array();
        return $data;
    }

    //研发部产品经理激励机制数据
    public function get_yfcpjl_encourage_data($userid, $year, $month){
        //任务系数
        $quarter                = get_quarter($month);
        $lastQuarterMonths      = $quarter == 1 ? getQuarterMonths($quarter,$year) : getQuarterMonths($quarter-1,$year); //上季度月份

        $quarterMonths          = getQuarterMonths($quarter,$year); //本季度月份
        $lastQuarterMonth       = substr($lastQuarterMonths,-6); //上季度最后一个月
        $endQuarterMonth        = substr($quarterMonths,-6); //本季度最后一个月
        $lastTarget             = $quarter == 1 ? 0 : M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>242,'month'=>array(like,'%'.$lastQuarterMonth)))->getField('target'); //上季度累计任务系数
        $target                 = M('kpi_more')->where(array('user_id'=>$userid,'quota_id'=>242,'month'=>array(like,'%'.$endQuarterMonth)))->getField('target'); //(本季度)累计任务系数  242=>季度累计毛利额-产品经理

        //毛利
        $lastYearQuarterCycle   = get_quarter_cycle_time($year-1,$quarter); //上年当季度周期
        $thisYearQuarterCycle   = get_quarter_cycle_time($year,$quarter); //本年当季度周期
        $thisYearCycle          = get_year_cycle($year); //年度累计周期

        if ($userid == 234){ // 马娜   具体指非标准化产品线路发布人和标准化产品研发设计人为马娜的项目毛利
            $lastYearQuarterProfit  = get_cpjl_gross_profit_op($userid,$lastYearQuarterCycle['begin_time'],$lastYearQuarterCycle['end_time']); //上年当季度结算毛利
            $thisYearQuarterProfit  = get_cpjl_gross_profit_op($userid,$thisYearQuarterCycle['begin_time'],$thisYearQuarterCycle['end_time']); //当年当季度结算毛利
            $thisYearSumProfit      = get_cpjl_gross_profit_op($userid,$thisYearCycle['beginTime'],$thisYearQuarterCycle['end_time']); //当年累计至当季度结算毛利
        }else{
            $lastYearQuarterProfit  = get_gross_profit_op($userid,$lastYearQuarterCycle['begin_time'],$lastYearQuarterCycle['end_time']); //上年当季度结算毛利
            $thisYearQuarterProfit  = get_gross_profit_op($userid,$thisYearQuarterCycle['begin_time'],$thisYearQuarterCycle['end_time']); //当年当季度结算毛利
            $thisYearSumProfit      = get_gross_profit_op($userid,$thisYearCycle['beginTime'],$thisYearQuarterCycle['end_time']); //当年累计至当季度结算毛利
        }

        //业绩提成
        $royaltyData            = $this->get_cpjl_royalty_data($target,$thisYearSumProfit['sum_profit']);

        //累计已发提成数据
        //$salary_months          = $this->get_salary_months($year);
        //$sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('bonus');
        $sum_royalty_salary     = $this->get_sum_royalty_salary($year,$userid);

        $data                   = array();
        $data['target']         = $target - $lastTarget; //当季度任务指标 = 累计任务指标 - 上季度任务指标
        $data['sum_target']     = $target; //累计目标值
        $data['lastYearProfit'] = $lastYearQuarterProfit['sum_profit']; //上年当季度业绩
        $data['thisYearProfit'] = $thisYearQuarterProfit['sum_profit']; //当年当季度业绩
        $data['thisYearSumProfit'] = $thisYearSumProfit['sum_profit']; //当年累计至当季度业绩
        $data['royalty5']       = $royaltyData['royalty5']; //5%提成部分
        $data['royalty10']      = $royaltyData['royalty10']; //10%提成部分
        $data['sum_should_royalty']     = $royaltyData['royaltySum']; //累计应发提成
        $data['sum_royalty_payoff']     = $sum_royalty_salary ? $sum_royalty_salary : 0; //累计已发操作奖金
        $data['quarter_should_royalty'] = $data['sum_should_royalty'] - $data['sum_royalty_payoff'];

        $info                   = array();
        $info['account_id']     = $userid;
        $info['sum']            = $data['quarter_should_royalty'];
        $data['info']           = $info;
        return $data;

    }

    //研发部产品经理提成数据
    private function get_cpjl_royalty_data($target=0,$sum_maoli=0){
        $royalty5               = 0; //5%提成部分
        $royalty10              = 0; //10%提成部分
        switch ($sum_maoli){
            case $sum_maoli <= $target:
                $royalty5           += 0;
                $royalty10          += 0;
                break;
            case $sum_maoli > $target && $sum_maoli <= $target*2:
                $royalty5           += ($sum_maoli - $target)*0.05;
                $royalty10          += 0;
                break;
            case $sum_maoli > $target*2:
                $royalty5           += ($target*2 - $target)*0.05;
                $royalty10          += ($sum_maoli - $target*2)*0.1;
                break;
        }

        $data                       = array();
        $royaltySum                 = $royalty5 + $royalty10;
        $data['royalty5']           = $royalty5;
        $data['royalty10']          = $royalty10;
        $data['royaltySum']         = $royaltySum;
        return $data;
    }

    //业务部门经理激励机制数据
    public function get_ywbmjl_encourage_data($userid, $year, $month){
        $quarter                        = get_quarter($month);
        $quarter_cycle                  = get_quarter_cycle_time($year,$quarter);
        $year_cycle                     = get_year_cycle($year);
        $departmentData                 = M()->table('__ACCOUNT__ as a')->join('__SALARY_DEPARTMENT__ as d on d.id=a.departmentid','left')->where(array('a.id'=>$userid))->field('d.id,d.department')->find();
        //毛利数据
        $maolidata                      = get_budget_up_rate($userid,$year,$quarter);
        $lastYearData                   = $maolidata['last_year_data'];
        $thisYearData                   = $maolidata['this_year_data'];

        //累计人力成本 + 公司五险一金增量
        $rbacMod                        = D('Rbac');
        $lastYearMonths                 = get_to_now_months($year-1,$month);
        $thisYearMonths                 = get_to_now_months($year,$month);
        $lastSumHrCostData              = $rbacMod -> get_sum_hr_cost($lastYearMonths); //今年累计人力成本
        $thisSumHrCostData              = $rbacMod -> get_sum_hr_cost($thisYearMonths); //今年累计人力成本
        $lastHrCost                     = $lastSumHrCostData['sum'][$departmentData['department']]; // 上一年累计人力成本
        $thisHrCost                     = $thisSumHrCostData['sum'][$departmentData['department']]; // 当年累计人力成本
        $lastFiveRisksOneFund           = $lastSumHrCostData['insurance'][$departmentData['department']]['sum']; //上一年累计五险一金
        $thisFiveRisksOneFund           = $thisSumHrCostData['insurance'][$departmentData['department']]['sum']; //当年累计五险一金

        //当年度累计人力成本额度 = (上年度累计人力成本 * (1 + 增长比率/2))
        //季度毛利额累计增长比率 > 季度毛利额累计增长比率目标值 ? 目标值 : 季度毛利额累计增长比率
        $quota_id                       = 248; //季度毛利额累计增长比率
        $profit_up_rate_target          = get_profit_up_rate_target($userid,$year,$month,$quota_id); //kpi季度毛利额累计增长比率目标值
        $maoli_up_rate_float            = $maolidata['up_rate_float'] > $profit_up_rate_target['target_float'] ? $profit_up_rate_target['target_float'] : $maolidata['up_rate_float'];
        $totalHrCost                    = round($lastHrCost * (1 + ($maoli_up_rate_float/2)), 2);

        //部门业绩提成(本部门非业务岗人员的毛利业绩*5%)
        $unBusinessUsers                = get_unBusinessUsers($departmentData['id']);
        $userids                        = array_column($unBusinessUsers,id);
        $unBusinessUsersOpLists         = get_settlement_list($year_cycle['beginTime'],$quarter_cycle['end_time'],0,0,'','',$userids);
        $unBusinessUsersSumMaoli        = array_sum(array_column($unBusinessUsersOpLists,'maoli'));
        $departmentRoyalty              = $unBusinessUsersSumMaoli ? round($unBusinessUsersSumMaoli * 0.05, 2) : 0;

        //部门奖金包(本部门人员立项)
        /*$departmentAllUsers             = get_department_account($departmentData['id']);
        $departmentAllUserIds           = array_column($departmentAllUsers,'id');
        $departmentSettlementLists      = get_settlement_list($year_cycle['beginTime'],$quarter_cycle['end_time'],0,0,'','',$departmentAllUserIds);
        $opids                          = array_unique(array_column($departmentSettlementLists,'op_id'));
        $allRoyaltyKeyWords             = array('计调提成','资源提成','研发提成','奖金包','计调奖金包','资源奖金包','研发奖金包','总奖金包');
        $allCostaccBonus                = M('op_costacc')->where(array('status'=>2,'op_id'=>array('in',$opids),'title'=>array('in',$allRoyaltyKeyWords)))->sum('total');
        $jdRoyaltyKeyWords              = array('计调提成','计调奖金包');
        $jdCostaccBonus                 = M('op_costacc')->where(array('status'=>2,'op_id'=>array('in',$opids),'title'=>array('in',$jdRoyaltyKeyWords)))->sum('total');
        $departmentBonus                = ($allCostaccBonus - $jdCostaccBonus)>0 ? $allCostaccBonus - $jdCostaccBonus : 0;*/

        //部门奖金包(本部门计调人员操作的奖金包)
        $departmentBonus                = $this->get_departmentBonus($year_cycle['beginTime'],$quarter_cycle['end_time'],$departmentData['id']);

        $data                           = array();
        $data['last_year_maoli']        = $lastYearData['sum_maoli']; //上年累计毛利
        $data['this_year_maoli']        = $thisYearData['sum_maoli']; //当年累计毛利
        $data['maoli_up_rate']          = $maolidata['up_rate']; //毛利增长率
        $data['lastHrCostData']         = $lastHrCost; //上一年累计人力成本
        $data['thisHrCostData']         = $thisHrCost; //当年累计人力成本
        $data['totalHrCost']            = $totalHrCost; //当年度累计人力成本额度
        $data['fiveRisksOneFundUpData'] = $thisFiveRisksOneFund - $lastFiveRisksOneFund; //五险一金增长
        $data['departmentRoyalty']      = $departmentRoyalty; //部门业绩提成
        $data['departmentBonus']        = $departmentBonus; //部门奖金包
        $data['total_salary_bag']       = round($data['totalHrCost'] + $data['departmentRoyalty'] + $data['fiveRisksOneFundUpData'] + $data['departmentBonus'],2); //当年度累计薪酬包 = 当年度累计人力成本额度 + 部门业绩提成 + 公司五险一金增量 + 部门奖金包
        $data['totalSalaryBagLeftOver'] = round($data['total_salary_bag'] - $data['thisHrCostData'],2);  //当年度累计薪酬包结余 = 当年季度累计薪酬包 - 当年季度累计实发人力成本
        $data['selfSumBonus']           = round($data['totalSalaryBagLeftOver'] * 0.15, 2); //本人季度累计奖励 = 当年季度累计薪酬包结余 * 15%
        $data['selfSumBonusPaid']       = $this->get_payoff_quarterRoyalty($userid, $year, 'sum'); //本人已发放奖励
        $data['selfSumBonusShould']     = $data['selfSumBonus'] - $data['selfSumBonusPaid']; //本人当季度应发奖励 = 本人季度累计奖励 - 本人季度已发放奖励
        $data['teamSumBonus']           = round($data['totalSalaryBagLeftOver'] * 0.25, 2); //团队季度累计奖励 = 当年季度累计薪酬包结余 * 25%
        $data['teamSumBonusPaid']       = $this->get_payoff_quarterRoyalty($userid, $year, 'AA_num');; //团队已发放奖励
        $data['teamSumBonusShould']     = $data['teamSumBonus'] - $data['teamSumBonusPaid']; //团队当季度应发放奖励
        $info                           = array();
        $info['account_id']             = $userid;
        $info['sum']                    = $data['selfSumBonusShould'];
        $info['AA_tit']                 = "团队当季度应发奖励";
        $info['AA_num']                 = $data['teamSumBonusShould'];
        $data['info']                   = $info;
        return $data;
    }

    //部门奖金包(本部门计调人员操作的奖金包)
    private function get_departmentBonus($beginTime,$endTime,$departmentid){
        $settlement_lists               = get_settlement_list($beginTime,$endTime);
        $jd_uids                        = array_unique(array_column($settlement_lists,'req_uid'));
        $jd_data                        = M('account')->where(array('id'=>array('in',$jd_uids)))->getField('id,nickname,departmentid',true);

        $department_jd_data             = $this->get_department_jd_uids($jd_data,$departmentid);
        $department_jd_ids              = array_column($department_jd_data,'id');

        $department_op_lists            = array();
        foreach ($settlement_lists as $v){
            if (in_array($v['req_uid'],$department_jd_ids)){
                $department_op_lists[]  = $v;
            }
        }
        $opids                          = array_column($department_op_lists,'op_id');
        $allRoyaltyKeyWords             = array('计调提成','资源提成','研发提成','奖金包','计调奖金包','资源奖金包','研发奖金包','总奖金包');
        $allCostaccBonus                = M('op_costacc')->where(array('status'=>2,'op_id'=>array('in',$opids),'title'=>array('in',$allRoyaltyKeyWords)))->sum('total');
        //$jdRoyaltyKeyWords              = array('计调提成','计调奖金包');
        //$jdCostaccBonus                 = M('op_costacc')->where(array('status'=>2,'op_id'=>array('in',$opids),'title'=>array('in',$jdRoyaltyKeyWords)))->sum('total');
        //$departmentBonus                = ($allCostaccBonus - $jdCostaccBonus)>0 ? $allCostaccBonus - $jdCostaccBonus : 0;
        $departmentBonus                = $allCostaccBonus ? $allCostaccBonus : 0;
        return $departmentBonus;
    }

    //获取本部门的计调
    private function get_department_jd_uids($jd_data,$departmentid){
        $s_departmentids                = C('noJiGuanJidiaoDepartmentIds');
        $data                           = array();
        if (in_array($departmentid,$s_departmentids)){ //使用本部门计调
            foreach ($jd_data as $v){
                if ($v['departmentid'] == $departmentid){
                    $data[]             = $v;
                }
            }
        }else{
            foreach ($jd_data as $v){
                if (!in_array($v['departmentid'],$s_departmentids)){
                    $data[]             = $v;
                }
            }
            $data['8888']['id']         = 0; //系统自动生成的(无计调) 记入机关部门
        }

        return $data;
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
        //$year_settlement_lists  = get_settlement_list($year_cycle['beginTime'],$year_cycle['endTime'],'',$userid);
        $year_settlement_lists  = get_settlement_list($year_cycle['beginTime'],$quarter_cycle['end_time'],'',$userid);
        $quarter_settlement_lists = get_settlement_list($quarter_cycle['begin_time'],$quarter_cycle['end_time'],'',$userid);

        //累计已发操作奖金
        //$salary_months          = $this->get_salary_months($year);
        //$sum_royalty_salary     = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('bonus');
        $sum_royalty_salary     = $this->get_sum_royalty_salary($year,$userid);

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

        //业务岗累计已发放提成	当季度发放提成
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

    //获取累计已发提成数据(非业务岗奖金)
    private function get_sum_royalty_salary($year,$userid){
        $salary_months              = $this->get_salary_months($year);
        $sum_royalty_salary         = M('salary_wages_month')->where(array('datetime'=>array('in',$salary_months['salary_year_months']),'account_id'=>$userid,'status'=>4))->sum('bonus');
        return $sum_royalty_salary;
    }

}
