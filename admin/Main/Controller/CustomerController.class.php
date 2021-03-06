<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;
ulib('Pinyin');
use Sys\Pinyin;

// @@@NODE-2###Customer###销售管理###
class CustomerController extends BaseController {

    protected $_pagetitle_ = '市场营销';
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

		$db                 = M('customer_gec');
		$id                 = I('id');
		$keywords           = I('keywords');
		$type               = I('type');
		$cm                 = I('cm');
		$address            = I('address');
		$province           = I('province');
		$city               = I('city');
		$county             = I('county');
		$level              = I('level');
		$qianli             = I('qianli');
		$create             = I('create');

        $map                = array();
		if(C('RBAC_SUPER_ADMIN')==session('username') || in_array(session('roleid'),array(10,14,28,30,45,54,60))){

		}else{
            $where          = array();
            $where['cm_id'] = array('in',Rolerelation(cookie('roleid')));
			$where['create_user_id'] = session('userid');
            $where['_logic']= 'or';
            $map['_complex']= $where;
		}

        $map['status']	    = 0;
		if ($id)         $map['id']  = $id;
        if($keywords)    $map['company_name'] = array('like','%'.$keywords.'%');
        if($type)        $map['type'] = $type;
        if($address)     $map['contacts_address'] = array('like','%'.$address.'%');
        if($cm)          $map['cm_name'] = array('like','%'.$cm.'%');
        if($province)    $map['province'] = array('like','%'.$province.'%');
        if($city)        $map['city'] = array('like','%'.$city.'%');
        if($county)      $map['county'] = array('like','%'.$county.'%');
        if($level)       $map['level'] = array('like','%'.$level.'%');
        if($qianli)      $map['qianli'] = array('like','%'.$qianli.'%');
        if ($create)     $map['create_user_name'] = array('like','%'.$create.'%');

		//分页
		$pagecount = $db->where($map)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists = $db->where($map)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$hz = M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->order('create_time DESC')->find();
			$lists[$k]['hezuo'] = $hz['create_time'] ? '<a href="'.U('Op/index',array('cus'=>$v['company_name'])).'">'.date('Y-m-d',$hz['create_time']).'</a>' : '无结算记录';
			$lists[$k]['hezuocishu'] = $hz['create_time'] ? M('op')->where(array('customer'=>$v['company_name'],'audit_status'=>1))->count() : '';
		    $lists[$k]['hide_mobile']= hide_mobile($v['contacts_phone']);
		}
		$this->lists                = $lists;
		$this->msg_gec_ids          = get_unread_req_ids(P::UNREAD_GEC_TRANSFER);

		$this->display('GEC');
    }

    public function op(){
		$db                         = M('customer_gec');
		$PinYin                     = new Pinyin();
		$id                         = M('op')->where(array('customer'=>array('like','%散客%')))->Getfield('id',true);

		$where                      = array();
		$where['customer']          = array('neq','NULL');
		$where['id']                = array('not in',implode(',',$id));
		$where['customer']          = array('neq',' ');

		$i                          = 0;
		$list                       = M('op')->field('customer,create_user,create_user_name,create_time')->where($where)->group('customer')->select();
		foreach($list as $v){
			$company_name           = iconv("utf-8","gb2312",trim($v['customer']));
			$data                   = array();
			$data['company_name']   = $v['customer'];
			$data['cm_id']          = $v['create_user'];
			$data['cm_name']        = $v['create_user_name'];
			$data['cm_time']        = $v['create_time'];
			$data['create_time']    = $v['create_time'];
			$data['pinyin']         = strtolower($PinYin->getFirstPY($company_name));
			if(!M('customer_gec')->where(array('company_name'=>$v['customer'],'cm_id'=>$v['create_user']))->find()){
				$res                = M('customer_gec')->add($data);
				if($res) $i++;
			}
		}

		echo $i;
    }

	// @@@NODE-3###GEC_edit###编辑政企客户###
    public function GEC_edit(){
        $this->title('政企客户管理');

		$db                     = M('customer_gec');
		$referer                = I('referer');
		$PinYin                 = new Pinyin();

		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){

			$gec_id             = I('gec_id');
			$info               = I('info');
			$info['cm_time']    = time();
			$company_name       = iconv("utf-8","gb2312",trim($info['company_name']));
			$info['pinyin']     = strtolower($PinYin->getFirstPY($company_name));
			//if (!$info['cm_id']){ $this->error('维护人信息错误,请选择匹配到的人员信息'); }

			if($info){
			    $info['company_name']   = trim($info['company_name']);
			    $info['level']          = trim($info['level']);
			    $info['type']           = trim($info['type']);
			    $info['contacts']       = trim($info['contacts']);
			    $info['post']           = trim($info['post']);
			    $info['contacts_phone'] = trim($info['contacts_phone']);
			    $info['county']         = trim($info['county']);
			    $info['remark']         = trim($info['remark']);
			    if (!$info['company_name']) { $this->error('客户名称不能为空'); }
			    if (!$info['level'])    { $this->error('客户级别不能为空'); }
			    if (!$info['type'])     { $this->error('客户类型不能为空'); }
			    if (!$info['contacts']) { $this->error('联系人不能为空'); }
			    if (!$info['post'])     { $this->error('联系人职务不能为空'); }
			    if (!$info['contacts_phone']){ $this->error('联系人手机不能为空'); }
			    if (!$info['province']) { $this->error('所在省份不能为空'); }
                if (!$info['city'])     { $this->error('所在城市不能为空'); }

				if($gec_id){
                    $list               = $db->where(array('company_name'=>$info['company_name'],'id'=>array('neq',$gec_id)))->find();
                    if ($list) $this->error('该客户信息已存在,请更改客户名称');
					$u                  = $db->find($gec_id);
					if($u['cm_id']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || in_array(session('userid'),C('GEC_TRANSFER_UID'))){
						$isok           = $db->data($info)->where(array('id'=>$gec_id))->save();
					}else{
						$this->error('您没有权限修改该用户信息' . $db->getError());
					}
					$record_msg         = '编辑客户信息';
					$process_node       = 11; //维护客户

					//查询有无给相关人员发送客户交接提示
                    if (!$info['cm_id']){
                        $send_msg       = $this->get_GEC_transfer_msg($gec_id);
                        $this->send_process_todo_log($gec_id,$info['company_name']);
                        if (!$send_msg){
                            $this->send_GEC_transfer_msg($gec_id);
                        }
                    }
				}else{
			        $list               = $db->where(array('company_name'=>$info['company_name']))->find();
			        if ($list) $this->error('该客户信息已存在,请勿重复录入');
					$info['create_time']= time();
					$isok               = $db->add($info);
					$gec_id             = $isok;
					$record_msg         = '添加客户信息';
                    $process_node       = 8; //新建客户信息

					if (!$info['cm_id']){ //需要转交维护人
					    $this->send_GEC_transfer_msg($gec_id);
                        $this->send_process_todo_log($gec_id,$info['company_name']);
                    }
				}

				if($isok){
				    if (cookie('userid') != 1){ //保存流程->待办事宜
                        $manager_data       = get_manage_uid(cookie('userid'));
                        save_process_log($process_node,P::PROCESS_STU_NOREAD,$info['company_name'],$gec_id,'',$manager_data['manager_id'],$manager_data['manager_name']);
				    }

                    //保存操作记录
                    $record             = array();
                    $record['qaqc_id']  = $gec_id;
                    $record['explain']  = $record_msg;
                    $record['type']     = P::RECORD_GEC; //客户管理操作记录
                    record($record);

					$this->success('保存成功！',$referer);
				}else{
					$this->error('保存失败' . $db->getError());
				}
			}else{
				$this->error('请填写企业信息' . $db->getError());
			}
		}else{
            $id                         = I('id');
            $this->gec                  = $db->find($id);
			$this->transfer_uid         = C('GEC_TRANSFER_UID');
			$this->records              = get_public_record($id,P::RECORD_GEC);
			$this->userkey              = get_username();
			//合作记录
			$where                      = array();
			$where['o.customer']        = $this->gec['company_name'];
			$where['s.audit_status']    = 1;
			$this->hezuo                = M()->table('__OP_SETTLEMENT__ as s')->field('s.*,o.group_id,o.project')->join('__OP__ as o on o.op_id = s.op_id','LEFT')->where($where)->select();

			$this->display('GEC_edit');
		}
    }

    //待办事宜 交接城市合伙人 提示信息
    private function send_process_todo_log($req_id,$title){
        $process_node   = 9; //转交客户信息
        $manager_data   = M('process_node')->where(array('id'=>$process_node))->field('blame_uid as manager_id,blame_name as manager_name')->find();
        save_process_log($process_node,P::PROCESS_STU_BEFORE,$title,$req_id,'',$manager_data['manager_id'],$manager_data['manager_name']);

    }

    //给相关人员发送客户交接提示
    private function send_GEC_transfer_msg($GEC_id){
        $uids                       = C('GEC_TRANSFER_UID'); //提示
        $read                       = array();
        $read['type']               = P::UNREAD_GEC_TRANSFER;
        $read['req_id']             = $GEC_id;
        $read['userids']            = implode(',',$uids);
        $read['create_time']        = NOW_TIME;
        $read['read_type']          = 0;
        M('unread')->add($read);
    }

    //获取该记录有无发送客户交接提示
    private function get_GEC_transfer_msg($GEC_id){
        $where                      = array();
        $where['type']              = P::UNREAD_GEC_TRANSFER;
        $where['req_id']            = $GEC_id;
        $list                       = M('unread')->where($where)->find();
        return $list;
    }

    //修改客户交接提示信息
    private function upd_GEC_transfer_msg($GEC_id){
        $where                      = array();
        $where['type']              = P::UNREAD_GEC_TRANSFER;
        $where['req_id']            = $GEC_id;
        $list                       = M('unread')->where($where)->find();
        if ($list){
            $userids                = explode(',',$list['userids']);
            $newUserIds             = array();
            foreach ($userids as $v){
                if (session('userid') != $v){
                    $newUserIds[]   = $v;
                }
            }
            $data                   = array();
            $data['userids']        = implode(',',$newUserIds);
            $data['read_type']      = 1;
            M('unread')->where($where)->save($data);
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

            if (!in_array(session('userid'),C('GEC_TRANSFER_UID'))){
                $this->error('您无权交接该客户');
            }

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
                    //保存操作记录
                    $record             = array();
                    $record['qaqc_id']  = $v;
                    $record['explain']  = '交接客户: '.$fm.' -> '.$to;
                    $record['type']     = P::RECORD_GEC; //客户管理操作记录
                    record($record);
					$i++;
				}
			}
            $this->upd_GEC_transfer_msg($v); //修改客户交接提示信息
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

	//交接客户(某一个客户)
    public function public_GEC_transfer(){
        $db                             = M('customer_gec');
        if (isset($_POST['dosubmint'])){
            $id                         = I('id');
            $info                       = I('info');
            if (!in_array(session('userid'),C('GEC_TRANSFER_UID'))){
                $this->msg              = '您无权交接该客户信息';
                $this->display('Index:public_audit');
            }
            if ($id){
                $list                   = $db->where(array('id'=>$id))->find();
                if (!$info['cm_id'] || !$info['cm_name']){
                    $this->msg          = '接收人员信息输入错误';
                    $this->display('Index:public_audit');
                }else{
                    $res                = $db ->where(array('id'=>$id))->save($info);
                    if ($res){
                        $this->msg      = '交接成功';
                        $this->upd_GEC_transfer_msg($id); //修改客户交接提示信息
                        //保存操作记录
                        $record             = array();
                        $record['qaqc_id']  = $id;
                        $record['explain']  = '交接客户: '.$list['cm_name'].' -> '.$info['cm_name'];
                        $record['type']     = P::RECORD_GEC; //客户管理操作记录
                        record($record);
                    }else{
                        $this->msg      = '交接失败';
                    }
                    $this->display('Index:public_audit');
                }
            }else{
                $this->msg              = '获取数据失败';
                $this->display('Index:public_audit');
            }
            $this->display('Index:public_audit');
        }else{
            $id                         = I('id');
            if (!$id){ $this->error('获取数据错误'); }
            $list                       = $db->where(array('id'=>$id))->find();
            $this->list                 = $list;
            $this->userkey              = get_username();
            $this->display('change_GEC');
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
		$this->record_title('客户管理操作记录');
		$this->record = get_public_record($id,P::RECORD_GEC);

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

        //获取需要满意度评分的城市合伙人
        $score_partners             = get_need_score_partner();
        $score_partner_ids          = array_column($score_partners,'id');
        $quota_id                   = 252; //城市合伙人满意度
        $time_data                  = get_this_month();
        $yearMonth                  = $time_data['year'].$time_data['month'];
        $kpi_more                   = M('kpi_more')->where(array('month'=>array('like','%'.$yearMonth.'%'),'quota_id'=>$quota_id))->find();

        $this->kpi_more             = $kpi_more;
        $this->score_partner_ids    = $score_partner_ids;
        $this->audit_stu            = $this->partner_audit_status();
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

        $this->audit_stu            = $this->partner_audit_status();
        $this->userkey              = $userkey;
        $this->provinces            = $default_province;
        $this->citys                = $arr_citys;
        $this->cost_type            = C('PARTNER_COST_TYPE');
        $this->display();
    }

    private function partner_audit_status(){
        $arr                        = array(
            '-1'                    => "<span class='red'>审核未通过</span>",
            '0'                     => "<span class='yellow'>未提交审核</span>",
            '1'                     => "<span class='yellow'>待审核</span>",
            '2'                     => "<span class='green'>审核通过</span>"
        );

        return $arr;
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
                if (!$info['cm_id'] || !trim($info['cm_name']))     { $msg['num'] = $num; $msg['msg'] = '维护人信息有误'; $this->ajaxReturn($msg); }
                if (!$info['sale_id'] || !trim($info['sale_name'])) { $msg['num'] = $num; $msg['msg'] = '销售人信息有误'; $this->ajaxReturn($msg); }
                if (!trim($info['start_date'])){ $msg['num'] = $num; $msg['msg'] = '合伙开始时间不能为空'; $this->ajaxReturn($msg); }
                if (!trim($info['end_date'])){ $msg['num'] = $num; $msg['msg'] = '合伙结束时间不能为空'; $this->ajaxReturn($msg); }

                $info['start_date']         = strtotime($info['start_date']);
                $info['end_date']           = strtotime($info['end_date']);

                if ($partner_id){
                    $record_msg             = '编辑城市合伙人';
                    $info['audit_stu']      = ($info['audit_stu'] == 2 && rolemenu(array('Customer/audit_partner'))) ? $info['audit_stu'] : 0; //审核通过 && 有审核权限
                    $res                    = $partner_db->where(array('id'=>$partner_id))->save($info);
                }else{
                    $record_msg             = '添加城市合伙人';
                    $info['create_user_id'] = session('userid');
                    $info['create_user_name']= session('nickname');
                    $info['audit_stu']      = 0; //未审核
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
                            $data['type']       = $v['type'];
                            $data['remark']     = trim($v['remark']);
                            if ($resid && $resid[$k]['id']){
                                $result         = $deposit_db->where(array('id'=>$resid[$k]['id']))->save($data);
                                $delid[]        = $resid[$k]['id'];
                                if ($result) $num++;
                            }else{
                                $data['input_time'] = NOW_TIME;
                                $result         = $deposit_db->add($data);
                                $delid[]        = $result;
                                if ($result) $num++;
                            }
                        }
                        $del                = $deposit_db->where(array('partner_id'=>$partner_id,'id'=>array('not in',$delid)))->delete();
                        if ($del) $num++;

                        $msg['num']             = $num;
                        $msg['msg']             = '保存成功';

                        //保存操作记录
                        $record             = array();
                        $record['qaqc_id']  = $partner_id;
                        $record['explain']  = $record_msg;
                        $record['type']     = P::RECORD_PARTNER; //城市合伙人操作记录
                        record($record);
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

                        //保存操作记录
                        $record             = array();
                        $record['qaqc_id']  = $partner_id;
                        $record['explain']  = '申请审核城市合伙人';
                        $record['type']     = P::RECORD_PARTNER; //城市合伙人操作记录
                        record($record);

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
                $info['audit_time']             = NOW_TIME;

                $res                            = $db->where(array('id'=>$id))->save($info);
                if ($res){
                    //保存操作记录
                    $result                     = $info['audit_stu'] == 2 ? '审核通过' : '审核不通过';
                    $record                     = array();
                    $record['qaqc_id']          = $id;
                    $record['explain']          = '审核城市合伙人,审核结果：'.$result;
                    $record['type']             = P::RECORD_PARTNER; //城市合伙人操作记录
                    record($record);

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
            //保存操作记录
            $record                     = array();
            $record['qaqc_id']          = $id;
            $record['explain']          = '删除城市合伙人';
            $record['type']             = P::RECORD_PARTNER; //城市合伙人操作记录
            record($record);
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

        $this->cost_type            = C('PARTNER_COST_TYPE');
        $this->audit_stu            = $this->partner_audit_status();
        $this->level                = array(1=>'省级',2=>'市级',3=>'县/区级');
        $this->agreement            = array(0=>"<span class='red'>未签订协议</span>",1=>"<span class='green'>已签订协议</span>");
        $this->partner              = $partner_list;
        $this->deposit              = $deposit_list;
        $this->city                 = $city;
        $this->record               = get_public_record($id,P::RECORD_PARTNER);
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
        $id                         = I('id');
        $list                       = $db->where(array('id'=>$id))->find();
        if (isset($_POST['dosubmit'])){
            $id                     = I('id');
            $info                   = I('info');
            $res                    = $db->where(array('id'=>$id))->save($info);
            //保存操作记录
            $record                 = array();
            $record['qaqc_id']      = $id;
            $record['explain']      = '交接城市合伙人：'.$list['cm_name'].'->'.$info['cm_name'];
            $record['type']         = P::RECORD_PARTNER; //城市合伙人操作记录
            record($record);
            echo '<script>window.top.location.reload();</script>';
        }else{
            $this->list             = $list;
            $this->userkey          = get_username();
            $this->display();
        }
    }

    //市场营销首页
    public function public_index(){
        $type                       = P::FILE_DOWNLOAD_SALE_RES;
        $customer_files             = get_download_files($type);


        $this->customer_files       = $customer_files;
        $this->msg_file_ids         = get_unread_req_ids(P::UNREAD_SALE_FILE);
        $this->unread_type          = P::UNREAD_SALE_FILE;
        $this->display('index');
    }

    //更多销售资料下载
    public function public_moreCustomerFiles(){
        $key                        = trim(I('key'));
        $db                         = M('customer_files');
        $where                      = array();
        if ($key) $where['file_name'] = array('like', '%'.$key.'%');
        $pagecount                  = $db->where($where)->count();
        $page                       = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->lists                = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
        $this->msg_file_ids         = get_unread_req_ids(P::UNREAD_SALE_FILE);
        $this->unread_type          = P::UNREAD_SALE_FILE;
        $this->display('moreCustomerFiles');
    }

    //宣传营销
    public function widely(){
        $this->title('宣传营销');
        $db                         = M('customer_widely');
        $title                      = trim(I('title'));
        $where                      = array();
        if ($title) $where['title'] = array('like', '%'.$title.'%');

        $pagecount                  = $db->where($where)->count();
        $page                       = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                      = $db->where($where)->limit($page->firstRow .','. $page->listRows)->order($this->orders('id'))->select();
        $this->lists                = $lists;
        $process_data               = get_process_data(); //流程
        $this->process_data         = array_column($process_data,'title','id');
        $this->audit_status         = get_submit_audit_status();
        $this->display();
    }

    //
    public function public_widely_add(){
        $this->title('添加市场营销计划');
        $db                         = M('customer_widely');
        if (isset($_POST['dosubmint'])){
            $id                     = I('id');
            $info                   = I('info');
            $info['title']          = trim($info['title']);
            $info['in_time']        = strtotime($info['in_time']);
            if (!$info['title']) $this->error('标题不能为空');
            if ($id){
                $res                = $db->where(array('id'=>$id))->save($info);
            }else{
                $info['create_time']    = NOW_TIME;
                $info['create_user_name'] = cookie('nickname');
                $info['create_user_id'] = cookie('userid');
                $res                = $db->add($info);
                $id                 = $res;
            }
            $res ? $this->success('数据保存成功',U('Customer/public_widely_add',array('id'=>$id))) : $this->error('数据保存失败');
        }else{
            $id                     = I('id');
            if ($id){
                $this->list         = $db->where(array('id'=>$id))->find();
            }
            $process_data           = get_process_data(); //流程
            $this->process_data     = $process_data;
            $this->userkey          = get_username(); //人员名单关键字
            $this->display('widely_add');
        }
    }

    //宣传营销计划详情(审批)
    public function public_widely_detail(){
        $this->title('宣传营销计划');
        $id                         = I('id');
        if (!$id) $this->error('获取数据失败');
        $db                         = M('customer_widely');
        $list                       = $db->find($id);
        $process_node_id            = 16; //制定业务季市场营销计划及预算
        $node_list                  = M('process_node')->find($process_node_id);

        $this->node_list            = $node_list;
        $process_data               = get_process_data(); //流程
        $this->process_data         = array_column($process_data,'title','id');
        $this->audit_status         = get_submit_audit_status();
        $this->list                 = $list;
        $this->display('widely_detail');
    }

    public function delWidely(){

    }

    //市场营销需求
    public function public_widelyNeed(){
        $this->title('市场营销需求');

        $this->display('widely_need');
    }

    //添加需求
    public function public_addWidelyNeed(){
        $this->title('添加活动需求');

        $process_data           = get_process_data(); //流程
        $this->process_data     = $process_data;
        $this->userkey          = get_username(); //人员名单关键字
        $this->display('widelyNeedAdd');
    }

    //宣传营销方案
    public function widelyPro(){
        $this->title('营销方案');

        //人员名单关键字
        $this->userkey          = get_username();
        $this->display('widely_pro');
    }

    //组织业务投标
    public function public_bid(){
        $this->title('业务投标计划');
        $db                         = M('customer_bid');
        $title                      = trim(I('title'));
        $where                      = array();
        if ($title) $where['title'] = array('like', '%'.$title.'%');
        $pagecount                  = $db->where($where)->count();
        $page                       = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->lists                = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

        $this->display('bid');
    }

    //添加组织业务投标
    public function public_bid_add(){
        $this->title('业务投标计划');
        $db                         = M('customer_bid');
        if (isset($_POST['dosubmint'])){
            $info                   = I('info');
            $id                     = I('id',0);
            $info['title']          = trim($info['title']);
            $info['customer']       = trim($info['customer']);
            $info['blame_name']     = trim($info['blame_name']);
            $info['bid_time']       = strtotime($info['bid_time']);
            if (!$info['title'])    $this->error('投标项目输入有误');
            if (!$info['customer']) $this->error('招标方输入有误');
            if (!$info['bid_time']) $this->error('投标时间输入有误');
            if (!$info['blame_name'] || !$info['blame_uid']) $this->error('提交人信息输入有误');
            $info['create_time']    = NOW_TIME;
            $info['create_user_name'] = cookie('nickname');
            $info['create_user_id'] = cookie('userid');
            if ($id){
                $res                = $db->where(array('id'=>$id))->save($info);
            }else{
                $res                = $db->add($info);
                $id                 = $res;
                save_bid_data($info['title'],$id,$info['blame_uid']); //提醒
            }
           $res ? $this->success('保存成功',U('Customer/public_bid')) : $this->error('保存失败');
        }else{
            $id                     = I('id',0);
            if ($id){
                $list               = $db->where(array('id'=>$id))->find();
                $this->list         = $list;
            }
            //$bid_pros               = M('customer_bid_project')->getField('id, title',true); //投标方案
            //$this->bid_pros         = $bid_pros;
            //人员名单关键字
            $this->userkey          = get_username();
            $this->display('bid_add');
        }
    }

    public function del_bid(){
        $db                         = M('customer_bid');
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $res                        = $db->where(array('id'=>$id))->delete();
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    //业务投标方案
    public function public_bidPro_add(){
        $this->title('投标工作方案');
        $bid_db                     = M('customer_bid');
        $bid_lists                  = $bid_db->order('id desc')->limit(50)->select();
        $this->bid_lists            = $bid_lists;

        //人员名单关键字
        $this->userkey              = get_username();
        $this->display('bid_pro_add');
    }


    //组织业务投标
    public function public_sale(){
        $process_id                 = I('process_id');
        $title                      = $process_id ? M('process')->where(array('id'=>$process_id))->getField('title') : '销售支持计划';
        $this->title($title);
        $db                         = M('customer_sale');
        $title                      = trim(I('title'));
        $where                      = array();
        if ($title) $where['title'] = array('like', '%'.$title.'%');
        $pagecount                  = $db->where($where)->count();
        $page                       = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $this->lists                = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
        $this->types                = get_sale_type(); //获取销售支持类型
        $this->audit_status         = get_submit_audit_status();
        $this->display('sale');
    }

    //销售支持计划详情
    public function public_sale_detail(){
        $this->title('销售支持计划');
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $db                         = M('customer_sale');
        $list                       = $db->find($id);
        $this->list                 = $list;
        $this->types                = get_sale_type(); //获取销售支持类型
        $this->audit_status         = get_submit_audit_status();
        $this->display('sale_detail');
    }

    //添加销售支持计划
    public function public_sale_add(){
        $this->title('销售支持计划');
        $db                         = M('customer_sale');
        if (isset($_POST['dosubmint'])){
            $info                   = I('info');
            $id                     = I('id',0);
            $info['title']          = trim($info['title']);
            $info['customer']       = trim($info['customer']);
            $info['blame_name']     = trim($info['blame_name']);
            $info['st_time']        = strtotime($info['st_time']);
            $info['et_time']        = strtotime($info['et_time']);
            if (!$info['title'])    $this->error('销售支持标题不能为空');
            if (!$info['blame_name'] || !$info['blame_uid']) $this->error('提交人信息输入有误');
            $manage_data            = get_manage_uid($info['blame_uid']);
            $info['audit_uid']      = $manage_data['manager_id'] ? $manage_data['manager_id'] : 0;
            $info['audit_uname']    = $manage_data['manager_name'] ? $manage_data['manager_name'] : '';
            if ($id){
                $res                = $db->where(array('id'=>$id))->save($info);
            }else{
                $info['create_time']= NOW_TIME;
                $info['create_user_name'] = cookie('nickname');
                $info['create_user_id'] = cookie('userid');
                $res                = $db->add($info);
                $id                 = $res;
                //save_bid_data($info['title'],$id,$info['blame_uid']); //提醒
            }
            $res ? $this->success('保存成功',U('Customer/public_sale')) : $this->error('保存失败');
        }else{
            $id                     = I('id',0);
            if ($id){
                $list               = $db->where(array('id'=>$id))->find();
                $this->list         = $list;
            }

            $this->customers        = get_customerlist();
            $this->types            = get_sale_type(); //获取销售支持类型
            $this->userkey          = get_username(); //人员名单关键字
            $this->display('sale_add');
        }
    }

    public function del_sale(){
        $db                         = M('customer_sale');
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $res                        = $db->where(array('id'=>$id))->delete();
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    //销售支持方案
    public function public_salePro_add(){
        $this->title('销售支持方案');
        $id                         = I('id');
        if (!$id) $this->error('获取数据错误');
        $list                       = M('customer_sale')->find($id);
        $pro_list                   = M('customer_sale_project')->where(array('sale_id'=>$id))->find();
        $costacc                    = M('customer_sale_project_cost')->where(array('pro_id'=>$pro_list['id']))->select();

        $this->types                = get_sale_type(); //获取销售支持类型
        $this->list                 = $list;
        $this->pro_list             = $pro_list;
        $this->costacc              = $costacc;
        $this->display('sale_pro_add');
    }


    //
    public function public_save_process(){
        $saveType                   = I('saveType');
        if (isset($_POST['dosubmint'])){
            if ($saveType == 1){ //提交审核市场营销计划
                $db                 = M('customer_widely');
                $id                 = I('id');
                $data               = array();
                $data['status']     = 3;
                $res                = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $list           = $db->find($id);
                    $process_node_id= 16; //制定业务季市场营销计划及预算
                    $node_list      = M('process_node')->find($process_node_id);
                    $pro_status     = 2; //事前提醒
                    $title          = $list['title'];
                    $req_id         = $list['id'];
                    $to_uid         = $node_list['blame_uid'];
                    $to_uname       = $node_list['blame_name'];
                    save_process_log($process_node_id,$pro_status,$title,$req_id,'',$to_uid,$to_uname);

                    $ok_node_id     = 15; //提交业务季宣传营销需求
                    save_process_ok($ok_node_id);
                    $this->success('数据保存成功',U('Customer/widely'));
                }else{
                    $this->error('数据保存失败');
                }
            }

            if ($saveType == 2){ //审核宣传营销计划
                $db                 = M('customer_widely');
                $id                 = I('id');
                $status             = I('status');
                $audit_remark       = trim(I('audit_remark'));
                $data               = array();
                $data['status']     = $status;
                $data['audit_user_id']  = cookie('userid');
                $data['audit_user_name']= cookie('nickname');
                $data['audit_time']     = NOW_TIME;
                $data['audit_remark']   = $audit_remark;
                $res                    = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $ok_node_id         = 16; //制定业务季市场营销计划及预算
                    save_process_ok($ok_node_id);
                    $this->success('审核成功');
                }else{
                    $this->error('审核失败');
                }
            }

            if ($saveType == 3){
                $id                 = I('id');
                if (!$id) $this->error('提交失败');
                $db                 = M('customer_sale');
                $data               = array();
                $data['status']     = 3;
                $res                = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $list           = $db->where(array('id'=>$id))->find();
                    $process_node_id= 33; //审批协助销售申请
                    $pro_status     = 2; //事前提醒
                    $title          = $list['title'];
                    $req_id         = $list['id'];
                    $to_uid         = $list['audit_uid'];
                    $to_uname       = $list['audit_uname'];
                    save_process_log($process_node_id,$pro_status,$title,$req_id,'',$to_uid,$to_uname);

                    $ok_node_id     = 32; //提交协助销售申请
                    save_process_ok($ok_node_id);
                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            if ($saveType == 4){ //审核销售支持计划
                $db                 = M('customer_sale');
                $id                 = I('id');
                $status             = I('status');
                $audit_remark       = trim(I('audit_remark'));
                if (!$status) $this->error('请选择是否审核通过');
                $data               = array();
                $data['status']     = $status;
                $data['audit_time']     = NOW_TIME;
                $data['audit_remark']   = $audit_remark;
                $res                    = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $ok_node_id         = 16; //制定业务季市场营销计划及预算
                    save_process_ok($ok_node_id,$audit_remark);
                    $this->success('审核成功');
                }else{
                    $this->error('审核失败');
                }
            }

            if ($saveType == 5){
                $id                 = I('id');
                $sale_id            = I('sale_id');
                $info               = I('info');
                $costacc            = I('costacc');
                $resid              = I('resid');
                $db                 = M('customer_sale_project');
                $cost_db            = M('customer_sale_project_cost');
                $info['addr']       = trim($info['addr']);
                $info['hope']       = trim($info['hope']);
                $info['content']    = trim($info['content']);
                $info['sale_id']    = $sale_id;
                $num                = 0;
                if ($id){
                    $res            = $db->where(array('id'=>$id))->save($info);
                    if ($res) $num++;
                    foreach($costacc as $k=>$v){
                        $data           = $v;
                        $data['pro_id'] = $id;
                        if($resid && $resid[$k]['id']){
                            $edits      = $cost_db->data($data)->where(array('id'=>$resid[$k]['id']))->save();
                            $delid[]    = $resid[$k]['id'];
                            if ($edits) $num++;
                        }else{
                            $savein     = $cost_db->add($data);
                            $delid[]    = $savein;
                            if($savein) $num++;
                        }
                    }
                    $del = $cost_db->where(array('pro_id'=>$id,'id'=>array('not in',$delid)))->delete();
                    if($del) $num++;
                }else{
                    $res1           = $db->add($info);
                    if ($res1) $num++;
                    foreach ($costacc as $v){
                        $v['pro_id']= $res;
                        $res2       = $cost_db->add($v);
                        if ($res2) $num++;
                    }
                }
                if ($num){
                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }

            }

            if ($saveType == 6){
                $id                         = I('id');
                if (!$id) $this->error('数据保存失败');
                $manager_data               = get_manage_uid(cookie('userid'));

                $db                         = M('customer_sale_project');
                $data                       = array();
                $data['audit_status']       = 3;
                $data['audit_uid']          = $manager_data['manager_id'];
                $data['audit_uname']        = $manager_data['manager_name'];
                $res                        = $db->where(array('id'=>$id))->save($data);
                if ($res) {
                    $pro_list               = M()->table('__CUSTOMER_SALE_PROJECT__ as p')->join('__CUSTOMER_SALE__ as s on s.id=p.sale_id','left')->field('s.title,p.*')->where(array('p.id'=>$id))->find();
                    $process_node_id        = 33; //审批协助销售申请
                    $pro_status             = 2; //事前提醒
                    $title                  = $pro_list['title'];
                    $req_id                 = $pro_list['sale_id'];
                    $to_uid                 = $pro_list['audit_uid'];
                    $to_uname               = $pro_list['audit_uname'];
                    save_process_log($process_node_id, $pro_status, $title, $req_id, '', $to_uid, $to_uname);

                    $ok_node_id = 32; //提交协助销售申请
                    save_process_ok($ok_node_id);
                    $this->success('保存成功');
                }else{
                    $this->error('保存失败');
                }
            }

            if ($saveType == 7){
                $id                         = I('id');
                $status                     = I('status');
                $audit_remark               = trim(I('audit_remark'));
                if (!id) $this->error('获取数据错误');
                if (!status) $this->error('请先选择是否审核通过');
                $db                         = M('customer_sale_project');
                $data                       = array();
                $data['audit_status']       = $status;
                $data['audit_time']         = NOW_TIME;
                $data['audit_remark']       = $audit_remark;
                $res                        = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    if ($status == 1){ //审核通过
                        $pro_list               = M()->table('__CUSTOMER_SALE_PROJECT__ as p')->join('__CUSTOMER_SALE__ as s on s.id=p.sale_id','left')->field('s.title,p.*')->where(array('p.id'=>$id))->find();
                        $process_node_id        = 33; //审批协助销售申请
                        $pro_status             = 1; //未读
                        $title                  = $pro_list['title'];
                        $req_id                 = $pro_list['sale_id'];
                        $to_uid1                = $pro_list['create_user_id']; //反馈给业务
                        $to_uname1              = $pro_list['create_user_name'];
                        $to_uid2                = 55; //反馈给财务经理
                        $to_uname2              = '程小平';
                        save_process_log($process_node_id, $pro_status, $title, $req_id, '', $to_uid1, $to_uname1);
                        save_process_log($process_node_id, $pro_status, $title, $req_id, '', $to_uid2, $to_uname2);
                    }
                    $ok_node_id             = 33; //审批协助销售申请
                    save_process_ok($ok_node_id,$audit_remark);
                    $this->success('审核成功');
                }else{
                    $this->error('审核失败');
                }
            }
        }
    }


}
