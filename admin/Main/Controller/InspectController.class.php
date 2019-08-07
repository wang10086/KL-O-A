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
            $charity_status     = $this->get_satisfied_status($v['op_id'],$v['kind']);
            $lists[$k]["charity_status"] = $charity_status;

            //求得分率
            $average            = $this->get_guide_score($v);
            $lists[$k]['average'] = $average;

        }
        $this->lists            = $lists;
        $this->is_kpi_det       = $kpi_opids ? 1 : '';
        $this->display();
    }

    //满意度评分状态
    /*课后一小时、讲座、小课题、中科BOX、实验室建设：不低于1人
    研学旅行、科学考察、少科院线路40人以内：不低于1人
    研学旅行、科学考察、少科院线路40-80人以上：不低于3人
    校园科技节、社会综合实践、亲子旅行、冬夏令营、教师培训、学趣课程：不低于3人*/
    private function get_satisfied_status($opid,$kind){
        $num_1                  = array(60,61,62,64,67,1,2,3,68,69); //课后一小时;小课题;中科box;专场讲座;实验室建设 (不低于1人) (线路,课程,其它,常规旅游,科学快车)
        $num_3                  = array(56,57,58,59,63,65); //校园科技节;社会综合实践;亲子旅行;冬夏令营;学趣课程;教师培训
        $num_unsure             = array(54,55,66); //研学旅行;科学考察;少科院线路
        $num                    = M()->table('__TCS_SCORE__ as s')->join('__TCS_SCORE_USER__ as u on u.id=s.uid','left')->where(array('u.op_id'=>$opid))->count();
        $create_op_day          = substr($opid,0,8);
        if ($create_op_day <= '20190625'){
            if ($num >0){ //不低于1人
                $stu            = "<span class='green'>已评分</span>";
            }else{
                $stu            = "<span class='red'>未评分</span>";
            }
        }else{
            if (in_array($kind,$num_1)){
                if ($num >0){ //不低于1人
                    $stu        = "<span class='green'>已评分(".$num."/1)</span>";
                }else{
                    $stu        = "<span class='red'>未评分</span>";
                }
            }elseif (in_array($kind,$num_3)){ //不低于3人
                if ($num < 1){
                    $stu        = "<span class='red'>未评分</span>";
                }elseif ($num >0 && $num <3){
                    $stu        = "<span class='yellow'>评分中(".$num."/3)</span>";
                }else{
                    $stu        = "<span class='green'>已评分(".$num."/3)</span>";
                }
            }elseif (in_array($kind,$num_unsure)){
                //求团人数(从预算中取值)
                $list           = M('op_budget')->where(array('op_id'=>$opid))->find();
                $person_num     = $list['renshu'];
                if ($person_num <= 40){ //不低于1人
                    if ($num >0){ //不低于1人
                        $stu    = "<span class='green'>已评分(".$num."/1)</span>";
                    }else{
                        $stu    = "<span class='red'>未评分</span>";
                    }
                }else{ //不低于3人
                    if ($num < 1){
                        $stu    = "<span class='red'>未评分</span>";
                    }elseif ($num >0 && $num <3){
                        $stu    = "<span class='yellow'>评分中(".$num."/3)</span>";
                    }else{
                        $stu    = "<span class='green'>已评分(".$num."/3)</span>";
                    }
                }
            }
        }
        return $stu;
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
            $lists[$k]['sum_score'] = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
        }
        $sum                = get_sum_score($lists);
        $average            = (round(array_sum(array_column($lists,'sum_score'))/$sum,2)*100).'%';
        return $average;
    }

    /*public function public_get_confirm_id($op_id){
        $charity        = M('op_guide_confirm')->where(array('op_id'=>$op_id,'charity_id'=>array('neq',0)))->getField('id',true);
        return $charity;
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
        $score_kind1    = array_keys(C('SCORE_KIND1'));
        $score_kind2    = array_keys(C('SCORE_KIND2'));
        $score_kind3    = array_keys(C('SCORE_KIND3'));

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

        $average                = $this->get_score_info($lists);
        $kind                   = M('op')->where(array('op_id'=>$op_id))->getField('kind');
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
        $this->dijie_opids      = get_dijie_opids();


        $this->display();
    }

    private function get_score_info($lists){
        $score_num                  = count($lists);
        $before_sell_num            = 0;
        $new_media_num              = 0;
        $stay_num                   = 0;
        $food_num                   = 0;
        $bus_num                    = 0;
        $travel_num                 = 0;
        $content_num                = 0;
        $driver_num                 = 0;
        $guide_num                  = 0;
        $teacher_num                = 0;
        $depth_num                  = 0;
        $major_num                  = 0;
        $interest_num               = 0;
        $material_num               = 0;
        $late_num                   = 0;
        $manage_num                 = 0;
        $morality_num               = 0;
        $cas_time_num               = 0;
        $cas_complete_num           = 0;
        $cas_addr_num               = 0;


        foreach ($lists as $k=>$v){
            $lists[$k]['sum_score'] = $v['before_sell']+$v['new_media']+$v['stay']+$v['travel']+$v['content']+$v['food']+$v['bus']+$v['driver']+$v['guide']+$v['teacher']+$v['depth']+$v['major']+$v['interest']+$v['material']+$v['late']+$v['manage']+$v['morality']+$v['cas_time']+$v['cas_complete']+$v['cas_addr'];
            if($v['before_sell'])   $before_sell_num++;
            if($v['new_media'])     $new_media_num++;
            if($v['stay'])          $stay_num++;
            if($v['food'])          $food_num++;
            if($v['bus'])           $bus_num++;
            if($v['travel'])        $travel_num++;
            if($v['content'])       $content_num++;
            if($v['driver'])        $driver_num++;
            if($v['guide'])         $guide_num++;
            if($v['teacher'])       $teacher_num++;
            if($v['depth'])         $depth_num++;
            if($v['major'])         $major_num++;
            if($v['interest'])      $interest_num++;
            if($v['material'])      $material_num++;
            if($v['late'])          $late_num++;
            if($v['manage'])        $manage_num++;
            if($v['morality'])      $morality_num++;
            if($v['cas_time'])      $cas_time_num++;
            if($v['cas_complete'])  $cas_complete_num++;
            if($v['cas_addr'])      $cas_addr_num++;
        }


        $average                    = array();
        $average['before_sell']     = round(array_sum(array_column($lists,'before_sell'))/$before_sell_num,2);
        $average['new_media']       = round(array_sum(array_column($lists,'new_media'))/$new_media_num,2);
        $average['stay']            = round(array_sum(array_column($lists,'stay'))/$stay_num,2);
        $average['food']            = round(array_sum(array_column($lists,'food'))/$food_num,2);
        $average['bus']             = round(array_sum(array_column($lists,'bus'))/$bus_num,2);
        $average['travel']          = round(array_sum(array_column($lists,'travel'))/$travel_num,2);
        $average['content']         = round(array_sum(array_column($lists,'content'))/$content_num,2);
        $average['driver']          = round(array_sum(array_column($lists,'driver'))/$driver_num,2);
        $average['guide']           = round(array_sum(array_column($lists,'guide'))/$guide_num,2);
        $average['teacher']         = round(array_sum(array_column($lists,'teacher'))/$teacher_num,2);
        $average['depth']           = round(array_sum(array_column($lists,'depth'))/$depth_num,2);
        $average['major']           = round(array_sum(array_column($lists,'major'))/$major_num,2);
        $average['interest']        = round(array_sum(array_column($lists,'interest'))/$interest_num,2);
        $average['material']        = round(array_sum(array_column($lists,'material'))/$material_num,2);
        $average['late']            = round(array_sum(array_column($lists,'late'))/$late_num,2);
        $average['manage']          = round(array_sum(array_column($lists,'manage'))/$manage_num,2);
        $average['morality']        = round(array_sum(array_column($lists,'morality'))/$morality_num,2);
        $average['cas_time']        = round(array_sum(array_column($lists,'cas_time'))/$cas_time_num,2);
        $average['cas_complete']    = round(array_sum(array_column($lists,'cas_complete'))/$cas_complete_num,2);
        $average['cas_addr']        = round(array_sum(array_column($lists,'cas_addr'))/$cas_addr_num,2);
        $average['score_num']       = $score_num?$score_num:'0';
        $sum                        = get_sum_score($lists); //总分
        $average['sum_score']       = (round(array_sum(array_column($lists,'sum_score'))/$sum,2)*100).'%';
        return $average;
    }

    // @@@NODE-3###score_detail###每条评分详情###
    public function public_score_detail(){
        $opid               = trim(I('opid'));
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
        $this->opid         = $opid;
        $this->dijie_opids  = get_dijie_opids();

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
        $st                         = I('st'); //kpi考核开始时间
        $et                         = I('et'); //kpi考核结束时间
        $userid                     = I('uid');
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $gross_margin               = get_gross_margin($yearMonth,$userid,1);  //获取当月月度累计毛利额目标值(如果毛利额目标为0,则不考核)
        $cycle_times                = get_cycle($yearMonth); //顾客满意度周期
        //$data                       = get_satisfied_kpi_data($userid,$cycle_times['begintime'],$cycle_times['endtime'],$gross_margin);
        $startTime                  = $st?$st:$cycle_times['begintime'];
        $endTime                    = $et?$et:$cycle_times['endtime'];
        $data                       = get_satisfied_kpi_data($userid,$startTime,$endTime,$gross_margin);
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
        $yw_departs                 = C('YW_DEPARTS_KPI');  //业务部门id
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
        $this->startTime            = $startTime;
        $this->endTime              = $endTime;
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
    public function public_user_kpi_statis(){
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
        $this->display('user_kpi_statis');
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

    // @@@NODE-3###public_user_kpi_score_info###顾客满意度分项统计记录详情###
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

    //内部人员满意度
    public function satisfaction(){
        $year               = I('year',date('Y'));
        $month              = I('month',date('m'));
        $yearMonth          = I('yearMonth')?I('yearMonth'):$year.$month;
        $lists              = $this->get_satisfaction_list($yearMonth);

        $this->lists        = $lists;
        $this->yearMonth    = $yearMonth;
        $this->year         = $year;
        $this->month        = $month;
        $this->prveyear     = $year-1;
        $this->nextyear     = $year+1;
        $this->display();
    }

    public function get_satisfaction_list($yearMonth){
        $mod                            = D('Inspect');
        $db                             = M('satisfaction');
        $satisfaction_config_db         = M('satisfaction_config');
        $satisfaction_lists             = $db->where(array('monthly'=>$yearMonth))->select(); //所有的已评分列表
        $should_users_lists             = $satisfaction_config_db->where(array('month'=>$yearMonth))->select(); //所有当月应评分信息
        $user_lists                     = array_keys(C('SATISFACTION_USERS'));

        $lists                          = array();
        foreach ($user_lists as $k=>$v){
            $should_users               = array(); //应评分人员
            $input_userids              = array(); //已评价人员
            $unscore_userids            = array(); //未评价人员
            $info                       = array();

            foreach ($should_users_lists as $sk=>$sv){
                if ($sv['user_id']==$v){
                    $should_users[]     = $sv['score_user_id'];
                }
            }

            foreach ($satisfaction_lists as $key=>$value){
                if ($value['monthly']==$yearMonth && $value['account_id']==$v){
                    $info[]             = $value;
                    $input_userids[]    = $value['input_userid'];
                }
            }

            foreach ($should_users as $kk=>$vv){
                if (!in_array($vv,$input_userids)){
                    $unscore_userids[]  = $vv;
                }
            }
            $unscore_user_lists         = M('account')->where(array('id'=>array('in',$unscore_userids)))->getField('nickname',true);

            $average_data               = $mod->get_average_data($info,$unscore_userids);
            $lists[$k]['monthly']       = $yearMonth;
            $lists[$k]['account_id']    = $v;
            $lists[$k]['account_name']  = M('account')->where(array('id'=>$v))->getField('nickname');
            $lists[$k]['average_AA']    = $average_data['average_AA'];
            $lists[$k]['average_BB']    = $average_data['average_BB'];
            $lists[$k]['average_CC']    = $average_data['average_CC'];
            $lists[$k]['average_DD']    = $average_data['average_DD'];
            $lists[$k]['average_EE']    = $average_data['average_EE'];
            $lists[$k]['average_FF']    = $average_data['average_FF'];
            $lists[$k]['sum_average']   = $average_data['sum_average'];
            $lists[$k]['score_accounts']= $average_data['score_account_name'];
            $lists[$k]['unscore_users'] = implode(',',$unscore_user_lists);
        }
        return $lists;
    }


    //增加内部评分信息
    public function satisfaction_add(){
        $db                             = M('satisfaction');
        $satisfaction_config_db         = M('satisfaction_config');
        $score_dimension_db             = M('score_dimension');
        if (isset($_POST['dosubmint']) && $_POST['dosubmint']){
            $info                       = I('info');
            $data                       = I('data');
            $info['problem']            = trim(I('problem'));
            $info['content']            = trim(I('content'));
            $info['input_userid']       = session('userid');
            $info['input_username']     = session('name');
            $info['create_time']        = NOW_TIME;
            $info['monthly']            = trim(I('monthly'));
            if (!$info['monthly']) $this->error('考核月份不能为空');

            $unok_arr                   = array(1,2,3);
            if ((in_array($info['AA'],$unok_arr) || in_array($info['BB'],$unok_arr) || in_array($info['CC'],$unok_arr) || in_array($info['DD'],$unok_arr) || in_array($info['EE'],$unok_arr)) && !$info['content']) $this->error('单项评分低于3分时,必须填写评价内容');
            $score_users                = $satisfaction_config_db->where(array('month'=>$info['monthly'],'user_id'=>$info['account_id']))->getField('score_user_id',true);
            if (!in_array(session('userid'),$score_users)) $this->error('您不在'.$info['account_name'].'的评分人列表!',U('Inspect/satisfaction'));

            $where                      = array();
            $where['monthly']           = $info['monthly'];
            $where['input_userid']      = $info['input_userid'];
            $where['account_id']        = $info['account_id'];
            $list                       = $db->where($where)->find();
            if ($list){
                $this->error('您本月已经完成对'.$info['account_name'].'的评价',U('Inspect/satisfaction'));
            }else{
                if (!$info['AA']) $this->error('获取评分数据失败');
                $res                        = $db->add($info);
                if ($res){
                    $data['satisfaction_id']= $res;
                    $data['account_id']     = $info['account_id'];
                    $data['account_name']   = $info['account_name'];
                    $score_dimension_db->add($data);
                    $this->success('数据保存成功',U('Inspect/satisfaction'));
                }else{
                    $this->error('数据保存失败');
                }
            }
        }else{
            $this->userkey  = get_username();
            $this->display('satisfaction_add');
        }
    }

    //得分详情
    public function satisfaction_detail(){
        $mod                        = D('Inspect');
        $db                         = M('satisfaction');
        $satisfaction_config_db     = M('satisfaction_config');
        $uid                        = I('uid');
        $month                      = I('month');
        $should_users               = $satisfaction_config_db->where(array('user_id'=>$uid,'month'=>$month))->getField('score_user_id',true); //应评分人员
        if (!$uid) $this->error('获取数据失败');

        $where                      = array();
        $where['monthly']           = $month;
        $where['account_id']        = $uid;
        $info                       = $db->where($where)->select();
        $input_userids              = array_column($info,'input_userid'); //已评分人员

        $unscore_userids            = array();
        foreach ($should_users as $kk=>$vv){
            if (!in_array($vv,$input_userids)){
                $unscore_userids[]  = $vv;
            }
        }
        $unscore_user_lists         = M('account')->where(array('id'=>array('in',$unscore_userids)))->getField('nickname',true);

        $list                       = $mod->get_average_data($info,$unscore_userids);
        $list['monthly']            = $month;
        $list['account_name']       = M('account')->where(array('id'=>$uid))->getField('nickname');
        $dimension                  = $this->get_user_dimension($uid); //获取考核维度
        //$contents                   = array_filter(array_column($info,'content'));
        $contents                   = $this->get_contents($info);
        $list['AA']                 = $dimension['AA'];
        $list['BB']                 = $dimension['BB'];
        $list['CC']                 = $dimension['CC'];
        $list['DD']                 = $dimension['DD'];
        $list['EE']                 = $dimension['EE'];
        $list['FF']                 = $dimension['FF'];
        $list['unscore_users']      = implode(',',$unscore_user_lists);
        $this->list                 = $list;
        $this->contents             = $contents;
        $this->display('satisfaction_detail');
    }

    public function get_contents($lists){
        $data                       = array();
        foreach ($lists as $k => $v){
            if ($v['problem']){
                $data[$k]['problem'] = $v['problem'];
                $data[$k]['content'] = $v['content'];
            }
        }
        return $data;
    }

    //评价详情
    public function satisfaction_info(){
        $uid                        = trim(I('uid'));
        $month                      = trim(I('month'));
        $dimension                  = $this->get_user_dimension($uid); //获取考核维度
        $db                         = M('satisfaction');
        $lists                      = $db->where(array('account_id'=>$uid,'monthly'=>$month))->select();
        foreach ($lists as $k=>$v){
            $lists[$k]['AA']        = $v['AA']?$v['AA']:'<font color="#999999">未考核</font>';
            $lists[$k]['BB']        = $v['BB']?$v['BB']:'<font color="#999999">未考核</font>';
            $lists[$k]['CC']        = $v['CC']?$v['CC']:'<font color="#999999">未考核</font>';
            $lists[$k]['DD']        = $v['DD']?$v['DD']:'<font color="#999999">未考核</font>';
            $lists[$k]['EE']        = $v['EE']?$v['EE']:'<font color="#999999">未考核</font>';
            $lists[$k]['FF']        = $v['FF']?$v['FF']:'<font color="#999999">未考核</font>';
            $lists[$k]['average']   = $this->get_one_sattisfaction_average($v);
        }

        $this->lists                = $lists;
        $this->dimension            = $dimension;
        $this->display();
    }

    //获取单词评分的内部满意度
    private function get_one_sattisfaction_average($info){
        $get_score                  = $info['AA'] + $info['BB'] + $info['CC'] + $info['DD'] + $info['EE'] + $info['FF']; //得分
        $sum_score                  = 0; //总分
        if ($info['AA']) $sum_score += 5;
        if ($info['BB']) $sum_score += 5;
        if ($info['CC']) $sum_score += 5;
        if ($info['DD']) $sum_score += 5;
        if ($info['EE']) $sum_score += 5;
        if ($info['FF']) $sum_score += 5;
        $average                    = (round($get_score/$sum_score,2)*100).'%';
        return $average;
    }

    public function get_user_dimension($uid){
        $db                         = M('score_dimension');
        $list1                      = $db->where(array('account_id'=>array('eq',$uid),trim('FF')=>array('neq','')))->order($this->orders('id'))->find(); //六项
        $list2                      = $db->where(array('account_id'=>array('eq',$uid),trim('EE')=>array('neq','')))->order($this->orders('id'))->find(); //五项
        $list3                      = $db->where(array('account_id'=>array('eq',$uid),trim('DD')=>array('neq','')))->order($this->orders('id'))->find(); //四项
        $list4                      = $db->where(array('account_id'=>array('eq',$uid),trim('CC')=>array('neq','')))->order($this->orders('id'))->find(); //三项
        $list                       = $list1?$list1:($list2?$list2:($list3?$list3:$list4));
        return $list;
    }

    public function del_satisfaction(){
        $db                             = M('satisfaction');
        $id                             = trim(I('id'));
        if ($id){
            $res                        = $db->where(array('id'=>$id))->delete();
            if ($res){
                M('score_dimension')->where(array('satisfaction_id'=>$id))->delete();
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('删除失败');
        }
    }

    //内部满意度评分人配置
    public function satisfaction_config(){
        $year                       = I('year',date('Y'));
        $month                      = I('month',date('m'));
        $yearMonth                  = I('yearMonth')?I('yearMonth'):$year.$month;
        $users                      = C('SATISFACTION_USERS');
        $db                         = M('satisfaction_config');
        $lists                      = array();
        foreach ($users as $k=>$v){
            $list                   = $db->where(array('year'=>$year,'month'=>$yearMonth,'user_id'=>$k))->select();
            $lists[$k]['user_id']   = $k;
            $lists[$k]['user_name'] = $v;
            $lists[$k]['score_users']=implode(',',array_column($list,'score_user_name'));
        }

        $this->lists                = $lists;
        $this->yearMonth            = $yearMonth;
        $this->year 	            = $year;
        $this->month                = $month;
        $this->prveyear	            = $year-1;
        $this->nextyear	            = $year+1;
        $this->display();
    }

    //编辑内部人员满意度评分人配置
    public function satisfaction_config_edit(){
        $year                       = I('year',date('Y'));
        $month                      = I('month')?I('month'):date('Ym');
        $userid                     = I('userid');
        $username                   = trim(I('username'));
        $db                         = M('satisfaction_config');
        $lists                      = $db->where(array('year'=>$year,'month'=>$month,'user_id'=>$userid))->select();

        $this->userkey              = get_username();
        $this->lists                = $lists;
        $this->userid               = $userid;
        $this->username             = $username;
        $this->year                 = $year;
        $this->month                = $month;
        $this->display();
    }

    public function public_save_satisfaction_config(){
        if (isset($_POST['dosubmint'])){
            $db                             = M('satisfaction_config');
            $info                           = I('info');
            $data                           = I('data');
            if (!$info['userid']) $this->error('数据错误');
            $num                            = 0;
            if ($data){
                $del_ids                    = array();
                foreach ($data as $k=>$v){
                    $conf                   = array();
                    $conf['user_id']        = $info['userid'];
                    $conf['user_name']      = trim($info['user_name']);
                    $conf['year']           = $info['year'];
                    $conf['month']          = $info['month'];
                    $conf['score_user_id']  = $v['score_user_id'];
                    $conf['score_user_name']= $v['score_user_name'];
                    if ($v['resid']){
                        $del_ids[]          = $v['resid'];
                        $res                = $db->where(array('id'=>$v['resid']))->save($conf);
                        if ($res) $num++;
                    }else{
                        $conf['input_time'] = NOW_TIME;
                        $res                = $db->add($conf);
                        $del_ids[]          = $res;
                        if ($res) $num++;
                    }
                }
                $where                      = array();
                $where['year']              = $info['year'];
                $where['month']             = $info['month'];
                $where['user_id']           = $info['userid'];
                $where['id']                = array('not in',$del_ids);
                $db->where($where)->delete();
                echo '<script>window.top.location.reload();</script>';
            }else{
                $this->error('数据不能为空');
            }
        }
    }

    //不合格处理率(公司)
    public function unqualify(){
        $this->title('不合格处理率');
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $times                      = get_cycle($yearMonth);
        $mod                        = D('Inspect');
        $data                       = $mod->get_unqualify_data($times['begintime'],$times['endtime']);
        $sum_data                   = $mod->get_sum_timely($data);

        $this->sum                  = $sum_data;
        $this->lists                = $data;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;
        $this->display();
    }

    //不合格率指标
    public function unqualify_list(){
        $this->title('考核指标管理');
        $lists                      = get_timely(2);
        $this->lists                = $lists;
        $this->display();
    }

    //编辑不合格处理率指标
    public function unqualify_edit(){
        $db                         = M('quota');
        $id                         = I('id');
        if ($id){
            $list                   = $db->find($id);
            $list['title']          = htmlspecialchars_decode($list['title']);
            $list['content']        = htmlspecialchars_decode($list['content']);
            $list['rules']          = htmlspecialchars_decode($list['rules']);
            $this->list             = $list;
        }
        $this->display();
    }

    //删除指标
    public function unqualify_del(){
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $res                        = timely_quota_del($id);
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //不合格处理率详情
    public function public_unqualify_detail(){
        $this->title('不合格处理率详情');
        $isop                   = I('isop','');
        //$opids                  = I('opids','');
        $ids                    = I('ids','');
        $startTime              = I('st',0);
        $endTime                = I('et',0);
        $type                   = I('tp',0);
        $mod                    = D('Inspect');

        $this->type             = $type;
        if ($isop){ //团内
            $lists              = $mod -> get_op_unqualify_list($type,$startTime,$endTime);
            $this->lists        = $lists;
            $this->display('unqualify_detail_op');
        }else{
            $lists              = $mod -> get_nop_unqualify_list($ids);
            $this->lists        = $lists;
            $this->display('unqualify_detail_nop');
        }
    }

    //不合格处理率(员工)
    public function unqualify_staff(){
        $this->title('不合格处理率');
        $year		                = I('year',date('Y'));
        $month		                = I('month',date('m'));
        if (strlen($month)<2) $month= str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                  = $year.$month;
        $mod                        = D('Inspect');
        $data                       = $mod->get_unqualify_staff_data($yearMonth);

        $this->lists                = $data;
        $this->year 	            = $year;
        $this->month 	            = $month;
        $this->prveyear             = $year-1;
        $this->nextyear             = $year+1;

        $this->display();
    }

    public function public_save(){
        $savetype                   = I('savetype');
        if (isset($_POST['dosubmint']) && $savetype){

            //保存不合格指标
            if ($savetype == 1){
                $db                 = M('quota');
                $id                 = I('id');
                $info               = I('info');
                $info['title']      = htmlspecialchars(trim($info['title']));
                $info['content']    = htmlspecialchars(trim($info['content']));
                $info['rules']      = htmlspecialchars(trim($info['rules']));
                $info['type']       = 2; //2=>不合格处理率
                if(!$info['title']) $this->error('指标标题不能为空');

                if ($id) {
                    $where          = array();
                    $where['id']    = $id;
                    $res            = $db->where($where)->save($info);
                }else{
                    $res            = $db->add($info);
                }

                echo '<script>window.top.location.reload();</script>';
            }
        }
    }
}