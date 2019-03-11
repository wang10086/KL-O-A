<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;
ulib('Pinyin');
use Sys\Pinyin;

// @@@NODE-2###Op###计调操作###
class OpController extends BaseController {
    
    protected $_pagetitle_ = '计调操作';
    protected $_pagedesc_  = '';

    // @@@NODE-3###index###出团计划列表###
    public function index(){
        $this->title('出团计划列表');

		$db		= M('op');

		$title	= I('title');		//项目名称
		$opid	= I('id');			//项目编号
		$oid	= I('oid');			//项目团号
		$dest	= I('dest');			//目的地
		$ou		= I('ou');			//立项人
		$status	= I('status','-1');	//成团状态
		$as		= I('as','-1');		//审核状态
		$kind	= I('kind');			//类型
		$su		= I('su');			//销售
		$pin	= I('pin');
		$cus	= I('cus');			//客户单位
		$jd		= I('jd');			//计调

		$where = array();

		if($title)			$where['o.project']			= array('like','%'.$title.'%');
		if($oid)			$where['o.group_id']		= array('like','%'.$oid.'%');
		if($opid)			$where['o.op_id']			= $opid;
		if($dest)			$where['o.destination']		= $dest;
		if($ou)				$where['o.create_user_name']= $ou;
		if($status!='-1')	$where['o.status']			= $status;
		if($as!='-1')		$where['o.audit_status']	= $as;
		if($kind)			$where['o.kind']			= $kind;
		if($su)				$where['o.sale_user']		= array('like','%'.$su.'%');
		if($cus)			$where['o.customer']	    = $cus;
		if($pin==1)			$where['o.create_user']		= cookie('userid');
        if($jd)				$where['a.nickname']		= array('like','%'.$jd.'%');
        $where['o.type']                                = 1;
        if($pin==2){
                            $where['o.create_user']		= cookie('userid');
                            $where['o.type']            = '0';
        }

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
		$this->pin     = $pin;

		$this->display('index');
    }
	
    
    // @@@NODE-3###plans###制定出团计划###
    public function plans(){
		$PinYin = new Pinyin();
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){

			$db             = M('op');
			$op_cost_db     = M('op_cost');
			$op_guide_db    = M('op_guide');
			$op_member_db   = M('op_member');
			$op_supplier_db = M('op_supplier');

			$info       = I('info');
            $guide      = I('guide');
            $member     = I('member');
            $cost       = I('cost');
            $supplier   = I('supplier');
            $wuzi       = I('wuzi');
            $province   = I('province');
            $addr       = I('addr');
            $info['op_create_user'] = cookie('rolename');
            if ($info['in_dijie'] == 1) {
                $info['project'] = '【发起团】'.$info['project'];
            }

            $exe_user_id    = I('exe_user_id');
            //$exe_user_name  = I('exe_user_name');
            //$exe_role_ids = I('exe');

            if(!$info['customer']){
				$this->error('客户单位不能为空' . $db->getError());	
				die();	
			}

			if($info){
				
				$opid = opid();

				$info['create_time'] = time();
                $info['op_id']       = $opid;
                $info['speed']       = 1;
                $info['op_create_date'] = date('Y-m-d',time());
                $info['destination'] = $province.'--'.$addr;
				$info['create_user'] = cookie('userid');
				$info['create_user_name'] = cookie('name');
                $info['audit_status'] = 1; //项目不用审核,默认通过
				$addok  = $db->add($info);
				//$this->request_audit(P::REQ_TYPE_PROJECT_NEW, $addok);

				if($addok){
                    $data = array();
                    $data['hesuan'] = cookie('userid');
                    $auth = M('op_auth')->where(array('op_id'=>$opid))->find();

                    if($auth){
                        M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
                    }else{
                        $data['op_id'] = $opid;
                        M('op_auth')->add($data);
                    }

					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 1;
					$record['explain'] = '项目立项';
					op_record($record);
					
					/*
					//收录客户信息
					$company_name = iconv("utf-8","gb2312",trim($info['customer']));
					$data = array();
					$data['company_name'] = $info['customer'];
					$data['cm_id'] = $info['create_user'];
					$data['cm_name'] = $info['create_user_name'];
					$data['cm_time'] = $info['create_time'];
					$data['create_time'] = $info['create_time'];
					$data['pinyin'] = strtolower($PinYin->getFirstPY($company_name));	
					
					if(!M('customer_gec')->where(array('company_name'=>$info['customer'],'cm_id'=>$info['create_user']))->find()){
						M('customer_gec')->add($data);
					}
					*/

					//创建工单
                    $id                 = $info['kind'];
                    $pro_info           = M('project_kind')->where(array('id'=>$id) )->find();
                    $pid                = $pro_info['pid'];
                    $pro_name           = $pro_info['name'];
                    $worder             = array();
                    $worder['op_id']    = M("op")->where(array('id'=>$addok))->getField('op_id');
                    $worder['worder_title']     = $info['project'];
                    $worder['worder_content']   = $info['context'];
                    $worder['worder_type']      = 100;
                    $worder['status']           = 0;
                    $worder['ini_user_id']      = cookie('userid');
                    $worder['ini_user_name']    = cookie('name');
                    $worder['ini_dept_id']      = cookie('roleid');
                    $worder['ini_dept_name']    = cookie('rolename');
                    $worder['create_time']      = NOW_TIME;
                    $u_time                     = 5;    //默认5个工作日
                    //计划完成时间 $u_time为工作日
                    $worder['plan_complete_time']= strtotime(getAfterWorkDay($u_time));

                    if($exe_user_id){
                        foreach ($exe_user_id as $k=>$v){
                            if ($v==12){
                                $worder['kpi_type'] = 1;    //公司研发
                            }elseif ($v==26){
                                $worder['kpi_type'] = 2;    //公司资源
                            } elseif ($v==31){
                                $worder['kpi_type'] = 3;    //京区校内研发
                            }elseif ($v==174){
                                $worder['kpi_type'] = 4;    //京区校内资源
                            }
                            $exe_user_info      = M('account')->field('nickname,roleid')->where(array('id'=>$v))->find();
                            $exe_user_id        = $v;
                            $exe_user_name      = $exe_user_info['nickname'];
                            $exe_dept_id        = $exe_user_info['roleid'];
                            $exe_dept_name      = M('role')->where(array('id'=>$exe_dept_id))->getField('role_name');
                            $worder['exe_dept_id']      = $exe_dept_id;
                            $worder['exe_dept_name']    = $exe_dept_name;
                            $worder['exe_user_id']      = $exe_user_id;
                            $worder['exe_user_name']    = $exe_user_name;
                            $res = M('worder')->add($worder);
                            if($res){
                                //保存操作记录
                                $record = array();
                                $record['worder_id'] = $res;
                                $record['type']     = 0;
                                $record['explain']  = '立项/创建工单';
                                worder_record($record);
                                //发送系统消息
                                $uid     = cookie('userid');
                                $title   = '您有来自['.$worder['ini_dept_name'].'--'.$worder['ini_user_name'].']的工单待执行!';
                                $content = '该工单为项目工单，现已立项通过，前期需要研发、资源等相关部门的协助。项目名称：'.$worder['worder_title'].'；备注信息：'.$worder['worder_content'];
                                $url     = U('worder/worder_info',array('id'=>$res));
                                $user    = '['.$worder['exe_user_id'].']';
                                send_msg($uid,$title,$content,$url,$user,'');
                            }
                        }
                    }

					$this->success('保存成功！',U('Op/plans_follow',array('opid'=>$opid)));
				}else{
					$this->error('保存失败' . $db->getError());
				}
				
			}else{
				$this->error('保存失败' . $db->getError());
			}
			
		}else{
			
			//客户名称关键字
			$where = array();
			if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==28 || cookie('roleid')==11 || cookie('roleid')==30){
				$where['company_name'] = array('neq','');
			}else{
				$where['company_name'] = array('neq','');
				$where['cm_id'] = array('in',Rolerelation(cookie('roleid')));
			}
		
			$key =  M('customer_gec')->field('id,pinyin,company_name')->where($where)->group("company_name")->order('pinyin ASC')->select();
			foreach($key as $v){
				if(!$v['pinyin']){
					$company_name = iconv("utf-8","gb2312",trim($v['company_name']));
					$pinyin = strtolower($PinYin->getFirstPY($company_name));	
					M('customer_gec')->data(array('pinyin'=>$pinyin))->where(array('id'=>$v['id']))->save();
				}
			}
			//if($key) $this->keywords =  json_encode($key);
            //固定线路
            $linelist   = M('product_line')->field('id,title,pinyin')->where(array('type'=>2))->select();
            foreach ($linelist as $v){
                if(!$v['pinyin']){
                    $title = iconv("utf-8","gb2312",trim($v['title']));
                    $pinyin = strtolower($PinYin->getFirstPY($title));
                    M('product_line')->data(array('pinyin'=>$pinyin))->where(array('id'=>$v['id']))->save();
                }
            }
            $this->linelist    = json_encode($linelist);

            $this->userkey     = get_userkey();
            $this->provinces   = M('provinces')->getField('id,name',true);
			$this->geclist     = M('customer_gec')->field('id,pinyin,company_name')->where($where)->group("company_name")->order('pinyin ASC')->select();
			$this->kinds       = get_project_kinds();
			$this->userlist    =  M('account')->where('`id`>3')->getField('id,nickname', true);
			$this->rolelist    =  M('role')->where('`id`>10')->getField('id,role_name', true);
            $this->apply_to    = C('APPLY_TO');
            $this->dijie_names = C('DIJIE_NAME');
            $this->expert      = C('EXPERT');
			$this->title('出团计划');
			$this->display('plans');
		}
    }
    
	
	// @@@NODE-3###plans_info###出团计划###
    public function plans_info(){
		
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
		$guide      = M()->table('__OP_GUIDE__ as g')->field('g.*,c.cost,c.amount,c.total')->join('__OP_COST__ as c on c.relevant_id=g.guide_id','LEFT')->where(array('g.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>2))->order('g.id')->select();
		$supplier   = M()->table('__OP_SUPPLIER__ as s')->field('s.id as sid,s.op_id,s.supplier_id,s.supplier_name,s.city,s.kind,s.remark as sremark,c.*')->join('__OP_COST__ as c on c.relevant_id=s.supplier_id')->where(array('s.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>3))->order('sid')->select();
		$member     = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
		$costlist   = M('op_cost')->where(array('op_id'=>$opid))->order('cost_type')->select();
		$shouru     = $op['sale_cost']*$op['number'];
		$chengben   = M('op_cost')->where(array('op_id'=>$opid))->sum('total');
		$wuzi       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.material=c.remark')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		$pretium    = M('op_pretium')->where(array('op_id'=>$opid))->order('id')->select();
		$costacc    = M('op_costacc')->where(array('op_id'=>$opid))->order('id')->select();
		
		$days       = M('op_line_days')->where(array('op_id'=>$opid))->select();
		$opauth     = M('op_auth')->where(array('op_id'=>$opid))->find();
		$record     = M('op_record')->where(array('op_id'=>$opid))->order('id DESC')->select();
		
		
		
		$where = array();
		$where['req_type'] = P::REQ_TYPE_PROJECT_NEW;
		$where['req_id']   = $op['id'];
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
		
		if($op['line_id']){
			$linetext   = M('product_line')->find($op['line_id']);
			$this->linetext = '<h4>行程来源：<a href="'.U('Product/view_line',array('id'=>$linetext['id'])).'" target="" id="travelcom">'.$linetext['title'].'</a><input type="hidden" name="line_id" value="'.$linetext['id'].'" ></h4>';	
		}else{
			$this->linetext = '';		
		}
		
		$this->kinds          =  M('project_kind')->getField('id,name', true);
		$this->user           =  M('account')->where('`id`>3')->getField('id,nickname', true);
		$this->op             = $op;
		$this->pro            = $pro;
		$this->guide          = $guide;
		$this->supplier       = $supplier;
		$this->member         = $member;
		$this->pretium        = $pretium;
		$this->costacc        = $costacc;
		$this->costlist       = $costlist;
		$this->chengben       = $chengben;
		$this->shouru         = $shouru;
		$this->wuzi           = $wuzi;
		$this->days           = $days;
		$this->opauth         = $opauth;
		$this->record         = $record;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->display('plans_info');
	}


	
	// @@@NODE-3###plans_follow###项目跟进###
    public function plans_follow(){

        header('Content-Type:text/html;charset=utf-8');
		$opid = I('opid');
		$id   = I('id');
		if($id){
            $where      = array();
            $where['id']= $id;
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
		$guide      = M()->table('__GUIDE_PAY__ as p')->field('g.*,p.guide_id,p.op_id,p.num,p.price,p.total,p.really_cost,p.remark,k.name as kind')->join('left join __GUIDE__ as g on p.guide_id=g.id')->join('left join __GUIDEKIND__ as k on g.kind=k.id')->where(array('p.op_id'=>$opid))->select();
        $guide_old  = M('op_cost')->field('remark as name, cost as price, amount as num,total as really_cost')->where(array('op_id'=>$opid,'cost_type'=>2))->select();
        $supplier   = M()->table('__OP_SUPPLIER__ as s')->field('s.id as sid,s.op_id,s.supplier_id,s.supplier_name,s.city,s.kind,s.remark as sremark,c.*')->join('__OP_COST__ as c on c.link_id=s.id')->where(array('s.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>3))->order('sid')->select();
		$member     = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
		$costlist   = M('op_cost')->where(array('op_id'=>$opid))->order('cost_type')->select();
		$shouru     = $op['sale_cost']*$op['number'];
		$chengben   = M('op_cost')->where(array('op_id'=>$opid))->sum('total');
		$wuzi       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		$pretium    = M('op_pretium')->where(array('op_id'=>$opid))->order('id')->select();
		$costacc    = M('op_costacc')->where(array('op_id'=>$opid))->order('id')->select();
		$yusuan     = M('op_costacc')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();

		$opauth     = M('op_auth')->where(array('op_id'=>$opid))->find();
		$record     = M('op_record')->where(array('op_id'=>$opid))->order('id DESC')->select();
		$budget     = M('op_budget')->where(array('op_id'=>$opid))->find();
		$settlement = M('op_settlement')->where(array('op_id'=>$opid))->find();

        //根据line_id判断是普通线路还是固定线路
        $line_id    = $op['line_id'];
        $line_type  = M('product_line')->where(array('id'=>$line_id))->getField('type');
        if ($line_type == 2){
            //固定线路
            $days = M('product_line_days')->where(array('line_id'=>$line_id))->select();
            $days['op_id'] = $opid;
        } else{
            //普通行程
            $days       = M('op_line_days')->where(array('op_id'=>$opid))->select();
        }

        $where = array();
		$where['req_type'] = P::REQ_TYPE_PROJECT_NEW;
		$where['req_id']   = $op['id'];
		$audit = M('audit_log')->where($where)->find();
		if($audit['dst_status']==0){
            $show = '系统默认通过';
            $show_user = '系统默认';
            $show_time = date('Y-m-d H:i:s',$op['create_time']);
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
		
		if($op['line_id']){
			$linetext   = M('product_line')->find($op['line_id']);
			$this->linetext = '<h4>已选方案：<a href="'.U('Product/view_line',array('id'=>$linetext['id'])).'" target="_blank" id="travelcom">'.$linetext['title'].'</a><input type="hidden" name="line_id" value="'.$linetext['id'].'" ></h4>';	
		}else{
			$this->linetext = '';		
		}
		
		//自动生成团号
		$roles = M('role')->where(array('role_name'=>$op['op_create_user']))->find();
		$tuanhao = $roles['name'].str_replace("-", "",$op['departure']);
		//验证团号是否可用
		$istuanhao = M('op')->where(array('group_id'=>array('like','%'.$tuanhao.'%')))->count();		
		if($istuanhao){
			$this->tuanhao    = $tuanhao.'-'.($istuanhao);
		}else{
			$this->tuanhao    = $tuanhao;
		}

		/*//项目需求单
        $service_type         = explode(',',$resource['service_type']);
        $act_need             = explode(',',$resource['act_need']);
        $les_field            = explode(',',$resource['les_field']);
        $act_field            = explode(',',$resource['act_field']);
        if ($resource['cou_time']) $resource['cou_time'] = date('Y-m-d',$resource['cou_time']);


        $job_name       = C('JOB_NAME');
        $job_names      = array();
        foreach($job_name as $key=>$value){
            $job_names[$key]['job_name'] = $value;
            foreach ($res_money as $k=>$v){
                if ($value == $v['job_name']){
                    $job_names[$key]['job_money']= $v['job_money'];
                }
            }
            $job_names[$key]['job_money']= $job_names[$key]['job_money']?$job_names[$key]['job_money']:null;
        }*/

        //项目类型
        //线路1 , 课程 2 , 其他 3
        $kind       = $op['kind'];
        $line       = M('project_kind')->where("id ='1' or pid ='1'")->getField('id',true);
        $lessions   = M('project_kind')->where("id ='2' or pid ='2'")->getField('id',true);
        $cgly       = M('project_kind')->where("name like '%常规旅游%'")->getField('id',true); //从'其他'栏目中提取 '常规旅游'放入线路中
        $lines      = array_merge($line,$cgly);
        $fixed_lineids  = M('product_line')->where(array('type'=>2))->getField('id',true);    //固定线路
        if (in_array($line_id,$fixed_lineids)){
            $this->isFixedLine = 1;
        }
        $guide_pk_id= M('guide_pricekind')->field('id,name')->select();
        $sum_cost = 0;
        foreach ($guide as $k=>$v){
            $sum_cost += $v['really_cost'];
            foreach ($guide_pk_id as $val){
                if ($v['gpk_id'] == $val['id']){
                    $guide[$k]['gpk_name'] = $val['name'];
                }
            }
        }
        $sum_cost_old = 0;
        foreach ($guide_old as $k=>$v){
            $sum_cost_old += $v['really_cost'];
            foreach ($guide_pk_id as $val){
                if ($v['gpk_id'] == $val['id']){
                    $guide[$k]['gpk_name'] = $val['name'];
                }
            }
        }
        //获取职能类型
        $priceKind = M()->table('__GUIDE_PRICEKIND__ as gpk')->field('gpk.id,gpk.name')->join('left join __OP__ as op on gpk.pk_id = op.kind')->where(array("op.op_id"=>$opid))->select();
        $this->price_kind     = $priceKind;
        $this->opid           = $opid;
		$this->kinds          = M('project_kind')->getField('id,name', true);
		$this->user           = M('account')->where('`id`>3')->getField('id,nickname', true);
		$this->rolelist       = M('role')->where('`id`>10')->getField('id,role_name', true);
		$this->op             = $op;
		$this->pro            = $pro;
		$this->budget         = $budget;
        $this->sum_cost       = $sum_cost?$sum_cost:$sum_cost_old;
		$this->settlement     = $settlement;
		$this->supplier       = $supplier;
		$this->member         = $member;
		$this->pretium        = $pretium;
		$this->costacc        = $costacc;
		$this->costlist       = $costlist;
		$this->chengben       = $chengben;
		$this->shouru         = $shouru;
		$this->wuzi           = $wuzi;
		$this->days           = $days;
		$this->opauth         = $opauth;
		$this->record         = $record;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
        $this->product_type   = C('PRODUCT_TYPE');
        $this->product_from   = C('PRODUCT_FROM');
        $this->reckon_mode    = C('RECKON_MODE');
		$this->ages           = C('AGE_LIST');
        $this->guide          = $guide?$guide:$guide_old;
        $this->dijie_names    = C('DIJIE_NAME');
        $this->change         = M('op')->where(array('dijie_opid'=>$opid))->find();
        $this->expert         = C('expert');

         $product_need         = M()->table('__OP_COSTACC__ as c')->field('c.*,p.from,p.subject_field,p.type as ptype,p.age,p.reckon_mode')->join('left join __PRODUCT__ as p on c.product_id=p.id')->where(array('c.op_id'=>$opid,'c.type'=>5,'c.status'=>0))->select();
         foreach ($product_need as $k=>$v){
             $ages             = explode(',',$v['age']);
             $age_list         = array();
             foreach ($this->ages as $key=>$value){
                 if (in_array($key,$ages)){
                     $age_list[]= $value;
                 }
             }
             $product_need[$k]['age_list'] = implode(',',$age_list);
         }
        $this->product_need  = $product_need;
        $this->yusuan         = $yusuan;
        $this->xuhao          = 1;
        $this->huikuan_status = M('contract_pay')->where(array('op_id'=>$opid))->getField('status');
        $this->guide_kind     = M('guidekind')->getField('id,name',true);
        $this->guide_confirm  = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('c.id as cid,c.*,p.id as pid,p.*')->join('left join __OP_GUIDE_PRICE__ as p on p.confirm_id = c.id')->where(array('c.op_id'=>$opid,'p.op_id'=>$opid))->select();
        $this->apply_to       = C('APPLY_TO');
        $this->arr_product    = C('ARR_PRODUCT');

        $this->guide_price    = M('op_guide_price')->where(array('op_id'=>$opid,'confirm_id'=>'0'))->select();
        if ($this->guide_price) {
            $this->rad = 1;
        }else{
            $this->rad = 0;
        }

        //资源需求单接收人员(资源管理部经理)
        //$this->men            = M('account')->field('id,nickname')->where(array('roleid'=>52))->find();
        $this->tcs = M()->table('__OP_GUIDE_PRICE__ as gp')
            ->field('gp.*,gk.name as gkname,gpk.name as gpkname')
            ->join('left join __GUIDEKIND__ as gk on gp.guide_kind_id = gk.id')
            ->join('left join __GUIDE_PRICEKIND__ as gpk on gp.gpk_id = gpk.id')
            ->where(array('gp.op_id'=>$opid,'gp.confirm_id'=>'0'))
            ->select();

        //客户名称关键字
		$where = array();
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==28 || cookie('roleid')==11 || cookie('roleid')==30){
			$where['company_name'] = array('neq','');
		}else{
			$where['company_name'] = array('neq','');
			$where['cm_id'] = array('in',Rolerelation(cookie('roleid')));
		}
		$this->geclist     = M('customer_gec')->field('id,pinyin,company_name')->where($where)->group("company_name")->order('pinyin ASC')->select();

        //人员名单关键字
        $this->userkey      = get_username();

        //研发和资源人员信息(用于前期对研发和资源人员评分)
        $score_data         = $this->get_score_user($opid);

        $pingfen            = $score_data['pingfen'];
        $yanfa              = $score_data['yanfa'];
        $ziyuan             = $score_data['ziyuan'];
        if ($pingfen) { $this->pingfen  = json_encode($pingfen) ;}
        $this->yanfa        = $yanfa;
        $this->ziyuan       = $ziyuan;

        $this->display('plans_edit');
		
	}

    private function get_score_user($opid){
        $pingfen            = M('op_score')->where(array('op_id'=>$opid))->find();
        $yanfa_info         = M('worder')->field('exe_user_id , exe_user_name , assign_id, assign_name')->where(array('op_id'=>$opid,'kpi_type'=>3,'status'=>array('neq',-1)))->find();   //京区校内研发
        $ziyuan_info        = M('worder')->field('exe_user_id , exe_user_name , assign_id, assign_name')->where(array('op_id'=>$opid,'kpi_type'=>4,'status'=>array('neq',-1)))->find();   //京区校内资源
        $jidiao_info        = M()->table('__OP_AUTH__ as o')->field('a.id,a.nickname')->join('__ACCOUNT__ as a on a.id=o.yusuan','left')->where(array('o.op_id'=>$opid))->find();
        $yanfa              = array();
        $yanfa['user_id']   = $pingfen['yf_uid']?$pingfen['yf_uid']:($yanfa_info['assign_id']?$yanfa_info['assign_id']:$yanfa_info['exe_user_id']);
        $yanfa['user_name'] = $pingfen['yf_uname']?$pingfen['yf_uname']:($yanfa_info['assign_name']?$yanfa_info['assign_name']:$yanfa_info['exe_user_name']);
        $ziyuan             = array();
        $ziyuan['user_id']  = $pingfen['zy_uid']?$pingfen['zy_uid']:($ziyuan_info['assign_id']?$ziyuan_info['assign_id']:$ziyuan_info['exe_user_id']);
        $ziyuan['user_name']= $pingfen['zy_uname']?$pingfen['zy_uname']:($ziyuan_info['assign_name']?$ziyuan_info['assign_name']:$ziyuan_info['exe_user_name']);
        $jidiao             = array();
        $jidiao['user_id']  = $pingfen['ji_uid']?$pingfen['ji_uid']:($jidiao_info['id']?$jidiao_info['id']:0);
        $jidiao['user_name']= $pingfen['ji_uname']?$pingfen['ji_uname']:($jidiao_info['nickname']?$jidiao_info['nickname']:'');

        $data               = array();
        $data['pingfen']    = $pingfen;
        $data['yanfa']      = $yanfa;
        $data['ziyuan']     = $ziyuan;
        $data['jidiao']     = $jidiao;
        return $data;
    }
	
	
	// @@@NODE-3###public_save###保存项目###
    public function public_save(){
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$db             = M('op');
			$op_cost_db     = M('op_cost');
			$op_guide_db    = M('op_guide');
			$op_member_db   = M('op_member');
			$op_supplier_db = M('op_supplier');
            $op_res_db      = M('op_res');
            //$op_res_money_db= M('op_res_money');
            $op_guide_price_db = M('op_guide_price');


            $opid       = I('opid');
			$info       = I('info');
			$guide      = I('guide');
			$member     = I('member');
			$cost       = I('cost');
			$supplier   = I('supplier');
			$wuzi       = I('wuzi');
			$savetype   = I('savetype');
			$days       = I('days');
			$resid      = I('resid');
			$num        = 0;

			//保存专家辅导员信息
			if($opid && $savetype==2 ){
				$delid = array();
				foreach($guide as $k=>$v){
					$data = array();
					$data = $v;
					if($resid && $resid[$k]['id']){
						$edits = $op_guide_db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
						$delid[] = $resid[$k]['id'];
						$cost[$k]['link_id'] = $resid[$k]['id'];
						$num++;
					}else{
						$data['op_id'] = $opid;
						$savein = $op_guide_db->add($data);
						$delid[] = $savein;
						$cost[$k]['link_id'] = $savein;
						if($savein) $num++;
					}
				}	
				
				$where = array();
				$where['op_id'] = $opid;
				if($delid) $where['id'] = array('not in',$delid);
				$del = $op_guide_db->where($where)->delete();
				if($del) $num++;
				
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 4;
					$record['explain'] = '专家辅导员资源';
					op_record($record);
				}
				
				
			
			}
				
			//保存合格供方信息
			if($opid && $savetype==3 ){		
					
				$delid = array();
				foreach($supplier as $k=>$v){
					$data = array();
					$data = $v;
					if($resid && $resid[$k]['id']){
						$edits = $op_supplier_db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
						$delid[] = $resid[$k]['id'];
						$cost[$k]['link_id'] = $resid[$k]['id'];
						$num++;
					}else{
						$data['op_id'] = $opid;
						$savein = $op_supplier_db->add($data);
						$delid[] = $savein;
						$cost[$k]['link_id'] = $savein;
						if($savein) $num++;
					}
				}	
				
				$where = array();
				$where['op_id'] = $opid;
				if($delid) $where['id'] = array('not in',$delid);
				$del = $op_supplier_db->where($where)->delete();
				if($del) $num++;
				
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 4;
					$record['explain'] = '调度合格供方资源资源';
					op_record($record);
				}
			}
					
			//保存物资信息	
			if($opid && $savetype==4 ){
				
				$delid = array();
				foreach($wuzi as $k=>$v){
					$data = array();
					$data = $v;
					if($resid && $resid[$k]['id']){
						$edits = M('op_material')->data($data)->where(array('id'=>$resid[$k]['id']))->save();
						$cost[$k]['link_id'] = $resid[$k]['id'];
						$delid[] = $resid[$k]['id'];
						$num++;
					}else{
						$data['op_id'] = $opid;
						$savein = M('op_material')->add($data);
						$cost[$k]['link_id'] = $savein;
						$delid[] = $savein;
						if($savein) $num++;
					}
				}	
				
				$where = array();
				$where['op_id'] = $opid;
				if($delid) $where['id'] = array('not in',$delid);
				$del = M('op_material')->where($where)->delete();
				if($del) $num++;
				
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 4;
					$record['explain'] = '调度物资';
					op_record($record);
				}
			}
			
			//保存用户名单信息
			if($opid && $savetype==5 ){
				
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
						$data['sales_person_uid'] = cookie('userid');
						$data['sales_time']       = time();
						$savein = $op_member_db->add($data);
						$delid[] = $savein;
						if($savein) $num++;
						
						//将名单保存至客户名单
						if(!M('customer_member')->where(array('number'=>$v['number']))->find()){
							$mem = $v;
							$mem['source'] = cookie('userid');
							$mem['create_time'] = time();
							M('customer_member')->add($mem);
						}
					}
				}	
				
				$where = array();
				$where['op_id'] = $opid;
				if($delid) $where['id'] = array('not in',$delid);
				$del = $op_member_db->where($where)->delete();
				if($del) $num++;
				
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 7;
					$record['explain'] = '保存用户名单';
					op_record($record);
				}
				
			}
			
			//确定成团
			if($opid && $savetype==9 ){
				
				$data = array();
				$data['status'] = I('status');
				$data['group_id'] = strtoupper(I('gid'));
				$data['nogroup'] = I('nogroup');
				$op = M('op')->where(array('op_id'=>$opid))->find();
				if($op['audit_status']==1){
					//保存成团
					$issave = M('op')->data($data)->where(array('op_id'=>$opid))->save();
					if($issave) $num++;
				}
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 6;
					if($data['status']==1){
						$record['explain'] = '项目成团操作';
					}elseif($data['status']==2){
						$record['explain'] = '项目不成团操作';
					}
					op_record($record);
				}
			}
			
			//修改项目基本信息
			if($opid && $savetype==10 ){
				
				$op = M('op')->where(array('op_id'=>$opid))->find();
				if($op['status']=='0' || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')) {
                    if (in_array($op['in_dijie'],array(0,2)) && $info['in_dijie']==1){
                        $info['project'] = '【发起团】'.$info['project'];
                    }elseif ($op['in_dijie']==1 && $info['in_dijie'] !=1){
                        $info['project']    = str_replace('【发起团】','',$info['project']);
                        $info['dijie_name'] = '';
                        $info['dijie_opid'] = '';
                    }

                    //保存成团
                    $issave = M('op')->data($info)->where(array('op_id' => $opid))->save();
                    if ($issave) $num++;
                }
				if($num){
					$record = array();
					$record['op_id']   = $opid;
					$record['optype']  = 1;
					$record['explain'] = '修改项目基本信息';
					op_record($record);
				}

			}
				
			//保存价格
			if($cost){
				$i = 0;
				$op_cost_db->where(array('op_id'=>$opid,'cost_type'=>$savetype))->delete();
				foreach($cost as $k=>$v){
					$data = array();
					$data = $v;
					$data['op_id'] = $opid;
					if($data['cost_type']==1){
						$data['amount'] = $info['number'];
					}
					$data['total'] = $data['cost']*$data['amount'];
					
					$op_cost_db->add($data);
					
					$i++;
				}	
			}

			//保存资源需求单
            if($opid && $savetype==11 ){

                header('Content-Type:text/html;charset=utf-8');
                $info['op_id']      = $opid;
                $info['in_time']    = strtotime($info['in_time']);
                $act_needs          = I('act_need');
                $task_fields        = I('task_field');
                $info['act_need']   = implode(',',$act_needs);
                $info['task_field'] = implode(',',$task_fields);

                if ($info['audit_user_id']){
                    $saved_id = $op_res_db->where(array('op_id'=>$opid))->getField('id');
                    if ($saved_id){
                        $op_res_db->where(array('id'=>$saved_id))->save($info);
                        $res = $saved_id;
                    }else{
                        $info['create_time']   = NOW_TIME;
                        $res = $op_res_db->add($info);
                    }
                    if($res){
                        $num++;
                        /*$op_res_money_db->where(array('op_res_id'=>$res))->delete();
                        foreach ($data as $v){
                            if ($v['job_name']) {
                                $v['op_res_id'] = $res;
                                $op_res_money_db->add($v);
                            }
                        }*/

                        $record = array();
                        $record['op_id']   = $opid;
                        $record['optype']  = 4;
                        $record['explain'] = '填写资源需求单';
                        op_record($record);

                        $audit_user_id        = $info['audit_user_id'];
                        if (cookie('userid') != $info['audit_user_id']){
                            $op      = M('op')->where(array('op_id'=>$opid))->find();
                            //发送系统消息
                            $uid     = cookie('userid');
                            $title   = '您有来自['.session('rolename').'--'.$info['ini_user_name'].']的资源需求单待审核!';
                            $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'];
                            $url     = U('Op/res_feedback',array('opid'=>$info['op_id']));
                            $user    = '['.$audit_user_id.']';
                            send_msg($uid,$title,$content,$url,$user,'');
                        }
                    }
                }

            }

            //保存辅导员/教师,专家需求
            if($opid && $savetype==12 ){
                $data   = I('data');
                $op     = $db->where(array('op_id'=>$opid))->find();

                $savedel = $op_guide_price_db->where(array('op_id'=>$opid,'confirm_id'=>0))->delete();
                if ($savedel)  $num++;
                foreach($data as $k=>$v){
                    $v['op_id'] = $opid;
                    $savein     = $op_guide_price_db->add($v);
                    if($savein) $num++;
                }

                //产品模块化,直接保存到核算costacc表(56=>校园科技节)
                //$arr_product    = C('ARR_PRODUCT');
                //if (in_array($op['kind'],$arr_product)){
                    M('op_costacc')->where(array('op_id'=>$opid,'type'=>2,'status'=>0))->delete();
                    foreach ($data as $k=>$v){
                        $data   = array();
                        $data['op_id']  = $opid;
                        $data['title']  = '注册辅导员/教师';
                        $data['unitcost']=$v['price'];
                        $data['amount'] = $v['num'];
                        $data['total']  = $v['total'];
                        $data['remark'] = $v['remark'];
                        $data['type']   = 2;    //专家辅导员
                        $data['status'] = 0;    //核算
                        $savein = M('op_costacc')->add($data);
                        if ($savein) $num++;
                    }
                //}

                //数据转存至op_guide_confirm表
                $confirm    = M('op_guide_confirm')->where(array('op_id'=>$opid))->find();
                if (!$confirm){
                    $confirm            = array();
                    $confirm['op_id']   = $opid;
                    $confirm['tcs_stu'] = 1;    //待要专家辅导员(未成团)
                    $res =M('op_guide_confirm')->add($confirm);
                }

                if ($res){
                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写专家辅导员资源需求';
                    op_record($record);
                }

            }

            //保存辅导员/教师,专家具体需求信息
            if($opid && $savetype==13 ){

                $data           = I('data');
                $in_day         = I('in_day');
                $tcs_time       = I('tcs_time');
                $address        = I('address');
                $confirm_id     = I('confirm_id');
                if (!$in_day || !$address) $this->error('请填写出行日期和出行时间');
                $in_begin_day   = substr($in_day,0,10);
                $in_end_day     = substr($in_day,13,10);
                $tcs_begin_time = $in_end_day.' '.substr($tcs_time,0,8);
                $tcs_end_time   = $in_end_day.' '.substr($tcs_time,11,8);
                $info['in_begin_day']   = strtotime($in_begin_day);
                $info['in_day']         = strtotime($in_end_day);
                $info['tcs_begin_time'] = strtotime($tcs_begin_time)?strtotime($tcs_begin_time):strtotime($in_begin_day);
                $info['tcs_end_time']   = strtotime($tcs_end_time)?strtotime($tcs_end_time):strtotime($in_end_day);
                $info['address']        = $address;
                $info['op_id']          = $opid;
                $info['tcs_stu']        = 2;    //已确认需求(已成团)

                if ($data){
                    if ($confirm_id){
                        $res = M('op_guide_confirm')->where(array('id'=>$confirm_id))->save($info);
                    }else{
                        //更改项目跟进时提出的需求信息
                        $list       = M('op_guide_confirm')->where(array('op_id'=>$opid,'tcs_stu'=>1))->find();
                        if ($list){
                            $confirm_id = $list['id'];
                            $res    = M('op_guide_confirm')->where(array('id'=>$confirm_id))->save($info);
                        }else{
                            $confirm_id = M('op_guide_confirm')->add($info);
                        }
                    }
                    if ($confirm_id){
                        //$op_guide_price_db->where(array('op_id'=>$opid,'confirm_id'=>0))->delete();
                        $res = $op_guide_price_db->where(array('op_id'=>$opid,'confirm_id'=>$confirm_id))->delete();
                        if ($res) $num++;
                        foreach($data as $k=>$v){
                            $v['op_id']      = $opid;
                            $v['confirm_id'] = $confirm_id;
                            $savein          = $op_guide_price_db->add($v);
                            if($savein) $num++;
                        }
                    }
                    if ($num){
                        $record = array();
                        $record['op_id']   = $opid;
                        $record['optype']  = 4;
                        $record['explain'] = '成团后确认辅导员资源需求(增加/编辑)';
                        op_record($record);
                        $this->success('保存成功');
                    }else{
                        $this->error('保存失败');
                    }
                }else{
                    $this->error('请填写完整信息!');
                }
            }


            //保存项目跟进校园科技节产品模块需求
            if($opid && $savetype==14 ){
                $costacc    = I('costacc');
                $resid      = I('resid');

                M('op_product')->where(array('op_id'=>$opid))->delete();
                foreach ($costacc as $k=>$v){
                    $v['op_id']     = $opid;
                    $v['total']     = floatval($v['unitcost'])*intval($v['amount']);
                    $v['status']    = 0;    //核算

                    if($resid && $resid[$k]['id']){
                        $edits      = M('op_costacc')->data($v)->where(array('id'=>$resid[$k]['id']))->save();
                        $delid[]    = $resid[$k]['id'];
                        $num++;
                    }else{
                        $savein     = M('op_costacc')->add($v);
                        $delid[]    = $savein;
                        if($savein) $num++;
                    }
                    $del            = M('op_costacc')->where(array('op_id'=>$opid,'type'=>5,'status'=>0,'id'=>array('not in',$delid)))->delete();
                    if ($del) $num++;

                    $data           = array();
                    $data['op_id']  = $opid;
                    $data['product_id'] = $v['product_id'];
                    $data['amount'] = $v['amount'];
                    $res = M('op_product')->add($data);
                    if ($res) $num++;
                }
                if ($num){
                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写项目模块信息';
                    op_record($record);
                }
            }

            //审核资源配置信息(审核15)
            if ($opid && $savetype==20){
                if ($info['audit_status']){
                    $res_id                 = I('res_id');
                    $info['audit_time']     = NOW_TIME;
                    $where                  = array();
                    $where['id']            = $res_id;
                    $res = $op_res_db->where($where)->save($info);
                    if ($res){
                        $status     = C('AUDIT_STATUS');
                        $op         = M('op')->where(array('op_id'=>$opid))->find();
                        if ($info['audit_status'] == 1){
                            //审核通过(发送系统消息)
                            $uid     = cookie('userid');
                            $title   = '您有来自['.session('rolename').'--'.session('nickname').']的资源需求单!';
                            $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'];
                            $url     = U('Op/res_feedback',array('opid'=>$opid));
                            $user    = '['.$info['exe_user_id'].']';
                            send_msg($uid,$title,$content,$url,$user,'');
                        }else{
                            $ini_user_id = $op_res_db->where(array('id'=>$res_id))->getField('ini_user_id');
                            //审核不通过
                            $uid     = cookie('userid');
                            $title   = '您有来自['.session('rolename').'--'.session('nickname').']的资源需求单审核结果通知!';
                            $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'].'；审核结果：'.$status[$info["audit_status"]];
                            $url     = U('Op/confirm',array('opid'=>$opid));
                            $user    = '['.$ini_user_id.']';
                            send_msg($uid,$title,$content,$url,$user,'');
                        }

                        //操作记录
                        $record = array();
                        $record['op_id']   = $opid;
                        $record['optype']  = 4;
                        $record['explain'] = '审核资源需求反馈信息['.$status[$info["audit_status"]].']';
                        op_record($record);

                        $num++;
                    }
                }
            }

            //保存资源配置回复信息(完成)
            if ($opid && $savetype==15){
                $res_id                 = I('res_id');
                $info['feedback_time']  = NOW_TIME;
                $where                  = array();
                $where['id']            = $res_id;
                $res = $op_res_db->where($where)->save($info);
                if ($res){
                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写资源需求反馈信息';
                    op_record($record);

                    $num++;
                }
            }

            //保存委托设计工作交接单
            if ($opid && $savetype==16){

                $info['op_id']       = $opid;
                $info['create_time'] = NOW_TIME;
                $info['need_time'] = strtotime($info['need_time']);
                if (!$info['audit_user_id']){
                    $this->error('请填写审核人员信息');
                }
                $list = M('op_design')->where(array('op_id'=>$opid))->find();
                if ($list) {
                    $res = M('op_design')->where(array('id'=>$list['id']))->save($info);
                }else{
                    $res = M('op_design')->add($info);
                }
                if ($res) {
                    //发送审核系统消息
                    $audit_user_id        = $info['audit_user_id'];
                    $op      = M('op')->where(array('op_id'=>$opid))->find();
                    //发送系统消息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.session('rolename').'--'.$info['ini_user_name'].']委托设计工作交接单待审核!';
                    $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'];
                    $url     = U('Op/res_audit',array('opid'=>$info['op_id'],'type'=>1));
                    $user    = '['.$audit_user_id.']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写/修改委托设计工作交接单(设计)';
                    op_record($record);

                    $num++;
                }
            }

            //保存"审核"委托设计工作交接单 + 业务实施计划单
            if ($opid && $savetype==17){

                $type           = I('type');
                if (!$info){
                    $this->error('审核信息有误!');
                }
                if ($type == 1){
                    //保存审核委托设计工作交接单
                    $design_id      = I('design_id');
                    $info['audit_time'] = NOW_TIME;
                    $res = M('op_design')->where(array('id'=>$design_id))->save($info);
                }else{
                    //保存业务实施计划单
                    $plan_id    = I('plan_id');
                    $info['audit_time'] = NOW_TIME;
                    $res = M('op_work_plans')->where(array('id'=>$plan_id))->save($info);
                }
                if ($res) {
                    $status     = C('AUDIT_STATUS');
                    $record     = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    if ($type == 1) {
                        $record['explain'] = '审核委托设计工作交接单';
                        $list    = M('op_design')->where(array('id'=>$design_id))->find();
                    }else{
                        $record['explain'] = '审核业务实施计划单';
                        $list    = M('op_work_plans')->where(array('id'=>$plan_id))->find();
                    }
                    op_record($record);
                    $op      = M('op')->where(array('op_id'=>$opid))->find();

                    if ($info['audit_status'] == P::AUDIT_STATUS_PASS){
                        $exe_user_id = $list['exe_user_id'];
                        //发送系统消息
                        $uid     = cookie('userid');
                        $title   = '您有来自['.session('rolename').'--'.$list['ini_user_name'].']委托设计工作交接单!';
                        $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'];
                        $url     = U('Op/res_audit',array('opid'=>$list['op_id'],'type'=>$type));
                        $user    = '['.$exe_user_id.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }else{
                        if ($type ==1){
                            //工作交接单
                            $ini_user_id = M('op_design')->where(array('id'=>$design_id))->getField('ini_user_id');
                            $name        = '委托设计工作交接单';
                        }else{
                            //业务实施计划单
                            $ini_user_id = M('op_work_plans')->where(array('id'=>$plan_id))->getField('ini_user_id');
                            $name        = '业务实施计划单';
                        }
                        //审核不通过
                        $uid     = cookie('userid');
                        $title   = '您有来自['.session('rolename').'--'.session('nickname').']的'.$name.'审核结果通知!';
                        $content = '项目名称：'.$op['project'].'；团号：'.$op['group_id'].'；审核结果：'.$status[$info["audit_status"]].'；<span class="red">'.$info['audit_remark'].'</span>';
                        $url     = U('Op/confirm',array('opid'=>$opid));
                        $user    = '['.$ini_user_id.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

                    $this->success('审核成功');
                }else{
                    $this->error('保存数据失败');
                }

            }

            ////保存"完成"委托设计工作交接单
            if ($opid && $savetype==18){
                $type               = I('type');
                if ($type == 1) {
                    $design_id          = I('design_id');
                    $info['finish_time']= NOW_TIME;
                    $res = M('op_design')->where(array('id'=>$design_id))->save($info);
                }else{
                    //保存业务实施计划单
                    $plan_id    = I('plan_id');
                    $info['finish_time'] = NOW_TIME;
                    $res = M('op_work_plans')->where(array('id'=>$plan_id))->save($info);
                }
                if ($res) {
                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    if ($type ==1) {
                        $record['explain'] = '完成委托设计工作交接单';
                    }else{
                        $record['explain'] = '完成保存业务实施计划单';
                    }
                    op_record($record);

                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            //保存业务实施计划单
            if ($opid && $savetype==19){

                $between_time       = I('between_time');
                $additive           = I('additive');
                $plan_lists         = I('plans');
                $begin_time         = strtotime(substr($between_time,0,10));
                $end_time           = strtotime(substr($between_time,-10,10));
                $info['op_id']      = $opid;
                $info['begin_time'] = $begin_time;
                $info['end_time']   = $end_time;
                $info['additive']   = implode(',',$additive);
                $info['create_time']= NOW_TIME;

                $planed = M('op_work_plans')->where(array('op_id'=>$opid))->find();
                if ($planed) {
                    $plan_id    = $planed['id'];
                    $res        = M('op_work_plans')->where(array('id'=>$plan_id))->save($info);
                }else{
                    $res        = M('op_work_plans')->add($info);
                    $plan_id    = $res;
                }

                if ($res) {
                    foreach ($plan_lists as $k=>$v){
                        $data   = array();
                        $data   = $v;
                        if ($resid && $resid[$k]['id']){
                            M('op_work_plan_lists')->where(array('id'=>$resid[$k]['id']))->save($data);
                            $delid[] = $resid[$k]['id'];
                        }else{
                            $data['plan_id']   = $plan_id;
                            $data['op_id']     = $opid;
                            $res = M('op_work_plan_lists')->add($data);
                            $delid[]           = $res;
                        }
                    }

                    $where          = array();
                    $where['op_id'] = $opid;
                    if ($delid) $where['id'] = array('not in',$delid);
                    M('op_work_plan_lists')->where($where)->delete();

                    //发送审核系统消息
                    $audit_user_id = $info['audit_user_id'];
                    $op      = M('op')->where(array('op_id'=>$opid))->find();
                    //发送系统消息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.session('rolename').'--'.$info['ini_user_name'].']业务实施计划单待审核!';
                    $content = '项目名称：'.$op['project'].';&nbsp;团号：'.$op['group_id'];
                    $url     = U('Op/res_audit',array('opid'=>$info['op_id'],'type'=>2));
                    $user    = '['.$audit_user_id.']';
                    send_msg($uid,$title,$content,$url,$user,'');

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写/修改业务实施计划单(计调)';
                    op_record($record);

                    $num++;
                }
            }

            //保存前期对资源评价
            if ($opid && $savetype==21){
                $info['op_id']      = $opid;
                $info['pf_id']      = cookie('userid');
                $info['pf_name']    = cookie('nickname');
                $info['create_time']= NOW_TIME;
                $pingfen    = M('op_score')->where(array('op_id'=>$opid))->find();
                if ($pingfen){
                    $res    = M('op_score')->where(array('id'=>$pingfen['id']))->save($info);

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '修改前期评分信息';
                    op_record($record);
                }else{
                    $res    = M('op_score')->add($info);

                    $record = array();
                    $record['op_id']   = $opid;
                    $record['optype']  = 4;
                    $record['explain'] = '填写前期评分信息';
                    op_record($record);
                }
                if ($res) $num++;
            }

            //活动结束后对计调的评价
            if ($opid && $savetype==22){
                $info                   = I('info');
                $info['jd_score_time']  = NOW_TIME;
                $pingfen                = M('op_score')->where(array('op_id'=>$opid))->find();
                if ($pingfen){
                    $res                = M('op_score')->where(array('id'=>$pingfen['id']))->save($info);

                    $record             = array();
                    $record['op_id']    = $opid;
                    $record['optype']   = 4;
                    $record['explain']  = '修改计调评分信息';
                    op_record($record);
                }else{
                    $info['op_id']      = $opid;
                    $info['pf_id']      = cookie('userid');
                    $info['pf_name']    = cookie('nickname');
                    $info['create_time']= NOW_TIME;
                    $res                = M('op_score')->add($info);

                    $record             = array();
                    $record['op_id']    = $opid;
                    $record['optype']   = 4;
                    $record['explain']  = '填写计调评分信息';
                    op_record($record);
                }

                if ($res) $num++;
            }

            echo $num;
        }
	
	}


	//@@@NODE-3###res_audit###审核委托设计工作交接单###
    public function res_audit(){
        if (isset($_POST['dosubmint'])){
            $design_id      = I('designed');
        }else{
            $opid           = I('opid');
            $design         = M('op_design')->where(array('op_id'=>$opid))->find();         //委托设计工作交接单
            $work_plan      = M('op_work_plans')->where(array('op_id'=>$opid))->find();     //业务实施计划单
            $plan_lists     = M('op_work_plan_lists')->where(array('plan_id'=>$work_plan['id']))->select();
            $this->work_plan= $work_plan;
            $this->additive = explode(',',$work_plan['additive']);
            $additive_con   = array(
                '1'         => '行程或方案',
                '2'         => '需解决大交通的《人员信息表》',
                '3'         => '其他'
            );
            $this->additive_con = $additive_con;
            $this->plan_lists= $plan_lists;
            $this->type     = I('type');
            if (!$design && !$work_plan){
                $this->error('暂无数据信息');
            }
            $this->design   = $design;
            $this->op       = M('op')->where(array('op_id'=>$opid))->find();
            $user_info      = M()->table('__ACCOUNT__ as a')
                ->field('a.mobile,d.department,o.create_user_name')
                ->join('__OP__ as o on o.create_user = a.id','left')
                ->join('__SALARY_DEPARTMENT__ as d on d.id = a.departmentid')
                ->where(array('o.op_id'=>$opid))
                ->find();
            $this->user_info   = $user_info;
            $this->output_info = array(
                '1'=>'出片打样',
                '2'=>'喷绘',
                '3'=>'只提供电子文件'
            );
            $this->audit_status = array (
                P::AUDIT_STATUS_NOT_AUDIT  => '<span class="yellow">未审核</span>',
                P::AUDIT_STATUS_PASS       => '<span class="green">审核通过</span>',
                P::AUDIT_STATUS_NOT_PASS   => '<span class="red">未通过</span>',
            );

            //人员名单关键字
            $this->userkey      = get_username();

            $this->display();
        }
    }

	//@@@NODE-3###assign_line###指派人员跟进线路行程信息###
    public function assign_line(){
		$opid       = I('opid');
		$info       = I('info');
		$user       =  M('account')->getField('id,nickname', true);
		
		if(isset($_POST['dosubmit']) && $info){
			
			$data = array();
			$data['line'] = $info;
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "行程方案";
            project_worder($info,$opid,$thing);

            if($auth){
				M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
			}else{
				$data['op_id'] = $opid;
				M('op_auth')->add($data);
			}
			
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 2;
			$record['explain'] = '指派【'.$user[$info].'】负责项目行程';
			op_record($record);
				
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key = I('key');
			$db = M('account');
			$where = array();
			$where['id'] = array('gt',3);
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  = M('role')->getField('id,role_name', true);
			$this->opid = $opid;
			$this->display('assign_line');
		}
	}

    //@@@NODE-3###assign_hesuan###指派人员跟进成本核算###
    /*public function assign_hesuan(){
        $opid       = I('opid');
        $info       = I('info');
        $user      =  M('account')->getField('id,nickname', true);

        if(isset($_POST['dosubmit']) && $info){

            $data = array();
            $data['hesuan'] = $info;
            $data['yusuan'] = $info;
            $data['jiesuan']= $info;
            $data['line']   = $info;
            $auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "行程方案";
            //project_worder($info,$opid,$thing);

            if($auth){
                M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
            }else{
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            //发送消息
            $uid     = cookie('userid');
            $title   = cookie('name').'指派您跟进成本核算';
            $content = '项目编号: '.$opid;
            $url     = U('Finance/costacc',array('opid'=>$opid));
            $users    = '['.$info.']';
            send_msg($uid,$title,$content,$url,$users,'');

            $record = array();
            $record['op_id']   = $opid;
            $record['optype']  = 2;
            $record['explain'] = '指派【'.$user[$info].'】跟进成本核算';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        }else{

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt',3);
            if($key) $where['nickname'] = array('like','%'.$key.'%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount,6);
            $this->pages = $pagecount>6 ? $page->show():'';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role  = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_hesuan');
        }
    }*/

    //@@@NODE-3###assign_yusuan###指派人员跟进项目预算###
    public function assign_yusuan(){
        $opid       = I('opid');
        $info       = I('info');
        $user       =  M('account')->getField('id,nickname', true);

        if(isset($_POST['dosubmit']) && $info){

            $data = array();
            $data['yusuan'] = $info;
            $data['jiesuan']= $info;
            $data['line']   = $info;
            $auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "行程方案";
            //project_worder($info,$opid,$thing);

            if($auth){
                M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
            }else{
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            //发送消息
            $uid     = cookie('userid');
            $title   = cookie('name').'指派您跟进项目预算';
            $content = '项目编号: '.$opid;
            $url     = U('Finance/op',array('opid'=>$opid));
            $users    = '['.$info.']';
            send_msg($uid,$title,$content,$url,$users,'');

            $record = array();
            $record['op_id']   = $opid;
            $record['optype']  = 2;
            $record['explain'] = '指派【'.$user[$info].'】跟进项目预算';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        }else{

            //用户列表
            $key = I('key');
            $db = M('account');
            $where          = array();
            $where['id']    = array('gt',3);
            $where['status']= array('eq',0);    //1=>停用, 2=>删除
            if($key) $where['nickname'] = array('like','%'.$key.'%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount,6);
            $this->pages = $pagecount>6 ? $page->show():'';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();

            $this->role  = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_yusuan');
        }
    }

    //@@@NODE-3###assign_jiesuan###指派人员跟进项目预算###
    public function assign_jiesuan(){
        $opid       = I('opid');
        $info       = I('info');
        $user       =  M('account')->getField('id,nickname', true);

        if(isset($_POST['dosubmit']) && $info){

            $data = array();
            $data['jiesuan'] = $info;
            $auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "行程方案";
            //project_worder($info,$opid,$thing);

            if($auth){
                M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
            }else{
                $data['op_id'] = $opid;
                M('op_auth')->add($data);
            }

            //发送消息
            $uid     = cookie('userid');
            $title   = cookie('name').'指派您跟进项目结算';
            $content = '项目编号: '.$opid;
            $url     = U('Finance/settlement',array('opid'=>$opid));
            $users    = '['.$info.']';
            send_msg($uid,$title,$content,$url,$users,'');

            $record = array();
            $record['op_id']   = $opid;
            $record['optype']  = 2;
            $record['explain'] = '指派【'.$user[$info].'】跟进项目结算';
            op_record($record);

            echo '<script>window.top.location.reload();</script>';

        }else{

            //用户列表
            $key = I('key');
            $db = M('account');
            $where          = array();
            $where['id']    = array('gt',3);
            $where['status']= array('eq',0);    //1=>停用, 2=>删除
            if($key) $where['nickname'] = array('like','%'.$key.'%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount,6);
            $this->pages = $pagecount>6 ? $page->show():'';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role  = M('role')->getField('id,role_name', true);
            $this->opid = $opid;
            $this->display('assign_jiesuan');
        }
    }
	
	//@@@NODE-3###assign_res###指派人员跟进资源调度###
    public function assign_res(){
		$opid       = I('opid');
		$info       = I('info');
		$user       =  M('account')->getField('id,nickname', true);
		if(isset($_POST['dosubmit']) && $info){
			
			$data = array();
			$data['res'] = $info;
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "物资调度";
            project_worder($info,$opid,$thing);

			if($auth){
				M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
			}else{
				$data['op_id'] = $opid;
				M('op_auth')->add($data);
			}



			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 2;
			$record['explain'] = '指派【'.$user[$info].'】负责项目所需资源调度';
			op_record($record);
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key = I('key');
			$db = M('account');
			$where = array();
			$where['id'] = array('gt',3);
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  =  M('role')->getField('id,role_name', true);
			$this->opid = $opid;
			$this->display('assign_res');
		}
	}

	//@@@NODE-3###assign_res###指派人员跟进导游辅导员调度###
    public function assign_guide(){
		$opid       = I('opid');
		$info       = I('info');
		$user       =  M('account')->getField('id,nickname', true);
		if(isset($_POST['dosubmit']) && $info){
			
			$data = array();
			$data['guide'] = $info;
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "专家辅导员调度";
            project_worder($info,$opid,$thing);

			if($auth){
				M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
			}else{
				$data['op_id'] = $opid;
				M('op_auth')->add($data);
			}
			
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 2;
			$record['explain'] = '指派【'.$user[$info].'】负责项目导游辅导员调度';
			op_record($record);
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key = I('key');
			$db = M('account');
			$where = array();
			$where['id'] = array('gt',3);
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  =  M('role')->getField('id,role_name', true);
			$this->opid = $opid;
			$this->display('assign_guide');
		}
	}

	//@@@NODE-3###assign_res###指派人员跟进导游辅导员调度###
    public function assign_material(){
		$opid       = I('opid');
		$info       = I('info');
		$user       =  M('account')->getField('id,nickname', true);
		if(isset($_POST['dosubmit']) && $info){
			
			$data = array();
			$data['material'] = $info;
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "合格供方调度";
            project_worder($info,$opid,$thing);

			if($auth){
				M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
			}else{
				$data['op_id'] = $opid;
				M('op_auth')->add($data);
			}
			
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 2;
			$record['explain'] = '指派【'.$user[$info].'】负责项目合格供方调度';
			op_record($record);
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key = I('key');
			$db = M('account');
			$where = array();
			$where['id'] = array('gt',3);
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  =  M('role')->getField('id,role_name', true);
			$this->opid = $opid;
			$this->display('assign_material');
		}
	}

	//@@@NODE-3###assign_price###指派人员制定价格###
    public function assign_price(){
		$opid       = I('opid');
		$info       = I('info');
		$user       =  M('account')->getField('id,nickname', true);
		if(isset($_POST['dosubmit']) && $info){
			
			$data = array();
			$data['price'] = $info;
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();

            //创建工单
            $thing  = "项目标价";
            project_worder($info,$opid,$thing);

			if($auth){
				M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
			}else{
				$data['op_id'] = $opid;
				M('op_auth')->add($data);
			}
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 2;
			$record['explain'] = '指派【'.$user[$info].'】负责项目标价';
			op_record($record);
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key = I('key');
			$db = M('account');
			$where = array();
			$where['id'] = array('gt',3);
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  =  M('role')->getField('id,role_name', true);
			$this->opid = $opid;
			$this->display('assign_price');
		}
	}

	//@@@NODE-3###public_save_price###保存项目价格###
    public function public_save_price(){
		
		$db         = M('op_pretium');
		$opid       = I('opid');
		$pretium    = I('pretium');
		$resid      = I('resid');
		$num        = 0;
		
		//保存价格政策
		if($opid && $pretium){
			
			$delid = array();
			foreach($pretium as $k=>$v){
				$data = array();
				$data = $v;
				if($resid && $resid[$k]['id']){
					$edits = $db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
					$delid[] = $resid[$k]['id'];
					$num++;
				}else{
					$data['op_id'] = $opid;
					$savein = $db->add($data);
					$delid[] = $savein;
					if($savein) $num++;
				}
			}	
			
			$del = $db->where(array('op_id'=>$opid,'id'=>array('not in',$delid)))->delete();
			if($del) $num++;
		}
		
		if($num){
			$record = array();
			$record['op_id']   = $opid;
			$record['optype']  = 5;
			$record['explain'] = '保存项目标价';
			op_record($record);
		}
			
		echo $num;
	}

	// @@@NODE-3###public_save_line###保存线路###
    public function public_save_line(){
			
		$opid       = I('opid');
		$days       = I('days');
		$line_id    = I('line_id');
		$num        = 0;
		
		//保存线路
		$isadd = M('op')->data(array('line_id'=>$line_id))->where(array('op_id'=>$opid))->save();
		if($isadd) $num++;

		//删除历史日程
		$del = M('op_line_days')->where(array('op_id'=>$opid))->delete();
		if($del) $num++;
		foreach($days as $v){
			 $data = array();
			 $data['op_id'] = $opid;
			 $data['citys']    =  $v['citys'];
			 $data['content']  =  $v['content'];
			 $data['remarks']  =  $v['remarks'];
			 $savein = M('op_line_days')->add($data);
			 if($savein) $num++;
		}	
		
		/*
		//剔除其他线路所带过来的物资
		$where_del = array();
		$where_del['line_id']   = array('gt',0);
		$where_del['line_id']   = array('neq',$line_id);
		$where_del['op_id']     = $opid;	
		$isdel = M('op_material')->where($where_del)->delete();
		if($isdel) $num++;
		
		//剔除其他线路所带过来的物资价格
		$where_del['cost_type'] = 4;	
		$isdel = M('op_cost')->where($where_del)->delete();
		if($isdel) $num++;
		
		//将线路中所包含的模块物资清单转入项目中
		$pdata = M('product_line_tpl')->where(array('line_id'=>$line_id,'type'=>1))->getField('pro_id',true);
		$where = array();
		$where['product_id'] = array('in',implode(',',$pdata));
		$list = M('product_material')->where($where)->select();
		
		//保存物资清单
		foreach($list as $v){
			
			//获取物资编号
			$mid = M('material')->where(array('material'=>$v['material']))->getField('id');
			
			$material = array();
			$material['op_id']       = $opid;
			$material['material']    = $v['material'];
			$material['remarks']     = $v['remarks'];
			$material['material_id'] = $mid;
			$material['line_id']     = $line_id;
			
			$cost = array();
			$cost['op_id']       = $opid;
			$cost['item']        = '物资费';
			$cost['cost']        = $v['unitprice'];
			$cost['amount']      = $v['amount'];
			$cost['total']       = $v['unitprice']*$v['amount'];
			$cost['cost_type']   = 4;
			$cost['remark']      = $v['material'];
			$cost['relevant_id'] = $mid;
			$cost['line_id']     = $line_id;
			
			//判断物资是否存在
			if(!M('op_material')->where(array('material'=>$v['material'],'op_id'=>$opid))->find()){
				$addmate = M('op_material')->add($material);
				$cost['link_id'] = $addmate;
				$addcost = M('op_cost')->add($cost);
			}
			
			if($addcost || $addmate) $num++;
		}
		*/
		 
		$record = array();
		$record['op_id']   = $opid;
		$record['optype']  = 3;
		$record['explain'] = '保存项目行程线路';
		op_record($record);	 
		
		echo $num;
	}

	// @@@NODE-3###public_ajax_line###获取线路日程###
	public function public_ajax_line(){
		$db = M('product_line_days');
		$line_id = I('id');
		$list = $db->where(array('line_id'=>$line_id))->select();
		if($list){
			foreach($list as $k=>$row){
			 	echo '<div class="daylist" id="task_a_'.$row['id'].'"><a class="aui_close" href="javascript:;" style="right:25px;" onClick="del_timu(\'task_a_'.$row['id'].'\')">×</a><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'.($k+1).'</span>天</strong></label><div class="input-group"><input type="text" placeholder="所在城市" name="days['.$row['id'].'][citys]" class="form-control" value="'.$row['citys'].'"></div><div class="input-group pads"><textarea class="form-control" placeholder="行程安排"  name="days['.$row['id'].'][content]">'.$row['content'].'</textarea></div><div class="input-group"><input type="text" placeholder="房餐车安排" name="days['.$row['id'].'][remarks]" value="'.$row['remarks'].'" class="form-control"></div></div></div>';	
			}
		}
		
	}

	// @@@NODE-3###public_ajax_material###获取模块物资信息###
	public function public_ajax_material(){
		$opid = I('id');
		$list = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.material=c.remark')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		
		foreach($list as $v){
			
			echo '<tr class="expense" id="wuzi_nid_'.$v['id'].'"><td><input type="hidden" name="cost['.(20000+$v['id']).'][item]" value="物资费"><input type="hidden" name="cost['.(20000+$v['id']).'][cost_type]" value="4"><input type="hidden" name="cost['.(20000+$v['id']).'][relevant_id]" value="'.$v['material_id'].'"><input type="hidden" name="cost['.(20000+$v['id']).'][remark]" value="'.$v['material'].'"><input type="hidden" name="resid['.(20000+$v['id']).'][id]" value="'.$v['id'].'"><input type="hidden" name="wuzi['.(20000+$v['id']).'][material]" value="'.$v['material'].'"><input type="hidden" name="wuzi['.(20000+$v['id']).'][material_id]" value="'.$v['material_id'].'">'.$v['material'].'</td><td><input type="text" name="cost['.(20000+$v['id']).'][cost]" value="'.$v['cost'].'" placeholder="价格" class="form-control min_input cost"></td><td><span>X</span></td><td><input type="text" name="cost['.(20000+$v['id']).'][amount]" value="'.$v['amount'].'" placeholder="数量" class="form-control min_input amount"></td><td class="total">¥'.($v['cost']*$v['amount']).'</td><td><input type="text" name="wuzi['.(20000+$v['id']).'][remarks]" value="'.$v['remarks'].'" class="form-control"></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'wuzi_nid_'.$v['id'].'\')">删除</a></td></tr>';
			
		}
		
	}

	// @@@NODE-3###select_product###选择产品模板###
	public function select_product(){

		$key          = I('key');
		$status       = I('status','-1');
		$kind         = I('kind','-1');
		$mdd          = I('mdd');

		$db = M('product_line');
		$this->status = $status;
		$this->kind   = $kind;
		$where = array();
		if($this->status != '-1') $where['audit_status'] = $this->status;
		if($this->kind != '-1')   $where['kind'] = $this->kind;
		if($key)    $where['title'] = array('like','%'.$key.'%');
		if($mdd)    $where['dest']  = array('like','%'.$mdd.'%');
		
		
        $page = new Page($db->where($where)->count(),25);
        $this->pages = $pagecount>25 ? $page->show():'';
		$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
		$this->kindlist = M('project_kind')->select();

		$this->display('select_product');
	}

    // @@@NODE-3###select_product###选择产品模块###
    public function select_module(){

        $opid         = I('opid');
        $key          = I('key');
        $type         = I('type');
        $subject_field= I('subject_field');
        $from         = I('from');
        $kind         = M('op')->where(array('op_id'=>$opid))->getField('kind');

        $db = M('product');
        $this->opid   = $opid;
        $where = array();
        $where['audit_status']      = 1;
        if($kind)   $where['business_dept']= $kind;
        if($key)    $where['title'] = array('like','%'.$key.'%');
        if ($type)  $where['type']  = array('eq',$type);
        if ($from)  $where['from']  = array('eq',$type);
        if ($subject_field)  $where['subject_field']  = array('eq',$subject_field);

        $pagecount   = $db->where($where)->count();
        $page        = new Page($pagecount,25);
        $this->pages = $pagecount>25 ? $page->show():'';
        $lists       = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();

        $ageval      = C('AGE_LIST');
        $reckon_mode = C('RECKON_MODE');
        foreach ($lists as $k=>$v){
            $agelist = array();
            $ages    = explode(',',$v['age']);

            foreach($ageval as $key=>$value){
                if (in_array($key,$ages)){
                    $agelist[] = $value;
                }
            }
            $lists[$k]['agelist']           = implode(',',$agelist);
            $lists[$k]['reckon_modelist']   = $reckon_mode[$v['reckon_mode']]?$reckon_mode[$v['reckon_mode']]:"<span class='red'>未定</span>";
            if (!$v['sales_price']) $lists[$k]['sales_price'] = '0.00';
        }

        $this->lists          = $lists;
        $this->product_type   = C('PRODUCT_TYPE');
        $this->subject_fields = C('SUBJECT_FIELD');
        $this->product_from   = C('PRODUCT_FROM');
        $this->ages           = C('AGE_LIST');
        $this->kindlist       = M('project_kind')->select();

        $this->display('select_product_module');

    }
	
	// @@@NODE-3###select_guide###选择导游辅导员###
	public function select_guide(){
		$kind = I('kind');
		$key  = I('key');
		$sex  = I('sex');
        $opid = I('opid');

        //求项目类型,根据项目类型计算出所选专家的价格
        $kid = M('op')->where(array('op_id'=>$opid))->getField('kind');

		$where = array();
		$where['1'] = priv_where(P::REQ_TYPE_GUIDE_RES_U);
		if($kind) $where['kind'] = $kind;
		if($key)  $where['name'] = array('like','%'.$key.'%');
		if($sex)  $where['sex']  = $sex;
		
		//分页
		$pagecount = M('guide')->where($where)->count();
		$page = new Page($pagecount,25);
		$this->pages = $pagecount>25 ? $page->show():'';
        
        $this->reskind = M('guidekind')->getField('id,name', true);
        $lists = M('guide')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        foreach($lists as $k=>$v){
            $gk_id  = $v['kind'];
            $price  = M('guide_price')->where(array('kid'=>$kid,'gk_id'=>$gk_id))->getField('price');
            //if($v['fee'] == '0.00') $v['fee'] = null;
            $lists[$k]['fee'] = $price;

        }
        $this->lists = $lists;
		
		$this->display('select_guide');
	}
	
	
	// @@@NODE-3###select_supplier###选择合格供方###
	public function select_supplier(){
		
		$kind = I('kind');
		$key  = I('key');
		
		$where = array();
		$where['1'] = priv_where(P::REQ_TYPE_SUPPLIER_RES_U);
		if($kind) $where['kind'] = $kind;
		if($key)  $where['name'] = array('like','%'.$key.'%');
		
		//分页
		$pagecount = M('supplier')->where($where)->count();
		$page = new Page($pagecount,25);
		$this->pages = $pagecount>25 ? $page->show():'';
        
        $this->reskind = M('supplierkind')->getField('id,name', true);
        $this->lists = M('supplier')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
		
		$this->display('select_supplier');
	}
    
	
	// @@@NODE-3###importuser###导入名单###
	public function importuser(){
		$time = time();
		if(isset($_POST['dosubmit'])){
			
			$data = array();
			
			$file = $_FILES["file"] ? $_FILES["file"] : $this->error('请提交要导入的文件！');	
			
			//获取文件扩展名
			$fileext = explode('.',$file["name"]);
			
			if($fileext[1]=='xls' || $fileext[1]=='xlsx'){
				if ($file["size"] < 10*1024*1024){
					if ($_FILES["file"]["error"] > 0){
						//报错
						$this->error($file["error"],I('referer',''));
					}else{
						
						//新文件名
						$newname = "upload/xls/".cookie('comid').'_'.date('YmdHis',time()).'.'.$fileext[1];
						
						//上传留存
						$ismove = move_uploaded_file($file["tmp_name"],$newname);	
						
						//读取EXCEL文件
						if($ismove) $data = importexcel($newname);
						$sum = count($data)-1;
						
						$this->data = $data;
						
						
					}
				}else{
					$this->error('文件大小不能超过10M！');	
				}
			}else{
				$this->error('请上传Excel文件！');	
			}
  			
			
		} 
		
		$this->display('importuser');
		
		
		
	}
	
	
	// @@@NODE-3###app_materials###申请物资###
	public  function  app_materials(){
		$opid = I('opid');
		
		if(!$opid) $this->error('出团计划不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$op         = M('op')->where($where)->find();
		$budget     = M('op_budget')->where($where)->find();
		$settlement = M('op_settlement')->where(array('op_id'=>$opid))->find();
		
		$matelist       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		foreach($matelist as $k=>$v){
			//获取物资库存
			$stock = M('material')->where(array('material'=>$v['material']))->find();	
			$matelist[$k]['stock']  = $stock['stock'] ?$stock['stock']:0;
			$matelist[$k]['stages'] = $stock['stages']?$stock['stages']:0;
			$matelist[$k]['lastcost'] = $stock ? $stock['price'] : '0.00';	
			
			$yichuku = $v['amount']-$v['outsum'];
			if($matelist[$k]['stock']<$yichuku){
				$matelist[$k]['status'] = $v['purchasesum'] ? '<span class="yellow">等待入库</span>' : '<span class="red">申请采购</span>';	
			}else{
				$matelist[$k]['status'] = $v['outsum'] ? '<span class="blue">完成出库</span>' : '<span class="green">申请出库</span>';		
			}
			
		}
		
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
		$this->op             = $op;
		$this->matelist       = $matelist;
		$this->budget         = $budget;
		$this->settlement     = $settlement;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->kinds          =  M('project_kind')->getField('id,name', true);
		$this->display('app_materials');
	}
	
	
	// @@@NODE-3###out_materials###申请物资###
	public  function  out_materials(){
		$opid = I('opid');
		
		//获取项目信息
		$where = array();
		$where['op_id'] = $opid;
		$op         = M('op')->where($where)->find();
		$budget     = M('op_budget')->where($where)->find();
		$roledet    = M('role')->where(array('role_name'=>$op['op_create_user']))->find();
		
		$ckinfo = array();
		$cginfo = array();
		
		
		//物资列表
		$matelist       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		foreach($matelist as $k=>$v){
			//获取物资库存
			$wz = M('material')->where(array('material'=>$v['material']))->find();	
			$stock    = $wz['stock']?$wz['stock']:0;
			$lastcost = $wz['price'] ? $wz['price'] : 0;	
			$wz_id = $wz['id'];
			
			
			/*处理出库*/
			$outrand = M('material_out')->where(array('op_id'=>$opid,'material'=>$v['material'],'audit_status'=>array('neq',2)))->sum('amount');
			$outsum = $v['amount']-$outrand;
			$daichuku = $outrand - $v['outsum'];
			$stock = $stock-$daichuku;
			if($outsum>0 && $stock>0){
				//申请出库
				$ckinfo[$k]['op_id']           = $opid;
				$ckinfo[$k]['material_id']     = $wz_id;
				$ckinfo[$k]['material']        = $v['material'];
				$ckinfo[$k]['unit_price']      = $lastcost;
				$ckinfo[$k]['order_id']        = $op['group_id'];
				$ckinfo[$k]['receive_liable']  = cookie('nickname');
				$ckinfo[$k]['out_time']        = time();
				if($stock>=$outsum){
					//如果库存充足，直接出库
					$ckinfo[$k]['amount']          = $outsum;
					$ckinfo[$k]['total']           = $outsum*$lastcost;	
				}else{
					//如果库存不够，申请部分出库
					$ckinfo[$k]['amount']          = $stock;
					$ckinfo[$k]['total']           = $stock*$lastcost;		
				}
			}
			
			
			/*处理采购*/
			$gourand = M('material_purchase')->where(array('op_id'=>$opid,'material'=>$v['material'],'audit_status'=>array('neq',2)))->sum('amount');
			$gousum = $v['amount']-$gourand-$outrand;
			$caigou = $gousum-$stock;
			if($stock < $gousum && $caigou>0){
				//申请采购
				$cginfo[$k]['op_id']           = $opid;
				$cginfo[$k]['material_id']     = $wz_id;
				$cginfo[$k]['material']        = $v['material'];
				$cginfo[$k]['unit_price']      = $v['cost'];
				$cginfo[$k]['order_id']        = $op['group_id'];
				$cginfo[$k]['department']      = $roledet['id'];
				$cginfo[$k]['create_time']     = time();
				$cginfo[$k]['amount']          = $caigou;
				$cginfo[$k]['total']           = $caigou*$v['cost'];	
				$cginfo[$k]['op_user']         = $op['create_user_name'];	
			}
			
		}
		
		
		$opnum = 0;
		if(count($ckinfo)){
			//申请出库
			$ck = array();
			$ck['type']            = 0;
			$ck['order_id']        = $op['group_id'];
			$ck['receive_liable']  = cookie('nickname');
			$ck['op_id']           = $opid;
			$ck['name']            = $op['project'];
			$ck['out_time']        = time();
			$ck['app_user']        = cookie('nickname');
			$batch_id = M('material_out_batch')->add($ck);
			if($batch_id){
				$this->request_audit(P::REQ_TYPE_GOODS_OUT, $batch_id);
				foreach($ckinfo as $v){
					$info = array();
					$info = $v;
					$info['batch_id'] = $batch_id;
					M('material_out')->add($info);
				}	
				$opnum++;
			}
		}
		
		if(count($cginfo)){
			
			//采购备注
			$proid = M()->table('__PRODUCT_LINE_TPL__ as t')->join('__OP__ as o on o.line_id = t.line_id')->where(array('o.op_id'=>$opid,'t.type'=>1))->GetField('pro_id',true);
			
			//申请采购
			$cg = array();
			$cg['op_id']           = $opid;
			$cg['order_id']        = $op['group_id'];
			$cg['name']            = $op['project'];
			$cg['department']      = $roledet['id'];
			$cg['create_time']     = time();
			$cg['app_user']        = cookie('nickname');
			$cg['op_user']         = $op['create_user_name'];
			$batch_id = M('material_purchase_batch')->add($cg);
			if($batch_id){
				$this->request_audit(P::REQ_TYPE_GOODS_PURCHASE, $batch_id);
				foreach($cginfo as $v){
					$info = array();
					$info = $v;
					$info['batch_id'] = $batch_id;
					//采购信息
					$wzcg = M('product_material')->where(array('material'=>$info['material'],'product_id'=>array('in',implode(',',$proid))))->find();
					if($wzcg){
						$info['unit_price'] = $wzcg['unitprice'];
						$info['total'] = $wzcg['unitprice']*$v['amount'];
						$info['remarks'] = $wzcg['channel'];
					}
					M('material_purchase')->add($info);
				}	
				$opnum++;
			}
		}
		
		if($opnum){
			M('op')->data(array('app_material_time'=>time()))->where(array('op_id'=>$opid))->save();	
		}
		
		echo $opnum;
		
		
	}
	
	
	
	// @@@NODE-3###revert_materials###归还物资###
	public  function  revert_materials(){
		$opid = I('opid');
		
		$matelist       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where(array('m.op_id'=>$opid,'c.op_id'=>$opid,'c.cost_type'=>4))->order('m.id')->select();
		foreach($matelist as $k=>$v){
			//获取物资库存
			$stock = M('material')->where(array('material'=>$v['material']))->find();	
			$matelist[$k]['stock']  = $stock['stock'] ?$stock['stock']:0;
			$matelist[$k]['stages'] = $stock['stages']?$stock['stages']:0;
			$matelist[$k]['lastcost'] = $stock ? $stock['price'] : 0;	
		}
		
		$this->matelist       = $matelist;
		$this->kinds          =  M('project_kind')->getField('id,name', true);
		$this->display('revert_materials');
	}
	
	
	// @@@NODE-3###select_material###调度物资###
	public  function  select_material(){
		//物料关键字
		$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
		if($key) $this->keywords =  json_encode($key);
		$this->material = M('material')->select();
		$this->display('select_material');
	}
	
	
	
	public function public_checkname_ajax(){
		$group_id = I('gid',0);
		
		//判断会员是否存在
		$db = M('op');
		if($db->where(array('group_id'=>$group_id))->find()) {
			exit('0');
		}else {
			exit('1');
		}	
	}
	
	
	
	// @@@NODE-3###delpro###删除项目###
    public function delpro(){
        $this->title('删除项目');
		
        $id = I('id', -1);
		
		$op = M('op')->find($id);
		if($op &&( cookie('roleid')==10 || cookie('roleid')==1)){
			$opid = $op['op_id'];
			//删除项目相关信息
			M('op_auth')->where(array('op_id'=>$opid))->delete();
			M('op_budget')->where(array('op_id'=>$opid))->delete();
			M('op_cost')->where(array('op_id'=>$opid))->delete();
			M('op_costacc')->where(array('op_id'=>$opid))->delete();
			M('op_guide')->where(array('op_id'=>$opid))->delete();
			M('op_line_days')->where(array('op_id'=>$opid))->delete();
			M('op_material')->where(array('op_id'=>$opid))->delete();
			M('op_partake')->where(array('op_id'=>$opid))->delete();
			M('op_pretium')->where(array('op_id'=>$opid))->delete();
			M('op_record')->where(array('op_id'=>$opid))->delete();
			M('op_settlement')->where(array('op_id'=>$opid))->delete();
			M('op_supplier')->where(array('op_id'=>$opid))->delete();
			M('order')->where(array('op_id'=>$opid))->delete();
            M('guide_pay')->where(array('op_id'=>$opid))->delete();
            M('op_guide_price')->where(array('op_id'=>$opid))->delete();
            M('op_team_confirm')->where(array('op_id'=>$opid))->delete();
            M('op_guide_confirm')->where(array('op_id'=>$opid))->delete();
            M('op_res')->where(array('op_id'=>$opid))->delete();        //资源需求单
            M('op_design')->where(array('op_id'=>$opid))->delete();     //委托设计工作交接单
            M('op_work_plans')->where(array('op_id'=>$opid))->delete(); //业务实施计划单
            M('worder')->where(array('op_id'=>$opid))->delete();        //项目工单

			//删除主项目
			M('op')->delete($id);
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！：' . $db->getError());	
		}
    }
	
	
	//排课
	public function course(){
		$op_id    = I('opid');
		$guide_id = I('id');
		
		//判断项目是否已结算
		$jiesuan = M('op_settlement')->where(array('op_id'=>$op_id))->find();
		
		$this->op_id     = $op_id;
		$this->guide_id  = $guide_id;
		$this->jiesuan   = $jiesuan['audit_status'] ? $jiesuan['audit_status'] : 0;
		$this->display('course');	
	}
 	
	//排课详情
	public function courselist(){
		
		$op_id    = I('get.opid');
		$guide_id = I('get.id');

		$rows = M('op_course')->where(array('op_id'=>$op_id,'guide_id'=>$guide_id))->select();
		$data = array();
		foreach($rows as $k =>$v){
			$data[$k]['id']  = $v['id'];
			$data[$k]['task'] = $v['userid'];
			$data[$k]['builddate'] = $v['coures_date'];
		}
		echo json_encode($data);
	}
	
	
	//排课详情
	public function addcourse(){
		
		$op_id    = I('op_id');
		$guide_id = I('guide_id');
		$date     = I('date');
		
		$info = array();
		$info['op_id']    = $op_id;
		$info['guide_id'] = $guide_id;
		$info['coures_date'] = $date;
		$info['userid'] = cookie('userid'); 
				
		$add = M('op_course')->add($info);
		if($add){
			echo $add;	
		}else{
			echo 0;	
		}
		
	}
	
	
	//删除课程
	public function delcourse(){
		$id = I('id');	
		$course = M('op_course')->find($id);
		//if($course && $course['userid'] == cookie('userid')){
			$del = M('op_course')->where(array('id'=>$id))->delete();
			if($del){
				echo 1;	
			}else{
				echo 0;	
			}
		//}else{
		//	echo 0;	
		//}
	}

	// @@@NODE-3###confirm###出团确认###
	public  function confirm(){
		$opid = I('opid');
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		$op				= M('op')->where($where)->find();
		$confirm		= M('op_team_confirm')->where($where)->find();
        $upd_num        = $confirm['upd_num'];

		if(isset($_POST['dosubmit']) && $_POST['dosubmit']){

			$info	    = I('info');
            $data       = I('data');

			//判断团号是否可用
			$where = array();
			$where['group_id']	= $info['group_id'];
			$where['op_id']		= array('neq',$opid);
			$check				= M('op')->where($where)->find();
			if($check)  $this->error($info['group_id'].'团号已存在');	 

			$info['op_id']			= $opid;
            $info['group_id']       = trim($info['group_id']);
			$info['user_id']		= cookie('userid'); 
			$info['user_name']		= cookie('nickname'); 
			$info['dep_time']		= $info['dep_time'] ? strtotime($info['dep_time']) : 0;
			$info['ret_time']		= $info['ret_time'] ? strtotime($info['ret_time']) : 0;
			$info['confirm_time']	= time();
			//判断是否已经确认
			if($confirm){
                if($upd_num == 1){
                    $this->error('您已经修改过一次了,不能反复修改!');
                }else{
                    $info['upd_num']    = 1;    //用来判断修改次数
                    $res = M('op_team_confirm')->data($info)->where(array('op_id'=>$opid))->save();
                }
			}else{
                $op_info            = array();
                $op_info['type']    = 1;
                M('op')->where(array('op_id'=>$opid))->save($op_info);
				$res = M('op_team_confirm')->add($info);
			}

			if ($res) {
                //如果是内部地接, 生成一个新地接团
                if ($op['in_dijie'] == 1 && !$op['dijie_opid']) {
                    $new_op             = array();
                    $project            = '【地接团】'.$op['project'];
                    $new_op['project']  = str_replace('【发起团】','',$project);
                    $new_op['op_id']    = opid();
                    $gtime              = $info['dep_time']?$info['dep_time']:time();
                    $groupid            = $op['dijie_name'].date('Ymd',$gtime);
                    //团号信息
                    $count_groupids     = M('op')->where(array('group_id'=>array('like','%'.$groupid.'%')))->count();
                    $new_op['group_id'] = $count_groupids?$groupid.'-'.$count_groupids:$groupid;
                    $new_op['number']       = $op['number'];
                    $new_op['departure']    = $op['departure'];
                    $new_op['days']         = $op['days'];
                    $new_op['destination']  = $op['destination'];
                    $new_op['create_time']  = NOW_TIME;
                    $new_op['status']       = 1; //已成团
                    $new_op['context']      = '地接项目';
                    $new_op['audit_status'] = 1; //默认审核通过
                    $new_op['create_user']  = C('DIJIE_CREATE_USER')[$op['dijie_name']];
                    $new_op['create_user_name'] = M('account')->where(array('id'=>$new_op['create_user']))->getField('nickname');
                    $new_op['kind']         = $op['kind'];
                    $new_op['sale_user']    = $new_op['create_user_name'];
                    $group                  = M('op')->where(array('op_id'=>$opid))->getField('group_id');
                    $group                  = strtoupper(substr($group,0,4));
                    $arr_group              = array('JQXN','JQXW','JWYW');
                    if (in_array($group,$arr_group)){
                        $new_op['customer'] = '北京总部';
                    }else{
                        $new_op['customer'] = C('DIJIE_NAME')[$group];
                    }
                    $new_op['op_create_date'] = date('Y-m-d',time());
                    $new_op['op_create_user'] = M()->table('__ACCOUNT__ as a')->join('left join __ROLE__ as r on r.id = a.roleid')->where(array('a.id'=>$new_op['create_user']))->getField('r.role_name');
                    $new_op['apply_to']       = $op['apply_to'];
                    $new_op['type']           = 1; //1=>已成团, (所有的费用带入系统预算)

                    //地接成团确认
                    $dijie_confirm            = array();
                    $dijie_confirm['op_id']   = $new_op['op_id'];
                    $dijie_confirm['group_id']= $new_op['group_id'];
                    $dijie_confirm['dep_time']= $confirm['dep_time'];
                    $dijie_confirm['ret_time']= $confirm['ret_time'];
                    $dijie_confirm['num_adult']     = $confirm['num_adult'];
                    $dijie_confirm['num_children']  = $confirm['num_children'];
                    $dijie_confirm['days']          = $confirm['days'];
                    $dijie_confirm['user_id']       = $new_op['create_user'];
                    $dijie_confirm['user_name']     = $new_op['user_name'];
                    $dijie_confirm['confirm_time']  = NOW_TIME;
                    $opres = M('op')->add($new_op);
                    if ($opres) {
                        M('op_team_confirm')->add($dijie_confirm);
                        $data = array();
                        $data['hesuan'] = $new_op['create_user'];
                        $auth = M('op_auth')->where(array('op_id'=>$new_op['op_id']))->find();

                        if($auth){
                            M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
                        }else{
                            $data['op_id'] = $new_op['op_id'];
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

                        $record                 = array();
                        $record['op_id']        = $new_op['op_id'];
                        $record['optype']       = 4;
                        $record['explain']      = '创建地接项目并成团';
                        op_record($record);
                    }

                }

                $infos = array();
                if ($new_op['op_id']){
                    $infos['dijie_opid']= $new_op['op_id'];
                }
                $infos['group_id']	    = $info['group_id'];
                $infos['status']		= 1;
                M('op')->data($infos)->where(array('op_id'=>$opid))->save();

                $record                 = array();
                $record['op_id']        = $opid;
                $record['optype']       = 4;
                $record['explain']      = '成团确认';
                op_record($record);

                //给教务组长 roleid  102
                $uid     = cookie('userid');
                $title   = '您有来自'.$op['create_user_name'].'的团号为['.$info['group_id'].']的团待安排专家辅导员!';
                $content = '项目编号:'.$op['op_id'].'；团号:'.$info['group_id'].';请登录"辅导员/教师、专家管理系统完成相关操作(如其他同事已完成操作,请忽略)!"';
                $url     = 'http://tcs.kexueyou.com/op.php?m=Main&c=Task&a=detail&id='.$op['id'];
                $user    = '';
                $roleid  = 102; //教务组长
                send_msg($uid,$title,$content,$url,$user,$roleid);

                $this->success('保存成功！');
            }else{
                $this->error('保存信息失败');
            }
		}else{

            $this->op		    = $op;
            $this->kinds	    = M('project_kind')->getField('id,name', true);
            $this->guide_kind   = M('guidekind')->getField('id,name',true);
            //获取职能类型
            $priceKind          = M()->table('__GUIDE_PRICEKIND__ as gpk')->field('gpk.id,gpk.name')->join('left join __OP__ as op on gpk.pk_id = op.kind')->where(array("op.op_id"=>$opid))->select();
            $this->price_kind   = $priceKind;
            $this->fields       = C('GUI_FIELDS');
            $jiesuan            = M('op_settlement')->where(array('op_id'=>$opid,'audit_status'=>1))->find(); //结算审批通过
            $this->jiesuan      = $jiesuan;
            $resource           = M('op_res')->where(array('op_id'=>$opid))->find();
            $this->resource     = $resource;
            if ($resource) {
                $this->rad          = 1;
                $this->task_fields  = explode(',',$resource['task_field']);
                $this->act_needs    = explode(',',$resource['act_need']);
                $this->men          = M('account')->field('id,nickname')->where(array('id'=>$resource['exe_user_id']))->find();
            }

            //辅导员/教师、专家
            $guide_price        = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('c.id as cid,c.*,p.id as pid,p.*')->join('left join __OP_GUIDE_PRICE__ as p on p.confirm_id = c.id')->where(array('c.op_id'=>$opid,'p.op_id'=>$opid))->select();
            foreach ($guide_price as $k=>$v){
                //职务信息
                foreach ($this->guide_kind as $key=>$value){
                    if ($v['guide_kind_id'] == $key){
                        $guide_price[$k]['zhiwu'] = $value;
                    }
                }

                //所属领域
                foreach ($this->fields as $key=>$value){
                    if ($v['field'] == $key){
                        $guide_price[$k]['lingyu'] = $value;
                    }
                }
            }
            $this->guide_price  = $guide_price;

            //项目跟进时提出的需求信息
            $this->guide_need   = M('op_guide_price')->where(array('op_id'=>$opid))->select();

            //人员名单关键字
            $this->userkey      = get_username();
            //科普资源关键字
            $this->scienceRes   = getScienceRes();

            //人员列表
            $stu_list       = M('op_member')->where(array('op_id'=>$opid))->select();
            $member         = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
            $this->member   = $member;
            $this->stu_list = $stu_list;
			$this->confirm 	= $confirm;
            $this->upd_num  = $confirm['upd_num'];
            $this->op_kind  = $op['kind'];
            $this->act_need = C('ACT_NEED');
            $this->task_field = C('LES_FIELD');
            $this->apply_to = C('APPLY_TO');
            $this->design   = M('op_design')->where(array('op_id'=>$opid))->find();    //委托设计工作交接单
            $work_plan          = M('op_work_plans')->where(array('op_id'=>$opid))->find();//业务实施计划单
            $this->work_plan= $work_plan;
            $this->additive = explode(',',$work_plan['additive']);
            $this->plan_between_time = $work_plan['begin_time']?date('Y-m-d',$work_plan['begin_time']).' - '.date('Y-m-d',$work_plan['end_time']):'';
            $this->plan_lists = M('op_work_plan_lists')->where(array('plan_id'=>$work_plan['id']))->select();

            $this->user_info= M()->table('__OP__ as o')
                ->field('a.*,d.department,o.create_user_name')
                ->join('__ACCOUNT__ as a on a.id = o.create_user')
                ->join('__SALARY_DEPARTMENT__ as d on d.id = a.departmentid')
                ->where(array('o.op_id'=>$opid))
                ->find();
            $this->output_info = array(
                '1'=>'出片打样',
                '2'=>'喷绘',
                '3'=>'只提供电子文件'
            );
            $this->audit_status = array (
                P::AUDIT_STATUS_NOT_AUDIT  => '<span class="yellow">未审核</span>',
                P::AUDIT_STATUS_PASS       => '<span class="green">审核通过</span>',
                P::AUDIT_STATUS_NOT_PASS   => '<span class="red">未通过</span>',
            );
            $this->additive = explode(',',$work_plan['additive']);
            $additive_con   = array(
                '1'         => '行程或方案',
                '2'         => '需解决大交通的《人员信息表》',
                '3'         => '其他'
            );
            $this->additive_con = $additive_con;

			$this->display('confirm');
		}
	}



    // @@@NODE-3###change_op###项目交接###
    public function change_op(){
        if (isset($_POST['dosubmit'])) {
            $op_id                  = I('opid');
            $info                   = I('info');
            if ($info['create_user']){
                $info['sale_user']      = $info['create_user_name'];
                $info['op_create_user'] = M()->table('__ACCOUNT__ as a')->join('__ROLE__ as r on r.id = a.roleid','left')->where(array('a.id'=>$info['create_user']))->getField('r.role_name');
                $res = M('op')->where(array('op_id'=>$op_id))->save($info);
                if ($res){
                    $data = array();
                    $data['hesuan'] = $info['create_user'];
                    $auth = M('op_auth')->where(array('op_id'=>$op_id))->find();

                    if($auth){
                        M('op_auth')->data($data)->where(array('id'=>$auth['id']))->save();
                    }else{
                        $data['op_id'] = $op_id;
                        M('op_auth')->add($data);
                    }

                    $record                 = array();
                    $record['op_id']        = $op_id;
                    $record['optype']       = 4;
                    $record['explain']      = '项目交接给'.$info['create_user_name'].'';
                    op_record($record);

                    $this->msg = '操作成功!';
                }else{
                    $this->msg = '操作失败!';
                }
            }else{
                $this->msg = '人员信息错误!';
            }
            $this->display('audit_ok');
        }else{
            //人员名单关键字
            $user       = M('account')->field("id,nickname")->where(array('status'=>0))->select();
            $user_key   = array();
            foreach($user as $k=>$v){
                $text                   = $v['nickname'];
                $user_key[$k]['id']     = $v['id'];
                $user_key[$k]['pinyin'] = strtopinyin($text);
                $user_key[$k]['text']   = $text;
            }
            $this->userkey  = json_encode($user_key);

            $this->opid = I('opid');
            $this->display();
        }
    }

    // @@@NODE-3###res_feedback###资源配置情况反馈###
    public function res_feedback(){
        $op_id              = I('opid');
        $op                 = M('op')->where(array('op_id'=>$op_id))->find();
        $this->op           = $op;
        $resource           = M('op_res')->where(array('op_id'=>$op_id))->find();
        $this->op_kind      = $op['kind'];
        $this->resource     = $resource;
        $this->act_need     = C('ACT_NEED');
        $this->task_field   = C('LES_FIELD');
        if ($resource) {
            $this->rad          = 1;
            $this->task_fields  = explode(',',$resource['task_field']);
            $this->act_needs    = explode(',',$resource['act_need']);
            $this->men          = M('account')->field('id,nickname')->where(array('id'=>$resource['exe_user_id']))->find();
        }

        //人员名单关键字
        $this->userkey      = get_username();
        $this->audit_status = array (
            P::AUDIT_STATUS_NOT_AUDIT  => '<span class="yellow">未审核</span>',
            P::AUDIT_STATUS_PASS       => '<span class="green">审核通过</span>',
            P::AUDIT_STATUS_NOT_PASS   => '<span class="red">未通过</span>',
        );

        $this->display();
    }
	
	
	// @@@NODE-3###relpricelist###项目比价记录###
    public function relpricelist(){
        $this->title('项目比价记录');
		
		$db		= M('rel_price');
		$kinds	= C('REL_TYPE');
		
		$title	= I('title');		//项目名称
		$opid	= I('opid');			//项目编号
		$op		= I('op');			//计调
		$type 	= I('type');
		
		$where = array();
		
		if($title)			$where['business_name']			= array('like','%'.$title.'%');
		if($op)				$where['op_user_name']			= array('like','%'.$op.'%');
		if($opid)			$where['op_id']					= $opid;
		if($type)			$where['type']					= $type;
		
		//分页
		$pagecount		= $db->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        
       
		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['kinds'] 			= $kinds[$v['type']];	
			$lists[$k]['create_time'] 	= date('Y-m-d H:i:s',$v['create_time']);
		}
		
		
		$this->lists   		=  $lists;  
		$this->kinds 		= C('REL_TYPE');
		$this->opid 			= $opid;
		$this->type 			= $type;
		$this->display('relpricelist');
    }
	
	
	// @@@NODE-3###confirm###项目比价###
	public  function relprice(){
		$opid 			= I('opid');
		$relid			= I('relid');
		$type 			= I('type');
		$op				= M('op')->where(array('op_id'=>$opid))->find();
	
		
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$info		= I('info');
			$com		= I('com');
			$reid 		= I('reid');
			
			$info['op_user_id']		= cookie('userid');
			$info['op_user_name']	= cookie('name');
			
			//保存主表
			if($reid){
				M('rel_price')->where(array('id'=>$reid))->data($info)->save();	
			}else{
				$info['create_time']		= time();
				$reid = M('rel_price')->add($info);	
			}
			
			
			
			$coms = array();
			$list = array();
			
			foreach($com as $k=>$v){
				//保存比价单位
				$cominfo = array();
				$cominfo['rel_id']			= $reid;
				$cominfo['op_id']			= $info['op_id'];
				$cominfo['company']			= $v['company'];
				$cominfo['contacts']			= $v['contacts'];
				$cominfo['contacts_tel']		= $v['contacts_tel'];
				$cominfo['contacts_email']	= $v['contacts_email'];
				$cominfo['checkout']			= 0;//isqual($v['company']);
				if($v['comid']){
					M('rel_price_com')->where(array('id'=>$v['comid']))->data($cominfo)->save();	
					$comid 		= $v['comid'];
					$coms[] 	= $v['comid'];
				}else{
					$comid 		= M('rel_price_com')->add($cominfo);	
					$coms[] 	= $comid;
				}
				
				//保存比价项目		
				foreach($v['info'] as $kk=>$vv){
					$termlist = array();
					$termlist['op_id'] 			= $info['op_id'];
					$termlist['rel_id'] 			= $reid;	
					$termlist['rel_com_id']		= $comid;	
					$termlist['term'] 			= $vv['term'];	
					$termlist['term_standard']	= $vv['term_standard'];	
					$termlist['price'] 			= $vv['price'];	
					if($vv['id']){
						M('rel_price_list')->where(array('id'=>$vv['id']))->data($termlist)->save();	
						$list[]	= $vv['id'];
					}else{
						$list[]	= M('rel_price_list')->add($termlist);
					}
					
				}	
					
			}
			
			//清除已删除单位和项目
			$where = array();
			$where['rel_id'] 	= $reid;
			$where['id'] 		= array('not in',implode(',',$coms));
			M('rel_price_com')->where($where)->delete();
			
			$where = array();
			$where['rel_id'] 	= $reid;
			$where['id'] 		= array('not in',implode(',',$list));
			M('rel_price_list')->where($where)->delete();
			
			$this->success('保存成功！',I('referer',''));
		
		}else{
			
			if($relid){
				$rel = M('rel_price')->find($relid);
				$com = M('rel_price_com')->where(array('rel_id'=>$relid))->select();
				foreach($com as $k=>$v){
					$com[$k]['info'] = M('rel_price_list')->where(array('rel_id'=>$relid,'rel_com_id'=>$v['id']))->select();
				}
			}
			
			$this->kinds 		= C('REL_TYPE');
			$this->b_name		= $rel['business_name'] ? $rel['business_name'] : $op['project'];
			$this->op_id		= $rel['op_id'] ? $rel['op_id'] : $opid;
			$this->vtype 		= $rel['type'] ? $rel['type'] : $type;
			$this->op 			= $op;
			$this->rel			= $rel;
			$this->com 			= $com;
			$this->display('relprice');
		}
	}
	
	

	// @@@NODE-3###delrel###删除项目比价###
    public function delrel(){
		
		$relid	= I('relid');
		M('rel_price')->where(array('id'=>$relid))->delete();
		M('rel_price_com')->where(array('rel_id'=>$relid))->delete();
		M('rel_price_list')->where(array('rel_id'=>$relid))->delete();
		
		$this->success('删除成功！');
		
    }
	
	
	
	// @@@NODE-3###evaluate###项目评价###
    /*public function evaluate(){
		
		$opid = I('opid');
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		$op				= M('op')->where($where)->find();
		
		
		if(isset($_POST['dosubmit']) && $_POST['dosubmit']){
			
			$info	= I('info');
			
			if(!$info[1]['evaluate']) 	$this->error('产品评价内容不能为空！');
            if(!$info[2]['evaluate']) 	$this->error('计调评价内容不能为空！');
            if(!$info[3]['evaluate']) 	$this->error('资源评价内容不能为空！');
            if(!$info[4]['evaluate']) 	$this->error('物资评价内容不能为空！');
			
			//保存
			foreach($info as $k=>$v){
				
				$data = array();
				$data['op_id']			= $v['op_id'];
				$data['eval_type']		= $v['eval_type'];
				$data['liable_uid']		= $v['liable_uid'];
				$data['liable_uname']	= $v['liable_uname'];
				$data['score']			= $v['score'];
				$data['evaluate']		= $v['evaluate'];
				$data['eval_uid']		= cookie('userid');
				$data['eval_uname']		= cookie('name');
				$data['eval_time']		= time();
				
				$eval = M('op_eval')->where(array('op_id'=>$v['op_id'],'eval_type'=>$v['eval_type']))->find();
				if($eval){
					M('op_eval')->data($data)->where(array('op_id'=>$v['op_id'],'eval_type'=>$v['eval_type']))->save();
				}else{
					M('op_eval')->add($data);
				}	
			}
			
			
			$this->success('保存成功！');
		
		}else{
			
			$this->kinds	= M('project_kind')->getField('id,name', true);
			$this->op		= $op;
            $member         = M('op_member')->where(array('op_id'=>$opid))->order('id')->select();
            $this->member   = $member;
			
			$auth = M('op_auth')->where(array('op_id'=>$opid))->find();
			//获取产品负责人信息
			
			$cp['uid'] 		= '';
			$cp['uname'] 	= '';
			
			//获取计调负责人信息
			$jd['uid'] 		= $auth['line'];
			$jd['uname'] 	= username($auth['line']);
			
			//获取物资负责人信息
			$wz['uid'] 		= $auth['res'];
			$wz['uname'] 	= username($auth['res']);
			
			//获取资源负责人信息
			$zy['uid'] 		= $auth['material'];
			$zy['uname'] 	= username($auth['material']);
			
			$this->cp 		= $cp;
			$this->jd 		= $jd;
			$this->wz 		= $wz;
			$this->zy 		= $zy;
			
			
			$this->cpv 		= M('op_eval')->where(array('op_id'=>$opid,'eval_type'=>1))->find();
			$this->jdv 		= M('op_eval')->where(array('op_id'=>$opid,'eval_type'=>2))->find();
			$this->zyv 		= M('op_eval')->where(array('op_id'=>$opid,'eval_type'=>3))->find();
			$this->wzv 		= M('op_eval')->where(array('op_id'=>$opid,'eval_type'=>4))->find();
			
			$this->cps 		= $this->cpv ? $this->cpv['score'] : 100;
			$this->jds 		= $this->jdv ? $this->jdv['score'] : 100;
			$this->zys 		= $this->zyv ? $this->zyv['score'] : 100;
			$this->wzs 		= $this->wzv ? $this->wzv['score'] : 100;
			
			$this->confirm 	= $confirm; 
			$this->display('evaluate');
		}
		
    }*/
    public function evaluate(){
        $opid               = I('opid');

        //计调人员人员信息(对计调人员人员评分)
        $score_data         = $this->get_score_user($opid);
        $this->op           = M('op')->where(array('op_id'=>$opid))->find();
        $this->jidiao       = $score_data['jidiao'];
        $pingfen            = $score_data['pingfen'];
        if ($pingfen['ysjsx']){ $this->pingfen = json_encode($pingfen); };

        $this->display();
    }

    //修改辅导员需求信息
    public function edit_tcs_need(){
        $confirm_id     = I('confirm_id');
        $price_id       = I('price_id');

        $opid               = I('opid');
        $this->opid         = $opid;
        $this->guide_kind   = M('guidekind')->getField('id,name',true);
        //获取职能类型
        $priceKind          = M()->table('__GUIDE_PRICEKIND__ as gpk')->field('gpk.id,gpk.name')->join('left join __OP__ as op on gpk.pk_id = op.kind')->where(array("op.op_id"=>$opid))->select();
        $this->price_kind   = $priceKind;
        $this->fields       = C('GUI_FIELDS');
        $this->display();
    }

    //销售人员系数配置
    public function saleConfig(){
        $year               = I('year',date('Y'));
        $yearTime           = array();

        $department_ids     = C('YW_DEPARTS');
        $departments        = M('salary_department')->field('id,department')->where(array('id'=>array('in',$department_ids)))->select();
        $sale_configs       = M('sale_config')->where(array('year'=>$year))->select();
        foreach ($departments as $k=>$v){
            foreach ($sale_configs as $key=>$value){
                if ($value['department_id']==$v['id']){
                    $departments[$k]['January']         = $value['January'];
                    $departments[$k]['February']        = $value['February'];
                    $departments[$k]['March']           = $value['March'];
                    $departments[$k]['April']           = $value['April'];
                    $departments[$k]['May']             = $value['May'];
                    $departments[$k]['June']            = $value['June'];
                    $departments[$k]['July']            = $value['July'];
                    $departments[$k]['August']          = $value['August'];
                    $departments[$k]['September']       = $value['September'];
                    $departments[$k]['October']         = $value['October'];
                    $departments[$k]['November']        = $value['November'];
                    $departments[$k]['December']        = $value['December'];
                }
            }
        }

        $this->year 	    = $year;
        $this->prveyear	    = $year-1;
        $this->nextyear	    = $year+1;
        $this->departments  = $departments;
        $this->display();
    }

    //配置销售人员系数
    public function sale_config_edit(){
        $db                 = M('sale_config');
        if (isset($_POST['dosubmint'])){
            $info                       = I('info');
            $info['year']               = trim(I('year'));
            $info['department_id']      = trim(I('department_id'));
            $data                       = $db->where(array('department_id'=>$department_id,'year'=>$year))->find();
            if ($data){
                $res                    = $db->where(array('id'=>$data['id']))->save($info);
            }else{
                $res                    = $db->add($info);
            }
            echo "<script>window.top.location.reload();</script>";
        }else{
            $id                         = trim(I('id'));
            $year                       = trim(I('year'));
            if ($id && $year){
                $where                  = array();
                $where['year']          = $year;
                $where['department_id'] = $id;
                $department             = M('salary_department')->field('id,department')->where(array('id'=>$id))->find();
                $list                   = $db->where($where)->find();
                $this->year             = $year;
                $this->list             = $list;
                $this->department       = $department;
                $this->display();
            }else{
                $this->error('获取信息失败');
            }
        }
    }

    //对研发经理评价(每月评分一次)
    public function satisfaction(){
        $account_name                   = trim(I('uname'));
        $input_username                 = trim(I('input_name'));
        $monthly                        = I('month');
        $has_rd                         = $this->has_research_and_development();    //查询评分人所在的部门是否有研发
        $db                             = M('satisfaction');
        $where                          = array();
        $user_ids                       = array(1,11,12,32,38);   //乔,王,杨,秦 id
        $where['type']                  = 1; //评价研发
        if (in_array(cookie('userid'),$user_ids)){
            if ($account_name) $where['account_name'] = array('like','%'.$account_name.'%');
        }else{
            $where['account_id']        = cookie('userid');
        }
        if ($monthly) $where['monthly'] = $monthly;

        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('create_time'))->select();
        $this->lists                    = $lists;
        $this->has_rd                   = $has_rd;
        $this->display();
    }

    //增加评分信息
    public function satisfaction_add(){
        if (isset($_POST['dosubmint']) && $_POST['dosubmint']){
            $db                         = M('satisfaction');
            $info                       = I('info');
            $info['has_rd']             = I('has_rd');
            $info['content']            = trim(I('content'));
            $info['monthly']            = trim(I('monthly'));
            $info['input_userid']       = cookie('userid');
            $info['input_username']     = cookie('nickname');
            $info['create_time']        = NOW_TIME;
            $info['type']               = 1; //对研发评分
            $where                      = array();
            $where['input_userid']      = $info['input_userid'];
            $where['monthly']           = $info['monthly'];
            $list                       = $db->where($where)->find();
            if ($list){
                $this->error('您已经完成当月的评分',U('Op/satisfaction'));
            }else{
                $res                    = $db->add($info);
                if ($res){
                    $this->success('数据保存成功',U('Op/satisfaction'));
                }else{
                    $this->error('数据保存失败');
                }
            }
        }else{
            $has_rd                     = $this->has_research_and_development();    //查询评分人所在的部门是否有研发
            $this->has_rd               = $has_rd;
            $this->display();
        }
    }

    //详情页
    public function satisfaction_detail(){
        $has_rd                         = $this->has_research_and_development();    //查询评分人所在的部门是否有研发
        $id                             = trim(I('id'));
        $db                             = M('satisfaction');
        $list                           = $db->where(array('id'=>$id))->find();

        $this->has_rd                   = $has_rd;
        $this->list                     = $list;
        $this->display();
    }

    private function has_research_and_development(){
        $user_id                        = session('userid');
        $has_rd_departments             = array('6');       //有自己研发的部门 6=>京区业务中心
        $userinfo                       = M('account')->where(array('id'=>$user_id))->find();
        if (in_array($userinfo['departmentid'],$has_rd_departments)){
            $has_rd                     = 1;
        }else{
            $has_rd                     = 0;
        }
        return $has_rd;
    }

    public function del_satisfaction(){
        $db                             = M('satisfaction');
        $id                             = trim(I('id'));
        if ($id){
            $res                        = $db->where(array('id'=>$id))->delete();
            if ($res){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('删除失败');
        }
    }

}