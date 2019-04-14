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
		
		
		$row				    = $db->find($insid);
		
		$row['problem_str'] 	= $problem[$row['problem']];	
		$row['issolve_str'] 	= $row['problem'] ? $issolve[$row['issolve']] : '';	
		$row['duixiang'] 	    = $row['type']==1 ? $row['group_id'] : $row['ins_dept_name'];
		$row['type'] 		    = $typestr[$row['type']];
		$row['create_time'] 	= date('Y-m-d H:i:s',$row['create_time']);
		$row['ins_date'] 	    = $row['ins_date'] ? date('Y-m-d',$row['ins_date']) : '';
		
			
		
		$this->deptlist 	= $deptlist;
		$this->solve 		= $solve;
		$this->problem 		= $problem;
		$this->type 	    = $typestr;
		$this->row			= $row;
		$this->atts        	= M('attachment')->where(array('catid'=>321,'rel_id'=>$insid))->select(); 
		$this->display('detail');
	}

	// @@@NODE-3###score###顾客满意度###
    public function score(){
        $title	                = I('title');		//项目名称
        $opid	                = I('id');			//项目编号
        $oid	                = I('oid');			//项目团号
        $ou		                = I('ou');			//立项人
        $kpi_opids              = I('kpi_opids')?explode(',',I('kpi_opids')):0;

        $where                  = array();
        if ($kpi_opids) $where['o.op_id']           = array('in',$kpi_opids);
        if($title)		$where['o.project']			= array('like','%'.$title.'%');
        if($oid)	    $where['o.group_id']		= array('like','%'.$oid.'%');
        if($opid)		$where['o.op_id']			= $opid;
        if($ou)			$where['o.create_user_name']= $ou;

        //分页
        $pagecount		        = M()->table('__OP__ as o')->field('o.*,c.ret_time')->join('left join __OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id')->where($where)->order($this->orders('o.create_time'))->count();
        $page			        = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	        = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                  = M()->table('__OP__ as o')->field('o.*,c.ret_time')->join('left join __OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id')->limit($page->firstRow . ',' . $page->listRows)->where($where)->order($this->orders('o.create_time'))->select();
        foreach ($lists as $k=>$v){
            $op_id              = $v['op_id'];
            $guide_manager      = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('g.name,c.score_num,c.op_id')->join('left join __GUIDE__ as g on g.id = c.charity_id')->where(array('c.op_id'=>$op_id,'c.charity_id'=>array('neq',0)))->select();
            $lists[$k]['guide_manager'] = $guide_manager?implode(',',array_unique(array_column($guide_manager,'name'))):'<span class="blue">待定</span>';

            $charity            = $this->public_get_confirm_id($op_id);
            $count_score        = M()->table('__TCS_SCORE__ as s')->join('__TCS_SCORE_USER__ as u on u.id=s.uid','left')->where(array('u.op_id'=>$v['op_id']))->count();

            if (!$charity && !$count_score){
                $charity_status = "<span class='red'>未安排</span>";
            }elseif ($charity && $count_score <1){
                $charity_status = "<span class='yellow'>已安排调查</span>";
            }else{
                $charity_status = "<span class='green'>已完成调查</span>";
            }
            $lists[$k]["charity_status"] = $charity_status;

            //求得分率
            $average            = $this->get_guide_score($v);
            $lists[$k]['average'] = $average;

        }
        $this->lists            = $lists;
        $this->display();
    }

    private function get_guide_score($v){
        $kind               = $v['kind'];
        $op_id              = $v['op_id'];
        $score_kind1        = array_keys(C('SCORE_KIND1'));
        $score_kind2        = array_keys(C('SCORE_KIND2'));
        $score_kind3        = array_keys(C('SCORE_KIND3'));
        $lists              = M()->table('__TCS_SCORE__ as s')
            ->field('s.*,u.mobile,u.confirm_id,c.in_begin_day,c.in_day,c.address,c.score_num')
            ->join('left join __TCS_SCORE_USER__ as u on u.id = s.uid')
            ->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')
            ->where(array('u.op_id'=>$op_id))
            ->select();
        $score_num          = count($lists);
        foreach ($lists as $k=>$v){
            $lists[$k]['sum_score'] = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
        }
        if (in_array($kind,$score_kind1)) $sum = 12*5*$score_num; //考核12项, 每项5分, 满分总分
        if (in_array($kind,$score_kind2)) $sum = 7*5*$score_num; //考核7项, 每项5分, 满分总分
        if (in_array($kind,$score_kind3)) $sum = 10*5*$score_num; //考核10项, 每项5分, 满分总分
        $average            = (round(array_sum(array_column($lists,'sum_score'))/$sum,2)*100).'%';
        return $average;
    }

    public function public_get_confirm_id($op_id){
        $charity        = M('op_guide_confirm')->where(array('op_id'=>$op_id,'charity_id'=>array('neq',0)))->getField('id',true);
        return $charity;
    }

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

                    //安全品控部经理发送系统消息uid 26(李岩),173(蔡金龙)
                    $safe = array(26,173);
                    $op          = M('op')->where(array('op_id'=>$op_id))->find();
                    foreach ($safe as $k=>$v) {
                        $uid     = cookie('userid');
                        $title   = '您有来自['.$op['project'].']项目追责,请及时跟进!';
                        $content = '';
                        $url     = U('Inspect/score_info',array('opid'=>$op_id));
                        $user    = '['.$v.']';
                        send_msg($uid,$title,$content,$url,$user,'');
                    }

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
        $score_num      = count($lists);

        foreach ($lists as $k=>$v){
            $lists[$k]['sum_score'] = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
        }

        $kind                   = M('op')->where(array('op_id'=>$op_id))->getField('kind');
        $score_kind1            = array_keys(C('SCORE_KIND1'));
        $score_kind2            = array_keys(C('SCORE_KIND2'));
        $score_kind3            = array_keys(C('SCORE_KIND3'));

        $average                = array();
        $average['before_sell'] = round(array_sum(array_column($lists,'before_sell'))/$score_num,2);
        $average['new_media']   = round(array_sum(array_column($lists,'new_media'))/$score_num,2);
        $average['stay']        = round(array_sum(array_column($lists,'stay'))/$score_num,2);
        $average['food']        = round(array_sum(array_column($lists,'food'))/$score_num,2);
        $average['bus']         = round(array_sum(array_column($lists,'bus'))/$score_num,2);
        $average['travel']      = round(array_sum(array_column($lists,'travel'))/$score_num,2);
        $average['content']     = round(array_sum(array_column($lists,'content'))/$score_num,2);
        $average['driver']      = round(array_sum(array_column($lists,'driver'))/$score_num,2);
        $average['guide']       = round(array_sum(array_column($lists,'guide'))/$score_num,2);
        $average['teacher']     = round(array_sum(array_column($lists,'teacher'))/$score_num,2);

        $average['depth']       = round(array_sum(array_column($lists,'depth'))/$score_num,2);
        $average['major']       = round(array_sum(array_column($lists,'major'))/$score_num,2);
        $average['interest']    = round(array_sum(array_column($lists,'interest'))/$score_num,2);
        $average['material']    = round(array_sum(array_column($lists,'material'))/$score_num,2);
        $average['cas_time']    = round(array_sum(array_column($lists,'cas_time'))/$score_num,2);
        $average['cas_complete']= round(array_sum(array_column($lists,'cas_complete'))/$score_num,2);
        $average['cas_addr']    = round(array_sum(array_column($lists,'cas_addr'))/$score_num,2);
        $average['score_num']   = $score_num?$score_num:'0';
        if (in_array($kind,$score_kind1)) $sum = 12*5*$score_num; //考核12项, 每项5分, 满分总分
        if (in_array($kind,$score_kind2)) $sum = 10*5*$score_num; //考核7项, 每项5分, 满分总分
        if (in_array($kind,$score_kind3)) $sum = 10*5*$score_num; //考核10项, 每项5分, 满分总分
        $average['sum_score']   = (round(array_sum(array_column($lists,'sum_score'))/$sum,2)*100).'%';
        $row                    = M('tcs_score_problem')->where(array('op_id'=>$op_id))->find();
        $this->row              = $row;
        $this->score_pro        = json_encode($row);
        if ($this->score_pro){
            $this->rad          = 1;
        }else{
            $this->rad          = 0;
        }

        $this->kind             = $kind;
        $this->score_kind1      = $score_kind1;
        $this->score_kind2      = $score_kind2;
        $this->score_kind3      = $score_kind3;
        $this->average          = $average;
        $this->lists            = $lists;
        $this->op_id            = $op_id;
        $visit_lists            = M('op_visit')->where(array('op_id'=>$op_id))->select();
        if ($visit_lists){ $this->return_visit = 1; }
        $this->visit_lists      = $visit_lists;


        $this->display();
    }

    // @@@NODE-3###score_detail###每条评分详情###
    public function public_score_detail(){
        $id                 = I('id');
        $info               = M()->table('__TCS_SCORE__ as s')
            ->field('s.*,u.mobile,o.project,o.kind')
            ->join('__TCS_SCORE_USER__ as u on u.id = s.uid','left')
            ->join('join __OP__ as o on o.op_id= u.op_id','left')
            ->where(array('s.id'=>$id))
            ->find();

        $score_kind1        = array_keys(C('SCORE_KIND1')); //线路类
        $score_kind2        = array_keys(C('SCORE_KIND2')); //课程类
        $score_kind3        = array_keys(C('SCORE_KIND3')); //亲自旅行 , 冬夏令营

        if (in_array($info['kind'],$score_kind2)){
            $kind           = 2;
        }elseif (in_array($info['kind'],$score_kind3)){
            $kind           = 3;
        }else{
            $kind           = 1;
        }
        $this->kind         = $kind;
        $this->row          = $info;
        $this->score_stu    = C('SCORE_STU');

        $this->display('score_detail');
    }


    // @@@NODE-3###return_visit###满意度回访###
    public function return_visit(){
        if (isset($_POST['dosubmint'])){
            $db                     = M('op_visit');
            $opid                   = I('opid');
            $id                     = I('id');
            $num                    = 0;
            $data                   = array();
            $data['tel']            = trim(I('tel'));
            $data['content']        = trim(I('content'));
            $data['op_id']          = $opid;
            $data['input_time']     = NOW_TIME;
            $data['input_user_id']  = cookie('userid');
            $data['input_user_name']= cookie('nickname');
            if ($id){
                $res                = $db->where(array('id'=>$id))->save($data);
            }else{
                $res                = $db->add($data);
            }
            if ($res) $num++;
            echo $num;
        }else{
            $id     = I('id');
            if (!$id) $this->error('获取数据失败');
            $this->row = M('op_visit')->where(array('id'=>$id))->find();

            $this->display('upd_visit');
        }
    }

    //业务人员顾客满意度详情页
    public function public_satisfied(){
        $year                       = I('year');
        $month                      = (int)I('month');
        $userid                     = I('uid');
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $gross_margin               = get_gross_margin($yearMonth,$userid,1);  //获取当月月度累计毛利额目标值(如果毛利额目标为0,则不考核)
        $cycle_times                = get_cycle($yearMonth);
        $data                       = get_satisfied_kpi_data($userid,$cycle_times['begintime'],$cycle_times['endtime'],$gross_margin);
        $op_lists                   = $data['shishi_lists'];

        $this->data                 = $data;
        $this->lists                = $op_lists;
        $this->year                 = $year;
        $this->month                = $month;
        $this->uid                  = $userid;
        $this->display('satisfied');
    }

    //顾客满意度统计
    public function score_statis(){
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $yw_departs                 = C('YW_DEPARTS');  //业务部门id
        $where                      = array();
        $where['id']                = array('in',$yw_departs);
        $departments                = M('salary_department')->field('id,department')->where($where)->select();
        $department_data            = get_company_score_statis($departments,$yearMonth); //部门当月合计
        $company_data               = get_company_sum_score_statis($departments,$yearMonth); //公司合计

        $this->company              = $company_data;
        $this->lists                = $department_data;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;
        $this->display();
    }


    //顾客满意度统计详情
    public function public_score_statis_detail(){
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        $department_id              = I('did');
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $where                      = array();
        $where['id']                = $department_id;
        $department                 = M('salary_department')->field('id,department')->where($where)->find();
        $lists                      = get_department_person_score_statis($year,$month,$department_id); //获取某个部门每个人的客户满意度

        $this->lists                = $lists;
        $this->department           = $department;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;
        $this->display('score_statis_detail');
    }

    public function public_kpi_score(){
        $uid                        = I('uid');
        $startTime                  = I('st');
        $endTime                    = I('et');
        $year                       = I('y');

        $departments                = get_departments($uid); //获取所管辖部门
        $data                       = array();
        foreach ($departments as $k=>$v){
            $data[$v]['departmentid']= $k;
            $data[$v]['department'] = $v;
            $data[$v]['info']       = get_department_person_score_statis($year,'',$k,'quarter',$startTime,$endTime); //获取季度某个部门每个人的客户满意度
        }
        $data                       = $this->getdepartment_data_sum($data,$startTime,$endTime);
        $sum                        = get_sum_kpi_score($departments,$startTime,$endTime); //所管辖(所属)部门总合计

        $this->sum                  = $sum;
        $this->lists                = $data;
        $this->year                 = $year;
        $this->display('kpi_score');
    }

    private function getdepartment_data_sum($data,$startTime,$endTime){
        foreach ($data as $k=>$v){
            $account_lists              = get_department_businessman($v['departmentid']);
            $account_ids                = array_column($account_lists,'id');
            $heji                       = quarter_statis($account_ids,$startTime,$endTime);
            $heji['userid']             = '';
            $heji['username']           = '合计';
            $data[$k]['row_span_num']= count($data[$k]['info']);
            $data[$k]['info'][($data[$k]['row_span_num'])]= $heji;
        }
        return $data;
    }

    //顾客满意度分项统计
    public function user_kpi_statis(){
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        $ut                         = trim(I('ut'))?trim(I('ut')):'jd';
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $yw_departs                 = C('YW_DEPARTS');  //业务部门id
        $where                      = array();
        $where['id']                = array('in',$yw_departs);
        $departments                = M('salary_department')->field('id,department')->where($where)->select();
        $department_data            = get_type_user_company_statis($departments,$yearMonth,$ut); //部门当月合计
        $company_data               = get_type_user_company_sum_statis($departments,$yearMonth,$ut); //公司合计

        $this->usertype             = $ut;
        $this->company              = $company_data;
        $this->lists                = $department_data;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;
        $this->display();
    }

    //顾客满意度分项统计详情
    public function public_user_kpi_statis_detail(){
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        $department_id              = I('did');
        $ut                         = trim(I('ut'));
        if (!$ut) $this->error('参数错误');
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $where                      = array();
        $where['id']                = $department_id;
        $department                 = M('salary_department')->field('id,department')->where($where)->find();
        $lists                      = get_user_kpi_department_person_statis($year,$month,$department_id,$ut); //获取某个部门每个人的分项客户满意度

        $this->usertype             = $ut;
        $this->lists                = $lists;
        $this->department           = $department;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;
        $this->display('user_kpi_statis_detail');
    }

    //顾客满意度分项统计详情页
    public function public_user_kpi_satisfied(){
        $year                       = I('year');
        $month                      = (int)I('month');
        $userid                     = I('uid');
        $ut                         = trim(I('ut'));
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        //$gross_margin               = get_gross_margin($yearMonth,$userid,1);  //获取当月月度累计毛利额目标值(如果毛利额目标为0,则不考核)
        $cycle_times                = get_cycle($yearMonth);
        $data                       = get_user_kpi_data($userid,$cycle_times['begintime'],$cycle_times['endtime'],$ut);
        $op_lists                   = $data['shishi_lists'];

        $this->usertype             = $ut;
        $this->data                 = $data;
        $this->lists                = $op_lists;
        $this->year                 = $year;
        $this->month                = $month;
        $this->uid                  = $userid;
        $this->display('user_kpi_satisfied');
    }

    // @@@NODE-3###score_info###顾客满意度分项统计记录详情###
    public function public_user_kpi_score_info(){
        $op_id                      = I('opid');
        $ut                         = trim(I('ut'));
        if (!$op_id){
            $this->error("数据获取失败");
        }

        $this->op                   = M('op')->where(array('op_id'=>$op_id))->find();

        //分页
        $pagecount		            = M()->table('__TCS_SCORE__ as s')->field('s.*,u.mobile,u.confirm_id,c.in_begin_day,c.in_day,c.address')->join('left join __TCS_SCORE_USER__ as u on u.id = s.uid')->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')->where(array('u.op_id'=>$op_id))->count();
        $page			            = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	            = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                      = M()->table('__TCS_SCORE__ as s')
            ->field('s.*,u.mobile,u.confirm_id,c.in_begin_day,c.in_day,c.address')
            ->join('left join __TCS_SCORE_USER__ as u on u.id = s.uid')
            ->join('left join __OP_GUIDE_CONFIRM__ as c on c.id = u.confirm_id')
            ->where(array('u.op_id'=>$op_id))
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        $score_num                  = 0;
        foreach ($lists as $k=>$v){
            if ($ut == 'jd') $lists[$k]['sum_score'] = $v['stay']+$v['travel']+$v['food']+$v['bus']+$v['driver']; //计调
            if ($ut == 'yf') $lists[$k]['sum_score'] = $v['depth']+$v['major']+$v['interest']+$v['material']; //研发
            if ($ut == 'zy') $lists[$k]['sum_score'] = $v['cas_time']+$v['cas_complete']+$v['cas_addr']; //资源
            if ($lists[$k]['sum_score']) $score_num++;
        }

        $kind                       = M('op')->where(array('op_id'=>$op_id))->getField('kind');
        $score_kind1                = array_keys(C('SCORE_KIND1'));
        $score_kind2                = array_keys(C('SCORE_KIND2'));
        $score_kind3                = array_keys(C('SCORE_KIND3'));

        $average                    = array();
        $average['before_sell']     = round(array_sum(array_column($lists,'before_sell'))/$score_num,2);
        $average['new_media']       = round(array_sum(array_column($lists,'new_media'))/$score_num,2);
        $average['stay']            = round(array_sum(array_column($lists,'stay'))/$score_num,2);
        $average['food']            = round(array_sum(array_column($lists,'food'))/$score_num,2);
        $average['bus']             = round(array_sum(array_column($lists,'bus'))/$score_num,2);
        $average['travel']          = round(array_sum(array_column($lists,'travel'))/$score_num,2);
        $average['content']         = round(array_sum(array_column($lists,'content'))/$score_num,2);
        $average['driver']          = round(array_sum(array_column($lists,'driver'))/$score_num,2);
        $average['guide']           = round(array_sum(array_column($lists,'guide'))/$score_num,2);
        $average['teacher']         = round(array_sum(array_column($lists,'teacher'))/$score_num,2);

        $average['depth']           = round(array_sum(array_column($lists,'depth'))/$score_num,2);
        $average['major']           = round(array_sum(array_column($lists,'major'))/$score_num,2);
        $average['interest']        = round(array_sum(array_column($lists,'interest'))/$score_num,2);
        $average['material']        = round(array_sum(array_column($lists,'material'))/$score_num,2);
        $average['cas_time']        = round(array_sum(array_column($lists,'cas_time'))/$score_num,2);
        $average['cas_complete']    = round(array_sum(array_column($lists,'cas_complete'))/$score_num,2);
        $average['cas_addr']        = round(array_sum(array_column($lists,'cas_addr'))/$score_num,2);
        $average['score_num']       = $score_num?$score_num:'0';
        $average['sum_score']       = (get_type_user_manyidu($lists,$ut)*100).'%'; //合计

        $this->usertype             = $ut;
        $this->kind                 = $kind;
        $this->score_kind1          = $score_kind1;
        $this->score_kind2          = $score_kind2;
        $this->score_kind3          = $score_kind3;
        $this->average              = $average;
        $this->lists                = $lists;
        $this->op_id                = $op_id;



        $this->display('user_kpi_score_info');
    }

}