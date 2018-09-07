<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

// @@@NODE-2###Rights###申请和审批###
class RightsController extends BaseController {
    
    protected $_pagetitle_ = '审批和申请';
    protected $_pagedesc_  = '';
 
    // @@@NODE-3###index###审批数据列表###
    public function index ()
    {
        $this->title('待审批列表');
        
        $this->req_types = C('REQ_TYPES');
        $this->status    = I('status','-1');
		$where = '';
        if($this->status=='1') $where .= "dst_status = 1 and ";
		if($this->status=='2') $where .= "dst_status = 2 and ";
		if($this->status=='0') $where .= "dst_status = 0 and ";
		$where .= " ( instr(concat(',',audit_roleid,','), ',". session('roleid') .",') > 0 or 1=" .session('roleid').") " ;
        $adb = M('audit_log');
        $cfgdb = M('audit_field');
        $resdb = M();
        
		$pagecount = $adb->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		

        $rs = $adb->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('req_time'))->select();
		
		
                
        foreach ($rs as $k => $row) {
            $cfg = $cfgdb->where('req_type='.$row['req_type'])->find();
            $res = $resdb->table('__' . strtoupper($cfg['table']) . '__')->field($cfg['field'])->find($row['req_id']);
            $rs[$k]['cfgdata'] = $cfg;
            $rs[$k]['resdata'] = $res;
            
            $field = explode(',', $cfg['field']);
            $title = explode(',', $cfg['title']);
            $other = '';
            for ($i = 2; $i < count($field); $i++) {
                $other .= $title[$i].':'.$res[$field[$i]] . '&nbsp;&nbsp;';
            }
            $rs[$k]['other'] = $other;
            $rs[$k]['req_type_name'] = $cfg['name'];

            //团号+计调人员 + 回款金额
            $fid                = $row['req_id'];
            $budget             = M('op_huikuan')->find($fid);
            $opid               = $budget['op_id'];
            $rs[$k]['group_id']    = M('op')->where(array('op_id'=>$opid))->getfield('group_id');

            //回款金额
            $rs[$k]['amount'] 	    = M('op_huikuan')->where(array('id'=>$row['req_id']))->getfield('huikuan');

            //计调人员
            $rs[$k]['jidiao'] = M()->table('__OP__ as o')->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where("o.op_id = $opid")->getfield('a.nickname');

        }

        $this->lists = $rs;
        //var_dump($this->lists);die;
		
		
         $this->audit_status = array (
                P::AUDIT_STATUS_NOT_AUDIT  => '未审核',
                P::AUDIT_STATUS_PASS       => '<span class="green">审核通过</span>',
                P::AUDIT_STATUS_NOT_PASS   => '<span class="red">未通过</span>',
        );

        $this->display('index');
    }
    
    
    // @@@NODE-3###myreq###我的申请列表###
    public function myreq ()
    {
        $this->title('我的申请列表');
    
        $this->req_types = C('REQ_TYPES');
    
        $where = " req_uid = ". session('userid') ;
        $adb = M('audit_log');
        $cfgdb = M('audit_field');
        $resdb = M();
		
		$pagecount = $adb->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
    
        $rs = $adb->where($where)->limit($page->firstRow . ',' . $page->listRows)
        ->order('req_time DESC')->select();
    
        foreach ($rs as $k => $row) {
            $cfg = $cfgdb->where('req_type='.$row['req_type'])->find();
            $res = $resdb->table('__' . strtoupper($cfg['table']) . '__')->field($cfg['field'])->find($row['req_id']);
            $rs[$k]['cfgdata'] = $cfg;
            $rs[$k]['resdata'] = $res;
    
            $field = explode(',', $cfg['field']);
            $title = explode(',', $cfg['title']);
            $other = '';
            for ($i = 2; $i < count($field); $i++) {
                $other .= $title[$i].':'.$res[$field[$i]] . '&nbsp;&nbsp;';
            }
            $rs[$k]['other'] = $other;
            $rs[$k]['req_type_name'] = $cfg['name'];
    
        }
    
        $this->lists = $rs;
        $this->audit_status = array (
                P::AUDIT_STATUS_NOT_AUDIT  => '未审核',
                P::AUDIT_STATUS_PASS       => '审核通过',
                P::AUDIT_STATUS_NOT_PASS   => '未通过',
        );
    
        $this->display('myreq');
    }
    
    // @@@NODE-3###audit_page###申请权限###
    public function audit_req ()
    {
        $id = I('id');
        $req_type = I('req_type');
        $info = I('info');
        
        if (isset($_POST['dosubmit'])) {

            $rs = $this->request_audit($req_type, $id, $info['req_reason']);
            
            if ($rs == P::ERROR) {
                $this->msg = "状态不符，操作失败！";
            } else {
                $this->msg = "操作成功！";
            }
            $this->display('audit_ok');
        } else {
            $this->id = I('id');
            $this->req_type = I('req_type');
            if ($this->req_type == P::REQ_TYPE_PRICE) {
                $this->display('audit_req');
            } else {
                $this->display('audit_req_price');
            }
        }
    }
   
    // @@@NODE-3###audit_apply###审批操作###
    public function audit_apply () {
        $id = I('id');
        $info = I('info');
        $req_type = I('req_type');

        if (isset($_POST['dosubmit'])) {
            $rs = $this->do_audit($id, $info['audit_reason'], $info['dst_status'], $info['param']);
            $this->rs = $rs;
            if ($rs == P::ERROR) {
                $this->msg = "状态不符，操作失败！";
            } else {
                $this->msg = "操作成功！";
            }
            $this->display('audit_ok');
        } else {
            
            $this->id = I('id');
            $this->req_type = M('audit_log')->where("id=".$this->id)->getField('req_type');
            $this->display('audit_apply');
        }
    }

}


