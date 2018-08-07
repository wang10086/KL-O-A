<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class SalaryController extends BaseController {

    /**
     * @salaryindex
     * oid id    name名字  department 部门  position 职位
     * staff_style 员工类别 1新入职 2 转正 3正式 4实习 5离职 6试用 7劳务
     * employee_member 员工编号
     */
     public function salaryindex(){

         if(IS_POST){//传值判断
             $where['id'] = $_POST('oid');
             $where['user_name'] = $_POST('name');
             $where['department'] = $_POST('department');
             $where['position'] = $_POST('position');
             $where['staff_style'] = $_POST('staff_style');
             $where['department'] = $_POST('employee_member');
             $where = array_filter($where);

             $list = M('salary')->field('id,user_id,createtime,wages,deduction_money,achievements_status,achievements,post_tax_wage,personal_income_tax,year_end_personal_income_tax,trade_union_fee,insurance_id')->where($where)->order('createtime desc')->select();

         }else{

             $list = M('salary')->field('id,user_id,createtime,wages,deduction_money,achievements_status,achievements,post_tax_wage,personal_income_tax,year_end_personal_income_tax,trade_union_fee,insurance_id')->order('createtime desc')->select();

         }
         foreach($list as $key =>$val){//获取所有扣款
             $id = $list[$key]['insurance_id'];
             $insurance = M('insurance')->where("id=$id")->find();
             $list[$key]['insu_money'] = $insurance['birth']+$insurance['injury']+$insurance['pension']+$insurance['medical_care']+$insurance['unemployment']+$insurance['accumulation_fund'];
             $list[$key]['_money'] =$list[$key]['deduction_money']+$list[$key]['personal_income_tax']+$list[$key]['year_end_personal_income_tax']+$list[$key]['trade_union_fee']+$list[$key]['insu_money'];
             //查询员工信息
             $userid = $list[$key]['user_id'];
             $user = M('salary_user')->where("id=$userid")->find();
             $list[$key]['user_name']= $user['user_name'];
             $list[$key]['employee_member']= $user['employee_member'];
//             print_r($list);die;

         }
         $this->assign('list',$list);
         $this->assign('ptitle',人力管理);
         $this->assign('title',员工薪资);
         $this->display();
    }
    private function operationlistadd(){

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