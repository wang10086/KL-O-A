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
		
		$kinds   =  M('project_kind')->getField('id,name', true);
			
		$gid   = trim($param['gid']);
		$opid  = trim($param['opid']);
		
		if($op_id){
			$where = 'group_id = "'.$gid.'" OR op_id = '.$opid;
		}else{
			$where = 'group_id = "'.$gid.'"';
		}
		
		$pro   = M('op')->field('id,project,op_id as opid,group_id as gid,status,op_create_user as dept,kind')->where($where)->find();
	
		$pro['kind'] = $kinds[$pro['kind']];
		
		echo return_result($pro);
		
	}
	
	
	
}