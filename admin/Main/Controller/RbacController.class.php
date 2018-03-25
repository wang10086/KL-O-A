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
    	
		//更新角色列表
		update_userlist_role();
		
        $this->title('用户列表');
    
        $db = D('account');
       	$where = array();
		
		if(rolemenu(array('Rbac/adduser'))){
			$key      = I('key','');
			$role     = I('role',0);
			$post     = I('post',0);
			
			$where['status'] = array('neq',2);
			$where['id'] = array('gt',3);
			if($key)  $where['nickname'] = array('like','%'.$key.'%');
			if($role) $where['roleid']  = $role;
			if($post) $where['postid']  = $post;
		}else{
			$where['id'] = cookie('userid');
		}
		
		
		//分页
		$pagecount      = $db->where($where)->count();
		$page           = new Page($pagecount, P::PAGE_SIZE);
		$this->pages    = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
        $this->users    = $db->relation(true)->where($where)->order($this->orders('id'))->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$this->roles    = M('role')->GetField('id,role_name',true);
		$this->posts    = M('posts')->GetField('id,post_name',true);
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
			
			$info['entry_time']	= $info['entry_time'] ? strtotime($info['entry_time']) : 0;
			
            if(!$id){
				$passwordinfo		= password(I('password_1'));
				$info['password']	= $passwordinfo['password'];
				$info['encrypt']	= $passwordinfo['encrypt'];
                $info['input_time'] = time();
                $info['ip']			= get_client_ip();
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
			$this->posts =  M('posts')->GetField('id,post_name',true);
            	
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

    // @@@NODE-3###worder_auth###指定部门工单执行人###
    //如果部门只有一个人时, 不用指定 , 如果是多个人时需要指定
    public function worder_auth(){
        $this->title('工单执行人设置');
        $r_ids = M('role')->getField('id',true);
        //需要制定执行人的部门 (排除一个人的部门)
        foreach ($r_ids as $v){
            $list               = M('account')->where(array('roleid'=>$v,'status'=>0))->select();
            $count              = count($list);
            if ($count ==1){
                //如果该部门只有一个人时 , 工单执行人就是其本人 , 求当前人员的id , 并赋值
                $account_id     = M('account')->where(array('roleid'=>$v,'status'=>0))->getField('id');
                $data['worder_auth'] = $account_id;
                M('auth')->where(array('role_id'=>$v))->save($data);
            }
        }

        $roles =  get_roles();
        foreach($roles as $k=>$v){
            $auth = M('auth')->where(array('role_id'=>$v['id']))->find();
            $roles[$k]['worder'] = $auth ? '<span class="blue">'.username($auth['worder_auth']).'<span>' : '<font color="#999">未设置</font>';
        }

        $this->roles = $roles;
        $this->pages = '';
        $this->display('worder_auth');
    }

    // @@@NODE-3###pdca_auth###指定部门工单执行人###
    public function op_worder_auth() {
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
                    $w_name = M('account')->find($row['worder_auth']);
                    $row['worder_auth_name'] = $w_name['nickname'];
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

            $this->display('op_worder_auth');

        }
    }

	
	// @@@NODE-3###kpi_quota###KPI指标管理###
    public function kpi_quota(){
    
        $this->title('KPI指标管理');
    
        $db 	= M('kpi_config');
		$auto 	= I('auto');
		$where 	= array();
		
		if($auto==1){
			$where['id'] = array('not in',array(1,2,3,4,5,6,81,8,9,10,11,15,16,18,20,23,26,21,24,27,32,37,19,22,25,28,33,38,42,45,103,56,113,92,29,34,39,46,102,55,57,58,59,84,87,89,90,111,107,83,66,54,44,12,112,108,100,96,95,65,114,86,85,64,63,62));
		}else if($auto==2){
			$where['id'] = array('in',array(91,82,41,40,36,31,30));
		}
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
        $this->datalist = $db->where($where)->order($this->orders('id'))->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->display('kpi_quota');
    }
    
    
	
    // @@@NODE-3###add_quota###编辑指标###
    public function add_quota(){
    
        $this->title('编辑指标');
         
        $db = M('kpi_config');
    
        if(isset($_POST['dosubmit'])){
            	
            $info    = I('info','');
            $id      = I('editid',0);
			$referer = I('referer','');
			$info['create_time'] = time();
			
            if(!$id){
                $save = $db->add($info);
            }else{
                $save = $db->data($info)->where(array('id'=>$id))->save();
            }
			if($save){
				$this->success('保存成功！',$referer);
			}else{
				$this->error('保存失败！',$referer);
			}
			 
            	
        }else{
            $id = I('id', 0);
            if($id) $this->row = $db->find($id);
            $this->display('add_quota');
        }
    }
    
	
	public function del_quota() {
        $db = M('kpi_config');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！', U('Rbac/kpi_quota'));
    }
	
	
	
	
	 // @@@NODE-3###rolequto###选择角色适用KPI指标范围###
    public function rolequto() {
        $this->title('选择KPI考核指标');
        if (isset($_POST['dosubmit'])) {
    
            $quto    = I('quto');
            $postid  = I('postid');
         	$referer = I('referer','');
			//删除
			$iddel = M('kpi_post_quota')->where(array('postid'=>$postid))->delete();
            foreach($quto as $k=>$v){
				$data = array();
				$data['postid']	 = $postid;
				$data['quotaid']	 = $v;
				M('kpi_post_quota')->add($data);
			}
			
			$this->success('已成功保存！',$referer);
            	
        } else {
            $postid = I('postid');
            if (!$postid) $this->error('非法操作！', U('Rbac/post'));
            $this->postid = $postid;
            	
            $post = M('posts')->find($postid);
            $this->postname = $post['post_name'];
			
			
			$selected = M('kpi_post_quota')->where(array('postid'=>$postid))->select();
            if($selected){
				$sel = array();
				foreach($selected as $k=>$v){
					$sel[] = $v['quotaid'];
				}	
				$this->sel = $sel;
			}
            	
            $this->datalist  = M('kpi_config')->select();
            $this->display('rolequto');
        }
    }
	
	
	
	// @@@NODE-3###post###岗位管理###
    public function post(){
    
        $this->title('岗位管理');
    
        $db = M('posts');
       
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
        $this->datalist = $db->where($where)->order($this->orders('id'))->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->display('post');
    }
    
	
	// @@@NODE-3###addpost###编辑岗位###
    public function addpost(){
    
        $this->title('编辑指标');
         
        $db = M('posts');
    
        if(isset($_POST['dosubmit'])){
            	
            $info    = I('info','');
            $id      = I('editid',0);
			$referer = I('referer','');
			
			
            if(!$id){
                $save = $db->add($info);
            }else{
                $save = $db->data($info)->where(array('id'=>$id))->save();
            }
			if($save){
				$this->success('保存成功！',$referer);
			}else{
				$this->error('保存失败！',$referer);
			}
			 
            	
        }else{
            $id = I('id', 0);
            if($id) $this->row = $db->find($id);
            $this->display('addpost');
        }
    }
	
	
	// @@@NODE-3###kpi_users###配置KPI数据###
	public function kpi_users(){
		$this->title('配置KPI目标数据');
		
		$db  = M('account');
		$key      = I('key','');
		$role     = I('role',0);
		$post     = I('post',0);
		
		$where = array();
		$where['status'] = array('neq',2);
		$where['id'] = array('gt',3);
		if($key)  $where['nickname'] = array('like','%'.$key.'%');
		if($role) $where['roleid']  = $role;
		if($post) $where['postid']  = $post;
		
		
		$pagecount   = $db->where($where)->count();
		$page        = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
		
		$role = M('role')->GetField('id,role_name',true);
		
		$userlist = $db->where($where)->order($this->orders('id'))->limit($page->firstRow . ',' . $page->listRows)->select();
		foreach($userlist as $k=>$v){
			$userlist[$k]['rolename'] = $role[$v['roleid']];	
		}
		$this->userlist = $userlist;
		$this->postlist = M('posts')->GetField('id,post_name',true);
		$this->roles    = M('role')->GetField('id,role_name',true);
		$this->posts    = M('posts')->GetField('id,post_name',true);
		$this->pid      = $post;
		$this->display('kpiuser');
	}
	
	
	
	// @@@NODE-3###kpi_data###配置KPI数据###
	public function kpi_data(){
		$this->title('配置KPI目标数据');
         
       $id    = I('id');
		
		$year  = I('year',date('Y'));
		$month = I('month',date('m'));
		$user  = I('uid',cookie('userid'));
		
		
		$sta   = C('KPI_STATUS');
		
		if($id){
			$kpi   = M('kpi')->where($where)->find($id);
			$year  = $kpi['year'];
			$month = ltrim(substr($kpi['month'],4,2),0);
			$user  = $kpi['user_id'];
		}else{
			$where = array();
			$where['month']   = $year.sprintf('%02s', $month);
			$where['user_id'] = $user;
			$kpi = M('kpi')->where($where)->find();
		}
		
		
		
		$kpi['kaoping']      = $kpi['mk_user_id'] ? username($kpi['mk_user_id']) : '未评分'; 	
		$kpi['score']        = $kpi['score'] ? $kpi['score'].'分' : '未评分'; 	
		$kpi['status_str']   = $sta[$kpi['status']]; 	
		
		//考核指标
		$lists = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->select();
		foreach($lists as $K=>$v){
			$lists[$K]['score']  = $v['score_status'] ?  $v['score']  : '<font color="#999">未评分</font>';
		}
		
		//审核记录
		$applist          = M('kpi_op_record')->where(array('kpi_id'=>$kpi['id']))->order('op_time DESC')->select();
		
		//用户信息
		$post             = M('posts')->GetField('id,post_name',true);
		$userinfo             = M('account')->find($user);
		$userinfo['postname'] = $userinfo['postid'] ? $post[$userinfo['postid']] : '<span class="red">未配置岗位</span>';
		
		$this->user       = $userinfo;
		$this->uid        = $user;
		$this->year       = $year;
		$this->month      = $month;
		$this->kpi        = $kpi;
		$this->lists      = $lists;
		$this->applist    = $applist;
		$this->prveyear   = $year-1;
		$this->nextyear   = $year+1;
		$this->allmonth   = $year.sprintf('%02s', $month);
        
		$this->display('kpidata');
	}
	
	// @@@NODE-3###save_kpi_data###保存KPI指标数据###
	public function save_kpi_data(){
		$id = I('id','');
		
		if(isset($_POST['dosubmint'])){
			$info = I('info');
			foreach($info as $k=>$v){
				
				//获取原记录
				$kpi = M('kpi_more')->find($k);
				
				//保存新数据
				$v['start_date'] = strtotime($v['start_date']);
				$v['end_date']   = strtotime($v['end_date']);
				M('kpi_more')->data($v)->where(array('id'=>$k))->save();
				
				//保存更新记录
				$remarks = '';
				if($v['start_date']!=$kpi['start_date']) $remarks.='考核开始日期由'.date('Y-m-d',$kpi['start_date']).'变更为'.date('Y-m-d',$v['start_date']).'；';
				if($v['end_date']!=$kpi['end_date'])  	$remarks.='考核结束日期由'.date('Y-m-d',$kpi['end_date']).'变更为'.date('Y-m-d',$v['end_date']).'；';
				if($v['plan']!=$kpi['plan'])  			$remarks.='计划由'.$kpi['plan'].'变更为'.$v['plan'].'；';
				if($v['target']!=$kpi['target'])  		$remarks.='目标由'.$kpi['target'].'变更为'.$v['target'].'；';
				if($v['weight']!=$kpi['weight'])  		$remarks.='权重由'.$kpi['weight'].'变更为'.$v['weight'].'；';
				
				
				if($remarks){
					$data = array();
					$data['kpi_id']        = $kpi['kpi_id'];
					$data['op_user_id']    = cookie('userid');
					$data['op_user_name']  = cookie('name');
					$data['op_time']       = time();
					$data['remarks']       = $kpi['quota_title'].'：'.$remarks;
					M('kpi_op_record')->add($data);
				}
				
			}
		}
		
		$this->success('保存成功！');
		
	}
	
    
	
	// @@@NODE-3###del_kpi_data###删除考核指标###
	public function del_kpi_data(){
		$id = I('id','');
		
		M('kpi_more')->delete($id);
		
		
		$this->success('删除成功！');
		
	}
}