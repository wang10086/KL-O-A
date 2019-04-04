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
        $month                  = intval(I('month',date('m')));
        $mod                    = D('Manage');
        $times                  = $mod->get_times($year,$month,'m');    //获取考核周期开始及结束时间戳

        $ymd                    = $mod->year_month_day($year,$month);//月度其他费用判断取出数据日期
        $mon                    = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据(不分摊)
        $mon_share              = $this->not_team_share($ymd[0],$ymd[1]);//月度其他费用取出数据(分摊)
        $department             = $mod->department_data($mon,$mon_share);//月度其他费用部门数据

        $number                 = $mod->get_number($year,$month);   //月度 部门人数
        $hr_cost                = $mod->month($year,$month,$times);// 月度 部门人力资源成本
        $money                  = $this->business($year,$month,1);// 月度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $profit                 = $mod->profit($money);//月度 收入 毛利 毛利率

        $human_affairs          = $mod->human_affairs($hr_cost,$profit);//月度 人事费用率
        $total_profit           = $mod->total_profit($profit,$hr_cost,$department);//月度 利润总额

        $this->department       = $department;//其他费用部门数据
        $this->total_profit     = $total_profit;//利润总额(未减去其他费用)
        $this->human_affairs    = $human_affairs;//人事费用率
        $this->profit           = $profit;//部门 收入 毛利 毛利率
        $this->number           = $number;  // 部门数量
        $this->hr_cost          = $hr_cost; // 部门人力资源成本
        $this->year             = $year;//年
        $this->month            = $month;//月
        $this->display();
    }

    /**
     * not_team 非团支出报销（其他费用）(不分摊)
     * $ymd1 开始时间 20180626
     * $ymd2 结束时间 20180726
     */
    /*public function not_team($ymd1,$ymd2){

        $ymd1                   =  strtotime($ymd1);
        $ymd2                   =  strtotime($ymd2);
        $map['bx_time']         = array(array('gt',$ymd1),array('lt',$ymd2));//开始结束时间
        $map['bxd_type']        = array(array('gt',1),array('lt',4));//2 非团借款报销 3直接报销
        $map['audit_status']    = array('eq',1);//审核通过
        $money                  = M('baoxiao')->where($map)->select();//日期内所有数据
        return  $money;
    }*/
    public function not_team($ymd1,$ymd2){

        $ymd1                   =  strtotime($ymd1);
        $ymd2                   =  strtotime($ymd2);
        $map['bx_time']         = array('between',"$ymd1,$ymd2");//开始结束时间
        $map['bxd_type']        = array('in',array(2,3));//2 非团借款报销 3直接报销
        $map['audit_status']    = array('eq',1);    //审核通过
        $map['share']           = array('neq',1);   //不分摊
        $otherExpensesKinds     = M('bxd_kind')->where(array('pid'=>2))->getField('id',true);
        $map['bxd_kind']        = array('in',$otherExpensesKinds);
        $money                  = M('baoxiao')->where($map)->select();//日期内所有数据
        return  $money;
    }

    /**
     * 非团支出报销(其他费用)(分摊)
     * @param $ymd1
     * @param $ymd2
     * @return mixed
     */
    public function not_team_share($ymd1,$ymd2){

        $ymd1                       =  strtotime($ymd1);
        $ymd2                       =  strtotime($ymd2);
        $where                      = array();
        $where['b.bx_time']         = array('between',"$ymd1,$ymd2");//开始结束时间
        $where['b.bxd_type']        = array('in',array(2,3));//2 非团借款报销 3直接报销
        $where['b.audit_status']    = array('eq',1);    //审核通过
        $otherExpensesKinds         = M('bxd_kind')->where(array('pid'=>2))->getField('id',true);
        $where['b.bxd_kind']        = array('in',$otherExpensesKinds);
        $money                      = M()->table('__BAOXIAO_SHARE__ as s')->field('b.bxd_kind,s.*')->join('__BAOXIAO__ as b on b.id=s.bx_id','left')->where($where)->select();
        return  $money;
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

    /**  monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
     * @param $year
     * @param $yms
     */
    public function get_business($year,$yms){
        $info                   = array();
        foreach ($yms as $v){
            $month              = substr($v,4,2);
            $info[]             = $this->business($year,$month,1);
        }

        $sum                    = array();
        foreach ($info as $key=>$value){
            foreach ($value as $k=>$v){
                if ($k == 'heji') $v['depname']     = '公司';
                if ($k == 'dj_heji') $v['depname']  = '地接合计';
                $sum[$v['depname']]['monthzsr']     += $v['monthzsr'];
                $sum[$v['depname']]['monthzml']     += $v['monthzml'];
                $sum[$v['depname']]['monthmll']     = round($sum[$v['depname']]['monthzml']/$sum[$v['depname']]['monthzsr'],4)*100;
            }
        }
        return $sum;
    }

    /**
     * manage_quarter 季度经营报表
     * $year 年 $quart月
     * $post 2 加  1 减年
     */
    public function Manage_quarter(){
        $year                   = (int)trim(I('year',date('Y')));//年
        $quart                  = trim(I('quart',date('m')));//季度
        $mod                    = D('Manage');
        // 季度经营报表
        $quart                  = quarter_month1($quart);//获取季度月份

        // 季度预算报表
        $datetime['year']       = $year;
        $datetime['type']       = $quart;//获取季度预算
        $manage                 = $mod->Manage_display($datetime,2);//季度预算

        $times                  = getQuarterlyCicle($year,$quart);  //获取季度周期
        $ymd[0]                 = date("Ymd",$times['begin_time']);
        $ymd[1]                 = date("Ymd",$times['end_time']);
        $mon                    = $this->not_team($ymd[0],$ymd[1]);//季度其他费用取出数据(不分摊)
        $mon_share              = $this->not_team_share($ymd[0],$ymd[1]);//季度其他费用取出数据(分摊)
        $department             = $mod->department_data($mon,$mon_share);//季度其他费用部门数据

        $yms                    = $mod->get_yms($year,$quart,'q');  //获取费季度包含的全部月份
        $times                  = $mod->get_times($year,$quart,'q');    //获取考核周期开始及结束时间戳
        $number                 = $mod->get_numbers($year,$yms);    //季度平均人数
        $hr_cost                = $mod->get_quarter_hr_cost($year,$yms,$times);// 季度部门人力资源成本
        $profit                 = $this->get_business($year,$yms);// 季度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $human_affairs          = $mod->human_affairs($hr_cost,$profit);//季度 人事费用率
        $total_profit           = $mod->total_profit($profit,$hr_cost,$department);//季度 利润总额

        $this->manage           = $manage;//季度预算
        // 季度经营报表
        $this->number           = $number;  // 部门数量
        $this->hr_cost          = $hr_cost; // 部门人力资源成本
        $this->profit           = $profit;  // 收入 毛利 毛利率
        $this->department       = $department;  //季度其他费用
        $this->human_affairs    = $human_affairs;   //季度人事费用率
        $this->total_profit     = $total_profit;    //季度利润总额
        $this->year             = $year;//年
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
        //机关部门营业总收入、毛利、总利率 为默认0.00
        $month_r[9]['monthzsr']                     = 0.00;//机关部门营业总收入为默认0
        $month_r[9]['monthzml']                     = 0.00;//机关部门营业总毛利为默认0
        $month_r[9]['monthmll']                     = 0.00;//机关部门营业总利率为默认0
        if(in_array($quart,$arr1)){ //判断是否是第一、二、三、四季度
            for($n = 2; $n >= $i;$i++){ //
                $month                              = $quart-$i; //季度上一个月
                $ymd                                = $mod->year_month_day($year1,$month);//月度其他费用判断取出数据日期
                $mon                                = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
                $mon_share                          = $this->not_team_share($ymd[0],$ymd[1]);//月度其他费用取出数据(分摊w)
                $department                         = $mod->department_data($mon,$mon_share);//月度其他费用部门数据
                foreach($department as $key =>$val){
                    $month_r[$key]['money']        += $val['money'];//季度其他费用
                }
                $count                              = $this->business($year1,$month,$type); //季度 人数和 人力资源成本
                $profit                             = $mod->profit($count);//收入 毛利 毛利率
                foreach($profit['departmen'] as $key => $val){ //获取 chart 控制器的 收入 毛利 毛利率
                    $month_r[$key]['monthzsr']     += $val['department']['monthzsr'];
                    $month_r[$key]['monthzml']     += $val['department']['monthzml'];
                    $month_r[$key]['monthmll']     += $val['department']['monthmll'];
                }
                $month_r[0]['monthzsr']            += $profit['profit']['monthzsr'];//所有的数据相加 公司收入
                $month_r[0]['monthzml']            += $profit['profit']['monthzml'];//所有的数据相加 公司毛利
                $month_r[0]['monthmll']            += $profit['profit']['monthmll'];//所有的数据相加 公司毛利率
            }
            foreach($month_r as $key =>$val){
                unset($month_r[$key]['monthmll']);
                $maoli                              = $val['monthzml']/$val['monthzsr'];
                $month_r[$key]['monthmll']          = round(($maoli*100),2);
            }
            ksort($month_r);return $month_r;
        }else{ //如果季度 不是整季度 例如：7月 8月
            for($n = 2;$n > $i;$i++){//循环两次
                $month                              = $quart-$i;//月份循环减一
               if($month==3 || $month==6 || $month==9 || $month==12) {//循环到某一季度 执行
                   foreach($month_r as $key =>$val){
                       unset($month_r[$key]['monthmll']);
                       $maoli                       = $val['monthzml']/$val['monthzsr'];
                       $month_r[$key]['monthmll']   = round($maoli*100,2);
                   }
                   ksort($month_r);return $month_r;
               }else{
                    $count                           = $this->business($year1,$month,1); //季度 人数和 人力资源成本
                    $profit                          = $mod->profit($count);//收入 毛利 毛利率
                    $month_r                         = array();
                    foreach($profit['departmen'] as $key => $val){ //获取 chart 控制器的 收入 毛利 毛利率
                        $month_r[$key]['monthzsr']  += $val['department']['monthzsr'];
                        $month_r[$key]['monthzml']  += $val['department']['monthzml'];
                        $month_r[$key]['monthmll']  += $val['department']['monthmll'];
                        $sum                         = $key;
                    }
                   //所有的数据相加 公司收入、毛利、毛利率
                    $month_r[0]['monthzsr']         += $profit['profit']['monthzsr'];
                    $month_r[0]['monthzml']         += $profit['profit']['monthzml'];
                    $month_r[0]['monthmll']         += $profit['profit']['monthmll'];
                   $ymd                              = $mod->year_month_day($year1,$month);//月度其他费用判断取出数据日期
                   $mon                              = $this->not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
                   $mon_share                        = $this->not_team_share($ymd[0],$ymd[1]);//月度其他费用取出数据(分摊w)
                   $department                       = $mod->department_data($mon,$mon_share);//月度其他费用部门数据
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
        $year                   = I('year')?trim(I('year')):date('Y');
        $post                   = trim(I('post'));
        $mod                    = D('Manage');
        $month                  = date('m');

        //年度预算报表
        $where['year']          = $year;
        $where['type']          = 5;
        $manage                 = $mod->Manage_display($where,1);

        // 其他费用
        $ymd                    = $mod->yearmonthday($year,$month);//年度其他费用判断取出数据日期
        $mon                    = $this->not_team($ymd[0],$ymd[1]);//年度其他费用取出数据
        $mon_share              = $this->not_team_share($ymd[0],$ymd[1]);//月度其他费用取出数据(分摊w)
        $department             = $mod->department_data($mon,$mon_share);//年度其他费用部门数据

        //年度经营报表
        $yms                    = $mod->get_yms($year,$month,'y');  //获取年度包含的所有月份信息
        $times                  = $mod->get_times($year,$month,'y');    //获取考核周期开始及结束时间戳
        $number                 = $mod->get_numbers($year,$yms);    //季度平均人数
        $hr_cost                = $mod->get_quarter_hr_cost($year,$yms,$times);// 季度部门人力资源成本
        $profit                 = $this->get_business($year,$yms);// 季度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $human_affairs          = $mod->human_affairs($hr_cost,$profit);//年度 人事费用率
        $total_profit           = $mod->total_profit($profit,$hr_cost,$department);//年度 利润总额

        $this->manage           = $manage;//年度预算
        $this->number           = $number;  // 部门数量
        $this->hr_cost          = $hr_cost; // 部门人力资源成本
        $this->profit           = $profit;  // 收入 毛利 毛利率
        $this->department       = $department;  //季度其他费用
        $this->human_affairs    = $human_affairs;   //季度人事费用率
        $this->total_profit     = $total_profit;    //季度利润总额
        $this->year             = $year;//年
        $this->post             = $post;
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
        $this->datetime     = $datetime;//当前年
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
        $this->datetime     = $datetime;//当前年和季度
        $this->type         = $type;//季度提交状态
        $this->display();
    }

    /**
     * Manage_input 季度数据录入与修改
     * $mod->quarter_month 自动获取季度
     */
    public function Manage_save(){
        $mod               = D('Manage');
        $date_Y['year']    = date('Y');
        $datetime          = $mod->quarter_month($date_Y);//获取季度预算
        $statu             = $mod->manage_input_statu('manage_input',$datetime);
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
        $m                  = trim($_GET['m']);
        $status             = trim($_GET['status']);
        $type               = trim($_GET['type']);
        $mod                = D('Manage');
        if($m=='Main' && is_numeric($status) && $status==3){
        }elseif($m=='Main' && is_numeric($type) && $type==1){
        }else{$this->error('数据提交失败!');die;}
        $manage             = $mod->quarter_paprova1($status,$type,3,4);//季度提交审
        if(strpos($manage,'成功') !==false){$this->success($manage);}else{$this->error($manage);}
    }
    /**
     * year_submit 年度提交审批
     * status 1 提交审批
     */
    public function year_submit(){
        if(trim($_POST['status']) == 1){
            $mod        = D('Manage');
            $manage     = $mod->year_submit1();//年度提交审核
        }else{
            $manage     = 3;
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


    /**
     * 其他费用
     * $tm: m=>月度, q=>季度, y=>年度
     */
    public function otherExpenses(){
        $year		            = I('year',date('Y'));
        $month		            = I('month',date('m'));
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $quarter                = I('quarter')?I('quarter'):get_quarter($month);
        $tm                     = I('tm')?I('tm'):'m';
        $bxd_kinds              = M('bxd_kind')->where(array('pid'=>2))->getField('id,name',true);
        $kind_ids               = array_keys($bxd_kinds);
        $departments            = C('department1');
        $mod                    = D('Manage');
        $times                  = $mod->get_times($year,$month,$tm);
        $lists                  = $mod->get_otherExpenses($departments,$kind_ids,$times);
        $heji                   = $lists['heji'];
        unset($lists['heji']);

        $this->lists            = $lists;
        $this->heji             = $heji;
        $this->departments      = $departments;
        $this->kinds            = $bxd_kinds;
        $this->tm               = $tm;
        $this->year 	        = $year;
        $this->month 	        = $month;
        $this->prveyear	        = $year-1;
        $this->nextyear	        = $year+1;
        $this->quarter          = $quarter;
        $this->kind_ids         = $kind_ids;
        $this->display();
    }

    /**
     * 人力资源成本详情
     * $tm: m=>月度, q=>季度, y=>年度
     */
    public function HR_cost(){
        $year		            = I('year',date('Y'));
        $month		            = I('month',date('m'));
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $quarter                = I('quarter')?I('quarter'):get_quarter($month);
        $tm                     = I('tm')?I('tm'):'m';
        $hr_cost                = C('HR_COST');
        $departments            = C('department1');
        $mod                    = D('Manage');
        $times                  = $mod->get_times($year,$month,$tm);    //获取考核周期开始及结束时间戳
        $ym_arr                 = $mod->get_yms($year,$month,$tm);      //获取某个时间段内的月份信息Ym
        $data                   = array();
        $data[$hr_cost[0]]      = $mod->get_wages($ym_arr);             //工资总额
        $data[$hr_cost[1]]      = $mod->get_insurance($ym_arr);         //公司五险一金
        $data[$hr_cost[2]]      = $mod->get_welfare($times,array(21));         //职工福利
        $data[$hr_cost[3]]      = $mod->get_welfare($times,array(12));         //职工教育经费
        $data[$hr_cost[4]]      = '';         //劳动保护费用
        $data[$hr_cost[5]]      = $mod->get_welfare($times,array(19));         //工会会费
        $data[$hr_cost[6]]      = '';         //职工住房费用

        $this->data             = $data;
        $sum                    = $mod->get_sum_cost($data);          //合计
        $this->hr_cost          = $hr_cost;
        $this->sum              = $sum;
        $this->departments      = $departments;
        $this->tm               = $tm;
        $this->year 	        = $year;
        $this->month 	        = $month;
        $this->prveyear	        = $year-1;
        $this->nextyear	        = $year+1;
        $this->quarter          = $quarter;

        $this->display();
    }

 }
