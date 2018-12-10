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
//print_R(number);die;
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

    //季度经营报表
    public function Manage_quarter(){
        $year                   = trim(I('year',date('Y')));//年
        $post                   = trim(I('post'));//加减年
        $quart                  = trim(I('quart',date('m')));//季度
        $mod                    = D('Manage');
        $year1                  = $mod->manageyear($year,$post);//判断加减年
        $quarter                = $mod->quarter($year1,$quart);// 季度人数 和人力资源成本
        $money                  = $this->business($year1,$quart);//monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $profit                 = $mod->profit($money);//收入 毛利 毛利率
//        print_r($profit);die;

        $this->quarter          = $quarter;// 季度人数 和人力资源成本
        $this->year             = $year1;//年
        $this->post             = $post;
        $this->quart            = $quart;
        $this->display();
    }

    /**
     *
     */
    public function profit_r(){

    }
    //年度经营报表
    public function Manage_year(){
        $year       = trim(I('year'));
        $post       = trim(I('post'));
        $mod        = D('Manage');

        $this->display();
    }

 }
