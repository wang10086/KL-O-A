<?php
namespace Main\Model;
use Think\Model;
use Sys\P;

class ManageModel extends Model{

    //月度经营统计
    public function month($year,$month){
        $year = 2018;$month=9;
        $datetime                               = $this->datetime($year,$month);
        $datime['datetime']                     = $datetime;
        $datime['status']                       = 4;
        $salary_month                           = M('salary_wages_month')->where('datetime='.$datetime)->select();//获取发工资的人
         if(!$salary_month){
            return 0;
         }
        $account[0]['sum']                      = count($salary_month);//获取发工资的人数
        $arr1                                   = array('F','G','L','M','N','P','B');
        $sum                                    = 0;
        $count                                  = $account[0]['sum'];
        foreach($arr1 as $key =>$val){//循环发工资的部门人数
            $key                                = $key+1;
            $where['employee_member']           = array('like',$val.'%');
            foreach($salary_month as $k =>$v){ //人员信息
                $where['id']                    = $v['account_id'];
                if($val=="B"){
                    $arr['position_name']       = array('like','%S%');
                    $position                   =  M('position')->where($arr)->select();
                    foreach($position as $ke => $va){ // 市场部业务人员信息
                        $where['position_id']   = $va['id'];
                        $userinfo[$key][$k]     = $this->userinfo($where);
                        if($userinfo[$key][$k]==''){
                            unset($userinfo[$key][$k]);
                        }
                    }
                    $count                      = $count-$account[$key]['sum'];//机关部门
                }else{
                    $userinfo[$key][$k]         = $this->userinfo($where);
                    if($userinfo[$key][$k]==''){
                        unset($userinfo[$key][$k]);
                    }
                }
            }
            $account[$key]['sum']               = count($userinfo[$key]);
            $count                              = $count-$account[$key]['sum'];//机关部门
            $sum                                = $key+1;
        }
        $wher['roleid']                         = 19; //常规旅游中心
        $userinfo[$sum]                         = $this->userinfo($wher,1);
        $account[$sum]['sum']                   = count($userinfo[$sum]);
        $num                                    = $sum+1;
        $account[$num]['sum']                   = $count-$account[$sum]['sum'];//机关部门人数
        $list['account']                        = $account;
        $list['userinfo']                       = $userinfo;
        return $list;
    }

    /**
     * sum 工资表 人力资源成本
     */
    public function sum_money($infomoney,$year,$month){
        $year = 2018;$month=9;
        $datetime                       = $this->datetime($year,$month);
        $datime['datetime']             = $datetime;
        $datime['status']               = 4;
        $count_money[0]['money']        = M('salary_count_money')->field('id,datetime,Should')->where($datime)->find();
        foreach($infomoney as $key => $val){
            $sum = 0;
            foreach($val as $k => $v){
                $datime['account_id']   = $v['id'];
                $salary_list            = M('salary_wages_month')->where($datime)->find();
                $sum += $salary_list['Should_distributed'];

            }
            $info[$key]['money'] = $sum;
        }


    }

    /**
     * datetime 年月 日期变换
     */
    public function datetime($year,$month){
        $datetime                               = 0;
        if($month<10 || $month==0 || $month==''){ //判断时间是否空 和 小于10
            if($month==0 || $month==''){ //为空默认
                $month                          = date('m');
            }
            if($month<10){ //小于10 添加为符合条件的字段
                $datetime                       = $year.'0'.$month;
            }else{ //不小于10 直接获取年月
                $datetime                       = $year.$month;
            }
        }
        return $datetime;
    }

    /**
     * userinfo 获取用户信息
     */
    public function userinfo($where,$type){
        if($type==1){
            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->select();die;
        }else{
            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->find();die;
        }
    }

    //月度统计 数额
    public function amount(){
        $arr1   = array('F','G','L','M','N','P','B');
        foreach($arr1 as $key =>$val){
            $where['employee_member']             = array('like','%'.$val.'%');

            if($key>=0){
                if($key<1){
                    //公司月度统计 数额
                    $month[$key]['employees_sum'] = $this->project_name($val);
                    $month[$key]['proportion']    = $this->number_people();
                }
                $key                              = $key+1;
                //月度统计 数额
                $month[$key]['employees_sum']     = $this->number_people($where);
                //月度统计 占比
                $month[$key]['proportion']        = (round($month[$key]['employees_sum']/$month[0]['proportion'],4)*100).'%';
            }
        }
        return $month;
    }

    /**
     * yearmonth 年月变化
     */
    public function yearmonth($year,$post){
        if(is_numeric($year)){//判断有无传送年
            if(is_numeric($post) && $post==1){
                $year = $year-1;
            }elseif(is_numeric($post) && $post==2){
                $year = $year+1;
            }
        }else{ //没有就默认
            $year = date('Y');
        }
        return $year;
    }
    /**
     * yearmonth 年月变化
     */
    public function yearquarter($year,$post){
        if(is_numeric($year)){//判断有无传送年
            if(is_numeric($post) && $post==1){
                $year = $year-1;
            }elseif(is_numeric($post) && $post==2){
                $year = $year+1;
            }
        }else{ //没有就默认
            $year = date('Y');
        }
        return $year;
    }
    /**
     * 项目排列名称
     */
    public  function project_name($project){
        switch ($project) {
            case 0:
                return '员工人数';
                break;
            case 1:
                return '营业收入';
                break;
            case 2:
                return '营业毛利';
                break;
            case 3:
                return '营业毛利率(%)';
                break;
            case 4:
                return '人力资源成本';
                break;
            case 5:
                return '其他费用';
                break;
            case 6:
                return '利润总额';
                break;
            case 7:
                return '人事费用率';
                break;
            default:
                break;
        }
    }

    /**
     * 项目排列公司名称
     */
    public  function project_company_name($project){
        switch ($project) {
            case 'F':
                return '京区业务中心';
                break;
            case 'G':
                return '京外业务中心';
                break;
            case 'L':
                return '南京项目部';
                break;
            case 'M':
                return '武汉项目部';
                break;
            case 'N':
                return '沈阳项目部';
                break;
            case 'P':
                return '长春项目部';
                break;
            case 'B':
                return '市场部';
                break;
            default:
                break;
        }
    }
    // 月度部门人数
	public function number_people($where){
        $where['status'] = 0;
        $num = M('account')->where($where)->count();
        return $num;
    }

    //月度统计 营业收入
    public function operation_revenue(){

    }
    //月度统计 毛利
    public function profit(){

    }
    //月度统计 毛利率
    public function profit_rate(){

    }
}
?>