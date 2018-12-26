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
		
		$db		= M('contract');
		
		$opid	= I('opid',0);
		$gid	= I('gid',0);
		$cid	= I('cid','');
		$key	= I('key','');
		
		$where = array();
		if($key)		$where['pro_name']		= array('like','%'.$key.'%');
		if($opid)	$where['op_id']			= $opid;
		if($gid)		$where['group_id']		= $gid;
		if($cid)		$where['contract_id']	= array('like','%'.$cid.'%');
		
		if(!rolemenu(array('Contract/confirm'))){
			$where['create_user']	= cookie('userid');
		}
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		
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
			$attr		= I('attr');
            $referer	= I('referer');
			$payment	= I('payment');
            $group_id   = trim($info['group_id']);
			
			
			//根据团号获取项目信息
			$op			= M('op')->where(array('group_id'=>$group_id))->find();
			if(!$op){
				$this->error('未找到该团的项目信息');	
			}
			$info['op_id']			= $op['op_id'];
			$info['update_time']	= time();
			
			//判断该团是否已创建合同
			$where	= array();
			$where['group_id']	= $info['group_id'];
			$where['id']		= array('neq',$id);
			$isok	= $db->where($where)->find();

            if(!$id){
                if (!$isok){
                    $info['create_user']		= cookie('userid');
                    $info['create_user_name']	= cookie('name');
                    $info['create_time']		= time();
                    $save	= $db->add($info);
                    $cid	= $save;

                    //保存操作记录
                    $record                 = array();
                    $record['contract_id']  = $save;
                    $record['type']         = 1;
                    $record['explain']      = '新建合同';
                    contract_record($record);
                }
            }else{
                $save	= $db->data($info)->where(array('id'=>$id))->save();
               	$cid	= $id;

                //保存操作记录
                $record                 = array();
                $record['contract_id']  = $id;
                $record['type']         = 2;
                $record['explain']      = '修改合同内容';
                contract_record($record);
            }
			//保存电子扫描件
			save_aontract_art($cid,$attr);
			
			//保存分期信息
			save_payment($cid,$payment);
			
			if($save) {
				$this->success('保存成功！',$referer);
			} else {
				$this->error('保存失败：' . $db->getError());
			}
            	
        }else{
			
            if (!$id) {
                $this->row	= false;
            } else {
                $this->row	= $db->find($id);
				$this->atts = get_aontract_res($id);
				$this->pays = M('contract_pay')->where(array('cid'=>$id))->order('id asc')->select();
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
			
			$gbsta = array('1'=>'合同已返回综合部','2'=>'合同已返回财务部');
			
			$opid = $row['op_id'];
			
			
			$op             = M('op')->where(array('op_id'=>$opid))->find();
			$settlement     = M('op_settlement')->where(array('op_id'=>$opid))->find();
			$huikuan        = M('op_huikuan')->where(array('op_id'=>$opid))->order('id DESC')->select();
			foreach($huikuan as $k=>$v){
				
				$show        = '';
				$show_user   = '';
				$show_time   = '';
				$show_reason = '';
				
				$where = array();
				$where['req_type'] = P::REQ_TYPE_HUIKUAN;
				$where['req_id']   = $v['id'];
				$audit = M('audit_log')->where($where)->find();
				if($audit['dst_status']==0){
					$show = '未审批';
					$show_user = '未审批';
					$show_time = '等待审批';
				}else if($audit['dst_status']==1){
					$show = '<span class="green">已通过</span>';
					$show_user = $audit['audit_uname'];
					$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
				}else if($audit['dst_status']==2){
					$show = '<span class="red">未通过</span>';
					$show_user = $audit['audit_uname'];
					$show_reason = $audit['audit_reason'];
					$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
				}
				$huikuan[$k]['showstatus']   = $show;
				$huikuan[$k]['show_user']    = $show_user;
				$huikuan[$k]['show_time']    = $show_time;
				$huikuan[$k]['show_reason']  = $show_reason;
			}
			
			$settlement['yihuikuan'] = $settlement['huikuan'] ? $settlement['huikuan']  : '0.00';
	
			$this->op				= $op;
			$this->settlement		= $settlement;
			$this->kinds			= M('project_kind')->getField('id,name', true);
			$this->huikuan			= $huikuan; 
			$this->atts				= M('contract_pic')->where(array('cid'=>$id))->order('id asc')->select();
			$this->pays				= M('contract_pay')->where(array('cid'=>$id))->order('id asc')->select();
			$this->huikuanlist		= M('contract_pay')->where(array('cid'=>$id,'status'=>array('neq','2')))->order('id asc')->select();
			
			
			$row['strseal']			= $row['seal'] ? '<span class="green">我司已盖章</span>' : '<span class="red">我司尚未盖章</span>';
			$row['gbstatus']		= $row['gbs'] ? $gbsta[$row['gbs']] : '未返回';
			$row['strstatus']		= $row['status'] ? '<span class="green">已确认</span>' : '<span class="red">未确认</span>';
			$this->row				= $row;

            //合同操作记录
            $this->record   = M('contract_record')->where(array('contract_id'=>$id))->order('id DESC')->select();

			$this->display('detail');
		}
	}
	
	
	
	// @@@NODE-3###confirm###合同确认###
    public function confirm(){
		
		$db = M('contract');
		
		if(isset($_POST['dosubmint'])){
			$id		= I('id', 0);
			
			$info	= I('info');
			$status = I('status',0);
			$seal	= I('seal',0);
			$gbs	= I('gbs',0);
			
			$row	= $db->find($id);
			if($id && $row){
				$info['status']				= $status;
				$info['seal']				= $seal;
				$info['gbs']					= $gbs;
				$info['confirm_user']		= cookie('userid');
				$info['confirm_user_name']	= cookie('name');
				$info['confirm_time']		= time();
				$isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    //保存操作记录
                    $record                 = array();
                    $record['contract_id']  = $id;
                    $record['type']         = 3;
                    $record['explain']      = '确认合同信息';
                    contract_record($record);

                    $this->success('已保存确认信息！',$referer);
                } else {
                    $this->error('保存确认失败：' . $db->getError());
                }
				
			}else{
				$this->error('合同信息不存在');
			}
			 
			
		}
		
	}
	
	
	
 
    
}