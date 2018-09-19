<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class SalaryController extends BaseController {

    /**
     * @salaryindex 工资列表
     *
     */
     public function salaryindex(){
         if(IS_POST){
             $where['account_id']               = trim($_POST['id']);
             $member                            = trim($_POST['employee_member']);
             $name                              = trim($_POST['name']);
             $where['datetime']                 = trim($_POST['month']);
             $where                             = array_filter($where);
             if(!empty($member) || !empty($name)) {
                 $query['nickname']             = $name;
                 $query['employee_member']      = $member;
                 $query                         = array_filter($query);
                 $account                       = M('account')->where($query)->getField('id');
                 if ($account) {
                     if ($where['account_id'] !== "") {
                         if ($where['account_id'] !== $account) {
                             $this->error('您的数据有误!请重新选择！');die;
                         }
                     } else {
                         $where['account_id']   = $account;
                     }
                 }
             }
         }
         $where['status']                       = 1;//审核通过
         $count                                 = M('salary_wages_month')->where($where)->count();
         $page                                  = new Page($count,15);
         $pages                                 = $page->show();
         $info                                  = M('salary_wages_month')->where($where)->limit("$page->firstRow","$page->listRows")->order('datetime desc')->select();//工资生成数据
         foreach($info as $key =>$value){
             $info[$key]                        += M('account')->where(array('id'=>$value['account_id']))->find();//用户数据
         }
//print_r($info);die;
         $this->assign('info',$info);
         $this->assign('page',$pages);
         $this->display();
    }


    /**
     * @salarydetails员工详情页
     * 参数id 用户id  datetime年月
     * sql_query 调用自封装函数
     * sql_query参数（1查2增3删4修,查询字段,表名,条件,1倒叙2正常顺序,1查一条0所有）
     */
    public function salarydetails(){

        if(!is_numeric(trim($_GET['id'])) || !is_numeric(trim($_GET['datetime']))){
            $this->error('您的数据有误!请重新选择！');die;
        }

        $where['id']                    = trim($_GET['id']);//用户account_id
        $account_id['datetime']         = trim($_GET['datetime']);
        $account_id['account_id']       = $where['id'];//用户
        $account_id['status']           = 1;//审核通过
        $wages                          = $this->query_wages($where,$account_id);//所有详细信息
        foreach($wages as $key =>$val){//变为一维数组
            foreach($val as $ke =>$va){
                foreach($va as $k =>$v){
                    $user_info[$ke]= $v;
                }
            }
        }
        $user_info['list'] = $this->salary_kpi_month($where,$account_id['datetime']); //目标任务 完成 提成

        // kpi  pdca 品质检查
        $que['p.tab_user_id']           = $where['id'];//用户id
        $que['p.month']                 = $account_id['datetime'] ;//查询年月
        $user_info['score']             = $this->query_score($que);

        $user_info['calculation']       = $this->calculation($user_info);//计算岗位工资和考勤
//        $type                           = $wages[1]['type'];// 页面状态

//        print_r($user_info);die;
        $this->assign('info',$user_info);
//        $this->assign('type',$type);
        $this->display();
    }

    /**
     * salary_kpi_month 季度
     * kpi 目标任务 完成 提成
     */
    private function salary_kpi_month($where,$datetime){

        //kpi 目标任务 完成 提成
        $month                      = (int)substr($datetime,4);
        $year                       = (int)substr($datetime,0,4);
        $query['user_id']           = $where;
        if($month<10){
            $year                   = $year.'0';
        }
       if($month == 3 || $month == 6 || $month == 9 ||$month == 12){
           $count                   = 0;
           $sum                     = 0;
           $i                       = $month-3;
           for($i;$i<$month;$month--){
               $query['month']      = $year.$month;
               $kpi                 = M('kpi')->where($query)->find();

               if($kpi){
                   $lists           = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->find();
                   if($lists){
                       if($lists['automatic'] == 0){
//                           $this->error('KPI暂未锁定!请锁定后查看信息！');
                           return 0;
                       }

                   }else{
                       $this->error('您的数据有误!请重新选择！');die;
                   }
               }else{
                   return 0;
               }
               $count               += $lists['target'];//季度目标
               $sum                 += $lists['complete'];//季度完成
           }
           $number = $sum/$count;//项目季度百分比
           if($number <= 1){
              $Total                = $sum*0.05;//不超过100%
           }
          if(1<$number && $number <=1.5){
               $Total               = $sum*(($number-1)*0.2+0.05);//超过100% 不到150%
           }
           if(1.5 < $number){
               $Total               = $sum*(($number-1.5)*0.25+(1.5-1)*0.2+0.05);//超过150%
           }
           $content['target']       = $count;
           $content['complete']     = $sum;
           $content['total']        = ((int)($Total*100))/100;//保留两位小数
        }
        return $content;
    }

    /**
     * sql_query
     * $que['p.tab_user_id'] 用户id
     * $que['a.nickname'] 用户昵称
     *$que['p.month'] 查询年月
     */
    private function query_score($que){
        $lists 			                    = M()->table('__PDCA__ as p')->field('p.*,a.nickname')->join('__ACCOUNT__ as a on a.id = p.tab_user_id')->where($que)->select();
        foreach($lists as $k=>$v){

            $sum_total_score                = 0;

            $yu                             = $v['status'] !=5 ? 0 : $v['total_score']-100;

            //计算PDCA加减分
            $sum_total_score                += $yu;

            //品质检查加减分
            $sum_total_score                += $v['total_qa_score'];

            //整理品质检查加减分
            $lists[$k]['total_score_show']  = $v['status']!=5 ? '<font color="#ff9900">未完成评分</font>' : show_score($yu);

            //整理品质检查加减分
            $lists[$k]['show_qa_score']     =  show_score($v['total_qa_score']);

            //获取KPI数据
            $kpi                            = M('kpi')->where(array('month'=>$v['month'],'user_id'=>$v['tab_user_id']))->find();
            if($kpi && $kpi['month']>=201803){
                $kpiscore                   =  $kpi['score']-100;
            }else{
                $kpiscore                   =  0;
            }

            //KPI加减分
            $sum_total_score                += $kpiscore;

            //KPI
            $lists[$k]['total_kpi_score']   = show_score($kpiscore);

            //合计
            $lists[$k]['sum_total_score']   =  show_score($sum_total_score);

        }
        return $lists;

    }

    /**
     * calculation ['basic']基本工资
     * ['achievements']绩效
     * ['grant'] 应发工资
     */
    private function calculation ($user_info){
        $info['basic']          = $user_info['salary']['standard_salary']*$user_info['salary']['basic_salary']/10;//基本工资
        $info['achievements']   = $user_info['salary']['standard_salary']*$user_info['salary']['performance_salary']/10;//绩效
        $info['grant']          = $user_info['salary']['standard_salary']*$user_info['salary']['basic_salary']/10-$user_info['attendance']['withdrawing'];//应发工资
        return $info;

    }

    /**
     *query_wages 查询工资
     */
    private function query_wages($where,$account_id){
        $wages_month                    = sql_query(1,'*','oa_salary_wages_month',$account_id,1,1);//工资关联是否生成
        if($wages_month){//判断生成  判断是否有权限

            $account['id']              = $wages_month[0]['account_id'];
            $department['id']           = $wages_month[0]['department_id'];
            $posts['id']                = $wages_month[0]['posts_id'];
            $salary['id']               = $wages_month[0]['salary_id'];
            $attendance['id']           = $wages_month[0]['attendance_id'];
            $bonus['id']                = $wages_month[0]['bonus_id'];
            $income['income_token']     = $wages_month[0]['income_token'];
            $insurance['id']            = $wages_month[0]['insurance_id'];
            $subsidy['id']              = $wages_month[0]['subsidy_id'];
            $withholding['token']       = $wages_month[0]['withholding_token'];

            $user_info['month']         = $wages_month;
            $user_info['account']       = sql_query(1,'*','oa_account',$account,2,1);//查询用户表
            $user_info['department']    = sql_query(1,'*','oa_salary_department',$department,1,1);//查询部门
            $user_info['posts']         = sql_query(1,'*','oa_posts',$posts,1,1);//查询岗位

            $user_info['salary']        = sql_query(1,'*','oa_salary',$salary,1,1);//岗位薪酬
            $user_info['attendance']    = sql_query(1,'*','oa_salary_attendance',$attendance,1,1);//员工考核
            $user_info['bonus']         = sql_query(1,'*','oa_salary_bonus',$bonus,1,1);//提成/奖金/年终奖
            $user_info['income'][]      = sql_query(1,'*','oa_salary_income',$income,1,0);//其他收入
            $user_info['insurance']     = sql_query(1,'*','oa_salary_insurance',$insurance,1,1);//五险一金表
            $user_info['subsidy']       = sql_query(1,'*','oa_salary_subsidy',$subsidy,1,0);//补贴
            $user_info['withholding'][] = sql_query(1,'*','oa_salary_withholding',$withholding,1,0);//代扣代缴

//            $type['type']               = 2;//状态成功 前台判断

        }else{//可以加判断是否是当前用户
            $this->error('您的数据有误!请重新选择!');die;
//            unset($account_id['datetime']);
//            $user_info['account']       = sql_query(1,'*','oa_account',$where,2,1);//查询用户表
//            $department_r['id']         = $user_info['account'][0]['departmentid'];//部门
//            $user_info['department']    = sql_query(1,'*','oa_salary_department',$department_r,1,1);//查询部门
//            $posts_r['id']              = $user_info['account'][0]['postid'];
//            $user_info['posts']         = sql_query(1,'*','oa_posts',$posts_r,1,1);//查询岗位
//
//            $user_info['salary']        = sql_query(1,'*','oa_salary',$account_id,1,1);//岗位薪酬
//            $user_info['attendance']    = sql_query(1,'*','oa_salary_attendance',$account_id,1,1);//员工考核
//            $user_info['bonus']         = sql_query(1,'*','oa_salary_bonus',$account_id,1,1);//提成/奖金/年终奖
//            $user_info['income'][]      = sql_query(1,'*','oa_salary_income',$account_id,1,0);//其他收入
//            $user_info['insurance']     = sql_query(1,'*','oa_salary_insurance',$account_id,1,1);//五险一金表
//            $user_info['subsidy']       = sql_query(1,'*','oa_salary_subsidy',$account_id,1,0);//补贴
//            $user_info['withholding'][] = sql_query(1,'*','oa_salary_withholding',$account_id,1,0);//代扣代缴
//            $type['type']               = 1;//状态失败 前台判断
        }
        $content[0]                     = $user_info;

        return $content;
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
            $where['A.id']                  = trim($_POST['id']);//用户id
            $where['A.employee_member']     = trim($_POST['employee_member']);//编码
            $where['A.nickname']            = trim($_POST['nickname']);//昵称
            $where['A.status'] = 0;
           //$where['grant_time']           = trim($_POST['grant_time']);
            $where                          = array_filter($where);
            $count                          = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->where($where)->count();
            $page                           = new Page($count,12);
            $pages                          = $page->show();
            $account_r                      = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->where($where)->field('A.id as aid,A.employee_member,A.nickname,B.late1,B.late2,B.leave_absence,B.sick_leave,B.absenteeism,B.withdrawing')->limit("$page->firstRow","$page->listRows")->order('B.id desc')->select();

        }else{//默认列表结果
            $count                          = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->count();
            $page                           = new Page($count,12);
            $pages                          = $page->show();
            $account_r                      = M()->table('oa_account as A')->join('oa_salary_attendance as B on A.id=B.account_id')->field('A.id as aid,A.employee_member,A.nickname,B.late1,B.late2,B.leave_absence,B.sick_leave,B.absenteeism,B.withdrawing')->limit("$page->firstRow","$page->listRows")->order('B.id desc')->select();

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
            $info               = trim($_POST['info']);
            $where['id']        = trim($_POST['id']);
            $data               = array_filter($info);
            $attend_r           = M('salary_attendance')->where($where)->save($data);
//            echo M()->getLastSql();
            if(!$attend_r){
                $this->error('您的数据编辑失败!请重新编辑！', U('Salary/salary_attendance'));die;
            }else{
                salary_info(12,7);//操作记录 编辑
                $this->success('编辑数据成功！', U('Salary/salary_attendance'));die;
            }
        }elseif(IS_GET){
            $sid['salary_id']   = trim($_GET['sid']);//薪资id
            $sid['id']          = trim($_GET['tid']);//考核id
            $attend_r           = M('salary_attendance')->where($sid)->find();
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
            $where['A.id']                              = trim($_POST['id']);
            $where['A.employee_member']                 = trim($_POST['employee_member']);
            $where['A.nickname']                        = trim($_POST['nickname']);
            $where['D.department']                      = trim($_POST['departmen']);
            $posts['post_name']                         = trim($_POST['posts']);
            $all = $_POST['all'];
            if($posts['post_name'] !==""){
                $postid                                 = M('posts')->where($posts)->find();
                $where['postid']                        = $postid['id'];
            }
            $where                                      = array_filter($where);

            if($all == '所有'){

                $count                                  = $this->salary_count(1,$where);
                $page                                   = new Page($count,16);
                $pages                                  = $page->show();

                $account_r                              = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();

            }else{

                $count                                  = $this->salary_count(1,$where);
                $page                                   = new Page($count,16);
                $pages                                  = $page->show();

                $account_r                              = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();

            }

            foreach($account_r as $key => $val){
                $aid['account_id']                      = $account_r[$key]['aid'];
                $account_r[$key]['salary_attendance']   = M('salary_attendance')->where($aid)->order('id desc')->find();
                $account_r[$key]['salary']              = M('salary')->field('id as salary_id,standard_salary')->where($aid)->order('id desc')->find();
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
            $where['A.id']                                  = trim(I('id'));
            $where['A.employee_member']                     = trim(I('employee_member'));
            $where['A.nickname']                            = trim(I('nickname'));
            $where['D.department']                          = trim(I('departmen'));
            $posts['post_name']                             = trim(I('posts'));
            $all = trim(I('all'));

            if($posts['post_name'] !==""){

                $postid                                     = M('posts')->where($posts)->find();
                $where['postid']                            = $postid['id'];
            }
            $where = array_filter($where);

            if(count($where) !== 0 || $all !== ""){

                if($all == '所有'){
                    $count                                  = $this->salary_count(1,$where);
                    $page                                   = new Page($count,4);
                    $pages                                  = $page->show();

                    $account_r                              = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->limit("$page->firstRow","$page->listRows")->select();

                }
                if(count($where) !== 0){

                    $count                                  = $this->salary_count(2,$where);
                    $page                                   = new Page($count,4);
                    $pages                                  = $page->show();

                    $account_r                              = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();

                }
                foreach($account_r as $key => $val){

                    $aid['account_id']                      = $account_r[$key]['aid'];

                    $salary = M('salary')->where($aid)->order('id desc')->find();//岗位薪资

                    $account_r[$key]['account_id']          = $salary['account_id'];
                    $account_r[$key]['standard_salary']     = $salary['standard_salary'];
                    $account_r[$key]['basic_salary']        = $salary['basic_salary'];
                    $account_r[$key]['performance_salary']  = $salary['performance_salary'];

                    $salary_bonus   = M('salary_bonus')->where($aid)->order('id desc')->find();//提成/奖金

                    $account_r[$key]['bonus_id']            = $salary_bonus['id'];
                    $account_r[$key]['extract']             = $salary_bonus['extract'];
                    $account_r[$key]['bonus']               = $salary_bonus['bonus'];
                    $account_r[$key]['annual_bonus']        = $salary_bonus['annual_bonus'];

                    $subsidy_r      = M('salary_subsidy')->where($aid)->order('id desc')->find();//补贴

                    $account_r[$key]['subsidy']             = $subsidy_r['id'];
                    $account_r[$key]['housing_subsidy']     = $subsidy_r['housing_subsidy'];
                    $account_r[$key]['foreign_subsidies']   = $subsidy_r['foreign_subsidies'];
                    $account_r[$key]['computer_subsidy']    = $subsidy_r['computer_subsidy'];

                    $account_r[$key]['insurance']           = M('salary_insurance')->where($aid)->order('id desc')->find();//五险一金

                    $income                                 = M('salary_income')->where($aid)->order('id desc')->find();//其他收入

                    if($income){

                        $wher['income_token']               = $income['income_token'];
                        $account_r[$key]['income']          = M('salary_income')->where($wher)->order('id desc')->select();//其他收入

                    }

                    $withholding                            = M('salary_withholding')->where($aid)->order('id desc')->find();//代扣代缴
                    if($withholding){

                        $query['token']                     = $withholding['token'];
                        $account_r[$key]['withholding']     = M('salary_withholding')->where($query)->order('id desc')->select();//代扣代缴
                    }
                }
                if(!$account_r || $account_r==""){$this->error('请添加员工编码或者员工部门！', U('Salary/salary_query'));die;}
            }
            $status                                         = trim(I('status'));
            if($status == 1){
                $this->assign('page',$pages);//数据分页
                $this->assign('list',$account_r);//数据
            }
            if($status == 2){
                $this->assign('page2',$pages);//数据分页
                $this->assign('rows',$account_r);//数据
            }
            if($status == 3){
                $this->assign('page3',$pages);//数据分页
                $this->assign('insurance',$account_r);//数据
            }
            if($status == 4){
                $this->assign('withholding',$account_r);//数据
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
        if($sum == 1){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->count();
        }
        if($sum == 2){
            $count = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->where($where)->count();
        }
        return $count;
    }



    /**
     * salary_add_department 添加部门
     */
    public function salary_add_department(){
        if(IS_POST){
            $where['department']    = trim($_POST['department']);//部门名称
            $add['letter']          = trim($_POST['letter']);//大写字母
            if(!preg_match('/^[A-Z]+$/', $add['letter'])){

                $this->error('请添加大写字母！', U('Salary/salary_add_department'));die;

            }

            $department_r           = M('salary_department')->where($where)->find();
            $department_r1          = M('salary_department')->where($add)->find();

            if($department_r || $department_r1){

                $this->error('请不要重复添加部门或字母！', U('Salary/salary_add_department'));die;

            }
            $add['department']      = trim($_POST['department']);//部门名称
            $department             = M('salary_department')->add($add);

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
        $status     = trim(I('status'));
        $sum        = M('op_record')->where('optype='.$status)->count();//操作记录数量
        $page       = I('page',1,'int');
        $limit      = 8;
        $fan        = 'salary_list';

        $record_r   = M('op_record')->where('optype='.$status)->order('op_time desc')->limit(($page-1)*$limit,$limit)->select();//操作记录
        $page_str   = $this->ajaxPageHtml($sum,$page,$limit,$fan);//数据总数 当前页面 显示条数 方法名

        $this->assign('pages',$page_str);//操作记录分页
        $this->assign('record',$record_r);//操作记录

        $this->display();
    }

    /**
     * @salary_excel_list 生成工资表
     */
    public function salary_excel_list(){

            $archives    = trim($_GET['archives']);
        if(!empty($archives)){
            if(!is_numeric($archives)){

                $this->error('您的数据有误！请重新选择！');die;
            }
            $info       = $this->salary_excel_sql($archives);//员工信息
        }else{//没有传送至

            $info       = $this->salary_excel_sql();//员工信息
        }

//        print_r($info);die;
        $this->assign('info',$info);//操作记录
        $this->assign('type',$archives);//操作记录
        $this->display();
    }

    /**
     * @salary_excel_sql
     */
    private function salary_excel_sql($archives){
        $where['status']                    = 0;
        $where['archives']                  = $archives;
        $where = array_filter($where);
        $info                               =  M('account')->where($where)->order('employee_member ASC')->select();//个人数据
       foreach($info as $k => $v){//去除编码空的数据
           if($v['employee_member']==""){
                unset($info[$k]);
           }
       }
        foreach($info as $key =>$val) {//薪资详情
            $user_info[$key]['account']     = $val;
            $id['account_id']               = $val['id'];
            $department['id']               = $val['departmentid'];//部门
            $user_info[$key]['department']  = sql_query(1,'*','oa_salary_department',$department,1,1);//查询部门
            $posts['id']                    = $val['postid'];
            $user_info[$key]['posts']       = sql_query(1,'*','oa_posts',$posts,1,1);//查询岗位

            $user_info[$key]['salary']      = sql_query(1, '*', 'oa_salary',$id, 1, 1);//岗位薪酬
            $user_info[$key]['attendance']  = sql_query(1, '*', 'oa_salary_attendance',$id, 1, 1);//员工考核
            $user_info[$key]['bonus']       = sql_query(1, '*', 'oa_salary_bonus',$id, 1, 1);//提成/奖金/年终奖
            $income                         = sql_query(1, '*', 'oa_salary_income',$id, 1, 1);//其他收入

            if ($income) {
                $token['income_token']      = $income['income_token'];
                $token['account_id']        = $val['id'];
                $token = array_filter($token);
                $user_info[$key]['income'] = sql_query(1, '*', 'oa_salary_income', $token, 1, 0);//其他收入所有项目
                $countmoney=0;
                foreach($user_info[$key]['income'] as $ke =>$va){
                    $countmoney += $va['income_money'];

                }
                $user_info[$key]['Other'] = $countmoney;//其他补款
            }
            $user_info[$key]['insurance'] = sql_query(1, '*', 'oa_salary_insurance', $id, 1, 1);//五险一金表

            $user_info[$key]['insurance_Total'] = $user_info[$key]['insurance'][0]['medical_care_base']*$user_info[$key]['insurance'][0]['medical_care_ratio']+$user_info[$key]['insurance'][0]['pension_base']*$user_info[$key]['insurance'][0]['pension_ratio']+$user_info[$key]['insurance'][0]['unemployment_base']*$user_info[$key]['insurance'][0]['unemployment_ratio']+$user_info[$key]['insurance'][0]['accumulation_fund_base']*$user_info[$key]['insurance'][0]['accumulation_fund_ratio'];//五险一金
//            print_r($user_info[166]);die;
            $user_info[$key]['subsidy'] = sql_query(1, '*', 'oa_salary_subsidy', $id, 1, 1);//补贴
            $withholding = sql_query(1, '*', 'oa_salary_withholding', $id, 1, 1);//代扣代缴
            if ($withholding) {
                $wit['token'] = $withholding['token'];
                $wit['account_id'] = $val['id'];
                $wit = array_filter($wit);
                $user_info[$key]['withholding'] = sql_query(1, '*', 'oa_salary_withholding', $wit, 1, 0);//代扣代缴
            }
            // kpi  pdca 品质检查
            $que['p.tab_user_id']           = $val['id'];//用户id
            $time_Y = date('Y');
            $time_M = date('m');
            $time_D = date('d');
            if($time_D < 10){
                $time_M = $time_M-1;
            }
//            $que['p.month']                 = $time_Y.$time_M ;//查询年月
            $que['p.month']='201806';
            $user            = $this->query_score($que);//绩效增减
            $use1 = str_replace(array('<span class="red">','<span>','<span class="green">','</span>'),"",$user[0]['total_score_show']);//PDCA
            $use2 = str_replace(array('<span class="red">','<span>','<span class="green">','</span>'),"",$user[0]['show_qa_score']);//品质检查
            $use3 = str_replace(array('<span class="red">','<span>','<span class="green">','</span>'),"",$user[0]['sum_total_score']);//KPI
            $money = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['performance_salary']/100;//绩效金额
            $branch =100;//给总共100分
            if(substr($use1,0,1)=='-' && is_numeric(substr($use1,1))){
                $user_info[$key]['Achievements']['total_score_show'] = $use1;//pdca分数
                $branch = $branch-substr($use1,1);
            }
            if(substr($use2,0,1)=='-' && is_numeric(substr($use2,1))){
                $user_info[$key]['Achievements']['show_qa_score'] = $use2;//品质检查分数
                $branch = $branch-substr($use2,1);
            }
            if(substr($use3,0,1)=='-' && is_numeric(substr($use3,1))){
                $user_info[$key]['Achievements']['sum_total_score'] = $use3;//KPI分数
                $branch = $branch-substr($use3,1);
            }
            if(substr($use1,0,1)=='+' && is_numeric(substr($use1,1))){
                $user_info[$key]['Achievements']['total_score_show'] = $use1;//pdca分数
                $branch = $branch-substr($use1,1);
            }
            if(substr($use2,0,1)=='+' && is_numeric(substr($use2,1))){
                $user_info[$key]['Achievements']['show_qa_score'] = $use2;//品质检查分数
                $branch = $branch-substr($use2,1);
            }
            if(substr($use3,0,1)=='+' && is_numeric(substr($use3,1))){
                $user_info[$key]['Achievements']['sum_total_score'] = $use3;//KPI分数
                $branch = $branch-substr($use3,1);
            }
            if($branch>100){//判断加减金额
               $achievements = '+'.(($branch-100)*$money);
            }
            if($branch<100){//判断加减金额
                $achievements = '-'.((100-$branch)*$money);
            }
            if($achievements=='-0' || $achievements=='+0'){
                $achievements=0;
            }
            $user_info[$key]['Achievements']['count_money'] = $achievements;//绩效增减金额

            $user_info[$key]['Extract'] = $this->salary_kpi_month($val['id'],$que['p.month']); //目标任务 完成 提成

            $user_info[$key]['tax_counting'] = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['performance_salary']+($user_info[$key]['Achievements']['count_money'])-$user_info[$key]['insurance_Total'];//计税工资

            //个人所得税
            if($user_info[$key]['tax_counting'] <= 5000){
                $counting            = '0';
            }else{
                $cout               = $user_info[$key]['tax_counting']-5000;

                if($cout <= 3000){
                    $counting        = $cout*0.03;
                }
                if($cout > 3000 && $cout <= 12000){
                    $counting        = $cout*0.10-210;
                }
                if($cout > 12000 && $cout <= 25000){
                    $counting        = $cout*0.20-1410;
                }
                if($cout > 25000 && $cout <= 35000){
                    $counting        = $cout*0.25-2660;
                }
                if($cout > 35000 && $cout <= 55000){
                    $counting        = $cout*0.30-4410;
                }
                if($cout > 55000 && $cout <= 80000){
                    $counting        = $cout*0.35-7160;
                }
                if($cout > 80000){
                    $counting        = $cout*0.45-15160;
                }
                $counting = ((int)($counting*100))/100;
            }
            $user_info[$key]['personal_tax'] = $counting;//个人所得税
            $user_info[$key]['Labour'] = ($user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['basic_salary']-500)*0.01;//工会会费
            $summoney=0;
            foreach($user_info[$key]['withholding'] as $key =>$val){
                $summoney += (int)$val['money'];

            }
            $user_info[$key]['summoney'] = $summoney;//代扣代缴总费用
//            var Tax_counting = '个人所得税 : '+(Math.floor(counting*100))/100+' (元)';
//            if($archives==100){print_r($user_info);die;}

        }
//        print_r($user_info[166]);die;
        return $user_info;
    }

}