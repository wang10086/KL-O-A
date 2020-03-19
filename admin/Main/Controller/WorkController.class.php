<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class WorkController extends BasepubController{

	// @@@NODE-3###record###工作记录###
    public function record(){


        $this->title('工作记录');

		$db		= M('work_record');
		$kinds	= C('REC_TYPE');

		$title	= trim(I('title'));		//项目名称
		$type 	= I('type');
		$id 	= I('id');
		$uname  = I('uname');
		$rname  = I('rname');
		$month  = I('month');
		$com	= I('com',0);
		$status = I('status');

		$where = array();

		if($id) 			$where['id']					= $id;
		if($month) 			$where['month']					= $month;
		if($title)			$where['title']					= array('like','%'.$title.'%');
		if($type)			$where['type']					= $type;
		if($uname)			$where['user_name']				= array('like','%'.$uname.'%');
		if($rname)			$where['rec_user_name']			= array('like','%'.$rname.'%');
		if($com==1) 		$where['user_id']				= cookie('userid');
		if($com==2) 		$where['rec_user_id']			= cookie('userid');
		//if($status)  	    $where['status']			    = $status;

		//分页
		$pagecount		= $db->where($where)->count();
		$page			= new Page($pagecount, P::PAGE_SIZE);
		$this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';


		//$sta = array('0'=>'<span class="red">正常</span>','1'=>'<span class="green">已撤销或未通过审核</span>');

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('rec_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['kinds'] 	= $kinds[$v['type']];
			$lists[$k]['rec_time'] 	= date('Y-m-d H:i:s',$v['rec_time']);
			//$lists[$k]['status'] 	= $sta[$v['status']];
		}


		$this->com 			= $com;
		$this->lists   		= $lists;
		$this->kinds 		= $kinds;
		$this->type 		= $type;
		$this->display('record');
    }


	// @@@NODE-3###addrecord###创建记录###
	public  function  addrecord(){

		$recid			= 0;//I('recid');
		$db				= M('work_record');

		if(isset($_POST['dosubmint']) && $_POST['dosubmint']){

			$info		= I('info');
			$com		= I('com');
			$recid 		= I('recid');

			if(!$info['user_name'])		$this->error('请输入工作人员信息' . $db->getError());
			if(!$info['user_id'])		$this->error('请输入工作人员信息无效' . $db->getError());
			if(!$info['month'])			$this->error('请输入工作月份' . $db->getError());
			if(!$info['type'])			$this->error('请选择工作记录类型' . $db->getError());
			if(!$info['typeinfo'])		$this->error('请选择工作记录详细类型' . $db->getError());
			if(!$info['title'])			$this->error('请输入记录标题' . $db->getError());
			if(!$info['content'])		$this->error('请输入记录内容' . $db->getError());


			$info['rec_user_id']	= cookie('userid');
			$info['rec_user_name']	= cookie('name');
			$info['status']			= 0;
			$info['year']			= substr($info['month'], 0, 4);
            $info['status']         = 1;

			//保存主表
			if($reid){
				$db->where(array('id'=>$recid))->data($info)->save();
			}else{
				$info['rec_time']		= time();
				$reid = $db->add($info);
			}

			//添加工作记录必须由品控部经理审核
            /*//$role_id    = 47;
            $uid        = M('account')->where(array('roleid'=>$role_id))->getField('id');

			$send 		= cookie('userid');
			$title 		= '您有新的工作记录待审核：'.$info['title'];
			$content 	= $info['content'];
			$user		= '['.$uid.']';
			$url		= U('Worder/verify_record',array('id'=>$reid));

			//发送消息
			//send_msg($send,$title,$content,$url,$user);*/


			$this->success('保存成功！',I('referer',''));

		}else{


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


			$this->kinds 		= C('REC_TYPE');
			$this->kindinfo 	= C('REC_TYPE_INFO');
			$this->rec			= M('work_record')->find($recid);
			$this->display('addrecord');
		}
	}

	//审核
    public function verify_record(){

        $db             = M('work_record');
        if(isset($_POST['dosubmint'])){
            $info       = I('info');
            $id         = I('id');
            $res        = $db->where(array('id'=>$id))->save($info);
            if ($res){
                if ($info['status'] == 0){
                    $data   = $db->where(array('id'=>$id))->find();
                    //如果审核通过,向被记录人发送系统消息
                    $send 		= $data['rec_user_id'];
                    $title 		= '您有新的工作记录产生：'.$data['title'];
                    $content 	= $data['content'];
                    $user		= '['.$data['user_id'].']';
                    $url		= U('Work/record',array('id'=>$id));
                    send_msg($send,$title,$content,$url,$user);
                }
                $this->success("保存数据成功",U('Work/record'));
            }else{
                $this->error('保存数据失败',U('Work/record'));
            }

        }else{
            $id             = I('id');
            $info           = $db->where(array('id'=>$id))->find();
            //判断状态
            if($info['status']==0) $info['sta'] = '<span class="red">正常记录</span>';
            if($info['status']==1) $info['sta'] = '<span class="green">已撤销或未通过审核</span>';
            //纪录性质
            $kinds 		    = C('REC_TYPE');
            foreach ($kinds as $k=>$v){
                if ($info['type'] == $k){
                    $info['type_name'] = $v;
                }
            }
            //详细分类
            $kindinfo 	= C('REC_TYPE_INFO');
            foreach ($kindinfo as $value){
                foreach ($value as $k=>$v){
                    if ($info['typeinfo']==$k){
                        $info['kf_name'] = $v;
                    }
                }
            }
            $uid            = $info['rec_user_id'];
            $info['rec_dept_name'] = M('account')->alias('a')->where(array('a.id'=>$uid))->join("left join oa_role as r on r.id=a.roleid")->getField('r.role_name');
            $this->info     = $info;
            $this->display();
        }
    }

	//详情
    public function public_work_detail(){
        $id                     = I('id',0);
        if (!$id) $this->error('获取数据错误');
        $db                     = M('work_record');
        $list                   = $db->where(array('id'=>$id))->find();

        //纪录性质
        $kinds 		    = C('REC_TYPE');
        foreach ($kinds as $k=>$v){
            if ($list['type'] == $k){
                $list['type_name'] = $v;
            }
        }
        //详细分类
        $kindinfo 	= C('REC_TYPE_INFO');
        foreach ($kindinfo as $value){
            foreach ($value as $k=>$v){
                if ($list['typeinfo']==$k){
                    $list['kf_name'] = $v;
                }
            }
        }
        $uid            = $list['rec_user_id'];
        $list['rec_dept_name'] = M('account')->alias('a')->where(array('a.id'=>$uid))->join("left join oa_role as r on r.id=a.roleid")->getField('r.role_name');
        $this->info     = $list;
        $this->display('work_detail');
    }



	// @@@NODE-3###revoke###撤销记录###
	public  function  revoke(){

		$recid			= I('recid');
		$db				= M('work_record');

		//查询记录
		$rec			= $db->find($recid);


		if(!$rec || !$recid)		$this->error('记录不存在' . $db->getError());
		if($rec['status']==1)		$this->error('记录已经撤销' . $db->getError());

		if($rec['rec_user_id'] == cookie('userid')  || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 || cookie('roleid')==13 || cookie('roleid')==14 || cookie('roleid')==54){

			//执行撤销
			$db->where(array('id'=>$recid))->data(array('status'=>"-1"))->save();
			$this->success('撤销成功！');

		}else{
			$this->error('您没有权限撤销' . $db->getError());
		}

	}


}
