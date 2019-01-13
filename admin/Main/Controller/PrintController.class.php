<?php
/**
 * Date: 2019/1/13
 * Time: 14:04
 */

namespace Main\Controller;
use Sys\P;

use Think\Controller;

class PrintController extends Controller{

    //打印报销单
    function printLoanBill(){
        $id             = I('jkids');
        $ids            = explode(',',$id);
        $field          = 'j.*,a.*,o.group_id,o.project,l.req_uname';
        $data           = M()->table('__JIEKUAN__ as j')
            ->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')
            ->join('__OP__ as o on o.op_id = j.op_id','left')
            ->join('__OP_BUDGET__ as b on b.op_id = j.op_id','left')
            ->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')
            ->where(array('j.id'=>array('in',$ids),'l.req_type'=>P::REQ_TYPE_BUDGET))
            ->select();

       $lists           = array_chunk($data,2,false);

        $this->jk_type  = C('JIEKUAN_TYPE');
        $this->lists    = $lists;
        $this->display();
    }
}