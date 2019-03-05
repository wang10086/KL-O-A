<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class KpiModel extends Model
{

    //保存 月度/季度/半年度KPI信息
    public function addKpiInfo($year,$user,$cycle,$month=0,$quarter=0,$half_year=0,$yearCycle=0){
        if ($month)     $yearm  = $year.sprintf('%02s',$month);
        if ($quarter)   $yearm  = getQuarterMonths($quarter,$year);
        if ($half_year) $yearm  = getHalfYearMonths($half_year,$year);
        if ($yearCycle) $yearm  = getFullYearMonths($year);

        //获取用户信息
        $acc                    = M('account')->find($user);

        //判断月份是否存在
        $where                  = array();
        $where['month']         = $yearm;
        $where['user_id']       = $user;

        /*//删除以前的旧数据
        $delKpi                 = array();
        $delKpi['user_id']      = $acc['id'];
        $delKpi['year']         = $year;
        $delKpi['cycle']        = array('neq',$cycle);
        $delKpiIds              = '';
        for($a=$month;$a<13;$a++){
            if (strlen($a)<2) $a = str_pad($a,2,'0',STR_PAD_LEFT);
            $ym                 = $year.$a;
            $delKpi['month']    = array('like','%'.$ym.'%');
            $delKpiId           = M('kpi')->where($delKpi)->getField('id');
            $delKpiIds          = $delKpiIds.','.$delKpiId;
        }
        $arr_delKpiIds          = array_unique(array_filter(explode(',',$delKpiIds)));
        $arr                    = array();
        if ($arr_delKpiIds) $arr['id']  = array('in',$arr_delKpiIds);
        M('kpi')->where($arr)->delete();
        $delKpiMore             = array();
        $delKpiMore['kpi_id']   = array('in',$arr_delKpiIds);
        M('kpi_more')->where($delKpiMore)->delete();*/

        //查询这个月的KPI信息
        $kpi = M('kpi')->where($where)->find();

        //如果不存在新增
        if(!$kpi){
            //获取评分人信息
            $pfr = M('auth')->where(array('role_id'=>$acc['roleid']))->find();
            $info['ex_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
            $info['mk_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
            $info['user_id']        = $acc['id'];
            $info['user_name']      = $acc['nickname'];
            $info['role_id']        = $acc['roleid'];
            $info['status']         = 0;
            $info['year']           = $year;
            $info['month']          = $yearm;
            $info['create_time']    = time();
            $info['cycle']          = $cycle;
            $info['quarter']        = $quarter;
            $info['half_year']      = $half_year;
            $kpiid = M('kpi')->add($info);
        }else{
            $kpiid = $kpi['id'];
        }

        //获取考核指标信息
        $postid = $acc['postid'];
        $quto   = M()->table('__KPI_POST_QUOTA__ as r')->field('c.*')->join('__KPI_CONFIG__ as c on c.id = r.quotaid')->where(array('r.postid'=>$postid))->select();

        if($quto){
            foreach($quto as $k=>$v){

                //整理数据
                $data = array();
                $data['user_id']            = $user;
                $data['kpi_id']             = $kpiid;
                $data['year']               = $year;
                $data['month']              = $yearm;
                $data['quota_id']           = $v['id'];
                $data['quota_title']        = $v['quota_title'];
                $data['quota_content']      = $v['quota_content'];
                $data['weight']             = $v['weight'];
                $data['status']             = 0;
                $data['create_time']        = time();
                $data['cycle']              = $cycle;

                $where                      = array();
                $where['month']             = $yearm;
                $where['quota_id']          = $v['id'];
                $where['kpi_id']            = $kpiid;
                $more = M('kpi_more')->where($where)->find();

                if(!$more){
                    if ($month){ //月度周期
                        $zhouqi                 = set_month($yearm);
                        $zhouqi['begin_time']   = $zhouqi[0];
                        $zhouqi['end_time']     = $zhouqi[1];
                    }
                    if ($quarter){ //季度周期
                        $zhouqi                 = set_quarter($year,$quarter);
                    }
                    if ($half_year){ //半年度周期
                        $zhouqi                 = $this->set_half_year_cycle($year,$half_year);
                    }
                    if ($yearCycle){ //年度周期
                        $zhouqi                 = array();
                        $zhouqi['begin_time']   = strtotime(($year-1).'1226');
                        $zhouqi['end_time']     = strtotime($year.'1226');
                    }
                    $data['start_date']         = $zhouqi['begin_time'];
                    $data['end_date']           = $zhouqi['end_time'];
                    M('kpi_more')->add($data);
                }else{
                    M('kpi_more')->data($data)->where(array('id'=>$more['id']))->save();
                }
            }
        }

    }

    function set_half_year_cycle($year,$half_year){
        $data                       = array();
        switch ($half_year){
            case 1:
                $data['begin_time'] = strtotime(($year-1).'1226');
                $data['end_time']   = strtotime($year.'0626');
                break;
            case 2:
                $data['begin_time'] = strtotime($year.'0626');
                $data['end_time']   = strtotime($year.'1226');
        }
        return $data;
    }


}