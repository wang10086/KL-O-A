<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class SalaryModel extends Model
{

    /**
     * individual_tax 个人所得税
     * $cout_money 个人金额 $userid 用户id
     */
    public function individual_tax($cout_money,$userid){
        $where['account_id']   = array('eq',$userid);
        $where['status']       = array('neq',3);
        $tax                   = M('salary_individual_tax')->where('account_id='.$userid)->order('id DESC')->find();
        if($tax && $tax['statu'] !==3){
            $counting          = $tax['individual_tax'];
        }else{
            if($cout_money <= 5000){
                $counting      = '0';
            }else{
                $cout          = $cout_money-5000;
                if($cout <= 3000){
                    $countin   = $cout*0.03;
                }elseif($cout > 3000 && $cout <= 12000){
                    $countin   = $cout*0.10-210;
                }elseif($cout > 12000 && $cout <= 25000){
                    $countin   = $cout*0.20-1410;
                }elseif($cout > 25000 && $cout <= 35000){
                    $countin   = $cout*0.25-2660;
                }elseif($cout > 35000 && $cout <= 55000){
                    $countin   = $cout*0.30-4410;
                }elseif($cout > 55000 && $cout <= 80000){
                    $countin   = $cout*0.35-7160;
                }elseif($cout > 80000){
                    $countin   = $cout*0.45-15160;
                }
                $counting      = round($countin,2);
            }
        }
        return $counting;
    }


    /**
     * year_end_tax 年终奖税
     * $Year_end 年终金额
     * $year_end_tax
     */
    public function year_end_tax($Year_end,$year_end_tax){
        if(is_numeric($Year_end) || is_numeric($year_end_tax)){
            return $year_end_tax;die;
        }else{
            return 0;die;
        }
    }


    /***
     * year_end 年终奖
     * $Year_end 年终金额
     */

    public function year_end($Year_end){

        if($Year_end < 1500){
            $price1   = $Year_end*0.03;
        }
        if($Year_end > 1500 && $Year_end < 4500){
            $price1   = $Year_end*0.1-105;
        }
        if($Year_end > 4500 && $Year_end < 9000){
            $price1   = $Year_end*0.2-555;
        }
        if($Year_end > 9000 && $Year_end < 35000){
            $price1   = $Year_end*0.25-1055;
        }
        if($Year_end > 35000 && $Year_end < 55000){
            $price1   = $Year_end*0.3-2755;
        }
        if($Year_end > 55000 && $Year_end < 80000){
            $price1   = $Year_end*0.35-5505;
        }
        if($Year_end>80000){
            $price1   = $Year_end*0.45-13505;
        }
        $price = round($price1,2);
        return $price;
    }


    /***************************************************************************************************************/
    /***************************************************************************************************************/
    /***************************************************************************************************************/

    public function get_salary_status($datetime){
        $list                           = M('salary_sign')->where(array('datetime'=>$datetime))->find();
        $sign_db                        = M('user_sign');
        $data                           = array();
        if (!$list || $list['examine_status']==1){ //待人事提交
            $data['status']             = 1;
        }elseif ($list['examine_status']==2 && $list['submission_status']==1 && $list['approval_status']==1){ //待财务审核
            $data['status']             = 2;
            $data['url1']               = $sign_db->where(array('user_id'=>77))->getField('file_url'); //人事签字
        }elseif ($list['examine_status']==2 && $list['submission_status']==2 && $list['approval_status']==1){ //待总经理审核
            $data['status']             = 3;
            $data['url1']               = $sign_db->where(array('user_id'=>77))->getField('file_url'); //人事签字
            $data['url2']               = $sign_db->where(array('user_id'=>55))->getField('file_url'); //财务签字
        }elseif ($list['examine_status']==2 && $list['submission_status']==2 && $list['approval_status']==2) { //已全部签字
            $data['status']             = 4;
            $data['url1']               = $sign_db->where(array('user_id'=>77))->getField('file_url'); //人事签字
            $data['url2']               = $sign_db->where(array('user_id'=>55))->getField('file_url'); //财务签字
            $data['url3']               = $sign_db->where(array('user_id'=>11))->getField('file_url'); //总经理
        }
        return $data;
    }

    /**
     * 获取销售季度任务系数oa_sale_config表
     * @param $quarter
     */
    private function getQuarterMonth($quarter,$year){
        $quarter                        = (int)$quarter;
        $field                          = array();
        switch ($quarter){
            case 1:
                $field                  = 'id,department_id,department,year,January,February,March';
                break;
            case 2:
                $field                  = 'id,department_id,department,year,April,May,June';
                break;
            case 3:
                $field                  = 'id,department_id,department,year,July,August,September';
                break;
            case 4:
                $field                  = 'id,department_id,department,year,October,November,December';
                break;
        }
        $lists                          = M('sale_config')->field($field)->where(array('year'=>$year))->select();
        foreach ($lists as $k=>$v){
            $January                    = $v['January']?$v['January']:0;
            $February                   = $v['February']?$v['February']:0;
            $March                      = $v['March']?$v['March']:0;
            $April                      = $v['April']?$v['April']:0;
            $May                        = $v['May']?$v['May']:0;
            $June                       = $v['June']?$v['June']:0;
            $July                       = $v['July']?$v['July']:0;
            $August                     = $v['August']?$v['August']:0;
            $September                  = $v['September']?$v['September']:0;
            $October                    = $v['October']?$v['October']:0;
            $November                   = $v['November']?$v['November']:0;
            $December                   = $v['December']?$v['December']:0;
            $lists[$k]['coefficient']       = $January + $February + $March + $April + $May + $June + $July + $August + $September + $October + $November + $December;
        }
        return $lists;
    }

    //获取李保罗的季度目标系数
    private function get_lbl_coefficient($quarter){
        switch ($quarter){
            case 1:
                $data                   = 11;
                break;
            case 2:
                $data                   = 7;
                break;
            case 3:
                $data                   = 16;
                break;
            case 4:
                $data                   = 6;
                break;
        }
        return $data;
    }

    //获取该季度所有结算的团
    private function get_quarter_settlement_list($quarter_time){
        $where                                  = array();
        $where['b.audit_status']                = 1;
        $where['l.req_type']                    = 801;
        $where['l.audit_time']                  = array('between', "$quarter_time[begin_time],$quarter_time[end_time]");
        $field                                  = array();
        $field                                  = 'o.op_id,o.project,o.group_id,o.create_user,o.create_user_name,b.maoli'; //获取所有该季度结算的团
        $op_settlement_list                     = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        return $op_settlement_list;
    }

    //获取本人季度业绩提成
    private function get_quarter_royalty($user,$sale_configs,$op_settlement_list,$salary,$pay_month,$quarter){
        //$salary                                 = $salary;    //工资岗位薪酬

        /************************************start***************************************/
        //201904调工资 , 基本工资取上个月数据(5月份删除此项)
        $salary                       = M('salary_wages_month')->where(array('account_id'=>$user['id'],'status'=>4,'datetime'=>'201903'))->getField('standard');
        /*************************************end****************************************/
        foreach ($sale_configs as $k=>$v){
            if ($user['id'] == 59){ //李保罗
                $coefficient                    = $this->get_lbl_coefficient($quarter);
            }else{
                if ($user['departmentid']==$v['department_id']){
                    $coefficient                = $v['coefficient'];    //季度目标系数
                }
            }
        }
        $lists                                  = array();
        foreach ($op_settlement_list as $key=>$value){
            if ($value['create_user']== $user['id']){
                $lists[]                        = $value;   //当季度结算的团
            }
        }
        $sum_profit                             = array_sum(array_column($lists,'maoli'));  //当季度结算毛利总额

        //提成金额 = 季度目标系数 * 工资岗位薪酬 (100%内提取5%; 100%-150%=>20%; 大于150%=>25%)
        $target                                 = $salary*$coefficient;     //目标值 = 季度目标系数 * 工资岗位薪酬
        $royalty                                = 0;
        if ($sum_profit < $target){
            $royalty                            += $sum_profit*0.05;
        }elseif ($sum_profit > $target && $sum_profit < $target*1.5){
            $royalty                            += $target*0.05;
            $royalty                            += ($sum_profit - $target)*0.2;
        }elseif ($sum_profit > $target*1.5){
            $royalty                            += $target*0.05;
            $royalty                            += ($target*1.5 - $target)*0.2;
            $royalty                            += ($sum_profit - $target*1.5)*0.25;
        }
        $data                                   = array();
        $data['account_id']                     = $user['id'];
        $data['salary']                         = $salary;
        $data['quarter_profit']                 = $sum_profit;  //季度毛利
        $data['target']                         = $target;      //目标值
        if (in_array($pay_month,array('01','04','07','10'))) {   //季度后一个月发放该季度提成
            if ($user['departmentid']==15){ //常规旅游中心
                $data['quarter_royalty'] = '0.00';
            }else{
                $data['quarter_royalty'] = $royalty;     //季度提成
            }
        }else{
            $data['quarter_royalty'] = '0.00';
        }
        return $data;
    }

    /**
     * 获取部门合计
     * @param $lists
     */
    public function get_department_wagesList($lists){
        $departments                                        = array_filter(array_unique(array_column($lists,'department')));
        $data                                               = array();
        foreach ($departments as $key=>$value){
            $data[$key]['department']                       = 0;
            $data[$key]['standard']                         = 0;
            $data[$key]['basic_salary']                     = 0;
            $data[$key]['withdrawing']                      = 0;
            $data[$key]['performance_salary']               = 0;
            $data[$key]['Achievements_withdrawing']         = 0;
            $data[$key]['Subsidy']                          = 0;
            $data[$key]['target']                           = 0;
            $data[$key]['complete']                         = 0;
            $data[$key]['total']                            = 0;
            $data[$key]['welfare']                          = 0;
            $data[$key]['bonus']                            = 0;
            $data[$key]['yearend']                          = 0;
            $data[$key]['housing_subsidy']                  = 0;
            $data[$key]['Other']                            = 0;
            $data[$key]['Should_distributed']               = 0;
            $data[$key]['medical_care']                     = 0;
            $data[$key]['pension_ratio']                    = 0;
            $data[$key]['unemployment']                     = 0;
            $data[$key]['accumulation_fund']                = 0;
            $data[$key]['insurance_Total']                  = 0;
            $data[$key]['specialdeduction']                 = 0;
            $data[$key]['tax_counting']                     = 0;
            $data[$key]['personal_tax']                     = 0;
            $data[$key]['Labour']                           = 0;
            $data[$key]['summoney']                         = 0;
            $data[$key]['real_wages']                       = 0;
            foreach ($lists as $k=>$v) {
                if ($v['department'] == $value) {
                    $data[$key]['name']                     = '部门合计';
                    $data[$key]['department']               = $value;
                    $data[$key]['standard']                 += $v['standard'];
                    $data[$key]['basic_salary']             += $v['basic_salary'];
                    $data[$key]['withdrawing']              += $v['withdrawing'];
                    $data[$key]['performance_salary']       += $v['performance_salary'];
                    $data[$key]['Achievements_withdrawing'] += $v['Achievements_withdrawing'];
                    $data[$key]['Subsidy']                  += $v['Subsidy'];
                    $data[$key]['target']                   += $v['target'];
                    $data[$key]['complete']                 += $v['complete'];
                    $data[$key]['total']                    += $v['total'];
                    $data[$key]['welfare']                  += $v['welfare'];
                    $data[$key]['bonus']                    += $v['bonus'];
                    $data[$key]['yearend']                  += $v['yearend'];
                    $data[$key]['housing_subsidy']          += $v['housing_subsidy'];
                    $data[$key]['Other']                    += $v['Other'];
                    $data[$key]['Should_distributed']       += $v['Should_distributed'];
                    $data[$key]['medical_care']             += $v['medical_care'];
                    $data[$key]['pension_ratio']            += $v['pension_ratio'];
                    $data[$key]['unemployment']             += $v['unemployment'];
                    $data[$key]['accumulation_fund']        += $v['accumulation_fund'];
                    $data[$key]['insurance_Total']          += $v['insurance_Total'];
                    $data[$key]['specialdeduction']         += $v['specialdeduction'];
                    $data[$key]['tax_counting']             += $v['tax_counting'];
                    $data[$key]['personal_tax']             += $v['personal_tax'];
                    $data[$key]['Labour']                   += $v['Labour'];
                    $data[$key]['summoney']                 += $v['summoney'];
                    $data[$key]['real_wages']               += $v['real_wages'];
                }
            }
        }
        return $data;
    }


    /**
     * 获取公司工资总和
     * @param $lists
     * @return array
     */
    public function get_company_wages($lists){
        $data                                               = array();
        $data['standard']                                   = 0;
        $data['basic_salary']                               = 0;
        $data['withdrawing']                                = 0;
        $data['performance_salary']                         = 0;
        $data['Achievements_withdrawing']                   = 0;
        $data['Subsidy']                                    = 0;
        $data['target']                                     = 0;
        $data['complete']                                   = 0;
        $data['total']                                      = 0;
        $data['welfare']                                    = 0;
        $data['bonus']                                      = 0;
        $data['yearend']                                    = 0;
        $data['housing_subsidy']                            = 0;
        $data['Other']                                      = 0;
        $data['Should_distributed']                         = 0;
        $data['medical_care']                               = 0;
        $data['pension_ratio']                              = 0;
        $data['unemployment']                               = 0;
        $data['accumulation_fund']                          = 0;
        $data['insurance_Total']                            = 0;
        $data['specialdeduction']                           = 0;
        $data['tax_counting']                               = 0;
        $data['personal_tax']                               = 0;
        $data['Labour']                                     = 0;
        $data['summoney']                                   = 0;
        $data['real_wages']                                 = 0;
        foreach ($lists as $k=>$v) {
            $data['name']                                   = '总合计';
            $data['standard']                               += $v['standard'];
            $data['basic_salary']                           += $v['basic_salary'];
            $data['withdrawing']                            += $v['withdrawing'];
            $data['performance_salary']                     += $v['performance_salary'];
            $data['Achievements_withdrawing']               += $v['Achievements_withdrawing'];
            $data['Subsidy']                                += $v['Subsidy'];
            $data['target']                                 += $v['target'];
            $data['complete']                               += $v['complete'];
            $data['total']                                  += $v['total'];
            $data['welfare']                                += $v['welfare'];
            $data['bonus']                                  += $v['bonus'];
            $data['yearend']                                += $v['yearend'];
            $data['housing_subsidy']                        += $v['housing_subsidy'];
            $data['Other']                                  += $v['Other'];
            $data['Should_distributed']                     += $v['Should_distributed'];
            $data['medical_care']                           += $v['medical_care'];
            $data['pension_ratio']                          += $v['pension_ratio'];
            $data['unemployment']                           += $v['unemployment'];
            $data['accumulation_fund']                      += $v['accumulation_fund'];
            $data['insurance_Total']                        += $v['insurance_Total'];
            $data['specialdeduction']                       += $v['specialdeduction'];
            $data['tax_counting']                           += $v['tax_counting'];
            $data['personal_tax']                           += $v['personal_tax'];
            $data['Labour']                                 += $v['Labour'];
            $data['summoney']                               += $v['summoney'];
            $data['real_wages']                             += $v['real_wages'];
        }
        return $data;
    }

    /**
     * 获取员工个人薪资信息
     * @param $accounts
     * @param $datetime
     * @return array
     */
    public function get_person_wages_lists($accounts,$datetime){
        //$month                              = substr($datetime,4,2);
        $departments                        = M('salary_department')->getField('id,department',true); //部门
        $posts                              = M('posts')->getField('id,post_name',true);

        $data                               = array();
        foreach ($accounts as $k=>$v){
            $data[$k]['account_id']         = $v['id'];
            $data[$k]['user_name']          = $v['nickname'];
            //$data[$k]['departmentid']       = $v['departmentid'];
            $data[$k]['department']         = $departments[$v['departmentid']];
            $data[$k]['post_name']          = $posts[$v['postid']];
            $data[$k]['datetime']           = $datetime;
            $salary                         = M('salary')->where(array('account_id'=>$v['id']))->order('id desc')->find();
            $data[$k]['salary_id']          = $salary['id']?$salary['id']:0;
            $data[$k]['standard']           = $salary['standard_salary']?$salary['standard_salary']:'0.00';   //岗位薪酬
            $data[$k]['basic_salary']       = round(($salary['standard_salary']/10)*$salary['basic_salary'],2); //基本工资
            $attendance_list                = M('salary_attendance')->where(array('account_id'=>$v['id'],'status'=>1))->order('id desc')->find();//员工考勤信息
            $data[$k]['attendance_id']      = $attendance_list['id']?$attendance_list['id']:'0';
            $data[$k]['withdrawing']        = $attendance_list['withdrawing']?$attendance_list['withdrawing']:'0.00';//考勤扣款
            $data[$k]['performance_salary'] = round(($salary['standard_salary']/10)*$salary['performance_salary'],2); //岗位绩效工资
            $kpi_pdca_score                 = $this->get_kpi_salary($v,$salary,$datetime); //绩效得分AAAA
            $data[$k]['Achievements_withdrawing']= $kpi_pdca_score['count_money']?$kpi_pdca_score['count_money']:'0.00'; //绩效增减
            $op_guide_info                  = $this->get_op_guide($v,$datetime); //带团补助信息
            $data[$k]['Subsidy']            = $op_guide_info['guide_salary']?$op_guide_info['guide_salary']:'0.00'; //带团补助金额
            $quarter_royalty_data           = $this->get_royalty($v,$datetime,$salary['standard_salary']); //季度毛利,季度目标,季度提成
            $data[$k]['target']             = $quarter_royalty_data['target']?$quarter_royalty_data['target']:'0.00'; //季度目标
            $data[$k]['complete']           = $quarter_royalty_data['quarter_profit']?$quarter_royalty_data['quarter_profit']:'0.00'; //季度毛利(完成值)

            $salary_bonus_list              = M('salary_bonus')->where(array('account_id'=>$v['id'],'status'=>1))->order('id desc')->find(); //其他人员提成 奖金 年终奖
            $data[$k]['bonus_id']           = $salary_bonus_list['id']?$salary_bonus_list['id']:'0';
            $royalty                        = $quarter_royalty_data['quarter_royalty'] + $salary_bonus_list['bonus']; //提成 : 业务人员季度提成(自动取值) + 其他人员提成(手动录入)
            $data[$k]['total']              = $royalty?round($royalty,2):'0.00'; //总业绩提成

            $data[$k]['welfare']            = $salary_bonus_list['annual_bonus']?$salary_bonus_list['annual_bonus']:'0.00'; //年终奖
            $data[$k]['bonus']              = $salary_bonus_list['foreign_bonus']?$salary_bonus_list['foreign_bonus']:'0.00'; //奖金
            $data[$k]['yearend']            = $salary_bonus_list['year_end_tax']; //年终奖计税
            $other_income                   = $this->get_other_income($v['id']); //其他收入变动(差额补)AAAA
            $data[$k]['income_token']       = $other_income['income_token']; //其他收入变动token

            $salary_subsidy_list            = M('salary_subsidy')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //补贴(住房补贴,外地补贴,电脑补贴)
            $data[$k]['subsidy_id']         = $salary_subsidy_list['id']?$salary_subsidy_list['id']:'0'; //补贴id
            $data[$k]['housing_subsidy']    = $salary_subsidy_list['housing_subsidy']?$salary_subsidy_list['housing_subsidy']:'0.00';  //住房补贴
            $other                          = $salary_subsidy_list['foreign_subsidies']+$salary_subsidy_list['computer_subsidy'] + $other_income['income_money'];
            $data[$k]['Other']              = $other?$other:'0.00'; //其他补款(外地补贴+电脑补贴+其他收入变动(补差额))
            //应发工资 = (基本工资 - 考勤扣款) + (绩效工资 - 绩效增减) + 业绩提成 + 带团补助 + 奖金 + 年终奖 + 住房补贴 + 其他补款;
            $data[$k]['Should_distributed'] = ($data[$k]['basic_salary'] - $data[$k]['withdrawing']) + ($data[$k]['performance_salary'] + $data[$k]['Achievements_withdrawing']) + $data[$k]['total'] + $data[$k]['Subsidy'] + $data[$k]['bonus'] + $data[$k]['welfare'] + $data[$k]['housing_subsidy'] + $data[$k]['Other']; //应发工资 = (基本工资 - 考勤扣款) + (绩效工资标准-绩效增减)+业绩提成+带团补助+ 奖金+年终奖+住房补贴+其他补款
            $salary_insurance_list          = M('salary_insurance')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //五险一金
            $data[$k]['insurance_id']       = $salary_insurance_list['id']?$salary_insurance_list['id']:'0';
            $data[$k]['medical_care']       = round(($salary_insurance_list['medical_care_base']*$salary_insurance_list['medical_care_ratio'])+ $salary_insurance_list['big_price'],2); //医疗保险个人
            $data[$k]['pension_ratio']      = round($salary_insurance_list['pension_base']*$salary_insurance_list['pension_ratio'],2);  //养老保险个人
            $data[$k]['unemployment']       = round($salary_insurance_list['unemployment_base']*$salary_insurance_list['unemployment_ratio'],2);  //失业保险个人
            $data[$k]['accumulation_fund']  = round($salary_insurance_list['accumulation_fund_base']*$salary_insurance_list['accumulation_fund_ratio']);  //公积金个人(不保留小数)
            $data[$k]['insurance_Total']    = $data[$k]['medical_care'] + $data[$k]['pension_ratio'] + $data[$k]['unemployment'] + $data[$k]['accumulation_fund']; //个人保险合计

            $specialdeduction_list          = M('salary_specialdeduction')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //专项附加扣除
            $specialdeduction               = round($specialdeduction_list['children_education'] + $specialdeduction_list['continue_education'] + $specialdeduction_list['health'] + $specialdeduction_list['buy_house'] + $specialdeduction_list['rent_house'] + $specialdeduction_list['support_older'],2); //专项附加扣除合计
            $data[$k]['specialdeduction']   = $specialdeduction?$specialdeduction:'0.00'; //专项附加扣除合计
            $data[$k]['specialdeduction_id']= $specialdeduction_list['id']?$specialdeduction_list['id']:'0';
            //本月计税工资 = (应发工资 - 个人保险合计 - 专项附加扣除 - 个人免征额) + [其他补助(差额补)]
            $data[$k]['tax_counting']       = round(($data[$k]['Should_distributed'] - $data[$k]['insurance_Total'] - $data[$k]['specialdeduction'] - 5000) + $data[$k]['Other'],2); //本月计税工资 = (应发工资 - 个人保险合计 - 专项附加扣除 - 个人免征额5000) + [其他补助(差额补)]
            $individual_tax_info            = $this->get_personal_income_tax($v['id']); //个人所得税AAAA
            $data[$k]['individual_id']      = $individual_tax_info['id']?$individual_tax_info['id']:'0';
            $data[$k]['personal_tax']       = $individual_tax_info['tax']?$individual_tax_info['tax']:'0.00'; //个人所得税
            $labour_list                    = M('salary_labour')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //工会会费信息
            $data[$k]['Labour']             = $labour_list['Labour_money']; //工会会费
            $data[$k]['labour_id']          = $labour_list['id']?$labour_list['id']:'0';
            $withholding                    = $this->get_withholding($v['id']); //代扣代缴
            $data[$k]['withholding_token']  = $withholding['token']; //代扣代缴token
            $data[$k]['summoney']           = $withholding['money']?$withholding['money']:'0.00'; //代扣代缴(税后扣款)
            //实发工资 = 应发工资 - 个人保险合计 - 个人所得税 - 年终奖个税 - 税后扣款 - 工会会费 - 代扣代缴;
            $data[$k]['real_wages']         = $data[$k]['Should_distributed'] - $data[$k]['insurance_Total']- $data[$k]['personal_tax'] - $data[$k]['yearend'] - $data[$k]['after_text_money'] - $data[$k]['Labour'] - $data[$k]['summoney'];

            $data[$k]['total_score_show']   = $kpi_pdca_score['sum_kpi_score']; //KPI分数
            $data[$k]['sum_total_score']    = $kpi_pdca_score['total_pdca_score']; //pdca分数
            $data[$k]['show_qa_score']      = $kpi_pdca_score['show_qa_score']; //品质检查分数
        }
        return $data;
    }

    /**
     * 获取季度提成信息
     * @param $userinfo 用户信息
     * @param $datetime 年月
     * @param $salary 基本工资
     * @return array
     */
    public function get_royalty($userinfo,$datetime,$salary){
        $pay_year                                   = (int)substr($datetime,0,4);
        $pay_month                                  = (int)substr($datetime,4);
        if ($pay_month==1) {
            $p_year                             = $pay_year - 1;
            $p_month                            = 12;
        }else{
            $p_year                             = $pay_year;
            $p_month                            = $pay_month - 1;
        }
        $quarter                                = get_quarter($p_month);
        $sale_configs                           = $this->getQuarterMonth($quarter,$p_year);     //获取所有销售季度任务基数 coefficient
        $quarter_time                           = getQuarterlyCicle($p_year,$p_month);          //获取该季度周期,方便业务提成(结算)取值
        $op_settlement_list                     = $this->get_quarter_settlement_list($quarter_time);   //获取该季度所有的结算团

        $quarter_royalty_data                   = $this->get_quarter_royalty($userinfo,$sale_configs,$op_settlement_list,$salary,$pay_month,$quarter);    //销售季度目标 完成 提成
        return $quarter_royalty_data;
    }

    /**
     * 获取带团补助
     * @param $userinfo
     * @param $datetime
     * @return array
     */
    public function get_op_guide($userinfo,$datetime){
        $guide_id                           = $userinfo['guide_id'];
        $times                              = get_cycle($datetime); //获取考核周期
        $where                              = array();
        $where['guide_id']                  = $guide_id;
        $where['status']                    = 2; //已完成
        $where['sure_time']                 = array('between',"$times[begintime],$times[endtime]");
        $lists                              = M('guide_pay')->where($where)->select();
        $guide_salary                       = array_sum(array_column($lists,'really_cost'));
        $data                               = array();
        $data['guide_salary']               = $guide_salary;
        $data['lists']                      = $lists;
        return $data;
    }


    //代扣代缴
    public function get_withholding($userid){
        $lists                  = M('salary_withholding')->where(array('account_id'=>$userid,'status'=>1))->order('id desc')->select();
        $data                   = array();
        $data['money']          = array_sum(array_column($lists,'money'));
        $data['token']          = $lists[0]['token'];
        $data['lists']          = $lists;
        return $data;
    }

    /**
     * 获取其他收入(补差额)
     * @param $userid
     * @return array
     */
    public function get_other_income($userid){
        $lists                  = M('salary_income')->where(array('account_id'=>$userid,'status'=>1))->order('id desc')->select();
        $data                   = array();
        $data['income_money']   = array_sum(array_column($lists,'income_money'));
        $data['income_token']   = $lists[0]['income_token'];
        $data['lists']          = $lists;
        return $data;
    }

    //个人所得税(已手动录入的话取手动录入的值 ,无手动录入则套用计算公式)
    public function get_personal_income_tax($userid){
        $list                   = M('salary_individual_tax')->where(array('account_id'=>$userid,'status'=>1))->order('id desc')->find();
        $personal_tax           = $list['individual_tax']?$list['individual_tax']:'0'; //注意后期添加计税公式
        $data                   = array();
        $data['id']             = $list['id'];
        $data['tax']            = $personal_tax;
        return $data;
    }

    /**
     * 获取KPI pdca 品质检查 得分及工资增减信息
     * @param $userinfo
     * @param $salary
     * @param $datetime
     * @return mixed
     */
    public function get_kpi_salary($userinfo,$salary,$datetime){
        $last_quarter_kpi_score_users           = C('KPI_QUARTER'); //kpi结果从上个月取值的用户id
        // kpi  pdca 品质检查
        $que['p.tab_user_id']                   = $userinfo['id'];//用户id
        $que['p.month']                         = datetime(date('Y'),date('m'),date('d'),1);
        $user                                   = $this->query_score($que);//绩效增减
        $use1                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['total_score_show']));//PDCA
        $use2                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['show_qa_score']));//品质检查
        if (in_array($userinfo['id'],$last_quarter_kpi_score_users)){ //kpi从上个季度取值
            $use3                              = $this->get_last_quarter_kpi_score($userinfo,$datetime);
        }else{
            $use3                               = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','+'),"",$user[0]['total_kpi_score']));//KPI
        }
        $money                                  = ($salary['standard_salary']/10)*$salary['performance_salary'];//绩效金额
        $base_money                             = ($salary['standard_salary']/10)*$salary['basic_salary'];    //基本工资
        $branch                                 = 100;//给总共100分

        if($userinfo['formal']==0 || $userinfo['formal']==4) {$use3 = 0;} //排除试用期和实习期
        $f      = $use2+$use3;//获得总分    品质检查+kpi从绩效工资取值
        $fpdca  = $use1;

        $balance1                           = round(($money/$branch*$f),2); //绩效工资余额
        $balance2                           = round(($base_money/$branch*$fpdca),2);    //基本工资余额

        $user_info['count_money']         = $balance1 + $balance2;
        $user_info['total_pdca_score']    = $use1;//pdca分数
        $user_info['show_qa_score']       = $use2;//品质检查分数
        $user_info['sum_kpi_score']       = $use3;//KPI分数
        return $user_info;
    }

    /**
     * 获取上个季度的kpi值
     * @param $userinfo
     * @param $datetime
     */
    private function get_last_quarter_kpi_score($userinfo,$datetime){
        $userid                             = $userinfo['id'];
        $year                               = substr($datetime,0,4);
        $month                              = substr($datetime,4,2);
        $kpi_month                          = $this->get_kpi_score_month($year,$month);
        $where                              = array();
        $where['month']                     = $kpi_month;
        $where['user_id']                   = $userid;
        $kpi_data                           = M('kpi')->where($where)->find();
        $kpi_score                          = $kpi_data['score'];
        $salary_score                       = $kpi_score?$kpi_score-100:0;
        return $salary_score;
    }

    //kpi所用到的季度月份信息
    private function get_kpi_score_month($year,$month){
        switch ($month){
            case '01':
                $cycle_month                = ($year-1).'10,'.($year-1).'11,'.($year-1).'12';
                break;
            case '02':
                $cycle_month                = ($year-1).'10,'.($year-1).'11,'.($year-1).'12';
                break;
            case '03':
                $cycle_month                = ($year-1).'10,'.($year-1).'11,'.($year-1).'12';
                break;
            case '04':
                $cycle_month                = $year.'01,'.$year.'02,'.$year.'03';
                break;
            case '05':
                $cycle_month                = $year.'01,'.$year.'02,'.$year.'03';
                break;
            case '06':
                $cycle_month                = $year.'01,'.$year.'02,'.$year.'03';
                break;
            case '07':
                $cycle_month                = $year.'04,'.$year.'05,'.$year.'06';
                break;
            case '08':
                $cycle_month                = $year.'04,'.$year.'05,'.$year.'06';
                break;
            case '09':
                $cycle_month                = $year.'04,'.$year.'05,'.$year.'06';
                break;
            case '10':
                $cycle_month                = $year.'07,'.$year.'08,'.$year.'09';
                break;
            case '11':
                $cycle_month                = $year.'07,'.$year.'08,'.$year.'09';
                break;
            case '12':
                $cycle_month                = $year.'07,'.$year.'08,'.$year.'09';
                break;
        }
        return $cycle_month;
    }

    /**
     * sql_query
     * $que['p.tab_user_id'] 用户id
     * $que['a.nickname'] 用户昵称
     *$que['p.month'] 查询年月
     */
    private function query_score($que){
        $lists 			                    = M()->table('__PDCA__ as p')->field('p.*,a.nickname')->join('__ACCOUNT__ as a on a.id = p.tab_user_id')->where($que)->select();
        foreach($lists as $k=>$v){

            $sum_total_score                = 0;

            $yu                             = $v['status'] !=5 ? 0 : $v['total_score']-100;

            //计算PDCA加减分
            $sum_total_score                += $yu;

            //品质检查加减分
            $sum_total_score                += $v['total_qa_score'];

            //整理品质检查加减分
            $lists[$k]['total_score_show']  = $v['status']!=5 ? '<font color="#ff9900">未完成评分</font>' : show_score($yu);

            //整理品质检查加减分
            $lists[$k]['show_qa_score']     =  show_score($v['total_qa_score']);

            //获取KPI数据
            $kpi                            = M('kpi')->where(array('month'=>$v['month'],'user_id'=>$v['tab_user_id']))->find();
            if($kpi && $kpi['month']>=201803){
                $kpiscore                   =  $kpi['score']-100;
            }else{
                $kpiscore                   =  0;
            }

            //KPI加减分
            $sum_total_score                += $kpiscore;

            //KPI
            $lists[$k]['total_kpi_score']   = show_score($kpiscore);

            //合计
            $lists[$k]['sum_total_score']   =  show_score($sum_total_score);

        }
        return $lists;

    }

}
?>