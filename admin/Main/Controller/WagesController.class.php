<?php
    /**
     * Date: 2019/3/7
     * Time: 9:19
     */

    namespace Main\Controller;
    use Think\Controller;
    use Sys\P;
    ulib('Page');
    use Sys\Page;

    class WagesController extends Controller{

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
            $user_info['specialdeduction']          = M('salary_specialdeduction')->where(array('id'=>$user_info1['specialdeduction_id']))->find();//专项附加扣除
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
         * @salary_excel_sql
         * 获取详情数据表
         */
        private function salary_excel_sql_bak20190308($archives='',$name='',$datetime=""){
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
                $user                                   = $this->query_score($que);//绩效增减
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
                $user_info[$key]['yearend']             = D('Salary')->year_end_tax($Year_end,$user_info[$key]['bonus'][0]['year_end_tax']);//年终奖计税
                //其他补款 = 其他补贴变动 + 外地补贴 + 电脑补贴
                $user_info[$key]['Other']               = round(($countmoney+$user_info[$key]['subsidy'][0]['foreign_subsidies']+$user_info[$key]['subsidy'][0]['computer_subsidy']),2);
                // 提成 + 奖金+带团补助+年终奖+住房补贴+外地补贴+电脑补贴+提成
                $user_info[$key]['welfare']             = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$extract+$user_info[$key]['bonus'][0]['annual_bonus']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']),2);//提成补助奖金

                //应发工资 = 岗位工资-考勤扣款+绩效增减+季度提成+奖金+年终奖-年终奖计税+住房补贴+其他补款
                $user_info[$key]['Should']              = round(($user_info[$key]['bonus'][0]['foreign_bonus']+$user_info[$key]['salary'][0]['standard_salary']-$user_info[$key]['attendance'][0]['withdrawing']+$extract+$user_info[$key]['bonus'][0]['annual_bonus']-$user_info[$key]['yearend']+$user_info[$key]['subsidy'][0]['housing_subsidy']+$user_info[$key]['Other']+$user_info[$key]['Achievements']['count_money']),2);

                //计税工资 = 应该工资-五险一金 + 合并计税 - 专项附加扣除
                $user_info[$key]['tax_counting']        = round(($user_info[$key]['Should']-$user_info[$key]['insurance_Total']+$user_info[$key]['labour']['merge_counting'] /*- $user_info[$key]['specialdeduction']*/),2);//计税工资

                $counting                               = D('Salary')->individual_tax($user_info[$key]['tax_counting'],$val['id']);//个人所得税
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
                $info_user1[$key][21]       = sprintf("%.2f",$val['specialdeduction']);
                $info_user1[$key][22]       = sprintf("%.2f",$val['tax_counting']);
                $info_user1[$key][23]       = sprintf("%.2f",$val['personal_tax']);
                $info_user1[$key][24]       = sprintf("%.2f",$val['summoney']);
                $info_user1[$key][25]       = sprintf("%.2f",$val['labour']['Labour_money']);
                $info_user1[$key][26]       = sprintf("%.2f",$val['real_wages']);
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
                $info_user2[$key][21]       = sprintf("%.2f",$val['specialdeduction']);
                $info_user2[$key][22]       = sprintf("%.2f",$val['tax_counting']);
                $info_user2[$key][23]       = sprintf("%.2f",$val['personal_tax']);
                $info_user2[$key][24]       = sprintf("%.2f",$val['summoney']);
                $info_user2[$key][25]       = sprintf("%.2f",$val['Labour']);
                $info_user2[$key][26]       = sprintf("%.2f",$val['real_wages']);
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
            $info_user3[$key][21]           = sprintf("%.2f",$summoney['specialdeduction']);
            $info_user3[$key][22]           = sprintf("%.2f",$summoney['tax_counting']);
            $info_user3[$key][23]           = sprintf("%.2f",$summoney['personal_tax']);
            $info_user3[$key][24]           = sprintf("%.2f",$summoney['summoney']);
            $info_user3[$key][25]           = sprintf("%.2f",$summoney['Labour']);
            $info_user3[$key][26]           = sprintf("%.2f",$summoney['real_wages']);
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
            $Excel_data[1]                  = array('1'=>'ID','2'=>'员工姓名','3'=>'岗位名称','4'=>'所属部门','5'=>'身份证号','6'=>'工资卡号','7'=>'岗位薪酬标准','8'=>'其中基本工资标准','9'=>'考勤扣款','10'=>'其中绩效工资标准','11'=>'绩效增减','12'=>'业绩提成','13'=>'奖金','14'=>'住房补贴','15'=>'其他补款','16'=>'应发工资','17'=>'医疗保险','18'=>'养老保险','19'=>'失业保险','20'=>'公积金','21'=>'个人保险合计','22'=>'专项扣除','23'=>'计税工资','24'=>'个人所得税','25'=>'税后扣款','26'=>'工会会费','27'=>'实发工资');

            $Excel_content                  = array_merge($Excel_data,$info_user1,$info_user2,$info_user3,$Approver);
            exportexcel($Excel_content,$setTitle,$setTitle);
        }



        /***************************************************************************************************************************/
        /***************************************************************************************************************************/
        /***************************************************************************************************************************/
        /***************************************************************************************************************************/

        //薪资首页
        public function index(){
            $name                                   = I('name')?trim(I('name')):'';
            $id                                     = I('id')?trim(I('id')):'';
            $department                             = I('department')?trim(I('department')):'';
            $month                                  = I('month')?trim(I('month')):'';
            $userid                                 = session('userid');

            $where                                  = array();
            $where['status']                        = 4;
            if ($name) $where['user_name']          = $name;
            if ($id) $where['account_id']           = $id;
            if ($department) $where['department']   = $department;
            if ($month) $where['datetime']          = $month;

            if (in_array($userid,array(1,11,12,32,38,55,77,185))){

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
            $mod                                = D('Wages');
            $datetime                           = I('datetime')?trim(I('datetime')):date('Ym');
            $name                               = I('name')?trim(I('name')):'';
            $archives                           = I('archives')?I('archives'):0;

            $wage                               = array();
            $wage['s.datetime']                 = $datetime;
            if ($name) $wage['a.user_name']     = array('eq',$name);
            if ($archives) $wage['a.archives']  = $archives;
            $wagesLists                         = M()->table('__SALARY_WAGES_MONTH__ as s')->join('__ACCOUNT__ as a on a.id=s.account_id','left')->where($wage)->select();

           /* if ($wagesLists){
                //$info                           = $mod->history_wages($wagesLists);
                $info                           = $this->arraysplit($wagesLists);
            }else{*/
                $where                          = array();
                $where['status']                = array('neq',2);   //未删除
                $where['id']                    = array('gt',10);
                //if ($name) $where['nickname']   = array('like','%'.$name.'%');
                //if ($archives)$where['archives']= $archives;

                //$where['id']                    = 11;

                $accounts                       = M('account')->where($where)->select();
                $personWagesLists               = $this-> get_person_wages_lists($accounts,$datetime); //获取员工个人薪资信息
                $departmentWagesLists           = $this->get_department_wagesList($personWagesLists); //部门合计
                $companyWagesLists              = $this->get_company_wages($personWagesLists); //公司合计

           /* }*/

            $this->personWagesLists             = $personWagesLists;
            $this->departmentWagesLists         = $departmentWagesLists;
            $this->companyWagesLists            = $companyWagesLists;
            $this->info                         = $info;
            $this->datetime                     = $datetime;
            $this->archives                     = $archives?$archives:0;
            $this->display();
        }

        /**
         * 获取员工个人薪资信息
         * @param $accounts
         * @param $datetime
         * @return array
         */
        public function get_person_wages_lists($accounts,$datetime){
            $mod                                = D('Wages');
            $month                              = substr($datetime,4,2);
            $royalty_months                     = array('01','04','07','10'); //业绩提成发放月份
            $departments                        = M('salary_department')->getField('id,department',true); //部门
            $posts                              = M('posts')->getField('id,post_name',true);

            $data                               = array();
            foreach ($accounts as $k=>$v){
                $data[$k]['account_id']         = $v['id'];
                $data[$k]['user_name']          = $v['nickname'];
                //$data[$k]['departmentid']       = $v['departmentid'];
                $data[$k]['department']         = $departments[$v['departmentid']];
                $data[$k]['post_name']          = $posts[$v['postid']];
                $data[$k]['datetime']           = $datetime;
                $salary                         = M('salary')->where(array('account_id'=>$v['id']))->order('id desc')->find();
                $data[$k]['salary_id']          = $salary['id'];
                $data[$k]['standard']           = $salary['standard_salary'];   //岗位薪酬
                $data[$k]['basic_salary']       = ($salary['standard_salary']/10)*$salary['basic_salary']; //基本工资
                $attendance_list                = M('salary_attendance')->where(array('account_id'=>$v['id'],'status'=>1))->order('id desc')->find();//员工考勤信息
                $data[$k]['attendance_id']      = $attendance_list['id'];
                $data[$k]['withdrawing']        = $attendance_list['withdrawing']?$attendance_list['withdrawing']:'0.00';//考勤扣款
                $data[$k]['performance_salary'] = ($salary['standard_salary']/10)*$salary['performance_salary']; //岗位绩效工资
                $kpi_pdca_score                 = $this->get_kpi_salary($v,$salary,$datetime); //绩效得分
                $data[$k]['Achievements_withdrawing']= $kpi_pdca_score['count_money']; //绩效增减
                $op_guide_info                  = $mod->get_op_guide($v,$datetime); //带团补助信息
                $data[$k]['Subsidy']            = $op_guide_info['guide_salary']?$op_guide_info['guide_salary']:'0.00'; //带团补助金额
                $quarter_royalty_data           = $mod->get_royalty($v,$datetime,$salary['standard_salary']); //季度毛利,季度目标,季度提成
                $data[$k]['target']             = $quarter_royalty_data['target']; //季度目标
                $data[$k]['complete']           = $quarter_royalty_data['quarter_profit']; //季度毛利(完成值)

                $salary_bonus_list              = M('salary_bonus')->where(array('account_id'=>$v['id'],'status'=>1))->order('id desc')->find(); //其他人员提成 奖金 年终奖
                $data[$k]['bonus_id']           = $salary_bonus_list['id'];
                $royalty                        = $quarter_royalty_data['quarter_royalty'] + $salary_bonus_list['bonus']; //提成 : 业务人员季度提成(自动取值) + 其他人员提成(手动录入)
                $data[$k]['total']              = $royalty?$royalty:'0.00'; //总业绩提成

                $data[$k]['welfare']            = $salary_bonus_list['annual_bonus']?$salary_bonus_list['annual_bonus']:'0.00'; //年终奖
                $data[$k]['bonus']              = $salary_bonus_list['foreign_bonus']?$salary_bonus_list['foreign_bonus']:'0.00'; //奖金
                $data[$k]['yearend']            = $salary_bonus_list['year_end_tax']; //年终奖计税
                $other_income                   = $this->get_other_income($v['id']); //其他收入变动(差额补)
                $data[$k]['income_token']       = $other_income['income_token']; //其他收入变动token

                $salary_subsidy_list            = M('salary_subsidy')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //补贴(住房补贴,外地补贴,电脑补贴)
                $data[$k]['subsidy_id']         = $salary_subsidy_list['id']; //补贴id
                $data[$k]['housing_subsidy']    = $salary_subsidy_list['housing_subsidy']?$salary_subsidy_list['housing_subsidy']:'0.00';  //住房补贴
                $other                          = $salary_subsidy_list['foreign_subsidies']+$salary_subsidy_list['computer_subsidy'] + $other_income['income_money'];
                $data[$k]['Other']              = $other?$other:'0.00'; //其他补款(外地补贴+电脑补贴+其他收入变动(补差额))
                //应发工资 = (基本工资 - 考勤扣款) + (绩效工资 - 绩效增减) + 业绩提成 + 带团补助 + 奖金 + 年终奖 + 住房补贴 + 其他补款;
                $data[$k]['Should_distributed'] = ($data[$k]['basic_salary'] - $data[$k]['withdrawing']) + ($data[$k]['performance_salary'] + $data[$k]['Achievements_withdrawing']) + $data[$k]['total'] + $data[$k]['Subsidy'] + $data[$k]['bonus'] + $data[$k]['welfare'] + $data[$k]['housing_subsidy'] + $data[$k]['Other']; //应发工资 = (基本工资 - 考勤扣款) + (绩效工资标准-绩效增减)+业绩提成+带团补助+ 奖金+年终奖+住房补贴+其他补款
                $salary_insurance_list          = M('salary_insurance')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //五险一金
                $data[$k]['insurance_id']       = $salary_insurance_list['id'];
                $data[$k]['medical_care']       = round($salary_insurance_list['medical_care_base']*$salary_insurance_list['medical_care_ratio'],2); //医疗保险个人
                $data[$k]['pension_ratio']      = round($salary_insurance_list['pension_base']*$salary_insurance_list['pension_ratio'],2);  //养老保险个人
                $data[$k]['unemployment']       = round($salary_insurance_list['unemployment_base']*$salary_insurance_list['unemployment_ratio'],2);  //失业保险个人
                $data[$k]['accumulation_fund']  = round($salary_insurance_list['accumulation_fund_base']*$salary_insurance_list['accumulation_fund_ratio']);  //公积金个人(不保留小数)
                $data[$k]['insurance_Total']    = $data[$k]['medical_care'] + $data[$k]['pension_ratio'] + $data[$k]['unemployment'] + $data[$k]['accumulation_fund']; //个人保险合计
                $specialdeduction_list          = M('salary_specialdeduction')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //专项附加扣除
                $specialdeduction               = round($specialdeduction_list['children_education'] + $specialdeduction_list['continue_education'] + $specialdeduction_list['health'] + $specialdeduction_list['buy_house'] + $specialdeduction_list['rent_house'] + $specialdeduction_list['support_older'],2); //专项附加扣除合计
                $data[$k]['specialdeduction']   = $specialdeduction?$specialdeduction:'0.00'; //专项附加扣除合计
                $data[$k]['specialdeduction_id']= $specialdeduction_list['id'];
                //本月计税工资 = (应发工资 - 个人保险合计 - 专项附加扣除 - 个人免征额) + [其他补助(差额补)]
                $data[$k]['tax_counting']       = round(($data[$k]['Should_distributed'] - $data[$k]['insurance_Total'] - $data[$k]['specialdeduction'] - 5000) + $data[$k]['Other'],2); //本月计税工资 = (应发工资 - 个人保险合计 - 专项附加扣除 - 个人免征额5000) + [其他补助(差额补)]
                $personal_tax                   = $this->get_personal_income_tax($v['id']); //个人所得税
                $data[$k]['personal_tax']       = $personal_tax?$personal_tax:'0.00'; //个人所得税
                $labour_list                    = M('salary_labour')->where(array('account_id'=>$v['id']))->order('id desc')->find(); //工会会费信息
                $data[$k]['Labour']             = $labour_list['Labour_money']; //工会会费
                $data[$k]['labour_id']          = $labour_list['id'];
                $withholding                    = $this->get_withholding($v['id']); //代扣代缴
                $data[$k]['withholding_token']  = $withholding['token']; //代扣代缴token
                $data[$k]['summoney']           = $withholding['money']?$withholding['money']:'0.00'; //代扣代缴(税后扣款)

                //实发工资 = 应发工资 - 个人保险合计 - 年终奖个税 - 税后扣款 - 工会会费 - 代扣代缴;
                $data[$k]['real_wages']         = $data[$k]['Should_distributed'] - $data[$k]['insurance_Total'] - $data[$k]['yearend'] - $data[$k]['after_text_money'] - $data[$k]['labour'] - $data[$k]['summoney'];
                $data[$k]['total_score_show']   = $kpi_pdca_score['sum_kpi_score']; //KPI分数
                $data[$k]['sum_total_score']    = $kpi_pdca_score['total_pdca_score']; //pdca分数
                $data[$k]['show_qa_score']      = $kpi_pdca_score['show_qa_score']; //品质检查分数
            }
            return $data;
        }

        /**
         * 获取部门合计
         * @param $lists
         */
        public function get_department_wagesList($lists){
            $departments                                        = array_filter(array_unique(array_column($lists,'department')));
            $data                                               = array();
            foreach ($departments as $key=>$value){
                $data[$key]['department']                       = 0;
                $data[$key]['standard']                         = 0;
                $data[$key]['basic_salary']                     = 0;
                $data[$key]['withdrawing']                      = 0;
                $data[$key]['performance_salary']               = 0;
                $data[$key]['Achievements_withdrawing']         = 0;
                $data[$key]['Subsidy']                          = 0;
                $data[$key]['target']                           = 0;
                $data[$key]['complete']                         = 0;
                $data[$key]['total']                            = 0;
                $data[$key]['welfare']                          = 0;
                $data[$key]['bonus']                            = 0;
                $data[$key]['yearend']                          = 0;
                $data[$key]['housing_subsidy']                  = 0;
                $data[$key]['Other']                            = 0;
                $data[$key]['Should_distributed']               = 0;
                $data[$key]['medical_care']                     = 0;
                $data[$key]['pension_ratio']                    = 0;
                $data[$key]['unemployment']                     = 0;
                $data[$key]['accumulation_fund']                = 0;
                $data[$key]['insurance_Total']                  = 0;
                $data[$key]['specialdeduction']                 = 0;
                $data[$key]['tax_counting']                     = 0;
                $data[$key]['personal_tax']                     = 0;
                $data[$key]['Labour']                           = 0;
                $data[$key]['summoney']                         = 0;
                $data[$key]['real_wages']                       = 0;
                foreach ($lists as $k=>$v) {
                    if ($v['department'] == $value) {
                        $data[$key]['department']               = $value;
                        $data[$key]['standard']                 += $v['standard'];
                        $data[$key]['basic_salary']             += $v['basic_salary'];
                        $data[$key]['withdrawing']              += $v['withdrawing'];
                        $data[$key]['performance_salary']       += $v['performance_salary'];
                        $data[$key]['Achievements_withdrawing'] += $v['Achievements_withdrawing'];
                        $data[$key]['Subsidy']                  += $v['Subsidy'];
                        $data[$key]['target']                   += $v['target'];
                        $data[$key]['complete']                 += $v['complete'];
                        $data[$key]['total']                    += $v['total'];
                        $data[$key]['welfare']                  += $v['welfare'];
                        $data[$key]['bonus']                    += $v['bonus'];
                        $data[$key]['yearend']                  += $v['yearend'];
                        $data[$key]['housing_subsidy']          += $v['housing_subsidy'];
                        $data[$key]['Other']                    += $v['Other'];
                        $data[$key]['Should_distributed']       += $v['Should_distributed'];
                        $data[$key]['medical_care']             += $v['medical_care'];
                        $data[$key]['pension_ratio']            += $v['pension_ratio'];
                        $data[$key]['unemployment']             += $v['unemployment'];
                        $data[$key]['accumulation_fund']        += $v['accumulation_fund'];
                        $data[$key]['insurance_Total']          += $v['insurance_Total'];
                        $data[$key]['specialdeduction']         += $v['specialdeduction'];
                        $data[$key]['tax_counting']             += $v['tax_counting'];
                        $data[$key]['personal_tax']             += $v['personal_tax'];
                        $data[$key]['Labour']                   += $v['Labour'];
                        $data[$key]['summoney']                 += $v['summoney'];
                        $data[$key]['real_wages']               += $v['real_wages'];
                    }
                }
            }
            return $data;
        }

        public function get_company_wages($lists){
            $data                                               = array();
            $data['standard']                                   = 0;
            $data['basic_salary']                               = 0;
            $data['withdrawing']                                = 0;
            $data['performance_salary']                         = 0;
            $data['Achievements_withdrawing']                   = 0;
            $data['Subsidy']                                    = 0;
            $data['target']                                     = 0;
            $data['complete']                                   = 0;
            $data['total']                                      = 0;
            $data['welfare']                                    = 0;
            $data['bonus']                                      = 0;
            $data['yearend']                                    = 0;
            $data['housing_subsidy']                            = 0;
            $data['Other']                                      = 0;
            $data['Should_distributed']                         = 0;
            $data['medical_care']                               = 0;
            $data['pension_ratio']                              = 0;
            $data['unemployment']                               = 0;
            $data['accumulation_fund']                          = 0;
            $data['insurance_Total']                            = 0;
            $data['specialdeduction']                           = 0;
            $data['tax_counting']                               = 0;
            $data['personal_tax']                               = 0;
            $data['Labour']                                     = 0;
            $data['summoney']                                   = 0;
            $data['real_wages']                                 = 0;
            foreach ($lists as $k=>$v) {
                $data['standard']                               += $v['standard'];
                $data['basic_salary']                           += $v['basic_salary'];
                $data['withdrawing']                            += $v['withdrawing'];
                $data['performance_salary']                     += $v['performance_salary'];
                $data['Achievements_withdrawing']               += $v['Achievements_withdrawing'];
                $data['Subsidy']                                += $v['Subsidy'];
                $data['target']                                 += $v['target'];
                $data['complete']                               += $v['complete'];
                $data['total']                                  += $v['total'];
                $data['welfare']                                += $v['welfare'];
                $data['bonus']                                  += $v['bonus'];
                $data['yearend']                                += $v['yearend'];
                $data['housing_subsidy']                        += $v['housing_subsidy'];
                $data['Other']                                  += $v['Other'];
                $data['Should_distributed']                     += $v['Should_distributed'];
                $data['medical_care']                           += $v['medical_care'];
                $data['pension_ratio']                          += $v['pension_ratio'];
                $data['unemployment']                           += $v['unemployment'];
                $data['accumulation_fund']                      += $v['accumulation_fund'];
                $data['insurance_Total']                        += $v['insurance_Total'];
                $data['specialdeduction']                       += $v['specialdeduction'];
                $data['tax_counting']                           += $v['tax_counting'];
                $data['personal_tax']                           += $v['personal_tax'];
                $data['Labour']                                 += $v['Labour'];
                $data['summoney']                               += $v['summoney'];
                $data['real_wages']                             += $v['real_wages'];
            }
            return $data;
        }

        public function get_withholding($userid){
            $lists                  = M('salary_withholding')->where(array('account_id'=>$userid,'status'=>1))->order('id desc')->select();
            $data                   = array();
            $data['money']          = array_sum(array_column($lists,'money'));
            $data['token']          = $lists[0]['token'];
            $data['lists']          = $lists;
            return $data;
        }

        /**
         * 获取其他收入(补差额)
         * @param $userid
         * @return array
         */
        public function get_other_income($userid){
            $lists                  = M('salary_income')->where(array('account_id'=>$userid,'status'=>1))->order('id desc')->select();
            $data                   = array();
            $data['income_money']   = array_sum(array_column($lists,'income_money'));
            $data['income_token']   = $lists[0]['income_token'];
            $data['lists']          = $lists;
            return $data;
        }

        //个人所得税(已手动录入的话取手动录入的值 ,无手动录入则套用计算公式)
        public function get_personal_income_tax($userid){
            $list                   = M('salary_individual_tax')->where(array('account_id'=>$userid,'statu'=>1))->order('id desc')->find();
            $personal_tax           = $list['individual_tax']?$list['individual_tax']:'0'; //注意后期添加计税公式
            return $personal_tax;
        }

        /**
         * 获取KPI pdca 品质检查 得分及工资增减信息
         * @param $userinfo
         * @param $salary
         * @param $datetime
         * @return mixed
         */
        public function get_kpi_salary($userinfo,$salary,$datetime){
            // kpi  pdca 品质检查
            $que['p.tab_user_id']                   = $userinfo['id'];//用户id
            $que['p.month']                         = datetime(date('Y'),date('m'),date('d'),1);
            $user                                   = $this->query_score($que);//绩效增减
            $use1                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['total_score_show']));//PDCA
            $use2                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','<span class="green">','+'),"",$user[0]['show_qa_score']));//品质检查
            $use3                                   = trim(str_replace(array('<font color="#999999">','</font>','无加扣分','<span class="red">','</span>','<span>','<font color="#ff9900">','未完成评分','+'),"",$user[0]['total_kpi_score']));//KPI
            $money                                  = ($salary['standard_salary']/10)*$salary['performance_salary'];//绩效金额
            $base_money                             = ($salary['standard_salary']/10)*$salary['basic_salary'];    //基本工资
            $branch                                 = 100;//给总共100分

            if($userinfo['formal']==0 || $userinfo['formal']==4) {$use3 = 0;} //排除试用期和实习期
            $f      = $use2+$use3;//获得总分    品质检查+kpi从绩效工资取值
            $fpdca  = $use1;

            //kpi季度考核的人员,从2019年开始实施下个季度从上个季度取值,第一季度均默认不扣KPI
            if (in_array($datetime,array('201901','201902','201903')) && in_array($userinfo['id'],C('KPI_QUARTER'))){
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

            $user_info['count_money']         = $balance1 + $balance2;
            $user_info['total_pdca_score']    = $use1;//pdca分数
            $user_info['show_qa_score']       = $use2;//品质检查分数
            $user_info['sum_kpi_score']       = $use3;//KPI分数
            return $user_info;
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





    }