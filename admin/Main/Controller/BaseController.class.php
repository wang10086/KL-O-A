<?php
namespace Main\Controller;
use Think\Controller;
use Org\Util\Rbac;
use Sys\P;

class BaseController extends Controller {
    
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
		
		if(!in_array(ACTION_NAME,explode(",",C('NOT_AUTH_ACTION')))){
			if(cookie('userid')){
				if(ACTION_NAME!='public_lock' && ACTION_NAME!='online' && ACTION_NAME!='public_serverdata'){
					//更新账户时间
					M('admin')->data(array('update_time'=>time()))->where(array('id'=>cookie('userid')))->save();
			    }
			}else{
				if(cookie('username')){
					header("location: ".U('Index/public_lockscreen','','',true)."");
				}else{
					$this->error('您尚未登陆，请先登录！',U('Main/Index/login'));	
					die();
				}
			}
			
		}
		
		//P($_SESSION['_ACCESS_LIST']['MAIN']);
		
		
		$notAuth =  strpos(ACTION_NAME, 'public_') === 0;

		if (!$notAuth) {
			if (C('RBAC_SUPER_ADMIN') != cookie('userid')){
				if( !Rbac::AccessDecision()) {
					Rbac::checkLogin();
					$this->error('无权访问',U('Main/Index/login'));
					//P($_SESSION);
				}
			} 
		}
		
		
		$this->_cssaddon                = array();
		$this->_scriptaddon             = array();
		$this->_jscode                  = array();
		
		$this->__additional_css__       = '';
		$this->__additional_js__        = '';
		$this->__additional_jscode__    = '';
		
		$this->_sum_audit               = $this->get_sum_audit();
        $this->_no_read_cas_res         = $this->get_no_read_res(P::UNREAD_CAS_RES);
		
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

                //判断预算毛利率是否达到指定标准
                $maolilv            = $dstdata['maolilv'];
                $rate               = get_grossProftRate($dstdata['op_id']); //该项目类型应该最低毛利率

                $real_rate          = round(str_replace('%','',$maolilv)/100,4);
                $should_rate        = round(str_replace('%','',$rate)/100,4);

                if (($real_rate < $should_rate) && !in_array(session('userid'),array(11))) { //实际毛利率低于目标毛利率
                    //修改审核结果状态
                    $data['dst_status'] = P::AUDIT_STATUS_MORE_AUDIT;
                    M()->table('__' . strtoupper($row['req_table']) . '__')
                        ->where('id='.$row['req_id'])->setField('audit_status', P::AUDIT_STATUS_MORE_AUDIT);
                    $record['explain'] = '预算毛利率未达标,待复批';
                    ////_bak20190724
                    /*$should_audit_uid   = 11;
                    $audit_more_id      = do_audit_more($id,$should_audit_uid);

                    if ($audit_more_id){
                        //修改审核结果状态
                        $data['dst_status'] = P::AUDIT_STATUS_MORE_AUDIT;
                        M()->table('__' . strtoupper($row['req_table']) . '__')
                            ->where('id='.$row['req_id'])->setField('audit_status', P::AUDIT_STATUS_MORE_AUDIT);

                        //发送系统消息
                        $op         = M('op')->where(array('op_id'=>$dstdata['op_id']))->field('op_id,project,group_id,create_user_name')->find();
                        $uid        = cookie('userid');
                        $title      = '您有预算毛利率较低的团待复审,团号['.$op['group_id'].'],请及时处理!';
                        $content    = '项目名称：'.$op['project'].'，团号：'.$op['group_id'].'，业务：'.$op['create_user_name'];
                        $url        = U('Right/audit_more',array('id'=>$audit_more_id));
                        $user       = '['.$should_audit_uid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }*/
                }
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

        //结算审核
        if ($row['req_type'] == P::REQ_TYPE_SETTLEMENT) {
            $dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();
            $record = array();
            $record['op_id']   = $dstdata['op_id'];
            $record['optype']  = 10;
            if($dst_status == P::AUDIT_STATUS_PASS){
                $record['explain'] = '结算审核通过';

                //判断预算毛利率是否达到指定标准
                $maolilv            = $dstdata['maolilv'];
                $rate               = get_grossProftRate($dstdata['op_id']); //该项目类型应该最低毛利率

                $real_rate          = round(str_replace('%','',$maolilv)/100,4);
                $should_rate        = round(str_replace('%','',$rate)/100,4);

                if (($real_rate < $should_rate) && !in_array(session('userid'),array(11))) { //实际毛利率低于目标毛利率
                    //修改审核结果状态
                    $data['dst_status'] = P::AUDIT_STATUS_MORE_AUDIT;
                    M()->table('__' . strtoupper($row['req_table']) . '__')
                        ->where('id='.$row['req_id'])->setField('audit_status', P::AUDIT_STATUS_MORE_AUDIT);
                    $record['explain'] = '结算毛利率未达标,待复批';
                }else{
                    $op             = M('op')->where(array('op_id'=>$dstdata['op_id']))->find();
                    if ($op['add_group'] == 1){ //拼团
                        save_op_groups_settlement($op);
                    }
                }
            }else{
                $record['explain'] = '结算审核未通过';
            }
            op_record($record);

        }

        // 回款审核
        if ($row['req_type'] == P::REQ_TYPE_HUIKUAN) {
            $dstdata = M()->table('__' . strtoupper($row['req_table']) . '__')->where('id='.$row['req_id'])->find();

            $record = array();
            $record['op_id']   = $dstdata['op_id'];
            $record['optype']  = 10;
            if($dst_status == P::AUDIT_STATUS_PASS){



                //回款计划处理
                if($dstdata['payid']){
                    $paydata	= array();
                    $pay		= M('contract_pay')->find($dstdata['payid']);
                    $pay_amount = $dstdata['huikuan']+$pay['pay_amount'];
                    if($pay_amount >= $pay['amount']){
                        $paydata['status']	= 2;
                    }else{
                        $paydata['status']	= 1;
                    }
                    $paydata['pay_amount']	= $pay_amount;
                    //$paydata['pay_time']		= $dstdata['huikuan_time'];
                    $paydata['pay_time']		= NOW_TIME;

                    M('contract_pay')->where(array('id'=>$dstdata['payid']))->data($paydata)->save();

                    //计入结算
                    $huikuan = M('op_huikuan')->where(array('cid'=>$pay['cid'],'audit_status'=>1))->sum('huikuan');
                    M('contract')->data(array('payment'=>$huikuan))->where(array('id'=>$pay['cid']))->save();
                }


                $record['explain'] = '回款审核通过';
            }else{
                $record['explain'] = '回款审核未通过';
            }
            op_record($record);

        }

        //审核科普资源
        if ($row['req_type'] == P::REQ_TYPE_SCIENCE_RES_NEW  && $dst_status == P::AUDIT_STATUS_PASS){
            $user_list                          = get_company_user();
            $read                               = array();
            $read['type']                       = P::UNREAD_CAS_RES;
            $read['req_id']                     = $row['req_id'];
            $read['userids']                    = implode(',',array_column($user_list,'id'));
            $read['create_time']                = NOW_TIME;
            $read['read_type']                  = 0;
            M('unread')->add($read);

        }

        return M('audit_log')->where('id='.$id)->save($data);
    }

	/**
     * ajaxPageHtml 分页
     * $count 总数 $page当前页面 $limit显示条数 $fan方法名
	 */
    public function ajaxPageHtml($count,$page,$limit,$fan){
        $total = ceil($count/$limit);
        if ($total == 1) {
            return $str;
        }
        $b5page = $page-5;
        $n5page = $page+5;
        if($page-5 <= 0){
            $b5page = 1;
            $n5page = $b5page+10;
        }else if($page+5 > $total){
            $b5page = $total-10;
            if ($b5page <= 0) {
                $b5page = 1;
            }
            $n5page = $total;
        }

        $str = '<div class="pagestyle"><ul><li class="active"><a href="javascript:;">总共'.$total.' 条</a></li>';
        if ($page != 1) {
            $str .= "<li class='pageunit'><a href='javascript:;' onclick='(".$fan."("."1))'>首 页</a></li>";
            $str .= "<li class='pageunit'><a href='javascript:;' onclick='(".$fan."(".($page-1)."))'>上一页</a></li>";
        }else{
            $str .= "<li class='active'><a href='javascript:;'>首 页</a></li>";
            $str .= "<li class='active'><a href='javascript:;'>上一页</a></li>";
        }
        for ($i=1; $i <= $total; $i++) {
            if($i>=$b5page && $i<=$n5page){
                if ($page == $i) {
                    $str .= "<li class='active'><a class='act' href='javascript:;'>$i</a></li>";
                }else{
                    $str .= "<li class='pageunit'><a href='javascript:;' onclick='(".$fan."(".$i."))'>$i</a></li>";
                }
            }
        }
        if ($page != $total) {
            $str .= "<li class='pageunit'><a href='javascript:;' onclick='(".$fan."(".($page+1)."))'>下一页</a></li>";
            $str .= "<li class='pageunit'><a href='javascript:;' onclick='(".$fan."(".$total."))'>末 页</a></li>";
        }else{
            $str .= "<li class='active'><a href='javascript:;'>下一页</a></li>";
            $str .= "<li class='active'><a href='javascript:;'>末 页</a></li>";
        }
        $str .= '<li class="active"><a href="javascript:;">当前'.$page.'/'.$total.' 页</a></li></ul></div>';
        return $str;
    }

    /**
     * salary_datetime 工资系统提醒条数
     */
    public function salary_datetime(){
        if($_SESSION['userid']==11 ||$_SESSION['userid']==55 || $_SESSION['userid']==77){//判断人员

            $time_Y                                 = date('Y');
            $time_M                                 = date('m');
            $time_D                                 = date('d');
            if($time_D < 10){
                if($time_M==1){
                    $time_Y = $time_Y-1;
                    $time_M = 13;
                }
                $time_M = $time_M-1;
                if($time_M < 10) {
                    $que['datetime']                = $time_Y.'0'.$time_M;//查询年月
                }else{
                    $que['datetime']                = $time_Y.$time_M;//查询年月
                }
            }

            switch ($_SESSION['userid'])
            {
                case 77:
                    $money                          = M('salary_count_money')->where($que)->count();
                    if(!$money){
                        $count                      = 1;
                    }
                    $_SESSION['salary_satus']       = $count;
                    return $count;break;
                case 55:
                    $status['status']               = 2;
                    $money                          = M('salary_count_money')->where($status)->count();
                    if($money){
                        $count                      = $money;
                        $_SESSION['salary_satus']   = $count;
                    }
                    return $count;break;
                case 11:
                    $status['status']               = 3;
                    $money                          = M('salary_count_money')->where($status)->count();
                    if($money){
                        $count                      = $money;
                        $_SESSION['salary_satus']   = $count;
                    }
                    return $count;  break;
            }
        }
    }

    /**
     * file_remind_number 文件提醒条数
     */
//   public function file_remind_number()
//   {
//       $useid                           = $_SESSION['userid'];//用户id
//       $sun                             = 0;//信息条数
//       $file                            = M('approval_flie')->where()->select();
//       foreach($file as $key =>$val){
//           $where = array();
//            $where['file_id']             = $val['id'];
//            $annotatio                    = M('approval_annotation')->where($where)->find();
//            if($annotatio){//判断有无文件批注
//                if($useid==13 && $annotatio['statu']==2){$where['statu']=2;$where['file_id']=$val['id'];}//判断综合
//
//                $conside                  = explode(',', $val['file_consider']);//显示审议人员id
//                if(in_array($useid,$conside) && $annotatio['statu']==3){$where['statu']=3;$where['file_id']=$val['id'];}//判断审议
//
//                $judgment                 = explode(',', $val['file_judgment']);//显示终审人员id
//                if(in_array($useid,$judgment) && $annotatio['statu']==4){$where['statu']=4;$where['file_id']=$val['id'];}//判断终审
//
//                $where['account_id']      = $useid;
//                $annotation               = M('approval_annotation')->where($where)->find();//判断状态文件是否存在
//                if(!$annotation){$sun     = $sun+1;}//没有查到文件
//            }else{
//                $where['account_id']      =  $val['pid'];
//                if($useid==$val['pid']){//判断上级
//                    $where['type']        = 1;
//                    $annotation           = M('approval_annotation')->where($where)->find();
//                    if(!$annotation){$sun = $sun+1;}// 有文件没有批注
//                }
//            }
//       }
//       $_SESSION['file_sum']              = $sun;//保存缓存
//        return $sun;
//   }


    /**
     * file_remind_number 文件提醒条数
     */
    public function file_remind_number()
    {
        $useid                              = $_SESSION['userid'];//用户id
        $sun                                = 0;//信息条数
        $file                               = M('approval_flie')->select();
        foreach($file as $key =>$val){
            $where                          = array();
            $where['file_id']               = $val['id'];
            $annotatio                      = M('approval_annotation')->where($where)->find();
            if($annotatio){//判断有无文件批注
                if($useid==$val['pid'] && $annotatio['statu']==1){$sun  = $sun+1; }//判断综合
                if($useid==13 && $annotatio['statu']==2){ $sun  = $sun+1;}//判断综合
                if($val['account_id']==$useid && $annotatio['statu']==6){$sun  = $sun+1;} //驳回

                $conside                    = explode(',', $val['file_consider']);//显示审议人员id
                if(in_array($useid,$conside) && $annotatio['statu']==3){//判断审议
                    $where['type']          = 3;
                    $where['account_id']    = $useid;
                    $annotation2            = M('approval_annotation')->where($where)->find();//判断状态文件是否存在
                    if(!$annotation2){$sun  = $sun+1;}//没有查到文件
                }
                $judgment                   = explode(',', $val['file_judgment']);//显示终审人员id
                if(in_array($useid,$judgment) && $annotatio['statu']==4){//判断终审
                    $where['type']          = 4;
                    $where['account_id']    = $useid;
                    $annotation3            = M('approval_annotation')->where($where)->find();//判断状态文件是否存在
                    if(!$annotation3){$sun  = $sun+1;}//没有查到文件
                }
            }else{
                if($useid==$val['pid']){//判断上级有文件没有批注
                 $sun                       = $sun+1;
                }
            }
        }
        $_SESSION['file_sum']               = $sun;//保存缓存
        return $sun;
    }

    /**
     * 未查看的资源
     * @param $type 类型
     * @return int
     */
    protected final function get_no_read_res($type){
        $db                                 = M('unread');
        $where                              = ' type = '.$type.' and ';
        $where                              .= ' read_type = 0 ';
        $lists                              = $db ->where($where)->select();
        $num                                = 0;
        foreach ($lists as $k=>$v){
            $user_ids                       = explode(',',$v['userids']);
            if (in_array(session('userid'),$user_ids)){
                $num++;
            }
        }
        return $num;
    }

    /**查看资源
     * @param $req_id
     * @param $type
     */
    protected final function read_res($req_id,$type){
        $db                                 = M('unread');
        $where                              = ' type = '.$type.' and ';
        $where                              .= ' req_id = '.$req_id;
        $list                               = $db ->where($where)->find();
        $user_ids                           = explode(',',$list['userids']);
        foreach ($user_ids as $k =>$v){
            if ($v == session('userid')) unset($user_ids[$k]);
        }
        $userids                            = implode(',',$user_ids);
        $db -> where('id = '.$list['id'])->setField('userids',$userids);
    }

    /**
     * 删除资源
     * @param $id
     * @param $type
     */
    protected final function del_read($id,$type){
        $db                                 = M('unread');
        $where                              = ' req_id = '.$id.' and ';
        $where                              .= ' type = '.$type;
        $db->where($where)->delete();
    }
}


