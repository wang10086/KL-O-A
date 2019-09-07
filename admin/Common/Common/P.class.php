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
	const  VERSION         =   "v2.2.0";
	const  VERSION_CODE    =   "20180107";
	const  VERSION_NAME    =   "";
	const  SYSTEM_NAME     =   "中科科OA系统";
    const  SYS_NAME        =   "中科科行";
    
    
    // 常用参数定义
    const  YES            =    1;   // 是
    const  NO             =    0;   // 否
    const  ENABLE         =    1;   // 允许，启用，可用
    const  DISABLE        =    0;   // 不可用，未开启
    const  SUCCESS        =    0;   // 成功
    const  ERROR          =    -1;  // 失败
    
    // 性别常量
    const  SEX_MALE       =    1;   // 性别 男
    const  SEX_FAMALE     =    2;   // 性别 女
    const  SEX_UNKOWN     =    0;   // 性别 未知
    
    // 页面
    const  PAGE_SIZE      =    20;  //每页记录条数
    
    
    // 用户状态
    const USER_STATUS_NORMAL   = 0;
    const USER_STATUS_DELETED  = -1;  //已删除或停用
    const USER_STATUS_UNAUDIT  = 2;   //未审核
    const USER_STATUS_EXPIRE   = 9;  //临时用户已到期
        
    
    const AUDIT_STATUS_NOT_AUDIT  = 0;  //待审批
    const AUDIT_STATUS_PASS       = 1;  //审批通过
	const AUDIT_STATUS_NOT_PASS   = 2;  //审批不通过
    const AUDIT_STATUS_MORE_AUDIT = 3;  //第一次审核通过,待复审
	
	const USER_TYPE_TEMP       = 2;  //临时用户
	const USER_TYPE_PART       = 1;  //兼职用户
	const USER_TYPE_FORMAL     = 0;  //正式员工、用户
	
	const RES_TYPE_SCIENCE     = 1;  //资源类型：科普资源
	const RES_TYPE_SUPPLIER    = 2;  //资源类型：合格供方资源
	const RES_TYPE_GUIDE       = 3;  //资源类型：导游辅导员
	
	
	const REQ_TYPE_PROJECT_NEW        = 99;   // 新项目审核
	const REQ_TYPE_PRODUCT_NEW        = 100;  // 新产品审核
	const REQ_TYPE_PRODUCT_V          = 101;  // 产品访问权限
	const REQ_TYPE_PRODUCT_D          = 102;  // 产品下载权限
	const REQ_TYPE_PRODUCT_U          = 103;  // 产品使用权限	
	const REQ_TYPE_PRODUCT_LINE       = 104;  // 产品线路审核	
	const REQ_TYPE_PRODUCT_MODEL      = 105;  // 新产品模板审核
    const REQ_TYPE_PRODUCTED          = 106;  // 新标准产品审核
	const REQ_TYPE_SCIENCE_RES_NEW    = 200;  // 新科普资源审核  
	const REQ_TYPE_SCIENCE_RES_V      = 201;  // 申请科普资源访问权限
	const REQ_TYPE_SCIENCE_RES_D      = 202;  // 申请科普资源下载权限
	const REQ_TYPE_SCIENCE_RES_U      = 203;  // 申请科普资源使用权限
	const REQ_TYPE_SUPPLIER_RES_NEW   = 300;  // 新合格供方资源审核
	const REQ_TYPE_SUPPLIER_RES_V     = 301;  // 申请合格供方资源访问权限
	const REQ_TYPE_SUPPLIER_RES_D     = 302;  // 申请合格供方资源下载权限
	const REQ_TYPE_SUPPLIER_RES_U     = 303;  // 申请合格供方资源使用权限
	const REQ_TYPE_GUIDE_RES_NEW      = 400;  // 新导游辅导员资源审核
	const REQ_TYPE_GUIDE_RES_V        = 401;  // 申请导游辅导员资源访问权限
	const REQ_TYPE_GUIDE_RES_D        = 402;  // 申请导游辅导员资源下载权限
	const REQ_TYPE_GUIDE_RES_U        = 403;  // 申请导游辅导员资源使用权限
	const REQ_TYPE_GOODS_NEW          = 500;  // 新物资审核
	const REQ_TYPE_GOODS_V            = 501;  // 申请物资访问权限
	const REQ_TYPE_GOODS_U            = 503;  // 申请物资使用权限
	const REQ_TYPE_GOODS_IN           = 504;  // 物资入库
	const REQ_TYPE_GOODS_OUT          = 505;  // 物资出库
	const REQ_TYPE_GOODS_PURCHASE     = 506;  // 物资采购
	const REQ_TYPE_PRICE              = 600;  // 价格申请
	const REQ_TYPE_FEES               = 700;  // 费用申请
	const REQ_TYPE_BUDGET             = 800;  // 项目预算申请
	const REQ_TYPE_SETTLEMENT         = 801;  // 项目结算申请
	const REQ_TYPE_HUIKUAN            = 802;  // 项目回款申请

    const WORDER_INI                  = 11;   //用户发起工单时上传文件
    const WORDER_EXE                  = 12;   //用户执行工单时上传文件
    const WORDER_PROJECT              = 100;  //用户执行工单时上传文件

	
	//错误
	const NOT_UPLOAD_DATA             =  '2000=未提交数据';   
	const NOT_DEL_FILE_DATA           =  '2001=未删除任何文件';   
	const NOT_MOVE_FILES_DATA         =  '2002=未移动任何文件';
	const NOT_AUTH_FILES_DATA         =  '2003=未设置任何权限';

    //上传文件类型
    const UPLOAD_PIC                = 1;    //图片文件
    const UPLOAD_THEORY             = 2;    //附件(原理及实施要求)
    const UPLOAD_VIDEO              = 3;    //视频文件
    const SIGN_USER                 = 4;    //员工签名

    //合同文件状态
    const BEFORE_AUDIT              = 1;    //律师审核前合同文件
    const AFTER_AUDIT               = 2;    //律师审核后合同文件
    const SURE                      = 3;    //确认版合同文件

    //未读内容表 unread表
    const UNREAD_CAS_RES            = 1;    //未读科普资源信息

    //满意度评分种类
    const SCORE_KIND_ACCOUNT        = 1;    //内部人员满意度评分
    const SCORE_KIND_WORDER         = 2;    //工单满意度评分

}


