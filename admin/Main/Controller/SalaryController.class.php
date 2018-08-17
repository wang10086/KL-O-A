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
     * @salary_attendance
     * 考勤列表
     */
    public function salary_attendance(){

        $count = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->field('*,S.id as sid')->count();
        $page = new Page($count,12);
        $pages = $page->show();
        if(IS_POST){
            $where['id'] = trim($_POST['id']);
            $where['employee_member'] = trim($_POST['employee_member']);
            $where['nickname'] = trim($_POST['nickname']);
            $where['grant_time'] =  $time = strtotime(date('Y-m',strtotime(trim($_POST['grant_time']))));
            $where = array_filter($where);
            foreach($where as $key =>$val){
                if($key=='id'){
                     $k = "T.$key";
                 }elseif($key=='employee_member'){
                     $k = "A.$key";
                 }elseif($key=='nickname'){
                     $k = "A.$key";
                 }elseif($key=='grant_time'){
                     $k = "s.$key";
                }
                $sql = "$k = '$val' and ";
            }
            $sql = substr($sql,0,-4);//去除最后一个 AND

            $list = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->where($sql)->field('*,S.id as sid,T.id as tid')->limit("$page->firstRow","$page->listRows")->select();
        }else{
            $list = M()->table('oa_salary_attendance as T')->join('oa_salary as S on T.salary_id=S.id')->join('oa_account as A on A.id=S.account_id')->field('*,S.id as sid,T.id as tid')->select();
        }
//        echo M()->getLastSql();
        $this->assign('list',$list);
        $this->assign('page',$pages);
        $this->display();
    }

    /**
     * salary_edtior 考勤详情 修改/编辑
     * id 考勤id
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
     * salary_query 查询数据
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
                $count = $this->salary_count(1);
                $page = new Page($count,12);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
            }else{
                $count = $this->salary_count(2);
                $page = new Page($count,12);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->select();
            }
            foreach($account_r as $key => $val){
                $aid['account_id'] = $account_r[$key]['aid'];
                $salary = M('salary')->where($aid)->find();
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
    private function salary_count($sum){
        if($sum==1){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->count();
        }
        if($sum==2){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->where($where)->count();
        }
        return $count;
    }

    /**
     * salary_add_attendance 考勤、操作记录
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
                $count = $this->salary_count(1);
                $page = new Page($count,8);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();
            }else{
                $count = $this->salary_count(2);
                $page = new Page($count,8);
                $pages = $page->show();
                $account_r = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->select();
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
     * salary_add 添加岗位工资 基效比例
     * $status 1 保存  2 编辑
     */
    public function salary_add(){
        if(IS_POST){
            $id['account_id'] = trim($_POST['account_id']);
            $add['type'] = trim($_POST['type']);
            $add['standard_salary'] = trim($_POST['standard_salary']);
            $add['basic_salary'] = trim($_POST['basic_salary']);
            $add['performance_salary'] = trim($_POST['performance_salary']);
//            $add['grant_time'] = trim(strtotime(date('Y-m',strtotime($_POST['grant_time']))));//数据从月份开始
            if(!is_numeric($id['account_id']) || !is_numeric($add['standard_salary']) || !is_numeric($add['basic_salary']) || !is_numeric($add['performance_salary'])){
                $sum = 0;
                $msg = "数据不能留空白或填写错误!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
            if(!empty($add['type']) && !is_numeric($add['type'])){
                $sum = 0;
                $msg = "数据错误!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
            $add = array_filter($add);
            $status = trim($_POST['status']);
            if(empty($id['account_id'])){
                $sum = 0;
                $msg = "您添加数据失败!请重新添加!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
            if($status==1){//保存
                $add['account_id'] = $id['account_id'];
                $salary_r = M('salary')->where($id)->find();
                if($salary_r){
                    $sum = 0;
                    $msg = "请不要重复添加数据!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
                $add['createtime'] = time();
                $salary_w = M('salary')->add($add);
                if($salary_w){
                    if($add['type'] ==1){
                        $info = salary_info(11,1);
                    }
                    if($add['type'] ==2){
                        $info = salary_info(11,6);
                    }
                    $sum  = 1;
                    $msg  = "恭喜你添加成功!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }else{
                    $sum = 0;
                    $msg = "您添加数据失败!请重新添加!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }
            if($status==2){//编辑
                $salary_x = M('salary')->where($id)->save($add);
                if($salary_x){
                    if($add['type'] ==1){
                        $info = salary_info(11,6);
                    }
                    if($add['type'] ==2){
                        $info = salary_info(11,7);
                    }
                    $sum  = 1;
                    $msg  = "恭喜您修改成功!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }else{
                    $sum = 0;
                    $msg = "修改数据失败!请重新修改!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
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

    /**
    * addPost
    * status  1 添加岗位薪酬  2 离职日期
    */
    public function addPost(){
        $status                         = code_number(trim($_POST['status']));//状态
        $aid['id']                      = code_number(trim($_POST['account_id']));//用户id
        if($status == 1){
            $account['departmentid']        = code_number(trim($_POST['department']));//部门
            $account['postid']              = code_number(trim($_POST['posts']));//岗位
            $salary['standard_salary']      = code_number(trim($_POST['salary']));//薪酬
            $salary['basic_salary']         = code_number(trim($_POST['basic1']));//基本薪酬比
            $salary['performance_salary']   = code_number(trim($_POST['basic2']));//岗位薪酬比
        }
        if($status == 2){
            $account['end_time'] = strtotime(trim($_POST['data']));
        }
        $query = M('account')->where($aid)->save($account);
        if(!$query){
            $sum  = 0;
            $msg  = "数据错误!请重新提交!";
            echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
        }else{
            if($status==2){
                $info = salary_info(11,9);
                $sum = 1;
                $msg = "恭喜您修改成功!";
                echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
            }
            $acountid['account_id'] = $aid['id'];
            $salary_x = M('salary')->where($acountid)->save($salary);
            if ($salary_x) {
                $info = salary_info(11, 8);
                $sum = 1;
                $msg = "恭喜您修改成功!";
                echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
            }else{
                $sum = 0;
                $msg = "修改数据失败!请重新修改!";
                echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
            }
        }
    }
}