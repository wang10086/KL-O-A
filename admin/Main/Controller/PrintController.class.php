<?php
/**
 * Date: 2019/1/13
 * Time: 14:04
 */

namespace Main\Controller;
use Sys\P;

use Think\Controller;

class PrintController extends Controller{

    //打印借款单
    public function printLoanBill(){
        $id                             = I('jkids');
        $ids                            = explode(',',$id);
        $data                           = M()->table('__JIEKUAN__ as j')->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where(array('j.id'=>array('in',$ids)))->select();
        foreach ($data as $k=>$v){
            if ($v['jkd_type']==1){
                $field                  = 'o.group_id,o.project,l.req_uname';
                $where                  = array();
                $where['o.op_id']       = $v['op_id'];
                $where['l.req_type']    = P::REQ_TYPE_BUDGET;
                $info                   = M()->table('__OP__ as o')->field($field)->join('__OP_BUDGET__ as b on b.op_id = o.op_id','left')->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')->where($where)->find();
                $data[$k]['project']    = $info['project'];
                $data[$k]['req_uname']  = $info['req_uname'];
            }
        }

        $lists                          = array_chunk($data,3,false);
        $this->jk_type                  = C('JIEKUAN_TYPE');
        $this->company                  = C('COMPANY');
        $this->lists                    = $lists;
        $this->display();
    }


    //打印 报销单(多张)
    public function printReimbursements(){
        $id                             = I('bxids');
        $ids                            = explode(',',$id);
        $data                           = M()->table('__BAOXIAO__ as b')->join('__BAOXIAO_AUDIT__ as a on a.BX_id=b.id','left')->where(array('b.id'=>array('in',$ids)))->select();
        foreach ($data as $k=>$v){
            if ($v['bxd_type']==1){      //团内借款报销
                $opids                      = explode(',',$v['opids']);
                $field                      = 'o.group_id,o.project,l.req_uname';
                $where                      = array();
                $where['o.op_id']           = array('in',$opids);
                $where['l.req_type']        = P::REQ_TYPE_BUDGET;
                $info                       = M()->table('__OP__ as o')->field($field)->join('__OP_BUDGET__ as b on b.op_id = o.op_id','left')->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')->where($where)->select();
                $data[$k]['project']        = implode(',',array_column($info,'project'));
                $data[$k]['req_uname']      = implode(',',array_unique(array_column($info,'req_uname')));
            }
        }
        $lists                          = array_chunk($data,3,false);
        $this->jk_type                  = C('JIEKUAN_TYPE');
        $this->company                  = C('COMPANY');
        $this->lists                    = $lists;
        $this->display();
    }
}