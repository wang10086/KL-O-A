<?php
//权限管理
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


// @@@NODE-2###Rbac###组织结构管理###
class RbacController extends BaseController {

    protected $_pagetitle_ = '组织结构和权限';
    protected $_pagedesc_  = '设置系统用户、部门和权限等';
    
    // @@@NODE-3###index###用户列表###
    public function index(){
    
        $this->title('用户列表');
    
        $db = D('account');
       
		if(rolemenu(array('Rbac/adduser'))){
			$where['status'] = array('neq',2);
			$where['id'] = array('gt',3);
		}else{
			$where['id'] = cookie('userid');
		}
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
        $this->users = $db->relation(true)->where($where)->order($this->orders('id'))->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->rolelist = get_roles();
        $this->display('index');
    }
    
	
	public function public_checkname_ajax(){
		$username = I('username',0);
		
		//判断会员是否存在
		$db = M('account');
		if($db->where(array('username'=>$username))->select()) {
			exit('0');
		}else {
			exit('1');
		}	
	}
	
    
	
    // @@@NODE-3###adduser###添加用户###
    public function adduser(){
    
        $this->title('添加/修改用户');
         
        $db = M('account');
    
        if(isset($_POST['dosubmit'])){
            	
            $info = I('info','');
            $id = I('id',0);
			$referer = I('referer','');
            if(!$id){
				$passwordinfo = password(I('password_1'));
				$info['password'] = $passwordinfo['password'];
				$info['encrypt'] = $passwordinfo['encrypt'];
			    
				//$info['roleid']  = intval($_POST['roles'][0]);
                $info['input_time'] = time();
                $info['ip'] = get_client_ip();
                $isadd = $db->add($info);
                if($isadd) {
                    $data = array();
                    $data['role_id']  =  $info['roleid'];
                    $data['user_id']  =  $isadd;
                    M('role_user')->add($data);
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                //$info['update_time'] = time();
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                $data = array();
				$data['role_id']  =  $info['roleid'];
				$data['user_id']  =  $id;
				
                $urdb = M('role_user');
                $urdb->where("`user_id`='".$id."'")->delete();
                $urdb->add($data);
    
                $this->success('修改成功！',$referer);
            }
            	
        }else{
            $id = I('id', 0);
            	
            $this->roles =  M('role')->where('id>3')->select();
            	
            if (!$id) {
                $this->pagetitle = '新增用户';
                $this->row = false;
                $this->userrole = array();
            } else {
                $this->pagetitle = '修改资料';
                $this->row = $db->find($id);
                $this->userrole = M('role_user')->where("`user_id`='".$id."'")->getField('role_id', true);
                if (!$this->row) {
                    $this->error('查无此人！', U('Rbac/index'));
                }
            }
            $this->display('adduser');
        }
    }
    
    // @@@NODE-3###deluser###删除用户###
    public function deluser(){
        $this->title('删除用户');
        $db = M('account');
        $id = I('id', -1);
        if ($id==1) {
            $this->error("超级管理员不能删除！");
        }
        $iddel = $db->data(array('status'=>2))->where(array('id'=>$id))->save();
        $this->success('删除成功！', U('Rbac/index'));
    
    }
    
    // @@@NODE-3###password###修改密码###
    public function password(){
        $this->title('修改密码');
        $db = M('account');
    
        if(isset($_POST['dosubmit'])){
            $id = I('id',0);
			$passwordinfo = password(I('password_1'));
			$info['password'] = $passwordinfo['password'];
			$info['encrypt'] = $passwordinfo['encrypt'];
					
			$referer = I('referer');
            	
            //if($_SESSION['code'] != I('code')) {
            //    $this->error('验证码错误！');
            //}
            	
            $isedit = $db->data($info)->where(array('id'=>$id))->save();
            if($isedit) {
                $this->success('修改成功！',$referer);
            } else {
                $this->error('修改失败：' . $db->getError());
            }
            	
        }else{
            $id = I('id', 0);
            if (!$id) $this->error('非法操作！', U('Rbac/index'));
            $this->row = $db->find($id);
            if (!$this->row) $this->error('查无此人！', U('Rbac/index'));
            $this->display('password');
        }
    }
    
    // @@@NODE-3###role###部门列表###
    public function role() {
        $this->title('部门列表');
        /*
         $db = M('role');
         $where = "id>=4";
         $page = new Page($db->where($where)->count(), 100);
         //p($page);
         //$this->pagetitle = '角色';
         $this->pages = $page->show();
         $allroles = $db->where($where)->order('pid,id')->limit($page->firstRow . ',' . $page->listRows)->select();
    
         $role_by_id  = array();
         foreach ($allroles as $row) {
         $role_by_id[$row['id']] = $row;
         }
    
         $roles = merge_node($role_by_id, null);
         sort_node($roles, $new);
        */
        $this->roles =  get_roles();
        $this->pages = '';
        $this->display('role');
    }
	
	
	
    
    // @@@NODE-3###addrole###添加部门###
    public function addrole() {
        $this->title('添加/修改部门');
        $db = M('role');
        $pid  = I('pid', 10);
    
        $id = I('id',0);
        if ($id == 10 || $pid < 10) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = 'null';
            $father['role_name'] = '无';
    
        } else {
            $father = M('role')->find($pid);
        }
    
        $this->father = $father;
    
        if(isset($_POST['dosubmit'])){
    
            $info = I('info','');
            $info['remark'] = $info['role_name'];
			
			$uplevel = M('role')->field('level')->find($info['pid']);
			$info['level'] = $uplevel['level']+1;
            	
            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('Rbac/role'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('Rbac/role'));
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
    
            if (!$id) {
                $this->pagetitle = '新增部门';
                $this->row = false;
            } else {
                $this->pagetitle = '修改部门';
                $this->row = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('Rbac/role'));
                }
            }
			
			$this->rolelist = M('role')->where('`id`>3 and `id`!='.$id)->select();
            $this->display('addrole');
        }
    }
    
    // @@@NODE-3###delrole###删除部门###
    public function delrole() {
        $this->title('删除部门');
         
        $db = M('role');
        $id = I('id', -1);
        if ($id <= 4) {
            $this->error("角色不能删除！");
        }
        $roles = get_roles();
    
        $where = "id in ($id";
        $flag = 99;
        for ($i = 0; $i < count($roles); $i++ ) {
            if ($roles[$i]['id'] == $id) {
                $flag = $roles[$i]['level'];
                continue;
            }
            if ($roles[$i]['level'] > $flag) {
                $where .= ',' . $roles[$i]['id'];
            } else {
                break;
            }
        }
        $where .= ')';
        $iddel = $db->where($where)->delete();
        $this->success('删除成功！', U('Rbac/role'));
    }
    
    
    
    public function node() {
        $this->title('结点列表');
        //import ('ORG.Util.Page');
        $db = M('node');
        //$page = new Page($db->count(), 12);
        //p($page);
        //$this->pages = $page->show();
        //$rs = $db->order('level asc, sort desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        $rs = $db->order('level asc, sort desc')->select();
        $this->pagetitle = '节点';
        $this->nodes = merge_node($rs);
        	
        $this->display('node');
    }
    
    public function delnode() {
        $this->title('删除结点');
        $db = M('node');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！', U('Rbac/node'));
    }
    
    public function addnode() {
        $this->title('添加结点');
        $db = M('node');
        if(isset($_POST['dosubmit'])){
            	
            //if($_SESSION['code'] != I('code')) {
            //    $this->error('验证码错误！');
            //}
            $info = I('info','');
            $id = I('id',0);
            	
            if(!$id){
                $info['pid'] = I('pid',0);
                $info['level'] = I('level',1);
    
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！');
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $info['id'] = $id;
    
                $isedit = $db->save($info);
                if($isedit) {
                    $this->success('修改成功！',U('Rbac/node'));
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
            $id = I('id', 0);
            $this->level = I('level', 1);
            $this->pid = I('pid', 0);
            	
            if ($this->level > 1) {
                $this->prnt = $db->find($this->pid);
            } else {
                $this->prnt = false;
            }
            $this->type = '';
            switch($this->level) {
                case 1:
                    $this->type = '应用';
                    break;
                case 2:
                    $this->type = '控制器';
                    break;
                case 3:
                    $this->type = '方法';
                    break;
            }
            if (!$id) {
                $this->pagetitle = '新增' . $this->type;
                $this->row = false;
            } else {
                $this->pagetitle = '修改' . $this->type;
                $this->row = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('Rbac/node'));
                }
            }
            $this->display('addnode');
        }
    }
    
    
    // @@@NODE-3###priv###分配角色权限###
    public function priv() {
        $this->title('分配角色权限');
        if (isset($_POST['dosubmit'])) {
    
            $access = I('access');
            $roleid = I('roleid');
            $db = M('access');
            	
            $db->where("`role_id`='".$roleid."'")->delete();
            $data = array();
            foreach($access as $row) {
                $tmp = explode('_', $row);
                $data[] = array(
                        'role_id' => $roleid,
                        'node_id' => $tmp[0],
                        'level'   => $tmp[1]
                );
            }
            $data[] =  array(   // Main 结点也需要插入
                        'role_id' => $roleid,
                        'node_id' => 1,
                        'level'   => 1,
                );
            if ($db->addAll($data)) {
                $this->success('权限配置成功！', U('Rbac/role'));
            } else {
                $this->error('保存失败！');
            }
            	
        } else {
            $roleid = I('roleid');
            if (!$roleid) $this->error('非法操作！', U('Rbac/role'));
            $this->roleid = $roleid;
            	
            $role = M('role')->find($roleid);
            $this->rolename = $role['remark'];
            	
            $access  = M('access')->where("`role_id`='".$roleid."'")->getField('node_id', true);
            	
            $rs = M('node')->order('level asc, sort desc')->select();
            $this->nodes = merge_node($rs, $access);
            $this->pagetitle = '配置权限';
            $this->display('priv');
        }
    }
    

    // @@@NODE-3###respriv_science###科普资源默认权限设置###
    public function respriv_science(){
        $this->title('科普资源默认权限设置');
    
        $db = M('rights');
    
        $restable = 'cas_res';
        $resid    = '0';
    
        if (isset($_POST['dosubmit'])) {
            $roles = I('roles');
            $info = $_POST['info'];
    
            $db->where("restable='$restable' and resid='$resid'")->delete();
            $alldata = array();
    
            foreach ($roles as $row) {
                $data = array();
                $data['input_user'] = session('userid');
                $data['input_uname'] = session('nickname');
                $data['input_time']  = time();
                $data['restable'] = $restable;
                $data['resid']    = $resid;
                $data['isdel']    = 0;
                $data['roleid']   = $row;
                $data['v']        = isset($info[$row][v]) ? $info[$row][v] : 0;
                $data['d']        = isset($info[$row][d]) ? $info[$row][d] : 0;
                $data['u']        = isset($info[$row][u]) ? $info[$row][u] : 0;
                $alldata[] = $data;
            }
    
            $db->addAll($alldata);
    
            $this->success('操作成功！');
    
        } else {
    
            $this->rights = M('rights')->where("restable='$restable' and resid='$resid'")
            ->getField('roleid,v,d,u', true);
    
            $this->roles = get_roles();
            $this->res   = $restable;
            $this->resid = $resid;
    
            $this->display('respriv_science');
        }
    
    }
    
    
    
    // @@@NODE-3###respriv_supplier###合格供方默认权限设置###
    public function respriv_supplier(){
        $this->title('合格供方默认权限设置');
    
        $db = M('rights');
    
        $restable = 'supplier';
        $resid    = '0';
    
        if (isset($_POST['dosubmit'])) {
            $roles = I('roles');
            $info = $_POST['info'];
    
            $db->where("restable='$restable' and resid='$resid'")->delete();
            $alldata = array();
    
            foreach ($roles as $row) {
                $data = array();
                $data['input_user'] = session('userid');
                $data['input_uname'] = session('nickname');
                $data['input_time']  = time();
                $data['restable'] = $restable;
                $data['resid']    = $resid;
                $data['isdel']    = 0;
                $data['roleid']   = $row;
                $data['v']        = isset($info[$row][v]) ? $info[$row][v] : 0;
                $data['d']        = isset($info[$row][d]) ? $info[$row][d] : 0;
                $data['u']        = isset($info[$row][u]) ? $info[$row][u] : 0;
                $alldata[] = $data;
            }
    
            $db->addAll($alldata);
    
            $this->success('操作成功！');
    
        } else {
    
            $this->rights = M('rights')->where("restable='$restable' and resid='$resid'")
            ->getField('roleid,v,d,u', true);
    
            $this->roles = get_roles();
            $this->res   = $restable;
            $this->resid = $resid;
    
            $this->display('respriv_supplier');
        }
    
    }

    
    
    // @@@NODE-3###respriv_guide###导游辅导员默认权限设置###
    public function respriv_guide(){
        $this->title('导游辅导员默认权限设置');
    
        $db = M('rights');
    
        $restable = 'guide';
        $resid    = '0';
    
        if (isset($_POST['dosubmit'])) {
            $roles = I('roles');
            $info = $_POST['info'];
    
            $db->where("restable='$restable' and resid='$resid'")->delete();
            $alldata = array();
    
            foreach ($roles as $row) {
                $data = array();
                $data['input_user'] = session('userid');
                $data['input_uname'] = session('nickname');
                $data['input_time']  = time();
                $data['restable'] = $restable;
                $data['resid']    = $resid;
                $data['isdel']    = 0;
                $data['roleid']   = $row;
                $data['v']        = isset($info[$row][v]) ? $info[$row][v] : 0;
                $data['d']        = isset($info[$row][d]) ? $info[$row][d] : 0;
                $data['u']        = isset($info[$row][u]) ? $info[$row][u] : 0;
                $alldata[] = $data;
            }
    
            $db->addAll($alldata);
    
            $this->success('操作成功！');
    
        } else {
    
            $this->rights = M('rights')->where("restable='$restable' and resid='$resid'")
            ->getField('roleid,v,d,u', true);
    
            $this->roles = get_roles();
            $this->res   = $restable;
            $this->resid = $resid;
    
            $this->display('respriv_guide');
        }
    
    }




    // @@@NODE-3###respriv_product###产品默认权限设置###
    public function respriv_product(){
        $this->title('产品默认权限设置');
    
        $db = M('rights');
    
        $restable = 'product';
        $resid    = '0';
    
        if (isset($_POST['dosubmit'])) {
            $roles = I('roles');
            $info = $_POST['info'];
    
            $db->where("restable='$restable' and resid='$resid'")->delete();
            $alldata = array();
    
            foreach ($roles as $row) {
                $data = array();
                $data['input_user'] = session('userid');
                $data['input_uname'] = session('nickname');
                $data['input_time']  = time();
                $data['restable'] = $restable;
                $data['resid']    = $resid;
                $data['isdel']    = 0;
                $data['roleid']   = $row;
                $data['v']        = isset($info[$row][v]) ? $info[$row][v] : 0;
                $data['d']        = isset($info[$row][d]) ? $info[$row][d] : 0;
                $data['u']        = isset($info[$row][u]) ? $info[$row][u] : 0;
                $alldata[] = $data;
            }
    
            $db->addAll($alldata);
    
            $this->success('操作成功！');
    
        } else {
    
            $this->rights = M('rights')->where("restable='$restable' and resid='$resid'")
            ->getField('roleid,v,d,u', true);
    
            $this->roles = get_roles();
            $this->res   = $restable;
            $this->resid = $resid;
    
            $this->display('respriv_product');
        }
    
    }
    
    
    // @@@NODE-3###respriv_project###项目默认权限设置###
    public function respriv_project(){
        $this->title('项目默认权限设置');
    
        $db = M('rights');
    
        $restable = 'project';
        $resid    = '0';
    
        if (isset($_POST['dosubmit'])) {
            $roles = I('roles');
            $info = $_POST['info'];
    
            $db->where("restable='$restable' and resid='$resid'")->delete();
            $alldata = array();
    
            foreach ($roles as $row) {
                $data = array();
                $data['input_user'] = session('userid');
                $data['input_uname'] = session('nickname');
                $data['input_time']  = time();
                $data['restable'] = $restable;
                $data['resid']    = $resid;
                $data['isdel']    = 0;
                $data['roleid']   = $row;
                $data['v']        = isset($info[$row][v]) ? $info[$row][v] : 0;
                $data['d']        = isset($info[$row][d]) ? $info[$row][d] : 0;
                $data['u']        = isset($info[$row][u]) ? $info[$row][u] : 0;
                $alldata[] = $data;
            }
    
            $db->addAll($alldata);
    
            $this->success('操作成功！');
    
        } else {
    
            $this->rights = M('rights')->where("restable='$restable' and resid='$resid'")
            ->getField('roleid,v,d,u', true);
    
            $this->roles = get_roles();
            $this->res   = $restable;
            $this->resid = $resid;
    
            $this->display('respriv_project');
        }
    
    }
    

    // @@@NODE-3###audit_config###资源审核设置###
    public function audit_config () {
        $this->title('资源审核设置');
    
        
        $db = M('audit_config');
        $this->req_types = M('audit_field')->getField('req_type,name', true);
        
        if (isset($_POST['dosubmit'])) {
            $info = I('info');
            $all = array();
            M('audit_config')->where('1=1')->delete();
            
            foreach ($info as $k => $v) {
                
                foreach ($v as $kk => $vv) {
                    $data = array();
                    $data['audit_roleid'] = $k;
                    $data['req_type']     = $kk;
                    $all[] = $data;
                }
            }
            
            // 超级管理员拥有所有审核权限
            
            
            foreach ($this->req_types as $k => $v) {
                $all[] = array('audit_roleid'=>1, 'req_type'=>$k);
            }
            
            M('audit_config')->addAll($all);
            $this->success('操作成功！');
            
        } else {
            $this->roles = get_roles();
            $conf = M('audit_config')->select();
            $rights = array();
            foreach ($conf as $row) {
                $rights[$row['audit_roleid']][$row['req_type']] = true;
            }
            $this->rights = $rights;
            $this->display('audit_config');
        }
        
    }
    

    
    
    
    
    public function init_nodes () {
        $db = M('node');
        //$db->where("remark <> 'sys'")->delete();
         
        $files = glob(dirname(__FILE__)."/*Controller.class.php");
        $info = array(
                'status'   => 1,
                'remark'   => '',
                'sort'     => 0,
        );
         
        foreach ($files as $f) {
            $str = file_get_contents($f);
            
            if (!preg_match_all('/@@@NODE-([2])###([a-zA-Z_0-9]+)###(.*?)###/u', $str, $match, PREG_SET_ORDER)) {
                continue;
            }
            $info = array();
            
            $info['level'] = 2;
            $info['name']  = $match[0][2];
            $info['pid']   = 1;
            
            $isadd = $db->where($info)->find();
            
            $info['title']  = $match[0][3];
            $info['status'] = 1;
            
            if ($isadd) {
                $db->data($info)->save();
                $pid = $isadd['id'];   
            } else {
                $pid = $db->add($info);
            }
            
            if (preg_match_all('/@@@NODE-([3])###([a-zA-Z_0-9]+)###(.*?)###/u', $str, $match, PREG_SET_ORDER)) {
                for ($i=0; $i < count($match); $i++) {
                    $info = array();
                    
                    $info['level'] = 3;
                    $info['name']  = $match[$i][2];
                    $info['pid']   = $pid;
                                       
					$isadd = $db->where($info)->find();
					
					$info['title']  = $match[$i][3];
					$info['status'] = 1;
					if($isadd){
					    $db->data($info)->save();
					} else {
					    $db->add($info);

					}
                }
                echo $f . '<br>';
                flush();
            }
             
        }
        echo "init nodes done! <br>";
    }
    
    
/*	
    public function role() {

		$db = M('role');
		$page = new Page($db->count(), PAGE_NUM);
		$this->pages = $page->show();
		
		$this->roles = $db->order($this->orders())->limit($page->firstRow . ',' . $page->listRows)->select();	
	    $this->display('role');		
	}
	
	public function addrole() {

		$db = M('role');
		if(isset($_POST['dosubmit'])){
			
			$info = I('info','');
			$id = I('id',0);
			if(!$id){
				$isadd = $db->add($info);
				if($isadd) {
					$this->success('添加成功！',I('referer',''));
				} else {
					$this->error('添加失败：' . $db->getError(),I('referer',''));
				}
			}else{
				$isedit = $db->data($info)->where(array('id'=>$id))->save();
				if($isedit) {
					$this->success('修改成功！',I('referer',''));
				} else {
					$this->error('修改失败：' . $db->getError(),I('referer',''));
				}	
			}	
			
		}else{
			$id = I('id', 0);
			
			if (!$id) {
				$this->pagetitle = '新增角色';	
				$this->row = false;
			} else {
				$this->pagetitle = '修改角色';
				$this->row = $db->find($id);	
				if (!$this->row) {
				    $this->error('无此数据！',I('referer',''));	
				}
			}
			$this->rolelist = $db->select();
			$this->display('addrole');
		}	
	}
	
	
	
	public function node() {
		$this->node_show = 'class="active"';
		$db = M('node');
		$rs = $db->order('level asc, sort desc')->select();
		$this->pagetitle = '节点';
		$this->nodes = merge_node($rs);
			
	    $this->display('node');		
	}
	
	
	
	public function addnode() {
		$db = M('node');
		if(isset($_POST['dosubmit'])){
			
			$info = I('info','');
			$id = I('id',0);
			
			if(!$id){
				$info['pid'] = I('pid',0);
				$info['level'] = I('level',1);
				
				$isadd = $db->add($info);
				if($isadd) {
					$this->success('添加成功！',I('referer',''));
				} else {
					$this->error('添加失败：' . $db->getError(),I('referer',''));
				}
			}else{
				$info['id'] = $id;
				
				$isedit = $db->save($info);
				if($isedit) {
					$this->success('修改成功！',I('referer',''));
				} else {
					$this->error('修改失败：' . $db->getError(),I('referer',''));
				}	
			}	
			
		}else{
			$id = I('id', 0);
			$this->level = I('level', 1);
			$this->pid = I('pid', 0);
			
			if ($this->level > 1) {
			    $this->prnt = $db->find($this->pid);	
			} else {
				$this->prnt = false;
			}
			$this->type = '';
			switch($this->level) {
			    case 1:
				    $this->type = '应用';
				    break;
				case 2:
				    $this->type = '控制器';
				    break;
				case 3:
				    $this->type = '方法';
				    break;	
			}
			if (!$id) {
				$this->pagetitle = '新增' . $this->type;	
				$this->row = false;
			} else {
				$this->pagetitle = '修改' . $this->type;	
				$this->row = $db->find($id);	
				if (!$this->row) {
				    $this->error('无此数据！',I('referer',''));	
				}
			}
			$this->display('addnode');
		}	
	}

	public function priv() {
		$this->role_show = 'class="active"';
		if (isset($_POST['dosubmit'])) {

			$access = I('access');
			$roleid = I('roleid');
			$db = M('access');
			
			$db->where("`role_id`='".$roleid."'")->delete();
			$data = array();
			foreach($access as $row) {
				$tmp = explode('_', $row);
				$data[] = array(
				    'role_id' => $roleid,
					'node_id' => $tmp[0],
					'level'   => $tmp[1]
				);
			}
			if ($db->addAll($data)) {
			    $this->success('权限配置成功！',I('referer',''));	
			} else {
				$this->error('保存失败！',I('referer',''));
			}
			
		} else {
		    $roleid = I('roleid');
			if (!$roleid) $this->error('非法操作！',I('referer',''));
			$this->roleid = $roleid;
			
			$role = M('role')->find($roleid);
			$this->rolename = $role['remark'].'('.$role['name'].')';
			
			$access  = M('access')->where("`role_id`='".$roleid."'")->getField('node_id', true);
			
			$rs = M('node')->order('level asc, sort desc')->select();
		    $this->nodes = merge_node($rs, $access);
	        $this->pagetitle = '配置权限';
	        $this->display('priv');	
		}
	}
	
	*/
    
	
	
	// @@@NODE-3###pdca_auth###PDCA评分人设置###
    public function pdca_auth() {
        $this->title('PDCA评分人设置');
        
        $roles =  get_roles();
		foreach($roles as $k=>$v){
			$auth = M('auth')->where(array('role_id'=>$v['id']))->find();
			$roles[$k]['pdca'] = $auth ? '<span class="blue">'.username($auth['pdca_auth']).'<span>' : '<font color="#999">未设置</font>';
		}
		$this->roles = $roles;
        $this->pages = '';
        $this->display('pdca_auth');
    }
    
	
	
	// @@@NODE-3###pdca_auth###指定PDCA评分人###
    public function op_pdca_auth() {
        if(isset($_POST['dosubmint'])){
			
			$info      = I('info');
				
			//判断数据是否存在
			if(M('auth')->where(array('role_id'=>$info['role_id']))->find()){
				$addinfo = M('auth')->data($info)->where(array('role_id'=>$info['role_id']))->save();
			}else{
				$addinfo = M('auth')->add($info);
			}
			
			echo '<script>window.top.location.reload();</script>';
			
		
		
		}else{
			
			$id = I('id','');
			if($id){
				$this->role = M('role')->find($id);
				$row  = M('auth')->where(array('role_id'=>$id))->find();
				if($row){
					$name = M('account')->find($row['pdca_auth']);
					$row['pdca_auth_name'] = $name['nickname'];
				}
				$this->row = $row;
			}
			
			
			//整理关键字
			$role = M('role')->GetField('id,role_name',true);
			$user =  M('account')->select();
			$key = array();
			foreach($user as $k=>$v){
				$text = $v['nickname'].'-'.$role[$v['roleid']];
				$key[$k]['id']         = $v['id'];
				$key[$k]['user_name']  = $v['nickname'];
				$key[$k]['pinyin']     = strtopinyin($text);
				$key[$k]['text']       = $text;
				$key[$k]['role']       = $v['roleid'];
				$key[$k]['role_name']  = $role[$v['roleid']];
			}
			
			$this->userkey =  json_encode($key);	
			
			$this->roles   =  get_roles();
			
			$this->display('op_pdca_auth');
		
		}
    }
    
    
}