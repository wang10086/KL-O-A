<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Finance###绩效管理###
class KpiController extends BaseController {
    
    protected $_pagetitle_ = '绩效管理';
    protected $_pagedesc_  = '';
    
	
    // @@@NODE-3###accounting###PDCA###
    public function pdca(){
        $this->title('PDCA');
		
		$db = M('pdca');
		
		$where = array();
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		
		$this->display('pdca');
    }
	
	
	// @@@NODE-3###accounting###PDCA计划###
	public function pdcainfo(){
		
		$where = array();
		$where['userid']      = cookie('userid');
		
		$lists = M('pdca_term')->where($where)->select();
		
		$this->lists = $lists;
		
		$this->display('pdca_info');
	}
	
    
	
	// @@@NODE-3###accounting###制定PDCA###
	public function editpdca(){
		
		
		
		if(isset($_POST['dosubmint'])){
			
			$editid   = I('editid');
			$info      = I('info');
			
			//执行保存
			if($editid){
				$addinfo = M('pdca_term')->data($info)->where(array('id'=>$editid))->save();
			}else{
				$info['month']       = date('Ym');
				$info['userid']      = cookie('userid');
				$info['create_time'] = time();
				$addinfo = M('pdca_term')->add($info);
			}
			
			echo '<script>window.top.location.reload();</script>';
			
		
		
		}else{
			
			$id = I('id','');
			if($id){
				$this->row = M('pdca_term')->find($id);
			}
			$this->display('editpdca');
		
		}
	}
	
	
	
	
	// @@@NODE-3###accounting###PDCA项目详情###
	public function pdcadetail(){
		
		$id = I('id','');
		if($id){
			$row = M('pdca_term')->find($id);
			
			$row['standard']    = $row['standard'] ? nl2br($row['standard']) : '无';
			$row['method']      = $row['method'] ? nl2br($row['method']) : '无';
			$row['emergency']   = $row['emergency'] ? nl2br($row['emergency']) : '无';
			$row['complete']    = $row['complete'] ? nl2br($row['complete']) : '无';
			$row['nocomplete']  = $row['nocomplete'] ? nl2br($row['nocomplete']) : '无';
			$row['newstrategy'] = $row['newstrategy'] ? nl2br($row['newstrategy']) : '无';
			
			$this->row = $row;
		}else{
			echo '<script>art_show_msgd(\'PDCA项目不存在\');</script>';	
		}
		$this->display('pdca_detail');
		
	}
 
    
}