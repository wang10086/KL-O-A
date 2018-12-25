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
     * $year 年 $month 月
     * F 京区业务中心 G 京外业务中心 L 南京项目部
     * M 武汉项目部 N 沈阳项目部 P 长春项目部 B 市场部
     */
    public function Manage_month(){
        $year                   = trim(I('year',date('Y')));
        $post                   = trim(I('post'));
        $month                  = trim(I('month',date('m')));
        $mod                    = D('Manage');

        $year1                  = $mod->manageyear($year,$post);//判断加减年
        $ymd                    = $mod->year_month_day($year1,$month);//月度其他费用判断取出数据日期
        $mon                    = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
        $department             = $mod->department_data($mon);//月度其他费用部门数据

        $number                 = $mod->month($year1,$month);// 月度 部门数量 部门人力资源成本
        $money                  = $this->business($year1,$month,1);// 月度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $profit                 = $mod->profit($money);//月度 收入 毛利 毛利率
        $human                  = $mod->human_affairs($number,$profit['profit'],$profit['departmen']);//月度 人事费用率
        $total_profit           = $mod->total_profit($number,$profit['profit'],$profit['departmen'],$department);//月度 利润总额

        $this->department       = $department;//其他费用部门数据
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
    public function  business($year,$month,$type){
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                       = $year.$month;
        $yw_departs                  = C('YW_DEPARTS');  //业务部门id
        $where                       = array();
        $where['id']                 = array('in',$yw_departs);
        $departments                 = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas                   = $this->count_lists($departments,$year,$month,$type);//1 结算 0预算
        return $listdatas;die;
    }

    /**
     * manage_quarter 季度经营报表
     * $year 年 $quart月
     * $post 2 加  1 减年
     */
    public function Manage_quarter(){
        $year                   = (int)trim(I('year',date('Y')));//年
        $post                   = (int)trim(I('post'));//加减年
        $quart                  = (int)trim(I('quart',date('m')));//季度
        $mod                    = D('Manage');
        // 季度经营报表
        $year1                  = $mod->manageyear($year,$post);//判断加减年
        $quarter                = $mod->quarter($year1,$quart);// 季度人数 和人力资源成本
        $profits                = $this->profit_r($year1,$quart,1);//月份循环季度数据 利润

//        print_r($profits);die;
        $manage_quarter         = $mod->manage_quarter($quarter,$profits);//季度利润总额
        $personnel_costs        = $mod->personnel_costs($quarter,$profits);//人事费用率
        // 季度预算报表
        $datetime['year']       = $year1;
        $datetime['type']       = $mod->quarter_month1($quart);//获取季度预算
        $manage                 = $mod->Manage_display($datetime,2);//季度预算
        $this->manage           = $manage;//季度预算
        // 季度经营报表
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
     * $type 1 结算 0 预算
     */
    public function profit_r($year1,$quart,$type){
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
                if($month<10){$month = '0'.$month;}
                $ymd                                = $mod->year_month_day($year1,$month);//月度其他费用判断取出数据日期
                $mon                                = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
                $department                         = $mod->department_data($mon);//月度其他费用部门数据
                foreach($department as $key =>$val){
                    $month_r[$key]['money']        += $val['money'];//季度其他费用
                }
//                print_r($ymd);
                $count                              = $this->business($year1,$month,$type); //季度 人数和 人力资源成本
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
            ksort($month_r);return $month_r;
        }else{
            for($n = 2;$n > $i;$i++){
                $month                              = $quart-$i;
               if($month==3 || $month==6 || $month==9 || $month==12) {
                   foreach($month_r as $key =>$val){
                       unset($month_r[$key]['monthmll']);
                       $maoli                       = $val['monthzml']/$val['monthzsr'];
                       $month_r[$key]['monthmll']   = round($maoli*100,2);
                   }
                   ksort($month_r);return $month_r;
               }else{
                    $count                           = $this->business($year1,$month,1); //季度 人数和 人力资源成本
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
                   $ymd                              = $mod->year_month_day($year1,$month);//月度其他费用判断取出数据日期
                   $mon                              = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
                   $department                       = $mod->department_data($mon);//月度其他费用部门数据
                   foreach($department as $key =>$val){
                       $month_r[$key]['money']      += $val['money'];//季度其他费用
                   }
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
        $year               = trim(I('year'));
        $post               = trim(I('post'));
        $mod                = D('Manage');
        $month              = date('m');
        //年度经营报表
        $year1              = $mod->manageyear($year,$post);//判断加减年
        $yea_report         = $mod->yea_report($year1,$post);//年人员数量  年人员人力资源成本
        $money              = $this->business($year1,$month,1);//年 monthzsr 收入合计 monthzml 毛利合计 monthmll 毛利率
        $profit             = $mod->profit_w($money);//年 收入 毛利 毛利率
        // 其他费用
        $ymd                = $mod->yearmonthday($year1);//年度其他费用判断取出数据日期
        $mon                = $this->not_team($ymd[0],$ymd[1]);//年度其他费用取出数据
        $department         = $mod->department_data($mon);//年度其他费用部门数据
        $count_profit       = $mod->count_profit($yea_report,$profit,$department);//年利润总额 年人事费用

        //年度预算报表
        $where['year']      = $year1;
        $where['type']      = 5;
        $manage             = $mod->Manage_display($where,1);
        $this->manage       = $manage;//年度预算
        //年度经营报表
        $this->department       = $department;//年度其他费用部门数据
        $this->count_profit = $count_profit;//年人员人力资源成本 收入 毛利 毛利率
        $this->profit       = $profit;//收入 毛利 毛利率
        $this->year         = $year1;//加减后年
        $this->yea_report   = $yea_report;//年人员数量  年人员人力资源成本
        $this->post         = $post;
        $this->display();
    }

    /**
     * Manage_input 年数据显示
     */
    public function Manage_input(){
        $mod                = D('Manage');
        $date_Y['year']     = (int)date('Y');
        $date_Y['type']     = 5;
        $datetime           = $mod->quarter_year($date_Y);//获取年度预算
        $manage             = $mod->Manage_display($datetime);
        $type               = $mod->Manage_type(2,5);//年度提交状态
        $this->type         = $type;//年度提交状态
        $this->manage       = $manage;
        $this->display();
    }

    /**
     * Manage_input 年数据录入与修改
     * $mod->quarter_month 自动获取年
     */
    public function Manage_year_w(){
        $mod                            = D('Manage');
        $date_Y['year']                 = (int)date('Y');
        $datetime                       = $mod->quarter_year($date_Y);//获取年度预算时间
        $datetime['type']               = 5;
        $statu                          = $mod->manage_input_statu('manage_input',$datetime);
        if($statu==1){
            $this->success('数据更新成功!',U('Manage/Manage_input'));die;
        }elseif($statu==2){
            $this->error('数据更新失败!',U('Manage/Manage_input'));die;
        }elseif($statu==3){
            $this->error('数据已存在！当前不支持更改！',U('Manage/Manage_input'));die;
        }
    }

    /**
     * Manage_input 季度数据显示
     * $mod->quarter_month 自动获取季度
     */
    public function Manage_quarter_w(){
        $mod                = D('Manage');
        $date_Y['year']     = date('Y');
        $datetime           = $mod->quarter_month($date_Y);//获取季度预算
        $manage             = $mod->Manage_display($datetime);//季度数据
        $type               = $mod->Manage_type(1);//季度提交状态
        $this->manage       = $manage;
        $this->type         = $type;//季度提交状态
        $this->display();
    }

    /**
     * Manage_input 季度数据录入与修改
     * $mod->quarter_month 自动获取季度
     */
    public function Manage_save(){
        $mod                            = D('Manage');
        $date_Y['year']                 = date('Y');
        $datetime                       = $mod->quarter_month($date_Y);//获取季度预算
        $statu                          = $mod->manage_input_statu('manage_input',$datetime);
        if($statu==1){
            $this->success('数据更新成功!',U('Manage/Manage_quarter_w'));die;
        }elseif($statu==2){
            $this->error('数据更新失败!',U('Manage/Manage_quarter_w'));die;
        }elseif($statu==3){
            $this->error('数据已存在！当前不支持更改！',U('Manage/Manage_quarter_w'));die;
        }
    }

    /**
     * quarter_submit 季度提交审批
     * status 1 提交审批
     */
    public function quarter_submit(){
        if(trim($_POST['status']) == 1){
            $mod    = D('Manage');
            $manage = $mod->quarter_submit1();//季度提交审核
        }else{
            $manage = 3;
        }
        if($manage==1){
            $this->success('数据提交成功!');
        }elseif($manage==2){
            $this->success('数据提交成功!');
        }elseif($manage==3){
            $this->error('数据提交失败!');
        }
    }
    /**
     * quarter_paprova 季度提交批准
     * $m 路径比对
     * $status 2 提交批准 $type 1 驳回
     */
//    public function quarter_paprova(){
//        $m              = trim($_GET['m']);
//        $status         = trim($_GET['status']);
//        $type           = trim($_GET['type']);
//        $mod            = D('Manage');
//        if($m=='Main' && is_numeric($status) && $status==2){
//        }elseif($m=='Main' && is_numeric($type) && $type==1){
//        }else{$this->error('数据提交失败!');die;}
//        $manage         = $mod->quarter_paprova1($status,$type,2,3);//季度提交审
//        if(strpos($manage,'成功') !==false){$this->success($manage);}else{$this->error($manage);}
//    }
    /**
     * quarter_approve 季度批准
     * $status 3 批准 $type 1 驳回
     */
    public function quarter_approve(){
        $m              = trim($_GET['m']);
        $status         = trim($_GET['status']);
        $type           = trim($_GET['type']);
        $mod            = D('Manage');
        if($m=='Main' && is_numeric($status) && $status==3){
        }elseif($m=='Main' && is_numeric($type) && $type==1){
        }else{$this->error('数据提交失败!');die;}
        $manage         = $mod->quarter_paprova1($status,$type,3,4);//季度提交审
        if(strpos($manage,'成功') !==false){$this->success($manage);}else{$this->error($manage);}
    }
    /**
     * year_submit 年度提交审批
     * status 1 提交审批
     */
    public function year_submit(){
        if(trim($_POST['status']) == 1){
            $mod    = D('Manage');
            $manage = $mod->year_submit1();//年度提交审核
        }else{
            $manage = 3;
        }
        if($manage==1){
            $this->success('数据提交成功!');
        }elseif($manage==2){
            $this->success('数据提交成功!');
        }elseif($manage==3){
            $this->error('数据提交失败!');
        }elseif($manage==4){
            $this->error('部门数据不完整！!');
        }
    }
    /**
     * year_paprova 年度提交批准
     * $status 2 提交批准 $type 1 驳回
     * 当出现部门->财务->总经办 可用
     */
//    public function year_paprova(){
//        $m              = trim($_GET['m']);
//        $status         = trim($_GET['status']);
//        $type           = trim($_GET['type']);
//        $mod            = D('Manage');
//        if($m=='Main' && is_numeric($status) && $status==2){
//        }elseif($m=='Main' && is_numeric($type) && $type==1){
//        }else{$this->error('数据提交失败!');die;}
//        $manage         = $mod->year_paprova1($status,$type,2,3);//年度提批准
//        if(strpos($manage,'成功') !==false){$this->success($manage);}else{$this->error($manage);}
//    }
    /**
     * year_approve 年度批准
     * $status 3 批准 $type 1 驳回
     */
    public function year_approve(){
        $m              = trim($_GET['m']);
        $status         = trim($_GET['status']);
        $type           = trim($_GET['type']);
        $mod            = D('Manage');
        if($m=='Main' && is_numeric($status) && $status==3){
        }elseif($m=='Main' && is_numeric($type) && $type==1){
        }else{$this->error('数据提交失败!');die;}
        $manage         = $mod->year_paprova1($status,$type,3,4);//季度提交审
        if(strpos($manage,'成功') !==false){$this->success($manage);}else{$this->error($manage);}
    }

 }
