<?php
namespace Sys;


final class P {
    // 防止创建实例
    private function __construct () { }
   
    // 版本定义
    // 系统版本号定义：x.y.z   
    // x:大版本，功能、UI、数据结构有重大改动时变更
    // y:增加或删除功能模块时变更
    // x:小功能变更，批量BUG修复时变更
    // 其他：alpha 开发预览版本  beta 上线公测版本  release最终确定版本
    const  VERSION                    =   "1.0.0";
    const  VERSION_CODE               =   "20170707";
    const  VERSION_NAME               =   "启航";
     
    // 常用参数定义
    const  YES                        =    1;   // 是
    const  NO                         =    0;   // 否
    const  ENABLE                     =    1;   // 允许，启用，可用
    const  DISABLE                    =    0;   // 不可用，未开启
    const  SUCCESS                    =    0;   // 成功
    const  ERROR                      =    -1;  // 失败
    
    // 性别常量
    const  SEX_MALE                   =    1;   // 性别 男
    const  SEX_FAMALE                 =    2;   // 性别 女
    const  SEX_UNKOWN                 =    0;   // 性别 未知
	
	// 用户类型定义
	const  ACCOUNT_PERSONAL           =    0;   //个人用户
    const  ACCOUNT_COMPANY            =    1;   //企业用户
	
	// 短信发送类型定义
	const  SMS_SEND_REG               =    0;   //注册短信
    const  SMS_SEND_LOGIN             =    1;   //登陆短信
	const  SMS_SEND_EDIT              =    2;   //修改资料短信
	
    // 页面
    const  PAGE_SIZE                  =    20;  //每页记录条数
	
	//严重错误
	const  ERR_SQL_ADD                =    '-1000=数据库无法新增数据';
	const  ERR_SQL_SAVE               =    '-1001=数据库无法修改数据';
	const  ERR_SQL_DEL                =    '-1002=数据库无法删除数据';
	
	//安全类错误
	const  ERR_PARAM_UNKNOWN          =    '1000=未知参数';
	const  ERR_PARAM_ILLEGAL          =    '1001=非法请求';
	const  ERR_EXPIRED                =    '1002=请求已过期';
	
}


