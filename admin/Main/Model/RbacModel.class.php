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
            /**
             * 员工人数 - 管理岗 - 业务岗 - 研发岗 - 专业岗 - 其他岗位 -  -  -  -
             */
            $staff_data                 = $this->get_staff_data($months); //员工人数
            $position_data              = $this->get_position_data($staff_data['list'],$months); //岗位人数信息

            $data                       = array();
            $data['员工人数']['company'] = $staff_data['avg_num'];
            $data['管理岗']['company']   = $position_data['M']['avg_num'];
            $data['业务岗']['company']   = $position_data['S']['avg_num'];
            $data['研发岗']['company']   = $position_data['P']['avg_num'];
            $data['专业岗']['company']   = $position_data['T']['avg_num'];
            $data['其他岗位']['company'] = $position_data['other']['num'];
            $data['年终奖']['company']   = $position_data['yearEndBonus']['avg_num'];
            $data['业务提成']['company'] = $position_data['percentage']['avg_num'];
            $data['奖金包']['company']   = $position_data['award']['avg_num'];
            $data['无奖金']['company']   = $position_data['noAward']['avg_num'];

            return $data;
        }

        //员工人数
        public function get_staff_data($months){
            $month_num                  = count($months);
            $where                      = array();
            $where['s.datetime']        = array('in',$months);
            $where['s.status']          = 4;
            $where['s.user_name']       = array('notlike','%1');
            $field                      = 's.id,s.account_id,s.user_name,s.department,s.datetime,s.post_name,s.total,a.position_id,p.position_name,p.code,b.foreign_bonus,b.annual_bonus';
            $lists                      = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->join('__POSITION__ as p on p.id=a.position_id','left')->join('__SALARY_BONUS__ as b on b.id=s.bonus_id','left')->where($where)->field($field)->select();
            $data                       = array();
            $data['avg_num']            = round(count($lists)/$month_num,2);
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
                if (intval($v['annual_bonus']) != 0){ //年终奖
                    $yearEndBonus[]     = $v;
                    $yearEndBonusMonth[]= $v['datetime'];
                    $yearEndBonusNum++;
                }elseif (intval($v['foreign_bonus']) != 0){ //奖金包
                    $award[]            = $v;
                    $awardMonth[]       = $v['datetime'];
                    $awardNum++;
                }elseif (intval($v['total']) != 0){ //业绩提成
                    $percentage[]       = $v;
                    $percentageMonth[]  = $v['datetime'];
                    $percentageNum++;
                }else{ //无奖金
                    $noAward[]          = $v;
                    $noAwardMonth[]     = $v['datetime'];
                    $noAwardNum++;
                }
            }

            $yearEndBonusMonthNum       = count(array_filter(array_unique($yearEndBonusMonth)));
            $awardMonthNum              = count(array_filter(array_unique($awardMonth)));
            $percentageMonthNum         = count(array_filter(array_unique($percentageMonth)));
            $noAwardMonthNum            = count(array_filter(array_unique($noAwardMonth)));

            $M['avg_num']               = round($M['num']/$month_num,2); //月平均人数
            $S['avg_num']               = round($S['num']/$month_num,2);
            $T['avg_num']               = round($T['num']/$month_num,2);
            $P['avg_num']               = round($P['num']/$month_num,2);
            $other['avg_num']           = round($other['num']/$month_num,2);
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


