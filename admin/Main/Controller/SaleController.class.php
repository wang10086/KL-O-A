<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Op###计调操作###
class SaleController extends BaseController {
    
    protected $_pagetitle_ = '计调操作';
    protected $_pagedesc_  = '';
    
	
    // @@@NODE-3###index###出团计划列表###
    public function index(){
        $this->title('出团计划列表');
		
		$db = M('op');
		$opid     = I('opid');
		$groupid     = I('groupid');
		$project     = I('project');
		$departure   = I('departure');
		$destination = I('destination');
		
		$where = array();
		$where['o.audit_status'] = 1;
		$where['p.id'] = array('gt',0);
		if($opid)        $where['o.op_id'] = $opid;
		if($groupid)     $where['o.group_id'] = $groupid;
		if($project)     $where['o.project'] = array('like','%'.$project.'%');
		if($departure)   $where['o.departure'] = array('like','%'.$departure.'%');;
		if($destination) $where['o.destination'] = array('like','%'.$destination.'%');
		
		//分页
		$pagecount = $db->table('__OP__ as o')->field('o.*')->join('__OP_PRETIUM__ as p on p.op_id = o.op_id')->group('o.op_id')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->table('__OP__ as o')->field('o.*')->join('__OP_PRETIUM__ as p on p.op_id = o.op_id')->group('o.op_id')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();
		foreach($lists as $k=>$v){
			$cost = M('op_pretium')->where(array('op_id'=>$v['op_id']))->order('sale_cost')->find();	
			$lists[$k]['sale_cost'] = $cost['sale_cost'];
			$lists[$k]['peer_cost'] = $cost['peer_cost'];
		}
		
		
		$this->lists   = $lists;
		
		$this->display('index');
    }
	
	
	
    // @@@NODE-3###order###销售记录###
    public function order(){
        $this->title('销售记录');
		
		$db = M('order');
		$orderid  = I('orderid');
		$opid     = I('opid');
		$groupid  = I('groupid');
		$keywords = I('keywords');
		
		$where = array();
		if($orderid)  $where['o.order_id'] = $orderid;
		if($opid)     $where['o.op_id'] = $opid;
		if($groupid)  $where['o.group_id'] = $groupid;
		if($keywords)  $where['p.project'] = array('like','%'.$keywords.'%');
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->lists = $db->table('__ORDER__ as o')->field('o.*,p.project')->join('__OP__ as p on p.op_id = o.op_id','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('sales_time'))->select();
		
		
		$this->kinds   =  M('project_kind')->getField('id,name', true);
		
		$this->display('order');
    }
	
	
	
	
	// @@@NODE-3###goods###产品详情###
    public function goods(){
		
		$opid = I('opid');
		$id   = I('id');
		if($id){
			$op   = M('op')->where($where)->find($id);
			$opid = $op['op_id'];		
		}else if($opid){
			$where = array();
			$where['op_id'] = $opid;
			$op   = M('op')->where($where)->find();	
		}
		
		if(!$op){
			$this->error('项目不存在');	
		}
		
		$pro        = M('product')->find($op['product_id']);
		$pretium    = M('op_pretium')->where(array('op_id'=>$opid))->order('id')->select();
		$days       = M('op_line_days')->where(array('op_id'=>$opid))->select();
		$member     = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
		
		//客户详情
		$this->kh = M('customer_gec')->where(array('company_name'=>$op['customer']))->find();
		
		$this->kinds          = M('project_kind')->getField('id,name', true);
		$this->op             = $op;
		$this->pro            = $pro;
		$this->pretium        = $pretium;
		$this->days           = $days;
		$this->member         = $member;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->display('goods');
	}
    
	
	
	//@@@NODE-3###signup###我要报名###
    public function signup(){
		$opid       = I('opid');
		$id         = I('id');
		$info       = I('info');
		$member     = I('member');
		$fornum     = I('fornum');
		
		if(isset($_POST['dosubmit']) && $info){
			
			//保存订单
			$orderid = date('Ymd').rand(1000,9999);   //订单号
			$info['order_id']          = $orderid;
			$info['op_id']             = $opid;
			$info['number']            = $info['amount']*$fornum;
			$info['sales_person']      = cookie('name');
			$info['sales_person_uid']  = cookie('userid');
			$info['sales_time']        = time();
			
			if(!M('order')->where(array('order_id'=>$orderid))->find()){
				M('order')->add($info);
			}
			
			//保存名单
			if($member){
				foreach($member as $v){
					if($v['name'] || $v['sex'] || $v['number'] || $v['mobile'] || $v['remark']){
						$data = array();
						$data = $v;
						$data['op_id']            = $opid;
						$data['order_id']         = $orderid;
						$data['sales_person_uid'] = cookie('userid');
						$data['sales_time']       = time();
						//if(!M('op_member')->where($data)->find()){
							M('op_member')->add($data);
						//}
					}
				}	
			}
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			$sale             = M('op_pretium')->find($id);
			$this->fornum     = $sale['adult']+$sale['children'];
			$this->sale       = $sale;
			$this->opid       = $opid;
			$this->id         = $id;
			$this->op         = M('op')->where(array('op_id'=>$opid))->find();	
			$this->display('signup');
		}
	}
    
	
	
	// @@@NODE-3###order_viwe###订单详情###
    public function order_viwe(){
		
		$oid = I('oid');
		
		$order      = M('order')->where(array('order_id'=>$oid))->find();
		if($order){
			$opid       = $order['op_id'];
			$op         = M('op')->where(array('op_id'=>$opid))->find();
			$pretium    = M('op_pretium')->find($order['pretium_id']);
			$days       = M('op_line_days')->where(array('op_id'=>$opid))->select();
			$member     = M('op_member')->where(array('order_id'=>$oid))->order('id')->select();
			
			$this->op             = $op;
			$this->order          = $order;
			$this->pro            = $pro;
			$this->pretium        = $pretium;
			$this->days           = $days;
			$this->member         = $member;
			$this->save_member    = count($member);
			$this->fornum         = $pretium['adult']+$pretium['children'];
			$this->business_depts = C('BUSINESS_DEPT');
			$this->subject_fields = C('SUBJECT_FIELD');
			$this->ages           = C('AGE_LIST');
			$this->display('order_viwe');
		}else{
			$this->error('订单不存在');
		}
	}
	
	
	// @@@NODE-3###edit_order###修改订单名单###
	public function edit_order(){
		$opid = I('opid');
		$order_id = I('order_id');
		$member = I('member');
		$op_member_db   = M('op_member');
		
		$delid = array();
		foreach($member as $k=>$v){
			$data = array();
			$data = $v;
			if($resid && $resid[$k]['id']){
				$edits = $op_member_db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
				$delid[] = $resid[$k]['id'];
				$num++;
			}else{
				$data['op_id'] = $opid;
				$data['order_id'] = $order_id;
				$data['sales_person_uid'] = cookie('userid');
				$data['sales_time']       = time();
				$savein = $op_member_db->add($data);
				$delid[] = $savein;
				if($savein) $num++;
				
				//将名单保存至客户名单
				if(!M('member')->where(array('number'=>$v['number']))->find()){
					M('member')->add($v);
				}
			}
		}	
		
		$where = array();
		$where['op_id'] = $opid;
		if($delid) $where['id'] = array('not in',$delid);
		$del = $op_member_db->where($where)->delete();
		if($del) $num++;
		
		
		echo $num;
	}

	//最低毛利率
    public function gross(){
        //$lists                              = M()->table('__PROJECT_KIND__ as k')->join('__GROSS__ as g on g.kind = k.id','left')->field('k.id,k.name,g.gross,g.input_time,g.input_user_name')->order($this->orders('g.id'))->select();
        $lists                              = M('project_kind')->field('id,name')->select();
        foreach($lists as $k=>$v){
            $data                           = M('gross')->where(array('kind_id'=>$v['id']))->order($this->orders('id'))->find();
            $lists[$k]['gross']             = $data['gross'];
            $lists[$k]['input_time']        = $data['input_time'];
            $lists[$k]['input_user_name']   = $data['input_user_name'];
        }

        $this->lists                        = $lists;
        $this->display();
    }

    public function edit_gross(){
        $kind_id                            = I('kid');
        if (!$kind_id) $this->error('获取数据失败');
        $list                               = M('project_kind')->where(array('id'=>$kind_id))->find();
        $this->row                          = $list;
        $this->display();
    }

    public function public_save(){
        $savetype                           = I('savetype');
        if (isset($_POST['dosubmint']) && $savetype){

            //保存最低毛利率
            if ($savetype == 2){
                $db                         = M('gross');
                $info                       = I('info');
                if (!$info['gross']) $this->error('最低毛利率不能为空');
                $info['gross']              = trim($info['gross']);
                $info['input_time']         = NOW_TIME;
                $info['input_user_id']      = session('userid');
                $info['input_user_name']    = session('nickname');
                $db->add($info);
            }
        }
    }

    //公司毛利率
    public function chart_gross(){
        $year                               = I('year',date('Y'));
        $times                              = get_year_cycle($year);
        $mod                                = D('Sale');
        $kinds                              = M('project_kind')->getField('id,name',true);
        $gross_avg                          = $mod->get_gross_avg($kinds,$times['beginTime'],$times['endTime']); //最低毛利率数据
        $settlement_no_dj_lists             = $mod->get_no_dj_settlement_lists($times['beginTime'],$times['endTime']); //排除地接团数据
        $settlement_lists                   = $mod->get_all_settlement_lists($times['beginTime'],$times['endTime']); //未排除地接团数据
        $data                               = $mod->get_company_sum_gross($settlement_no_dj_lists,$settlement_lists,$kinds,$gross_avg); //获取公司总合计数据
        $info                               = $data['info'];
        $info['合计']                       = $data['合计'];

        $this->lists                        = $info;
        $this->year                         = $year;
        $this->prveyear                     = $year-1;
        $this->nextyear                     = $year+1;
        $this->display();
    }

    //各计调毛利率
    public function chart_jd_gross(){
        $year                               = I('year',date('Y'));
        $times                              = get_year_cycle($year);
        $mod                                = D('Sale');
        $kinds                              = M('project_kind')->getField('id,name',true);
        $gross_avg                          = $mod->get_gross_avg($kinds,$times['beginTime'],$times['endTime']); //最低毛利率数据
        $settlement_lists                   = $mod->get_all_settlement_lists($times['beginTime'],$times['endTime']);
        $operator                           = array_column($settlement_lists,'req_uname','req_uid');
        $data                               = $mod->get_gross($operator,$settlement_lists,$kinds,$gross_avg); //各计调数据
        $sum                                = $mod->get_sum_gross($settlement_lists,$kinds,$gross_avg); //获取公司总合计数据

        $this->lists                        = $data;
        $this->sum                          = $sum;
        $this->year                         = $year;
        $this->prveyear                     = $year-1;
        $this->nextyear                     = $year+1;
        $this->display();
    }

    //计调各业务类型毛利率
    public function gross_jd_info(){
        $jd_id                              = I('jid');
        $jd_name                            = I('jname');
        $year                               = I('year',date('Y'));
        $times                              = get_year_cycle($year);
        $mod                                = D('Sale');
        $kinds                              = M('project_kind')->getField('id,name',true);
        $gross_avg                          = $mod->get_gross_avg($kinds,$times['beginTime'],$times['endTime']); //最低毛利率数据
        $settlement_lists                   = $mod->get_all_settlement_lists($times['beginTime'],$times['endTime']);

        if ($jd_id == '888888' || $jd_name == '公司合计'){
            $data                           = $mod->get_sum_gross($settlement_lists,$kinds,$gross_avg);
        }else{
            $data                           = $mod->get_jd_gross($jd_id,$jd_name,$settlement_lists,$kinds,$gross_avg); //各计调数据
        }
        $info                               = $data['info'];
        $info['合计']                       = $data['合计'];
        $this->lists                        = $info;
        $this->year                         = $year;
        $this->display();
    }

    //计调业务毛利率项目详情
    public function gross_op_list(){
        $mod                                = D('Sale');
        $opids                              = I('opids')?explode(',',I('opids')):'';
        $year                               = I('year',date('Y'));
        $times                              = get_year_cycle($year);
        $kinds                              = M('project_kind')->getField('id,name',true);
        $gross_avg                          = $mod->get_gross_avg($kinds,$times['beginTime'],$times['endTime']); //最低毛利率数据
        $where                              = array();
        $where['s.op_id']                   = array('in', $opids);
        $where['l.req_type']                = 801;
        $field                              = 'o.op_id,o.group_id,o.project,o.create_user_name,o.kind,s.shouru,s.maoli,s.maolilv,l.req_uid,l.req_uname';

        //分页
        $pagecount                          = M()->table('__OP_SETTLEMENT__ as s')->field($field)->join('__OP__ as o on s.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = s.id', 'LEFT')->where($where)->count();
        $page                               = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                        = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                              = M()->table('__OP_SETTLEMENT__ as s')->field($field)->join('__OP__ as o on s.op_id = o.op_id', 'LEFT')->join('__AUDIT_LOG__ as l on l.req_id = s.id', 'LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($lists as $k=>$v){
            $lists[$k]['gross']             = $gross_avg[$v['kind']]['gross'];
            $lists[$k]['low_gross']         = round($v['shouru']*$gross_avg[$v['kind']]['num'],2);
            $lists[$k]['rate']              = (round($v['maoli']/$lists[$k]['low_gross'],4)*100).'%';
        }

        $this->lists                        = $lists;
        $this->display();
    }

    //kpi页面
    public function public_kpi_gross(){
        $yearMonth                          = I('ym');
        $user_id                            = I('uid');
        $times                              = get_cycle($yearMonth);
        $mod                                = D('Sale');
        $kinds                              = M('project_kind')->getField('id,name',true);
        $settlement_lists                   = $mod->get_all_settlement_lists($times['begintime'],$times['endtime']);
        $gross_avg                          = $mod->get_gross_avg($kinds,$times['begintime'],$times['endtime']); //最低毛利率数据
        $data                               = $mod->get_jd_gross($user_id,username($user_id),$settlement_lists,$kinds,$gross_avg); //各计调数据
        $info                               = $data['info'];
        $info['合计']                       = $data['合计'];

        $this->lists                        = $info;
        $this->display('gross_kpi');
    }
    
}