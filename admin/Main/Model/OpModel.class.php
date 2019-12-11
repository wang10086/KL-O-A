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
}