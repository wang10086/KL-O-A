<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;

class AaaprintController extends BasepubController {


    public function index(){
        $monthly                        = trim(I('month'));
        $archives                       = trim(I('archives'));
        $datetime                       = trim(I('datetime'));
        $name                           = trim(I('name'));//名字
        if(is_numeric($monthly) && is_numeric($archives)){
            $dateti['datetime']         = $monthly;
            $sql                    = 'SELECT *,month.status as mstatus FROM oa_salary_wages_month as month, oa_account as account where month.account_id=account.id AND account.archives='.$archives.' AND month.datetime='.$monthly;
            if($name!==""){
                $sql .= ' AND month.user_name='.$name;
            }
            $user_info = M()->query($sql);
            $info                       = $this->arraysplit($user_info);
            $sum                        = $this->countmoney($archives,$info,1);//部门合计
            $summoney                   = $this->summoney($sum); //总合计
            $status                     = $user_info[0]['mstatus'];
            if($status=="" || $status==0){
                $status                 = 1;
            }
        }else{
            if(!empty($archives)){
                $info                   = $this->salary_excel_sql($archives,$name);//员工信息
                $sum                    = $this->countmoney($archives,$info);//部门合计
                $summoney               = $this->summoney($sum); //总合计
            }elseif(is_numeric($monthly)){
                $dateti['datetime']     = $monthly;
                if($name!==""){
                    $dateti['user_name']= $name;
                }
                $wages_month            = M('salary_wages_month')->where($dateti)->select();//已经提交数据
                $info                   = $this->arraysplit($wages_month);
                $sum                    = M('salary_departmen_count')->where($dateti)->select();
                $summoney               = M('salary_count_money')->where($dateti)->find();
                $status                 = $wages_month[0]['status'];
            }else{
                $wher['status']     = 3;
                if($name!==""){
                    $wher['user_name']  = $name;
                }
                $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                if(!$wages_month){
                    $wher['status']     = 2;
                    if($name!==""){
                        $wher['user_name']  = $name;
                    }
                    $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                    if(!$wages_month) {
                        $info           = $this->salary_excel_sql($archives,$name);//员工信息
                        $sum            = $this->countmoney('',$info);//部门合计
                        $summoney       = $this->summoney($sum); //总合计
                        $status         = 1;
                    }else{
                        $info           = $this->arraysplit($wages_month);
                        $sum            = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                        $summoney       = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                        $status         = 2;
                    }
                }else{
                    $info               = $this->arraysplit($wages_month);
                    $sum                = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                    $summoney           = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                    $status             = 3;
                }
            }
        }
        $userid                         = (int)$_SESSION['userid'];//用户id

//        $this->assign('number1',count($info));//员工数量
//        $this->assign('number2',count($sum));//部门数量
        $this->assign('info',$info);//员工信息 inf
        $this->assign('type',$archives);//状态
        $this->assign('sum',$sum);//部门合计 su
        $this->assign('count',$summoney);//总合计 coun
        $this->assign('time',$datetime);//表时间
        $this->assign('status',$status);//提交状态
        $this->assign('userid',$userid);//提交状态
		$this->display();
    }

    public function bbb(){//判断权限
        $monthly                        = trim(I('month'));
        $archives                       = trim(I('archives'));
        $datetime                       = trim(I('datetime'));
        $name                           = trim(I('name'));//名字
        if(is_numeric($monthly) && is_numeric($archives)){
            $dateti['datetime']         = $monthly;
            $sql                    = 'SELECT *,month.status as mstatus FROM oa_salary_wages_month as month, oa_account as account where month.account_id=account.id AND account.archives='.$archives.' AND month.datetime='.$monthly;
            if($name!==""){
                $sql .= ' AND month.user_name='.$name;
            }
            $user_info = M()->query($sql);
            $info                       = $this->arraysplit($user_info);
            $sum                        = $this->countmoney($archives,$info,1);//部门合计
            $summoney                   = $this->summoney($sum); //总合计
            $status                     = $user_info[0]['mstatus'];
            if($status=="" || $status==0){
                $status                 = 1;
            }
        }else{
            if(!empty($archives)){
                $info                   = $this->salary_excel_sql($archives,$name);//员工信息
                $sum                    = $this->countmoney($archives,$info);//部门合计
                $summoney               = $this->summoney($sum); //总合计
            }elseif(is_numeric($monthly)){
                $dateti['datetime']     = $monthly;
                if($name!==""){
                    $dateti['user_name']= $name;
                }
                $wages_month            = M('salary_wages_month')->where($dateti)->select();//已经提交数据
                $info                   = $this->arraysplit($wages_month);
                $sum                    = M('salary_departmen_count')->where($dateti)->select();
                $summoney               = M('salary_count_money')->where($dateti)->find();
                $status                 = $wages_month[0]['status'];
            }else{
                $wher['status']     = 3;
                if($name!==""){
                    $wher['user_name']  = $name;
                }
                $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                if(!$wages_month){
                    $wher['status']     = 2;
                    if($name!==""){
                        $wher['user_name']  = $name;
                    }
                    $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                    if(!$wages_month) {
                        $info           = $this->salary_excel_sql($archives,$name);//员工信息
                        $sum            = $this->countmoney('',$info);//部门合计
                        $summoney       = $this->summoney($sum); //总合计
                        $status         = 1;
                    }else{
                        $info           = $this->arraysplit($wages_month);
                        $sum            = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                        $summoney       = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                        $status         = 2;
                    }
                }else{
                    $info               = $this->arraysplit($wages_month);
                    $sum                = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                    $summoney           = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                    $status             = 3;
                }
            }
        }
        $userid                         = (int)$_SESSION['userid'];//用户id

//        $this->assign('number1',count($info));//员工数量
//        $this->assign('number2',count($sum));//部门数量
        $this->assign('info',$info);//员工信息 inf
        $this->assign('type',$archives);//状态
        $this->assign('sum',$sum);//部门合计 su
        $this->assign('count',$summoney);//总合计 coun
        $this->assign('time',$datetime);//表时间
        $this->assign('status',$status);//提交状态
        $this->assign('userid',$userid);//提交状态
        $this->display();
    }

    private function salary_excel_sql($archives,$name){
        if($name!==""){
            $where['nickname']                  = $name;
        }
        $where['archives']                          = $archives;
        if($archives==null || $archives==false){
            unset($where['archives']);
        }
        $where['status'] = array('between','0,1');
        $info                                       =  M('account')->where($where)->order('id ASC')->select();//个人数据
        foreach($info as $k => $v){//去除编码空的数据
            if($v['employee_member'] == ""){
                unset($info[$k]);
            }
        }
        foreach($info as $key =>$val) {//薪资详情
            $user_info[$key]['account']             = $val;
            $id['account_id']                       = $val['id'];
            $department['id']                       = $val['departmentid'];//部门
            $user_info[$key]['department']          = sql_query(1,'*','oa_salary_department',$department,1,1);//查询部门
            $posts['id']                            = $val['postid'];
            $user_info[$key]['posts']               = sql_query(1,'*','oa_posts',$posts,1,1);//查询岗位
            $user_info[$key]['salary']              = sql_query(1,'*','oa_salary',$id, 1, 1);//岗位薪酬
            $att_id['account_id']                   = $val['id'];
            $att_id['status']                       = 1;
            $user_info[$key]['attendance']          = sql_query(1,'*','oa_salary_attendance',$att_id, 1, 1);//员工考核
            $user_bonus                             = sql_query(1,'*','oa_salary_bonus',$att_id, 1, 1);//提成/奖金/年终奖
            $generate_month                         = datetime(date('Y'),date('m'),date('d'),1);//获取当前年月
            $bonus_extract                          = Acquisition_Team_Subsidy($generate_month,$val['guide_id']);//带团补助
            $user_info[$key]['bonus']               = $user_bonus;
            $user_info[$key]['bonus'][0]['extract'] = $bonus_extract;
            $user_info[$key]['labour']              = M('salary_labour')->where($id)->order('id desc')->find();//工会会费
            if(count($user_info[$key]['salary'])==0){
                unset($user_info[$key]);continue;
            }
            $income                                 = sql_query(1,'*','oa_salary_income',$att_id, 1,1);//其他收入
            $countmoney                             = 0;
            if ($income) {
                $token['income_token']              = $income[0]['income_token'];
                $user_info[$key]['income']          = sql_query(1,'*','oa_salary_income', $token,1,2);//其他收入所有项目
                foreach($user_info[$key]['income'] as $ke =>$va){
                    $countmoney                     += $va['income_money'];
                }
            }
            $user_info[$key]['insurance']           = sql_query(1,'*','oa_salary_insurance', $id, 1,1);//五险一金表
            $user_info[$key]['insurance_Total']     = round(($user_info[$key]['insurance'][0]['pension_ratio']*$user_info[$key]['insurance'][0]['pension_base']+$user_info[$key]['insurance'][0]['medical_care_ratio']*$user_info[$key]['insurance'][0]['medical_care_base']+$user_info[$key]['insurance'][0]['unemployment_ratio']*$user_info[$key]['insurance'][0]['unemployment_base']+round($user_info[$key]['insurance'][0]['accumulation_fund_ratio']*$user_info[$key]['insurance'][0]['accumulation_fund_base'])+$user_info[$key]['insurance'][0]['big_price']),2);//五险一金

            $user_info[$key]['accumulation']        = round(($user_info[$key]['insurance'][0]['accumulation_fund_ratio']*$user_info[$key]['insurance'][0]['accumulation_fund_base']),0);

            $user_info[$key]['subsidy']             = sql_query(1,'*','oa_salary_subsidy', $id,1,1);//补贴
            $withholding                            = sql_query(1,'*','oa_salary_withholding', $id,1,1);//代扣代缴

            if ($withholding) {
                $wit['token']                       = $withholding[0]['token'];
                $wit['account_id']                  = $val['id'];
                $wit                                = array_filter($wit);
                $user_info[$key]['withholding']     = sql_query(1,'*','oa_salary_withholding',$wit,1,2);//代扣代缴

                foreach($user_info[$key]['withholding'] as $kk =>$vv){
                    $user_info[$key]['summoney']    += $vv['money']; //总代扣代缴
                }
            }
            // kpi  pdca 品质检查
            $que['p.tab_user_id']                   = $val['id'];//用户id
            $que['p.month']                         = datetime(date('Y'),date('m'),date('d'),1);
            $user                                   = $this->query_score($que);//绩效增减
            $use1                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['total_score_show']));//PDCA
            $use2                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['show_qa_score']));//品质检查
            $use3                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['total_kpi_score']));//KPI
            $money                                  = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['performance_salary'];//绩效金额
            $branch                                 = 100;//给总共100分

            if($val['formal']==0 || $val['formal']==4) {
                $use3 = 0;
            }
            $f = $use1+$use2+$use3;//获得总分
            if(substr($f,0,1)=='-'){
                $user_info[$key]['Achievements']['count_money']     = (substr($f,0,1)).(round(($money/$branch*(substr($f,1))),2));
            }else{
                $user_info[$key]['Achievements']['count_money']     = (substr($f,0,1)).(round(($money/$branch*(substr($f,1))),2));
            }
            $user_info[$key]['Achievements']['total_score_show']    = $use1;//pdca分数
            $user_info[$key]['Achievements']['show_qa_score']       = $use2;//品质检查分数
            $user_info[$key]['Achievements']['sum_total_score']     = $use3;//KPI分数

            //如果做季度提成可以变为奖金放开屏蔽即可
//            if($user_info[$key]['bonus'][0]['annual_bonus']!==0 && !empty($user_info[$key]['bonus'][0]['annual_bonus'])){
//                $Year_end = $user_info[$key]['Extract']['total'];
//                 unset($user_info[$key]['Extract']['total']);
//                $user_info[$key]['Extract']['total']= $user_bonus;
//
//            }else{
//                 $user_info[$key]['Extract']['total']    = $user_info[$key]['Extract']['total']+$user_bonus;//提成相加
//            }
            $user_price                             = $this->salary_kpi_month(100,$que['p.month'],1); //业务人员 目标任务 完成 提成
            $user_info[$key]['Extract']['total']    = $user_price['total']+$user_bonus[0]['bonus'];//提成相加
            $extract                                = $user_info[$key]['Extract']['total'];
//            $Year_end                               = $Year_end;//如果做季度提成可以变为奖金放开屏蔽即可
            $Year_end                               = ($user_info[$key]['bonus'][0]['annual_bonus'])/12;
            if($Year_end < 1500){
                $price1                             = $Year_end*0.03;
            }
            if($Year_end > 1500 && $Year_end < 4500){
                $price1                             = $Year_end*0.1-105;
            }
            if($Year_end > 4500 && $Year_end < 9000){
                $price1                             = $Year_end*0.2-555;
            }
            if($Year_end > 9000 && $Year_end < 35000){
                $price1                             = $Year_end*0.25-1055;
            }
            if($Year_end > 35000 && $Year_end < 55000){
                $price1                             = $Year_end*0.3-2755;
            }
            if($Year_end > 55000 && $Year_end < 80000){
                $price1                             = $Year_end*0.35-5505;
            }
            if($Year_end>80000){
                $price1                             = $Year_end*0.45-13505;
            }
            $user_info[$key]['yearend']             = round($price1,2);//年终奖计税

            //其他补款 = 其他补贴变动 + 外地补贴 + 电脑补贴
            $user_info[$key]['Other']               = round(($countmoney+$user_info[$key]['subsidy'][0]['foreign_subsidies']+$user_info[$key]['subsidy'][0]['computer_subsidy']),2);

            // 提成 + 奖金+带团补助+年终奖+住房补贴+外地补贴+电脑补贴+提成
            $user_info[$key]['welfare']             = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$bonus_extract+$extract+$user_info[$key]['bonus'][0]['annual_bonus']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']),2);//提成补助奖金

            //应发工资 = 岗位工资-考勤扣款+绩效增减+季度提成+奖金+年终奖-年终奖计税+住房补贴+其他补款
            $user_info[$key]['Should'] = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$bonus_extract+$extract+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']),2);

            $user_info[$key]['tax_counting']        = round(($user_info[$key]['Should']-$user_info[$key]['insurance_Total']+$user_info[$key]['labour']['merge_counting']),2);//计税工资
            //个人所得税$user_info[$key]['labour']['merge_counting']
            if($user_info[$key]['tax_counting'] <= 5000){
                $counting                           = '0';
            }else{
                $cout                               = $user_info[$key]['tax_counting']-5000;
                if($cout <= 3000){
                    $countin                        = $cout*0.03;

                }elseif($cout > 3000 && $cout <= 12000){
                    $countin                        = $cout*0.10-210;
                }elseif($cout > 12000 && $cout <= 25000){
                    $countin                        = $cout*0.20-1410;
                }elseif($cout > 25000 && $cout <= 35000){
                    $countin                        = $cout*0.25-2660;
                }elseif($cout > 35000 && $cout <= 55000){
                    $countin                        = $cout*0.30-4410;
                }elseif($cout > 55000 && $cout <= 80000){
                    $countin                        = $cout*0.35-7160;
                }elseif($cout > 80000){
                    $countin                        = $cout*0.45-15160;
                }
                $counting                           = round($countin,2);
            }
            $user_info[$key]['datetime']            = $que['p.month'];//现在日期
            $user_info[$key]['personal_tax']        = $counting;//个人所得税

            //实发工资=岗位工资-考勤扣款+绩效增减+提成(带团补助)+奖金-代扣代缴+年终奖-年终奖计税+住房补贴+外地补贴+电脑补贴-五险一金-个人所得税-工会会费+其他补款
            $user_info[$key]['real_wages']          = round(($user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$bonus_extract+$extract-$user_info[$key]['summoney']+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']-$user_info[$key]['insurance_Total']-$counting-$user_info[$key]['labour']['Labour_money']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']+$user_info[$key]['bonus'][0]['foreign_bonus']),2);
        }
        return $user_info;
    }

    /**
     * sql_query
     * $que['p.tab_user_id'] 用户id
     * $que['a.nickname'] 用户昵称
     *$que['p.month'] 查询年月
     */
    private function query_score($que){
        $lists 			                    = M()->table('__PDCA__ as p')->field('p.*,a.nickname')->join('__ACCOUNT__ as a on a.id = p.tab_user_id')->where($que)->select();
        foreach($lists as $k=>$v){

            $sum_total_score                = 0;

            $yu                             = $v['status'] !=5 ? 0 : $v['total_score']-100;

            //计算PDCA加减分
            $sum_total_score                += $yu;

            //品质检查加减分
            $sum_total_score                += $v['total_qa_score'];

            //整理品质检查加减分
            $lists[$k]['total_score_show']  = $v['status']!=5 ? '<font color="#ff9900">未完成评分</font>' : show_score($yu);

            //整理品质检查加减分
            $lists[$k]['show_qa_score']     =  show_score($v['total_qa_score']);

            //获取KPI数据
            $kpi                            = M('kpi')->where(array('month'=>$v['month'],'user_id'=>$v['tab_user_id']))->find();
            if($kpi && $kpi['month']>=201803){
                $kpiscore                   =  $kpi['score']-100;
            }else{
                $kpiscore                   =  0;
            }

            //KPI加减分
            $sum_total_score                += $kpiscore;

            //KPI
            $lists[$k]['total_kpi_score']   = show_score($kpiscore);

            //合计
            $lists[$k]['sum_total_score']   =  show_score($sum_total_score);

        }
        return $lists;

    }

    private function salary_kpi_month($where,$datetime,$type){
        //kpi 目标任务 完成 提成
        $month                                  = (int)substr($datetime,4);
        $year                                   = (int)substr($datetime,0,4);
        $count                                  = 0;
        $sum1                                   = 0;
        $sum2                                   = 0;
        $query['user_id']                       = $where;
        if($month<10){
            $year                               = $year.'0';
        }
        if($type==2){
            $query['month']                     = $year.$month;
            if($month == 3 || $month == 6 || $month == 9 || $month == 12){
                $i                              = $month-3;
                for($i;$i<$month;$month--){
                    $query['month']             = $year.$month;
                    $kpi                        = M('kpi')->where($query)->find();
                    $lists                      = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->find();
                    //季度完成
                    $user                       = M('account')->where('id='.$query['user_id'])->find();
                    $mont1                      = $year.($month-1).'26';//开始月日
                    $mont2                      = $year.$month.'26';//结束月日

                    $support = M('salary_support')->where('account_id='.$query['user_id'])->find();//扶植人员
                    if($support){//查询是否是扶植人员
                        //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                        if($support['starttime']>strtotime($mont1) && $support['endtime']<strtotime($mont2)){
                            $mont3              = date('Ymd',$support['starttime']);
                            $mont4              = date('Ymd',$support['endtime']);
                            $sum1               += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                        }elseif($support['starttime']>strtotime($mont1) && $support['endtime']>strtotime($mont2) && $support['starttime']<strtotime($mont2)){
                            //扶植起日期 > 季度起日期   扶植止日期 > 季度止日期 扶植起日期<季度止日期
                            $mont3              = date('Ymd',$support['starttime']);
                            $mont4              = $mont2;
                            $sum1               += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                        }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']>strtotime($mont2))){
                            //扶植起日期 < 季度起日期   扶植止日期 > 季度止日期
                            $mont3              = $mont1;
                            $mont4              = $mont2;
                            $sum1               += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                        }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']<strtotime($mont2))){
                            //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                            $mont3              = $mont1;
                            $mont4              = $support['endtime'];
                        }else{
                            $mont3              = 0;
                            $mont4              = 0;
                        }
                    }
                    $sum_user                   = monthly_Finance($user['nickname'],$mont1,$mont2);//季度完成
                    $count                      += $lists['target'];//季度目标
                    $sum2                       += $sum_user;//季度完成
                }
                $price                          = $sum1*0.25;//扶植期提成
                $sum                            = $sum2-$sum1;//季度完成-扶植人员日期完成
                $number                         = $sum/$count;//项目季度百分比
                if($number <= 1){
                    $Total1                     = $sum*0.05;//不超过100%
                }
                if(1<$number && $number <=1.5){
                    $Total1                     = $count*0.05+($sum-$count)*0.2;//超过100% 不到150%
                }
                if(1.5 < $number){
                    $tot                        = $count*0.05;//100%以内
                    $tt                         = ($count*1.5-$count)*0.2;//100%以上 150% 以内
                    $yy                         = ($sum-$count*1.5)*0.25;//150% 以上
                    $Total1                     = $tot+$tt+$yy;
                }
                $Total = $Total1 + $price;//提成+扶植期提成
                $content['target']              = $count;
                $content['complete']            = $sum;
                $content['total']               = round($Total,2);//保留两位小数
            }else{
                $kpi                            = M('kpi')->where($query)->find();
                $lists                      = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->find();
                //季度完成
                $user                           = M('account')->where('id='.$query['user_id'])->find();
                $mont1                          = $year.($month-1).'26';//开始月
                $mont2                          = $year.$month.'26';//结束月
                $sum_user                       = monthly_Finance($user['nickname'],$mont1,$mont2);//季度完成
                $content['target']              = $lists['target'];//季度目标
                $content['complete']            = $sum_user;//季度完成
                $content['total']               = '0.00';//保留两位小数
            }
            return $content;
        }
        if($month == 3 || $month == 6 || $month == 9 || $month == 12){
            $i                                  = $month-3;
            for($i;$i<$month;$month--){
                $query['month']                 = $year.$month;
                $kpi                            = M('kpi')->where($query)->find();
                $lists                          = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->find();
                //季度完成
                $user                           = M('account')->where('id='.$query['user_id'])->find();
                $mont1                          = $year.($month-1).'26';//开始月
                $mont2                          = $year.$month.'26';//结束月
                $support                        = M('salary_support')->where('account_id='.$query['user_id'])->find();//扶植人员
                if($support){//查询是否是扶植人员

                    //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                    if($support['starttime']>strtotime($mont1) && $support['endtime']<strtotime($mont2)){
                        $mont3                  = date('Ymd',$support['starttime']);
                        $mont4                  = date('Ymd',$support['endtime']);
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif($support['starttime']>strtotime($mont1) && $support['endtime']>strtotime($mont2) && $support['starttime']<strtotime($mont2)){
                        //扶植起日期 > 季度起日期   扶植止日期 > 季度止日期 扶植起日期<季度止日期
                        $mont3                  = date('Ymd',$support['starttime']);
                        $mont4                  = $mont2;
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']>strtotime($mont2))){
                        //扶植起日期 < 季度起日期   扶植止日期 > 季度止日期
                        $mont3                  = $mont1;
                        $mont4                  = $mont2;
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']<strtotime($mont2))){
                        //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                        $mont3                  = $mont1;
                        $mont4                  = $support['endtime'];
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }else{
                        //1、扶植起日期<季度止日期  扶植止日期<季度起日期 2、扶植起日期<季度止日期 扶植止日期<季度起日期 3、扶植起日期>季度止日期 扶植止日期>季度起日期 4、扶植起日期>季度止日期 扶植止日期<季度起日期
                        $mont3                  = 0;
                        $mont4                  = 0;
                    }
                }
                $sum2                           += monthly_Finance($user['nickname'],$mont1,$mont2);//季度完成
                $count                          += $lists['target'];//季度目标
            }
            $price                              = $sum1*0.25;//扶植期提成
            $sum                                = $sum2-$sum1;//季度完成-扶植人员日期完成
            $number                             = $sum/$count;//项目季度百分比
            if($number <= 1){
                $Total1                          = $sum*0.05;//不超过100%
            }
            if(1<$number && $number <=1.5){
                $Total1                         = $count*0.05+($sum-$count)*0.2;//超过100% 不到150%
            }
            if(1.5 < $number){
                $tot                            = $count*0.05;//100%以内
                $tt                             = ($count*1.5-$count)*0.2;//100%以上 150% 以内
                $yy                             = ($sum-$count*1.5)*0.25;//150% 以上
                $Total1                         = round($tot+$tt+$yy,2);
            }
            $Total                              = $Total1+$price;//提成+扶植期提成
            $content['target']                  = $count;
            $content['complete']                = $sum;
            $content['total']                   = round($Total,2);//保留两位小数
        }else{
            $content['target']                  = '0.00';//季度目标
            $content['complete']                = '0.00';//季度完成
            $content['total']                   = '0.00';//保留两位小数
        }
        return $content;
    }

    private function countmoney($archives,$list='',$status=0){
        $where['archives']                                  = $archives;
        $where = array_filter($where);
        $info1                                              =  M('account')->where($where)->group('departmentid')->order('employee_member ASC')->select();//个人数据
        foreach($info1 as $k => $v){//去除编码空的数据
            if($v['employee_member'] == ""){//去空
                unset($info1[$k]);
            }else{
                $query['departmentid']                      = $v['departmentid'];
                foreach($list as $key =>$val){
                    if($val['department'][0]['id']==$v['departmentid']){
                        $sum[$k]['name']                    = '部门合计';
                        $sum[$k]['department']              =  $val['department'][0]['department'];//部门
                        $sum[$k]['standard_salary']         += round($val['salary'][0]['standard_salary']);//标准薪资
                        $sum[$k]['basic']                   += round($val['salary'][0]['standard_salary']/10*$val['salary'][0]['basic_salary'],2);//基本薪资
                        $sum[$k]['withdrawing']             += round($val['attendance'][0]['withdrawing'],2);//考勤扣款
                        $sum[$k]['performance_salary']      += round($val['salary'][0]['standard_salary']/10*$val['salary'][0]['performance_salary'],2);//绩效薪资
                        $sum[$k]['count_money']             += round($val['Achievements']['count_money'],2);//绩效增减
                        $sum[$k]['total']                   += round($val['Extract']['total'],2);//业绩提成
                        $sum[$k]['bonus']                   += round($val['bonus'][0]['foreign_bonus'],2);// 奖金
                        $sum[$k]['housing_subsidy']         += round($val['subsidy'][0]['housing_subsidy'],2);//住房补贴
                        $sum[$k]['Other']                   += round($val['Other'],2);//其他补款
                        $sum[$k]['Should']                  += round($val['Should'],2);//应发工资
                        $sum[$k]['care']                    += round($val['insurance'][0]['medical_care_base']*$val['insurance'][0]['medical_care_ratio'],3);//医疗保险
                        $sum[$k]['pension']                 += round($val['insurance'][0]['pension_base']*$val['insurance'][0]['pension_ratio']);//养老保险
                        $sum[$k]['unemployment']            += round($val['insurance'][0]['unemployment_base']*$val['insurance'][0]['unemployment_ratio'],3);// 失业保险
                        $sum[$k]['accumulation']            += round($val['insurance'][0]['accumulation_fund_base']*$val['insurance'][0]['accumulation_fund_ratio'],3);//公积金
                        $sum[$k]['insurance_Total']         += round($val['insurance_Total'],3);//个人保险合计
                        $sum[$k]['tax_counting']            += round($val['tax_counting'],2);//计税工资
                        $sum[$k]['personal_tax']            += round($val['personal_tax'],2);//个人所得税
                        $sum[$k]['summoney']                += round($val['summoney'],2);//税后扣款
                        $sum[$k]['Labour']                  += round($val['labour']['Labour_money'],2);//工会会费
                        $sum[$k]['real_wages']              += round($val['real_wages'],2);// 实发工资
                        $sum[$k]['datetime']                 = $val['datetime'];
                    }
                }
            }
        }
        return $sum;
    }

    private function summoney($sum){
        $cout['name']                                = '总合计';
        foreach($sum as $key => $val){
            $cout['standard_salary']                 += round($val['standard_salary'],2);//标准薪资
            $cout['basic']                           += round($val['basic'],2);//基本薪资
            $cout['withdrawing']                     += round($val['withdrawing'],2);//考勤扣款
            $cout['performance_salary']              += round($val['performance_salary'],2);//绩效薪资
            $cout['count_money']                     += round($val['count_money'],2);//绩效增减
            $cout['total']                           += round($val['total'],2);//业绩提成
            $cout['bonus']                           += round($val['bonus'],2);//奖金
            $cout['housing_subsidy']                 += round($val['housing_subsidy'],2);//住房补贴
            $cout['Other']                           += round($val['Other'],2);//其他补款
            $cout['Should']                          += round($val['Should'],2);//应发工资
            $cout['care']                            += round($val['care'],3);//医疗保险
            $cout['pension']                         += round($val['pension'],3);//养老保险
            $cout['unemployment']                    += round($val['unemployment'],3);//失业保险
            $cout['accumulation']                    += round($val['accumulation'],2);//公积金
            $cout['insurance_Total']                 += round($val['insurance_Total'],3);//个人保险合计
            $cout['tax_counting']                    += round($val['tax_counting'],2);//计税工资
            $cout['personal_tax']                    += round($val['personal_tax'],2);//个人所得税
            $cout['summoney']                        += round($val['summoney'],2);//税后扣款
            $cout['Labour']                          += round($val['Labour'],2);//工会会费
            $cout['real_wages']                      += round($val['real_wages'],2);//实发工资
            $cout['datetime']                         = $val['datetime'];
        }
        return $cout;
    }


    // 带的所有的团信息
    public function testA(){
        $where                  = array();
        $where['p.guide_id']    = 1272;
        $where['p.status']      = 2;
        $field                  = array();
        $field                  = 'o.project,o.group_id,p.really_cost,p.sure_time';
        $data = M()->table('__GUIDE_PAY__ as p')->join('__OP__ as o on o.op_id=p.op_id','left')->where($where)->field($field)->order('p.sure_time desc')->select();
        foreach ($data as $k=>$v){
            $data[$k]['sure_time'] = date('Y-m-d',$v['sure_time']);
        }

        $title = array('团号','名称','金额','时间');

        exportexcel($data,$title,'赵洋');
    }

    //http://oa.kexueyou.com/index.php?m=Main&c=Aaaprint&a=testB
    //某个周期内所有的结算的团(已结算审批时间为准)
    public function testB(){
        $this->title('导出结算信息');
        if (isset($_POST['dosubmint'])){
            $starttime              = strtotime(I('st'));
            $endtime                = strtotime(I('et'));
            if (!$starttime || !$endtime){ $this->error('时间格式错误'); }
            //查询月度
            $where                  = array();
            $where['b.audit_status']= 1;
            $where['l.req_type']    = 801;
            $where['l.audit_time']  = array('between', "$starttime,$endtime");

            $field                  = 'o.op_id,o.group_id,o.project,a.nickname,b.shouru,b.maoli,b.maolilv';
            $lists                  = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('o.create_time asc')->select();
            $title                  = array('项目编号','团号','项目名称','业务人员','收入','毛利','毛利率');
            $table_name             = date('Y-m-d',$starttime).'至'.date('Y-m-d',$endtime).'所有结算团信息(已结算审批时间为准)';
            exportexcel($lists,$title,$table_name);
        }else{
            $this->display();
        }
    }

    //获取某个周期内所有已做预算,未做结算的团
    public function testC(){
        $this->title('导出预算已通过,未做结算的团');
        if (isset($_POST['dosubmint'])){
            $starttime              = strtotime(I('st'));
            $endtime                = strtotime(I('et'));
            if (!$starttime || !$endtime){ $this->error('时间格式错误'); }
            //本周期预算审核通过的团
            $where                  = array();
            $where['l.audit_time']  = array('between',array($starttime,$endtime));
            $where['l.req_type']    = P::REQ_TYPE_BUDGET;
            $where['l.dst_status']  = 1;
            $field                  = 'b.name,b.op_id,l.req_uname,l.audit_uname';
            $lists                  = M()->table('__AUDIT_LOG__ as l')->join('__OP_BUDGET__ as b on b.id=l.req_id','left')->field($field)->where($where)->select();

            $new_arr                = array();
            foreach ($lists as $k=>$v){
                //查看结算状态
                $where              = array();
                $where['s.op_id']   = $v['op_id'];
                $where['l.req_type']= P::REQ_TYPE_SETTLEMENT;
                $where['l.dst_status']= 1;
                $sett               = M()->table('__OP_SETTLEMENT__ as s')->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')->where($where)->find();
                if ($sett['dst_status'] != 1 && $v['op_id']){ //结算审核未通过
                    $where          = array();
                    $where['op_id'] = $v['op_id'];
                    $field          = 'op_id,group_id,project,sale_user';
                    $data           = M('op')->where($where)->field($field)->find();
                    $data['req_uname'] = $v['req_uname'];
                    $new_arr[]      = $data;
                }
            }
            $title                  = array('项目编号','团号','项目名称','业务人员','计调');
            $table_name             = date('Y-m-d',$starttime).'至'.date('Y-m-d',$endtime).'已预算未结算项目C';
            exportexcel($new_arr,$title,$table_name);
        }else{
            $this->display();
        }
    }

    //获取某个周期内所有已做预算的团(不管结算状态)
    public function testD(){
        $this->title('导出所有预算已通过的团');
        if (isset($_POST['dosubmint'])){
            $starttime              = strtotime(I('st'));
            $endtime                = strtotime(I('et'));
            if (!$starttime || !$endtime){ $this->error('时间格式错误'); }
            //本周期预算审核通过的团
            $where                  = array();
            $where['l.audit_time']  = array('between',array($starttime,$endtime));
            $where['l.req_type']    = P::REQ_TYPE_BUDGET;
            $where['l.dst_status']  = 1;
            $field                  = 'b.op_id,o.group_id,b.name,o.sale_user,l.req_uname';
            $lists                  = M()->table('__AUDIT_LOG__ as l')->join('__OP_BUDGET__ as b on b.id=l.req_id','left')->join('__OP__ as o on o.op_id=b.op_id','left')->field($field)->where($where)->select();

            foreach ($lists as $k=>$v){
                $lists[$k]['op_id'] = $v['op_id'] ? $v['op_id'] : '该团已删除';
                //查看结算状态
                $where              = array();
                $where['s.op_id']   = $v['op_id'];
                $where['l.req_type']= P::REQ_TYPE_SETTLEMENT;
                $where['l.dst_status']= 1;
                $sett               = M()->table('__OP_SETTLEMENT__ as s')->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')->where($where)->find();

                //回款信息
                $field              = array();
                $field[]            = 'op_id';
                $field[]            = 'sum(amount) as plan';
                $field[]            = 'sum(pay_amount) as pay_amount';
                $huikuan            = M('contract_pay')->where(array('op_id'=>$v['op_id']))->field($field)->find();

                if ($sett['dst_status'] != 1 && $v['op_id']){ //结算审核未通过
                    $lists[$k]['sett_stu']  = '请注意,该团未结算';
                    $lists[$k]['shouru']    = '';
                    $lists[$k]['maoli']     = '';
                    $lists[$k]['maolilv']   = '';
                }else{
                    $lists[$k]['sett_stu']  = date('Y-m-d H:i:s',$sett['audit_time']);
                    $lists[$k]['shouru']    = $sett['shouru'];
                    $lists[$k]['maoli']     = $sett['maoli'];
                    $lists[$k]['maolilv']   = $sett['maolilv'];
                }
                $lists[$k]['plan']          = $huikuan['plan'] ? $huikuan['plan'] : 0;
                $lists[$k]['pay_amount']    = $huikuan['pay_amount'] ? $huikuan['pay_amount'] : 0;
            }

            $title                  = array('项目编号','团号','项目名称','业务人员','计调','结算审批时间','结算收入','结算毛利','结算毛利率','计划回款金额','实际回款金额');
            $table_name             = date('Y-m-d',$starttime).'至'.date('Y-m-d',$endtime).'已完成预算项目D';
            exportexcel($lists,$title,$table_name);
        }else{
            $this->display();
        }
    }

    //导出在某个时间段返回的团(以成团确认返回时间为准)
    public function testE(){
        $begin                  = '2019-11-01';
        $end                    = '2019-11-04';
        $beginTime              = strtotime($begin);
        $endTime                = strtotime($end);
        $where                  = array();
        $where['c.ret_time']    = array('between',array($beginTime,$endTime));
        $field                  = 'o.op_id,o.group_id,o.project,o.create_user_name,c.ret_time';
        $list                   = M()->table('__OP_TEAM_CONFIRM__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->field($field)->where($where)->select();
        foreach ($list as $k=>$v){
            $list[$k]['ret_time']   = date('Y-m-d',$v['ret_time']);
        }

        $title = array('项目编号','团号','项目名称','业务','返回时间');
        exportexcel($list,$title,$begin.'至'.$end.'返回项目');
    }
}