<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###Finance###绩效管理###
class KpiController extends BaseController {
    
    protected $_pagetitle_ = '绩效管理';
    protected $_pagedesc_  = '';

    //初始化(更新所有人员KPI信息)
    public function get_initialize(){
        $where                  = array();
        $where['status']		= 0;
        $where['id']            = array('gt',10);
        $userlist               = M('account')->field('id,nickname,roleid,postid,kpi_cycle')->where($where)->select();

        foreach($userlist as $k=>$v){
            //获取该用户KPI
            $year               = date('Y');
            $month              = date('m');
            $yearMonth          = get_kpi_yearMonth($year,$month);
            $user_id	        = $v['id'];

            //更新数据
            updatekpi($yearMonth,$user_id);
        }
    }

	// @@@NODE-3###pdcaresult###考评结果###
    public function pdcaresult(){
        $this->get_initialize();    //初始化KPI数据
        $this->title('绩效考评结果');
		
		$year		= I('year',date('Y'));
		$bkpr		= I('bkpr');
		$bkprnm		= I('bkprnm','');
		$month		= I('month',date('Ym'));
		
		
		
		$db = M('pdca');
		
		$where = array();
		if($month)		$where['p.month']	= trim($month);
		if($bkprnm)		$where['a.nickname']	= array('like','%'.$bkprnm.'%'); 
		if($bkpr)		$where['p.tab_user_id']	= $bkpr; 
		
		/*
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==13  || cookie('userid')==11 || cookie('roleid')==43 || cookie('roleid')==44){}else{
			$where .= ' AND (`tab_user_id` in ('.Rolerelation(cookie('roleid')).') || `eva_user_id` = '.cookie('userid').')';
		}
		*/
		
		
		//分页
		$pagecount		= M()->table('__PDCA__ as p')->join('__ACCOUNT__ as a on a.id = p.tab_user_id')->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages 	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists 			= M()->table('__PDCA__ as p')->field('p.*,a.nickname')->join('__ACCOUNT__ as a on a.id = p.tab_user_id')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('month'))->select();
		foreach($lists as $k=>$v){
			
			$sum_total_score = 0;
			
			$yu = $v['status']!=5 ? 0 : $v['total_score']-100;
			
			//计算PDCA加减分
			$sum_total_score += $yu;
			
			//品质检查加减分
			$sum_total_score += $v['total_qa_score'];
			
			//整理品质检查加减分
			$lists[$k]['total_score_show']  = $v['status']!=5 ? '<font color="#ff9900">未完成评分</font>' : show_score($yu);
			
			//整理品质检查加减分
			$lists[$k]['show_qa_score']     =  show_score($v['total_qa_score']);
			
			//获取KPI数据
			$kpi = M('kpi')->where(array('month'=>$v['month'],'user_id'=>$v['tab_user_id']))->find();
			if($kpi && $kpi['month']>=201803){
				$kpiscore =  $kpi['score']-100;
			}else{
				$kpiscore =  0;	
			}
			
			//KPI加减分
			$sum_total_score += $kpiscore;
			
			//KPI
			$lists[$k]['total_kpi_score']   = show_score($kpiscore);
			
			//合计
			$lists[$k]['sum_total_score']   =  show_score($sum_total_score);
			
			
		}
		
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		
		//整理关键字
		/*
		$userwhere = '`status`=0';
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==28 || cookie('roleid')==43 || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==11){}else{
			$userwhere .= ' AND `id` in ('.Rolerelation(cookie('roleid')).') || `id` = '.cookie('userid').'';
		}
		*/
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
		
		$this->bkpr 		= $bkpr;
		$this->bkprnm 	= $bkprnm;
		$this->year 		= $year;
		$this->month 	= $month;
		$this->prveyear	= $year-1;
		$this->nextyear	= $year+1;
		$this->display('pdcaresult');
    }
	
	
	
	
	
	
	
	
    // @@@NODE-3###pdca###PDCA###
    public function pdca(){
        $this->title('PDCA');
		$year = I('year',date('Y'));
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
		/*
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==14 || cookie('roleid')==28 || cookie('roleid')==43 || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==13  || cookie('userid')==11){}else{
			$where .= ' AND (`tab_user_id` in ('.Rolerelation(cookie('roleid')).') || `eva_user_id` = '.cookie('userid').')';
		}
		*/
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
			
			//修正品质检查评分
			qa_score_num($v['tab_user_id'],$v['month']);
		}
		
		$this->show     = $show;
		$this->lists    = $lists; 
		$this->pdcasta  = C('PDCA_STATUS');
		
		
		
		//整理关键字
		$role 		= M('role')->GetField('id,role_name',true);
		$user 		= M('account')->where(array('status'=>0))->select();
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
		$this->year 		= $year;
		$this->prveyear		= $year-1;
		$this->nextyear		= $year+1;
		$this->userkey 		= json_encode($key);
			
			
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
                $lists[$K]['score']  = $v['score_status'] ? 	$v['score']  : '<font color="#999">未评分</font>';
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
                $total += $v['score_status'] ? $v['score'] : $v['weight'];
            }
            if($total > 100){
                $this->totalstr = '<span class="red" style="font-size:16px;">当前各项总分为'.$total.'，PDCA总分不允许超过100分！</span>';
            }else if($total == 100){
                $this->totalstr = '<span class="blue" style="font-size:16px;">当前各项总分为'.$total.'，被考评人本月不扣分！</span>';
            }else{
                $koufen = 100-$total;
                $this->totalstr = '<span class="yellow" style="font-size:16px;">被考评人本月已扣'.$koufen.'分！</span>';
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
			
			//判断是否全部评分
			$isok = M('pdca_term')->where(array('pdcaid'=>$id,'score_status'=>0))->find();
			if($isok) $this->error('请将所有项目打分完毕再确认');	 
			
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
		if(cookie('userid')==$pdca['eva_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){}else{
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			//保存分数
			$info = I('info');
			$info['score_status']  = 1;
			if($info['score'] > $info['weight'])  $this->error('评分不能超出权重分');	
			
			M('pdca_term')->data($info)->where(array('id'=>$id))->save();
			
			
			//汇总总分
			$pdcalist = M('pdca_term')->where(array('pdcaid'=>$team['pdcaid']))->select();
			$total = 0;
			foreach($pdcalist as $k=>$v){
				$total += $v['score_status']	? $v['score'] : $v['weight'];
			}
			
			$data = array();
			$data['total_score']      = $total;
			$issave = M('pdca')->data($data)->where(array('id'=>$team['pdcaid']))->save();
			
			
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
			//if(!$info['complete'])   $this->error('完成情况及未完成原因');

			
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
		$this->year		= I('year',date('Y'));
		//$this->type   = intval(I('type',2));
		$this->uid		= I('uid',0);
		$this->month	= I('month');
		$this->user   	= I('user','');
		
		/*
		if($this->type < 0 || $this->type >2){
			$this->error('数据不存在');	
		}
		*/
		
		if($this->uid || $this->user){
			$where = array();
			if($this->user)    $where['a.nickname'] = trim($this->user);
			if($this->uid)     $where['u.user_id'] = $this->uid;
			if($this->month)   $where['q.month'] = $this->month;
			$lists		= M()->table('__QAQC_USER__ as u')->field('q.*')->join('__QAQC__ as q on q.id = u.qaqc_id')->join('__ACCOUNT__ as a on a.id = u.user_id')->where($where)->order($this->orders('id'))->group('u.qaqc_id')->select();
			
		}else{
			$where = array();
			if($this->month)   $where['month'] = $this->month;
			$pagecount		= $db->where($where)->count();
			$page			= new Page($pagecount, P::PAGE_SIZE);
			$this->pages 	= $pagecount>P::PAGE_SIZE ? $page->show():'';
			$lists			= $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
		}
		
		$stastr = array(
			'0' => '<span>未审核</span>',
			'1' => '<span class="green">审核通过</span>',
			'2' => '<span class="red">审核未过</span>',
		);
		
		
        
		foreach($lists as $k=>$v){
			//$lists[$k]['score']      = $v['status'] ? '-'.$v['red_score']:'+'.$v['inc_score']; 	
			$lists[$k]['statusstr']  = $stastr[$v['status']]; 	
		}
		
		$this->lists    = $lists; 
		$this->prveyear	= $this->year-1;
		$this->nextyear	= $this->year+1;
		$this->display('qa');	
	}
	
    
	
	// @@@NODE-3###addpdca###发布品质检查###
	public function addqa(){
		
		if(isset($_POST['dosubmit'])){
			
			
			$editid   = I('editid');
			$info     = I('info');
			$qadata   = I('qadata');
			
			
			//获取相关人员信息
			if($info['rp_user_name']){
				$user = getuserinfo($info['rp_user_name']);	
				$info['rp_user_id']  = $user['userid'];
			}else{
				$info['rp_user_id']  = 0;
			}
			if($info['ld_user_name']){
				$user = getuserinfo($info['ld_user_name']);	
				$info['ld_user_id']  = $user['userid'];
			}else{
				$info['ld_user_id']  = 0;
			}
			if($info['fd_user_name']){
				$user = getuserinfo($info['fd_user_name']);	
				$info['fd_user_id']  = $user['userid'];
			}else{
				$info['fd_user_id']  = 0;
			}
			if($info['ac_user_name']){
				$user = getuserinfo($info['ac_user_name']);	
				$info['ac_user_id']  = $user['userid'];
			}else{
				$info['ac_user_id']  = 0;
			}
			
			
			
			//执行保存
			if($editid){
				
				$qaqc    = M('qaqc')->find($editid);
				
				if($qaqc['status']==0 && ( C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 ||  cookie('userid')==$qaqc['inc_user_id'])) {
					
					$addinfo = M('qaqc')->data($info)->where(array('id'=>$editid))->save();
					$qaqc    = M('qaqc')->find($editid);
					$qaqcid  = $editid;
					$status  = $qaqc['status'];
				}else{
					$this->error('您没有权限修改该信息');		
				}
			}else{
				$info['create_time']       = time();
				$info['status']            = 0;
				$info['inc_user_id']       = cookie('userid');
				$info['inc_user_name']     = cookie('name');
				$qaqcid  = M('qaqc')->add($info);
				$status  = 0;
			}
			
			
			//保存相关人员信息
			if(M('qaqc_user')->where(array('qaqc_id'=>$qaqcid))->find()){
				M('qaqc_user')->where(array('qaqc_id'=>$qaqcid))->delete();
			}
			foreach($qadata as $k=>$v){
				if($v['user_name']){
					$user = getuserinfo($v['user_name']);	
					$data = array();
					$data['qaqc_id']      = $qaqcid;
					$data['user_id']      = $user['userid'];
					$data['user_name']    = $v['user_name'];
					$data['type']  		  = $v['type'];
					$data['month']  	  = $info['month'];
					$data['score']  	  = $v['score'];
					$data['remark']  	  = $v['remark'];
					$data['status']       = $status;
					$data['update_time']  = time();
					
					//判断是否存在
					$where = array();
					$where['qaqc_id']      = $qaqcid;
					$where['user_id']      = $v['user_name'];
					$is = M('qaqc_user')->where($where)->find();
					if(!$is){
						M('qaqc_user')->add($data);	
					}
					
					
				}
			}
			
			
			
			$this->success('信息已保存！',I('referer'));
			
		
		}else{
			
			$id = I('id','');
			if($id){
				$this->row      = M('qaqc')->find($id);
				$this->userlist = M('qaqc_user')->where(array('qaqc_id'=>$id))->select();
				
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
			
			$this->display('addqaqc');
		
		}
	}
	
	
	// @@@NODE-3###addpdca###审核品质检查###
	public function appqa(){
		
		if(isset($_POST['dosubmit'])){
			
			
			$editid   = I('editid');
			$info     = I('info');
			$qadata   = I('qadata');
			
			
			//获取相关人员信息
			if($info['rp_user_name']){
				$user = getuserinfo($info['rp_user_name']);	
				$info['rp_user_id']  = $user['userid'];
			}else{
				$info['rp_user_id']  = 0;
			}
			if($info['ld_user_name']){
				$user = getuserinfo($info['ld_user_name']);	
				$info['ld_user_id']  = $user['userid'];
			}else{
				$info['ld_user_id']  = 0;
			}
			if($info['fd_user_name']){
				$user = getuserinfo($info['fd_user_name']);	
				$info['fd_user_id']  = $user['userid'];
			}else{
				$info['fd_user_id']  = 0;
			}
			if($info['ac_user_name']){
				$user = getuserinfo($info['ac_user_name']);	
				$info['ac_user_id']  = $user['userid'];
			}else{
				$info['ac_user_id']  = 0;
			}
			
			if($info['status']){
				$info['ex_user_id']       = cookie('userid');
				$info['ex_user_name']     = cookie('name');
				$info['ex_time']          = time();
			}
			
			
			//执行保存
			$addinfo = M('qaqc')->data($info)->where(array('id'=>$editid))->save();
			$qaqc    = M('qaqc')->find($editid);
			$qaqcid  = $editid;
			$status  = $qaqc['status'];
		
			//保存相关人员信息
			if(M('qaqc_user')->where(array('qaqc_id'=>$qaqcid))->find()){
				M('qaqc_user')->where(array('qaqc_id'=>$qaqcid))->delete();
			}
			foreach($qadata as $k=>$v){
				if($v['user_name']){
					$user = getuserinfo($v['user_name']);	
					$data = array();
					$data['qaqc_id']      = $qaqcid;
					$data['user_id']      = $user['userid'];
					$data['user_name']    = $v['user_name'];
					$data['type']  		  = $v['type'];
					$data['month']  	  = $info['month'];
					$data['score']  	  = $v['score'];
					$data['remark']  	  = $v['remark'];
					$data['status']       = $status;
					$data['update_time']  = time();
					
					//判断是否存在
					$where = array();
					$where['qaqc_id']      = $qaqcid;
					$where['user_id']      = $v['user_name'];
					$is = M('qaqc_user')->where($where)->find();
					if(!$is){
						M('qaqc_user')->add($data);	
					}
					
					//修正绩效评分
					qa_score_num($user['userid'],$info['month']);
					
				}
			}
			
			if($info['status']==1){
				//发送公告
				$title       = $info['title'];
				$content     = $info['chen'].'<br>'.$info['reason'].'<br>'.$info['verif'];
				$url    	 = '';
				$source      = 1;
				$source_id   = $qaqcid;
				send_notice($title,$content,$url,$source,$source_id);
			}
			
			
			$this->success('已审批！',I('referer'));
			
		
		}else{
			
			$id = I('id','');
			if($id){
				$this->row      = M('qaqc')->find($id);
				$this->userlist = M('qaqc_user')->where(array('qaqc_id'=>$id))->select();
				
				if(C('RBAC_SUPER_ADMIN')!=cookie('username') && cookie('roleid')!=10){
					if($this->row['status']!=0) {
						$this->error('该信息已审批');	
					}
				}
				
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
			
			$this->display('appqaqc');
		
		}
	}
	
	
	// @@@NODE-3###qadetail###查看品质检查详情###
	public function qadetail(){
		
		$stastr = array(
			'0' => '<span>未审核</span>',
			'1' => '<span class="green">审核通过</span>',
			'2' => '<span class="red">审核未过</span>',
		);
		
		$id = I('id','');
		if($id){
			$row = M('qaqc')->find($id);
			
			$row['reason']     = $row['reason'] ? nl2br($row['reason']) : '无';
			$row['chen']       = $row['chen'] ? nl2br($row['chen']) : '无';
			$row['verif']      = $row['verif'] ? nl2br($row['verif']) : '无';
			$row['statusstr']  = $stastr[$row['status']];
			
			$this->row         = $row;
			$this->userlist    = M('qaqc_user')->where(array('qaqc_id'=>$id))->select();
			
			$this->pdca        = M('pdca')->find($row['pdcaid']);
			
		}else{
			echo '<script>art_show_msgd(\'品质检查信息不存在\');</script>';	
		}
		$this->display('qa_detail');
		
	}
	
	
	// @@@NODE-3###revoke###撤销品质检查信息###
	public function revoke(){
		$id = I('id','');
		
		M('qaqc')->delete($id);
		
		//撤销评分
		$list = M('qaqc_user')->where(array('qaqc_id'=>$id))->select();
		foreach($list as $k=>$v){
			//修正绩效评分
			M('qaqc_user')->where(array('id'=>$v['id']))->delete();
			qa_score_num($v['user_id'],$v['month']);
		}
		
		
		M('notice')->where(array('source'=>1,'source_id'=>$id))->delete();
		
		
		$this->success('撤销成功！');
		
		/*
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
		*/
			
	}
	
	
	
	
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////
	
	
	// @@@NODE-3###kpi###KPI###
    public function kpi(){
        $this->title('KPI');
		
		
		$this->year  = I('year',date('Y'));
		$this->month = I('month',date('m'));
		
		
		if($show) $bkpr = cookie('userid');
		
		$db = M('kpi');
		
		$where = '';
		$where .= '1 = 1';
		if($month) $where .= ' AND `month` = '.trim($month); 
		if($kpr)   $where .= ' AND `ex_user_id` = '.$kpr; 
		if($bkpr)  $where .= ' AND `user_id` = '.$bkpr; 
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==28 || cookie('roleid')==43){}else{
			$where .= ' AND (`user_id` in ('.Rolerelation(cookie('roleid')).') || `ex_user_id` = '.cookie('userid').')';
		}
		
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
			$lists[$k]['kaoping']      = $v['mk_user_id'] ? '<a href="'.U('Kpi/kpi',array('bkpr'=>$v['mk_user_id'])).'">'.username($v['mk_user_id']).'</a>' : '未评分'; 	
		}
		
		$this->show     = $show;
		$this->lists    = $lists; 
		$this->pdcasta  = C('KPI_STATUS');
		
		
		
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
		$this->prev_month   = date('Ym',strtotime("-1 month"));
		$this->same_month   = date('Ym');
		$this->next_month   = date('Ym',strtotime("+1 month"));
		$this->userkey =  json_encode($key);	
			
			
		$this->display('kpi');
    }
	
	
	
	// @@@NODE-3###addkpi###新建KPI###
	public function addkpi(){
		$mod            = D('Kpi');
		$year           = I('year',date('Y'));
		$month          = I('month',date('m'));
		$user           = I('uid',cookie('userid'));
        $cycle          = I('cycle',1);
        if (!$cycle) $this->error('请选择考核周期');

        $acc                = array();
        $acc['kpi_cycle']   = $cycle;
        M('account')->where(array('id'=>$user))->save($acc);

        /*//获取全年数据,保留已过考核周期月份的数据
        $delKpi                 = array();
        $delKpi['user_id']      = $user;
        $delKpi['year']         = $year;
        $delKpi['cycle']        = array('neq',$cycle);
        $delKpiIds              = '';
        for($a=$month;$a<13;$a++){
            if (strlen($a)<2) $a = str_pad($a,2,'0',STR_PAD_LEFT);
            $ym                 = $year.$a;
            $delKpi['month']    = array('like','%'.$ym.'%');
            $delKpiId           = M('kpi')->where($delKpi)->getField('id');
            $delKpiIds          = $delKpiIds.','.$delKpiId;
        }
        $arr_delKpiIds          = array_unique(array_filter(explode(',',$delKpiIds)));
        $arr                    = array();
        if ($arr_delKpiIds) $arr['id']  = array('in',$arr_delKpiIds);
        M('kpi')->where($arr)->delete();
        $delKpiMore             = array();
        $delKpiMore['kpi_id']   = array('in',$arr_delKpiIds);
        M('kpi_more')->where($delKpiMore)->delete();*/

        //获取全年数据,保留已过考核周期月份的数据
        $delKpi                 = array();
        $delKpi['user_id']      = $user;
        $delKpi['year']         = $year;
        $delKpi['cycle']        = array('neq',$cycle);
        $delKpiIds              = M('kpi')->where($delKpi)->getField('id',true);
        $delKpi['id']           = array('in',$delKpiIds);
        M('kpi')->where($delKpi)->delete();
        $delKpiMore             = array();
        $delKpiMore['kpi_id']   = array('in',$delKpiIds);
        M('kpi_more')->where($delKpiMore)->delete();

		if ($cycle == 1){   //月度
            for($i=1;$i<13;$i++){
                $mod->addKpiInfo($year,$user,$cycle,$i);
            }
        }elseif ($cycle==2){ //季度
            for ($i=1;$i<5;$i++){
                $mod->addKpiInfo($year,$user,$cycle,$month,$i);
            }
        }elseif ($cycle==3){    //半年度
            for ($i=1;$i<3;$i++){
                $mod->addKpiInfo($year,$user,$cycle,$month,'',$i);
            }
        }elseif ($cycle==4){    //年度
            $yearCycle  = 1;
            $mod->addKpiInfo($year,$user,$cycle,$month,'','',$yearCycle);
        }

		$this->success('获取成功!');
				
			
	}

	
	// @@@NODE-3###kpiinfo###KPI指标管理###
	public function kpiinfo(){
		
		$id    = I('id');
		
		$year  = I('year',date('Y'));
		$month = I('month',date('m'));
		$user  = I('uid',cookie('userid'));
		
		
		//更新数据
		updatekpi($year.$month,$user);
		
		$sta   = C('KPI_STATUS');
		
		if($id){
			$kpi   = M('kpi')->where($where)->find($id);
			$year  = $kpi['year'];
			$month = ltrim(substr($kpi['month'],4,2),0);
			$user  = $kpi['user_id'];
		}else{
			$where = array();
			$where['month']   = array('like','%'.$year.sprintf('%02s', $month).'%');
			$where['user_id'] = $user;
			$kpi = M('kpi')->where($where)->find();
		}
		
		
		
		$kpi['kaoping']      = $kpi['mk_user_id'] ? username($kpi['mk_user_id']) : '未评分'; 	
		$kpi['score']        = $kpi['mk_user_id'] ? $kpi['score'].'分' : '未评分'; 	
		$kpi['status_str']   = $sta[$kpi['status']]; 	
		
		//考核指标
		$lists = M('kpi_more')->where(array('kpi_id'=>$kpi['id']))->select();
		foreach($lists as $K=>$v){
			$lists[$K]['score']  = $v['score_status'] ?  $v['score']  : '<font color="#999">未评分</font>';
		}
		
		//审核记录
		$applist          = M('pdca_apply')->where(array('kpiid'=>$kpi['id']))->order('apply_time DESC')->select();
		foreach($applist as $k=>$v){
			$applist[$k]['status'] = $sta[$v['status']];	
		}
		
		
		//操作记录
		$applist          = M('kpi_op_record')->where(array('kpi_id'=>$kpi['id']))->order('op_time DESC')->select();
		
		
		//用户信息
		$this->user       = M('account')->find($user);
		
		$this->uid        = $user;
		$this->year       = $year;
		$this->month      = $month;
		$this->kpi        = $kpi;
		$this->lists      = $lists;
		$this->applist    = $applist;
		$this->prveyear   = $year-1;
		$this->nextyear   = $year+1;
		$this->allmonth   = $year.sprintf('%02s', $month);
		
		$this->display('kpi_info');
		
		
		
		
	}
	
	
	
	// @@@NODE-3###kpi_unitscore###单项KPI评分###
	public function kpi_unitscore(){
		
		$id = I('id',0);
		$team = M('kpi_more')->find($id);
		//查看KPI状态
		$kpi = M('kpi')->find($team['kpi_id']);
		
		//判断是否有权限评分
		if(cookie('userid')==$kpi['mk_user_id'] || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){}else{
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			//保存分数
			$info = I('info');
			$info['score_status']  = 1;
			//if($info['score'] > $info['weight'])  $this->error('评分不能超出权重分');	
			
			M('kpi_more')->data($info)->where(array('id'=>$id))->save();
			
			
			//汇总总分
			$kpilist = M('kpi_more')->where(array('kpi_id'=>$team['kpi_id']))->select();
			$total = 0;
			foreach($kpilist as $k=>$v){
				$total += $v['score_status']	? $v['score'] : $v['weight'];
			}
			
			$data = array();
			$data['score']      = $total;
			$issave = M('kpi')->data($data)->where(array('id'=>$team['kpi_id']))->save();
			
			
			echo '<script>window.top.location.reload();</script>';
		
		}else{
		
		
			if($id && $team){
				
				$this->kpi   = $kpi;
				$this->team  = $team;
				$this->display('kpi_unitscore');
				
			}else{
				$this->error('KPI不存在');	
			}
		
		}
		
	}
    
	
	// @@@NODE-3###editkpi###编辑KPI指标###
	public function editkpi(){
		
		if(isset($_POST['dosubmint'])){
			
			$editid    = I('editid');
			$info      = I('info');
			
			/*
			if(!$info['quota_title'])  $this->error('指标名称未填写');
			if(!$info['weight'])       $this->error('权重未填写');
			if(!$info['target'])       $this->error('目标未填写');
			*/
			
			$kpi = M('kpi')->find($info['kpi_id']);
			//执行保存
			if($editid){
				
				if(cookie('roleid')==43 || cookie('roleid')==44 || cookie('userid')==$kpi['user_id'] || cookie('userid')==$pdca['mk_user_id'] || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10){
					
					$km = M('kpi_more')->find($editid);
					
					//总经理修改过后，取消自动同步 43=>人事经理 44=>人事专员 10=>总经理
					if(cookie('roleid')==43 || cookie('roleid')==44 || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username')){
						$info['automatic']	= 1;
					}
					
					
					//合计完成率
					$rate = $km['target'] ? round(($info['complete'] / $km['target'])*100,2) : 100;
					$rate = $rate>100 ? 100 : $rate; 
					
					$info['complete']		= $info['complete'] ? $info['complete'] : 0;
					$info['complete_rate']	= $rate."%";
					$info['score']			= round(($rate * $km['weight']) / 100,1);
					$info['score_status']	= 1;
					
					$addinfo = M('kpi_more')->data($info)->where(array('id'=>$editid))->save();
					
					//合计总分
					$total	= M('kpi_more')->where(array('kpi_id'=>$km['kpi_id']))->sum('score');
					$data	= array();
					$data['score']      = $total;
					
					//如果是人事或者总经理修改，直接审核通过
					if(cookie('roleid')==43 || cookie('roleid')==44 || cookie('roleid')==10){
						$data['status'] = 5;	
					}
					$issave = M('kpi')->data($data)->where(array('id'=>$km['kpi_id']))->save();
					
					
					
					//保存更新记录
					$remarks = '';
					if($info['complete']!=$km['complete'])  $remarks.='完成值'.$km['complete'].'变更为'.$info['complete'].'；';
					
					if($remarks){
						$data = array();
						$data['kpi_id']        = $km['kpi_id'];
						$data['op_user_id']    = cookie('userid');
						$data['op_user_name']  = cookie('name');
						$data['op_time']       = time();
						$data['remarks']       = $km['quota_title'].'：'.$remarks;
						M('kpi_op_record')->add($data);
					}
				
				
					
				}else{
					$this->error('您没有权限保存');
				}
			}else{
				
				
				$info['userid']      = cookie('userid');
				$info['create_time'] = time();
				$info['score']       = 0;
				$addinfo = M('kpi_more')->add($info);
			}
			
			
		
			//如果是制表人保存，修正状态
			if($kpi['user_id'] == cookie('userid')){
				$issave = M('kpi')->data(array('status'=>0))->where(array('id'=>$info['kpi_id']))->save();
			}
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			$id               = I('id','');
			$kpiid            = I('kpiid',0);
			$this->kpi        = M('kpi')->find($kpiid);
			$this->row        = M('kpi_more')->find($id);
			
			
			$this->display('editkpi');
		}
	}
	
	
	
	
	
	
	// @@@NODE-3###kpi_applyscore###KPI申请评分###
	public function kpi_applyscore(){
		
		$kpiid      = I('kpiid','');
		$status     = I('status','');
		$app_remark = I('app_remark','');
		if(isset($_POST['dosubmint'])){
			
			if(!$status)   $this->error('请选择审批结果');	
			
			//查看KPI状态
			$kpi = M('kpi')->find($kpiid);
			
			$data = array();
			$data['status']         = $status;
			$apply = M('kpi')->data($data)->where(array('id'=>$kpiid))->save();
			if($apply){
				
				if($status==1){
					$title   = '['.$kpi['month'].'KPI],已整理完毕，请您审核';	
					$user    = '['.$kpi['ex_user_id'].']';
					$content = '';
				}else if($status==4){
					$title   = '['.$kpi['month'].'KPI],已整理完毕，请您评分';	
					$user = '['.$kpi['mk_user_id'].']';
					$content = $app_remark;
				}else if($status==2){
					$title   = '['.$kpi['month'].'KPI],已审核通过';	
					$user = '['.$kpi['user_id'].']';
					$content = '';
				}else if($status==3){
					$title   = '['.$kpi['month'].'KPI],审核未通过';	
					$user = '['.$kpi['user_id'].']';
					$content = $app_remark;
				}
				
				//发送消息
				$uid  = cookie('userid');
				$url  = U('Kpi/kpiinfo',array('id'=>$kpiid));
				send_msg($uid,$title,$content,$url,$user);
				
				//保存审核记录
				if($status==2 || $status==3){
					$myid = cookie('userid');
					$data = array();
					$data['kpiid']          = $kpiid;
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
			$kpiid            = I('kpiid',0);
			$this->kpi        = M('kpi')->find($kpiid);
			$this->row        = M('kpi_more')->find($id);
			
			$this->display('editkpi');
		}
		
	}
 	
	
	
	
	
	// @@@NODE-3###kpidetail###查看指标信息###
	public function kpidetail(){
		
		$id = I('id','');
		if($id){
			$row = M('kpi_config')->find($id);
			$row['quota_content']    = $row['quota_content'] ? nl2br($row['quota_content']) : '无';
			$row['method']           = $row['method'] ? nl2br($row['method']) : '无';
			$row['calculate']        = $row['calculate'] ? nl2br($row['calculate']) : '无';
			
			$this->row = $row;
			
		}else{
			echo '<script>art_show_msgd(\'PDCA项目不存在\');</script>';	
		}
		$this->display('kpi_detail');
		
	}
	
	
	// @@@NODE-3###kpi_score###KPI确认评分###
	public function kpi_score(){
		$id = I('kpiid',0);
		//查看KPI状态
		$kpi = M('kpi')->find($id);
		
		//判断是否有权限评分
		if(cookie('userid')!=$kpi['mk_user_id']){
			 $this->error('您没有权限评分');		
		}
			
		if(isset($_POST['dosubmint'])){
			
			//判断是否全部评分
			$isok = M('kpi_more')->where(array('kpi_id'=>$id,'score_status'=>0))->find();
			if($isok) $this->error('请将所有指标打分完毕再确认');	 
			
			$total = 0;
			$kpidata = M('kpi_more')->where(array('kpi_id'=>$id))->select();
			foreach($kpidata as $k=>$v){
				//合计总分
				$total += $v['score'];
			}
			
			if($total>100)   $this->error('总分不能超过100分');	
			
			
			//保存总分
			$data = array();
			$data['status']  		  = 5;
			$data['score']            = $total;
			$issave = M('kpi')->data($data)->where(array('id'=>$id))->save();
			if($issave){
				
				//发送消息
				$uid     = cookie('userid');
				$title   = '您的['.$kpi['month'].'KPI]已评分';
				$content = '';
				$url     = U('Kpi/kpiinfo',array('id'=>$id));
				$user    = '['.$kpi['user_id'].']';
				send_msg($uid,$title,$content,$url,$user,'');
				
				$this->success('已评分！');
				
			}else{
				$this->error('保存评分失败');		
			}
		
		}
	}
	
	
	
	
	// @@@NODE-3###postkpi###部门KPI管理###
	public function postkpi(){
		
		
		$pnm = M('posts')->GetField('id,post_name',true);
		$use = get_branch_user();
		
		$this->year		= I('year',date('Y'));
		$this->month	= I('month',date('m'));
		$this->post		= I('post',$use['dpid']);
		
		$postlist = array();
		
		//列举人员
		$where = array();
		/*
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid')==32 || cookie('userid')==38 || cookie('userid')==12 || cookie('userid')==11 ){}else{
			$where['group_role']	= array('like','%['.cookie('roleid').']%');
		}
		*/
		
		$where['postid']		= $this->post;
		$where['status']		= 0;
		$userlist = M('account')->field('id,nickname,roleid,postid,kpi_cycle')->where($where)->select();

	
		foreach($userlist as $k=>$v){
            $cycle              = $v['cycle'];
			//获取该用户KPI
			$where = array();
			$where['month']		= array('like','%'.$this->year.$this->month.'%');
			$where['user_id']	= $v['id'];

			//更新数据
			updatekpi($where['month'],$where['user_id']);
			
			$kpi = M('kpi_more')->field('quota_id,quota_title,target,complete,weight,score')->where($where)->order('quota_id ASC')->select();
			$userlist[$k]['kpi'] = $kpi;
			
		}
		
		//获取岗位考核指标
		$postlist		= M()->table('__KPI_POST_QUOTA__ as p')->join('__KPI_CONFIG__ as c on c.id = p.quotaid')->where(array('p.postid'=>$this->post))->GetField('c.id,c.quota_title',true);
		
		
		$this->title	= $this->year.$this->month.' - '.$pnm[$this->post].' - KPI考核';
		$this->kpils	= $userlist;
		$this->upost	= $use['pid'];
		$this->postlist = $postlist;
		$this->prveyear	= $this->year-1;
		$this->nextyear	= $this->year+1;
		$this->check 	= count($postlist);
		$this->display('kpi_post');
		
		
		
		
	}

	//kpi排行
	public function kpiChart(){
        $pin            = I('pin')?I('pin'):'00';
        //if ($pin=='00'){ $this->get_initialize(); }    //初始化KPI数据
        $year           = I('year',date('Y'));
        $where          = array();
        $where['status']= array('neq',2);
        $where['id']    = array('gt',10);
        $where['employee_member'] = array('neq','');
        if ($pin && $pin !=100) $where['rank'] = $pin;

        //分页
        //$pagecount		= M('account')->field('id,nickname')->where($where)->count();
        //$page			= new Page($pagecount, P::PAGE_SIZE);
        //$this->pages 	= $pagecount>P::PAGE_SIZE ? $page->show():'';
        //$accountlists   = M('account')->field('id,nickname,rank')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        $accountlists   = M('account')->field('id,nickname,rank,employee_member,kpi_cycle')->where($where)->order('employee_member ASC')->select();
        $kpiLists       = $this->getKpiResult($accountlists,$year,$pin); //获取KPI数据
        $lists          = $this->getKpiCycle($kpiLists); //获取最终考核结果显示的月份

        $this->lists    = $lists;
        $this->pin      = $pin;
        $this->year 	= $year;
        $this->prveyear	= $year-1;
        $this->nextyear	= $year+1;
        $this->display();
    }

    //获取KPI数据
    private function getKpiResult($accountlists,$year,$pin){
        $kpilists                                           = M('kpi')->where(array('year'=>$year))->select();
        foreach ($accountlists as $k=>$v){
            $lists[$k]                                      = $v;
            if ($v['rank']=='00')   $lists[$k]['ranks']     = '0队列';
            if ($v['rank']=='01')   $lists[$k]['ranks']     = '1队列';
            if ($v['rank']=='02')   $lists[$k]['ranks']     = '2队列';
            if ($v['rank']=='03')   $lists[$k]['ranks']     = '3队列';
            if ($v['kpi_cycle']==1) $lists[$k]['cycle']     = '月度';
            if ($v['kpi_cycle']==2) $lists[$k]['cycle']     = '季度';
            if ($v['kpi_cycle']==3) $lists[$k]['cycle']     = '半年度';
            if ($v['kpi_cycle']==4) $lists[$k]['cycle']     = '年度';
            $lists[$k]['kpi_cycle']                         = $v['kpi_cycle'];

            $sum_score                                      = 0; //总分
            foreach ($kpilists as $key=>$value){
                $lists[$k]['year']      = $year;
                if ($value['user_id']==$v['id']){
                    $num                = $this->get_month_num($value['cycle'],$year,date('m'),date('d'));
                    $arr_months         = $this->get_kpi_cycle_months($v['kpi_cycle'],$year);
                    if (in_array($value['month'],$arr_months) &&  date('Ym')>= $year.date('m')){
                        $dm             = substr($value['month'],4,2);
                        $lists[$k]['kpi'][$dm] = $value['score'];
                        $sum_score      += $value['score'];
                    }
                }
            }
            if ($pin =='02'){
                $time_info              = get_this_month();
                $year                   = $time_info['year'];
                $month                  = $time_info['month'];
                $yearMonth              = $year.$month;
                $where                  = array();
                $where['user_id']       = $v['id'];
                $where['year']          = $year;
                $where['quota_id']      = array('neq',1); //排除月度累计毛利额
                $where['month']         = array('elt',$yearMonth);
                $kpi_more_lists         = M('kpi_more')->where($where)->select();
                $maoli_score            = M('kpi_more')->where(array('user_id'=>$v['id'],'year'=>$year,'month'=>$yearMonth,'quota_id'=>1))->getField('score'); //当月月度累计毛利额得分
                $month_num              = count(array_unique(array_column($kpi_more_lists,'month')));
                $sum_other_score        = array_sum(array_column($kpi_more_lists,'score'));
                $lists[$k]['average']   = round($sum_other_score/$month_num,2) + $maoli_score;
            }else{
                $lists[$k]['average']   = round($sum_score/$num,2);
            }
        }
        return $lists;
    }

    public function get_month_num($cycle=1,$year,$month,$day){
        $month                  = $month?$month:date('m');
        $day                    = $day?$day:date('d');
        switch ($cycle){
            case 1: //月度
                if ($year < date('Y')){
                    $num                = 12;
                }else{
                    if($day > 0 && $day < 26){
                        $num                = (int)$month;
                    }else{
                        if ($month==12){
                            $num            = 1;
                        }else{
                            $num            = $month + 1;
                        }
                    }
                }
                break;
            case 2: //季度
                if ($year < date('Y')){
                    $num                = 4;
                }else {
                    if ($day > 0 && $day < 26) {
                        if ($month > 1 && $month <= 3) {
                            $num = 1;
                        } elseif ($month > 3 && $month <= 6) {
                            $num = 2;
                        } elseif ($month > 6 && $month <= 9) {
                            $num = 3;
                        } elseif ($month > 9 && $month <= 12) {
                            $num = 4;
                        }
                    } else {
                        if ($month >= 1 && $month < 3 || $month==12){
                            $num = 1;
                        } elseif ($month >= 3 && $month < 6) {
                            $num = 2;
                        } elseif ($month >= 6 && $month < 9) {
                            $num = 3;
                        } elseif ($month >= 9 && $month < 12) {
                            $num = 4;
                        }
                    }
                }
                break;
            case 3: //半年度
                if ($year < date('Y')){
                    $num                = 2;
                }else {
                    if ($day > 0 && $day < 26) {
                        if ($month > 1 && $month <= 6) {
                            $num = 1;
                        } elseif ($month > 6 && $month <= 12) {
                            $num = 2;
                        }
                    } else {
                        if ($month == 12) {
                            $num = 1;
                        } else {
                            if ($month >= 1 && $month < 6 || $month==12){
                                $num = 1;
                            } elseif ($month >= 6 && $month < 12) {
                                $num = 2;
                            }
                        }
                    }
                }
                break;
            case 3: //年度
                $num = 1;
                break;
        }
        return $num;
    }

    public function get_kpi_cycle_months($cycle,$year){
        switch ($cycle){
            case 1: //月度
                $months                 = array($year.'01',$year.'02',$year.'03',$year.'04',$year.'05',$year.'06',$year.'07',$year.'08',$year.'09',$year.'10',$year.'11',$year.'12');
                break;
            case 2: //季度
                $months                 = array($year.'01,'.$year.'02,'.$year.'03',$year.'04,'.$year.'05,'.$year.'06',$year.'07,'.$year.'08,'.$year.'09',$year.'10,'.$year.'11,'.$year.'12');
                break;
            case 3: //半年度
                $months                 = array($year.'01,'.$year.'02,'.$year.'03,'.$year.'04,'.$year.'05,'.$year.'06',$year.'07,'.$year.'08,'.$year.'09,'.$year.'10,'.$year.'11,'.$year.'12');
                break;
            case 4: //年度
                $months                 = array($year.'01,'.$year.'02,'.$year.'03,'.$year.'04,'.$year.'05,'.$year.'06,'.$year.'07,'.$year.'08,'.$year.'09,'.$year.'10,'.$year.'11,'.$year.'12');
        }
        return $months;
    }

    //获取最终考核结果显示的月份
    private function getKpiCycle($lists){
        foreach ($lists as $k=>$v){
            if ($v['kpi_cycle']=='2'){ //季度
                $lists[$k]['finalMonth']    = array('03','06','09','12');
            }elseif($v['kpi_cycle']=='3'){ //半年度
                $lists[$k]['finalMonth']    = array('06','12');
            }elseif($v['kpi_cycle']=='4'){ //年度
                $lists[$k]['finalMonth']    = array('12');
            }else{ //月度
                $lists[$k]['finalMonth']    = array('01','02','03','04','05','06','07','08','09','10','11','12');
            }
        }

        $lists                              = multi_array_sort($lists,'average');  //排序(平均值由高到低)
        return $lists;
    }

    //关键事项评价
    public function crux(){
        $this->title('关键事项评价');
        $mod                                = D('Kpi');
        $pin                                = I('pin',0);
        $user_name                          = trim(I('uname'));
        $title                              = trim(I('title'));
        $month                              = trim(I('month')); //kpi

        $where                              = array();
        if ($pin == 1) $where['status']     = 0; //未批准
        if ($pin == 2) $where['status']     = 1; //已批准
        if ($user_name)$where['user_name']  = array('like','%'.$user_name.'%');
        if ($title)    $where['title']      = array('like','%'.$title.'%');
        if ($month)    $where['month']      = $month;

        $pagecount		                    = M('kpi_crux')->where($where)->count();
        $page			                    = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	                    = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                              = M('kpi_crux')->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('id'))->select();
        foreach ($lists as $k=>$v){
            if ($v['cycle']==1){
                $lists[$k]['cycle_stu']     = '月度';
            }elseif ($v['cycle']==2){
                $lists[$k]['cycle_stu']     = '季度';
            }
            $lists[$k]['cruxinfo_url']      = U('Kpi/public_crux_info',array('id'=>$v['id'])); //详情url
            $lists[$k]['scorecrux_url']     = U('Kpi/scorecrux',array('id'=>$v['id'])); //打分url
            $lists[$k]['addcrux_url']       = U('Kpi/add_crux',array('id'=>$v['id'])); //编辑url
            $lists[$k]['delcrux_url']       = U('Kpi/delcrux',array('id'=>$v['id'])); //删除url
            $lists[$k]['score']             = floatval($v['score']).'%'; //得分
        }

        $this->lists                        = $lists;
        $this->pin                          = $pin;
        $this->display();
    }

    //添加关键事项
    public function add_crux(){
        $id                                 = I('id');
        $mod                                = D('Kpi');
        $year                               = I('year',date('Y'));
        $userkey                            = $mod->get_kpi_crux_username();
        $list                               = M('kpi_crux')->find($id);
        $remainder_weight                   = $mod->get_upd_crux_remainder_weight($list['user_id'],$list['month'],$id); //获取剩余权重

        $this->row                          = $list;
        $this->remainder_weight             = $remainder_weight?$remainder_weight:100;
        $this->userkey                      = $userkey;
        $this->year                         = $list['year']?$list['year']:$year;
        $this->display();
    }

    public function public_save(){
        $savetype                           = trim(I('savetype'));
        if (isset($_POST['dosubmint']) && $savetype){
            //保存关键事项
            if ($savetype == 1){
                $mod                        = D('Kpi');
                $db                         = M('kpi_crux');
                $id                         = I('id');
                $info                       = I('info');
                $where                      = array();
                $where['user_id']           = $info['user_id'];
                $where['month']             = $info['month'];
                $where['quota_id']          = 216;
                $kpi_more_info              = M('kpi_more')->where($where)->find();
                $info['kpi_id']             = $kpi_more_info['kpi_id'];
                $info['kpi_more_id']        = $kpi_more_info['id'];
                $info['standard']           = trim($info['standard']);
                $info['title']              = trim($info['title']);
                $info['content']            = trim($info['content']);

                if ($info['year'] && $info['month'] && $info['kpi_id'] && $info['kpi_more_id']){
                    if ($id){
                        $res                = $db->where(array('id'=>$id))->save($info);
                        $operation          = '修改';
                    }else{
                        $info['create_user_id']   = session('userid');
                        $info['create_user_name'] = session('nickname');
                        $info['create_time']= NOW_TIME;
                        $res                = $db->add($info);
                        $operation          = '添加';
                    }
                }

                if ($res){
                    $this->msg              = '<span class="green">保存成功</span>';
                    $this->time             = 1000;
                    $record                 = $operation.'关键事项：'.$info['title'];
                    $mod->save_kpi_record($info['kpi_id'],$record); //保存操作记录
                }else{
                    $this->msg              = '<span class="red">保存失败</span>';
                    $this->time             = 3000;
                }
                $this->display('audit_ok');
            }

            //保存关键事项评分
            if ($savetype == 2){
                $mod                        = D('Kpi');
                $db                         = M('kpi_crux');
                $id                         = I('id');
                $info                       = I('info');
                $info['score']              = trim(str_replace('%','',$info['score']));
                $info['audit_suggest']      = trim($info['audit_suggest']);
                $info['audit_user_id']      = session('userid');
                $info['audit_user_name']    = session('nickname');
                $info['audit_time']         = NOW_TIME;
                $info['status']             = 1; //已审批
                if ($id) $res               = $db->where(array('id'=>$id))->save($info);
                if ($res){
                    $this->msg              = '<span class="green">保存成功</span>';
                    $this->time             = 1000;

                    $list                   = $db->find($id);
                    $record                 = '关键事项评分：'.$list['title'].'--'.$info['score'].'分';
                    $mod->save_kpi_record($list['kpi_id'],$record); //保存操作记录
                }else{
                    $this->msg              = '<span class="red">保存失败</span>';
                    $this->time             = 3000;
                }
                $this->display('audit_ok');
            }
        }
    }

    //关键事项评分
    public function scorecrux(){
        $mod                                = D('Kpi');
        $id                                 = I('id');
        $list                               = $mod->get_crux_info($id);


        $this->list                         = $list;
        $this->display();
    }

    //关键事项详情
    public function public_crux_info(){
        $mod                                = D('Kpi');
        $id                                 = I('id');
        $list                               = $mod->get_crux_info($id);
        $this->list                         = $list;
        $this->display('crux_info');
    }

    //删除关键事项
    public function delcrux(){
        $mod                                = D('Kpi');
        $db                                 = M('kpi_crux');
        $id                                 = I('id');
        $list                               = $db->find($id);
        $res                                = $db->delete($id);
        if ($res){
            $record                         = '删除关键事项评分：'.$list['title'];
            $mod->save_kpi_record($list['kpi_id'],$record); //保存操作记录

            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
	
	public function test(){
		P(team_new_customers(35,array(strtotime('2018-01-01'),strtotime('2018-01-25'))));
	}



	
	
	
}