<?php
/**
 * Date: 2018/12/4
 * Time: 11:14
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class ChartModel extends Model
{

    /**
     * 已结算分部门汇总
     * 1.部门信息(array)
     * 2.年月Ym
     * 3.年份时间戳(array)
     * 4.状态 0=>预算及结算; 1=>结算
     */
    public function js_deplist($userlists, $month, $yeartimes, $pin = 0)
    {

        $monthtime = intval($month);
        $month = get_cycle($monthtime, 26);
        $lists = array();
        foreach ($userlists as $k => $v) {
            //年度累计
            $where = array();
            $where['b.audit_status'] = 1;
            $where['l.req_type'] = 801;
            $where['l.audit_time'] = array('between', "$yeartimes[yearBeginTime],$yeartimes[yearEndTime]");
            $where['a.id'] = array('in', $v['users']);

            $field = array();
            $field[] = 'count(o.id) as xms';
            $field[] = 'sum(c.num_adult) as renshu';
            $field[] = 'sum(b.shouru) as zsr';
            $field[] = 'sum(b.maoli) as zml';
            $field[] = '(sum(b.maoli)/sum(b.shouru)) as mll';

            $yearlist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();
            $lists[$v['id']]['yearxms'] = $yearlist['xms'] ? $yearlist['xms'] : 0;
            $lists[$v['id']]['yearrenshu'] = $yearlist['renshu'] ? $yearlist['renshu'] : 0;
            $lists[$v['id']]['yearzsr'] = $yearlist['zsr'] ? $yearlist['zsr'] : "0.00";
            $lists[$v['id']]['yearzml'] = $yearlist['zml'] ? $yearlist['zml'] : "0.00";
            $lists[$v['id']]['yearmll'] = $yearlist['mll'] ? sprintf("%.2f", $yearlist['mll'] * 100) : "0.00";

            //查询月度
            $where = array();
            $where['b.audit_status'] = 1;
            $where['l.req_type'] = 801;
            $where['l.audit_time'] = array('between', "$month[begintime],$month[endtime]");
            $where['a.id'] = array('in', $v['users']);

            $field = array();
            $field[] = 'count(o.id) as xms';
            $field[] = 'sum(c.num_adult) as renshu';
            $field[] = 'sum(b.shouru) as zsr';
            $field[] = 'sum(b.maoli) as zml';
            $field[] = '(sum(b.maoli)/sum(b.shouru)) as mll';

            $monthlist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();

            $lists[$v['id']]['monthxms'] = $monthlist['xms'] ? $monthlist['xms'] : 0;
            $lists[$v['id']]['monthrenshu'] = $monthlist['renshu'] ? $monthlist['renshu'] : 0;
            $lists[$v['id']]['monthzsr'] = $monthlist['zsr'] ? $monthlist['zsr'] : "0.00";
            $lists[$v['id']]['monthzml'] = $monthlist['zml'] ? $monthlist['zml'] : "0.00";
            $lists[$v['id']]['monthmll'] = $monthlist['mll'] ? sprintf("%.2f", $monthlist['mll'] * 100) : "0.00";
            $lists[$v['id']]['users'] = $v['users'];
            $lists[$v['id']]['id'] = $v['id'];
            $lists[$v['id']]['depname'] = $v['depname'];
        }
        $heji = array();
        $heji['yearxms'] = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu'] = array_sum(array_column($lists, 'yearrenshu'));
        $heji['yearzsr'] = array_sum(array_column($lists, 'yearzsr'));
        $heji['yearzml'] = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll'] = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $heji['monthxms'] = array_sum(array_column($lists, 'monthxms'));
        $heji['monthrenshu'] = array_sum(array_column($lists, 'monthrenshu'));
        $heji['monthzsr'] = array_sum(array_column($lists, 'monthzsr'));
        $heji['monthzml'] = array_sum(array_column($lists, 'monthzml'));
        $heji['monthmll'] = sprintf("%.2f", ($heji['monthzml'] / $heji['monthzsr']) * 100);
        $lists['heji'] = $heji;
        return $lists;
    }

    /**
     * 获取某个时间段结算项目
     * @param 用户 (array)
     * @param 开始时间
     * @param 结束时间
     * @param 类型(800=>预算 , 801=>结算)
     * @return mixed
     */
    function get_js_opids($users, $begintime, $endtime, $req_type = 801)
    {
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        $where['a.id'] = array('in', $users);
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**从工资表获取部门每个月及全年人员信息
     * @param $depart
     * @param $year
     * @return array
     */
    function getMonthUser($depart,$yearMonth){
        //上个月人员信息
        $lastMonthUser              = M('salary_wages_month')->where(array('datetime'=>$yearMonth,'department'=>$depart['department']))->getField('account_id,user_name',true);    //从工资表获取累计人数
        $sumMonth                   = count($lastMonthUser);
        //全年人员信息
        $months                     = $this->getYearMonth($yearMonth);
        $year                       = substr($yearMonth,0,4);
        $yearUser                   = M('salary_wages_month')->field('account_id,user_name,datetime')->where(array('datetime'=>array('in',$months),'department'=>$depart['department']))->select();    //从工资表获取累计人数
        $countMonth                 = count(array_unique(array_column($yearUser,'datetime')));
        $sumYearUser                = count($yearUser);         //年总人数
        $sumYear                    = $sumYearUser/$countMonth; //年平均人数
        $data                       = array();
        $data[$yearMonth]['users']  = $lastMonthUser;
        $data[$yearMonth]['sumMonth'] = $sumMonth;
        $data['yearUser']           = $yearUser;
        $data['sumYear']            = $sumYear;
        return $data;
    }

    /**
     * 获取本周期年内的月份(上一年12月至本年11月)
     * @param $yearMonth
     * @return array
     */
    function getYearMonth($yearMonth){
        $year                       = substr($yearMonth,0,4);
        $month                      = substr($yearMonth,4,2);
        $month_arr                  = array();
        if ($month == 12){
            $month_arr[]            = $yearMonth;
            $y                      = $year+1;
            for ($n=1;$n<12;$n++){
                $m                  = str_pad($n,2,"0",STR_PAD_LEFT);
                $ym                 = $y.$m;
                $month_arr[]        = $ym;
            }
        }else{
            $y                      = $year;
            for ($n=1;$n<12;$n++){
                $m                  = str_pad($n,2,"0",STR_PAD_LEFT);
                $ym                 = $y.$m;
                $month_arr[]        = $ym;
            }
            $lym                    = ($year-1).'12';   //上一年的12月份
            $month_arr[]            = $lym;
        }
        return $month_arr;
    }

    /**
     * 获取某个时间段结算项目
     * @param 用户 (array)
     * @param 开始时间
     * @param 结束时间
     * @param 类型(800=>预算 , 801=>结算)
     * @return mixed
     */
    function get_ys_opids($users, $begintime, $endtime, $req_type = 800)
    {
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        $where['a.id'] = array('in', $users);
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * 预算结算部门数据
     * @param array 相关部门及人员信息
     * @param 月份 200808
     * @param array 当年开始及结束时间
     * @return array
     */
    public function ysjs_deplist($userlists, $month, $yeartimes)
    {
        //年累计
        $yearbegintime = $yeartimes['yearBeginTime'];
        $yearendtime = $yeartimes['yearEndTime'];
        $monthtime = intval($month);
        $month = get_cycle($monthtime, 26);
        foreach ($userlists as $k => $v) {
            //年累计
            //年度预算的团
            $req_type = 800;
            $ysopids = $this->get_ys_opids($v['users'], $yearbegintime, $yearendtime, $req_type);
            $ysopids = array_column($ysopids, 'op_id');

            //年度结算的团
            $req_type = 801;
            $jsopids = $this->get_js_opids($v['users'], $yearbegintime, $yearendtime, $req_type);
            $jsopids = array_column($jsopids, 'op_id');

            //年度数据
            $yeardata = $this->get_ysjshz($ysopids, $jsopids);
            $yearxms = $yeardata['xms'];
            $yearrenshu = $yeardata['renshu'];
            $yearzsr = $yeardata['zsr'];
            $yearzml = $yeardata['zml'];
            $yearmll = $yeardata['mll'];

            $lists[$v['id']]['yearxms'] = $yearxms ? $yearxms : 0;
            $lists[$v['id']]['yearrenshu'] = $yearrenshu ? $yearrenshu : 0;
            $lists[$v['id']]['yearzsr'] = $yearzsr ? $yearzsr : "0.00";
            $lists[$v['id']]['yearzml'] = $yearzml ? $yearzml : "0.00";
            $lists[$v['id']]['yearmll'] = $yearmll ? sprintf("%.2f", $yearmll * 100) : "0.00";

            //月累计
            //月度预算的团
            $req_type = 800;
            $monthysopids = $this->get_ys_opids($v['users'], $month['begintime'], $month['endtime'], $req_type);
            $monthysopids = array_column($monthysopids, 'op_id');

            //月度结算的团
            $req_type = 801;
            $monthjsopids = $this->get_js_opids($v['users'], $month['begintime'], $month['endtime'], $req_type);
            $monthjsopids = array_column($monthjsopids, 'op_id');

            //月度数据
            $monthdata = $this->get_ysjshz($monthysopids, $monthjsopids);
            $monthxms = $monthdata['xms'];
            $monthrenshu = $monthdata['renshu'];
            $monthzsr = $monthdata['zsr'];
            $monthzml = $monthdata['zml'];
            $monthmll = $monthdata['mll'];

            $lists[$v['id']]['monthxms'] = $monthxms ? $monthxms : 0;
            $lists[$v['id']]['monthrenshu'] = $monthrenshu ? $monthrenshu : 0;
            $lists[$v['id']]['monthzsr'] = $monthzsr ? $monthzsr : "0.00";
            $lists[$v['id']]['monthzml'] = $monthzml ? $monthzml : "0.00";
            $lists[$v['id']]['monthmll'] = $monthmll ? sprintf("%.2f", $monthmll * 100) : "0.00";
            $lists[$v['id']]['users'] = $v['users'];
            $lists[$v['id']]['id'] = $v['id'];
            $lists[$v['id']]['depname'] = $v['depname'];
        }

        //地接团信息
        $dj_opids       = array_filter(M('op')->group('dijie_opid')->getField('dijie_opid',true));
        //年累计
        $req_type       = 801;
        $dj_js_opids    = $this->get_dj_js_opids($yearbegintime, $yearendtime, $req_type);
        $req_type       = 800;
        $dj_ys_opids    = $this->get_dj_ys_opids($yearbegintime, $yearendtime, $req_type);
        //return $dj_ys_opids;

        $heji = array();
        $heji['yearxms'] = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu'] = array_sum(array_column($lists, 'yearrenshu'));
        $heji['yearzsr'] = array_sum(array_column($lists, 'yearzsr'));
        $heji['yearzml'] = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll'] = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $heji['monthxms'] = array_sum(array_column($lists, 'monthxms'));
        $heji['monthrenshu'] = array_sum(array_column($lists, 'monthrenshu'));
        $heji['monthzsr'] = array_sum(array_column($lists, 'monthzsr'));
        $heji['monthzml'] = array_sum(array_column($lists, 'monthzml'));
        $heji['monthmll'] = sprintf("%.2f", ($heji['monthzml'] / $heji['monthzsr']) * 100);
        $lists['heji'] = $heji;
        return $lists;
    }

    /**获取地接结算团信息
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_dj_js_opids($begintime, $endtime, $req_type){
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**获取地接预算团信息
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_dj_ys_opids($begintime, $endtime, $req_type){
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * @param array 所有预算id
     * @param array 所有结算id
     * @return array
     */
    public function get_ysjshz($ysopids, $jsopids)
    {
        //从预算取值的团
        $fromys = array();
        foreach ($ysopids as $value) {
            if (in_array($value, $jsopids)) {
            } else {
                $fromys[] = $value;
            }
        }

        //结算相关费用
        $jswhere = array();
        $jswhere['b.op_id'] = array('in', $jsopids);
        $yswhere = array();
        $yswhere['b.op_id'] = array('in', $fromys);

        $field = array();
        $field[] = 'count(o.id) as xms';
        $field[] = 'sum(c.num_adult) as renshu';
        $field[] = 'sum(b.shouru) as zsr';
        $field[] = 'sum(b.maoli) as zml';

        $yearjslist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($jswhere)->order('zsr DESC')->find();
        $yearyslist = M()->table('__OP_BUDGET__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($yswhere)->order('zsr DESC')->find();

        $data = array();
        $data['xms'] = $yearjslist['xms'] + $yearyslist['xms'];
        $data['renshu'] = $yearjslist['renshu'] + $yearyslist['renshu'];
        $data['zsr'] = $yearjslist['zsr'] + $yearyslist['zsr'];
        $data['zml'] = $yearjslist['zml'] + $yearyslist['zml'];
        $data['mll'] = $data['zml'] / $data['zsr'];
        return $data;
    }


    /**
     * department 部门数据
     * $type 类型(800=>预算 , 801=>结算)
     * $begintime 月开始时间（时间戳） $endtime 月结束时间（时间戳）
     * $year 年 2018
     */
    public function department($year,$begintime,$endtime,$type){

        $department = array('2' => '市场部', '6' => '京区业务中心', '7' => '京外业务中心', '12' => '南京项目部', '13' => '武汉项目部', '14' => '沈阳项目部', '15' => '常规业务中心', '16' => '长春项目部', '17' => '济南项目部');

        $data      = $this->time_department($year,$department,$begintime,$endtime,$type);//年 月度数据

        return $data;
    }


    /**
     * department 部门数据
     * $type 类型(800=>预算 , 801=>结算)
     * $begintime 月开始时间（时间戳） $endtime 月结束时间（时间戳）
     * $year 年 2018
     */
    public function time_department($year,$department,$begintime,$endtime,$type){
        $lists                                                      = array();
        $table_list                                                 = array();
        $count_list                                                 = array();
        foreach($department as $key =>$val){
            $account                                                = M('account')->where(array('departmentid='.$key,'status=0'))->select();//用户id
            $kind                                                   = M('project_kind')->field('id,name')->select();//部门分类
            $table_list[$key]['department']                         = $val;//部门名称
            foreach($kind as $ke => $va){//分类
                $where['o.kind']                                    = $va['id'];
                $month_sum  = 0;$month_people_num = 0;$month_income = 0;$month_profit = 0;
                $year_sum   = 0;$year_people_num  = 0;$year_income  = 0;$year_profit  = 0;
                foreach($account as $k => $v){//分类下的部门数据
                    $time1                                          = strtotime((int)(($year-1).'1226'));//默认年开始时间
                    $time2                                          = strtotime((int)($year.'1226'));//默认年结束时间
                    $where['o.status']                              = array('eq', 1);
                    $where['o.create_user']                         = array('eq', $v['id']);
                    $where['b.audit_status']                        = array('eq', 1);
                    $where['l.req_type']                            = array('eq', $type);
                    $where['l.audit_time']                          = array('between', "$begintime,$endtime");
                    //月度数据
                    if ($type == 800) { //800=>预算 数据
                        $lists = M()->table('__OP_BUDGET__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
                    } elseif ($type == 801) { // 801=>结算 数据
                        $lists = M()->table('__OP_SETTLEMENT__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
                    }
                    if($lists){
                        $month_sum                                  = $month_sum+count($lists);//月项目数
                        foreach($lists as $kk =>$vv){
                            $month_people_num                       += $vv['renshu'];//人数
                            $month_income                           += $vv['shouru'];//收入
                            $month_profit                           += $vv['maoli'];//毛利
                        }
                    }
                    //年度数据
                    unset($where['l.audit_time']);
                    $where['l.audit_time']                          = array('between', "$time1,$time2");
                    if ($type == 800) { //800=>预算 数据
                        $list = M()->table('__OP_BUDGET__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
                    } elseif ($type == 801) { // 801=>结算 数据
                        $list = M()->table('__OP_SETTLEMENT__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
                    }
                    if($list){
                        $year_sum                                   = $year_sum+count($list);//月项目数
                        foreach($list as $kkk =>$vvv){
                            $year_people_num                        += $vvv['renshu'];//人数
                            $year_income                            += $vvv['shouru'];//收入
                            $year_profit                            += $vvv['maoli'];//毛利
                        }
                    }
                }
                //月度数据
                $table_list[$key]['name'][$ke]['month_sum']         = $month_sum;//人数
                $table_list[$key]['name'][$ke]['month_people_num']  = $month_people_num;//人数
                $table_list[$key]['name'][$ke]['month_income']      = $month_income;//收入
                $table_list[$key]['name'][$ke]['month_profit']      = $month_profit;//毛利
//                $table_list[$key]['name'][$ke]['month_ratio']       = round(($month_profit/$month_income)*100,2);//毛利率
                //年度数据
                $table_list[$key]['name'][$ke]['year_sum']          = $year_sum;//人数
                $table_list[$key]['name'][$ke]['year_people_num']   = $year_people_num;//人数
                $table_list[$key]['name'][$ke]['year_income']       = $year_income;//收入
                $table_list[$key]['name'][$ke]['year_profit']       = $year_profit;//毛利
//                $table_list[$key]['name'][$ke]['year_ratio']        = round(($year_profit/$year_people_num)*100,2);//毛利率
                //总计 月度数据
                $count_list['name'][$ke]['month_sum']         += $month_sum;//人数
                $count_list['name'][$ke]['month_people_num']  += $month_people_num;//人数
                $count_list['name'][$ke]['month_income']      += $month_income;//收入
                $count_list['name'][$ke]['month_profit']      += $month_profit;//毛利
                //总计 年度数据
                $count_list['name'][$ke]['year_sum']          += $year_sum;//人数
                $count_list['name'][$ke]['year_people_num']   += $year_people_num;//人数
                $count_list['name'][$ke]['year_income']       += $year_income;//收入
                $count_list['name'][$ke]['year_profit']       += $year_profit;//毛利
                if($month_sum==0&&$month_people_num==0&&$month_income==0&&$month_profit==0&&$year_sum==0&&$year_people_num==0&&$year_income==0&&$year_profit==0){
                    unset($table_list[$key]['name'][$ke]);
                }else{
                    $table_list[$key]['name'][$ke]['type_name']     = $va['name'];
                }
                if($count_list['name'][$ke]['month_sum']==0 && $count_list['name'][$ke]['month_people_num']==0 && $count_list['name'][$ke]['month_income']==0 &&  $count_list['name'][$ke]['month_profit']==0 &&  $count_list['name'][$ke]['year_sum']==0 && $count_list['name'][$ke]['year_people_num']==0 && $count_list['name'][$ke]['year_income']==0 && $count_list['name'][$ke]['year_profit']==0 && $count_list['name'][$ke]['month_ratio']==0 && $count_list['name'][$ke]['year_ratio']==0){
                    unset($count_list['name'][$ke]);
                }else{
                    $count_list['name'][$ke]['type_name']             = $va['name'];
                    $count_list['name'][$ke]['month_ratio']           = round(($count_list['name'][$ke]['month_profit']/$count_list['name'][$ke]['month_income'])*100,2);//总计 月度 毛利率
                    $count_list['name'][$ke]['year_ratio']            = round(($count_list['name'][$ke]['year_profit']/$count_list['name'][$ke]['year_income'])*100,2);//总计 年度毛利率
                }
            }
        }
        foreach($table_list as $key => $val){
            if(count($table_list[$key]['name'])==0){
                //月度数据
                $table_list[$key]['name'][$ke]['month_sum']         = '';//人数
                $table_list[$key]['name'][$ke]['month_people_num']  = '';//人数
                $table_list[$key]['name'][$ke]['month_income']      = '';//收入
                $table_list[$key]['name'][$ke]['month_profit']      = '';//毛利
//                $table_list[$key]['name'][$ke]['month_ratio']       = '';//毛利率
                //年度数据
                $table_list[$key]['name'][$ke]['year_sum']          = '';//人数
                $table_list[$key]['name'][$ke]['year_people_num']   = '';//人数
                $table_list[$key]['name'][$ke]['year_income']       = '';//收入
                $table_list[$key]['name'][$ke]['year_profit']       = '';//毛利
//                $table_list[$key]['name'][$ke]['year_ratio']        = '';//毛利率
            }
        }

        $table[0] = $table_list;//部门
        $table[1] = $count_list;//合计
        $table[1]['nickname'] = '合计';
        return $table;
    }




}