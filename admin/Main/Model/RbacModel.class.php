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

                $data['员工人数'][$k] = $staff_data['avg_num'];
                $data['管理岗'][$k]   = $position_data['M']['avg_num'];
                $data['业务岗'][$k]   = $position_data['S']['avg_num'];
                $data['研发岗'][$k]   = $position_data['P']['avg_num'];
                $data['专业岗'][$k]   = $position_data['T']['avg_num'];
                $data['其他岗位'][$k] = $position_data['other']['num'];
                $data['年终奖'][$k]   = $position_data['yearEndBonus']['avg_num'];
                $data['业务提成'][$k] = $position_data['percentage']['avg_num'];
                $data['奖金包'][$k]   = $position_data['award']['avg_num'];
                $data['无奖金'][$k]   = $position_data['noAward']['avg_num'];
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
            //$field                      = 's.id,s.account_id,s.user_name,s.department,s.datetime,s.post_name,s.total,a.position_id,d.bonusType,p.position_name,p.code,b.foreign_bonus,b.annual_bonus';
            $field                      = 's.id,s.account_id,s.user_name,s.department,s.datetime,s.post_name,s.total,a.position_id,d.bonusType,p.position_name,p.code';
            $lists                      = M()->table('__SALARY_WAGES_MONTH__ as s')
                                            ->join('__ACCOUNT__ as a on a.id=s.account_id','left')
                                            ->join('__ACCOUNT_DETAIL__ as d on d.account_id = s.account_id','left')
                                            ->join('__POSITION__ as p on p.id=a.position_id','left')
                                            //->join('__SALARY_BONUS__ as b on b.id=s.bonus_id','left')
                                            ->where($where)
                                            ->field($field)
                                            ->select();
            $month_num                  = count(array_unique(array_column($lists,'datetime')));
            $data                       = array();
            $data['avg_num']            = $month_num ? round(count($lists)/$month_num,2) : 0;
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

    }


