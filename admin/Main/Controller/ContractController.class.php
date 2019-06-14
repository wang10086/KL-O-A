<?php
namespace Main\Controller;
use Monolog\Handler\IFTTTHandler;
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
                    $info['create_user']		= session('userid');
                    $info['create_user_name']	= session('name');
                    $info['create_time']		= time();
                    $save	= $db->add($info);
                    $cid	= $save;

                    //保存操作记录
                    $record                 = array();
                    $record['contract_id']  = $save;
                    $record['type']         = 1;
                    $record['explain']      = '新建合同';
                    contract_record($record);

                    //发送系统消息
                    $uid     = session('userid');
                    $title   = '您有来自['.session('name').'--'.$op['project'].']的合同待审核!';
                    $content = '项目名称：'.$op['project'].'团号：'.$op['group_id'];
                    $url     = U('Contract/index');
                    $user    = '[104]'; //段丽华
                    send_msg($uid,$title,$content,$url,$user,'');

                    //发送短信通知
                    $mobile  = 13611112021;
                    sendTemplateSMS($mobile, array(session('name'),$op['project']), "425448"); //手机号码，替换内容数组，模板ID
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
			//save_payment($cid,$payment);
			
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
			//$this->pays				= M('contract_pay')->where(array('cid'=>$id))->order('id asc')->select();
			//$this->huikuanlist		= M('contract_pay')->where(array('cid'=>$id,'status'=>array('neq','2')))->order('id asc')->select();
            $this->pays				= M('contract_pay')->where(array('op_id'=>$opid))->order('id asc')->select();
            $this->huikuanlist		= M('contract_pay')->where(array('op_id'=>$opid,'status'=>array('neq','2')))->order('id asc')->select();

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
	
	//合同统计
    public function statis(){
        $year		                        = I('year',date('Y'));
        $month	                            = I('month',date('m'));
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $times                              = $year.$month;
        $yw_departs                         = C('YW_DEPARTS_KPI');  //业务部门id
        $where                              = array();
        $where['id']                        = array('in',$yw_departs);
        $departments                        = M('salary_department')->field('id,department')->where($where)->select();
        $cycle_times                        = get_cycle($times);
        $lists                              = get_department_op_list($departments,$cycle_times['begintime'],$cycle_times['endtime'],$times);
        $sum                                = get_contract_sum($lists);

        $this->sum                          = $sum;
        $this->lists                        = $lists;
        $this->departments                  = $departments;
        $this->year		                    = I('year',date('Y'));
        $this->month	                    = I('month',date('m'));
        $this->prveyear	                    = $year-1;
        $this->nextyear	                    = $year+1;
        $this->display();
    }

    public function public_department_detail(){
        $year                               = I('year',date("Y"));
        $month                              = I('month',date('m'));
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $yearMonth                          = $year.$month;
        $cycle_times                        = get_cycle($yearMonth);
        $department_id                      = I('id');

        $count_lists                        = get_department_businessman($department_id);
        $data                               = array();
        foreach ($count_lists as $key=>$value){
            $contract_data                  = get_user_contract_list($value['id'],$yearMonth,$cycle_times['begintime'],$cycle_times['endtime']);
            $contract_data['user_id']       = $value['id'];
            $contract_data['user_name']     = $value['nickname'];
            $data[$key]                     = $contract_data;
        }
        $this->lists                        = $data;
        $this->year                         = $year;
        $this->month                        = $month;
        $this->department_info              = M('salary_department')->where(array('id'=>$department_id))->find();
        $this->display('department_detail');
    }

    public function public_month_detail(){
        $year                               = I('year');
        $month                              = I('month');
        if (strlen($month)<2) $month        = str_pad($month,2,'0',STR_PAD_LEFT);
        $uid                                = I('uid');
        $cycle_times                        = get_cycle($year.$month);
        $yearMonth                          = $year.$month;
        $data                               = get_user_contract_list($uid,$yearMonth,$cycle_times['begintime'],$cycle_times['endtime']);
        $op_list                            = $data['op_list'];

        $this->data                         = $data;
        $this->lists                        = $op_list;
        $this->year                         = $year;
        $this->month                        = $month;
        $this->uid                          = $uid;
        $this->display('month_detail');
    }

    //项目合同
    public function op_list(){
        $opid	                            = I('opid',0);
        $gid	                            = trim(I('gid',''));
        $cid	                            = I('cid','');
        $key	                            = I('key','');

        $where                              = array();
        if($key)    $where['o.project']		= array('like','%'.$key.'%');
        if($opid)	$where['o.op_id']	    = $opid;
        if($gid)    $where['o.group_id']	= $gid;
        if($cid)    $where['c.contract_id']	= array('like','%'.$cid.'%');
        $field                              = 'o.project,o.group_id,o.op_id,o.create_user,o.create_user_name,c.id as cid,c.contract_id,c.contract_amount,c.status';

        /*if(!rolemenu(array('Contract/confirm'))){
            $where['c.create_user']	= cookie('userid');
        }*/

        //分页
        $pagecount                          = M()->table('__OP__ as o')->join('__CONTRACT__ as c on c.op_id = o.op_id','left')->field($field)->where($where)->count();
        $page                               = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                        = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = M()->table('__OP__ as o')->join('__CONTRACT__ as c on c.op_id = o.op_id','left')->where($where)->field($field)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('o.create_time'))->select();
        foreach($lists as $k=>$v){
            $lists[$k]['has_contract']      = $v['cid']? '<span class="green">有合同</span>' : '<span class="red">无合同</span>';
            $lists[$k]['strstatus']	        = $v['status'] ? '<span class="green">已确认</span>' : '<span class="red">未确认</span>';
        }

        $this->lists                        = $lists;
        $this->display();
    }

    /*******************************************************************************************************/
    //合同模板
    public function contract_tpl(){
        $this->title('合同模板');
        $db                         = M('contract_tpl');
        $tit                        = I('tit')?trim(I('tit')):'';
        $con                        = I('con')?trim(I('con')):'';

        $where                      = array();
        if ($tit) $where['title']   = array('like','%'.$tit.'%');
        if ($con) $where['content'] = array('like','%'.$con.'%');

        //分页
        $pagecount                  = $db->where($where)->count();
        $page                       = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                      = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        $this->lists                = $lists;
        $this->display();
    }

    //新增合同模板
    public function add_tpl(){
        $this->title('编辑合同模板');
        $id                         = I('id',0);
        if ($id){
            $info                   = M('contract_tpl')->find($id);
            $attids                 = $info['fileids']?explode(',',$info['fileids']):'';
            if ($attids) $files     = get_files($attids);
            $this->files            = $files;
            $this->row              = $info;
        }

        $this->display();
    }

    //合同模板详情
    public function tpl_detail(){
        $this->title('合同模板详情');
        $id                         = I('id');
        if (!$id) $this->error('获取数据失败');
        $list                       = M('contract_tpl')->find($id);
        $fileids                    = $list['fileids']?explode(',',$list['fileids']):'';
        if ($fileids) $files        = get_files($fileids);

        $this->list                 = $list;
        $this->files                = $files;
        $this->display();
    }

    //删除合同模板
    public function del_tpl(){
        $id                         = I('id');
        if (!$id) $this->error('获取数据信息失败');
        $db                         = M('contract_tpl');
        $fileids                    = $db->where(array('id'=>$id))->getField('fileids');
        if ($fileids) $fileids      = explode(',',$fileids);
        $res                        = $db->delete($id);
        M('attachment')->where(array('id'=>array('in',$fileids)))->delete();
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


    public function add_contract(){
        $this->title('新建合同');
        $tpl_list                   = M('contract_tpl')->getField('id,title',true);


        $this->tpl_list             = $tpl_list;
        $this->display();
    }

    public function public_save(){
        $savetype                           = I('savetype');
        if (isset($_POST['dosubmint']) && $savetype){
            if ($savetype == 1){ //保存合同模板
                $db                         = M('contract_tpl');
                $id                         = I('id',0);
                $title                      = trim(I('title'));
                $content                    = trim(I('content'));
                $fileid                     = I('fileid','');
                if (!$title)    $this->error('模板标题不能为空');
                if (!$content)  $this->error('模板内容不能为空');
                $info                       = array();
                $info['title']              = stripslashes($title);
                $info['content']            = stripslashes($content);
                $info['fileids']            = $fileid?implode(',',$fileid):'';
                $info['create_user']        = session('userid');
                $info['create_user_name']   = session('nickname');

                if ($id){
                    $res                    = $db->where(array('id'=>$id))->save($info);
                }else{
                    $info['create_time']    = NOW_TIME;
                    $res                    = $db->add($info);
                }
                if ($res){
                    $this->success('数据保存成功',U('Contract/contract_tpl'));
                }else{
                    $this->error('数据保存失败');
                }
            }

            if ($savetype == 2){ //保存填写的基本合同信息

            }
        }
    }

}