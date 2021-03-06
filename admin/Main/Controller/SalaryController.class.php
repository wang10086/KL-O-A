<?php
namespace Main\Controller;
use Symfony\Component\Translation\Tests\IdentityTranslatorTest;
use Think\Controller;
use Sys\P;
ulib('Page');
use Sys\Page;
class SalaryController extends BaseController {

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
        if($month == 3 || $month == 6 || $month == 9 || $month == 1){
            if($month==1){$year=$year-1;$month=12;$query['month'] = $year.$month;}//如果季度提取正常就删除此行
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
     * @salary_attendance 考勤列表
     * grant_time  年月份搜索
     */
    public function salary_attendance(){
        $userid = (int)$_SESSION['userid'];

        if (in_array($userid,array(1,11,12,32,38,55,77,185,13))){

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
   /*  public function salary_add_department(){
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
    } */

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
            $list[$key]['Extract']['total']                         = $val['total']+$val['Subsidy'];
            $list[$key]['tax_counting']                             = $val['tax_counting'];
            $list[$key]['specialdeduction']                         = $val['specialdeduction'];
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
     * 获取销售季度任务系数oa_sale_config表
     * @param $quarter
     */
    private function getQuarterMonth($quarter,$year){
        $quarter                        = (int)$quarter;
        $field                          = array();
        switch ($quarter){
            case 1:
                $field                  = 'id,department_id,department,year,January,February,March';
                break;
            case 2:
                $field                  = 'id,department_id,department,year,April,May,June';
                break;
            case 3:
                $field                  = 'id,department_id,department,year,July,August,September';
                break;
            case 4:
                $field                  = 'id,department_id,department,year,October,November,December';
                break;
        }
        $lists                          = M('sale_config')->field($field)->where(array('year'=>$year))->select();
        foreach ($lists as $k=>$v){
            $January                    = $v['January']?$v['January']:0;
            $February                   = $v['February']?$v['February']:0;
            $March                      = $v['March']?$v['March']:0;
            $April                      = $v['April']?$v['April']:0;
            $May                        = $v['May']?$v['May']:0;
            $June                       = $v['June']?$v['June']:0;
            $July                       = $v['July']?$v['July']:0;
            $August                     = $v['August']?$v['August']:0;
            $September                  = $v['September']?$v['September']:0;
            $October                    = $v['October']?$v['October']:0;
            $November                   = $v['November']?$v['November']:0;
            $December                   = $v['December']?$v['December']:0;
            $lists[$k]['coefficient']       = $January + $February + $March + $April + $May + $June + $July + $August + $September + $October + $November + $December;
        }
        return $lists;
    }

    //获取该季度所有结算的团
    private function get_quarter_settlement_list($quarter_time){
        $where                                  = array();
        $where['b.audit_status']                = 1;
        $where['l.req_type']                    = 801;
        $where['l.audit_time']                  = array('between', "$quarter_time[begin_time],$quarter_time[end_time]");
        $field                                  = array();
        $field                                  = 'o.op_id,o.project,o.group_id,o.create_user,o.create_user_name,b.maoli'; //获取所有该季度结算的团
        $op_settlement_list                     = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        return $op_settlement_list;
    }

    //获取本人季度业绩提成
    private function get_quarter_royalty($user,$sale_configs,$op_settlement_list,$salary){
        $salary                                 = $salary[0]['standard_salary'];    //工资岗位薪酬
        foreach ($sale_configs as $k=>$v){
            if ($user['departmentid']==$v['department_id']){
                $coefficient                    = $v['coefficient'];    //季度目标系数
            }
        }
        $lists                                  = array();
        foreach ($op_settlement_list as $key=>$value){
            if ($value['create_user']== $user['id']){
                $lists[]                        = $value;   //当季度结算的团
            }
        }
        $sum_profit                             = array_sum(array_column($lists,'maoli'));  //当季度结算毛利总额

        //提成金额 = 季度目标系数 * 工资岗位薪酬 (100%内提取5%; 100%-150%=>20%; 大于150%=>25%)
        $target                                 = $salary*$coefficient;     //目标值 = 季度目标系数 * 工资岗位薪酬
        $royalty                                = 0;
        if ($sum_profit < $target){
            $royalty                            += $sum_profit*0.05;
        }elseif ($sum_profit > $target && $sum_profit < $target*1.5){
            $royalty                            += $target*0.05;
            $royalty                            += ($sum_profit - $target)*0.2;
        }elseif ($sum_profit > $target*1.5){
            $royalty                            += $target*0.05;
            $royalty                            += ($target*1.5 - $target)*0.2;
            $royalty                            += ($sum_profit - $target*1.5)*0.25;
        }
        $data                                   = array();
        $data['account_id']                     = $user['id'];
        $data['salary']                         = $salary;
        $data['quarter_profit']                 = $sum_profit;  //季度毛利
        $data['target']                         = $target;      //目标值
        $data['quarter_royalty']                = $royalty;     //季度提成
        return $data;
    }

    /**
     * @salary_excel_sql
     * 获取详情数据表
     */
    private function salary_excel_sql($archives='',$name='',$datetime=""){
        $mod                                        = D('Salary');
        $pay_year                                   = (int)substr($datetime,0,4);
        $pay_month                                  = (int)substr($datetime,4);
        if (in_array($pay_month,array('01','04','07','10'))){   //季度后一个月发放该季度提成
            if ($pay_month==1) {
                $p_year                             = $pay_year - 1;
                $p_month                            = 12;
            }else{
                $p_year                             = $pay_year;
                $p_month                            = $pay_month - 1;
            }
            $quarter                                = get_quarter($p_month);
            $sale_configs                           = $this->getQuarterMonth($quarter,$p_year);     //获取所有销售季度任务基数 coefficient
            $quarter_time                           = getQuarterlyCicle($p_year,$p_month);          //获取该季度周期,方便业务提成(结算)取值
            $op_settlement_list                     = $this->get_quarter_settlement_list($quarter_time);   //获取该季度所有的结算团
        }

        $where                                      = array();
        if($name)       $where['nickname']          = $name;
        if($archives)   $where['archives']          = $archives;
        $where['status']                            = 0;
        //$where['nickname']                          = '杨开玖';
        $info                                       =  M('account')->where($where)->order('employee_member ASC')->select();//个人数据

        foreach($info as $k => $v){//去除编码空的数据
            if($v['employee_member'] == ""){unset($info[$k]);}
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
            if(count($user_info[$key]['salary'])==0){unset($user_info[$key]);continue;}
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
            $specialdeduction                       = sql_query(1,'*','oa_salary_specialdeduction',$id,1,1); //专项附加扣除
            $user_info[$key]['specialdeduction_id'] = $specialdeduction[0]['id'];
            $user_info[$key]['specialdeduction']    = round($specialdeduction[0]['children_education'] + $specialdeduction[0]['continue_education'] + $specialdeduction[0]['health'] + $specialdeduction[0]['buy_house'] + $specialdeduction[0]['rent_house'] + $specialdeduction[0]['support_older'],2); //专项附加扣除合计
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
            $user                                   = $mod->query_score($que);//绩效增减
            $use1                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['total_score_show']));//PDCA
            $use2                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['show_qa_score']));//品质检查
            $use3                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','+'),"",$user[0]['total_kpi_score']));//KPI
            $money                                  = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['performance_salary'];//绩效金额
            $base_money                             = $user_info[$key]['salary'][0]['standard_salary']/10*$user_info[$key]['salary'][0]['basic_salary'];    //基本工资
            $branch                                 = 100;//给总共100分

            if($val['formal']==0 || $val['formal']==4) {$use3 = 0;}
            $f      = $use2+$use3;//获得总分    品质检查+kpi从绩效工资取值
            $fpdca  = $use1;

            //kpi季度考核的人员,从2019年开始实施下个季度从上个季度取值,第一季度均默认不扣KPI
            if (in_array($datetime,array('201901','201902','201903')) && in_array($val['id'],C('KPI_QUARTER'))){
                $f  = 0;
            }

            /*if(substr($f,0,1)=='-'){    //绩效工资余额
                $balance1                           = (substr($f,0,1)).(round(($money/$branch*$f),2));
                var_dump($f);
                var_dump($balance1);
            }else{
                $balance1                           = round(($money/$branch*$f),2);
            }
            if(substr($fpdca,0,1)=='-'){    //基本工资余额
                $balance2                           = (substr($fpdca,0,1)).(round(($base_money/$branch*(substr($fpdca,1))),2));
            }else{
                $balance2                           = round(($base_money/$branch*$fpdca),2);
            }*/
            $balance1                           = round(($money/$branch*$f),2); //绩效工资余额
            $balance2                           = round(($base_money/$branch*$fpdca),2);    //基本工资余额

            $user_info[$key]['Achievements']['count_money']         = $balance1 + $balance2;
            $user_info[$key]['Achievements']['total_score_show']    = $use1;//pdca分数
            $user_info[$key]['Achievements']['show_qa_score']       = $use2;//品质检查分数
            $user_info[$key]['Achievements']['sum_total_score']     = $use3;//KPI分数

            $quarter_royalty_data                   = $this->get_quarter_royalty($val,$sale_configs,$op_settlement_list,$user_info[$key]['salary']);    //销售季度目标 完成 提成
            //$quarter_royalty                        = $quarter_royalty_data['quarter_royalty'];

            $user_price                             = $this->salary_kpi_month($id['account_id'],$que['p.month'],1); //业务人员 目标任务 完成 提成 (刘 ) ??
            $user_price['target']                   = $quarter_royalty_data['target']?$quarter_royalty_data['target']:$user_price['target'];
            $user_price['complete']                 = $quarter_royalty_data['quarter_profit']?$quarter_royalty_data['quarter_profit']:$user_price['complete'];
            $user_price['total']                    = $quarter_royalty_data['quarter_royalty']?$quarter_royalty_data['quarter_royalty']:$user_price['total'];
            $user_info[$key]['bonus'][0]['royalty'] = $user_price['total'];
            $user_info[$key]['Extract']['total']    = $user_price['total']+$user_bonus[0]['bonus']+$bonus_extract ;//提成相加
            $extract                                = $user_info[$key]['Extract']['total'];
            $Year_end                               = ($user_info[$key]['bonus'][0]['annual_bonus'])/12;
            $user_info[$key]['yearend']             = $mod->year_end_tax($Year_end,$user_info[$key]['bonus'][0]['year_end_tax']);//年终奖计税
            //其他补款 = 其他补贴变动 + 外地补贴 + 电脑补贴
            $user_info[$key]['Other']               = round(($countmoney+$user_info[$key]['subsidy'][0]['foreign_subsidies']+$user_info[$key]['subsidy'][0]['computer_subsidy']),2);
            // 提成 + 奖金+带团补助+年终奖+住房补贴+外地补贴+电脑补贴+提成
            $user_info[$key]['welfare']             = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$extract+$user_info[$key]['bonus'][0]['annual_bonus']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']),2);//提成补助奖金

            //应发工资 = 岗位工资-考勤扣款+绩效增减+季度提成+奖金+年终奖-年终奖计税+住房补贴+其他补款
            $user_info[$key]['Should']              = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$extract+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']),2);

            //计税工资 = 应该工资-五险一金 + 合并计税 - 专项附加扣除
            $user_info[$key]['tax_counting']        = round(($user_info[$key]['Should']-$user_info[$key]['insurance_Total']+$user_info[$key]['labour']['merge_counting'] /*- $user_info[$key]['specialdeduction']*/),2);//计税工资

            $counting                               = $mod->individual_tax($user_info[$key]['tax_counting'],$val['id']);//个人所得税
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
        $info1                                              =  M('account')->where(
        )->group('departmentid')->order('employee_member ASC')->select();//个人数据
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
                        $sum[$k]['specialdeduction']        += round($val['specialdeduction']);//专项附加扣除
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
            $cout['specialdeduction']                += round($val['specialdeduction'],2);//专项附加扣除
            $cout['tax_counting']                    += round($val['tax_counting'],2);//计税工资
            $cout['personal_tax']                    += round($val['personal_tax'],2);//个人所得税
            $cout['summoney']                        += round($val['summoney'],2);//税后扣款
            $cout['Labour']                          += round($val['Labour'],2);//工会会费
            $cout['real_wages']                      += round($val['real_wages'],2);//实发工资
            $cout['datetime']                         = $val['datetime'];
        }
        return $cout;
    }

    //薪资首页
    public function salaryindex(){
        $name                                   = I('name')?trim(I('name')):'';
        $id                                     = I('id')?trim(I('id')):'';
        $department                             = I('department')?trim(I('department')):'';
        $month                                  = I('month')?trim(I('month')):'';
        $userid                                 = session('userid');
        $months                                 = I('months');

        $where                                  = array();
        $where['status']                        = 4;
        if ($name) $where['user_name']          = array('like','%'.$name.'%');
        if ($id) $where['account_id']           = $id;
        if ($department) $where['department']   = $department;
        if ($month) $where['datetime']          = $month;
        if ($months)$where['datetime']          = array('in',$months); //数据统计页面

        if (in_array($userid,array(1,11,12,32,38,55,13))){ //查看全部人员信息

        }elseif(in_array($userid,array(100,109))){ //查看所管辖人员信息 (100=>石曼, 109=>徐娜)
            $auth                               = explode(',',Rolerelation(cookie('roleid')));
            $where['account_id']                = array('in',$auth);
        }else{
            $where['account_id']                = $userid;
        }

        $count                                  = M('salary_wages_month')->where($where)->count();
        $page                                   = new Page($count,P::PAGE_SIZE);
        $this->pages                            = $count>P::PAGE_SIZE?$page->show():'';
        $lists                                  = M('salary_wages_month')->where($where)->limit("$page->firstRow","$page->listRows")->order('datetime desc')->select();//工资生成数据
        $this->lists                            = $lists;
        $this->display();
    }

    public function salary_excel_list(){
        $mod                                = D('Salary');
        $datetime                           = I('datetime')?trim(I('datetime')):date('Ym');
        $name                               = I('name')?trim(I('name')):'';
        $archives                           = I('archives')?I('archives'):0;

        $wage                               = array();
        $wage['s.datetime']                 = $datetime;
        if ($name) $wage['a.user_name']     = array('eq',$name);
        if ($archives) $wage['a.archives']  = $archives;
        $wagesLists                         = M()->table('__SALARY_WAGES_MONTH__ as s')->field('s.*')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->where($wage)->order('a.departmentid asc')->select();

         if ($wagesLists){
             $personWagesLists              = $wagesLists; //获取员工个人薪资信息
             if ($archives ==0){ //全部数据
                 $departmentWagesLists           = M('salary_departmen_count')->where(array('datetime'=>$datetime))->select(); //部门合计
                 $companyWagesLists              = M('salary_count_money')->where(array('datetime'=>$datetime))->find(); //公司合计
             }else{
                 $departmentWagesLists           = $mod->get_department_wagesList($personWagesLists); //部门合计
                 $companyWagesLists              = $mod->get_company_wages($personWagesLists); //公司合计 //公司合计
             }
             $sign_status                   = $mod->get_salary_status($datetime); //签字及审核状态
             $status                        = $sign_status['status'];
         }else{
            $where                          = array();
            $where['status']                = array('eq',0);   //未删除 未停用
            $where['id']                    = array('gt',10);
            if ($name) $where['nickname']   = array('like','%'.$name.'%');
            if ($archives)$where['archives']= $archives;

            $accounts                       = M('account')->where($where)->order('departmentid asc')->select();
            $personWagesLists               = $mod->get_person_wages_lists($accounts,$datetime); //获取员工个人薪资信息
            $departmentWagesLists           = $mod->get_department_wagesList($personWagesLists); //部门合计
            $companyWagesLists              = $mod->get_company_wages($personWagesLists); //公司合计
            $status                         = 1; //待人事提交
         }

        $this->sign_url                     = $sign_status;
        $this->status                       = $status;
        $this->personWagesLists             = $personWagesLists;
        $this->departmentWagesLists         = $departmentWagesLists;
        $this->companyWagesLists            = $companyWagesLists;
        $this->datetime                     = $datetime;
        $this->archives                     = $archives?$archives:0;

        $this->display();
    }



    public function salary_query(){

        $pin                                            = I('pin');
        $withholding_type                               = I('withholding_type');        //代扣代缴
        $type                                           = trim(I('typeval'));           //?
        $id                                             = trim(I('id'));
        $nickname                                       = trim(I('nickname'));
        $post_id                                        = trim(I('post_id'));           //岗位id
        $department_id                                  = trim(I('department_id'));     //部门id
        $where                                          = array();
        if ($id) $where['A.id']                         = $id;
        if ($nickname) $where['A.nickname']             = $nickname;
        if ($post_id) $where['A.postid']                = $post_id;
        if ($department_id) $where['A.departmentid']    = $department_id;
        $where['A.status']                              = array('in',array(0,1));

        //分页
        $pagecount		                            = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.guide_id,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->where($where)->order($this->orders('A.input_time'))->count();
        $page			                            = new Page($pagecount, 10);
        $this->pages	                            = $pagecount>10 ? $page->show():'';

        $account_r                                  = M()->table('oa_account as A')->join('oa_posts as P on A.postid=P.id')->join('oa_salary_department as D on D.id=A.departmentid')->field('A.id as aid,A.employee_member,A.guide_id,A.departmentid,A.employee_member,A.nickname,A.entry_time,A.archives,D.department,P.post_name')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('A.input_time'))->select();
        $specialDeduction_lists                     = M('salary_specialdeduction')->select();
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
            $account_r[$key]['foreign_bonus']       = $salary_bonus['foreign_bonus'];
            $account_r[$key]['year_end_tax']        = $salary_bonus['year_end_tax'];

            $subsidy_r                              = M('salary_subsidy')->where($aid)->order('id desc')->find();//补贴

            $account_r[$key]['bonus1']              = $subsidy_r['bonus'];
            $account_r[$key]['subsidy']             = $subsidy_r['id'];
            $account_r[$key]['housing_subsidy']     = $subsidy_r['housing_subsidy'];
            $account_r[$key]['foreign_subsidies']   = $subsidy_r['foreign_subsidies'];
            $account_r[$key]['computer_subsidy']    = $subsidy_r['computer_subsidy'];
            $account_r[$key]['insurance']           = M('salary_insurance')->where($aid)->order('id desc')->find();//五险一金
            $income                                 = M('salary_income')->where($aid)->order('id desc')->find();//其他收入
            if($income){
                $wher['income_token']               = $income['income_token'];
                $wher['status']                     = 1;
                $account_r[$key]['Other']           = sql_query(1,'*','oa_salary_income',$wher,1,2);//其他收入
            }
            $withholding                            = M('salary_withholding')->where($aid)->order('id desc')->find();//代扣代缴
            if($withholding){
                $query['token']                     = $withholding['token'];
                $query['status']                    = 1;
                $account_r[$key]['withholding']     = sql_query(1,'*','oa_salary_withholding',$query,1,2);//代扣代缴
            }

            //代扣代缴
            foreach ($specialDeduction_lists as $k=>$v){
                if ($v['account_id']==$val['aid']){
                    $account_r[$key]['account_name']        = $v['account_name'];
                    $account_r[$key]['children_education']  = $v['children_education']?$v['children_education']:'0.01'; //子女教育
                    $account_r[$key]['continue_education']  = $v['continue_education']?$v['continue_education']:'0.00'; //继续教育
                    $account_r[$key]['health']              = $v['health']?$v['health']:'0.00';                         //大病医疗
                    $account_r[$key]['buy_house']           = $v['buy_house']?$v['buy_house']:'0.00';                   //住房贷款
                    $account_r[$key]['rent_house']          = $v['rent_house']?$v['rent_house']:'0.00';                 //租房租金
                    $account_r[$key]['support_older']       = $v['support_older']?$v['support_older']:'0.00';           //赡养老人
                }
            }
        }

        if ($withholding_type){
            //代扣代缴
            $this->withholding_lists                = $account_r;
        }
        //人员名单关键字
        $this->userkey                              = get_username();
        $this->departments                          = M('salary_department')->getField('id,department',true);
        $this->lists                                = $account_r;
        $this->assign('type',$type);            //数据
        $this->assign('department',query_department());//部门
        $this->assign('posts',query_posts());   //岗位
        $this->assign('pin',$pin);
        $this->display();
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
        $this->assign('pin',I('pin')?I('pin'):5);
        $this->display();
    }

    /**
     * 导出 excel
     */
    public function salary_exportExcel(){
        $mod                                = D('Salary');
        $datetime                           = I('datetime');
        $archives                           = I('archives')?I('archives'):0;
        if (!$datetime) $this->error('导出数据失败');

        $wage                               = array();
        $wage['s.datetime']                 = $datetime;
        if ($archives) $wage['a.archives']  = $archives;
        $wagesLists                         = M()->table('__SALARY_WAGES_MONTH__ as s')->field('s.*,a.id as aid,a.ID_number,a.Salary_card_number')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->where($wage)->select();

        if ($wagesLists){
            $personWagesLists               = $wagesLists; //获取员工个人薪资信息
            if ($archives ==0){ //全部数据
                $departmentWagesLists           = M('salary_departmen_count')->where(array('datetime'=>$datetime))->select(); //部门合计
                $companyWagesLists              = M('salary_count_money')->where(array('datetime'=>$datetime))->find(); //公司合计
            }else{
                $departmentWagesLists           = $mod->get_department_wagesList($personWagesLists); //部门合计
                $companyWagesLists              = $mod->get_company_wages($personWagesLists); //公司合计 //公司合计
            }
        }else{
            $where                          = array();
            $where['status']                = array('neq',2);   //未删除
            $where['id']                    = array('gt',10);

            $accounts                       = M('account')->where($where)->select();
            $personWagesLists               = $mod->get_person_wages_lists($accounts,$datetime); //获取员工个人薪资信息
            $departmentWagesLists           = $mod->get_department_wagesList($personWagesLists); //部门合计
            $companyWagesLists              = $mod->get_company_wages($personWagesLists); //公司合计
            foreach ($personWagesLists as $k=>$v){
                $account                    = M('account')->where(array('id'=>$v['account_id']))->find();
                $personWagesLists[$k]['ID_number']          = $account['ID_number'];
                $personWagesLists[$k]['Salary_card_number'] = $account['Salary_card_number'];
            }
        }

        $excelLists                         = array();
        $account_ids                        = array();
        $account_wages_list                 = $wagesLists ? $wagesLists : $personWagesLists;
        $company_insurance_data             = 0;
        $num                                = 0;
        foreach ($personWagesLists as $k=>$v){ //个人
            $account_ids[]                  = $v['account_id'];
            $insurance_data                 = $mod->get_insurance_data($v['insurance_id']);
            $company_insurance_data         += $insurance_data['company_cost'];
            $excelLists[$num][0]            = $v['account_id'];
            $excelLists[$num][1]            = $v['user_name'];
            $excelLists[$num][2]            = $v['post_name'];
            $excelLists[$num][3]            = $v['department'];
            $excelLists[$num][4]            = $v['ID_number'];
            $excelLists[$num][5]            = $v['Salary_card_number'];
            $excelLists[$num][6]            = $v['standard'];
            $excelLists[$num][7]            = $v['basic_salary']; //基本工资
            $excelLists[$num][8]            = $v['withdrawing']; //考勤扣款
            $excelLists[$num][9]            = $v['performance_salary']; //绩效工资
            $excelLists[$num][10]           = $v['Achievements_withdrawing']; //绩效增减
            $excelLists[$num][11]           = $insurance_data['company_cost']; //公司五险一金
            $excelLists[$num][12]           = $v['Subsidy']; //带团补助
            $excelLists[$num][13]           = $v['total']; //业绩提成
            $excelLists[$num][14]           = $v['bonus'] + $v['welfare']?$v['bonus'] + $v['welfare']:'0.00'; //奖金
            $excelLists[$num][15]           = $v['housing_subsidy']; //住房补贴
            $excelLists[$num][16]           = $v['Other']; //其他补款
            $excelLists[$num][17]           = $v['Should_distributed']; //应发工资
            $excelLists[$num][18]           = $v['medical_care']; //医疗保险
            $excelLists[$num][19]           = $v['pension_ratio']; //养老保险
            $excelLists[$num][20]           = $v['unemployment']; //失业保险
            $excelLists[$num][21]           = $v['accumulation_fund']; //公积金
            $excelLists[$num][22]           = $v['insurance_Total']; //个人保险合计
            $excelLists[$num][23]           = $v['specialdeduction']; //专项附加扣除
            $excelLists[$num][24]           = $v['tax_counting']; //计税工资
            $excelLists[$num][25]           = $v['personal_tax']; //个人所得税
            $excelLists[$num][26]           = $v['summoney']; //税后扣款
            $excelLists[$num][27]           = $v['Labour']?$v['Labour']:'0.00'; //工会会费
            $excelLists[$num][28]           = $v['real_wages']; //实发工资
            $num++;
        }

        foreach ($departmentWagesLists as $v){ //部门合计
            $department_insurance_data      = $mod->get_department_insurance_data($account_ids,$v['department'],$account_wages_list);
            $excelLists[$num][0]            = $v['name'];
            $excelLists[$num][1]            = '';
            $excelLists[$num][2]            = '';
            $excelLists[$num][3]            = $v['department'];
            $excelLists[$num][4]            = '';
            $excelLists[$num][5]            = '';
            $excelLists[$num][6]            = $v['standard'];
            $excelLists[$num][7]            = $v['basic_salary']; //基本工资
            $excelLists[$num][8]            = $v['withdrawing']; //考勤扣款
            $excelLists[$num][9]            = $v['performance_salary']; //绩效工资
            $excelLists[$num][10]           = $v['Achievements_withdrawing']; //绩效增减
            $excelLists[$num][11]           = $department_insurance_data['company_cost']; //公司五险一金(部门合计)
            $excelLists[$num][12]           = $v['Subsidy']; //带团补助
            $excelLists[$num][13]           = $v['total']; //业绩提成
            $excelLists[$num][14]           = $v['bonus'] + $v['welfare']?$v['bonus'] + $v['welfare']:'0.00'; //奖金
            $excelLists[$num][15]           = $v['housing_subsidy']; //住房补贴
            $excelLists[$num][16]           = $v['Other']; //其他补款
            $excelLists[$num][17]           = $v['Should_distributed']; //应发工资
            $excelLists[$num][18]           = $v['medical_care']; //医疗保险
            $excelLists[$num][19]           = $v['pension_ratio']; //养老保险
            $excelLists[$num][20]           = $v['unemployment']; //失业保险
            $excelLists[$num][21]           = $v['accumulation_fund']; //公积金
            $excelLists[$num][22]           = $v['insurance_Total']; //个人保险合计
            $excelLists[$num][23]           = $v['specialdeduction']; //专项附加扣除
            $excelLists[$num][24]           = $v['tax_counting']; //计税工资
            $excelLists[$num][25]           = $v['personal_tax']; //个人所得税
            $excelLists[$num][26]           = $v['summoney']; //税后扣款
            $excelLists[$num][27]           = $v['Labour']; //工会会费
            $excelLists[$num][28]           = $v['real_wages']; //实发工资
            $num++;
        }

        //公司合计
        $excelLists[$num][0]            = $companyWagesLists['name'];
        $excelLists[$num][1]            = '';
        $excelLists[$num][2]            = '';
        $excelLists[$num][3]            = '';
        $excelLists[$num][4]            = '';
        $excelLists[$num][5]            = '';
        $excelLists[$num][6]            = $companyWagesLists['standard'];
        $excelLists[$num][7]            = $companyWagesLists['basic_salary']; //基本工资
        $excelLists[$num][8]            = $companyWagesLists['withdrawing']; //考勤扣款
        $excelLists[$num][9]            = $companyWagesLists['performance_salary']; //绩效工资
        $excelLists[$num][10]           = $companyWagesLists['Achievements_withdrawing']; //绩效增减
        $excelLists[$num][11]           = $company_insurance_data; //公司五险一金(部门合计)
        $excelLists[$num][12]           = $companyWagesLists['Subsidy']; //带团补助
        $excelLists[$num][13]           = $companyWagesLists['total']; //业绩提成
        $excelLists[$num][14]           = $companyWagesLists['bonus'] + $companyWagesLists['welfare']?$companyWagesLists['bonus'] + $companyWagesLists['welfare']:'0.00'; //奖金
        $excelLists[$num][15]           = $companyWagesLists['housing_subsidy']; //住房补贴
        $excelLists[$num][16]           = $companyWagesLists['Other']; //其他补款
        $excelLists[$num][17]           = $companyWagesLists['Should_distributed']; //应发工资
        $excelLists[$num][18]           = $companyWagesLists['medical_care']; //医疗保险
        $excelLists[$num][19]           = $companyWagesLists['pension_ratio']; //养老保险
        $excelLists[$num][20]           = $companyWagesLists['unemployment']; //失业保险
        $excelLists[$num][21]           = $companyWagesLists['accumulation_fund']; //公积金
        $excelLists[$num][22]           = $companyWagesLists['insurance_Total']; //个人保险合计
        $excelLists[$num][23]           = $companyWagesLists['specialdeduction']; //专项附加扣除
        $excelLists[$num][24]           = $companyWagesLists['tax_counting']; //计税工资
        $excelLists[$num][25]           = $companyWagesLists['personal_tax']; //个人所得税
        $excelLists[$num][26]           = $companyWagesLists['summoney']; //税后扣款
        $excelLists[$num][27]           = $companyWagesLists['Labour']; //工会会费
        $excelLists[$num][28]           = $companyWagesLists['real_wages']; //实发工资
        $num++;

        //表底
        $excelLists[$num][0]            = '';
        $excelLists[$num][1]            = '';
        $excelLists[$num][2]            = '';
        $excelLists[$num][3]            = '制表人：'.session('name');
        $excelLists[$num][4]            = '';
        $excelLists[$num][5]            = '';
        $excelLists[$num][6]            = '';
        $excelLists[$num][7]            = '制表时间'.date("Y-m-d");
        $excelLists[$num][8]            = '';
        $excelLists[$num][9]            = '';
        $excelLists[$num][10]           = '';
        $excelLists[$num][11]           = '';
        $excelLists[$num][12]           = '';
        $excelLists[$num][13]           = '';
        $excelLists[$num][14]           = '';
        $excelLists[$num][15]           = '';
        $excelLists[$num][16]           = '';
        $excelLists[$num][17]           = '';
        $excelLists[$num][18]           = '';
        $excelLists[$num][19]           = '';
        $excelLists[$num][20]           = '';
        $excelLists[$num][21]           = '';
        $excelLists[$num][22]           = '';
        $excelLists[$num][23]           = '';
        $excelLists[$num][24]           = '';
        $excelLists[$num][25]           = '';
        $excelLists[$num][26]           = '';
        $excelLists[$num][27]           = '';
        $excelLists[$num][28]           = '';

        $title                          = array('ID','员工姓名','岗位名称','所属部门','身份证号','工资卡号','岗位薪酬标准','其中基本工资标准','考勤扣款','其中绩效工资标准','绩效增减','公司五险一金','带团补助','业绩提成','奖金','住房补贴','其他补款','应发工资','医疗保险','养老保险','失业保险','公积金','个人保险合计','专项扣除','计税工资','个人所得税','税后扣款','工会会费','实发工资');
        exportexcel($excelLists,$title,$datetime.'月工资发放表');
    }

    //员工薪资详情
    public function salarydetails(){
        $id                                     = I('id');
        $mod                                    = D('Salary');
        $where                                  = array();
        $where['id']                            = $id;
        $userid                                 = session('userid');

        if (!in_array($userid,array(1,11,12,13,32,38,55,77,185,100,109))){
            $where['account_id']                = $userid;
        }
        $wages_list                             = M('salary_wages_month')->where($where)->find();
        if (!$wages_list) $this->error('获取数据失败');

        $account_list                           = M('account')->where(array('id'=>$wages_list['account_id']))->find();
        $salary_list                            = M('salary')->where(array('id'=>$wages_list['salary_id']))->find();
        $attendance_list                        = M('salary_attendance')->where(array('id'=>array('in',$wages_list['attendance_id'])))->find(); //考勤
        $bonus_list                             = M('salary_bonus')->where(array('id'=>array('in',$wages_list['bonus_id'])))->find(); //提成/奖金/年终奖
        $individual_tax_list                    = M('individual_tax')->where(array('id'=>array('in',$wages_list['individual_id'])))->find(); //个税
        $insurance_list                         = M('salary_insurance')->where(array('id'=>array('in',$wages_list['insurance_id'])))->find(); //五险一金
        $labour_list                            = M('salary_labour')->where(array('id'=>array('in',$wages_list['labour_id'])))->find(); //工会会费
        $specialdeduction_list                  = M('salary_specialdeduction')->where(array('id'=>array('in',$wages_list['specialdeduction_id'])))->find(); //专项附加扣除
        $subsidy_list                           = M('salary_subsidy')->where(array('id'=>array('in',$wages_list['subsidy_id'])))->find(); //补贴
        $income_list                            = M('salary_income')->where(array('income_token'=>array('in',$wages_list['income_token'])))->select(); //其他收入
        $withholding_list                       = M('salary_withholding')->where(array('token'=>array('in',$wages_list['withholding_token'])))->select(); //代扣代缴
        $salary                                 = M('salary')->where(array('account_id'=>$account_list['id']))->order('id desc')->find();
        $royalty                                = $mod->get_royalty($account_list,$wages_list['datetime'],$salary['standard_salary']); //目标,提成

        $this->pdca_id                          = M('pdca')->where(array('tab_user_id'=>$wages_list['account_id'],'month'=>$wages_list['datetime']))->getField('id');
        $this->department                       = M('salary_department')->getField('id,department',true);
        $this->wages_list                       = $wages_list; //当月工资信息
        $this->account_list                     = $account_list; //个人基本信息
        $this->salary_list                      = $salary_list; //基本工资信息
        $this->attendance_list                  = $attendance_list; //考勤
        $this->bonus_list                       = $bonus_list; //提成/奖金/年终奖
        $this->individual_tax_list              = $individual_tax_list; //个税
        $this->insurance_list                   = $insurance_list; //五险一金
        $this->labour_list                      = $labour_list; //工会会费
        $this->specialdeduction_list            = $specialdeduction_list; //专项附加扣除
        $this->subsidy_list                     = $subsidy_list; //补贴
        $this->income_list                      = $income_list;  //其他收入
        $this->withholding_list                 = $withholding_list; //代扣代缴
        $this->royalty                          = $royalty;
        $this->display();
    }

    //带团补助详情
    public function public_guide_pay_detail(){
        $uid                                    = I('uid');
        $yearMonth                              = I('ym');
        if ($uid && $yearMonth){
            $cycle                              = get_cycle($yearMonth);
            $guide_id                           = M('account')->where(array('id'=>$uid))->getField('guide_id');
            if ($guide_id){
                $where                          = array();
                $where['p.guide_id']              = $guide_id;
                $where['p.status']                = 2; //已完成
                $where['p.sure_time']             = array('between',array($cycle['begintime'],$cycle['endtime']));
                $lists                          = M()->table('__GUIDE_PAY__ as p')->join('__OP__ as o on o.op_id = p.op_id','left')->where($where)->field('p.*,o.group_id,o.project')->select();
            }
            $this->lists                        = $lists ? $lists : '';
            $this->display('guide_pay_detail');
        }else{
            $this->error('参数错误');
        }
    }

}
