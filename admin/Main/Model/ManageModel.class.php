<?php
namespace Main\Model;
use Think\Model;
use Sys\P;

class ManageModel extends Model{

    //月度经营统计
    public function month($year,$month){
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
        $arr                                                = array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心');//部门
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
    public function datetime($year,$month){

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
    }

    /**
     * userinfo 获取用户信息 价格
     * $type 1 用户所有条件信息 2 总价格列表信息 3价格列表信息
     */
    public function userinfo($where,$type){

        if($type==1){

            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->select();die;

        }elseif($type==2){

            return M('salary_count_money')->field('id,datetime,Should')->where($where)->find();die;

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
    public function profit($money){

        $arr                                          = array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心');//部门

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
    }

    /**
     * manageyear 年变化
     *$year 年  $post 1 加年  2 减年
     */
    public function manageyear($year,$post){

        if(is_numeric($year)){//判断有无传送年

            if(is_numeric($post) && $post==1){

                $year       = $year-1;

            }elseif(is_numeric($post) && $post==2){

                $year       = $year+1;
            }

        }else{ //没有就默认

            $year           = date('Y');
        }
        return $year;
    }


    /**
     * human_affairs人事费用率
     * $number 人力资源成本
     * $profit 总 收入 毛利 毛利率
     * $departmen 部门 收入 毛利 毛利率
     */

    public function human_affairs($number,$profit,$departmen){

        $affairs                          = $this->company_profit($profit,$departmen);//营业收入合并成需求数组

        foreach($number as $key => $val){

            $human[$key]['human_affairs'] = round(($val['money']/$affairs[$key]['affairs'])*100,2);//人事费用率
        }
        return $human;
    }

    /**
     * total_profit 月度利润总额
     * $number人力资源成本
     * $profit  总 营业收入
     * $departmen 部门 营业收入
     */
    public function total_profit($number,$profit,$departmen){

        $departmen[0]['department']['monthzml'] = $profit['monthzml'];//总毛利 添加到部门营业毛利中

        $departmen[9]['department']['monthzml'] = 0;//机关部门营业毛利默认为0

        ksort($departmen);//按键值进行排序

        foreach($departmen as $key => $val){

           $total_profit[$key]['total_profit']  =  round($val['department']['monthzml']-$number[$key]['money'],2); //营业毛利-人力资源成本
        }
        return $total_profit;
    }

    /**
     * company_profit 月度 人力资源成本 营业收入
     *$profit 总 营业收入 毛利 毛利率
     * $departmen 部门 营业收入 毛利 毛利率
     */
    public function company_profit($profit,$departmen){

        $affairs[0]['affairs']        = $profit['monthzsr'];//公司营业收入

        $sum                          = 0;

        foreach($departmen as $key =>$val){

            $affairs[$key]['affairs'] = $val['department']['monthzsr'];//部门营业收入

            $sum                      = $key + 1;
        }
        $affairs[$sum]['affairs']     = 0.00;//机关部门营业收入

        return $affairs;
    }

    /**
     * quarter 季度 年月 数据值修正返回
     *  $year 加减年 $quarter季度
     */
    public function quarter($year,$quarter){
        $arr1                                    = array('3','6','9','12');
        $i                                       = 0; //现在季度月 减一
        $company                                 = array(); //季度内数据总和
        $count_sum                               = 3;
        $content                                 = array();
        $count                                   = array();
        if(in_array($quarter,$arr1)){ //判断是否是第一、二、三、四季度
            for($n = 3; $n > $i;$i++){ //
                $month                           =  $quarter-$i; //季度上一个月
                $count[$i]                       = $this->month($year,$month); //季度 人数和 人力资源成本
                foreach($count[$i] as $k => $v){
                    $company[$k]['sum']         += $v['sum'];//人数相加
                    $company[$k]['money']       += $v['money'];//人力资源成本相加
                }
                foreach($count[$i] as $key =>$val){ //删除数组等于空 和 0 的数据、
                    if(($val['sum']=='' || $val['sum']==0) && ($val['money']=='' || $val['money']==0)){
                        unset($count[$i][$key]);
                    }else{
                        if($val['sum']=='' || $val['sum']==0){unset($count[$i][$key]['sum']);}
                        if($val['money']=='' || $val['money']==0){unset($count[$i][$key]['money']);}
                    }
                }
                if(count($count[$i]) ==0 || $count[$i]==''){$count_sum = $count_sum -1;unset($count[$i]);}
            }
            foreach($company as $ke => $va){$company[$ke]['sum'] = round($va['sum']/$count_sum,2);}
            return $company;
        }else{
            for($n = 3;$n > $i;$i++){
                $month                           = $quarter-$i;
                if($month==3 || $month==6 || $month==9 || $month==12){
                    $count_sum = count($company);
                    foreach($company as $ke => $va){$company[$ke]['sum'] = round($va['sum']/$count_sum,2);}
                    return $company;
                }else{
                    $count[$i]                   = $this->month($year,$month); //季度 人数和 人力资源成本
                    foreach($count[$i] as $k => $v){
                        $company[$k]['sum']     += $v['sum'];//人数相加
                        $company[$k]['money']   += $v['money'];//人力资源成本相加
                    }
                    foreach($count[$i] as $key =>$val){ //删除数组等于空 和 0 的数据、
                        if(($val['sum']=='' || $val['sum']==0) && ($val['money']=='' || $val['money']==0)){
                            unset($count[$i][$key]);
                        }else{
                            if($val['sum']=='' || $val['sum']==0){unset($count[$i][$key]['sum']);}
                            if($val['money']=='' || $val['money']==0){unset($count[$i][$key]['money']);}
                        }
                    }
                    $count[$i]                  = array_filter($count[$i]);//去空和0
                }
            }
        }
    }

    /**
     * manage_quarter 季度利润总额
     * $quarter  人数 人力资源成本
     * $profits 季度数据 总收入 总毛利 总利率
     */
    public function manage_quarter($quarter,$profits){

        foreach($quarter as $key =>$val){ //循环数据

            //季度利润总额 = 季度总毛利-人力资源成本
           $countprofit[$key]['monthzml'] =  $profits[$key]['monthzml']-$val['money'];
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
        $arr                                            = array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心');//部门
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
        $arr                                         = array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心');//部门
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
     */
    public function count_profit($yea_report,$profit){

        foreach($yea_report as $key =>$val){

            $profit_sum[$key]['yearprofit'] = $profit[$key]['yearzml']-$val['money'];//利润总额 = 营业毛利-人力资源成本

            $profit_sum[$key]['personnel']  = round(($val['money']/$profit[$key]['yearzml'])*100,2);//人事费用率=人力资源成本/营业毛利

        }
        return $profit_sum;
    }
}

?>