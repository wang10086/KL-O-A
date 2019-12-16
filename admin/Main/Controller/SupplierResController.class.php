<?php
namespace Main\Controller;
use Sys\P;

ulib('Page');
use Sys\Page;


// @@@NODE-2###SupplierRes###合格供方管理###
class SupplierResController extends BaseController {

    protected $_pagetitle_              = '合格供方管理';
    protected $_pagedesc_               = '录入、修改、删除合格供方资源数据';

    // @@@NODE-3###res###合格供方列表###
    public function res() {
        $this->title('合格供方');
        $pin                            = I('pin') ? I('pin') : 0 ;
		$key                            = trim(I('key'));
		$type                           = trim(I('type'));
		$city                           = trim(I('city'));

		$where                          = array();
		$where['1']                     = priv_where(P::REQ_TYPE_SUPPLIER_RES_V);
        if ($pin)  $where['type']       = $pin;
		if ($key)  $where['name']       = array('like','%'.$key.'%');
		if ($type) $where['kind']       = $type;
		if ($city) $where['city']       = array('like','%'.$city.'%');

		//分页
		$pagecount                      = M('supplier')->where($where)->count();
		$page                           = new Page($pagecount, P::PAGE_SIZE);
		$this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';

        $this->reskind                  = M('supplierkind')->getField('id,name', true);
        $this->lists                    = M('supplier')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->status = array(
            P::AUDIT_STATUS_PASS        => '已通过',
            P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
            P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->types = array(
            1                           => '普通供方',
            2                           => '<span class="blue">合格供方</span>',
            3                           => '<span class="green">集中采购方</span>'
        );
        $this->pin                      = $pin;
        $this->display('res');

    }


	// @@@NODE-3###res_view###合格供方详情###
    public function res_view () {
        $this->title('合格供方');

		$id                                 = I('id',0);
        $this->reskind                      = M('supplierkind')->getField('id,name', true);
        $row                                = M('supplier')->find($id);

		//$where                              = array('type' => P::RES_TYPE_SUPPLIER);
		$this->row                          = $row;

        $this->status                       = array(
                P::AUDIT_STATUS_PASS        => '已通过',
                P::AUDIT_STATUS_NOT_AUDIT   => '待审批',
				P::AUDIT_STATUS_NOT_PASS    => '未通过',
        );
        $this->types = array(
            1                           => '普通供方',
            2                           => '<span class="blue">合格供方</span>',
            3                           => '<span class="green">集中采购方</span>'
        );
        $this->oplist                       = get_supplier_op_lists($id,$row['kind']); //合作记录
		if(I('viewtype')){
			$this->display('res_view_win');
		}else{
       		$this->display('res_view');
		}

    }


    // @@@NODE-3###delres###删除合格供方###
    public function delres(){
        $this->title('删除合格供方');
        $db = M('supplier');
        $id = I('id', -1);
        $iddel = $db->delete($id);
        $this->success('删除成功！');
    }

    // @@@NODE-3###addres###新建合格供方###
    public function addres(){
        $this->title('新建/修改合格供方');
        $db                             = M('supplier');
        $id                             = I('id', 0);

        if(isset($_POST['dosubmit'])){
            $info                       = I('info');
            $referer                    = I('referer');
            $info['name']               = trim($info['name']);
            $info['country']            = trim($info['country']);
            $info['prov']               = trim($info['prov']);
            $info['city']               = trim($info['city']);
            $info['contact']            = trim($info['contact']);
            $info['tel']                = trim($info['tel']);
            $info['desc']               = stripslashes($_POST['content']);

            if (!$info['name'])         $this->error('供方名称不能为空!');
            if (!$info['country'])      $this->error('供方国家不能为空!');
            if (!$info['kind'])         $this->error('供方分类不能为空!');
            if (!$info['prov'])         $this->error('供方省份不能为空!');
            if (!$info['city'])         $this->error('供方所在城市不能为空!');
            if (!$info['contact'] && $info['kind'] != 11) $this->error('供方联系人不能为空!'); //排除景点
            if (!$info['tel'])          $this->error('供方联系电话不能为空!');
            //if (!$info['desc'])         $this->error('供方介绍不能为空!');

            if(!$id){
				$info['input_uid']      = session('userid');
				$info['input_uname']    = session('nickname');
                $info['input_time']     = time();
                $info['audit_status']   = 1; //不用审核
                $isadd                  = $db->add($info);
                if($isadd) {
                    //$this->request_audit(P::REQ_TYPE_SUPPLIER_RES_NEW, $isadd);
                    $this->success('添加成功！',$referer);
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit                 = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',$referer);
                } else {
                    $this->error('修改失败：' . $db->getError());
                }
            }

        }else{
            $where                      = array();
            $where['type']              = P::RES_TYPE_SUPPLIER;
            $where['id']                = array('not in',array(2,6)); //排除专家辅导员 和 研究所台站
            $this->kinds                = M('supplierkind')->where($where)->select();

            if (!$id) {
                $this->row              = false;
            } else {
                $this->row              = $db->find($id);
                if (!$this->row) {
                    $this->error('无此数据！', U('SupplierRes/res'));
                }
            }
            $this->display('addres');
        }


    }


    // @@@NODE-3###reskind###合格供方分类列表###
    public function reskind () {
        $this->title('合格供方分类');
        $where = array('type' => P::RES_TYPE_SUPPLIER);

        $this->lists = M('supplierkind')->where($where)->select();

        $this->display('reskind');

    }


    // @@@NODE-3###addreskind###添加合格供方分类###
    public function addreskind () {
        $this->title('添加/修改合格供方分类');
        $where = array('type' => P::RES_TYPE_SUPPLIER);

        $db = M('supplierkind');

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
                    $this->success('添加成功！',U('SupplierRes/reskind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('SupplierRes/reskind'));
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
                    $this->error('无此数据！', U('SupplierRes/reskind'));
                }
            }
            $this->display('addreskind');
        }

    }


    // @@@NODE-3###delreskind###删除合格供方分类###
    public function delreskind(){
        $this->title('删除合格供方分类');
        $db         = M('supplierkind');
        $id         = I('id', -1);
        $iddel      = $db->delete($id);
        $this->success('删除成功！');
    }

    //资源统计
    /*public function chart(){
        $this->title('资源统计');
        $year                   = I('year',date('Y'));
        $month                  = I('month',date('m'));
        $pin                    = I('pin',1);

        $this->month  		    = $month;
        $this->year 		    = $year;
        $this->prveyear		    = $year-1;
        $this->nextyear		    = $year+1;
        $this->pin              = $pin;
        $this->display();
    }*/

    //资源统计
    public function chart(){
        $this->title('资源统计');
        $mod                    = D('Supplier');
        $year                   = I('year',date('Y'));
        $month                  = I('month',date('m'));
        $where                  = array();
        $supplierKinds          = M('supplierkind')->where($where)->getField('id,name',true);
        $data                   = $mod -> get_supplier_chart($supplierKinds,$year,$month);

        $this->data             = $data;
        $this->supplierKinds    = $supplierKinds;
        $this->month  		    = $month;
        $this->year 		    = $year;
        $this->prveyear		    = $year-1;
        $this->nextyear		    = $year+1;
        $this->display();
    }

    //供方统计详情页
    public function public_chart_detail(){
        $this->title('供方统计详情');
        $mod                    = D('Supplier');
        $year                   = I('year',date('Y'));
        $month                  = I('month',date('m'));
        $kid                    = I('kid',0);
        $supplierKind           = M('supplierkind')->where(array('id'=>$kid))->field('id,name')->find();
        if ($supplierKind['id'] == 2){
            $data               = $mod -> get_guide_supplier_lists($supplierKind,$year,$month);
        }else{
            $data               = $mod -> get_supplier_lists($supplierKind,$year,$month);
        }

        //分页
        $p                              = I('p',1);
        $pagecount                      = count($data);
        $page                           = new Page($pagecount, P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $data                           = arr_page($data,$p,20);

        $this->data             = $data;
        $this->supplierKind     = $supplierKind;
        $this->kid              = $kid;
        $this->year             = $year;
        $this->month            = $month;
        $this->prveyear         = $year-1;
        $this->nextyear         = $year+1;
        $this->display('chart_detail');
    }

    //集中采购执行率-采购主管 KPI
    public function public_focus_buy(){
        $this->title('集中采购执行率');
        $mod                                = D('Supplier');
        $year                               = I('year',date('Y'));
        $month                              = I('month',date('m'));
        $month                              = strlen($month) < 2 ? str_pad($month,2,'0',STR_PAD_LEFT) : $month;
        $yearMonth                          = $year.$month;
        $cycle                              = get_cycle($yearMonth);

        $lists                              = get_timely(4);
        $data                               = $mod->get_focus_buy_data($cycle['begintime'],$cycle['endtime']);
        //P($cycle);


        $this->lists                        = $lists;
        $this->year                         = $year;
        $this->month                        = $month;
        $this->display('focus_buy');
    }

    //集中采购执行率指标详情
    public function public_focus_buy_detail(){
        $id                                 = I('id');
        $db                                 = M('quota');
        $list                               = $db->find($id);
       
        $this->list                         = $list;
        $this->display('focus_buy_detail');
    }

    //集中采购比率指标
    public function focus_buy_list(){
        $this->title('集中采购执行率考核指标');
        $lists                              = get_timely(4);

        $this->lists                        = $lists;
        $this->display();
    }

    //编辑集中采购率考核指标
    public function focus_list_edit(){
        $id                                 = I('id',0);
        $db                                 = M('quota');
        $id                                 = I('id','');
        if ($id){
            $list                           = $db->find($id);
            $list['title']                  = htmlspecialchars_decode($list['title']);
            $list['content']                = htmlspecialchars_decode($list['content']);
            $list['rules']                  = htmlspecialchars_decode($list['rules']);
            $this->list                     = $list;
        }
        $this->display();
    }

    //删除
    public function focus_list_del(){
        $id                                 = I('id');
        if (!$id) $this->error('获取数据错误');
        $res                                = timely_quota_del($id);
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function public_save(){
        $savetype                           = I('savetype');
        if (isset($_POST['dosubmint']) && $savetype){
            if ($savetype == 1){ //保存集中采购率考核指标
                $db                         = M('quota');
                $id                         = I('id');
                $info                       = I('info');
                $info['title']              = htmlspecialchars(trim($info['title']));
                $info['content']            = htmlspecialchars(trim($info['content']));
                $info['rules']              = htmlspecialchars(trim($info['rules']));
                $info['type']               = 4; //4=>集中采购执行率指标(采购主管)
                if (!$info['title'])        $this->error('指标标题不能为空');

                if ($id){
                    $where                  = array();
                    $where['id']            = $id;
                    $res                    = $db->where($where)->save($info);
                }else{
                    $res                    = $db->add($info);
                }
                echo '<script>window.top.location.reload();</script>';
            }
        }
    }

}
