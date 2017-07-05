<?php
namespace Main\Controller;
use Think\Controller;
use Think\Log;
use Sys\P;
ulib('Jodes');
use Sys\Jodes;
ulib('Behavior');
use Sys\Behavior;

class BaseController extends Controller {
    
	protected $param_data;
	
	// 初始化函数
	public function _initialize(){	
		
		$openaction = C('OPEN_ACTION');
		
		if (!in_array(ACTION_NAME, $openaction)){
			
			//获取参数
			$auth    = I('get.auth');
			$verify  = I('get.verify');
			
			if($auth && $verify){
				
				//验证数据是否合法
				if(md5($auth.C('API_PAR_KEY')) != $verify)  die(return_error(P::ERR_PARAM_ILLEGAL));
				
				//解码参数
				$dedes = new Jodes();
				$auth = $dedes->decode($auth,C('API_DES_KEY'));
				
				$this->param_data = array();
				foreach(explode('&',html_entity_decode($auth)) as $v){
					$sp = explode('=',$v); 
					$this->param_data[$sp[0]] = $sp[1];
				}
				
			}else{
				die(return_error(P::ERR_PARAM_UNKNOWN));
			}
		}

	}
	
	
}


