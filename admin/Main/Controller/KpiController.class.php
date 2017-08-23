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
        $this->title('PDCA');
		
		$this->type = intval(I('type',2));
		
		if($this->type < 1 || $this->type >2){
			$this->error('数据不存在');	
		}
		
		$db = M('pdca');
		
		$where = array();
		$where['status'] = $this->type;
		
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){}else{
			$where['tab_user_id'] = array('in',Rolerelation(cookie('roleid')));
		}
		
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['total_score']  = $v['status']!=2 ? '未评分':$v['total_score']; 	
		}
		
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		$this->display('pdcaresult');
    }
	
    // @@@NODE-3###pdca###PDCA###
    public function pdca(){
        $this->title('PDCA');
		
		$db = M('pdca');
		
		$where = array();
		
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){}else{
			$where['tab_user_id'] = array('in',Rolerelation(cookie('roleid')));
		}
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['total_score']  = $v['status']!=2 ? '未评分':$v['total_score']; 	
		}
		
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		$this->display('pdca');
    }
	
	
	// @@@NODE-3###addpdca###新建PDCA###
	public function addpdca(){
		
		
		if(isset($_POST['dosubmint'])){
			
			$editid   = I('editid');
			$info      = I('info');
			
			//执行保存
			if($editid){
				$addinfo = M('pdca')->data($info)->where(array('id'=>$editid))->save();
			}else{
				
				//判断月份是否存在
				if(M('pdca')->where(array('month'=>$info['month'],'tab_user_id'=>cookie('userid')))->find()){
					$this->error('改月已存在PDCA，您可以直接完善PDCA项目');	
				}else{
				
					//$info['month']       = date('Ym');
					$info['tab_user_id'] = cookie('userid');
					$info['tab_time']    = time();
					$addinfo = M('pdca')->add($info);
				}
			}
			
			echo '<script>window.top.location.reload();</script>';
			
		
		
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
		
		$pdca = M('pdca')->find($id);
		$pdca['total_score']  = $pdca['status']!=2 ? '未评分':$pdca['total_score'].'分'; 	
		
		if($id && $pdca){
			$where = array();
			$where['pdcaid'] = $id;
			
			$lists = M('pdca_term')->where($where)->select();
			foreach($lists as $K=>$v){
				$lists[$K]['score']  = $v['score'] ? 	$v['score']  : '未评分';
			}
			
			$this->lists = $lists;
			$this->pdca  = $pdca;
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
		if(cookie('roleid')!=$pdca['app_role']){
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
			$data['eva_user_id']      = cookie('userid');
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
	
    
	
	// @@@NODE-3###editpdca###编辑PDCA计划###
	public function editpdca(){
		
		if(isset($_POST['dosubmint'])){
			
			$editid    = I('editid');
			$info      = I('info');
			//执行保存
			if($editid){
				
				$pdca = M('pdca')->find($info['pdcaid']);
				//判断是否自己保存
				if(cookie('userid')==$pdca['tab_user_id'] || cookie('roleid')==$pdca['app_role']){
					$addinfo = M('pdca_term')->data($info)->where(array('id'=>$editid))->save();
				}else{
					$this->error('您没有权限保存');
				}
			}else{
				$info['userid']      = cookie('userid');
				$info['create_time'] = time();
				$info['score']       = 0;
				$addinfo = M('pdca_term')->add($info);
			}
			
			$data = array();
			$data['status']  		  = 0;
			$issave = M('pdca')->data($data)->where(array('id'=>$info['pdcaid']))->save();
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			$id               = I('id','');
			$pdcaid           = I('pdcaid',0);
			$this->pdca       = M('pdca')->find($pdcaid);
			$this->row        = M('pdca_term')->find($id);
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
			$row['score']       = $row['score'] ? $row['score'] : '未评分';
			
			$this->row = $row;
			
			$this->pdca       = M('pdca')->find($row['pdcaid']);
			
		}else{
			echo '<script>art_show_msgd(\'PDCA项目不存在\');</script>';	
		}
		$this->display('pdca_detail');
		
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
		
		$pdcaid = I('pdcaid','');
		if(isset($_POST['dosubmint'])){
			
			//查看PDCA状态
			$pdca = M('pdca')->find($pdcaid);
			if($pdca['status']!=2){
				
				//获取上级领导ID
				$role = M('role')->find(cookie('roleid'));
				
				$data = array();
				$data['status']         = 1;
				$data['app_role']       = $role['pid'];     //审批部门
				$data['app_time']       = time();           //申请时间
				$apply = M('pdca')->data($data)->where(array('id'=>$pdcaid))->save();
				if($apply){
					
					//向审批人发送消息
					if($role['pid']){
						$uid     = cookie('userid');
						$title   = '['.$pdca['month'].'PDCA],已编制完毕，请您给予评分';
						$content = $pdca['title'];
						$url     = U('Kpi/score',array('pdcaid'=>$pdcaid));
						$roleid  = '['.$role['pid'].']';
						send_msg($uid,$title,$content,$url,'',$roleid);
					}
					
					$this->success('已提交申请！');
				}else{
					$this->error('申请失败');	
				}
				
			}else{
				$this->error('该PDCA已评分');	
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
		
		$this->type = intval(I('type',0));
		
		if($this->type < 0 || $this->type >1){
			$this->error('数据不存在');	
		}
		
		
		$where = array();
		$where['status'] = $this->type;
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['score']      = $v['status'] ? $v['red_score']:$v['inc_score']; 	
			$lists[$k]['statusstr']  = $v['status'] ? '处罚':'奖励'; 	
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
			$user =  M('account')->select();
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
	
}