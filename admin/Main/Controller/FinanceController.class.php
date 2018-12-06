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

        $isCost     = M('op_costacc')->where(array('op_id'=>$opid))->count();
		$op         = M('op')->where($where)->find();
        $op['costacc'] = $isCost;
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
		$this->budget         = $budget;
		$this->audit          = $audit;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->kinds          =  M('project_kind')->getField('id,name', true);
        $is_dijie             = M('op')->where(array('dijie_opid'=>$opid))->getField('op_id');
        $this->is_dijie       = $is_dijie?$is_dijie:0;
        $is_zutuan            = $op['in_dijie'];
        $this->is_zutuan      = $is_zutuan;
        if ($is_zutuan == 1){
            $dijie_shouru     = M('op_budget')->where(array('op_id'=>$op['dijie_opid'],'audit_status'=>1))->getField('shouru');
            $op_types         = array_column($costacc,'type');

            if (!in_array(13,$op_types)){
                $arr                = array();
                $arr['id']          = 0;
                $arr['op_id']       = $opid;
                $arr['title']       = '地接费用';
                $arr['unitcost']    = $dijie_shouru;
                $arr['amount']      = 1;
                $arr['total']       = $dijie_shouru;
                $arr['remark']      = '地接费用';
                $arr['type']        = 13;   //内部地接
                $arr['status']      = 0;
                $arr['del_status']  = 0;
                $arr['product_id']  = 0;

                $costacc[]        = $arr;
            }
        }
        $this->dijie_shouru   = $dijie_shouru?$dijie_shouru:0;

        $this->costacc        = $costacc;
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

        $isCost     = M('op_costacc')->where(array('op_id'=>$opid,'product_id'=>array('neq','0')))->count();
		$op         = M('op')->where($where)->find();
        $op['produ']= $isCost;
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
        $guide_price      = M('op_guide_price')->where(array('op_id'=>$opid,'confirm_id'=>0))->select();
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
        $this->productList      = M('op_costacc')->where(array('op_id'=>$opid,'type'=>5,'status'=>0))->select();
        $this->is_dijie         = $op['in_dijie'];

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

            $auth_line      = M('op_auth')->where(array('op_id'=>$opid))->find();
            $auth           = array();
            $auth['line']   = cookie('userid');
            $auth['yusuan'] = cookie('userid');
            $auth['material'] = cookie('userid');
            if ($auth_line){
                M('op_auth')->where(array('op_id'=>$opid))->save($auth);
            }else{
                $auth['op_id'] = $opid;
                M('op_auth')->add($auth);
            }

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

    // @@@NODE-3###settlement###项目结算###now
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
            $guide        = M()->table('__GUIDE_PAY__ as p')->field('g.name,p.op_id,p.num,p.price,p.total,p.really_cost,p.remark')->join('left join __GUIDE__ as g on p.guide_id = g.id')->where(array('p.op_id'=>$opid))->select();
            $costa        = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1,'type'=>array('neq',2)))->order('type')->select();
            $op_supplier  = M()->table('__OP_SUPPLIER__ as s')->field('s.op_id,s.supplier_name as title,c.cost as unitcost,c.amount,c.total,c.cost_type as type,s.remark')->join('left join __OP_COST__ as c on c.link_id=s.id')->where(array('s.op_id'=>$opid,'c.op_id' => $opid))->select();

            $costacc      = array();
            foreach ($guide as $k=>$v){
                $data['op_id']     = $v['op_id'];
                $data['title']     = $v['name'];
                $data['unitcost']  = $v['price'];
                $data['amount']    = $v['num'];
                $data['total']     = $v['really_cost'];
                $data['type']      = 2;
                $data['remark']    = $v['remark'];
                $costacc[]         = $data;
            }
            foreach ($costa as $v){
                $costacc[]          = $v;
            }
            foreach ($op_supplier as $v){
                $costacc[]          = $v;
            }

            /*$costacc    = M('op_cost')->where(array('op_id'=>$opid))->order('cost_type')->select();
            foreach($costacc as $k=>$v){
                if($v['type']==3){
                    $op_supplier = M('op_supplier')->find($v['link_id']);
                    $costacc[$k]['beizhu'] = $op_supplier['remark'];
                }
                if($v['type']==4){
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
            //$qita   = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1,'type'=>4))->order('id')->select();*/
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
        $this->cost_type        = C('COST_TYPE');

        //先回款,在做结算  //已回款金额
        $huikuan_lists          = M('op_huikuan')->where(array('op_id'=>$opid,'audit_status'=>1))->select();
        $yihuikuan              = array_sum(array_column($huikuan_lists,'huikuan'));
        //合同金额
        $contract_amount        = M('contract')->where(array('op_id'=>$opid,'status'=>1))->getField('contract_amount');
        //地接团结算不受汇款限制
        $dijie_opids            = array_filter(M('op')->getField('dijie_opid',true));
        if ($yihuikuan > $contract_amount || $yihuikuan == $contract_amount || in_array($opid,$dijie_opids)){
            $this->yihuikuan    = 1;
        }

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
        if (!$info['payer'])    $this->error('付款方不能为空');
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

    // @@@NODE-3###jiekuan###团内支出借款###
    public function jiekuan(){
        $this->title('出团计划列表');

        $db		= M('op');

        $title	= I('title');		//项目名称
        $opid	= I('id');			//项目编号
        $oid	= I('oid');			//项目团号
        $ou		= I('ou');			//立项人

        $where = array();

        if($title)			$where['o.project']			= array('like','%'.$title.'%');
        if($oid)			$where['o.group_id']		= array('like','%'.$oid.'%');
        if($opid)			$where['o.op_id']			= $opid;
        if($ou)				$where['o.create_user_name']= $ou;
        $where['o.type']                                = 1;

        //分页
        $pagecount		= $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $field	= 'o.*,a.nickname as jidiao';
        $lists = $db->table('__OP__ as o')->field($field)->join('__OP_AUTH__ as u on u.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = u.line','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();

        foreach($lists as $k=>$v){

            //判断项目是否审核通过
            if($v['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="blue">未审核</span>';
            if($v['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="blue">立项通过</span>';
            if($v['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="blue">立项未通过</span>';

            //判断预算是否通过
            $yusuan = M('op_budget')->where(array('op_id'=>$v['op_id']))->find();
            if($yusuan && $yusuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="green">已提交预算</span>';
            if($yusuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="green">预算通过</span>';
            if($yusuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="green">预算未通过</span>';

            //判断结算是否通过
            $jiesuan = M('op_settlement')->where(array('op_id'=>$v['op_id']))->find();
            if($jiesuan && $jiesuan['audit_status']==0) $lists[$k]['zhuangtai'] = '<span class="yellow">已提交结算</span>';
            if($jiesuan['audit_status']==1) $lists[$k]['zhuangtai'] = '<span class="yellow">完成结算</span>';
            if($jiesuan['audit_status']==2) $lists[$k]['zhuangtai'] = '<span class="yellow">结算未通过</span>';

        }
        $this->lists   =  $lists;
        $this->kinds   =  M('project_kind')->getField('id,name', true);

        $this->display();
    }

    // @@@NODE-3###jk_detail###新增借款###
    public function jk_detail(){
        $opid               = I('opid');
        if (!$opid) $this->error('获取信息失败');
        $op                 = M('op')->where(array('op_id'=>$opid))->find();
        $budget             = M('op_budget')->where(array('op_id'=>$opid))->find();
        $jk_lists           = M()->table('__JIEKUAN__ as j')->field('j.*,a.*,j.id as jid,a.id as aid')->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where(array('j.op_id'=>$opid))->order($this->orders('j.id'))->select();
        $cost               = M('op_costacc')->field('id,op_id,title,unitcost,amount,total as ctotal,remark')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();
        $jiekuan_detail     = M('jiekuan_detail')->where(array('op_id'=>$opid))->select();
        $departids          = array(2,6,7,12,13,14,16,17);
        $departments        = M('salary_department')->where(array('id'=>array('in',$departids)))->select();

        $costacc            = array();
        foreach ($cost as $k=>$v){
            $costacc[$k]['id']      = $v['id'];
            $costacc[$k]['op_id']   = $v['op_id'];
            $costacc[$k]['title']   = $v['title'];
            $costacc[$k]['unitcost']= $v['unitcost'];
            $costacc[$k]['amount']  = $v['amount'];
            $costacc[$k]['ctotal']  = $v['ctotal'];
            $costacc[$k]['remark']  = $v['remark'];
            if ($jiekuan_detail){
                foreach ($jiekuan_detail as $kk=>$vv){
                    if($vv['costacc_id']==$v['id'] && $vv['audit_status'] != 2){
                        $costacc[$k]['jk_id'] = $vv['jk_id'];
                        $costacc[$k]['costacc_id'] = $vv['costacc_id'];
                        $costacc[$k]['sjk']   = $vv['sjk'];
                        $costacc[$k]['total'] = $vv['rest'];
                        $costacc[$k]['audit_status'] = $vv['audit_status'];
                        break;
                    }else{
                        $costacc[$k]['total'] = $v['ctotal'];
                    }
                }
            }else{
                $costacc[$k]['total'] = $v['ctotal'];
            }

        }

        foreach ($jk_lists as $k=>$v){
            if ($v['audit_status']==0) $jk_lists[$k]['auditstatus'] = '<span class="yellow">审核中</span>';
            if ($v['audit_status']==1) $jk_lists[$k]['auditstatus'] = '<span class="green">审核通过</span>';
            if ($v['audit_status']==2) $jk_lists[$k]['auditstatus'] = '<span class="red">审核未通过</span>';
        }

        //审核通过的预算信息
        $audit_yusuan       = M()->table('__OP_BUDGET__ as b')
            ->join('__AUDIT_LOG__ as l on l.req_id=b.id')
            ->where(array('b.op_id'=>$opid,'l.req_type'=>P::REQ_TYPE_BUDGET,'l.dst_status'=>1))
            ->find();
        $this->record       = M('op_record')->where(array('op_id'=>$opid,'optype'=>array('in',array(13,14))))->order('id DESC')->select();
        $this->jk_lists     = $jk_lists;
        $this->departments  = $departments;
        $this->budget       = $budget;
        $this->costacc      = $costacc;
        $this->kind         = C('COST_TYPE');
        $this->audit_yusuan = $audit_yusuan;
        $this->op           = $op;
        $settlement = M('op_settlement')->where(array('op_id'=>$opid))->find();
        $this->settlement   = $settlement;
        $this->display();
    }

    // @@@NODE-3###sign###个人签字###
    public function sign(){
        $db             = M('user_sign');
        $uids           = array(1,11);
        if (in_array(session('userid'),$uids)){
            $lists          = $db->select();
        }else{
            $lists          = $db->where(array('user_id'=>session('userid')))->select();
        }
        $this->lists    = $lists;
        $this->mine     = $db->where(array('user_id'=>session('userid')))->find();  //当前用户信息
        $this->display();
    }

    // @@@NODE-3###sign_add###新增个人签字###
    public function sign_add(){
        if (isset($_POST['dosubmint'])){
            $pic                = I('pic');
            $info               = I('info');
            $id                 = I('id');
            if ($id){
                $info['password']   = md5(I('password'));
                $info['file_url']   = $pic['filepath'][0];
                $info['atta_id']    = $pic['id']['0'];
                $res = M('user_sign')->where(array('id'=>$id))->save($info);
                $isadd              = $id;
            }else{
                $info['user_id']    = session('userid');
                $info['role_id']    = session('roleid');
                $info['password']   = md5(I('password'));
                $info['department'] = M()->table('__ACCOUNT__ as a')->join('__SALARY_DEPARTMENT__ as d on d.id=a.departmentid')->where(array('a.id'=>$info['user_id']))->getField('d.department');
                $info['file_url']   = $pic['filepath'][0];
                $info['atta_id']    = $pic['id']['0'];
                $res = M('user_sign')->add($info);
                $isadd              = $res;
            }
            //保存上传图片
            save_res(P::SIGN_USER,$isadd,$pic,5);

            echo '<script>window.top.location.reload();</script>';
            /*if ($res){
                $this->success('保存成功');
            }else{
                $this->error('数据保存失败');
            }*/
        }else{
            $list       = M('user_sign')->where(array('user_id'=>session('userid')))->find();
            $this->list = $list;
            if ($list['atta_id']) {
                $pic          = get_res(P::SIGN_USER,$list['id']);
                $this->pic    = array_column($pic,'id');
            }

            $this->display();
        }
    }

    // @@@NODE-3###del_sign###删除个人签字信息###
    public function del_sign(){
        $db         = M('user_sign');
        $id         = I('id');
        $atta_id    = $db->where(array('id'=>$id))->getField('atta_id');
        $res        = $db->where(array('id'=>$id))->delete();
        M('attachment')->where(array('id'=>$atta_id))->delete();
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function public_save(){
        if (isset($_POST['dosubmint']) && $_POST['dosubmint']){
            $savetype           = I('savetype');

            //保存借款申请
            if ($savetype==2){

                $db                 = M('jiekuan');
                $info               = I('info');
                $data               = I('data');
                $info['type']       = I('type');
                $info['jkd_id']     = jkdid($info['op_id']);
                $info['jk_user']    = cookie('nickname');
                $info['jk_user_id'] = cookie('userid');
                $info['jk_time']    = NOW_TIME;

                $res = $db->add($info);
                if ($res){
                    //该团的预算审批人
                    $jkr_departmentid   = cookie('department');
                    $audit_ys           = M('salary_department')->field('department,jk_audit_user_id,jk_audit_user_name')->where(array('id'=>$jkr_departmentid))->find();

                    $jiekuan_audit          = array();
                    $jiekuan_audit['op_id'] = $info['op_id'];
                    $jiekuan_audit['jk_id'] = $res;
                    $jiekuan_audit['jkd_id']= $info['jkd_id'];

                    //与预算审批人审核
                    $jiekuan_audit['ys_audit_userid']   = $audit_ys['jk_audit_user_id'];
                    $jiekuan_audit['ys_audit_username'] = $audit_ys['jk_audit_user_name'];
                    $audit_usertype                     = 1;    //预算审核人
                    $msg_user                           = $jiekuan_audit['ys_audit_userid'];

                    M('jiekuan_audit')->add($jiekuan_audit);

                    //保存借款详情
                    foreach ($data as $k=>$v){
                        $con                = array();
                        $con['op_id']       = $info['op_id'];
                        $con['jk_id']       = $res;
                        $con['jkd_id']      = $info['jkd_id'];
                        $con['costacc_id']  = $v['costacc_id'];
                        $con['yjk']         = $v['yjk'];
                        $con['sjk']         = $v['sjk'];
                        $con['rest']        = $v['yjk'] - $v['sjk'];
                        M('jiekuan_detail')->add($con);
                    }

                    //发送系统消息
                    $project = M('op')->where(array('op_id'=>$info['op_id']))->getField('project');

                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_ys['department'].'--'.$info['jk_user'].']的借款申请!';
                    $content = '项目名称：'.$project.'，团号：'.$info['group_id'].'，借款金额：'.$info['sum'];
                    $url     = U('Finance/audit_jiekuan',array('id'=>$res,'op_id'=>$info['op_id'],'audit_usertype'=>$audit_usertype));
                    $user    = '['.$msg_user.']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['op_id']   = $info['op_id'];
                    $record['optype']  = 13;
                    $record['explain'] = '填写借款申请,借款金额'.$info['sum'];
                    op_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存借款预算审核人审核信息
            if ($savetype==3){

                $db                 = M('jiekuan_audit');
                $jk_id              = I('jk_id');
                $jkd_id             = I('jkd_id');
                $opid               = I('op_id');
                $info               = I('info');
                $audit_id           = I('audit_id');
                $info['ys_audit_time'] = NOW_TIME;

                $res = $db->where(array('id'=>$audit_id))->save($info);
                if ($res){
                    $audit_status   = C('AUDIT_STATUS');
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $op             = M('op')->where(array('op_id'=>$opid))->find();
                    if ($info['ys_audit_status'] ==1){
                        $audit_usertype                     = 2;    //财务主管
                        $cw_audit_userid                    = 55;   //程小平
                        //审核通过,到达财务//发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['rolename'].$jk_info['jk_user'].']的借款申请!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门主管审核意见：<span class='red'>".$info['ys_remark']."</span>";
                        $url     = U('Finance/audit_jiekuan',array('id'=>$jk_id,'op_id'=>$opid,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$cw_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //审核不通过
                        $audit                  = array();
                        $audit['audit_status']  = $info['ys_audit_status'];
                        M('jiekuan')->where(array('id'=>$jk_id))->save($audit);
                        M('jiekuan_detail')->where(array('jk_id'=>$jk_id))->save($audit);

                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['ys_audit_username'].']的借款审批回复!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门主管审核意见：<span class='red'>".$info['ys_remark']."</span>";
                        $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                        $user    = '['.$jk_info['jk_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 14;
                    $record['explain'] = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$audit_status[$info['ys_audit_status']];
                    op_record($record);

                    $this->success('数据保存成功!');
                }else{
                    $this->error('数据保存失败!');
                }
            }

            //保存借款财务审核信息
            if ($savetype==4){
                $db                 = M('jiekuan_audit');
                $jk_id              = I('jk_id');
                $jkd_id             = I('jkd_id');
                $opid               = I('op_id');
                $info               = I('info');
                $audit_id           = I('audit_id');
                $info['cw_audit_time'] = NOW_TIME;

                $res = $db->where(array('id'=>$audit_id))->save($info);
                if ($res){
                    $audit_status   = C('AUDIT_STATUS');
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $op             = M('op')->where(array('op_id'=>$opid))->find();
                    if ($info['cw_audit_status'] ==1){
                        $cn_userid  = 27;   //出纳(殷红)
                        //审核通过发送系统消息(出纳)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款单,请及时跟进!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$info['cw_remark']."</span>";
                        $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                        $user    = '['.$cn_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }
                    //发送系统消息(借款人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['cw_audit_username'].']的借款审批回复!';
                    $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$info['cw_remark']."</span>";
                    $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                    $user    = '['.$jk_info['jk_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $audit                  = array();
                    $audit['audit_status']  = $info['cw_audit_status'];
                    M('jiekuan')->where(array('id'=>$jk_id))->save($audit);
                    M('jiekuan_detail')->where(array('jk_id'=>$jk_id))->save($audit);

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 14;
                    $record['explain'] = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$audit_status[$info['cw_audit_status']];
                    op_record($record);

                    $this->success('数据保存成功');
                }else{
                    $this->error('数据保存失败');
                }
            }
        }
    }

    // @@@NODE-3###audit_jiekuan###审批借款###
    public function audit_jiekuan(){
        $id                 = I('id');
        $opid               = I('op_id');
        $audit_usertype     = I('audit_usertype');
        $op                 = M('op')->where(array('op_id'=>$opid))->find();
        $jiekuan            = M('jiekuan')->where(array('id'=>$id))->find();
        $jk_lists           = M()->table('__JIEKUAN_DETAIL__ as j')->join('__OP_COSTACC__ as c on c.id=j.costacc_id','left')->where(array('j.jk_id'=>$jiekuan['id']))->select();

        $audit_userinfo     = M('jiekuan_audit')->where(array('op_id'=>$opid,'jk_id'=>$id))->find();
        if (!$audit_userinfo){ $this->error('获取信息失败'); };

        $this->jiekuan      = $jiekuan;
        $this->jk_lists     = $jk_lists;
        $this->op           = $op;
        $this->audit_userinfo= $audit_userinfo;
        $this->audit_usertype= $audit_usertype;


        $this->display();
    }

    // @@@NODE-3###jiekuan_lists###借款单列表###
    public function jiekuan_lists(){
        $project        = I('title');
        $group_id       = I('oid');
        $jkd_id         = I('jkdid');
        $jk_user        = I('ou');

        $where          = array();
        if ($project)   $where['o.project'] = array('like','%'.$project.'%');
        if ($group_id)  $where['j.group_id']= array('like','%'.$group_id.'%');
        if ($jkd_id)    $where['j.jkd_id']  = array('like','%'.$jkd_id.'%');
        if ($jk_user)   $where['j.jk_user'] = array('like','%'.$jk_user.'%');

        $lists          = M()->table('__JIEKUAN__ as j')->field('j.*,o.project')->join('__OP__ as o on o.op_id=j.op_id','left')->where($where)->order($this->orders('j.id'))->select();

        foreach ($lists as $k=>$v){
            if ($v['audit_status'] == 0) $lists[$k]['zhuangtai'] = "<span class='yellow'>审核中</span>";
            if ($v['audit_status'] == 1) $lists[$k]['zhuangtai'] = "<span class='green'>审核通过</span>";
            if ($v['audit_status'] == 2) $lists[$k]['zhuangtai'] = "<span class='red'>审核未通过</span>";
        }
        $this->lists    = $lists;
        $this->display();
    }

    // @@@NODE-3###jiekuandan_info###借款单详情###
    public function jiekuandan_info(){
        $id             = I('jkid');
        $jiekuan        = M()->table('__JIEKUAN__ as j')->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where(array('j.id'=>$id))->find();
        $jk_lists       = M()->table('__JIEKUAN_DETAIL__ as j')->join('__OP_COSTACC__ as c on c.id=j.costacc_id','left')->where(array('j.jk_id'=>$id))->select();
        $this->op       = M('op')->where(array('op_id'=>$jiekuan['op_id']))->find();
        $this->jiekuan  = $jiekuan;
        $this->jk_lists = $jk_lists;
        $this->display();
    }

    //@@@NODE-3###jk_audit_user###部门借款审核人###
    public function jk_audit_user(){
        $this->departments  = M('salary_department')->select();
        $this->display();
    }

    //@@@NODE-3###set_jiekuan_user###配置部门借款审核人###
    public function set_jiekuan_user(){
        if(isset($_POST['dosubmint'])){
            $db             = M('salary_department');
            $id             = I('id');
            $info           = I('info');
            $res            = $db->where(array('id'=>$id))->save($info);

            echo "<script>window.top.location.reload();</script>";
        }else{
            $id                 = I('id');
            $list           = M('salary_department')->where(array('id'=>$id))->find();
            $this->list     = $list;
            $this->userkey  = get_userkey();
            $this->display();
        }
    }

    //@@@NODE-3###del_jkd###删除借款单###
    public function del_jkd(){
        $id                 = I('id');
        if ($id){
            M('jiekuan')->where(array('id'=>$id))->delete();
            M('jiekuan_audit')->where(array('jk_id'=>$id))->delete();
            M('jiekuan_detail')->where(array('jk_id'=>$id))->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除数据失败');
        }
    }

}