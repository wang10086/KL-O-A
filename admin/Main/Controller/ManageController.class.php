<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class ManageController extends BaseController {

    /**
     * Manage_month 月度经营报表
     * F 京区业务中心 G 京外业务中心 L 南京项目部
     * M 武汉项目部 N 沈阳项目部 P 长春项目部 B 市场部
     */
    public function Manage_month(){
        $year                   = trim(I('year'));
        $post                   = trim(I('post'));
        $month                  = trim(I('month'));
        $mod                    = D('Manage');
        //年月变化
        $year                   = $mod->yearmonth($year,$post);
        if($post==''){
            $post               = 0;
        }
//        月度统计人员 数额 占比
        $number           = $mod->month($year,$month);
//        print_r($number);die;
        $this->year             =$year;
        $this->post             =$post;
        $this->month            =$month;
        $this->display();
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
