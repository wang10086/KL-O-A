<?php
// 加载参数类

import ('P', COMMON_PATH . 'Common/'); 
use Sys\P;

/**
 * @brief  载入第三方类库
 * @param  string  $class   要加载的类名（含路径）
 * @return
 */
function ulib ($class) {
    import($class, THINK_PATH . '../ulib/');
}

/** 
 * @desc  im:通过IP获取IP所在城市以及运营商信息 
 * @param (string)$char IP 
 * @return   Array
 */  
function ipku($ipval = null){
	
	$ip = $ipval ? $ipval :get_client_ip();
	
	//淘宝IP库
	$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
	//新浪IP库
	//$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$ip;
	
	$arr=json_decode(file_get_contents($url),true);
	
	return $arr['data'];

}


/*打印数组用于调试*/
function P($var, $stop = true){
	header("Content-Type: text/html;charset=utf-8"); 
    echo '<pre>';
	print_r($var);
	echo '</pre>';
	if ($stop) die();	
}


/**
 * @desc  返回错误信息
 * @param Int  错误代号
 * @return JSON 
 */ 
function return_error($code){	   
	
	$arr = explode('=',$code);
	$data['status'] = $arr[0];
	$data['msg']  = $arr[1]; 
    return json_encode($data,JSON_UNESCAPED_UNICODE);   
}

/**
 * @desc  API返回结果
 * @param Int 返回数据
 * @return JSON 
 */ 
function return_result($array='0'){	   
	if(!is_array($array) && $array!='0'){
		$array = json_decode($array, true);	
	}
	$data['status'] = 0;
	if($array!=0) $data['ret']  = $array; 
    return json_encode($data,JSON_UNESCAPED_UNICODE);   
}


/**
 * @desc  DES加密
 * @param $input 字符串
 * @param $key   密钥
 * @return JSON 
 */ 
function mencrypt($input, $key){
	$input = str_replace(array("\n","\t","\r"), array("","",""), $input);
	$key = substr(md5($key), 0, 24);
	$td = mcrypt_module_open('tripledes', '', 'ecb', '');
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	mcrypt_generic_init($td, $key, $iv);
	$encrypted_data = mcrypt_generic($td, $input);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	$rts = base64_encode($encrypted_data);
	$rts = str_replace(array('+','='), array('_','.'), $rts);
	return $rts;
}
	
/**
 * @desc  DES解密
 * @param $input 字符串
 * @param $key   密钥
 * @return JSON 
 */ 	
function mdecrypt($input, $key){
	$input = str_replace(array("_",".","\n","\t","\r"), array("+","=","","",""), $input);
	$input = base64_decode($input);
	$td = mcrypt_module_open('tripledes', '', 'ecb', '');
	$key = substr(md5($key), 0, 8);
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	mcrypt_generic_init($td, $key, $iv);
	$decrypted_data = mdecrypt_generic($td, $input);
	mcrypt_generic_deinit($td);
	mcrypt_module_close($td);
	return $decrypted_data;
} 


