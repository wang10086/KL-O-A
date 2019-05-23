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
    public function js_deplist($userlists, $month='', $yeartimes, $pin = 0,$quartertimes='')
    {

        $monthtime                  = intval($month);
        $month                      = get_cycle($monthtime, 26);
        $quarterbegintime           = $quartertimes['begin_time'];
        $quarterendtime             = $quartertimes['end_time'];
        $lists                      = array();
        foreach ($userlists as $k => $v) {
            //年度累计
            $where                  = array();
            $where['b.audit_status']= 1;
            $where['l.req_type']    = 801;
            $where['l.audit_time']  = array('between', "$yeartimes[yearBeginTime],$yeartimes[yearEndTime]");
            $where['a.id']          = array('in', $v['users']);

            $field                  = array();
            $field[]                = 'count(o.id) as xms';
            $field[]                = 'sum(c.num_adult) as renshu';
            $field[]                = 'sum(b.shouru) as zsr';
            $field[]                = 'sum(b.maoli) as zml';
            $field[]                = '(sum(b.maoli)/sum(b.shouru)) as mll';

            $yearopid_lists         = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->select();
            $yearlist               = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();
            $lists[$v['id']]['yearxms']     = $yearlist['xms'] ? $yearlist['xms'] : 0;
            $lists[$v['id']]['yearrenshu']  = $yearlist['renshu'] ? $yearlist['renshu'] : 0;
            $lists[$v['id']]['yearzsr']     = $yearlist['zsr'] ? $yearlist['zsr'] : "0.00";
            $lists[$v['id']]['yearzml']     = $yearlist['zml'] ? $yearlist['zml'] : "0.00";
            $lists[$v['id']]['yearmll']     = $yearlist['mll'] ? sprintf("%.2f", $yearlist['mll'] * 100) : "0.00";
            $lists[$v['id']]['yearopids']   = implode(',',array_column($yearopid_lists,'op_id'));

            if ($quartertimes){ //季度
                $where                  = array();
                $where['b.audit_status']= 1;
                $where['l.req_type']    = 801;
                $where['l.audit_time']  = array('between', "$quarterbegintime,$quarterendtime");
                $where['a.id']          = array('in', $v['users']);

                $field                  = array();
                $field[]                = 'count(o.id) as xms';
                $field[]                = 'sum(c.num_adult) as renshu';
                $field[]                = 'sum(b.shouru) as zsr';
                $field[]                = 'sum(b.maoli) as zml';
                $field[]                = '(sum(b.maoli)/sum(b.shouru)) as mll';
                $quarteropid_lists      = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->select();
                $quarterlist            = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();

                $lists[$v['id']]['quarterxms']      = $quarterlist['xms'] ? $quarterlist['xms'] : 0;
                $lists[$v['id']]['quarterrenshu']   = $quarterlist['renshu'] ? $quarterlist['renshu'] : 0;
                $lists[$v['id']]['quarterzsr']      = $quarterlist['zsr'] ? $quarterlist['zsr'] : "0.00";
                $lists[$v['id']]['quarterzml']      = $quarterlist['zml'] ? $quarterlist['zml'] : "0.00";
                $lists[$v['id']]['quartermll']      = $quarterlist['mll'] ? sprintf("%.2f", $quarterlist['mll'] * 100) : "0.00";
                $lists[$v['id']]['quarteropids']    = implode(',',array_column($quarteropid_lists,'op_id'));
            }

            if ($month){
                //查询月度
                $where                  = array();
                $where['b.audit_status']= 1;
                $where['l.req_type']    = 801;
                $where['l.audit_time']  = array('between', "$month[begintime],$month[endtime]");
                $where['a.id']          = array('in', $v['users']);

                $field                  = array();
                $field[]                = 'count(o.id) as xms';
                $field[]                = 'sum(c.num_adult) as renshu';
                $field[]                = 'sum(b.shouru) as zsr';
                $field[]                = 'sum(b.maoli) as zml';
                $field[]                = '(sum(b.maoli)/sum(b.shouru)) as mll';

                $monthopid_lists        = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->select();
                $monthlist              = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();

                $lists[$v['id']]['monthxms']    = $monthlist['xms'] ? $monthlist['xms'] : 0;
                $lists[$v['id']]['monthrenshu'] = $monthlist['renshu'] ? $monthlist['renshu'] : 0;
                $lists[$v['id']]['monthzsr']    = $monthlist['zsr'] ? $monthlist['zsr'] : "0.00";
                $lists[$v['id']]['monthzml']    = $monthlist['zml'] ? $monthlist['zml'] : "0.00";
                $lists[$v['id']]['monthmll']    = $monthlist['mll'] ? sprintf("%.2f", $monthlist['mll'] * 100) : "0.00";
                $lists[$v['id']]['monthopids']  = implode(',',array_column($monthopid_lists,'op_id'));
            }
            $lists[$v['id']]['users']           = $v['users'];
            $lists[$v['id']]['id']              = $v['id'];
            $lists[$v['id']]['depname']         = $v['depname'];
        }

        //地接团信息
        $dj_opids       = array_filter(M('op')->group('dijie_opid')->getField('dijie_opid',true));
        //地接年累计
        $req_type       = 801;  //结算
        $dj_js_opids    = $this->get_dj_js_opids($yeartimes['yearBeginTime'], $yeartimes['yearEndTime'], $req_type,$dj_opids);
        $dj_js_opids    = array_column($dj_js_opids,'op_id');
        $dj_yeardata    = $this->get_dj_js_info($yeartimes['yearBeginTime'],$yeartimes['yearEndTime'],$dj_js_opids);

        if ($quartertimes){
            //地接季度累计
            $req_type                = 801;  //结算
            $dj_m_js_opids           = $this->get_dj_js_opids($quarterbegintime, $quarterendtime, $req_type,$dj_opids);
            $dj_m_js_opids           = array_column($dj_m_js_opids,'op_id');
            $dj_quarterdata          = $this->get_dj_js_info($quarterbegintime,$quarterendtime,$dj_m_js_opids);
        }

        if ($month){
            //地接月累计
            $req_type               = 801;  //结算
            $dj_m_js_opids          = $this->get_dj_js_opids($month['begintime'], $month['endtime'], $req_type,$dj_opids);
            $dj_m_js_opids          = array_column($dj_m_js_opids,'op_id');
            $dj_monthdata           = $this->get_dj_js_info($month['begintime'],$month['endtime'],$dj_m_js_opids);
        }
        $dj_heji                    = array();
        $dj_heji['yearxms']         = $dj_yeardata['xms'];
        $dj_heji['yearrenshu']      = $dj_yeardata['renshu'];
        $dj_heji['yearzsr']         = $dj_yeardata['zsr'];
        $dj_heji['yearzml']         = $dj_yeardata['zml'];
        $dj_heji['yearmll']         = sprintf("%.2f", ($dj_heji['yearzml'] / $dj_heji['yearzsr']) * 100);
        $dj_heji['yearopids']       = implode(',',$dj_yeardata['opids']);
        $dj_heji['quarterxms']      = $dj_quarterdata['xms'];
        $dj_heji['quarterrenshu']   = $dj_quarterdata['renshu'];
        $dj_heji['quarterzsr']      = $dj_quarterdata['zsr'];
        $dj_heji['quarterzml']      = $dj_quarterdata['zml'];
        $dj_heji['quartermll']      = sprintf("%.2f", ($dj_heji['quarterzml'] / $dj_heji['quarterzsr']) * 100);
        $dj_heji['quarteropids']    = implode(',',$dj_quarterdata['opids']);
        $dj_heji['monthxms']        = $dj_monthdata['xms'];
        $dj_heji['monthrenshu']     = $dj_monthdata['renshu'];
        $dj_heji['monthzsr']        = $dj_monthdata['zsr'];
        $dj_heji['monthzml']        = $dj_monthdata['zml'];
        $dj_heji['monthmll']        = sprintf("%.2f", ($dj_heji['monthzml'] / $dj_heji['monthzsr']) * 100);
        $dj_heji['monthopids']      = implode(',',$dj_monthdata['opids']);

        $heji                   = array();
        $heji['yearxms']        = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu']     = array_sum(array_column($lists, 'yearrenshu')) - $dj_yeardata['renshu'];
        $heji['yearzsr']        = array_sum(array_column($lists, 'yearzsr')) - $dj_yeardata['zsr'];
        $heji['yearzml']        = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll']        = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $heji['yearopids']      = implode(',',array_filter(array_column($lists,'yearopids')));
        $heji['quarterxms']     = array_sum(array_column($lists, 'quarterxms'));
        $heji['quarterrenshu']  = array_sum(array_column($lists, 'quarterrenshu')) - $dj_quarterdata['renshu'];
        $heji['quarterzsr']     = array_sum(array_column($lists, 'quarterzsr')) - $dj_quarterdata['zsr'];
        $heji['quarterzml']     = array_sum(array_column($lists, 'quarterzml'));
        $heji['quartermll']     = sprintf("%.2f", ($heji['quarterzml'] / $heji['quarterzsr']) * 100);
        $heji['quarteropids']   = implode(',',array_filter(array_column($lists,'quarteropids')));
        $heji['monthxms']       = array_sum(array_column($lists, 'monthxms'));
        $heji['monthrenshu']    = array_sum(array_column($lists, 'monthrenshu')) - $dj_monthdata['renshu'];
        $heji['monthzsr']       = array_sum(array_column($lists, 'monthzsr')) - $dj_monthdata['zsr'];
        $heji['monthzml']       = array_sum(array_column($lists, 'monthzml'));
        $heji['monthmll']       = sprintf("%.2f", ($heji['monthzml'] / $heji['monthzsr']) * 100);
        $heji['monthopids']     = implode(',',array_filter(array_column($lists,'monthopids')));
        $lists['heji']          = $heji;
        $lists['dj_heji']       = $dj_heji;
        return $lists;
    }


    function get_dj_js_info($beginTime,$endTime,$dj_opids){
        //年度累计
        $where                  = array();
        $where['b.audit_status']= 1;
        $where['l.req_type']    = 801;
        $where['l.audit_time']  = array('between', "$beginTime,$endTime");
        $where['b.op_id']       = array('in',$dj_opids);

        $field                  = array();
        $field[]                = 'count(o.id) as xms';
        $field[]                = 'sum(c.num_adult) as renshu';
        $field[]                = 'sum(b.shouru) as zsr';
        $field[]                = 'sum(b.maoli) as zml';
        $field[]                = '(sum(b.maoli)/sum(b.shouru)) as mll';

        $yearlist               = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($where)->order('zsr DESC')->find();
        $list['xms']            = $yearlist['xms'] ? $yearlist['xms'] : 0;
        $list['renshu']         = $yearlist['renshu'] ? $yearlist['renshu'] : 0;
        $list['zsr']            = $yearlist['zsr'] ? $yearlist['zsr'] : "0.00";
        $list['zml']            = $yearlist['zml'] ? $yearlist['zml'] : "0.00";
        $list['mll']            = $yearlist['mll'] ? sprintf("%.2f", $yearlist['mll'] * 100) : "0.00";
        $list['opids']          = $dj_opids;
        return $list;
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
        $sumYear                    = round($sumYearUser/$countMonth,2); //年平均人数
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
    function get_ys_opids($users, $begintime, $endtime, $req_type = 800,$opids='')
    {
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        $where['a.id'] = array('in', $users);
        if ($opids){ $where['o.op_id']  = array('not in',$opids); }
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * 预算结算部门数据
     * @param array 相关部门及人员信息
     * @param 月份 200808
     * @param array 当年开始及结束时间
     * @param pin
     * @param array 季度开始及结束时间
     * @return array
     */
    public function ysjs_deplist($userlists, $month='', $yeartimes,$pin='',$quartertimes='')
    {

        //年累计
        $yearbegintime          = $yeartimes['yearBeginTime'];
        $yearendtime            = $yeartimes['yearEndTime'];
        $quarterbegintime       = $quartertimes['begin_time'];
        $quarterendtime         = $quartertimes['end_time'];
        $monthtime              = intval($month);
        $month                  = get_cycle($monthtime, 26);

        foreach ($userlists as $k => $v) {
            //年累计
            //年度结算的团
            $req_type           = 801;
            $jsopids            = $this->get_js_opids($v['users'], $yearbegintime, $yearendtime, $req_type);
            $jsopids            = array_column($jsopids, 'op_id');

            //年度预算的团
            $req_type           = 800;
            $ysopids            = $this->get_ys_opids($v['users'], $yearbegintime, $yearendtime, $req_type,$jsopids);
            $ysopids            = array_column($ysopids, 'op_id');

            //年度数据
            $yeardata           = $this->get_ysjshz($ysopids, $jsopids);
            $yearxms            = $yeardata['xms'];
            $yearrenshu         = $yeardata['renshu'];
            $yearzsr            = $yeardata['zsr'];
            $yearzml            = $yeardata['zml'];
            $yearmll            = $yeardata['mll'];
            $yearopids          = implode(',',$yeardata['opids']);

            $lists[$v['id']]['yearxms']     = $yearxms ? $yearxms : 0;
            $lists[$v['id']]['yearrenshu']  = $yearrenshu ? $yearrenshu : 0;
            $lists[$v['id']]['yearzsr']     = $yearzsr ? $yearzsr : "0.00";
            $lists[$v['id']]['yearzml']     = $yearzml ? $yearzml : "0.00";
            $lists[$v['id']]['yearmll']     = $yearmll ? sprintf("%.2f", $yearmll * 100) : "0.00";
            $lists[$v['id']]['yearopids']   = $yearopids;

            if ($quartertimes){ //季度累计
                //季度结算的团
                $req_type       = 801;
                $quarterjsopids = $this->get_js_opids($v['users'], $quarterbegintime, $quarterendtime, $req_type);
                $quarterjsopids = array_column($quarterjsopids, 'op_id');

                //季度预算的团
                $req_type       = 800;
                $ysopids        = $this->get_ys_opids($v['users'], $quarterbegintime, $quarterendtime, $req_type,$quarterjsopids);
                $ysopids        = array_column($ysopids, 'op_id');

                //季度数据
                $quarterdata    = $this->get_ysjshz($ysopids, $quarterjsopids);
                $quarterxms     = $quarterdata['xms'];
                $quarterrenshu  = $quarterdata['renshu'];
                $quarterzsr     = $quarterdata['zsr'];
                $quarterzml     = $quarterdata['zml'];
                $quartermll     = $quarterdata['mll'];
                $quarteropids   = implode(',',$quarterdata['opids']);

                $lists[$v['id']]['quarterxms']      = $quarterxms ? $quarterxms : 0;
                $lists[$v['id']]['quarterrenshu']   = $quarterrenshu ? $quarterrenshu : 0;
                $lists[$v['id']]['quarterzsr']      = $quarterzsr ? $quarterzsr : "0.00";
                $lists[$v['id']]['quarterzml']      = $quarterzml ? $quarterzml : "0.00";
                $lists[$v['id']]['quartermll']      = $quartermll ? sprintf("%.2f", $quartermll * 100) : "0.00";
                $lists[$v['id']]['quarteropids']    = $quarteropids;
            }

            if ($month){ //月度累计
                //月度结算的团
                $req_type       = 801;
                $monthjsopids   = $this->get_js_opids($v['users'], $month['begintime'], $month['endtime'], $req_type);
                $monthjsopids   = array_column($monthjsopids, 'op_id');

                //月度预算的团
                $req_type       = 800;
                $monthysopids   = $this->get_ys_opids($v['users'], $month['begintime'], $month['endtime'], $req_type,$monthjsopids);
                $monthysopids   = array_column($monthysopids, 'op_id');

                //月度数据
                $monthdata      = $this->get_ysjshz($monthysopids, $monthjsopids);
                $monthxms       = $monthdata['xms'];
                $monthrenshu    = $monthdata['renshu'];
                $monthzsr       = $monthdata['zsr'];
                $monthzml       = $monthdata['zml'];
                $monthmll       = $monthdata['mll'];
                $monthopids     = implode(',',$monthdata['opids']);

                $lists[$v['id']]['monthxms']    = $monthxms ? $monthxms : 0;
                $lists[$v['id']]['monthrenshu'] = $monthrenshu ? $monthrenshu : 0;
                $lists[$v['id']]['monthzsr']    = $monthzsr ? $monthzsr : "0.00";
                $lists[$v['id']]['monthzml']    = $monthzml ? $monthzml : "0.00";
                $lists[$v['id']]['monthmll']    = $monthmll ? sprintf("%.2f", $monthmll * 100) : "0.00";
                $lists[$v['id']]['monthopids']  = $monthopids;
            }
            $lists[$v['id']]['users']           = $v['users'];
            $lists[$v['id']]['id']              = $v['id'];
            $lists[$v['id']]['depname']         = $v['depname'];
        }

        //地接团信息
        $dj_opids       = array_filter(M('op')->group('dijie_opid')->getField('dijie_opid',true));
        //地接年累计
        $req_type       = 801;  //结算
        $dj_js_opids    = $this->get_dj_js_opids($yearbegintime, $yearendtime, $req_type,$dj_opids);
        $dj_js_opids    = array_column($dj_js_opids,'op_id');
        $in_year_opids  = array();
        foreach ($dj_opids as $v){
            if (!in_array($v,$dj_js_opids)){
                $in_year_opids[] = $v;
            }
        }

        $req_type       = 800;  //预算
        $dj_ys_opids    = $this->get_dj_ys_opids($yearbegintime, $yearendtime, $req_type,$in_year_opids);
        $dj_ys_opids    = array_column($dj_ys_opids,'op_id');
        $dj_yeardata    = $this->get_ysjshz($dj_ys_opids,$dj_js_opids);

        if ($quartertimes){ //季度
            //地接季度累计
            $req_type       = 801;  //结算
            $dj_q_js_opids  = $this->get_dj_js_opids($quarterbegintime, $quarterendtime, $req_type,$dj_opids);
            $dj_q_js_opids  = array_column($dj_q_js_opids,'op_id');
            $in_quarter_opids = array();
            foreach ($dj_opids as $v){
                if (!in_array($v,$dj_q_js_opids)){
                    $in_quarter_opids[] = $v;
                }
            }
            $req_type       = 800;  //预算
            $dj_q_ys_opids  = $this->get_dj_ys_opids($quarterbegintime, $quarterendtime, $req_type,$in_quarter_opids);
            $dj_q_ys_opids  = array_column($dj_q_ys_opids,'op_id');
            $dj_quarterdata = $this->get_ysjshz($dj_q_ys_opids,$dj_q_js_opids);
        }

        if ($month){ //月度
            //地接月累计
            $req_type       = 801;  //结算
            $dj_m_js_opids  = $this->get_dj_js_opids($month['begintime'], $month['endtime'], $req_type,$dj_opids);
            $dj_m_js_opids  = array_column($dj_m_js_opids,'op_id');
            $in_month_opids = array();
            foreach ($dj_opids as $v){
                if (!in_array($v,$dj_m_js_opids)){
                    $in_month_opids[] = $v;
                }
            }
            $req_type       = 800;  //预算
            $dj_m_ys_opids  = $this->get_dj_ys_opids($month['begintime'], $month['endtime'], $req_type,$in_month_opids);
            $dj_m_ys_opids  = array_column($dj_m_ys_opids,'op_id');
            $dj_monthdata   = $this->get_ysjshz($dj_m_ys_opids,$dj_m_js_opids);
        }

        $dj_heji                    = array();
        $dj_heji['yearxms']         = $dj_yeardata['xms'];
        $dj_heji['yearrenshu']      = $dj_yeardata['renshu'];
        $dj_heji['yearzsr']         = $dj_yeardata['zsr'];
        $dj_heji['yearzml']         = $dj_yeardata['zml'];
        $dj_heji['yearmll']         = sprintf("%.2f", ($dj_heji['yearzml'] / $dj_heji['yearzsr']) * 100);
        $dj_heji['yearopids']       = implode(',',$dj_yeardata['opids']);
        $dj_heji['quarterxms']      = $dj_quarterdata['xms'];
        $dj_heji['quarterrenshu']   = $dj_quarterdata['renshu'];
        $dj_heji['quarterzsr']      = $dj_quarterdata['zsr'];
        $dj_heji['quarterzml']      = $dj_quarterdata['zml'];
        $dj_heji['quartermll']      = sprintf("%.2f", ($dj_heji['quarterzml'] / $dj_heji['quarterzsr']) * 100);
        $dj_heji['quarteropids']    = implode(',',$dj_quarterdata['opids']);
        $dj_heji['monthxms']        = $dj_monthdata['xms'];
        $dj_heji['monthrenshu']     = $dj_monthdata['renshu'];
        $dj_heji['monthzsr']        = $dj_monthdata['zsr'];
        $dj_heji['monthzml']        = $dj_monthdata['zml'];
        $dj_heji['monthmll']        = sprintf("%.2f", ($dj_heji['monthzml'] / $dj_heji['monthzsr']) * 100);
        $dj_heji['monthopids']      = implode(',',$dj_monthdata['opids']);

        $heji                       = array();
        $heji['yearxms']            = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu']         = array_sum(array_column($lists, 'yearrenshu')) - $dj_heji['yearrenshu'];
        $heji['yearzsr']            = array_sum(array_column($lists, 'yearzsr')) - $dj_heji['yearzsr'];
        $heji['yearzml']            = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll']            = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $heji['yearopids']          = implode(',',array_filter(array_column($lists,'yearopids')));
        $heji['quarterxms']         = array_sum(array_column($lists, 'quarterxms'));
        $heji['quarterrenshu']      = array_sum(array_column($lists, 'quarterrenshu')) - $dj_heji['quarterrenshu'];
        $heji['quarterzsr']         = array_sum(array_column($lists, 'quarterzsr')) - $dj_heji['quarterzsr'];
        $heji['quarterzml']         = array_sum(array_column($lists, 'quarterzml'));
        $heji['quartermll']         = sprintf("%.2f", ($heji['quarterzml'] / $heji['quarterzsr']) * 100);
        $heji['quarteropids']       = implode(',',array_filter(array_column($lists,'quarteropids')));
        $heji['monthxms']           = array_sum(array_column($lists, 'monthxms'));
        $heji['monthrenshu']        = array_sum(array_column($lists, 'monthrenshu')) - $dj_heji['monthrenshu'];
        $heji['monthzsr']           = array_sum(array_column($lists, 'monthzsr')) - $dj_heji['monthzsr'];
        $heji['monthzml']           = array_sum(array_column($lists, 'monthzml'));
        $heji['monthmll']           = sprintf("%.2f", ($heji['monthzml'] / $heji['monthzsr']) * 100);
        $heji['monthopids']         = implode(',',array_filter(array_column($lists,'monthopids')));
        $lists['heji']              = $heji;
        $lists['dj_heji']           = $dj_heji;

        return $lists;
    }

    /**获取地接结算团信息
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_dj_js_opids($begintime, $endtime, $req_type,$dj_opids=''){
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type'] = $req_type;
        $where['l.audit_time'] = array('between', "$begintime,$endtime");
        if ($dj_opids){ $where['o.op_id']   = array('in',$dj_opids); }
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**获取地接预算团信息
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_dj_ys_opids($begintime, $endtime, $req_type,$in_opids=''){
        $where = array();
        $where['b.audit_status']= 1;
        $where['l.req_type']    = $req_type;
        $where['l.audit_time']  = array('between', "$begintime,$endtime");
        if ($in_opids){ $where['o.op_id']       = array('in',$in_opids); }
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * @param array 所有预算id
     * @param array 所有结算id
     * @return array
     */
    public function get_ysjshz($ysopids, $jsopids){
        //从预算取值的团
        /*$fromys = array();
        foreach ($ysopids as $value) {
            if (in_array($value, $jsopids)) {
            } else {
                $fromys[] = $value;
            }
        }*/

        //结算相关费用
        $jswhere = array();
        $jswhere['b.op_id'] = array('in', $jsopids);
        $yswhere = array();
        $yswhere['b.op_id'] = array('in', $ysopids);

        $field = array();
        $field[] = 'count(o.id) as xms';
        $field[] = 'sum(c.num_adult) as renshu';
        $field[] = 'sum(b.shouru) as zsr';
        $field[] = 'sum(b.maoli) as zml';

        $yearjslist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($jswhere)->order('zsr DESC')->find();
        $yearyslist = M()->table('__OP_BUDGET__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($yswhere)->order('zsr DESC')->find();

        $opids          = array();
        if ($ysopids){ foreach ($ysopids as $v){ $opids[] = $v;}}
        if ($jsopids){ foreach ($jsopids as $v){ $opids[] = $v;}}

        $data           = array();
        $data['xms']    = $yearjslist['xms'] + $yearyslist['xms'];
        $data['renshu'] = $yearjslist['renshu'] + $yearyslist['renshu'];
        $data['zsr']    = $yearjslist['zsr'] + $yearyslist['zsr'];
        $data['zml']    = $yearjslist['zml'] + $yearyslist['zml'];
        $data['mll']    = $data['zml'] / $data['zsr'];
        //$data['opids']  = array_merge($ysopids,$jsopids);
        $data['opids']  = $opids;
        return $data;
    }


    /**
     * department 部门数据
     * $type 类型(800=>预算 , 801=>结算)
     * $begintime 月开始时间（时间戳） $endtime 月结束时间（时间戳）
     * $year 年 2018
     */
    /*public function department($year,$begintime,$endtime,$type){

        $department = array(
            '2'     => '市场部',
            '6'     => '京区业务中心',
            '7'     => '京外业务中心',
            '12'    => '南京项目部',
            '13'    => '武汉项目部',
            '14'    => '沈阳项目部',
            '15'    => '常规业务中心',
            '16'    => '长春项目部',
        );

        //$data       = $this->time_department($year,$department,$begintime,$endtime,$type);//年 月度数据
        return $data;
    }*/

    /***
     * bak_20190522
     * year_month_day 查询日期
     * $year 年 $month月
     */
    /*public function year_month_day($year,$month){

        if($month==1){
            $time[0]     = ($year-1).'1226';
            $time[1]     = $year.'0'.$month.'26';
        }else{
            if($month<10){
                $time[0] = $year.'0'.($month-1).'26';
                $time[1] = $year.'0'.$month.'26';
            }elseif($month==10){
                $time[0] = $year.'0'.($month-1).'26';
                $time[1] = $year.$month.'26';
            }else{
                $time[0] = $year.($month-1).'26';
                $time[1] = $year.$month.'26';
            }
        }
        return $time;
    }*/

    /**
     * settlement 结算 801
     * $where 查询条件
     */
    public function SETTLEMENT($where)
    {
        $list  = M()->table('__OP_SETTLEMENT__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        return $list;
    }

    /**
     * op_budget 预算 800
     * $where 查询条件
     */
    public function op_budget($where)
    {
        $list  = M()->table('__OP_BUDGET__ as b')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();
        return $list;
    }

    /**
     * 预算及结算分部门分类型汇总
     * @param $userlists
     * @param $yeartimes
     * @param $monthtimes
     * @param $quartertimes
     */
    public function ysjs_department_type($userlists,$yeartimes,$monthtimes,$quartertimes){
        //年累计
        $yearbegintime          = $yeartimes['beginTime'];
        $yearendtime            = $yeartimes['endTime'];
        $quarterbegintime       = $quartertimes['begin_time'];
        $quarterendtime         = $quartertimes['end_time'];
        $monthbegintime         = $monthtimes['begintime'];
        $monthendtime           = $monthtimes['endtime'];
        $kinds                  = M('project_kind')->getField('id,name',true);
        foreach ($userlists as $k => $v) {
            foreach ($kinds as $kid=>$kvalue){
                //年累计
                //年度结算的团
                $req_type           = 801;
                $jsopids            = $this->get_type_js_opids($v['users'], $yearbegintime, $yearendtime, $req_type,$kid);
                $jsopids            = array_column($jsopids, 'op_id');

                //年度预算的团
                $req_type           = 800;
                $ysopids            = $this->get_type_ys_opids($v['users'], $yearbegintime, $yearendtime, $req_type,$jsopids,$kid);
                $ysopids            = array_column($ysopids, 'op_id');

                //年度数据
                $yeardata           = $this->get_type_ysjshz($ysopids, $jsopids,$kid);
                $yearxms            = $yeardata['xms'];
                $yearrenshu         = $yeardata['renshu'];
                $yearzsr            = $yeardata['zsr'];
                $yearzml            = $yeardata['zml'];
                $yearmll            = $yeardata['mll'];
                $yearopids          = implode(',',$yeardata['opids']);

                if ($yearxms){
                    $lists[$v['id']]['year_data'][$kvalue]['yearxms']     = $yearxms ? $yearxms : 0;
                    $lists[$v['id']]['year_data'][$kvalue]['yearrenshu']  = $yearrenshu ? $yearrenshu : 0;
                    $lists[$v['id']]['year_data'][$kvalue]['yearzsr']     = $yearzsr ? $yearzsr : "0.00";
                    $lists[$v['id']]['year_data'][$kvalue]['yearzml']     = $yearzml ? $yearzml : "0.00";
                    $lists[$v['id']]['year_data'][$kvalue]['yearmll']     = $yearmll ? sprintf("%.2f", $yearmll * 100) : "0.00";
                    $lists[$v['id']]['year_data'][$kvalue]['yearopids']   = $yearopids;
                    $lists[$v['id']]['year_data'][$kvalue]['yearkindid']  = $kid;
                }

                if ($quartertimes){ //季度累计
                    //季度结算的团
                    $req_type       = 801;
                    $quarterjsopids = $this->get_type_js_opids($v['users'], $quarterbegintime, $quarterendtime, $req_type,$kid);
                    $quarterjsopids = array_column($quarterjsopids, 'op_id');

                    //季度预算的团
                    $req_type       = 800;
                    $ysopids        = $this->get_type_ys_opids($v['users'], $quarterbegintime, $quarterendtime, $req_type,$quarterjsopids,$kid);
                    $ysopids        = array_column($ysopids, 'op_id');

                    //季度数据
                    $quarterdata    = $this->get_type_ysjshz($ysopids, $quarterjsopids,$kid);
                    $quarterxms     = $quarterdata['xms'];
                    $quarterrenshu  = $quarterdata['renshu'];
                    $quarterzsr     = $quarterdata['zsr'];
                    $quarterzml     = $quarterdata['zml'];
                    $quartermll     = $quarterdata['mll'];
                    $quarteropids   = implode(',',$quarterdata['opids']);

                    if ($quarterxms){
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarterxms']      = $quarterxms ? $quarterxms : 0;
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarterrenshu']   = $quarterrenshu ? $quarterrenshu : 0;
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarterzsr']      = $quarterzsr ? $quarterzsr : "0.00";
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarterzml']      = $quarterzml ? $quarterzml : "0.00";
                        $lists[$v['id']]['quarter_data'][$kvalue]['quartermll']      = $quartermll ? sprintf("%.2f", $quartermll * 100) : "0.00";
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarteropids']    = $quarteropids;
                        $lists[$v['id']]['quarter_data'][$kvalue]['quarterkindid']   = $kid;
                    }
                }

                if ($monthtimes){ //月度累计
                    //月度结算的团
                    $req_type       = 801;
                    $monthjsopids   = $this->get_type_js_opids($v['users'], $monthbegintime, $monthendtime, $req_type,$kid);
                    $monthjsopids   = array_column($monthjsopids, 'op_id');

                    //月度预算的团
                    $req_type       = 800;
                    $monthysopids   = $this->get_type_ys_opids($v['users'], $monthbegintime, $monthendtime, $req_type,$monthjsopids,$kid);
                    $monthysopids   = array_column($monthysopids, 'op_id');

                    //月度数据
                    $monthdata      = $this->get_type_ysjshz($monthysopids, $monthjsopids,$kid);
                    $monthxms       = $monthdata['xms'];
                    $monthrenshu    = $monthdata['renshu'];
                    $monthzsr       = $monthdata['zsr'];
                    $monthzml       = $monthdata['zml'];
                    $monthmll       = $monthdata['mll'];
                    $monthopids     = implode(',',$monthdata['opids']);

                    if ($monthxms){
                        $lists[$v['id']]['month_data'][$kvalue]['monthxms']    = $monthxms ? $monthxms : 0;
                        $lists[$v['id']]['month_data'][$kvalue]['monthrenshu'] = $monthrenshu ? $monthrenshu : 0;
                        $lists[$v['id']]['month_data'][$kvalue]['monthzsr']    = $monthzsr ? $monthzsr : "0.00";
                        $lists[$v['id']]['month_data'][$kvalue]['monthzml']    = $monthzml ? $monthzml : "0.00";
                        $lists[$v['id']]['month_data'][$kvalue]['monthmll']    = $monthmll ? sprintf("%.2f", $monthmll * 100) : "0.00";
                        $lists[$v['id']]['month_data'][$kvalue]['monthopids']  = $monthopids;
                        $lists[$v['id']]['month_data'][$kvalue]['monthkindid'] = $kid;
                    }
                }
            }
            $lists[$v['id']]['users']           = $v['users'];
            $lists[$v['id']]['id']              = $v['id'];
            $lists[$v['id']]['depname']         = $v['depname'];
        }

        /*//地接团信息
        $dj_opids           = array_filter(M('op')->group('dijie_opid')->getField('dijie_opid',true));
        $dj_heji            = array();

        foreach ($kinds as $kid=>$kvalue){
            //地接年累计
            $req_type       = 801;  //结算
            $dj_y_js_opids    = $this->get_type_dj_js_opids($yearbegintime, $yearendtime, $req_type,$dj_opids,$kid);
            $dj_y_js_opids    = array_column($dj_y_js_opids,'op_id');
            $in_year_opids  = array();
            foreach ($dj_opids as $v){
                if (!in_array($v,$dj_y_js_opids)){
                    $in_year_opids[] = $v;
                }
            }

            $req_type       = 800;  //预算
            $dj_ys_opids    = $this->get_type_dj_ys_opids($yearbegintime, $yearendtime, $req_type,$in_year_opids,$kid);
            $dj_ys_opids    = array_column($dj_ys_opids,'op_id');
            $dj_yeardata    = $this->get_ysjshz($dj_ys_opids,$dj_y_js_opids);

            if ($dj_yeardata['xms']){
                $lists['dj_year_data'][$kvalue]['yearxms']     = $dj_yeardata['xms'] ? $dj_yeardata['xms'] : 0;
                $lists['dj_year_data'][$kvalue]['yearrenshu']  = $dj_yeardata['renshu'] ? $dj_yeardata['renshu'] : 0;
                $lists['dj_year_data'][$kvalue]['yearzsr']     = $dj_yeardata['zsr'] ? $dj_yeardata['zsr'] : "0.00";
                $lists['dj_year_data'][$kvalue]['yearzml']     = $dj_yeardata['zml'] ? $dj_yeardata['zml'] : "0.00";
                $lists['dj_year_data'][$kvalue]['yearmll']     = $dj_yeardata['mll'] ? sprintf("%.2f", $dj_yeardata['mll'] * 100) : "0%";
                $lists['dj_year_data'][$kvalue]['yearopids']   = $dj_yeardata['opids'] ? $dj_yeardata['opids'] :'';
                $lists['dj_year_data'][$kvalue]['yearkindid']  = $kid;
            }

            if ($quartertimes){ //季度
                //地接季度累计
                $req_type       = 801;  //结算
                $dj_q_js_opids  = $this->get_type_dj_js_opids($quarterbegintime, $quarterendtime, $req_type,$dj_opids,$kid);
                $dj_q_js_opids  = array_column($dj_q_js_opids,'op_id');
                $in_quarter_opids = array();
                foreach ($dj_opids as $v){
                    if (!in_array($v,$dj_q_js_opids)){
                        $in_quarter_opids[] = $v;
                    }
                }
                $req_type       = 800;  //预算
                $dj_q_ys_opids  = $this->get_type_dj_ys_opids($quarterbegintime, $quarterendtime, $req_type,$in_quarter_opids,$kid);
                $dj_q_ys_opids  = array_column($dj_q_ys_opids,'op_id');
                $dj_quarterdata = $this->get_ysjshz($dj_q_ys_opids,$dj_q_js_opids);

                if ($dj_quarterdata['xms']){
                    $lists['dj_quarter_data'][$kvalue]['quarterxms']     = $dj_quarterdata['xms'] ? $dj_quarterdata['xms'] : 0;
                    $lists['dj_quarter_data'][$kvalue]['quarterrenshu']  = $dj_quarterdata['renshu'] ? $dj_quarterdata['renshu'] : 0;
                    $lists['dj_quarter_data'][$kvalue]['quarterzsr']     = $dj_quarterdata['zsr'] ? $dj_quarterdata['zsr'] : "0.00";
                    $lists['dj_quarter_data'][$kvalue]['quarterzml']     = $dj_quarterdata['zml'] ? $dj_quarterdata['zml'] : "0.00";
                    $lists['dj_quarter_data'][$kvalue]['quartermll']     = $dj_quarterdata['mll'] ? sprintf("%.2f", $dj_quarterdata['mll'] * 100) : "0%";
                    $lists['dj_quarter_data'][$kvalue]['quarteropids']   = $dj_quarterdata['opids'] ? $dj_quarterdata['opids'] :'';
                    $lists['dj_quarter_data'][$kvalue]['quarterkindid']  = $kid;
                }
            }

            if ($monthtimes){ //月度
                //地接月累计
                $req_type       = 801;  //结算
                $dj_m_js_opids  = $this->get_type_dj_js_opids($monthbegintime, $monthendtime, $req_type,$dj_opids,$kid);
                $dj_m_js_opids  = array_column($dj_m_js_opids,'op_id');
                $in_month_opids = array();
                foreach ($dj_opids as $v){
                    if (!in_array($v,$dj_m_js_opids)){
                        $in_month_opids[] = $v;
                    }
                }
                $req_type       = 800;  //预算
                $dj_m_ys_opids  = $this->get_type_dj_ys_opids($monthbegintime, $monthendtime, $req_type,$in_month_opids,$kid);
                $dj_m_ys_opids  = array_column($dj_m_ys_opids,'op_id');
                $dj_monthdata   = $this->get_ysjshz($dj_m_ys_opids,$dj_m_js_opids);

                if ($dj_monthdata['xms']){
                    $lists['dj_month_data'][$kvalue]['monthxms']     = $dj_monthdata['xms'] ? $dj_monthdata['xms'] : 0;
                    $lists['dj_month_data'][$kvalue]['monthrenshu']  = $dj_monthdata['renshu'] ? $dj_monthdata['renshu'] : 0;
                    $lists['dj_month_data'][$kvalue]['monthzsr']     = $dj_monthdata['zsr'] ? $dj_monthdata['zsr'] : "0.00";
                    $lists['dj_month_data'][$kvalue]['monthzml']     = $dj_monthdata['zml'] ? $dj_monthdata['zml'] : "0.00";
                    $lists['dj_month_data'][$kvalue]['monthmll']     = $dj_monthdata['mll'] ? sprintf("%.2f", $dj_monthdata['mll'] * 100) : "0%";
                    $lists['dj_month_data'][$kvalue]['monthopids']   = $dj_monthdata['opids'] ? $dj_monthdata['opids'] :'';
                    $lists['dj_month_data'][$kvalue]['monthkindid']  = $kid;
                }
            }
        }*/
        $depart_sum_list    = $lists;

        //地接团信息
        $dj_opids       = array_filter(M('op')->group('dijie_opid')->getField('dijie_opid',true));
        $heji           = array();
        foreach ($kinds as $kid=>$kvalue){
            //地接年累计
            $req_type       = 801;  //结算
            $dj_js_opids    = $this->get_type_dj_js_opids($yearbegintime, $yearendtime, $req_type,$dj_opids,$kid);
            $dj_js_opids    = array_column($dj_js_opids,'op_id');
            $in_year_opids  = array();
            foreach ($dj_opids as $v){
                if (!in_array($v,$dj_js_opids)){
                    $in_year_opids[] = $v;
                }
            }

            $req_type       = 800;  //预算
            $dj_ys_opids    = $this->get_type_dj_ys_opids($yearbegintime, $yearendtime, $req_type,$in_year_opids,$kid);
            $dj_ys_opids    = array_column($dj_ys_opids,'op_id');
            $dj_yeardata    = $this->get_ysjshz($dj_ys_opids,$dj_js_opids);

            if ($dj_yeardata['xms']){
                $lists['dijie']['dj_year_data'][$kvalue]['yearxms']     = $dj_yeardata['xms'] ? $dj_yeardata['xms'] : 0;
                $lists['dijie']['dj_year_data'][$kvalue]['yearrenshu']  = $dj_yeardata['renshu'] ? $dj_yeardata['renshu'] : 0;
                $lists['dijie']['dj_year_data'][$kvalue]['yearzsr']     = $dj_yeardata['zsr'] ? $dj_yeardata['zsr'] : "0.00";
                $lists['dijie']['dj_year_data'][$kvalue]['yearzml']     = $dj_yeardata['zml'] ? $dj_yeardata['zml'] : "0.00";
                $lists['dijie']['dj_year_data'][$kvalue]['yearmll']     = $dj_yeardata['mll'] ? sprintf("%.2f", $dj_yeardata['mll'] * 100) : "0%";
                $lists['dijie']['dj_year_data'][$kvalue]['yearopids']   = $dj_yeardata['opids'] ? $dj_yeardata['opids'] :'';
                $lists['dijie']['dj_year_data'][$kvalue]['yearkindid']  = $kid;
            }

            $sum_y_val                                              = $this-> get_sum_ysjs($depart_sum_list,$lists['dijie']['dj_year_data'][$kvalue],$kvalue,'y');
            if ($sum_y_val['yearxms']){
                $lists['heji']['year_data'][$kvalue]['yearxms']     = $sum_y_val['yearxms'] ? $sum_y_val['yearxms'] : 0;
                $lists['heji']['year_data'][$kvalue]['yearrenshu']  = $sum_y_val['yearrenshu'] ? $sum_y_val['yearrenshu'] : 0;
                $lists['heji']['year_data'][$kvalue]['yearzsr']     = $sum_y_val['yearzsr'] ? $sum_y_val['yearzsr'] : "0.00";
                $lists['heji']['year_data'][$kvalue]['yearzml']     = $sum_y_val['yearzml'] ? $sum_y_val['yearzml'] : "0.00";
                $lists['heji']['year_data'][$kvalue]['yearmll']     = $sum_y_val['yearmll'];
                $lists['heji']['year_data'][$kvalue]['yearkindid']  = $sum_y_val['yearkindid'];
            }

            if ($quartertimes){ //季度
                //地接季度累计
                $req_type       = 801;  //结算
                $dj_q_js_opids  = $this->get_type_dj_js_opids($quarterbegintime, $quarterendtime, $req_type,$dj_opids,$kid);
                $dj_q_js_opids  = array_column($dj_q_js_opids,'op_id');
                $in_quarter_opids = array();
                foreach ($dj_opids as $v){
                    if (!in_array($v,$dj_q_js_opids)){
                        $in_quarter_opids[] = $v;
                    }
                }
                $req_type       = 800;  //预算
                $dj_q_ys_opids  = $this->get_type_dj_ys_opids($quarterbegintime, $quarterendtime, $req_type,$in_quarter_opids,$kid);
                $dj_q_ys_opids  = array_column($dj_q_ys_opids,'op_id');
                $dj_quarterdata = $this->get_ysjshz($dj_q_ys_opids,$dj_q_js_opids);

                if ($dj_quarterdata['xms']){
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarterxms']     = $dj_quarterdata['xms'] ? $dj_quarterdata['xms'] : 0;
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarterrenshu']  = $dj_quarterdata['renshu'] ? $dj_quarterdata['renshu'] : 0;
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarterzsr']     = $dj_quarterdata['zsr'] ? $dj_quarterdata['zsr'] : "0.00";
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarterzml']     = $dj_quarterdata['zml'] ? $dj_quarterdata['zml'] : "0.00";
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quartermll']     = $dj_quarterdata['mll'] ? sprintf("%.2f", $dj_quarterdata['mll'] * 100) : "0%";
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarteropids']   = $dj_quarterdata['opids'] ? $dj_quarterdata['opids'] :'';
                    $lists['dijie']['dj_quarter_data'][$kvalue]['quarterkindid']  = $kid;
                }

                $sum_q_val                                              = $this-> get_sum_ysjs($depart_sum_list,$lists['dijie']['dj_quarter_data'][$kvalue],$kvalue,'q');
                if ($sum_q_val['quarterxms']){
                    $lists['heji']['quarter_data'][$kvalue]['quarterxms']     = $sum_q_val['quarterxms'] ? $sum_q_val['quarterxms'] : 0;
                    $lists['heji']['quarter_data'][$kvalue]['quarterrenshu']  = $sum_q_val['quarterrenshu'] ? $sum_q_val['quarterrenshu'] : 0;
                    $lists['heji']['quarter_data'][$kvalue]['quarterzsr']     = $sum_q_val['quarterzsr'] ? $sum_q_val['quarterzsr'] : "0.00";
                    $lists['heji']['quarter_data'][$kvalue]['quarterzml']     = $sum_q_val['quarterzml'] ? $sum_q_val['quarterzml'] : "0.00";
                    $lists['heji']['quarter_data'][$kvalue]['quartermll']     = $sum_q_val['quartermll'];
                    $lists['heji']['quarter_data'][$kvalue]['quarterkindid']  = $sum_q_val['quarterkindid'];
                }
            }

            if ($monthtimes){ //月度
                //地接月累计
                $req_type       = 801;  //结算
                $dj_m_js_opids  = $this->get_type_dj_js_opids($monthbegintime, $monthendtime, $req_type,$dj_opids,$kid);
                $dj_m_js_opids  = array_column($dj_m_js_opids,'op_id');
                $in_month_opids = array();
                foreach ($dj_opids as $v){
                    if (!in_array($v,$dj_m_js_opids)){
                        $in_month_opids[] = $v;
                    }
                }
                $req_type       = 800;  //预算
                $dj_m_ys_opids  = $this->get_type_dj_ys_opids($monthbegintime, $monthendtime, $req_type,$in_month_opids,$kid);
                $dj_m_ys_opids  = array_column($dj_m_ys_opids,'op_id');
                $dj_monthdata   = $this->get_ysjshz($dj_m_ys_opids,$dj_m_js_opids);

                if ($dj_monthdata['xms']){
                    $lists['dijie']['dj_month_data'][$kvalue]['monthxms']     = $dj_monthdata['xms'] ? $dj_monthdata['xms'] : 0;
                    $lists['dijie']['dj_month_data'][$kvalue]['monthrenshu']  = $dj_monthdata['renshu'] ? $dj_monthdata['renshu'] : 0;
                    $lists['dijie']['dj_month_data'][$kvalue]['monthzsr']     = $dj_monthdata['zsr'] ? $dj_monthdata['zsr'] : "0.00";
                    $lists['dijie']['dj_month_data'][$kvalue]['monthzml']     = $dj_monthdata['zml'] ? $dj_monthdata['zml'] : "0.00";
                    $lists['dijie']['dj_month_data'][$kvalue]['monthmll']     = $dj_monthdata['mll'] ? sprintf("%.2f", $dj_monthdata['mll'] * 100) : "0%";
                    $lists['dijie']['dj_month_data'][$kvalue]['monthopids']   = $dj_monthdata['opids'] ? $dj_monthdata['opids'] :'';
                    $lists['dijie']['dj_month_data'][$kvalue]['monthkindid']  = $kid;
                }

                $sum_m_val                                                  = $this-> get_sum_ysjs($depart_sum_list,$lists['dijie']['dj_month_data'][$kvalue],$kvalue,'m');
                if ($sum_m_val['monthxms']){
                    $lists['heji']['month_data'][$kvalue]['monthxms']       = $sum_m_val['monthxms'] ? $sum_m_val['monthxms'] : 0;
                    $lists['heji']['month_data'][$kvalue]['monthrenshu']    = $sum_m_val['monthrenshu'] ? $sum_m_val['monthrenshu'] : 0;
                    $lists['heji']['month_data'][$kvalue]['monthzsr']       = $sum_m_val['monthzsr'] ? $sum_m_val['monthzsr'] : "0.00";
                    $lists['heji']['month_data'][$kvalue]['monthzml']       = $sum_m_val['monthzml'] ? $sum_m_val['monthzml'] : "0.00";
                    $lists['heji']['month_data'][$kvalue]['monthmll']       = $sum_m_val['monthmll'];
                    $lists['heji']['month_data'][$kvalue]['monthkindid']    = $sum_m_val['monthkindid'];
                }
            }
        }

       /* $heji                       = array();
        $heji['yearxms']            = array_sum(array_column($lists, 'yearxms'));
        $heji['yearrenshu']         = array_sum(array_column($lists, 'yearrenshu')) - $dj_heji['yearrenshu'];
        $heji['yearzsr']            = array_sum(array_column($lists, 'yearzsr')) - $dj_heji['yearzsr'];
        $heji['yearzml']            = array_sum(array_column($lists, 'yearzml'));
        $heji['yearmll']            = sprintf("%.2f", ($heji['yearzml'] / $heji['yearzsr']) * 100);
        $heji['yearopids']          = implode(',',array_filter(array_column($lists,'yearopids')));
        $heji['quarterxms']         = array_sum(array_column($lists, 'quarterxms'));
        $heji['quarterrenshu']      = array_sum(array_column($lists, 'quarterrenshu')) - $dj_heji['quarterrenshu'];
        $heji['quarterzsr']         = array_sum(array_column($lists, 'quarterzsr')) - $dj_heji['quarterzsr'];
        $heji['quarterzml']         = array_sum(array_column($lists, 'quarterzml'));
        $heji['quartermll']         = sprintf("%.2f", ($heji['quarterzml'] / $heji['quarterzsr']) * 100);
        $heji['quarteropids']       = implode(',',array_filter(array_column($lists,'quarteropids')));
        $heji['monthxms']           = array_sum(array_column($lists, 'monthxms'));
        $heji['monthrenshu']        = array_sum(array_column($lists, 'monthrenshu')) - $dj_heji['monthrenshu'];
        $heji['monthzsr']           = array_sum(array_column($lists, 'monthzsr')) - $dj_heji['monthzsr'];
        $heji['monthzml']           = array_sum(array_column($lists, 'monthzml'));
        $heji['monthmll']           = sprintf("%.2f", ($heji['monthzml'] / $heji['monthzsr']) * 100);
        $heji['monthopids']         = implode(',',array_filter(array_column($lists,'monthopids')));
        $lists['heji']              = $heji;*/
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
    function get_type_js_opids($users, $begintime, $endtime, $req_type = 801,$kid)
    {
        $where                      = array();
        $where['b.audit_status']    = 1;
        $where['l.req_type']        = $req_type;
        $where['l.audit_time']      = array('between', "$begintime,$endtime");
        $where['a.id']              = array('in', $users);
        $where['o.kind']            = $kid;
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

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
    function get_type_ys_opids($users, $begintime, $endtime, $req_type = 800,$opids='',$kid)
    {
        $where                      = array();
        $where['b.audit_status']    = 1;
        $where['l.req_type']        = $req_type;
        $where['l.audit_time']      = array('between', "$begintime,$endtime");
        $where['a.id']              = array('in', $users);
        $where['o.kind']            = $kid;
        if ($opids){ $where['o.op_id']  = array('not in',$opids); }
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * 预算及结算分部门分类型汇总
     * @param array 所有预算id
     * @param array 所有结算id
     * @return array
     */
    public function get_type_ysjshz($ysopids, $jsopids){
        //从预算取值的团
        /*$fromys = array();
        foreach ($ysopids as $value) {
            if (in_array($value, $jsopids)) {
            } else {
                $fromys[] = $value;
            }
        }*/

        //结算相关费用
        $jswhere = array();
        $jswhere['b.op_id'] = array('in', $jsopids);
        $yswhere = array();
        $yswhere['b.op_id'] = array('in', $ysopids);

        $field = array();
        $field[] = 'count(o.id) as xms';
        $field[] = 'sum(c.num_adult) as renshu';
        $field[] = 'sum(b.shouru) as zsr';
        $field[] = 'sum(b.maoli) as zml';

        $yearjslist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($jswhere)->order('zsr DESC')->find();
        $yearyslist = M()->table('__OP_BUDGET__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id', 'left')->where($yswhere)->order('zsr DESC')->find();

        $opids          = array();
        if ($ysopids){ foreach ($ysopids as $v){ $opids[] = $v;}}
        if ($jsopids){ foreach ($jsopids as $v){ $opids[] = $v;}}

        $data           = array();
        $data['xms']    = $yearjslist['xms'] + $yearyslist['xms'];
        $data['renshu'] = $yearjslist['renshu'] + $yearyslist['renshu'];
        $data['zsr']    = $yearjslist['zsr'] + $yearyslist['zsr'];
        $data['zml']    = $yearjslist['zml'] + $yearyslist['zml'];
        $data['mll']    = $data['zml'] / $data['zsr'];
        //$data['opids']  = array_merge($ysopids,$jsopids);
        $data['opids']  = $opids;
        return $data;
    }

    /**获取地接结算团信息(预算及结算分部门分类型汇总)
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_type_dj_js_opids($begintime, $endtime, $req_type,$dj_opids='',$kindid){
        $where                              = array();
        $where['b.audit_status']            = 1;
        $where['l.req_type']                = $req_type;
        $where['l.audit_time']              = array('between', "$begintime,$endtime");
        $where['o.kind']                    = $kindid;
        if ($dj_opids){ $where['o.op_id']   = array('in',$dj_opids); }
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**获取地接预算团信息(预算及结算分部门分类型汇总)
     * @param $begintime
     * @param $endtime
     * @param $req_type
     */
    function get_type_dj_ys_opids($begintime, $endtime, $req_type,$in_opids='',$kindid){
        $where                              = array();
        $where['b.audit_status']            = 1;
        $where['l.req_type']                = $req_type;
        $where['l.audit_time']              = array('between', "$begintime,$endtime");
        $where['o.kind']                    = $kindid;
        if ($in_opids){ $where['o.op_id']   = array('in',$in_opids); }
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id', 'LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id', 'LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * 求合计
     * @param $lists 各部门数据
     * @param $data 当前类型数据
     * @param $depname 类型名称
     * @param $type y=>年,q=>季度 , m=>月
     */
    public function get_sum_ysjs($lists,$data,$depname,$type){
        $info                               = array();

        $yearxms                            = 0;
        $yearrenshu                         = 0;
        $yearzsr                            = 0;
        $yearzml                            = 0;
        $quarterxms                         = 0;
        $quarterrenshu                      = 0;
        $quarterzsr                         = 0;
        $quarterzml                         = 0;
        $monthxms                           = 0;
        $monthrenshu                        = 0;
        $monthzsr                           = 0;
        $monthzml                           = 0;

        foreach ($lists as $k=>$v){
            if ($type == 'y'){ //年
                $yearxms                    += $v['year_data'][$depname]['yearxms'];
                $yearrenshu                 += $v['year_data'][$depname]['yearrenshu'];
                $yearzsr                    += $v['year_data'][$depname]['yearzsr'];
                $yearzml                    += $v['year_data'][$depname]['yearzml'];

                $info['yearxms']            = $yearxms;
                $info['yearrenshu']         = $yearrenshu;
                $info['yearzsr']            = $yearzsr;
                $info['yearzml']            = $yearzml;
                $info['yearmll']            = (round($info['yearzml']/$info['yearzsr'],4)*100).'%';
                $info['yearkindid']         = $v['year_data'][$depname]['yearkindid'];
            }elseif ($type == 'q'){ //季度
                $quarterxms                 += $v['quarter_data'][$depname]['quarterxms'];
                $quarterrenshu              += $v['quarter_data'][$depname]['quarterrenshu'];
                $quarterzsr                 += $v['quarter_data'][$depname]['quarterzsr'];
                $quarterzml                 += $v['quarter_data'][$depname]['quarterzml'];

                $info['quarterxms']         = $quarterxms;
                $info['quarterrenshu']      = $quarterrenshu;
                $info['quarterzsr']         = $quarterzsr;
                $info['quarterzml']         = $quarterzml;
                $info['quartermll']         = (round($info['quarterzml']/$info['quarterzsr'],4)*100).'%';
                $info['quarterkindid']      = $v['quarter_data'][$depname]['quarterkindid'];
            }elseif ($type == 'm'){ //月度
                $monthxms                   += $v['month_data'][$depname]['monthxms'];
                $monthrenshu                += $v['month_data'][$depname]['monthrenshu'];
                $monthzsr                   += $v['month_data'][$depname]['monthzsr'];
                $monthzml                   += $v['month_data'][$depname]['monthzml'];

                $info['monthxms']           = $monthxms;
                $info['monthrenshu']        = $monthrenshu;
                $info['monthzsr']           = $monthzsr;
                $info['monthzml']           = $monthzml;
                $info['monthmll']           = (round($info['monthzml']/$info['monthzsr'],4)*100).'%';
                $info['monthkindid']        = $v['month_data'][$depname]['monthkindid'];
            }
        }
        return $info;
    }

}