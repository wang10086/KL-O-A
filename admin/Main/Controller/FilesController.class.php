<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Finance###文件管理###
class FilesController extends BaseController {
    
    protected $_pagetitle_ = '文件管理';
    protected $_pagedesc_  = '';
    
	
    // @@@NODE-3###accounting###单团核算列表###
    public function index(){
        $this->title('文件管理');
		
		$db                     = M('files');
        $filename               = I('filename');
		
		//定义配置
		$this->type             = array('0'=>'文件夹','1'=>'文档');
		
		//取参
		$this->pid              = I('pid',0);
		
		//查询条件
		$where = array();
		$where['pid']           = $this->pid;
        if ($filename) $where['file_name'] = array('like','%'.$filename.'%');
		
		//权限识别
		/*
		if (C('RBAC_SUPER_ADMIN') != cookie('userid')){
			
			$userid = cookie('userid');
			$roleid = cookie('roleid');
			
			$where['_string'] = ' (auth_group like "%'.$roleid.'%")  OR ( auth_user like "%'.$userid.'")   OR ( est_user_id = '.$userid.') ';
				
		}
		*/
		
		//获取上级目录级别
		if($this->pid){
			$upfile = $db->find($this->pid);
			if(!$upfile || $upfile['file_type']){
				$this->error('目录不存在');
				die();
			}
			if($upfile)   $this->level = $upfile['level']+1;
		}else{
			$this->level  = 1;	
		}
		
		$datalist = $db->where($where)->order($this->orders('file_type'))->select();
		foreach($datalist as $k=>$v){
			$datalist[$k]['file_type']	 = $this->type[$v['file_type']];
			if($v['file_type']==0){
				$datalist[$k]['url']         = U('Files/index',array('pid'=>$v['id']));
				$datalist[$k]['target']      = '';
			}else{
				$datalist[$k]['url']         = $v['file_path'];
				$datalist[$k]['target']      = 'target="_blank"';
			}
		}
		
		$this->datalist = $datalist;
		
		//文件路径
		$this->dir_path = array();	
		if($this->pid) $this->dir_path = file_dir($this->pid); 
		
		
		$this->display('index');
    }
	

	// @@@NODE-3###addres###创建文件夹###
    public function mkdirs(){
        $this->title('创建文件夹');
        
        $db = M('files');

        if(isset($_POST['dosubmit'])){
        	
			$level    = I('level');
            $pid      = I('pid');
            $filename = I('filename');
			
			
			//判断文件夹是否存在
			$data = array();
			$data['pid']          = $pid;
			$data['file_name']    = $filename;
			
			//重复文件修正文件名
			if($db->where($data)->find()){
				$data['file_name']    = $filename.'_'.rand(1000,9999);
			}
			
			//整理数据
			$data['est_time']    = time();
			$data['est_user']    = cookie('name');
			$data['est_user_id'] = cookie('userid');
			
			//继承父级目录权限
			if($pid){
				$p_file = $db->find($pid);
				$data['auth_group']      = $p_file['auth_group'];
				$data['auth_user']       = $p_file['auth_user'];
				$data['level']           = $p_file['level']+1;
			}else{
				$data['auth_group']      = '';
				$data['auth_user']       = '';
				$data['level']           = 1;	
			}
			
			
			$db->add($data);
			$this->success('创建成功！');
			
			
        }else{
            $this->success('创建失败！');
        }
        
        
    }
    

	// @@@NODE-3###addres###上传界面###
    public function upload(){
		
		$this->pid    = I('pid',0);
		$this->level  = I('level',1);
        $this->department   = M('salary_department')->getField('id,department',true);           //部门
        $this->posts        = M('posts')->where(array('post_name'=>array('neq','')))->select(); //岗位
        $this->file_tag     = C('FILE_TAG');

		$this->display('upload');
	}
 	
	
	// @@@NODE-3###addres###保存上传文件###
	public function savefile(){

		$db = M('files');
        $department = I('department');
        $posts      = I('posts');
        if ($department){
            foreach ($department as $k=>$v){
                $department[$k] = '['.$v.']';
            }
        }
        if ($posts){
            foreach ($posts as $k=>$v){
                $posts[$k] = '['.$v.']';
            }
        }

        $department = $department?implode(',',$department):'';
        $posts      = $posts?implode(',',$posts):'';
        $file_tag   = I('file_tag',0);
		$filename   = I('newname','');
		$fileid     = I('fileid',0);
		$pid        = I('pid',0);
		$level      = I('level',1);

        $files              = array();
        foreach ($fileid as $k=>$v){
            $files[$v]['level']     = $level[$k];
            $files[$v]['filename']  = $filename[$k];
            $files[$v]['fileid']    = $fileid[$k];
            $files[$v]['pid']       = $pid[$k];
        }

		if($files){
			foreach($files as $v){
				//查找数据
				$file = M('attachment')->find($v['fileid']);
				
				$data = array();
				$data['file_name']     = $v['filename'];
				$data['file_type']     = 1;
				$data['file_size']     = $file['filesize'];
				$data['file_ext']      = $file['fileext'];
				$data['file_path']     = $file['filepath'];
				$data['file_id']       = $v['fileid'];
				$data['est_time']      = time();
				$data['est_user']      = cookie('name');
				$data['est_user_id']   = cookie('userid');
				$data['pid']           = $v['pid'];
                $data['department']    = $department;
                $data['posts']         = $posts;
                $data['file_tag']      = $file_tag;
				
				//继承父级目录权限
				if($v['pid']){
					$p_file = $db->find($v['pid']);
					$data['auth_group']      = $p_file['auth_group'];
					$data['auth_user']       = $p_file['auth_user'];
					$data['level']           = $p_file['level']+1;
				}else{
					$data['auth_group']      = '';
					$data['auth_user']       = '';
					$data['level']           = 1;	
				}
			
				
				//判断文件夹是否存在,修正文件名
				$where = array();
				$where['pid']          = $v['pid'];
				$where['file_name']    = $v['filename'];
				if($db->where($where)->find()){
					$data['file_name']  = $v['fileid'].'_'.$v['filename'];
				}
				
				//保存
				$save = $db->add($data);
			}
			//die(return_success());
            //die(return_error(P::NOT_UPLOAD_DATA));

        }
		if ($save){
            $this->success("上传成功",U('Files/index'));
        }else{
            $this->error('请选择文件');
        }
		
		
	}
	
	
	// @@@NODE-3###addres###删除文件###
	public function delfile(){
		
		$db  = M('files');
		$fid = I('fid','');
		$fid = trim($fid,'.');
		
		$i   = 0;
		$ids = explode('.',$fid);
		if($ids){
			foreach($ids as $v){
				$iddel = $db->delete($v);
				if($iddel) $i++;
			}	
		}
		
		if($i){
			die(return_success());
		}else{
			die(return_error(P::NOT_DEL_FILE_DATA));
		}
			
	}
	
	
	// @@@NODE-3###addres###移动文件选择界面###
	public function movefile(){
		
		$this->fid   = I('fid','');
		
		//修正等级
		up_file_level(0);
		
		$datalist = getTree(0);
	
		foreach($datalist as $k=>$v){
			
			$datalist[$k]['tab']        = fortext($v['level']-1,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		}
		
		$this->datalist = $datalist;
			
		$this->display('movefile');
	}
	

	// @@@NODE-3###addres###移动文件###
	public function move(){
		
		$db = M('files');
		
		$files      = I('files','');
		
		if($files){
			
			$filelist = $files[0]['files'];
			$dir      = $files[0]['dir'];
			
			$dir_path = file_dir($dir);
			$dirid = array();
			foreach($dir_path as $k=>$v){
				$dirid[] = $v['id'];
			}
			
			$newlist  = array();
			$array    = explode('.',$filelist);
			foreach($array as $v){
				//判断目标路径是否在该路径下
				$in = in_array($v,$dirid);
				if($v && $v!=$dir && !$in){
					$newlist[] = $v;
				}
			}
			
			$move = implode(',',$newlist);
			
			$where = array();
			$where['id']  = array('in',$move);
			
			$data = array();
			$data['pid']    = $dir;
			
			$db->data($data)->where($where)->save();
			
			up_file_level($dir);
			
			die(return_success());
		}else{
			die(return_error(P::NOT_MOVE_FILES_DATA));
		}
	}
	
	
	// @@@NODE-3###addres###打开权限配置界面###
	public function authfile(){
		
		$this->fid   = I('fid','');	
		
		$this->roles = M('role')->where('id>3')->select();
		
		$this->users = M('account')->where('id>10')->order('id ASC')->select();
	
		$this->display('authfile');
	}
	

	// @@@NODE-3###auth###保存权限###
	public function auth(){
		
		$db = M('files');
		
		$files      = I('files','');
		
		if($files){
			$filelist	= $files[0]['files'];
			$rolse		= $files[0]['rolse'];
			$users   	= $files[0]['users'];
			
			
			$newlist  = array();
			$array    = explode('.',$filelist);
			foreach($array as $v){
				if($v){
					$newlist[] = $v;
				}
			}
			
			$move = implode(',',$newlist);
			
			$where = array();
			$where['id']  = array('in',$move);
			
			$data = array();
			$data['auth_group']    = $rolse;
			$data['auth_user']     = $users;
			
			$db->data($data)->where($where)->save();
			
			die(return_success());
		}else{
			die(return_error(P::NOT_AUTH_FILES_DATA));
		}
	}


    // @@@NODE-3###auth###编辑文件###
    public function upd_file(){
        $id         = I('id');
        $db         = M('files');
        $file       = $db->where(array('id'=>$id))->find();
        if ($file['file_type']=='0'){
            $this->error('不能直接编辑文件夹');
        }

        if (isset($_POST['dosubmit'])){
            $info               = I('info');
            $department         = I('department');
            $posts              = I('posts');

            if ($department){
                foreach ($department as $k=>$v){
                    $department[$k] = '['.$v.']';
                }
            }
            if ($posts){
                foreach ($posts as $k=>$v){
                    $posts[$k]  = '['.$v.']';
                }
            }

            $department         = $department?implode(',',$department):'';
            $posts              = $posts?implode(',',$posts):'';
            $info['department'] = $department;
            $info['posts']      = $posts;

            $res = $db->where(array('id'=>$id))->save($info);
            if ($res){
                $this->success('修改成功',U('Files/index',array('pid'=>$info['pid'])));
            }else{
                $this->error('数据保存失败');
            }

        }else{
            $this->pid          = I('pid',0);
            $this->level        = I('level',1);
            $this->department   = M('salary_department')->getField('id,department',true);           //部门
            $this->file_tag     = C('FILE_TAG');

            $file['department'] = str_replace('[','',$file['department']);
            $file['department'] = str_replace(']','',$file['department']);
            $file['posts']      = str_replace('[','',$file['posts']);
            $file['posts']      = str_replace(']','',$file['posts']);
            $file['department'] = explode(',',$file['department']);
            $file['posts']      = explode(',',$file['posts']);
            $this->file         = $file;
            $this->posts        = M('posts')->where(array('departmentid'=>array('in',$file['department'])))->select();
            $arr_departmentid   = $file['department'];
            $departmentids      = array();
            foreach ($arr_departmentid as $k=>$v){
                $departmentids[]= '['.$v.'],';
            }
            $this->departmentids= implode('',$departmentids);

            $this->display();
        }
    }
	
    
}