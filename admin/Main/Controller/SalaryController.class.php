<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class SalaryController extends BaseController {

    /**
     * @salaryindex
     * id id    name名字
     * staff_style 员工类别 1新入职 2 转正 3正式 4实习 5离职 6试用 7劳务
     * employee_member 员工编号 salary_time 发工资时间
     */
     public function salaryindex(){
         if(IS_POST){//传值判断
             $where['id'] = trim($_POST['id']);
             $where['nickname'] = trim($_POST['name']);
             $where['salary_time'] = trim($_POST['salary_time']);
             $where['staff_style'] = trim($_POST['staff_style']);
             $where['employee_member'] = trim($_POST['employee_member']);
             $where = array_filter($where);//去空数组键和值
             if(!empty($where['salary_time'])){
                 $time = strtotime(date('Y-m',strtotime($where['salary_time'])));//转换年月时间戳
                 unset($where['salary_time']);
                 $where['salary_time'] = $time;
             }
             $sql = "SELECT *,oa_salary.id as sid FROM oa_salary LEFT JOIN oa_account ON ";
             foreach($where as $key =>$val){//判断条件
                 if($key=='nickname'){
                     $k = "oa_account.$key";
                 }else{
                     $k = "oa_salary.$key";
                 }
                 $sql .= "$k = '$val' AND ";
             }
             $sql = substr($sql,0,-4);//去除最后一个 AND
             $sql .="WHERE oa_salary.account_id = oa_account.id ORDER BY oa_salary.createtime DESC";
             $list = M()->query($sql);
             if(!$list)$this->success('您的输入条件不存在！', U('Salary/salaryindex'));

         }else{
             $list = M('salary')->alias('a')->field('*,a.id as sid')->join('oa_account b on a.account_id = b.id')->select();
         }
//         foreach ($list as $key => $val){
//
//         }
//         $subsidy = $list['bonus']+$list['housing_subsidy']+$list['other_subsidie']+$list['subsidy']; //奖金+住房补贴+其他补贴+其他补助
//         $ll = $list[0]['bonus'];
//         print_r($ll);die;
         $this->assign('list',$list);
         $this->display();
    }


    public function salaryadd(){

        $this->display();
    }

    /**
     * @salarydetails
     * 员工详情页
     */
    public function salarydetails(){
        $where['id'] = I('id');
//        print_r($id);die;

        $list = M('salary')->where($where)->order('createtime desc')->find();//单个员工详情
        $userid = $list['user_id'];
        $user = M('salary_user')->where("id=$userid")->find();
        $id = $list['insurance_id'];
        $insurance = M('insurance')->where("id=$id")->find();//五险一金

        $this->assign('row',$list);
        $this->assign('user',$user);
        $this->assign('insurance',$insurance);
        $this->display();
    }

}