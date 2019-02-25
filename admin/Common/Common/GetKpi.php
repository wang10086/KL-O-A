<?php

    /**将上个季度的考核结果扶植到当季度
     * @param $user_id
     * @param $year
     * @param $month
     * @param $quata_id
     */
function get_prev_kpi_result($user_id,$year,$month,$quota_id){
    $monthly                = get_kpi_monthly($year,$month);
    $where                  = array();
    $where['user_id']       = $user_id;
    $where['year']          = $year;
    $where['month']         = $year.$month;
    $where['quota_id']      = $quota_id;
    $list                   = M('kpi_more')->where($where)->find();
    $complete               = $list['complete'];
    return $complete;
}

function get_kpi_monthly($year,$month){
    switch ($month){
        case in_array($month,array('01','02','03')):
            $kpi_monthly    = ($year-1).'12';
            break;
        case in_array($month,array('04','05','06')):
            $kpi_monthly    = $year.'03';
            break;
        case in_array($month,array('07','08','09')):
            $kpi_monthly    = $year.'06';
            break;
        case in_array($month,array('10','11','12')):
            $kpi_monthly    = $year.'09';
            break;
    }
    return $kpi_monthly;
}

/*
* 工单满意度(京区设计,新媒体)
* 1.员工id
* 2.本周期开始时间
* 3.本周期结束时间
* 4.考核纬度
* */
function get_worder_score($user,$start_date,$end_date,$num){
    $where                  = array();
    $where['bpfr_id']       = $user;
    $where['input_time']    = array('between',array($start_date,$end_date));
    $lists                  = M('worder_score')->field('pfr_name,worder_id,text,pic,article,habit,hot,light,bpfr_name')->where($where)->select();
    $hege_list              = array();
    foreach ($lists as $k=>$v){
        $zongfen            = 5*$num;
        $defen              = $v['text']+$v['pic']+$v['article']+$v['habit']+$v['hot']+$v['light'];
        $manyidu            = round($defen/$zongfen,2);
        if ($manyidu >0.72) $hege_list[] = $v;
    }
    $data                   = array();
    $data['lists']          = $lists;
    $data['hege_list']      = $hege_list;
    $data['pingfencishu']   = count($lists);
    $data['hegecishu']      = count($hege_list);
    $data['hegelv']         = round($data['hegecishu']/$data['pingfencishu'],2);
    return $data;
}

/*
* 工单满意度(京区设计,新媒体)
* 1.员工id
* 2.本周期开始时间
* 3.本周期结束时间
* 4.考核纬度
* 5.合格数 默认0.72 ; 1=>0.9
* */
function get_worder_sum_score($user,$start_date,$end_date,$num){
    $where                  = array();
    $where['bpfr_id']       = $user;
    $where['input_time']    = array('between',array($start_date,$end_date));
    $lists                  = M('worder_score')->field('pfr_name,worder_id,text,pic,article,habit,hot,light,bpfr_name')->where($where)->select();
    $defen                  = 0;
    foreach ($lists as $k=>$v){
        $defen              += $v['text']+$v['pic']+$v['article']+$v['habit']+$v['hot']+$v['light'];
    }

    $data                   = array();
    $data['lists']          = $lists;
    $data['pingfencishu']   = count($lists);
    $data['zongfen']        = $data['pingfencishu']*$num*5;
    $data['zongdefen']      = $defen;
    $data['defenlv']        = round($data['zongdefen']/$data['zongfen'],2);
    return $data;
}

/*
 * 客户满意度
 * 1.开始时间
 * 2.结束时间
 * 3.活动类型
 * 4.字段
 * 5.字段数量
 * */
function get_kfmyd($start_date,$end_date,$kinds='',$field='',$num=1){
    $where                  = array();
    if ($kinds){ $where['o.kind']  = array('in',$kinds); };
    if ($field == 'new_media'){$where['s.new_media'] = array('neq',0); }
    $where['s.input_time']	= array('between',array($start_date,$end_date));
    $lists = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.id as sid,s.before_sell,s.new_media')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();
    $hege_list              = array();
    foreach ($lists as $k=>$v){
        $zongfen            = $num*5;
        $defen              = $v[''.$field.''];
        if (round($defen/$zongfen,2) >= 0.8){
            $hege_list[]    = $v;
        }
    }
    $hegecishu              = count($hege_list);
    $pingfencishu           = count($lists);
    $data                   = array();
    $data['lists']          = $lists;
    $data['hege_list']      = $hege_list;
    $data['pingfencishu']   = $pingfencishu;
    $data['hegecishu']      = $hegecishu;
    $data['hegelv']         = round($hegecishu/$pingfencishu,2);
    return $data;
}

//合格供方转化率(计调)
 function jd_zhuanhualv($user,$start_date,$end_date){
     //考核三个月前新增资源数量
     $where                 = array();
     $where['input_time']	= array('between',array($start_date-(120*24*3600),$end_date-(120*24*3600)));
     $where['audit_status'] = 1;    //审核通过
     $where['input_uid']    = $user;
     $xinzengziyuan         = M('supplier')->field('id,name')->where($where)->select();
     $xinzengziyuan_ids     = array_column($xinzengziyuan,'id');
     $xinzengshu            = count($xinzengziyuan);

     //已转化资源数量
     $where                 = array();
     $where['supplier_id']  = array('in',$xinzengziyuan_ids);
     $field                 = ('op_id,supplier_id,supplier_name');
     $zhuanhuaziyuan        = M('op_supplier')->field($field)->group('supplier_id')->where($where)->select();
     $zhuanhuashu           = count($zhuanhuaziyuan);

     $data                  = array();
     $data['xinzengziyuan'] = $xinzengziyuan;
     $data['zhuanhuaziyuan']= $zhuanhuaziyuan;
     $data['xinzengshu']    = $xinzengshu;
     $data['zhuanhuashu']   = $zhuanhuashu;
     $data['zhuanhualv']    = round($zhuanhuashu/$xinzengshu,2);
     return $data;
 }

/*
* 新增资源转化率(京区业务中心资源)
* 1.员工id
* 2.本周期开始时间
* 3.本周期结束时间
* */
function get_zhuanhualv($user,$start_date,$end_date){
    //考核三个月前新增资源数量
    $where                  = array();
    $where['input_time']	= array('between',array($start_date-(120*24*3600),$end_date-(120*24*3600)));
    $where['audit_status']  = 1;    //审核通过
    $where['input_user']    = $user;
    $xinzengziyuan          = M('cas_res')->where($where)->getField('id',true);

    //已转化资源数量
    $where                  = array();
    $where['cas_res_id']    = array('in',$xinzengziyuan);
    $zhuanhuaziyuan         = M('op_res')->field('id')->where($where)->group('cas_res_id')->select();

    $data                   = array();
    $data['xinzengziyuan']  = $xinzengziyuan;
    $data['zhuanhuaziyuan'] = $zhuanhuaziyuan;
    $data['xinzengshu']     = count($xinzengziyuan);
    $data['zhuanhuashu']    = count($zhuanhuaziyuan);
    $data['zhuanhualv']     = round($data['zhuanhuashu']/$data['xinzengshu'],2);
    return $data;
}

/*
 * 教务满意度
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * */
function get_jw_myd($user,$start_date,$end_date){
    //本月以评分的总项目
    $where                  = array();
    $where['c.manager_id']  = $user;
    $where['s.input_time']  = array('between',array($start_date,$end_date));
    $where['s.late']        = array('neq',0);
    $field                  = "s.id,s.guide,s.late,s.manage,s.morality,u.id as uid,u.confirm_id";
    $lists                  = M()->table('__TCS_SCORE__ as s')->field($field)->join('__TCS_SCORE_USER__ as u on u.id=s.uid','left')->join('__OP_GUIDE_CONFIRM__ as c on c.id=u.confirm_id','left')->where($where)->select();

    $hegexiangmu            = array();
    $zongfen                = 4*5;   //考核4项, 每项5分, 满分总分
    foreach ($lists as $k=>$v){
        $defen              = $v['guide']+$v['late']+$v['manage']+$v['morality'];
        $score              = round($defen/$zongfen,2);
        if ($score > 0.72){
            $hegexiangmu[]  = $v;
        }
    }

    $data                   = array();
    $data['zongxiangmu']    = $lists;
    $data['hegexiangmu']    = $hegexiangmu;
    $data['zongshu']        = count($lists);
    $data['hegeshu']        = count($hegexiangmu);
    $data['hegelv']         = round($data['hegeshu']/$data['zongshu'],2);
    return $data;
}

/*
 * 辅导员管理准确性
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * */
function get_fdyzqx($user,$start_date,$end_date){
    //辅导员本月调度总团数
    $where                    = array();
    $where['heshi_oa_uid']    = $user;
    $where['heshi_time']      = array('between',array($start_date,$end_date));
    $lists                    = M('op_guide_confirm')->where($where)->select();          //活动结束后核实人员信息

    $buhegexiangmu            = array();
    foreach ($lists as $k=>$v){
        if ($v['istrue'] ==1){
            $buhegexiangmu[]  = $v;
        }
    }
    $zongxiangmu            = $lists;
    $buhegexiangmu          = $buhegexiangmu;
    $zongshu                = count($zongxiangmu);
    $buhegeshu              = count($buhegexiangmu);
    //$hegeshu                = $zongshu - $buhegeshu;
    //$hegelv                 = round($hegeshu/$zongshu,2);

    $data                   = array();
    $data['zongxiangmu']    = $zongxiangmu;
    $data['buhegexiangmu']  = $buhegexiangmu;
    $data['zongshu']        = $zongshu;
    $data['buhegeshu']      = $buhegeshu;
    //$data['hegelv']         = $hegelv;
    return $data;
}

/*
 * 辅导员管理及时率
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * */
function get_fdyjsl($user,$start_date,$end_date){
    //辅导员本月调度总团数
    $before_where                   = array();
    $before_where['manager_id']     = $user;
    $before_where['set_guide_time'] = array('between',array($start_date,$end_date));
    $before_lists                   = M('op_guide_confirm')->where($before_where)->select();   //出团前安排人员
    $after_where                    = array();
    $after_where['heshi_oa_uid']    = $user;
    $after_where['heshi_time']      = array('between',array($start_date,$end_date));
    $after_lists                    = M('op_guide_confirm')->where($after_where)->select();          //活动结束后核实人员信息

    $zongxiangmu            = array();
    $hegexiangmu            = array();
    foreach ($before_lists as $k=>$v){
        $timeaa             = $v['in_begin_day']-$v['set_guide_time'];
        $timebb             = 3*24*3600;     //活动实施前3天完成辅导员安排
        if ($timeaa >= $timebb){
            $hegexiangmu[]  = $v;            //合格团数
        }
        $zongxiangmu[]      = $v;
    }

    foreach ($after_lists as $kk=>$vv){
        $timeaa             = $vv['heshi_time']-$vv['daiheshi_time'];
        $timebb             = 5*24*3600;     //活动实施后5天内完成核实
        if ($timeaa <= $timebb){
            $hegexiangmu[]  = $vv;
        }
        $zongxiangmu[]      = $vv;
    }
    $zongshu                = count($zongxiangmu);
    $hegeshu                = count($hegexiangmu);
    $hegelv                 = round($hegeshu/$zongshu,2);

    $data                   = array();
    $data['zongxiangmu']    = $zongxiangmu;
    $data['hegexiangmu']    = $hegexiangmu;
    $data['zongshu']        = $zongshu;
    $data['hegeshu']        = $hegeshu;
    $data['hegelv']         = $hegelv;
    return $data;
}


/*
 * 培训完成率
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * 4.应培训总数
 * 5.工单数
 * */
function get_peixunlv($user,$start_date,$end_date,$sum=0,$sumlists=''){
    //需要培训数(工单取值)
    $worder             = get_worder($user,$start_date,$end_date);
    $zonggongdan        = $sumlists?$sumlists:$worder['zonggongdan'];
    $zongshu            = $sum?$sum:count($zonggongdan);

    //已完成培训数量(培训管理取值)
    $where = array();
    $where['create_time']	= array('between',array($start_date,$end_date));
    $where['lecturer_uid']  = $user;
    $lists = M('cour_ppt')->where($where)->select();
    $yiwancheng             = count($lists);

    $peixunlv               = round($yiwancheng/$zongshu,2);
    $data                   = array();
    $data['zgd']            = $zonggongdan;
    $data['wcpx']           = $lists;
    $data['zongshu']        = $zongshu;
    $data['yiwancheng']     = $yiwancheng;
    $data['peixunlv']       = $peixunlv;
    return $data;
}


/*
 * 获取工作及时率
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * 4.工单发起人
 * */
function get_jishilv($user,$start_date,$end_date,$ini_user_ids=''){
    $worder             = get_worder($user,$start_date,$end_date,$ini_user_ids);
    $zonggongdan        = $worder['zonggongdan'];
    $wanchenggongdan    = $worder['wanchenggongdan'];
    $zongshu            = count($zonggongdan);
    $yiwancheng         = count($wanchenggongdan);
    $jishilv            = round($yiwancheng/$zongshu,2);

    $data               = array();
    $data['zgd']        = $zonggongdan;
    $data['wcgd']       = $wanchenggongdan;
    $data['zongshu']    = $zongshu;
    $data['yiwancheng'] = $yiwancheng;
    $data['jishilv']    = $jishilv;
    return $data;
}

/*
 * 获取本月应完成工单
 * 1.员工id
 * 2.本周期开始时间
 * 3.本周期结束时间
 * */
function get_worder($user,$start_date,$end_date,$ini_user_ids=''){
    $where                  = array();
    //$where['create_time']	= array('between',array($v['start_date'],$v['end_date']));
    $where['status']        = array('neq',-1);
    if ($ini_user_ids){ $where['ini_user_id'] =array('in',$ini_user_ids) ; };
    $where['_string']       = " (assign_id = $user) OR (exe_user_id = $user and assign_id = 0) ";
    $lists  = M()->table('__WORDER__ as w')->field('w.*,d.use_time')->join('__WORDER_DEPT__ as d on d.id=w.wd_id','left')->where($where)->select();

    $zonggongdan     = array();
    $wanchenggongdan = array();
    foreach ($lists as $k=>$v){
        $use_time   = $v['use_time']?$v['use_time']:5;                          //默认5个工作日
        $end_time   = strtotime(getAfterWorkDay($use_time,$v['create_time']));  //工单应完成时间
        if ($end_time > $start_date && $end_time < $end_date){
            $zonggongdan[]      = $v;            //本月应完成总工单数
        }
        if ($end_time > $start_date && $end_time < $end_date && in_array($v['status'],array(2,3))){
            $wanchenggongdan[]  = $v;           //本月已完成工单(2=>执行部门确认完成)
        }
    }

    $data                   = array();
    $data['zonggongdan']    = $zonggongdan;
    $data['wanchenggongdan']= $wanchenggongdan;
    return $data;
}

/*
 * 获取合格率
 * 1.总考核数
 * 2.考核维度
 * 3.单个纬度分数(星星数量)
 * */
function get_hegelv($lists,$n,$star=5){
    $hege_list          = array();
    foreach ($lists as $k=>$v){
        $defen          = array_sum($v);
        $zongfen        = $n*$star;
        $ratio          = round($defen/$zongfen,2);
        //大于72%即为合格
        if ($ratio >= 0.72){
            $hege_list[]= $v;
        }
    }
    $hegetuanshu        = count($hege_list);
    $zongtuanshu        = count($lists);
    $hegelv             = round($hegetuanshu/$zongtuanshu,2);

    return $hegelv;
}

//根据项目类型不同考核内容不同(研发)
/*function get_hegelvaa($lists){
    $score_kind1        = array_keys(C('SCORE_KIND1')); //线路类
    $score_kind2        = array_keys(C('SCORE_KIND2')); //课程类
    $score_kind3        = array_keys(C('SCORE_KIND3')); //亲自旅行 , 冬夏令营

    $hege_list          = array();
    foreach ($lists as $k=>$v){
        if (in_array($v['kind'],$score_kind2)){
            //考核研发(3项:课程深度、课程专业性、课程趣味性)
            $n          = 3;
            $defen      = $v['depth']+ $v['major']+ $v['interest'];
        }elseif (in_array($v['kind'],$score_kind3)){
            //考核研发(项1:内容专业性)
            $n          = 1;
            $defen      = $v['major'];
        }else{
            //考核研发(1项:)
            $n          = 1;
            $defen      = $v['content'];
        }
        $zongfen        = 5*$n;
        $ratio          = round($defen/$zongfen,2);
        //大于72%即为合格
        if ($ratio >= 0.72){
            $hege_list[]= $v;
        }
    }
    $hegetuanshu        = count($hege_list);
    $zongtuanshu        = count($lists);
    $hegelv             = round($hegetuanshu/$zongtuanshu,2);

    return $hegelv;
}*/

//客户满意度
function get_manyidu($lists){
    $score_kind1= array_keys(C('SCORE_KIND1'));
    $score_kind2= array_keys(C('SCORE_KIND2'));
    $score_kind3= array_keys(C('SCORE_KIND3'));

    $zongfen    = 0;
    $defen      = 0;
    foreach ($lists as $k=>$v){
        $kind   = $v['kind'];
        if (in_array($kind,$score_kind1)) $zongfen += 9*5;  //考核9项, 每项5分, 满分总分
        if (in_array($kind,$score_kind2)) $zongfen += 10*5; //考核10项, 每项5分, 满分总分
        if (in_array($kind,$score_kind3)) $zongfen += 10*5; //考核10项, 每项5分, 满分总分
        $defen += $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality'];
    }
    $score      = round($defen/$zongfen,2);
    return $score;
}

/**
 * 获取别考评人所管辖的部门信息
 * @param $uid
 * @return array|mixed
 */
function get_department($uid){
    $department     = M()->table('__ACCOUNT__ as a')->join('__SALARY_DEPARTMENT__ as d on d.id=a.departmentid','left')->where(array('a.id'=>$uid))->getField("d.department");    //获取部门信息
    switch ($uid){
        case 32:
            $department = C('MANAGER_WANG');
            break;
        case 38:
            $department = C('MANAGER_YANG');
            break;
        default:
            $department = array($department);
            break;
    }
    return $department;
}

/**
 * 部门季度预算信息
 * @param $userid
 * @param $month
 * @return mixed
 */
function get_department_budget($department,$year,$month){
    $quarter                    = get_quarter($month);  //获取季度信息
    $year                       = $year?$year:date("Y");
    $where                      = array();
    $where['datetime']          = $year;
    $where['logged_department'] = array('in',$department);
    $where['type']              = $quarter;
    $field                      = array();
    $field[]                    = 'sum(employees_number) as sum_employees_number,sum(logged_income) as sum_logged_income,sum(logged_profit) as sum_logged_profit, sum(manpower_cost) as sum_manpower_cost, sum(other_expenses) as sum_other_expenses, sum(total_profit) as sum_total_profit';
    $budget                     = M('manage_input')->field($field)->where($where)->find();
    return $budget;
}

/**
 * 获取所管辖所有部门经营总额
 * @param $department   array
 * @param $year
 * @param $month
 */
function get_sum_department_operate($department,$year,$month){
    foreach ($department as $v){
        $info[]                 = get_department_operate($v,$year,$month);
    }
    $data                       = array();
    $data['ygrs']               = array_sum(array_column($info,'ygrs'));        //员工人数
    $data['yysr']               = array_sum(array_column($info,'yysr'));        //营业收入
    $data['yyml']               = array_sum(array_column($info,'yyml'));        //营业毛利
    $data['yymll']              = round($data['yyml']/$data['yysr'],4)*100;     //营业毛利率(%)
    $data['rlzycb']             = array_sum(array_column($info,'rlzycb'));      //人力资源成本
    $data['qtfy']               = array_sum(array_column($info,'qtfy'));        //其他费用
    $data['lrze']               = array_sum(array_column($info,'lrze'));        //利润总额
    $data['rsfyl']              = round($data['rlzycb']/$data['yysr'],4)*100;   //人事费用率(%)
    return $data;
}

/**
 * 获取部门实际经营信息(从季度经营报表中取值)
 * @param $userid
 * @param $month
 */
 function get_department_operate($department,$year,$month){
     $mod           = D('Manage');
     $quart         = $mod->quarter_month1($month);  //季度信息

     $yms                    = $mod->get_yms($year,$quart,'q');  //获取费季度包含的全部月份
     $times                  = $mod->get_times($year,$quart,'q');    //获取考核周期开始及结束时间戳

     $ymd[0]                 = date("Ymd",$times['beginTime']);
     $ymd[1]                 = date("Ymd",$times['endTime']);
     $mon                    = not_team_not_share($ymd[0],$ymd[1]);//季度其他费用取出数据(不分摊)
     $mon_share              = not_team_share($ymd[0],$ymd[1]);//季度其他费用取出数据(分摊)
     $otherExpenses          = $mod->department_data($mon,$mon_share);//季度其他费用部门数据

     $number                 = $mod->get_numbers($year,$yms);    //季度平均人数
     $hr_cost                = $mod->get_quarter_hr_cost($year,$yms,$times);// 季度部门人力资源成本
     $profit                 = get_business_sum($year,$yms);// 季度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
     $human_affairs          = $mod->human_affairs($hr_cost,$profit);//季度 人事费用率
     $total_profit           = $mod->total_profit($profit,$hr_cost,$department);//季度 利润总额

     $info              = array();
     $info['ygrs']      = $number[$department];             //部门员工人数
     $info['yysr']      = $profit[$department]['monthzsr']; //营业收入
     $info['yyml']      = $profit[$department]['monthzml']; //营业毛利
     $info['yymll']     = $profit[$department]['monthmll']; //营业毛利率
     $info['rlzycb']    = $hr_cost[$department];            //人力资源成本
     $info['qtfy']      = $otherExpenses[$department];      //其他费用
     $info['lrze']      = $total_profit[$department];       //利润总额
     $info['rsfyl']     = $human_affairs[$department];      //人事费用率

     return $info;
}

    /**
     * not_team 非团支出报销（其他费用）(不分摊)
     * $ymd1 开始时间 20180626
     * $ymd2 结束时间 20180726
     */
    function not_team_not_share($ymd1,$ymd2){
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
    function not_team_share($ymd1,$ymd2){

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
    function  business_sum($year,$month,$type){
    if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
    $times                       = $year.$month;
    $yw_departs                  = C('YW_DEPARTS');  //业务部门id
    $where                       = array();
    $where['id']                 = array('in',$yw_departs);
    $departments                 = M('salary_department')->field('id,department')->where($where)->select();
    //预算及结算分部门汇总
    $listdatas                   = count_lists($departments,$year,$month,$type);//1 结算 0预算
    return $listdatas;
}

    /**  monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
     * @param $year
     * @param $yms
     */
    function get_business_sum($year,$yms){
    $info                   = array();
    foreach ($yms as $v){
        $month              = substr($v,4,2);
        $info[]             = business_sum($year,$month,1);
    }

    $sum                    = array();
    foreach ($info as $key=>$value){
        foreach ($value as $k=>$v){
            if ($k == 'heji') $v['depname'] = '公司';
            $sum[$v['depname']]['monthzsr'] += $v['monthzsr'];
            $sum[$v['depname']]['monthzml'] += $v['monthzml'];
            $sum[$v['depname']]['monthmll'] = round($sum[$v['depname']]['monthzml']/$sum[$v['depname']]['monthzsr'],4)*100;
        }
    }
    return $sum;
}

/**
 * ManageController
 * profit_r 月份循环季度数据
 * $quarter  人数 人力资源成本
 * $profits 季度数据 总收入 总毛利 总利率
 * $type 1 结算 0 预算
 */
function profit_r($year1,$quart,$type){
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
            $mon                                = not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
            $department                         = $mod->department_data($mon);//月度其他费用部门数据
            foreach($department as $key =>$val){
                $month_r[$key]['money']        += $val['money'];//季度其他费用
            }
            $count                              = business_kpi($year1,$month,$type); //季度 人数和 人力资源成本
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
                $count                           = business_kpi($year1,$month,1); //季度 人数和 人力资源成本
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
                $mon                              = not_team($ymd[0],$ymd[1]);//月度其他费用取出数据
                $department                       = $mod->department_data($mon);//月度其他费用部门数据
                foreach($department as $key =>$val){
                    $month_r[$key]['money']      += $val['money'];//季度其他费用
                }
            }
        }
    }
}

//ManageController
function  business_kpi($year,$month,$type){
    if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
    $times                       = $year.$month;
    $yw_departs                  = C('YW_DEPARTS');  //业务部门id
    $where                       = array();
    $where['id']                 = array('in',$yw_departs);
    $departments                 = M('salary_department')->field('id,department')->where($where)->select();
    //预算及结算分部门汇总
    $listdatas                   = count_lists($departments,$year,$month,$type);//1 结算 0预算
    return $listdatas;
}

//chartController
function count_lists($departments,$year,$month,$pin=0){
    $yearBegin      			= ($year-1).'1226';
    $yearEnd        			= $year.'1226';
    $yeartimes					= array();
    $yeartimes['yearBeginTime'] = strtotime($yearBegin);
    $yeartimes['yearEndTime']   = strtotime($yearEnd);
    $month                      = $year.$month;
    $userlists      			= array();
    foreach ($departments as $k=>$v){
        $userlists[$v['id']]['users']   = M('account')->where(array('departmentid'=>$v['id']))->getField('id',true);
        $userlists[$v['id']]['id']      = $v['id'];
        $userlists[$v['id']]['depname'] = $v['department'];
    }

    if ($pin == 0){
        //预算及结算分部门汇总
        $lists      = D('Chart')->ysjs_deplist($userlists,$month,$yeartimes,$pin);
    }else{
        //结算分部门汇总
        $lists      = D('Chart')->js_deplist($userlists,$month,$yeartimes,$pin);
    }
    return $lists;
}

//ChartController
function not_team($ymd1,$ymd2){

    $ymd1                   =  strtotime($ymd1);
    $ymd2                   =  strtotime($ymd2);
    $map['bx_time']         = array(array('gt',$ymd1),array('lt',$ymd2));//开始结束时间
    $map['bxd_type']        = array(array('gt',1),array('lt',4));//2 非团借款报销 3直接报销
    $map['audit_status']    = array('eq',1);//审核通过
    $money                  = M('baoxiao')->where($map)->select();//日期内所有数据
    return  $money;
}

/**
 * 获取季度顾客满意度
 * @param $users  array
 * @param $year
 * @param $month
 */
function get_QCS($userids,$year,$month){
    $quart_time     = getQuarterlyCicle($year,$month);  //季度周期
    //获取周期所有评分信息
    $where                  = array();
    $where['s.input_time']	= array('between',array($quart_time['begin_time'],$quart_time['end_time']));
    $where['o.create_user'] = array('in',$userids);
    $lists = M()->table('__TCS_SCORE__ as s')->field('u.op_id,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

    $average = get_manyidu($lists);
    return $average;
}

/**
 * 获取当前用户所管理部门的人员信息
 * @param $userid       userid
 * @return array        id=>name
 */
function get_department_users($userid){
    $departments            = get_department($userid);
    $department_ids         = M('salary_department')->where(array('department'=>array('in',$departments)))->getField('id',true);
    $users                  = M('account')->where(array('departmentid'=>array('in',$department_ids)))->getField('id,nickname',true);
    return $users;
}

/**获取该用户本周期所带团评分信息
 * @param $userid
 * @param $beginTime
 * @param $endTime
 */
function get_op_guide($userid,$beginTime,$endTime){
    $tcsBeginTime           = $beginTime + 24*3600;     //辅导员确认时间比OA系统晚一天
    $tcsEndTime             = $endTime + 24*3600;
    $guide                  = M()->table('__TCS_ADMIN__ as t')->field('g.id,g.name')->join('__GUIDE__ as g on g.uid=t.id','left')->where(array('t.oa_id'=>$userid))->find();
    $guide_id               = $guide['id'];
    $where                  = array();
    $where['guide_id']      = $guide_id;
    $where['status']        = 2;
    $where['sure_time']     = array('between',array($tcsBeginTime,$tcsEndTime));
    $op_ids                 = M('guide_pay')->where($where)->getField('op_id',true);
    $num                    = count($op_ids);
    $op_ids                 = array_unique($op_ids);
    $where                  = array();
    $where['s.input_time']	= array('between',array($tcsBeginTime,$tcsEndTime));
    $where['o.op_id']       = array('in',$op_ids);
    $score_lists            = M()->table('__TCS_SCORE__ as s')->field('u.op_id,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();
    $data                   = array();
    $data['num']            = $num;
    $data['lists']          = $score_lists;
    return $data;
}

/**
 * 获取该用户的薪资信息
 * @param $userid
 */
function get_wages_info($userid){
    $where                  = array();
    $where['account_id']    = $userid;
    $info                   = M('salary')->where($where)->order('id DESC')->find();
    $info['otherWages']     = $info['standard_salary']*1.5;
    return $info;
}

//研发专家业绩贡献度
function get_gross_profit($userid,$beginTime,$endTime){
    //个人立项毛利部分(结算)
    $where                  = array();
    $where['o.create_user'] = $userid;
    $where['l.req_type']    = 801;
    $where['l.audit_time']  = array('between',array($beginTime,$endTime));
    $where['s.audit_status']= 1;
    $field                  = array();
    $field[]                = 'sum(s.maoli) as selfSumGrossProfit';
    $settlement_self        = M()->table('__OP__ as o')
        ->join('__OP_SETTLEMENT__ as s on s.op_id=o.op_id','left')
        ->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')
        ->where($where)
        ->field($field)
        ->find();

    //协助销售毛利*0.4
    $where                  = array();
    $where['o.create_user'] = array('neq',$userid);
    $where['o.expert']      = $userid;
    $where['l.req_type']    = 801;
    $where['l.audit_time']  = array('between',array($beginTime,$endTime));
    $where['s.audit_status']= 1;
    $field                  = array();
    $field[]                = 'sum(s.maoli) as otherSumGrossProfit';
    $settlement_other       = M()->table('__OP__ as o')
        ->join('__OP_SETTLEMENT__ as s on s.op_id=o.op_id','left')
        ->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')
        ->where($where)
        ->field($field)
        ->find();
    $data                       = array();
    $data['self']               = $settlement_self['selfSumGrossProfit'];
    $data['otherSum']           = $settlement_other['otherSumGrossProfit'];
    $data['other']              = $data['otherSum']*0.4;
    $data['sum']                = $data['self'] + $data['other'];
    return $data;
}

//研发专家毛利总额 和 基本工资总和
function get_sum_gross_profit($userids,$beginTime,$endTime){
    $lists                      = array();
    $base_wages                 = array();
    foreach ($userids as $v){
        $lists[$v]              = get_gross_profit($v,$beginTime,$endTime);
        $base_wages[$v]         = get_wages_info($v);
    }

    $data                       = array();
    $sum_profit                 = array_sum(array_column($lists,'self')) + array_sum(array_column($lists,'other')); //毛利总额
    $sum_base_wages             = array_sum(array_column($base_wages,'otherWages'));    //1.5倍基本工资总和
    $data['sum_profit']         = $sum_profit;
    $data['sum_base_wages']     = $sum_base_wages;
    return $data;
}

    /**
     * 获取当月考核KPI的某一项值
     * @param $yearmonth
     * @param $user_id
     * @param int $quota_id = 1(默认月度累计毛利额)
     */
function get_gross_margin($yearmonth,$user_id,$quota_id=1){
    $db                         = M('kpi_more');
    $where                      = array();
    $where['user_id']           = $user_id;
    $where['month']             = $yearmonth;
    $where['quota_id']          = $quota_id;
    $list                       = $db->where($where)->find();
    return $list;
}

function get_satisfaction($yearmonth){
    $db                         = M('satisfaction');
    $lists                      = $db->where(array('monthly'=>$yearmonth))->select();
    $num                        = count($lists);
    $sum_average                = 0;
    foreach ($lists as $k=>$v){
        $score                  = $v['timely'] + $v['accord'] + $v['cost'] + $v['train'] + $v['service'];
        $count_score            = 5*5;  //总分 = 5各维度, 每个维度5颗星
        $sum_average            += round($score/$count_score,2);
    }
    $average                    = round($sum_average/$num,2);
    $data                       = array();
    $data['num']                = $num;
    $data['average']            = $average;
    return $data;
}

        /*
         * 研发主管客户满意度平均值
         * 1.开始时间
         * 2.结束时间
         * */
    function get_satisfaction_average($start_date,$end_date){
        $where                  = array();
        $where['s.input_time']	= array('between',array($start_date,$end_date));
        $lists = M()->table('__TCS_SCORE__ as s')->field('u.op_id,o.kind,s.id as sid,s.content,s.teacher,s.depth,s.major,s.interest,s.material')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

        $score_kind1            = array_keys(C('SCORE_KIND1'));
        $score_kind2            = array_keys(C('SCORE_KIND2'));
        $score_kind3            = array_keys(C('SCORE_KIND3'));
        $snum1                  = 0;
        $snum2                  = 0;
        $snum3                  = 0;
        $average1               = 0;
        $average2               = 0;
        $average3               = 0;
        foreach ($lists as $key=>$value){
            if (in_array($value['kind'],$score_kind1)){
                $score          = $value['content'] + $value['teacher'];
                $sum_score      = 5*2;
                $average1       += round($score/$sum_score,2);
                $snum1++;
            }
            if (in_array($value['kind'],$score_kind2)){
                $score          = $value['depth'] + $value['major'] + $value['interest'] + $value['teacher'] + $value['material'];
                $sum_score      = 5*5;
                $average2       += round($score/$sum_score,2);
                $snum2++;
            }
            if (in_array($value['kind'],$score_kind3)){
                $score          = $value['major'] + $value['material'];
                $sum_score      = 5*2;
                $average3       += round($score/$sum_score,2);
                $snum3++;
            }
        }
        $score1                 = round($average1/$snum1,2);
        $score2                 = round($average2/$snum2,2);
        $score3                 = round($average3/$snum3,2);
        $average                = round(($score1 + $score2 + $score3)/3,2);
        $data                   = array();
        $data['num']            = count($lists);    //评分次数
        $data['average']        = $average;
        return $data;
    }

    /**
     * 获取研发人员模块使用率
     * @param $userid
     * @param $beginTime
     * @param $endTime
     */
    function get_use_times($userid,$beginTime,$endTime){
        $op_ids                 = M('op_team_confirm')->where(array('confirm_time'=>array('between',"$beginTime,$endTime")))->getField('op_id',true);
        $count                  = M()->table('__OP_PRODUCT__ as o')->join('__PRODUCT__ as p on p.id=o.product_id','left')->where(array('o.op_id'=>array('in',$op_ids),'p.input_user'=> $userid))->count();
        return $count;
    }


