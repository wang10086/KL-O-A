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
		
		
		
		$this->display('pdca_info');
	}
	
    
	
	// @@@NODE-3###accounting###制定PDCA###
	public function editpdca(){
		
		
		
		$this->display('editpdca');
	}
 
    
}