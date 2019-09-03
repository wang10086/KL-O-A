<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###ScienceRes###科普资源管理###
class ScienceResController extends BaseController {
    
    protected $_pagetitle_ = '科普资源管理';
    protected $_pagedesc_  = '录入、修改、删除科普资源数据';
     
    // @@@NODE-3###res###科普资源列表###
    public function res () {
        $this->title('科普资源');
		$pin          = I('pin',0);
		$key          = I('key');
		$type         = I('type');
		$pro          = I('pro');
		
		$where = array();
        if ($pin == 1){ $where['in_cas'] = 1; }elseif ($pin ==2){ $where['in_cas'] = 0; }
		$where['1'] = priv_where(P::REQ_TYPE_SCIENCE_RES_V);
		if($key)      $where['title'] = array('like','%'.$key.'%');
		if($type)     $where['kind'] = $type;
		if($pro)      $where['business_dept'] = array('like','%'.$pro.'%');
		
		//分页
		$pagecount = M('cas_res')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->reskind = M('reskind')->getField('id,name', true);
		$this->kinds = M('project_kind')->getField('id,name');
        $this->lists = M('cas_res')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->pin      = $pin;
        $this->display('res');
    
    }
	
	
	// @@@NODE-3###res_view###科普资源详情###
    public function res_view () {
        $this->title('科普资源');
		$id                     = I('id',0);
        $this->reskind          = M('reskind')->getField('id,name', true);
        $row                    = M('cas_res')->find($id);
        $this->cas_res_kind     = M('cas_res_kind')->where(array('res_id'=>$id))->select();
        $this->apply            = C('APPLY_TO');
		
		if($row){
			$where              = array();
			$where['req_type']  = P::REQ_TYPE_SCIENCE_RES_NEW;
			$where['req_id']    = $id;
			$audit              = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show           = '未审批';
				$show_user      = '未审批';
				$show_time      = '等待审批';
			}else if($audit['dst_status']==1){
				$show           = '已通过';
				$show_user      = $audit['audit_uname'];
				$show_time      = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show           = '未通过';
				$show_user      = $audit['audit_uname'];
				$show_time      = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$row['showstatus']  = $show;
			$row['show_user']   = $show_user;
			$row['show_time']   = $show_time;
		}else{
			$this->error('资源不存在' . $db->getError());	
		}
		$this->row              = $row;
		
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->read_res($id,P::UNREAD_CAS_RES); //查看资源

        $this->oplist                       = get_supplier_op_lists($id,6); //合作记录 6=>研究所台站
        $this->display('res_view');
    
    }
    
    
    // @@@NODE-3###delres###删除科普资源###
    public function delres(){
        $this->title('删除科普资源');
        $db                 = M('cas_res');
        $cas_res_kind_db    = M('cas_res_kind');
        $id                 = I('id', -1);
        $iddel              = $db->delete($id);
        $this->del_read($id,P::UNREAD_CAS_RES);
        $this->success('删除成功！');
    }
    
    // @@@NODE-3###addres###新建科普资源###
    public function addres(){
        $this->title('新建/修改科普资源');
        
        $db                                     = M('cas_res');
        $cas_res_kind_db                        = M('cas_res_kind');
        $id                                     = I('id', 0);

        if(isset($_POST['dosubmit'])){
            $info                               = I('info');
            $data                               = I('data');
            $referer                            = I('referer');
			$business_dept                      = I('business_dept');
			$info['content']                    = stripslashes($_POST['content']);
			$info['business_dept']              = implode(',',array_unique($business_dept));

            if(!$id){
				$info['input_user']             = session('userid');
				$info['input_uname']            = session('nickname');
				$info['input_time']             = time();
                $isadd                          = $db->add($info);
                if($isadd) {
                    if ($data){ //保存项目类型
                        foreach ($data as $v){
                            $karr               = array();
                            $karr['res_id']     = $isadd;
                            $karr['kind_id']    = $v['kind_id'];
                            $karr['kind']       = $v['kind'];
                            $karr['apply']      = $v['apply'];
                            $karr['time_length']= $v['time_length'];
                            $karr['use_time']   = $v['use_time'];
                            $karr['scale']      = $v['scale'];
                            $karr['module']     = $v['module'];
                            $karr['money']      = $v['money'];
                            $karr['lead_time']  = $v['lead_time'];
                            $karr['remark']     = $v['remark'];
                            $cas_res_kind_db->add($karr);
                        }
                    }

                    $this->request_audit(P::REQ_TYPE_SCIENCE_RES_NEW, $isadd);
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $reset_ids                      = array();
                if ($data){ //保存项目类型
                    foreach ($data as $v){
                        $karr                   = array();
                        $karr['res_id']         = $id;
                        $karr['kind_id']        = $v['kind_id'];
                        $karr['kind']           = $v['kind'];
                        $karr['apply']          = $v['apply'];
                        $karr['time_length']    = $v['time_length'];
                        $karr['use_time']       = $v['use_time'];
                        $karr['scale']          = $v['scale'];
                        $karr['module']         = $v['module'];
                        $karr['money']          = $v['money'];
                        $karr['lead_time']      = $v['lead_time'];
                        $karr['remark']         = $v['remark'];
                        if ($v['id']){
                            $cas_res_kind_db->where(array('id'=>$v['id']))->save($karr);
                            $reset_ids[]        = $v['id'];
                        }else{
                            $res                = $cas_res_kind_db->add($karr);
                            $reset_ids[]        = $res;
                        }
                    }
                }
                $cas_res_kind_db->where(array('res_id'=>$id,'id'=>array('not in',$reset_ids)))->delete();
                $isedit                         = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',$referer);
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
            $this->kinds            = M('reskind')->where(array('type'=>P::RES_TYPE_SCIENCE))->select();

            if (!$id) {
                $this->row          = false;
            } else {
                $this->row          = $db->find($id);
                $this->kindlist     = $cas_res_kind_db->where(array('res_id'=>$id))->select();
				$depts              = explode(',',$this->row['business_dept']);
				$kinds              = M('project_kind')->getField('id,name');
				$deptlist           = array();
				foreach($depts as $k=>$v){
					if($kinds[$v]){
						$deptlist[$k]['id'] = $v;
						$deptlist[$k]['name'] = $kinds[$v];
					}
				}
				
				$this->deptlist     = $deptlist;
                if (!$this->row) {
                    $this->error('无此数据！', U('ScienceRes/res'));
                }
            }

            $this->apply            = C('APPLY_TO'); //适合人群
            $this->time_length      = C('TIME_LENGTH'); //活动时长
            $this->use_time         = C('USE_TIME'); //可实施时间
            $this->scale            = C('SCALE'); //可接待规模
            $this->lead_time        = C('LEAD_TIME'); //预约需提前时间
            $this->display('addres');
        }
        
        
    }
    
    
    // @@@NODE-3###reskind###科普资源分类列表###
    public function reskind () {
        $this->title('科普资源分类');
        $where = array('type' => P::RES_TYPE_SCIENCE);
        
        $this->lists = M('reskind')->where($where)->select();
        
        $this->display('reskind');
        
    }
    
    
    // @@@NODE-3###addreskind###添加科普资源分类###
    public function addreskind () {
        $this->title('添加/修改科普资源分类');
        $where = array('type' => P::RES_TYPE_SCIENCE);
    
        $db = M('reskind');
        
        $pid  = I('pid', 0);
        
        $id = I('id',0);
        if ($pid <= 0) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = '顶级分类';
        
        } else {
            $father = M('reskind')->find($pid);
        }
        
        
        $this->father = $father;
        
        if(isset($_POST['dosubmit'])){
        
            $info = I('info','');
            $info['level'] = 1;
            $info['pid'] = 0;
            
            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('ScienceRes/reskind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('ScienceRes/reskind'));
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
        
            if (!$id) {
                $this->row = false;
            } else {
                $this->row = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('ScienceRes/reskind'));
                }
            }
            $this->display('addreskind');
        }
    
    }
    
    
    // @@@NODE-3###delreskind###删除科普资源分类###
    public function delreskind(){
        $this->title('删除科普资源分类');
        $db = M('reskind');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }


    public function public_kpi_res () {
        $this->title('科普资源');
        $target                         = I('target',0);
        $ids                            = explode(',',I('ids'));

        $where                          = array();
        //$where['1']                   = priv_where(P::REQ_TYPE_SCIENCE_RES_V);
        $where['id']                    = array('in',$ids);

        //分页
        $pagecount                      = M('cas_res')->where($where)->count();
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->reskind                  = M('reskind')->getField('id,name', true);
        $this->kinds                    = M('project_kind')->getField('id,name');
        $lists                          = M('cas_res')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->lists                    = $lists;
        $this->status                   = array(
            P::AUDIT_STATUS_PASS        => '已通过',
            P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
            P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $num                            = count($lists);
        $average                        = (round($num/$target,4)*100).'%';
        $data                           = array();
        $data['target']                 = $target;
        $data['num']                    = $num;
        $data['average']                = $average;
        $this->data                     = $data;
        $this->display('kpi_res');

    }
    

    
    
}