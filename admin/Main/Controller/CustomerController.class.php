<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;
ulib('Pinyin');
use Sys\Pinyin;

// @@@NODE-2###Customer###销售管理###
class CustomerController extends BaseController {
    
    protected $_pagetitle_ = '销售管理';
    protected $_pagedesc_  = '';
    
	
	
	// @@@NODE-3###o2o###支撑服务校记录###
    public function o2o(){
        $this->title('支撑服务校记录');

		$db                 = M('customer_gec');
		$keywords           = I('keywords');
		$type               = I('type');
		$cm                 = I('cm');
		$address            = I('address');
		$province           = I('province');
		$city               = I('city');
		$county             = I('county');
		$level              = I('level');
		$qianli             = I('qianli');
		
		$where              = array();
		$where['status']	= 1;
		$where['com']		= 1;
		if($keywords)       $where['company_name'] = array('like','%'.$keywords.'%');
		if($type)           $where['type'] = $type;
		if($address)        $where['contacts_address'] = array('like','%'.$address.'%');
		if($cm)             $where['cm_name'] = array('like','%'.$cm.'%');
		if($province)       $where['province'] = array('like','%'.$province.'%');
		if($city)           $where['city'] = array('like','%'.$city.'%');
		if($county)         $where['county'] = array('like','%'.$county.'%');
		if($level)          $where['level'] = array('like','%'.$level.'%');
		if($qianli)         $where['qianli'] = array('like','%'.$qianli.'%');
		
		//分页
		$pagecount          = $db->where($where)->count();
		$page               = new Page($pagecount, P::PAGE_SIZE);
		$this->pages        = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists              = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$hz             = M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->order('create_time DESC')->find();
			$lists[$k]['hezuo'] = $hz['create_time'] ? '<a href="'.U('Op/index',array('cus'=>$v['company_name'])).'">'.date('Y-m-d',$hz['create_time']).'</a>' : '无结算记录';
			$lists[$k]['hezuocishu'] = $hz['create_time'] ? M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->count() : '';	
		}

		$this->lists        = $lists;
		$this->display('o2o');
    }
	
	// @@@NODE-3###GEC###分配客户###
	public function o2o_apply(){
		
		$fid		= I('fid');
		if(isset($_POST['dosubmit']) && $fid){
			
			$userid = I('userid');
			$user	= M('account')->find($userid);
			$fid	= str_replace(".",",",$fid);
			
			//保存数据
			$data = array();
			$data['cm_id']		= $userid;
			$data['cm_name']	= $user['nickname'];
			$data['status']		= 0;
			M('customer_gec')->data($data)->where(array('id'=>array('in',$fid)))->save();
			
			echo '<script>window.top.location.reload();</script>';
			
		}else{
			
			//用户列表
			$key		= I('key');
			$db			= M('account');
			$where		= array();
			$where['postid'] = array('in','1,2,4,31,32');
			$where['status'] = 0;
			if($key) $where['nickname'] = array('like','%'.$key.'%');
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount,6);
			$this->pages = $pagecount>6 ? $page->show():'';
			$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
			$this->role  =  M('role')->getField('id,role_name', true);
			$this->fid   = $fid;
			$this->display('o2o_apply');
		}
		
		
	}
	
	
    // @@@NODE-3###GEC###政企客户管理###
    public function GEC(){
        $this->title('政企客户管理');
		
		
		$db = M('customer_gec');
		$keywords     = I('keywords');
		$type         = I('type');
		$cm           = I('cm');
		$address      = I('address');
		$province     = I('province');
		$city         = I('city');
		$county       = I('county');
		$level        = I('level');
		$qianli       = I('qianli');
		
		$where = array();
		$where['status']	= 0;
		if($keywords)    $where['company_name'] = array('like','%'.$keywords.'%');
		if($type)        $where['type'] = $type;
		if($address)     $where['contacts_address'] = array('like','%'.$address.'%');
		if($cm)          $where['cm_name'] = array('like','%'.$cm.'%');
		if($province)    $where['province'] = array('like','%'.$province.'%');
		if($city)        $where['city'] = array('like','%'.$city.'%');
		if($county)      $where['county'] = array('like','%'.$county.'%');
		if($level)       $where['level'] = array('like','%'.$level.'%');
		if($qianli)      $where['qianli'] = array('like','%'.$qianli.'%');
		
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || in_array(cookie('roleid'),array(10,11,14,28,30,45,47))){
			
		}else{
			$where['cm_id'] = array('in',Rolerelation(cookie('roleid')));
		}
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$hz = M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->order('create_time DESC')->find();	
			$lists[$k]['hezuo'] = $hz['create_time'] ? '<a href="'.U('Op/index',array('cus'=>$v['company_name'])).'">'.date('Y-m-d',$hz['create_time']).'</a>' : '无结算记录';
			$lists[$k]['hezuocishu'] = $hz['create_time'] ? M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->count() : '';	
		    $lists[$k]['hide_mobile']= hide_mobile($v['contacts_phone']);
		}
		$this->lists   = $lists;
		
		$this->display('GEC');
    }
	
	

	
    public function op(){
      
		$db = M('customer_gec');
		$PinYin = new Pinyin();
		$id = M('op')->where(array('customer'=>array('like','%散客%')))->Getfield('id',true);

		$where = array();
		$where['customer'] = array('neq','NULL');
		$where['id'] = array('not in',implode(',',$id));
		$where['customer'] = array('neq',' ');
		
		$i = 0;
		$list = M('op')->field('customer,create_user,create_user_name,create_time')->where($where)->group('customer')->select();
		foreach($list as $v){
			$company_name = iconv("utf-8","gb2312",trim($v['customer']));
			$data = array();
			$data['company_name'] = $v['customer'];
			$data['cm_id'] = $v['create_user'];
			$data['cm_name'] = $v['create_user_name'];
			$data['cm_time'] = $v['create_time'];
			$data['create_time'] = $v['create_time'];
			$data['pinyin'] = strtolower($PinYin->getFirstPY($company_name));	
			if(!M('customer_gec')->where(array('company_name'=>$v['customer'],'cm_id'=>$v['create_user']))->find()){
				$aaa = M('customer_gec')->add($data);
				if($aaa) $i++;
			}
		}
		
		echo $i;
    }
	
	
	
	
	// @@@NODE-3###GEC_edit###编辑政企客户###
    public function GEC_edit(){
        $this->title('政企客户管理');
		
		$db                     = M('customer_gec');
		$id                     = I('id');
		$referer                = I('referer');
		$PinYin                 = new Pinyin();
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$gec_id             = I('gec_id');
			$info               = I('info');
			$info['cm_time']    = time();
			$company_name       = iconv("utf-8","gb2312",trim($info['company_name']));
			$info['pinyin']     = strtolower($PinYin->getFirstPY($company_name));
			if (!$info['cm_id']){ $this->error('维护人信息错误,请选择匹配到的人员信息'); }
			
			if($info){
			    $info['company_name']   = trim($info['company_name']);
			    $info['level']          = trim($info['level']);
			    $info['type']           = trim($info['type']);
			    $info['contacts']       = trim($info['contacts']);
			    $info['post']           = trim($info['post']);
			    $info['contacts_phone'] = trim($info['contacts_phone']);
			    $info['county']         = trim($info['county']);
			    $info['remark']         = trim($info['remark']);

				if($gec_id){
					$u          = $db->find($gec_id);
					if($u['cm_id']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || in_array(cookie('roleid'),array(10,11,28,30))){
						$isok = $db->data($info)->where(array('id'=>$gec_id))->save();
					}else{
						$this->error('您没有权限修改该用户信息' . $db->getError());		
					}
				}else{
					$info['create_time'] = time();
					$isok = $db->add($info);
				}
				
				if($isok){
					$this->success('保存成功！',$referer);		
				}else{
					$this->error('保存失败' . $db->getError());	
				}
				
			}else{
				$this->error('请填写企业信息' . $db->getError());	
			}
			
		}else{
			$this->gec                  = $db->find($id);
			$this->userkey              = get_username();
			//合作记录
			$where                      = array();
			$where['o.customer']        = $this->gec['company_name'];
			$where['s.audit_status']    = 1;
			$this->hezuo                = M()->table('__OP_SETTLEMENT__ as s')->field('s.*,o.group_id,o.project')->join('__OP__ as o on o.op_id = s.op_id','LEFT')->where($where)->select();
			
			$this->display('GEC_edit');
		}
		
		
    }
	
	// @@@NODE-3###GEC_transfer###交接客户###
	public function GEC_transfer(){
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$referer = I('referer');
			$fm      = I('fm');
			$fmid    = I('fmid');
			$to      = I('to');
			$toid    = I('toid');
			$gec     = I('gec');
			
			if(!$toid){
				$user = M('account')->where(array('nickname'=>$to))->find();	
				$toid = $user['id'];
			}
			$i = 0;
			foreach($gec as $k=>$v){
				$data = array();
				$data['cm_id']   = $toid;
				$data['cm_name'] = $to;
				$save = M('customer_gec')->data($data)->where(array('id'=>$v))->save();
				if($save){
					$i++;	
				}
			}
			
			$this->success('成功交接了'.$i.'条客户信息！',$referer);		
			
		}else{
			
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
			
			$this->userkey = json_encode($key);	
			$this->display('GEC_transfer');
		}
	}
	
	
	// @@@NODE-3###GEC_viwe###编辑政企客户###
    public function GEC_viwe(){
        $this->title('政企客户管理');
		
		$db = M('customer_gec');
		$id = I('id');
		$referer = I('referer');
		
		
		$this->gec       = $db->find($id);
		//合作记录
		$where = array();
		$where['o.customer'] = $this->gec['company_name'];
		$where['s.audit_status'] = 1;
		
		$this->hezuo = M()->table('__OP_SETTLEMENT__ as s')->field('s.*,o.group_id,o.project')->join('__OP__ as o on o.op_id = s.op_id','LEFT')->where($where)->select();
		
		$this->display('GEC_viwe');
		
		
		
    }
	
	
	// @@@NODE-3###delgec###删除客户###
	public function delgec(){
		$id = I('id');
		if($id){
			$isdel = M('customer_gec')->where(array('id'=>$id))->delete();
			if($isdel){
				$this->success('删除成功！');		
			}else{
				$this->error('删除失败！');	
			}
		}else{
			$this->error('数据不存在！');	
		}
	}
	
	
    // @@@NODE-3###IC###参团客户###
    public function IC(){
        $this->title('参团客户');
		
		$db = M('op_member');
		$nm = I('nm');
		$sex = I('sex');
		$no = I('no');
		$tel = I('tel');
		$ec = I('ec');
		$ectel = I('ectel');
		$dw = I('dw');
		
		$where = array();

		if($nm)    $where['name'] = array('like','%'.$nm.'%');
		if($sex)   $where['sex'] = $sex;
		if($no)    $where['number'] = array('like','%'.$no.'%');
		if($tel)   $where['mobile'] = array('like','%'.$tel.'%');
		if($ec)    $where['ecname'] = array('like','%'.$ec.'%');
		if($ectel) $where['ecmobile'] = array('like','%'.$ectel.'%');
		if($dw)    $where['remark'] = array('like','%'.$dw.'%');
		
		
		if(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==28 || cookie('roleid')==11 || cookie('roleid')==30){
			
		}else{
			$where['sales_person_uid'] = array('in',Rolerelation(cookie('roleid')));
		}
		
		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
		
		$account = M('account')->Getfield('id,nickname',true);
		
		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('sales_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['user'] = $account[$v['sales_person_uid']];	
		}
		
		$this->lists = $lists;
		
		$this->kinds   =  M('project_kind')->getField('id,name', true);
		
		$this->display('IC');
    }
	
	
	
	// @@@NODE-3###IC_edit###编辑参团客户###
    public function IC_edit(){
        $this->title('参团客户管理');
		
		$db = M('op_member');
		$id = I('id');
		$referer = I('referer');
		
		
		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){
			
			$ic_id = I('ic_id');
			$info = I('info');
			
			if($info){
				
				if($ic_id){
					$u = $db->find($ic_id);
					if($u['sales_person_uid']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==28 || cookie('roleid')==11 || cookie('roleid')==30){
						$isok = $db->data($info)->where(array('id'=>$ic_id))->save();
					}else{
						$this->error('您没有权限修改该用户信息' . $db->getError());		
					}
				}else{
					$info['sales_person_uid'] = cookie('userid');
					$isok = $db->add($info);
				}
				
				if($isok){
					$this->success('保存成功！',$referer);		
				}else{
					$this->error('保存失败' . $db->getError());	
				}
				
			}else{
				$this->error('请填写企业信息' . $db->getError());	
			}
			
		}else{
			$this->ic       = $db->find($id);
			
			//合作记录
			$where = array();
			$where['o.op_id'] = $this->ic['op_id'];
			//$where['s.audit_status'] = 1;
		
			$this->hezuo = M()->table('__OP__ as o')->field('s.renjunmaoli,o.group_id,o.project')->join('__OP_SETTLEMENT__ as s on o.op_id = s.op_id')->where($where)->select();
		
			$this->display('IC_edit');
		}
		
    }

    //城市合伙人
    public function partner(){
        $partner_db                 = M('customer_partner'); //合伙人
        $deposit_db                 = M('customer_deposit'); //保证金
        $citys_db                   = M('citys');

        $where                      = array();
        $where['del_stu']           = array('neq','-1');

        //分页
        $pagecount                  = $partner_db->where($where)->count();
        $page                       = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists                      = $partner_db->where($where)->order($this->orders('id'))->select();

        foreach ($lists as $k=>$v){
            $deposit_lists          = $deposit_db->where(array('partner_id'=>$v['id']))->select();
            $money                  = array_sum(array_column($deposit_lists,'money'));
            //if ($v['agreement']==1){ $lists[$k]['agreement'] = "<span class='green'>已签订</span>"; }else{ $lists[$k]['agreement'] = "<span class='red'>未签订</span>"; }
            $lists[$k]['money']     = $money;
        }

        $this->lists                = $lists;
        $this->citys                = $citys_db->getField('id,name',true);
        $this->title('城市合伙人');
        $this->display('partner');
    }
    
    //新增/编辑合伙人信息
    public function partner_edit(){
        $citys_db                   = M('citys');
        $partner_db                 = M('customer_partner'); //合伙人
        $deposit_db                 = M('customer_deposit'); //保证金
        $id                         = I('id');
        if ($id){ //编辑
            $partner                = $partner_db->where(array('id'=>$id))->find();
            $deposit                = $deposit_db->where(array('partner_id'=>$id))->select();
            $default_city           = $partner['province'] != 0 ? get_pid_citys($partner['province']) : '';
            $default_agent_city     = $partner['agent_province'] != 0 ? get_pid_citys($partner['agent_province']) : '';
            $default_country        = $partner['city'] != 0 ? get_pid_citys($partner['city']) : '';
            $default_agent_country  = $partner['agent_city'] != 0 ? get_pid_citys($partner['agent_city']) : '';
            $this->partner          = $partner;
            $this->deposit          = $deposit;
            $this->default_city     = $default_city;
            $this->default_agent_city = $default_agent_city;
            $this->default_country  = $default_country;
            $this->default_agent_country = $default_agent_country;
            $this->agent_country    = $partner['agent_country'] ? explode(',',$partner['agent_country']) : '';
        }

        $userkey                    = get_username();
        $arr_citys                  = $citys_db->getField('id,name',true);
        $default_province           = get_pid_citys(0);

        $this->userkey              = $userkey;
        $this->provinces            = $default_province;
        $this->citys                = $arr_citys;
        $this->display();
    }

    public function public_save(){
        $savetype                           = I('savetype');
        if (isset($_POST['dosubmint'])){

            //添加/编辑合伙人信息
            if ($savetype == 1){
                $num                        = 0;
                $msg                        = array();
                $partner_db                 = M('customer_partner'); //合伙人
                $deposit_db                 = M('customer_deposit'); //保证金
                $partner_id                 = I('partner_id')?I('partner_id'):0;
                $info                       = I('info');
                $agent_country              = I('agent_country','');
                $deposit_data               = I('deposit_data'); //保证金
                $resid                      = I('resid');
                $info['agent_country']      = $agent_country ? implode(',',$agent_country) : '';

                if (!trim($info['name']))   { $msg['num'] = $num; $msg['msg'] = '合伙人名称不能为空'; $this->ajaxReturn($msg); }
                if (!$info['level'])        { $msg['num'] = $num; $msg['msg'] = '合伙人级别不能为空'; $this->ajaxReturn($msg); }
                if (!trim($info['manager'])){ $msg['num'] = $num; $msg['msg'] = '负责人不能为空'; $this->ajaxReturn($msg); }
                if (!$info['contacts'])     { $msg['num'] = $num; $msg['msg'] = '联系人不能为空'; $this->ajaxReturn($msg); }
                if (!$info['province'])     { $msg['num'] = $num; $msg['msg'] = '所在省份信息不能为空'; $this->ajaxReturn($msg); }
                if (!$info['agent_province']){ $msg['num'] = $num; $msg['msg'] = '独家省份信息不能为空'; $this->ajaxReturn($msg); }
                if (!$info['cm_id'])        { $msg['num'] = $num; $msg['msg'] = '维护人信息有误'; $this->ajaxReturn($msg); }
                if (!$info['sale_id'])      { $msg['num'] = $num; $msg['msg'] = '销售人信息有误'; $this->ajaxReturn($msg); }
                if (!trim($info['start_date'])){ $msg['num'] = $num; $msg['msg'] = '合伙开始时间不能为空'; $this->ajaxReturn($msg); }
                if (!trim($info['end_date'])){ $msg['num'] = $num; $msg['msg'] = '合伙结束时间不能为空'; $this->ajaxReturn($msg); }

                $info['start_date']         = strtotime($info['start_date']);
                $info['end_date']           = strtotime($info['end_date']);
                $info['create_user_id']     = session('userid');
                $info['create_user_name']   = session('nickname');
                $info['audit_stu']          = 0; //未审核

                if ($partner_id){
                    $res                    = $partner_db->where(array('id'=>$partner_id))->save($info);
                }else{
                    $info['create_time']    = NOW_TIME;
                    $res                    = $partner_db->add($info);
                    $partner_id             = $res;
                }

                if ($partner_id || (!$partner_id && $res)){ //修改 || 增加
                    $num++;
                    if ($deposit_data){
                        foreach ($deposit_data as $k=>$v){
                            $data               = array();
                            $data['partner_id'] = $partner_id;
                            $data['money']      = trim($v['money']);
                            $data['start_date'] = strtotime($v['start_date']);
                            $data['end_date']   = strtotime($v['end_date']);
                            $data['remark']     = trim($v['remark']);
                            if ($resid && $resid[$k]['id']){
                                $result         = $deposit_db->where(array('id'=>$resid[$k]['id']))->save($data);
                                $delid[]        = $resid[$k]['id'];
                                if ($result) $num++;
                            }else{
                                $result         = $deposit_db->add($data);
                                $delid[]        = $result;
                                if ($result) $num++;
                            }
                        }
                        $del                = $deposit_db->where(array('partner_id'=>$partner_id,'id'=>array('not in',$delid)))->delete();
                        if ($del) $num++;

                        $msg['num']             = $num;
                        $msg['msg']             = '保存成功';
                    }
                }else{
                    $msg['num']                 = 0;
                    $msg['msg']                 = '数据保存失败';
                }
                $this->ajaxReturn($msg);
            }

            //保存提交审核
            if ($savetype == 2){
                $db                             = M('customer_partner');
                $partner_id                     = I('partner_id');
                if ($partner_id){
                    $partner                    = $db->where(array('id'=>$partner_id))->find();
                    $data                       = array();
                    $data['audit_stu']          = 1; //已提交审核
                    $res                        = $db->where(array('id'=>$partner_id))->save($data);
                    if ($res){
                        //系统消息提醒
                        $uid     = cookie('userid');
                        $title   = '您有新的的城市合伙人待审核,城市合伙人名称：'.$partner['name'].'，请及时处理!';
                        $content = '城市合伙人名称：'.$partner['name'].'；独家区域：'.$partner['agent_province'].$partner['city'].$partner['country'];
                        $url     = U('Customer/partner_detail',array('id'=>$partner_id));
                        $user    = '[32]'; //王凯
                        $roleid  = '';
                        send_msg($uid,$title,$content,$url,$user,$roleid);

                        $this->success('提交审核成功',U('Customer/partner'));
                    }else{
                        $this->error('提交审核失败');
                    }
                }else{
                    $this->error('提交审核失败');
                }
            }

            //保存审核城市合伙人
            if ($savetype==3){
                $db                             = M('customer_partner'); //合伙人
                $info                           = I('info');
                $id                             = I('id');
                $info['audit_remark']           = trim($info['audit_remark']);

                $res                            = $db->where(array('id'=>$id))->save($info);
                if ($res){
                    $this->success('审核成功');
                }else{
                    $this->error('数据保存失败');
                }
            }
        }
    }

    //删除
    public function del_partner(){
        $partner_db                 = M('customer_partner'); //合伙人
        $id                         = I('id');
        if($id){
            $data                   = array();
            $data['del_stu']        = -1;
            $res                    = $partner_db->where(array('id'=>$id))->save($data);
        }
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    //城市合伙人详情
    public function partner_detail(){
        $partner_db                 = M('customer_partner'); //合伙人
        $deposit_db                 = M('customer_deposit'); //保证金
        $citys_db                   = M('citys');
        $id                         = I('id');
        if (!$id) $this->error('获取数据失败');
        $partner_list               = $partner_db->where(array('id'=>$id))->find();
        $deposit_list               = $deposit_db->where(array('partner_id'=>$id))->select();
        $city                       = $citys_db->getField('id,name',true);
        $partner_list['money']      = array_sum(array_column($deposit_list,'money'));
        $audit_stu                  = array(
            '-1'                    => "<span class='red'>审核未通过</span>",
            '0'                     => "<span class='yellow'>未提交审核</span>",
            '1'                     => "<span class='yellow'>待审核</span>",
            '2'                     => "<span class='green'>审核通过</span>"
        );

        $this->audit_stu            = $audit_stu;
        $this->level                = array(1=>'省级',2=>'市级',3=>'县/区级');
        $this->agreement            = array(0=>"<span class='red'>未签订协议</span>",1=>"<span class='green'>已签订协议</span>");
        $this->partner              = $partner_list;
        $this->deposit              = $deposit_list;
        $this->city                 = $city;
        $this->display();
    }

    //城市合伙人地图
    public function public_partner_map(){
        $this->title('城市合伙人');
        $city_data                  = M('citys')->field('id,name,pid')->select();
        $where                      = array();
        //$where['audit_stu']         = 2;
        $where['del_stu']           = array('neq','-1');
        $customer_data              = M('customer_partner')->where($where)->select();
        $data                       = array();
        foreach ($city_data as $k=>$v){
            $province_num           = 0;
            $city_num               = 0;
            foreach ($customer_data as $key=>$value){
                if ($value['agent_province'] == $v['id']){ $province_num++; }
                if ($value['agent_city']     == $v['id']){ $city_num++; }
            }

            $city_data[$k]['pinyin']= get_all_pinyin($v['name']);
            $data[$k]['name']       = $v['name'];
            $data[$k]['value']      = $v['pid'] == 0 ? $province_num : $city_num;
            $data[$k]['pid']        = $v['pid'];
        }
        $citys                      = json_encode(array_column($city_data,'name'));
        $city_pinyin                = json_encode(array_column($city_data,'pinyin'));

        $this->citys                = $citys;
        $this->city_pinyin          = $city_pinyin;
        $this->data                 = json_encode($data);
        $this->display('map');
    }


    //kpi
    public function public_kpi_partner(){
        $citys_db                   = M('citys');
        $partner_db                 = M('customer_partner'); //合伙人
        $deposit_db                 = M('customer_deposit'); //保证金
        $user_id                    = I('uid');
        $start_time                 = I('st');
        $end_time                   = I('et');
        $target                     = I('target');
        $data                       = get_partner($user_id,$start_time,$end_time);
        $partner_ids                = array_unique(array_column($data['lists'],'partner_id'));
        $deposit_ids                = array_column($data['lists'],'id');
        $where                      = array();
        $where['id']                = array('in',$partner_ids);
        //$where['d.id']              = array('in',$deposit_ids);
        //$lists                      = M()->table('__CUSTOMER_PARTNER__ as p')->join('__CUSTOMER_DEPOSIT__ as d on d.partner_id=p.id','left')->where($where)->select();
        $lists                      = $partner_db->where($where)->select();
        foreach ($lists as $k=>$v){
            $deposit_lists          = $deposit_db->where(array('partner_id'=>$v['id'],'id'=>array('in',$deposit_ids)))->select();
            $money                  = array_sum(array_column($deposit_lists,'money'));
            $lists[$k]['money']     = $money;
        }

        $info                       = array();
        $info['target']             = $target;
        $info['really']             = array_sum(array_column($lists,',money'));
        $info['complete']           = (round($info['really']/$info['target'],4)*100).'%';
        $this->lists                = $lists;
        $this->info                 = $info;
        $this->citys                = $citys_db->getField('id,name',true);
        $this->user_id              = $user_id;
        $this->start_time           = $start_time;
        $this->end_time             = $end_time;
        $this->target               = $target;
        $this->display('kpi_partner');
    }

    //交接城市合伙人维护人
    public function change_cm(){
        $db                         = M('customer_partner');
        if (isset($_POST['dosubmit'])){
            $id                     = I('id');
            $info                   = I('info');
            $res                    = $db->where(array('id'=>$id))->save($info);
            echo '<script>window.top.location.reload();</script>';
        }else{
            $id                     = I('id');
            $list                   = $db->where(array('id'=>$id))->find();
            $this->list             = $list;
            $this->userkey          = get_username();
            $this->display();
        }
    }
}