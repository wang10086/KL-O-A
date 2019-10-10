<?php
    namespace Main\Model;
    use Think\Model;
    use Sys\P;

    class RbacModel extends Model{

        /**
         * 获取统计数据
         * @param $months 月份 array
         * @return array
         */
        public function get_chart_personnel($months){
            $department_arr             = C('department1'); //部门
            $department_info            = $this->get_department_info($department_arr);

            $data                       = array();
            foreach ($department_info as $k => $v){
                $staff_data             = $this->get_staff_data($months,$v); //员工人数
                $really_months          = array_unique(array_column($staff_data['list'],'datetime'));
                $position_data          = $this->get_position_data($staff_data['list'],$really_months); //岗位人数信息

                $data['员工人数'][$k]['num']   = $staff_data['avg_num'];
                $data['管理岗'][$k]['num']     = $position_data['M']['avg_num'];
                $data['业务岗'][$k]['num']     = $position_data['S']['avg_num'];
                $data['研发岗'][$k]['num']     = $position_data['P']['avg_num'];
                $data['专业岗'][$k]['num']     = $position_data['T']['avg_num'];
                //$data['其他岗位'][$k]['num']  = $position_data['other']['num'];
                $data['其他岗位'][$k]['num']   = $position_data['other']['avg_num'];
                $data['年终奖'][$k]['num']     = $position_data['yearEndBonus']['avg_num'];
                $data['业务提成'][$k]['num']   = $position_data['percentage']['avg_num'];
                $data['奖金包'][$k]['num']     = $position_data['award']['avg_num'];
                $data['无奖金'][$k]['num']     = $position_data['noAward']['avg_num'];

                $data['员工人数'][$k]['uids']   = $staff_data['uids'];
                $data['管理岗'][$k]['uids']    = $position_data['M']['uids'];
                $data['业务岗'][$k]['uids']    = $position_data['S']['uids'];
                $data['研发岗'][$k]['uids']    = $position_data['P']['uids'];
                $data['专业岗'][$k]['uids']    = $position_data['T']['uids'];
                //$data['其他岗位'][$k]['uids'] = $position_data['other']['num'];
                $data['其他岗位'][$k]['uids']  = $position_data['other']['avg_num'];
                $data['年终奖'][$k]['uids']    = $position_data['yearEndBonus']['uids'];
                $data['业务提成'][$k]['uids']  = $position_data['percentage']['uids'];
                $data['奖金包'][$k]['uids']    = $position_data['award']['uids'];
                $data['无奖金'][$k]['uids']    = $position_data['noAward']['uids'];
            }
            return $data;
        }

        /**
         * 获取部门ID
         * @param $departments
         * @return array|int
         */
        public function get_department_info($departments){
            $list                       = M('salary_department')->getField('department,id',true);
            $departs                    = array();
            $data                       = array();
            foreach ($departments as $k=>$v){
                if ($v == '公司'){
                    $department         = 0;
                }elseif ($v == '机关部门'){
                    $department         = array();
                    foreach ($list as $key=>$value){
                        if (!in_array($value,$departs)){
                            $department[] = $value;
                        }
                    }
                }else{
                    $department         = array();
                    $department[]       = $list[$v];
                    $departs[]          = $list[$v];
                }
                $data[$v]               = $department;
            }
            return $data;
        }

        //员工人数
        public function get_staff_data($months,$departments=0){
            $where                      = array();
            if ($departments != 0){ $where['a.departmentid'] = array('in',$departments); }
            $where['s.datetime']        = array('in',$months);
            $where['s.status']          = 4;
            $where['s.user_name']       = array('notlike','%1');
            //$field                      = 's.id,s.account_id,s.user_name,s.department,s.datetime,s.post_name,s.total,a.position_id,d.bonusType,p.position_name,p.code';
            $field                      = 's.*,a.position_id,d.bonusType,p.position_name,p.code,b.extract,b.foreign_bonus,b.annual_bonus,sub.housing_subsidy,sub.foreign_subsidies,sub.computer_subsidy';
            $lists                      = M()->table('__SALARY_WAGES_MONTH__ as s')
                                            ->join('__ACCOUNT__ as a on a.id=s.account_id','left')
                                            ->join('__ACCOUNT_DETAIL__ as d on d.account_id = s.account_id','left')
                                            ->join('__POSITION__ as p on p.id=a.position_id','left')
                                            ->join('__SALARY_BONUS__ as b on b.id=s.bonus_id','left')
                                            ->join('__SALARY_SUBSIDY__ as sub on sub.id = s.subsidy_id','left')
                                            ->where($where)
                                            ->field($field)
                                            ->select();
            $month_num                  = count(array_unique(array_column($lists,'datetime')));
            $data                       = array();
            $data['avg_num']            = $month_num ? round(count($lists)/$month_num,2) : 0;
            $data['uids']               = implode(',',array_column($lists,'account_id'));
            $data['list']               = $lists;
            return $data;
        }

        //岗位信息
        public function get_position_data($lists,$months){
            $month_num                  = count($months);
            $M                          = array(); //管理岗 M
            $S                          = array(); //业务岗 S
            $T                          = array(); //专业岗 T
            $P                          = array(); //研发岗 P
            $other                      = array(); //其他岗位
            $yearEndBonus               = array(); //年终奖
            $percentage                 = array(); //业绩提成
            $award                      = array(); //奖金包
            $noAward                    = array(); //无奖金
            $yearEndBonusMonth          = array();
            $percentageMonth            = array();
            $awardMonth                 = array();
            $noAwardMonth               = array();

            $M['num']                   = 0;
            $S['num']                   = 0;
            $T['num']                   = 0;
            $P['num']                   = 0;
            $other['num']               = 0;
            $yearEndBonusNum            = 0;
            $percentageNum              = 0;
            $awardNum                   = 0;
            $noAwardNum                 = 0;

            foreach ($lists as $k => $v){
                //岗位
                if ($v['code'] == 'M'){
                    $M['num']++;
                    $M['list'][]        = $v;
                }elseif ($v['code'] == 'S'){
                    $S['num']++;
                    $S['list'][]        = $v;
                }elseif ($v['code'] == 'T'){
                    $T['num']++;
                    $T['list'][]        = $v;
                }elseif ($v['code'] == 'P'){
                    $P['num']++;
                    $P['list'][]        = $v;
                }else{
                    $other['num']++;
                    $other['list'][]    = $v;
                }

                //奖金
                if ($v['bonusType'] == 1){ //年终奖
                    $yearEndBonusNum++;
                    $yearEndBonusMonth[]= $v['datetime'];
                    $yearEndBonus[]     = $v;
                }elseif ($v['bonusType'] == 3){ //奖金包
                    $awardNum++;
                    $awardMonth[]       = $v['datetime'];
                    $award[]            = $v;
                }elseif ($v['bonusType'] == 2){ //业绩提成
                    $percentageNum++;
                    $percentageMonth[]  = $v['datetime'];
                    $percentage[]       = $v;
                }else{ //无奖金
                    $noAwardNum++;
                    $noAwardMonth[]     = $v['datetime'];
                    $noAward[]          = $v;
                }
            }

            $yearEndBonusMonthNum       = count(array_filter(array_unique($yearEndBonusMonth)));
            $awardMonthNum              = count(array_filter(array_unique($awardMonth)));
            $percentageMonthNum         = count(array_filter(array_unique($percentageMonth)));
            $noAwardMonthNum            = count(array_filter(array_unique($noAwardMonth)));

            $M['avg_num']               = $month_num ? round($M['num']/$month_num,2) : 0; //月平均人数
            $S['avg_num']               = $month_num ? round($S['num']/$month_num,2) : 0;
            $T['avg_num']               = $month_num ? round($T['num']/$month_num,2) : 0;
            $P['avg_num']               = $month_num ? round($P['num']/$month_num,2) : 0;
            $other['avg_num']           = $month_num ? round($other['num']/$month_num,2) : 0;
            $yearEndBonus['avg_num']    = $yearEndBonusMonthNum ? round($yearEndBonusNum/$yearEndBonusMonthNum,2) : 0; //年终奖平均人数
            $award['avg_num']           = $awardMonthNum ? round($awardNum/$awardMonthNum) : 0;
            $percentage['avg_num']      = $percentageMonthNum ? round($percentageNum/$percentageMonthNum) : 0;
            $noAward['avg_num']         = $noAwardMonthNum ? round($noAwardNum/$noAwardMonthNum) : 0;

            $M['uids']                  = implode(',',array_column($M['list'],'account_id'));
            $S['uids']                  = implode(',',array_column($S['list'],'account_id'));
            $T['uids']                  = implode(',',array_column($T['list'],'account_id'));
            $P['uids']                  = implode(',',array_column($P['list'],'account_id'));
            $other['uids']              = implode(',',array_column($other['list'],'account_id'));
            $yearEndBonus['uids']       = implode(',',array_column($yearEndBonus,'account_id'));
            $award['uids']              = implode(',',array_column($award,'account_id'));
            $percentage['uids']         = implode(',',array_column($percentage,'account_id'));
            $noAward['uids']            = implode(',',array_column($noAward,'account_id'));

            $data                       = array();
            $data['M']                  = $M;
            $data['S']                  = $S;
            $data['T']                  = $T;
            $data['P']                  = $P;
            $data['other']              = $other;
            $data['yearEndBonus']       = $yearEndBonus;
            $data['award']              = $award;
            $data['percentage']         = $percentage;
            $data['noAward']            = $noAward;
            return $data;
        }

        public function get_sum_hr_cost($months){
            $department_arr                     = C('department1'); //部门
            $department_info                    = $this->get_department_info($department_arr);

            $data                               = array();
            foreach ($department_info as $k => $v){
                $staff_data                     = $this->get_staff_data($months,$v); //员工人数
                $post_salary[$k]                = $this->get_post_salary($staff_data['list'])['salary']; //岗位薪酬
                $bonus[$k]                      = $this->get_post_salary($staff_data['list'])['bonus']; //奖金
                $subsidy[$k]                    = $this->get_post_salary($staff_data['list'])['subsidy']; //补助
                $insurance[$k]                  = $this->get_post_salary($staff_data['list'])['insurance']; //公司五险一金
                $sum[$k]                        = $this->get_post_salary($staff_data['list'])['sum']; //合计
                $uids[$k]                       = $this->get_post_salary($staff_data['list'])['uids'];
            }

            $data['postSalary']                 = $post_salary;
            $data['bonus']                      = $bonus;
            $data['subsidy']                    = $subsidy;
            $data['insurance']                  = $insurance;
            $data['sum']                        = $sum;
            $data['uids']                       = $uids;
            return $data;
        }

        //获取员工岗位薪酬
        public function get_post_salary($salaryList){
            $data                               = array(); //基本薪酬
            $data['sum']                        = 0;
            $data['basic_salary']               = 0; //基本工资
            $data['performance_salary']         = 0; //绩效工资
            $data['really_basic_salary']        = 0; //实发基本工资
            $data['really_performance_salary']  = 0; //实发绩效工资
            $uids                               = array(); //人员信息
            $bonus                              = array();
            $bonus['sum']                       = 0; //合计
            $bonus['royalty']                   = 0; //业绩提成
            $bonus['bonus']                     = 0; //奖金包
            $bonus['yearEndBonus']              = 0; //年终奖
            $subsidy                            = array(); //补助 = 带团补助 + 电脑补助 + 外地补助 + 其他收入变动
            $subsidy['sum']                     = 0;
            $subsidy['op_subsidy']              = 0; //带团补助
            $subsidy['computer_subsidy']        = 0; //电脑补助
            $subsidy['foreign_subsidy']         = 0; //外地补助
            $subsidy['other_subsidy']           = 0; //其他收入变动
            $insurance                          = array(); //公司五险一金
            $insurance['sum']                   = 0;
            $insurance['fiveRisks']             = 0; //公司五险
            $insurance['oneFund']               = 0; //公司一金
            foreach ($salaryList as $k=>$v){
                //岗位薪酬
                $data['basic_salary']           += $v['basic_salary'];
                $data['performance_salary']     += $v['performance_salary'];
                $data['really_basic_salary']    += ($v['basic_salary'] - $v['withdrawing']); //实发基本工资 = 标准基本工资 - 考勤扣款
                $data['really_performance_salary']+= ($v['performance_salary'] + $v['Achievements_withdrawing']); //实发绩效工资 = 标准绩效工资 + 绩效增减
                $data['sum']                    += ($v['basic_salary'] - $v['withdrawing']) +($v['performance_salary'] + $v['Achievements_withdrawing']);
                $uids[]                         = $v['account_id'];
                //奖金
                $bonus['royalty']               += $v['total']; //业绩提成
                $bonus['bonus']                 += $v['foreign_bonus']; //奖金包
                $bonus['yearEndBonus']          += $v['annual_bonus']; //年终奖
                $bonus['sum']                   += $v['total'] + $v['foreign_bonus'] + $v['annual_bonus'];
                //补助
                $subsidy['op_subsidy']          += $v['Subsidy']; //带团补助
                $subsidy['computer_subsidy']    += $v['computer_subsidy']; //电脑补助
                $subsidy['foreign_subsidy']     += $v['foreign_subsidies']; //外地补助
                $subsidy['other_subsidy']       += $v['Other']; //其他收入变动
                $subsidy['sum']                 += $v['Subsidy'] + $v['computer_subsidy'] + $v['foreign_subsidies'] + $v['Other'];
                //公司五险一金
                $insuranceList                  = M('salary_insurance')->where(array('id'=>$v['insurance_id']))->find();
                $insurance['fiveRisks']         += ($insuranceList['company_birth_ratio'] * $insuranceList['company_birth_base']) + ($insuranceList['company_injury_ratio'] * $insuranceList['company_injury_base']) + ($insuranceList['company_pension_ratio'] * $insuranceList['company_pension_base']) + ($insuranceList['company_medical_care_ratio'] * $insuranceList['company_medical_care_base']) + ($insuranceList['company_unemployment_ratio'] * $insuranceList['company_unemployment_base']);
                $insurance['oneFund']           += ($insuranceList['company_accumulation_fund_ratio'] * $insuranceList['company_accumulation_fund_base']);
                $insurance['sum']               += ($insuranceList['company_birth_ratio'] * $insuranceList['company_birth_base']) + ($insuranceList['company_injury_ratio'] * $insuranceList['company_injury_base']) + ($insuranceList['company_pension_ratio'] * $insuranceList['company_pension_base']) + ($insuranceList['company_medical_care_ratio'] * $insuranceList['company_medical_care_base']) + ($insuranceList['company_unemployment_ratio'] * $insuranceList['company_unemployment_base']) + ($insuranceList['company_accumulation_fund_ratio'] * $insuranceList['company_accumulation_fund_base']);
            }

            $arr                                = array();
            $arr['salary']                      = $data;
            $arr['bonus']                       = $bonus;
            $arr['subsidy']                     = $subsidy;
            $arr['insurance']                   = $insurance;
            $arr['sum']                         = $data['sum'] + $bonus['sum'] + $subsidy['sum'] + $insurance['sum'];
            $arr['uids']                        = implode(',',array_unique(array_filter($uids)));

            return $arr;
        }


    }


