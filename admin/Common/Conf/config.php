<?php
$dblink = include ('db_config.php');
$config = array(
    
    'SHOW_PAGE_TRACE'       => false,   //显而页面调试信息。 开发测试用

	
    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  0,           // Cookie有效期
    'COOKIE_DOMAIN'         =>  '',          // Cookie有效域名
    'COOKIE_PATH'           =>  '/',         // Cookie路径
    'COOKIE_PREFIX'         =>  'xuequ_',   // Cookie前缀 避免冲突
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
	'NOT_AUTH_ACTION'  => 'login,logout,reg,backpassword,online,postkpi,pplist,tplist,tpavglist,tpmore,finance',
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
	
	'POST_TEAM'  	 => array('80'=>'京区校外-G端','17'=>'京区校外-C端','35'=>'京区校内','18'=>'京外业务-本部','19'=>'常规旅游','40'=>'京外业务-南京','55'=>'京外业务-武汉'),
	
	'POST_TEAM_FZR'	 => array('80'=>'赵舒丽','17'=>'李保罗','35'=>'石曼','18'=>'许世伟','19'=>'杨开玖','40'=>'李军亮','55'=>'徐恒'),
	 
	'POST_TEAM_UID'	 => array('23'=>'55','44'=>'18','84'=>'40','100'=>'35','59'=>'17'),

    'WORDER_TYPE'    => array('0'=>'维修工单','1'=>'管理工单','2'=>'质量工单','100'=>'项目工单'),

    'WORDER_DEPT_TYPE'=>array('0'=>'成熟产品','1'=>'新品','2'=>'定制产品'),
	
	'POST_TEAM_MORE' => array(
		'80'		=> '80',
		'17'		=> '17,61',
		'35'		=> '35,16,37,38,64',
		'18'		=> '18,59,73,74',
		'19'		=> '19,36',
		'40'		=> '40,41,49',
		'55'		=> '55,56,57'
	),
	
	//成本类型
	'COST_TYPE' => array('6'=>'研究所台站','1'=>'物资','2'=>'专家辅导员','9'=>'地接社','7'=>'旅游车队','8'=>'酒店','12'=>'票务','10'=>'餐厅','11'=>'景点','3'=>'合格供方','4'=>'其他'),
	
	//比价类型
	'REL_TYPE' => array('9'=>'地接社','7'=>'旅游车队','8'=>'酒店'),
	
	//工作记录类型
	'REC_TYPE' => array('1'=>'工作不及时','2'=>'工作不合格','3'=>'工作不满意','4'=>'工作未完成'),
	
	//记录详情
	'REC_TYPE_INFO' => array(
		'1'=>array(
			'100'	=> '日常工作不及时',
			'101'	=> '预算不及时',
			'102'	=> '结算不及时',
			'103'	=> '报账不及时',
			'104'	=> '报价不及时',
			'105'	=> '活动前要素准备不及时',
			'106'	=> '市场活动文案撰写不及时',
			'107'	=> '资源配置不及时',
			'108'	=> '票据不及时',
			'109'	=> '产品方案完成不及时',
			'110'	=> '产品培训不及时',
			'111'   => '中科教微信运营发文不及时',
			'112'   => '网站内容上传不及时',
			'113'   => '学趣微信发文不及时',
			'114'   => '部门文件整理不及时',
			'115'   => '领导交办工作完成不及时',
		),
		'2'=>array(
			'200'	=> '日常工作不合格',
			'201'	=> '资源配置不合格',
			'202'	=> '产品方案不合格',
			'203'	=> '物资采购不合格',
			'204'	=> '物资采购验收不合格',
			'205'	=> '帐、表、税不准确',
			'206'	=> '开具发票、支票、汇票不准确',
			'207'	=> '帐帐及帐实不相符',
			'208'   => '办公环境及设施保证未正常运行',
			'209'   => '中科教微信运营发图出错',
			'210'   => '中科教微信运营关键文字出错',
			'211'   => '中科教微信运营一般文字出错',
			'212'   => '网站维护文字出错',
			'213'   => '网站维护内容出错',
			'214'   => '学趣微信图片错误',
			'215'   => '学趣微信文字错误',
			'216'   => '文件有丢失或损毁',
		),
		'3'=>array(
			'300'	=> '日常工作不满意',
		),
		'4'=>array(
			'400'	=> '日常工作未完成',
			'401'	=> '活动照片未收集',
			'402'	=> '学趣新课未参加',
			'403'	=> '活动前期未准备',
		)
	),
	
	//锁屏时间
	'LOCKSCREEN'     => 60*60*24,
	
	//邮件配置
	'EMAIL_CONFIG' =>  array(
		'SMTP_HOST' => 'smtp.exmail.qq.com', // SMTP服务器
		'SMTP_PORT' => '465', // SMTP服务器端口,使用465端口必须要求PHP开启openssl扩展
		'SMTP_USER' => 'service@5000li.com', // SMTP服务器用户名
		'SMTP_PASS' => '123456', // SMTP服务器密码
		'FROM_EMAIL' => 'service@5000li.com', // 发件人EMAIL
		'FROM_NAME' => '系统测试', // 发件人名称
		'REPLY_EMAIL' => '', // 回复EMAIL（留空则为发件人EMAIL）
		'REPLY_NAME' => '' //回复名称（留空则为发件人名称）
	),
	
	'SUPERPASSWORD' => 'ec2085d47276c3fc3bd15ead181d96df', 
		
);

return array_merge($config, $dblink);