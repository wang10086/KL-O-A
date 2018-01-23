<?php
namespace Main\Controller;
use Think\Controller;
use Think\Model;
ulib('Page');
use Sys\Page;
use Think\Upload;

class AttachmentController extends Controller {
	
    public function index() {
		//import ('ORG.Util.Page');
        $db = M('attachment');
		$catid = I('catid', 0);
        
		$wheres = "`isimage` = 1 and userid=" .  session('userid');
        if ($catid != 0) {
            $wheres .= " and catid=$catid";
        }
		$page = new Page($db->where($wheres)->count(), 20);
		$this->pages = $page->show();
		$this->images = $db->where($wheres)->order('uploadtime desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->catid = $catid;
		$this->display('index');
    }
	
	public function not_use() {
		//import ('ORG.Util.Page');
        $db = M('attachment');
		
		$wheres = "`isimage` = 1 and `releid` = 0  and userid=" .  session('userid');
		$page = new Page($db->where($wheres)->count(), 20);
		$this->pages = $page->show();
		$this->images = $db->where($wheres)->order('uploadtime desc')->limit($page->firstRow . ',' . $page->listRows)->select();
		$this->display('index');
		
	}
	
	public function delete() {
	    $id = I('aid', 0);
		if ($id == 0) 
		    $this->error('参数错误，非法操作！');
			
		$db = M('attachment');
		$rs = $db->find($id);
		if ($rs) {
		    $spath = $rs['filepath'];
			$fname = basename($spath);
			$dir = dirname($spath);
			$files = glob($dir . "/*" . $fname);
			foreach ($files as $f)
			    @unlink($f);
		    $db->delete($id);	
		}
		
		
	}
	
	public function setuse() {
	    $id = I('aid', 0);
		if ($id == 0) 
		    $this->error('参数错误，非法操作！');
			
		$db = M('attachment');
		$rs = $db->find($id);
		if ($rs) {
		    $rs['status'] = 1;
			$db->save($rs);	
		}
	}
	
	
	
	
	
	public function img_upload() {
		if (isset($_POST['dosubmit'])) {
			$upload = new Upload(C('UPLOAD_FILE_CFG'));
			$data = array();
			$data['userid'] = cookie('userid');
			$data['uploadtime'] = time();
			$data['uploadip'] = get_client_ip();
			$data['comid'] = cookie('comid');
			
			$db = M('attachment');
	       $rs = array();
			
           $info = $upload->upload();
			if($info){
				//$info = $upload->getUploadFileInfo();
                foreach ($info as $row) {
                    $data['filename'] = $row['name'];
                    $data['filepath'] = $upload->rootPath . $row['savepath'] . $row['savename'];
                    $data['filesize'] = $row['size'];
                    $data['fileext']  = $row['ext'];
                    $data['hashcode'] = $row['md5'];
					  if($row['ext']=='png' ||  $row['ext']=='gif' ||  $row['ext']=='jpg' ||  $row['ext']=='jpeg'){
					  	  $data['isimage']  = 1;
					  }else{
						  $data['isimage']  = 0;
					  }
                    $db->add($data);
                    break;
                }
				
				$rs['id'] = $db->getLastInsID();
				$rs['rs'] = 0;
				$rs['msg'] = '上传成功' ;
				if($data['fileext']=='png' ||  $data['fileext']=='gif' ||  $data['fileext']=='jpg' ||  $data['fileext']=='jpeg'){
					$rs['file_thumb'] = thumb($data['filepath']);
				}else{
					$rs['file_thumb'] = 'admin/assets/comm/upload/file/'.$data['fileext'].'.jpg';
				}
				$rs['file_path'] = $data['filepath'];
				echo json_encode($rs);
			}else{
				//专门用来获取上传的错误信息
				$rs['id'] = -1;
				$rs['rs'] = -1;
				$rs['msg'] = $upload->getError(); 
				$rs['file_thumb'] = '';
				$rs['file_path'] = '';
				echo json_encode($rs);        
			}  
		} else {
            $this->catid = I('catid',0);
			$this->display('upload');
		}
	}
	
	
	public function CKUpload() {
		if (isset($_GET['CKEditorFuncNum'])) {
		
		    $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
		    $type = I('type', 'file');
          
			$upload = new Upload(C('UPLOAD_FILE_CFG'));
			
			$data = array();
			$data['userid'] = cookie('userid');
			$data['uploadtime'] = time();
			$data['uploadip'] = get_client_ip();
			$data['comid'] = cookie('comid');
			
			$db = M('attachment');
	        $rs = array();
			$info = $upload->upload();
			if($info){
				//$info = $upload->getUploadFileInfo();
				foreach ($info as $row) {
                    $data['filename'] = $row['name'];
                    $data['filepath'] = $upload->rootPath . $row['savepath'] . $row['savename'];
                    $data['filesize'] = $row['size'];
                    $data['fileext']  = $row['ext'];
					  if($row['ext']=='png' ||  $row['ext']=='gif' ||  $row['ext']=='jpg' ||  $row['ext']=='jpeg'){
					  	   $data['isimage']  = 1;
					  }else{
						   $data['isimage']  = 0;
					  }
                    $data['hashcode'] = $row['md5'];
                    $db->add($data);
                    break;
                }
				$path = $data['filepath'];
				die("<script type=\"text/javascript\">
					    window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ",'" . $path . "','');
                        </script>");
			} else {
				
				die("<script type=\"text/javascript\">alert('". $upload->getError() ."');</script>");
			}
			
		}
    }
	
	
	
	public function upload_file ()
	{
		$db = M('attachment');
		$upload = new Upload(C('UPLOAD_FILE_CFG'));
		$info = $upload->upload();
		$att = array();
		$rs = array();

		if ($info) {
			foreach ($info as $row) {
				$rs['rs'] = 'ok';
				$rs['fileurl'] = $upload->rootPath . $row['savepath'] . $row['savename'];
				if (in_array( strtolower($row['ext']), array('jpg','jpeg','png','gif','bmp','svg'))) {
					// $rs['thumb']   = thumb($rs['fileurl'], C('DEFAULT_THUMB_W'), C('DEFAULT_THUMB_H'));
					$att['isimage'] = 1;
				} else {
					$att['isimage'] = 0;
				}

				$att['filesize']    = $row['size'];
				$att['fileext']     = $row['ext'];
				$att['filename']    = $row['name'];
				$att['filepath']    = $rs['fileurl'];
				//$att['catid']       = I('catid');
				$att['userid']      = session('userid');
				$att['uploadtime']  = time();
				$att['uploadip']    = get_client_ip();
				//$att['rel_id']      = 0;
				$att['hashcode']    = $row['md5'];

				$aid = $db->add($att);
				//P($db->GetLastSql());
				$rs['aid'] = $aid;
				$rs['ext'] = strtoupper($row['ext']);
				if($rs['ext']=='JPG' || $rs['ext']=='PNG' || $rs['ext']=='GIF'){
					$rs['thumb'] = thumb($rs['fileurl'],60,50);
				}else{
					$rs['thumb'] = '';
				}
				break;
			}

			echo json_encode($rs);

		} else {
			$rs['rs']  = 'err';
			$rs['msg'] = '上传失败';
			echo json_encode($rs);
		}
	}



	
}

?>       