<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###ScienceRes###科普资源管理###
class ScienceResController extends BaseController {
    
    protected $_pagetitle_ = '科普资源管理';
    protected $_pagedesc_  = '录入、修改、删除科普资源数据';
     
    // @@@NODE-3###res###科普资源列表###
    public function res () {
        $this->title('科普资源');
		
		$key          = I('key');
		$type         = I('type');
		$pro          = I('pro');
		
		$where = array();
		$where['1'] = priv_where(P::REQ_TYPE_SCIENCE_RES_V);
		if($key)      $where['title'] = array('like','%'.$key.'%');
		if($type)     $where['kind'] = $type;
		if($pro)      $where['business_dept'] = array('like','%'.$pro.'%');
		
		//分页
		$pagecount = M('cas_res')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->reskind = M('reskind')->getField('id,name', true);
		$this->kinds = M('project_kind')->getField('id,name');
        $this->lists = M('cas_res')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->display('res');
    
    }
	
	
	// @@@NODE-3###res_view###科普资源详情###
    public function res_view () {
        $this->title('科普资源');
		
		$id = I('id',0);

        $this->reskind = M('reskind')->getField('id,name', true);
        $row = M('cas_res')->find($id);
		
		if($row){
			$where = array();
			$where['req_type'] = P::REQ_TYPE_SCIENCE_RES_NEW;
			$where['req_id']   = $id;
			$audit = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show = '未审批';
				$show_user = '未审批';
				$show_time = '等待审批';
			}else if($audit['dst_status']==1){
				$show = '已通过';
				$show_user = $audit['audit_uname'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show = '未通过';
				$show_user = $audit['audit_uname'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$row['showstatus'] = $show;
			$row['show_user']  = $show_user;
			$row['show_time']  = $show_time;
		}else{
			$this->error('资源不存在' . $db->getError());	
		}
		$this->row = $row;
		
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->display('res_view');
    
    }
    
    
    // @@@NODE-3###delres###删除科普资源###
    public function delres(){
        $this->title('删除科普资源');
        $db = M('cas_res');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }
    
    // @@@NODE-3###addres###新建科普资源###
    public function addres(){
        $this->title('新建/修改科普资源');
        
        $db = M('cas_res');
        $id = I('id', 0);

        if(isset($_POST['dosubmit'])){
        
            $info  = I('info');
            $referer = I('referer');
			$business_dept = I('business_dept');
			$info['content'] = stripslashes($_POST['content']);
			$info['business_dept'] = implode(',',array_unique($business_dept));
			
            if(!$id){
				$info['input_user'] = session('userid');
				$info['input_uname'] = session('nickname');
				$info['input_time']  = time();
                $isadd = $db->add($info);
                if($isadd) {
                    $this->request_audit(P::REQ_TYPE_SCIENCE_RES_NEW, $isadd);
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',$referer);
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
            $this->kinds = M('reskind')->where(array('type'=>P::RES_TYPE_SCIENCE))->select();
            
            if (!$id) {
                $this->row = false;
            } else {
                $this->row = $db->find($id);
				$depts = explode(',',$this->row['business_dept']);
				$kinds = M('project_kind')->getField('id,name');
				$deptlist = array();
				foreach($depts as $k=>$v){
					if($kinds[$v]){
						$deptlist[$k]['id'] = $v;
						$deptlist[$k]['name'] = $kinds[$v];
					}
				}
				
				$this->deptlist = $deptlist;
                if (!$this->row) {
                    $this->error('无此数据！', U('ScienceRes/res'));
                }
            }
            $this->display('addres');
        }
        
        
    }
    
    
    // @@@NODE-3###reskind###科普资源分类列表###
    public function reskind () {
        $this->title('科普资源分类');
        $where = array('type' => P::RES_TYPE_SCIENCE);
        
        $this->lists = M('reskind')->where($where)->select();
        
        $this->display('reskind');
        
    }
    
    
    // @@@NODE-3###addreskind###添加科普资源分类###
    public function addreskind () {
        $this->title('添加/修改科普资源分类');
        $where = array('type' => P::RES_TYPE_SCIENCE);
    
        $db = M('reskind');
        
        $pid  = I('pid', 0);
        
        $id = I('id',0);
        if ($pid <= 0) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = '顶级分类';
        
        } else {
            $father = M('reskind')->find($pid);
        }
        
        
        $this->father = $father;
        
        if(isset($_POST['dosubmit'])){
        
            $info = I('info','');
            $info['level'] = 1;
            $info['pid'] = 0;
            
            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('ScienceRes/reskind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('ScienceRes/reskind'));
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
        
            if (!$id) {
                $this->row = false;
            } else {
                $this->row = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('ScienceRes/reskind'));
                }
            }
            $this->display('addreskind');
        }
    
    }
    
    
    // @@@NODE-3###delreskind###删除科普资源分类###
    public function delreskind(){
        $this->title('删除科普资源分类');
        $db = M('reskind');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }
    
    
 
    

    
    
}