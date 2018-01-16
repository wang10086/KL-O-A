<?php
// 加载参数类
import ('P', COMMON_PATH . 'Common/'); 
use App\P;
ulib('Pinyin');
use Sys\Pinyin;

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
		M('pdca')->data($data)->where(array('id'=>$pdcaid))->save();
		
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
	
	$year  = substr($month,0,4);
	$yue   = substr($month,4,2);
	$ym    = getthemonth($year.'-'.$yue.'-01');
	
	$where = array();
	$where['month']   = $month;
	$where['user_id'] = $user;
	
	
	$quto   = M('kpi_more')->where($where)->select();
	
	if($quto){
		foreach($quto as $k=>$v){
			
			
			//获取月度累计毛利额
			if($v['quota_id']==1){
				$where = array();
				$where['b.audit_status'] = 1;
				$where['b.create_time']  = array('between',$ym);
				$where['o.create_user']  = $user;
				$complete = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->sum('b.maoli');
			}
			
			
			//获取累计毛利率
			if($v['quota_id']==2){
				$where = array();
				$where['b.audit_status'] = 1;
				$where['b.create_time']  = array('between',$ym);
				$where['o.create_user']  = $user;
				$maoli = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->sum('b.maoli');
				$shouru = M()->table('__OP_SETTLEMENT__ as b')->field('b.shouru')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->sum('b.shouru');
				$complete = round(($maoli / $shouru)*100,2).'%';
			}
			
			//获取回款及时率
			if($v['quota_id']==3){
				$where = array();
				$where['b.audit_status'] = 1;
				$where['b.create_time']  = array('between',$ym);
				$where['o.create_user']  = $user;
				$shouru = M()->table('__OP_SETTLEMENT__ as b')->field('b.shouru')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->sum('b.shouru');
				$huikuan = M()->table('__OP_SETTLEMENT__ as b')->field('b.huikuan')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->sum('b.huikuan');
				$complete = round(($huikuan / $shouru)*100,2).'%';
			}
			
			//获取成团率
			if($v['quota_id']==4){
				$where = array();
				$where['create_time']  = array('between',$ym);
				$where['create_user']  = $user;
				$zongxiangmu = M('op')->where($where)->count();
				$where['group_id']     = array('neq','');
				$chengtuan = M('op')->where($where)->count();
				
				$complete = round(($chengtuan / $zongxiangmu)*100,2).'%';
			}
			
			//获取合同签订率（含家长协议书）
			if($v['quota_id']==5){
				$where = array();
				$where['b.audit_status'] = 1;
				$where['b.create_time']  = array('between',$ym);
				$where['o.create_user']  = $user;
				$xiangmu = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->count();
				$where['b.hetong']  = 1;
				$hetong  = M()->table('__OP_SETTLEMENT__ as b')->field('b.maoli')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->count();
				$complete = round(($hetong / $xiangmu)*100,2).'%';
			}
			
			//保存数据
			if($v['quota_id'] <=5 ){
				
				$data = array();
				$data['complete'] = $complete;
				$data['complete_rate'] = round(($complete / $v['target'])*100,2)."%";
				
				M('kpi_more')->data($data)->where(array('id'=>$v['id']))->save();	
			}
			
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

//统计部门数据
function tplist($roleid){
	
	$db			= M('op');
	$roles		= M('role')->GetField('id,role_name',true);
	
	//获取部门人数
	$where = array();
	if($roleid==33){
		$where['roleid'] = array('in','33,61');
		$fzr = '赵舒丽';
	}else if($roleid==17){
		$where['roleid'] = array('in','17');
		$fzr = '李保罗';
	}else if($roleid==35){
		$where['roleid'] = array('in','35,16,37,38,64');
		$fzr = '石曼';
	}else if($roleid==18){
		$where['roleid'] = array('in','18,59,73,74');
		$fzr = '许世伟';
	}else if($roleid==19){
		$where['roleid'] = array('in','19,36');
		$fzr = '杨开玖';	
	}else if($roleid==40){
		$where['roleid'] = array('in','40,41,49');
		$fzr = '李军亮';	
	}else if($roleid==55){
		$where['roleid'] = array('in','55,56,57');
		$fzr = '徐恒';		
	}
	$where['status'] = array('eq',0);
	$users = M('account')->where($where)->select();	
	$num   = count($users);
	$ulist = array();
	foreach($users as $k=>$v){
		$ulist[] = $v['id'];
	}
	
	$where = array();
	$where['b.audit_status']		= 1;
	$where['l.req_type']			= 801;
	$where['l.audit_time']			= array('gt',strtotime('2018-01-01'));
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
	$where = array();
	$where['b.audit_status']	= 1;
	$where['a.id']				= array('in',implode(',',$ulist));
	$where['l.req_type']		= 801;
	$where['l.audit_time']		= array('gt',strtotime(date('Y-m-01',time())));
	
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
	$users['fzr']		= $fzr;
	
	return array_merge($lists, $users);
}



//获取某时间段个人业绩
function personal_income($userid,$time){
	
	
	//$time = $time ? $time : strtotime(date('Y-m-01',time()));
	//查询月度
	$where = array();
	$where['b.audit_status']	= 1;
	$where['o.create_user']		= $userid;
	$where['a.req_type']		= 801;
	$where['a.audit_time']		= array('gt',$time);
	
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

//获取自己下属员工ID
function get_branch_user(){
	
	$post = M('posts')->GetField('id,post_name',true);
	
	//获取自己的岗位信息
	$me = M('account')->find(cookie('userid'));
	
	//获取属于员工信息
	$where = array();
	
	if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==11 ){}else{
		$where['group_role']	= array('like','%['.cookie('roleid').']%');
	}
	
	
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

?>


