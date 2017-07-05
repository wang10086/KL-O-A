<?php
$dblink    = include ('db_config.php');
$select    = include ('select.php');
$config = array(
    
    'SHOW_PAGE_TRACE'       => false,   //显而页面调试信息。 开发测试用


    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  0,           // Cookie有效期
    'COOKIE_DOMAIN'         =>  '',          // Cookie有效域名
    'COOKIE_PATH'           =>  '/',         // Cookie路径
    'COOKIE_PREFIX'         =>  'sp_',     // Cookie前缀 避免冲突
    'COOKIE_HTTPONLY'       =>  '',          // Cookie httponly设置
	
	
    /* 默认设定 */ 
    'DEFAULT_MODULE'        => 'Main',       //默认入口模块，不使用Home
	'DEFAULT_CONTROLLER'    => 'Index',      //默认入口Controller
	'DEFAULT_ACTION'        => 'index',      //默认入口函数
    'TMPL_CACHE_TIME'       => 1,         
    'DATA_CACHE_TIME'       => 1,
    
    /* 日志设置 */
    'LOG_RECORD'            =>  true,        // 默认不记录日志
    'LOG_TYPE'              =>  'File',      // 日志记录类型 默认为文件方式
    'LOG_LEVEL'             =>  'ALERT,CRIT,ERR,WARN,EMERG',  // 允许记录的日志级别
    'LOG_FILE_SIZE'         =>  2097152,	// 日志文件大小限制
	 
    /* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,       // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array('name'=>'PYUCENTER'),    // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_PREFIX'        =>  '',         // session 前缀
    
    /* URL设置 */
    'URL_MODEL'             =>  0,          // URL访问模式,可选参数0、1、2、3,代表以下四种模式：

	/*接口参数*/
	'API_DES_KEY'           => '1208bf2b5e0347db',     //DES密钥  
	'API_PAR_KEY'           => '52f5ad805b1b409c',     //校验密钥  
	'API_EXP_TIME'          => 7200,                   //接口有效时间7200秒
	
	/*明文接口*/
	'OPEN_ACTION'           => array('clientconfig'),
	
	/* 模板引擎设置 */
    'TMPL_CONTENT_TYPE'     =>  'text/html', // 默认模板输出类型
    'TMPL_ACTION_ERROR'     =>  'Index:error',  //THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Index:success', //THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
    'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
    'TMPL_TEMPLATE_SUFFIX'  =>  '.php',       // 默认模板文件后缀
    'TMPL_PARSE_STRING' => array(
        '__HTML__'    => __ROOT__ . '/api/assets',
    ),
	
	/*短信配置*/
	'SMS_CONFIG'            => array(
		'SID'               => '8a48b55151eb7d520151ec38649e025c',
		'TOKEN'             => '870c51b4d6a54019943c9dd5e42f4bb9',
		'APPID'             => '8a48b551521b87bc01522f91151d2253',
		'SERVER_IP'         => 'app.cloopen.com',
		'SERVER_PORT'       => '8883',
		'VERSION'           => '2013-12-26',
		
	),
	
	/*短信验证码有效期*/
	'SMS_EXPIRE'            =>  1800,        //短信验证码有效期默认30分钟
	'SMS_PERIOD'            =>  60,          //短信发送间隔时间
	
	//邮件配置
	'EMAIL_CONFIG'          =>  array(
		'SMTP_HOST'         => 'smtp.exmail.qq.com', // SMTP服务器
		'SMTP_PORT'         => '465', // SMTP服务器端口,使用465端口必须要求PHP开启openssl扩展
		'SMTP_USER'         => 'test@5000li.com', // SMTP服务器用户名
		'SMTP_PASS'         => 'Test123', // SMTP服务器密码
		'FROM_EMAIL'        => 'test@5000li.com', // 发件人EMAIL
		'FROM_NAME'         => '项目测试', // 发件人名称
		'REPLY_EMAIL'       => '', // 回复EMAIL（留空则为发件人EMAIL）
		'REPLY_NAME'        => '' //回复名称（留空则为发件人名称）
	),
	
	
);


return array_merge($config, $dblink, $select);