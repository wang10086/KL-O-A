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
		$id 		= I('id');
		$uname  	= I('uname');
		$rname  	= I('rname');
		$problem 	= I('problem','-1');
		$solve		= I('solve','-1');
		
		$where = array();
		/*
		if($id) 			$where['id']					= $id; 
		if($title)			$where['title']					= array('like','%'.$title.'%');
		if($type)			$where['type']					= $type;
		if($uname)			$where['ins_uname']				= array('like','%'.$uname.'%');
		if($rname)			$where['liable_uname']			= array('like','%'.$rname.'%');
		if($problem!='-1') 	$where['problem']				= $problem; 
		if($solve!='-1') 	$where['issolve']				= $solve; 
		*/
		
		//分页
		$pagecount		= $db->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        
		
		$typestr	= C('INS_TYPE');
		$problem 	= array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">有问题</span>');
		$issolve 	= array('0'=>'<span class="red">未解决</span>','1'=>'<span class="green">已解决</span>');
 
		$lists 		= $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('rec_time'))->select();
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
		$this->type 		= $typestr;
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
		
		$insid			= I('insid');
		$db				= M('inspect');
		$typestr		= C('INS_TYPE');
		$problem 		= array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">有问题</span>');
		$issolve 		= array('0'=>'<span class="red">未解决</span>','1'=>'<span class="green">已解决</span>');
		$deptlist 		= M('role')->where('`id`>10')->GetField('id,role_name',true);
		
		
		//获取默认素材
		$attid = array();
		$attachment = M('attachment')->field('id')->where(array('catid'=>321,'rel_id'=>$insid))->select();  //
		foreach($attachment as $v){
			$attid[] = 	$v['id'];
		}
		
		$row			= $db->find($insid);
		
		$row['problem'] 		= $problem[$row['problem']];	
		$row['issolve'] 		= $row['problem'] ? $issolve[$row['issolve']] : '';	
		$row['duixiang'] 		= $row['type']==1 ? $row['group_id'] : $row['ins_dept_name'];
		$row['type'] 			= $typestr[$row['type']];	
		$row['create_time'] 	= date('Y-m-d H:i:s',$row['create_time']);
		$row['ins_date'] 		= $row['ins_date'] ? date('Y-m-d',$row['ins_date']) : '';
		
			
		
		$this->deptlist 	= $deptlist;
		$this->solve 		= $solve;
		$this->problem 		= $problem;
		$this->type 		= $typestr;
		$this->row			= $row;
		$this->atts        	= implode(',',$attid);
		$this->display('detail');
	}
	
	
    
}