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

        $userid['status'] = 4;
        $userid['account_id']                  = trim($_POST['id']);
        $userid['department']                  = trim($_POST['employee_member']);
        $userid['user_name']                   = trim($_POST['name']);
        $userid['datetime']                    = trim($_POST['month']);
        $userid                                = array_filter($userid);
        $user_id                               = (int)$_SESSION['userid'];

        if($user_id==11 ||$user_id==55 || $user_id==77 || $user_id==32 || $user_id==38 || $user_id==12  || $user_id==1 || $user_id==185){
        }else{
            $userid['account_id']              = $user_id;
        }
        $count                                 = M('salary_wages_month')->where($userid)->count();
        $page                                  = new Page($count,15);
        $pages                                 = $page->show();
        $info                                  = M('salary_wages_month')->where($userid)->limit("$page->firstRow","$page->listRows")->order('datetime desc')->select();//工资生成数据

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
        if(!is_numeric(trim($_GET['id'])) && !is_numeric(trim($_GET['datetime']))){
            $this->error('您查找的数据有误!请重新选择！');die;
        }
        $id['id']                               = trim($_GET['id']);
        $id['datetime']                         = trim($_GET['datetime']);
        $user_info1                             = M('salary_wages_month')->where($id)->find();//工资表
        if(!$user_info1){
            $this->error('您查找的数据有误!请重新选择！');die;
        }
        $user_info['wages_month']               = $user_info1;
        $uid                                    = (int)$user_info1['account_id'];
        $userid = (int)$_SESSION['userid'];

        if($userid==1 || $userid===55|| $userid===77 || $userid===11 || $userid==38 || $userid==12 || $userid==32 || $userid==185){

        }else{
            if($uid!==$userid){
                $this->error('您只能选择自己的数据查看！');die;
            }
        }
        $user_info['account']                   = user_table($user_info1['account_id']);//用户表
        $user_info['attendance']                = M('salary_attendance')->where(array('id='.$user_info1['attendance_id']))->find();//员工考核表
        $user_info['bonus']                     = M('salary_bonus')->where(array('id='.$user_info1['bonus_id']))->find();//提成/奖金
        $que['p.tab_user_id']                   = $uid;
        $que['p.month']                         = $id['datetime'];
        $user_info['fen']                       = $this->query_score($que); //绩效增减
        $position_id['id']                      = $user_info['account']['position_id'];
        $position                               = sql_query(1,'*','oa_position',$position_id,1,1);//职位
        $strstr                                 = $position[0]['position_name'];
        $user_info['kpi']                       = $this->salary_kpi_month($uid,$que['p.month'],2); //业务人员 目标任务 完成 提成

        $user_info['income']                    = M('salary_income')->where(array('income_token='.$user_info1['income_token']))->select();//其他收入
        $user_info['insurance']                 = M('salary_insurance')->where(array('id='.$user_info1['insurance_id']))->find();//五险一金表
        $user_info['subsidy']                   = M('salary_subsidy')->where(array('id='.$user_info1['subsidy_id']))->find();//补贴
        $user_info['withholding']               = M('salary_withholding')->where(array('token='.$user_info1['withholding_token']))->select();//代扣代缴

        $this->assign('info',$user_info);
        $this->display();
    }



    /**
     * salary_kpi_month 季度
     * kpi 目标任务 完成 提成
     */

    private function salary_kpi_month($where,$datetime,$type){
        //kpi 目标任务 完成 提成
        $month                                  = (int)substr($datetime,4);
        $year                                   = (int)substr($datetime,0,4);
        $count                                  = 0;
        $sum1                                   = 0;
        $sum2                                   = 0;
        $query['user_id']                       = $where;
        if($month<10){
            $year                               = $year.'0';
        }
        if($type==2) {
            $query['month'] = $year . $month;
            if ($month == 3 || $month == 6 || $month == 9 || $month == 12) {
                $i = $month - 3;
                for ($i; $i < $month; $month--) {
                    $query['month'] = $year . $month;
                    $kpi = M('kpi')->where($query)->find();
                    $lists = M('kpi_more')->where(array('kpi_id' => $kpi['id']))->find();
                    //季度完成
                    $user = M('account')->where('id=' . $query['user_id'])->find();
                    $yearmonth    = GetGuideMonth($query['month']);
                    $mont1 = $yearmonth['firstday'];//开始月日
                    $mont2 = $yearmonth['lastday'];//结束月日

                    $support = M('salary_support')->where('account_id=' . $query['user_id'])->find();//扶植人员
                    if ($support) {//查询是否是扶植人员
                        //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                        if ($support['starttime'] > strtotime($mont1) && $support['endtime'] < strtotime($mont2)) {
                            $mont3 = date('Ymd', $support['starttime']);
                            $mont4 = date('Ymd', $support['endtime']);
                            $sum1 += monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                        } elseif ($support['starttime'] > strtotime($mont1) && $support['endtime'] > strtotime($mont2) && $support['starttime'] < strtotime($mont2)) {
                            //扶植起日期 > 季度起日期   扶植止日期 > 季度止日期 扶植起日期<季度止日期
                            $mont3 = date('Ymd', $support['starttime']);
                            $mont4 = $mont2;
                            $sum1 += monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                        } elseif (($support['starttime'] < strtotime($mont1) && $support['endtime'] > strtotime($mont2))) {
                            //扶植起日期 < 季度起日期   扶植止日期 > 季度止日期
                            $mont3 = $mont1;
                            $mont4 = $mont2;
                            $sum1 += monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                        } elseif (($support['starttime'] < strtotime($mont1) && $support['endtime'] < strtotime($mont2))) {
                            //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                            $mont3 = $mont1;
                            $mont4 = $support['endtime'];
                        } else {
                            $mont3 = 0;
                            $mont4 = 0;
                        }
                    }
                    $sum_user = monthly_Finance($user['nickname'], $mont1, $mont2);//季度完成
                    $count += $lists['target'];//季度目标
                    $sum2 += $sum_user;//季度完成
                }
                $price = $sum1 * 0.25;//扶植期提成
                $sum = $sum2 - $sum1;//季度完成-扶植人员日期完成
                $number = $sum / $count;//项目季度百分比
                if ($number <= 1) {
                    $Total1 = $sum * 0.05;//不超过100%
                }
                if (1 < $number && $number <= 1.5) {
                    $Total1 = $count * 0.05 + ($sum - $count) * 0.2;//超过100% 不到150%
                }
                if (1.5 < $number) {
                    $tot = $count * 0.05;//100%以内
                    $tt = ($count * 1.5 - $count) * 0.2;//100%以上 150% 以内
                    $yy = ($sum - $count * 1.5) * 0.25;//150% 以上
                    $Total1 = $tot + $tt + $yy;

                }
                $Total = $Total1 + $price;//提成+扶植期提成
                $content['target'] = $count;
                $content['complete'] = $sum;
                $content['total'] = round($Total, 2);//保留两位小数
            } else {//月度提成

                $query['month'] = $year . $month;
                $kpi = M('kpi')->where($query)->find();
                $lists = M('kpi_more')->where(array('kpi_id' => $kpi['id']))->find();

                //季度完成
                $user = M('account')->where('id=' . $query['user_id'])->find();

                $yresmonth = GetGuideMonth($query['month']);
                $mont1 = $yresmonth['firstday'];//开始月日
                $mont2 = $yresmonth['lastday'];//结束月日日

                $support = M('salary_support')->where('account_id=' . $query['user_id'])->find();//扶植人员

                if ($support) {//查询是否是扶植人员
                    //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                    if ($support['starttime'] > strtotime($mont1) && $support['endtime'] < strtotime($mont2)) {
                        $mont3 = date('Ymd', $support['starttime']);
                        $mont4 = date('Ymd', $support['endtime']);
                        $sum1 = monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                    } elseif ($support['starttime'] > strtotime($mont1) && $support['endtime'] > strtotime($mont2) && $support['starttime'] < strtotime($mont2)) {
                        //扶植起日期 > 季度起日期   扶植止日期 > 季度止日期 扶植起日期<季度止日期
                        $mont3 = date('Ymd', $support['starttime']);
                        $mont4 = $mont2;
                        $sum1 = monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                    } elseif (($support['starttime'] < strtotime($mont1) && $support['endtime'] > strtotime($mont2))) {
                        //扶植起日期 < 季度起日期   扶植止日期 > 季度止日期
                        $mont3 = $mont1;
                        $mont4 = $mont2;
                        $sum1 = monthly_Finance($user['nickname'], $mont3, $mont4);//季度完成
                    } elseif (($support['starttime'] < strtotime($mont1) && $support['endtime'] < strtotime($mont2))) {
                        //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                        $mont3 = $mont1;
                        $mont4 = $support['endtime'];
                    } else{
                        $mont3 = 0;
                        $mont4 = 0;
                    }
                }
                    $sum_user = monthly_Finance($user['nickname'],$mont1,$mont2);//季度完成

                    $count = $lists['target'];//季度目标
                    $sum2 = $sum_user;//季度完成
                    $price = $sum1 * 0.25;//扶植期提成
                    $sum = $sum2 - $sum1;//季度完成-扶植人员日期完成
                    $number = $sum / $count;//项目季度百分比
                    if ($number <= 1) {
                        $Total1 = $sum * 0.05;//不超过100%
                    }
                    if (1 < $number && $number <= 1.5) {
                        $Total1 = $count * 0.05 + ($sum - $count) * 0.2;//超过100% 不到150%
                    }
                    if (1.5 < $number) {
                        $tot = $count * 0.05;//100%以内
                        $tt = ($count * 1.5 - $count) * 0.2;//100%以上 150% 以内
                        $yy = ($sum - $count * 1.5) * 0.25;//150% 以上
                        $Total1 = $tot + $tt + $yy;
                    }
                    $Total = $Total1 + $price;//提成+扶植期提成
                    $content['target'] = $count;
                    $content['complete'] = $sum;
                    $content['total'] = $Total;//保留两位小数
            }
            return $content;
        }
        if($month == 3 || $month == 6 || $month == 9 || $month == 12){
            $i                                  = $month-3;
            for($i;$i<$month;$month--){
                $query['month']                 = $year.$month;
                $kpi                            = M('kpi')->where($query)->find();
                $lists                          = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->find();
                //季度完成
                $user                           = M('account')->where('id='.$query['user_id'])->find();
                $yearmonth    = GetGuideMonth($query['month']);
                $mont1 = $yearmonth['firstday'];//开始月日
                $mont2 = $yearmonth['lastday'];//结束月日
                $support                        = M('salary_support')->where('account_id='.$query['user_id'])->find();//扶植人员
                if($support){//查询是否是扶植人员

                    //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                    if($support['starttime']>strtotime($mont1) && $support['endtime']<strtotime($mont2)){
                        $mont3                  = date('Ymd',$support['starttime']);
                        $mont4                  = date('Ymd',$support['endtime']);
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif($support['starttime']>strtotime($mont1) && $support['endtime']>strtotime($mont2) && $support['starttime']<strtotime($mont2)){
                        //扶植起日期 > 季度起日期   扶植止日期 > 季度止日期 扶植起日期<季度止日期
                        $mont3                  = date('Ymd',$support['starttime']);
                        $mont4                  = $mont2;
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']>strtotime($mont2))){
                        //扶植起日期 < 季度起日期   扶植止日期 > 季度止日期
                        $mont3                  = $mont1;
                        $mont4                  = $mont2;
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }elseif(($support['starttime']<strtotime($mont1) && $support['endtime']<strtotime($mont2))){
                        //扶植起日期 > 季度起日期   扶植止日期 < 季度止日期
                        $mont3                  = $mont1;
                        $mont4                  = $support['endtime'];
                        $sum1                   += monthly_Finance($user['nickname'],$mont3,$mont4);//季度完成
                    }else{
                        //1、扶植起日期<季度止日期  扶植止日期<季度起日期 2、扶植起日期<季度止日期 扶植止日期<季度起日期 3、扶植起日期>季度止日期 扶植止日期>季度起日期 4、扶植起日期>季度止日期 扶植止日期<季度起日期
                        $mont3                  = 0;
                        $mont4                  = 0;
                    }
                }
                $sum2                           += monthly_Finance($user['nickname'],$mont1,$mont2);//季度完成
                $count                          += $lists['target'];//季度目标
            }
            $price                              = $sum1*0.25;//扶植期提成
            $sum                                = $sum2-$sum1;//季度完成-扶植人员日期完成
            $number                             = $sum/$count;//项目季度百分比
            if($number <= 1){
                $Total1                          = $sum*0.05;//不超过100%
            }
            if(1<$number && $number <=1.5){
                $Total1                         = $count*0.05+($sum-$count)*0.2;//超过100% 不到150%
            }
            if(1.5 < $number){
                $tot                            = $count*0.05;//100%以内
                $tt                             = ($count*1.5-$count)*0.2;//100%以上 150% 以内
                $yy                             = ($sum-$count*1.5)*0.25;//150% 以上
                $Total1                         = round($tot+$tt+$yy,2);
            }
            $Total                              = $Total1+$price;//提成+扶植期提成
            $content['target']                  = $count;
            $content['complete']                = $sum;
            $content['total']                   = round($Total,2);//保留两位小数
        }else{
            $content['target']                  = '0.00';//季度目标
            $content['complete']                = '0.00';//季度完成
            $content['total']                   = '0.00';//保留两位小数
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
     * @salary_attendance 考勤列表
     * grant_time  年月份搜索
     */
    public function salary_attendance(){
        $userid = (int)$_SESSION['userid'];

        if($userid==11 ||$userid==55 || $userid==77 || $userid==32 || $userid==38 || $userid==12  || $userid==1 || $userid==185){

            $where['account_id']           = (int)(trim($_POST['id']));//编码
        }else{
            $uid                           = (int)(trim($_POST['id']));//编码
            if($uid!==$userid){
                $this->error('您只能查看自己的工资！');die;
            }
            $where['account_id']           = $userid;
        }

        $where['user_name']                = trim($_POST['nickname']);//昵称
        if(!empty($_POST['grant_time'])){
            $where['datetime']             = date('Ym',strtotime($_POST['grant_time']));//时间
        }
        $where['status']                   = 4;//状态
        $where                             = array_filter($where);
        $count                             = M('salary_wages_month')->where($where)->count();

        $page                              = new Page($count,12);
        $pages                             = $page->show();
        $accou                             = M('salary_wages_month')->where($where)->limit("$page->firstRow","$page->listRows")->select();

        foreach($accou as $key => $val) {
            $account['id']                 = $val['attendance_id'];
            $account_r[$key]['attendance'] = M('salary_attendance')->where($account)->find();
            $account_r[$key]['datetime']   = $val['datetime'];
            $account_r[$key]['nickname']   = $val['user_name'];
            $account_r[$key]['aid']        = $val['account_id'];
            $acc['id']                     = $val['account_id'];
            $oa_account                    = user_table($val['account_id']);
            $cor['account_id']             = $val['account_id'];
            $account_r[$key]['member']     = $oa_account['employee_member'];
            $yea                           = M('salary_attendance')->where($cor)->field('year_leave')->select();
            foreach($yea as $k => $v){
                $account_r[$key]['year']  += $v['year_leave'];
            }
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
            if(!$attend_r){
                $this->error('您的数据编辑失败!请重新编辑！', U('Salary/salary_attendance'));die;
            }else{
                $sum = salary_info(12,7);//操作记录 编辑
                if($sum==0 || $sum=='0'){
                    $this->error('您的数据编辑失败!请重新编辑！', U('Salary/salary_attendance'));die;
                }
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
        $where['A.status']                          = array('between','0,1');

        $count                                      = $this->salary_count(1,$where);
        $page                                       = new Page($count,16);
        $pages                                      = $page->show();
        $account_r                                  = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.departmentid,A.employee_member,A.nickname,A.entry_time,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();

        foreach($account_r as $key => $val){
            $aid['account_id']                      = $account_r[$key]['aid'];
            $account_r[$key]['salary_attendance']   = M('salary_attendance')->where($aid)->order('id desc')->find();
            $account_r[$key]['salary']              = M('salary')->where($aid)->order('id desc')->find();
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
        $type                                           = trim(I('typeval'));
        $where['A.id']                                  = trim(I('id'));
        $where['A.employee_member']                     = trim(I('employee_member'));
        $where['A.nickname']                            = trim(I('nickname'));
        $where['D.department']                          = trim(I('departmen'));
        $posts['post_name']                             = trim(I('posts'));
        $all                                            = trim(I('all'));
        if($posts['post_name'] !==""){
            $postid                                     = M('posts')->where($posts)->find();
            $where['postid']                            = $postid['id'];
        }
        $where['A.status']                              = array('between','0,1');
        $where                                          = array_filter($where);
        if(count($where) !== 0 || $all !== ""){
            if($all == '所有'){
                $count                                  = $this->salary_count(1,$where);
            }
            if(count($where) !== 0){
                $count                                  = $this->salary_count(2,$where);
            }
            $page                                       = new Page($count,4);
            $pages                                      = $page->show();
            $account_r                                  = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.guide_id,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->where($where)->limit("$page->firstRow","$page->listRows")->select();
            foreach($account_r as $key => $val){
                $aid['account_id']                      = $account_r[$key]['aid'];
                $whe['account_id']                      = $aid['account_id'];
                $whe['status']                          = (int)1;
                $account_r[$key]['Labour']              = M('salary_labour')->where($whe)->find();
                $salary                                 = M('salary')->where($aid)->order('id desc')->find();//岗位薪资
                $account_r[$key]['account_id']          = $salary['account_id'];
                $account_r[$key]['standard_salary']     = $salary['standard_salary'];
                $account_r[$key]['basic_salary']        = $salary['basic_salary'];
                $account_r[$key]['performance_salary']  = $salary['performance_salary'];
                $salary_bonus                           = M('salary_bonus')->where($aid)->order('id desc')->find();//提成/奖金
                $account_r[$key]['bonus_id']            = $salary_bonus['id'];

                $month                                  = datetime(date('Y'),date('m'),date('d'),1);//获取201810月份
                $account_r[$key]['extract']             = round(Acquisition_Team_Subsidy($month,$val['guide_id']),2);//带团补助

                $account_r[$key]['bonus']               = $salary_bonus['bonus'];
                $account_r[$key]['annual_bonus']        = $salary_bonus['annual_bonus'];
                $subsidy_r                              = M('salary_subsidy')->where($aid)->order('id desc')->find();//补贴
                $account_r[$key]['subsidy']             = $subsidy_r['id'];
                $account_r[$key]['housing_subsidy']     = $subsidy_r['housing_subsidy'];
                $account_r[$key]['foreign_subsidies']   = $subsidy_r['foreign_subsidies'];
                $account_r[$key]['computer_subsidy']    = $subsidy_r['computer_subsidy'];
                $account_r[$key]['insurance']           = M('salary_insurance')->where($aid)->order('id desc')->find();//五险一金
                $income                                 = M('salary_income')->where($aid)->order('id desc')->find();//其他收入
                if($income){
                    $wher['income_token']               = $income['income_token'];
                    $account_r[$key]['Other']           = sql_query(1,'*','oa_salary_income',$wher,1,2);//其他收入
                }
                $withholding                            = M('salary_withholding')->where($aid)->order('id desc')->find();//代扣代缴
                if($withholding){
                    $query['token']                     = $withholding['token'];
                    $account_r[$key]['withholding']     = sql_query(1,'*','oa_salary_withholding',$query,1,2);//代扣代缴
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
        if($status == 5){
            $this->assign('withhold',$account_r);//数据
            $this->assign('stau',$status);//数据
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
        if(isset($_POST['dosubmint'])){
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
        }else{
            $db                     = M('salary_department');
            //分页
            $pagecount		        = $db->count();
            $page			        = new Page($pagecount, 5);
            $this->pages	        = $pagecount>P::PAGE_SIZE ? $page->show():'';

            //$this->lists    = $db->limit($page->firstRow,$page->listRows)->select();

            $this->lists            = $db->select();
            $this->display();
        }
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
    public function salary_excel_list(){//判断权限
        $monthly                        = trim(I('month'));
        $archives                       = trim(I('archives'));
        $datetime                       = trim(I('datetime'));
        $name                           = trim(I('name'));//名字
        if(is_numeric($monthly) && is_numeric($archives)){
            $dateti['datetime']         = $monthly;
                $sql                    = 'SELECT *,month.status as mstatus FROM oa_salary_wages_month as month, oa_account as account where month.account_id=account.id AND account.archives='.$archives.' AND month.datetime='.$monthly;
            if($name!==""){
                $sql .= " AND month.user_name=$name";
            }
            $user_info = M()->query($sql);
            $info                       = $this->arraysplit($user_info);
            $sum                        = $this->countmoney($archives,$info,1);//部门合计
            $summoney                   = $this->summoney($sum); //总合计
            $status                     = $user_info[0]['mstatus'];
            if($status=="" || $status==0){
                $status                 = 1;
            }
        }else{
            if(!empty($archives)){
                $info                   = $this->salary_excel_sql($archives,$name);//员工信息
                $sum                    = $this->countmoney($archives,$info);//部门合计
                $summoney               = $this->summoney($sum); //总合计
            }elseif(is_numeric($monthly)){
                $dateti['datetime']     = $monthly;
                if($name!==""){
                    $dateti['user_name']= $name;
                }
                $wages_month            = M('salary_wages_month')->where($dateti)->select();//已经提交数据
                $info                   = $this->arraysplit($wages_month);
                unset( $dateti['user_name']);
                $sum                    = M('salary_departmen_count')->where($dateti)->select();
                $summoney               = M('salary_count_money')->where($dateti)->find();
                $status                 = $wages_month[0]['status'];
            }else{
                $wher['status']     = 3;
                if($name!==""){
                    $wher['user_name']  = $name;
                }
                $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                if(!$wages_month){
                    $wher['status']     = 2;
                    if($name!==""){
                        $wher['user_name']  = $name;
                    }
                    $wages_month        = M('salary_wages_month')->where($wher)->select();//已经提交数据
                    if(!$wages_month) {
                        $info           = $this->salary_excel_sql($archives,$name);//员工信息
                        $sum            = $this->countmoney('',$info);//部门合计
                        $summoney       = $this->summoney($sum); //总合计
                        $status         = 1;
                    }else{
                        $info           = $this->arraysplit($wages_month);
                        $sum            = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                        $summoney       = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                        $status         = 2;
                    }
                }else{
                    $info               = $this->arraysplit($wages_month);
                    $sum                = M('salary_departmen_count')->where('datetime='.$wages_month[0]['datetime'])->select();
                    $summoney           = M('salary_count_money')->where('datetime='.$wages_month[0]['datetime'])->find();
                    $status             = 3;
                }
            }
        }
        if(!empty($summoney['datetime'])){//判断当前总和年月
            $year1 = substr($summoney['datetime'],0,4);
            $month1 = substr($summoney['datetime'],4);
            $date = $year1.'年'.$month1.'月';
          
        }else{
            $date=datetime(date('Y'),date('m'),date('d'),2);
        }

        $sign = M('salary_sign')->where('datetime='.$summoney['datetime'])->find();
        if($sign['submission_status']==2){//判断提交人id 是否存在
            $sign1 = M('user_sign')->where('user_id='.$sign['submission_user_id'])->find();
            if($sign1){
                $url1 = $sign1['file_url'];
                $this->assign('url1',$url1);
            }
        }
        if($sign['examine_status']==2){//判断审批人id 是否存在
            $sign2 = M('user_sign')->where('user_id='.$sign['examine_user_id'])->find();
            if($sign2){
                $url2 = $sign2['file_url'];
                $this->assign('url2',$url2);
            }
        }
        if($sign['approval_status']==2){//判断批准人id 是否存在
            $sign3 = M('user_sign')->where('user_id='.$sign['approval_user_id'])->find();
            if($sign3){
                $url3 = $sign3['file_url'];
                $this->assign('url3',$url3);
            }
        }
        $this->date = $date;
        $userid                         = (int)$_SESSION['userid'];//用户id
        $this->assign('info',$info);//员工信息 inf
        $this->assign('type',$archives);//状态
        $this->assign('sum',$sum);//部门合计 su
        $this->assign('count',$summoney);//总合计 coun
        $this->assign('time',$datetime);//表时间
        $this->assign('status',$status);//提交状态
        $this->assign('userid',$userid);//提交状态
        $this->display();
    }

    /**
     *  数组拆分
     */
    private function arraysplit($wages_month){

        foreach($wages_month as $key => $val){
            $list[$key]['wages_mont_id']                            = $val['id'];
            $list[$key]['account']['id']                            = $val['account_id'];
            $list[$key]['account']['nickname']                      = $val['user_name'];
            $list[$key]['department'][0]['department']              = $val['department'];
            $list[$key]['department'][0]['id']                      = $val['departmentid'];
            $list[$key]['posts'][0]['post_name']                    = $val['post_name'];
            $list[$key]['salary'][0]['standard_salary']             = $val['standard'];
            $list[$key]['salary'][0]['basic_salary']                = ((int)($val['basic_salary']/$val['standard']*1000))/100;
            $list[$key]['salary'][0]['performance_salary']          = ((int)($val['performance_salary']/$val['standard']*1000))/100;
            $list[$key]['salary'][0]['id']                          = $val['salary_id'];
            $list[$key]['attendance'][0]['id']                      = $val['attendance_id'];
            $list[$key]['attendance'][0]['withdrawing']             = $val['withdrawing'];
            $list[$key]['bonus'][0]['id']                           = $val['bonus_id'];
            $list[$key]['bonus'][0]['foreign_bonus']                = $val['bonus'];
            $list[$key]['income'][0]['income_token']                = $val['income_token'];
            $list[$key]['Other']                                    = $val['Other'];
            $list[$key]['insurance'][0]['id']                       = $val['insurance_id'];
            $list[$key]['insurance_Total']                          = $val['insurance_Total'];
            $list[$key]['insurance'][0]['medical_care_base']        = $val['medical_care'];
            $list[$key]['insurance'][0]['pension_base']             = $val['pension_ratio'];
            $list[$key]['insurance'][0]['unemployment_base']        = $val['unemployment'];
            $list[$key]['insurance'][0]['accumulation_fund_base']   = $val['accumulation_fund'];
            $list[$key]['insurance'][0]['medical_care_ratio']       = 1;
            $list[$key]['insurance'][0]['pension_ratio']            = 1;
            $list[$key]['insurance'][0]['unemployment_ratio']       = 1;
            $list[$key]['insurance'][0]['accumulation_fund_ratio']  = 1;
            $list[$key]['subsidy'][0]['id']                         = $val['subsidy_id'];
            $list[$key]['subsidy'][0]['housing_subsidy']            = $val['housing_subsidy'];
            $list[$key]['withholding'][0]['token']                  = $val['withholding_token'];
            $list[$key]['Extract']['target']                        = $val['target'];
            $list[$key]['Extract']['complete']                      = $val['complete'];
            $list[$key]['Extract']['total']                         = $val['total'];
            $list[$key]['tax_counting']                             = $val['tax_counting'];
            $list[$key]['personal_tax']                             = $val['personal_tax'];
            $list[$key]['Labour']                                   = $val['Labour'];
            $list[$key]['summoney']                                 = $val['summoney'];
            $list[$key]['real_wages']                               = $val['real_wages'];
            $list[$key]['Achievements']['sum_total_score']          = $val['sum_total_score'];
            $list[$key]['Achievements']['total_score_show']         = $val['total_score_show'];
            $list[$key]['Achievements']['show_qa_score']            = $val['show_qa_score'];
            $list[$key]['Achievements']['count_money']              = $val['Achievements_withdrawing'];
            $list[$key]['Should']                                   = $val['Should_distributed'];
            $list[$key]['accumulation']                             = $val['accumulation_fund'];
            $list[$key]['labour']['Labour_money']                   = $val['Labour'];
            $list[$key]['datetime']                                 = $val['datetime'];
        }
        return $list;
    }

    /**
     * @salary_excel_sql
     * 获取详情数据表
     */
    private function salary_excel_sql($archives,$name){
            if($name!==""){
                $where['nickname']                  = $name;
            }
        $where['archives']                          = $archives;
        if($archives==null || $archives==false){
            unset($where['archives']);
        }
        $where['status'] = array('between','0,1');
        $info                                       =  M('account')->where($where)->order('employee_member ASC')->select();//个人数据
        foreach($info as $k => $v){//去除编码空的数据
            if($v['employee_member'] == ""){
                unset($info[$k]);
            }
        }
        foreach($info as $key =>$val) {//薪资详情
            $user_info[$key]['account']             = $val;
            $id['account_id']                       = $val['id'];
            $department['id']                       = $val['departmentid'];//部门
            $user_info[$key]['department']          = sql_query(1,'*','oa_salary_department',$department,1,1);//查询部门
            $posts['id']                            = $val['postid'];
            $user_info[$key]['posts']               = sql_query(1,'*','oa_posts',$posts,1,1);//查询岗位
            $user_info[$key]['salary']              = sql_query(1,'*','oa_salary',$id, 1, 1);//岗位薪酬
            $att_id['account_id']                   = $val['id'];
            $att_id['status']                       = 1;
            $user_info[$key]['attendance']          = sql_query(1,'*','oa_salary_attendance',$att_id, 1, 1);//员工考核
            $user_bonus                             = sql_query(1,'*','oa_salary_bonus',$att_id, 1, 1);//提成/奖金/年终奖
            $generate_month                         = datetime(date('Y'),date('m'),date('d'),1);//获取当前年月
            $bonus_extract                          = Acquisition_Team_Subsidy($generate_month,$val['guide_id']);//带团补助
            $user_info[$key]['bonus']               = $user_bonus;
            $user_info[$key]['bonus'][0]['extract'] = $bonus_extract;
            $user_info[$key]['labour']              = M('salary_labour')->where($id)->order('id desc')->find();//工会会费
            if(count($user_info[$key]['salary'])==0){
                unset($user_info[$key]);continue;
            }
            $income                                 = sql_query(1,'*','oa_salary_income',$att_id, 1,1);//其他收入
            $countmoney                             = 0;
            if ($income) {
                $token['income_token']              = $income[0]['income_token'];
                $user_info[$key]['income']          = sql_query(1,'*','oa_salary_income', $token,1,2);//其他收入所有项目
                foreach($user_info[$key]['income'] as $ke =>$va){
                    $countmoney                     += $va['income_money'];
                }
            }
            $user_info[$key]['insurance']           = sql_query(1,'*','oa_salary_insurance', $id, 1,1);//五险一金表
            $user_info[$key]['insurance_Total']     = round(($user_info[$key]['insurance'][0]['pension_ratio']*$user_info[$key]['insurance'][0]['pension_base']+$user_info[$key]['insurance'][0]['medical_care_ratio']*$user_info[$key]['insurance'][0]['medical_care_base']+$user_info[$key]['insurance'][0]['unemployment_ratio']*$user_info[$key]['insurance'][0]['unemployment_base']+round($user_info[$key]['insurance'][0]['accumulation_fund_ratio']*$user_info[$key]['insurance'][0]['accumulation_fund_base'])+$user_info[$key]['insurance'][0]['big_price']),2);//五险一金

            $user_info[$key]['accumulation']        = round(($user_info[$key]['insurance'][0]['accumulation_fund_ratio']*$user_info[$key]['insurance'][0]['accumulation_fund_base']),0);

            $user_info[$key]['subsidy']             = sql_query(1,'*','oa_salary_subsidy', $id,1,1);//补贴
            $withholding                            = sql_query(1,'*','oa_salary_withholding', $id,1,1);//代扣代缴

            if ($withholding) {
                $wit['token']                       = $withholding[0]['token'];
                $wit['account_id']                  = $val['id'];
                $wit                                = array_filter($wit);
                $user_info[$key]['withholding']     = sql_query(1,'*','oa_salary_withholding',$wit,1,2);//代扣代缴

                foreach($user_info[$key]['withholding'] as $kk =>$vv){
                    $user_info[$key]['summoney']    += $vv['money']; //总代扣代缴
                }
            }
            // kpi  pdca 品质检查
            $que['p.tab_user_id']                   = $val['id'];//用户id
            $que['p.month']                         = datetime(date('Y'),date('m'),date('d'),1);
            $user                                   = $this->query_score($que);//绩效增减
            $use1                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['total_score_show']));//PDCA
            $use2                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['show_qa_score']));//品质检查
            $use3                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分'),"",$user[0]['total_kpi_score']));//KPI
            $money                                  = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['performance_salary'];//绩效金额
            $branch                                 = 100;//给总共100分

            if($val['formal']==0 || $val['formal']==4) {
                $use3 = 0;
            }
            $f = $use1+$use2+$use3;//获得总分
            if(substr($f,0,1)=='-'){
                $user_info[$key]['Achievements']['count_money']     = (substr($f,0,1)).(round(($money/$branch*(substr($f,1))),2));
            }else{
                $user_info[$key]['Achievements']['count_money']     = (substr($f,0,1)).(round(($money/$branch*(substr($f,1))),2));
            }
            $user_info[$key]['Achievements']['total_score_show']    = $use1;//pdca分数
            $user_info[$key]['Achievements']['show_qa_score']       = $use2;//品质检查分数
            $user_info[$key]['Achievements']['sum_total_score']     = $use3;//KPI分数

                //如果做季度提成可以变为奖金放开屏蔽即可
//            if($user_info[$key]['bonus'][0]['annual_bonus']!==0 && !empty($user_info[$key]['bonus'][0]['annual_bonus'])){
//                $Year_end = $user_info[$key]['Extract']['total'];
//                 unset($user_info[$key]['Extract']['total']);
//                $user_info[$key]['Extract']['total']= $user_bonus;
//
//            }else{
//                 $user_info[$key]['Extract']['total']    = $user_info[$key]['Extract']['total']+$user_bonus;//提成相加
//            }
            $user_price                             = $this->salary_kpi_month(100,$que['p.month'],1); //业务人员 目标任务 完成 提成
            $user_info[$key]['Extract']['total']    = $user_price['total']+$user_bonus[0]['bonus']+$bonus_extract;//提成相加
            $extract                                = $user_info[$key]['Extract']['total'];
//            $Year_end                               = $Year_end;//如果做季度提成可以变为奖金放开屏蔽即可
            $Year_end                               = ($user_info[$key]['bonus'][0]['annual_bonus'])/12;
            if($Year_end < 1500){
                $price1                             = $Year_end*0.03;
            }
            if($Year_end > 1500 && $Year_end < 4500){
                $price1                             = $Year_end*0.1-105;
            }
            if($Year_end > 4500 && $Year_end < 9000){
                $price1                             = $Year_end*0.2-555;
            }
            if($Year_end > 9000 && $Year_end < 35000){
                $price1                             = $Year_end*0.25-1055;
            }
            if($Year_end > 35000 && $Year_end < 55000){
                $price1                             = $Year_end*0.3-2755;
            }
            if($Year_end > 55000 && $Year_end < 80000){
                $price1                             = $Year_end*0.35-5505;
            }
            if($Year_end>80000){
                $price1                             = $Year_end*0.45-13505;
            }
            $user_info[$key]['yearend']             = round($price1,2);//年终奖计税

            //其他补款 = 其他补贴变动 + 外地补贴 + 电脑补贴
            $user_info[$key]['Other']               = round(($countmoney+$user_info[$key]['subsidy'][0]['foreign_subsidies']+$user_info[$key]['subsidy'][0]['computer_subsidy']),2);

            // 提成 + 奖金+带团补助+年终奖+住房补贴+外地补贴+电脑补贴+提成
            $user_info[$key]['welfare']             = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$bonus_extract+$extract+$user_info[$key]['bonus'][0]['annual_bonus']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']),2);//提成补助奖金

            //应发工资 = 岗位工资-考勤扣款+绩效增减+季度提成+奖金+年终奖-年终奖计税+住房补贴+其他补款
            $user_info[$key]['Should'] = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$extract+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']),2);

            $user_info[$key]['tax_counting']        = round(($user_info[$key]['Should']-$user_info[$key]['insurance_Total']+$user_info[$key]['labour']['merge_counting']),2);//计税工资
            //个人所得税$user_info[$key]['labour']['merge_counting']
            if($user_info[$key]['tax_counting'] <= 5000){
                $counting                           = '0';
            }else{
                $cout                               = $user_info[$key]['tax_counting']-5000;
                if($cout <= 3000){
                    $countin                        = $cout*0.03;

                }elseif($cout > 3000 && $cout <= 12000){
                    $countin                        = $cout*0.10-210;
                }elseif($cout > 12000 && $cout <= 25000){
                    $countin                        = $cout*0.20-1410;
                }elseif($cout > 25000 && $cout <= 35000){
                    $countin                        = $cout*0.25-2660;
                }elseif($cout > 35000 && $cout <= 55000){
                    $countin                        = $cout*0.30-4410;
                }elseif($cout > 55000 && $cout <= 80000){
                    $countin                        = $cout*0.35-7160;
                }elseif($cout > 80000){
                    $countin                        = $cout*0.45-15160;
                }
                $counting                           = round($countin,2);
            }
            $user_info[$key]['datetime']            = $que['p.month'];//现在日期
            $user_info[$key]['personal_tax']        = $counting;//个人所得税

            //实发工资=岗位工资-考勤扣款+绩效增减+提成(带团补助)+奖金-代扣代缴+年终奖-年终奖计税+住房补贴+外地补贴+电脑补贴-五险一金-个人所得税-工会会费+其他补款
            $user_info[$key]['real_wages']          = round(($user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$extract-$user_info[$key]['summoney']+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']-$user_info[$key]['insurance_Total']-$counting-$user_info[$key]['labour']['Labour_money']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']+$user_info[$key]['bonus'][0]['foreign_bonus']),2);
        }
        return $user_info;
    }

    /**
     * countmoney 部门合计
     * $archives $list  $status 分类状态 信息 判定
     */
    private function countmoney($archives,$list,$status){
        $where['archives']                                  = $archives;
        $where = array_filter($where);
        $info1                                              =  M('account')->where($where)->group('departmentid')->order('employee_member ASC')->select();//个人数据
        foreach($info1 as $k => $v){//去除编码空的数据
            if($v['employee_member'] == ""){//去空
                unset($info1[$k]);
            }else{
                $query['departmentid']                      = $v['departmentid'];
                foreach($list as $key =>$val){
                    if($val['department'][0]['id']==$v['departmentid']){
                        $sum[$k]['name']                    = '部门合计';
                        $sum[$k]['department']              =  $val['department'][0]['department'];//部门
                        $sum[$k]['standard_salary']         += round($val['salary'][0]['standard_salary']);//标准薪资
                        $sum[$k]['basic']                   += round($val['salary'][0]['standard_salary']/10*$val['salary'][0]['basic_salary'],2);//基本薪资
                        $sum[$k]['withdrawing']             += round($val['attendance'][0]['withdrawing'],2);//考勤扣款
                        $sum[$k]['performance_salary']      += round($val['salary'][0]['standard_salary']/10*$val['salary'][0]['performance_salary'],2);//绩效薪资
                        $sum[$k]['count_money']             += round($val['Achievements']['count_money'],2);//绩效增减
                        $sum[$k]['total']                   += round($val['Extract']['total'],2);//业绩提成
                        $sum[$k]['bonus']                   += round($val['bonus'][0]['foreign_bonus'],2);// 奖金
                        $sum[$k]['housing_subsidy']         += round($val['subsidy'][0]['housing_subsidy'],2);//住房补贴
                        $sum[$k]['Other']                   += round($val['Other'],2);//其他补款
                        $sum[$k]['Should']                  += round($val['Should'],2);//应发工资
                        $sum[$k]['care']                    += round($val['insurance'][0]['medical_care_base']*$val['insurance'][0]['medical_care_ratio'],3);//医疗保险
                        $sum[$k]['pension']                 += round($val['insurance'][0]['pension_base']*$val['insurance'][0]['pension_ratio'],3);//养老保险
                        $sum[$k]['unemployment']            += round($val['insurance'][0]['unemployment_base']*$val['insurance'][0]['unemployment_ratio'],2);// 失业保险
                        $sum[$k]['accumulation']            += round($val['insurance'][0]['accumulation_fund_base']*$val['insurance'][0]['accumulation_fund_ratio']);//公积金
                        $sum[$k]['insurance_Total']         += round($val['insurance_Total'],3);//个人保险合计
                        $sum[$k]['big_price']               += round($val['insurance'][0]['big_price'],3);//个人大额医疗
                        $sum[$k]['tax_counting']            += round($val['tax_counting'],2);//计税工资
                        $sum[$k]['personal_tax']            += round($val['personal_tax'],2);//个人所得税
                        $sum[$k]['summoney']                += round($val['summoney'],2);//税后扣款
                        $sum[$k]['Labour']                  += round($val['labour']['Labour_money'],2);//工会会费
                        $sum[$k]['real_wages']              += round($val['real_wages'],2);// 实发工资
                        $sum[$k]['datetime']                 = $val['datetime'];
                    }
                }
            }
        }
        return $sum;
    }

    /**
     * summoney 总合计
     */
    private function summoney($sum){
        $cout['name']                                = '总合计';
        foreach($sum as $key => $val){
            $cout['standard_salary']                 += round($val['standard_salary'],2);//标准薪资
            $cout['basic']                           += round($val['basic'],2);//基本薪资
            $cout['withdrawing']                     += round($val['withdrawing'],2);//考勤扣款
            $cout['performance_salary']              += round($val['performance_salary'],2);//绩效薪资
            $cout['count_money']                     += round($val['count_money'],2);//绩效增减
            $cout['total']                           += round($val['total'],2);//业绩提成
            $cout['bonus']                           += round($val['bonus'],2);//奖金
            $cout['housing_subsidy']                 += round($val['housing_subsidy'],2);//住房补贴
            $cout['Other']                           += round($val['Other'],2);//其他补款
            $cout['Should']                          += round($val['Should'],2);//应发工资
            $cout['big_price']                       += round($val['big_price'],3);//个人大额医疗
            $cout['care']                            += round($val['care'],3);//医疗保险
            $cout['pension']                         += round($val['pension'],3);//养老保险
            $cout['unemployment']                    += round($val['unemployment'],2);//失业保险
            $cout['accumulation']                    += round($val['accumulation'],2);//公积金
            $cout['insurance_Total']                 += round($val['insurance_Total'],3);//个人保险合计
            $cout['tax_counting']                    += round($val['tax_counting'],2);//计税工资
            $cout['personal_tax']                    += round($val['personal_tax'],2);//个人所得税
            $cout['summoney']                        += round($val['summoney'],2);//税后扣款
            $cout['Labour']                          += round($val['Labour'],2);//工会会费
            $cout['real_wages']                      += round($val['real_wages'],2);//实发工资
            $cout['datetime']                         = $val['datetime'];
        }
        return $cout;
    }

    /**
     * 导出 excel
     */
    public function salary_exportExcel(){

        $datetim                            = I('datetime');
        $type                               = I('type');
        if(is_numeric($datetim)){
            $datetime                       = datetime(date('Y'),date('m'),date('d'),2);
            $money                          = M('salary_count_money')->where('datetime='.$datetim)->find();
            if(!$money){
                unset($datetim);
            }else{
                $examine_user_id            = user_table($money['examine_user_id']);//提交人
                $submission_user_id         = user_table($money['submission_user_id']);//审批人
                $approval_user_id           = user_table($money['approval_user_id']);//批准人
            }
        }
        if(is_numeric($datetim) && is_numeric($type)){//没有数据
            $sql                            = 'SELECT *,month.status as mstatus FROM oa_salary_wages_month as month, oa_account as account where month.account_id=account.id AND account.archives='.$type.' AND month.datetime='.$datetim;
            $user_info                      = M()->query($sql);
            $info                           = $this->arraysplit($user_info);
            $sum                            = $this->countmoney($type,$info,1);//部门合计
            $summoney                       = $this->summoney($sum); //总合计
            $examine_name                   = $examine_user_id['nickname'];//提交人
            $submissin_name                 = $submission_user_id['nickname'];//审批人
            $approval_name                  = $approval_user_id['nickname'];//批准人
            $approval_time                  = $money['approval_time'];//批准时间
        }elseif(is_numeric($datetim)){//有时间
            $dateti['datetime']             = $datetim;
            $wages_month                    = M('salary_wages_month')->where($dateti)->select();//已经提交数据
            $info                           = $this->arraysplit($wages_month);
            $sum                            = M('salary_departmen_count')->where($dateti)->select();
            $summoney                       = M('salary_count_money')->where($dateti)->find();
            $examine_name                   = $examine_user_id['nickname'];//提交人
            $submissin_name                 = $submission_user_id['nickname'];//审批人
            $approval_name                  = $approval_user_id['nickname'];//批准人
            $approval_time                  = $summoney['approval_time'];//批准时间

        }elseif(is_numeric($type)) {//有状态
            $info                           = $this->salary_excel_sql($type);//员工信息
            $sum                            = $this->countmoney($type,$info);//部门合计
            $summoney                       = $this->summoney($sum); //总合计
        }else{//没时间 没状态
            $info                           = $this->salary_excel_sql();//员工信息
            $sum                            = $this->countmoney('', $info);//部门合计
            $summoney = $this->summoney($sum); //总合计
        }

        foreach($info as $key => $val){
            $account                    = user_table($val['account']['id']);
            $info_user1[$key][0]        = $val['account']['id'];
            $info_user1[$key][1]        = $account['nickname'];
            $info_user1[$key][2]        = $val['posts'][0]['post_name'];
            $info_user1[$key][3]        = $val['department'][0]['department'];
            $info_user1[$key][4]        = $account['ID_number'];
            $info_user1[$key][5]        = $account['Salary_card_number'];
            $info_user1[$key][6]        = sprintf("%.2f",$val['salary'][0]['standard_salary']);
            $info_user1[$key][7]        = sprintf("%.2f",$val['salary'][0]['standard_salary']/10*$val['salary'][0]['basic_salary']);
            $info_user1[$key][8]        = sprintf("%.2f",$val['attendance'][0]['withdrawing']);
            $info_user1[$key][9]        = sprintf("%.2f",$val['salary'][0]['standard_salary']/10*$val['salary'][0]['performance_salary']) ;
            $info_user1[$key][10]       = sprintf("%.2f",$val['Achievements']['count_money']);
            $info_user1[$key][11]       = sprintf("%.2f",$val['Extract']['total']);
            $info_user1[$key][12]       = sprintf("%.2f",$val['bonus'][0]['bonus']);
            $info_user1[$key][13]       = sprintf("%.2f",$val['subsidy'][0]['housing_subsidy']);
            $info_user1[$key][14]       = sprintf("%.2f",$val['Other']);
            $info_user1[$key][15]       = sprintf("%.2f",$val['Should']);
            $info_user1[$key][16]       = sprintf("%.2f",($val['insurance'][0]['medical_care_base']*$val['insurance'][0]['medical_care_ratio']+$val['insurance'][0]['big_price'])) ;
            $info_user1[$key][17]       = sprintf("%.2f",$val['insurance'][0]['pension_base']*$val['insurance'][0]['pension_ratio']) ;
            $info_user1[$key][18]       = sprintf("%.2f",$val['insurance'][0]['unemployment_base']*$val['insurance'][0]['unemployment_ratio']) ;
            $info_user1[$key][19]       = sprintf("%.2f",$val['accumulation']);
            $info_user1[$key][20]       = sprintf("%.2f",$val['insurance_Total']);
            $info_user1[$key][21]       = sprintf("%.2f",$val['tax_counting']);
            $info_user1[$key][22]       = sprintf("%.2f",$val['personal_tax']);
            $info_user1[$key][23]       = sprintf("%.2f",$val['summoney']);
            $info_user1[$key][24]       = sprintf("%.2f",$val['labour']['Labour_money']);
            $info_user1[$key][25]       = sprintf("%.2f",$val['real_wages']);
        }
        foreach($sum as $key => $val){
            $info_user2[$key][0]        = $val['name'];
            $info_user2[$key][1]        = '';
            $info_user2[$key][2]        = '';
            $info_user2[$key][3]        = $val['department'];
            $info_user2[$key][4]        = '';
            $info_user2[$key][5]        = '';
            $info_user2[$key][6]        = sprintf("%.2f",$val['standard_salary']);
            $info_user2[$key][7]        = sprintf("%.2f",$val['basic']);
            $info_user2[$key][8]        = sprintf("%.2f",$val['withdrawing']);
            $info_user2[$key][9]        = sprintf("%.2f",$val['performance_salary']);
            $info_user2[$key][10]       = sprintf("%.2f",$val['count_money']);
            $info_user2[$key][11]       = sprintf("%.2f",$val['total']);
            $info_user2[$key][12]       = sprintf("%.2f",$val['bonus']);
            $info_user2[$key][13]       = sprintf("%.2f",$val['housing_subsidy']);
            $info_user2[$key][14]       = sprintf("%.2f",$val['Other']);
            $info_user2[$key][15]       = sprintf("%.2f",$val['Should']);
            $info_user2[$key][16]       = sprintf("%.2f",$val['care']);
            $info_user2[$key][17]       = sprintf("%.2f",$val['pension']);
            $info_user2[$key][18]       = sprintf("%.2f",$val['unemployment']);
            $info_user2[$key][19]       = sprintf("%.2f",$val['accumulation']);
            $info_user2[$key][20]       = sprintf("%.2f",$val['insurance_Total']);
            $info_user2[$key][21]       = sprintf("%.2f",$val['tax_counting']);
            $info_user2[$key][22]       = sprintf("%.2f",$val['personal_tax']);
            $info_user2[$key][23]       = sprintf("%.2f",$val['summoney']);
            $info_user2[$key][24]       = sprintf("%.2f",$val['Labour']);
            $info_user2[$key][25]       = sprintf("%.2f",$val['real_wages']);
        }

        $info_user3[$key][0]            = $summoney['name'];
        $info_user3[$key][1]            = '';
        $info_user3[$key][2]            = '';
        $info_user3[$key][3]            = '';
        $info_user3[$key][4]            = '';
        $info_user3[$key][5]            = '';
        $info_user3[$key][6]            = sprintf("%.2f",$summoney['standard_salary']);
        $info_user3[$key][7]            = sprintf("%.2f",$summoney['basic']);
        $info_user3[$key][8]            = sprintf("%.2f",$summoney['withdrawing']);
        $info_user3[$key][9]            = sprintf("%.2f",$summoney['performance_salary']);
        $info_user3[$key][10]           = sprintf("%.2f",$summoney['count_money']);
        $info_user3[$key][11]           = sprintf("%.2f",$summoney['total']);
        $info_user3[$key][12]           = sprintf("%.2f",$summoney['bonus']);
        $info_user3[$key][13]           = sprintf("%.2f",$summoney['housing_subsidy']);
        $info_user3[$key][14]           = sprintf("%.2f",$summoney['Other']);
        $info_user3[$key][15]           = sprintf("%.2f",$summoney['Should']);
        $info_user3[$key][16]           = sprintf("%.2f",$summoney['care']);
        $info_user3[$key][17]           = sprintf("%.2f",$summoney['pension']);
        $info_user3[$key][18]           = sprintf("%.2f",$summoney['unemployment']);
        $info_user3[$key][19]           = sprintf("%.2f",$summoney['accumulation']);
        $info_user3[$key][20]           = sprintf("%.2f",$summoney['insurance_Total']);
        $info_user3[$key][21]           = sprintf("%.2f",$summoney['tax_counting']);
        $info_user3[$key][22]           = sprintf("%.2f",$summoney['personal_tax']);
        $info_user3[$key][23]           = sprintf("%.2f",$summoney['summoney']);
        $info_user3[$key][24]           = sprintf("%.2f",$summoney['Labour']);
        $info_user3[$key][25]           = sprintf("%.2f",$summoney['real_wages']);
        $info_user3[$key][25]           = sprintf("%.2f",$summoney['real_wages']);
        if($datetim){
            $datetime = $datetim;
        }else{
            $datetime                   = $summoney['datetime'];
        }
        if(!empty($examine_name) && !empty($submissin_name) && !empty($approval_name) && !empty($approval_time)){//判断是否批准
            $Approver[0] = array('0'=>'','1'=>'','2'=>'','3'=>'提交审核 ：'.$examine_name,'4'=>'','5'=>'','6'=>'','7'=>'审核通过 ：'.$submissin_name,'8'=>'','9'=>'','10'=>'','11'=>'批准通过 ：'.$approval_name,'12'=>'','13'=>'','14'=>'','15'=>'批准日期 ：'.date('Y年m月d日',$approval_time));
        }else{
            $Approver[0] = array('0'=>'','1'=>'','2'=>'','3'=>'制表人 ：'.$_SESSION['name'],'4'=>'','5'=>'','6'=>'','7'=>'制表日期 ：'.date('Y年m月d日',time()));
        }

        $setTitle                       = $datetime.'工资发放表';
        $Excel_data[0]                  = array('0'=>'1',''=>'','2'=>'','3'=>'','4'=>$setTitle);
        $Excel_data[1]                  = array('1'=>'ID','2'=>'员工姓名','3'=>'岗位名称','4'=>'所属部门','5'=>'身份证号','6'=>'工资卡号','7'=>'岗位薪酬标准','8'=>'其中基本工资标准','9'=>'考勤扣款','10'=>'其中绩效工资标准','11'=>'绩效增减','12'=>'业绩提成','13'=>'奖金','14'=>'住房补贴','15'=>'其他补款','16'=>'应发工资','17'=>'医疗保险','18'=>'养老保险','19'=>'失业保险','20'=>'公积金','21'=>'个人保险合计','22'=>'计税工资','23'=>'个人所得税','24'=>'税后扣款','25'=>'工会会费','26'=>'实发工资');

        $Excel_content                  = array_merge($Excel_data,$info_user1,$info_user2,$info_user3,$Approver);
        exportexcel($Excel_content,$setTitle,$setTitle);
    }

    /**
     *salary_support 扶植人员信息表
     * $userid 用户id  $employee_member编码
     * $username 用户名字   $status状态 1 查询扶植人员 2添加扶植人员
     * $type 1 添加扶植人员
     */
    public function salary_support(){//departmentid
        $type                                = $_POST['type'];
        if(IS_POST){
            if($type==1){ //添加扶植人员
                $save['account_id']          = trim($_POST['userid']);
                $user['entry_account_id']    = $_SESSION['userid'];
                $user['starttime']           = trim(strtotime($_POST['starttime']));
                $user['endtime']             = trim(strtotime($_POST['endtime']));
                if(empty($user['starttime']) || empty($user['endtime'])){
                    $this->error('添加扶植人员起止时间不能为空!', U('Salary/salary_support'));die;
                }
                $support_r                   = M('salary_support')->where($save)->find();
                if($support_r){ //判断是否已经有扶植人员 已有修改
                    $save                    = M('salary_support')->where($save)->save($user);
                    if($save){//判断是否修改
                        $this->success('添加扶植人员成功!', U('Salary/salary_support'));die;
                    }else{
                        $this->error('添加扶植人员失败!请重新添加!', U('Salary/salary_support'));die;
                    }
                }else{ //没有就添加
                    $user['account_id']      = $_POST['userid'];
                    $user['createtime']      = time();
                    $add                     = M('salary_support')->add($user);
                    if($add){ //判断是否添加
                        $this->success('添加扶植人员成功!', U('Salary/salary_support'));die;
                    }else{
                        $this->error('添加扶植人员失败!请重新添加!', U('Salary/salary_support'));die;
                    }
                }
            }
            //查询扶植人员
            $userid['id']                    = $_POST['id'];
            $empl['department']              = $_POST['employee_member'];
            $userid['nickname']              = $_POST['name'];
            $status                          = $_POST['status'];
            if(!empty($empl['department'])){
                $departmentid                = M('salary_department')->where($empl)->find();//查询部门
                $userid['departmentid']      = $departmentid['id'];
            }
            $userid                          = array_filter($userid); //去除空数组
           if(!empty($userid)) {
               $userinfo                     = userinfo($userid);
               foreach($userinfo as $key => $val){
                   $account['account_id']    = $val['info']['id'];
                   $account['status']        = 1;
                   $userinfo[$key]['support']= M('salary_support')->where($account)->find();
               }
           }
        }else{
            $count                           = M('salary_support')->where('status=1')->count();
            $page                            = new Page($count,12);
            $pages                           = $page->show();
            $info                            = M('salary_support')->where('status=1')->limit("$page->firstRow","$page->listRows")->order('account_id ASC')->select();//分页显示
            foreach($info as $key => $val){
                $where['id']                 = $val['account_id'];
                $user                        = userinfo($where);
                foreach($user as $k => $v){
                    $content = $v;
                }
                $userinfo[$key]              = $content;
                $userinfo[$key]['support']   = $val;
            }
        }
        $this->assign('userinfo',$userinfo); //查询下详情
        $this->assign('status',$status);//当前回返状态
        $this->assign('page',$pages);//分页
        $this->display();
    }

}