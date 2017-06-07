<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

class UserController extends BaseController {
	
	//企业列表
	public function company(){
		
		$db = M('company');
		$this->company_name = I('company_name','');
		//分页
		if($this->company_name)  $where['company_name'] = array('like','%'.$this->company_name.'%');
		
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
		$this->companylist = $db->where($where)->order($this->orders())->limit($page->firstRow . ',' . $page->listRows)->select();

		$this->display('company');	
	}
	
	//编辑企业
	public function company_edit(){
		$db = M('company');
		
		if(isset($_POST['dosubmit'])){
			$infos = I('info','');			
			$editid = I('editid',0);
			if(!$editid){
				$newid = $db->add($infos);
				if($newid){
					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));			
				}
			}else{
				$isedit = $db->data($infos)->where(array('id'=>$editid))->save();	
				$newid = $editid;
				if($newid){
					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));			
				}
			}
		}else{
			$id = I('id',0);
			$this->row = $db->find($id);
			$this->display('company_edit');	
		}
	}
	
	//管理员列表
    public function index(){
		$db = M('admin');
		//企业
		$dw = '';
		if(cookie('company_id')!=1) $dw = '`id`='.cookie('company_id');
		$this->companylist = M('company')->where($dw)->select();
		
		//角色
		$this->rolelist = M('role')->where('id in ('.rtrim(Rolerelation(cookie('roleid')),',').')')->select();	
		
		//条件
		$this->status  = I('status','');
		$this->pid     = I('pid','');
		$this->role    = I('role','');
		$this->user    = I('user','');
		$this->name    = I('name','');
		if(!empty($this->status))       $where['a.status'] = $this->status;	
		if(!empty($this->pid))          $where['a.company_id'] = $this->pid;	
		if(!empty($this->role))         $where['a.roleid'] = $this->role;
		if(!empty($this->user))         $where['a.username'] = array('like','%'.$this->user.'%');
		if(!empty($this->name))         $where['a.nickname'] = array('like','%'.$this->name.'%');

		//如果为非开发者权限附加以下条件
		if(cookie('roleid')>=1){
			$users = Userrelation(cookie('userid'));
			$where['a.id'] = array('in',$users.cookie('userid'));
		}
		
		
		//查询字段
		$field = 'a.id as userid,a.username,a.nickname,a.mobile,a.email ,a.update_time,a.roleid,a.company_id,a.parentid,a.status,d.id,d.company_name,r.id,r.remark';
		
		//分页
		$pagecount = $db->table(C('DB_PREFIX').'admin a')->field($field)->join('left join '.C('DB_PREFIX').'company d on a.company_id = d.id')->join('left join '.C('DB_PREFIX').'role r on a.roleid = r.id')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
		//查询
		$this->users = $db->table(C('DB_PREFIX').'admin a')->field($field)->join('left join '.C('DB_PREFIX').'company d on a.company_id = d.id')->join('left join '.C('DB_PREFIX').'role r on a.roleid = r.id')->where($where)->order($this->orders())->limit($page->firstRow . ',' . $page->listRows)->select();
		
		//P($db->GetLastSql());
		
		$this->display('index');
		
    }
	
	//新增管理员
	public function add(){
		$db = M('admin');				
		if(isset($_POST['dosubmit'])){
			
			$info = I('info','');
			$roleid = I('roles','');
			$info['roleid'] = $roleid;
			$info['parentid'] = cookie('userid');
			
			//加入随机字符串重组多重加密密码
			$passwordinfo = password(I('password_1'));
			$info['password'] = $passwordinfo['password'];
			$info['encrypt'] = $passwordinfo['encrypt'];
				
			$info['input_time'] = time();
			$info['ip'] = get_client_ip();
			$info['username'] = trim($info['username']);
			$isadd = $db->add($info);
			if($isadd) {
				$data = array();
				$data['role_id'] = $roleid;
				$data['user_id'] = $isadd;
				M('role_user')->add($data);
				$this->success('添加成功！',I('referer',''));
			} else {
				$this->error('添加失败',I('referer',''));
			}
			
			
		}else{
			$id = I('id', 0);
			//$where = 'id in ('.rtrim(Rolerelation(cookie('roleid')),',').')';
			
			$this->roles = M('role')->where($where)->select();	
			$this->companylist = M('company')->select();			
		
			$this->pagetitle = '新增用户';	
			$this->row = false;
			$this->userrole = array();
			
			$this->display('add');
		}
    }
	
	
	//编辑管理员
	public function edit(){
		$this->user_show = 'class="active"';
		$db = M('admin');				
		if(isset($_POST['dosubmit'])){
			
			$info = I('info','');
			$id = I('id',0);
			$roleid = I('roles','');
			if($roleid){
				$info['roleid'] = $roleid;
			}
			if($id){
				$isedit = $db->data($info)->where(array('id'=>$id))->save();
				if($roleid){
					$data = array();
					$data['role_id'] = $roleid;
					$data['user_id'] = $id;					
					$urdb = M('role_user');
					$urdb->where("`user_id`='".$id."'")->delete();
					$urdb->add($data);
				}
				$this->success('修改成功！',I('referer',''));
			}	
			
		}else{
			$id = I('id', 0);
			//$where = 'id in ('.rtrim(Rolerelation(cookie('roleid')),',').')';
			$where = '';
			
			$this->roles = M('role')->where($where)->select();		
			
			$this->pagetitle = '修改资料';
			$this->row = $db->find($id);	
			$this->userrole = M('role_user')->where("`user_id`='".$id."'")->getField('role_id', true);
			if (!$this->row) {
				$this->error('用户不存在！',I('referer',''));	
			}
			$this->display('edit');
		}
    }
	
	
	//修改密码
	public function password(){
		$db = M('admin');
		$this->user_show = 'class="active"';
		if(isset($_POST['dosubmit'])){
			
			$editdate = I('editdate',0);
			
			//加入随机字符串重组多重加密密码
			$passwordinfo = password(I('password_1'));
			$info['password'] = $passwordinfo['password'];
			$info['encrypt'] = $passwordinfo['encrypt'];
			
			$isedit = $db->data($info)->where(array('id'=>$editdate))->save();	
			if($isedit){
				$this->success('修改成功！',I('referer',''));
			}else{
				$this->error('修改失败！',I('referer',''));	
			}
			
		}else{
			$id = I('id', -1);
			$this->row = $db->find($id);
			$this->display('password');	
		}
	}
	
	//管理员注册验证
	public function public_checkname_ajax(){
		$username = I('username',0);;
		
		//判断会员是否存在
		$db = M('admin');
		if($db->where(array('username'=>$username))->select()) {
			exit('0');
		}else {
			exit('1');
		}	
	}
	
	//管理员注册邮箱验证
	public function public_checkmail_ajax(){
		$email = I('email',0);;
		
		//判断会员是否存在
		$db = M('admin');
		if($db->where(array('email'=>$email))->select()) {
			exit('0');
		}else {
			exit('1');
		}	
	}
	

	
}
	