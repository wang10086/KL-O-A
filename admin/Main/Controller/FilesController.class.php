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
		
		$db = M('files');
		
		//定义配置
		$this->type            = array('0'=>'文件夹','1'=>'文档');
		
		//取参
		$this->pid             = I('pid',0);
		
		//查询条件
		$where = array();
		$where['pid']          = $this->pid;
		
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
			
			
			
			if(!$db->where($data)->find()){
				
				$data['est_time']    = time();
				$data['est_user']    = cookie('name');
				$data['est_user_id'] = cookie('userid');
				$data['level']       = $level;
				$db->add($data);
				$this->success('创建成功！');
				
			}else{
				$this->error('创建失败，文件夹已存在');
			}
			
			
        }else{
            $this->success('创建失败！');
        }
        
        
    }
    
	
	
	
	// @@@NODE-3###addres###上传界面###
    public function upload(){
		
		$this->pid    = I('pid',0);
		$this->level  = I('level',1);
		
		$this->display('upload');
  
	}
 	
	
	// @@@NODE-3###addres###保存上传文件###
	public function savefile(){
		
		$db = M('files');
		 
		$filename   = I('filename','');
		$fileid     = I('fileid',0);
		$pid        = I('pid',0);
		$level      = I('level',1);
		
		$files      = I('files','');
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
				$data['level']         = $v['level'];
				
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
			
			die(return_success());
		}else{
			die(return_error(P::NOT_UPLOAD_DATA));
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
			die(return_error(P::NOT_UPLOAD_DATA));
		}
	}
	
	
	// @@@NODE-3###addres###打开权限配置界面###
	public function authfile(){
		
		$this->roles =  M('role')->where('id>3')->select();
		
		$this->users =  M('account')->where('id>10')->order('id ASC')->select();
			
		$this->display('authfile');
	}
	
	
	
	
    
}