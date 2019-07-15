<?php

    /**将上个季度的考核结果扶植到当季度
     * @param $arr
     */
function get_prev_quarter_kpi_result($arr){
    $year                   = $arr['year'];
    $monthd                 = substr($arr['month'],4,2);
    $monthly                = get_kpi_monthly($year,$monthd);
    $where                  = array();
    $where['user_id']       = $arr['user_id'];
    $where['year']          = $year;
    $where['month']         = $monthly;
    $where['quota_id']      = $arr['quota_id'];
    $list                   = M('kpi_more')->where(array($where))->find();
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
     //考核六个月前新增资源数量
     $where                 = array();
     $where['input_time']	= array('between',array($start_date-(210*24*3600),$end_date-(210*24*3600)));
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
    /*foreach ($before_lists as $k=>$v){
        $timeaa             = $v['in_begin_day']-$v['set_guide_time'];
        $timebb             = 7*24*3600;     //活动实施前7天完成辅导员安排
        //if ($timeaa >= $timebb){
        if ($timeaa >= 0){                   //活动开始前安排
            $hegexiangmu[]  = $v;            //合格团数
        }
        $zongxiangmu[]      = $v;
    }*/

    foreach ($after_lists as $kk=>$vv){
        $timeaa             = $vv['heshi_time']-$vv['daiheshi_time'];
        $timebb             = strtopinyin(date('Ym').'26');     //活动实施后每月26号前完成内完成核实
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
    $data['kpi_cour_ids']   = implode(',',array_column($lists,'id'));
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
    $worder                 = get_worder($user,$start_date,$end_date,$ini_user_ids);
    $zonggongdan            = $worder['zonggongdan'];
    $wanchenggongdan        = $worder['wanchenggongdan'];
    $zongshu                = count($zonggongdan);
    $yiwancheng             = count($wanchenggongdan);
    $jishilv                = round($yiwancheng/$zongshu,2);

    $data                   = array();
    $data['zgd']            = $zonggongdan;
    $data['wcgd']           = $wanchenggongdan;
    $data['zongshu']        = $zongshu;
    $data['yiwancheng']     = $yiwancheng;
    $data['jishilv']        = $jishilv;
    $data['kpi_worder_ids'] = implode(',',array_column($zonggongdan,'id'));
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
    $where['status']        = array('not in',array(-1,-2)); //-1拒绝, -2=>撤销
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

//客户满意度 kpi
function get_manyidu($lists){
    $defen      = 0;
    foreach ($lists as $k=>$v){
        $defen += $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
    }
    $zongfen    = get_sum_score($lists);
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
 * 获取所管辖所有部门经营总额(包括地接营收)
 * @param $department   array
 * @param $year
 * @param $month
 */
function get_sum_department_operate($department,$year,$month,$type){
    foreach ($department as $v){
        $info[]                 = get_department_operate($v,$year,$month,$type);
    }
    $data                       = array();
    $data['ygrs']               = array_sum(array_column($info,'ygrs'));        //员工人数
    $data['yysr']               = array_sum(array_column($info,'yysr'));        //营业收入
    $data['yyml']               = array_sum(array_column($info,'yyml'));        //营业毛利
    $data['yymll']              = round($data['yyml']/$data['yysr'],4)*100;     //营业毛利率(%)
    $data['rlzycb']             = array_sum(array_column($info,'rlzycb'));      //人力资源成本
    $data['qtfy']               = array_sum(array_column($info,'qtfy'));        //其他费用
    $data['lrze']               = array_sum(array_column($info,'lrze'));        //利润总额
    $data['rsfyl']              = round($data['rlzycb']/$data['yysr'],4)*100;   //人事费用率(%)  人力资源成本/营业收入
    return $data;
}

/**
 * 获取部门实际经营信息(从季度经营报表中取值)
 * @param $userid
 * @param $month
 */
 /*function get_department_operate_bak_20190417($department,$year,$month){
     $mod                       = D('Manage');
     $quart                     = quarter_month1($month);  //季度信息

     $yms                       = $mod->get_yms($year,$quart,'q');  //获取费季度包含的全部月份
     $times                     = $mod->get_times($year,$quart,'q');    //获取考核周期开始及结束时间戳

     $ymd[0]                    = date("Ymd",$times['beginTime']);
     $ymd[1]                    = date("Ymd",$times['endTime']);
     $mon                       = not_team_not_share($ymd[0],$ymd[1]);//季度其他费用取出数据(不分摊)
     $mon_share                 = not_team_share($ymd[0],$ymd[1]);//季度其他费用取出数据(分摊)
     $otherExpenses             = $mod->department_data($mon,$mon_share);//季度其他费用部门数据

     $number                    = $mod->get_numbers($year,$yms);    //季度平均人数
     $hr_cost                   = $mod->get_quarter_hr_cost($year,$yms,$times);// 季度部门人力资源成本
     $profit                    = get_business_sum($year,$yms);// 季度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
     $human_affairs             = $mod->human_affairs($hr_cost,$profit);//季度 人事费用率
     $total_profit              = $mod->total_profit($profit,$hr_cost,$otherExpenses);//季度 利润总额

     $info                      = array();
     $info['ygrs']              = $number[$department];             //部门员工人数
     $info['yysr']              = $profit[$department]['monthzsr']; //营业收入
     $info['yyml']              = $profit[$department]['monthzml']; //营业毛利
     $info['yymll']             = $profit[$department]['monthmll']; //营业毛利率
     $info['rlzycb']            = $hr_cost[$department];            //人力资源成本
     $info['qtfy']              = $otherExpenses[$department]['money'];      //其他费用
     $info['lrze']              = $total_profit[$department];       //利润总额
     $info['rsfyl']             = $human_affairs[$department];      //人事费用率

     return $info;
}*/

    /**
     * 实际经营信息(年度累计)
     * @param $department
     * @param $year
     * @param $month
     * @param $type 'm'=>月度 'q'=>季度 'y'=>年度
     * @return array
     */
    function get_department_operate($department,$year,$month,$type='q'){
        $mod                       = D('Manage');
        $quart                     = quarter_month1($month);  //季度信息

        $yms                       = $mod->get_yms($year,$quart,$type);  //获取费年度包含的全部月份
        $times                     = $mod->get_times($year,$quart,$type);    //获取考核周期开始及结束时间戳

        $ymd[0]                    = date("Ymd",$times['beginTime']);
        $ymd[1]                    = date("Ymd",$times['endTime']);
        $mon                       = not_team_not_share($ymd[0],$ymd[1]);//年度其他费用取出数据(不分摊)
        $mon_share                 = not_team_share($ymd[0],$ymd[1]);//年度其他费用取出数据(分摊)
        $otherExpenses             = $mod->department_data($mon,$mon_share);//年度其他费用部门数据

        $number                    = $mod->get_numbers($year,$yms);    //年度平均人数
        $hr_cost                   = $mod->get_quarter_hr_cost($year,$yms,$times);// 年度部门人力资源成本
        $profit                    = get_business_sum($year,$yms);// 年度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $human_affairs             = $mod->human_affairs($hr_cost,$profit);//年度 人事费用率
        $total_profit              = $mod->total_profit($profit,$hr_cost,$otherExpenses);//年度 利润总额

        $info                      = array();
        $info['ygrs']              = $number[$department];             //部门员工人数
        $info['yysr']              = $profit[$department]['monthzsr']; //营业收入
        $info['yyml']              = $profit[$department]['monthzml']; //营业毛利
        $info['yymll']             = $profit[$department]['monthmll']; //营业毛利率
        $info['rlzycb']            = $hr_cost[$department];            //人力资源成本
        $info['qtfy']              = $otherExpenses[$department]['money'];      //其他费用
        $info['lrze']              = $total_profit[$department];       //利润总额
        $info['rsfyl']             = $human_affairs[$department];      //人事费用率

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


    /**
     * //chartController
     * @param $departments
     * @param $year
     * @param $month
     * @param int $pin 0预算 1结算
     * @return mixed
     */
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
    $lists = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

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
    $score_lists            = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();
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
    //$where['o.expert']      = $userid;
    $where['o.expert']      = array('neq',0);
    $where['l.req_type']    = 801;
    $where['l.audit_time']  = array('between',array($beginTime,$endTime));
    $where['s.audit_status']= 1;
    $field                  = array();
    $field[]                = 'o.group_id,o.op_id,o.project,o.expert,s.maoli';
    //$field[]                = 'sum(s.maoli) as otherSumGrossProfit';
    $settlement_other_lists = M()->table('__OP__ as o')
        ->join('__OP_SETTLEMENT__ as s on s.op_id=o.op_id','left')
        ->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')
        ->where($where)
        ->field($field)
        ->select();
    $otherSumGrossProfit        = 0;
    if ($settlement_other_lists){
        foreach ($settlement_other_lists as $v){
            $experts            = explode(',',$v['expert']);
            if (in_array($userid,$experts)){
                $otherSumGrossProfit += $v['maoli'];
            }
        }
    }


    $data                       = array();
    $data['self']               = $settlement_self['selfSumGrossProfit'];
    $data['otherSum']           = $otherSumGrossProfit;
    $data['other']              = $data['otherSum']*0.4;
    $data['sum']                = $data['self'] + $data['other'];
    return $data;
}

    /*//研发专家毛利总额 和 基本工资总和
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
        }*/

//研发专家毛利总额 和 基本工资总和
function get_sum_gross_profit($userids,$beginTime,$endTime){
    $lists                      = array();
    $base_wages                 = array();
    $userdata                   = array();
    foreach ($userids as $v){
        $lists[$v]              = get_gross_profit($v,$beginTime,$endTime);
        $base_wages[$v]         = get_wages_info($v);
        $userdata[$v]['userid'] = $v;
        $userdata[$v]['uasrname']   = M('account')->where(array('id'=>$v))->getField('nickname');
        $userdata[$v]['profit']     = $lists[$v]['sale'] + $lists[$v]['other']; //业绩贡献
        $userdata[$v]['salary']     = $base_wages[$v]['standard_salary'];
        $userdata[$v]['t_salary']   = $base_wages[$v]['otherWages']; //1.5倍薪资
        $userdata[$v]['complete']   = (round($userdata[$v]['profit']/$userdata[$v]['t_salary'],2)*100).'%';
    }

    $data                       = array();
    $sum_salary                 = array_sum(array_column($base_wages,'standard_salary'));
    $sum_profit                 = array_sum(array_column($lists,'self')) + array_sum(array_column($lists,'other')); //毛利总额
    $sum_base_wages             = array_sum(array_column($base_wages,'otherWages'));    //1.5倍基本工资总和
    $wanchenglv                 = round($sum_profit/$sum_base_wages,2);
    $complete                   = ($wanchenglv*100).'%';

    $data['sum_profit']         = $sum_profit;
    $data['sum_salary']         = $sum_salary;
    $data['sum_base_wages']     = $sum_base_wages;
    $data['complete']           = $complete;
    $data['userdata']           = $userdata;
    return $data;
}

    /**
     * 获取销售当月任务季度系数
     * @param $yearmonth
     * @param $user_id
     * @param int $quota_id
     * @return mixed
     */
    function get_gross_margin($yearmonth,$user_id,$quota_id=1){
        $db                     = M('kpi_more');
        $where                  = array();
        $where['user_id']       = $user_id;
        $where['month']         = $yearmonth;
        $where['quota_id']      = $quota_id;
        $list                   = $db->where($where)->find();

        $year                   = substr($yearmonth,0,4);
        $month                  = substr($yearmonth,4,2);
        $departmnet_id          = M('account')->where(array('id'=>$user_id))->getField('departmentid');
        $monthBase              = get_sale_config_field($year,$month,$user_id,$departmnet_id); //月度任务系数

        //当月任务目标 = 工资*当月任务系数
        $salary                 = M('salary')->where(array('account_id'=>$user_id))->order('id desc')->getField('standard_salary');
        $monthTarget            = $salary*$monthBase;
        $list['monthTarget']    = $monthTarget;
        return $list;
    }

    /**
     * 获取销售当月任务系数字段
     * @param $month
     * @return string
     */
    function get_sale_config_field($year,$month,$user_id,$departmnet_id){
        switch ($month){
            case '01':
                $field          = "department_id,department,year,January as monthBase";
                break;
            case '02':
                $field          = "department_id,department,year,February as monthBase";
                break;
            case '03':
                $field          = "department_id,department,year,March as monthBase";
                break;
            case '04':
                $field          = "department_id,department,year,April as monthBase";
                break;
            case '05':
                $field          = "department_id,department,year,May as monthBase";
                break;
            case '06':
                $field          = "department_id,department,year,June as monthBase";
                break;
            case '07':
                $field          = "department_id,department,year,July as monthBase";
                break;
            case '08':
                $field          = "department_id,department,year,August as monthBase";
                break;
            case '09':
                $field          = "department_id,department,year,September as monthBase";
                break;
            case '10':
                $field          = "department_id,department,year,October as monthBase";
                break;
            case '11':
                $field          = "department_id,department,year,November as monthBase";
                break;
            case '12':
                $field          = "department_id,department,year,December as monthBase";
                break;
        }

        if ($user_id == 59){ //京区业务C端(李保罗)
            $jqyw_c             = C('JQXY-C');
            $monthBase          = $jqyw_c[$month];
        }else{
            $monthBaseData      = M('sale_config')->where(array('department_id'=>$departmnet_id,'year'=>$year))->field($field)->find();
            $monthBase          = $monthBaseData['monthBase']; //当月系数
        }
        return $monthBase;
    }

    function get_satisfaction($yearmonth){
        $db                         = M('satisfaction');
        $lists                      = $db->where(array('monthly'=>$yearmonth,'type'=>1))->select();
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

    /**
     * 获取月度公司顾客满意度,本周期评分情况
     */
    function get_month_satisfaction($beginTime,$endTime){
        //获取周期所有评分信息
        $where                  = array();
        $where['s.input_time']	= array('between',array($beginTime,$endTime));
        $lists                  = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

        return $lists;
    }

    //获取顾客满意度不合格数
    function get_score_unqualified_lists($lists){
        $num                        = 0;
        $unok_arr                   = array(1,2,3);
        $unok_list                  = array();
        foreach ($lists as $k=>$v){
            $zongfen                = 0;
            $defen                  = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
            if ($v['before_sell']   !=0) $zongfen += 5;
            if ($v['new_media']     !=0) $zongfen += 5;
            if ($v['stay']          !=0) $zongfen += 5;
            if ($v['food']          !=0) $zongfen += 5;
            if ($v['bus']           !=0) $zongfen += 5;
            if ($v['travel']        !=0) $zongfen += 5;
            if ($v['content']       !=0) $zongfen += 5;
            if ($v['driver']        !=0) $zongfen += 5;
            if ($v['guide']         !=0) $zongfen += 5;
            if ($v['teacher']       !=0) $zongfen += 5;
            if ($v['depth']         !=0) $zongfen += 5;
            if ($v['major']         !=0) $zongfen += 5;
            if ($v['interest']      !=0) $zongfen += 5;
            if ($v['material']      !=0) $zongfen += 5;
            if ($v['late']          !=0) $zongfen += 5;
            if ($v['manage']        !=0) $zongfen += 5;
            if ($v['morality']      !=0) $zongfen += 5;
            if ($v['cas_time']      !=0) $zongfen += 5;
            if ($v['cas_complete']  !=0) $zongfen += 5;
            if ($v['cas_addr']      !=0) $zongfen += 5;
            $score                  = round($defen/$zongfen,2);
            //单项3颗星或顾客满意度低于80%
            if ($score < 0.8 || (in_array($v['before_sell'],$unok_arr) || in_array($v['new_media'],$unok_arr) || in_array($v['stay'],$unok_arr) || in_array($v['travel'],$unok_arr) || in_array($v['content'],$unok_arr) || in_array($v['food'],$unok_arr) || in_array($v['bus'],$unok_arr) || in_array($v['driver'],$unok_arr) || in_array($v['guide'],$unok_arr) || in_array($v['teacher'],$unok_arr) || in_array($v['depth'],$unok_arr) || in_array($v['major'],$unok_arr) || in_array($v['interest'],$unok_arr) || in_array($v['material'],$unok_arr) || in_array($v['late'],$unok_arr) || in_array($v['manage'],$unok_arr) || in_array($v['morality'],$unok_arr) || in_array($v['cas_time'],$unok_arr) || in_array($v['cas_complete'],$unok_arr) || in_array($v['cas_addr'],$unok_arr))){
                //$num++;
                $v['score']         = $score;
                $unok_list[]        = $v;
            }
        }
        return $unok_list;
    }

    function get_visit($opids){
        $where                      = array();
        $where['op_id']             = array('in',$opids);
        $lists                      = M('op_visit')->where($where)->group('op_id')->select();
        return $lists;
    }


    //获取内部人员满意度
    function get_company_satisfaction($v){
        $mod                        = D('Inspect');
        $db                         = M('satisfaction');
        $satisfaction_config_db     = M('satisfaction_config');
        $uid                        = $v['user_id'];
        $month                      = explode(',',$v['month']);
        //$month                      = substr($v['month'],-6,6);
        $should_users               = $satisfaction_config_db->where(array('user_id'=>$uid,'month'=>array('in',$month)))->getField('score_user_id',true); //应评分人员

        $where                      = array();
        $where['monthly']           = array('in',$month);
        $where['account_id']        = $uid;
        $info                       = $db->where($where)->select();
        $input_userids              = array_column($info,'input_userid'); //已评分人员

        $unscore_userids            = array();
        foreach ($should_users as $kk=>$vv){
            if (!in_array($vv,$input_userids)){
                $unscore_userids[]  = $vv;
            }
        }

        $data                       = $mod->get_average_data($info,$unscore_userids);
        return $data;
    }

    /**
     * 月度顾客满意度(业务kpi)
     * @param $userid
     * @param $start_time
     * @param $end_time
     * @param string $gross_margin
     * @return array
     */
    function get_satisfied_kpi_data($userid,$start_time,$end_time,$gross_margin=''){
        //当月实施的团
        $where                          = array();
        $start_time                     = $start_time - 4*24*3600; //4天前实施的团
        $end_time                       = $end_time - 4*24*3600;
        $where['c.ret_time']            = array('between',array($start_time,$end_time));
        $where['o.create_user']         = $userid;
        $shishi_true_num                = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->count();
        //$where['o.in_dijie']            = array('neq',1); //排除发起团(发起团不做满意度调查)
        $shishi_lists                   = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $score_lists                    = array();
        $score_num                      = 0; //评分的团个数
        foreach ($shishi_lists as $k=>$v){
            //获取当月已评分的团
            $where                      = array();
            $where['o.op_id']           = $v['op_id'];
            $lists                      = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();
            if ($lists){ //已评分
                $score_num++;
                $op_average_data                = get_manyidu($lists);
                $shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $shishi_lists[$k]['score_num']  = count($lists);
                //$shishi_lists[$k]['op_average'] = $op_average_data >= 0.9?'100%':((round($op_average_data*100/90,2))*100).'%'; //平均得分(如果得分>90%,得分100, 如果小于90%,以90%作为满分求百分比)
                $shishi_lists[$k]['op_average'] = ($op_average_data*100).'%';
                foreach ($lists as $key=>$value){
                    $score_lists[]              = $value;
                }
            }else{ //未评分
                $shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $shishi_lists[$k]['op_average'] = '0%';
            }

            //满意度调查负责人信息
            $auth                       = M('op_guide_confirm')->where(array('op_id'=>$v['op_id']))->getField('charity_id',true);
            $str_auth_ids               = explode(',',implode(',',$auth));
            $auth_names                 = M('guide')->where(array('id'=>array('in',$str_auth_ids)))->getField('name',true);
            $shishi_lists[$k]['guide_manager']= implode(',',$auth_names);
        }
        $op_average_sum                 = array_sum(array_filter(explode(',',str_replace('%','',implode(',',array_column($shishi_lists,'op_average'))))));
        $score_average                  = round($op_average_sum/$score_num,2).'%'; //已调查顾客满意度
        $shishi_num                     = count($shishi_lists); //所有实施团的数量(包括未调查的数量)
        $average                        = round($op_average_sum/$shishi_num,2)/100; //全部平均值

        if (($shishi_num==0 && $gross_margin && $gross_margin['monthTarget']==0) || ($shishi_true_num != 0 && $shishi_num==0)) { //当月目标为0 有发起团, 无满意度调查(发起团不做满意度调查,地接团做满意度调查)
            $complete = '100%';
        }else{
            //总平均分,包括未调查的
            $complete = ($average*100).'%';
        }

        $data                           = array();
        $data['op_num']                 = count($shishi_lists);
        $data['score_num']              = $score_num;
        $data['score_average']          = $score_num?$score_average:'100%'; //已调查团的满意度
        $data['complete']               = $complete; //所有顾客满意度(包括未调查)
        $data['shishi_lists']           = $shishi_lists;
        $data['score_lists']            = $score_lists;
        return $data;
    }

    function get_year_settlement_start_time($year){
        $month                          = date('m');
        $day                            = date('d');
        if ($month ==12){
            if ($day < 26){
                $year                   = $year - 1;
            }else{
                $year                   = $year;
            }
        }else{
            $year                       = $year - 1;
        }
        $beginTime                      = strtotime($year.'1226');
        return $beginTime;
    }

    //获取当前考核时间所对应的年月日
    function get_this_month(){
        $year                           = date('Y');
        $month                          = date('m');
        $day                            = date('d');
        $data                           = array();
        if ($day < 26){
            $data['year']               = $year;
            $data['month']              = $month;
            $data['day']                = $day;
        }else{
            if ($month == 12){
                $year                   = $year + 1;
                $month                  = '01';
            }else{
                $year                   = $year;
                $month                  = $month + 1;
            }
            if (strlen($month) < 2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
            $data['year']               = $year;
            $data['month']              = $month;
            $data['day']                = $day;
        }
        return $data;
    }


    /**
     * 获取各部门的合同签订率
     * @param $departments
     * @param $begintime
     * @param $endtime
     * @return array
     */
    function get_department_op_list($departments,$begintime,$endtime,$yearMonth){
        $data                               = array();
        foreach ($departments as $k=>$v){
            $data[$k]                       = get_department_contract($v,$begintime,$endtime,$yearMonth);
        }
        return $data;
    }

    /**
     * 获取单个部门的合同签订率
     * @param $op_lists
     * @param $department
     * @return array
     */
    function get_department_contract($department,$begintime,$endtime,$yearMonth){
        $data                               = array();
        $data['id']                         = $department['id'];
        $data['department']                 = $department['department'];

        $count_lists                        = get_department_businessman($department['id']);
        $department_op_lists                = array();
        $department_contract_lists          = array();
        foreach ($count_lists as $key=>$value){
            $contract_data          = get_user_contract_list($value['id'],$yearMonth,$begintime,$endtime);
            if ($contract_data['op_list']){ //项目列表
                foreach ($contract_data['op_list'] as $opk=>$opv){
                    $department_op_lists[]  = $opv;
                }
            }
            if ($contract_data['contract_list']){ //合同信息
                foreach ($contract_data['contract_list'] as $conk=>$conv){
                    $department_contract_lists[] = $conv;
                }
            }
        }

        $data['department_op_lists']        = $department_op_lists;
        $data['department_contract_lists']  = $department_contract_lists;
        $data['op_num']                     = count($department_op_lists); //项目数量
        $data['contract_num']               = count($department_contract_lists); //合同数量
        $data['average']                    = $data['op_num']?(round($data['contract_num']/$data['op_num'],4)*100).'%':'100%';
        return $data;
    }

    //获取公司合计合同签订率
    function get_user_contract_list($userid,$yearMonth,$begintime,$endtime){
        //$userid = 78;
        $mod                                = D('contract');
        $gross_margin                       = get_gross_margin($yearMonth,$userid,1);  //获取当月月度累计毛利额目标值(如果毛利额目标为0,则不考核)
        $target                             = $gross_margin['monthTarget']; //当月目标值
        //$op_list                            = $mod->get_user_op_list($userid,$begintime,$endtime); //以出团时间为准
        $op_list                            = $mod->get_budget_list($userid,$begintime,$endtime); //以预算审核通过为准
        $op_num 		                    = count($op_list);
        $contract_list                      = array();
        foreach ($op_list as $key=>$value){
            //出团后5天内完成上传
            $time                           = strtotime(getAfterWorkDay(6,$value['dep_time'])); //出团后6个工作日
            $list                           = M('contract')->where(array('op_id'=>$value['op_id'],'status'=>1,'confirm_time'=>array('lt',$time)))->find(); //按规定时间上传合同
            $list2                          = M('contract')->where(array('op_id'=>$value['op_id'],'status'=>1))->find(); //查看截止当期有无合同

            if ($list){
                $contract_list[]    = $list;
                $op_list[$key]['contract_confirm_time'] = $list['confirm_time'];
                $op_list[$key]['contract_stu'] = "<span class='green'>有合同</span>";
            }elseif (!$list && $list2){
                $op_list[$key]['contract_stu'] = "<span class='yellow'>合同超时，已返回</span>";
            }else{
                $op_list[$key]['contract_stu'] = "<span class='red'>无合同</span>";
            }
        }
        $contract_num                       = count($contract_list);
        $data                               = array();
        $data['op_list']                    = $op_list;
        $data['contract_list']              = $contract_list;
        $data['op_num']                     = $op_num;
        $data['contract_num']               = $contract_num;
        $data['target']                     = $target?$target:'0.00';
        $data['average']                    = $target?(round($contract_num/$op_num,4)*100).'%':'100%';
        return $data;
    }

    /**获取公司合计合同签订率
     * @param $lists
     * @return array
     */
    function get_contract_sum($lists){
    $data                               = array();
    $data['name']                       = '合计';
    $data['op_num']                     = array_sum(array_column($lists,'op_num'));
    $data['contract_num']               = array_sum(array_column($lists,'contract_num'));
    $data['average']                    = $data['op_num']?(round($data['contract_num']/$data['op_num'],4)*100).'%':'100%';
    return $data;
}


//获取公司合计满意度
    function get_company_sum_score_statis($departments,$yearMonth){
        $year                               = substr($yearMonth,0,4);
        $month                              = substr($yearMonth,4,2);
        $department_ids                     = array_column($departments,'id');
        $where                              = array();
        $where['p.code']                    = array('like','S%');
        $where['a.departmentid']            = array('in',$department_ids); //全部业务人员
        $where['a.status']                  = array('neq',2); //已删除
        $account_lists                      = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
        $account_ids                        = array_column($account_lists,'id');
        $data                               = year_month_statis($year,$month,$account_ids);
        return $data;
    }

    /**
     * 求顾客满意度 年度 + 当月数据
     * @param $year
     * @param $month
     * @param $account_ids
     * @param int $type 0=> 部门 , 2=>个人
     * @return array
     */
    function year_month_statis($year,$month,$account_ids,$type=0){
        $year_cycle_times                   = get_year_cycle($year);
        $month_cycle_times                  = get_cycle($year.$month);

        //该年度实施的团
        $year_start_time                    = $year_cycle_times['beginTime'];
        $year_end_time                      = $year_cycle_times['endTime'];
        $where                              = array();
        $year_start_time                    = $year_start_time - 4*24*3600; //4天前实施的团
        $year_end_time                      = $year_end_time - 4*24*3600;
        $where['c.ret_time']                = array('between',array($year_start_time,$year_end_time));
        $where['o.create_user']             = array('in',$account_ids);
        //$where['o.in_dijie']                = array('neq',1); //排除发起团
        $year_shishi_lists                  = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $year_score_lists                   = array();
        $year_score_num                     = 0; //评分的团个数
        $year_op_average_sum                = 0; //平均分
        foreach ($year_shishi_lists as $k=>$v){
            //获取当年已评分的团
            $where                          = array();
            $where['o.op_id']               = $v['op_id'];
            $year_lists                     = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();


            if ($year_lists){ //已评分
                $year_score_num++;
                $year_op_average_data                = get_op_manyidu($year_lists); //单团满意度得分
                $year_op_average_sum                 += $year_op_average_data;
                $year_shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $year_shishi_lists[$k]['score_num']  = count($year_lists);
                $year_shishi_lists[$k]['op_average'] = ($year_op_average_data*100).'%';
                foreach ($year_lists as $key=>$value){
                    $year_score_lists[]              = $value;
                }
            }else{ //未评分
                $year_shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $year_shishi_lists[$k]['op_average'] = '0%';
            }
        }
        $year_score_average                    = (round($year_op_average_sum/$year_score_num,4)*100).'%'; //已调查顾客满意度
        $year_shishi_num                       = count($year_shishi_lists); //所有实施团的数量(包括未调查的数量)
        $year_average                          = round($year_op_average_sum/$year_shishi_num,4); //全部平均值
        $year_average                          = ($year_average*100).'%';  //总平均分,包括未调查的

        $data                                   = array();
        if ($type==2){
            $data['userid']                     = $account_ids[0];
            $data['username']                   = M('account')->where(array('id'=>$account_ids[0]))->getField('nickname');
        }
        $data['year_op_num']                   = count($year_shishi_lists);
        $data['year_score_num']                = $year_score_num;
        $data['year_score_average']            = $year_score_num?$year_score_average:'100%'; //已调查团的满意度
        $data['year_average']                  = $year_average; //所有顾客满意度(包括未调查)
        //$data['year_shishi_lists']           = $year_shishi_lists;
        //$data['year_score_lists']            = $year_score_lists;

        //该月度实施的团
        $month_start_time                   = $month_cycle_times['begintime'];
        $month_end_time                     = $month_cycle_times['endtime'];
        $where                              = array();
        $month_start_time                   = $month_start_time - 4*24*3600; //4天前实施的团
        $month_end_time                     = $month_end_time - 4*24*3600;
        $where['c.ret_time']                = array('between',array($month_start_time,$month_end_time));
        $where['o.create_user']             = array('in',$account_ids);
        //$where['o.in_dijie']                = array('neq',1); //排除发起团
        $month_shishi_lists                 = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $month_score_lists                  = array();
        $month_score_num                    = 0; //评分的团个数
        $month_op_average_sum               = 0; //平均分
        foreach ($month_shishi_lists as $k=>$v){
            //获取当月已评分的团
            $where                          = array();
            $where['o.op_id']               = $v['op_id'];
            $lists                          = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

            if ($lists){ //已评分
                $month_score_num++;
                $month_op_average_data                = get_op_manyidu($lists); //单团满意度得分
                $month_op_average_sum                 += $month_op_average_data;
                $month_shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $month_shishi_lists[$k]['score_num']  = count($lists);
                $month_shishi_lists[$k]['op_average'] = ($month_op_average_data*100).'%';
                foreach ($lists as $key=>$value){
                    $month_score_lists[]              = $value;
                }
            }else{ //未评分
                $month_shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $month_shishi_lists[$k]['op_average'] = '0%';
            }
        }
        $month_score_average                    = (round($month_op_average_sum/$month_score_num,4)*100).'%'; //已调查顾客满意度
        $month_shishi_num                       = count($month_shishi_lists); //所有实施团的数量(包括未调查的数量)
        $month_average                          = round($month_op_average_sum/$month_shishi_num,4); //全部平均值
        $month_average                          = ($month_average*100).'%';  //总平均分,包括未调查的

        $data['month_op_num']                   = count($month_shishi_lists);
        $data['month_score_num']                = $month_score_num;
        $data['month_score_average']            = $month_score_num?$month_score_average:'100%'; //已调查团的满意度
        $data['month_average']                  = $month_average; //所有顾客满意度(包括未调查)
        //$data['month_shishi_lists']           = $month_shishi_lists;
        //$data['month_score_lists']            = $month_score_lists;

        return $data;
    }

//获取部门当月合计
    function get_company_score_statis($departments,$yearMonth){
        $year                                   = substr($yearMonth,0,4);
        $month                                  = substr($yearMonth,4,2);
        $info                                   = array();
        foreach ($departments as $k=>$v){
            $where                              = array();
            $where['p.code']                    = array('like','S%');
            $where['a.departmentid']            = $v['id']; //本部门业务人员
            $where['a.status']                  = array('neq',2); //已删除
            $account_lists                      = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
            $account_ids                        = array_column($account_lists,'id');
            $data                               = year_month_statis($year,$month,$account_ids);

            $info[$k]['department_id']          = $v['id'];
            $info[$k]['department']             = $v['department'];
            $info[$k]['year_op_num']            = $data['year_op_num'];
            $info[$k]['year_score_num']         = $data['year_score_num'];
            $info[$k]['year_score_average']     = $data['year_score_average'];
            $info[$k]['year_average']           = $data['year_average'];
            $info[$k]['month_op_num']           = $data['month_op_num'];
            $info[$k]['month_score_num']        = $data['month_score_num'];
            $info[$k]['month_score_average']    = $data['month_score_average'];
            $info[$k]['month_average']          = $data['month_average'];
        }
        return $info;
    }


    /**
     * 获取某个部门每个人的客户满意度
     * @param string $year
     * @param string $month
     * @param $department_id
     * @param string $cycle
     * @param $startTime
     * @param $endTime
     * @return array
     */
function get_department_person_score_statis($year='',$month='',$department_id,$cycle='',$startTime='',$endTime=''){
    $account_lists                      = get_department_businessman($department_id);
    $lists                              = array();
    foreach ($account_lists as $k=>$v){
        $arr                            = array($v['id']);
        if ($cycle=='quarter'){
            $lists[$k]                  = quarter_statis($arr,$startTime,$endTime);
        }else{
            $lists[$k]                  =  year_month_statis($year,$month,$arr,2); //年度 + 月度满意度
        }
    }

    return $lists;
}

    /**
     * 获取季度顾客满意度信息
     * @param $account_ids
     * @param $year
     * @param $startTime
     * @param $endTime
     */
    function quarter_statis($account_ids,$startTime,$endTime){

        //该周期实施的团
        $where                          = array();
        $start_time                     = $startTime - 4*24*3600; //4天前实施的团
        $end_time                       = $endTime - 4*24*3600;
        $where['c.ret_time']            = array('between',array($start_time,$end_time));
        $where['o.create_user']         = array('in',$account_ids);
        //$where['o.in_dijie']            = array('neq',1); //排除发起团
        $shishi_lists                   = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $score_lists                    = array();
        $score_num                      = 0; //评分的团个数
        $op_average_sum                 = 0; //平均分
        foreach ($shishi_lists as $k=>$v){
            //获取当月已评分的团
            $where                      = array();
            $where['o.op_id']           = $v['op_id'];
            $lists                      = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

            if ($lists){ //已评分
                $score_num++;
                $op_average_data                = get_op_manyidu($lists); //单团满意度得分
                $op_average_sum                 += $op_average_data;
                $shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $shishi_lists[$k]['score_num']  = count($lists);
                $shishi_lists[$k]['op_average'] = ($op_average_data*100).'%';
                foreach ($lists as $key=>$value){
                    $score_lists[]              = $value;
                }
            }else{ //未评分
                $shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $shishi_lists[$k]['op_average'] = '0%';
            }
        }
        $score_average                  = (round($op_average_sum/$score_num,4)*100).'%'; //已调查顾客满意度
        $shishi_num                     = count($shishi_lists); //所有实施团的数量(包括未调查的数量)
        $average                        = round($op_average_sum/$shishi_num,4); //全部平均值
        $average                        = ($average*100).'%';  //总平均分,包括未调查的
        $data                           = array();
        $data['userid']                 = $account_ids[0];
        $data['username']               = M('account')->where(array('id'=>$account_ids[0]))->getField('nickname');
        $data['op_num']                 = count($shishi_lists);
        $data['score_num']              = $score_num;
        $data['score_average']          = $score_average; //已调查团的满意度
        $data['average']                = $average; //所有顾客满意度(包括未调查)
        //$data['shishi_lists']         = $shishi_lists;
        //$data['score_lists']          = $score_lists;
        return $data;
    }

    //获取单个团的客户满意度
    function get_op_manyidu($lists){
        $defen      = 0;
        foreach ($lists as $k=>$v){
            $defen += $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
        }
        $zongfen    = get_sum_score($lists);
        $score      = round($defen/$zongfen,2);
        return $score;
    }

    /**
     * quarter_month 自动计算当前季度
     * $month 月
     */
    function quarter_month1($month){
    switch ($month)
    {
        case 1:
            $statu    = 3;
            return $statu;die;
        case 2:
            $statu    = 3;
            return $statu;break;
        case 3:
            $statu    = 3;
            return $statu;break;
        case 4:
            $statu    = 6;
            return $statu;break;
        case 5:
            $statu    = 6;
            return $statu;break;
        case 6:
            $statu    = 6;
            return $statu;break;
        case 7:
            $statu    = 9;
            return $statu;break;
        case 8:
            $statu    = 9;
            return $statu;break;
        case 9:
            $statu    = 9;
            return $statu;break;
        case 10:
            $statu    = 12;
            return $statu;break;
        case 11:
            $statu    = 12;
            return $statu;break;
        case 12:
            $statu    = 12;
            return $statu;break;
    }
}

    /**
     * 获取公司当季度的预算(营收)营业收入
     * @param $year
     * @param $quarter
     */
    function get_quarter_plan_income($year,$quarter){
        $db                         = M('manage_input');
        $where                      = array();
        $where['logged_department'] = '公司';
        $where['datetime']          = $year;
        $where['type']              = $quarter;
        $where['statu']             = 4; //已通过审核
        $income_data                = $db->where($where)->find();
        return $income_data;
    }

    /**
     * 根据平均值求结果分(财务)
     */
    function get_rifht_avg($point,$snum){
            if ($point > -0.1 && $point <= 0.1){
                $score                  = $snum;
            }else {
                for ($i = 1; $i < 10; $i++) {
                    if (($point > '0.'.$i && $point <= '0.'.($i+1)) || ($point > '-0.'.($i+2) && $point <= '-0.'.($i+1))){
                        $score          = $snum - (10*$i);
                        if ($score < 0) $score = 0;
                        break;
                    }else{
                        $score          = 0;
                    }
                }
            }
        return $score;
    }

    /**
     * 根据平均值求结果分(人事)
     */
    function get_sum_avg($point,$snum){
        if ($point > 0){
            $score                  = 0;
        }elseif ($point <= 0 && $point >= -0.5){ //50%
            $score                  = $snum;
        } else {
            for ($i = 5; $i < 10; $i++) {
                if (($point >= '-0.'.($i+1) && $point < '-0.'.$i)){
                    $score          = $snum - (20*($i-4));
                    if ($score < 0) $score = 0;
                    break;
                }else{
                    $score          = 0;
                }
            }
        }
        return $score;
    }

/**
 * 获取当月计划回款金额
 * @param $userinfo
 * @param $begintime
 * @param $endtime
 * @return array
 */
function get_money_back_info($userinfo='',$starttime,$endtime){
    $where                                  = array();
    if ($userinfo) $where['payee']          = $userinfo['id'];
    $where['return_time']                   = array('lt',$endtime);
    $lists                                  = M('contract_pay')->where($where)->select();
    $data                                   = check_list($lists,$starttime,$endtime);
    return $data;
}

function get_department_money_back_list($departments,$begintime,$endtime){
    $data                               = array();
    foreach ($departments as $k=>$v){
        $data[$k]['id']                 = $v['id'];
        $data[$k]['department']         = $v['department'];
        $where                          = array();
        $where['p.code']                = array('like','S%');
        $where['a.departmentid']        = $v['id'];
        $count_lists                    = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
        foreach ($count_lists as $key=>$value){
            $info                       = get_money_back_info($value,$begintime,$endtime);
            $data[$k]['this_month']         += $info['this_month'];
            $data[$k]['history']            += $info['history'];
            $data[$k]['this_month_return']  += $info['this_month_return'];
        }
        $data[$k]['money_back_average']     = ($data[$k]['this_month']+$data[$k]['history'])?(round($data[$k]['this_month_return']/($data[$k]['this_month']+$data[$k]['history']),4)*100).'%':'100%';
    }
    return $data;
}

function get_sum($lists){
    $sum                                = array();
    $sum['this_month']                  = array_sum(array_column($lists,'this_month'));
    $sum['history']                     = array_sum(array_column($lists,'history'));
    $sum['this_month_return']           = array_sum(array_column($lists,'this_month_return'));
    $sum['sum_average']                 = (round($sum['this_month_return']/($sum['this_month']+$sum['history']),4)*100).'%';
    return $sum;
}

/**
 * 获取财务经理汇款及时率
 * @param $starttime
 * @param $endtime
 * @return array
 */
function get_hkjsl($starttime,$endtime){
    $yw_departs                         = C('YW_DEPARTS');  //业务部门id
    $where                              = array();
    $where['id']                        = array('in',$yw_departs);
    $departments                        = M('salary_department')->field('id,department')->where($where)->select();
    $lists                              = get_department_money_back_list($departments,$starttime,$endtime);
    $sum                                = get_sum($lists);
    return $sum;
}

function get_yw_department(){
    $yw_departs                         = C('YW_DEPARTS');  //业务部门id
    $where                              = array();
    $where['id']                        = array('in',$yw_departs);
    $departments                        = M('salary_department')->field('id,department')->where($where)->select();
    return $departments;
}

    function get_yw_department_kpi(){
        $yw_departs                         = C('YW_DEPARTS_KPI');  //业务部门id 排除常规业务中心
        $where                              = array();
        $where['id']                        = array('in',$yw_departs);
        $departments                        = M('salary_department')->field('id,department')->where($where)->select();
        return $departments;
    }

//获取部门当月合计
    function get_type_user_company_statis($departments,$yearMonth,$user_type){
        $year                                   = substr($yearMonth,0,4);
        $month                                  = substr($yearMonth,4,2);
        $info                                   = array();
        foreach ($departments as $k=>$v){
            $where                              = array();
            $where['p.code']                    = array('like','S%');
            $where['a.departmentid']            = $v['id']; //本部门业务人员
            $where['a.status']                  = array('neq',2); //已删除
            $account_lists                      = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
            $account_ids                        = array_column($account_lists,'id');
            $data                               = cycle_statis($year,$month,$account_ids,$user_type);

            $info[$k]['department_id']          = $v['id'];
            $info[$k]['department']             = $v['department'];
            $info[$k]['year_op_num']            = $data['year_op_num'];
            $info[$k]['year_score_num']         = $data['year_score_num'];
            $info[$k]['year_score_average']     = $data['year_score_average'];
            $info[$k]['year_average']           = $data['year_average'];
            $info[$k]['month_op_num']           = $data['month_op_num'];
            $info[$k]['month_score_num']        = $data['month_score_num'];
            $info[$k]['month_score_average']    = $data['month_score_average'];
            $info[$k]['month_average']          = $data['month_average'];
        }
        return $info;
    }

 //获取公司合计满意度
    function get_type_user_company_sum_statis($departments,$yearMonth,$user_type){
        $year                               = substr($yearMonth,0,4);
        $month                              = substr($yearMonth,4,2);
        $department_ids                     = array_column($departments,'id');
        $where                              = array();
        $where['p.code']                    = array('like','S%');
        $where['a.departmentid']            = array('in',$department_ids); //全部业务人员
        $where['a.status']                  = array('neq',2); //已删除
        $account_lists                      = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
        $account_ids                        = array_column($account_lists,'id');
        $data                               = cycle_statis($year,$month,$account_ids,$user_type);
        return $data;
    }

    /**
     * 求计调,研发,资源等岗位的顾客满意度
     * @param $year
     * @param $month
     * @param $account_ids
     * @param string $user_type 考核人员 jd=>计调,yf=>研发, zy=>资源
     * @param string $type ''=>部门 , 2=>人员
     * @return array
     */
    function cycle_statis($year,$month,$account_ids,$user_type,$type=''){
        $year_cycle_times                   = get_year_cycle($year);
        $month_cycle_times                  = get_cycle($year.$month);

        //该年度实施的团
        $year_start_time                    = $year_cycle_times['beginTime'];
        $year_end_time                      = $year_cycle_times['endTime'];
        $where                              = array();
        $year_start_time                    = $year_start_time - 4*24*3600; //4天前实施的团
        $year_end_time                      = $year_end_time - 4*24*3600;
        $where['c.ret_time']                = array('between',array($year_start_time,$year_end_time));
        $where['o.create_user']             = array('in',$account_ids);
        $where['o.in_dijie']                = array('neq',1); //排除发起团
        $year_shishi_lists                  = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $year_score_lists                   = array();
        $year_score_num                     = 0; //评分的团个数
        $year_op_average_sum                = 0; //平均分
        foreach ($year_shishi_lists as $k=>$v){
            //获取当年已评分的团
            $where                          = array();
            $where['o.op_id']               = $v['op_id'];
            $year_lists                     = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

            if ($year_lists){ //已评分
                $year_op_average_data                = get_type_user_manyidu($year_lists,$user_type); //单团满意度得分
                if ($year_op_average_data)           $year_score_num++;
                $year_op_average_sum                 += $year_op_average_data;
                $year_shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $year_shishi_lists[$k]['score_num']  = count($year_lists);
                $year_shishi_lists[$k]['op_average'] = ($year_op_average_data*100).'%';
                foreach ($year_lists as $key=>$value){
                    $year_score_lists[]              = $value;
                }
            }else{ //未评分
                $year_shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $year_shishi_lists[$k]['op_average'] = '0%';
            }
        }
        $year_score_average                    = $year_score_num?(round($year_op_average_sum/$year_score_num,4)*100).'%':'100%'; //已调查顾客满意度
        $year_shishi_num                       = count($year_shishi_lists); //所有实施团的数量(包括未调查的数量)
        $year_average                          = round($year_op_average_sum/$year_shishi_num,4); //全部平均值
        $year_average                          = ($year_average*100).'%';  //总平均分,包括未调查的

        $data                                  = array();
        if ($type==2){
            $data['userid']                    = $account_ids[0];
            $data['username']                  = M('account')->where(array('id'=>$account_ids[0]))->getField('nickname');
        }
        $data['year_op_num']                   = count($year_shishi_lists);
        $data['year_score_num']                = $year_score_num;
        $data['year_score_average']            = $year_score_average; //已调查团的满意度
        $data['year_average']                  = $year_average; //所有顾客满意度(包括未调查)
        //$data['year_shishi_lists']           = $year_shishi_lists;
        //$data['year_score_lists']            = $year_score_lists;

        //该月度实施的团
        $month_start_time                   = $month_cycle_times['begintime'];
        $month_end_time                     = $month_cycle_times['endtime'];
        $where                              = array();
        $month_start_time                   = $month_start_time - 4*24*3600; //4天前实施的团
        $month_end_time                     = $month_end_time - 4*24*3600;
        $where['c.ret_time']                = array('between',array($month_start_time,$month_end_time));
        $where['o.create_user']             = array('in',$account_ids);
        $month_shishi_lists                 = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $month_score_lists                  = array();
        $month_score_num                    = 0; //评分的团个数
        $month_op_average_sum               = 0; //平均分
        foreach ($month_shishi_lists as $k=>$v){
            //获取当月已评分的团
            $where                          = array();
            $where['o.op_id']               = $v['op_id'];
            $lists                          = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

            if ($lists){ //已评分
                $month_op_average_data                = get_type_user_manyidu($lists,$user_type); //单团满意度得分
                if ($month_op_average_data)           $month_score_num++; //有此评分信息的才加1
                $month_op_average_sum                 += $month_op_average_data;
                $month_shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $month_shishi_lists[$k]['score_num']  = count($lists);
                $month_shishi_lists[$k]['op_average'] = ($month_op_average_data*100).'%';
                foreach ($lists as $key=>$value){
                    $month_score_lists[]              = $value;
                }
            }else{ //未评分
                $month_shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $month_shishi_lists[$k]['op_average'] = '0%';
            }
        }
        $month_score_average                    = $month_score_num?(round($month_op_average_sum/$month_score_num,4)*100).'%':'100%'; //已调查顾客满意度
        $month_shishi_num                       = count($month_shishi_lists); //所有实施团的数量(包括未调查的数量)
        $month_average                          = round($month_op_average_sum/$month_shishi_num,4); //全部平均值
        $month_average                          = ($month_average*100).'%';  //总平均分,包括未调查的

        $data['month_op_num']                   = count($month_shishi_lists);
        $data['month_score_num']                = $month_score_num;
        $data['month_score_average']            = $month_score_average; //已调查团的满意度
        $data['month_average']                  = $month_average; //所有顾客满意度(包括未调查)
        //$data['month_shishi_lists']           = $month_shishi_lists;
        //$data['month_score_lists']            = $month_score_lists;
        return $data;
    }

    //获取计调/研发/资源单个团的客户满意度
    function get_type_user_manyidu($lists,$user_type){
        $zongfen                        = 0;
        $defen                          = 0;
        switch ($user_type){
            case 'jd': //计调
                foreach ($lists as $k=>$v){
                    if ($v['stay']      != 0) $zongfen +=5; //住宿
                    if ($v['food']      != 0) $zongfen +=5; //餐
                    if ($v['travel']    != 0) $zongfen +=5; //行程安排
                    if ($v['bus']       != 0) $zongfen +=5; //车况
                    if ($v['driver']    != 0) $zongfen +=5; //司机服务
                    $defen += $v['stay'] + $v['food'] + $v['travel'] + $v['bus'] + $v['driver'];
                }
                $score                  = round($defen/$zongfen,2);
                break;
            case 'yf': //研发
                foreach ($lists as $k=>$v){
                    if ($v['depth']     != 0) $zongfen +=5; //课程深度
                    if ($v['major']     != 0) $zongfen +=5; //课程专业性/内容专业性
                    if ($v['interest']  != 0) $zongfen +=5; //课程趣味性
                    if ($v['material']  != 0) $zongfen +=5; //材料及设备
                    $defen += $v['depth'] + $v['major'] + $v['interest'] + $v['material'];
                }
                $score                  = round($defen/$zongfen,2);
                break;
            case 'zy': //资源
                foreach ($lists as $k=>$v){
                    if ($v['cas_time']  != 0) $zongfen +=5; //中科院相关活动满足时长
                    if ($v['cas_complete'] != 0) $zongfen +=5; //中科院相关活动完整度
                    if ($v['cas_addr']  != 0) $zongfen +=5; //中科院单位场地服务
                    $defen += $v['cas_time'] + $v['cas_complete'] + $v['cas_addr'];
                }
                $score                  = round($defen/$zongfen,2);
                break;
        }
        return $score;
    }

    /**
     * 获取某个部门每个人的分项客户满意度
     * @param string $year
     * @param string $month
     * @param $department_id
     * @param string $cycle
     * @param $startTime
     * @param $endTime
     * @return array
     */
    function get_user_kpi_department_person_statis($year='',$month='',$department_id,$usertype='',$cycle='',$startTime='',$endTime=''){
        $account_lists                      = get_department_businessman($department_id);
        $lists                              = array();
        foreach ($account_lists as $k=>$v){
            $arr                            = array($v['id']);
            /*if ($cycle=='quarter'){
                $lists[$k]                  = quarter_statis($arr,$startTime,$endTime);
            }else{
                $lists[$k]                  =  year_month_statis($year,$month,$arr,2); //年度 + 月度满意度
            }*/
            $lists[$k]                      =  cycle_statis($year,$month,$arr,$usertype,2); //年度 + 月度满意度
        }

        return $lists;
    }

    /**
     * 月度顾客满意度(业务kpi)
     * @param $userid
     * @param $start_time
     * @param $end_time
     * @param string $gross_margin
     * @return array
     */
    function get_user_kpi_data($userid,$start_time,$end_time,$usertype=''){
        //当月实施的团
        $where                          = array();
        $start_time                     = $start_time - 4*24*3600; //4天前实施的团
        $end_time                       = $end_time - 4*24*3600;
        $where['c.ret_time']            = array('between',array($start_time,$end_time));
        $where['o.create_user']         = $userid;
        $where['o.in_dijie']            = array('neq',1); //排除发起团
        $shishi_lists                   = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->where($where)->select();

        $score_lists                    = array();
        $score_num                      = 0; //评分的团个数
        foreach ($shishi_lists as $k=>$v){
            //获取当月已评分的团
            $where                      = array();
            $where['o.op_id']           = $v['op_id'];
            $lists                      = M()->table('__TCS_SCORE__ as s')->field('u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();
            if ($lists){ //已评分
                $op_average_data                = get_type_user_manyidu($lists,$usertype);
                if ($op_average_data)           $score_num++;
                $shishi_lists[$k]['score_stu']  = '<span class="green">已评分</span>';
                $shishi_lists[$k]['score_num']  = count($lists);
                $shishi_lists[$k]['op_average'] = ($op_average_data*100).'%';
                foreach ($lists as $key=>$value){
                    $score_lists[]              = $value;
                }
            }else{ //未评分
                $shishi_lists[$k]['score_stu']  = '<span class="red">未评分</span>';
                $shishi_lists[$k]['op_average'] = '0%';
            }

            //满意度调查负责人信息
            $auth                       = M('op_guide_confirm')->where(array('op_id'=>$v['op_id']))->getField('charity_id',true);
            $str_auth_ids               = explode(',',implode(',',$auth));
            $auth_names                 = M('guide')->where(array('id'=>array('in',$str_auth_ids)))->getField('name',true);
            $shishi_lists[$k]['guide_manager']= implode(',',$auth_names);
        }
        $op_average_sum                 = array_sum(array_filter(explode(',',str_replace('%','',implode(',',array_column($shishi_lists,'op_average'))))));
        $score_average                  = round($op_average_sum/$score_num,2).'%'; //已调查顾客满意度
        $shishi_num                     = count($shishi_lists); //所有实施团的数量(包括未调查的数量)
        $average                        = round($op_average_sum/$shishi_num,2)/100; //全部平均值


        if ($shishi_num==0) { //当月目标为0
            $complete = '100%';
        }else{
            //总平均分,包括未调查的
            $complete = ($average*100).'%';
        }

        $data                           = array();
        $data['op_num']                 = count($shishi_lists);
        $data['score_num']              = $score_num;
        $data['score_average']          = $score_average; //已调查团的满意度
        $data['complete']               = $complete; //所有顾客满意度(包括未调查)
        $data['shishi_lists']           = $shishi_lists;
        $data['score_lists']            = $score_lists;
        return $data;
    }

    /**
     * 获取顾客满意度总分(分母)
     * @param $lists
     */
    function get_sum_score($lists){
        $sum                       = 0;
        foreach ($lists as $k=>$v){
            if ($v['before_sell']  !=0) $sum += 5;
            if ($v['new_media']    !=0) $sum += 5;
            if ($v['stay']         !=0) $sum += 5;
            if ($v['food']         !=0) $sum += 5;
            if ($v['bus']          !=0) $sum += 5;
            if ($v['travel']       !=0) $sum += 5;
            if ($v['content']      !=0) $sum += 5;
            if ($v['driver']       !=0) $sum += 5;
            if ($v['guide']        !=0) $sum += 5;
            if ($v['teacher']      !=0) $sum += 5;
            if ($v['depth']        !=0) $sum += 5;
            if ($v['major']        !=0) $sum += 5;
            if ($v['interest']     !=0) $sum += 5;
            if ($v['material']     !=0) $sum += 5;
            if ($v['late']         !=0) $sum += 5;
            if ($v['manage']       !=0) $sum += 5;
            if ($v['morality']     !=0) $sum += 5;
            if ($v['cas_time']     !=0) $sum += 5;
            if ($v['cas_complete'] !=0) $sum += 5;
            if ($v['cas_addr']     !=0) $sum += 5;
        }
        return $sum;
    }

    /**
     * 季度利润总额目标完成率
     * @param $target
     * @param $complete
     */
    function get_plus_minus_data($target,$complete){
        if ($target > 0){ //目标为正
            $rate                   = round($complete/$target,2);
        }else{
            $rate                   = 2 - (round($complete/$target,2));
        }
        $rate                       = $rate > 0 ? $rate*100 : '0';
        return $rate;
    }

    /**
     * 获取人事费用率KPI得分
     * @param $target 目标值
     * @param $comp 实际完成值
     */
    function get_rsfyl_rate($target,$comp){
        if ($comp <= $target){
            //实际值不超过计划值得满分
            $rate       = 100;
        }else{ //大于指标值
            if ($comp > $target && $comp < $target+1){
                $rate   = 80; //小于一个百分点 80%
            }elseif ($comp > $target+1 && $comp < $target+2){
                $rate   = 60; //大于一个百分点点 , 小于2个百分点 60%
            } elseif ($comp > $target+2 && $comp < $target+3){
                $rate   = 40; //大于2个百分点点 , 小于3个百分点 40%
            }elseif ($comp > $target+3 && $comp < $target+4){
                $rate   = 20; //大于3个百分点点 , 小于4个百分点 20%
            }else{
                $rate   = 0;
            }
        }
        return $rate;
    }

    /**
     * 根据不同的岗位, 满意度指数不同, 获取不同的结果
     * @param $v
     * @param $data 满意度评分情况
     */
    function get_kpi_satis($v,$data){
        $num                    = $data['num']; //评分次数
        $average                = $data['average']; //评分平均分
        if (in_array($v['quota_id'],array(155))){ //155->研发经理
            if ($average >= 0.9 || !$num){ //90%满分
                $complete       = '100%';
            }else{
                $complete       = (round(($average/0.9),2)*100).'%';
            }
        }elseif (in_array($v['quota_id'],array(193))){ //193->财务经理
            if ($average >= 0.8 || !$num){ //80%满分
                $complete       = '100%';
            }else{
                $complete       = (round(($average/0.8),2)*100).'%';
            }
        }else{ ////206=>人事, 212->计调部经理指标,214->安全品控部经理指标,218=>市场 , 219=>资源
            if ($average >= 0.85 || !$num){ //85%满分
                $complete       = '100%';
            }else{
                $complete       = (round(($average/0.85),2)*100).'%';
            }
        }
        return $complete;
    }

    /**
     * 获取今年的考核周期 和 去年的考核周期
     * @param $year
     * @param $month
     */
    function get_years_cycle($year,$month){
        $day                                    = 26;
        $now_day                                = date('d');
        if ($month.$now_day > 1225){ //今年考核周期
            $cycle['this_year_start_time']      = strtotime(($year-1).'1226'); ;
            $cycle['this_year_end_time']        = strtotime(($year-1).'12'.$now_day.date('His'));
        }else{
            $cycle['this_year_start_time']      = strtotime(($year-1).'1226');
            $cycle['this_year_end_time']        = strtotime($year.$month.$day);
        }

        //去年考核周期
        $cycle['last_year_start_time']          = strtotime(($year-2).'1226');
        if ($now_day > 26){
            $cycle['last_year_end_time']        = strtotime(($year-1).$month.'26');
        }else{
            $cycle['last_year_end_time']        = strtotime(($year-1).$month.date('dHis'));
        }
        return $cycle;
    }

    //获取公司 当年 和 上一年 总毛利率
    function get_manage_data($cycle){
        $chart_mod                      = D('Chart');
        $thisYearTimes                  = array();
        $thisYearTimes['yearBeginTime'] = $cycle['this_year_start_time'];
        $thisYearTimes['yearEndTime']   = $cycle['this_year_end_time'];
        $lastYearTimes                  = array();
        $lastYearTimes['yearBeginTime'] = $cycle['last_year_start_time'];
        $lastYearTimes['yearEndTime']   = $cycle['last_year_end_time'];

        $yw_departs                     = C('YW_DEPARTS');  //业务部门id
        $userlists                      = M('account')->where(array('departmentid'=>array('in',$yw_departs)))->getField('id,nickname',true);
        $userids                        = array_keys($userlists);

        $info                           = array();
        $info[0]['users']               = $userids;
        $info[0]['depname']             = '公司';
        $thisYearData                   = $chart_mod->js_deplist($info,'',$thisYearTimes);
        $lastYearData                   = $chart_mod->js_deplist($info,'',$lastYearTimes);
        $data                           = array();
        $data['thisYear_zsr']           = $thisYearData['heji']['yearzsr'];
        $data['thisYear_zml']           = $thisYearData['heji']['yearzml'];
        $data['thisYear_mll']           = $thisYearData['heji']['yearmll'];
        $data['lastYear_zsr']           = $lastYearData['heji']['yearzsr'];
        $data['lastYear_zml']           = $lastYearData['heji']['yearzml'];
        $data['lastYear_mll']           = $lastYearData['heji']['yearmll'];
        return $data;
    }

    function get_special_manage_data($cycle){
        $chart_mod                      = D('Chart');
        $thisYearTimes                  = array();
        $thisYearTimes['yearBeginTime'] = $cycle['this_year_start_time'];
        $thisYearTimes['yearEndTime']   = $cycle['this_year_end_time'];
        $lastYearTimes                  = array();
        $lastYearTimes['yearBeginTime'] = $cycle['last_year_start_time'];
        $lastYearTimes['yearEndTime']   = $cycle['last_year_end_time'];

        $yw_departs                     = C('YW_DEPARTS');  //业务部门id
        $userlists                      = M('account')->where(array('departmentid'=>array('in',$yw_departs)))->getField('id,nickname',true);
        $userids                        = array_keys($userlists);

        $info                           = array();
        $info[0]['users']               = $userids;
        $info[0]['depname']             = '公司';
        $thisYearData                   = special_js_deplist($info,$thisYearTimes['yearBeginTime'],$thisYearTimes['yearEndTime']);
        $lastYearData                   = special_js_deplist($info,$lastYearTimes['yearBeginTime'],$lastYearTimes['yearEndTime']);
        $data                           = array();
        $data['thisYear_zsr']           = $thisYearData['heji']['yearzsr'];
        $data['thisYear_zml']           = $thisYearData['heji']['yearzml'];
        $data['thisYear_mll']           = $thisYearData['heji']['yearmll'];
        $data['lastYear_zsr']           = $lastYearData['heji']['yearzsr'];
        $data['lastYear_zml']           = $lastYearData['heji']['yearzml'];
        $data['lastYear_mll']           = $lastYearData['heji']['yearmll'];
        return $data;
    }

    function special_js_deplist($userlists, $begin_time,$end_time){
        $chart_mod                      = D('Chart');
        $lists                      = array();
        foreach ($userlists as $k => $v) {
            //年度累计
            $where                  = array();
            $where['b.audit_status']= 1;
            $where['l.req_type']    = 801;
            $where['l.audit_time']  = array('between', "$begin_time,$end_time");
            $where['a.id']          = array('in', $v['users']);
            if ($begin_time >= strtotime('20181226')){ //2019年以后的团排除其他和南北极合作
                $where['o.kind']    = array('not in',array(3,86));
            }

            $field                  = array();
            $field[]                = 'count(o.id) as xms';
            $field[]                = 'sum(c.num_adult) as renshu';
            $field[]                = 'sum(b.shouru) as zsr';
            $field[]                = 'sum(b.maoli) as zml';
            $field[]                = '(sum(b.maoli)/sum(b.shouru)) as mll';

            $yearlist               = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();

            $lists['all']['yearxms']     = $yearlist['xms'] ? $yearlist['xms'] : 0;
            $lists['all']['yearrenshu']  = $yearlist['renshu'] ? $yearlist['renshu'] : 0;
            $lists['all']['yearzsr']     = $yearlist['zsr'] ? $yearlist['zsr'] : "0.00";
            $lists['all']['yearzml']     = $yearlist['zml'] ? $yearlist['zml'] : "0.00";
            $lists['all']['yearmll']     = $yearlist['mll'] ? sprintf("%.2f", $yearlist['mll'] * 100) : "0.00";
        }

        //地接团信息
        $dj_opids       = get_djopid();
        //地接年累计
        $req_type       = 801;  //结算
        $dj_js_opids    = $chart_mod->get_dj_js_opids($begin_time, $end_time, $req_type,$dj_opids);
        $dj_js_opids    = array_column($dj_js_opids,'op_id');
        $dj_yeardata    = $chart_mod->get_dj_js_info($begin_time,$end_time,$dj_js_opids);

        $dj_heji                    = array();
        $dj_heji['yearxms']         = $dj_yeardata['xms'];
        $dj_heji['yearrenshu']      = $dj_yeardata['renshu'];
        $dj_heji['yearzsr']         = $dj_yeardata['zsr'];
        $dj_heji['yearzml']         = $dj_yeardata['zml'];
        $dj_heji['yearmll']         = sprintf("%.2f", ($dj_heji['yearzml'] / $dj_heji['yearzsr']) * 100);

        $heji                       = array();
        $heji['yearxms']            = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu']         = array_sum(array_column($lists, 'yearrenshu')) - $dj_yeardata['renshu'];
        $heji['yearzsr']            = array_sum(array_column($lists, 'yearzsr')) - $dj_yeardata['zsr'];
        $heji['yearzml']            = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll']            = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $lists['heji']              = $heji;
        $lists['dj_heji']           = $dj_heji;
        return $lists;
    }

    /**
     * 获取预算准确度
     * @param $real 实际值
     * @param $plan 预算值
     */
    function get_exact_budget($real,$plan){
        if ($real < $plan){ //实际值 < 计划值
            if ($plan == 0){ //计划值为0
                $res                    = $real - $plan;
            }else{
                $res                    = round(($real - $plan)/$plan,4); //(实际值 - 计划值)/计划值
            }
        }else{
            if ($plan == 0){ //计划值为0
                $res                    = $real - $plan;
            }elseif ($real > 0 && $plan < 0){ //实际正,计划负
               $res                     = round(1-(($real - $plan)/$plan),4); // 1-(实际-计划)/计划
           }else{
                $res                    = round(($real - $plan)/$plan,4); //(实际值 - 计划值)/计划值
           }
        }
        return $res;
    }

    /**
     * 公司季度预算信息
     * @param $userid
     * @param $month
     * @return mixed
     */
    function get_company_budget($year,$month){
        $quarter                    = get_quarter($month);  //获取季度信息
        $quarters                   = get_all_quarters($quarter);
        $year                       = $year?$year:date("Y");
        $where                      = array();
        $where['datetime']          = $year;
        $where['type']              = array('in',$quarters);
        $where['logged_department'] = '公司';
        $field                      = 'sum(employees_number) as sum_employees_number,sum(logged_income) as sum_logged_income,sum(logged_profit) as sum_logged_profit, sum(manpower_cost) as sum_manpower_cost, sum(other_expenses) as sum_other_expenses, sum(total_profit) as sum_total_profit,sum(target_profit) as sum_target_profit';
        $budget                     = M('manage_input')->where($where)->field($field)->find();
        return $budget;
    }

    //获取从年初累计的季度信息
    function get_all_quarters($quarter){
        $arrs                       = array(1,2,3,4); //季度
        $quarters                   = array();
        foreach ($arrs as $v){
            if ($v <= $quarter){
                $quarters[]         = $v;
            }
        }
        return $quarters;
    }

    /**
     * 公司经营信息(年度累计)
     * @param $department
     * @param $year
     * @param $month
     * @param $type 'm'=>月度 'q'=>季度 'y'=>年度
     * @return array
     */
    function get_company_operate($department,$year,$month){
        $mod                       = D('Manage');
        //$quart                     = quarter_month1($month);  //季度月份
        $quarter                   = get_quarter($month); //季度

        $yms                       = year_to_now_yms($year,$quarter);  //获取累计到当前季度(含)的所有月份
        $times                     = year_to_now_times($year,$quarter);    //获取累计到当前季度(含)的开始及结束时间戳

        $ymd[0]                    = date("Ymd",$times['beginTime']);
        $ymd[1]                    = date("Ymd",$times['endTime']);
        $mon                       = not_team_not_share($ymd[0],$ymd[1]);//年度其他费用取出数据(不分摊)
        $mon_share                 = not_team_share($ymd[0],$ymd[1]);//年度其他费用取出数据(分摊)
        $otherExpenses             = $mod->department_data($mon,$mon_share);//年度其他费用部门数据

        $number                    = $mod->get_numbers($year,$yms);    //年度平均人数
        $hr_cost                   = $mod->get_quarter_hr_cost($year,$yms,$times);// 年度部门人力资源成本
        $profit                    = get_business_sum($year,$yms);// 年度 monthzsr 收入合计   monthzml 毛利合计  monthmll 毛利率
        $human_affairs             = $mod->human_affairs($hr_cost,$profit);//年度 人事费用率
        $total_profit              = $mod->total_profit($profit,$hr_cost,$otherExpenses);//年度 利润总额

        $info                      = array();
        $info['ygrs']              = $number[$department];             //部门员工人数
        $info['yysr']              = $profit[$department]['monthzsr']; //营业收入
        $info['yyml']              = $profit[$department]['monthzml']; //营业毛利
        $info['yymll']             = $profit[$department]['monthmll']; //营业毛利率
        $info['rlzycb']            = $hr_cost[$department];            //人力资源成本
        $info['qtfy']              = $otherExpenses[$department]['money'];      //其他费用
        $info['lrze']              = $total_profit[$department];       //利润总额
        $info['rsfyl']             = $human_affairs[$department];      //人事费用率

        return $info;
    }

    /**
     * 获取年初累计到当前季度所有的月份
     * @param $year 年
     * @param $quarter 季度
     * @return array
     */
    function year_to_now_yms($year,$quarter){
        $yms                        = array();
      switch ($quarter){
          case 1:
              $sum                  = 3;
              break;
          case 2:
              $sum                  = 6;
              break;
          case 3:
              $sum                  = 9;
              break;
          case 4:
              $sum                  = 12;
              break;
      }

      for ($i=1;$i<=$sum;$i++){
          $n                        = $i;
          if (strlen($n) < 2) $n    = str_pad($n,2,'0',STR_PAD_LEFT);
          $yms[]                    = $year.$n;
      }
      return$yms;
    }

    /**
     * 获取累计到当前季度(含)的开始及结束时间戳
     * @param $year
     * @param $quarter
     */
    function year_to_now_times($year,$quarter){
        switch ($quarter){
            case 1:
                $m                  = '03';
                break;
            case 2:
                $m                  = '06';
                break;
            case 3:
                $m                  = '09';
                break;
            case 4:
                $m                  = '12';
                break;
        }
        $prveyear                   = $year-1;
        $times                      = array();
        $times['beginTime']         = strtotime($prveyear.'1226');
        $times['endTime']           = strtotime($year.$m.'26');
        return $times;
    }

    //员工流失率
    function get_person_loss($start_time,$end_time){
        //全部人员信息
        $where                      = array();
        $where['id']                = array('gt',10);
        $where['status']            = array('in',array(0,1));
        $where['input_time']        = array('lt',$end_time);
        $where['nickname']          = array('not in',array('孟华华','李岩1','魏春竹1'));
        $sum_lists                  = M('account')->where($where)->order('id asc')->getField('id,nickname,formal,status,expel',true);

        //本月离职人员
        $loss                       = array();
        $loss['status']             = array('in',array(1,2)); //1=>停用,2=>删除
        $loss['expel']              = 0; //排除公司辞退人员
        $loss['formal']             = 1; //正式员工
        $loss['end_time']           = array('between',array($start_time,$end_time));
        $loss['nickname']           = array('not in',array('孟华华','李岩1','魏春竹1'));
        $loss_lists                 = M('account')->where($loss)->getField('id,nickname,formal,status,expel',true);

        $data                       = array();
        $data['sum_num']            = count($sum_lists);
        $data['loss_num']           = count($loss_lists);
        $data['sum_lists']          = $sum_lists;
        $data['loss_lists']         = $loss_lists;
        return $data;
    }

    //获取所有的地接团opid
    function get_djopid(){
        $arr                        = M('op')->getField('dijie_opid',true);
        $opids                      = array_filter($arr);
        return $opids;
    }

    //获取本周期内累计的城市合伙人收入
    function get_partner($user_id,$start_time,$end_time){
        $partner_db                 = M('Customer_partner');
        $deposit_db                 = M('customer_deposit');
        $partner_ids                = $partner_db->where(array('cm_id'=>$user_id,'audit_stu'=>2))->getField('id',true);
        $where                      = array();
        $where['start_date']        = array('between',"$start_time,$end_time");
        $where['end_date']          = array('between',"$start_time,$end_time");
        $where['_logic']            = 'or';
        $map['_complex']            = $where;
        $map['partner_id']          = array('in',$partner_ids);
        $lists                      = $deposit_db->where($map)->select();

        $data                       = array();
        $data['money']              = array_sum(array_column($lists,'money'));
        $data['lists']              = $lists;
        return $data;
    }

    //城市合伙人满意度评分
    function get_partner_satisfaction($uid,$month){
        $month                      = explode(',',$month);
        $db                         = M('partner_satisfaction');
        $where                      = array();
        $where['account_id']        = $uid;
        $where['monthly']           = array('in',$month);
        $where['status']            = 1; //已评分
        $lists                      = $db->where($where)->select();

        $number                     = 0; //评分次数
        $score_num                  = 0; //评分得分
        $dimension_num              = 0; //维度合计
        foreach ($lists as $k=>$v){
            if ($v['AA']) $dimension_num++;
            if ($v['BB']) $dimension_num++;
            if ($v['CC']) $dimension_num++;
            if ($v['DD']) $dimension_num++;
            if ($v['DD']) $dimension_num++;
            $score_num              += $v['AA'] + $v['BB'] + $v['CC'] + $v['DD'] + $v['EE'];
            $number++;
        }
        $score_sum                  = $dimension_num * 5;
        $average                    = round($score_num/$score_sum,2);
        $data                       = array();
        $data['average']            = $average;
        $data['number']             = $number;
        $data['lists']              = $lists;
        return $data;
    }

    //获取部门主管信息
    function get_department_manager($uid){
        $where                      = array();
        $where['a.id']              = $uid;
        $field                      = 'a.id as userid,a.nickname as username,d.*';
        $data                       = M()->table('__ACCOUNT__ as a')->join('__SALARY_DEPARTMENT__ as d on d.id = a.departmentid','left')->field($field)->where($where)->find();
        return $data;
    }

    //判断是不是地接团
    function is_dijie($opid){
        $arr_opid                   = get_dijie_opids();
        $data                       = array();
        if (in_array($opid,$arr_opid)){
            $create_op              = M('op')->where(array('dijie_opid'=>$opid))->find(); //发起团信息
            $data['is_dijie']       = 1;
            $data['op_id']          = $create_op['op_id'];
            $data['group_id']       = $create_op['group_id'];
            $data['project']        = $create_op['project'];
            $data['create_user_id'] = $create_op['create_user'];
            $data['create_user_name'] = $create_op['create_user_name'];
        }else{
            $data                   = '';
        }
        return $data;
    }

    //所有的内部地接团
    function get_dijie_opids(){
        $dijie_opid                 = array_filter(M('op')->getField('dijie_opid',true));
        return $dijie_opid;
    }

    //外部客户满意度二维码链接
    function get_qrcode_url($opid){
        $dijie_opids                = get_dijie_opids();
        if(in_array($opid,$dijie_opids)) {
            $zutuan_data                = is_dijie($opid);
            $zutuan_opid                = $zutuan_data['op_id'];
            $qrcode_url                 = 'http://tcs.kexueyou.com/op.php?m=Main&c=Score&a=index&opid='.$zutuan_opid;
            //$qrcode_url                 = 'http://www.tcs.com/op.php?m=Main&c=Score&a=index&opid='.$zutuan_opid;
        }else{
            $qrcode_url                 = 'http://tcs.kexueyou.com/op.php?m=Main&c=Score&a=index&opid='.$opid;
            //$qrcode_url                 = 'http://www.tcs.com/op.php?m=Main&c=Score&a=index&opid='.$opid;
        }
        return $qrcode_url;
    }

    //获取当前考核周期'院内接待资源方开发
    function get_cas_res($start_time,$end_time){
        $db                             = M('cas_res');
        /*$where                          = array();
        $where['input_time']            = array('between',array($start_time,$end_time));
        $where['audit_status']          = 1; //审核通过
        $list                           = $db ->where($where)->select();*/

        $where                          = array();
        $where['req_type']              = 200; //P::REQ_TYPE_SCIENCE_RES_NEW
        $where['audit_time']            = array('between',array($start_time,$end_time));
        $where['dst_status']            = 1;
        $list                           = M('audit_log')->where($where)->select();
        $res_ids                        = array_column($list,'req_id');

        $data                           = array();
        $data['num']                    = count($list);
        $data['res_ids']                = $res_ids;
        return $data;
    }

    function get_little_title($year,$month=''){
        $month                          = $month?str_pad($month,2,'0',STR_PAD_LEFT):date('m');
        $data                           = array();
        $data[0]['title']               = '全部';
        switch ($month){
            case in_array($month,array('01','02')): //寒假
                $data[1]['title']       = ($year+1).'年寒假';
                $data[1]['year']        = ($year+1).'-1';
                $data[2]['title']       = ($year+1).'年春季';
                $data[2]['year']        = ($year+1).'-2';
                $data[3]['title']       = $year.'年暑假';
                $data[3]['year']        = $year.'-3';
                $data[4]['title']       = $year.'年秋季';
                $data[4]['year']        = $year.'-4';
                break;
            case in_array($month,array('03','04','05','06')): //春季
                $data[1]['title']       = ($year+1).'年寒假';
                $data[1]['year']        = ($year+1).'-1';
                $data[2]['title']       = ($year+1).'年春季';
                $data[2]['year']        = ($year+1).'-2';
                $data[3]['title']       = ($year+1).'年暑假';
                $data[3]['year']        = ($year+1).'-3';
                $data[4]['title']       = $year.'年秋季';
                $data[4]['year']        = $year.'-4';
                break;
            case in_array($month,array('07','08')): //暑假
                $data[1]['title']       = ($year+1).'年寒假';
                $data[1]['year']        = ($year+1).'-1';
                $data[2]['title']       = ($year+1).'年春季';
                $data[2]['year']        = ($year+1).'-2';
                $data[3]['title']       = ($year+1).'年暑假';
                $data[3]['year']        = ($year+1).'-3';
                $data[4]['title']       = ($year+1).'年秋季';
                $data[4]['year']        = ($year+1).'-4';
                break;
            case in_array($month,array('09','10','11','12')): //秋季
                $data[1]['title']       = ($year+2).'年寒假';
                $data[1]['year']        = ($year+2).'-1';
                $data[2]['title']       = ($year+1).'年春季';
                $data[1]['year']        = ($year+1).'-2';
                $data[3]['title']       = ($year+1).'年暑假';
                $data[1]['year']        = ($year+1).'-3';
                $data[4]['title']       = ($year+1).'年秋季';
                $data[1]['year']        = ($year+1).'-4';
                break;
        }
        return $data;
    }

    function get_apply_time($title,$pin=0){
        $data                           = array();
        if (in_array($pin,array(1,2,3,4))){
            $data['ayear']              = substr($title[$pin]['year'],0,4);
            $data['atime']              = substr($title[$pin]['year'],-1);
        }else{
            $data['ayear']              = '0';
            $data['atime']              = '0';
        }
        return $data;
    }

    function get_files($ids){
        $db                             = M('attachment');
        $lists                          = $db->where(array('id'=>array('in',$ids)))->select();
        return $lists;
    }

    /**获取项目类型(解决以前被删除的项目类型对数据的影响)
     * @param $kid
     * @return array
     */
    function get_kids($kid){
        $kind_db                = M('project_kind');
        $kind_ids               = $kind_db->getField('id',true);
        $last_id                = $kind_db->order('id desc')->getField('id');
        $del_ids                = array();
        if ($kid == 3){
            $del_ids[]          = 3;
            for ($i=1;$i<$last_id;$i++){
                if (!in_array($i,$kind_ids)){
                    $del_ids[]  = $i;
                }
            }
            $arr                = $del_ids;
        }else{
            $arr                = array($kid);
        }
        return $arr;
    }

    /**
     * 获取该周期结算的团
     * @param $begin_time
     * @param $end_time
     * @param $sale_uid 销售id
     * @param int $jd_uid 计调id
     * @return mixed
     */
    function get_settlement_list($begin_time,$end_time,$sale_uid=0,$jd_uid=0){
        $where                                  = array();
        $where['b.audit_status']                = 1;
        $where['l.req_type']                    = 801;
        $where['l.audit_time']                  = array('between', "$begin_time,$end_time");
        if ($sale_uid) $where['o.create_user']  = $sale_uid;
        if ($jd_uid) $where['l.req_uid']        = $jd_uid;
        $field                                  = 'o.op_id,o.project,o.group_id,o.create_user,o.create_user_name,b.shouru,b.maoli,l.req_uid,l.req_uname,l.req_time,l.audit_time'; //获取所有该季度结算的团
        $op_settlement_list                     = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        return $op_settlement_list;
    }

    /**
     * 获取计调的满意度评分
     * @param $settlement_lists
     */
    function get_jd_satis_chart($settlement_lists){
        $operator                               = array_unique(array_column($settlement_lists,'req_uname','req_uid'));
        $data                                   = array();
        foreach ($operator as $k => $v){
            $data[$k]                           = get_jd_satis($k,$settlement_lists);
            $data[$k]['jd_uid']                 = $k;
            $data[$k]['jd_name']                = $v;
        }
        return $data;
    }

    /**
     * 获取单个计调的满意度数据
     * @param $uid
     * @param $lists
     */
    function get_jd_satis($uid,$lists){
        $list                               = array(); //总操作的的团
        $score_list                         = array();  //已评分的团
        $zongfen                            = 0; //总分
        $yipingfen                          = 0; //已评分总分
        $defen                              = 0; //已得分
        $num                                = 0; //所有团数量
        $score_num                          = 0; //已评分团数量
        foreach ($lists as $key => $value){
            if ($value['req_uid'] == $uid){
                $s_list                     = get_jd_op_score($value['op_id']);
                $list[]                     = $value;
                if ($s_list) {
                    $score_list[]           = $s_list;
                    $score_num++;
                    $defen                  += $s_list['ysjsx'] + $s_list['zhunbei'] + $s_list['peixun'] + $s_list['genjin'] + $s_list['yingji'];
                    $yipingfen              += 5*5; //5各维度,每个维度5颗星
                }
                $zongfen                    += 5*5;
                $num++;
            }
        }
        $data                               = array();
        $data['zongfen']                    = $zongfen;
        $data['yipingfen']                  = $yipingfen;
        $data['defen']                      = $defen;
        $data['num']                        = $num;
        $data['score_num']                  = $score_num;
        $data['score_average']              = (round($defen/$yipingfen,4)*100).'%'; //已评分得分
        $data['sum_average']                = (round($defen/$zongfen,4)*100).'%'; //合计得分(包含未评分的)
        $data['score_list']                 = $score_list;
        $data['list']                       = $list;
        return $data;
    }

    /**
     * 获取计调某个团的评分信息
     * @param $opid
     * @return mixed
     */
    function get_jd_op_score($opid){
        $db                                     = M('op_score');
        $field                                  = 'op_id,pf_id,pf_name,ysjsx,zhunbei,peixun,genjin,yingji,jd_content,jd_uid,jd_uname,jd_score_time';
        $where                                  = array();
        $where['op_id']                         = $opid;
        $where['ysjsx']                         = array('neq',0);
        $list                                   = $db->where($where)->field($field)->find();
        return $list;
    }

    /**
     * 获取公司总的计调满意度信息
     * @param $lists
     */
    function get_company_jd_statis($lists){
        $score_list                         = array();  //已评分的团
        $zongfen                            = 0; //总分
        $yipingfen                          = 0; //已评分总分
        $defen                              = 0; //已得分
        $num                                = 0; //所有团数量
        $score_num                          = 0; //已评分团数量
        foreach ($lists as $key => $value){
            $s_list                         = get_jd_op_score($value['op_id']);
            if ($s_list) {
                $score_list[]               = $s_list;
                $score_num++;
                $defen                      += $s_list['ysjsx'] + $s_list['zhunbei'] + $s_list['peixun'] + $s_list['genjin'] + $s_list['yingji'];
                $yipingfen                  += 5*5; //5各维度,每个维度5颗星
            }
            $zongfen                        += 5*5;
            $num++;
        }
        $data                               = array();
        $data['zongfen']                    = $zongfen;
        $data['yipingfen']                  = $yipingfen;
        $data['defen']                      = $defen;
        $data['num']                        = $num;
        $data['score_num']                  = $score_num;
        $data['score_average']              = (round($defen/$yipingfen,4)*100).'%'; //已评分得分
        $data['sum_average']                = (round($defen/$zongfen,4)*100).'%'; //合计得分(包含未评分的)
        $data['score_list']                 = $score_list;
        $data['list']                       = $lists;
        $data['jd_name']                    = '合计';
        return $data;
    }

    /**
     *  获取本周期报价及时性
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     */
    function get_costacc_data($startTime,$endTime,$title='',$content='',$uid=''){
        $where                              = array();
        if ($uid){ $where['c.input_user_id']= $uid; }
        $where['c.create_time']             = array('between',"$startTime,$endTime");
        $field                              = 'o.op_id,o.group_id,o.project,o.create_user,o.create_user_name,o.create_time as op_create_time,c.*';
        $costacc_list                       = M()->table('__OP_COSTACC_RES__ as c')->join('__OP__ as o on o.op_id=c.op_id','left')->where($where)->field($field)->select();
        $ok_list                            = array();
        $sum_num                            = 0;
        $ok_num                             = 0;
        foreach ($costacc_list as $k=>$v){
            $sum_num++;
            $ok_time                        = strtotime(getAfterWorkDay(3,$v['op_create_time'])); //立项后3个工作日
            $costacc_list[$k]['ok_time']    = $ok_time;
            $costacc_list[$k]['type']       = $title;
            if ($v['create_time'] <= $costacc_list[$k]['ok_time']){
                $v['ok_time']               = $ok_time;
                $ok_list[]                  = $v;
                $costacc_list[$k]['is_ok']  = 1;
                $ok_num++;
            }
        }

        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['sum_list']                   = $costacc_list;
        $data['ok_list']                    = $ok_list;
        return $data;
    }

    /**
     *  获取本周期预算及时性
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     */
    function get_budget_data($startTime,$endTime,$title='',$content='',$uid=''){
        $budget_list                        = get_budget_list($startTime,$endTime,'',$uid);
        $ok_list                            = array();
        $sum_num                            = 0;
        $ok_num                             = 0;

        foreach ($budget_list as $k=>$v){
            $sum_num++;
            $ok_time                        = $v['req_time'] + (3*24*3600); //req_time 提交时间
            $budget_list[$k]['ok_time']     = $ok_time;
            $budget_list[$k]['type']        = $title;
            if ($v['dep_time'] >= $ok_time){
                $v['ok_time']               = $ok_time;
                $ok_list[]                  = $v;
                $budget_list[$k]['is_ok']   = 1;
                $ok_num++;
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['sum_list']                   = $budget_list;
        $data['ok_list']                    = $ok_list;
        return $data;
    }

    /**
     * 获取该周期结算的团
     * @param $begin_time
     * @param $end_time
     * @param $sale_uid 销售id
     * @param int $jd_uid 计调id
     * @return mixed
     */
    function get_budget_list($begin_time,$end_time,$sale_uid=0,$jd_uid=0){
        $where                                  = array();
        $where['b.audit_status']                = 1;
        $where['l.req_type']                    = 800;
        $where['l.audit_time']                  = array('between', "$begin_time,$end_time");
        if ($sale_uid) $where['o.create_user']  = $sale_uid;
        if ($jd_uid) $where['l.req_uid']        = $jd_uid;
        $field                                  = 'o.op_id,o.project,o.group_id,o.create_user,o.create_user_name,b.shouru,b.maoli,l.req_uid,l.req_uname,l.req_time,l.audit_time,c.dep_time,c.ret_time'; //获取所有该季度结算的团
        $op_budget_list                         = M()->table('__OP_BUDGET__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=b.op_id','left')->where($where)->select();
        return $op_budget_list;
    }

    /**
     *  获取本周期结算及时性
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     */
    function get_settlement_data($startTime,$endTime,$title='',$content='',$uid=''){
        $settlement_list                        = get_settlement_list($startTime,$endTime,'',$uid);
        $ok_list                                = array();
        $sum_num                                = 0;
        $ok_num                                 = 0;
        $sum_list                               = array();
        foreach ($settlement_list as $k=>$v){
            //判断是否完全回款
            $money_back_stu                     = check_money_back($v['op_id']);
            if ($money_back_stu == 1){ //已全部回款
                //回款审核时间
                $where                          = array();
                $where['h.op_id']               = $v['op_id'];
                $where['h.audit_status']        = 1; //审核通过
                $where['l.req_type']            = 802; //回款
                $field                          = 'h.op_id,l.req_time,l.audit_time';
                $back_money_data                = M()->table('__OP_HUIKUAN__ as h')->join('__AUDIT_LOG__ as l on l.req_id = h.id','left')->where($where)->field($field)->order('h.id desc')->find();
                $back_money_time                = $back_money_data['audit_time'];

                $ok_time                        = strtotime(getAfterWorkDay(10,$back_money_time));
                $sum_num++;
                $v['ok_time']                   = $ok_time;
                $v['type']                      = $title;
                if ($v['req_time'] <= $ok_time){ //req_time 提交时间
                    $v['ok_time']               = $ok_time;
                    $ok_list[]                  = $v;
                    $v['is_ok']                 = 1;
                    $ok_num++;
                }
                $sum_list[]                     = $v;
            }
        }

        $data                                   = array();
        $data['title']                          = $title;
        $data['content']                        = $content;
        $data['sum_num']                        = $sum_num;
        $data['ok_num']                         = $ok_num;
        $data['average']                        = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['sum_list']                       = $sum_list;
        $data['ok_list']                        = $ok_list;
        return $data;
    }

    /**
     * 判断该团是否已完成回款(按照应回款金额)
     * @param $opid
     * @return int
     */
    function check_money_back($opid){
    $huikuan_lists          = M('op_huikuan')->where(array('op_id'=>$opid,'audit_status'=>1))->select();
    $yihuikuan              = array_sum(array_column($huikuan_lists,'huikuan'));

    //合同金额
    //$contract_amount        = M('contract')->where(array('op_id'=>$opid,'status'=>1))->getField('contract_amount');
    //应回款金额
    $contract_pay_lists     = M('contract_pay')->where(array('op_id'=>$opid))->select();
    $contract_amount        = array_sum(array_column($contract_pay_lists,'amount'));
    //地接团结算不受回款限制
    $dijie_opids            = get_dijie_opids();
    //暂未排除未立合同的项目

    if (($yihuikuan >= $contract_amount || in_array($opid,$dijie_opids)) && $contract_pay_lists){ //(&& $contract_pay_lists)以免2019年以前的数据干扰
        $money_back         = 1;    //已回款
    }else{
        $money_back         = 0;    //未回款
    }
    return $money_back;
}


    /**
     *  获取本周期报账及时性
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     * reimbursement
     */
    function get_reimbursement_data($startTime,$endTime,$title='',$content='',$uid=''){
        //$reimbursement_list                 = get_reimbursement_list($startTime,$endTime,'',$uid);
        $reimbursement_list                 = '';
        $ok_list                            = array();
        $sum_num                            = 0;
        $ok_num                             = 0;

        foreach ($reimbursement_list as $k=>$v){
            $reimbursement_list[$k]['ok_time']= '';
            $reimbursement_list[$k]['type'] = $title;
            $reimbursement_list[$k]['is_ok']= 1;
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['sum_list']                   = $reimbursement_list;
        $data['ok_list']                    = $ok_list;
        return $data;
    }

    //获取公司全部人员信息
    function get_company_user(){
        $where                      = array();
        $where['id']                = array('gt',10);
        $where['status']            = array('in',array(0,1));
        $where['nickname']          = array('not in',array('孟华华','李岩1','魏春竹1'));
        $lists                      = M('account')->where($where)->order('id asc')->getField('id,nickname,formal,status,expel',true);
        return $lists;
    }

    /**
     * 相关指标
     * @param $type 1=>计调操作及时性指标 2=>不合格处理率指标
     * @return mixed
     */
    function get_timely($type=0){
        $db                             = M('quota');
        $where                          = array();
        $where['status']                = 0; //正常使用
        $where['type']                  = $type;
        $list                           = $db->where($where)->select();
        foreach ($list as $k=>$v){
            $list[$k]['title']          = htmlspecialchars_decode($v['title']);
            $list[$k]['content']        = htmlspecialchars_decode($v['content']);
            $list[$k]['rules']          = htmlspecialchars_decode($v['rules']);
        }
        return $list;
    }

    //删除相关指标
    function timely_quota_del($id){
        $db                             = M('quota');
        $data                           = array();
        $data['status']                 = 1; //删除
        $where                          = array();
        $where['id']                    = $id;
        $res                            = $db->where($where)->save($data);
        return $res;
    }

    /**
     *  单项顾客满意度(不合格处理率)排除总满意度小于90%的团
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     */
    function get_unqualify_lg3_data($startTime,$endTime,$title='',$content=''){
        $unqualify_data                     = get_lg3_list($startTime,$endTime); //十个工作日前的不合格团
        $sum_list                           = array();
        $sum_opid                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_opid                            = array();
        $ok_num                             = 0;
        $solve_lists                        = get_solve_op_list($startTime,$endTime);

        foreach ($unqualify_data as $k=>$v){
            $sum_num++;
            $sum_list[]                     = $v;
            $sum_opid[]                     = $v['op_id'];
            foreach ($solve_lists as $key=>$value){
                if ($v['op_id'] == $value['op_id'] && in_array($value['status'],array(1,2))){
                    $ok_num++;
                    $ok_list[]              = $value;
                    $ok_opid[]              = $value['op_id'];
                }
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_opid']                    = $ok_opid;
        $data['sum_opid']                   = $sum_opid;
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        $data['url']                        = U('Inspect/public_unqualify_detail',array('isop'=>1,'st'=>$startTime,'et'=>$endTime,'tp'=>1));
        return $data;
    }

    //少于三星或低于60分；10个工作日处理完成
    function get_lg3_list($startTime,$endTime){
        //排除总满意度小于90%的团
        $lg90percent_data                   = get_unqualify_lg_90percent_data($startTime,$endTime);
        $lg90percent_opids                  = $lg90percent_data['sum_opid'];

        //获取10个工作日前的考核周期
        $n                                  = 12;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];

        $where                              = array();
        $where['s.input_time']	            = array('between',array($work_startTime,$work_endTime));
        $where['u.op_id']                   = array('not in',$lg90percent_opids);
        $field                              = 'u.op_id,s.input_time,o.kind,s.id as sid,s.before_sell,s.new_media,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality,s.cas_time,s.cas_complete,s.cas_addr';
        $score_lists                        = M()->table('__TCS_SCORE__ as s')->field($field)->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

        $unok_arr                           = array(1,2,3);
        foreach ($score_lists as $k=>$v){
            $zongfen                = 0;
            $defen                  = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
            if ($v['before_sell']   !=0) $zongfen += 5;
            if ($v['new_media']     !=0) $zongfen += 5;
            if ($v['stay']          !=0) $zongfen += 5;
            if ($v['food']          !=0) $zongfen += 5;
            if ($v['bus']           !=0) $zongfen += 5;
            if ($v['travel']        !=0) $zongfen += 5;
            if ($v['content']       !=0) $zongfen += 5;
            if ($v['driver']        !=0) $zongfen += 5;
            if ($v['guide']         !=0) $zongfen += 5;
            if ($v['teacher']       !=0) $zongfen += 5;
            if ($v['depth']         !=0) $zongfen += 5;
            if ($v['major']         !=0) $zongfen += 5;
            if ($v['interest']      !=0) $zongfen += 5;
            if ($v['material']      !=0) $zongfen += 5;
            if ($v['late']          !=0) $zongfen += 5;
            if ($v['manage']        !=0) $zongfen += 5;
            if ($v['morality']      !=0) $zongfen += 5;
            if ($v['cas_time']      !=0) $zongfen += 5;
            if ($v['cas_complete']  !=0) $zongfen += 5;
            if ($v['cas_addr']      !=0) $zongfen += 5;
            $score                  = round($defen/$zongfen,2);
            //单项少于3颗星或低于60分
            if ($score < 0.8 || (in_array($v['before_sell'],$unok_arr) || in_array($v['new_media'],$unok_arr) || in_array($v['stay'],$unok_arr) || in_array($v['travel'],$unok_arr) || in_array($v['content'],$unok_arr) || in_array($v['food'],$unok_arr) || in_array($v['bus'],$unok_arr) || in_array($v['driver'],$unok_arr) || in_array($v['guide'],$unok_arr) || in_array($v['teacher'],$unok_arr) || in_array($v['depth'],$unok_arr) || in_array($v['major'],$unok_arr) || in_array($v['interest'],$unok_arr) || in_array($v['material'],$unok_arr) || in_array($v['late'],$unok_arr) || in_array($v['manage'],$unok_arr) || in_array($v['morality'],$unok_arr) || in_array($v['cas_time'],$unok_arr) || in_array($v['cas_complete'],$unok_arr) || in_array($v['cas_addr'],$unok_arr))){
                $unok_list[$k]['score']         = $score;
                $unok_list[$k]['op_id']         = $v['op_id'];
                $unok_list[$k]['input_time']    = $v['input_time'];
            }
        }
        return $unok_list;
    }

    /**
     *  项目顾客满意度(不合格处理率)
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $uid
     * @return array
     */
    function get_unqualify_lg_90percent_data($startTime,$endTime,$title='',$content=''){
        //获取10个工作日前的考核周期
        $n                                  = 12;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];
        $unqualify_data                     = get_lg_90percent_list($work_startTime,$work_endTime); //十个工作日前的不合格团
        $sum_list                           = array();
        $sum_opid                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_opid                            = array();
        $ok_num                             = 0;
        $solve_lists                        = get_solve_op_list($startTime,$endTime);

        foreach ($unqualify_data as $k=>$v){
            $sum_num++;
            $sum_list[]                     = $v;
            $sum_opid[]                     = $v['op_id'];
            foreach ($solve_lists as $key=>$value){
                if ($v['op_id'] == $value['op_id']  && in_array($value['status'],array(1,2))){
                    $ok_num++;
                    $ok_list[]              = $value;
                    $ok_opid[]              = $value['op_id'];
                }
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_opid']                    = $ok_opid;
        $data['sum_opid']                   = $sum_opid;
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        //$data['url']                        = U('Inspect/public_unqualify_detail',array('isop'=>1,'st'=>$startTime,'et'=>$endTime,'tp'=>2,'opids'=>implode(',',$sum_opid)));
        $data['url']                        = U('Inspect/public_unqualify_detail',array('isop'=>1,'st'=>$startTime,'et'=>$endTime,'tp'=>2));
        return $data;
    }


    //项目顾客满意度(以项目为基数)	低于90%；10个工作日处理完成
    function get_lg_90percent_list($startTime,$endTime){
        $score_lists                        = get_month_satisfaction($startTime,$endTime); //总评分列表
        $op_ids                             = array_unique(array_column($score_lists,'op_id'));

        $unok_list                          = array();
        foreach ($op_ids as $value){
            $zongfen                        = 0;
            $defen                          = 0;
            foreach ($score_lists as $k=>$v){
                if ($v['op_id'] == $value){
                    $defen                  += $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
                    if ($v['before_sell']   !=0) $zongfen += 5;
                    if ($v['new_media']     !=0) $zongfen += 5;
                    if ($v['stay']          !=0) $zongfen += 5;
                    if ($v['food']          !=0) $zongfen += 5;
                    if ($v['bus']           !=0) $zongfen += 5;
                    if ($v['travel']        !=0) $zongfen += 5;
                    if ($v['content']       !=0) $zongfen += 5;
                    if ($v['driver']        !=0) $zongfen += 5;
                    if ($v['guide']         !=0) $zongfen += 5;
                    if ($v['teacher']       !=0) $zongfen += 5;
                    if ($v['depth']         !=0) $zongfen += 5;
                    if ($v['major']         !=0) $zongfen += 5;
                    if ($v['interest']      !=0) $zongfen += 5;
                    if ($v['material']      !=0) $zongfen += 5;
                    if ($v['late']          !=0) $zongfen += 5;
                    if ($v['manage']        !=0) $zongfen += 5;
                    if ($v['morality']      !=0) $zongfen += 5;
                    if ($v['cas_time']      !=0) $zongfen += 5;
                    if ($v['cas_complete']  !=0) $zongfen += 5;
                    if ($v['cas_addr']      !=0) $zongfen += 5;
                }
            }
            $score                          = round($defen/$zongfen,2);
            if ($score < 0.8){ //单团满意度得分低于90%计入不合格
                $unok_list[$value]['score'] = $score;
                $unok_list[$value]['op_id'] = $value;
                $unok_list[$value]['input_time'] = $v['input_time'];
            }
        }

        return $unok_list;
    }

    /**
     * 获取几个工作日前的日期
     * @param int $n
     * @param $startTime
     * @param $endTime
     * @return array
     */
    function get_before_work_day($n=0,$startTime,$endTime){
        $data                               = array();
        $data['startTime']                  = $startTime - (60*60*$n);
        $data['endTime']                    = $endTime - (60*60*$n);
        return $data;
    }

    //获取已处理的所有不合格项目
    function get_solve_op_list(){
        $db                                 = M('qaqc');
        $where                              = array();
        $where['is_op']                     = 1;
        //$where['status']                    = 1; //审核通过
        $field                              = 'id,title,is_op,group_id,op_id,month,type,status,handle_time,ex_time';
        $list                               = $db ->where($where)->field($field)->select();
        return $list;
    }

    //获取本周期内的不合格数据
    function get_unqualify_nop_list($type=0,$startTime,$endTime){
        $db                                 = M('qaqc');
        $where                              = array();
        $where['type']                      = $type;
        $where['create_time']               = array('between',array($startTime,$endTime));
        $field                              = 'id,title,is_op,group_id,op_id,month,type,status,create_time,handle_time,ex_time';
        $list                               = $db ->where($where)->field($field)->select();
        return $list;
    }

    /**
     * 顾客有效投诉
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $content
     * @return array
     */
    function get_complaint_data($startTime,$endTime,$title='',$content=''){
        //获取10个工作日前的考核周期
        $n                                  = 12;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];
        $type                               = 3; //C('QAQC_TYPE')=>'顾客投诉'
        $unqualify_data                     = get_unqualify_nop_list($type,$work_startTime,$work_endTime); //十个工作日前的顾客有效投诉

        $sum_list                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_num                             = 0;
        $ids                                = array();

        foreach ($unqualify_data as $k=>$v){
            $ids[]                          = $v['id'];
            $sum_num++;
            $sum_list[]                     = $v;
            if ($v['ex_time'] != 0 && in_array($v['status'],array(1,2))){ //跟进处理时间不为0
                $ok_num++;
                $ok_list[]              = $v;
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        $data['url']                        = U('Inspect/public_unqualify_detail',array('ids'=>implode(',',$ids)));
        return $data;
    }

    /**
     * 安全责任事故
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $content
     * @return array
     */
    function get_safe_data($startTime,$endTime,$title='',$content=''){
        //获取10个工作日前的考核周期
        $n                                  = 12;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];
        $type                               = 4; //C('QAQC_TYPE')=>'安全责任事故'
        $unqualify_data                     = get_unqualify_nop_list($type,$work_startTime,$work_endTime); //十个工作日前的安全责任事故

        $sum_list                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_num                             = 0;
        $ids                                = array();

        foreach ($unqualify_data as $k=>$v){
            $ids[]                          = $v['id'];
            $sum_num++;
            $sum_list[]                     = $v;
            if ($v['ex_time'] != 0  && in_array($v['status'],array(1,2))){ //跟进处理时间不为0
                $ok_num++;
                $ok_list[]              = $v;
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        $data['url']                        = U('Inspect/public_unqualify_detail',array('ids'=>implode(',',$ids)));
        return $data;
    }

    /**
     * 公司内部有效投诉
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $content
     * @return array
     */
    function get_company_complaint_data($startTime,$endTime,$title='',$content=''){
        //获取5个工作日前的考核周期
        $n                                  = 7;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];
        $type                               = 5; //C('QAQC_TYPE')=>'公司内部有效投诉'
        $unqualify_data                     = get_unqualify_nop_list($type,$work_startTime,$work_endTime); //5个工作日前的公司内部有效投诉

        $sum_list                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_num                             = 0;
        $ids                                = array();

        foreach ($unqualify_data as $k=>$v){
            $ids[]                          = $v['id'];
            $sum_num++;
            $sum_list[]                     = $v;
            if ($v['ex_time'] != 0 && in_array($v['status'],array(1,2))){ //跟进处理时间不为0
                $ok_num++;
                $ok_list[]              = $v;
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        $data['url']                        = U('Inspect/public_unqualify_detail',array('ids'=>implode(',',$ids)));
        return $data;
    }

    /**
     * 品质检查
     * @param $startTime
     * @param $endTime
     * @param string $title
     * @param string $content
     * @return array
     */
    function get_company_qaqc_data($startTime,$endTime,$title='',$content=''){
        //获取5个工作日前的考核周期
        $n                                  = 7;
        $before_work_day                    = get_before_work_day($n,$startTime,$endTime);
        $work_startTime                     = $before_work_day['startTime'];
        $work_endTime                       = $before_work_day['endTime'];
        $type                               = 6; //C('QAQC_TYPE')=>'品质检查'
        $unqualify_data                     = get_unqualify_nop_list($type,$work_startTime,$work_endTime); //5个工作日前的品质检查

        $sum_list                           = array();
        $sum_num                            = 0;
        $ok_list                            = array();
        $ok_num                             = 0;
        $ids                                = array();

        foreach ($unqualify_data as $k=>$v){
            $ids[]                          = $v['id'];
            $sum_num++;
            $sum_list[]                     = $v;
            if ($v['ex_time'] != 0  && in_array($v['status'],array(1,2))){ //跟进处理时间不为0
                $ok_num++;
                $ok_list[]              = $v;
            }
        }
        $data                               = array();
        $data['title']                      = $title;
        $data['content']                    = $content;
        $data['sum_num']                    = $sum_num;
        $data['ok_num']                     = $ok_num;
        $data['average']                    = $sum_num ? (round($ok_num/$sum_num,4)*100).'%' : '100%';
        $data['ok_list']                    = $ok_list;
        $data['sum_list']                   = $sum_list;
        $data['url']                        = U('Inspect/public_unqualify_detail',array('ids'=>implode(',',$ids)));
        return $data;
    }

