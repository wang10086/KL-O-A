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
        $mod                = D('Finance');
		$opid               = I('opid');
		$id                 = I('id');
		if($id){
			$budget         = M('op_budget')->find($id);
			$opid           = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');
        $op                 = M('op')->where(array('op_id'=>$opid))->find();

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
		}else if($audit['dst_status']==3){
            $show = '<span class="yellow">毛利率未达标,待领导复批</span>';
            $show_user = $audit['audit_uname'];
            $show_reason = $audit['audit_reason'];
            $show_time = date('Y-m-d H:i:s',$audit['audit_time']);
        }
		$op['showstatus'] = $show;
		$op['show_user']  = $show_user;
		$op['show_time']  = $show_time;
		$op['show_reason']  = $show_reason;

        $pays                 = $mod->get_money_back_lists($opid); //回款计划
        $this->pays           = $pays;
        $this->jd             = $mod->get_jidiao($opid);
		//$this->kind           = C('COST_TYPE');
		$this->kind           = M('supplierkind')->getField('id,name',true);
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

        if ($is_zutuan == 1 && $op['kind'] != 87){ //87=>排除单进院所,单进院所暂时未生成地接团
            $dijie_shouru     = $mod->get_landAcquisitionAgency_money($op,P::REQ_TYPE_BUDGET);
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

                $costacc[]          = $arr;
            }
        }

        $this->dijie_shouru         = $dijie_shouru?$dijie_shouru:0;
        $this->costacc              = $costacc;
        $this->type                 = C('JIEKUAN_TYPE'); //回款方式
        $this->company              = C('COMPANY'); //回款单位
        $this->display('op');
	}


	// @@@NODE-3###costacc###成本核算###
    public function costacc(){

		$opid                       = I('opid');
		if(!$opid) $this->error('项目不存在');

		$where                      = array();
		$where['op_id']             = $opid;

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
		//$this->kind				= C('COST_TYPE');
		$this->kind				= M('supplierkind')->getField('id,name',true);
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

		$db                     = M('op_costacc');
        $op_auth_db             = M('op_auth');
		$opid                   = I('opid');
		$costacc                = I('costacc');
		$info                   = I('info');
		$resid                  = I('resid');
		$referer                = I('referer');
        $guideprice             = I('guideprice');
		$num                    = 0;
        if(!$costacc){
            $costacc            = array();
            foreach ($guideprice as $v){
                $costacc[]      = $v;
            }
        }

        //保存成本核算
		if($opid && $costacc){
			$delid              = array();
			foreach($costacc as $k=>$v){
				$data           = array();
				$data           = $v;
				$data['op_id']  = $opid;
				$data['status'] = 0;
				if($resid && $resid[$k]['id']){
					$edits      = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[]    = $resid[$k]['id'];
					$num++;
				}else{
					$savein     = $db->add($data);
					$delid[]    = $savein;
					if($savein) $num++;
				}
			}
            $del = $db->where(array('op_id'=>$opid,'status'=>0,'id'=>array('not in',$delid)))->delete();
            if($del) $num++;

			M('op')->data($info)->where(array('op_id'=>$opid))->save();
            $auth               = array();
            $auth['hesuan']     = session('userid');
            if (!in_array(session('userid'),array(1,11))){
                $op_auth_db->where(array('op_id'=>$opid))->save($auth);
            }

            $cres                           = array();
            $cres['op_id']                  = $opid;
            $cres['costacc']                = $info['costacc']?trim($info['costacc']):0;
            $cres['costacc_min_price']      = $info['costacc_min_price']?trim($info['costacc_min_price']):0;
            $cres['costacc_max_price']      = $info['costacc_max_price']?trim($info['costacc_max_price']):0;
            $cres['input_user_id']          = session('userid');
            $cres['input_user_name']        = session('nickname');
            $costacc_res_db                 = M('op_costacc_res');
            $res                            = $costacc_res_db->where(array('op_id'=>$opid))->find();
            if ($res){
                $cres['update_time']        = NOW_TIME;
                $costacc_res_db->where(array('id'=>$res['id']))->save($cres);
            }else{
                $cres['create_time']        = NOW_TIME;
                $costacc_res_db->add($cres);
            }
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


	// @@@NODE-3###costacclist###成本核算记录###(删除20181228_bak)
    /*public function costacclist_bak(){
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
	}*/


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
		$where['b.audit_status'] = 1;
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
        $mod                = D('Finance');
		$db                 = M('op_costacc');
		$opid               = I('opid');
		$costacc            = I('costacc');
		$info               = I('info');
		$resid              = I('resid');
		$referer            = I('referer');
		$budget             = I('budget',0);
		$xinzhi             = I('xinzhi');
		$num                = 0;
        $payment            = I('payment');
        $info['should_back_money']  = $info['shouru'];

		$info['xinzhi']     = implode(',',$xinzhi);
		$sum_back_money     = array_sum(array_column($payment,'amount'));
        $is_dijie           = M('op')->where(array('dijie_opid'=>$opid))->getField('op_id'); //判断是不是地接团(排除内部地接)
        if ((!$info['shouru'] || $sum_back_money != $info['shouru']) && !$is_dijie) $this->error('请确保回款总金额和收入一致');


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

			//保存回款计划
            $mod->save_money_back_plans($payment,$opid,$info['shouru']);

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
			$record                 = array();
			$record['op_id']        = $opid;
			$record['optype']       = 8;
			$record['explain']      = '保存预算';
			op_record($record);

            if (!in_array(cookie('userid'),array(1,11))){
                $auth_line          = M('op_auth')->where(array('op_id'=>$opid))->find();
                $auth               = array();
                $auth['line']       = cookie('userid');
                $auth['yusuan']     = cookie('userid');
                $auth['material']   = cookie('userid');
                if ($auth_line){
                    M('op_auth')->where(array('op_id'=>$opid))->save($auth);
                }else{
                    $auth['op_id']  = $opid;
                    M('op_auth')->add($auth);
                }
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
                    $record                 = array();
                    $record['op_id']        = $op_id;
                    $record['optype']       = 8;
                    $record['explain']      = '提交预算审核';
                    op_record($record);
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
        $mod                    = D('Finance');
        $opid                   = I('opid');
        $id                     = I('id');
        if($id){
            $budget             = M('op_settlement')->find($id);
            $opid               = $budget['op_id'];
        }
        if(!$opid) $this->error('项目不存在');

        $where                  = array();
        $where['op_id']         = $opid;
        $op                     = M('op')->where($where)->find();
        $is_zutuan              = $op['in_dijie'];

        $jiesuan                = M('op_costacc')->where(array('op_id'=>$opid,'status'=>2))->order('id')->select();
        if(count($jiesuan)==0){
            $costacc            = $mod->get_budget_costacc($op,$is_zutuan);

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
        $budget                 = M('op_budget')->where(array('op_id'=>$opid))->find();
        $settlement             = M('op_settlement')->where(array('op_id'=>$opid))->find();

        $where                  = array();
        $where['req_type']      = P::REQ_TYPE_SETTLEMENT;
        $where['req_id']        = $settlement['id'];
        $audit                  = M('audit_log')->where($where)->find();
        if($audit['dst_status']==0){
            $show               = '未审批';
            $show_user          = '未审批';
            $show_time          = '等待审批';
        }else if($audit['dst_status']==1){
            $show               = '<span class="green">已通过</span>';
            $show_user          = $audit['audit_uname'];
            $show_time          = date('Y-m-d H:i:s',$audit['audit_time']);
        }else if($audit['dst_status']==2){
            $show               = '<span class="red">未通过</span>';
            $show_user          = $audit['audit_uname'];
            $show_reason        = $audit['audit_reason'];
            $show_time          = date('Y-m-d H:i:s',$audit['audit_time']);
        }else if($audit['dst_status']==3){
            $show               = '<span class="yellow">毛利率未达标,待领导复批</span>';
            $show_user          = $audit['audit_uname'];
            $show_reason        = $audit['audit_reason'];
            $show_time          = date('Y-m-d H:i:s',$audit['audit_time']);
        }

        $op_cost_type           = M('op_cost_type')->getField('name',true);
        //求未填写合格供方的数据(辅导员和op_c(ost_type表中的数据不用填写合格供方)
        $noSupplierResData      = array();
        foreach($jiesuan as $k=>$v){
            if($v['type'] != 2 &&  !in_array($v['title'],$op_cost_type) && !$v['supplier_id']){
                $noSupplierResData[] = $v;
            }
        }

        $op['showstatus']       = $show;
        $op['show_user']        = $show_user;
        $op['show_time']        = $show_time;
        $op['show_reason']      = $show_reason;

        $this->noSupplierResNum = count($noSupplierResData);
        $is_dijie               = M('op')->where(array('dijie_opid'=>$opid))->getField('op_id');
        $this->is_dijie         = $is_dijie?$is_dijie:0;
        $dijie_shouru           = $mod->get_landAcquisitionAgency_money($op,P::REQ_TYPE_SETTLEMENT);   //801 获取地接结算收入
        $this->kind				= M('supplierkind')->where(array('id'=>array('neq',2)))->getField('id,name',true);
        $this->kind_all		    = M('supplierkind')->getField('id,name',true);
        //$this->costtype			= array('1'=>'其他','2'=>'专家辅导员','3'=>'合格供方','4'=>'物资');
        $budget_list            = M('op_budget')->where(array('op_id'=>$opid))->find();
        $this->should_back_money= $is_dijie?$settlement['shouru']:($budget_list['should_back_money']?$budget_list['should_back_money']:$budget['shouru']); //回款金额(带入结算收入)
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
        //$this->kinds			=  M('project_kind')->getField('id,name', true);
        $this->kinds			=  M('project_kind')->where(array('id'=>$op['kind']))->find();
        $this->is_zutuan        = $is_zutuan;
        $this->dijie_shouru     = $dijie_shouru?$dijie_shouru:0;
        $this->op_cost_type     = $op_cost_type;
        $this->op_cost_type_str = implode(',',$op_cost_type);
        //检查先回款,在做结算  //已回款金额
        $money_back             = check_money_back($opid);
        $this->yihuikuan        = $money_back;
        $this->guide            = M()->table('__GUIDE_PAY__ as p')->field('g.name as title,p.op_id,p.num,p.price,p.total,p.really_cost,p.remark')->join('left join __GUIDE__ as g on p.guide_id=g.id')->where(array('p.op_id'=>$opid,'p.status'=>2))->select();
        $this->businessDep      = C('DIJIE_NAME');
        $this->groups           = M('op_group')->where(array('op_id'=>$opid))->select(); //拼团信息
        $this->userkey          = get_username(); //人员名单关键字
        if ($op['kind']==87 && $op['in_dijie'] ==1) {  //单进院所 + 地接团
            $this->dijie_op_data= $this->get_dijie_op_data($op);
        }
        $this->display('settlement');
    }

    //获取地接团信息
    private function get_dijie_op_data($op){
        $dep_time               = M('op_team_confirm')->where(array('op_id'=>$op['op_id']))->getField('dep_time'); //出团时间
        $dijie_opid             = $op['dijie_opid'];
        $dijie_op               = $dijie_opid ? M('op')->where(array('op_id'=>$dijie_opid))->find() : '';
        $dijie_settlement       = $dijie_opid ? M('op_settlement')->where(array('op_id'=>$dijie_opid))->find() : '';
        $data                   = $dijie_op ? $dijie_op : array();
        $data['group_id']       = $data['group_id'] ? $data['group_id'] : get_group_id($op['dijie_name'],$dep_time);
        $data['op_id']          = $data['op_id'] ? $data['op_id'] : opid();
        $data['project']        = $data['project'] ? $data['project'] : create_dj_project($op['project']);
        $data['maoli']          = $dijie_settlement ? $dijie_settlement['maoli'] : 0;
        return $data;
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
		$group          = I('group','');
		$num			= 0;

		//保存结算
		if($opid && $costacc){

			$delid                  = array();
			foreach($costacc as $k=>$v){
				$data               = array();
				$data               = $v;
				$data['op_id']      = $opid;
				$data['status']     = 2;

				if($resid && $resid[$k]['id']>0){
					$edits          = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[]        = $resid[$k]['id'];
					$num++;
				}else{
					$savein         = $db->add($data);
					$delid[]        = $savein;
					if($savein) $num++;
				}
			}

			if($settlement){
				M('op_settlement')->data($info)->where(array('id'=>$settlement))->save();
			}else{
				$info['create_time']= time();
				$settlement         = M('op_settlement')->add($info);
			}

			$del                    = $db->where(array('op_id'=>$opid,'status'=>2,'id'=>array('not in',$delid)))->delete();
			if($del) $num++;
		}

		if ($group){ //保存个拼团数据毛利
		    $group_db               = M('op_group');
		    foreach ($group as $gk=>$gv){
                $data               = $gv;
                $data['settlement_id'] = $settlement;
                $res                = $group_db->where(array('id'=>$gv['id']))->save($data);
                if ($res) $num++;
            }
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
		$op_id 					= I('opid');
		if(isset($_POST['dosubmit'])){
			$noSupplierResNum	= I('noSupplierResNum');
		if ($noSupplierResNum) { $this->error('您有结算项未填写合格供方'); }
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
        $mod                            = D('Finance');
		$opid                           = I('opid');
		$id                             = I('id');
		if($id){
			$budget                     = M('op_huikuan')->find($id);
			$opid                       = $budget['op_id'];
		}
		if(!$opid) $this->error('项目不存在');

		$op                             = M('op')->where(array('op_id'=>$opid))->find();
		$settlement                     = M('op_settlement')->where(array('op_id'=>$opid))->find();
		$huikuan                        = M('op_huikuan')->where(array('op_id'=>$opid))->order('id DESC')->select();
		foreach($huikuan as $k=>$v){

			$show                       = '';
			$show_user                  = '';
			$show_time                  = '';
			$show_reason                = '';

			$where                      = array();
			$where['req_type']          = P::REQ_TYPE_HUIKUAN;
			$where['req_id']            = $v['id'];
			$audit                      = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show                   = '未审批';
				$show_user              = '未审批';
				$show_time              = '等待审批';
			}else if($audit['dst_status']==1){
				$show                   = '<span class="green">已通过</span>';
				$show_user              = $audit['audit_uname'];
				$show_time              = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show                   = '<span class="red">未通过</span>';
				$show_user              = $audit['audit_uname'];
				$show_reason            = $audit['audit_reason'];
				$show_time              = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$huikuan[$k]['showstatus']  = $show;
			$huikuan[$k]['show_user']   = $show_user;
			$huikuan[$k]['show_time']   = $show_time;
			$huikuan[$k]['show_reason'] = $show_reason;
		}

        $this->jd               = $mod->get_jidiao($opid); //计调
        $this->budget_audit_uid = $mod->get_budget_audit_uid($opid); //预算审核人
		$this->op    		    = $op;
		$this->settlement	    = $settlement;
		$this->kinds		    = M('project_kind')->getField('id,name', true);
		$this->payment		    = M('contract_pay')->where(array('op_id'=>$opid))->sum('pay_amount');
		$this->huikuan          = $huikuan;
		$this->huikuanlist	    = M()->table('__CONTRACT_PAY__ as p')->field('p.*,c.contract_id')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->where(array('p.op_id'=>$opid,'p.status'=>array('neq','2')))->order('p.id asc')->select();
        $this->type             = C('JIEKUAN_TYPE'); //回款方式
        $this->company          = C('COMPANY'); //回款单位
		//$this->pays 			= M()->table('__CONTRACT_PAY__ as p')->field('p.*,c.contract_id')->join('__CONTRACT__ as c on c.id = p.cid','LEFT')->where(array('p.op_id'=>$opid))->order('p.id asc')->select();
		$this->pays 			= $mod->get_money_back_lists($opid);
        $budget_list            = M('op_budget')->where(array('op_id'=>$opid))->find();
        $this->should_back_money= $budget_list['should_back_money']?$budget_list['should_back_money']:$budget_list['shouru'];
        $is_dijie               = M('op')->where(array('dijie_opid'=>$opid))->getField('op_id');
        $this->is_dijie         = $is_dijie?$is_dijie:0;
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
        $info['create_time']    = time();
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
    /*public function payment(){
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
	}*/

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
        $departids          = array(2,6,7,12,13,14,15,16,17);
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
        $this->jk_lists     = $jk_lists;
        $this->departments  = $departments;
        $this->budget       = $budget;
        $this->costacc      = $costacc;
        //$this->kind         = C('COST_TYPE');
        $this->kind         = M('supplierkind')->getField('id,name',true);
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->audit_yusuan = $audit_yusuan;
        $this->op           = $op;
        $this->company      = C('COMPANY');
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

            //保存团内支出借款申请
            if ($savetype==2){

                $db                 = M('jiekuan');
                $info               = I('info');
                $data               = I('data');
                $info['type']       = I('type');
                $info['jkd_id']     = make_num('TNJK','jiekuan','jkd_id');
                $info['jk_user']    = cookie('nickname');
                $info['jk_user_id'] = cookie('userid');
                $info['jk_time']    = NOW_TIME;
                $info['jkd_type']   = 1;    //团内支出借款

                $res = $db->add($info);
                if ($res){
                    //该团的预算审批人
                    $jk_departmentid    = $info['department_id'];
                    $audit_ys           = M('salary_department')->field('department,jk_audit_user_id,jk_audit_user_name')->where(array('id'=>$jk_departmentid))->find();

                    $jiekuan_audit          = array();
                    $jiekuan_audit['op_id'] = $info['op_id'];
                    $jiekuan_audit['jk_id'] = $res;
                    $jiekuan_audit['jkd_id']= $info['jkd_id'];

                    //与预算审批人审核
                    $jiekuan_audit['ys_audit_userid']   = $audit_ys['jk_audit_user_id'];
                    $jiekuan_audit['ys_audit_username'] = $audit_ys['jk_audit_user_name'];
                    $jiekuan_audit['cw_audit_userid']   = 55;
                    $jiekuan_audit['cw_audit_username'] = '程小平';
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
                    $title   = '您有来自['.$info['jk_user'].']的借款申请!';
                    $content = '项目名称：'.$project.'，团号：'.$info['group_id'].'，借款金额：'.$info['sum'];
                    $url     = U('Finance/audit_jiekuan',array('id'=>$res,'op_id'=>$info['op_id'],'audit_usertype'=>$audit_usertype));
                    $user    = '['.$msg_user.']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['bill_id']      = $info['jkd_id'];
                    $record['type']         = 1;
                    $record['explain']      = '填写借款申请,借款金额'.$info['sum'];
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存团内借款预算审核人审核信息
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
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $op             = M('op')->where(array('op_id'=>$opid))->find();
                    $audit_zhuangtai= C('AUDIT_STATUS');
                    $zhuangtai      = $audit_zhuangtai[$info['ys_audit_status']];
                    if ($info['ys_audit_status'] ==1){
                        $audit_usertype                     = 2;    //财务主管
                        $cw_audit_userid                    = 55;   //程小平
                        //审核通过,到达财务//发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款申请!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门主管审核意见：<span class='red'>".$zhuangtai."；".$info['ys_remark']."</span>";
                        $url     = U('Finance/audit_jiekuan',array('id'=>$jk_id,'op_id'=>$opid,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$cw_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //审核不通过
                        D('Finance')->save_jkd_audit($jk_id,$info['ys_audit_status']);

                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['ys_audit_username'].']的借款审批回复!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门主管审核意见：<span class='red'>".$zhuangtai."；".$info['ys_remark']."</span>";
                        $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                        $user    = '['.$jk_info['jk_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

                    $record = array();
                    $record['bill_id']  = $jkd_id;
                    $record['type']     = 1;
                    $record['explain']  = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('数据保存成功!');
                }else{
                    $this->error('数据保存失败!');
                }
            }

            //保存团内借款财务审核信息
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
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $op             = M('op')->where(array('op_id'=>$opid))->find();
                    $audit_zhuangtai= C('AUDIT_STATUS');
                    $zhuangtai      = $audit_zhuangtai[$info['cw_audit_status']];
                    if ($info['cw_audit_status'] ==1){
                        $cn_userid  = 27;   //出纳(殷红)
                        //审核通过发送系统消息(出纳)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款单,请及时跟进!';
                        $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai."；".$info['cw_remark']."</span>";
                        $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                        $user    = '['.$cn_userid.']';
                        //send_msg($uid,$title,$content,$url,$user,'');
                    }
                    //发送系统消息(借款人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['cw_audit_username'].']的借款审批回复!';
                    $content = '项目名称：'.$op['project'].'，借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai."；".$info['cw_remark']."</span>";
                    $url     = U('Finance/jiekuandan_info',array('jkid'=>$jk_id));
                    $user    = '['.$jk_info['jk_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    //审核不通过
                    D('Finance')->save_jkd_audit($jk_id,$info['cw_audit_status']);

                    $record = array();
                    $record['bill_id']  = $jkd_id;
                    $record['type']     = 1;
                    $record['explain']  = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('数据保存成功');
                }else{
                    $this->error('数据保存失败');
                }
            }

            //保存团内借款报销
            if ($savetype==5){
                $loan_lists     = I('loan');
                $info           = I('info');
                $type           = I('type');
                $total          = I('total');

                if (!$info['department_id']){ $this->error('报销部门不能为空'); }
                if (!$info['company']){ $this->error('账单分类不能为空'); }
                if (!$info['supplierid'] || !trim($info['payee'])){ $this->error('受款单位信息错误'); }

                $info['bxd_id']         = make_num('TNBX','baoxiao','bxd_id');
                $info['opids']          = implode(',',array_unique(array_column($loan_lists,'op_id')));
                $info['group_ids']      = implode(',',array_unique(array_column($loan_lists,'group_id')));
                $info['costacc_ids']    = implode(',',array_unique(array_column($loan_lists,'costacc_id')));
                $info['jkd_ids']        = D('Finance')->get_jkd($loan_lists);
                $info['yingbaoxiao']    = $total['jk_total'];
                $info['type']           = $type;
                $info['bx_user_id']     = cookie('userid');
                $info['bx_user']        = cookie('nickname');
                $department             = M('salary_department')->where(array('id'=>$info['department_id']))->find();
                $info['department']     = $department['department'];
                $info['bx_time']        = NOW_TIME;
                $info['bxd_type']       = 1;    //团内借款报销

                //获取证明验收人信息(所选单项预算金额最多的业务)
                $new_lists              = multi_array_sort($loan_lists,'ctotal',SORT_DESC,SORT_NUMERIC);
                $opid                   = D('Finance')->get_zmysr_id($new_lists);
                $where                  = array();
                $where['o.op_id']       = $opid;
                $fields                 = "a.id,a.nickname,o.project,o.group_id";
                $zmysr_info             = M()->table('__OP__ as o')->join('__ACCOUNT__ as a on a.id=o.create_user','left')->where($where)->field($fields)->find();
                if ($zmysr_info['id']){
                    $res    = M('baoxiao')->add($info);   //保存报销单基本信息
                    if ($res){
                        $audit                      = array();
                        $audit['bx_id']             = $res;
                        $audit['bxd_id']            = $info['bxd_id'];
                        $audit['zm_audit_userid']   = $zmysr_info['id'];
                        $audit['zm_audit_username'] = $zmysr_info['nickname'];
                        $audit['ys_audit_userid']   = $department['jk_audit_user_id'];
                        $audit['ys_audit_username'] = $department['jk_audit_user_name'];
                        $audit['cw_audit_userid']   = 55;
                        $audit['cw_audit_username'] = '程小平';
                        M('baoxiao_audit')->add($audit);    //保存报销审核信息

                        //保存报销详情
                        foreach ($loan_lists as $k=>$v){
                            $con                = array();
                            $con['op_id']       = $v['op_id'];
                            $con['group_id']    = $v['group_id'];
                            $con['bx_id']       = $res;
                            $con['bxd_id']      = $info['bxd_id'];
                            $con['costacc_id']  = $v['costacc_id'];
                            $con['ys']          = $v['ctotal'];
                            $con['ybx']         = $v['jiekuan'];
                            $con['sbx']         = $v['baoxiao'];
                            M('baoxiao_detail')->add($con);
                        }

                        //发送系统通知
                        $audit_usertype         = 1;    //证明验收人
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$info['bx_user'].']团内报销单待证明验收!';
                        $content = '项目名称：'.$zmysr_info['project'].'，团号：'.$zmysr_info['group_id'].'，报销金额：'.$info['sum'];
                        $url     = U('Finance/audit_baoxiao',array('id'=>$res,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$audit['zm_audit_userid'].']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        $record             = array();
                        $record['bill_id']  = $info['bxd_id'];
                        $record['type']     = 2;
                        $record['explain']  = '填写报销单,报销金额'.$info['sum'];
                        jkbx_record($record);

                        $this->success('保存成功');
                    }else{
                        $this->error('数据保存失败');
                    }
                }else{
                    $this->error('获取证明验收人信息失败');
                }

            }

            //审核团内报销单(证明验收人审核)
            if ($savetype==6){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['zm_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['zm_audit_status']];
                if ($res){
                    if ($info['zm_audit_status']==1){
                        //审核通过(预算审核人)
                        $audit_usertype                     = 2;    //预算审核人
                        $ys_audit_userid                    = $audit_info['ys_audit_userid'];
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销申请!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />证明验收人审核意见：<span class='red'>".$zhuangtai.'；'.$info['zm_remark']."</span>";
                        $url     = U('Finance/audit_baoxiao',array('id'=>$bx_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$ys_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //发送系统消息 审核不通过(报销人)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['zm_audit_username'].']的报销单审核反馈!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />证明验收人审核意见：<span class='red'>".$zhuangtai.'；'.$info['zm_remark']."</span>";
                        $url     = U('Finance/baoxiaodan_info',array('id'=>$bx_id));
                        $user    = '['.$bx_info['bx_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        //保存审核结果
                        D('Finance')->save_bxd_audit($bx_id,$info['zm_audit_status']);
                    }
                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '证明验收人审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //审核团内报销单(预算审核人审核)
            if ($savetype==7){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['ys_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['ys_audit_status']];
                if ($res){
                    if ($info['ys_audit_status']==1){
                        //审核通过(财务主管)
                        $audit_usertype                     = 3;    //财务主管
                        $cw_audit_userid                    = $audit_info['cw_audit_userid'];
                        //审核通过,到达财务//发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销申请!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />预算负责人审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>";
                        $url     = U('Finance/audit_baoxiao',array('id'=>$bx_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$cw_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        $bxr_content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />预算审核人审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>；请及时打印报销单,并附上相关票据交至财务部审核!";
                    }else{

                        $bxr_content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />预算审核人审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>";
                        //保存审核结果
                        D('Finance')->save_bxd_audit($bx_id,$info['ys_audit_status']);
                    }

                    //发送系统消息过(报销人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['ys_audit_username'].']的报销单审核反馈!';
                    $content = $bxr_content;
                    $url     = U('Finance/baoxiaodan_info',array('id'=>$bx_id));
                    $user    = '['.$bx_info['bx_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '预算审核人审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //审核团内报销单(财务主管审核)
            if ($savetype==8){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['cw_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['cw_audit_status']];
                if ($res){
                    if ($info['cw_audit_status']==1){
                        //审核通过(通知出纳)
                        $cn_userid  = 27;   //出纳(殷红)
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销单,请及时跟进!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai.'；'.$info['cw_remark']."</span>";
                        $url     = U('Finance/baoxiaodan_info',array('id'=>$bx_id));
                        $user    = '['.$cn_userid.']';
                        //send_msg($uid,$title,$content,$url,$user,'');
                    }
                    //发送系统消息(报销人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['cw_audit_username'].']的报销单审核反馈!';
                    $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai.'；'.$info['cw_remark']."</span>";
                    $url     = U('Finance/baoxiaodan_info',array('id'=>$bx_id));
                    $user    = '['.$bx_info['bx_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    //保存审核结果
                    D('Finance')->save_bxd_audit($bx_id,$info['cw_audit_status']);

                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '财务主管审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存非团支出借款
            if ($savetype==9){

                $db                 = M('jiekuan');
                $info               = I('info');
                $info['type']       = I('type');
                $info['jkd_id']     = make_num('JKD','jiekuan','jkd_id');
                $info['jk_user']    = cookie('nickname');
                $info['jk_user_id'] = cookie('userid');
                $info['jk_time']    = NOW_TIME;
                $info['jkd_type']   = 2;    //非团支出借款
                $res = $db->add($info);

                if ($res){
                    //该团的部门负责人及分管领导信息
                    $jk_departmentid    = $info['department_id'];
                    $fields             = "department,manager_id,manager_name,boss_id,boss_name";
                    $audit_users        = M('salary_department')->field($fields)->where(array('id'=>$jk_departmentid))->find();

                    $jiekuan_audit          = array();
                    $jiekuan_audit['jk_id'] = $res;
                    $jiekuan_audit['jkd_id']= $info['jkd_id'];

                    //相关审核人员信息
                    $jiekuan_audit['manager_userid']    = $audit_users['manager_id'];   //部门负责人
                    $jiekuan_audit['manager_username']  = $audit_users['manager_name'];
                    $jiekuan_audit['ys_audit_userid']   = $audit_users['boss_id'];      //部门分管领导
                    $jiekuan_audit['ys_audit_username'] = $audit_users['boss_name'];
                    $jiekuan_audit['cw_audit_userid']   = 55;
                    $jiekuan_audit['cw_audit_username'] = '程小平';
                    $audit_usertype                     = 1;                            //部门负责人(主管/经理)
                    $msg_user                           = $jiekuan_audit['manager_userid'];

                    M('jiekuan_audit')->add($jiekuan_audit);

                    //发送系统消息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$info['jk_user'].']的借款申请!';
                    $content = '借款单号'.$info['jkd_id'].'，借款金额：'.$info['sum'];
                    $url     = U('Finance/audit_nopjk',array('id'=>$res,'audit_usertype'=>$audit_usertype));
                    $user    = '['.$msg_user.']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['bill_id']      = $info['jkd_id'];
                    $record['type']         = 1;
                    $record['explain']      = '填写借款申请,借款金额'.$info['sum'];
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存非团借款部门负责人签字
            if ($savetype==10){

                $db                 = M('jiekuan_audit');
                $jk_id              = I('jk_id');
                $jkd_id             = I('jkd_id');
                $info               = I('info');
                $audit_id           = I('audit_id');
                $info['manager_audit_time'] = NOW_TIME;

                $res = $db->where(array('id'=>$audit_id))->save($info);
                if ($res){
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $audit_zhuangtai= C('AUDIT_STATUS');
                    $zhuangtai      = $audit_zhuangtai[$info['manager_audit_status']];

                    if ($info['manager_audit_status'] ==1){
                        $audit_usertype     = 2;                                //部门分管领导
                        $ys_audit_userid    = $audit_info['ys_audit_userid'];   //部门分管领导
                        //发送系统消息  审核通过,到达部门分管领导
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款申请!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门负责人审核意见：<span class='red'>".$zhuangtai."；".$info['manager_remark']."</span>";
                        $url     = U('Finance/audit_nopjk',array('id'=>$jk_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$ys_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //审核不通过
                        D('Finance')->save_jkd_audit($jk_id,$info['manager_audit_status']);

                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['manager_username'].']的借款审批回复!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门负责人审核意见：<span class='red'>".$zhuangtai."；".$info['manager_remark']."</span>";
                        $url     = U('Finance/nopjk_info',array('jkid'=>$jk_id));
                        $user    = '['.$jk_info['jk_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

                    $record = array();
                    $record['bill_id']  = $jkd_id;
                    $record['type']     = 1;
                    $record['explain']  = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('数据保存成功!');
                }else{
                    $this->error('数据保存失败!');
                }
            }

            //保存非团借款部门分管领导签字
            if ($savetype==11){
                $db                 = M('jiekuan_audit');
                $jk_id              = I('jk_id');
                $jkd_id             = I('jkd_id');
                $info               = I('info');
                $audit_id           = I('audit_id');
                $info['ys_audit_time'] = NOW_TIME;

                $res = $db->where(array('id'=>$audit_id))->save($info);
                if ($res){
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $audit_zhuangtai= C('AUDIT_STATUS');
                    $zhuangtai      = $audit_zhuangtai[$info['ys_audit_status']];
                    if ($info['ys_audit_status'] ==1){
                        $audit_usertype                     = 3;    //财务主管
                        $cw_audit_userid                    = 55;   //程小平
                        //审核通过,到达财务//发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款申请!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai."；".$info['ys_remark']."</span>";
                        $url     = U('Finance/audit_nopjk',array('id'=>$jk_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$cw_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        //发送系统消息(给借款人反馈)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['ys_audit_username'].']的借款审批回复!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai."；".$info['ys_remark']."</span>";
                        $url     = U('Finance/nopjk_info',array('jkid'=>$jk_id));
                        $user    = '['.$jk_info['jk_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //审核不通过
                        D('Finance')->save_jkd_audit($jk_id,$info['ys_audit_status']);

                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['ys_audit_username'].']的借款审批回复!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai."；".$info['ys_remark']."</span>";
                        $url     = U('Finance/nopjk_info',array('jkid'=>$jk_id));
                        $user    = '['.$jk_info['jk_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

                    $record = array();
                    $record['bill_id']  = $jkd_id;
                    $record['type']     = 1;
                    $record['explain']  = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('数据保存成功!');
                }else{
                    $this->error('数据保存失败!');
                }
            }

            //保存非团借款财务审核信息
            if ($savetype==12){

                $db                 = M('jiekuan_audit');
                $jk_id              = I('jk_id');
                $jkd_id             = I('jkd_id');
                $info               = I('info');
                $audit_id           = I('audit_id');
                $info['cw_audit_time'] = NOW_TIME;

                $res = $db->where(array('id'=>$audit_id))->save($info);
                if ($res){
                    $jk_info        = M('jiekuan')->where(array('id'=>$jk_id))->find();
                    $audit_info     = M('jiekuan_audit')->where(array('id'=>$audit_id))->find();
                    $audit_zhuangtai= C('AUDIT_STATUS');
                    $zhuangtai      = $audit_zhuangtai[$info['cw_audit_status']];
                    if ($info['cw_audit_status'] ==1){
                        $cn_userid  = 27;   //出纳(殷红)
                        //审核通过发送系统消息(出纳)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$jk_info['jk_user'].']的借款单,请及时跟进!';
                        $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai."；".$info['cw_remark']."</span>";
                        $url     = U('Finance/nopjk_info',array('jkid'=>$jk_id));
                        $user    = '['.$cn_userid.']';
                        //send_msg($uid,$title,$content,$url,$user,'');
                    }
                    //发送系统消息(借款人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['cw_audit_username'].']的借款审批回复!';
                    $content = '借款单号：'.$jkd_id.'，借款金额：'.$jk_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai."；".$info['cw_remark']."</span>";
                    $url     = U('Finance/nopjk_info',array('jkid'=>$jk_id));
                    $user    = '['.$jk_info['jk_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    D('Finance')->save_jkd_audit($jk_id,$info['cw_audit_status']);

                    $record = array();
                    $record['bill_id']  = $jkd_id;
                    $record['type']     = 1;
                    $record['explain']  = '审核借款申请单，借款单号：'.$jkd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('数据保存成功');
                }else{
                    $this->error('数据保存失败');
                }
            }

            //保存非团支出报销(修改时注意:关联两个表单提交loan_content and loan_jk_content)
            if ($savetype==13){

                $share              = I('share');
                $zmysr_id           = I('zmysr_id');
                $zmysr_name         = I('zmysr_name');
                $info               = I('info');
                $info['type']       = I('type');
                $info['bxd_type']   = I('bxd_type');    //2=>非团借款报销,3=>直接报销
                $info['bxd_id']     = make_num('BXD','baoxiao','bxd_id');
                $info['jkd_ids']    = I('jkd_id')?I('jkd_id'):'';
                $info['yingbaoxiao']= I('yingbaoxiao')?I('yingbaoxiao'):'0.00';
                $info['bx_user_id'] = cookie('userid');
                $info['bx_user']    = cookie('nickname');
                $info['bx_time']    = NOW_TIME;

                if ($zmysr_id){
                    $res    = M('baoxiao')->add($info);   //保存报销单基本信息
                    if ($res){
                        $department                 = M('salary_department')->where(array('id'=>$info['department_id']))->find();
                        $audit                      = array();
                        $audit['bx_id']             = $res;
                        $audit['bxd_id']            = $info['bxd_id'];
                        $audit['zm_audit_userid']   = $zmysr_id;
                        $audit['zm_audit_username'] = $zmysr_name;
                        $audit['manager_userid']    = $department['manager_id'];
                        $audit['manager_username']  = $department['manager_name'];
                        $audit['ys_audit_userid']   = $department['boss_id'];
                        $audit['ys_audit_username'] = $department['boss_name'];
                        $audit['cw_audit_userid']   = 55;
                        $audit['cw_audit_username'] = '程小平';
                        M('baoxiao_audit')->add($audit);    //保存报销审核信息

                        if ($share && $info['share']==1){
                            //保存分摊信息
                            foreach ($share as $v){
                                $v['bx_id']         = $res;
                                $v['bxd_id']        = $info['bxd_id'];
                                $v['input_time']    = NOW_TIME;
                                M('baoxiao_share')->add($v);
                            }
                        }

                        //发送系统通知
                        $audit_usertype         = 1;    //证明验收人
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$info['bx_user'].']非团支出报销单待证明验收!';
                        $content = '报销单号：'.$info['bxd_id'].'，报销金额：'.$info['sum'];
                        $url     = U('Finance/nopbxd_info',array('id'=>$res,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$audit['zm_audit_userid'].']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        $record             = array();
                        $record['bill_id']  = $info['bxd_id'];
                        $record['type']     = 2;
                        $record['explain']  = '填写非团支出报销单,报销金额'.$info['sum'];
                        jkbx_record($record);

                        $this->success('保存成功');
                    }else{
                        $this->error('数据保存失败');
                    }
                }else{
                    $this->error('获取证明验收人信息失败');
                }
            }

            //审核非团借款报销单(证明验收人审核)
            if ($savetype==14){

                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['zm_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['zm_audit_status']];
                if ($res){
                    if ($info['zm_audit_status']==1){
                        //审核通过(部门主管)
                        $audit_usertype     = 2;    //部门主管
                        $manager_userid     = $audit_info['manager_userid'];
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销申请!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />证明验收人审核意见：<span class='red'>".$zhuangtai.'；'.$info['zm_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$manager_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //发送系统消息 审核不通过(报销人)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['zm_audit_username'].']的报销单审核反馈!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />证明验收人审核意见：<span class='red'>".$zhuangtai.'；'.$info['zm_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id));
                        $user    = '['.$bx_info['bx_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        //保存审核结果
                        D('Finance')->save_bxd_audit($bx_id,$info['zm_audit_status']);
                    }
                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '证明验收人审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //审核非团借款报销单(部门主管审核)
            if ($savetype==15){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['manager_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['manager_audit_status']];
                if ($res){
                    if ($info['manager_audit_status']==1){
                        //审核通过(部门分管领导)
                        $audit_usertype                     = 3;    //部门分管领导
                        $ys_audit_userid                    = $audit_info['ys_audit_userid'];
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销申请!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai.'；'.$info['manager_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$ys_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        //发送系统消息 审核不通过(报销人)
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$audit_info['zm_audit_username'].']的报销单审核反馈!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai.'；'.$info['manager_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id));
                        $user    = '['.$bx_info['bx_user_id'].']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        //保存审核结果
                        D('Finance')->save_bxd_audit($bx_id,$info['manager_audit_status']);
                    }
                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '部门分管领导审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //审核非团借款报销单(部门分管领导审核)
            if ($savetype==16){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $info['ys_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['ys_audit_status']];

                if ($res){
                    if ($info['ys_audit_status']==1){
                        //审核通过(财务)
                        $audit_usertype                     = 4;    //财务
                        $cw_audit_userid                    = $audit_info['cw_audit_userid'];
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销申请!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id,'audit_usertype'=>$audit_usertype));
                        $user    = '['.$cw_audit_userid.']';
                        send_msg($uid,$title,$content,$url,$user,'');

                        $bxr_content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>；请及时打印报销单,并附上相关票据交至财务部审核!";
                    }else{

                        $bxr_content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />部门分管领导审核意见：<span class='red'>".$zhuangtai.'；'.$info['ys_remark']."</span>";
                        //保存审核结果
                        D('Finance')->save_bxd_audit($bx_id,$info['ys_audit_status']);
                    }

                    //发送系统消息(报销人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['ys_audit_username'].']的报销单审核反馈!';
                    $content = $bxr_content;
                    $url     = U('Finance/nopbxd_info',array('id'=>$bx_id));
                    $user    = '['.$bx_info['bx_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '部门分管领导审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //审核非团借款报销单(财务审核)
            if ($savetype==17){
                $db                     = M('baoxiao_audit');
                $bx_id                  = I('bx_id');
                $bxd_id                 = I('bxd_id');
                $audit_id               = I('audit_id');
                $info                   = I('info');
                $empty_bill             = I('empty_bill');
                $info['cw_audit_time']  = NOW_TIME;
                $res                    = $db->where(array('id'=>$audit_id))->save($info);
                $bxd                    = array();
                $bxd['bxd_kind']        = I('bxd_kind');
                if ($empty_bill == 1){ //销账(调到资源管理部)
                    $bxd['department_id']= 4;
                    $bxd['department']  = '资源管理部';
                }
                M('baoxiao')->where(array('id'=>$bx_id))->save($bxd);
                $bx_info                = M('baoxiao')->where(array('id'=>$bx_id))->find();
                $audit_info             = M('baoxiao_audit')->where(array('id'=>$audit_id))->find();
                $audit_zhuangtai        = C('AUDIT_STATUS');
                $zhuangtai              = $audit_zhuangtai[$info['cw_audit_status']];
                if ($res){
                    if ($info['cw_audit_status']==1){
                        //审核通过(通知出纳)
                        $cn_userid  = 27;   //出纳(殷红)
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$bx_info['bx_user'].']的报销单,请及时跟进!';
                        $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai.'；'.$info['cw_remark']."</span>";
                        $url     = U('Finance/nopbxd_info',array('id'=>$bx_id));
                        $user    = '['.$cn_userid.']';
                        //send_msg($uid,$title,$content,$url,$user,'');
                    }
                    //发送系统消息(报销人)
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$audit_info['cw_audit_username'].']的报销单审核反馈!';
                    $content = '报销单号：'.$bxd_id.'，报销金额：'.$bx_info['sum']."，<hr />财务主管审核意见：<span class='red'>".$zhuangtai.'；'.$info['cw_remark']."</span>";
                    $url     = U('Finance/nopbxd_info',array('id'=>$bx_id));
                    $user    = '['.$bx_info['bx_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    //保存审核结果
                    D('Finance')->save_bxd_audit($bx_id,$info['cw_audit_status']);

                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '财务主管审核报销申请单，报销单号：'.$bxd_id.'，审核结果：'.$zhuangtai;
                    jkbx_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存项目预算详情财务备注等信息
            if ($savetype==18){
                $num                = 0;
                $costacc_id         = I('costacc_id');
                $info               = array();
                $info['cwremark']   = I('cwremark');
                $res                = M('op_costacc')->where(array('id'=>$costacc_id))->save($info);
                if ($res) $num++;
                echo $num;
            }

            //保存修改借款单
            if ($savetype==19){
                $id             = I('jkid');
                $jkd_id         = I('jkd_id');
                if (!$id){ $this->error('保存信息失败'); }
                $info           = I('info');
                $info['type']   = I('type');
                $res            = M('jiekuan')->where(array('id'=>$id))->save($info);
                if ($res){
                    $record = array();
                    $record['bill_id']      = $jkd_id;
                    $record['type']         = 1;
                    $record['explain']      = '更改借款单信息';
                    jkbx_record($record);

                    $this->success('修改成功',U('Finance/jiekuan_lists'));
                }else{
                    $this->error('修改失败');
                }
            }

            //保存回款计划
            if ($savetype==20){
                $opid                           = I('opid');
                $payment                        = I('payment');
                $old_sum                        = I('old_sum'); //原计划回款金额
                $new_sum                        = array_sum(array_column($payment,'amount')); //现计划回款金额
                if (!$opid) $this->error('获取数据失败');
                $db                             = M('contract_pay');
                $cid                            = M('contract')->where(array('op_id'=>$opid))->getField('id');
                $op                             = M('op')->where(array('op_id'=>$opid))->find();
                $num                            = 0;
                $ids                            = array();
                if (is_array($payment)){
                    foreach ($payment as $v){
                        //保存数据
                        $info                   = array();
                        $info['cid']			= $cid?$cid:0;
                        $info['no']			    = $v['no'];
                        $info['pro_name']	    = $op['project'];
                        $info['op_id']  		= $opid;
                        $info['amount']		    = $v['amount'];
                        $info['ratio']		    = $v['ratio'];
                        $info['return_time']	= strtotime($v['return_time']);
                        $info['remark']		    = $v['remarks'];
                        $info['type']           = $v['type'];
                        $info['company']        = $v['company'];
                        $info['userid'] 		= cookie('userid');
                        $info['payee']		    = $op['create_user'];
                        $info['create_time']    = NOW_TIME;
                        if ($v['pid']){
                            $res                = $db->where(array('id'=>$v['pid']))->save($info);
                            $ids[]              = $v['pid'];
                        }else{
                            $res                = $db->add($info);
                            $ids[]              = $res;
                        }
                        if ($res) $num++;
                    }

                    if ($ids){ //删除相关数据
                        $where                  = array();
                        $where['op_id']         = $opid;
                        $where['id']            = array('not in',$ids);
                        $delres                 = $db->where($where)->delete();
                        if ($delres) $num++;
                    }
                }
                if ($num){
                    $data                       = array();
                    $data['should_back_money']  = $new_sum;
                    M('op_budget')->where(array('op_id'=>$opid))->save($data);
                    $record                     = array();
                    $record['op_id']            = $opid;
                    $record['optype']           = 4;
                    $record['explain']          = '编辑回款计划信息，原计划回款总金额'.$old_sum.'，现计划回款总金额'.$new_sum;
                    op_record($record);
                    $this->success('数据保存成功');
                }
            }

            //保存财务操作及时率指标
            if ($savetype==21){
                $db                         = M('quota');
                $id                         = I('id');
                $info                       = I('info');
                $info['title']              = htmlspecialchars(trim($info['title']));
                $info['content']            = htmlspecialchars(trim($info['content']));
                $info['rules']              = htmlspecialchars(trim($info['rules']));
                $info['type']               = 5; //5=>财务工作及时率
                if (!$info['title'])        $this->error('指标标题不能为空');

                if ($id){
                $where                  = array();
                $where['id']            = $id;
                $res                    = $db->where($where)->save($info);
                }else{
                $res                    = $db->add($info);
                }

                echo '<script>window.top.location.reload();</script>';

            }
        }
    }

    // @@@NODE-3###audit_jiekuan###审批团内借款###
    public function audit_jiekuan(){
        $id                 = I('id');
        $opid               = I('op_id');
        $audit_usertype     = I('audit_usertype');
        $op                 = M('op')->where(array('op_id'=>$opid))->find();
        $jiekuan            = M('jiekuan')->where(array('id'=>$id))->find();
        $jk_lists           = M()->table('__JIEKUAN_DETAIL__ as j')->join('__OP_COSTACC__ as c on c.id=j.costacc_id','left')->where(array('j.jk_id'=>$jiekuan['id']))->select();
        $this->jidiao       = M()->table('__OP_BUDGET__ as b')->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')->where(array('l.req_type'=>P::REQ_TYPE_BUDGET,'b.op_id'=>$jiekuan['op_id']))->getField('l.req_uname');

        $audit_userinfo     = M('jiekuan_audit')->where(array('op_id'=>$opid,'jk_id'=>$id))->find();
        if (!$audit_userinfo){ $this->error('获取信息失败'); };

        $this->jiekuan      = $jiekuan;
        $this->jk_lists     = $jk_lists;
        $this->op           = $op;
        $this->audit_userinfo= $audit_userinfo;
        $this->audit_usertype= $audit_usertype;
        $this->jk_type      = C('JIEKUAN_TYPE');

        $this->display();
    }

    // @@@NODE-3###jiekuan_lists###借款单列表###
    public function jiekuan_lists(){
        $pin            = I('pin')?I('pin'):0;
        $project        = I('title');
        $group_id       = I('oid');
        $jkd_id         = I('jkdid');
        $jk_user        = I('ou');

        $where          = array();
        $all_jkd        = array('Finance/all_jkd'); //查看所有借款单权限
        $auth           = explode(',',Rolerelation(cookie('roleid')));

        if (rolemenu($all_jkd)){
            if ($project)   $where['o.project'] = array('like','%'.$project.'%');
            if ($group_id)  $where['j.group_id']= array('like','%'.$group_id.'%');
            if ($jkd_id)    $where['j.jkd_id']  = array('like','%'.$jkd_id.'%');
            if ($jk_user)   $where['j.jk_user'] = array('like','%'.$jk_user.'%');
            if ($pin==1)    $where['jkd_type']  = 1;    //团内借款
            if ($pin==2)    $where['jkd_type']  = 2;    //非团借款
        }else{
            $where['j.jk_user_id']              = array('in',$auth);
            $where['a.ys_audit_userid']         = array('eq',cookie('userid'));
            $where['_logic'] = 'or';
            $map['_complex'] = $where;
            if ($project)   $map['o.project']   = array('like','%'.$project.'%');
            if ($group_id)  $map['j.group_id']  = array('like','%'.$group_id.'%');
            if ($jkd_id)    $map['j.jkd_id']    = array('like','%'.$jkd_id.'%');
            if ($jk_user)   $map['j.jk_user']   = array('like','%'.$jk_user.'%');
        }
        //分页
        $pagecount		= M()->table('__JIEKUAN__ as j')->field('j.*,o.project')->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->join('__OP__ as o on o.op_id=j.op_id','left')->where($where)->order($this->orders('j.id'))->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = M()->table('__JIEKUAN__ as j')->field('j.*,o.project')->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->join('__OP__ as o on o.op_id=j.op_id','left')->where($where)->order($this->orders('j.id'))->limit($page->firstRow . ',' . $page->listRows)->select();

        foreach ($lists as $k=>$v){
            if ($v['audit_status'] == 0) $lists[$k]['zhuangtai'] = "<span class='yellow'>审核中</span>";
            if ($v['audit_status'] == 1) $lists[$k]['zhuangtai'] = "<span class='green'>审核通过</span>";
            if ($v['audit_status'] == 2) $lists[$k]['zhuangtai'] = "<span class='red'>审核未通过</span>";
            if ($v['audit_status'] == -1) $lists[$k]['zhuangtai'] = "<span class=''>借款已销账</span>";
        }
        $this->lists    = $lists;
        $this->jk_type  = C('JIEKUAN_TYPE');
        $this->pin      = $pin;
        $this->display();
    }

    // @@@NODE-3###jiekuandan_info###团内借款单详情###
    public function jiekuandan_info(){
        $id             = I('jkid');
        $field          = 'j.*,a.jk_id,a.manager_userid,a.manager_username,a.manager_audit_file,a.manager_audit_status,a.manager_audit_time,a.manager_remark,a.ys_audit_userid,a.ys_audit_username,a.ys_audit_file,a.ys_audit_status,a.ys_audit_time,a.ys_remark,a.cw_audit_userid,a.cw_audit_username,a.cw_audit_file,a.cw_audit_status,a.cw_audit_time,a.cw_remark';
        $jiekuan        = M()->table('__JIEKUAN__ as j')->field($field)->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where(array('j.id'=>$id))->find();
        $jk_lists       = M()->table('__JIEKUAN_DETAIL__ as j')->join('__OP_COSTACC__ as c on c.id=j.costacc_id','left')->where(array('j.jk_id'=>$id))->select();
        $op             = M('op')->where(array('op_id'=>$jiekuan['op_id']))->find();
        $this->op       = $op;
        $this->jiekuan  = $jiekuan;
        $this->jk_lists = $jk_lists;
        $this->jk_type  = C('JIEKUAN_TYPE');
        $audit_userinfo = M('jiekuan_audit')->where(array('op_id'=>$op['op_id'],'jk_id'=>$id))->find();
        $this->audit_userinfo= $audit_userinfo;
        $this->record   = D('Finance')->get_record($jiekuan['jkd_id']);
        $this->jidiao   = M()->table('__OP_BUDGET__ as b')->join('__AUDIT_LOG__ as l on l.req_id=b.id','left')->where(array('l.req_type'=>P::REQ_TYPE_BUDGET,'b.op_id'=>$jiekuan['op_id']))->getField('l.req_uname');
        $this->company  = C('COMPANY');

        //审核人信息
        if ($jiekuan['ys_audit_userid']==cookie('userid') || cookie('userid')==11){
            $this->audit_usertype = 1;  //预算审批人(或乔总)
        }elseif ($jiekuan['cw_audit_userid']==cookie('userid')){
            $this->audit_usertype = 2;
        }
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
            if ($info['jk_audit_user_id']){
                $res            = $db->where(array('id'=>$id))->save($info);
            }

            echo "<script>window.top.location.reload();</script>";
        }else{
            $id                 = I('id');
            $list           = M('salary_department')->where(array('id'=>$id))->find();
            $this->list     = $list;
            $this->userkey  = get_userkey();
            $this->display();
        }
    }

    //@@@NODE-3###set_manager###配置部门经理###
    public function set_manager(){
        if(isset($_POST['dosubmint'])){
            $db             = M('salary_department');
            $id             = I('id');
            $info           = I('info');
            if ($info['manager_id']){
                $res            = $db->where(array('id'=>$id))->save($info);
            }

            echo "<script>window.top.location.reload();</script>";
        }else{
            $id             = I('id');
            $list           = M('salary_department')->where(array('id'=>$id))->find();
            $this->list     = $list;
            $this->userkey  = get_userkey();
            $this->display();
        }
    }

    //@@@NODE-3###set_manager###配置部门分管领导###
    public function set_depart_boss(){
        if(isset($_POST['dosubmint'])){
            $db             = M('salary_department');
            $id             = I('id');
            $info           = I('info');
            if ($info['boss_id']){
                $res            = $db->where(array('id'=>$id))->save($info);
            }

            echo "<script>window.top.location.reload();</script>";
        }else{
            $id             = I('id');
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

    //@@@NODE-3###loan_op###填写团内支出报销单###
    public function loan_op(){

        $departids          = array(2,6,7,12,13,14,15,16,17);
        $departments        = M('salary_department')->where(array('id'=>array('in',$departids)))->select();
        $this->kind			= M('supplierkind')->getField('id,name',true);
        $this->departments  = $departments;
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->company      = C('COMPANY');
        $this->display();
    }

    // @@@NODE-3###select_ys###选择预算信息###
    public function select_ys(){
        $title  = I('tit');
        $type   = I('ty');
        $opid   = I('opid');

        $where          = array();
        if ($title) $where['c.title'] = array('like','%'.$title.'%');
        if ($type)  $where['c.type']  = $type;
        $where['c.op_id'] = $opid;
        $where['c.status']= 1;
        $field          = array('o.group_id,c.id,c.op_id,c.title,c.unitcost,c.amount,c.total as ctotal,c.type');

        $lists          = M()->table('__OP_COSTACC__ as c')->join('__OP__ as o on o.op_id=c.op_id')->field($field)->where($where)->select();
        foreach ($lists as $k=>$v){
            //已借款信息
            $field      = array();
            $field[]    = 'sum(sjk) as jiekuan';
            $jiekuan_list= M('jiekuan_detail')->where(array('costacc_id'=>$v['id'],'audit_status'=>1))->field($field)->find();
            $jiekuan    = $jiekuan_list['jiekuan']?$jiekuan_list['jiekuan']:0;
            $lists[$k]['jiekuan'] = $jiekuan;
        }

        $this->opid     = $opid;
        $this->lists    = $lists;
        //$this->ctype    = C('COST_TYPE');
        $this->ctype    = M('supplierkind')->getField('id,name',true);
        $this->display('select_ys');
    }

    // @@@NODE-3###baoxiao_lists###报销单列表###
    public function baoxiao_lists(){
        $pin            = I('pin')?I('pin'):0;
        $group_id       = I('oid');
        $bxd_id         = I('bxdid');
        $bx_user        = I('ou');

        $where          = array();
        $all_jkd        = array('Finance/all_jkd'); //查看所有借款单权限
        $auth           = explode(',',Rolerelation(cookie('roleid')));

        if (rolemenu($all_jkd)){
            if ($group_id)  $where['b.group_ids']   = array('like','%'.$group_id.'%');
            if ($bxd_id)    $where['b.bxd_id']      = array('like','%'.$bxd_id.'%');
            if ($bx_user)   $where['b.bx_user']     = array('like','%'.$bx_user.'%');
            if ($pin==1)    $where['b.bxd_type']    = 1;
            if ($pin==2)    $where['b.bxd_type']    = array('in',array(2,3));
        }else{
            $where[]                                = " b.bx_user_id IN (".implode(',',$auth).") OR a.ys_audit_userid =".cookie('userid');
            if ($group_id)  $where['b.group_ids']   = array('like','%'.$group_id.'%');
            if ($bxd_id)    $where['b.bxd_id']      = array('like','%'.$bxd_id.'%');
            if ($bx_user)   $where['b.bx_user']     = array('like','%'.$bx_user.'%');
            if ($pin==1)    $where['b.bxd_type']    = 1;
            if ($pin==2)    $where['b.bxd_type']    = array('in',array(2,3));
        }

        //分页
        $pagecount		= M()->table('__BAOXIAO__ as b')->field('b.*')->join('__BAOXIAO_AUDIT__ as a on a.bx_id=b.id','left')->where($where)->order($this->orders('b.id'))->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = M()->table('__BAOXIAO__ as b')->field('b.*,a.ys_audit_status')->join('__BAOXIAO_AUDIT__ as a on a.bx_id=b.id','left')->where($where)->order($this->orders('b.id'))->limit($page->firstRow . ',' . $page->listRows)->select();

        foreach ($lists as $k=>$v){
            if ($v['audit_status'] == 0) $lists[$k]['zhuangtai'] = "<span class='yellow'>审核中</span>";
            if ($v['audit_status'] == 1) $lists[$k]['zhuangtai'] = "<span class='green'>审核通过</span>";
            if ($v['audit_status'] == 2) $lists[$k]['zhuangtai'] = "<span class='red'>审核未通过</span>";
        }
        $this->lists    = $lists;
        $this->pin      = $pin;
        $this->jk_type  = C('JIEKUAN_TYPE');
        $this->display();
    }

    // @@@NODE-3###audit_baoxiao###审批报销单(包括证明验收人审核)###
    public function audit_baoxiao(){
        $id                 = I('id');
        $audit_usertype     = I('audit_usertype');
        $baoxiao            = M('baoxiao')->where(array('id'=>$id))->find();
        $field              = 'b.*,c.title';
        $bx_lists           = M()->table('__BAOXIAO_DETAIL__ as b')->join('__OP_COSTACC__ as c on c.id=b.costacc_id','left')->where(array('b.bx_id'=>$id))->field($field)->select();
        foreach ($bx_lists as $k=>$v){
            $where                  = array();
            $where['costacc_id']    = $v['costacc_id'];
            $jkd_ids                = M('jiekuan_detail')->where($where)->getField('jkd_id',true);
            $bx_lists[$k]['jkd_id'] = implode(',',array_unique($jkd_ids));
        }

        $audit_userinfo     = M('baoxiao_audit')->where(array('bx_id'=>$id))->find();
        if (!$audit_userinfo){ $this->error('获取信息失败'); };

        $this->baoxiao      = $baoxiao;
        $this->bx_lists     = $bx_lists;
        $this->audit_userinfo= $audit_userinfo;
        $this->audit_usertype= $audit_usertype;
        $this->company      = C('COMPANY');

        $this->display();
    }

    // @@@NODE-3###baoxiaodan_info###报销单详情###
    public function baoxiaodan_info(){
        $id             = I('id');
        $field          = "b.*,a.bx_id,a.zm_audit_userid,a.zm_audit_username,a.zm_audit_file,a.zm_audit_status,a.zm_audit_time,a.zm_remark,a.manager_userid,a.manager_username,a.manager_audit_file,a.manager_audit_status,a.manager_audit_time,a.manager_remark,a.ys_audit_userid,a.ys_audit_username,a.ys_audit_file,a.ys_audit_status,a.ys_audit_time,a.ys_remark,a.cw_audit_userid,a.cw_audit_username,a.cw_audit_file,a.cw_audit_status,a.cw_audit_time,a.cw_remark";
        $baoxiao        = M()->table('__BAOXIAO__ as b')->field($field)->join('__BAOXIAO_AUDIT__ as a on a.bx_id=b.id','left')->where(array('b.id'=>$id))->find();
        $bx_lists       = M()->table('__BAOXIAO_DETAIL__ as b')->join('__OP_COSTACC__ as c on c.id=b.costacc_id','left')->where(array('b.bx_id'=>$id))->select();
        foreach ($bx_lists as $k=>$v){
            $where                  = array();
            $where['costacc_id']    = $v['costacc_id'];
            $jkd_ids                = M('jiekuan_detail')->where($where)->getField('jkd_id',true);
            $bx_lists[$k]['jkd_id'] = implode(',',array_unique($jkd_ids));
        }

        $this->baoxiao  = $baoxiao;
        $this->bx_lists = $bx_lists;
        $this->bx_type  = C('JIEKUAN_TYPE');
        $audit_userinfo = M('baoxiao_audit')->where(array('bx_id'=>$id))->find();
        $this->audit_userinfo= $audit_userinfo;
        $this->record   = D('Finance')->get_record($baoxiao['bxd_id']);
        $this->company  = C('COMPANY');

        //审核人信息
        if ($baoxiao['zm_audit_userid']==cookie('userid')){
            $this->audit_usertype = 1;  //证明验收人
        }elseif ($baoxiao['ys_audit_userid']==cookie('userid')){
            $this->audit_usertype = 2;  //预算审批人(或乔总)
        }elseif ($baoxiao['cw_audit_userid']==cookie('userid')){
            $this->audit_usertype = 3;
        }
        $this->display();
    }

    //@@@NODE-3###nopjk###填写非团支出借款单###
    public function nopjk(){

        $departments        = M('salary_department')->select();
        $this->departments  = $departments;
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->company      = C('COMPANY');
        $this->display();
    }

    // @@@NODE-3###audit_jiekuan###审批非团借款###
    public function audit_nopjk(){
        $id                 = I('id');
        $audit_usertype     = I('audit_usertype');
        $jiekuan            = M('jiekuan')->where(array('id'=>$id))->find();
        $audit_userinfo     = M('jiekuan_audit')->where(array('jk_id'=>$id))->find();
        if (!$audit_userinfo){ $this->error('获取信息失败'); };

        $this->jiekuan      = $jiekuan;
        $this->audit_userinfo= $audit_userinfo;
        $this->audit_usertype= $audit_usertype;
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->company      = C('COMPANY');

        $this->display();
    }

    // @@@NODE-3###nopjk_info###非团借款单详情###
    public function nopjk_info(){
        $id             = I('jkid');
        $field          = 'j.*,a.jk_id,a.manager_userid,a.manager_username,a.manager_audit_file,a.manager_audit_status,a.manager_audit_time,a.manager_remark,a.ys_audit_userid,a.ys_audit_username,a.ys_audit_file,a.ys_audit_status,a.ys_audit_time,a.ys_remark,a.cw_audit_userid,a.cw_audit_username,a.cw_audit_file,a.cw_audit_status,a.cw_audit_time,a.cw_remark';
        $jiekuan        = M()->table('__JIEKUAN__ as j')->field($field)->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where(array('j.id'=>$id))->find();
        $this->jiekuan  = $jiekuan;
        $this->jk_type  = C('JIEKUAN_TYPE');
        $audit_userinfo = M('jiekuan_audit')->where(array('jk_id'=>$id))->find();
        $this->audit_userinfo= $audit_userinfo;
        $this->record   = D('Finance')->get_record($jiekuan['jkd_id']);

        //审核人信息
        if ($jiekuan['cw_audit_userid']==cookie('userid') && $audit_userinfo['cw_audit_status'] == 0) $this->audit_usertype = 3;    //财务
        if ($jiekuan['ys_audit_userid']==cookie('userid') && $audit_userinfo['ys_audit_status'] == 0) $this->audit_usertype = 2;    //部门分管领导
        if ($jiekuan['manager_userid']==cookie('userid') && $audit_userinfo['manager_audit_status'] == 0) $this->audit_usertype = 1; //部门主管

        $this->company  = C('COMPANY');
        $this->display();
    }

    //@@@NODE-3###loan_nopjk###非团借款报销(列表)###
    public function loan_nopjk(){
        $project        = I('title');
        $group_id       = I('oid');
        $jkd_id         = I('jid');
        $jk_user        = I('ou');

        $where          = array();
        $all_jkd        = array('Finance/all_jkd'); //查看所有借款单权限
        $where['jkd_type']  = 2;
        if ($jkd_id)    $where['j.jkd_id']  = array('like',$jkd_id);
        if ($jk_user)   $where['j.jk_user'] = array('like',$jk_user);
        $auth           = explode(',',Rolerelation(cookie('roleid')));
        if (rolemenu($all_jkd)){

        }else{
            $where['jk_user_id']    = array('in',$auth);
        }

        $lists          = M()->table('__JIEKUAN__ as j')->field('j.*,o.project')->join('__OP__ as o on o.op_id=j.op_id','left')->where($where)->order($this->orders('j.id'))->select();

        foreach ($lists as $k=>$v){
            if ($v['audit_status'] == 0) $lists[$k]['zhuangtai'] = "<span class='yellow'>审核中</span>";
            if ($v['audit_status'] == 1) $lists[$k]['zhuangtai'] = "<span class='green'>审核通过</span>";
            if ($v['audit_status'] == 2) $lists[$k]['zhuangtai'] = "<span class='red'>审核未通过</span>";
        }
        $this->lists    = $lists;
        $this->jk_type  = C('JIEKUAN_TYPE');

        $this->display();
    }

    //@@@NODE-3###loan_jk###填写非团支出报销单###
    public function loan_jk(){
        $db                 = M('jiekuan');
        $jkid               = I('jkid');
        $list               = $db->where(array('id'=>$jkid))->find();
        $departments        = M('salary_department')->field('id,department')->select();
        $this->departments  = $departments;
        $this->list         = $list;
        $this->userkey      = get_userkey();
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->company      = C('COMPANY');
        $this->display();
    }

    //@@@NODE-3###loan###填写直接报销页###
    public function loan(){

        $departments        = M('salary_department')->field('id,department')->select();
        $this->departments  = $departments;
        $this->jk_type      = C('JIEKUAN_TYPE');
        $this->userkey      = get_userkey();
        $this->company      = C('COMPANY');
        $this->display();
    }

    //@@@NODE-3###nopbxd_info###报销单详情(审核非团支出报销单)###
    public function nopbxd_info(){

        $id                 = I('id');
        $audit_usertype     = I('audit_usertype');
        $baoxiao            = M('baoxiao')->where(array('id'=>$id))->find();

        $this->baoxiao  = $baoxiao;
        $this->bx_type  = C('JIEKUAN_TYPE');
        $audit_userinfo = M('baoxiao_audit')->where(array('bx_id'=>$id))->find();
        $this->audit_userinfo= $audit_userinfo;
        $this->record   = D('Finance')->get_record($baoxiao['bxd_id']);
        $this->share_lists = M('baoxiao_share')->where(array('bx_id'=>$id))->select();

        //审核人信息
        if ($audit_userinfo['zm_audit_status'] == 0 && $baoxiao['audit_status'] == 0){
            $auditUserType = 1;  //证明验收人
        }elseif ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 0 && $baoxiao['audit_status'] == 0){
            $auditUserType = 2;  //部门主管
        }elseif ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 0 && $baoxiao['audit_status'] == 0){
            $auditUserType = 3;  //预算审批人
        }elseif ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 1 && $baoxiao['audit_status'] == 0){
            $auditUserType = 4;
        }
        $this->audit_usertype   = $audit_usertype?$audit_usertype:$auditUserType;
        $this->bxdkind          = M('bxd_kind')->where(array('pid'=>0))->getField('id,name',true);
        $this->company          = C('COMPANY');
        $this->display();
    }

    //@@@NODE-3###del_bxd###删除报销单###
    public function del_bxd(){
        $id         = I('id');
        if ($id){
            M('baoxiao')->where(array('id'=>$id))->delete();
            M('baoxiao_audit')->where(array('bx_id'=>$id))->delete();
            M('baoxiao_detail')->where(array('bx_id'=>$id))->delete();
            $this->success('删除数据成功');
        }else{
            $this->error('删除数据失败');
        }
    }

    //选择报销金额分摊部门
    public function select_department(){
        $departments           = C('department1');
        unset($departments[0]); //删除第一项(公司)
        $this->departments      = $departments;
        $this->display();
    }


    //财务费用预算
    public function budget_loan(){
        $opid = I('opid');
        if(!$opid) $this->error('项目不存在');

        $where      = array();
        $where['o.op_id'] = $opid;
        $field      = "o.*,c.num_adult,c.num_children";
        $op         = M()->table('__OP__ as o')->field($field)->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->where($where)->find();
        $costacc    = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();
        foreach ($costacc as $k=>$v){
            $field  = array();
            $field[]= 'sjk,jkd_id';
            $list   = M('jiekuan_detail')->field($field)->where(array('costacc_id'=>$v['id'],'audit_status'=>1))->select();
            $jiekuan= array_sum(array_column($list,'sjk'));                     //借款金额
            $arr_jkdid= array_unique(array_column($list,'jkd_id'));             //借款单号
            $jkd_ids= implode(',',$arr_jkdid);
            $costacc[$k]['jiekuan'] = $jiekuan?$jiekuan:'0.00';
            $costacc[$k]['jkd_ids'] = $jkd_ids?$jkd_ids:'';
            $costacc[$k]['arr_jkdid'] = $arr_jkdid?$arr_jkdid:'';

            $where  = array();
            $where['j.jkd_id']  = $arr_jkdid[0];
            $field  = 'j.type,j.payee,a.cw_audit_time';
            $loan   = M()->table('__JIEKUAN__ as j')->field($field)->join('__JIEKUAN_AUDIT__ as a on a.jk_id=j.id','left')->where($where)->find();
            $costacc[$k]['jktype']          = $loan['type'];
            $costacc[$k]['payee']           = $loan['payee'];
            $costacc[$k]['cw_audit_time']   = $loan['cw_audit_time'];
        }

        $budget         = M('op_budget')->where(array('op_id'=>$opid))->find();
        $budget['xz']   = explode(',',$budget['xinzhi']);

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

        //$this->kind           = C('COST_TYPE');
        $this->kind           = M('supplierkind')->getField('id,name',true);
        $this->op             = $op;
        $this->budget         = $budget;
        $this->kinds          =  M('project_kind')->getField('id,name', true);
        $this->jiekuan_type   = C('JIEKUAN_TYPE');
        $this->costacc        = $costacc;
        $this->display('budget_loan');
    }

    //修改借款单
    public function edit_jiekuandan(){
        $jkid                   = I('jkid');
        if (!$jkid) { $this->error("获取信息失败"); }
        $departments            = M('salary_department')->select();
        $jiekuan_info           = M('jiekuan')->where(array('id'=>$jkid))->find();

        $this->jiekuandan       = $jiekuan_info;
        $this->departments      = $departments;
        $this->jk_type          = C('JIEKUAN_TYPE');
        $this->jkid             = $jkid;
        $this->company          = C('COMPANY');

        $this->display();
    }

    //确认打印信息
    public function sure_print(){
        $id                     = I('jkid');
        $db                     = M('jiekuan');
        $msg                    = array();
        if (!$id){
            $msg['msg']         = '获取信息失败';
            $msg['time']        = 3;
            $this->ajaxReturn($msg);
            die;
        }
        $jkd_id                 = $db->where(array('id'=>$id))->getField('jkd_id');
        $data                   = array();
        $data['is_print']       = 1;
        $res                    = $db->where(array('id'=>$id))->save($data);
        if ($res){
            $record = array();
            $record['bill_id']      = $jkd_id;
            $record['type']         = 1;
            $record['explain']      = '确认已打印借款单';
            jkbx_record($record);

            $msg['msg']         = '保存成功';
            $msg['time']        = 1;
            $this->ajaxReturn($msg);
        }else{
            $msg['msg']         = '保存信息失败';
            $msg['time']        = 3;
            $this->ajaxReturn($msg);
        }
    }

    //回款详情
    public function public_money_back_detail(){
        $pin                                = I('pin');
        $uid                                = I('uid');
        $start_time                         = I('start_time');
        $end_time                           = I('end_time');
        $title                              = trim(I('title'));
        $group_id                           = trim(I('oid'));
        $opid                               = trim(I('opid'));
        $dj_opids                           = get_djopid();
        if (!$uid) $this->error('获取数据错误');
        $where                              = array();
        $where['c.payee']                   = $uid;
        $where['c.return_time']	            = array('lt',$end_time);
        $where['c.op_id']                   = array('not in',$dj_opids);
        if ($title) $where['o.project']     = array('like','%'.$title.'%');
        if ($group_id) $where['o.group_id'] = $group_id;
        if ($opid)  $where['c.op_id']       = $opid;
        $lists                              = M()->table('__CONTRACT_PAY__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->join('__OP_TEAM_CONFIRM__ as t on t.op_id=c.op_id','left')->field('c.*,o.group_id,o.project,t.dep_time,t.ret_time')->where($where)->order($this->orders('c.id'))->select();

        $data                               = check_list($lists,$start_time,$end_time);
        if ($pin==0){
            $lists                          = $data['this_month_list'];
        }elseif ($pin==1){
            $lists                          = $data['history_list'];
        }
        $this->uid                          = $uid;
        $this->start_time                   = $start_time;
        $this->end_time                     = $end_time;
        $this->data                         = $data;
        $this->lists                        = $lists;
        $this->pin                          = $pin?$pin:0;
        $this->display('money_back_detail');
    }

    //@@@NODE-3###payment###月度回款管理###
    public function payment(){
        $year		                        = I('year',date('Y'));
        $month	                            = I('month',date('m'));
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                              = $year.$month;
        $yw_departs                         = C('YW_DEPARTS');  //业务部门id
        $where                              = array();
        $where['id']                        = array('in',$yw_departs);
        $departments                        = M('salary_department')->field('id,department')->where($where)->select();
        $cycle_times                        = get_cycle($times);
        $lists                              = get_department_money_back_list($departments,$cycle_times['begintime'],$cycle_times['endtime']);
        $sum                                = get_sum($lists);

        $this->sum                          = $sum;
        $this->lists                        = $lists;
        $this->departments                  = $departments;
        $this->year		                    = I('year',date('Y'));
        $this->month	                    = I('month',date('m'));
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        $this->display();
    }

    //@@@NODE-3###payment###季度回款管理###
    public function payment_quarter(){
        $year		                        = I('year',date('Y'));
        $month	                            = I('month',date('m'));
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $quarter                            = I('quarter')?I('quarter'):get_quarter($month);
        $cycle_times                        = set_quarter($year,$quarter);

        $yw_departs                         = C('YW_DEPARTS');  //业务部门id
        $where                              = array();
        $where['id']                        = array('in',$yw_departs);
        $departments                        = M('salary_department')->field('id,department')->where($where)->select();
        $lists                              = get_department_money_back_list($departments,$cycle_times['begin_time'],$cycle_times['end_time']);
        $sum                                = get_sum($lists);

        $this->sum                          = $sum;
        $this->lists                        = $lists;
        $this->departments                  = $departments;
        $this->year		                    = I('year',date('Y'));
        $this->month	                    = I('month',date('m'));
        $this->quarter                      = $quarter;
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        $this->display();
    }



    public function public_payment_detail(){
        $year		                        = I('year',date('Y'));
        $month	                            = I('month',date('m'));
        $pin                                = I('pin',0);
        $name                               = trim(I('name'));
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                              = $year.$month;
        $departmnet_id                      = I('department');
        $where                              = array();
        $where['a.departmentid']            = $departmnet_id;
        $where['a.status']                  = array('neq',2); //未删除
        $where['p.code']                    = array('like','S%');
        if ($name) $where['a.nickname']     = array('like','%'.$name.'%');

        $cycle_time                         = get_cycle($year.$month);
        $lists                              = M()->table('__ACCOUNT__ as a')->join('__POSITION__ as p on p.id=a.position_id','left')->field('a.*')->where($where)->select();
        foreach ($lists as $k=>$v){
            //当月回款/欠款信息
            $data                           = get_money_back_info($v,$cycle_time['begintime'],$cycle_time['endtime']);
            $lists[$k]['this_month']        = $data['this_month']?$data['this_month']:'0.00'; //计划回款时间或实际回款时间在当月的团
            $lists[$k]['history']           = $data['history']?$data['history']:'0.00'; //历史欠付
            $lists[$k]['this_month_return'] = $data['this_month_return']?$data['this_month_return']:'0.00'; //当月回款金额
            $lists[$k]['money_back_average']= $data['money_back_average']; //回款及时率
        }
        $sum                                = get_sum($lists);

        $this->sum                          = $sum;
        $this->cycle_time                   = $cycle_time;
        $this->year		                    = I('year',date('Y'));
        $this->month	                    = I('month',date('m'));
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        $this->pin                          = $pin;
        $this->lists                        = $lists;
        $this->department                   = $departmnet_id;
        $this->displaY('payment_detail');
    }


//保存修改回款总金额(预算审核通过后)
    public function save_upd_money_back(){
        $mod                                = D('Finance');
        $contract_pay_db                    = M('contract_pay');
        $op_budget_db                       = M('op_budget');
        $opid                               = I('opid');
        $should_back_money                  = I('should_back_money');
        if (!$opid || intval($should_back_money)==0) $this->error('数据错误');
        $pays                               = $mod->get_money_back_lists($opid); //回款计划
        $money_back_num                     = count($pays); //回款次数
        $num                                = 0;
        $sum                                = 0;
        $sum_paied                          = $contract_pay_db->where(array('op_id'=>$opid,'status'=>array('in',array(1,2))))->sum('pay_amount');
        $sum_paied                          = $sum_paied?$sum_paied:0; //已回款金额
        if (is_array($pays)){
            foreach ($pays as $k=>$v){
                $info                       = array();
                if ($k<($money_back_num-1)){ //前几次回款重置百分比
                    $info['ratio']          = (round($v['amount']/$should_back_money,4)*100).'%';
                    $sum                    += $v['amount'];
                }else{ //最后一次回款
                    $info['amount']         = $should_back_money - $sum;
                    $info['ratio']          = (round($info['amount']/$should_back_money,4)*100).'%';
                    if ($sum_paied >= $should_back_money){ //已回款金额>=应回款金额
                        $info['status']     = 2; //已回款
                    }else{
                        $status             = in_array($v['status'],array(1,2))?1:0;
                        $info['status']     = $status; //未回款
                    }
                }
                $res                        = $contract_pay_db->where(array('id'=>$v['id']))->save($info);
                if ($res) $num++;
            }
        }else{
            $field                          = 'o.op_id,o.project,o.group_id,o.create_user,c.id as cid';
            $op                             = M()->table('__OP__ as o')->join('__CONTRACT__ as c on c.op_id=o.op_id','left')->where(array('o.op_id'=>$opid))->field($field)->find();
            $return_time                    = getAfterWorkDay(10);
            $info                           = array();
            $info['no']                     = 1;
            $info['pro_name']               = $op['project'];
            $info['op_id']                  = $opid;
            $info['cid']                    = $op['cid']?$op['cid']:0;
            $info['amount']                 = $should_back_money;
            $info['ratio']                  = '100%';
            $info['return_time']            = strtotime($return_time);
            $info['remark']                 = cookie('name').'填写';
            $info['status']                 = 0; //未回款
            $info['type']                   = 4; //其他
            $info['company']                = 2; //中心
            $info['userid']                 = session('userid');
            $info['payee']                  = $op['create_user'];
            $res                            = $contract_pay_db->add($info);
            if ($res) $num++;
        }
        if ($num != 0){
            $data                           = array();
            $data['should_back_money']      = $should_back_money;
            $op_budget_db->where(array('op_id'=>$opid))->save($data);
            $record = array();
            $record['op_id']   = $opid;
            $record['optype']  = 1;
            $record['explain'] = '修改回款计划总金额';
            op_record($record);
            $this->success('数据保存成功');
        }else{
            $this->error('数据保存失败');
        }
    }

    /**
     * 月度历史欠款
     */
    public function arrears_detail(){
        $year		                        = I('year',date('Y'));
        $month	                            = I('month',date('m')); //月度
        //$quarter                            = I('quarter'); //季度
        $pin                                = I('pin');  //1=>当月回款详情 2=>历史欠款详情
        $title                              = trim(I('title'));
        $group_id                           = trim(I('gid'));
        $opid                               = trim(I('opid'));
        $create_user                        = trim(I('ou')); //销售
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        /*if ($quarter){
            $times                          = set_quarter($year,$quarter);
            $start_time                     = $times['begin_time'];
            $end_time                       = $times['end_time'];
        }else{*/
            $yearmonth                      = $year.$month;
            $times                          = get_cycle($yearmonth);
            $start_time                     = $times['begintime'];
            $end_time                       = $times['endtime'];
        //}

        $where                              = array();
        $where['c.return_time']	            = array('lt',$end_time);
        if ($title) $where['o.project']     = array('like','%'.$title.'%');
        if ($group_id) $where['o.group_id'] = $group_id;
        if ($opid)  $where['c.op_id']       = $opid;
        if ($create_user) $where['create_user_name'] = $create_user;
        $lists                              = M()->table('__CONTRACT_PAY__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->join('__OP_TEAM_CONFIRM__ as t on t.op_id=c.op_id','left')->field('c.*,o.group_id,o.project,o.create_user_name,t.dep_time,t.ret_time')->where($where)->order($this->orders('c.id'))->select();
        $data                               = check_list($lists,$start_time,$end_time);

        if ($pin==1){ $this->lists          = $data['this_month_list'];
        }elseif ($pin==2){ $this->lists     = $data['history_list']; };

        $this->data                         = $data;
        $this->pin                          = $pin;
        $this->year		                    = $year;
        $this->month	                    = $month;
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        //$this->quarter                      = $quarter;
        $this->display();
    }

    /**
     * 季度历史欠款
     */
    public function quarter_arrears_detail(){
        $year		                        = I('year',date('Y'));
        $quarter                            = I('quarter',get_quarter(date('m'))); //季度
        $pin                                = I('pin');  //1=>当月回款详情 2=>历史欠款详情
        $title                              = trim(I('title'));
        $group_id                           = trim(I('gid'));
        $opid                               = trim(I('opid'));
        $create_user                        = trim(I('ou')); //销售
        $times                              = set_quarter($year,$quarter);
        $start_time                         = $times['begin_time'];
        $end_time                           = $times['end_time'];

        $where                              = array();
        $where['c.return_time']	            = array('lt',$end_time);
        if ($title) $where['o.project']     = array('like','%'.$title.'%');
        if ($group_id) $where['o.group_id'] = $group_id;
        if ($opid)  $where['c.op_id']       = $opid;
        if ($create_user) $where['create_user_name'] = $create_user;
        $lists                              = M()->table('__CONTRACT_PAY__ as c')->join('__OP__ as o on o.op_id = c.op_id','left')->join('__OP_TEAM_CONFIRM__ as t on t.op_id=c.op_id','left')->field('c.*,o.group_id,o.project,o.create_user_name,t.dep_time,t.ret_time')->where($where)->order($this->orders('c.id'))->select();
        $data                               = check_list($lists,$start_time,$end_time);

        if ($pin==1){ $this->lists          = $data['this_month_list'];
        }elseif ($pin==2){ $this->lists     = $data['history_list']; };

        $this->data                         = $data;
        $this->pin                          = $pin;
        $this->year		                    = $year;
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        $this->quarter                      = $quarter;
        $this->display();
    }

    //删除
    public function del_payment(){
        $id                                 = I('id');
        $db                                 = M('contract_pay');
        $list                               = M()->table('__CONTRACT_PAY__ as p')->join('__OP__ as o on o.op_id=p.op_id','left')->field('p.*,o.group_id')->where(array('p.id'=>$id))->find();
        $res                                = $db->where(array('id'=>$id))->delete();
        if ($res){
            $record = array();
            $record['op_id']   = $list['op_id'];
            $record['optype']  = 1;
            $record['explain'] = '删除项目回款信息；计划回款金额'.$list['amount'].'；回款金额'.$list['pay_amount'];
            op_record($record);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //项目报账
    public function reimbursement(){
        $this->title('项目报账');
        $title                              = I('title','');
        $opid                               = I('opid','');
        $group_id                           = I('group_id','');
        $sale                               = I('ou','');
        $jd                                 = I('jd','');
        $where                              = array();
        if ($title) $where['o.project']     = array('like','%'.$title.'%');
        if ($opid)  $where['o.op_id']       = $opid;
        if ($group_id) $where['o.group_id'] = array('like','%'.$group_id.'%');
        if ($sale)  $where['o.sale_user']   = array('like','%'.$sale.'%');
        if ($jd)    $where['l.req_uname']   = $jd;
        $where['l.req_type']                = 801;
        $where['s.audit_status']            = 1;
        $field                              = array();
        $field[]                            = 'o.op_id,o.group_id,o.project,o.sale_user,s.reimbursement_status,s.reimbursement_time,l.req_uid,l.req_uname,l.audit_time';

        //分页
        $pagecount                          = M()->table('__OP__ as o')->join('__OP_SETTLEMENT__ as s on s.op_id=o.op_id','left')->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')->where($where)->field($field)->count();
        $page			                    = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	                    = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                              = M()->table('__OP__ as o')
            ->join('__OP_SETTLEMENT__ as s on s.op_id=o.op_id','left')
            ->join('__AUDIT_LOG__ as l on l.req_id=s.id','left')
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order($this->orders('op_id'))
            ->field($field)
            ->select();
        $this->lists                        = $lists;
        $this->display();
    }

    //财务工作及时性
    public function timely(){
        $this->title('财务工作及时率');
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $times                      = get_cycle($yearMonth);
        $mod                        = D('Sale');
        //$data                       = $mod->get_timely_data($times['begintime'],$times['endtime']);
        //$sum_data                   = $mod->get_sum_timely($data);

        $this->sum                  = $sum_data;
        $this->lists                = $data;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;

        $this->display();
    }


    //财务及时率考核指标
    public function timely_list(){
        $this->title('及时率指标管理');
        $lists                      = get_timely(5);

        $this->lists                = $lists;
        $this->display();
    }

    //配置财务及时率考核指标
    public function timely_edit(){
        $db                         = M('quota');
        $id                         = I('id','');
        if ($id){
            $list                   = $db->find($id);
            $list['title']          = htmlspecialchars_decode($list['title']);
            $list['content']        = htmlspecialchars_decode($list['content']);
            $list['rules']          = htmlspecialchars_decode($list['rules']);
            $this->list             = $list;
        }

        $this->display();
    }

    //删除
    public function timely_del(){
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $res                        = timely_quota_del($id);
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
