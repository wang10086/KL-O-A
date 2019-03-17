<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class WagesModel extends Model
{

    /**
     * individual_tax 个人所得税
     * $cout_money 个人金额 $userid 用户id
     */
    public function individual_tax($cout_money,$userid){
        $where['account_id']   = array('eq',$userid);
        $where['statu']        = array('neq',3);
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

        $quarter_royalty_data                   = $this->get_quarter_royalty($userinfo,$sale_configs,$op_settlement_list,$salary,$pay_month);    //销售季度目标 完成 提成
        return $quarter_royalty_data;
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
    private function get_quarter_royalty($user,$sale_configs,$op_settlement_list,$salary,$pay_month){
        $salary                                 = $salary;    //工资岗位薪酬
        foreach ($sale_configs as $k=>$v){
            if ($user['departmentid']==$v['department_id']){
                $coefficient                    = $v['coefficient'];    //季度目标系数
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
            $data['quarter_royalty'] = $royalty;     //季度提成
        }else{
            $data['quarter_royalty'] = '0.00';
        }
        return $data;
    }

}
?>