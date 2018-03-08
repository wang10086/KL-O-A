<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class WorkController extends BasepubController{
	
	// @@@NODE-3###record###工作记录###
    public function record(){
		
        $this->title('工作记录');
		
		$db		= M('work_record');
		$kinds	= C('REC_TYPE');
		
		$title	= I('title');		//项目名称
		$type 	= I('type');
		$id 	= I('id');
		$uname  = I('uname');
		$rname  = I('rname');
		$month  = I('month');
		$com	= I('com',0);
		$status = I('status','-1');
		
		$where = array();
		
		if($id) 			$where['id']					= $id; 
		if($month) 			$where['month']					= $month; 
		if($title)			$where['title']					= array('like','%'.$title.'%');
		if($type)			$where['type']					= $type;
		if($uname)			$where['user_name']				= array('like','%'.$uname.'%');
		if($rname)			$where['rec_user_name']			= array('like','%'.$rname.'%');
		if($com==1) 		$where['user_id']				= cookie('userid');		
		if($com==2) 		$where['rec_user_id']			= cookie('userid');	
		if($status!='-1')  	$where['status']			= $status;	
		
		//分页
		$pagecount		= $db->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        
		
		$sta = array('0'=>'<span class="green">正常</span>','1'=>'<span class="red">已撤销</span>');
       
		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('rec_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['kinds'] 	= $kinds[$v['type']];	
			$lists[$k]['rec_time'] 	= date('Y-m-d H:i:s',$v['rec_time']);
			$lists[$k]['status'] 	= $sta[$v['status']];
		}
		
		
		$this->com 			= $com;
		$this->lists   		= $lists;  
		$this->kinds 		= $kinds;
		$this->opid 		= $opid;
		$this->type 		= $type;
		$this->display('record');
    }
	
	
	// @@@NODE-3###addrecord###创建记录###
	public  function  addrecord(){
		
		$recid			= 0;//I('recid');
		$db				= M('work_record');
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$info		= I('info');
			$com		= I('com');
			$recid 		= I('recid');
			
			if(!$info['user_name'])		$this->error('请输入工作人员信息' . $db->getError());
			if(!$info['user_id'])		$this->error('请输入工作人员信息无效' . $db->getError());	
			if(!$info['month'])			$this->error('请输入工作月份' . $db->getError());	
			if(!$info['type'])			$this->error('请选择工作记录类型' . $db->getError());	
			if(!$info['title'])			$this->error('请输入记录标题' . $db->getError());	
			if(!$info['content'])		$this->error('请输入记录内容' . $db->getError());	
			
			
			$info['rec_user_id']	= cookie('userid');
			$info['rec_user_name']	= cookie('name');
			$info['status']			= 0;
			$info['year']			= substr($info['month'], 0, 4);
			
			//保存主表
			if($reid){
				$db->where(array('id'=>$recid))->data($info)->save();	
			}else{
				$info['rec_time']		= time();
				$reid = $db->add($info);	
			}
			
			$send 		= cookie('userid');
			$title 		= '工作记录：'.$info['title'];
			$content 	= $info['content'];
			$user		= '['.$info['user_id'].']';
			$url		= U('Work/record',array('id'=>$reid));
			
			//发送消息
			send_msg($send,$title,$content,$url,$user);
			
			
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
		
			
			$this->kinds 		= C('REC_TYPE');
			$this->rec			= M('work_record')->find($recid);
			$this->display('addrecord');
		}
	}
	
	
	
	// @@@NODE-3###revoke###撤销记录###
	public  function  revoke(){
		
		$recid			= I('recid');
		$db				= M('work_record');
		
		//查询记录
		$rec			= $db->find($recid);
		
		
		if(!$rec || !$recid)		$this->error('记录不存在' . $db->getError());
		if($rec['status']==1)		$this->error('记录已经撤销' . $db->getError());
		
		if($rec['rec_user_id'] == cookie('userid')  || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==54){
			
			//执行撤销
			$db->where(array('id'=>$recid))->data(array('status'=>1))->save();	
			$this->success('撤销成功！');
			
		}else{
			$this->error('您没有权限撤销' . $db->getError());
		}
		
		
		
	}
	
    
}