<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###SupplierRes###合格供方管理###
class SupplierResController extends BaseController {
    
    protected $_pagetitle_              = '合格供方管理';
    protected $_pagedesc_               = '录入、修改、删除合格供方资源数据';
     
    // @@@NODE-3###res###合格供方列表###
    public function res() {
        $this->title('合格供方');
        $pin                            = I('pin') ? I('pin') : 0 ;
		$key                            = trim(I('key'));
		$type                           = trim(I('type'));
		$city                           = trim(I('city'));
		
		$where                          = array();
		$where['1']                     = priv_where(P::REQ_TYPE_SUPPLIER_RES_V);
        //if ($pin)  $where['']           = '';
		if ($key)  $where['name']       = array('like','%'.$key.'%');
		if ($type) $where['kind']       = $type;
		if ($city) $where['city']       = array('like','%'.$city.'%');
		
		//分页
		$pagecount                      = M('supplier')->where($where)->count();
		$page                           = new Page($pagecount, P::PAGE_SIZE);
		$this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->reskind                  = M('supplierkind')->getField('id,name', true);
        $this->lists                    = M('supplier')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
            P::AUDIT_STATUS_PASS        => '已通过',
            P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
            P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->pin                      = $pin;
        $this->display('res');
    
    }
	
	
	// @@@NODE-3###res_view###合格供方详情###
    public function res_view () {
        $this->title('合格供方');
		
		$id = I('id',0);
		$where = array('type' => P::RES_TYPE_SUPPLIER);

        $this->reskind = M('supplierkind')->getField('id,name', true);
        $row = M('supplier')->find($id);
		
		if($row){
			$where = array();
			$where['req_type'] = P::REQ_TYPE_SUPPLIER_RES_NEW;
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
			$this->error('产品模板不存在' . $db->getError());	
		}
		$this->row = $row;
		
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
		
		if(I('viewtype')){
			$this->display('res_view_win');
		}else{
       		$this->display('res_view');
		}
    
    }
    
    
    // @@@NODE-3###delres###删除合格供方###
    public function delres(){
        $this->title('删除合格供方');
        $db = M('supplier');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }
    
    // @@@NODE-3###addres###新建合格供方###
    public function addres(){
        $this->title('新建/修改合格供方');
        $db                             = M('supplier');
        $id                             = I('id', 0);

        if(isset($_POST['dosubmit'])){
            $info                       = I('info');
            $referer                    = I('referer');
            $info['name']               = trim($info['name']);
            $info['country']            = trim($info['country']);
            $info['prov']               = trim($info['prov']);
            $info['city']               = trim($info['city']);
            $info['contact']            = trim($info['contact']);
            $info['tel']                = trim($info['tel']);
            $info['desc']               = stripslashes($_POST['content']);

            if (!$info['name'])         $this->error('供方名称不能为空!');      
            if (!$info['country'])      $this->error('供方国家不能为空!');
            if (!$info['kind'])         $this->error('供方分类不能为空!');
            if (!$info['prov'])         $this->error('供方省份不能为空!');
            if (!$info['city'])         $this->error('供方所在城市不能为空!');
            if (!$info['contact'])      $this->error('供方联系人不能为空!');
            if (!$info['tel'])          $this->error('供方联系电话不能为空!');
            //if (!$info['desc'])         $this->error('供方介绍不能为空!');
			
            if(!$id){
				$info['input_uid']      = session('userid');
				$info['input_uname']    = session('nickname');
                $info['input_time']     = time(); 
                $info['audit_status']   = 1; //不用审核
                $isadd                  = $db->add($info);
                if($isadd) {
                    //$this->request_audit(P::REQ_TYPE_SUPPLIER_RES_NEW, $isadd);
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit                 = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',$referer);
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
            $where                      = array();
            $where['type']              = P::RES_TYPE_SUPPLIER;
            $where['id']                = array('not in',array(2,6)); //排除专家辅导员 和 研究所台站
            $this->kinds                = M('supplierkind')->where($where)->select();

            if (!$id) {
                $this->row              = false;
            } else {
                $this->row              = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('SupplierRes/res'));
                }
            }
            $this->display('addres');
        }
        
        
    }
    

    // @@@NODE-3###reskind###合格供方分类列表###
    public function reskind () {
        $this->title('合格供方分类');
        $where = array('type' => P::RES_TYPE_SUPPLIER);
        
        $this->lists = M('supplierkind')->where($where)->select();
        
        $this->display('reskind');
        
    }
    
    
    // @@@NODE-3###addreskind###添加合格供方分类###
    public function addreskind () {
        $this->title('添加/修改合格供方分类');
        $where = array('type' => P::RES_TYPE_SUPPLIER);
    
        $db = M('supplierkind');
        
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
                    $this->success('添加成功！',U('SupplierRes/reskind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('SupplierRes/reskind'));
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
                    $this->error('无此数据！', U('SupplierRes/reskind'));
                }
            }
            $this->display('addreskind');
        }
    
    }
    
    
    // @@@NODE-3###delreskind###删除合格供方分类###
    public function delreskind(){
        $this->title('删除合格供方分类');
        $db         = M('supplierkind');
        $id         = I('id', -1);
        $iddel      = $db->delete($id);
        $this->success('删除成功！');
    }

    //资源统计
    public function chart(){
        $this->title('资源统计');
        $year                   = I('year',date('Y'));
        $month                  = I('month',date('m'));
        $pin                    = I('pin',1);

        $this->month  		    = $month;
        $this->year 		    = $year;
        $this->prveyear		    = $year-1;
        $this->nextyear		    = $year+1;
        $this->pin              = $pin;
        $this->display();
    }

    //资源统计
    public function chart_supplier(){
        $this->title('资源统计');
        $mod                    = D('Supplier');
        $year                   = I('year',date('Y'));
        $month                  = I('month',date('m'));
        $where                  = array();
        $where['id']            = array('not in',array(2,6));
        $supplierKinds          = M('supplierkind')->where($where)->getField('id,name');

        $data                   = $mod -> get_supplier_chart($supplierKinds,$year,$month);

        $this->supplierKinds    = $supplierKinds;
        $this->month  		    = $month;
        $this->year 		    = $year;
        $this->prveyear		    = $year-1;
        $this->nextyear		    = $year+1;
        $this->display();
    }
    
    
    
}