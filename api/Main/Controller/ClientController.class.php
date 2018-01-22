<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;
use Think\Upload;
ulib('Pinyin');
use Sys\Pinyin;
class ClientController extends BaseController {
	
	
	
	/****** 获取配置项 ******/
	public function config(){
		
		//获取解码后参数
		$param = $this->param_data;
		
		$ages            = C('AGE_LIST');
		$prokinds        = M('project_kind')->getField('id,name',true);
		
		$return = array();
		$return['ages']        = $ages;
		$return['prokinds']    = $prokinds;
		
		echo return_result($return);
		
	}
	
	
	
	/****** 获取项目信息 ******/
	public function op(){
		
		//获取解码后参数
		$param = $this->param_data;
		
		$kinds   =  M('project_kind')->getField('id,name', true);
			
		$gid   = trim($param['gid']);
		$opid  = trim($param['opid']);
		
		if($op_id){
			$where = 'group_id = "'.$gid.'" OR op_id = '.$opid;
		}else{
			$where = 'group_id = "'.$gid.'"';
		}
		
		$pro   = M('op')->field('id,project,op_id as opid,group_id as gid,status,op_create_user as dept,kind')->where($where)->find();
	
		$pro['kind'] = $kinds[$pro['kind']];
		
		echo return_result($pro);
		
	}
	
	
	
	/****** 提交客户信息 ******/
	public function save_gec(){
		
		$com = $this->param_data;
		
		P('aaa');
		$PinYin = new Pinyin();
		$company_name = iconv("utf-8","gb2312",trim($com['school_name']));
		
		
	
		//整理数据
		$info	= array();
		$info['company_name']		= $com['school_name'];								//学校名称
		$info['pinyin']				= strtolower($PinYin->getFirstPY($company_name));	//拼音	
		$info['type']				= '学校';											//类型
		$info['contacts']			= $com['contacts_name'];							//联系人     
		$info['contacts_phone']		= $com['contacts_mobile'];							//联系人手机号
		$info['post']				= $com['contacts_job'];								//联系人职位
		$info['contacts_fox']		= '';												//联系人传真号码
		$info['contacts_tel']		= $com['contacts_tel'];								//联系人座机电话
		$info['contacts_email']		= $com['contacts_email'];							//联系人邮箱
		$info['contacts_b']			= $com['manager_name'];								//负责人
		$info['contacts_phone_b']	= $com['mobile_num'];								//负责人手机
		$info['post_b']				= $com['manager_job'];								//负责人职务
		$info['contacts_fox_b']		= '';												//负责人传真
		$info['contacts_tel_b']		= $com['tel_num'];									//负责人电话
		$info['contacts_email_b']	= $com['wechat_email'];								//负责人邮箱
		$info['level']				= '重要客户';
		$info['qianli']				= '潜力巨大';
		$info['province']			= $com['province'];
		$info['city']				= '';
		$info['county']				= '';
		$info['contacts_address']	= $com['school_addr'];								//学校地址
		$info['create_time']		= time();
		$info['cm_id']				= 0;
		$info['cm_name']			= '';
		$info['cm_time']			= 0;
		$info['remark']				= '校长：'.$com['school_master'];
		$info['status']				= 1;
		$info['com']				= 1;
		
		
		$where = array();
		$where['company_name']		= $com['school_name'];
		$where['com']				= 1;
		
		//判断是否导入
		$gec = M('customer_gec')->where($where)->find();
		if($gec){
			if($gec['status']==1){
				M('customer_gec')->where(array('id'=>$gec['id']))->data($info)->save();
			}
		}else{
			M('customer_gec')->add($info);
		}
		
		
		
	}
	
	
	
}