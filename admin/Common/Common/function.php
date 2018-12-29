<?php
// 加载参数类
import ('P', COMMON_PATH . 'Common/'); 
use App\P;
ulib('Pinyin');
use Sys\Pinyin;
require_once 'GetKpi.php';

/**
 * @brief  载入第三方类库
 * @param  string  $class   要加载的类名（含路径）
 * @return
 */
function ulib ($class) {
    import($class, THINK_PATH . '../ulib/');
}


/*redis*/
function redis($key,$val=null){
	//global $redis_server;
	//if (!$redis_server) {
	   $redis_server = new \Redis();	
	   $redis_server->connect( C('REDIS_HOST'), C('REDIS_PORT'));
		//$redis_server->auth(ccc);
	//}
	if($val){
		$redis_server->set($key, $val);	
		
	}else{
		 $val = $redis_server->get($key);
	}
	$redis_server->close();
	return $val;
}


/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='') {
    $pwd = array();
    $pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();
    $pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}

/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6) {
    return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
* 产生随机字符串
* @param    int        $length  输出长度
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 判断菜单是否有权限显示
 * @text String 如"Index/index"
 * @return 1为有权限显示、0为无权限显示
 */
function rolemenu($obj){
	
	
	$menu = array();
	//默认样式
	$style =  0;	
	//判断是否为开发者权限
	if(session(C('ADMIN_AUTH_KEY'))){
		$style = 1;
	}else{
		
		foreach($obj as $bb=>$unit){
			$text = strtoupper($unit);
			if($_SESSION['_ACCESS_LIST']){
				if(is_array($_SESSION['_ACCESS_LIST']['MAIN'])){
					foreach($_SESSION['_ACCESS_LIST']['MAIN'] as $k=>$v){
						foreach($v as $a=>$b){
							$menu[] = $k.'/'.$a;
						}
					}
					if(in_array($text,$menu)){
						$style = 1;	
					}
				}
			}
		}
		
	}

	return $style;	
}

//用户关系递归
function Userrelation($id = 0) { 
    global $str; 
	$db = M('admin');
	$guanxibiao = $db->field('id,parentid')->where(array('parentid'=>$id))->select();
    if($guanxibiao){
		foreach ($guanxibiao as $row){
            $str .= $row['id']. ",";
            Userrelation($row['id']);
		}
    } 
    return $str; 
} 

//角色关系递归
function Rolerelation($id = 0,$type = 0) { 
    global $str; 
	$db = M('role');
	$guanxibiao = $db->field('id,pid')->where(array('pid'=>$id))->select();
    if($guanxibiao){
		foreach ($guanxibiao as $row){
            $str .= $row['id']. ",";
            Rolerelation($row['id']);
		}
    } 
	
	if($type==1){
		 $str .= $id. ",";
	}
	
	$role = trim($str,',');
	
	//返回用户ID
	$user = array();
	$user = M('account')->where(array('roleid'=>array('in',$role)))->Getfield('id',true);	
	if($type==0){
		$user[] = cookie('userid');
	}
	$data = implode(',',$user);
		
	
	//if($type){
		
	//}else{
		//返回角色ID
		//$data = $role;	
	//}
    return $data; 
} 

//渠道关系递归
function Dealerrelation($id = 0) { 
    global $str; 
	$db = M('dealer');
	$guanxibiao = $db->field('id,parentid')->where(array('parentid'=>$id))->select();
    if($guanxibiao){
		foreach ($guanxibiao as $row){
            $str .= $row['id']. ",";
            Dealerrelation($row['id']);
		}
    } 
    return $str; 
} 

/**
* 状态输出
* @param    int        $status  状态
* @return   String     $status对应的显示状态
*/
function statustr($status){
	if($status==1){
		return '<font color="#009900">正常</font>';
	}else{
		return '<font color="#cc0000">异常</font>';
	}
}


function merge_node($node, $access, $pid = 0) {
	$arr = array();
	foreach ($node as $v) {
		if (is_array($access)) {
	        $v['access'] = in_array($v['id'], $access) ? 1 : 0;	
	    }
	    if ($v['pid'] == $pid) {
		    $v['child'] = merge_node($node, $access, $v['id']);
			$arr[] = $v;	
		}
	}
	return $arr;
}

//
function ck ($str, $val, $yes = ' checked="checked" ', $no = ''){
    if (is_int($str)) return $str == $val ? $yes : $no;
    if (empty($str) && $val == "0" ) return $yes;
    return strpos($str, $val) === 0 ? $yes : $no;
}

function hide ($str, $val, $yes = ' style="display:none;" ', $no = ''){
    if (empty($str) && $val == "0" ) return $yes;
    return strpos($str, $val) === 0 ? $yes : $no;
}

function sel ($str, $val, $yes = ' selected ', $no = ''){
    if (is_int($str)) return $str == $val ? $yes : $no;
    if (empty($str) && $val =="0" ) return $yes;
    return $str == $val ? $yes : $no;
}

function ison ($str, $val, $yes = 'active', $no =''){
    return ck($str, $val, $yes, $no);
}


function P($var, $stop = true){
	header("Content-Type: text/html;charset=utf-8"); 
    echo '<pre>';
	print_r($var);
	echo '</pre>';
	if ($stop) die();	
}


/**
 * 编辑器
**/
function editor($editor_name, $default = '', $editor_id = '') {
	$str = '';
	if(!defined('EDITOR_INIT')) {
		$str .= '<script type="text/javascript" src="' .__ROOT__. '/admin/assets/comm/ckeditor/ckeditor.js"></script>';
				
		define('EDITOR_INIT', 1);
	}     
	if (empty($editor_id)) $editor_id = preg_replace("/\[\]/", "_", $editor_name);
	return $str.'<textarea class="ckeditor" name="'.$editor_name.'" id="'.$editor_id.'" >'.$default.'</textarea>';
}

function upload_image($name,$uptext = '上传图片', $default = '', $multi = true) {
    $str = '';    
	if (!defined('INIT_UPLOAD_IMAGE')) {
		  $str .= '<script type="text/javascript" src="' .__ROOT__. '/admin/assets/comm/upfile.js"></script>';
		  //$str .= '<link rel="stylesheet" href="'. __ASSETS__. 'css/upload_img.css" />';
		  define('INIT_UPLOAD_IMAGE', 1);
	}
	
	$show = '';
	$values = array();
	if (!empty($default)) {
		if (preg_match('/^(\d+,?)+$/', $default)) {
		    $db = M('attachment');
		    $rs = $db->where("id in (".$default.")")->select();
			$i = 0;
			foreach($rs as $line) {
			    $values[$i]['id'] = $line['id'];
				$values[$i]['thumb'] =  dirname($line['filepath']). "/thumb_80_60_" . basename($line['filepath']);
				$values[$i]['imgurl'] = $line['filepath'];
				$i++;
			}
		} else {
			$i = 0;
			foreach(explode(",", $default) as $img) {
				if (empty($img)) continue;
		        $values[$i]['id'] = '';
				if (strpos($img, 'http://') === false) {
				    $values[$i]['thumb'] = dirname($img). "/thumb_80_60_" . basename($img);
				} else {
					$values[$i]['thumb'] = $img;
				}
				$values[$i]['imgurl'] = $img;
				$i++;
			}
		}
	}
	
	$close = $multi ? '<div class="closeimg"><a href="javascript:;" onclick="javascript:g_remove_img(this);" class="iclose"></a></div>' : '';
	$arr = $multi ? '[]' : '';
	foreach($values as $row) {
		$show .= '<div class="oneimg">'.$close.'<div class="imgdiv"><div class="outline"><img src="'.$row['thumb'].'"  height="60" alt="点击查看大图" onclick="g_open_big(\''.$row['imgurl'] .'\');" /></div></div><div style="display:none"><input type="checkbox" name="'.$name.'[id]'.$arr.'" value="'.$row['id'].'" checked="checked"/><input type="checkbox" name="'.$name.'[imgurl]'.$arr.'" value="'.$row['imgurl'].'" checked="checked"  /><input type="checkbox" name="'.$name.'[thumb]'.$arr.'" value="'.$row['thumb'].'" checked="checked"/></div></div>';	
		
	}
	
	$str .= '
			<table rules="none" border="0" cellpadding="0" cellspacing="0" class="upload_table">
			<tr>
				<td align="left">
				<div>
				<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:g_upload_image(\''.U('Attachment/img_upload'). '\',\''. $name .'\','. $multi.');">'.$uptext.'</a>
				<label style="margin:0px;display:inline-block;"><small>&nbsp;&nbsp;单个文件最大上传限制20M'. ($multi?' (可多选)':'') .'</small></label>
				</div>
				</td>
			</tr>
			<tr>
				<td>
				<div id="'.$name.'_show" class="imgs_show">'.$show.'
				</div>
				</td>
			</tr>
		</table>';
	
	return $str;
}


function upload_m($obj,$cont,$attr='',$btn='上传',$showbox="flist",$formname="attr",$filename="文件名称"){
	
	$html = '';
	$html .= '<a href="javascript:;" id="'.$obj.'" class="btn btn-success btn-sm" style="margin:-10px 0 0 15px;"><i class="fa fa-upload"></i> '.$btn.'</a>';
    
	$html .= '<div class="form-group col-md-12" style=" padding:10px 0;"  id="flist" >';
	
	if($attr){
		
		//查找
		$where = array();
		$where['id']  = array('in',$attr);
		$attrlist = M('attachment')->where($where)->select();
			
		foreach($attrlist as $k=>$v){
			$size = format_bytes($v['filesize']);
			$ext  = strtoupper($v['fileext']);
			$html .= '<div class="form-group col-md-3" id="aid_'.$v['id'].'" >';
			$html .= '<input type="hidden" name="'.$formname.'[id][]" value="'.$v['id'].'" />';
			$html .= '<input type="hidden" name="'.$formname.'[filepath][]" value="'.$v['filepath'].'" />';
			$html .= '<div class="uploadlist">';
			if($ext=='JPG' || $ext=='PNG' || $ext=='GIF'){
				$bg = 'style="background-image:url('.thumb($v['filepath']).')"';  
				$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="ext"></div></a>';
			}else{
				$bg = 'style="background-color:#00a65a"';  
				$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="ext">'.$ext.'</div></a>';
			}	
			$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="upimg" '.$bg.'></div></a>';
			$html .= '<input type="text" name="'.$formname.'[filename][]" value="'.$v['filename'].'" placeholder="'.$filename.'" class="form-control" />';
			$html .= '<div class="size">'.$size.'</div>';
			$html .= '<div class="jindu"><div class="progress sm"><div class="progress-bar progress-bar-aqua" rel="o_1bjn0q9lj1qjg1mmj1d43mf5qrp8" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div></div>';
			$html .= '<span class="dels" onclick="removeThisFile(\'aid_'.$v['id'].'\');">X</span>';
			$html .= '</div>';
			$html .= '</div>';
		}
	}						
	
	$html .= '</div>';
	$html .= '<div id="'.$cont.'" style="display:none;"></div>';
	$html .= '<script>';
	$html .= '$(document).ready(function() {';
	$html .= 'upload_multi_file(\''.$obj.'\',\''.$cont.'\',\''.$showbox.'\',\''.$formname.'\',\''.$filename.'\');';
	$html .= '});';
	$html .= '</script>';
	
	return $html;
}

//删除多余的图片
function save_res($module,$releid,$data,$catid='0'){
	//处理图片
	$where = array();
	$where['module']  = $module;
	$where['rel_id']  = $releid;

	$tp_db = M('attachment');

	if(is_array($data)){
		foreach($data['id'] as $k=>$v){
			//保存数据
			$info = array();
			$info['module']        = $module;
			$info['catid']         = $catid;
			$info['rel_id']        = $releid;
			$info['status']        = $data['status'][$k];
			$info['filename']      = $data['filename'][$k];
			$info['filepath']      = $data['filepath'][$k];
			$issave = $tp_db->where(array('id'=>$v))->save($info);
		}
		$where['id']     = array('not in',implode(',',$data['id']));
	}

	//查询要删除的图片
	$isdel = $tp_db->where($where)->select();
	if($isdel){
		foreach($isdel as $k=>$v){
			$tp_db->where(array('id'=>$v['id']))->delete();
		}
	}
}

//增加图片 , 不删除原图片
function save_add_res($module,$releid,$data){
	//处理图片
	$where = array();
	$where['module']  = $module;
	$where['rel_id']  = $releid;

	$tp_db = M('attachment');

	if(is_array($data)){
		foreach($data['id'] as $k=>$v){
			//保存数据
			$info = array();
			$info['module']        = $module;
			$info['rel_id']        = $releid;
			$info['status']        = $data['status'][$k];
			$info['filename']      = $data['filename'][$k];
			$issave = $tp_db->where(array('id'=>$v))->save($info);
		}
	}


}

function get_res($module,$releid){
	//获取默认素材
	$attid = array();
	$attachment = M('attachment')->where(array('module'=>$module,'rel_id'=>$releid))->select();  //
	foreach($attachment as $v){
		$attid[] = 	$v['id'];
	}
	//return implode(',',$attid);
	return $attachment;
}


function get_upload_m($attr=''){
	
	$html = '';
	$html .= '<div  id="flist" >';
	
	if($attr){
		
		//查找
		$where = array();
		$where['id']  = array('in',$attr);
		$attrlist = M('attachment')->where($where)->select();
			
		foreach($attrlist as $k=>$v){
			$size = format_bytes($v['filesize']);
			$ext  = strtoupper($v['fileext']);
			$html .= '<div class="form-group col-md-3" id="aid_'.$v['id'].'" >';
			$html .= '<div class="downloadlist">';
			if($ext=='JPG' || $ext=='PNG' || $ext=='GIF'){
				$bg = 'style="background-image:url('.thumb($v['filepath']).')"';  
				$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="ext"></div></a>';
			}else{
				$bg = 'style="background-color:#00a65a"';  
				$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="ext">'.$ext.'</div></a>';
			}	
			$html .= '<a href="'.$v['filepath'].'" target="_blank"><div class="upimg" '.$bg.'></div></a>';
			$html .= '<div class="filename">'.$v['filename'].'</div>';
			//$html .= '<div class="size">'.$size.'</div>';
			$html .= '<div class="uptime">'.date('m-d H:i',$v['uploadtime']).'&nbsp;&nbsp;/&nbsp;&nbsp;'.$size.'</div>';
			$html .= '<a href="'.$v['filepath'].'" target="_blank" class="download">下载</a>';
			//$html .= '<div class="jindu"><div class="progress sm"><div class="progress-bar progress-bar-aqua" rel="o_1bjn0q9lj1qjg1mmj1d43mf5qrp8" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div></div>';
			//$html .= '<span class="dels" onclick="removeThisFile(\'aid_'.$v['id'].'\');">X</span>';
			$html .= '</div>';
			$html .= '</div>';
		}
	}						
	
	$html .= '</div>';
	
	
	return $html;
}



function format_bytes($size) { 
	$units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
	for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
	return round($size).$units[$i]; 
} 

/**
 * 生成缩略图函数
 * @param  $img 图片路径
 * @param  $width  缩略图宽度
 * @param  $height 缩略图高度
 * @param  $autocut 是否自动裁剪 默认不裁剪，当高度或宽度有一个数值为0是，自动关闭
 * @param  $smallpic 无图片是默认图片路径
*/ 
function thumb($img, $width = 80, $height = 60 ,$autocut = 1, $nopic = 'images/nopic.jpg') {

	if(empty($img)) return __ASSETS__ . DS . $nopic;   //判断原图路径是否输入

	if(!extension_loaded('gd') || strpos($img, '://')) return $img;
    
	$root_path =  __ROOT__ . DS ;
	if (strpos($img, $root_path) === 0) {
	    $img_replace = substr_replace($img, '', 0, strlen($root_path));
	} else {
	    $img_replace = $img;
	}
	
	if(!file_exists($img_replace)) return  __ASSETS__ . DS . $nopic; //判断原图是否存在

	$newimg = dirname($img_replace).'/thumb_'.$width.'_'.$height.'_'.basename($img_replace);   //缩略图路径

	if(file_exists($newimg)) return $newimg;  //如果缩略图存在则直接输入
	
	$image = new \Think\Image(); 
	$image->open($img_replace);
    
	if ($autocut) {
        $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save($newimg);
	} else {
        $image->thumb($width, $height)->save($newimg);
	}
    
	return $newimg;
}


/**
 * @brief 导出Excel
 * @param array $data
 * @param array $title
 * @param string $filename
 */
function exportexcel($data=array(),$title=array(),$filename='export'){
    ini_set('max_execution_time', 500);

    $cols = array();
	 for($i='A'; $i!='YZ'; $i++) {
		 $cols[] = $i;
	 }
     
     ulib('PHPExcel');

    $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
    $cacheSettings = array();
    \PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings);

    $objPHPExcel = new \PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->getDefaultColumnDimension()->setWidth(20);
    

    $n = 1;
    if (!empty($title)) {
        $j = 0;
        foreach($title as $v) {
            $sheet->setCellValue($cols[$j] . '1', $v);
            $j++;
        }
        $n = 2;
    }

    foreach($data as $k => $v) {
        if (is_array($v)) {
            for($i = 0; $i < count($v); $i++) {
                $sheet->setCellValueExplicit($cols[$i].$n, current($v), \PHPExcel_Cell_DataType::TYPE_STRING);
                //$sheet->setCellValue($cols[$i].$n, current($v));
                each($v);
            }
        } else {
            $sheet->setCellValueExplicit($cols[0].$n, $v, \PHPExcel_Cell_DataType::TYPE_STRING);
            //$sheet->setCellValue($cols[0].$n, $v);
        }
        $n++;
    }

    ob_end_clean();
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
     
}



/**
 * @brief 使用模板导出Excel
 * @param array $data
 * @param array $title
 * @param string $filename
 */
function model_exportexcel($data=array(),$filename='export',$model){
    ini_set('max_execution_time', 500);

    ulib('PHPExcel'); //导入thinkphp第三方类库
	//创建一个读Excel模板的对象
	$objReader= \PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = $objReader->load ("$model");//读取模板，模版放在根目录
	//获取当前活动的表
	$objActSheet=$objPHPExcel->getActiveSheet();
	$objActSheet->setTitle($filename);//设置excel的标题
	
	foreach($data as $k=>$v){
		$objActSheet->setCellValue($k,$v);
	}
	
	//导出
	$filename = iconv('utf-8',"gb2312",$filename);//转换名称编码，防止乱码
	//header ( 'Content-Type: application/vnd.ms-excel;charset=utf-8' );
	//header ( 'Content-Disposition: attachment;filename="' . $filename . '.xls"' ); //”‘.$filename.’.xls”
   // header ( 'Cache-Control: max-age=0');
	
	ob_end_clean();
	header("Content-type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=".$filename.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	
	$objWriter = \PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel5' ); //在内存中准备一个excel2003文件
	$objWriter->save ('php://output');
     
}


/**
 * @brief 导入Excel
 * @param array $file
 */
function importexcel($filePath){
	
	ulib('PHPExcel');
	
	$PHPExcel = new \PHPExcel(); 
	
	/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
	$PHPReader = new \PHPExcel_Reader_Excel2007(); 
	if(!$PHPReader->canRead($filePath)){ 
		$PHPReader = new \PHPExcel_Reader_Excel5(); 
		if(!$PHPReader->canRead($filePath)){ 
			echo 'no Excel'; 
			return ; 
		} 
	} 
	
	$PHPExcel = $PHPReader->load($filePath); 
	/**读取excel文件中的第一个工作表*/ 
	$currentSheet = $PHPExcel->getSheet(0); 
	/**取得最大的列号*/ 
	$allColumn = $currentSheet->getHighestColumn(); 
	/**取得一共有多少行*/ 
	$allRow = $currentSheet->getHighestRow(); 
	/**从第二行开始输出，因为excel表中第一行为列名*/ 
	
	$data = array();
	for($currentRow = 1;$currentRow <= $allRow;$currentRow++){ 
		/**从第A列开始输出*/ 
		$cont = array();
		for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){ 
			$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/ 
			$cont[] = $val;
			/**如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出*/ 
			//$cont[] = iconv('utf-8','gb2312', $val);
		} 
		$data[] = $cont;
	} 
	
	return $data;
     
}



/**
 * @brief 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function send_mail ($to,  $name,  $subject = '', $body = '', $attachment = null)
{

    $config = C('EMAIL_CONFIG');

	 ulib('PHPMailer.PHPMailerAutoload');
    
    $mail             = new \PHPMailer(); //PHPMailer对象
    $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();  // 设定使用SMTP服务
    $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';                 // 使用安全协议
    $mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
    $mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
    $mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
    $mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
    $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject    = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if(is_array($attachment)){ // 添加附件
        foreach ($attachment as $file){
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}


/*邮件模板*/
function mailmode($mail,$url){
	return '<p>您收到这封邮件，是因为chengli@btte.net（Email：'.$mail.'）在我们网站为您的Email开通了子账户权限。</p><p>您可以通过我们的网站实时查看到被授权应用的统计数据。</p><p>如果您并不需要访问我们的网站，请忽略这封邮件。您不需要退订或进行其他进一步的操作。</p><p>----------------------------------------------------------------------</p><p>帐号激活说明</p><p>----------------------------------------------------------------------</p><p>您是我们网站的新用户，我们需要对您的地址有效性进行验证以避免垃圾邮件或地址被滥用。</p><p>您只需点击下面的链接，并补全相关的注册信息，即可激活您的帐号：</p><p><a target="_blank" href="'.$url.'" _act="check_domail">'.$url.'</a></p><p>(如果上面不是链接形式，请将地址手工粘贴到浏览器地址栏再访问)</p><p>感谢您的访问，祝您使用愉快！</p><p>此致</p><p>友盟管理团队</p><p>-----------------------------</p><p>友盟（<a target="_blank" href="http://www.umeng.com" _act="check_domail">www.umeng.com</a>）<br>最专业的移动平台分析工具</p>';
}



/**
 * @brief  拉伸合并后的节点
 */
function sort_node($nodes, &$arr) {
    foreach ($nodes as $row) {
        if (isset($row['child'])) {
            $child = $row['child'];
            unset($row['child']);
        } else {
            $child = false;
        }
        $arr[] = $row;
        if ($child) {
            array_merge($arr, sort_node($child, $arr));
        }
    }
}

/**
 * @brief  获取角色列表
 */
function get_roles($sort = true) {

    global $__roles_list;
    global $__roles_list_unsort;

    if (count($__roles_list) > 0) {
        return  $sort == true ? $__roles_list : $__roles_list_unsort;
    } else {
        $db = M('role');
        $where = "id>3";
        //p($page);
        //$this->pagetitle = '角色';
        $allroles = $db->where($where)->order('pid,id')->select();

        $role_by_id  = array();
        foreach ($allroles as $row) {
            $role_by_id[$row['id']] = $row;
        }
        $__roles_list_unsort = $role_by_id;
        $roles = merge_node($role_by_id, null);
        sort_node($roles, $__roles_list);
    }
    return  $sort == true ? $__roles_list : $__roles_list_unsort;
}

/**
 * @brief  获取物资分类列表
 */
function get_material_kinds($sort = true) {

    global $__prj_kind_list;
    global $__prj_kind_list_unsort;

    if (count($__prj_kind_list) > 0) {
        return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
    } else {
        $db = M('material_kind');

        $allroles = $db->order('pid,id')->select();

        $kind_by_id  = array();
        foreach ($allroles as $row) {
            $kind_by_id[$row['id']] = $row;
        }
        $__prj_kind_list_unsort = $kind_by_id;
        $kinds = merge_node($kind_by_id, null);
        sort_node($kinds, $__prj_kind_list);
    }
    return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
}

/**
 * @brief  获取项目分类列表
 */
function get_project_kinds($sort = true) {

    global $__prj_kind_list;
    global $__prj_kind_list_unsort;

    if (count($__prj_kind_list) > 0) {
        return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
    } else {
        $db = M('project_kind');

        $allroles = $db->order('pid,id')->select();

        $kind_by_id  = array();
        foreach ($allroles as $row) {
            $kind_by_id[$row['id']] = $row;
        }
        $__prj_kind_list_unsort = $kind_by_id;
        $kinds = merge_node($kind_by_id, null);
        sort_node($kinds, $__prj_kind_list);
    }
    return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
}


/**
 * @brief  获取线路分类列表
 */
function get_product_kinds($sort = true) {

    global $__prj_kind_list;
    global $__prj_kind_list_unsort;

    if (count($__prj_kind_list) > 0) {
        return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
    } else {
        $db = M('product_kind');

        $allroles = $db->order('pid,id')->select();

        $kind_by_id  = array();
        foreach ($allroles as $row) {
            $kind_by_id[$row['id']] = $row;
        }
        $__prj_kind_list_unsort = $kind_by_id;
        $kinds = merge_node($kind_by_id, null);
        sort_node($kinds, $__prj_kind_list);
    }
    return  $sort == true ? $__prj_kind_list : $__prj_kind_list_unsort;
}

/**
 * @brief  根据项目分类ID取分类名称
 */
function get_prj_kind_name($id, $isfull = true, $sep = ' > ') {

    $kinds = get_project_kinds(false);
    $name = '';
    if (array_key_exists($id, $kinds)) {
        $name = $kinds[$id]['name'];

        if (!$isfull) return $name;
        $pid = $kinds[$id]['pid'];
        while ($pid  > 0) {
            $name = $kinds[$pid]['name'] . $sep . $name;
            $pid = $kinds[$pid]['pid'];
        }
    }
    return $name;
}

/**
 * @brief  补足树形前缀
 */
function tree_pad($level, $usespace = false) {
    if ($level <= 1) {
        return '';
    }

    if ($level == 2) {
        return '<font color="#999">├</font>&nbsp;&nbsp;';
    }

    $tmpstr = '';

    for ($i=1; $i < $level - 1; $i++) {
        if ($usespace) {
            $tmpstr .= '<font color="#999">│&nbsp;&nbsp;&nbsp;&nbsp;</font>';
        } else {
            $tmpstr .= '<font color="#999">│&nbsp;&nbsp;&nbsp;&nbsp;</font>';
        }
    }
    $tmpstr .= '<font color="#999">├</font>&nbsp;&nbsp;';
    return $tmpstr;
}

/**
 * @brief  根据roleid取角色名称
 */
function get_role_name($id, $isfull = true, $sep = ' > ') {

    $roles = get_roles(false);
    $name = '';
    if (array_key_exists($id, $roles)) {
        $name = $roles[$id]['role_name'];

        if (!$isfull) return $name;
        $pid = $roles[$id]['pid'];
        while ($pid  > 4) {
            $name = $roles[$pid]['role_name'] . $sep . $name;
            $pid = $roles[$pid]['pid'];
        }
    }
    return $name;
}


/**
 * @brief  检查当前控制器和方法名称，返回指定的CSS class名
 * @param string  $str 目标值，如 User/index （判断控制器+方法）  User （仅判断控制器）
 * @param string  $css 可选css类名
 * return 匹配时返回 $css  否则为空串
 */
function on ($str, $css = ' active') {
    $tmp = explode('/', $str);
    if (count($tmp) > 1) {
        return  (CONTROLLER_NAME == $tmp[0] && ACTION_NAME == $tmp[1]) ? $css : '';
    } else {
        return  (CONTROLLER_NAME == $tmp[0]) ? $css : '';
    }
}


/**
 * @brief  检查当前用户资源权限配置，生成where过滤条件
 * @param string $tb 
 * @param string $priv = v,d,u
 * return 返回 生成的where条件
 */
function get_priv_condition($tb, $priv = 'v', $short_name = null) {
    
    if (session(C('ADMIN_AUTH_KEY')) || session('userid') == 1) return '1';
    if (!$short_name) $short_name = $tb;
    $roleid = M('role_user')->where('user_id='.session('userid'))->getField('role_id');
    $str = " (select substring(GROUP_CONCAT(${$priv} order by resid desc),1,1)
            from oa_rights where roleid=${roleid} and restable = '${tb}'
            and ({$short_name}.id = oa_rights.resid or oa_rights.resid = 0)) ";
            
    return $str;

}


function priv_where($req_type, $short_name = null) {
    
    if (session(C('ADMIN_AUTH_KEY')) || session('userid') == 1) return '1';
    $cfg  = M('audit_field')->where("req_type=$req_type")->find();
    $tb   = $cfg['table'];
    $priv = $cfg['priv'];
    if (!$short_name) $short_name = C('DB_PREFIX') . $tb;
    $roleid = M('role_user')->where('user_id='.session('userid'))->getField('role_id');
    $str = " (select substring(GROUP_CONCAT(${priv} order by resid desc),1,1)
    from oa_rights where roleid=${roleid} and restable = '${tb}'
    and (${short_name}.id = oa_rights.resid or oa_rights.resid = 0)) ";

    return $str;

}


function fsize($size) {

    $mod = 1024;

    $units = explode(' ','b kb mb gb tb pb');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
    
    return round($size, 1) . ' ' . $units[$i];
}

function open_req($req_type, $req_id) {
    return "open_req('" . U('Rights/audit_req', array('req_type'=>$req_type, 'id'=>$req_id)) ."')";
}

function open_audit($audit_id) {
    return "open_audit('" . U('Rights/audit_apply', array('id'=>$audit_id)) ."')";
}

function open_resure($resure_id) {
	return "open_resure('" . U('Worder/audit_resure', array('id'=>$resure_id)) ."')";
}

function open_field ($id) {
	return "open_field('" .U('Project/fields_add',array('id'=>$id)) ."')";
}

function open_type ($id) {
	return "open_type('" .U('Project/types_add',array('id'=>$id)) ."')";
}

function open_cost ($op_id,$cost,$name) {
	return "open_cost('" .U('GuideRes/upd_cost',array('op_id'=>$op_id,'cost'=>$cost,'name'=>$name)) ."')";
}

/*function open_price ($id) {
	return "open_price('" .U('GuideRes/addprice',array('id'=>$id)) ."')";
}*/

function open_priceKind ($id) {
	return "open_priceKind('" .U('GuideRes/addPriceKind',array('id'=>$id)) ."')";
}

function open_edit_tcs_need ($cid,$pid,$opid) {
	return "open_edit_tcs_need('" .U('Op/edit_tcs_need',array('confirm_id'=>$cid,'price_id'=>$pid,'opid'=>$opid)) ."')";
}

function open_sign ($id) {
    return "open_sign('" .U('Finance/sign_add',array('id'=>$id)) ."')";
}

function opid($day=''){
	if($day){
		$date = date('Ymd',strtotime($day));
	}else{
		$date = date('Ymd',time());
	}
	$lastid = M('op')->where(array('op_id'=>array('like',$date.'%')))->order('id DESC')->find();
	if($lastid){
		$opid = 	$lastid['op_id']+1;
	}else{
		$opid = 	($date*10000)+1;
	}
	return $opid;
}


function op_record($info){
	$data = array();
	$data = $info;
	$data['uname'] = cookie('name');
	$data['op_time'] = time();
	$isok = M('op_record')->add($data);
	if($isok){
		return true;	
	}else{
		return false;	
	}
}

//借款报销操作记录
function jkbx_record($info){
    $data = array();
    $data = $info;
    $data['uname'] = cookie('name');
    $data['time'] = time();
    $isok = M('jkbx_record')->add($data);
    if($isok){
        return true;
    }else{
        return false;
    }
}

//工单操作记录
function worder_record($info){
	$data = array();
	$data = $info;
	$data['uname'] = cookie('name');
	$data['time'] = NOW_TIME;
	$isok = M('worder_record')->add($data);
	if($isok){
		return true;
	}else{
		return false;
	}
}

//合同操作记录
function contract_record($info){
	$data = array();
	$data = $info;
	$data['uname'] = cookie('name');
	$data['time'] = NOW_TIME;
	$isok = M('contract_record')->add($data);
	if($isok){
		return true;
	}else{
		return false;
	}
}


//汇总项目预算
function opcost($opid){
	//汇总项目预算
	$cost = $costlist   = M('op_cost')->where(array('op_id'=>$opid))->sum('total');
	$sumcost = $cost ? '&yen'.$cost : '';
	return $sumcost;
}


//二维数组去重
function unique_arr($array,$field='name'){
	if($array){
		foreach($array as $k=>$v){
			if($v['id']){
				$unitid[$v['id']]['id']   = $v['id'];	
				$unitid[$v['id']]['name'] = $v[$field];	
			}
		}
	}
    return $unitid;
}

//获取任意日期的月第一天和最后一天
function month_phase($date){
	
	if(strlen($date)==6) $date = $date.'01'; 
	
	$data = array();
	$data['start'] = strtotime(date('Y-m-01', strtotime($date)).' 00:00:00');
	$data['end']   = strtotime(date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day')).' 23:59:59');
	$data['month'] = date('Ym', strtotime($date));
	
	//上个月
	$data['prevmonth'] = date('Ym', ($data['start']-(86400*3)));
	
	//下个月
	$data['nextmonth'] = date('Ym', ($data['end']+(86400*3)));
	
	return $data;
}


//角色下所有的用户
function Roleinuser($id = 0,$check='role') { 
	global $$check;
	$db = M('role');
	$guanxibiao = $db->field('id,pid')->where(array('pid'=>$id))->select();
    if($guanxibiao){
		foreach ($guanxibiao as $row){
            $roid[] = $row['id'];
            Roleinuser($row['id'],$check);
		}
    } 
	//返回用户ID
 	$roid[] = $id;
	$userlist = M('account')->where(array('roleid'=>array('in',implode(',',$roid))))->Getfield('id',true);	
    return implode(',',$userlist); 
} 


//获取用户信息
function getuserinfo($user){
	if($user){
		$role = M('role')->GetField('id,role_name',true);
		$user = M('account')->field('id as userid,nickname,roleid')->where('`id`="'.$user.'" OR `nickname` = "'.trim($user).'"')->find();	
		$user['role_name'] = $role[$user['roleid']];
		return $user;
	}
}


//项目数量统计
function op_sum($date,$type=1,$dept){
	
	$db  = M();
	$day = month_phase($date);	
	//京区校外
	$where = array();
	if($dept) $where['o.create_user'] = array('in',Roleinuser($dept));
	if($type==1){
		$where['o.create_time'] = array('between',array($day['start'],$day['end']));	
	}else if($type==2){
		$where['o.create_time'] = array('between',array($day['start'],$day['end']));	
		$where['o.group_id']    = array('neq','');
	}else if($type==3){
		$where['a.audit_time']  = array('between',array($day['start'],$day['end']));	
		$where['b.audit']       = 1;
	}
	$sum = $db->table('__OP__ as o')->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')->where($where)->count();
	return $sum;
}



//项目提成统计
function op_tc($date,$type=1,$dept){
	
	$db  = M();
	$day = month_phase($date);
	
	if($type==1){
		$keywords = '计调提成';	
	}else if($type==2){
		$keywords = '研发提成';	
	}
	//京区校外
	$where = array();
	if($dept) $where['o.create_user'] = array('in',Roleinuser($dept));
	$where['a.audit_time']  = array('between',array($day['start'],$day['end']));	
	$where['b.audit']       = 1;
	$where['c.status']      = 2;
	$where['c.title']       = array('like','%'.$keywords.'%');
	
	$sum = $db->table('__OP_COSTACC__ as c')->join('__OP__ as o on o.op_id = c.op_id')->join('__OP_SETTLEMENT__ as b on b.op_id = c.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')->where($where)->sum('c.total');
	return $sum;
}

//项目提成统计
function ticheng($year,$type=1){
		
	$db   = M();
	
	$jqxw    = array();
	$jqxn    = array();
	$jwyw    = array();
	$cgly    = array();
	$zong    = array();
	
	for($i=1;$i<=12;$i++){	
		$date = $year.'-'.$i.'-01';
		
		//京区校外
		$jqxwsum = op_tc($date,$type,33);
		$jqxw[]  = $jqxwsum ? floatval($jqxwsum) : 0;
		
		//京区校内
		$jqxnsum = op_tc($date,$type,35);
		$jqxn[]  = $jqxnsum ? floatval($jqxnsum) : 0;
		
		//京外业务
		$jwywsum = op_tc($date,$type,18);
		$jwyw[]  = $jwywsum ? floatval($jwywsum) : 0;
		
		//常规旅游
		$cglysum = op_tc($date,$type,19);
		$cgly[]  = $cglysum ? floatval($cglysum) : 0;
		
		//总计
		$zongsum = op_tc($date,$type,0);
		$zong[]  = $zongsum ? floatval($zongsum) : 0;
		
	}
	
	$rs = array();
	$rs[0]['name'] = '京区校内';
	$rs[0]['data'] = $jqxn;
	$rs[1]['name'] = '京区校外';
	$rs[1]['data'] = $jqxw;
	$rs[2]['name'] = '京外业务';
	$rs[2]['data'] = $jwyw;
	$rs[3]['name'] = '常规业务';
	$rs[3]['data'] = $cgly;
	$rs[4]['name'] = '总计';
	$rs[4]['data'] = $zong;
	
	return json_encode($rs);
	
	
}

//项目收入
function op_income($date,$type=1,$dept=0,$kind=0){
	
	$db  = M();
	$day = month_phase($date);	
	//京区校外
	
	if($type==1){
		$field = 'b.shouru';	
	}else{
		$field = 'b.maoli';	
	}
	
	$sum = 0;
	//结算的项目
	$where = array();
	if($dept) $where['o.create_user'] = array('in',Roleinuser($dept));
	if($kind) $where['o.kind']        = $kind;
	$where['a.audit_time']  = array('between',array($day['start'],$day['end']));	
	$where['b.audit']       = 1;
	$sum += $db->table('__OP__ as o')
			->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')
			->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')
			->where($where)->sum($field);
	
	//未结算的项目
	$where = array();
	if($dept) $where['o.create_user'] = array('in',Roleinuser($dept));
	$where['a.audit_time']  = array('between',array($day['start'],$day['end']));	
	$where['b.audit']       = 1;
	$where['s.audit']       = array('neq','1');
	
	$sum += $db->table('__OP__ as o')
			->join('__OP_SETTLEMENT__ as s on s.op_id = o.op_id','LEFT')
			->join('__OP_BUDGET__ as b on b.op_id = o.op_id','LEFT')
			->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 800','LEFT')
			->where($where)
			->sum($field);
	
	
	
		   
	return $sum;
}


//业务部门收入
function business($bumen,$year,$type=1){
	$kind = M('project_kind')->where(array('name'=>array('like',$bumen.'-%')))->order('id ASC')->select();
	$html = array();
	foreach($kind as $k=>$v){
		$unitdata = array();
		for($i=1;$i<=12;$i++){	
			$sum = op_income($year.'-'.$i.'-01',$type,0,$v['id']);
			$unitdata[]  = $sum ? intval($sum) : 0;
		}
		if($k==0){
			$html[] = '{name:\''.trim(trim($v['name'],$bumen),'-').'\',data:['.implode(',',$unitdata).']}';
		}else{
			$html[] = '{name:\''.trim(trim($v['name'],$bumen),'-').'\',data:['.implode(',',$unitdata).'],visible: false}';
		}
		
	}
	
	return '['.implode(',',$html).']';
	
}




//项目收入
function op_cycle($date,$dept=0,$kind=0){
	
	$db  = M();
	$day = month_phase($date);	
	//京区校外
	
	
	$sum = 0;
	//结算的项目
	$where = array();
	//if($dept) $where['o.create_user'] = array('in',Roleinuser($dept));
	if($kind) $where['o.kind']        = $kind;
	$where['a.audit_time']  = array('between',array($day['start'],$day['end']));	
	$where['b.audit']       = 1;
	
	$field = '(a.audit_time-o.create_time)/86400 as days';
	$lists = $db->field($field)->table('__OP__ as o')
			->join('__OP_SETTLEMENT__ as b on b.op_id = o.op_id','LEFT')
			->join('__AUDIT_LOG__ as a on a.req_id = b.id and a.req_type = 801','LEFT')
			->where($where)->select();
	
	
	$i=0;
	foreach($lists as $k=>$v){
		$sum += $v['days'];
		$i++;
	}
	
	
		   
	return round($sum/$i);
}


//业务部门结算周期
function cycle($bumen,$year,$type=1){
	$kind = M('project_kind')->where(array('name'=>array('like',$bumen.'-%')))->order('id ASC')->select();
	$html = array();
	foreach($kind as $k=>$v){
		$unitdata = array();
		for($i=1;$i<=12;$i++){	
			$sum = op_cycle($year.'-'.$i.'-01',0,$v['id']);
			$unitdata[]  = $sum ? intval($sum) : 0;
		}
		if(array_sum($unitdata)){
			$html[] = '{name:\''.trim(trim($v['name'],$bumen),'-').'\',data:['.implode(',',$unitdata).']}';
		}else{
			$html[] = '{name:\''.trim(trim($v['name'],$bumen),'-').'\',data:['.implode(',',$unitdata).'],visible: false}';
		}
		
	}
	
	return '['.implode(',',$html).']';
	
}


/*API返回值*/
function return_error($error){
	$arr = explode("=",$error);
	$status = array();
	$status['status'] = $arr[0];
	$status['msg']    = $arr[1];
	return json_encode($status);
}
function return_success($success = '成功'){
	$status = array();
	$status['status'] = 0;
	$status['msg']    = $success;
	return json_encode($status);
}




function getTree($pid=0){
	
	global $str; 
	global $str_level; 
	
	$str_level = $str_level ? $str_level : 0;
	 
	$db = M('files');
	$where = array();
	$where['pid']          = $pid;
	$where['file_type']    = 0;
	//权限识别
	if (C('RBAC_SUPER_ADMIN') != cookie('userid')){
		
		$userid = cookie('userid');
		$roleid = cookie('roleid');
		
		$where['_string'] = ' (auth_group like "%'.$roleid.'%")  OR ( auth_user like "%'.$userid.'")   OR ( est_user_id = '.$userid.') ';
			
	}
		
	
	$list = $db->where($where)->order('`id` ASC')->select();
	$str_level++;
	if($list){
		foreach($list as $k =>$v){
			$list[$k]['str_level'] = $str_level;
			$str[] = $list[$k];
			getTree($v['id']);
		}
		
	}
	
	return $str;
	
}


function fortext($no,$html='&nbsp;&nbsp;&nbsp;&nbsp;',$bu='├'){
	
	$return = '';
	for($i=1;$i<=$no;$i++){
		$return .= $html;
	}
	$return .=$bu;
	return $return;
}


//获取文件路径
function file_dir($fid){
	
	global $dir; 
	global $dir_level; 
	
	$dir_level = $dir_level ? $dir_level : 10000;
	
	$db = M('files');
	
	//获取文件名
	$data = $db->where(array('id'=>$fid))->find();
	$dir[$dir_level]['id']        =  $data['id'];
	$dir[$dir_level]['file_name'] =  $data['file_name'];
	
	$dir_level--;
	
	if($data['pid']!=0){
		file_dir($data['pid']);
	}
	/*
	$data = $db->where(array('id'=>$fid))->find();
	$list = $db->where(array('id'=>$data['pid']))->find();
	
	if($list){
		$dir[$list['id']] = $list['file_name'];
	
		if($list['pid']){
			file_dir($list['pid']);
		}
	}
	*/
	
	ksort($dir);
	
	return $dir;
	 	
}


function up_file_level($fid){
	
	$db = M('files');
	
	
	$data = $db->find($fid);
	
	if($data){
		//修正自身等级
		if($data['pid']){
			$upfile = $db->find($data['pid']);
			$level  = $upfile['level']+1;
			
		}else{
			$level = 1;	
		}
		$db->data(array('level'=>$level))->where(array('id'=>$fid))->save();
		
		//查询是否有下级目录
		$nextfile = $db->where(array('pid'=>$fid))->select();
		foreach($nextfile as $k=>$v){
			up_file_level($v['id']);	
		}
	
		
	}else{
		$db->data(array('level'=>1))->where(array('pid'=>0))->save();	
		
		$nextfile = $db->where(array('pid'=>0))->select();
		foreach($nextfile as $k=>$v){
			up_file_level($v['id']);	
		}
		
	}
}



// @@@NODE-3###pdca_auditor###审批人信息###
 function pdca_auditor($id){
	$role_id    = $id;
	$auditor    = M('auth')->where("role_id = '$role_id'")->getField('pdca_auth');
	$user = M('account')->find($auditor);
	return $user['nickname'];
}

//获取用户姓名
function username($userid){
	if($userid){
		$user = M('account')->find($userid);	
		return $user['nickname'];
	}else{
        return '';
	}
}


//发送消息
function send_msg($send,$title,$content,$url='',$user,$role=''){
	$data = array();
	$data['send_user']		 = $send;
	$data['send_time']	 	 = time();
	$data['title']		 	 = $title;
	$data['content']		     = $content;
	$data['msg_url']	 	     = $url;
	$data['receive_user']	 = $user;
	$data['receive_role']	 = $role;
	$add = M('message')->add($data);
	if($add){
		return $add;	
	}else{
		return 0;		
	}
}


//阅读消息
function read_msg($msg_id){
	$data = array();
	$data['user_id']		 = cookie('userid');
	$data['msg_id']		 	 = $msg_id;
	
	$isread = M('message_read')->where($data)->find();
	if(!$isread){
		$data['read_time']	 	 = time();
		$add = M('message_read')->add($data);
		if($add){
			return $add;	
		}else{
			return 0;		
		}
	}else{
		return 0;		
	}
}


//阅读消息
function del_msg($msg_id){
	$data = array();
	$data['user_id']		 = cookie('userid');
	$data['msg_id']		 	 = $msg_id;
	
	$isread = M('message_read')->where($data)->find();
	if(!$isread){
		$data['read_time']	 = time();
		$data['del']	 	 = 1;
		M('message_read')->add($data);
		
	}else{
		M('message_read')->where(array('id'=>$isread['id']))->data(array('del'=>1))->save();
	}
}


//未读消息数量
function no_read(){
	$read     = M('message_read')->where(array('user_id'=>cookie('userid')))->Getfield('msg_id',true);
	$readstr  = implode(',',$read);
			
	$where = '(receive_user like "%['.cookie('userid').']%"  OR  receive_role like "%['.cookie('roleid').']%") ';
	if($readstr) $where .= ' AND id NOT IN ('.$readstr.')';
			
	$count = M('message')->where($where)->count();	
	return $count;
}


//发送公告
function send_notice($title,$content,$url='',$source=0,$source_id=0,$userid=0,$username=''){
	$data = array();
	$data['send_user_id']	 = $userid ? $userid : cookie('userid');
	$data['send_user_name']	 = $username ? $username : cookie('nickname');
	$data['send_time']	 	 = time();
	$data['title']		 	 = $title;
	$data['content']		 = $content;
	$data['link_url']	 	 = $url;
	$data['source']	         = $source;
	$data['source_id']	     = $source_id;
	
	//判断是否重复
	if(!M('notice')->where(array('source'=>$source,'source_id'=>$source_id))->find()){
		$add = M('notice')->add($data);
		if($add){
			return $add;	
		}else{
			return 0;		
		}
	}
}

function strtopinyin($str){
	$PinYin = new Pinyin();
	$str = iconv("utf-8","gb2312",trim($str));
	$pinyin = strtolower($PinYin->getFirstPY($str));
	return $pinyin;
}


//创建PDCA
function addpdca($user,$month){
	
	if($user && $month){
		//判断PDCA是否存在、
		$pdca = M('pdca')->where(array('tab_user_id'=>$user,'month'=>$month))->find();
		
		//获取用户信息
		$us   = M('account')->find($user);
		if(!$pdca){
			//获取上级评分人信息
			$pfr  = M('auth')->where(array('role_id'=>$us['roleid']))->find();
			$info = array();
			$info['month']        = $month;
			$info['eva_user_id']  = $pfr ? $pfr['pdca_auth'] : 0;
			$info['tab_user_id']  = $user;
			$info['tab_time']     = time();
			$pdcaid = M('pdca')->add($info);
		}else{
			$pdcaid = $pdca['id'];	
		}
	}else{
		$pdcaid = 0;	
	}
	
	return $pdcaid;
}


function qa_score_num($user,$month){
	
	if($user && $month){
	
		$pdcaid = addpdca($user,$month);
		
		//获取加分情况
		$where = array();
		$where['user_id']    = $user;
		$where['month']      = $month;
		$where['status']     = 1;
		$where['type']       = 1;
		$inc_score = M('qaqc_user')->field('score')->where($where)->sum('score');
		
		//获取扣分情况
		$where = array();
		$where['user_id']    = $user;
		$where['month']      = $month;
		$where['status']     = 1;
		$where['type']       = 0;
		$red_score = M('qaqc_user')->field('score')->where($where)->sum('score');
		
		//总分
		$sum = $inc_score - $red_score;
		
		$data = array();
		$data['total_qa_score']  = $sum;
		
		$where = array();
		$where['tab_user_id'] = $user;
		$where['month'] = $month;
		M('pdca')->data($data)->where($where)->save();
		
		return true;	
		
	}else{
		return false;	
	}
	
	
}


function show_score($score){
	if($score==0){
		$return   = '<font color="#999999">无加扣分</font>';	
	}elseif($score<0){
		$return   = '<span class="red">'.$score.'<span>';
	}else{
		$return   = '<span class="green">+'.$score.'<span>';
	}
	
	return $return;
}




function getthemonth($date,$type=0){
	$firstday = date('Y-m-01', strtotime($date));
	$lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
	
	if($type==0){
		return array(strtotime($firstday), strtotime($lastday)+86399);
	}else{
		return array($firstday, $lastday);
	}
   
} 


function set_month($date,$type=0){
	$year   = substr($date,0,4);
	$month  = substr($date,4,2);
	
	//开始日期
	$enddate = $year.'-'.$month.'-25'.' 00:00:00';

	if($month == '01'){
		$year = $year-1;
		$prvemonth = '12';	
	}else{
		$prvemonth = $month-1;	
	}
	
	//结束日期
	$startdate = $year.'-'.sprintf('%02s', $prvemonth).'-26'.' 00:00:00';
	
	if($type){
		$return = array($startdate,$enddate);
	}else{
		$return = array(strtotime($startdate),strtotime($enddate));
	}
	
	return $return;
}


function addkpiinfo($year,$month,$user){
	$yearm = $year.sprintf('%02s', $month);
	
	
	//获取用户信息
	$acc = M('account')->find($user);
	
	//判断月份是否存在
	$where = array();
	$where['month']   = $yearm;
	$where['user_id'] = $user;
	
	//查询这个月的KPI信息
	$kpi = M('kpi')->where($where)->find();
	
	//如果不存在新增
	if(!$kpi){
		//获取评分人信息
		$pfr = M('auth')->where(array('role_id'=>$acc['roleid']))->find();
		$info['ex_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
		$info['mk_user_id']     = $pfr ? $pfr['pdca_auth'] : 0;
		$info['user_id']        = $acc['id'];
		$info['user_name']      = $acc['nickname'];
		$info['role_id']        = $acc['roleid'];
		$info['status']         = 0;
		$info['year']           = $year;
		$info['month']          = $yearm;
		$info['create_time']    = time();
		$kpiid = M('kpi')->add($info);
	}else{
		$kpiid = $kpi['id'];	
	}
	
	
			
	//获取考核指标信息
	$postid = $acc['postid'];
	$quto   = M()->table('__KPI_POST_QUOTA__ as r')->field('c.*')->join('__KPI_CONFIG__ as c on c.id = r.quotaid')->where(array('r.postid'=>$postid))->select();
	
	if($quto){
		foreach($quto as $k=>$v){
			
			
			//整理数据
			$data = array();
			$data['user_id']       = $user;	
			$data['kpi_id']        = $kpiid;
			$data['year']          = $year;
			$data['month']         = $yearm;
			$data['quota_id']      = $v['id'];
			$data['quota_title']   = $v['quota_title'];
			$data['quota_content'] = $v['quota_content'];
			$data['weight']        = $v['weight'];
			$data['status']        = 0;
			$data['create_time']   = time();
			
				
			$where = array();
			$where['month']     = $yearm;
			$where['quota_id']  = $v['id'];
			$where['kpi_id']    = $kpiid;
			$more = M('kpi_more')->where($where)->find();
			if(!$more){
				$zhouqi = set_month($yearm);
				$data['start_date']      = $zhouqi[0];
				$data['end_date']        = $zhouqi[1];
				M('kpi_more')->add($data);
			}else{
				M('kpi_more')->data($data)->where(array('id'=>$more['id']))->save();	
			}
			
		}	
	}
		
}



function updatekpi($month,$user){

	$where = array();
	$where['month']   = $month;
	$where['user_id'] = $user;
	
	$quto   = M('kpi_more')->where($where)->select();

	if($quto){
		foreach($quto as $k=>$v){
            $v['end_date']   = $v['end_date']+86399;
			
			if($v['automatic']==0){
				//获取月度累计毛利额
				if($v['quota_id']==1){
					$where = array();
					$where['b.audit_status']		= 1;
					$where['o.create_user']			= $user;
					$where['l.req_type']			= 801;
					$where['l.audit_time']			= array('between',array($v['start_date'],$v['end_date']));
					$complete = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->sum('b.maoli');

					$complete = $complete ? $complete : 0;
				}

				//获取累计毛利率
				if($v['quota_id']==2){
					$where = array();
					$where['b.audit_status']		= 1;
					$where['o.create_user']			= $user;
					$where['l.req_type']			= 801;
					$where['l.audit_time']			= array('between',array($v['start_date'],$v['end_date']));
					$maoli = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->sum('b.maoli');
					$shouru = M()->table('__OP_SETTLEMENT__ as b')->field('b.shouru')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->sum('b.shouru');
					$complete = round(($maoli / $shouru)*100,2).'%';
				}
				
				//获取回款及时率
				if($v['quota_id']==3){
					$where = array();
					$where['return_time']			= array('lt',$v['end_date']);
					$where['payee']					= $user;
					$shouru		= M('contract_pay')->where($where)->sum('amount');
					$huikuan	= M('contract_pay')->where($where)->sum('pay_amount');
					$complete = round(($huikuan / $shouru)*100,2).'%';
				}
				
				//获取成团率
				if($v['quota_id']==4){

					//计划出团日期在当前考核周期三个月之前一个月的总团数
					$zxm 					= array();
					$where 					= array();
					$where['create_user'] 	= $user;
					$lists 					= M('op')->where($where)->select();
					foreach ($lists as & $val){
						$val['departure'] 	= strtotime($val['departure']);
						if($v['start_date']-90*24*3600<$val['departure'] && $val['departure']<$v['end_date']-90*24*3600 && $val['create_user']==$user){
							$zxm[] = $val;
						}
					}
					$zongxiangmu = count($zxm);

					//求这些团中未成团的个数
					$ct 			= array();
					foreach ($zxm as $value){
						if ($value['group_id']){
							$ct[] 		= $value;
						}
					}
					$chengtuan 		= count($ct);

					//当月未有团时默认满分
					if($zongxiangmu ==0){
						$complete = "100%";
					}else{
						$complete = round(($chengtuan / $zongxiangmu)*100,2).'%';
					}

				}

				//获取合同签订率（含家长协议书）
				if($v['quota_id']==5){
					$where 							= array();
					$where['o.create_user']			= $user;
					$where['c.dep_time']			= array('between',array($v['start_date'],$v['end_date']));
					$xiangmu_list	= M()->table('__OP__ as o')->field('o.op_id,c.dep_time')->join('left join __OP_TEAM_CONFIRM__ as c on o.op_id=c.op_id')->where($where)->select();
					$xiangmu 		= count($xiangmu_list);
                    $hetong_list    = array();
					foreach ($xiangmu_list as $key=>$value){
						//出团后5天内完成上传
						$time 		= $value['dep_time'] + 5*24*3600;
						$list       = M('contract')->where(array('op_id'=>$value['op_id'],'status'=>1,'confirm_time'=>array('lt',$time)))->find();
						if ($list){ $hetong_list[] = $list; }
					}
					$hetong         = count($hetong_list);
					$complete = $xiangmu ? round(($hetong / $xiangmu)*100,2).'%' : 0 .'%';
				}
				
				
				//地接、房、车性价比比选-计调专员，以项目创建时间为准
				if(in_array($v['quota_id'],array(6,81))){
					$where = array();
					$where['o.create_time']			= array('between',array($v['start_date'],$v['end_date']));
					$bj_type 						= array(9,7,8);		//'9'=>'地接社','7'=>'旅游车队','8'=>'酒店'
					$where['c.type'] 				= array('in',$bj_type);
					$where['u.line']				= $user;
					//获取周期内创建的项目数(op_costacc)
					//$sj = M()->table('__OP_AUTH__ as u')->join('__OP__ as o on o.op_id = u.op_id','LEFT')->where($where)->count();
					//获取需要比价的项(类型为地接 , 旅游车队 , 酒店的项)
					$sj_op = M()->table('__OP_AUTH__ as u')->field('o.op_id')->join('__OP__ as o on o.op_id = u.op_id','LEFT')->join('__OP_COSTACC__ as c on c.op_id = o.op_id','LEFT')->where($where)->select();
					$sj = count(array_unique(array_column($sj_op,'op_id')));
					//获取已比价的项目数
					$bj_op = M()->table('__REL_PRICE__ as p')->field('o.op_id')->join('__OP__ as o on o.op_id = p.op_id','LEFT')->join('__OP_AUTH__ as u on u.op_id = p.op_id','LEFT')->join('__OP_COSTACC__ as c on c.op_id = o.op_id','LEFT')->where($where)->select();
					$bj = count(array_unique(array_column($bj_op,'op_id')));
					$complete = $sj ? round(($bj / $sj)*100,2).'%' : '100%';
				}
				
				
				//业务经理 月度累计毛利额-业务经理  6个月平均毛利率-业务经理
				if(in_array($v['quota_id'],array(8,9,10,11))){
					$fzr = C('POST_TEAM_UID');
					if($fzr[$user]){
						//获取具体团队数据
						if($v['quota_id']==8){	
							$ywdata 	= tplist($fzr[$user],array($v['start_date'],$v['end_date']));
							$complete	= $ywdata['zml'] ? $ywdata['zml'] : '0';
						}
						if($v['quota_id']==9){
							$ywdata 	= tplist($fzr[$user],array($v['start_date'],$v['end_date']));
							$complete	= $ywdata['mll'] ? $ywdata['mll'].'%' : '0.00%';	
						}
						if($v['quota_id']==10){
							$xkh		= team_new_customers($fzr[$user],array($v['start_date'],$v['end_date']));
							$complete	= $xkh['ratio'] ? $xkh['ratio'].'%' : '0.00%';	
						}
						if($v['quota_id']==11){
							$xkh		= team_new_customers($fzr[$user],array($v['start_date'],$v['end_date']));
							$complete	= $xkh['reratio'] ? $xkh['reratio'].'%' : '0.00%';	
						}
					}
				}
				
				//月度累计预算准确度
				if($v['quota_id']==15){
					$where = array();
					$where['s.audit_status']		= 1;
					$where['u.line']				= $user;
					//$where['l.req_type']			= 801;
					$where['l.audit_time']			= array('between',array($v['start_date'],$v['end_date']));
					
					//获取总的结算毛利
					$js = M()->table('__OP_SETTLEMENT__ as s')
							 ->join('__AUDIT_LOG__ as l on l.req_id = s.id','LEFT')
							 ->join('__OP_AUTH__ as u 	on u.op_id  = s.op_id','LEFT')
							 ->where($where)->sum('s.maoli');
					
					//获取总的预算毛利		 
					$ys = M()->table('__OP_SETTLEMENT__ as s')
							 ->join('__AUDIT_LOG__ as l on l.req_id = s.id','LEFT')
							 ->join('__OP_AUTH__ as u 	on u.op_id  = s.op_id','LEFT')
							 ->join('__OP_BUDGET__ as b on b.op_id  = s.op_id','LEFT')
							 ->where($where)->sum('b.maoli');

					//定义比较区间
					$v1 = intervalsn($ys,0.10);
					$v2 = intervalsn($ys,0.15);
					/*if($js > $v1[0] && $js<$v1[1]){
						$complete = '100%';
					}else if(($js < $v1[0] && $js > $v2[0]) || ($js > $v1[1] && $js < $v2[1]) ){
						$complete = '80%';
					}else{
						$complete = '0%';	
					}*/
					$complete = '100%';

				}
				
				
				//活动前要素准备不及时
				if($v['quota_id']==16){
					$rsum = user_work_record($user,$month,105);
					if($rsum){
						$rcom	= $rsum>=10 ? 0 : 100-($rsum*10);		
					}else{
						$rcom	= 100;
					}
					$complete	= $rcom.'%';
				}
				
				
				//帐、表、税准确性-财务经理
				if($v['quota_id']==18){
					$rsum = user_work_record($user,$month,205);
					$complete	= $rsum ? '0%' : '100%';
				}
				
				//开具发票、支票、汇票等准确-财务经理
				if(in_array($v['quota_id'],array(20,23,26))){
					$rsum = user_work_record($user,$month,206);
					$complete	= $rsum ? '0%' : '100%';
				}
				
				//帐帐相符、帐实相符-出纳员
				if(in_array($v['quota_id'],array(21,24))){
					$rsum = user_work_record($user,$month,207);
					$complete	= $rsum ? '0%' : '100%';
				}
				
				//办公环境及设施保障指标（OA）-综合部经理
				if(in_array($v['quota_id'],array(27,32,37))){
					$sum = user_work_record($user,$month,208);
					if($sum>4){
						$complete	= 0;	
					}else{
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
					$complete = $complete.'%';
				}
				
				//日常工作及时性
				if(in_array($v['quota_id'],array(19,22,25,28,33,38,45,103))){
					$sum = user_work_record($user,$month,100);
					if($sum>4){
						$complete	= 0;	
					}else{
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
					$complete = $complete.'%';
				}
				
				//活动前要素准备不及时
				if(in_array($v['quota_id'],array(56,113))){
					$rsum = user_work_record($user,$month,106);
					if($rsum){
						$rcom	= $rsum>=20 ? 0 : 100-($rsum*5);		
					}else{
						$rcom	= 100;
					}
					$complete	= $rcom.'%';
				}
				
				//票据及时性--采购经理
				if($v['quota_id']==92){
					$rsum = user_work_record($user,$month,108);
					if($rsum){
						$rcom	= $rsum>=10 ? 0 : 100-($rsum*10);		
					}else{
						$rcom	= 100;
					}
					$complete	= $rcom.'%';
				}
				
				//日常工作质量不合格
				if(in_array($v['quota_id'],array(29,34,39,46,102))){
					$sum = user_work_record($user,$month,200);
					if($v['quota_id']!=102){
						if($sum>4){
							$complete	= 0;	
						}else{
							$zongfen 	= 100-($sum*10);
							$complete	= $zongfen>0 ? $zongfen : 0;
						}
					}else{
						if($sum>1){
							$complete	= 0;	
						}else{
							$zongfen 	= 100-($sum*50);
							$complete	= $zongfen>0 ? $zongfen : 0;
						}
					}
					$complete = $complete.'%';
				}
				
				//中科教微信运营——市场文案
				if($v['quota_id']==55){
					
					$koufen = 0;
					
					//发图出错
					$sum = user_work_record($user,$month,209);
					if($sum>1) 	$koufen += $sum*2;
					
					//一般文字出错
					$sum = user_work_record($user,$month,211);
					if($sum) 	$koufen += $sum*2;
					
					//发文不及时
					$sum = user_work_record($user,$month,array('111','210'));
					if($sum) 	$koufen += $sum*5;
					
					//汇总扣分数
					$zongfen 	= 100-$koufen;
					
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//招聘到岗率
				if($v['quota_id']==42){
					
					//获取招聘人数
					$where = array();
					$where['status']			= 0;
					$where['input_time']		= array('between',array($v['start_date'],$v['end_date']));
					$sum = M('account')->where($where)->count();
					
					$complete = $v['plan'] ? round(($sum / $v['plan'])*100,2).'%' : '100%';
				}
				
				//网站维护--市场文案
				if($v['quota_id']==57){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,array('212','213','112'));
					
					//汇总扣分数
					$zongfen 	= 100-($sum*5);
					
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//学趣微信--市场新媒体
				if($v['quota_id']==58){
					
					$koufen = 0;
					
					//发图出错
					$sum = user_work_record($user,$month,214);
					if($sum>1) 	$koufen += $sum*3;
					
					//发文不及时或者文字错误
					$sum = user_work_record($user,$month,array('113','215'));
					if($sum) 	$koufen += $sum*5;
					
					//汇总扣分数
					$zongfen 	= 100-$koufen;
					
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//信息收集--市场新媒体
				if($v['quota_id']==59){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,array('401','402'));
					
					//汇总扣分数
					$zongfen 	= 100-($sum*2);
					
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//每月新增10家物资采购方--采购经理
				if($v['quota_id']==84){
					
					$where = array();
					$where['input_time']  		= array('between',array($v['start_date'],$v['end_date']));
					$where['input_uid']  		= $user;
					$where['audit_status']  		= 1;
					
					$rsum = M('supplier')->where($where)->count();
					$complete	= $rsum>10 ? '100%' : ($rsum*10).'%';
				}
				
				//新资源拓展--资源管理部（教务专员）
				if(in_array($v['quota_id'],array(112,108,65))){
					
					$where = array();
					$where['input_time']  		= array('between',array($v['start_date'],$v['end_date']));
					$where['input_uid']  		= $user;
					$where['audit_status']  		= 1;
					
					$rsum = M('supplier')->where($where)->count();
					
					$complete = $v['plan'] ? round(($rsum / $v['plan'])*100,2).'%' : '100%';
					
				}
				
				
				//新产品模块开发数量
				if(in_array($v['quota_id'],array(100,96))){
					
					$where = array();
					$where['input_time']  		= array('between',array($v['start_date'],$v['end_date']));
					$where['input_user']  		= $user;
					$where['audit_status']  		= 1;
					
					$rsum = M('product')->where($where)->count();
					
					$complete = $v['plan'] ? round(($rsum / $v['plan'])*100,2).'%' : '100%';
					
				}
				
				
				//活动前期准备--业务助理活动
				if($v['quota_id']==87){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,403);
					
					//汇总扣分数
					$zongfen 	= 100-($sum*2);
					
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//文件归集整理工作--业务助理
				if($v['quota_id']==89){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,array('114','216'));
					
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//完成领导交办的其他任务--业务助理
				if($v['quota_id']==90){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,115);
					
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//网站微信运营--市场经理
				if($v['quota_id']==53){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,404);
					
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				//市场活动前期准备--市场经理
				if($v['quota_id']==52){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,405);
					$zongfen 	= 100-($sum*2);
					$complete	= $zongfen>0 ? $zongfen : 0;
				}
				
				
				//员工满意度--物资专员
				if($v['quota_id']==41){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,300);
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				//物资物料盘点抽查账实相符--物资专员
				if($v['quota_id']==40){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,217);
					if($sum){
						$complete	= 0;	
					}else{
						$complete	= 100;
					}
				}
				
				
				//重大责任事故控制--安全副经理员
				if($v['quota_id']==48){
					
					//汇总记录次数
					$sum = user_work_record($user,$month,218);
					if($sum){
						$complete	= 0;	
					}else{
						$complete	= 100;
					}
				}
				
				
				//培训相关
				if(in_array($v['quota_id'],array(111,107,83,66,54,44,12,95))){
					
					//获取培训次数
					$where = array();
					$where['lecture_date']  		= array('between',array($v['start_date'],$v['end_date']));
					$where['lecturer_uid']  		= $user;
					$where['del']  				= 0;
					$sum = M('cour_ppt')->where($where)->count();
					
					$complete = $v['plan'] ? round(($sum / $v['plan'])*100,2).'%' : '100%';
					
				}
				
				
				//满意度考核-采购经理
				if($v['quota_id']==114){
					$sum = user_work_record($user,$month,217);
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//物资采购合格率--采购经理
				if($v['quota_id']==86){
					$sum = user_work_record($user,$month,217);
					if($sum>4){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//日常所有工作及时性--采购经理
				if($v['quota_id']==85){
					$sum = user_work_record($user,$month,100);
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				//数据前端后端对接--市场PHP
				if($v['quota_id']==64){
					$sum = user_work_record($user,$month,116);
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//前端网页实现--市场PHP
				if($v['quota_id']==63){
					$sum = user_work_record($user,$month,117);
					if($sum>3){
						$complete	= 0;	
					}else{
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				//前端网页实现--市场PHP
				if($v['quota_id']==62){
					$sum = user_work_record($user,$month,118);
					if($sum>3){
						$complete	= 0;	
					}else{
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//满意度调查--安全副经理
				if($v['quota_id']==49){
					
					//获取当月出团项目数
					$where = array();
					$where['o.dep_time']		= array('between',array($v['start_date'],$v['end_date']));
					
					//当月出团项目数
					$ops = M()->table('__OP_TEAM_CONFIRM__ as o')->where($where)->count();
					
					//已巡查的项目数
					$ins = M()->table('__INSPECT__ as i')->join('__OP_TEAM_CONFIRM__ as o on i.group_id = o.group_id','LEFT')->where($where)->count();
					
					$sum = $ops - $ins;
					
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
					
					
				}
				
				//各业务平均毛利率--计调经理
				if($v['quota_id']==80){
					
					
					$zongfen	= 0;
					//京区校内
					$jqxn 		= business_dept_data(35,array($v['start_date'],$v['end_date']));
					$zongfen 	+= absdata($jqxn['mll'],19.5);
					
					//京区校外
					$jqxw		= business_dept_data(80,array($v['start_date'],$v['end_date']));
					$zongfen 	+= absdata($jqxw['mll'],28);
					
					//京外业务
					$jwyw		= business_dept_data(18,array($v['start_date'],$v['end_date']));
					$zongfen 	+= absdata($jwyw['mll'],24.5);
					
					$complete 	= $zongfen ? round(($zongfen / 300)*100,2) : '100';
										
					
				}
				
				
				//物资采购验收率--采购经理
				if($v['quota_id']==91){
					//汇总记录次数
					$sum = user_work_record($user,$month,204);
					if($sum>3){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//日常所有工作及时性--计调经理
				if($v['quota_id']==79){
					//汇总记录次数
					$sum = user_work($user,$month,1);
					if($sum>2){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//安全隐患控制--安全副经理
				if($v['quota_id']==47){
					//汇总记录次数
					$sum = user_work_record($user,$month,219);
					$complete		= $sum ? 0 : 100;	
				}
				
				
				//员工满意度--综合部专员
				if(in_array($v['quota_id'],array(36,31))){
					//汇总记录次数
					$sum = user_work($user,$month,3);
					if($sum>3){
						$complete	= 0;	
					}else{
						$nsum 		= $sum ? $sum-1 : 0;
						//汇总扣分数
						$zongfen 	= 100-($nsum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				//公司制度、文件管理执行率--综合部专员
				if(in_array($v['quota_id'],array(35,30))){
					//汇总记录次数
					$sum = user_work_record($user,$month,220);
					if($sum>2){
						$complete	= 0;	
					}else{
						//汇总扣分数
						$zongfen 	= 100-($sum*10);
						$complete	= $zongfen>0 ? $zongfen : 0;
					}
				}
				
				
				//业务人员满意度--计调经理
				if($v['quota_id']==82){
					
					//获取当月出团项目数
					$where = array();
					$where['o.ret_time']		= array('between',array($v['start_date'],$v['end_date']));
					$where['e.liable_uid']	= $user;
					$where['e.eval_type']	= 2;
					
					//当月结束的团项目数
					$cou = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->count();
					
					$sum = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->sum('score');
					
					//平均得分
					$score = round($sum/($cou*100)*100);
					if($score>=85 || !$cou){
						$complete	= 100;	
					}else{
						$complete	= $score;	
					}
					
				}
				
				
				//资源配置质量--资源管理部（教务专员）
				if(in_array($v['quota_id'],array(110,106,67))){
					
					//获取当月出团项目数
					$where = array();
					$where['o.dep_time']		= array('between',array($v['start_date'],$v['end_date']));
					$where['e.liable_uid']	= $user;
					$where['e.eval_type']	= 3;
					
					//当月结束的团项目数
					$cou = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->count();
					
					$sum = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->sum('score');
					
					//平均得分
					$score = round($sum/($cou*90)*100);
					if($score>100 || !$cou){
						$complete	= 100;	
					}else{
						$complete	= $score;	
					}
					
				}
				
				
				//产品方案完成质量---研发
				if(in_array($v['quota_id'],array(99,94))){
					
					//获取当月出团项目数
					$where = array();
					$where['o.dep_time']		= array('between',array($v['start_date'],$v['end_date']));
					$where['e.liable_uid']	= $user;
					$where['e.eval_type']	= 1;
					
					//当月结束的团项目数
					$cou = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->count();
					
					$sum = M()->table('__OP_EVAL__ as e')->join('__OP_TEAM_CONFIRM__ as o on o.op_id = e.op_id','LEFT')->where($where)->sum('score');
					
					//平均得分
					$score = round($sum/($cou*90)*100);
					if($score>100 || !$cou){
						$complete	= 100;	
					}else{
						$complete	= $score;	
					}
					
				}

                //月度顾客满意度
                if($v['quota_id']==124){

                    //获取当月已评分的团
                    $where                  = array();
                    $where['s.input_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['o.create_user'] = $user;
                    $lists = M()->table('__TCS_SCORE__ as s')->field('u.op_id,o.kind,s.id as sid,s.stay,s.travel,s.content,s.food,s.bus,s.driver,s.guide,s.teacher,s.depth,s.major,s.interest,s.material,s.late,s.manage,s.morality')->join('join __TCS_SCORE_USER__ as u on u.id = s.uid','left')->join('__OP__ as o on o.op_id = u.op_id','left')->where($where)->select();

                    $average = get_manyidu($lists);

                    //无项目的，得0分；有项目，但无调查项目的，得100分。
                    //本月实际实施团
                    $where                  = array();
                    $where['dep_time']      = array('between',array($v['start_date'],$v['end_date']));
                    $where['user_id']       = $user;
                    $shishi = M('op_team_confirm')->where($where)->getField('op_id',true);
                    //需要辅导员的团
                    $where                  = array();
                    $where['in_begin_day']  = array('between',array($v['start_date'],$v['end_date']));
                    $where['manager_id']    = $user;
                    $need_guide             = M('op_guide_confirm')->where($where)->count();

                    if ($shishi && !$need_guide){
                        //有项目，但无调查项目的，得100分。
                        $complete = 100;
                    }else{
                        //平均得分(如果得分>90%,得分100, 如果小于90%,以90%作为满分求百分比)
                        $score = (round($average*100/90,2))*100;
                        $complete = $average > 0.9 ? 100 : $score;
                    }
                }

                //业务人员满意度（京区业务中心研发)
                /*if ($v['quota_id']==129){
                    $where = array();
                    $where['s.input_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['r.exe_user_id'] = $user;
                    $lists = M()->table('__TCS_SCORE_USER__ as u')
                        ->field('u.confirm_id,s.*,o.kind')
                        ->join('__TCS_SCORE__ as s on s.uid = u.id','left')
                        ->join('__OP__ as o on o.op_id = u.op_id','left')
                        ->join('__OP_RES__ as r on r.op_id = u.op_id','left')
                        ->where($where)
                        ->select();

                    //合格率>0.9(满分)
                    $hegelv = get_hegelvaa($lists);
                    if($hegelv>0.9 || !$lists){
                        $complete	= 100;
                    }else{
                        $complete	= (round($hegelv/0.9,2)*100).'%';
                    }
                }*/
                if ($v['quota_id']==129){
                    $where = array();
                    $where['create_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['yf_uid']        = $user;
                    $lists = M('op_score')->field('match,innovate,cost,safe,ptfa')->where($where)->select();

                    //合格率>0.9(满分)
                    $hegelv = get_hegelv($lists,5);

                    if($hegelv>0.9 || !$lists){
                        $complete	= 100;
                    }else{
                        $complete	= (round($hegelv/0.9,2)*100).'%';
                    }
                }

                //工作及时率(京区业务中心)(工单)
                /*if ($v['quota_id']==130){
                    //5天内完成为不超时
                    $where                  = array();
                    $where['audit_time']    = array('between',array($v['start_date']-5*86400,$v['end_date']-4*86400));
                    $where['audit_status']  = 1;
                    $where['exe_user_id']   = $user;
                    $lists1 = M('op_res')->where($where)->select();         //资源需求单
                    $lists2 = M('op_design')->where($where)->select();      //设计委托单
                    $lists3 = M('op_work_plans')->where($where)->select();  //工作计划单
                    $lists  = array();
                    foreach ($lists1 as $aa=>$bb){
                        $lists[] = $bb;
                    }
                    foreach ($lists2 as $cc=>$dd){
                        $lists[] = $dd;
                    }
                    foreach ($lists3 as $ee=>$ff){
                        $lists[] = $ff;
                    }

                    $hege   = array();
                    foreach ($lists as $key=>$value){
                        $time   = $value['feedback_time'] - $value['create_time'];
                        $ftime  = $value['finish_time'] - $value['create_time'];
                        if ((0<$time && $time< 5*86400) || (0<$ftime && $ftime<5*86400)){
                            $hege[] = $value;
                        }
                    }
                    $zongxiangmu    = count($lists);
                    $hegexiangmu    = count($hege);
                    $hegelv         = round($hegexiangmu/$zongxiangmu,2);

                    if($hegelv>0.9 || !$zongxiangmu){
                        $complete	= 100;
                    }else{
                        $complete	= round($hegelv/0.9,2)*100;
                    }
                }*/
                if (in_array($v['quota_id'],array(130,136,148,150))){
                    //及时率
                    $jishilv_data           = get_jishilv($user,$v['start_date'],$v['end_date']);
                    $jishilv                = $jishilv_data['jishilv'];

                    if($jishilv>0.9 || !$jishilv_data['zongshu']){
                        $complete	= 100;
                    }else{
                        $complete	= round($jishilv/0.9,2)*100;
                    }

                }

                //研发培训(京区业务中心研发)(每月至少培训一次)
                if ($v['quota_id']==131){
                    //培训完成率
                    $peixun_data            = get_peixunlv($user,$v['start_date'],$v['end_date'],1);
                    $zongshu                = $peixun_data['zongshu'];
                    $peixunlv               = $peixun_data['peixunlv'];

                    if($peixunlv >= 1 || !$zongshu){
                        $complete	= 100;
                    }else{
                        $complete	= ($peixunlv*100).'%';
                    }
                }

                //辅导员/教师管理及时率(京区业务中心教务)
                if ($v['quota_id']==132){
                    //辅导员管理及时率
                    $jishilv_data       = get_fdyjsl($user,$v['start_date'],$v['end_date']);
                    $jishilv            = $jishilv_data['hegelv'];

                    if($jishilv >= 1){
                        $complete	= 100;
                    }else{
                        $complete	= ($jishilv*100).'%';
                    }
                }

                //辅导员/教师管理满意度(京区业务中心教务)
                if ($v['quota_id']==133){
                    $manyidu_data       = get_jw_myd($user,$v['start_date'],$v['end_date']);
                    $hegelv             = $manyidu_data['hegelv'];
                    if($hegelv >= 0.9){
                        $complete	= 100;
                    }else{
                        $complete   = (round($hegelv/0.9,2)*100).'%';
                    }
                }

                //辅导员管理准确性(京区业务中心教务)
                if ($v['quota_id']==134){
                    //辅导员管理准确性
                    $zhunque_data       = get_fdyzqx($user,$v['start_date'],$v['end_date']);
                    $buhegeshu          = $zhunque_data['buhegeshu'];

                    if($buhegeshu <= 1){
                        $complete	= 100;
                    }else{
                        $cifang     = $buhegeshu - 2;
                        $fenshu     = 5*pow(2,$cifang);
                        if ($fenshu > 100) { $fenshu = 100; };
                        $complete	= (100 - $fenshu).'%';
                    }
                }

                //辅导员/教师资源培训完成率(京区业务中心教务)
                if ($v['quota_id']==135){
                    $where                  = array();
                    $where['manager_id']    = $user;
                    $where['set_guide_time']= array('between',array($v['start_date'],$v['end_date']));
                    $field                  = 'op_id,id as confirm_id,manager_id,set_guide_time';
                    $lists                  = M('op_guide_confirm')->field($field)->where($where)->group('op_id')->select();
                    $count                  = count($lists);

                    $peixun_data            = get_peixunlv($user,$v['start_date'],$v['end_date'],$count,$lists);
                    $peixunlv               = $peixun_data['peixunlv'];

                    if($peixunlv >= 1){
                        $complete	= 100;
                    }else{
                        $complete	= ($peixunlv*100).'%';
                    }
                }

                //场馆资源调度质量(京区业务中心资源)
                if ($v['quota_id']==137){
                    $where = array();
                    $where['create_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['zy_uid']        = $user;
                    $lists = M('op_score')->field('times,finish,site')->where($where)->select();

                    //合格率>0.9(满分)
                    $hegelv = get_hegelv($lists,3);

                    if($hegelv>0.9 || !$lists){
                        $complete	= 100;
                    }else{
                        $complete	= (round($hegelv/0.9,2)*100).'%';
                    }
                }

                //新增资源转化率(京区业务中心资源)
                if ($v['quota_id']==138){
                    $zhuanhualv_data = get_zhuanhualv($user,$v['start_date'],$v['end_date']);
                    $xinzengshu      = $zhuanhualv_data['xinzengshu'];
                    $zhuanhualv      = $zhuanhualv_data['zhuanhualv'];

                    if($zhuanhualv >= 1 || !$xinzengshu){
                        $complete	= 100;
                    }else{
                        $complete	= $zhuanhualv*100;
                    }
                }

                //资源培训率(京区业务中心资源)
                if ($v['quota_id']==139){
                    //需要培训的资源数
                    $where                  = array();
                    $where['input_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['audit_status']  = 1;    //审核通过
                    $where['input_user']    = $user;
                    $lists                  = M('cas_res')->where($where)->getField('id',true);
                    $count                  = count($lists);
                    $peixun_data            = get_peixunlv($user,$v['start_date'],$v['end_date'],$count,$lists);
                    $peixunlv               = $peixun_data['peixunlv'];

                    if($peixunlv >= 1){
                        $complete	= 100;
                    }else{
                        $complete	= $peixunlv*100;
                    }
                }

                //业务人员满意度调查(计调)
                if ($v['quota_id']==140){
                    $where = array();
                    $where['jd_score_time']	= array('between',array($v['start_date'],$v['end_date']));
                    $where['jd_uid']        = $user;
                    $lists = M('op_score')->field('ysjsx,zhunbei,peixun,genjin,yingji')->where($where)->select();

                    //合格率>0.9(满分)
                    $hegelv = get_hegelv($lists,5);

                    if($hegelv>0.9 || !$lists){
                        $complete	= 100;
                    }else{
                        $complete	= (round($hegelv/0.9,2)*100).'%';
                    }
                }

                //地接社、酒店、旅游车转化率(计调)
                if ($v['quota_id']==141){
                    $zhuanhualv_data      = jd_zhuanhualv($user,$v['start_date'],$v['end_date']);
                    $xinzengshu           = $zhuanhualv_data['xinzengshu'];
                    $zhuanhualv           = $zhuanhualv_data['zhuanhualv'];

                    /*if ($zhuanhualv >= 1 || !$xinzengshu){*/
                    if ($zhuanhualv >= 1){
                        $complete   = 100;
                    }else{
                        $complete   = ($zhuanhualv*100).'%';
                    }
                }

                //培训完成率
                if ($v['quota_id']==143){
                   //需要培训数量
                    $where                  = array();
                    $where['c.dep_time']    = array('between',array($v['start_date'],$v['end_date']));
                    $where['a.yusuan']      = $user;
                    $lists                  = M()->table('__OP__ as o')->field('o.op_id,o.kind,k.name')->join('__OP_AUTH__ as a on a.op_id=o.op_id','left')->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->join('__PROJECT_KIND__ as k on k.id=o.kind','left')->group('o.kind')->where($where)->select();
                    $count                  = count($lists);
                    $peixun_data            = get_peixunlv($user,$v['start_date'],$v['end_date'],$count,$lists);
                    $zongshu                = $peixun_data['zongshu'];
                    $peixunlv               = $peixun_data['peixunlv'];

                    $complete   = $peixunlv?$peixunlv*100:100;
                }

                //客户满意度(客服)(58=>亲子旅行,59=>冬夏令营,63=>学趣课程)
                if ($v['quota_id']==144){
                    //获取当月已评分的相关团
                    $kinds                  = array(58,59,63);
                    $field                  = 'before_sell';
                    $manyidu_data           = get_kfmyd($v['start_date'],$v['end_date'],$kinds,$field,1);
                    $pingfencishu           = $manyidu_data['pingfencishu'];
                    $hegelv                 = $manyidu_data['hegelv'];

                    if ($hegelv >= 0.9 && !$pingfencishu){
                        $complete = 100;
                    }else{
                        $score = (round($hegelv*100/90,2))*100;
                        $complete = $score;
                    }
                }

                //工作及时性(客服)(工单)
                if ($v['quota_id']==145){
                    $ini_user_ids           = array(59);    //学趣主管
                    $jishilv_data           = get_jishilv($user,$v['start_date'],$v['end_date'],$ini_user_ids);
                    $zongshu                = $jishilv_data['zongshu'];
                    $jishilv                = $jishilv_data['jishilv'];
                    $complete               = ($jishilv >=1 || !$zongshu)? 100 : $jishilv*100;
                }

                //工作准确性(客服)(工单)
                if ($v['quota_id']==146){
                    $ini_user_ids           = array(33,86,39);  //计调
                    $jishilv_data           = get_jishilv($user,$v['start_date'],$v['end_date'],$ini_user_ids);
                    $zongshu                = $jishilv_data['zongshu'];
                    $jishilv                = $jishilv_data['jishilv'];
                    $complete               = ($jishilv >=1 || !$zongshu)? 100 : $jishilv*100;
                }

                //客户满意度('新媒体推广')
                if ($v['quota_id']==147){
                    $field                  = 'new_media';
                    $manyidu_data           = get_kfmyd($v['start_date'],$v['end_date'],'',$field,1);
                    $pingfencishu           = $manyidu_data['pingfencishu'];
                    $hegelv                 = $manyidu_data['hegelv'];

                    if ($hegelv >= 0.9 && !$pingfencishu){
                        $complete = 100;
                    }else{
                        $score = (round($hegelv*100/90,2))*100;
                        $complete = $score;
                    }
                }

                //工作及时性('新媒体推广')148=>同上
                //工作及时性(' 平面设计')150=>同上
                //工作质量('新媒体推广')149
                if ($v['quota_id']==149){
                    $score_date             = get_worder_score($user,$v['start_date'],$v['end_date'],4);
                    $pingfencishu           = $score_date['pingfencishu'];
                    $hegelv                 = $score_date['hegelv'];

                    if ($hegelv >= 1 || !$pingfencishu){
                        $complete           = 100;
                    }else{
                        $complete           = round(($hegelv*100)/72,2)*100;
                    }
                }

                //工作质量('平面设计')151
                if ($v['quota_id']==151){
                    $score_date             = get_worder_score($user,$v['start_date'],$v['end_date'],5);
                    $pingfencishu           = $score_date['pingfencishu'];
                    $hegelv                 = $score_date['hegelv'];

                    if ($hegelv >= 1 || !$pingfencishu){
                        $complete           = 100;
                    }else{
                        $complete           = round(($hegelv*100)/72,2)*100;
                    }
                }

				//已实现自动获取指标值
				$auto_quta	= array(1,2,3,4,5,6,81,8,9,10,11,15,16,18,20,23,26,21,24,27,32,37,19,22,25,28,33,38,42,45,103,56,113,92,29,34,39,46,102,55,57,58,59,84,87,89,90,111,107,83,66,54,44,12,112,108,100,96,95,65,114,86,85,64,63,62,53,52,41,40,49,80,48,91,79,47,36,35,31,30,82,110,106,99,94,67,124,129,130,131,132,133,134,135,136,137,138,139,140,141,143,144,145,146,147,148,149,150,151);
				
				//计算完成率并保存数据
				if(in_array($v['quota_id'],$auto_quta)){
					
					$rate = $v['target'] ? round(($complete / $v['target'])*100,2) : 100;
					$rate = $rate>100 ? 100 : $rate; 
					
					$data = array();
					$data['complete']		= $complete;
					$data['complete_rate']	= $rate."%";
					$data['score']			= round(($rate * $v['weight']) / 100,1);
					$data['score_status']	= 1;

					
				}else{
					
					$rate = 100;
					$data = array();
					//$data['complete']		= $complete;
					//$data['complete_rate']	= $rate."%";
					$data['score']			= round(($rate * $v['weight']) / 100,1);
					$data['score_status']	= 1;
				}
				
				M('kpi_more')->data($data)->where(array('id'=>$v['id']))->save();	
				
			}
			
			//合计总分
			$total	= M('kpi_more')->field('score,weight,score_status')->where(array('kpi_id'=>$v['kpi_id']))->sum('score');
			$issave	= M('kpi')->data(array('score'=>$total))->where(array('id'=>$v['kpi_id']))->save();

		}

	}
}



function get_role_link($roleid,$rtype = 0){
	
	global $rolegroup;
	
	$role = M('role')->find($roleid);
	
	$rolegroup[$role['id']] = $role['role_name'];	
		
	if($role['pid']!=0){
		get_role_link($role['pid']);
	}
	
	$return = array_reverse($rolegroup,true);
	
	if($rtype){
		return $return;
	}else{
		$rid = array();
		foreach($return as $k=>$v){
			$rid[] = '['.$k.']';
		}
		return implode(',',$rid);
		
	}

}


function update_user_role($id){
	
	$db = M('account');
	
	$user = $db->field('id,roleid,group_role')->find($id);
	
	$info = array();
	$info['group_role'] = get_role_link($user['roleid']);
	
	$save = $db->data($info)->where(array('id'=>$id))->save();
	if($save){
		return 0;	
	}else{
		return 1;	
	}
	
}


function update_userlist_role(){
	
	$db = M('account');
	
	$user = $db->field('id,roleid,group_role')->select();
	
	$i = 0;
	foreach($user as $v){
		
		$save = update_user_role($v['id']);
		global $rolegroup;
		$rolegroup = array();
		if($save==0){
			$i++;	
		}
		
	}
	
	return $i;
	
}

//获取上月25至本月25时间戳
/*function twentyfive(){
	$today = date('d',time());
	if($today<25){
		$firstday		= date("Y-m-25",strtotime('-1 month')); 
		$lastday		= date("Y-m-25",time());
	}else{
		$firstday		= date("Y-m-25",time());
		$lastday		= date("Y-m-25",strtotime('+1 month')); 
	}
	
	if($firstday<'2018-01-01') $firstday = '2018-01-01';
	$firsttime		= strtotime($firstday);
	$lasttime		= strtotime($lastday)+86399;
	
	$return = array();
	$return[0] = $firsttime;
	$return[1] = $lasttime;

	return $return;
}*/
function twentyfive(){
    $today = date('d',time());
    if($today<26){
        $firstday		= date("Y-m-26",strtotime('-1 month'));
        $lastday		= date("Y-m-25",time());
    }else{
        $firstday		= date("Y-m-26",time());
        $lastday		= date("Y-m-25",strtotime('+1 month'));
    }

    if($firstday<'2018-01-01') $firstday = '2017-12-26';
    $firsttime		= strtotime($firstday);
    $lasttime		= strtotime($lastday)+86399;

    $return = array();
    $return[0] = $firsttime;
    $return[1] = $lasttime;

    return $return;
}

//获取当前月份的周期
function get_cycle($yearmonth,$day=26){
    if ($yearmonth){
        $year       = substr($yearmonth,0,4);
        $month      = substr($yearmonth,4,2);
        $data       = array();
        if ($month ==01){
            $mon                = 12;
            $data['beginday']   = ($year-1).$mon.$day;
            $data['endday']     = $yearmonth.$day;
            $data['begintime']  = strtotime($data['beginday']);
            $data['endtime']    = strtotime($data['endday']);
        }else{
            $data['beginday']   = ($yearmonth-1).$day;
            $data['endday']     = $yearmonth.$day;
            $data['begintime']  = strtotime($data['beginday']);
            $data['endtime']    = strtotime($data['endday']);
        }
    }
    return $data;
}

//统计部门数据
function tplist($roleid,$times){
	
	$db			= M('op');
	$roles		= M('role')->GetField('id,role_name',true);
	
	$post 		= C('POST_TEAM');
	$postmore	= C('POST_TEAM_MORE');
	$postfzr  	= C('POST_TEAM_FZR');
	
	//获取部门人数
	$where = array();
	$where['roleid'] = array('in',$postmore[$roleid]);
	$where['status'] = array('eq',0);
	$users = M('account')->where($where)->select();
	$num   = count($users);
	$ulist = array();
	foreach($users as $k=>$v){
		$ulist[] = $v['id'];
	}
	
	//查询结算数据
	$where = array();
	$where['b.audit_status']		= 1;
	$where['l.req_type']			= 801;
	if($times){
		$where['l.audit_time']		= array('between',$times);
	}else{
		$where['l.audit_time']		= array('gt',strtotime('2018-01-01'));
	}
	$where['a.id']					= array('in',implode(',',$ulist));
	
	$field = array();
	$field[] =  'sum(b.shouru) as zsr';
	$field[] =  'sum(b.maoli) as zml';
	$field[] =  '(sum(b.maoli)/sum(b.shouru)) as mll';
	
	$lists = $db->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->order('zsr DESC')->find();
	
	$lists['mll']			= $lists['zml']>0 ?  sprintf("%.2f",$lists['mll']*100) : '0.00';	
	
	$lists['zsr'] 			= $lists['zsr'] ? $lists['zsr'] : '0.00';	
	$lists['zml'] 			= $lists['zml'] ? $lists['zml'] : '0.00';	
	$lists['rjzsr']			= sprintf("%.2f",$lists['zsr']/$num);	
	$lists['rjzml']			= sprintf("%.2f",$lists['zml']/$num);	
	$lists['rjmll']			= $lists['zml'] ? sprintf("%.2f",($lists['rjzml']/$lists['rjzsr'])*100) : '0.00';	
	
	
	//查询月度
	$month = twentyfive();
	$where = array();
	$where['b.audit_status']	= 1;
	$where['a.id']				= array('in',implode(',',$ulist));
	$where['l.req_type']		= 801;
	$where['l.audit_time']		= array('between',array($month[0],$month[1]));
	
	$field = array();
	$field[] =  'sum(b.shouru) as ysr';
	$field[] =  'sum(b.maoli) as yml';
	$field[] =  '(sum(b.maoli)/sum(b.shouru)) as yll';
	$users = $db->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->find();
	
	$users['ysr'] 		= $users['ysr'] ? $users['ysr'] : '0.00';	
	$users['yml'] 		= $users['yml'] ? $users['yml'] : '0.00';		
	$users['yll'] 		= $users['yml']>0 ? sprintf("%.4f",$users['yll'])*100 : '0.00';	
	$users['rjysr']		= sprintf("%.2f",$users['ysr']/$num);	
	$users['rjyml']		= sprintf("%.2f",$users['yml']/$num);	
	$users['rjyll']		= sprintf("%.2f",($users['rjyml']/$users['rjysr'])*100);	
	$users['num']		= $num;
	$users['rid']		= $roleid;
	$users['fzr']		= $postfzr[$roleid];
	
	return array_merge($lists, $users);
}



//获取某时间段个人业绩
function personal_income($userid,$time,$yearTime){
	
	$month = twentyfive();

	//查询月度
	$where = array();
	$where['b.audit_status']	= 1;
	$where['o.create_user']		= $userid;
	$where['a.req_type']		= 801;
	
	if($time == 0){
		$where['a.audit_time']		= array('between',$yearTime);
	}else{
		$where['a.audit_time']		= array('between',$month); 
	}
	
	$field = array();
	$field[] =  'sum(b.shouru) as zsr';
	$field[] =  'sum(b.maoli) as zml';
	$field[] =  '(sum(b.maoli)/sum(b.shouru)) as mll';
	$users = M()->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as a on a.req_id = b.id','LEFT')->where($where)->find();
	
	$lists = array();
	$lists['zsr'] 		=  $users['zsr'] ? $users['zsr'] : '0.00';	
	$lists['zml'] 		=  $users['zml'] ? $users['zml'] : '0.00';		
	$lists['mll'] 		=  $users['zml']>0 ? sprintf("%.4f",$users['mll'])*100 : '0.00';	
	
	return $lists;	
}



//统计大业务部数据
function business_dept_data($roleid,$times){
	
	$db			= M('op');
	$roles		= M('role')->GetField('id,role_name',true);
	
	$postmore	= C('POST_TEAM_MORE_ALL');
	
	//获取部门人数
	$where = array();
	$where['roleid'] = array('in',$postmore[$roleid]);
	$where['status'] = array('eq',0);
	$users = M('account')->where($where)->select();	
	$num   = count($users);
	$ulist = array();
	foreach($users as $k=>$v){
		$ulist[] = $v['id'];
	}
	
	//查询结算数据
	$where = array();
	$where['b.audit_status']		= 1;
	$where['l.req_type']			= 801;
	$where['l.audit_time']			= array('between',$times);
	$where['a.id']					= array('in',implode(',',$ulist));
	
	$field = array();
	$field[] =  'sum(b.shouru) as zsr';
	$field[] =  'sum(b.maoli) as zml';
	$field[] =  '(sum(b.maoli)/sum(b.shouru)) as mll';
	
	$lists = $db->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->order('zsr DESC')->find();
	
	$lists['mll']			= $lists['zml']>0 ?  sprintf("%.2f",$lists['mll']*100) : '0.00';	
	

	
	return $lists;
}



//获取自己下属员工ID
function get_branch_user(){
	
	$post = M('posts')->GetField('id,post_name',true);
	
	//获取自己的岗位信息
	$me = M('account')->find(cookie('userid'));
	
	//获取属于员工信息
	$where = array();
	/*
	if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==11 ){}else{
		$where['group_role']	= array('like','%['.cookie('roleid').']%');
	}
	*/
	
	
	$where['status']		= 0;
	$userlist = M('account')->field('id,nickname,roleid,postid')->where($where)->order('postid ASC')->select();
	$uid = array();
	$pid = array();
	$dpid = '';
	
	foreach($userlist as $k=>$v){
		$uid[]	= $v['id'];	
		if($v['postid']){
			$pid[$v['postid']]	= $post[$v['postid']];
		}
		if(!$dpid){
			$dpid = 	$v['postid'];
		}
	}
	
	$return = array();
	$return['uid']	= $uid;
	$return['pid']	= $pid;
	$return['dpid']	= $me['postid'] ? $me['postid'] : $dpid;
	
	return $return;
	
	
}



//统计部门时间段内新增客户数量
function team_new_customers($roleid,$times){
	
	$db			= M();
	$postmore	= C('POST_TEAM_MORE');
	$asstime	= $times[0]-(86400*365);
					
	//获取至考核开始日期司龄1年以上的业务人员数
	$where = array();
	$where['roleid']		= array('in',$postmore[$roleid]);
	$where['status']		= 0;
	$where['entry_time']	= array('lt',$asstime);
	$old					= M('account')->where($where)->GetField('id',true);	
	$oldnum					= count($old) ? count($old) : 0;
	
	//获取至考核开始日期司龄1年以下的业务人员数
	$where = array();
	$where['roleid']		= array('in',$postmore[$roleid]);
	$where['status']		= 0;
	$where['entry_time']	= array('gt',$asstime);
	$young					= M('account')->where($where)->GetField('id',true);	
	$youngnum				= count($young) ? count($young) : 0;
	
	//应该成交的新客户数
	$mubiao = ($oldnum*1*3)+($youngnum*0.5*3);
				
	//部门总人员名单
	$ulist	= array_merge($old, $young);
	
	//查询结算数据
	$where = array();
	$where['b.audit_status']		= 1;
	$where['l.req_type']			= 801;
	$where['l.audit_time']			= array('between',$times);
	$where['a.id']					= array('in',implode(',',$ulist));
	$field 							= 'o.customer';
	$lists = $db->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->group($field)->select();
	
	$xinzeng = 0;
	$erci    = 0;
	foreach($lists as $k=>$v){
		
		//查询该客户在考核前以前有没有产生过项目
		$where = array();
		$where['b.audit_status']		= 1;
		$where['l.req_type']			= 801;
		$where['l.audit_time']			= array('lt',$times[0]);
		$where['a.id']					= array('in',implode(',',$ulist));
		$where['o.customer']			= trim($v['customer']);
		$check = $db->table('__OP_SETTLEMENT__ as b')->field($field)->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->where($where)->find();
		if($check){
			$erci++;
		}else{
			$xinzeng++;
		}
	}
	
	
	$return = array();
	$return['suoyou'] 	= count($lists);
	$return['mubiao'] 	= $mubiao;
	$return['xinzeng'] 	= $xinzeng;
	$return['erci'] 	= $erci;
	$return['ratio'] 	= sprintf("%.4f",($xinzeng/$mubiao))*100;
	$return['reratio'] 	= sprintf("%.4f",($erci/count($lists)))*100;
	
	return $return;
	
}



function save_aontract_art($releid,$data){
	//处理图片
	$where = array();
	$where['cid']  = $releid;
	
	$db = M('contract_pic');
	$id = array();
	
	if(is_array($data)){
		foreach($data['filepath'] as $k=>$v){
			
			if($data['filepath'][$k]){
				//保存数据
				$info = array();	
				$info['cid']        = $releid; 
				$info['filename']	= $data['filename'][$k]; 
				$info['filepath']  	= $data['filepath'][$k]; 
				$info['fileid']		= $data['id'][$k]; 
				$info['uptime']		= time(); 
				$info['upuser']		= cookie('userid'); 
				$info['upusername']	= cookie('nickname'); 
				
				//判断是否存在
				$isup = $db->where(array('cid'=>$releid,'fileid'=>$data['id'][$k]))->find();
				
				if($isup){
					$issave = $db->where(array('id'=>$isup['id']))->save($info);
					$id[]	= $isup['id'];
				}else{
					$id[]	= $db->add($info);	
				}
				
				
				//更新图片库
				$info = array();
				$info['filename']	= $data['filename'][$k]; 
				M('attachment')->data($info)->where(array('id'=>$data['id'][$k]))->save();
			}
			
		}
		$where['id']     = array('not in',implode(',',$id));
	}
	
	//删除
	$isdel = $db->where($where)->select();
	if($isdel){
		foreach($isdel as $k=>$v){
			$db->where(array('id'=>$v['id']))->delete();
		}	
	}
}


function get_aontract_res($releid){
	$attid	= array();
	$db		= M('contract_pic');
	$attachment = $db->field('fileid')->where(array('cid'=>$releid))->select();
	foreach($attachment as $v){
		$attid[] = 	$v['fileid'];
	}
	return implode(',',$attid);
}



function save_payment($releid,$data){
	
	//获取合同信息
	$contract	= M('contract')->find($releid);
	$op			= M('op')->where(array('op_id'=>$contract['op_id']))->find();
	
	//处理图片
	$where = array();
	$where['cid']  = $releid;
	
	$db = M('contract_pay');
	$id = array();
	
	if(is_array($data)){
		foreach($data as $k=>$v){
			
			
			
			//保存数据
			$info = array();	
			$info['cid']			= $releid; 
			$info['no']			= $v['no']; 
			$info['pro_name']	= $contract['pro_name']; 
			$info['op_id']  		= $contract['op_id']; 
			$info['amount']		= $v['amount']; 
			$info['ratio']		= $v['ratio']; 
			$info['return_time']	= strtotime($v['return_time']); 
			$info['remark']		= $v['remarks']; 
			$info['userid'] 		= cookie('userid');
			$info['payee']		= $op['create_user'];
			
			if($v['pid']){
				$issave = $db->where(array('id'=>$v['pid']))->save($info);
				$id[]	= $v['pid'];
			}else{
				$info['create_time'] 	= time();
				$id[]	= $db->add($info);	
			}
			
		}
		$where['id']     = array('not in',implode(',',$id));
	}
	
	//删除
	$isdel = $db->where($where)->select();
	if($isdel){
		foreach($isdel as $k=>$v){
			$db->where(array('id'=>$v['id']))->delete();
		}	
	}
}


//判断是否为图片
function isimg($path){
	if($path){
		$file	= explode('.',$path);
		$ext	= strtoupper($file[1]);
		$extlist = array('JPG','PNG','GIF','JPEG');
		if(in_array($ext,$extlist)){
			return 0;
		}else{
			return $ext;	
		}
	}	
}


//创建项目工单
function project_worder($exe_user_id,$pro_id,$thing){
	$account_db     = M('account');
	$role_db        = M('role');
	$op_db 			= M('op');
	$worder_db 		= M('worder');
	$worder         = array();
	$worder['exe_user_id']      = $exe_user_id;
	$worder['exe_user_name']    = $account_db->where("id = '$exe_user_id'")->getfield('nickname');
	$exe_dept_id                = $account_db->where("id = '$exe_user_id'")->getfield('roleid');
	$worder['exe_dept_id']      = $exe_dept_id;
	$worder['exe_dept_name']    = $role_db->where("id = '$exe_dept_id'")->getfield('role_name');
	$pro 						= $op_db->where("op_id = '$pro_id'")->find();
	$worder['worder_title']   	= $pro['project'];
	$worder['worder_content']   = "处理事项为:".$thing."; 项目编号为".$pro_id;
	$worder['worder_type']      = 100;     //项目工单
	$worder['status']           = 0;
	$worder['ini_user_id']      = $_SESSION['userid'];
	$worder['ini_user_name'] 	= $_SESSION['username'];
	$worder['ini_dept_id']      = $_SESSION['roleid'];
	$worder['ini_dept_name']    = $_SESSION['rolename'];
	$worder['create_time']      = NOW_TIME;
	//$worder['plan_complete_time'] = NOW_TIME+(3600*24*5);
	$worder['plan_complete_time'] = strtotime(getAfterWorkDay(5));
	$res = $worder_db->add($worder);
	if ($res){
		//发送系统通知消息
		$uid     = cookie('userid');
		$title   = '您有来自['.$worder['ini_dept_name'].'--'.$worder['ini_user_name'].']指派的负责['.$thing.']项目工单待执行!';
		$content = '';
		//$url     = U('worder/my_worder',array('id'=>$worder['exe_user_id'],'pin'=>102));
		$url     = U('worder/worder_info',array('id'=>$res));
		$user    = '['.$worder['exe_user_id'].']';
		send_msg($uid,$title,$content,$url,$user,'');
	}

}


//获取某个员工某项工作记录数
function user_work_record($user,$month,$type){
	
	$db 	= M('work_record');
	
	$where 	= array();
	$where['status'] 	= 0;
	$where['month'] 	= $month;
	$where['user_id'] 	= $user;
	
	if(is_array($type)){
		$where['typeinfo'] 	= array('in',$type);
	} else {
		$where['typeinfo'] 	= $type;
	}
	
	$sum 	= $db->where($where)->count();
	
	return $sum;
}


//获取某个员工某项工作记录数
function user_work($user,$month,$type){
	
	$db 	= M('work_record');
	
	$where 	= array();
	$where['status'] 	= 0;
	$where['month'] 		= $month;
	$where['user_id'] 	= $user;
	$where['type'] 		= $type;
	
	$sum 	= $db->where($where)->count();
	
	return $sum;
}



//处理区间值
function intervalsn($value,$ratio){
	$zhi 	= $value*$ratio;
	$return = array($value-$zhi,$value+$zhi);
	return $return;
}



/*
 * 获取某个工作日之后的日期
 * 1.n个工作日
 * 2.开始时间
 * */
function getAfterWorkDay($n,$start_time = NOW_TIME){
	//节假日
	$holiday=['2018-03-03','2018-03-04','2018-03-10','2018-03-11','2018-03-17','2018-03-18','2018-03-24','2018-03-25','2018-03-31','2018-04-01','2018-04-05','2018-04-06','2018-04-07','2018-04-14','2018-04-15','2018-04-21','2018-04-22','2018-04-29','2018-04-30','2018-05-01','2018-05-05','2018-05-06','2018-05-12','2018-05-13','2018-05-19','2018-05-20','2018-05-26','2018-05-27','2018-06-02','2018-06-03','2018-06-09','2018-06-10','2018-06-16','2018-06-17','2018-06-23','2018-06-24','2018-06-30','2018-07-01','2018-07-07','2018-07-08','2018-07-14','2018-07-15','2018-07-21','2018-07-22','2018-07-28','2018-07-29','2018-08-04','2018-08-05','2018-08-11','2018-08-12','2018-08-18','2018-08-19','2018-08-25','2018-08-26','2018-09-01','2018-09-02','2018-09-08','2018-09-09','2018-09-15','2018-09-16','2018-09-22','2018-09-23','2018-09-24','2018-10-01','2018-10-02','2018-10-03','2018-10-04','2018-10-05','2018-10-06','2018-10-07','2018-10-13','2018-10-14','2018-10-20','2018-10-21','2018-10-27','2018-10-28','2018-11-03','2018-11-04','2018-11-10','2018-11-11','2018-11-17','2018-11-18','2018-11-24','2018-11-25','2018-12-01','2018-12-02','2018-12-08','2018-12-09','2018-12-15','2018-12-16','2018-12-22','2018-12-23','2018-12-29','2018-12-30',];
	$time=$start_time;
	$start_timestamp=$time;

	//计算两个工作日后的时间
	$t = afterWorkDay($start_timestamp,$n,$holiday);
	return $t;
}

function afterWorkDay($start_timestamp='',$add_workday_num='',$holiday=[]){
	//实际工作时间数组
	$workday=array();
	$i=0;
	//判断实际工作时间数组的长度
	while(count($workday)<intval($add_workday_num)){
		$i++;
		$onewdate=date('Y-m-d',($start_timestamp)+$i*(60*60*24));
		//非节假日添加实际工作时间数组
		if(!in_array($onewdate,$holiday)){
			$workday[]=$onewdate;
		}
	}
	//return array('day'=>date('Y-m-d',($start_timestamp)+$i*(60*60*24)),'workday'=>$workday);
	$day=date('Y-m-d',($start_timestamp)+$i*(60*60*24));
	return $day;

}

//人民币小写转换成大写
function numTrmb($num){
    $d = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
    $e = array('元', '拾', '佰', '仟', '万', '拾万', '佰万', '仟万', '亿', '拾亿', '佰亿', '仟亿');
    $p = array('分', '角');
    $zheng = "整";
    $final = array();
    $inwan = 0;//是否有万
    $inyi = 0;//是否有亿
    $len = 0;//小数点后的长度
    $y = 0;
    $num = round($num, 2);//精确到分
    if(strlen($num) > 15){
        return "金额太大";
        die();
    }
    if($c = strpos($num, '.')){//有小数点,$c为小数点前有几位
        $len=strlen($num)-strpos($num,'.')-1;//小数点后有几位数
    }else{//无小数点
        $c = strlen($num);
        $zheng = '整';
    }
    for($i = 0; $i < $c; $i++){
        $bit_num = substr($num, $i, 1);
        if ($bit_num != 0 || substr($num, $i + 1, 1) != 0) {
            @$low = $low . $d[$bit_num];
        }
        if ($bit_num || $i == $c - 1) {
            @$low = $low . $e[$c - $i - 1];
        }
    }
    if($len!=1){
        for ($j = $len; $j >= 1; $j--) {
            $point_num = substr($num, strlen($num) - $j, 1);
            @$low = $low . $d[$point_num] . $p[$j - 1];
        }
    }else{
        $point_num = substr($num, strlen($num) - $len, 1);
        $low=$low.$d[$point_num].$p[$len];
    }
    $chinses = str_split($low, 3);//字符串转化为数组
    for ($x = count($chinses) - 1; $x >= 0; $x--) {
        if ($inwan == 0 && $chinses[$x] == $e[4]) {//过滤重复的万
            $final[$y++] = $chinses[$x];
            $inwan = 1;
        }
        if ($inyi == 0 && $chinses[$x] == $e[8]) {//过滤重复的亿
            $final[$y++] = $chinses[$x];
            $inyi = 1;
            $inwan = 0;
        }
        if ($chinses[$x] != $e[4] && $chinses[$x] !== $e[8]) {
            $final[$y++] = $chinses[$x];
        }
    }
    $newstr = (array_reverse($final));
    $nstr = join($newstr);
    if((substr($num, -2, 1) == '0') && (substr($num, -1) <> 0)){
        $nstr = substr($nstr, 0, (strlen($nstr) -6)).'零'. substr($nstr, -6, 6);
    }
    $nstr=(strpos($nstr,'零角')) ? substr_replace($nstr,"",strpos($nstr,'零角'),6) : $nstr;
    return $nstr = (substr($nstr,-3,3)=='元') ? $nstr . $zheng : $nstr;
}


function absdata($val,$goal){
	$score = abs(($val-$goal)/$goal)*100;
	if($score<=10){
		return 100;	
	}else if($score>10 && $score<15){
		return 80;	
	}else{
		return 0;	
	}
}

function get_roleid($id=0){

	global $str;
	global $str_level;

	$str_level = $str_level ? $str_level : 0;

	$db = M('role');
	$where = array();
	$where['pid']          = $id;
	$list = $db->where($where)->order('`id` ASC')->select();
	$str_level++;
	$aaa 	= array();
	if($list){
		foreach($list as $k =>$v){
			$list[$k]['str_level'] = $str_level;
			$str[] = $list[$k];
			get_roleid($v['id']);
		}

	}

	foreach ($str as $key=>$value){
		$aaa[] 	= $value['id'];
	}
	return $aaa;
	//return $str;

}


function kpilock($month,$uid){
	
	$uname = username($uid);
	
	
	$where = array();
	$where['month']	 	= $month;
	$where['user_id']	= $uid;
	
	$save = M('kpi_more')->where($where)->data(array('automatic'=>1))->save();
	
	if($save){
	
		
		$data	= array();
		$data['month']		= $month;
		$data['uid']		= $uid;
		$data['uname']		= $uname;
		$data['op_time']	= time();
		$data['op_uid']		= cookie('userid');
		$data['op_uname']	= cookie('name');
		$data['remarks']	= $uname.'【'.$month.'】KPI数据已锁定！';
		
		M('kpi_lock_record')->add($data);
		
		
		return true;
	
	}else{
		return false;	
	}

}

/**
 *  echo M()->getLastSql();
 * salary_info 操作记录 函数
 */
function salary_info($status,$cont){

	$add['op_time'] 	= time();
	$add['uname'] 		= $_SESSION['name'];
	$add['optype'] 		= $status;//添加岗位薪酬变动
	$add['explain'] 	= $cont;

	$isok = M('op_record')->add($add);
	if(!$isok){
        $sum                = 0;
        $msg                = $cont."添加失败!";
        echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
	}
}

function query_posts($where){//查询岗位
    if(count($where)==0){
        return M('posts')->select();
    }else{
        return M('posts')->where($where)->select();
    }
}
function query_department(){//部门

return M('salary_department')->select();

}
function code_number($number,$style){//数字验证

	if(!is_numeric($number)){
        if($style==1){
            return 0;
        }
		$sum  	= 0;
		$msg  	= "格式错误!请重新提交!";
		echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
	}else{
		return $number;
	}
}

/**
 * sql_query 查询数据
 * $status 1 查询 2添加 3删除  4 修改
 * $field 查询字段（修改时作修改的字段）  $table 查询表 $where 查询条件
 * $order 1倒叙 2正常  $type (1 查询一条  2查询所有)
 */

function sql_query($status,$field,$table,$where,$order,$type){

	if(empty($status) || empty($table)){

			return 0;
	}
	if($status == 1){//查看

		$add_sql 	= sql_sel($field,$table,$where,$order,$type);

	}
	if($status == 2){//添加

		$add_sql 	= sql_add($table,$where);

	}
	if($status == 3){//删除

		$add_sql 	= sql_del($table,$where);
	}
	if($status == 4){//修改

		$add_sql 	= sql_upd($field,$table,$where);
	}

	$sql 			= M()->query($add_sql);
	return $sql;

}

function sql_sel($field,$table,$where,$order,$type){//查询



	$add_sql 			= 'SELECT ';

	if(!empty($field) && $field !== 0){

		$add_sql 		.= $field.' ';
	}
	$add_sql 			.='FROM '.$table.' ';

	if(!empty($where) && $where !== 0){

		$add_sql 		.='WHERE';

		foreach($where as $key => $val){

			$add_sql 	.= " $key='$val' ";
			$add_sql 	.= 'AND ';
		}
	}
	$add_sql = substr($add_sql,0,-4);
	if($order == 1){
		$add_sql 		.= 'ORDER BY id DESC';
	}
	if($order == 2){
		$add_sql 		.= 'ORDER BY id ASC';
	}
	if($type == 1){
		$add_sql 		.=' LIMIT 1';
	}

	return $add_sql;
}

function sql_add($table,$where){//添加

	$add_sql 			= 'INSERT INTO ';
	$add_sql 			.=$table.' ';
	if(!empty($where) && $where !== 0){
		$str			= "";
		$vales     		= "";
		foreach($where as $key => $val){
			$str 		.= $key.',';
			$vales 		.= "$val','";
		}
		$str 			= substr($str,0,-1);
		$add_sql 		.= '('.$str.') values ';
		$add_sql 		.= '('.$vales.')';
	}
	return $add_sql;
}


function sql_del($table,$where){//删除

	$add_sql 			= 'DELETE FROM '.$table.' ';

	if(!empty($where) && $where !== 0){
		$add_sql 		.='WHERE';
		foreach($where as $key => $val){
			$add_sql 	.= " $key='$val' ";
			$add_sql 	.= 'AND ';
		}
		$add_sql = substr($add_sql,0,-4);
	}
	return $add_sql;
}


function sql_upd($field,$table,$where){//修改

	$add_sql 			= 'UPDATE '.$table.'SET ';
	if(!empty($field) && $field !== 0){
		foreach($field as $k => $v){
			$add_sql 	.= " $k='$v'";
			$add_sql 	.= ',';
		}
		$add_sql = substr($add_sql,0,-1);
	}
	if(!empty($where) && $where !== 0){
		$add_sql 		.=' WHERE';
		foreach($where as $key => $val){
			$add_sql 	.= " $key='$val' ";
			$add_sql 	.= 'AND ';
		}
		$add_sql 		= substr($add_sql,0,-4);

	}
	return $add_sql;
}

function personnel(){//所有人员名称 id
    return M('account')->field('id,nickname')->where('status=0 and id>2')->select();

}
function user_table($where,$type){//查询用户 1 查询一个 2 查询符合条件的 默认查询id

    if($type==1){
        $where['status'] = 0;
        return M('account')->where($where)->find();
    }elseif($type==2) {
        $where['status'] = 0;
        return M('account')->where($where)->order('id ASC')->select();
    }else{
        return M('account')->where('id='.$where)->find();
    }

}

    function datetime($time_Y,$time_M,$time_D,$type){//获取年月日

        if($type==1){
            if($time_D < 10){
                if($time_M==1){
                    $time_Y = $time_Y-1;
                    $time_M = 13;
                }
                $time_M = $time_M-1;
                if($time_M < 10) {
                    $que                 = $time_Y.'0'.$time_M;//查询年月
                }else{
                    $que                 = $time_Y.$time_M;//查询年月

                }
            }else{
                $que                     = $time_Y.$time_M;//查询年月
            }
        }elseif($type==2){
            if($time_D < 10){
                if($time_M==1){
                    $time_Y = $time_Y-1;
                    $time_M = 13;
                }
                $time_M                     = $time_M-1;
                if($time_M < 10) {
                    $que               = $time_Y.'年0'.$time_M.'月';//查询年月
                }else{
                    $que               = $time_Y.'年'.$time_M.'月';//查询年月
                }
            }else{
                $que                   = $time_Y.'年'.$time_M.'月';//查询年月
            }
        }
        return $que;
    }

    //带团补助  $month 查询年月 例如:201809
    function Acquisition_Team_Subsidy($month,$guide_id){

        $yearmonth                          = GetGuideMonth($month);
        $firstday                           = $yearmonth['firstday'];
        $lastday                            = $yearmonth['lastday'];
        /*$firstday                           = date('Y-m-27', strtotime("$month -2 month"));//获取第一天
        $lastday                            = date('Y-m-27', strtotime("$firstday +1 month"));//获取最后一天*/
        $firstday_time                      = strtotime($firstday);//当月第一天时间戳
        $lastday_time                       = strtotime($lastday);//当月最后一天时间戳

        if(!empty($guide_id) && ($guide_id)!==0){
            $price                          = 0;
            $guide_array                    = array();
            $guide_array['guide_id']        = $guide_id;
            $guide_array['status']          = 2;
            $guide_array['sure_time']       = array('between',"$firstday_time,$lastday_time");
            $guide_pay                      =  M('guide_pay')->where($guide_array)->select();
            if($guide_pay){
                foreach($guide_pay as $k => $v){
                    $price                  += $v['really_cost'];
                }
            }
        }
        return $price;
    }

    function GetGuideMonth($yearmonth){
        //辅导员费用从每月27日开始
        if ($yearmonth){
            $year       = substr($yearmonth,0,4);
            $month      = substr($yearmonth,4,2);
            $day        = 27;
            $data       = array();
            if ($month ==01){
                $mon                = 12;
                $data['firstday']   = ($year-1).$mon.$day;
                $data['lastday']    = $yearmonth.$day;
            }else{
                $data['firstday']   = ($yearmonth-1).$day;
                $data['lastday']    = $yearmonth.$day;
            }
        }
        return $data;
    }

    /**
     * user_contrast_status 信心对比状态
     * $file_id 文件 id
     * $user_id 用户id
     */
     function user_contrast_status($file_id,$user_id){

            $where['file_id']       = $file_id;
            $where['account_id']    = $user_id;
            $status                 = M('annotation_file')->where($where)->find();
            if($status){
                return $status['status'];//已批注
            }else{
                return 0;//未批注
            }
        }



//获取用户信息(用户名+角色)
function get_userkey(){
    //整理关键字
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
    return json_encode($key);
}

//获取用户信息(用户名)
function get_username(){
    $user       = M('account')->field("id,nickname")->where(array('status'=>0))->select();
    $user_key   = array();
    foreach($user as $k=>$v){
        $text                   = $v['nickname'];
        $user_key[$k]['id']     = $v['id'];
        $user_key[$k]['pinyin'] = strtopinyin($text);
        $user_key[$k]['text']   = $text;
    }
    return json_encode($user_key);
}

//科普资源信息
function getScienceRes(){
    $lists          = M('cas_res')->field("id,title")->where(array('audit_status'=>1))->select();
    $scienceRes     = array();
    foreach($lists as $k=>$v){
        $text                     = $v['title'];
        $scienceRes[$k]['id']     = $v['id'];
        $scienceRes[$k]['pinyin'] = strtopinyin($text);
        $scienceRes[$k]['text']   = $text;
    }
    return json_encode($scienceRes);
}

    /**
     * 财务统计
     * $xs 名字 $st 开始时间 $et 结束时间
     * $dept=0 全部部门
     */
    function monthly_Finance($xs,$st,$et,$dept=0){
        $db			= M('op_settlement');
        $post 		= C('POST_TEAM');
        $postmore	= C('POST_TEAM_MORE');

        //获取团队相关数据
        $where = array();
        $where['roleid'] = array('in',$postmore[$dept]);
        $where['status'] = array('between','0,1');
        $users = M('account')->where($where)->select();
        $ulist = array();
        foreach($users as $k=>$v){
            $ulist[] = $v['id'];
        }
        $where = array();
        $where['b.audit_status'] = 1;
        $where['l.req_type']	= 801;
        if($st && $et){
            $where['l.audit_time'] = array('between',array(strtotime($st),strtotime($et)));
        }else if($st){
            $where['l.audit_time'] = array('gt',strtotime($st));
        }else if($et){
            $where['l.audit_time'] = array('lt',strtotime($et));
        }

        if($xs)   $where['o.create_user_name']	= array('eq',$xs);
        if($dept) $where['o.create_user']		= array('in',implode(',',$ulist));

        $datalist = $db->table('__OP_SETTLEMENT__ as b')->group('o.op_id')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark,l.audit_time')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->order('l.audit_time DESC')->select();

        $sum = 0;
        foreach($datalist as $k=>$v){
            //获取月份毛利
            $sum +=$v['maoli'];
        }
        return $sum;
    }


//    /**
//     * monthly_Finance 财务统计
//     * $userid 用户id
//     * $createtime 开始时间
//     * $endtime 结束时间
//     */
//    function monthly_Finance($userid,$createtime,$endtime){
//
//        $where['userid']             = $userid;
//        $where['huikuan_time']       = array('between',"$createtime,$endtime");
//        $huikuan                     = M('op_huikuan')->where($where)->select();
//        $price = '';
//        foreach($huikuan as $key =>$val){
//            $price += $val['huikuan'];
//        }
//    return $price;
//}

    //用户的 部门 岗位  详情信息
    function userinfo($userid,$type){
        if($type==2){
            $userinfo  = M('salary_department')->where('id='.$userid)->find();//查询部门
            return $userinfo;die;
        }
        $info                              = M('account')->where($userid)->select();//查询用户信息
        foreach($info as $key => $val){
            $userinfo[$key]['info']        = $val;
            $userinfo[$key]['posts']       = M('posts')->where('id='.$val['postid'])->find();
            $userinfo[$key]['department']  = M('salary_department')->where('id='.$val['departmentid'])->find();//查询部门
        }
        return $userinfo;
    }

    /**
     * 自动生成单据编号
     * @param $str
     * @param $table
     * @param $ele
     * @return string
     */
    function make_num($str,$table,$ele){
        $date   = date('Ymd',time());
        $length = strlen($str);
        $lastid = M("$table")->where(array("$ele"=>array('like',$str.$date.'%')))->order('id DESC')->find();
        if ($lastid){
            $numb   = substr($lastid["$ele"],$length);
            $num    = $str.($numb+1);
        }else{
            $num    = $str.(($date*10000)+1);
        }
        return $num;
    }

    /**
     * 对二维数组排序
     * @param $arr
     * @param $shortKey
     * @param int $short
     * @param int $shortType
     * @return mixed
     */
    function multi_array_sort($arr,$shortKey,$short=SORT_DESC,$shortType=SORT_REGULAR){
        foreach ($arr as $key => $data){
            $name[$key] = $data[$shortKey];
        }
        array_multisort($name,$shortType,$short,$arr);
        return $arr;
    }


