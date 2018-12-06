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
        $year                   = trim(I('year'));
        $post                   = trim(I('post'));
        $month                  = trim(I('month'));
        $mod                    = D('Manage');
        //年月变化
        $year1                  = $mod->manageyear($year,$post);//判断加减年
        $month1                 = $mod->managemonth($month);
        //月度统计人员 数额 占比
        $number                 = $mod->month($year1,$month);// 部门数量 部门人力资源成本
        $money                  = $this->business($year1,$month);
//        print_r($money);die;
        $this->number           = $number;
        $this->year             = $year1;
        $this->post             = $post;
        $this->month            = $month;
        $this->display();
    }

    /**
     * business 营业收入 营业毛利 营业毛利率
     * $year 年 $month月
     * $pin 1 结算 0预算
     */
    public function  business($year,$month){
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $times          = $year.$month;
        $yw_departs     = C('YW_DEPARTS');  //业务部门id
        $where          = array();
        $where['id']    = array('in',$yw_departs);
        $departments    = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas      = $this->count_lists($departments,$year,$month,1);//1 结算 0预算
        unset($listdatas['heji']);  //注意顺序
        return $listdatas;die;

    }

    //季度经营报表
    public function Manage_quarter(){
        $year = trim(I('year'));
        $post = trim(I('post'));
        $quarter = trim(I('quarter'));
        $mod            = D('Manage');
        // 月度统计人员 数额 占比
        $number         = $mod->month();
        //年季度变化
        $year = $mod->yearmonth($year,$post);
        if($post==''){
            $post=0;
        }
        $this->year=$year;
        $this->post=$post;
        $this->quarter=$quarter;
        $this->number   = $number;
        $this->display();
    }
    //年度经营报表
    public function Manage_year(){
        $year = trim(I('year'));
        $post = trim(I('post'));
        $mod            = D('Manage');
        // 月度统计人员 数额 占
        $number         = $mod->month();
        $year = $mod->yearmonth($year,$post);
        $this->post=$post;
        $this->year=$year;
        $this->number   = $number;
        $this->display();
    }

 }
