<?php
/**
 * Date: 2019/12/09
 * Time: 16:13
 */

namespace Main\Model;


use Think\Model;
use Sys\P;

class OpModel extends Model{

    //创建一个地接团
    public function create_dejie_op($opid , $info ,$op){
        $new_op                         = array();
        /*$project                        = '【地接团】'.$op['project'];
        $new_op['project']              = str_replace('【发起团】','',$project);*/
        /*$groupid                        = $op['dijie_name'].date('Ymd',$gtime);
        //团号信息
        $count_groupids                 = M('op')->where(array('group_id'=>array('like','%'.$groupid.'%')))->count();
        $new_op['group_id']             = $count_groupids?$groupid.'-1'.$count_groupids:$groupid;*/
        $new_op['project']              = create_dj_project($op['project']);
        $new_op['op_id']                = opid();
        $gtime                          = $info['dep_time']?$info['dep_time']:time();
        $new_op['group_id']             = get_group_id($op['dijie_name'],$gtime);
        $new_op['number']               = $op['number'];
        $new_op['departure']            = $op['departure'];
        $new_op['days']                 = $op['days'];
        $new_op['destination']          = $op['destination'];
        $new_op['create_time']          = NOW_TIME;
        $new_op['status']               = 1; //已成团
        $new_op['context']              = '地接项目';
        $new_op['audit_status']         = 1; //默认审核通过
        $new_op['create_user']          = C('DIJIE_CREATE_USER')[$op['dijie_name']];
        $new_op['create_user_name']     = M('account')->where(array('id'=>$new_op['create_user']))->getField('nickname');
        $new_op['kind']                 = $op['kind'] == 83 ? 84 :$op['kind']; //83=>组团研学旅行,84=>地接研学旅行
        $new_op['sale_user']            = $new_op['create_user_name'];
        $group                          = M('op')->where(array('op_id'=>$opid))->getField('group_id');
        $group                          = strtoupper(substr($group,0,4));
        $arr_group                      = array('JQXN','JQXW','JWYW');
        if (in_array($group,$arr_group)){
            $new_op['customer']         = '北京总部';
        }else{
            $new_op['customer']         = C('DIJIE_NAME')[$group];
        }
        $new_op['op_create_date']       = date('Y-m-d',time());
        $new_op['op_create_user']       = M()->table('__ACCOUNT__ as a')->join('left join __ROLE__ as r on r.id = a.roleid')->where(array('a.id'=>$new_op['create_user']))->getField('r.role_name');
        $new_op['apply_to']             = $op['apply_to'];
        $new_op['type']                 = 1; //1=>已成团, (所有的费用带入系统预算)

        //地接成团确认
        $dijie_confirm                  = array();
        $dijie_confirm['op_id']         = $new_op['op_id'];
        $dijie_confirm['group_id']      = $new_op['group_id'];
        $dijie_confirm['dep_time']      = $info['dep_time'];
        $dijie_confirm['ret_time']      = $info['ret_time'];
        $dijie_confirm['num_adult']     = $info['num_adult'];
        $dijie_confirm['num_children']  = $info['num_children'];
        $dijie_confirm['days']          = $info['days'];
        $dijie_confirm['user_id']       = $new_op['create_user'];
        $dijie_confirm['user_name']     = $new_op['user_name'];
        $dijie_confirm['confirm_time']  = NOW_TIME;
        $opres                          = M('op')->add($new_op);

        if ($opres) {
            M('op_team_confirm')->add($dijie_confirm);
            $data                       = array();
            $data['hesuan']             = $new_op['create_user'];
            $data['line']               = $new_op['create_user'];
            $auth                       = M('op_auth')->where(array('op_id'=>$new_op['op_id']))->find();

            if($auth){
                M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
            }else{
                $data['op_id']          = $new_op['op_id'];
                M('op_auth')->add($data);
            }

            //系统消息提醒
            $uid     = cookie('userid');
            $title   = '您有来自【'.$op['project'].'】的地接团，请及时跟进!';
            $content = '项目名称：'.$new_op['project'].'；团号：'.$new_op['group_id'].'；请及时跟进！"';
            $url     = U('Op/plans_follow',array('opid'=>$new_op['op_id']));
            $user    = '['.$new_op['create_user'].']';
            $roleid  = '';
            send_msg($uid,$title,$content,$url,$user,$roleid);

            $record                     = array();
            $record['op_id']            = $new_op['op_id'];
            $record['optype']           = 4;
            $record['explain']          = '创建地接项目并成团';
            op_record($record);
        }

        return $new_op['op_id'];
    }

    //保存标准化模块
    public function save_create_op_product($opid , $costacc, $resid='', $num=0){
        M('op_product')->where(array('op_id'=>$opid))->delete();
        foreach ($costacc as $k=>$v){
            $v['op_id']     = $opid;
            $v['total']     = floatval($v['unitcost'])*intval($v['amount']);
            $v['status']    = 0;    //核算

            if($resid && $resid[$k]['id']){
                $edits      = M('op_costacc')->data($v)->where(array('id'=>$resid[$k]['id']))->save();
                $delid[]    = $resid[$k]['id'];
                if ($edits) $num++;
            }else{
                $savein     = M('op_costacc')->add($v);
                $delid[]    = $savein;
                if($savein) $num++;
            }
            $del            = M('op_costacc')->where(array('op_id'=>$opid,'type'=>5,'status'=>0,'id'=>array('not in',$delid)))->delete();
            if ($del) $num++;

            $data           = array();
            $data['op_id']  = $opid;
            $data['product_id'] = $v['product_id'];
            $data['amount'] = $v['amount'];
            $res = M('op_product')->add($data);
            if ($res) $num++;
        }
        return $num;
    }

    //立项时保存成本核算(标准化产品)
    public function save_create_op_costacc($opid , $producted_id){

        $db                             = M('producted_material');
        $op_costacc_db                  = M('op_costacc');
        $lists                          = $db->where(array('producted_id'=>$producted_id))->select();
        foreach ($lists as $k=>$v){
            $data                       = array();
            $data['op_id']              = $opid;
            $data['title']              = $v['material'];
            $data['unitcost']           = $v['unitprice'];
            $data['amount']             = $v['amount'];
            $data['total']              = $v['total'];
            $data['remark']             = $v['remark'];
            $data['type']               = $v['type'];
            $data['status']             = 0; //0=>成本核算
            $data['supplier_id']        = $v['supplierRes_id'];
            $data['supplier_name']      = $v['channel'];
            $op_costacc_db->add($data);
        }
    }

    //立项时创建工单
    public function save_create_op_worder($addok , $info , $exe_user_id){
        $id                         = $info['kind'];
        $pro_info                   = M('project_kind')->where(array('id'=>$id) )->find();
        $pid                        = $pro_info['pid'];
        $pro_name                   = $pro_info['name'];
        $worder                     = array();
        $worder['op_id']            = M("op")->where(array('id'=>$addok))->getField('op_id');
        $worder['worder_title']     = $info['project'];
        $worder['worder_content']   = $info['context'];
        $worder['worder_type']      = 100;
        $worder['status']           = 0;
        $worder['ini_user_id']      = cookie('userid');
        $worder['ini_user_name']    = cookie('name');
        $worder['ini_dept_id']      = cookie('roleid');
        $worder['ini_dept_name']    = cookie('rolename');
        $worder['create_time']      = NOW_TIME;
        $u_time                     = 5;    //默认5个工作日
        //计划完成时间 $u_time为工作日
        $worder['plan_complete_time']= strtotime(getAfterWorkDay($u_time));

        if($exe_user_id){
            foreach ($exe_user_id as $k=>$v){
                if ($v==12){
                    $worder['kpi_type'] = 1;    //公司研发
                }elseif ($v==26){
                    $worder['kpi_type'] = 2;    //公司资源
                } elseif ($v==31){
                    $worder['kpi_type'] = 3;    //京区校内研发
                }elseif ($v==174){
                    $worder['kpi_type'] = 4;    //京区校内资源
                }
                $exe_user_info      = M('account')->field('nickname,roleid')->where(array('id'=>$v))->find();
                $exe_user_id        = $v;
                $exe_user_name      = $exe_user_info['nickname'];
                $exe_dept_id        = $exe_user_info['roleid'];
                $exe_dept_name      = M('role')->where(array('id'=>$exe_dept_id))->getField('role_name');
                $worder['exe_dept_id']      = $exe_dept_id;
                $worder['exe_dept_name']    = $exe_dept_name;
                $worder['exe_user_id']      = $exe_user_id;
                $worder['exe_user_name']    = $exe_user_name;
                $res = M('worder')->add($worder);
                if($res){
                    //保存操作记录
                    $record = array();
                    $record['worder_id'] = $res;
                    $record['type']     = 0;
                    $record['explain']  = '立项/创建工单';
                    worder_record($record);
                    //发送系统消息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$worder['ini_dept_name'].'--'.$worder['ini_user_name'].']的工单待执行!';
                    $content = '该工单为项目工单，现已立项通过，前期需要研发、资源等相关部门的协助。项目名称：'.$worder['worder_title'].'；备注信息：'.$worder['worder_content'];
                    $url     = U('worder/worder_info',array('id'=>$res));
                    $user    = '['.$worder['exe_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');
                }
            }
        }
    }
}