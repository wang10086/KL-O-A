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
//         if(IS_POST){//传值判断
//             $where['id'] = trim($_POST['id']);
//             $where['nickname'] = trim($_POST['name']);
//             $where['salary_time'] = trim($_POST['salary_time']);
//             $where['employee_member'] = trim($_POST['employee_member']);
//             $where = array_filter($where);//去空数组键和值
//             if(!empty($where['salary_time'])){
//                 $time = strtotime(date('Y-m',strtotime($where['salary_time'])));//转换年月时间戳
//                 unset($where['salary_time']);
//                 $where['salary_time'] = $time;
//             }
//             $sql = "SELECT *,oa_salary.id as sid FROM oa_salary LEFT JOIN oa_account ON ";
//             foreach($where as $key =>$val){//判断条件
//                 if($key=='nickname'){
//                     $k = "oa_account.$key";
//                 }else{
//                     $k = "oa_salary.$key";
//                 }
//                 $sql .= "$k = '$val' AND ";
//             }
//             $sql = substr($sql,0,-4);//去除最后一个 AND
//             $sql .="WHERE oa_salary.account_id = oa_account.id ORDER BY oa_salary.createtime DESC";
//         }else{
//             $sql = "SELECT *,oa_salary.id as sid FROM oa_salary LEFT JOIN oa_account ON oa_salary.account_id = oa_account.id ORDER BY oa_salary.createtime DESC";
//         }
//         $count = count(M()->query($sql));
//         $page = new Page($count,12);
//         $pages = $page->show();
//         $list = M()->query($sql." LIMIT ".$page->firstRow.",".$page->listRows);//分页页数
//         if(!$list) $this->success('您的输入条件不存在！', U('Salary/salaryindex'));
//         foreach ($list as $key => $val){
//             $list[$key]['_subsidy'] = $list[$key]['bonus']+$list[$key]['housing_subsidy']+$list[$key]['other_subsidie']+$list[$key]['subsidy'];//奖金+住房补贴+其他补贴+其他补助
//             $insurance_id['id'] = $list[$key]['insurance_id'];
//             $insurance = M('salary_insurance')->where($insurance_id)->find();
//             //年终奖个税+年终奖个税+工会会费 + 五险一金 = 税费扣款
//             $list[$key]['_taxation'] = $list[$key]['personal_income_tax']+$list[$key]['year_end_personal_income_tax']+$list[$key]['trade_union_fee']+$insurance['birth']+$insurance['injury']+$insurance['pension']+$insurance['medical_care']+$insurance['unemployment']+$insurance['accumulation_fund'];
//         }
//         $this->assign('list',$list);
//         $this->assign('page',$pages);
         $this->display();
    }


    /**
     * @salarydetails
     * 员工详情页
     */
    public function salarydetails(){
        $id = $_GET['id'];
//        if(is_numeric($id)){
//           // $list = M()->table('oa_salary as s,oa_salary_insurance as i,oa_salary_attendance as at,oa_account as a,oa_posts as p,oa_role as r')->where("s.id=$id and s.account_id=a.id and s.insurance_id=i.id and s.attendance_id=at.id and a.roleid=r.id and a.postid=p.id")->find();
////            echo M()->getLastSql();
//                $list = M('salary')->field('*,oa_salary.id as sid')->where('sid='.$id)->field('oa_salary.id as sid,*')
//                                                        ->join('oa_salary on oa_salary.account_id=oa_account.id')
//                                                        ->join('oa_salary on oa_salary.insurance_id=oa_salary_insurance.id')
//                                                        ->join('oa_salary on oa_salary.attendance_id=oa_salary_attendance.id')
//                                                        ->join('oa_account on oa_account.roleid=oa_role.id')
//                                                        ->join('oa_account on oa_account.postid=oa_posts.id')
//                                                        ->find();echo M()->getLastSql();
//            print_r($list);die;
//        }else{
//            $this->success('您的数据有误!请重新选择！', U('Salary/salaryindex'));
//        }
        $this->display();
    }

}