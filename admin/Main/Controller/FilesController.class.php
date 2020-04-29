<?php
namespace Main\Controller;
//use Think\Controller;
use Think\Upload;
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
        $filename               = trim(I('filename'));

		//定义配置
		$this->type             = array('0'=>'文件夹','1'=>'文档');

		//取参
		$this->pid              = I('pid',0);

		//查询条件
		$where = array();
        if ($filename){
            $where['file_name'] = array('like','%'.$filename.'%'); //文件搜索不受文件夹限制
        }else{
            $where['pid']       = $this->pid;
        }

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
			$datalist[$k]['file_types']	 = $this->type[$v['file_type']];
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
		$this->dir_ids              = implode(',',$db->where(array('file_type'=>0))->getField('id',true));

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

		$this->pid          = I('pid',0);
		$this->level        = I('level',1);
        $this->department   = M('salary_department')->getField('id,department',true);           //部门
        $this->posts        = M('posts')->where(array('post_name'=>array('neq','')))->select(); //岗位
        $this->file_tag     = C('FILE_TAG');

		$this->display('upload');
	}


	// @@@NODE-3###addres###保存上传文件###
	public function savefile(){

		$db                     = M('files');
        $department             = I('department');
        $posts                  = I('posts');
        $file_tag               = I('file_tag','');

        if ($department){
            foreach ($department as $k=>$v){
                $department[$k] = '['.$v.']';
            }
        }
        if ($posts){
            foreach ($posts as $k=>$v){
                $posts[$k]      = '['.$v.']';
            }
        }
        if ($file_tag){
            foreach ($file_tag as $k=>$v){
                $file_tag[$k]   = '['.$v.']';
            }
        }

        $department = $department?implode(',',$department):'';
        $posts      = $posts?implode(',',$posts):'';
        $file_tag   = $file_tag ? implode(',',$file_tag) : '';
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

		$this->users = M('account')->where(array('id'=>array('gt',10),'status'=>0))->order('id ASC')->select();

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

        if (isset($_POST['dosubmit'])){
            $info               = I('info');
            $department         = I('department');
            $posts              = I('posts');
            $file_tag           = I('file_tag');

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
            if ($file_tag){
                foreach ($file_tag as $k=>$v){
                    $file_tag[$k] = '['.$v.']';
                }
            }

            $department         = $department?implode(',',$department):'';
            $posts              = $posts?implode(',',$posts):'';
            $file_tag           = $file_tag ? implode(',',$file_tag): '';
            $info['department'] = $department;
            $info['posts']      = $posts;
            $info['file_tag']   = $file_tag;

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
            $file['department'] = array_filter(explode(',',$file['department']));
            $file['posts']      = array_filter(explode(',',$file['posts']));
            $this->file         = $file;
            $this->tags         = explode(',',$file['file_tag']);
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

    //编辑文件夹
    public function edit_dir(){
        $db                         = M('files');
        if (isset($_POST['dosubmint'])){
            $id                     = I('id');
            $file_name              = trim(I('file_name'));
            if (!$id || !$file_name){
                if (!$id) $msg      = '获取数据失败';
                if (!$file_name) $msg = '文件夹名称不能为空';
                $this->msg          = $msg;
                $this->display("Index:public_audit");
            }
            $res                    = $db->where(array('id'=>$id))->setField('file_name',$file_name);
            $msg                    = $res ? '保存成功' : '保存数据失败';
            $this->msg              = $msg;
            $this->display("Index:public_audit");
        }else{
            $id                     = I('id');
            if (!$id){ $this->error('获取数据失败'); }
            $list                   = $db->find($id);
            $this->list             = $list;
            $this->display();
        }
    }

    //复制文件
    public function copyfile(){
        $db                         = M('files');
        $fid                        = I('fid','');
        $num                        = 0;
        if ($fid){
            $list                   = $db->where(array('id'=>$fid))->find();
            unset($list['id']);
            $list['est_time']       = NOW_TIME;
            $res                    = $db->add($list);
            if ($res){
                $num++;
                $msg                = '复制成功';
            }else{
                $msg                = '复制失败';
            }
        }else{
            $msg                    = '获取数据失败';
        }
        $data                       = array();
        $data['num']                = $num;
        $data['msg']                = $msg;
        $this->ajaxReturn($data);
    }

    //文件审批
    public function audit_list(){
        $this->title('文件审批');

        $db                     = M('process_files');
        $pagecount              = $db->count();
        $page                   = new Page($pagecount,P::PAGE_SIZE);
        $this->pages            = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->lists            = $db->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

        $this->status           = $this->get_audit_status();
        $this->display();
    }

    //新增待审批文件
    public function public_audit_add(){
        $this->title('新增文件');

        $id                         = I('id',0);
        if ($id) {
            $db                     = M('process_files');
            $list                   = $db->where(array('id'=>$id))->find();
            $this->row              = $list;
            $this->typeInfo         = M('approval_file_type')->where(array('pid'=>$list['type']))->select();
            $file                   = M('attachment')->where(array('id'=>$list['atta_id']))->find();
            $file['newFileName']    = $list['filename'];
            $this->file             = $file;
        }
        $this->timeType             = C('timeType');
        $this->userkey              = get_username();
        //$this->types                = M('approval_file_type')->where(array('pid'=>0))->select();
        $this->types                = M('approval_file_type')->where(array('pid'=>0,id=>array('gt',1)))->select();


        $this->display('audit_add');
    }

    private function get_audit_status(){
        $status                 = array(
            0                   => "<span>未提交审核</span>",
            1                   => "<span class='green'>审核通过</span>",
            2                   => "<span class='red'>审核不通过</span>",
            3                   => "<span class='yellow'>已提交,未审核</span>",
        );
        return $status;
    }

    //详情/审核
    public function audit(){
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $db                         = M('process_files');
        $this->list                 = $db->where(array('id'=>$id))->find();
        $this->typelists            = M('approval_file_type')->getField('id,title',true);
        $this->status               = $this->get_audit_status();
        $this->timeType             = C('timeType');
        /*$file                   = M('attachment')->where(array('id'=>$list['atta_id']))->find();
        $file['newFileName']    = $list['filename'];
        $this->file             = $file;*/
        $this->display();
    }

    public function audit_del(){
        $id                         = I('id');
        if (!$id){ $this->error('数据错误'); }
        $db                         = M('process_files');
        $res                        = $db->where(array('id'=>$id))->delete();
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    public function public_save(){
        $saveType                   = I('saveType');
        $num                        = 0;
        if (isset($_POST['dosubmint'])){ //保存待审核文件信息
            if ($saveType == 1){
                $db                     = M('process_files');
                $id                     = I('id',0);
                $info                   = I('info');
                $newname                = I('newname',array());
                $fileurl                = I('fileurl');
                $fileNum                = count($newname);
                $returnMsg              = array();
                $returnMsg['num']       = $num;
                if (!$info['audit_user_id']){ $msg = '文件审核人员信息错误'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                if ($fileNum < 1){ $msg = '请至少上传一个文件'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                if ($fileNum > 1){ $msg = '请上传一个文件'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                if (!$info['type'] || !$info['typeInfo']){ $msg = '文件类型信息错误'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                $data                   = array();
                $data['type']           = $info['type'];
                $data['typeInfo']       = $info['typeInfo'];
                $data['year']           = $info['year'];
                $data['timeType']       = $info['timeType'];
                $data['content']        = trim($info['content']);
                $data['create_time']    = NOW_TIME;
                $data['create_user_name'] = session('nickname');
                $data['create_user_id'] = session('userid');
                $data['audit_user_id']  = $info['audit_user_id'];
                $data['audit_user_name']= $info['audit_user_name'];
                foreach ($newname as $k=>$v){
                    $data['filename']   = trim($v);
                    $data['filepath']   = $fileurl[$k];
                    $data['atta_id']    = $k;
                    if ($id){
                        $res            = $db->where(array('id'=>$id))->save($data);
                    }else{
                        $res            = $db->add($data);
                        $id             = $res;
                    }
                }

                if ($res) $num++;
                $msg                    = $num > 0 ? '保存成功' : '保存失败';
                $returnMsg['num']       = $num;
                $returnMsg['msg']       = $msg;
                $this->ajaxReturn($returnMsg);
            }

            if ($saveType == 2){
                $id                     = I('id');
                if (!$id) $this->error('请先保存文件信息');
                $db                     = M('process_files');
                $list                   = $db->where(array('id'=>$id))->find();
                $save                   = array();
                $save['audit_status']   = 3; //已提交,未审核
                $db->where(array('id'=>$list['id']))->save($save);
                if ($list){ //发送系统消息
                    $typeId             = $list['typeInfo'] ? $list['typeInfo'] : $list['type'];
                    $this->set_submit_file_ok($typeId); //更改系统消息状态

                    $uid     = cookie('userid');
                    $title   = '您有来自['.session('nickname').']的文件待审核!';
                    $content = '文件名称:$list[\'filename\']';
                    $url     = U('Files/audit',array('id'=>$id));
                    $user    = '['.$data['audit_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');
                }
                $this->success('提交成功',U('Files/audit_list'));
            }

            if ($saveType == 3){ //保存审核文件信息
                $id                     = I('id');
                $audit_status           = I('audit_status');
                $audit_msg              = I('audit_msg');
                $returnMsg              = array();
                $returnMsg['num']       = $num;
                if (!$id){ $msg = '数据错误'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                if (!$audit_status){ $msg = '审核信息错误'; $returnMsg['msg'] = $msg; $this->ajaxReturn($returnMsg); }
                $data                   = array();
                $data['audit_status']   = $audit_status;
                $data['audit_msg']      = trim($audit_msg);
                $data['audit_time']     = NOW_TIME;
                $db                     = M('process_files');
                $res                    = $db->where(array('id'=>$id))->save($data);
                $list                   = $db->where(array('id'=>$id))->find();
                if ($res){
                    $num++;
                    if ($list['type'] >= 5 && $audit_status == 1){ //直接上传文件至文件管理->****文件夹
                        save_file_data($id);
                    }
                }
                $msg                    = $num > 0 ? '数据保存成功' : '数据保存失败';
                $returnMsg['num']       = $num;
                $returnMsg['msg']       = $msg;
                $this->ajaxReturn($returnMsg);
            }
        }
    }

    public function set_submit_file_ok($typeId=0){
        if ($typeId){
            $processId                  = M('approval_file_type')->where(array('id'=>$typeId))->getField('process_id');
            $submit_file_node_ids       = C('process_submit_file_node_id'); ////提交文件即触发完成的node_id
            $where                      = array();
            $where['p_id']              = $processId;
            $where['pnode_id']          = array('in',$submit_file_node_ids);
            $save                       = array();
            $save['del_status']         = '-1';
            M('process_log')->where($where)->save($save);
        }
    }
}
