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
        $datime['status']                       = 4;//数据锁定
        $account[0]['sum']                      = $this->userinfo($datime,5);//获取发工资的人员数量
        $account[0]['money']                    = (float)$this->userinfo($datime,2)['Should'];//获取人力资源成本（应发工资）
        //  array('6','7','12','13','14','16','2','15');//部门  'F','G','L','M','N','P','B','O'
        $arr1                                   = array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心');//部门
        $number                                 = $account[0]['sum'];
        $num                                    = $account[0]['money'];
        $sum                                    = 0;
        foreach($arr1 as $key =>$val){//循环发工资的部门人数 $key=0 公司
            $key                                = $key+1;
            $datime['department']               = $val;
            if($val=='市场部'){ //业务人员
                $where['code']                  = array('like','S%');
                $position                       = M('position')->where($where)->select();//查询业务人员
                $wher['departmentid']           = 2;
                $wher['status']                 = 0;
                foreach($position as $k => $v){
                    $wher['position_id']        = $v['id'];
                    $info                       = $this->userinfo($wher,1);//查询业务人员信息
                    $account[$key]['sum']       = count($info);//业务人员人数
                    foreach($info as $ke => $va){
                        $datime['account_id']   = $va['id'];
                        $money                  = $this->userinfo($datime,4)['Should_distributed'];//查询业务人员人力资源成本
                        if($money){
                            $number             = $number-1;
                        }
                        $account[$key]['money'] = $account[$key]['money']+$money;//查询业务人员人力资源成本
                        unset($datime['account_id']);
                    }
                }
                $num                            = $num-$account[$key]['money'];
            }else{ //非市场业务人员
                $salary_month1                  = $this->userinfo($datime,3);//获取发工资的应发工资(所有)
                $account[$key]['sum']           = count($salary_month1);//人数
                foreach($salary_month1 as $k=>$v){
                    $account[$key]['money']     = $account[$key]['money']+$v['Should_distributed'];//人力资源成本
                    $number                     = $number-1;
                }
                $num                            = $num-$account[$key]['money'];
            }
            $sum                                = $key+1;
        }
        $account[$sum]['sum']                   = $number;
        $account[$sum]['money']                 = $num;
        return $account;
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
     * userinfo 获取用户信息 价格
     * $type 1 用户所有条件信息 2 总价格列表信息 3价格列表信息
     */
    public function userinfo($where,$type){
        if($type==1){
            return M('account')->field('id,employee_member,nickname,roleid,postid,position_id')->where($where)->select();die;
        }elseif($type==2){
            return  M('salary_count_money')->field('id,datetime,Should')->where($where)->find();die;
        }elseif($type==3){
            return  M('salary_wages_month')->field('id,account_id,datetime,Should_distributed')->where($where)->select();die;
        }elseif($type==4){
            return  M('salary_wages_month')->field('id,account_id,datetime,Should_distributed')->where($where)->find();die;
        }elseif($type==5){
            return  M('salary_wages_month')->field('id,account_id,datetime,Should_distributed')->where($where)->count();die;
        }{
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
     * manageyear 年变化
     *$year 年  $post 1 加年  2 减年
     */
    public function manageyear($year,$post){
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
     * managemonth 月变化
     *$month 月
     */
    public function managemonth($month){
        if(is_numeric($month)){
            return $month;
        }else{
           return date('m');
        }
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