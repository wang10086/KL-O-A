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
	
	
	
}