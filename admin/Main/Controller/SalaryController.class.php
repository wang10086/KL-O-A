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
//             $where['grant_time'] = trim($_POST['month']);
//             $where['employee_member'] = trim($_POST['employee_member']);
//             $where = array_filter($where);//去空数组键和值
//             if(!empty($where['grant_time'])){
//                 $time = strtotime(date('Y-m',strtotime($where['grant_time'])));//转换年月时间戳
//                 unset($where['grant_time']);
//                 $where['grant_time'] = $time;
//             }
//             $sql = "SELECT *,oa_salary.id as sid FROM oa_salary LEFT JOIN oa_account ON ";
//             foreach($where as $key =>$val){//判断条件
//                 if($key=='nickname'){
//                     $k = "oa_account.$key";
//                 }elseif($key=='employee_member'){
//                     $k = "oa_account.$key";
//                 }else{
//                     $k = "oa_salary.$key";
//                 }
//                 $sql .= "$k = '$val' AND ";
//             }
//             $sql = substr($sql,0,-4);//去除最后一个 AND
//             $sql .="WHERE oa_salary.account_id = oa_account.id ORDER BY oa_account.employee_member ASC";
//         }else{
//             $sql = "SELECT *,oa_salary.id as sid FROM oa_salary LEFT JOIN oa_account ON oa_salary.account_id = oa_account.id ORDER BY oa_account.employee_member ASC";
//         }
//         $count = count(M()->query($sql));
//         $page = new Page($count,12);
//         $pages = $page->show();
//         $list = M()->query($sql." LIMIT ".$page->firstRow.",".$page->listRows);//分页页数
//         if(!$list){$this->success('您的输入条件不存在！', U('Salary/salaryindex'));die;}else{
//         foreach ($list as $key => $val){
//             $list[$key]['_subsidy'] = $list[$key]['bonus']+$list[$key]['housing_subsidy']+$list[$key]['other_subsidie']+$list[$key]['subsidy'];//奖金+住房补贴+其他补贴+其他补助
//             $insurance_id['id'] = $list[$key]['insurance_id'];
//             $insurance = M('salary_insurance')->where($insurance_id)->find();
//             //年终奖个税+年终奖个税+工会会费 + 五险一金 = 税费扣款
//             $list[$key]['_taxation'] = $list[$key]['personal_income_tax']+$list[$key]['year_end_personal_income_tax']+$list[$key]['trade_union_fee']+$insurance['birth']+$insurance['injury']+$insurance['pension']+$insurance['medical_care']+$insurance['unemployment']+$insurance['accumulation_fund'];
//         }}
//         $this->assign('list',$list);
//         $this->assign('page',$pages);
         $this->display();
    }


    /**
     * @salarydetails
     * 员工详情页
     */
    public function salarydetails(){
//        $id = $_GET['id'];
//
//        if(is_numeric($id)){
//            $list = M()->table('oa_salary as S')->join('oa_salary_attendance as T on T.id=S.attendance_id')->join('oa_account as A on A.id=S.account_id')->join('oa_salary_department as D on D.id=A.departmentid')->join('oa_posts as P on A.postid=P.id')->field('*,S.id as sid')->where("s.id='$id'")->find();
////            echo M()->getLastSql(); print_r($list);die;
//        }else{
//            $this->success('您的数据有误!请重新选择！', U('Salary/salaryindex'));
//        }
//        $this->assign('row',$list);
        $this->display();
    }


    /**
     * @salary_attendance
     * 考勤列表
     */
    public function salary_attendance(){


//        $count = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->field('*,S.id as sid')->count();
//        $page = new Page($count,12);
//        $pages = $page->show();
//        if(IS_POST){
//            $where['id'] = trim($_POST['id']);
//            $where['employee_member'] = trim($_POST['employee_member']);
//            $where['nickname'] = trim($_POST['nickname']);
//            $where['grant_time'] =  $time = strtotime(date('Y-m',strtotime(trim($_POST['grant_time']))));
//            $where = array_filter($where);
//            foreach($where as $key =>$val){
//                if($key=='id'){
//                     $k = "T.$key";
//                 }elseif($key=='employee_member'){
//                     $k = "A.$key";
//                 }elseif($key=='nickname'){
//                     $k = "A.$key";
//                 }elseif($key=='grant_time'){
//                     $k = "s.$key";
//                }
//                $sql = "$k = '$val' and ";
//            }
//            $sql = substr($sql,0,-4);//去除最后一个 AND
//
//            $list = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->where($sql)->field('*,S.id as sid,T.id as tid')->limit("$page->firstRow","$page->listRows")->select();
//        }else{
//            $list = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->field('*,S.id as sid,T.id as tid')->limit("$page->firstRow","$page->listRows")->select();
//        }
//
////        echo M()->getLastSql();
////        print_r($list);die;
//        $this->assign('list',$list);
//        $this->assign('page',$pages);
        $this->display();
    }

    /**
     * salary_edtior 考勤详情 修改/编辑
     * id 考勤id
     */
    public function salary_edtior(){
//        if(IS_POST){
//            $info = $_POST['info'];
//            $where['id'] = $_POST['id'];
//            $data = array_filter($info);
//            $attend_r = M('salary_attendance')->where($where)->save($data);
////            echo M()->getLastSql();
//            if(!$attend_r){
//                $this->error('您的数据添加失败!请重新编辑！', U('Salary/salary_attendance'));die;
//            }else{
//                $this->success('编辑数据成功！', U('Salary/salary_attendance'));die;
//            }
//        }elseif(IS_GET){
//            $sid['salary_id'] = trim($_GET['sid']);//薪资id
//            $sid['id'] = trim($_GET['tid']);//考核id
//            $attend_r = M('salary_attendance')->where($sid)->find();
//            if(!$attend_r){
//                $this->error('您的数据有误!请重新选择！', U('Salary/salary_attendance'));die;
//            }
//        }
//        $this->assign('list',$attend_r);
        $this->display();
    }

}