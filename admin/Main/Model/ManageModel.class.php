<?php
namespace Main\Model;
use Think\Model;
use Sys\P;

class ManageModel extends Model{

    //月度部门人数(从工资表取值)
    public function get_number($year,$month){
        $datetime                   = $this->datetime($year,$month);
        $where['s.datetime']        = $datetime;
        $where['s.status']          = 4;//数据锁定
        $where['s.user_name']       = array('notlike','%1');
        $wages_lists                = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->field('s.id,s.account_id,s.user_name,s.department,s.insurance_id,s.datetime,s.Should_distributed,a.position_id')->where($where)->select(); //应付工资
        $depart_account             = $this->get_account($wages_lists);
        $info                       = array();
        foreach ($depart_account as $k=>$v){
            $info[$k]               = count($v);
        }
        return $info;
    }

    //月度经营统计
    /*public function month($year,$month){
        $datetime                                           = $this->datetime($year,$month);
        $datime['datetime']                                 = $datetime;
        $datime['status']                                   = 4;//数据锁定
        $account_sum                                        = $this->userinfo($datime,3);//获取发工资的人员数量
        $moner2                                             = 0;
        foreach($account_sum as $kk => $vv){ //循环公司五险一金加大额
            $query['id']                                    = $vv['insurance_id'];
            $moner2                                         += $this->insurance($query);//公司总共缴五险一金
        }
        $account[0]['sum']                                  = count($account_sum);
        $account[0]['money']                                = (float)$this->userinfo($datime,2)['Should']+$moner2;//获取人力资源成本（应发工资）
        $arr                                                = C('department');//部门
        $number                                             = $account[0]['sum'];
        $num                                                = $account[0]['money'];
        $sum                                                = 0;
        foreach($arr as $key =>$val){//循环发工资的部门人数 $key=0 公司
            $key                                            = $key+1;
            $datime['department']                           = $val;
            if($val=='市场部'){ //业务人员
                $where['code']                              = array('like','S%');
                $position                                   = M('position')->where($where)->select();//查询业务人员
                $wher['departmentid']                       = 2;
                $wher['status']                             = 0;
                foreach($position as $k => $v){
                    $wher['position_id']                    = $v['id'];
                    $info                                   = $this->userinfo($wher,1);//查询业务人员信息
                    if($info){
                        foreach($info as $ke => $va){
                            $datime['account_id']           = $va['id'];
                            $datime['department']           = '市场部';
                            $mon                            = $this->userinfo($datime,3);//查询业务人员人力资源成本
                            if($mon){
                                $account[$key]['sum']       = $account[$key]['sum']+1;
                                $number                     = $number-$account[$key]['sum'];
                                foreach($mon as $kk => $vv){
                                    $number                 = $number-$account[$key]['sum'];
                                    $medical['id']          = $vv['insurance_id'];
                                    $medical_insurance      = $this->insurance($medical);//个人五险一金
                                    $money                  = $vv['Should_distributed']+$medical_insurance;//应发工资+五险一金
                                    $account[$key]['money'] = $account[$key]['money']+$money;//查询业务人员人力资源成本
                                }
                            }else{
                                $account[$key]['sum']       = 0;
                            }
                            unset($datime['account_id']);
                            unset($datime['department']);
                        }
                    }
                }
                $num                                        = $num-$account[$key]['money'];
            }else{ //非市场业务人员
                $salary_month1                              = $this->userinfo($datime,3);//获取发工资的应发工资(所有)
                $account[$key]['sum']                       = count($salary_month1);//人数
                foreach($salary_month1 as $k=>$v){
                    $medical['id']                          = $v['insurance_id'];
                    $medical_insurance                      = $this->insurance($medical);//个人五险一金
                    $account[$key]['money']                 = $account[$key]['money']+$v['Should_distributed']+$medical_insurance;//人力资源成本
                    $medical['id']                          = $v['insurance_id'];
                    if($account[0]['sum']!==0){
                        $number                             = $number-1;
                    }
                }
                $num                                        = $num-$account[$key]['money'];
            }
            $sum                                            = $key+1;
        }
        $account[$sum]['sum']                               = $number;
        $account[$sum]['money']                             = $num;
        return $account;
    }*/

    public function month($year,$month,$times){
        $datetime                   = $this->datetime($year,$month);
        $datime['datetime']         = $datetime;
        $datime['status']           = 4;//数据锁定
        $wages_lists                = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->field('s.id,s.account_id,s.user_name,s.department,s.insurance_id,s.datetime,s.Should_distributed,a.position_id')->where(array('s.datetime'=>$datetime,'s.status'=>4))->select(); //应付工资
        $field                      = "s.account_id,s.user_name,s.datetime,s.department,i.*";
        $insurance_lists            = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__SALARY_INSURANCE__ as i on i.id=s.insurance_id','left')->field($field)->where(array('s.datetime'=>$datetime,'s.status'=>4))->select();
        $sumLists                   = $this->sum_insurance($insurance_lists);   //五险一金
        $depart_account             = $this->get_account($wages_lists);
        //职工福利,教育经费,工会费......
        $kinds                      = array(12,19,21);
        $money                      = $this->get_welfare($times,$kinds);

        foreach ($depart_account as $k=>$v){
            $info[$k]               = 0;
            foreach ($wages_lists as $key=>$value){
                if (in_array($value['account_id'],$v)){
                    $info[$k]       += $value['Should_distributed'];    //应付工资
                }
            }

            foreach ($sumLists as $key=>$value){
                if (in_array($value['account_id'],$v)){
                    $info[$k]       += $value['company_pay_sum'];       //公司缴纳五险一金
                }
            }
            $info[$k]               += $money[$k];
        }

        return $info;
    }

     /**
      * 公司五险一金 insurance
      *  $where 条件
      */
     public function insurance($where){
         $insurance              = M('salary_insurance')->where($where)->find();
         // 公司 生育 工伤 养老 医疗 失业
         $medical_insurance      = $insurance['company_birth_ratio']*$insurance['company_birth_base']+$insurance['company_injury_ratio']*$insurance['company_injury_base']+$insurance['company_pension_ratio']*$insurance['company_pension_base']+$insurance['company_medical_care_ratio']*$insurance['company_medical_care_base']+$insurance['company_unemployment_ratio']*$insurance['company_unemployment_base']+$insurance['company_accumulation_fund_ratio']*$insurance['company_accumulation_fund_base']+$insurance['company_big_price'];
         return $medical_insurance;
     }

    /**
     * datetime 年月 日期变换
     */
    /*public function datetime($year,$month){

        if($month<10 || $month==0 || $month==''){ //判断时间是否空 和 小于10

            if($month==0 || $month==''){ //为空默认

                $month                = date('m');
            }

            if($month<10){ //小于10 添加为符合条件的字段

                $datetime             = $year.'0'.$month;

            }else{ //不小于10 直接获取年月

                $datetime             = $year.$month;
            }
        }else{
            $datetime                 = $year.$month;
        }
        return $datetime;
    }*/
    public function datetime($year,$month){
        $year                           = $year?$year:date('Y');
        $month                          = $month?$month:date('m');
        if (strlen($month)<2) $month    = str_pad($month,2,'0',STR_PAD_LEFT);
        $datetime                       = $year.$month;
        return $datetime;
    }

    /**
     * userinfo 获取用户信息 价格
     * $type 1 用户所有条件信息 2 总价格列表信息 3价格列表信息
     */
    public function userinfo($where,$type){

        if($type==1){

            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->select();die;

        }elseif($type==2){

            return M('salary_count_money')->field('id,datetime,Should_distributed')->where($where)->find();die;

        }elseif($type==3){

            return M('salary_wages_month')->field('id,account_id,datetime,insurance_id,Should_distributed')->where($where)->select();die;

        }elseif($type==4){

            return M('salary_wages_month')->field('id,account_id,datetime,insurance_id,Should_distributed')->where($where)->find();die;

        }elseif($type==5){

            return M('salary_wages_month')->field('id,account_id,datetime,Should_distributed')->where($where)->count();die;

        }else{

            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->find();die;
        }
    }

    /**
     * profit 毛利  利润 毛利率
     * $money 价格 匹配已有条件
     *
     */
    /*public function profit($money){

        $arr                                          =  C('department');//部门

        $departmen                                    = array();

        foreach($arr as $key =>$val){

            $key                                      = $key + 1;

            $departmen[$key]['department']['depname'] = $val;

            foreach($money as $k => $v){

                if($v['depname']==$val){

                    $departmen[$key]['department']    = $v;
                }
            }
        }
        $list['departmen']                            = $departmen;

        $list['profit']                               = $money['heji'];

        return $list;
    }*/
    public function profit($money){
        $info                                         = array();
        foreach ($money as $k=>$v){
            if ($k=='heji') $v['depname']             = '公司';
            if ($k == 'dj_heji') $v['depname']        = '地接合计';
            $info[$v['depname']]                      = $v;
        }

        return $info;
    }

    /**
     * manageyear 年变化
     *$year 年  $post 1 加年  2 减年
     */
    /*public function manageyear($year,$post){

        if(is_numeric($year)){//判断有无传送年

            if(is_numeric($post) && $post==1){

                $year           = (int)$year-1;

            }elseif(is_numeric($post) && $post==2){

                $year           = (int)$year+1;
            }

        }else{ //没有就默认

            $year               = (int)date('Y');
        }
        return $year;
    }*/


    /**
     * human_affairs    人事费用率 = 人力资源成本/收入
     * @param $hr_cost  人力资源成本
     * @param $profit   部门收人 毛利  毛利率
     * @return mixed
     */

    public function human_affairs($hr_cost,$profit){
        $human_affairs                  = array();
        foreach($hr_cost as $key => $val){

            $human_affairs[$key] = round(($val/$profit[$key]['monthzsr'])*100,2);//人事费用率
        }
        return $human_affairs;
    }

    /**
     * 利润总额 = 营业毛利-人力资源成本-其他费用
     * @param $profit   营业毛利
     * @param $hr_cost  人力资源成本
     * @param $department 其他费用
     */
    public function total_profit($profit,$hr_cost,$department){
        $info                   = array();
        foreach ($department as $k=>$v){
            $info[$k]           = $profit[$k]['monthzml'] - $hr_cost[$k] - $v['money'];
        }
        return $info;
    }


    /** 获取季度人数平均值
     * @param $year
     * @param $yms
     */
    public function get_numbers($year,$yms){
        $info                   = array();
        foreach ($yms as $k=>$v){
            $month              = substr($v,4,2);
            $info[]             = $this->get_number($year,$month);
        }

        $sum                    = array();  //总人数
        $num                    = 0;
        foreach ($info as $key=>$value){
            if ($value){
                $num++;
                foreach ($value as $k=>$v){
                    $sum[$k]    += $v;
                }
            }
        }

        $average                = array();
        foreach ($sum as $k=>$v){
            $average[$k]        = round($v/$num,2);
        }
        return $average;
    }

    /**
     * 季度部门人力资源成本
     * @param $year
     * @param $yms
     * @param $times
     */
    public function get_quarter_hr_cost($year,$yms,$times){
        $info                   = array();
        foreach ($yms as $v){
            $month              = substr($v,4,2);
            $info[]             = $this->month($year,$month,$times);
        }

        $sum                    = array();
        foreach ($info as $value){
            foreach ($value as $k=>$v){
                $sum[$k]        += $v;
            }
        }
        return $sum;
    }

    /**
     * manage_quarter 季度利润总额
     * $quarter  人数 人力资源成本
     * $profits 季度数据 总收入 总毛利 总利率
     */
    public function manage_quarter($quarter,$profits){

        foreach($quarter as $key =>$val){ //循环数据

            //季度利润总额 = 季度总毛利-人力资源成本-其他费用
           $countprofit[$key]['monthzml'] =  $profits[$key]['monthzml']-$val['money']-$profits[$key]['money'];

        }
        return $countprofit;
    }

    /**
     * personnel_costs 人事费用率
     * $quarter  人数 人力资源成本
     * $profits 季度数据 总收入 总毛利 总利率
     */
    public function personnel_costs($quarter,$profits){

        foreach($quarter as $key =>$val){ //循环数据

            //人事费用率 = 季度总毛利-人力资源成本
            $personnel_costs[$key]['personnel_costs'] = round(($val['money']/$profits[$key]['monthzsr'])*100,2);
        }
        return $personnel_costs;
    }

    /**
     * yea_report 年度经营报表
     * $year 年 $quart月
     * $post 2 加  1 减年
     */
    public  function yea_report($year,$post){
        $arr                                            = C('department');//部门
        $where['datetime']                              = array('like',$year.'%');
        $where['status']                                = 4;
        $query                                          = array();
        $user_count[0]['sum']                           = $this->userinfo($where,5); //公司今年人员数量
        $count_money                                    = M('salary_count_money')->where($where)->select();//今年应发总计数据
        $sum                                            = 0;//市场部 业务人员 数量
        foreach($count_money as $key => $val){
            $query_r['id']                              = $val['insurance_id'];
            $moner2                                     = $this->insurance($query_r);//公司总共缴五险一金
            $user_count[0]['money']                    += $val['Should']+$moner2;//今年应发总计金额
        }
        $money                                          = $user_count[0]['money'];//今年应发总计金额
        $count                                          = $user_count[0]['sum'];// 公司今年人员数量
        $number                                         = 0;
        foreach($arr as $key => $val){
            $key                                        = $key+1;
            $where['department']                        = $val;
            if($val=='市场部'){
                $query[$key]['code']                    = array('like','S'.'%');
                $position                               = M('position')->where($query)->select();//业务 带S的职位
                foreach($position as $k => $v){
                    $quer['position_id']                = $v['id'];
                    $quer['departmentid']               = 2;
                    $userid                             = M('account')->where($quer)->select();//市场部 业务人员id
                    foreach($userid as $kk => $vv){
                        $user_r['account_id']           = $vv['id'];
                        $user_r['datetime']             = array('like',$year.'%');
                        $user_r['status']               = 4;
                        $salary_count                   = $this->userinfo($user_r,3); //公司今年人员工资信息
                        if($salary_count){$sum = $sum+1;}
                        foreach($salary_count as $ke => $va){
                            $que['id']                  = $va['insurance_id'];
                            $mon                        = $this->insurance($que);//公司总共缴五险一金
                            $user_count[$key]['money'] += $va['Should_distributed']+$mon;//市场部 业务人员应发工资
                            $money                      = $money-$va['Should_distributed']-$mon;
                        }
                    }
                }
                $user_count[$key]['sum']                = $sum;//市场部 业务人员数量
                $count                                  = $count-$sum;
            }else{ //各部门应发总额
                $salary_count                           = $this->userinfo($where,3); //公司今年人员工资信息
                $user_count[$key]['sum']                = count($salary_count); //公司今年人员数量
                $count                                  = $count-count($salary_count);
                foreach($salary_count as $k => $v){
                    $qu['id']                           = $v['insurance_id'];
                    $money1                             = $this->insurance($qu);//公司总共缴五险一金
                    $user_count[$key]['money']         += $v['Should_distributed']+$money1;//部门人员应发工资
                    $money                              = $money-$v['Should_distributed']-$money1;
                }
            }
            $number                                     = $key+2;
        }
        $user_count[$number]['sum']                     = $count;
        foreach($user_count as $key => $val){$user_count[$key]['sum'] = round($val['sum']/count($count_money),2);}
        $user_count[$number]['money']                   = $money;
        return $user_count;
    }


    /**
     * profit_w 整理年 收入 毛利 利率
     * $money 年 收入 毛利 利率
     */
    public function profit_w($money){
        $arr                                         =  C('department');//部门
        $departmen                                   = array();
        $sum                                         = 0;
        foreach($arr as $key =>$val){ //部门循环
            $key                                     = $key + 1;
            $departmen[$key]['department']['depname']= $val;
            foreach($money as $k => $v){ //部门年收入 毛利 利率
                if($v['depname']==$val){ $departmen[$key]= $v;}//每个部门年收入 毛利 利率
                if($k=='heji'){$departmen[0] = $v;}       //总收入 毛利 利率
            }
            $sum                                     = $key+1;
        }
        $departmen[$sum]['yearzsr']                  = 0.00;//机关部门收入 默认0
        $departmen[$sum]['yearzml']                  = 0.00;//机关部门毛利 默认
        $departmen[$sum]['yearmll']                  = 0.00;//机关部门利率 默认
        ksort($departmen);
        return $departmen;
    }

    /**
     * count_profit 年利润总额
     * $yea_report 年人员人力资源成本
     * $profit 年 收入 毛利 毛利率
     * $department 部门其他费用
     */
    public function count_profit($yea_report,$profit,$department){

        foreach($yea_report as $key =>$val){

            $profit_sum[$key]['yearprofit'] = $profit[$key]['yearzml']-$val['money']-$department[$key]['money'];//利润总额 = 营业毛利-人力资源成本-其他费用

            $profit_sum[$key]['personnel']  = round(($val['money']/$profit[$key]['yearzsr'])*100,2);//人事费用率=人力资源成本/营业毛利

        }
        return $profit_sum;
    }

    /**
     * quarter_month 自动计算当前季度
     * $date_Y['year'] 年
     * $time_M 月
     */
    public function quarter_month($date_Y){

        $time_M = date('m');
        switch ($time_M)
        {
            case 1:
                $date_Y['type']    = 1;
                return $date_Y;die;
            case 2:
                $date_Y['type']    = 2;
                return $date_Y;break;
            case 3:
                $date_Y['type']    = 2;
                return $date_Y;break;
            case 4:
                $date_Y['type']    = 2;
                return $date_Y;break;
            case 5:
                $date_Y['type']    = 3;
                return $date_Y;break;
            case 6:
                $date_Y['type']    = 3;
                return $date_Y;break;
            case 7:
                $date_Y['type']    = 3;
                return $date_Y;break;
            case 8:
                $date_Y['type']    = 4;
                return $date_Y;break;
            case 9:
                $date_Y['type']    = 4;
                return $date_Y;break;
            case 10:
                $date_Y['type']    = 4;
                return $date_Y;break;
            case 11:
                $date_Y['year']    = $date_Y['year']+1;
                $date_Y['type']    = 1;
                return $date_Y;break;
            case 12:
                $date_Y['year']    = $date_Y['year']+1;
                $date_Y['type']    = 1;
                return $date_Y;break;
        }
    }


    /** bak_20190404
     * quarter_month 自动计算当前季度
     * $date_Y['statu'] 季度
     * $time_M 月
     */
    /*public function quarter_month1($time_M){
        switch ($time_M)
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
    }*/
    /**
     * quarter_month 自动计算当前年
     * $date_Y['year'] 年
     * $time_M 月
     */
    public function quarter_year($date_Y){
        $time_M                  = (int)date('m');
        switch ($time_M)
        {
            case 1:
                return $date_Y;break;
            case 2:
                return $date_Y;break;
            case 3:
                return $date_Y;break;
            case 4:
                return $date_Y;break;
            case 10:
                $date_Y['year']  = (int)$date_Y['year']+1;
                return $date_Y;break;
            case 11:
                $date_Y['year']  = (int)$date_Y['year']+1;
                return $date_Y;break;
            case 12:
                $date_Y['year']  = (int)$date_Y['year']+1;
                return $date_Y;break;
        }
    }

    /**
     * manage_input_statu 判断是否有数据
     * 返回数据
     */
    public  function manage_input_statu($table,$datetime){


        $add['datetime']                = $datetime['year'];//年
        $add['type']                    = $datetime['type'];
        $add['logged_department']       = trim(I('department'));//部门
        $tab                            = $this->sql_r($table,$add,2);
        $count                          = $this->sql_r($table,$add,1);
        if(!$count){
            if(count($tab)==10){return 3;die;}
            $add['account_id']          = $_SESSION['userid'];//用户uid
            $add['createtime']          = time(); //时间
            $add['username']            = $_SESSION['name'];//用户名
            $add['employees_number']    = trim(I('number'));//员工人数
            $add['logged_income']       = trim(I('income'));//营业收入
            $add['logged_profit']       = trim(I('profit'));//营业毛利
            $add['logged_rate']         = trim(I('rate'));//营业利率比
            $add['manpower_cost']       = trim(I('cost'));//人力资源成本
            $add['other_expenses']      = trim(I('other'));//其他费用
            $add['total_profit']        = trim(I('total'));//利润总额
            $add['personnel_cost_rate'] = trim(I('personnel'));//人事费用率
            $add                        = array_filter($add);
            $add_input                  = M($table)->add($add);
            if($add_input){return 1;die;}else{return 2;die;}
        }else{
            if($count['statu']>1){return 3;die;}
            $save['createtime']         = time(); //时间
            $save['username']           = $_SESSION['name'];//用户名
            $save['employees_number']   = trim(I('number'));//员工人数
            $save['logged_income']      = trim(I('income'));//营业收入
            $save['logged_profit']      = trim(I('profit'));//营业毛利
            $save['logged_rate']        = trim(I('rate'));//营业利率比
            $save['manpower_cost']      = trim(I('cost'));//人力资源成本
            $save['other_expenses']     = trim(I('other'));//其他费用
            $save['total_profit']       = trim(I('total'));//利润总额
            $save['personnel_cost_rate']= trim(I('personnel'));//人事费用率
            $save                       = array_filter($save);
            $save_input                 = M($table)->where($add)->save($save);
            if($save_input){return 1;die;}else{return 2;die;}
        }
    }

    /**
     * 保存季度录入数据
     * @param $info
     * @return array
     */
    public function save_manage($info){
        $db                             = M('manage_input');
        $year                           = $info['year'];
        $type                           = $info['type'];
        $num                            = 0;
        $save_data                      = array();

        if (!$year || !$type || !$info['department']){
            $save_data['stu']           = $num;
            $save_data['msg']           = '数据错误';
            return $save_data;
        }

        $data                           = array();
        $data['account_id']             = session('userid');//用户uid
        $data['username']               = session('name');  //用户名
        $data['createtime']             = NOW_TIME; //时间
        $data['datetime']               = trim($info['year']); //年
        $data['logged_department']      = trim($info['department']); //部门
        $data['employees_number']       = trim($info['number']);//员工人数
        $data['logged_income']          = trim($info['income']);//营业收入
        $data['logged_profit']          = trim($info['profit']);//营业毛利
        $data['logged_rate']            = trim($info['rate']);//营业利率比
        $data['manpower_cost']          = trim($info['cost']);//人力资源成本
        $data['other_expenses']         = trim($info['other']);//其他费用
        $data['total_profit']           = trim($info['total']);//利润总额
        $data['target_profit']          = trim($info['target_profit']); //目标利润
        $data['personnel_cost_rate']    = trim($info['personnel']);//人事费用率
        $data['type']                   = trim($info['type']); //1-4季度 , 5年度

        $where2                         = array();
        $where2['datetime']             = $data['datetime'];
        $where2['type']                 = $data['type'];
        $where2['logged_department']    = $data['logged_department'];

        if (in_array(session('userid'),array(11))){ //乔总修改数据
            $list2                      = $db->where($where2)->find();
            if (!$list2){
                $data['statu']          = 1; //待提交审核
                $result                 = $db->add($data);
            }else{
                $result                 = $db->where(array('id'=>$list2['id']))->save($data);
            }
            if ($result) $num++;
        }else{
            $where2['statu']            = array('in',array(1,3)); //1=>待提交审核, 3=>审核不通过
            $list2                      = $db->where($where2)->find();
            $data['statu']              = 1; //待提交审核
            if (!$list2){
                $res                    = $db->add($data);
            }else{
                $res                    = $db->where($where2)->save($data);
            }
        }
        if ($res){
            if (in_array($info['type'],1,2,3,4)){ $cycle=$info['type'].'季度'; }else{ $cycle='年度'; }
            //发送系统通知
            $uid     = cookie('userid');
            $title   = '您有来自'.session('username').'提交的'.$info['year'].'年'.$cycle.'预算报表待审核';
            $content = '';
            $url     = U('Manage/Manage_quarter_w',array('year'=>$info['year'],'type'=>$info['type']));
            $user    = '[11]'; //乔总
            send_msg($uid,$title,$content,$url,$user,'');

            $num++;
        }
        $msg                            = $num ? '数据保存成功' : '数据保存失败';
        $save_data['stu']               = $num;
        $save_data['msg']               = $msg;
        return $save_data;
    }

    //判断是否可以修改
    /*public function get_not_upd_manage($year,$type){
        $db                             = M('manage_input');
        $where                          = array();
        $where['datetime']              = $year;
        $where['type']                  = $type;
        $where['statu']                 = array('in',array(2,4)); //2=>待审核 , 4=>审核通过
        $list                           = $db->where($where)->find();
        return $list;
    }*/

    /**
     * Manage_display 显示季度数据输入页面信息排序
     * $datetime 当前季度时间
     */
    public function Manage_display($datetime,$statu){

        $where['datetime']                          = array('eq',$datetime['year']);//年

        if($statu==1){
            $where['type'] = array('eq',5);
        }else{

            switch ($datetime['type'])
            {
                case 3:
                    $type    = 1; break;
                case 6:
                    $type    = 2; break;
                case 9:
                    $type    = 3; break;
                case 12:
                    $type    = 4; break;
            }
            $where['type'] = array('eq',$type);
        }

        $department                                 = C('department1');

        if($statu==1 || $statu==2){$where['statu']  = array('eq',4);}else{$where['statu'] = array('lt',4);}

        foreach($department as $key => $val){

            $where['logged_department']             = $val;

            $manage[$key]                           = $this->sql_r('manage_input',$where,1);//批准通过的数据

            $manage[$key]['logged_department']      = $val;
        }
        return $manage;
    }

    /**
     * sql_r 查询数据
     */
    public function sql_r($table,$where,$type){

        if($type==1){

            return M($table)->where($where)->find();

        }elseif($type==2){

            return M($table)->where($where)->select();

        }elseif($type==3){

            return M($table)->where($where)->count();
        }
    }

    /**
     * Manage_type 年和季度显示提交状态
     * 1 待提交审核 2 待提交批准 3 待批准
     * $sum 1年度 2 季度 $type 5
     */

    public function Manage_type($sum,$type){

        if($sum==1){
            $year['year']                   = (int)date('Y');
            $datetime                       = $this->quarter_month($year);
            $where['datetime']              = array('eq',$datetime['year']);
            $where['type']                  = array('eq',$datetime['type']);
        }elseif($sum==2){
            $year['year']                   = (int)date('Y');
            $datetime                       = $this->quarter_year($year);
            $where['datetime']              = array('eq',$datetime['year']);
            $where['type']                  = array('eq',$type);
        }
//        $where['account_id']                = array('eq',$_SESSION['userid']);
        $where['statu']                     = array('eq',1);
        $content                            = $this->sql_r('manage_input',$where,1); //查询当前状态是否为待提交审
        if($content){
            return 1;die;
        }else{
            unset($where['statu']);
            $where['statu']                 = array('eq',2);
            $count                          = $this->sql_r('manage_input',$where,3);//查询当前状态是否为待提交批准
            if($count==10){
                return 2;die;
            }else{
                unset($where['statu']);
                $where['statu']             = array('eq',3);
                $input                      = $this->sql_r('manage_input',$where,1);//查询当前状态是否为待批准
                if($input){return 3;die;}else{return 0;die;}
            }
        }
    }

    /**
     * quarter_submit1 季度提交审批
     */
    /*public function quarter_submit1(){

        $sum['year']          = (int)date('Y');

        $datetime             = $this->quarter_month($sum);

        $where['datetime']    = $datetime['year'];

        $where['type']        = $datetime['type'];

        $where['statu']       = 1;

        $manage               = $this->sql_r('manage_input',$where,2);

        if(!$manage){return 3;die;}

        foreach($manage as $key => $val){

            $query['id']      = $val['id'];

            $save['statu']    = 3;

            $input            = M('manage_input')->where($query)->save($save);

            if(!$input){return 3;die;}
        }

        $wher['statu']        = 3;

        $wher['datetime']     = $where['datetime'];

        $wher['type']         = $where['type'];

        $count                = $this->sql_r('manage_input',$wher,3);

        if($count==10){return 2;die;}else{return 3;die;}
    }*/



    /**
     * quarter_paprova1 季度批准
     * $status 2 提交批准 $type 1 驳回
     * $num 当前状态  $sum 成功修改状态
     */
    /*public function quarter_paprova1($status,$type,$num,$sum){

        $where['statu']                 = $num;

        $number['year']                 = (int)date('Y');

        $datetime                       = $this->quarter_month($number);

        $where['datetime']              = $datetime['year'];

        $where['type']                  = $datetime['type'];

        $count                          = $this->sql_r('manage_input',$where,2);

        if(count($count)==10){

            foreach($count as $key => $val){

                $query['id']            = $val['id'];

                if($type=='' || $type==0){$save['statu']=$sum;$content='批准';}else{$save['statu']=1;$content='驳回';}

                $input                  = M('manage_input')->where($query)->save($save);
            }

            if(!$input){return $content.'失败！';}else{return $content.'成功！';}

        }else{

            return '请确认所有人员预算数据已提交！';die;
        }
    }*/

    /**
     * 审核预算信息
     * @param $year
     * @param $type
     * @param $stu 3=>驳回 4=>通过
     */
    public function quarter_paprova1($year,$type,$stu){
        $db                     = M('manage_input');
        $where                  = array();
        $where['datetime']      = $year;
        $where['type']          = $type;
        $where['statu']         = 2; //待审核
        $data                   = array();
        $data['statu']          = $stu;
        $num                    = 0;
        $res                    = $db->where($where)->save($data);
        if ($res) $num++;
        return $num;
    }


    /**
     * year_submit1 年度提交审核
     */
    public function year_submit1(){

        $sum['year']          = (int)date('Y');

        $where['datetime']    = $this->quarter_year($sum)['year']; //查询当前年度

        $where['statu']       = 1;

        $where['type']        = 5;

        $manage               = $this->sql_r('manage_input',$where,2);//查询预算是年度 并且

        if(!$manage){return 3;die;}

        if(count($manage)==10){}else{return 4;die;}

        foreach($manage as $key => $val){

            $query['id']      = $val['id'];

//            $save['statu']    = 2;

            $save['statu']    = 3;

            $input            = M('manage_input')->where($query)->save($save);

            if(!$input){return 3;die;}
        }

        $wher['statu']        = 3;

        $wher['datetime']     = $where['datetime'];

        $wher['type']         = 5;

        $count                = $this->sql_r('manage_input',$wher,3);

        if($count==10){return 2;die;}else{return 3;die;}
    }


    /**
     * year_paprova1 年度提交批准
     * $status 2 提交批准 $type 1 驳回
     * $num 当前状态  $sum 成功修改状态
     */
    public function year_paprova1($status,$type,$num,$sum){

        $wher['statu']                  = $num;

        $date['year']                   = (int)date('Y');

        $wher['datetime']               = $this->quarter_year($date)['year'];//获取年度

        $wher['type']                   = 5;

        $count                          = $this->sql_r('manage_input',$wher,2);

        if(count($count)==10){//判断数据是不是已经都填写，

            foreach($count as $key => $val){

                $query['id']            = $val['id'];

                if($type=='' || $type==0){$save['statu']=$sum;$content='批准';}else{$save['statu']=1;$content='驳回';}

                $input                  = M('manage_input')->where($query)->save($save); //已有数据修改状态

            }
            if(!$input){return $content.'失败！';}else{return $content.'成功！';}

        }else{

            return '请确认所有人员预算数据已提交！';die;
        }
    }

    /**
     * year_month_day 月度当前查询日期
     * $year1 年  $month月
     */
    public function year_month_day($year1,$month){
        $day                    = 26;//当月结束天数
        if($month==1){//判断时间 如果是一月份
            $yea                = $year1-1;
            $mon                = 12;
            $ymd1               = $yea.$mon.$day;//开始时间
            $ymd2               = $year1.'01'.$day;//结束时间
        }else{
            if($month<10){ //小于10月的
                $ymd1           = $year1.'0'.($month-1).$day;//开始时间
                $ymd2           = $year1.'0'.$month.$day;//结束时间
            }else{
                if($month-1 < 10){//减一月小于10月的
                    $ymd1       = $year1.'0'.($month-1).$day;//开始时间
                }else{
                    $ymd1       = $year1.($month-1).$day;//开始时间
                }
                $ymd2           = $year1.$month.$day;//结束时间
            }
        }
        $ymd[0]                 = $ymd1;
        $ymd[1]                 = $ymd2;
        return $ymd;
    }

    /**
     * @param $data         不分摊金额
     * @param $data_share   分摊金额
     * @return array
     */
    public function department_data($data,$data_share=''){
        $money                        = array();//部门其他费用
        $count                        = 0;//公司总其他费用
        foreach($data as $key => $val){
            $count                   += $val['sum'];//公司总其他费用
        }
        if ($data_share){
            foreach ($data_share as $k => $v){
                $count               += $v['depart_sum'];
            }
        }
        $money['公司']['money']       = $count;
        $department                   = C('department');//部门顺序
        $count_departmen              = 0;//总部门其他费用
        foreach($department as $key => $val){//循环部门
            //$key                      = $key+1;
            $departmen                = 0;//部门他费用
            foreach($data as $k => $v){//循环部门其他费用
                if($val ==$v['department']){
                    $count_departmen +=$v['sum'];
                    $departmen       +=$v['sum'];//部门总计
                }else{
                    $departmen        = $departmen+0;
                }
            }
            if ($data_share){
                foreach ($data_share as $k => $v){
                  if ($v['department'] == $val){
                      $count_departmen +=$v['depart_sum'];
                      $departmen       +=$v['depart_sum'];//部门总计
                  }
                }
            }

            $money[$val]['money']       = $departmen;
        }
        $money['机关部门']['money']     = $money['公司']['money']-$count_departmen;//机关部门
        //ksort($money);
        return $money;
    }

    /**
     * yearmonthday 年度其他费用部门数据
     * $year 年
     */
    public function yearmonthday($year,$month){
        /*$day              = date('d');
        if ($month.$day > 1225){
            $ymd[0]       = $year.'1226';
            $ymd[1]       = ($year+1).'1226';
        }else{
            $ymd[0]       = ($year-1).'1226';
            $ymd[1]       = $year.'1226';
        }*/
        $ymd[0]       = ($year-1).'1226';
        $ymd[1]       = $year.'1226';
        return $ymd;
    }

    public function get_otherExpenses($departments,$kinds,$times){
        $otherExpensesKinds             = M('bxd_kind')->where(array('pid'=>2))->getField('id',true);
        $lists                          = M('baoxiao')->where(array('bx_time'=>array('between',"$times[beginTime],$times[endTime]"),'audit_status'=>1,'bxd_type'=>array('in',array(2,3)),'share'=>array('neq',1),'bxd_kind'=>array('in',$otherExpensesKinds)))->select();   //bxd_type 2=> 非团借款报销,3=>直接报销
        $share_lists                    = M()->table('__BAOXIAO_SHARE__ as s')->field('b.bxd_kind,s.*')->join('__BAOXIAO__ as b on b.id=s.bx_id','left')->where(array('b.bx_time'=>array('between',"$times[beginTime],$times[endTime]"),'b.audit_status'=>1,'b.bxd_type'=>array('in',array(2,3)),'b.bxd_kind'=>array('in',$otherExpensesKinds)))->select();
        $infos                          = array();
        $depart_business                = C('department');  //业务部门

        $heji                           = array();
        foreach ($kinds as $k=>$v){ //办公耗材,网络及通讯费,差旅费,交通费,印刷宣传费...
            $data                   = array();
            $data['jqyw']           = $this->get_sum($v,'京区业务中心',$lists,$share_lists);
            $data['jwyw']           = $this->get_sum($v,'京外业务中心',$lists,$share_lists);
            $data['nanjing']        = $this->get_sum($v,'南京项目部',$lists,$share_lists);
            $data['wuhan']          = $this->get_sum($v,'武汉项目部',$lists,$share_lists);
            $data['shenyang']       = $this->get_sum($v,'沈阳项目部',$lists,$share_lists);
            $data['changchun']      = $this->get_sum($v,'长春项目部',$lists,$share_lists);
            $data['shichang']       = $this->get_sum($v,'市场部',$lists,$share_lists);
            $data['changgui']       = $this->get_sum($v,'常规业务中心',$lists,$share_lists);
            $data['jiguan']         = $this->get_jiguan_sum($v,$depart_business,$lists,$share_lists);
            $data['gongsi']         = $data['jqyw']+$data['jwyw']+$data['nanjing']+$data['wuhan']+$data['shenyang']+$data['changchun']+$data['shichang']+$data['changgui']+$data['jiguan'];
            $infos[$k]              = $data;
            $heji['jqyw']           += $data['jqyw'];
            $heji['jwyw']           += $data['jwyw'];
            $heji['nanjing']        += $data['nanjing'];
            $heji['wuhan']          += $data['wuhan'];
            $heji['shenyang']       += $data['shenyang'];
            $heji['changchun']      += $data['changchun'];
            $heji['shichang']       += $data['shichang'];
            $heji['changgui']       += $data['changgui'];
            $heji['jiguan']         += $data['jiguan'];
            $heji['gongsi']         += $data['gongsi'];
        }
        $infos['heji']          = $heji;
        return $infos;
    }

    /**
     * 获取某部门某一类型的费用
     * @param $kindid               办公耗材,网络及通讯费,差旅费,交通费,印刷宣传费...id
     * @param $department           部门名称
     * @param string $lists         报销列表
     * @param string $share_lists   分摊列表
     */
    public function get_sum($kindid,$department,$lists='',$share_lists=''){
        $sum                    = 0;
        if ($lists){
            foreach ($lists as $k=>$v){
                if ($v['bxd_kind'] == $kindid && $v['department']== $department){
                    $sum += $v['sum'];
                }
            }
        }

        if ($share_lists){
            foreach ($share_lists as $k=>$v){
                if ($v['bxd_kind'] == $kindid && $v['department']== $department){
                    $sum += $v['depart_sum'];
                }
            }
        }
        return $sum;
    }

    /**
     * 获取机关部门费用
     * @param $kindid       办公耗材,网络及通讯费,差旅费,交通费,印刷宣传费...id
     * @param $arr          非机关部门名称
     * @param $lists        报销列表
     * @param $share_lists  分摊列表
     */
    public function get_jiguan_sum($kindid,$arr,$lists='',$share_lists=''){
        $sum                    = 0;
        if ($lists){
            foreach ($lists as $k=>$v){
                if ($v['bxd_kind'] == $kindid && !in_array($v['department'],$arr)){
                    $sum += $v['sum'];
                }
            }
        }

        if ($share_lists){
            foreach ($share_lists as $k=>$v){
                if ($v['bxd_kind'] == $kindid && !in_array($v['department'],$arr)){
                    $sum += $v['depart_sum'];
                }
            }
        }
        return $sum;
    }

    /**
     * 获取考核时间
     * @param $year     年 2019
     * @param $month    月 01
     * @param $tm       类别 : m=>月度; q=>季度; y=>年度
     * @return array    (beginTime,endTime) 时间戳
     */
    public function get_times($year,$month,$tm='m'){
        if (strlen($month)<2) $month    = str_pad($month,2,'0',STR_PAD_LEFT);
        $betweenTime                    = array();
        if ($tm=='m'){  //月度
            $yearmonth                  = $year.$month;
            $times                      = get_cycle($yearmonth,$day=26);
            $betweenTime['beginTime']   = $times['begintime'];
            $betweenTime['endTime']     = $times['endtime'];
        }elseif ($tm=='q'){ //季度
            $times                      = getQuarterlyCicle($year,$month);
            $betweenTime['beginTime']   = $times['begin_time'];
            $betweenTime['endTime']     = $times['end_time'];
        }elseif ($tm=='y'){ //年度
            $betweenTime['beginTime']   = strtotime(($year-1).'1226');
            $betweenTime['endTime']     = strtotime($year.'1226');
        }
        return $betweenTime;
    }

    /**
     * 获取考核周期内的月份信息
     * @param $year     年 2019
     * @param $month    月 01
     * @param $tm       类别 : m=>月度; q=>季度; y=>年度
     * @return array    (beginTime,endTime) 时间戳
     */
    public function get_yms($year,$month,$tm){
        if (strlen($month)<2) $month    = str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                      = array();
        if ($tm == 'm'){        //月度
            $yearMonth[]                = $year.$month;
        }elseif ($tm == 'q'){   //季度
            $quarter                    = get_quarter($month);
            switch ($quarter){
                case 1:
                    $yearMonth[]        = $year.'01';
                    $yearMonth[]        = $year.'02';
                    $yearMonth[]        = $year.'03';
                    break;
                case 2:
                    $yearMonth[]        = $year.'04';
                    $yearMonth[]        = $year.'05';
                    $yearMonth[]        = $year.'06';
                    break;
                case 3:
                    $yearMonth[]        = $year.'07';
                    $yearMonth[]        = $year.'08';
                    $yearMonth[]        = $year.'09';
                    break;
                case 4:
                    $yearMonth[]        = $year.'10';
                    $yearMonth[]        = $year.'11';
                    $yearMonth[]        = $year.'12';
                    break;
            }
        }elseif ($tm == 'y'){   //年度
            for ($m=1;$m<13;$m++){
                if (strlen($m)<2) $m    = str_pad($m,2,'0',STR_PAD_LEFT);
                $yearMonth[]            = $year.$m;
            }
        }
        return $yearMonth;
    }

    /**
     * 工资总额(应付)
     * @param $ym_arr   相关月份信息
     */
    /*public function get_wages($ym_arr){
        //$hr_cost                    = C('HR_COST');
        //$departments                = C('department1');     //公司所有部门信息
        $business_departments       = C('department');      //公司业务部门信息
        $lists                      = M('salary_departmen_count')->where(array('datetime'=>array('in',$ym_arr),'status'=>4))->select();

        $info                       = array();
        foreach ($business_departments as $value){
            $info[$value]           = 0;
            foreach ($lists as $vv){
                if ($vv['department']==$value){
                    $info[$value]   += $vv['Should'];
                }
            }
        }
        $info['机关部门']           = 0;
        $info['公司']               = 0;
        foreach ($lists as $v){
            if (!in_array($v['department'],$business_departments)){
                $info['机关部门']   += $v['Should'];
            }
            $info['公司']           += $v['Should'];
        }
        return $info;
    }*/
    public function get_wages($ym_arr){
        $lists                      = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->field('s.account_id,s.user_name,s.department,s.datetime,s.Should_distributed,a.position_id')->where(array('s.datetime'=>array('in',$ym_arr),'s.status'=>4))->select();

        $depart_account             = $this->get_account($lists);
        foreach ($depart_account as $k=>$v){
            $info[$k]               = 0;
            foreach ($lists as $key=>$value){
                if (in_array($value['account_id'],$v)){
                    $info[$k]       += $value['Should_distributed'];    //应付工资
                }
            }
        }
        return $info;
    }

    //获取每个部门的人员id
    public function get_account($lists){
        $business_departments               = C('department');      //公司业务部门信息
        $noOffice                           = array();
        foreach ($lists as $k=>$v){
            foreach ($business_departments as $value){
                if ($value == '市场部'){   //市场部只提取市场业务人员
                    $where['code']          = array('like','S%');
                    $position               = M('position')->where($where)->getField('id',true);//查询业务人员
                    if (in_array($v['position_id'],$position) && $v['department']==$value){
                        $account[$value][]  = $v['account_id'];
                        $noOffice[]         = $v['account_id'];
                    }
                }else{
                    if ($v['department']==$value){
                        $account[$value][]  = $v['account_id'];
                        $noOffice[]         = $v['account_id'];
                    }
                }
            }
            $account['公司'][]              = $v['account_id'];
        }
        foreach ($lists as $k=>$v){
            if (!in_array($v['account_id'],$noOffice)){
                $account['机关部门'][]      = $v['account_id'];
            }
        }
        return $account;
    }

    //公司五险一金
    public function get_insurance($ym_arr){
        $where                      = array();
        $where['s.datetime']        = array('in',$ym_arr);
        $field                      = "s.account_id,s.datetime,a.nickname as aname,a.position_id,d.department,i.*";
        $lists                      = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__SALARY_INSURANCE__ as i on i.id=s.insurance_id','left')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->join('__SALARY_DEPARTMENT__ as d on d.id=a.departmentid','left')->field($field)->where($where)->select();
        $sumLists                   = $this->sum_insurance($lists);
        $depart_account             = $this->get_account($sumLists);

        foreach ($depart_account as $k=>$v){
            $info[$k]               = 0;
            foreach ($sumLists as $key=>$value){
                if (in_array($value['account_id'],$v)){
                    $info[$k]       += $value['company_pay_sum'];    //公司缴纳五险一金
                }
            }
        }
        return $info;
    }

    /**
     * 求公司为个人员所缴纳五险一金(公司部分)之和
     * @param $lists
     */
    public function sum_insurance($lists){
        foreach ($lists as $k=>$v){
            $company_pay_sum        = ($v['company_birth_ratio']*$v['company_birth_base']) + ($v['company_injury_ratio']*$v['company_injury_ratio']) + ($v['company_pension_ratio']*$v['company_pension_base']) + ($v['company_medical_care_ratio']*$v['company_medical_care_base']) + ($v['company_unemployment_ratio']*$v['company_unemployment_base']) + ($v['company_accumulation_fund_ratio']*$v['company_accumulation_fund_base']);
            $lists[$k]['company_pay_sum']   = round($company_pay_sum,2);
        }
        return $lists;
    }

    /**
     * 获取人力资源成本合计费用
     * @param $info
     * @return array
     */
    public function get_sum_cost($info){
        $departments                = C('department1');     //公司所有部门信息
        $data                       = array();
        foreach ($departments as $v){
            $data[$v]     = array_sum(array_column($info,"$v"));
        }
        return $data;
    }

    /**职工福利费
     * @param $times
     * @param $kind 报销单种类
     */
    public function get_welfare($times,$kinds){
        $departments            = C('department1');
        $lists                  = $this->get_lists($times,$kinds);
        $info                   = array();
        $sum_other_depart       = 0;
        foreach ($departments as $v){
            $info['公司']       = 0;
            foreach ($lists as $key=>$value){
                $info['公司']   += $value['sum'];
                if($value['department']==$v){
                    $info[$v]   += $value['sum'];
                    $sum_other_depart += $value['sum'];
                }
            }
        }
        $info['机关部门']       += $info['公司'] - $sum_other_depart;
        return $info;
    }

    private function get_lists($times,$kinds){
        $not_share_lists        = $this->not_share_list($times,$kinds);
        $share_lists            = $this->share_list($times,$kinds);
        $lists                  = array_merge($not_share_lists,$share_lists);
        return $lists;
    }

    /**
     * not_share_list 非团支出报销（其他费用）(不分摊)
     * $ymd1 开始时间 20180626
     * $ymd2 结束时间 20180726
     */

    public function not_share_list($times,$kinds=''){
        $map['bx_time']         = array('between',"$times[beginTime],$times[endTime]");//开始结束时间
        $map['bxd_type']        = array('in',array(2,3));//2 非团借款报销 3直接报销
        $map['audit_status']    = array('eq',1);    //审核通过
        $map['share']           = array('neq',1);   //不分摊
        $map['bxd_kind']        = array('in',$kinds);
        $money                  = M('baoxiao')->where($map)->select();//日期内所有数据
        return  $money;
    }

    /**
     * 非团支出报销(其他费用)(分摊)
     * @param $ymd1
     * @param $ymd2
     * @return mixed
     */
    public function share_list($times,$kinds=''){

        $where                      = array();
        $where['b.bx_time']         = array('between',"$times[beginTime],$times[endTime]");//开始结束时间
        $where['b.bxd_type']        = array('in',array(2,3));//2 非团借款报销 3直接报销
        $where['b.audit_status']    = array('eq',1);    //审核通过
        $where['b.bxd_kind']        = array('in',$kinds);
        $money                      = M()->table('__BAOXIAO_SHARE__ as s')->field('b.bxd_kind,s.*,s.depart_sum as sum')->join('__BAOXIAO__ as b on b.id=s.bx_id','left')->where($where)->select();
        return  $money;
    }


    /**
     * 获取不能修改预算信息的部门(已提交审核)
     * @param $year
     * @param $type
     * @return array
     */
    public function get_upd_department($year,$type){
        $db                         = M('manage_input');
        $all_departments            = C('department1');
        if (in_array(session('userid'),array(11))){ //乔总
            $data                   = $all_departments;
        }else{
            $where                  = array();
            $where['datetime']      = $year;
            $where['type']          = $type;
            $where['statu']         = array('in',array(2,4)); //2=>待审核, 4=>审核通过
            $unupd_departments      = $db->where($where)->getField('logged_department',true); //不可修改的部门
            $data                   = array();
            foreach ($all_departments as $v){
                if (!in_array($v,$unupd_departments)){
                    $data[]         = $v;
                }
            }
        }
        return $data;
    }

    /**
     * 获取待审核数据
     * @param $year
     * @param $type
     * @return mixed
     */
    public function get_check_data($year,$type){
        $db                         = M('manage_input');
        $where                      = array();
        $where['datetime']          = $year;
        $where['type']              = $type;
        $where['statu']             = array('in',array(1,3)); //1=>未审核, 3=>审核不通过
        $lists                      = $db->where($where)->select(); //待审核的数据
        return $lists;
    }

    /**
     * 有无待审核信息(是否显示待审核按钮)
     * @param $year
     * @param $type
     * @return mixed
     */
    public function show_check($year,$type){
        $db                         = M('manage_input');
        $where                      = array();
        $where['datetime']          = $year;
        $where['type']              = $type;
        $where['statu']             = 2; //2=>待审核
        $lists                      = $db->where($where)->select(); //待审核的数据
        return $lists;
    }

    /**
     * 获取已审核通过的数据信息
     * @param $year
     * @param $type
     */
    public function get_checked_lists($year,$type){
        $db                         = M('manage_input');
        $where                      = array();
        $where['datetime']          = $year;
        $where['type']              = $type;
        $where['statu']             = 4; //审批通过
        $lists                      = $db->where($where)->select();
        return $lists;
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
        $otherExpensesKindData  = $this->getOtherExpensesKinds();
        $otherExpensesKinds     = $otherExpensesKindData['ids'];
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
        $otherExpensesKindData      = $this->getOtherExpensesKinds();
        $otherExpensesKinds         = $otherExpensesKindData['ids'];
        $where['b.bxd_kind']        = array('in',$otherExpensesKinds);
        $money                      = M()->table('__BAOXIAO_SHARE__ as s')->field('b.bxd_kind,s.*')->join('__BAOXIAO__ as b on b.id=s.bx_id','left')->where($where)->select();
        return  $money;
    }

    //获取其他费用类型(不包含代收代付)
    public function getOtherExpensesKinds(){
        $kind                       = M('bxd_kind')->where(array('pid'=>2,'name'=>array('neq','代收代付')))->getField('id,name',true);
        $data                       = array();
        $data['kind']               = $kind;
        $data['ids']                = array_keys($kind);
        return $data;
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
                $sum[$v['depname']]['monthmll']     = $sum[$v['depname']]['monthzsr'] ? round($sum[$v['depname']]['monthzml']/$sum[$v['depname']]['monthzsr'],4)*100 : '0%';
            }
        }
        return $sum;
    }

    /**
     * business 营业收入 营业毛利 营业毛利率
     * $year 年 $month月
     * $pin 1 结算 0预算
     */
    public function  business($year,$month,$type){
        $chartMod                    = D('Chart');
        if (strlen($month)<2) $month = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                       = $year.$month;
        $yw_departs                  = C('YW_DEPARTS');  //业务部门id
        $where                       = array();
        $where['id']                 = array('in',$yw_departs);
        $departments                 = M('salary_department')->field('id,department')->where($where)->select();
        //预算及结算分部门汇总
        $listdatas                   = $chartMod->count_lists($departments,$year,$month,$type);//1 结算 0预算
        return $listdatas;
    }

}

?>
