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
     * employee_member 员工编号 salary_time 发工资时间
     */
     public function salaryindex(){
         if(IS_POST){//传值判断
             $where['id'] = trim($_POST['id']);
             $where['nickname'] = trim($_POST['name']);
             $where['salary_time'] = trim($_POST['salary_time']);
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
             $count = count(M()->query($sql));//分页数量
             $page = new Page($count,5);
             $pages = $page->show();
             $sql .="WHERE oa_salary.account_id = oa_account.id ORDER BY oa_salary.createtime DESC LIMIT $page->firstRow,$page->listRows";
             $list = M()->query($sql);//分页页数
//             print_r($list);die;
             if(!$list)$this->success('您的输入条件不存在！', U('Salary/salaryindex'));

         }else{
             $count = M('salary')->alias('a')->field('*,a.id as sid')->join('oa_account b on a.account_id = b.id')->count();//数据数量
             $business_depts = C('BUSINESS_DEPT');//调用config
             $page = new Page($count,5);//显示的页数
             $pages = $page->show();//分页
             $list = M('salary')->alias('a')->field('*,a.id as sid')->join('oa_account b on a.account_id = b.id')->limit($page->firstRow.','.$page->listRows)->select();//分页数据
         }
         foreach ($list as $key => $val){
             $list[$key]['_subsidy'] = $list[$key]['bonus']+$list[$key]['housing_subsidy']+$list[$key]['other_subsidie']+$list[$key]['subsidy'];//奖金+住房补贴+其他补贴+其他补助
             $insurance_id['id'] = $list[$key]['insurance_id'];
             $insurance = M('insurance')->where($insurance_id)->find();
             //年终奖个税+年终奖个税+工会会费 + 五险一金 = 税费扣款
             $list[$key]['_taxation'] = $list[$key]['personal_income_tax']+$list[$key]['year_end_personal_income_tax']+$list[$key]['trade_union_fee']+$insurance['birth']+$insurance['injury']+$insurance['pension']+$insurance['medical_care']+$insurance['unemployment']+$insurance['accumulation_fund'];
         }
         $this->assign('list',$list);
         $this->assign('page',$pages);
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