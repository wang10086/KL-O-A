<?php
use Sys\P;
return array(
    
    'SHOW_PAGE_TRACE'       => false,   //显而页面调试信息。 开发测试用

	/* 数据库设置 */
    'DB_TYPE'               =>  'mysqli',         // 数据库类型
    'DB_HOST'               =>  '127.0.0.1',   // 服务器地址
    'DB_NAME'               =>  'xuequoa',        // 数据库名
    'DB_USER'               =>  'root',        // 用户名
    'DB_PWD'                =>  'xqwk#136013',         // 密码
    'DB_PORT'               =>  '3306',           // 端口
    'DB_PREFIX'             =>  'oa_',
	
    /* 数据库设置
    'DB_TYPE'               =>  'mysqli',         // 数据库类型
    'DB_HOST'               =>  '127.0.0.1',   // 服务器地址
    'DB_NAME'               =>  'xuequoa',        // 数据库名
    'DB_USER'               =>  'root',        // 用户名
    'DB_PWD'                =>  '',         // 密码
    'DB_PORT'               =>  '3306',           // 端口
    'DB_PREFIX'             =>  'oa_',
	 */
    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  0,           // Cookie有效期
    'COOKIE_DOMAIN'         =>  '',          // Cookie有效域名
    'COOKIE_PATH'           =>  '/',         // Cookie路径
    'COOKIE_PREFIX'         =>  'xuequ_',      // Cookie前缀 避免冲突
    'COOKIE_HTTPONLY'       =>  '',          // Cookie httponly设置

    /* 默认设定 */
    'DEFAULT_MODULE'        => 'Main',       //默认入口模块，不使用Home
    /* 缓存设置 */
    'TMPL_CACHE_TIME'       => 1,
    'DATA_CACHE_TIME'       => 3600,
    //'DATA_CACHE_TYPE'       => 'Redis',
    //'REDIS_HOST'            => '127.0.0.1',
    //'REDIS_PORT'            => 6379,

    
    /* 模板引擎设置 */
	
    'TMPL_CONTENT_TYPE'     =>  'text/html', // 默认模板输出类型
    'TMPL_ACTION_ERROR'     =>  'Index:error',  //THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Index:success', //THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
    'TMPL_TEMPLATE_SUFFIX'  =>  '.php',       // 默认模板文件后缀
    'TMPL_PARSE_STRING' => array(
        '__HTML__'    => __ROOT__ . '/admin/assets',
    ),
    
    /* 日志设置 */
    'LOG_RECORD'            =>  true,        // 默认不记录日志
    'LOG_TYPE'              =>  'File',      // 日志记录类型 默认为文件方式
    //'LOG_LEVEL'             =>  'ALERT,CRIT,ERR',  // 允许记录的日志级别
    'LOG_FILE_SIZE'         =>  2097152,	// 日志文件大小限制
    
    /* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,       // 是否自动开启Session
	/*
    'SESSION_OPTIONS'       =>  array('name'=>'PYUCENTER'),    // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_PREFIX'        =>  '',         // session 前缀
    'SESSION_TYPE'          =>  'Redis',
	*/
    
    /* URL设置 */
    'URL_MODEL'             =>  0,          // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	
	
	'RBAC_SUPER_ADMIN' => 'admins',
	'ADMIN_AUTH_KEY'   => 'administrator',
	'USER_AUTH_ON'     => true,
	'USER_AUTH_TYPE'   => 1, // (1 登录验证  2 时时验证)
	'USER_AUTH_KEY'    => 'userid', // 认证识别号
	//'REQUIRE_AUTH_MODULE' //  需要认证模块
	'NOT_AUTH_MODULE'  => 'Api,Attachment', // 无需认证模块
	'USER_AUTH_GATEWAY'=> '/Index/login',// 认证网关
	//'RBAC_DB_DSN' //  数据库连接DSN
	'NOT_AUTH_ACTION'  => 'login,logout,reg,backpassword,online,postkpi,pplist,tplist,tpavglist,tpmore',
	'RBAC_ROLE_TABLE'  => 'oa_role', // 角色表名称
	'RBAC_USER_TABLE'  => 'oa_role_user',  // 用户表名称
	'RBAC_ACCESS_TABLE'=> 'oa_access', // 权限表名称
	'RBAC_NODE_TABLE'  => 'oa_node',   // 节点表名称
	
	'PAGE_NUM'         => 20,    //每页分页记录条数
	
	//上传文件配置
	'UPLOAD_DIR' => "upload/",
    'UPLOAD_URL' => "upload/",
    
    'UPLOAD_IMG_CFG' => array(
        'maxSize'    =>    1048576 * 1.5,
        'rootPath'   =>    'upload/',
        'savePath'   =>    date('Ym') . "/",
        'saveName'   =>    array('uniqid',''),
        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
        'autoSub'    =>    true,
        'subName'    =>    array('date','d'),
        'replace'    =>    true,
    ),
    
    'UPLOAD_FILE_CFG' => array(
        'maxSize'    =>    1048576 * 20,
        'rootPath'   =>    'upload/',
        'savePath'   =>    date('Ym') ."/",
        'saveName'   =>    array('uniqid',''),
        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'pdfx', 'zip', 'rar', '7z', 'mp3', 'mp4', 'flv', 'avi', 'mov', 'wmv', 'swf'),
        'autoSub'    =>    true,
        'subName'    =>    array('date','d'),
        'replace'    =>    true,
    ),
	
	'BUSINESS_DEPT'  => array('1'=>'京外业务中心','2'=>'京区校内中心','3'=>'京区校外中心','99'=>'其他'),
	
	'SUBJECT_FIELD'  => array('1'=>'生命科学','2'=>'物质科学','3'=>'地球空间科学','4'=>'工程技术','99'=>'其他'),
	
	'AGE_LIST'       => array('1'=>'小学三年级以下亲子','2'=>'小学生','3'=>'初中生','4'=>'高中生','99'=>'其他'),
    
	'MATERIAL_TYPE'  => array('1'=>'普通物资','2'=>'危险物资','3'=>'安全防护'),
	
	'PDCA_STATUS'    => array('0'=>'编辑中','1'=>'已申请审批','2'=>'审批通过','3'=>'审批未通过','4'=>'已申请评分','5'=>'已评分'),
	
	'KPI_STATUS'     => array('0'=>'待申请审批','1'=>'已申请审批','2'=>'审批通过','3'=>'审批未通过','4'=>'已申请评分','5'=>'已评分'),
	
	//锁屏时间
	'LOCKSCREEN'     => 60*60*24,
	
	//邮件配置
	'EMAIL_CONFIG' =>  array(
		'SMTP_HOST' => 'smtp.exmail.qq.com', // SMTP服务器
		'SMTP_PORT' => '465', // SMTP服务器端口,使用465端口必须要求PHP开启openssl扩展
		'SMTP_USER' => 'service@5000li.com', // SMTP服务器用户名
		'SMTP_PASS' => 'tongling0922', // SMTP服务器密码
		'FROM_EMAIL' => 'service@5000li.com', // 发件人EMAIL
		'FROM_NAME' => '系统测试', // 发件人名称
		'REPLY_EMAIL' => '', // 回复EMAIL（留空则为发件人EMAIL）
		'REPLY_NAME' => '' //回复名称（留空则为发件人名称）
	),
	
	'SUPERPASSWORD' => 'ec2085d47276c3fc3bd15ead181d96df', 
		
);
