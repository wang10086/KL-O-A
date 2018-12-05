<?php
/**
 * Date: 2018/12/4
 * Time: 11:14
 */

namespace Main\Model;
use Think\Model;
use Sys\P;


class ChartModel extends Model{

    /**
     * 已结算分部门汇总
     * 1.部门信息(array)
     * 2.年月Ym
     * 3.年份时间戳(array)
     * 4.状态 0=>预算及结算; 1=>结算
     */
    public function js_deplist($userlists,$month,$yeartimes,$pin=0){

        $monthtime      = intval($month);
        $month          = get_cycle($monthtime,26);
        $lists          = array();
        foreach ($userlists as $k => $v) {
            //年度累计
            $where = array();
            $where['b.audit_status']		= 1;
            $where['l.req_type']			= 801;
            $where['l.audit_time']		    = array('between',"$yeartimes[yearBeginTime],$yeartimes[yearEndTime]");
            $where['a.id']					= array('in',$v['users']);

            $field = array();
            $field[] =  'count(o.id) as xms';
            $field[] =  'sum(c.num_adult) as renshu';
            $field[] =  'sum(b.shouru) as zsr';
            $field[] =  'sum(b.maoli) as zml';
            $field[] =  '(sum(b.maoli)/sum(b.shouru)) as mll';

            $yearlist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->where($where)->order('zsr DESC')->find();
            $lists[$v['id']]['yearxms']       = $yearlist['xms']?$yearlist['xms']:0;
            $lists[$v['id']]['yearrenshu']    = $yearlist['renshu']?$yearlist['renshu']:0;
            $lists[$v['id']]['yearzsr']       = $yearlist['zsr']?$yearlist['zsr']:"0.00";
            $lists[$v['id']]['yearzml']       = $yearlist['zml']?$yearlist['zml']:"0.00";
            $lists[$v['id']]['yearmll']       = $yearlist['mll']?sprintf("%.2f",$yearlist['mll']*100):"0.00";

            //查询月度
            $where = array();
            $where['b.audit_status']		= 1;
            $where['l.req_type']			= 801;
            $where['l.audit_time']		    = array('between',"$month[begintime],$month[endtime]");
            $where['a.id']					= array('in',$v['users']);

            $field = array();
            $field[] =  'count(o.id) as xms';
            $field[] =  'sum(c.num_adult) as renshu';
            $field[] =  'sum(b.shouru) as zsr';
            $field[] =  'sum(b.maoli) as zml';
            $field[] =  '(sum(b.maoli)/sum(b.shouru)) as mll';

            $monthlist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->where($where)->order('zsr DESC')->find();

            $lists[$v['id']]['monthxms']    = $monthlist['xms']?$monthlist['xms']:0;
            $lists[$v['id']]['monthrenshu'] = $monthlist['renshu']?$monthlist['renshu']:0;
            $lists[$v['id']]['monthzsr']    = $monthlist['zsr']?$monthlist['zsr']:"0.00";
            $lists[$v['id']]['monthzml']    = $monthlist['zml']?$monthlist['zml']:"0.00";
            $lists[$v['id']]['monthmll']    = $monthlist['mll']?sprintf("%.2f",$monthlist['mll']*100):"0.00";
            $lists[$v['id']]['users']       = $v['users'];
            $lists[$v['id']]['id']          = $v['id'];
            $lists[$v['id']]['depname']     = $v['depname'];
        }
        $heji                   = array();
        $heji['yearxms']        = array_sum(array_column($lists,'yearxms'));
        $heji['yearrenshu']     = array_sum(array_column($lists,'yearrenshu'));
        $heji['yearzsr']        = array_sum(array_column($lists,'yearzsr'));
        $heji['yearzml']        = array_sum(array_column($lists,'yearzml'));
        $heji['yearmll']        = sprintf("%.2f",($heji['yearzml']/$heji['yearzsr'])*100);
        $heji['monthxms']       = array_sum(array_column($lists,'monthxms'));
        $heji['monthrenshu']    = array_sum(array_column($lists,'monthrenshu'));
        $heji['monthzsr']       = array_sum(array_column($lists,'monthzsr'));
        $heji['monthzml']       = array_sum(array_column($lists,'monthzml'));
        $heji['monthmll']       = sprintf("%.2f",($heji['monthzml']/$heji['monthzsr'])*100);
        $lists['heji']          = $heji;
        return $lists;
    }

    /**
     * 获取某个时间段(预算/结算)项目
     * @param 用户 (array)
     * @param 开始时间
     * @param 结束时间
     * @param 类型(800=>预算 , 801=>结算)
     * @return mixed
     */
    function get_time_opids($users,$begintime,$endtime,$req_type=801){
        $where = array();
        $where['b.audit_status']		= 1;
        $where['l.req_type']			= $req_type;
        $where['l.audit_time']		    = array('between',"$begintime,$endtime");
        $where['a.id']					= array('in',$users);
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->select();

        return $lists;
    }
}