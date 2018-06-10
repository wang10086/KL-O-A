<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Finance###财务管理###
class FinanceController extends BaseController {
    
    protected $_pagetitle_ = '财务管理';
    protected $_pagedesc_  = '';
    
	
    // @@@NODE-3###accounting###单团核算列表###
    public function accounting(){
        $this->title('单团核算');
		
		$db = M('op');
		
		$where = array();
		$where['o.audit_status'] = 1;
		$where['p.id'] = array('gt',0);
		
		//分页
		$pagecount = $db->table('__OP__ as o')->field('o.*')->join('__OP_COST__ as p on p.op_id = o.op_id')->group('o.op_id')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->lists = $db->table('__OP__ as o')->field('o.*')->join('__OP_COST__ as p on p.op_id = o.op_id')->group('o.op_id')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();
		
		$this->display('accounting');
    }
	
    
	
	// @@@NODE-3###op###项目预算###
    public function op(){
			
		$opid = I('opid');
		$id   = I('id');
		if($id){
			$budget = M('op_budget')->find($id);
			$opid = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$op         = M('op')->where($where)->find();
		$costacc    = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();
		if(count($costacc)==0){
			$costacc = 	M('op_costacc')->where(array('op_id'=>$opid,'status'=>0))->order('id')->select();
			foreach($costacc as $k=>$v){
				$costacc[$k]['id'] = 0;	
			}
		}
		
		$budget     = M('op_budget')->where(array('op_id'=>$opid))->find();
		$budget['xz'] = explode(',',$budget['xinzhi']);	
		
		$where = array();
		$where['req_type'] = P::REQ_TYPE_BUDGET;
		$where['req_id']   = $budget['id'];
		$audit = M('audit_log')->where($where)->find();
		if($audit['dst_status']==0){
			$show = '未审批';
			$show_user = '未审批';
			$show_time = '等待审批';
		}else if($audit['dst_status']==1){
			$show = '<span class="green">已通过</span>';
			$show_user = $audit['audit_uname'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}else if($audit['dst_status']==2){
			$show = '<span class="red">未通过</span>';
			$show_user = $audit['audit_uname'];
			$show_reason = $audit['audit_reason'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}
		$op['showstatus'] = $show;
		$op['show_user']  = $show_user;
		$op['show_time']  = $show_time;
		$op['show_reason']  = $show_reason;

        $member               = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
        $this->member         = $member;
		$this->kind           = C('COST_TYPE');
		$this->op             = $op;
		$this->costacc        = $costacc;
		$this->budget         = $budget;
		$this->audit          = $audit;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->kinds          =  M('project_kind')->getField('id,name', true);
		$this->display('op');
	}
	
	
	
	
	// @@@NODE-3###costacc###成本核算###
    public function costacc(){
			
		$opid = I('opid');
		$id   = I('id');
		if($id){
			$budget = M('op_budget')->find($id);
			$opid = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$op         = M('op')->where($where)->find();
		$costacc    = M('op_costacc')->where(array('op_id'=>$opid,'status'=>0))->order('id')->select();
		if($op['line_id']){
			$mokuai     = M('product_line_tpl')->where(array('line_id'=>$op['line_id'],'type'=>1))->getField('pro_id',true);
			$this->mokuailist = M('product_material')->where(array('product_id'=>array('in',implode(',',$mokuai))))->select();
		}
		$budget     = M('op_budget')->where(array('op_id'=>$opid))->find();
		
		$where = array();
		$where['req_type'] = P::REQ_TYPE_BUDGET;
		$where['req_id']   = $budget['id'];
		$audit = M('audit_log')->where($where)->find();
		if($audit['dst_status']==0){
			$show = '未审批';
			$show_user = '未审批';
			$show_time = '等待审批';
		}else if($audit['dst_status']==1){
			$show = '<span class="green">已通过</span>';
			$show_user = $audit['audit_uname'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}else if($audit['dst_status']==2){
			$show = '<span class="red">未通过</span>';
			$show_user = $audit['audit_uname'];
			$show_reason = $audit['audit_reason'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}
		$op['showstatus'] = $show;
		$op['show_user']  = $show_user;
		$op['show_time']  = $show_time;
		$op['show_reason']= $show_reason;
        $guide_price      = M('op_guide_price')->where(array('op_id'=>$opid))->select();
        $tit              = M()->table('__OP_GUIDE_PRICE__ as gp')->field('gp.*,gk.name as gkn,gpk.name as gkpn')->join('left join __GUIDEKIND__ as gk on gk.id = gp.guide_kind_id')->join('left join __GUIDE_PRICEKIND__ as gpk on gpk.id = gp.gpk_id')->where(array('gp.op_id'=>$opid))->select();
        foreach ($guide_price as & $v){
            $v['type']    = 2;  //专家辅导员
            foreach ($tit as $value){
                if($v['guide_kind_id'] == $value['guide_kind_id'] && $v['gpk_id'] == $value['gpk_id']){
                    $v['title']   = $value['gkn'].'['.$value['gkpn'].']';
                }
            }
        }

        $this->guide_price      = $guide_price;
        $member                 = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
        $this->member           = $member;
		$this->kind				= C('COST_TYPE');
		$this->op				= $op;
		$this->budget			= $budget;
		$this->costacc			= $costacc;
		$this->business_depts	= C('BUSINESS_DEPT');
		$this->subject_fields	= C('SUBJECT_FIELD');
		$this->ages				= C('AGE_LIST');
		$this->kinds			= M('project_kind')->getField('id,name', true);
		$this->display('costacc');
	}
	
	
	
	
	
	
	//@@@NODE-3###save_costacc###保存成本核算###
    public function save_costacc(){
		
		$db              = M('op_costacc');
		$opid            = I('opid');
		$costacc         = I('costacc');
		$info            = I('info');
		$resid           = I('resid');
		$referer         = I('referer');
        $guideprice      = I('guideprice');
		$num             = 0;
        if(!$costacc){
            $costacc = array();
            foreach ($guideprice as $v){
                $costacc[] = $v;
            }
        }

        //保存成本核算
		if($opid && $costacc){
			
			$delid = array();
			foreach($costacc as $k=>$v){
				$data = array();
				$data = $v;
				$data['op_id'] = $opid;
				$data['status'] = 0;
				if($resid && $resid[$k]['id']){
					$edits = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[] = $resid[$k]['id'];
					$num++;
				}else{
					$savein = $db->add($data);
					$delid[] = $savein;
					if($savein) $num++;
				}
			}	
			
			M('op')->data($info)->where(array('op_id'=>$opid))->save();
			
			$del = $db->where(array('op_id'=>$opid,'status'=>0,'id'=>array('not in',$delid)))->delete();
			if($del) $num++;
		}
		
		if($num){
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 8;
			$record['explain'] = '保存成本核算';
			op_record($record);
			$this->success('保存成功！');   
		}else{
			$this->error('保存失败');	
		}

	}
	
	
	// @@@NODE-3###costacclist###成本核算记录###
    public function costacclist(){
		$this->title('成本核算记录');
		
		$db = M('op');
		$title = I('title');
		$opid = I('opid');
		$oid = I('oid');
		$cname = I('cname');
		
		$where = array();
		$where['costacc'] = array('gt',0);
		if($title)  $where['project'] = array('like','%'.$title.'%');
		if($oid)    $where['group_id'] = array('like','%'.$oid.'%');
		if($cname)  $where['create_user_name'] = array('like','%'.$cname.'%');
		if($opid)   $where['op_id'] = $opid;
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		
		$this->display('costacclist');
	}
	
	
	
	// @@@NODE-3###costapply###费用申请记录###
    public function costapply(){
        $this->title('费用申请记录');
		
		$db = M('op');
		
		$where = array();
		//分页
		$pagecount = $db->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		
		$this->display('costapply');
    }
	
	
	
	// @@@NODE-3###accounting###项目预算###
    public function budget(){
        $this->title('项目预算');
		
		$db = M('op');
		
		
		$title = I('title');         //项目名称
		$opid = I('opid');         //项目编号
		$oid = I('oid');         //项目团号
		$ou = I('ou');           //立项人
		$as = I('as','-1');   //审核状态
		
		
		$where = array();
		$where['o.audit_status'] = 1;
		$where['b.id'] = array('gt',0);
		if($title)   $where['o.project'] = array('like','%'.$title.'%');
		if($oid)   $where['o.group_id'] = array('like','%'.$oid.'%');
		if($ou)     $where['o.create_user_name'] = array('like','%'.$ou.'%');
		if($as!='-1')     $where['b.audit_status'] = $as;
		if($opid)     $where['o.op_id'] = $opid;
		
		//分页
		$pagecount = $db->table('__OP_BUDGET__ as b')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->table('__OP_BUDGET__ as b')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('b.create_time'))->select();
		
		
		foreach($lists as $k=>$v){
			
			if($v['audit_status']==0){
				$status = '未审核';	
			}elseif($v['audit_status']==1){
				$status = '<span class="green">通过</span>';	
			}elseif($v['audit_status']==2){
				$status = '<span class="red">未通过</span>';	
			}
			
			$lists[$k]['budget'] = opcost($v['op_id']);
			$lists[$k]['budget_audit_status'] = 	$status ;
		}
		

		$this->lists = $lists;
		$this->display('budget');
    }
	
	
	// @@@NODE-3###settlementlist###项目结算列表###
    public function settlementlist(){
        $this->title('项目结算');
		
		$db = M('op');
		
		
		$title = I('title');         //项目名称
		$opid = I('opid');         //项目编号
		$oid = I('oid');         //项目团号
		$ou = I('ou');           //立项人
		$as = I('as','-1');   //审核状态
		
		
		$where = array();
		$where['o.audit_status'] = 1;
		$where['b.id'] = array('gt',0);
		if($title)   $where['o.project'] = array('like','%'.$title.'%');
		if($oid)   $where['o.group_id'] = array('like','%'.$oid.'%');
		if($ou)     $where['o.create_user_name'] = array('like','%'.$ou.'%');
		if($as!='-1')     $where['b.audit_status'] = $as;
		if($opid)     $where['o.op_id'] = $opid;
		
		
		
		//分页
		$pagecount = $db->table('__OP_SETTLEMENT__ as b')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->count();
		
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->table('__OP_SETTLEMENT__ as b')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.remark')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('b.create_time'))->select();
		
		foreach($lists as $k=>$v){
			
			if($v['audit_status']==0){
				$status = '未审核';	
			}elseif($v['audit_status']==1){
				$status = '<span class="green">通过</span>';	
			}elseif($v['audit_status']==2){
				$status = '<span class="red">未通过</span>';	
			}
			
			$lists[$k]['budget'] = opcost($v['op_id']);
			$lists[$k]['budget_audit_status'] = 	$status ;
		}
		

		$this->lists = $lists;
		$this->display('settlementlist');
    }
	
	
	public function addcost(){
		
		$opid = I('opid');
		$info = I('info');
		
		if(isset($_POST['dosubmit']) && $info){
			$info['cost_type'] = 0;
			M('op_cost')->add($info);	
			echo '<script>window.top.location.reload();</script>';
		}else{
			$this->opid = $opid;
			$this->display('add_cost');	
		}
		
		
	}
	
	
	
	//@@@NODE-3###save_appcost###保存预算###
    public function save_appcost(){
		
		$db              = M('op_costacc');
		$opid            = I('opid');
		$costacc         = I('costacc');
		$info            = I('info');
		$resid           = I('resid');
		$referer         = I('referer');
		$budget          = I('budget',0);
		$xinzhi          = I('xinzhi');
		$num             = 0;
		
		$info['xinzhi']  = implode(',',$xinzhi);
		
		//保存预算
		if($opid && $costacc){
			
			$delid = array();
			foreach($costacc as $k=>$v){
				$data = array();
				$data = $v;
				$data['op_id'] = $opid;
				$data['status'] = 1;
				if($resid && $resid[$k]['id']>0){
					$edits = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[] = $resid[$k]['id'];
					$num++;
				}else{
					$savein = $db->add($data);
					$delid[] = $savein;
					if($savein) $num++;
				}
			}	
			
			
			if($budget){
				M('op_budget')->data($info)->where(array('id'=>$budget))->save();	
			}else{
				$info['create_time'] = time();
				M('op_budget')->add($info);
			}
			
			$del = $db->where(array('op_id'=>$opid,'status'=>1,'id'=>array('not in',$delid)))->delete();
			if($del) $num++;
		}
		
		if($num){
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 8;
			$record['explain'] = '保存预算';
			op_record($record);
			$this->success('保存成功！');   
		}else{
			$this->error('保存失败');	
		}

	}
	
	//@@@NODE-3###appcost###预算申请###
	public function appcost(){
		$op_id = I('opid');
		if(isset($_POST['dosubmit'])){	
			
			//判断是否申请过
			$ifok = M('op_budget')->where(array('op_id'=>$op_id))->find();
			if($ifok['audit_status']!=1){
				
				M('op_budget')->data(array('audit'=>1))->where(array('id'=>$ifok['id']))->save();
				$audit = M('audit_log')->where(array('req_type'=>P::REQ_TYPE_BUDGET,'req_id'=>$ifok['id']))->find();
				if($audit){
					M('audit_log')->data(array('dst_status'=>0))->where(array('id'=>$audit['id']))->save();
				}else{
					$this->request_audit(P::REQ_TYPE_BUDGET, $ifok['id']);		
				}
				$this->success('已提交申请等待审批！');
				
			}else{
				$this->error('您的预算已被通过，无需重复申请！');		
			}
			
		}
	}
	
	
	// @@@NODE-3###settlement###项目结算###
    public function settlement(){
			
		$opid = I('opid');
		$id   = I('id');
		if($id){
			$budget = M('op_settlement')->find($id);
			$opid = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$op         = M('op')->where($where)->find();

		$jiesuan    = M('op_costacc')->where(array('op_id'=>$opid,'status'=>2))->order('id')->select();
		if(count($jiesuan)==0){
			$costacc    = M('op_cost')->where(array('op_id'=>$opid))->order('cost_type')->select();
			foreach($costacc as $k=>$v){
				if($v['cost_type']==3){
					$op_supplier = M('op_supplier')->find($v['link_id']);
					$costacc[$k]['beizhu'] = $op_supplier['remark'];
				}
				if($v['cost_type']==4){
					//查询物资价格
					$mate = M('material')->where(array('material'=>$v['remark']))->find();
					$costacc[$k]['cost'] = $mate['price'];
					$costacc[$k]['m_stages'] = $mate['stages'];
					//查询物资出入库记录
					$op_mate = M('op_material')->find($v['link_id']);
					$costacc[$k]['m_outsum'] = $op_mate['outsum'];
					$costacc[$k]['m_purchasesum'] = $op_mate['purchasesum'];
					$costacc[$k]['m_returnsum'] = $op_mate['returnsum'];
				}
				if ($v['cost_type']==2){
                    //专家辅导员  //获取专家辅导员实际提成
                    $really_cost            = M('op_cost')->where(array('op_id'=>$v['op_id'],'remark'=>$v['remark']))->find();
                    $g                      = M('op_guide')->where(array('op_id'=>$v['op_id'],'name'=>$v['remark']))->getField('remark');
                    if ($really_cost['really_cost'] =='0.00') $really_cost['really_cost'] = null;
                    $costacc[$k]['total']   = $really_cost['really_cost']?$really_cost['really_cost']:$v['total'];
                    $costacc[$k]['beizhu']  = $really_cost['upd_remark']?$really_cost['upd_remark']:$g;
                }
            }
			$qita   = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1,'type'=>4))->order('id')->select();
		}
        $budget     = M('op_budget')->where(array('op_id'=>$opid))->find();
		$settlement = M('op_settlement')->where(array('op_id'=>$opid))->find();

		
		$where = array();
		$where['req_type'] = P::REQ_TYPE_SETTLEMENT;
		$where['req_id']   = $settlement['id'];
		$audit = M('audit_log')->where($where)->find();
		if($audit['dst_status']==0){
			$show = '未审批';
			$show_user = '未审批';
			$show_time = '等待审批';
		}else if($audit['dst_status']==1){
			$show = '<span class="green">已通过</span>';
			$show_user = $audit['audit_uname'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}else if($audit['dst_status']==2){
			$show = '<span class="red">未通过</span>';
			$show_user = $audit['audit_uname'];
			$show_reason = $audit['audit_reason'];
			$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
		}
		$op['showstatus'] = $show;
		$op['show_user']  = $show_user;
		$op['show_time']  = $show_time;
		$op['show_reason']  = $show_reason;

        $member                 = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
        $this->member           = $member;
		$this->kind				= C('COST_TYPE');
		$this->costtype			= array('1'=>'其他','2'=>'专家辅导员','3'=>'合格供方','4'=>'物资');
		$this->op				= $op;
		$this->costacc			= $costacc;
		$this->jiesuan			= $jiesuan;
		$this->budget			= $budget;
		$this->settlement		= $settlement;
		$this->qita				= $qita;
		$this->audit			= $audit;
		$this->business_depts	= C('BUSINESS_DEPT');
		$this->subject_fields	= C('SUBJECT_FIELD');
		$this->ages 			= C('AGE_LIST');
		$this->kinds			=  M('project_kind')->getField('id,name', true);
		$this->display('settlement');
	}
	
	
	
	//@@@NODE-3###save_settlement###保存结算###
    public function save_settlement(){
		
		$db				= M('op_costacc');
		$opid			= I('opid');
		$costacc		= I('costacc');
		$info			= I('info');
		$resid			= I('resid');
		$referer		= I('referer');
		$settlement		= I('settlement',0);
		$num			= 0;
		
		
		
		//保存预算
		if($opid && $costacc){
			
			
		
			$delid = array();
			foreach($costacc as $k=>$v){
				$data = array();
				$data = $v;
				$data['op_id'] = $opid;
				$data['status'] = 2;
					
				if($resid && $resid[$k]['id']>0){
					$edits = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[] = $resid[$k]['id'];
					$num++;
				}else{
					$savein = $db->add($data);
					$delid[] = $savein;
					if($savein) $num++;
				}
			}	
			
			
			if($settlement){
				M('op_settlement')->data($info)->where(array('id'=>$settlement))->save();
			}else{
				$info['create_time'] = time();
				M('op_settlement')->add($info);
			}
			
			$del = $db->where(array('op_id'=>$opid,'status'=>2,'id'=>array('not in',$delid)))->delete();
			if($del) $num++;
		}
		
		if($num){
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 8;
			$record['explain'] = '保存结算';
			op_record($record);
			$this->success('保存成功！');   
		}else{
			$this->error('保存失败');	
		}

	}
	
	
	
	//@@@NODE-3###appsettlement###结算申请###
	public function appsettlement(){
		$op_id = I('opid');
		if(isset($_POST['dosubmit'])){	
			//判断是否重复申请
			$ifok = M('op_settlement')->where(array('op_id'=>$op_id))->find();
			if($ifok['audit_status']!=1){
				M('op_settlement')->data(array('audit'=>1))->where(array('id'=>$ifok['id']))->save();
				
				$audit = M('audit_log')->where(array('req_type'=>P::REQ_TYPE_SETTLEMENT,'req_id'=>$ifok['id']))->find();
				if($audit){
					M('audit_log')->data(array('dst_status'=>0))->where(array('id'=>$audit['id']))->save();
				}else{
					$this->request_audit(P::REQ_TYPE_SETTLEMENT, $ifok['id']);		
				}
				$this->success('已提交申请等待审批！');		
			}else{
				$this->error('您的结算已被通过，无需重复申请！');		
			}
			
		}
	}
	
	
	
	
	// @@@NODE-3###huikuan###项目回款###
    public function huikuan(){
			
		$opid = I('opid');
		$id   = I('id');
		if($id){
			$budget = M('op_huikuan')->find($id);
			$opid = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');	
		
		$op             = M('op')->where(array('op_id'=>$opid))->find();
		$settlement     = M('op_settlement')->where(array('op_id'=>$opid))->find();
		$huikuan        = M('op_huikuan')->where(array('op_id'=>$opid))->order('id DESC')->select();
		foreach($huikuan as $k=>$v){
			
			$show        = '';
			$show_user   = '';
			$show_time   = '';
			$show_reason = '';
			
			$where = array();
			$where['req_type'] = P::REQ_TYPE_HUIKUAN;
			$where['req_id']   = $v['id'];
			$audit = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show = '未审批';
				$show_user = '未审批';
				$show_time = '等待审批';
			}else if($audit['dst_status']==1){
				$show = '<span class="green">已通过</span>';
				$show_user = $audit['audit_uname'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show = '<span class="red">未通过</span>';
				$show_user = $audit['audit_uname'];
				$show_reason = $audit['audit_reason'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$huikuan[$k]['showstatus']   = $show;
			$huikuan[$k]['show_user']    = $show_user;
			$huikuan[$k]['show_time']    = $show_time;
			$huikuan[$k]['show_reason']  = $show_reason;
		}

        $member             = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
        $this->member       = $member;
		$this->op    		= $op;
		$this->settlement	= $settlement;
		$this->kinds		= M('project_kind')->getField('id,name', true);
		$this->payment		= M('contract_pay')->where(array('op_id'=>$opid))->sum('pay_amount'); 
		$this->huikuan  		= $huikuan;
		$this->huikuanlist	= M()->table('__CONTRACT_PAY__ as p')->field('p.*,c.contract_id')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->where(array('p.op_id'=>$opid,'p.status'=>array('neq','2')))->order('p.id asc')->select();
		
		
		$this->pays 			= M()->table('__CONTRACT_PAY__ as p')->field('p.*,c.contract_id')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->where(array('p.op_id'=>$opid))->order('p.id asc')->select();
		
		
		$this->display('huikuan');
	}
	
	
	
	//@@@NODE-3###save_huikuan###保存回款###
    public function save_huikuan(){
		
		$info			= I('info');
		$referer		= I('referer');
		$settlement		= I('settlement',0);
		$num			= 0;

		//保存回款
		if(!$info['huikuan'])	$this->error('本次回款金额不能为空');
		if(!$info['type'])		$this->error('请选择回款类型');
		$info['userid']			= cookie('userid');
		$info['create_time']		= time();
		$info['huikuan_time']	= strtotime($info['huikuan_time']);
		
		if(!$info['cid']){
			$cc = M('contract_pay')->find($info['payid']);	
			$info['cid'] = $cc['cid'];
		}
		
		$save = M('op_huikuan')->add($info);

		//提交审核
		$audit = M('audit_log')->where(array('req_type'=>P::REQ_TYPE_HUIKUAN,'req_id'=>$save))->find();
		if(!$audit){
			$this->request_audit(P::REQ_TYPE_HUIKUAN, $save);		
		}
		
		if($save){
            //保存合同操作记录
            $c_record                 = array();
            $c_record['contract_id']  = $info['cid'];
            $c_record['type']         = 5;
            $c_record['explain']      = '修改回款内容';
            contract_record($c_record);

            $record = array();
			$record['op_id']   = $info['op_id'];
			$record['optype']  = 9;
			$record['explain'] = '保存回款';
			op_record($record);
			$this->success('已提交申请等待审批！');		
		}else{
			$this->error('保存失败');	
		}
		
		
		

	}
	
	
	
	//@@@NODE-3###payment###回款管理###
    public function payment(){
		$this->title('回款管理');
		
		$db		= M('op');
		
		
		$title	= I('title');         	//项目名称
		$opid	= I('opid');         	//项目编号
		$cid	= I('cid');         	//合同编号
		$gid	= I('gid');         	//项目团号
		$ou		= I('ou');           	//立项人
		$as		= I('as','-1');   		//审核状态
		
		$where	= array();
		if($title)			$where['o.project']				= array('like','%'.$title.'%');
		if($opid)			$where['p.op_id']				= array('like','%'.$opid.'%');
		if($cid)     		$where['c.contract_id']			= array('like','%'.$cid.'%');
		if($gid)     		$where['c.group_id']			= array('like','%'.$gid.'%');
		if($as!='-1')     	$where['p.status']				= $as;
		if($ou)     		$where['o.create_user_name']	= array('like','%'.$ou.'%');
		
		//分页
		$pagecount = $db->table('__CONTRACT_PAY__ as p')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->join('__OP__ as o on o.op_id = p.op_id','LEFT')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->table('__CONTRACT_PAY__ as p')->field('p.*,c.contract_id,c.group_id,o.project,o.project,o.create_user_name')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->join('__OP__ as o on o.op_id = p.op_id','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.return_time'))->select();
		
		
		foreach($lists as $k=>$v){
			
			if($v['status']==0){
				$status = '<span class="red">未回款</span>';	
			}elseif($v['status']==1){
				$status = '<span class="blue">回款中</span>';	
			}elseif($v['status']==2){
				$status = '<span class="green">已回款</span>';	
			}
			
			$lists[$k]['strstatus'] = $status;
		}
		

		$this->lists = $lists;
		$this->display('payment');
	}

    // @@@NODE-3###costapply###劳务费用###
    public function costlabour(){
        $this->title('劳务费用');
        $key          = I('key');
        $type         = I('type');
        $sex         = I('sex');
        $where = array();
        $where['1'] = priv_where(P::REQ_TYPE_GUIDE_RES_V);
        if($key)      $where['name'] = array('like','%'.$key.'%');
        if($type)     $where['kind'] = $type;
        if($sex)     $where['sex'] = $sex;

        //分页
        $pagecount = M('guide')->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->reskind = M('guidekind')->getField('id,name', true);
        $this->lists = M('guide')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
            P::AUDIT_STATUS_PASS        => '已通过',
            P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
            P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );

    $this->display();
    }
	
    // @@@NODE-3###res_view###劳务费用详情###
    public function labour_detail () {
        $this->title('劳务费用');

        $id = I('id',0);
        $row = M('guide')->find($id);
        $this->row = $row;

        //工作记录
        $opids = M('guide as g')->join("left join __OP_GUIDE__ as o on o.guide_id = g.id ")->where(array('g.id'=>$id))->field('o.op_id')->select();
        $opids = array_column($opids,'op_id');
        foreach ($opids as $v){
            $guide      = M()->table('__OP_GUIDE__ as g')->field('g.*,c.cost,p.group_id,p.project,s.audit_status')->join('__OP_COST__ as c on c.link_id=g.id')->join("left join __OP__ as p on p.op_id = g.op_id")->join("left join __OP_SETTLEMENT__ as s on s.op_id = g.op_id")->where(array('c.remark'=>$row['name']))->select();
        }
        foreach ($guide as $k=>$v){
            if ($v['audit_status']==0) $guide[$k]['stu']  = '<span class="yellow">已提交结算</span>';
            if ($v['audit_status']==1) $guide[$k]['stu']  = '<span class="green">完成结算</span>';
            if ($v['audit_status']==2) $guide[$k]['stu']  = '<span class="yellow">结算未通过</span>';
        }
        $this->guide        = $guide;
        $this->countcost    = array_sum(array_column($guide,'cost'));

        $this->display('labour_detail');

    }


	

    
}