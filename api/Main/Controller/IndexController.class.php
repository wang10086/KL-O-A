<?php
namespace Main\Controller;
use Think\Controller;
ulib('Jodes');
use Sys\Jodes;
use Sys\P;
class IndexController extends Controller {
	
	
	/*接口测试*/
	public function test(){
		
		
		if(isset($_POST['cval']) && isset($_POST['aval']) && isset($_POST['code']) ){
			$des = C('API_DES_KEY');
			$ver = C('API_PAR_KEY');
			
			$this->cval = I('cval');
			$this->aval = I('aval');
			$this->code = I('code');
			
			
			$endes = new Jodes();
	
			$encode = $endes->encode($this->code,$des);
	
			$verify = md5($encode.$ver);
			
			$this->url =  C('WEB_PATH').'api.php?c='.$this->cval.'&a='.$this->aval.'&auth='.$encode.'&verify='.$verify;
			
			$this->encode = $encode;
			$this->verify = $verify;
			
			$this->jieguo = file_get_contents($this->url);
			
			$this->display('index');	
			
		}else{
			$this->display('index');		
		}
		
		

	}
	
	
	
}