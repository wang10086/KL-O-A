<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class InspectController extends BaseController{
	
	// @@@NODE-3###record###巡检记录###
    public function record(){
		
		
        $this->title('品控巡检记录');
		
		$db		= M('inspect');
		
		
		$title		= I('title');		//项目名称
		$type 		= I('type');
		$id 			= I('id');
		$uname  		= I('uname');
		$rname  		= I('rname');
		$dx  		= I('dx');
		$problem 	= I('problem','-1');
		$solve		= I('solve','-1');
		
		$where = '1=1';
		
		if($id) 				$where			.= ' AND `id`=' .$id; 
		if($title)			$where			.= ' AND `title` like \'%'.$title.'%\'';
		if($type)			$where			.= ' AND `type`='.$type;
		if($uname)			$where			.= ' AND `ins_uname` like \'%'.$uname.'%\'';
		if($rname)			$where			.= ' AND `liable_uname` like \'%'.$rname.'%\'';
		if($problem!='-1') 	$where			.= ' AND `problem`='.$problem;
		if($solve!='-1') 	$where			.= ' AND `issolve`=' .$solve; 
		if($dx)				$where 			.= ' AND (`group_id` like \'%'.$dx.'%\' OR `ins_dept_name` like \'%'.$dx.'%\' )';
		
		
		//分页
		$pagecount		= $db->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        
		
		$typestr	= C('INS_TYPE');
		$problem 	= array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">有问题</span>');
		$issolve 	= array('0'=>'<span class="red">未解决</span>','1'=>'<span class="green">已解决</span>');
 
		$lists 		= $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['problem'] 		= $problem[$v['problem']];	
			$lists[$k]['issolve'] 		= $v['problem'] ? $issolve[$v['issolve']] : '';	
			$lists[$k]['duixiang'] 		= $v['type']==1 ? $v['group_id'] : $v['ins_dept_name'];
			$lists[$k]['type'] 			= $typestr[$v['type']];	
			$lists[$k]['create_time'] 	= date('Y-m-d H:i:s',$v['create_time']);
			$lists[$k]['ins_date'] 		= $v['ins_date'] ? date('Y-m-d',$v['ins_date']) : '';
			
		}
		
		
		$this->lists   		= $lists;  
		$this->solve 		= $solve;
		$this->problem 		= $problem;
		$this->type 			= $typestr;
		$this->display('record');
    }
	
	
	// @@@NODE-3###addrecord###编辑巡检记录###
	public  function  edit_ins(){
		
		$insid			= I('insid');
		$db				= M('inspect');
		$typestr		= C('INS_TYPE');
		$problem 		= array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">有问题</span>');
		$issolve 		= array('0'=>'<span class="red">未解决</span>','1'=>'<span class="green">已解决</span>');
		$deptlist 		= M('role')->where('`id`>10')->GetField('id,role_name',true);
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$info		= I('info');
			$insid		= I('insid');
			$matter  	= I('attr');
			
			
			
			if($info['type']==1){
				$info['ins_dept_name'] 		= '';	
				$info['ins_dept_id'] 		= '0';	
			}else{
				$info['group_id'] 			= '';	
				$info['op_id'] 				= '0';	
				
				if($info['ins_dept_id']){
					$info['ins_dept_name']	= $deptlist[$info['ins_dept_id']];
				}
					
			}
			
			if($info['problem']==0){
				$info['problem_desc'] 		= '';	
				$info['issolve'] 			= '0';	
				$info['resolvent'] 			= '';	
			}
			
			$info['ins_date']	= $info['ins_date'] ? strtotime($info['ins_date']) : '';
		
			
			//保存主表
			if($insid){
				$db->where(array('id'=>$insid))->data($info)->save();	
			}else{
				$info['ins_uid']		= cookie('userid');
				$info['ins_uname']		= cookie('name');
				$info['create_time']	= time();
				$insid = $db->add($info);	
			}
			
			//保存巡检资料
			M('attachment')->data(array('rel_id'=>0))->where(array('catid'=>321,'rel_id'=>$insid))->save();
			
			if($matter){
				foreach($matter['id'] as $k=>$v){
					$data = array();
					$data['catid']    	= 321;
					$data['rel_id']    	= $insid;
					$data['filename']  	= $matter['filename'][$k];
					M('attachment')->data($data)->where(array('id'=>$v))->save();
				}	
			}
					
					
			
			$this->success('保存成功！',I('referer',''));
		
		}else{
			
			
			$role = M('role')->GetField('id,role_name',true);
			$user =  M('account')->where(array('status'=>0))->select();
			$key = array();
			foreach($user as $k=>$v){
				$text = $v['nickname'].'-'.$role[$v['roleid']];
				$key[$k]['id']         = $v['id'];
				$key[$k]['user_name']  = $v['nickname'];
				$key[$k]['pinyin']     = strtopinyin($text);
				$key[$k]['text']       = $text;
				$key[$k]['role']       = $v['roleid'];
				$key[$k]['role_name']  = $role[$v['roleid']];
			}
			
			$this->userkey =  json_encode($key);	
			
			
			
			//获取默认素材
			$attid = array();
			$attachment = M('attachment')->field('id')->where(array('catid'=>321,'rel_id'=>$insid))->select();  //
			foreach($attachment as $v){
				$attid[] = 	$v['id'];
			}
			
			
			
			$this->deptlist 	= $deptlist;
			$this->solve 		= $solve;
			$this->problem 		= $problem;
			$this->type 		= $typestr;
			$this->row			= $db->find($insid);
			$this->atts        	= implode(',',$attid);
			$this->display('edit_ins');
		}
	}



	
	// @@@NODE-3###addrecord###记录详情###
	public  function  detail(){
		
		$insid				= I('insid');
		$db					= M('inspect');
		$typestr			= C('INS_TYPE');
		$problem 			= array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">有问题</span>');
		$issolve 			= array('0'=>'<span class="red">未解决</span>','1'=>'<span class="green">已解决</span>');
		$deptlist 			= M('role')->where('`id`>10')->GetField('id,role_name',true);
		
		
		$row				= $db->find($insid);
		
		$row['problem_str'] 	= $problem[$row['problem']];	
		$row['issolve_str'] 	= $row['problem'] ? $issolve[$row['issolve']] : '';	
		$row['duixiang'] 	= $row['type']==1 ? $row['group_id'] : $row['ins_dept_name'];
		$row['type'] 		= $typestr[$row['type']];	
		$row['create_time'] 	= date('Y-m-d H:i:s',$row['create_time']);
		$row['ins_date'] 	= $row['ins_date'] ? date('Y-m-d',$row['ins_date']) : '';
		
			
		
		$this->deptlist 		= $deptlist;
		$this->solve 		= $solve;
		$this->problem 		= $problem;
		$this->type 			= $typestr;
		$this->row			= $row;
		$this->atts        	= M('attachment')->where(array('catid'=>321,'rel_id'=>$insid))->select(); 
		$this->display('detail');
	}

	// @@@NODE-3###score###顾客满意度###
    public function score(){
        $title	= I('title');		//项目名称
        $opid	= I('id');			//项目编号
        $oid	= I('oid');			//项目团号
        $ou		= I('ou');			//立项人

        $where = array();

        if($title)			$where['o.project']			= array('like','%'.$title.'%');
        if($oid)			$where['o.group_id']		= array('like','%'.$oid.'%');
        if($opid)			$where['o.op_id']			= $opid;
        if($ou)				$where['o.create_user_name']= $ou;

        //分页
        $pagecount		= M()->table('__OP__ as o')->field('o.*,c.ret_time')->join('left join __OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id')->where($where)->order($this->orders('o.create_time'))->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $score_kind1    = array_keys(C('SCORE_KIND1')); //旅行类至少十分之一人投票
        $score_kind2    = array_keys(C('SCORE_KIND2')); //课程类至少一人投票
        $lists = M()->table('__OP__ as o')->field('o.*,c.ret_time')->join('left join __OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id')->limit($page->firstRow . ',' . $page->listRows)->where($where)->order($this->orders('o.create_time'))->select();
        foreach ($lists as $k=>$v){
            $op_id          = $v['op_id'];
            $number         = $v['number'];
            $project_kind   = M('op')->where(array('op_id'=>$op_id))->getField('kind');
            $guide_manager  = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('g.name')->join('left join __GUIDE__ as g on g.id = c.charity_id')->where(array('c.op_id'=>$op_id,'c.charity_id'=>array('neq',0)))->select();
            $lists[$k]['guide_manager'] = $guide_manager?implode(',',array_unique(array_column($guide_manager,'name'))):'<span class="blue">待定</span>';

            $charity        = $this->public_get_confirm_id($op_id);
            $score_list     = M()->table('__TCS_SCORE_USER__ as u')->join('left join __TCS_SCORE__ as s on s.uid=u.id')->where(array('u.confirm_id'=>array('in',$charity)))->select();

            if (in_array($project_kind,$score_kind1)) {
                $yg_num         = intval($number/10);    //应完成人数,只要1/10的人投票即完成
                $sj_num         = count($score_list);   //实际投票人数
            }else{
                $yg_num         = 1;                     //只要有一人投票
                $sj_num         = count($score_list);   //实际投票人数
            }

            if (!$charity){
                $charity_status = "<span class='red'>未安排</span>";
            }elseif ($charity && !$score_list){
                $charity_status = "<span class='yellow'>已安排调查</span>";
            }elseif($charity && $score_list && $sj_num<$yg_num){
                $charity_status = "<span class='yellow'>未完成调查</span>";
            }else{
                $charity_status = "<span class='green'>已完成调查</span>";
            }
            $lists[$k]["charity_status"] = $charity_status;

            //只要有不满意的就需要追责
            /*$where          = array();
            $where['u.confirm_id']  = array('in',$charity);
            $where['s.solve']       = array('eq',0);
            $where['_string']       = "s.stay = 1 or s.travel = 1 or s.content = 1 or s.food = 1 or s.bus = 1 or s.driver = 1 or s.guide = 1 or s.teacher = 1";
            $zhuize         = M()->table('__TCS_SCORE_USER__ as u')->join('left join __TCS_SCORE__ as s on s.uid=u.id')->where($where)->count();
            $lists[$k]['zhuize'] = $zhuize;*/

        }

        $this->lists    = $lists;
        $this->display();
    }

    public function public_get_confirm_id($op_id){
        $charity        = M('op_guide_confirm')->where(array('op_id'=>$op_id,'charity_id'=>array('neq',0)))->getField('id',true);
        return $charity;
    }

    // @@@NODE-3###blame###顾客满意度追责###
    /*public function blame(){
        if (isset($_POST['dosubmint'])){
            $info                   = I('info');
            $score_id               = I('score_id');
            if ($score_id){
                $info['solve_time'] = NOW_TIME;
                $info['solver_uid'] = cookie('userid');
                $res = M('tcs_score')->where(array('id'=>$score_id))->save($info);
                if ($res){
                    $this->success('数据保存成功');
                }else{
                    $this->error('数据保存失败');
                }
            }else{
                $this->error('数据保存失败');
            }
        }else{
            $op_id                  = I('op_id');
            $confirm_id             = $this->public_get_confirm_id($op_id);
            $where                  = array();
            $where['u.confirm_id']  = array('in',$confirm_id);
            $where['s.solve']       = array('eq',0);
            $where['_string']       = "s.stay = 1 or s.travel = 1 or s.content = 1 or s.food = 1 or s.bus = 1 or s.driver = 1 or s.guide = 1 or s.teacher = 1";

            //分页
            $pagecount		        = M()->table('__TCS_SCORE_USER__ as u')->field('u.*,s.id as score_id,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.suggest,s.problem,s.solve,s.resolvent,c.in_begin_day,c.in_day,c.address')->join('left join __TCS_SCORE__ as s on s.uid=u.id')->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')->where($where)->count();
            $page			        = new Page($pagecount, P::PAGE_SIZE);
            $this->pages	        = $pagecount>P::PAGE_SIZE ? $page->show():'';

            $zhuize                 = M()->table('__TCS_SCORE_USER__ as u')
                ->field('u.*,s.id as score_id,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.suggest,s.problem,s.solve,s.resolvent,c.in_begin_day,c.in_day,c.address')
                ->join('left join __TCS_SCORE__ as s on s.uid=u.id')
                ->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')
                ->where($where)
                ->limit($page->firstRow.','.$page->listRows)
                ->select();
            $this->score_stu        = C('SCORE_STU');
            $this->lists            = $zhuize;
            $op                     = M('op')->where(array('op_id'=>$op_id))->find();
            $this->op               = $op;

            $this->display();
        }
    }*/

    public function blame(){
        if (isset($_POST['dosubmint'])){

            $op_id                  = I('op_id');
            $info                   = I('info');
            if ($op_id){
                $list               = M('tcs_score_problem')->where(array('op_id'=>$op_id))->find();
                $info['op_id']      = $op_id;
                $info['solve_time'] = NOW_TIME;
                $info['solver_uid'] = cookie('userid');
                if ($list){
                    $id             = $list['id'];
                    $res            = M('tcs_score_problem')->where(array('id'=>$id))->save($info);
                }else{
                    $res            = M('tcs_score_problem')->where(array('op_id'=>$op_id))->add($info);
                }
                if ($res){

                    $record = array();
                    $record['op_id']   = $op_id;
                    $record['optype']  = 4;
                    $record['explain'] = '评分结果追责';
                    op_record($record);

                    $this->success('数据保存成功');
                }else{
                    $this->error('数据保存失败');
                }
            }else{
                $this->error('数据保存失败');
            }
        }
    }

    // @@@NODE-3###score_info###记录详情###
    public function score_info(){
        $op_id          = I('opid');
        if (!$op_id){
            $this->error("数据获取失败");
        }

        $this->op       = M('op')->where(array('op_id'=>$op_id))->find();
        $list           = M('op_guide_confirm')->field('id,score_num')->where(array('op_id'=>$op_id))->select();
        $score_num      = array_sum(array_column($list,'score_num'));

        //分页
        $pagecount		= M()->table('__TCS_SCORE__ as s')->field('s.*,u.mobile,u.confirm_id,c.in_begin_day,c.in_day,c.address')->join('left join __TCS_SCORE_USER__ as u on u.id = s.uid')->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')->where(array('u.op_id'=>$op_id))->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = M()->table('__TCS_SCORE__ as s')
            ->field('s.*,u.mobile,u.confirm_id,c.in_begin_day,c.in_day,c.address')
            ->join('left join __TCS_SCORE_USER__ as u on u.id = s.uid')
            ->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')
            ->where(array('u.op_id'=>$op_id))
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        foreach ($lists as $k=>$v){
            /*if ($v['solve']==1){
                $status     = '已处理';
            }else{
                if ($v['solve']==0 && ($v['stay'] ==1 || $v['food'] ==1 || $v['bus'] ==1 || $v['travel'] ==1 || $v['content'] ==1 || $v['driver'] ==1 || $v['guide'] ==1 || $v['teacher'] ==1)){
                    $status = '<span class="red">未处理</span>';
                }else{
                    $status = '无需处理';
                }
            }
            $lists[$k]['status']    = $status;*/
            $lists[$k]['sum_score'] = $v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material'];
        }

        $kind               = M('op')->where(array('op_id'=>$op_id))->getField('kind');
        $score_kind1        = array_keys(C('SCORE_KIND1'));
        $score_kind2        = array_keys(C('SCORE_KIND2'));

        $average            = array();
        $average['stay']    = round(array_sum(array_column($lists,'stay'))/$score_num,2);
        $average['food']    = round(array_sum(array_column($lists,'food'))/$score_num,2);
        $average['bus']     = round(array_sum(array_column($lists,'bus'))/$score_num,2);
        $average['travel']  = round(array_sum(array_column($lists,'travel'))/$score_num,2);
        $average['content'] = round(array_sum(array_column($lists,'content'))/$score_num,2);
        $average['driver']  = round(array_sum(array_column($lists,'driver'))/$score_num,2);
        $average['guide']   = round(array_sum(array_column($lists,'guide'))/$score_num,2);
        $average['teacher'] = round(array_sum(array_column($lists,'teacher'))/$score_num,2);

        $average['depth']   = round(array_sum(array_column($lists,'depth'))/$score_num,2);
        $average['major']   = round(array_sum(array_column($lists,'major'))/$score_num,2);
        $average['interest'] = round(array_sum(array_column($lists,'interest'))/$score_num,2);
        $average['material'] = round(array_sum(array_column($lists,'material'))/$score_num,2);
        $average['score_num']= $score_num?$score_num:'0';
        if (in_array($kind,$score_kind1)) $sum = 8*5*$score_num; //考核8项, 每项5分, 满分总分
        if (in_array($kind,$score_kind2)) $sum = 6*5*$score_num; //考核6项, 每项5分, 满分总分
        $average['sum_score'] = (round(array_sum(array_column($lists,'sum_score'))/$sum,2)*100).'%';
        $row                = M('tcs_score_problem')->where(array('op_id'=>$op_id))->find();
        $this->score_pro    = json_encode($row);
        if ($this->score_pro){
            $this->rad      = 1;
        }else{
            $this->rad      = 0;
        }

        $this->kind         = $kind;
        $this->score_kind1  = $score_kind1;
        $this->score_kind2  = $score_kind2;
        $this->average      = $average;
        $this->lists        = $lists;
        $this->op_id        = $op_id;
        $this->score_stu    = C('SCORE_STU');


        $this->display();
    }

    // @@@NODE-3###score_detail###每条评分详情###
    public function score_detail(){
        $id                 = I('id');
        $info               = M()->table('__TCS_SCORE__ as s')
            ->field('s.*,u.mobile,o.project,acc.nickname')
            ->join('__TCS_SCORE_USER__ as u on u.id = s.uid')
            ->join('left join __OP__ as o on o.op_id= u.op_id')
            ->join('left join __ACCOUNT__ as acc on acc.id= s.solver_uid')
            ->where(array('s.id'=>$id))
            ->find();

        /*if ($info['solve']==1){
            $status         = '已处理';
        }else{
            if ($info['solve']==0 && ($info['stay'] ==1 || $info['food'] ==1 || $info['bus'] ==1 || $info['travel'] ==1 || $info['content'] ==1 || $info['driver'] ==1 || $info['guide'] ==1 || $info['teacher'] ==1)){
                $status     = '<span class="red">未处理</span>';
            }else{
                $status     = '无需处理';
            }
        }
        $info['status']     = $status;*/
        $this->row          = $info;
        $this->score_stu    = C('SCORE_STU');

        $this->display();
    }
    
}