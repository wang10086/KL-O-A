<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ManageController extends ChartController {
    /**
     * Manage_month 月度经营报表
     * $post 1 上一年 2 下一年
     * F 京区业务中心 G 京外业务中心 L 南京项目部
     * M 武汉项目部 N 沈阳项目部 P 长春项目部 B 市场部
     */
    public function Manage_month(){
        $year                   = trim(I('year',date('Y')));
        $post                   = trim(I('post'));
        $month                  = trim(I('month',date('m')));
        $mod                    = D('Manage');
        //年月变化
        $year1                  = $mod->manageyear($year,$post);//判断加减年
        //月度统计人员 数额 占比
        $number                 = $mod->month($year1,$month);// 部门数量 部门人力资源成本
        $money                  = $this->business($year1,$month);//monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $profit                 = $mod->profit($money);//收入 毛利 毛利率
        $human                  = $mod->human_affairs($number,$profit['profit'],$profit['departmen']);//人事费用率
        $total_profit           = $mod->total_profit($number,$profit['profit'],$profit['departmen']);//利润总额

        $this->total_profit     = $total_profit;//利润总额(未减去其他费用)
        $this->human_affairs    = $human;//人事费用率
        $this->profit           = $profit['departmen'];//部门 收入 毛利 毛利率
        $this->company          = $profit['profit'];//总数 收入 毛利 毛利率
        $this->number           = $number;// 部门数量 部门人力资源成本
        $this->year             = $year1;//年
        $this->post             = $post;//加减年
        $this->month            = $month;//月
        $this->display();
    }

    /**
     * business 营业收入 营业毛利 营业毛利率
     * $year 年 $month月
     * $pin 1 结算 0预算
     */
    public function  business($year,$month){

        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                       = $year.$month;
        $yw_departs                  = C('YW_DEPARTS');  //业务部门id
        $where                       = array();
        $where['id']                 = array('in',$yw_departs);
        $departments                 = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas                   = $this->count_lists($departments,$year,$month,1);//1 结算 0预算
        return $listdatas;die;
    }

    /**
     * manage_quarter 季度经营报表
     * $year 年 $quart月
     * $post 2 加  1 减年
     */
    public function manage_quarter(){
        $year                   = trim(I('year',date('Y')));//年
        $post                   = trim(I('post'));//加减年
        $quart                  = trim(I('quart',date('m')));//季度
        $mod                    = D('Manage');
        $year1                  = $mod->manageyear($year,$post);//判断加减年
        $quarter                = $mod->quarter($year1,$quart);// 季度人数 和人力资源成本
        $profits                = $this->profit_r($year1,$quart);//月份循环季度数据 利润
        $manage_quarter         = $mod->manage_quarter($quarter,$profits);//季度利润总额
        $personnel_costs        = $mod->personnel_costs($quarter,$profits);//人事费用率

        $this->personnel_costs  = $personnel_costs;//人事费用率
        $this->manage_quarter   = $manage_quarter;// 季度利润总额
        $this->profit           = $profits;// 收入 毛利 毛利率
        $this->quarter          = $quarter;// 季度人数 和人力资源成本
        $this->year             = $year1;//年
        $this->post             = $post;
        $this->quart            = $quart;
        $this->display();
    }

    /**
     * profit_r 月份循环季度数据
     * $quarter  人数 人力资源成本
     * $profits 季度数据 总收入 总毛利 总利率
     */
    public function profit_r($year1,$quart){
        $mod                                        = D('Manage');
        $arr1                                       = array('3','6','9','12');
        $i                                          = 0; //现在季度月 减一
        $company                                    = array(); //季度内数据总和
        $month_r                                    = array();
        $month_r[9]['monthzsr']                     = 0.00;//机关部门营业总收入为默认0
        $month_r[9]['monthzml']                     = 0.00;//机关部门营业总毛利为默认0
        $month_r[9]['monthmll']                     = 0.00;//机关部门营业总利率为默认0
        if(in_array($quart,$arr1)){ //判断是否是第一、二、三、四季度
            for($n = 2; $n >= $i;$i++){ //
                $month                              = $quart-$i; //季度上一个月
                $count                              = $this->business($year1,$month); //季度 人数和 人力资源成本
                $profit                             = $mod->profit($count);//收入 毛利 毛利率
                foreach($profit['departmen'] as $key => $val){
                    $month_r[$key]['monthzsr']      += $val['department']['monthzsr'];
                    $month_r[$key]['monthzml']      += $val['department']['monthzml'];
                    $month_r[$key]['monthmll']      += $val['department']['monthmll'];
                }
                $month_r[0]['monthzsr']             += $profit['profit']['monthzsr'];
                $month_r[0]['monthzml']             += $profit['profit']['monthzml'];
                $month_r[0]['monthmll']             += $profit['profit']['monthmll'];
            }
            foreach($month_r as $key =>$val){
                unset($month_r[$key]['monthmll']);
                $maoli                              = $val['monthzml']/$val['monthzsr'];
                $month_r[$key]['monthmll']          = round(($maoli*100),2);
            }
            ksort($month_r);
            return $month_r;
        }else{
            for($n = 2;$n > $i;$i++){
                $month                              = $quart-$i;
               if($month==3 || $month==6 || $month==9 || $month==12) {
                   foreach($month_r as $key =>$val){
                       unset($month_r[$key]['monthmll']);
                       $maoli                       = $val['monthzml']/$val['monthzsr'];
                       $month_r[$key]['monthmll']   = round($maoli*100,2);
                   }
                   ksort($month_r);
                   return $month_r;
               }else{
                    $count                           = $this->business($year1,$month); //季度 人数和 人力资源成本
                    $profit                          = $mod->profit($count);//收入 毛利 毛利率
                    $month_r = array();
                    foreach($profit['departmen'] as $key => $val){
                        $month_r[$key]['monthzsr']  += $val['department']['monthzsr'];
                        $month_r[$key]['monthzml']  += $val['department']['monthzml'];
                        $month_r[$key]['monthmll']  += $val['department']['monthmll'];
                        $sum                         = $key;
                    }
                    $month_r[0]['monthzsr']         += $profit['profit']['monthzsr'];
                    $month_r[0]['monthzml']         += $profit['profit']['monthzml'];
                    $month_r[0]['monthmll']         += $profit['profit']['monthmll'];
                }
            }
        }
    }

    /**
     * Manage_year 年度经营报表
     * $year 年 $quart月
     * $post 2 加  1 减年
     */
    public function Manage_year(){
        $year       = trim(I('year',date('Y')));
        $post       = trim(I('post'));
        $mod        = D('Manage');
        $yea_report =$mod->yea_report($year,$post);

        $this->post = $post;
        $this->display();
    }

 }
