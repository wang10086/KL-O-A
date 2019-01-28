<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

class MessageController extends BasepubController {
	
	//消息列表
	public function index(){
	
		
		$db = M('message');
		
		$type = I('type',0);
		
		if($type==0){
			
			//获取已读消息
			$read     = M('message_read')->where(array('user_id'=>cookie('userid')))->Getfield('msg_id',true);
			$readstr  = implode(',',$read);
			
			$where = '(m.receive_user like "%['.cookie('userid').']%"  OR  m.receive_role like "%['.cookie('roleid').']%") ';
			if($readstr) $where .= ' AND m.id NOT IN ('.$readstr.')';
		}else{
			$where = '(m.receive_user like "%['.cookie('userid').']%"  OR  m.receive_role like "%['.cookie('roleid').']%") AND r.read_time > 0 AND r.del = 0';	
		}
		
		
		$type = I('type','-1');
		$keywords = I('keywords');
		
		
		//分页
		$pagecount = M()->table('__MESSAGE__ as m')->field('m.*,r.user_id,r.read_time,r.del')->where($where)->join('__MESSAGE_READ__ as r on r.msg_id = m.id','LEFT')->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('m.send_time'))->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		
		//查询
		$status = C('STATUS_STR');
		
		$datalist = M()->table('__MESSAGE__ as m')->field('m.*,r.user_id,r.read_time,r.del')->where($where)->join('__MESSAGE_READ__ as r on r.msg_id = m.id','LEFT')->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('m.send_time'))->select();
		foreach($datalist as $k=>$v){
			//read_msg($v['id']);
			$datalist[$k]['send_user'] = $v['send_user'] ? username($v['send_user']) : '系统';
		}
		
		$this->type     = $type;
		$this->datalist = $datalist;
		
		
		
		$this->display('index');
		
	}
	
	
	
	
	//查看消息
	public function info(){
		
		$db = M('message');
		$id = I('id');
		
		//判断是否有权限阅读
		$where = '( `receive_user` like "%['.cookie('userid').']%"  OR  `receive_role` like "%['.cookie('roleid').']%" ) AND `id`='.$id;
		$msg = $db->where($where)->find();
		if(!$msg){
			$this->error('消息不存在！');	
		}else{
			read_msg($id);    //记录阅读状态
			$this->row = $msg;
			$this->display('message_info');
		}
		
		
	}
	
	
	//删除消息
	public function del(){
		$db = M('message');
		$id = I('id');
		//判断是否有权限阅读
		$where = '( `receive_user` like "%['.cookie('userid').']%"  OR  `receive_role` like "%['.cookie('roleid').']%" ) AND `id`='.$id;
		$msg = $db->where($where)->find();
		if(!$msg){
			$this->error('消息不存在！');	
		}else{
			del_msg($id);    //记录阅读状态
			$this->success('删除成功！');	
		}
	}
	
	
	
	
	function noticeinfo(){
		$id = I('id');
		$this->row = M('notice')->find($id);
		$this->display('noticeinfo');
	}
	
	
	function msginfo(){
		$id = I('id');
		$row = M('message')->find($id);
		$row['send_user'] = $row['send_user'] ? username($row['send_user']) : '系统消息';
        read_msg($id);    //记录阅读状态
		$this->row  = $row;
		$this->display('msginfo');
	}
	
	
	
}
	