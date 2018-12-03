<?php
namespace Main\Model;
use Think\Model;
use Sys\P;

class ManageModel extends Model{

    //月度经营统计
    public function month($year,$month){

        if($month<10 || $month==0 || $month==''){ //判断时间是否空 和 小于10
            if($month==0 || $month==''){ //为空默认
                $month          = date('m');
            }
            if($month<10){ //小于10 添加为符合条件的字段
                $datetime       = $year.'0'.$month;
            }else{ //不小于10 直接获取年月
                $datetime       = $year.$month;
            }
        }
        $salary_month           = M('salary_wages_month')->field('id')->where('datetime='.$datetime)->select();//获取发工资的人
         if(!$salary_month){
            return 0;
         }
        $sum_count              = count($salary_month);//获取发工资的人数
        foreach($salary_month as $key =>$val){
            $id['id'] = $val['account_id'];
            $account = M('account')->where($id)->find();

        }
//        print_r($salary_month);die;

        $month1 = $this->amount();//数额
        return $month1;
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