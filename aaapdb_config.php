<?php
return array(

    'DB_TYPE'               =>  'mysqli',          // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'xuequoa',         // 数据库名
    'DB_USER'               =>  'root',            // 用户名
    'DB_PWD'                =>  'xqwk#136013',     // 密码
    'DB_PORT'               =>  '3306',            // 端口
    'DB_PREFIX'             =>  'oa_',
	
	/* 缓存设置 */
    'TMPL_CACHE_TIME'       => 1,
    'DATA_CACHE_TIME'       => 3600,
    //'DATA_CACHE_TYPE'       => 'Redis',
    //'REDIS_HOST'            => '127.0.0.1',
    //'REDIS_PORT'            => 6379,
	
	 /*素材CDN服务器*/
	'CDN_URL'               =>  'http://oa.kexueyou.com/',
	
	/*项目访问地址*/
	'WEB_PATH'              =>  'http://oa.kexueyou.com/',
);
?>
