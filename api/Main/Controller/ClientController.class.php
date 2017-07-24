<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
use Think\Upload;
class ClientController extends BaseController {
	
	
	
	/****** 获取配置项 ******/
	public function config(){
		
		//获取解码后参数
		$param = $this->param_data;
		
		$ages            = C('AGE_LIST');
		$prokinds        = M('project_kind')->getField('id,name',true);
		
		$return = array();
		$return['ages']        = $ages;
		$return['prokinds']    = $prokinds;
		
		echo return_result($return);
		
	}
	
	
	
	/****** 获取项目信息 ******/
	public function op(){
		
		//获取解码后参数
		$param = $this->param_data;
		
		$opid  = trim($param['gid']);
		
		$pro   = M('op')->field('id,project,op_id as opid,group_id as gid,status,op_create_user as dept')->where(array('group_id'=>$opid))->find();
		
		echo return_result($pro);
		
	}
	
	
	
}