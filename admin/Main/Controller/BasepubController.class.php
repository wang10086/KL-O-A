<?php
namespace Main\Controller;
use Think\Controller;
use Org\Util\Rbac;
use Sys\P;

class BasepubController extends Controller {
    
    private $_cssaddon;
    private $_scriptaddon;
    private $_jscode;

    protected $_pagetitle_ = '';
    protected $_pagedesc_  = '';
    protected $_action_    = '';

    public $_sum_audit = 0;
    
    // 初始化函数
	public function _initialize()
	{
		
		
		
		$this->_cssaddon = array();
		$this->_scriptaddon = array();
		$this->_jscode = array();
		
		$this->__additional_css__    = '';
		$this->__additional_js__     = '';
		$this->__additional_jscode__ = '';
		
		$this->_sum_audit = $this->get_sum_audit();
		
		$this->assign('_pagetitle_', $this->_pagetitle_);
		$this->assign('_pagedesc_',  $this->_pagedesc_);
		$this->assign('_action_',    $this->_action_);
		$this->assign('_sum_audit',    $this->_sum_audit);
		
		
    }
    
    /*
     * 设置页面主标题，在右侧主页面区域上方显示
     * @access protected
     * @param string $str  标题字符串
     * @return void
     *
     */
    protected function title($str) {
        $this->_action_ = $str;
        $this->assign('_action_',    $this->_action_);
    }
    
    
    /*
     * 获取待我审批的和我申请的未审批数据数量，用来显示气泡提示
     * @access protected
     * @param 
     * @return int  统计数据
     *
     */
    protected function get_sum_audit ()
    {
        $sum = 0;
		/*
        $where = "(req_uid=" . session('userid');
        $where .= " or instr(concat(',',audit_roleid,','), ',". session('roleid') .",') > 0 )";
        $where .= " and audit_time = 0";
		*/
		$where = "dst_status = 0 and ";
		$where .= " ( instr(concat(',',audit_roleid,','), ',". session('roleid') .",') > 0 or 1=" .session('roleid').") " ;
        $sum = M('audit_log')->where($where)->count();
        return $sum;
    }
    
   /*
    * 为页面额外添加CSS样式文件
    * @access protected
    * @param string $fname  CSS文件名，不需要写.css后缀。自动从assets/css 目录寻找同名文件
    * @return void     
    * 
    */
    protected final function css($fname) 
    {
        $fname = preg_replace('/\.css$/', '', $fname);
        $this->_cssaddon[] = '<link href="'.__ROOT__. '/admin/assets/css/'.$fname.'.css" rel="stylesheet" type="text/css" />';
        $this->__additional_css__ = join(PHP_EOL, $this->_cssaddon);
        //$this->assign('__additional_css__', join(PHP_EOL, $this->_cssaddon));
    }

    /*
     * 为页面额外添加javascript文件
     * @access protected
     * @param string $fname  Javascript文件名，不需要写.js后缀。自动从assets/js 目录寻找同名文件
     * @return void
     *
     */
    protected  final function js($fname) 
    {
        $fname = preg_replace('/\.js$/', '', $fname);
        $this->_scriptaddon[] = '<script type="text/javascript" src="' .__ROOT__. '/admin/assets/js/'.$fname.'.js"></script>';
        $this->__additional_js__ = join(PHP_EOL, $this->_scriptaddon);
        //$this->assign('__additional_js__', join(PHP_EOL, $this->_scriptaddon));
    }
    
    protected final function jscode($value)
    {
        $this->_jscode[] = '<script type="text/javascript">' . PHP_EOL . $value . PHP_EOL . '</script>';
        $this->__additional_jscode__ = join(PHP_EOL, $this->_jscode);
    }
	
	
	protected final function orders($field=''){
		
		$cname = strtolower(CONTROLLER_NAME);
		$aname = strtolower(ACTION_NAME);
		
		$order_field = I('cookie.'.$cname.'_'.$aname.'_ofield', $field);
		$order_type  = I('cookie.'.$cname.'_'.$aname.'_otype', 'desc');
		
		$order ='';
		if($order_field) $order = $order_field . ' ' .$order_type;

		$this->js('plugins/cookie/jquery.cookie');
		$this->jscode(" var order_page = '".$cname."_".$aname."'; ");
		$this->jscode("$(document).ready(function(){ init_order(); });");	
		
		
		return $order;
	}
	
	
	/*
	protected final function request_audit($req_type, $req_id, $req_reason = '', $src_status = P::AUDIT_STATUS_NOT_AUDIT,  $req_uid = null, $req_uname = null)
	{
	    // 如果没有指定用户ID 则使用当前登录用户
	    if (!$req_uid) {
	        $req_uid    = session('userid');
	        $req_uname  = session('nickname');
	    }
	    
	    $data = array();
	    $data['req_type']     = $req_type;
	    $data['req_id']       = $req_id;
	    $data['req_reason']   = $req_reason;
	    $data['req_uid']      = $req_uid;
	    $data['req_uname']    = $req_uname;
	    $data['req_time']     = time();
	    $data['req_table']    = M('audit_field')->where('req_type='.$req_type)->getField('table');
	    $data['src_status']   = $src_status;
	    $roleids = M('audit_config')->field('group_concat(audit_roleid) as rid')->where('req_type='.$req_type)->find();
	    $data['audit_roleid'] =$roleids['rid'];
	    
	    $data['audit_uid']   = 0;
	    $data['audit_uname'] = '';
	    $data['audit_reason']= '';
	    $data['audit_time']  = 0;
	    $data['dst_status']  = 0;
	    
	    return M('audit_log')->add($data);
	    
	}
	
	protected final function do_audit($audit_id, $audit_reason = '', $dst_status = P::AUDIT_STATUS_PASS, $audit_param = '') 
	{
	    $id   = intval($audit_id);
	    $row  = M('audit_log')->find($id);
	    
	    if (!$row) {
	        $this->msg = "非法操作";
	        $this->display('audit_ok');
	        die();
	    } 
	    
	    if ($row['dst_status'] != P::AUDIT_STATUS_NOT_AUDIT ) {
	       // return P::ERROR;
	    }
	    $data = array();
	    
	    $data['audit_uid']   = session('userid');
	    $data['audit_uname'] = session('nickname');
	    $data['audit_reason']= $audit_reason;
	    $data['audit_time']  = time();
	    $data['dst_status']  = $dst_status;
	    $data['audit_param'] = $audit_param;
	    
	    M()->table('__' . strtoupper($row['req_table']) . '__')
	       ->where('id='.$row['req_id'])->setField('audit_status', $dst_status);
	    
	    // 物资入库处理
	    if ($row['req_type'] == P::REQ_TYPE_GOODS_IN  && $dst_status == P::AUDIT_STATUS_PASS) {
	       
		    $dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();
			$matelist = M('material_into')->where(array('batch_id'=>$dstdata['id']))->select();
			foreach($matelist as $v){
				$at = M('material_into')->data(array('audit_status'=>$dst_status))->where(array('id'=>$v['id']))->save();
				if($at){
					 if($dst_status == P::AUDIT_STATUS_PASS ){
						 $wzinfo = M('material')->find($v['material_id']);
						 if($v['type']){
							  M('material')->where(array('id'=>$v['material_id']))->setField(array('stock'=>$wzinfo['stock']+$v['amount']));
						 }else{
							  M('material')->where(array('id'=>$v['material_id']))->setField(array('price'=>$v['unit_price'], 'stock'=>$wzinfo['stock']+$v['amount']));
						 }
						 
						 if($v['op_id']){
							 $shuliang = M('op_material')->where(array('op_id'=>$v['op_id'],'material'=>$v['material']))->find();
							 M('op_material')->where(array('op_id'=>$v['op_id'],'material'=>$v['material']))->data(array('returnsum'=>($shuliang['returnsum']+$v['amount'])))->save();
						 }
					 
					 }
				}
			}

	    }
	    
	    // 物资出库处理
	    if ($row['req_type'] == P::REQ_TYPE_GOODS_OUT) {
			$dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();
			$matelist = M('material_out')->where(array('batch_id'=>$dstdata['id']))->select();
			foreach($matelist as $v){
				$at = M('material_out')->data(array('audit_status'=>$dst_status))->where(array('id'=>$v['id']))->save();
				if($at){
					 if($dst_status == P::AUDIT_STATUS_PASS ){
						 M('material')->where(array('id'=>$v['material_id']))->setDec('stock', $v['amount']);
					 }
					 if($v['op_id'] && $dst_status == P::AUDIT_STATUS_PASS){
						 $shuliang = M('op_material')->where(array('op_id'=>$v['op_id'],'material'=>$v['material']))->find();
						 M('op_material')->where(array('op_id'=>$v['op_id'],'material'=>$v['material']))->data(array('outsum'=>($shuliang['outsum']+$v['amount'])))->save();
				     }
				}
			}
			
	    }
		
		// 物资采购申请
	    if ($row['req_type'] == P::REQ_TYPE_GOODS_PURCHASE) {
			$dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();
			$matelist = M('material_purchase')->where(array('batch_id'=>$dstdata['id']))->select();
			foreach($matelist as $v){
				$at = M('material_purchase')->data(array('audit_status'=>$dst_status))->where(array('id'=>$v['id']))->save();
				if($v['op_id'] && $dst_status == P::AUDIT_STATUS_PASS){
					 M('op_material')->where(array('op_id'=>$v['op_id'],'material'=>$v['material']))->setInc('purchasesum', $v['amount']);
				}
			}
			
	    }
		
		// 预算审批
	    if ($row['req_type'] == P::REQ_TYPE_BUDGET) {
			$dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();
			
			//在预算前所建立的物资都无效，需要在预算审批之后调度的才有效
			M('op_cost')->where(array('op_id'=>$dstdata['op_id'],'cost_type'=>4))->delete();
			M('op_material')->where(array('op_id'=>$dstdata['op_id']))->delete();
			
			$matelist = M('op_costacc')->where(array('op_id'=>$dstdata['op_id'],'status'=>1,'type'=>1))->select();
			foreach($matelist as $v){
				
				$wuzi = M('material')->field('id')->where(array('material'=>$v['title']))->find();
				$matedata = array();
				$matedata['op_id'] = $dstdata['op_id'];
				$matedata['material'] = $v['title'];
				$matedata['remarks']  = $v['remark'];
				$matedata['material_id']  = $wuzi['id'];
				$mateid = M('op_material')->add($matedata);
				
				$matecost = array();
				$matecost['op_id'] = $dstdata['op_id'];
				$matecost['item']  = '物资费';
				$matecost['cost']  = $v['unitcost'];
				$matecost['amount']  = $v['amount'];
				$matecost['total']  = $v['total'];
				$matecost['cost_type']  = 4;
				$matecost['remark']  = $v['title'];
				$matecost['relevant_id']  = $wuzi['id'];
				$matecost['link_id']  = $mateid;
				M('op_cost')->add($matecost);
				
			}
			
			$record = array();
			$record['op_id']   = $dstdata['op_id'];
			$record['optype']  = 10;
			if($dst_status == P::AUDIT_STATUS_PASS){
				 $record['explain'] = '预算审核通过'; 
			}else{
				 $record['explain'] = '预算审核未通过'; 
			}
			op_record($record);
			
	    }
	    
	    // 价格申请处理
	    if ($row['req_type'] == P::REQ_TYPE_PRICE  && $dst_status == P::AUDIT_STATUS_PASS) {
	        $price = intval($audit_param);
	        $srcdata = M()->table('__' . strtoupper($row['req_table']) . '__')
	                     ->where('id='.$row['req_id'])->find(); 
	        
	        $data['srcdata'] = "op_cost.cost=[" .$srcdata['cost'] ."]  op_cost.total=[" . $srcdata['total'] ."]";
	        $data['dstdata'] = "op_cost.cost=[" .$price ."]  op_cost.total=[" . $price*$srcdata['amount'] ."]";
	        
	        M('op_cost')->where('id=' . $row['req_id'])
	                    ->setField(array('cost'=>$price, 'total'=>$price*$srcdata['amount']));
	    }
		
		
		//项目审核通知
		if ($row['req_type'] == P::REQ_TYPE_PROJECT_NEW){
			 
			 $pro = M('op')->find($row['req_id']);
			 $record = array();
			 $record['op_id']   = $pro['op_id'];
			 $record['optype']  = 9;
			 if($dst_status == P::AUDIT_STATUS_PASS){
				  $record['explain'] = '项目审核通过'; 
			 }else{
				  $record['explain'] = '项目审核未通过'; 
			 }
			 op_record($record);
			 
	    }
	    
	    return M('audit_log')->where('id='.$id)->save($data);    
	}
	*/

	/*########系统自动生成工单工作质量记录#########*/
	public function worder_log(){
        $worder_db          = M('worder');
        $work_db            = M('work_record');
        $where              = array();
        $sta                = array(0,1,2,-3);  //-3需要做二次修改
        $where['status']    = array('in',$sta);
        $time               = NOW_TIME;
        $lists              = $worder_db->where($where)->select();
        $wd_ids             = $work_db->getField('wd_id',true);

        foreach ($lists as $v){
            if ($v['plan_complete_time'] < $time and $v['ini_confirm_time'] == 0){
                $w_id           = $v['id'];
                if (in_array($w_id,$wd_ids)){
                    exit();
                    //判断该工单是否已经记录 , 防止重复记录
                }else{
                    $info           = array();
                    $info['year']   = date("Y");
                    $info['month']  = date("Ym");
                    $info['user_id']= $v['exe_user_id'];
                    $info['user_name']  = $v['exe_user_name'];
                    $info['dept_id']    = $v['exe_dept_id'];
                    $info['dept_name']  = $v['exe_dept_name'];
                    $info['title']      = $v['worder_title'];
                    $info['content']    = $v['worder_content'];
                    $info['type']       = 4;    //工作未完成
                    $info['rec_user_id']= 0;    //记录者id 为系统自动生成
                    //$info['typeinfo']
                    //$info['rec_user_name']
                    $info['rec_time']   = NOW_TIME;
                    $info['status']     = 0;
                    $info['wd_id']      = $w_id;
                    $res = $work_db->add($info);
                    if ($res){
                        //发送系统通知消息
                        $uid     = 0;
                        $title   = '您有来自[系统自动生成的工作未完成记录],请及时处理!';
                        $content = '';
                        $url     = U('Work/record',array('com'=>1));
                        $user    = '['.$info['user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }
                }
            }
        }
    }
}


