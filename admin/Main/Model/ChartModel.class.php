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
     * 获取某个时间段结算项目
     * @param 用户 (array)
     * @param 开始时间
     * @param 结束时间
     * @param 类型(800=>预算 , 801=>结算)
     * @return mixed
     */
    function get_js_opids($users,$begintime,$endtime,$req_type=801){
        $where = array();
        $where['b.audit_status']		= 1;
        $where['l.req_type']			= $req_type;
        $where['l.audit_time']		    = array('between',"$begintime,$endtime");
        $where['a.id']					= array('in',$users);
        $lists = M()->table('__OP_SETTLEMENT__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->select();

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
    function get_ys_opids($users,$begintime,$endtime,$req_type=800){
        $where = array();
        $where['b.audit_status']		= 1;
        $where['l.req_type']			= $req_type;
        $where['l.audit_time']		    = array('between',"$begintime,$endtime");
        $where['a.id']					= array('in',$users);
        $lists = M()->table('__OP_BUDGET__ as b')->field('o.op_id')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->select();

        return $lists;
    }

    /**
     * 预算结算部门数据
     * @param array 相关部门及人员信息
     * @param 月份 200808
     * @param array 当年开始及结束时间
     * @return array
     */
    public function ysjs_deplist($userlists,$month,$yeartimes){
        //年累计
        $yearbegintime          = $yeartimes['yearBeginTime'];
        $yearendtime            = $yeartimes['yearEndTime'];
        $monthtime              = intval($month);
        $month                  = get_cycle($monthtime,26);
        foreach ($userlists as $k=>$v){
            //年累计
            //年度预算的团
            $req_type			= 800;
            $ysopids            =$this->get_ys_opids($v['users'],$yearbegintime,$yearendtime,$req_type);
            $ysopids            = array_column($ysopids,'op_id');

            //年度结算的团
            $req_type			= 801;
            $jsopids            = $this->get_js_opids($v['users'],$yearbegintime,$yearendtime,$req_type);
            $jsopids            = array_column($jsopids,'op_id');

            //年度数据
            $yeardata           = $this->get_ysjshz($ysopids,$jsopids);
            $yearxms            = $yeardata['xms'];
            $yearrenshu         = $yeardata['renshu'];
            $yearzsr            = $yeardata['zsr'];
            $yearzml            = $yeardata['zml'];
            $yearmll            = $yeardata['mll'];

            $lists[$v['id']]['yearxms']       = $yearxms?$yearxms:0;
            $lists[$v['id']]['yearrenshu']    = $yearrenshu?$yearrenshu:0;
            $lists[$v['id']]['yearzsr']       = $yearzsr?$yearzsr:"0.00";
            $lists[$v['id']]['yearzml']       = $yearzml?$yearzml:"0.00";
            $lists[$v['id']]['yearmll']       = $yearmll?sprintf("%.2f",$yearmll*100):"0.00";

            //月累计
            //月度预算的团
            $req_type			= 800;
            $monthysopids       = $this->get_ys_opids($v['users'],$month['begintime'],$month['endtime'],$req_type);
            $monthysopids       = array_column($monthysopids,'op_id');

            //月度结算的团
            $req_type		    = 801;
            $monthjsopids       = $this->get_js_opids($v['users'],$month['begintime'],$month['endtime'],$req_type);
            $monthjsopids       = array_column($monthjsopids,'op_id');

            //月度数据
            $monthdata           = $this->get_ysjshz($monthysopids,$monthjsopids);
            $monthxms            = $monthdata['xms'];
            $monthrenshu         = $monthdata['renshu'];
            $monthzsr            = $monthdata['zsr'];
            $monthzml            = $monthdata['zml'];
            $monthmll            = $monthdata['mll'];

            $lists[$v['id']]['monthxms']       = $monthxms?$monthxms:0;
            $lists[$v['id']]['monthrenshu']    = $monthrenshu?$monthrenshu:0;
            $lists[$v['id']]['monthzsr']       = $monthzsr?$monthzsr:"0.00";
            $lists[$v['id']]['monthzml']       = $monthzml?$monthzml:"0.00";
            $lists[$v['id']]['monthmll']       = $monthmll?sprintf("%.2f",$monthmll*100):"0.00";
            $lists[$v['id']]['users']         = $v['users'];
            $lists[$v['id']]['id']            = $v['id'];
            $lists[$v['id']]['depname']       = $v['depname'];
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
     * @param array 所有预算id
     * @param array 所有结算id
     * @return array
     */
    public function get_ysjshz($ysopids,$jsopids){
        //从预算取值的团
        $fromys             = array();
        foreach ($ysopids as $value){
            if (in_array($value,$jsopids)){
            }else{
                $fromys[]   = $value;
            }
        }

        //结算相关费用
        $jswhere            = array();
        $jswhere['b.op_id'] = array('in',$jsopids);
        $yswhere            = array();
        $yswhere['b.op_id'] = array('in',$fromys);

        $field              = array();
        $field[]            =  'count(o.id) as xms';
        $field[]            =  'sum(c.num_adult) as renshu';
        $field[]            =  'sum(b.shouru) as zsr';
        $field[]            =  'sum(b.maoli) as zml';

        $yearjslist = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->where($jswhere)->order('zsr DESC')->find();
        $yearyslist = M()->table('__OP_BUDGET__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->where($yswhere)->order('zsr DESC')->find();

        $data               = array();
        $data['xms']        = $yearjslist['xms'] + $yearyslist['xms'];
        $data['renshu']     = $yearjslist['renshu'] + $yearyslist['renshu'];
        $data['zsr']        = $yearjslist['zsr'] + $yearyslist['zsr'];
        $data['zml']        = $yearjslist['zml'] + $yearyslist['zml'];
        $data['mll']        = $data['zml']/$data['zsr'];
        return $data;
    }

}