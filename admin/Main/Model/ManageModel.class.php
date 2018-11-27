<?php
namespace Main\Model;
use Think\Model;
use Sys\P;

class ManageModel extends Model{

    //月度经营统计
    public function month(){
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
                    $month[$key]['employees_sum'] = $this->number_people();
                }
                $key                              = $key+1;
                //月度统计 数额
                $month[$key]['employees_sum']     = $this->number_people($where);
                //月度统计 占比
                $month[$key]['proportion']        = (round($month[$key]['employees_sum']/$month[0]['employees_sum'],4)*100).'%';
            }
        }
        return $month;
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