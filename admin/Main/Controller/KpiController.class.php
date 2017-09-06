<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Finance###绩效管理###
class KpiController extends BaseController {
    
    protected $_pagetitle_ = '绩效管理';
    protected $_pagedesc_  = '';
    
	
	// @@@NODE-3###pdcaresult###考评结果###
    public function pdcaresult(){
        $this->title('绩效考评结果');
		
		
		$kpr   = I('kpr');
		$bkpr  = I('bkpr');
		$month = I('month','');
		
		$db = M('pdca');
		
		$where = '1=1';
		if($month) $where .= ' AND `month` = '.trim($month);
		if($kpr)   $where .= ' AND `eva_user_id` = '.$kpr; 
		if($bkpr)  $where .= ' AND `tab_user_id` = '.$bkpr; 
		
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){}else{
			$where .= ' AND (`tab_user_id` in ('.Rolerelation(cookie('roleid')).') || `eva_user_id` = '.cookie('userid').')';
		}
		
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		foreach($lists as $k=>$v){
			
			$sum_total_score = 0;
			
			$yu = $v['total_score']==0 ? 0 :$v['total_score']-100;
			
			//计算PDCA加减分
			$sum_total_score += $yu;
			
			//品质检查加减分
			$sum_total_score += $v['total_qa_score'];
			
			//整理品质检查加减分
			$lists[$k]['total_score_show']  = $v['status']!=5 ? '<font color="#999999">未评分</font>' : show_score($yu);
			
			//整理品质检查加减分
			$lists[$k]['show_qa_score']     =  show_score($v['total_qa_score']);
			
			//合计
			$lists[$k]['sum_total_score']   =  show_score($sum_total_score);
			
			//KPI
			$lists[$k]['total_kpi_score']   = '<font color="#999999">待完善</font>';
			
		}
		
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		
		//整理关键字
		$userwhere = '`status`=0';
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==28 || cookie('roleid')==43){}else{
			$userwhere .= ' AND `id` in ('.Rolerelation(cookie('roleid')).') || `id` = '.cookie('userid').'';
		}
		$role = M('role')->GetField('id,role_name',true);
		$user =  M('account')->where($userwhere)->select();
		$key = array();
		foreach($user as $k=>$v){
			$text = $v['nickname'].'-'.$role[$v['roleid']];
			$key[$k]['id']         = $v['id'];
			$key[$k]['user_name']  = $v['nickname'];
			$key[$k]['pinyin']     = strtopinyin($text);
			$key[$k]['text']       = $text;
			$key[$k]['role']       = $v['roleid'];
			$key[$k]['role_name']  = $role[$v['roleid']];
		}
		
		$this->userkey =  json_encode($key);	
		
		
		$this->month = $month;
		$this->display('pdcaresult');
    }
	
    // @@@NODE-3###pdca###PDCA###
    public function pdca(){
        $this->title('PDCA');
		
		$kpr   = I('kpr');
		$bkpr  = I('bkpr');
		$month = I('month','');
		$show  = I('show',0);
		
		if($show) $bkpr = cookie('userid');
		
		$db = M('pdca');
		
		$where = '';
		$where .= '1 = 1';
		if($month) $where .= ' AND `month` = '.trim($month); 
		if($kpr)   $where .= ' AND `eva_user_id` = '.$kpr; 
		if($bkpr)  $where .= ' AND `tab_user_id` = '.$bkpr; 
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==28 || cookie('roleid')==43){}else{
			$where .= ' AND (`tab_user_id` in ('.Rolerelation(cookie('roleid')).') || `eva_user_id` = '.cookie('userid').')';
		}
		
		//P($where);
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		foreach($lists as $k=>$v){
			if($v['total_score']==0){
				$totalshow = '<font color="#999">未评分</font>';	
			}else{
				$yu = 100-$v['total_score'];
				if($yu){
					$totalshow = '-'.$yu;	
				}else{
					$totalshow = '<font color="#999">无加扣分</font>';
				}
			}
			
			$lists[$k]['total_score_show']  = $totalshow; 	
			$lists[$k]['kaoping']      = $v['eva_user_id'] ? '<a href="'.U('Kpi/pdca',array('bkpr'=>$v['eva_user_id'])).'">'.username($v['eva_user_id']).'</a>' : '未评分'; 	
		}
		
		$this->show     = $show;
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		
		
		//整理关键字
		$userwhere = '`status`=0';
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){}else{
			$userwhere .= ' AND `id` in ('.Rolerelation(cookie('roleid')).') || `id` = '.cookie('userid').'';
		}
		$role = M('role')->GetField('id,role_name',true);
		$user =  M('account')->where($userwhere)->select();
		$key = array();
		foreach($user as $k=>$v){
			$text = $v['nickname'].'-'.$role[$v['roleid']];
			$key[$k]['id']         = $v['id'];
			$key[$k]['user_name']  = $v['nickname'];
			$key[$k]['pinyin']     = strtopinyin($text);
			$key[$k]['text']       = $text;
			$key[$k]['role']       = $v['roleid'];
			$key[$k]['role_name']  = $role[$v['roleid']];
		}
		
		$this->month  		= $month;
		$this->same_month   = date('Ym');
		$this->next_month   = date('Ym',strtotime("+1 month"));
		$this->userkey =  json_encode($key);	
			
			
		$this->display('pdca');
    }
	
	
	// @@@NODE-3###addpdca###新建PDCA###
	public function addpdca(){
		
		
		if(isset($_POST['dosubmint'])){
			
			$editid    = I('editid');
			$info      = I('info');
			$com       = I('com',0);
			
			//执行保存
			if($editid){
				
				//获取评分人信息
				$pd  = M('pdca')->find($editid);
				$us  = M('account')->find($pd['tab_user_id']);
				$pfr = M('auth')->where(array('role_id'=>$us['roleid']))->find();
				$info['eva_user_id']  = $pfr ? $pfr['pdca_auth'] : 0;
				
				$addinfo = M('pdca')->data($info)->where(array('id'=>$editid))->save();
			}else{
				//判断月份是否存在
				if(M('pdca')->where(array('month'=>$info['month'],'tab_user_id'=>cookie('userid')))->find()){
					$this->error('该月已存在PDCA，您可以直接完善PDCA项目');	
				}else{
					
					//获取评分人信息
					$pfr = M('auth')->where(array('role_id'=>cookie('roleid')))->find();
					$info['eva_user_id']  = $pfr ? $pfr['pdca_auth'] : 0;
					$info['tab_user_id'] = cookie('userid');
					$info['tab_time']    = time();
					$addinfo = M('pdca')->add($info);
				}
			}
			
			if($com){
				$this->success('已保存！');
			}else{
				echo '<script>window.top.location.reload();</script>';
			}
			
			
		
		
		}else{
			
			$id = I('id','');
			if($id){
				$this->row = M('pdca')->find($id);
			}
			$this->display('addpdca');
		
		}
	}
	
	
	
	// @@@NODE-3###pdcainfo###PDCA计划管理###
	public function pdcainfo(){
		
		$id = I('id',0);
		
		$pdcasta  = C('PDCA_STATUS');
		
		$pdca = M('pdca')->find($id);
		$pdca['total_score']  = $pdca['total_score'] ? $pdca['total_score'].'分' : '<font color="#999">未评分</font>'; 	
		$pdca['kaoping']      = $pdca['eva_user_id'] ? username($pdca['eva_user_id']) : '未评分'; 	
		$pdca['status_str']   = $pdcasta[$pdca['status']]; 	
		if($id && $pdca){
			$where = array();
			$where['pdcaid'] = $id;
			
			$lists = M('pdca_term')->where($where)->select();
			foreach($lists as $K=>$v){
				$lists[$K]['score']  = $v['score'] ? 	$v['score']  : '<font color="#999">未评分</font>';
			}
			
			$this->lists = $lists;
			$this->pdca  = $pdca;
			
			$applist          = M('pdca_apply')->where(array('pdcaid'=>$id))->order('apply_time DESC')->select();
			$pdcasta          = C('PDCA_STATUS');
			foreach($applist as $k=>$v){
				$applist[$k]['status'] = $pdcasta[$v['status']];	
			}
			$this->applist    = $applist;
			
			
			//获取已评总分信息
			$total = 0;
			$pdcadata = M('pdca_term')->where(array('pdcaid'=>$id))->select();
			foreach($pdcadata as $k=>$v){
				//合计总分
				$total += $v['score'];
			}
			if($total > 100){
				$this->totalstr = '<span class="red" style="font-size:16px;">当前各项总分为'.$total.'，PDCA总分不允许超过100分！</span>';
			}else if($total == 100){
				$this->totalstr = '<span class="blue" style="font-size:16px;">当前各项总分为'.$total.'，被考评人本月不扣分！</span>';	
			}else{
				$koufen = 100-$total;
				$this->totalstr = '<span class="yellow" style="font-size:16px;">当前各项总分为'.$total.'，被考评人本月扣'.$koufen.'分！</span>';		
			}
			
			
			$this->display('pdca_info');
			
		}else{
			$this->error('PDCA不存在');	
		}
		
		
	}
	
	// @@@NODE-3###pdcainfo###PDCA评分###
	public function score(){
		$id = I('pdcaid',0);
		//查看PDCA状态
		$pdca = M('pdca')->find($id);
		
		//判断是否有权限评分
		if(cookie('userid')!=$pdca['eva_user_id']){
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			
			
			$total = 0;
			$pdcadata = M('pdca_term')->where(array('pdcaid'=>$id))->select();
			foreach($pdcadata as $k=>$v){
				//合计总分
				$total += $v['score'];
			}
			
			if($total>100)   $this->error('总分不能超过100分');	
			
			
			//保存总分
			$data = array();
			$data['status']  		  = 5;
			$data['total_score']      = $total;
			$issave = M('pdca')->data($data)->where(array('id'=>$id))->save();
			if($issave){
				
				//发送消息
				$uid     = cookie('userid');
				$title   = '您的['.$pdca['month'].'PDCA]已评分';
				$content = '';
				$url     = U('Kpi/pdcainfo',array('id'=>$id));
				$user    = '['.$pdca['tab_user_id'].']';
				send_msg($uid,$title,$content,$url,$user,'');
				
				$this->success('已评分！');
				
			}else{
				$this->error('保存评分失败');		
			}
		
		}else{
		
		
			if($id && $pdca){
				$where = array();
				$where['pdcaid'] = $id;
				
				$lists = M('pdca_term')->where($where)->select();
				$this->lists = $lists;
				$this->pdca  = $pdca;
				$this->display('pdca_score');
				
			}else{
				$this->error('PDCA不存在');	
			}
		
		}
	}
	/*
	public function score(){
		$id = I('pdcaid',0);
		//查看PDCA状态
		$pdca = M('pdca')->find($id);
		
		//判断是否有权限评分
		if(cookie('userid')!=$pdca['eva_user_id']){
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			
			
			$total = 0;
			$pdcadata = I('pdca');
			foreach($pdcadata as $k=>$v){
				//保存评分
				M('pdca_term')->data(array('score'=>$v))->where(array('id'=>$k))->save();
				$total += $v;
			}
			
			//保存总分
			$data = array();
			$data['status']  		  = 2;
			//$data['eva_user_id']      = cookie('userid');
			$data['eva_time'] 		  = time();
			$data['total_score']      = $total;
			$issave = M('pdca')->data($data)->where(array('id'=>$id))->save();
			if($issave){
				
				//发送消息
				$uid     = cookie('userid');
				$title   = '您的['.$pdca['month'].'PDCA]已评分';
				$content = '';
				$url     = U('Kpi/pdcainfo',array('id'=>$id));
				$user    = '['.$pdca['tab_user_id'].']';
				send_msg($uid,$title,$content,$url,$user,'');
				
				$this->success('已评分！');
				
			}else{
				$this->error('保存评分失败');		
			}
		
		}else{
		
		
			if($id && $pdca){
				$where = array();
				$where['pdcaid'] = $id;
				
				$lists = M('pdca_term')->where($where)->select();
				$this->lists = $lists;
				$this->pdca  = $pdca;
				$this->display('pdca_score');
				
			}else{
				$this->error('PDCA不存在');	
			}
		
		}
	}
	*/
	
	
	
	// @@@NODE-3###unitscore###单项PDCA评分###
	public function unitscore(){
		
		$id = I('id',0);
		$team = M('pdca_term')->find($id);
		//查看PDCA状态
		$pdca = M('pdca')->find($team['pdcaid']);
		
		//判断是否有权限评分
		if(!$id || !$pdca || cookie('userid')!=$pdca['eva_user_id']){
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			//保存分数
			$info = I('info');
			M('pdca_term')->data($info)->where(array('id'=>$id))->save();
			
			/*
			//总分
			$total = M('pdca_term')->where(array('pdcaid'=>$team['pdcaid']))->sum('score');
			
			
			$data = array();
			$data['eva_user_id']      = cookie('userid');
			$data['eva_time'] 		  = time();
			$data['total_score']      = $total;
			
			//判断是否全部打分完毕
			$isall = M('pdca_term')->where(array('pdcaid'=>$team['pdcaid'],'score'=>0))->find();
			if(!$isall){
				$data['status']  		  = 5;
				//发送消息
				$uid     = cookie('userid');
				$title   = '您的['.$pdca['month'].'PDCA]已评分';
				$content = '';
				$url     = U('Kpi/pdcainfo',array('id'=>$team['pdcaid']));
				$user    = '['.$pdca['tab_user_id'].']';
				send_msg($uid,$title,$content,$url,$user,'');
			}
			
			$issave = M('pdca')->data($data)->where(array('id'=>$team['pdcaid']))->save();
			*/
			
			echo '<script>window.top.location.reload();</script>';
		
		}else{
		
		
			if($id && $team){
				
				$this->pdca  = $pdca;
				$this->team  = $team;
				$this->display('unitscore');
				
			}else{
				$this->error('PDCA不存在');	
			}
		
		}
		
	}
    
	
	// @@@NODE-3###editpdca###编辑PDCA计划###
	public function editpdca(){
		
		if(isset($_POST['dosubmint'])){
			
			$editid    = I('editid');
			$info      = I('info');
			
			if(!$info['work_plan'])  $this->error('计划工作项目标题未填写');
			if(!$info['weight'])     $this->error('权重未填写');
			if(!$info['standard'])   $this->error('细项及标准未填写');
			
			
			//执行保存
			if($editid){
				
				//if(!$info['complete'])   $this->error('完成情况及未完成原因未填写');
				
				$where = array();
				$where['pdcaid'] = $info['pdcaid'];
				$where['id']     = array('neq',$editid);
				$sumweight       = M('pdca_term')->field('weight')->where($where)->sum('weight');
				$shengyu         = 100-$sumweight;
				
				//if($info['weight']>$shengyu)   $this->error('月度总权重分不能大于100分');
				
				$pdca = M('pdca')->find($info['pdcaid']);
				//判断是否自己保存
				if(cookie('userid')==$pdca['tab_user_id'] || cookie('userid')==$pdca['eva_user_id'] || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){
					$addinfo = M('pdca_term')->data($info)->where(array('id'=>$editid))->save();
				}else{
					$this->error('您没有权限保存');
				}
			}else{
				
				$sumweight  = M('pdca_term')->field('weight')->where(array('pdcaid'=>$info['pdcaid']))->sum('weight');
				$shengyu  = 100-$sumweight;
			
				if($info['weight']>$shengyu)   $this->error('月度总权重分不能大于100分');
				
				$info['userid']      = cookie('userid');
				$info['create_time'] = time();
				$info['score']       = 0;
				$addinfo = M('pdca_term')->add($info);
			}
			
			//修正评分人信息
			$pd  = M('pdca')->find($info['pdcaid']);
			$us  = M('account')->find($pd['tab_user_id']);
			$pfr = M('auth')->where(array('role_id'=>$us['roleid']))->find();
			$eva_user_id  = $pfr ? $pfr['pdca_auth'] : 0;
			M('pdca')->data(array('eva_user_id'=>$eva_user_id))->where(array('id'=>$info['pdcaid']))->save();
				
			
			//如果是制表人保存，修正状态
			if($pd['tab_user_id'] == cookie('userid')){
				$issave = M('pdca')->data(array('status'=>0,'total_score'=>0))->where(array('id'=>$info['pdcaid']))->save();
			}
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			$id               = I('id','');
			$pdcaid           = I('pdcaid',0);
			$this->pdca       = M('pdca')->find($pdcaid);
			$this->row        = M('pdca_term')->find($id);
			
			$where = array();
			$where['pdcaid'] = $pdcaid;
			if($id) $where['id']     = array('neq',$id);
			$shengyu          = M('pdca_term')->field('weight')->where($where)->sum('weight');
			
			$this->shengyu    = 100-$shengyu;
			$this->display('editpdca');
		}
	}
	
	
	
	
	// @@@NODE-3###pdcadetail###查看PDCA计划详情###
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
			$row['view']        = $row['view'] ? nl2br($row['view']) : '无';
			$row['score']       = $row['score'] ? $row['score'] : '未评分';
			
			$this->row = $row;
			
			$this->pdca       = M('pdca')->find($row['pdcaid']);
			
		}else{
			echo '<script>art_show_msgd(\'PDCA项目不存在\');</script>';	
		}
		$this->display('pdca_detail');
		
	}
	
	// @@@NODE-3###delpdca###删除PDCA###
	public function delpdca(){
		$id = I('id',0);
		
		$pdca = M('pdca')->find($id);
		if(cookie('userid')==$pdca['tab_user_id'] || cookie('roleid')==$pdca['app_role']) {
			//执行删除
			$iddel = M('pdca')->delete($id);
			$this->success('删除成功！');
		}else{
			$this->error('您没有权限删除');	
		}
	}
	
	
	// @@@NODE-3###delpdcaterm###删除PDCA项目###
	public function delpdcaterm(){
		$id = I('id',0);
		
		$pdca = M('pdca_term')->find($id);
		if($id && $pdca['userid']==cookie('userid')){
			
			//执行删除
			$iddel = M('pdca_term')->delete($id);
			$this->success('删除成功！');
		}else{
			$this->error('您没有权限删除');	
		}
		
	}
	
	
	// @@@NODE-3###applyscore###PDCA申请评分###
	public function applyscore(){
		
		$pdcaid     = I('pdcaid','');
		$status     = I('status','');
		$app_remark = I('app_remark','');
		if(isset($_POST['dosubmint'])){
			
			if(!$status)   $this->error('请选择审批结果');	
			
			//查看PDCA状态
			$pdca = M('pdca')->find($pdcaid);
			
				
			$us   = M('account')->find($pdca['tab_user_id']);
			$pfr  = M('auth')->where(array('role_id'=>$us['roleid']))->find();
			
			$data = array();
			$data['status']         = $status;
			$data['eva_user_id']    = $pfr ? $pfr['pdca_auth'] : 0;
			//$data['app_role']     = $role['pid'];     //审批部门
			$data['app_time']       = time();           //申请时间
			if($app_remark) $data['app_remark']     = $app_remark;      //审批时间
			$apply = M('pdca')->data($data)->where(array('id'=>$pdcaid))->save();
			if($apply){
				
				if($status==1){
					$title   = '['.$pdca['month'].'PDCA],已编制完毕，请您审核';	
					$user    = '['.$pdca['eva_user_id'].']';
					$content = '';
				}else if($status==4){
					$title   = '['.$pdca['month'].'PDCA],已编制完毕，请您评分';	
					$user = '['.$pdca['eva_user_id'].']';
					$content = $app_remark;
				}else if($status==2){
					$title   = '['.$pdca['month'].'PDCA],已审核通过';	
					$user = '['.$pdca['tab_user_id'].']';
					$content = '';
				}else if($status==3){
					$title   = '['.$pdca['month'].'PDCA],审核未通过';	
					$user = '['.$pdca['tab_user_id'].']';
					$content = $app_remark;
				}
				
				//发送消息
				$uid  = cookie('userid');
				$url  = U('Kpi/pdcainfo',array('id'=>$pdcaid));
				send_msg($uid,$title,$content,$url,$user);
				
				//保存审核记录
				if($status==2 || $status==3){
					$myid = cookie('userid');
					$data = array();
					$data['pdcaid']         = $pdcaid;
					$data['apply_user']     = $myid;
					$data['apply_user_nme'] = cookie('nickname') ? cookie('nickname') : username($myid);
					$data['apply_time']     = time();
					$data['status']         = $status;
					$data['remark']         = $app_remark;
					M('pdca_apply')->add($data);
					$this->success('已审核！');
				}else{
					
					$this->success('已提交申请！');	
				}
				
				
			}else{
				$this->error('申请失败');	
			}
				
			
			
		}else{
			$id               = I('id','');
			$pdcaid           = I('pdcaid',0);
			$this->pdca       = M('pdca')->find($pdcaid);
			$this->row        = M('pdca_term')->find($id);
			
			$this->display('editpdca');
		}
		
	}
 	
	
	
	// @@@NODE-3###addpdca###品质检查###
	public function qa(){
		$this->title('品质检查');
		 
		$db = M('qaqc');
		
		$this->type   = intval(I('type',2));
		$this->uid    = I('uid',0);
		$this->month  = I('month','');
		$this->user   = I('user','');
		
		if($this->type < 0 || $this->type >2){
			$this->error('数据不存在');	
		}
		
		
		$where = array();
		if($this->type!=2) $where['status'] = $this->type;
		if($this->uid)     $where['rp_user_id'] = $this->uid;
		if($this->month)   $where['month'] = $this->month;
		if($this->user)    $where['rp_user_name'] = array('like','%'.$this->user.'%');
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['score']      = $v['status'] ? '-'.$v['red_score']:'+'.$v['inc_score']; 	
			$lists[$k]['statusstr']  = $v['status'] ? '<span class="red">处罚</span>':'<span class="green">奖励</span>'; 	
		}
		
		$this->lists    = $lists; 
		 
		$this->display('qa');	
	}
	
    
	
	// @@@NODE-3###addpdca###发布品质检查###
	public function addqa(){
		
		if(isset($_POST['dosubmint'])){
			
			$editid   = I('editid');
			$info     = I('info');
			$score    = I('score');
			if($info['status']==0){
				$info['inc_score'] = $score;
				$info['red_score'] = 0;
			}else{
				$info['inc_score'] = 0;
				$info['red_score'] = $score;
			}
			
			if(!$info['rp_user_id'])  $this->error('接受奖惩人员不存在');	
			if(!$info['month'])       $this->error('请输入执行月份');	
			if(!$score)               $this->error('请填写奖惩分数');	
			
			//执行保存
			if($editid){
				$addinfo = M('qaqc')->data($info)->where(array('id'=>$editid))->save();
			}else{
				$info['ins_user_id']    = cookie('userid');
				$info['ins_user_name']  = cookie('nickname');
				$info['ins_time']       = time();
				$addinfo = M('qaqc')->add($info);
				
				//发送公告
				$title       = $info['title'];
				$content     = $info['reason'];
				$url    	 = '';
				$source      = 1;
				$source_id   = $addinfo;
				send_notice($title,$content,$url,$source,$source_id);
			}
			
			
			//修正绩效评分
			qa_score_num($info['rp_user_id'],$info['month']);
			
			echo '<script>window.top.location.reload();</script>';
			
		
		}else{
			
			$id = I('id','');
			if($id){
				$row = M('qaqc')->find($id);
				if($row['status']==0){
					$row['score']  = $row['inc_score'];
				}else{
					$row['score']  = $row['red_score'];
				}
				$this->row = $row;
			}
			
			//整理关键字
			$role = M('role')->GetField('id,role_name',true);
			$user =  M('account')->where(array('status'=>0))->select();
			$key = array();
			foreach($user as $k=>$v){
				$text = $v['nickname'].'-'.$role[$v['roleid']];
				$key[$k]['id']         = $v['id'];
				$key[$k]['user_name']  = $v['nickname'];
				$key[$k]['pinyin']     = strtopinyin($text);
				$key[$k]['text']       = $text;
				$key[$k]['role']       = $v['roleid'];
				$key[$k]['role_name']  = $role[$v['roleid']];
			}
			
			$this->userkey =  json_encode($key);	
			
			$this->display('addqa');
		
		}
	}
	
	
	// @@@NODE-3###qadetail###查看品质检查详情###
	public function qadetail(){
		
		$id = I('id','');
		if($id){
			$row = M('qaqc')->find($id);
			
			$row['reason']     = $row['reason'] ? nl2br($row['reason']) : '无';
			$row['joint']      = $row['joint'] ? nl2br($row['joint']) : '无';
			$row['score']      = $row['status'] ? '-'.$row['red_score']:'+'.$row['inc_score']; 	
			$row['statusstr']  = $row['status'] ? '<span class="red">处罚</span>':'<span class="green">奖励</span>';
			
			$this->row = $row;
			
			$this->pdca       = M('pdca')->find($row['pdcaid']);
			
		}else{
			echo '<script>art_show_msgd(\'品质检查信息不存在\');</script>';	
		}
		$this->display('qa_detail');
		
	}
	
	
	// @@@NODE-3###revoke###撤销品质检查信息###
	public function revoke(){
		$id = I('id','');
		
		//获取品质检查信息
		$qa = M('qaqc')->find($id);
		
		//撤销评分
		if($id && $qa){
			
			//删除评分
			$iddel = M('qaqc')->delete($id);
			if($iddel){
				//撤销公告
				$where = array();
				$where['source']     = 1;
				$where['source_id']  = $id;
				 M('notice')->where($where)->delete();
				
				//修正评分
				qa_score_num($qa['rp_user_id'],$qa['month']);
				
				$this->success('撤销成功！');
				
			}else{
				$this->error('撤销失败');	
			}
		}else{
			$this->error('品质检查信息不存在');		
		}
		
			
	}
}