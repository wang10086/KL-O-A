<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###GuideRes###导游辅导员管理###
class GuideResController extends BaseController {
    
    protected $_pagetitle_ = '导游辅导员管理';
    protected $_pagedesc_  = '录入、修改、删除导游辅导员资源数据';
     
    // @@@NODE-3###res###导游辅导员列表###
    public function res () {
        $this->title('导游辅导员');
		$key          = I('key');
		$type         = I('type');
		$sex         = I('sex');
		$where = array();
		$where['1'] = priv_where(P::REQ_TYPE_GUIDE_RES_V);
		if($key)      $where['name'] = array('like','%'.$key.'%');
		if($type)     $where['kind'] = $type;
		if($sex)     $where['sex'] = $sex;
		
		//分页
		$pagecount = M('guide')->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';
        
        $this->reskind = M('guidekind')->getField('id,name', true);
        $this->lists = M('guide')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->display('res');
    
    }
	
	
	// @@@NODE-3###res_view###导游辅导员详情###
    public function res_view () {
        $this->title('导游辅导员');
		
		$id = I('id',0);

        $this->reskind = M('guidekind')->getField('id,name', true);
        $row = M('guide')->find($id);

		if($row){
			$where = array();
			$where['req_type'] = P::REQ_TYPE_GUIDE_RES_NEW;
			$where['req_id']   = $id;
			$audit = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show = '未审批';
				$show_user = '未审批';
				$show_time = '等待审批';
			}else if($audit['dst_status']==1){
				$show = '已通过';
				$show_user = $audit['audit_uname'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show = '未通过';
				$show_user = $audit['audit_uname'];
				$show_time = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$row['showstatus'] = $show;
			$row['show_user']  = $show_user;
			$row['show_time']  = $show_time;
		}else{
			$this->error('导游/辅导员不存在' . $db->getError());	
		}
		$this->row = $row;
		
        $this->status = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );

        //价格
        $kind   = $row['kind'];
        $cost = M('guide_price as g')->field('g.*,k.name as kname')->join('inner join __PROJECT_KIND__ as k on g.kid = k.id')->where(array('g.gk_id'=>$kind))->select();
        $this->cost     = $cost;

        //出团记录
        $opids = M('guide as g')->join("left join oa_op_guide as o on o.guide_id = g.id ")->where(array('g.id'=>$id))->field('o.op_id')->select();
        $opids = array_column($opids,'op_id');
        foreach ($opids as $v){
            $guide      = M()->table('__OP_GUIDE__ as g')->field('g.*,c.cost,c.really_cost,c.upd_remark,p.group_id,p.project,s.audit_status')->join('__OP_COST__ as c on c.link_id=g.id')->join("left join __OP__ as p on p.op_id = g.op_id")->join("left join __OP_SETTLEMENT__ as s on s.op_id = g.op_id")->where(array('c.remark'=>$row['name']))->select();
        }
        foreach ($guide as $k=>$v){
            if ($v['audit_status']==0) $guide[$k]['stu']  = '<span class="yellow">已提交结算</span>';
            if ($v['audit_status']==1) $guide[$k]['stu']  = '<span class="green">完成结算</span>';
            if ($v['audit_status']==2) $guide[$k]['stu']  = '<span class="yellow">结算未通过</span>';
            if ($v['really_cost'] == '0.00') $v['really_cost'] = null;
            $guide[$k]['really_cost'] = $v['really_cost']?$v['really_cost']:$v['cost'];
            $guide[$k]['remark']      = $v['upd_remark']?"<span class='red'>$v[upd_remark]</span>":$v['remark'];
        }
        $this->guide    = $guide;

		if(I('viewtype')){
			$this->display('res_view_win');
		}else{
        	$this->display('res_view');
		}
    
    }
    
    
    // @@@NODE-3###delres###删除导游辅导员###
    public function delres(){
        $this->title('删除导游辅导员');
        $db = M('guide');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }
    
    // @@@NODE-3###addres###新建导游辅导员###
    public function addres(){
        $this->title('新建/修改导游辅导员');
        
        $db             = M('guide');
        $guide_price_db = M('guide_price');
        $id             = I('id', 0);

        if(isset($_POST['dosubmit'])){
            $cost       = I('cost');
            $info       = I('info');
            $referer    = I('referer');
			$info['experience'] = stripslashes($_POST['content']);
			
            if(!$id){
				$info['input_uid'] = session('userid');
				$info['input_uname'] = session('nickname');
				$info['input_time']  = time();
                $isadd = $db->add($info);
                if($isadd) {
                    foreach ($cost as $v){
                        $v['gk_id']    = $isadd;
                        $res = $guide_price_db->add($v);
                    }
                    $this->request_audit(P::REQ_TYPE_GUIDE_RES_NEW, $isadd);
                    if (!$res){
                        $this->error('保存价格失败：' . $db->getError());
                    }
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $guide_price_db->where(array('gk_id'=>$id))->delete();
                    foreach ($cost as $v){
                        $v['gk_id']    = $id;
                        $res = $guide_price_db->add($v);
                    }
                    if (!$res){
                        $this->error('保存价格失败：' . $db->getError());
                    }
                    $this->success('修改成功！',$referer);
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }
            	
        }else{
            $this->kinds      = M('guidekind')->where(array('type'=>P::RES_TYPE_GUIDE))->select();
            $this->pro_kinds  = get_project_kinds();
            $this->cost       = $guide_price_db->where(array('gk_id'=>$id))->select();

            if (!$id) {
                $this->row = false;
            } else {
                $this->row = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('GuideRes/res'));
                }
            }
            $this->display('addres');
        }
        
        
    }
    
    
    // @@@NODE-3###reskind###导游辅导员分类列表###
    public function reskind () {
        $this->title('导游辅导员分类');
        $where = array('type' => P::RES_TYPE_GUIDE);
        
        $this->lists = M('guidekind')->where($where)->select();
        
        $this->display('reskind');
        
    }
    
    
    // @@@NODE-3###addreskind###添加导游辅导员分类###
    public function addreskind () {
        $this->title('添加/修改导游辅导员分类');
        $where = array('type' => P::RES_TYPE_GUIDE);
    
        $db = M('guidekind');
        
        $pid  = I('pid', 0);
        
        $id = I('id',0);
        if ($pid <= 0) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = '顶级分类';
        
        } else {
            $father = M('guidekind')->find($pid);
        }
        
        
        $this->father = $father;
        
        if(isset($_POST['dosubmit'])){
        
            $info = I('info','');
            $info['level'] = 1;
            $info['pid'] = 0;
            
            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('GuideRes/reskind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('GuideRes/reskind'));
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
                    $this->error('无此数据！', U('GuideRes/reskind'));
                }
            }
            $this->display('addreskind');
        }
    
    }
    
    
    // @@@NODE-3###delreskind###删除导游辅导员分类###
    public function delreskind(){
        $this->title('删除导游辅导员分类');
        $db = M('guidekind');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }

    // @@@NODE-3###delreskind###修改(讲师辅导员)实际所得金额###
    public function upd_cost(){
        if (isset($_POST['dosubmint'])){
            $op_id          = I('op_id');
            $remark         = I('remark');
            $info           = I('info');
            $db             = M('op_cost');
            $where          = array();
            $where['op_id'] = $op_id;
            $where['remark']= $remark;
            $res = $db->where($where)->save($info);
            echo '<script>window.top.location.reload();</script>';
        }else{
            $op_id          = I('op_id');
            $cost           = I('cost');
            $name           = I('name');
            $this->op_id    = $op_id;
            $this->cost     = $cost;
            $this->name     = $name;
            $this->display('upd_cost');
        }
    }

// @@@NODE-3###GuideRes/price###导游辅导员价格体系###
    public function price(){
        $kname  = I('kname');
        $gkname = I('gkname');
        $where  = array();
        if ($kname) $where['k.name']    = array('like',"%$kname%");
        if ($gkname) $where['gk.name'] = array('like',"%$gkname%");

        //分页
        $pagecount = M('guide_price')->where($where)->count();
        $page = new Page($pagecount, P::PAGE_SIZE);
        $this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->kinds      = M('guidekind')->where(array('type'=>P::RES_TYPE_GUIDE))->select();
        $this->pro_kinds  = get_project_kinds();
        $this->lists      = M('guide_price as p')->field('p.*,gk.name as gkname,k.name as kname')->join('left join __GUIDEKIND__ as gk on p.gk_id = gk.id')->join('left join __PROJECT_KIND__ as k on p.kid = k.id')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('p.id desc')->select();

        $this->pagetitle = '导游辅导员价格体系';
        $this->display('price');
    }

    // @@@NODE-3###GuideRes/addprice###添加/修改导游辅导员价格体系###
    public function addprice(){
        $db     = M('guide_price');
        $id     = I('id');
        if (isset($_POST['dosubmint'])){
            $info = I('info');
            if(!$id){
                $res = $db->add($info);
            }else{
                $res = $db->where(array('id'=>$id))->save($info);
            }
            echo '<script>window.top.location.reload();</script>';
        }
        $this->row        = $db->where(array('id'=>$id))->find();
        $this->kinds      = M('guidekind')->where(array('type'=>P::RES_TYPE_GUIDE))->select();
        $this->pro_kinds  = get_project_kinds();
        $this->display('addprice');
    }

    // @@@NODE-3###GuideRes/del_price###删除导游辅导员价格体系###
    public function del_price(){
        $db = M('guide_price');
        $id = I('id');
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }

    
}