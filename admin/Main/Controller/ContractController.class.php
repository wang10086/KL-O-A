<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Contract###合同管理###
class ContractController extends BaseController {
    
    protected $_pagetitle_ = '合同管理';
    protected $_pagedesc_  = '';
    
	
    // @@@NODE-3###index###合同列表###
    public function index(){
        $this->title('合同管理');
		
		$db = M('contract');
		
		
		
		$where = array();
		//$where['o.audit_status'] = 1;
		//$where['p.id'] = array('gt',0);
		
		//分页
		$pagecount = $db->table('__CONTRACT__ as c')->field('c.*,s.huikuan')->join('__OP_SETTLEMENT__ as s on s.op_id = c.op_id','LEFT')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->table('__CONTRACT__ as c')->field('c.*,s.huikuan')->join('__OP_SETTLEMENT__ as s on s.op_id = c.op_id','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('c.create_time'))->select();
		
		foreach($lists as $k=>$v){
			$lists[$k]['strstatus']	= $v['status'] ? '<span class="green">已确认</span>' : '<span class="red">未确认</span>';	
		}
		
		$this->lists = $lists;
		$this->display('index');
    }
	
    

	
	// @@@NODE-3###add###创建合同###
    public function add(){
        $this->title('新建/修改合同信息');
        
        $db = M('contract');
        $id = I('id', 0);

        if(isset($_POST['dosubmit'])){
        
            $info		= I('info');
            $referer	= I('referer');
			
			
            if(!$id){
				$info['create_user']		= cookie('userid');
				$info['create_user_name']	= cookie('name');
				$info['create_time']		= time();
                $isadd = $db->add($info);
                if($isadd) {
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
			
            if (!$id) {
                $this->row = false;
            } else {
                $this->row = $db->find($id);
            }
            $this->display('add');
        }
        
        
    }
	
	
	
	// @@@NODE-3###detail###合同详情###
    public function detail(){
		
		$this->title('合同详情');
		
		$db = M('contract');
        $id = I('id', 0);
		
		$row = $db->find($id);
		if(!$id || !$row){
			$this->error('合同信息不存在');
		}else{
			
			$row['strstatus']	= $row['status'] ? '<span class="green">已确认</span>' : '<span class="red">未确认</span>';
			$this->row			= $row;
			$this->display('detail');
		}
	}
	
	
	
 
    
}