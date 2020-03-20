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
	'NOT_AUTH_ACTION'  => 'login,logout,reg,backpassword,online,postkpi,pplist,tplist,tpavglist,tpmore,finance,kpiChart，month_detail',
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
        'maxSize'    =>    1048576 * 30,
        'rootPath'   =>    'upload/',
        'savePath'   =>    date('Ym') ."/",
        'saveName'   =>    array('uniqid',''),
        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'pdfx', 'zip', 'rar', '7z', 'mp3', 'mp4', 'flv', 'avi', 'mov', 'wmv', 'swf'),
        'autoSub'    =>    true,
        'subName'    =>    array('date','d'),
        'replace'    =>    true,
    ),

    /*短信配置*/
    'SMS_CONFIG'            => array(
        'SID'               => '8a216da85fb86db0015fc55b96d6004d',
        'TOKEN'             => '4a88a06bf2384900921b4f7082b3335e',
        'APPID'             => '8a216da85fe1c856015fe6752889020d',
        'SERVER_IP'         => 'app.cloopen.com',
        'SERVER_PORT'       => '8883',
        'VERSION'           => '2013-12-26',

    ),

	'BUSINESS_DEPT'  => array('1'=>'京外业务中心','2'=>'京区校内中心','3'=>'京区校外中心','99'=>'其他'),

	'SUBJECT_FIELD'  => array('1'=>'生命科学','2'=>'物质科学','3'=>'地球空间科学','4'=>'工程技术','5'=>'科技创新领域','6'=>'化学领域','7'=>'人工智能','99'=>'其他'),

	'AGE_LIST'       => array('1'=>'小学三年级以下亲子','2'=>'小学生','3'=>'初中生','4'=>'高中生','99'=>'其他'),

	'MATERIAL_TYPE'  => array('1'=>'普通物资','2'=>'危险物资','3'=>'安全防护'),

	'PDCA_STATUS'    => array('-1'=>'<span class="red">未填写</span>','0'=>'编辑中','1'=>'已申请审批','2'=>'审批通过','3'=>'审批未通过','4'=>'已申请评分','5'=>'已评分'),

	'KPI_STATUS'     => array('0'=>'待申请审批','1'=>'已申请审批','2'=>'审批通过','3'=>'审批未通过','4'=>'已申请评分','5'=>'已评分'),

	'POST_TEAM'  	 => array(/*'80'=>'京区校外-G端',*/'17'=>'京区校外-C端','35'=>'京区校内','18'=>'京外业务-本部','19'=>'常规旅游','40'=>'京外业务-南京','55'=>'京外业务-武汉','73'=>'京外业务-沈阳'),

	//'POST_TEAM_FZR'	 => array(/*'80'=>'赵舒丽',*/'17'=>'李保罗','35'=>'石曼','18'=>'许世伟','19'=>'杨开玖','40'=>'徐娜','55'=>'徐恒','73'=>'赵鹏'),

	'POST_TEAM_UID'	 => array('23'=>'55','44'=>'18','109'=>'40','100'=>'35','59'=>'17'),

    'WORDER_TYPE'    => array('0'=>'维修工单','1'=>'管理工单','2'=>'质量工单','100'=>'项目工单','3'=>'其他工单'),

    'WORDER_DEPT_TYPE'=>array('0'=>'成熟产品','1'=>'新产品','2'=>'定制产品'),

    'SERVICE_TYPE'   =>array('校内-开放性科学实践课程','校内-寒暑假京外科考' , '校内-课后一小时课程' ,'校内-校园科技节','校内-课内京外科考、游学活动','校内-寒暑假京内科考', '校内-小课题研究','校内-社会实践课程','校内-专家讲座','校内-校园文化建设','校内-课内京区科考活动','校内-教师培训','校内-出境游学',
        '校外-国内长线活动', '校外-系列科学课程','校外-周末、小长假京内不过夜活动','校外-周末、小长假京内过夜活动','校外-政府项目','校外-出境活动','校外-趣谈活动',
        '京外-寒暑假冬夏令营', '京外-教师培训','京外-周末、小长假来京活动', '京外-周末、小长假当地活动', '京外-京区校外国内长线活动','京外-京区校外出境活动', '校外-开放性科学实践课程', '京外-专家讲座活动','校外-寒暑假托管班','京外-课内来京长线活动','京外-课内京外长线活动',),

    'ACT_NEED'       =>array('参观','讲解','动手活动','讲座','会议室','教室'),

    'JOB_NAME'       =>array('院士','研究院','副研究员','青年博物学家','兼职博士、研究生'),

    'LES_FIELD'      =>array('自然与环境','健康与安全','结构与机械','人文与历史','电子与控制','数据与信息','材料与能源','其他'),

    'ACT_FIELD'      =>array('冬夏令营','短线','长线'),

	'POST_TEAM_MORE' => array(
		//'80'		=> '80',
		'17'		=> '17,61,108',         //京区校外C-端(108活动实施专员--刘雨)
		//'35'		=> '35,16,37,38,64',//京区业务中心经理
		'35'		=> '35,16,37,38,64,87,88,96,89,97,90,98,91,99,92',//京区业务中心经理
		//'18'		=> '18,59,73,74',
		'18'		=> '18,59',
		'19'		=> '19,36',
		//'40'		=> '40,41,49,82,83',
		'40'		=> '40,41,42,49,82,83',
		'55'		=> '55,56,57,58,84',
        '73'        => '73,74'
	),


	'POST_TEAM_MORE_ALL' => array(
		/*'80'		=> '80,17,61',*/							    //京区校外
		'17'		=> '17,61,108',								        //京区校外
		'35'		=> '35,16,37,38,64,87,88,96,89,97,90,98,91,99,92,93,101,104,105,106', //京区校内
		'18'		=> '18,59,73,74,19,36,40,41,49,55,56,57,73,74'	//京外业务
	),

	//成本类型
	//'COST_TYPE' => array('1'=>'物资','2'=>'专家辅导员',/*'3'=>'合格供方','5'=>'产品模块',*/ '6'=>'研究所台站','7'=>'旅游车队','8'=>'酒店','9'=>'地接社','10'=>'餐厅','11'=>'景点','12'=>'票务','13'=>'内部地接','4'=>'其他'),

	//比价类型
	'REL_TYPE' => array('9'=>'地接社','7'=>'旅游车队','8'=>'酒店'),

	//巡检类型
	'INS_TYPE' => array('1'=>'业务巡检','2'=>'部门巡检'),

    //线路类型
    'LINE_TYPE'=> array('1'=>'普通行程','2'=>'固定线路'),

    //固定线路酒店星级
    'HOTEL_START'=>array('3'=>'三星级','4'=>'四星级','5'=>'五星级','6'=>'六星级','10'=>'其他'),

    //适合人群(立项和录入专家资源信息、科普资源)
    'APPLY_TO' => array('6'=>'亲子、幼儿','1'=>'小学','2'=>'初中','3'=>'高中','4'=>'成人','5'=>'混合'),

    //活动时长(time_length)
    'TIME_LENGTH'   => array('1小时以内','1小时','1.5小时','2小时(半天)','一到三天','三天以上'),

    //可实施时间(use_time)
    'USE_TIME'      => array('工作日','节假日','不限','工作日(非周一)'),

    //可接待规模(scale)
    'SCALE'         => array('20人以下','20-40人','40-100人','100人以上'),

    //预约需提前时间(lead_time)
    'LEAD_TIME'     => array('5-7个工作日','7个工作日以上'),

    //借款单借款方式
    'JIEKUAN_TYPE'  => array('1'=>'支票','2'=>'现金','3'=>'汇款','4'=>'其他'),

    //辅导员/教师、专家所属领域
    'GUI_FIELDS'     => array(
        '1'=>'数学与信息','2'=>'物理与工程','3'=>'生命科学','4'=>'地球与空间科学','5'=>'化学与材料','6'=>'能源与环境','7'=>'专项科学','8'=>'研学旅行','9'=>'STEAM课程','10'=>'生态学','11'=>'历史','12'=>'人文','13'=>'其他'),

    //产品模块类别
    'PRODUCT_TYPE'  => array('1'=>'演示类','2'=>'体验类','3'=>'制作类','4'=>'展示类'),

    //产品来源
    'PRODUCT_FROM'  => array('1'=>'自研','2'=>'外采'),

    //产品核算模式
    'RECKON_MODE'   => array('1'=>'按项目核算','2'=>'按人数核算 ','3'=>'按批次核算(100人/批)'),

    //产品标准化
    'STANDARD'      => array('1'=>'标准化','2'=>'非标准化'),

    //标准化产品的项目类型 54研学旅行 56校园科技节 57综合实践 60科学课程 82科学博物园 67实验室建设 87单进院所 90背景提升及科研实习
    'STANDARD_PRODUCT_KIND_IDS' => array(54,56,57,60,67,82,87,90),

    //需要做产品模块化的项(56=>校园科技节,60=>课后一小时,87=>单进院所)
    'ARR_PRODUCT'   => array(56,60,87),

    //获取IP,论坛输入限制
    'ARR_IP'        => array('124.16.248.193','124.16.248.194','124.16.248.195','124.16.248.196','124.16.248.197','124.16.248.198','124.16.248.199','124.16.248.200','124.16.248.201','124.16.248.202','124.16.248.203','124.16.248.204','124.16.248.205',
        '124.16.248.206','124.16.248.207','124.16.248.208','124.16.248.209','124.16.248.210', '124.16.248.211','124.16.248.212','124.16.248.213','124.16.248.214','124.16.248.215','124.16.248.216', '124.16.248.217','124.16.248.218','124.16.248.219','111.196.67.223',
        '124.16.248.220','124.16.248.221','124.16.248.222','111.196.66.142','114.254.59.121','192.168.1.113','218.2.2.2','218.4.4.4','27.17.222.120','175.168.190.146','223.99.20.87','36.104.40.146','125.34.49.57','222.130.132.219','114.254.45.144','114.252.213.54','117.153.4.211'),
    //'192.168.1.113,'218.2.2.2','218.4.4.4'(南京),27.17.222.120(武汉),'175.168.190.146(沈阳),'223.99.20.87(济南)','36.104.40.146(长春)'

    //文件标签
    'FILE_TAG'     => array(
        '1'         => array( //公司文件
                              '1'     => '公司制度',
                              '2'     => '管理规程'
                              //'3'     => '业务规范',
                              //'4'     => '产品资料'
        ),
        '2'         => array( //部门文件
                              '11'    => '部门职责',
                              '14'    => '部门制度',
                              '12'    => '管理规程',
                              '13'    => '其他'
        ),
        '3'         => array( //岗位文件
                              '21'    => '岗位说明',
                              '22'    => '管理规程',
                              '23'    => '业务规范',
                              '24'    => '其他'
        )
    ),

    //内部地接社
    'DIJIE_NAME'    =>array(
        'JQYW'  => '京区业务中心',
        'JWYW'  => '京外业务中心',
        'SCYW'  => '市场部',
        'WHXM'  => '武汉项目部',
        'NJXM'  => '南京项目部',
        'SYXM'  => '沈阳项目部',
        'CCXM'  => '长春项目部'
    ),

    //内部地接成团后生成的新项目的创建者, 默认内部地接社项目经理
    'DIJIE_CREATE_USER'    =>array(
        'JQYW'  => 100,     //石曼
        'WHXM'  => 23,      //徐恒
        'NJXM'  => 109,     //徐娜
        'SYXM'  => 45,      //赵鹏
        'CCXM'  => 179,     //赵艳
    ),

    //业务部门id 2=>市场部 6=>京区业务中心; 7=>京外业务中心; 12=>南京; 13=>武汉; 14=> 沈阳; 15=>常规旅游; 16=>长春; 17=>济南;
    'YW_DEPARTS'            =>array(2,6,7,12,13,14,15,16),
    'YW_DEPARTS_KPI'        =>array(2,6,7,12,13,14,16), //(kpi=>合同签订率, 顾客满意度)排除常规旅游中心

    //京区业务C端(李保罗uid=59) 月度销售任务系数
    'JQXY-C'                => array('01'=>3,'02'=>5,'03'=>3,'04'=>2,'05'=>3,'06'=>2,'07'=>1,'08'=>7,'09'=>8,'10'=>2,'11'=>3,'12'=>1),

    //实施专家
    'EXPERT'                =>array('16'=>'黄鑫磊','18'=>'戴明'),

    //城市合伙人费用类型
    'PARTNER_COST_TYPE'     =>array('1'=>'保证金','2'=>'宣传费','3'=>'其他'),

    //项目预结算费用项
    //'OP_COST_TYPE'          =>array('税点','奖金包'),

    //满意度状态
    'SCORE_STU'     =>array(
        '5'     => '<span class="green">非常满意</span>',
        '4'     => '<span class="green">满意</span>',
        '3'     => '<span class="blue">一般</span>',
        '2'     => '<span class="yellow">不满意</span>',
        '1'     => '<span class="red">非常不满意</span>'
    ),

    //评分,根据不同的项目类型显示不同内容
    'SCORE_KIND1'          => array(
        '1'  =>  '线路' ,
        '3'  =>  '其它' ,
        '54' =>  '研学旅行' ,
        '55' =>  '科学考察' ,
        '57' =>  '社会综合实践' ,
        '65' =>  '教师培训' ,
        '66' =>  '少科院线路' ,
        '68' =>  '常规旅游'
    ),
    'SCORE_KIND2'          => array(
        '2'  =>  '课程' ,
        '56' =>  '校园科技节' ,
        '60' =>  '课后一小时' ,
        '61' =>  '小课题' ,
        '62' =>  '中科box' ,
        '64' =>  '专场讲座'
    ),
    'SCORE_KIND3'           => array(
        '58' =>  '亲子旅行' ,
        '59' =>  '冬夏令营' ,
        '63' =>  '学趣课程'

    ),
    'SCORE_KIND4'          => array(
        '67' =>  '实验室建设'
    ),

    'AUDIT_STATUS'  => array(
        '0' => '未审核',
        '1' => '审核通过',
        '2' => '审核未通过',
    ),

    'KPI_QUARTER'   => array(13,23,32,38,55,77,100,109),    //kpi季度考核人员的id 13=>杜莹 23=>徐恒 55=>程小平 77=>王茜 100=>石曼, 109=>徐娜
    'KPI_CYCLE'     => array('1'=>'月度','2'=>'季度','3'=>'半年','4'=>'年度'),
    'NOT_SELECT_USER'=>array('孟华华','李岩1','魏春竹1','石曼1','王爱1','彭白鸽1','王旭1','郑志江1','杨晓旺1'), //统计人员时不查询的人员信息
    'GEC_TRANSFER_UID'  => array(1,11,13,32), //调整客户交接人员信息 11=>乔峰,13=>杜莹, 32=>王凯
    'UN_USE_MEMBER_WEIGHT_USER'=>array(191=>'刘利',194=>'李菊华',227=>'刘丹'), //激励机制中不使用核定权重人数的人员

    'QUARTER_QUOTA_ID'  => array(   //季度考核KPI的指标id
        125,    //季度利润总额目标完成率
        126,    //季度顾客满意度
        127,    //季度人事费用率
        128,    //不发生安全责任事故
        153,    //上级领导组织对关键事项绩效评价
        160     //标准化模块使用量
    ),

    //品控巡检类型(不合格处理率)
    'QAQC_TYPE'     => array(
        '3'         => '顾客投诉',
        '4'         => '安全责任事故',
        '5'         => '公司内部投诉',
        '6'         => '品质检查'
    ),

    'OA_CONTROLLER_NAMES'=>array('Index','Approval','Attachment','Chart','Contract','Cour','Customer','Export','File','Files','Finance','GuideRes','Inspect','Kpi','Minange','Material','Message','Op','Product','Project','Rbac','Rights','Salary','Sale','ScienceRes','Staff','SupplierRes','User','Wages','Worder','Work'),

    /*//工作记录类型  bak_20200318
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
			'116'   => '数据前端后端对接不及时',
			'117'   => '前端网页开发不及时',
			'118'   => '平台数据库开发不及时',
		),
		'2'=>array(
			'200'	=> '日常工作不合格',
			'201'	=> '资源配置不合格',
			'202'	=> '产品方案不合格',
			'203'	=> '物资采购不合格',
			'204'	=> '物资采购验收不合格',
			'217'	=> '物资采购不符合要求',
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
			'217'   => '物资物料盘点账实不相符',
			'218'   => '出现重大安全责任事故',
			'219'	=> '出现安全隐患',
			'220'	=> '文件管理执行不合格'
		),
		'3'=>array(
			'300'	=> '日常工作不满意',
		),
		'4'=>array(
			'400'	=> '日常工作未完成',
			'401'	=> '活动照片未收集',
			'402'	=> '学趣新课未参加',
			'403'	=> '活动前期未准备',
			'404'	=> '日常微信网站维护未完成',
			'405'	=> '市场活动前期未准备',
		)
	),*/

    //工作记录类型
    'REC_TYPE' => array('1'=>'财务部出纳','100'=>'其他'),

    //记录详情
    'REC_TYPE_INFO' => array(
        '1'=>array(
            '100'	=> '开发票',
            '101'	=> '汇款',
            '102'	=> '网银支付',
            '103'	=> '回款确认',
            '104'	=> '现金付款',
            '105'	=> '个税申报',
            '106'	=> '其他'
        ),
        '100'=>array(
            '10001'	=> '其他'
        )
    ),

	//文件流转状态
    'FILE_STATUS'   => array(
        -1          => '<span class="red">总经理审核未通过</span>',
        0           => '编辑中,未提交',
        1           => '文件正常流转中',
        2           => '<span class="yellow">文件超时流转中</span>',
        3           => '<span class="blue">已返回至发布者</span>',
        4           => '<span class="primary">已提交总经理审核</span>',
        5           => '<span class="green">总经理审核通过</span>'
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

    'department'    => array('京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心'),//查询其他表部门
    'department1'   => array('公司','京区业务中心','京外业务中心','南京项目部','武汉项目部','沈阳项目部','长春项目部','市场部','常规业务中心','机关部门'),//manage_input 表 数据部门排序
    'HR_COST'       => array('工资总额','公司五险一金','职工福利费','职工教育经费','劳动保护费用','工会经费及其他','职工住房费用'),
    'MANAGER_YANG'  => array('京外业务中心','武汉项目部','常规业务中心'),    //杨总所辖部门
    'MANAGER_WANG'  => array('沈阳项目部','长春项目部','市场部'),            //王总所辖部门
    'COMPANY'       => array(                                               //报销单分类
        '1'         => '科学国际旅行社有限责任公司',
        '2'         => '北京市海淀区中科科学文化传播发展中心',
        '3'         => '中科科行教育科技(北京)有限责任公司'
    ),
    'JiGuanNoManagerDepartmentIds'=>array(3,4,5,8,/*9,*/ 10,11,18,19), //机关部门ID,不包含总经办 //3=>研发部,4=>资源管理部,5=>计调部,8=>安全品控部,/*9=>综合部(弃用),*/ 10=>财务部,11=>人资综合部,18=>票务中心,19=>外联部
    'noJiGuanJidiaoDepartmentIds' =>array(6,12,13), //激励机制中使用本部门计调的业务部门ID // 6=>京区业务中心  12=>南京项目部  13=>武汉项目部

    //内部满意度被评分人员 bak_20191119
    /*'SATISFACTION_USERS'=>array(
       '12'         => '秦鸣',
       '55'         => '程小平',
       '77'         => '王茜',
       '13'         => '杜莹',
       '39'         => '孟华',
       '26'         => '李岩',
       //'114'        => '王丹',
       '204'        => '李徵红',
       '31'         => '魏春竹',
    ),*/

);

return array_merge($config, $dblink);
