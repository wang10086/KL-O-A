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

        $count = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->count();
        $page = new Page($count,12);
        $pages = $page->show();
        if($_POST['grant_time']){
            $this->error('时间查询暂时未开通!请使用其它查询！', U('Salary/salary_attendance'));die;
        }
        if(IS_POST){//搜索列表结果
            $where['A.id']                 = trim($_POST['id']);//用户id
            $where['A.employee_member']    = trim($_POST['employee_member']);//编码
            $where['A.nickname']           = trim($_POST['nickname']);//昵称
            $where['A.status'] = 0;
           //$where['grant_time']          = trim($_POST['grant_time']);
            $where = array_filter($where);
            $account_r = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->where($where)->field('A.id as aid,A.employee_member,A.nickname,B.late1,B.late2,B.leave_absence,B.sick_leave,B.absenteeism,B.withdrawing')->limit("$page->firstRow","$page->listRows")->order('B.id desc')->select();

        }else{//默认列表结果

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
     * salaryattendance 添加考勤录入
     * $account_r 查询工资标准
     * strip_tags 去掉php 和html 标签
     */
    public function salaryattendance(){

        if(IS_POST){
            $user['account_id']     = code_number(trim($_POST['account_id']));//用户id
            $add['late1']           = code_number(trim($_POST['late1']));//15分钟以内
            $add['late2']           = code_number(trim($_POST['late2']));//15~2小时以内
            $add['leave_absence']   = code_number(trim($_POST['leave_absence']));//事假
            $add['sick_leave']      = code_number(trim($_POST['sick_leave']));//病假
            $add['absenteeism']     = code_number(trim($_POST['absenteeism']));//矿工
            $add['lowest_wage']     = code_number(trim($_POST['money']));//北京最低工资标准
            $add['createtime']      = time();
            $withdrawing            = (float)code_number(trim($_POST['withdrawing']));//传过来的总价格
            $account_r = M('salary_attendance')->field('id,status')->where($user)->order('id desc')->find();
            $salary = M('salary')->field('id,standard_salary')->where($user)->order('id desc')->find();

            if($account_r && $salary){//$add['withdrawing']
                $add['withdrawing'] = floor(($add['late1']*10+$add['late2']*30+($salary['standard_salary']/21.75)*$add['leave_absence']+($add['lowest_wage']/21.75)*0.2+($salary['standard_salary']/21.75)*$add['absenteeism']*2)*100)/100;

                if($add['withdrawing'] !== $withdrawing){
//                    var_dump($add); var_dump($withdrawing);die;
                    $sum = 0;
                    $msg = "考勤数据添加失败!请重新添加!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
                if($account_r['status'] == 1){
                    $id['id'] = $account_r['id'];
                    $cot = "添加";
                    $account_w = M('salary_attendance')->where($id)->save($add);
                }
                if($account_r['status'] == 2){
                    $add['account_id'] = $user['account_id'];
                    $cot = "修改";
                    $account_w = M('salary_attendance')->add($add);
                }
                if(!$account_w){
                    $sum = 0;
                    $msg = "考勤添加失败!请重新添加!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }else{
                if($salary){
                    $add['withdrawing'] = floor(($add['late1']*10+$add['late2']*30+($salary['standard_salary']/21.75)*$add['leave_absence']+($add['lowest_wage']/21.75)*0.2+($salary['standard_salary']/21.75)*$add['absenteeism']*2)*100)/100;
                    $add['account_id'] = $user['account_id'];
                    $cot = "添加";
                    $account_w = M('salary_attendance')->add($add);
                }else{
                    $sum = 0;
                    $msg = "考勤数据添加失败!请先添加薪酬标准信息!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }
            if($account_w){
                $cont = $cot."考勤信息,扣款：".$add['withdrawing']." （元）" ;
                $info = salary_info(12,$cont);
                $sum = 1;
                $msg = "考勤数据添加成功!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
            $sum = 0;
            $msg = "考勤数据添加失败!";
            echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
        }
    }

    /**
     * salary_add_attendance 考勤数据录入搜索结果与操作记录
     * optype=12 考勤记录
     */
    public function salary_add_attendance(){
        if(IS_POST){
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
                $page = new Page($count,8);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
            }else{
                $count = $this->salary_count(2,$where);
                $page = new Page($count,8);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->select();
            }

            foreach($account_r as $key => $val){
                $aid['account_id'] = $account_r[$key]['aid'];
                $account_r[$key]['salary_attendance'] = M('salary_attendance')->where($aid)->order('id desc')->find();
                $account_r[$key]['salary'] = M('salary')->field('id as salary_id,standard_salary')->where($aid)->order('id desc')->find();
            }

            if(!$account_r || $account_r == ""){$this->error('请添加员工编码或者员工部门！', U('Rbac/index'));die;}
        }
        $sum = M('op_record')->where('optype=12')->count();//操作记录数量
        $pag = new Page($sum,12);
        $pagese = $pag->show();
        $record_r = M('op_record')->where('optype=12')->order('op_time desc')->limit("$pag->firstRow","$pag->listRows")->select();//操作记录
        $this->assign('pages',$pagese);//操作记录分页
        $this->assign('record',$record_r);//操作记录
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
        if(IS_POST){
//            print_r($_POST);die;
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
                $page = new Page($count,12);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
            }else{
                $count = $this->salary_count(2,$where);
                $page = new Page($count,12);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->select();
            }
            foreach($account_r as $key => $val){
                $aid['account_id'] = $account_r[$key]['aid'];
                $salary = M('salary')->where($aid)->order('id desc')->find();
                $account_r[$key]['account_id'] = $salary['account_id'];
                $account_r[$key]['standard_salary'] = $salary['standard_salary'];
                $account_r[$key]['basic_salary'] = $salary['basic_salary'];
                $account_r[$key]['performance_salary'] = $salary['performance_salary'];

            }
            if(!$account_r || $account_r==""){$this->error('请添加员工编码或者员工部门！', U('Rbac/index'));die;}
        }
        $sum = M('op_record')->where('optype=11')->count();//操作记录数量
        $pag = new Page($sum,12);
        $pagese = $pag->show();
        $record_r = M('op_record')->where('optype=11')->order('op_time desc')->limit("$pag->firstRow","$pag->listRows")->select();//操作记录
        $this->assign('pages',$pagese);//操作记录分页
        $this->assign('record',$record_r);//操作记录
        $this->assign('page',$pages);//数据分页
        $this->assign('list',$account_r);
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
     * salary_add 添加岗位工资 基效比例
     * $status 1 入职   2 转正 3 调岗 4 离职 5 调薪
     */
    public function salary_add(){
        if(IS_POST){
            $add['type']        = code_number(trim($_POST['type']));
            $add['account_id']  = code_number(trim($_POST['account_id']));
            if($add['type'] == 3){
                $aid['id'] = $add['account_id'];
                $account['departmentid']        = code_number(trim($_POST['department']));//部门
                $account['postid']              = code_number(trim($_POST['posts']));//岗位
                $query = M('account')->where($aid)->save($account);
                if(!$query){
                    $sum = 0;
                    $msg = "信息添加失败!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }
            if($add['type'] == 4){
                $salary['id']        = $add['account_id'];
                $account['end_time'] = strtotime(trim($_POST['data']));
                $account = array_filter($account);
                $query = M('account')->where($salary)->save($account);
                if($query){
                    $sum = 0;
                    $msg = "信息添加失败!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }else{
                    $cont = "添加离职信息, 离职日期: ".$_POST['data'];
                    $info = salary_info(11,$cont);
                    $sum  = 1;
                    $msg  = "恭喜你添加成功!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }
            $add['standard_salary']     = code_number(trim($_POST['standard_salary']));
            $add['basic_salary']        = code_number(trim($_POST['basic_salary']));
            $add['performance_salary']  = code_number(trim($_POST['performance_salary']));
            $add['createtime'] = time();
            $add = array_filter($add);

            $id['account_id'] = $add['account_id'];
            $salar_r = M('salary')->field('id,type,status')->where($id)->order('id desc')->find();
            if($salar_r){

                if(strlen($add['type'])!==1 || strlen($add['basic_salary'])!==1 || strlen($add['performance_salary'])!==1){
                    $sum = 0;
                    $msg = "数据有误!请查证后提交!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
                if($salar_r['status'] ==1){
                    $id['id']                   = $salar_r['id'];
                    $save['standard_salary']    = $add['standard_salary'];
                    $save['basic_salary']       = $add['basic_salary'];
                    $save['performance_salary'] = $add['performance_salary'];
                    $salary_w = M('salary')->where($id)->save($save);
                    $uecont = "修改";
                }
                if($salar_r['status'] ==2){
                    $salary_w = M('salary')->add($add);
                    $uecont = "添加";
                }
            }else{
                $salary_w = M('salary')->add($add);
                $uecont = "添加";
            }
            if($salary_w){
                if($add['type'] ==1){
                    $cot = "入职";
                }
                if($add['type'] ==2){
                    $cot = "转正";
                }
                if($add['type'] ==3){
                    $cot = "调岗";
                }
                if($add['type'] ==5){
                    $cot = "调薪";
                }
                $cont = $uecont.$cot."信息: 岗位薪酬=".$add['standard_salary'].";绩效比=".$add['basic_salary'].":".$add['performance_salary'];
                $info = salary_info(11,$cont);
                $sum  = 1;
                $msg  = "恭喜你".$uecont."成功!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }else{
                $sum = 0;
                $msg = "您".$uecont."数据失败!请重新".$uecont."!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
        }
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

}