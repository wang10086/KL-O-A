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
//         if(!$list){
//             $this->success('您的输入条件不存在！', U('Salary/salaryindex'));die;
//         }else{
//             foreach ($list as $key => $val){
//                 $list[$key]['_subsidy'] = $list[$key]['bonus']+$list[$key]['housing_subsidy']+$list[$key]['other_subsidie']+$list[$key]['subsidy'];//奖金+住房补贴+其他补贴+其他补助
//                 $insurance_id['id'] = $list[$key]['insurance_id'];
//                 $insurance = M('salary_insurance')->where($insurance_id)->find();
//                 //年终奖个税+年终奖个税+工会会费 + 五险一金 = 税费扣款
//                 $list[$key]['_taxation'] = $list[$key]['personal_income_tax']+$list[$key]['year_end_personal_income_tax']+$list[$key]['trade_union_fee']+$insurance['birth']+$insurance['injury']+$insurance['pension']+$insurance['medical_care']+$insurance['unemployment']+$insurance['accumulation_fund'];
//             }
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
//        $id = trim($_GET['id']);
//
//        if(is_numeric($id)){
//            $list = M()->table('oa_salary as S')->join('oa_salary_attendance as T on T.id=S.attendance_id')->join('oa_account as A on A.id=S.account_id')->join('oa_salary_department as D on D.id=A.departmentid')->join('oa_posts as P on A.postid=P.id')->field('*,S.id as sid')->where("s.id='$id'")->find();
////            echo M()->getLastSql(); print_r($list);die;
//        }else{
//            $this->success('您的数据有误!请重新选择！', U('Salary/salaryindex'));die;
//        }
//        $this->assign('row',$list);
        $this->display();
    }


    /**
     * @salary_attendance 考勤列表
     * grant_time  年月份搜索
     */
    public function salary_attendance(){

        if($_POST['grant_time']){//年月搜索
            $this->error('时间查询暂时未开通!请使用其它查询！', U('Salary/salary_attendance'));die;
        }
        if(IS_POST){//搜索列表结果
            $where['A.id']                 = trim($_POST['id']);//用户id
            $where['A.employee_member']    = trim($_POST['employee_member']);//编码
            $where['A.nickname']           = trim($_POST['nickname']);//昵称
            $where['A.status'] = 0;
           //$where['grant_time']          = trim($_POST['grant_time']);
            $where = array_filter($where);
            $count = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->where($where)->count();
            $page = new Page($count,12);
            $pages = $page->show();
            $account_r = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->where($where)->field('A.id as aid,A.employee_member,A.nickname,B.late1,B.late2,B.leave_absence,B.sick_leave,B.absenteeism,B.withdrawing')->limit("$page->firstRow","$page->listRows")->order('B.id desc')->select();

        }else{//默认列表结果
            $count = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->count();
            $page = new Page($count,12);
            $pages = $page->show();
            $account_r = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->field('A.id as aid,A.employee_member,A.nickname,B.late1,B.late2,B.leave_absence,B.sick_leave,B.absenteeism,B.withdrawing')->limit("$page->firstRow","$page->listRows")->order('B.id desc')->select();

        }
        $this->assign('list',$account_r);
        $this->assign('page',$pages);
        $this->display();
    }

    /**
     * salary_edtior 考勤详情 修改/编辑
     * salary_attendance 考勤
     */
    public function salary_edtior(){
        if(IS_POST){
            $info = trim($_POST['info']);
            $where['id'] = trim($_POST['id']);
            $data = array_filter($info);
            $attend_r = M('salary_attendance')->where($where)->save($data);
//            echo M()->getLastSql();
            if(!$attend_r){
                $this->error('您的数据编辑失败!请重新编辑！', U('Salary/salary_attendance'));die;
            }else{
                salary_info(12,7);//操作记录 编辑
                $this->success('编辑数据成功！', U('Salary/salary_attendance'));die;
            }
        }elseif(IS_GET){
            $sid['salary_id'] = trim($_GET['sid']);//薪资id
            $sid['id'] = trim($_GET['tid']);//考核id
            $attend_r = M('salary_attendance')->where($sid)->find();
            if(!$attend_r){
                $this->error('您的数据有误!请重新选择！', U('Salary/salary_attendance'));die;
            }
        }
        $this->assign('list',$attend_r);
        $this->display();
    }




    /**
     * salary_add_attendance 考勤数据录入搜索结果与操作记录
     * optype=12 考勤记录
     */
    public function salary_add_attendance(){
            $where['A.id'] = trim($_POST['id']);
            $where['A.employee_member'] = trim($_POST['employee_member']);
            $where['A.nickname'] = trim($_POST['nickname']);
            $where['D.department'] = trim($_POST['departmen']);
            $posts['post_name'] = trim($_POST['posts']);
            $all = $_POST['all'];
            if($posts['post_name'] !==""){
                $postid = M('posts')->where($posts)->find();
                $where['postid'] = $postid['id'];
            }
            $where = array_filter($where);

            if($all == '所有'){
                $count = $this->salary_count(1,$where);
                $page = new Page($count,16);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
            }else{
                $count = $this->salary_count(1,$where);
                $page = new Page($count,16);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();
            }
            foreach($account_r as $key => $val){
                $aid['account_id'] = $account_r[$key]['aid'];
                $account_r[$key]['salary_attendance'] = M('salary_attendance')->where($aid)->order('id desc')->find();
                $account_r[$key]['salary'] = M('salary')->field('id as salary_id,standard_salary')->where($aid)->order('id desc')->find();
            }
            if(!$account_r || $account_r == ""){$this->error('请添加员工编码或者员工部门！', U('Rbac/index'));die;}
        $this->assign('page',$pages);//数据分页
        $this->assign('list',$account_r);
        $this->display();
    }

    /**
     * salary_query 薪酬数据录入搜索结果 查询数据 操作记录
     * oa_post 岗位
     * department_name 部门
     */
    public function salary_query(){

            $type = trim(I('typeval'));
            $where['A.id']              = trim(I('id'));
            $where['A.employee_member'] = trim(I('employee_member'));
            $where['A.nickname']        = trim(I('nickname'));
            $where['D.department']      = trim(I('departmen'));
            $posts['post_name']         = trim(I('posts'));
            $all = trim(I('all'));
            if($posts['post_name'] !==""){
                $postid = M('posts')->where($posts)->find();
                $where['postid'] = $postid['id'];
            }
            $where = array_filter($where);
            if(count($where) !==0 || $all !==""){
                if($all == '所有'){
                    $count      = $this->salary_count(1,$where);
                    $page       = new Page($count,4);
                    $pages      = $page->show();
                    $account_r  = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
                }
                if(count($where) !==0){
                    $count      = $this->salary_count(2,$where);
                    $page       = new Page($count,4);
                    $pages      = $page->show();
                    $account_r  = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();
                }
                foreach($account_r as $key => $val){
                    $aid['account_id']                      = $account_r[$key]['aid'];
                    $salary = M('salary')->where($aid)->order('id desc')->find();
                    $account_r[$key]['account_id']          = $salary['account_id'];
                    $account_r[$key]['standard_salary']     = $salary['standard_salary'];
                    $account_r[$key]['basic_salary']        = $salary['basic_salary'];
                    $account_r[$key]['performance_salary']  = $salary['performance_salary'];
                    $salary_bonus = M('salary_bonus')->where($aid)->order('id desc')->field('id,bonus,extract,annual_bonus')->find();
                    $account_r[$key]['bonus_id']            = $salary_bonus['id'];
                    $account_r[$key]['extract']             = $salary_bonus['extract'];
                    $account_r[$key]['bonus']               = $salary_bonus['bonus'];
                    $account_r[$key]['annual_bonus']        = $salary_bonus['annual_bonus'];
                    $subsidy_r = M('salary_subsidy')->where($aid)->order('id desc')->find();
                    $account_r[$key]['subsidy']             = $subsidy_r['id'];
                    $account_r[$key]['housing_subsidy']     = $subsidy_r['housing_subsidy'];
                    $account_r[$key]['foreign_subsidies']   = $subsidy_r['foreign_subsidies'];
                    $account_r[$key]['computer_subsidy']    = $subsidy_r['computer_subsidy'];

                }

                if(!$account_r || $account_r==""){$this->error('请添加员工编码或者员工部门！', U('Salary/salary_query'));die;}
            }

            $status        = trim(I('status'));
            if($status==1){
                $_SESSION['page']   = $pages;
                $_SESSION['list']   = $account_r;
                $this->assign('page',$pages);//数据分页
                $this->assign('list',$account_r);//数据
            }else{
                $page  = $_SESSION['page'];
                $list  = $_SESSION['list'];
                $this->assign('page',$page);//数据分页
                $this->assign('list',$list);//数据
            }
            if($status==2){
                $_SESSION['page2']  = $pages;
                $_SESSION['rows']   = $account_r;
                $this->assign('page2',$pages);//数据分页
                $this->assign('rows',$account_r);//数据
            }else{
                $page2  = $_SESSION['page2'];
                $rows   = $_SESSION['rows'];
                $this->assign('page2',$page2);//数据分页
                $this->assign('rows',$rows);//数据
            }
        $this->assign('type',$type);//数据
        $this->assign('department',query_department());//部门
        $this->assign('posts',query_posts());//岗位
        $this->display();
    }


    /**
     *salary_count 查询数量
     */
    private function salary_count($sum,$where){
        if($sum==1){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->count();
        }
        if($sum==2){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->where($where)->count();
        }
        return $count;
    }



    /**
     * salary_add_department 添加部门
     */
    public function salary_add_department(){
        if(IS_POST){
            $where['department'] = trim($_POST['department']);//部门名称
            $add['letter'] = trim($_POST['letter']);//大写字母
            if(!preg_match('/^[A-Z]+$/', $add['letter'])){
                $this->error('请添加大写字母！', U('Salary/salary_add_department'));die;
            }
            $department_r = M('salary_department')->where($where)->find();
            $department_r1 = M('salary_department')->where($add)->find();
            if($department_r || $department_r1){
                $this->error('请不要重复添加部门或字母！', U('Salary/salary_add_department'));die;
            }
            $add['department'] = trim($_POST['department']);//部门名称
            $department = M('salary_department')->add($add);
            if($department){
                $this->success('添加部门成功！', U('Salary/salary_add_department'));die;
            }else{
                $this->error('添加部门失败！请重写添加！', U('Salary/salary_add_department'));die;
            }
        }
        $this->display();
    }

    /**
     * record_list 数据操作记录
     */
    public function salary_list(){
        $status = trim(I('status'));
        $sum = M('op_record')->where('optype='.$status)->count();//操作记录数量
        $page = I('page',1,'int');
        $limit = 8;
        $fan = 'salary_list';

        $record_r = M('op_record')->where('optype='.$status)->order('op_time desc')->limit(($page-1)*$limit,$limit)->select();//操作记录
        //$count,$page,$limit,$fan
        $page_str = $this->ajaxPageHtml($sum,$page,$limit,$fan);//数据总数 当前页面 显示条数 方法名

        $this->assign('pages',$page_str);//操作记录分页
        $this->assign('record',$record_r);//操作记录

        $this->display();
    }


}