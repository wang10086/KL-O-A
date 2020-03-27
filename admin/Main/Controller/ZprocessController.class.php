<?php
namespace Main\Controller;
use function GuzzleHttp\Promise\is_settled;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class ZprocessController extends BaseController{

    protected $_pagetitle_ = '流程管理';
    protected $_pagedesc_  = '';

	// @@@NODE-3###record###待办事宜###
    public function public_index(){
        $this->title('新建流程');
        $db                     = M('process');
        $type_db                = M('process_type');
        $typeLists              = $type_db ->where(array('status'=>array('neq', '-1'))) -> select();
        foreach ($typeLists as $k=>$v){
            $where              = array();
            $where['type']      = $v['id'];
            $where['status']    = array('neq','-1');
            $processLists       = $db->where($where)->select();
            $typeLists[$k]['pro_num']   = count($processLists);
            $typeLists[$k]['lists']     = $processLists;
        }

        $ids                    = array(); //已有表单页面的process_id
        $this->ids              = $ids;
        $this->lists            = $typeLists;
		$this->display('index');
    }

	// @@@NODE-3###addrecord###新建流程###
	public  function  addProcess(){
	    $db                     = M('process');
        if (isset($_POST['dosubmint'])){
            $id                 = I('id',0);
            $info               = I('info');
            $fileid             = I('fileid');
            $info['title']      = trim($info['title']);
            $info['remark']     = trim($info['remark']);
            $info['fileids']    = $fileid ? implode(',',$fileid) : '';
            $info['input_time'] = NOW_TIME;
            $info['input_uid']  = cookie('userid');
            if (!$info['title']) $this->error('流程标题不能为空');
            if (!$info['type']) $this->error('流程类型不能为空');
            if ($id){
                $res            = $db -> where(array('id'=>$id))->save($info);
                $msg            = '修改';
            }else{
                $res            = $db -> add($info);
                $msg            = '添加';
            }
            $res ? $this->success($msg.'数据成功',U('Zprocess/process')) : $this->error($msg.'数据失败');
        }else{
            $this->title('新建流程');
            $type_db            = M('process_type');
            $typeLists          = $type_db ->where(array('status'=>array('neq', '-1'))) -> select();
            $id                 = I('id',0);
            $processList        = $id ? M('process')->where(array('id'=>$id))->find() : '';
            $fileids            = $processList['fileids'] ? explode(',',$processList['fileids']) : '';
            $files              = $fileids ? M('attachment')->where(array('id'=>array('in',$fileids)))->select() : '';
            $this->files        = $files ? $files : '';
            $this->list         = $processList;
            $this->typeLists    = $typeLists;
            $this->display('addProcess');
        }
	}

	//流程管理
    public function process(){
        $this->title('流程管理');
        $db                     = M('process');
        $type_db                = M('process_type');
        $pin                    = I('pin',0);
        $typeLists              = $type_db ->where(array('status'=>array('neq', '-1'))) -> getField('id,title',true);

        $where                  = array();
        if ($pin) $where['type']= $pin;
        $where['status']        = array('neq','-1');

        //分页
        $pagecount		        = $db->where($where)->count();
        $page			        = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	        = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $processLists           = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->lists            = $processLists;
        $this->typeLists        = $typeLists;
        $this->pin              = $pin;

        $this->display();

    }

	//删除流程
    public function delProcess(){
        $id                     = I('id',0);
        if (!$id) $this->error('获取数据失败');
        $db                     = M('process');
        $data                   = array();
        $data['status']         = '-1';
        $res                    = $db->where(array('id'=>$id))->save($data);
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

	//流程类型管理
    public function setType(){
        $this->title('流程类型管理');
        $db                     = M('process_type');
        $lists                  = $db ->where(array('status'=>array('neq', '-1'))) -> select();

        $this->lists            = $lists;
        $this->display('setType');
    }

    //编辑类型
    public function addType(){
        $db                     = M('process_type');
        if (isset($_POST['dosubmint'])){
            $id                 = I('id',0);
            $title              = trim(I('title'));
            if (!$title){ $this->error('类型标题不能为空'); }
            $data               = array();
            $data['title']      = $title;
            $res                = $id ? $db -> where(array('id'=>$id))->save($data) : $db->add($data);
            //$res ? $this->success('编辑成功') : $this->error('数据保存失败');
            $this->msg          = $res ? '编辑成功' : '数据保存失败';
            $this->display("Index:public_audit");
        }else{
            $id                 = I('id',0);
            if ($id){
                $list           = $db -> where(array('id'=>$id))->find();
                $this->list     = $list;
            }
            $this->display();
        }
    }

    //删除类型
    public function delType(){
        $id                     = I('id',0);
        if (!$id) $this->error('获取数据失败');
        $db                     = M('process_type');
        $data                   = array();
        $data['status']         = '-1';
        $res                    = $db->where(array('id'=>$id))->save($data);
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    //流程节点管理
    public function node(){
        $this->title('流程节点管理');
        $db                     = M('process_node');
        //分页
        $pagecount		        = $db->count();
        $page			        = new Page($pagecount, P::PAGE_SIZE);
        $this->pages	        = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                  = $db->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

        $this->lists            = $lists;
        $this->display('node');
    }

    //添加节点
    public function addNode(){
        $this->title('编辑节点');
        $db                     = M('process_node');
        if (isset($_POST['dosubmint'])){
            $id                 = I('id',0);
            $info               = I('info');
            $info['title']      = trim($info['title']);
            $info['time_data']  = trim($info['time_data']);
            $info['OK_data']    = trim($info['OK_data']);
            $info['remark']     = trim($info['remark']);
            $info['input_time'] = NOW_TIME;
            $info['input_uid']  = cookie('userid');
            if (!$info['title']){ $this->error('类型标题不能为空'); }
            //if (!$info['blame_uid']){ $this->error('责任人信息错误'); }
            //if ($info['ok_feedback'] && !$info['blame_uid']){ $this->error('反馈至人员信息错误'); }
            $res                = $id ? $db -> where(array('id'=>$id))->save($info) : $db->add($info);
            $res ? $this->success('编辑成功',U('Zprocess/node')) : $this->error('数据保存失败');
        }else{
            //人员名单关键字
            $this->userkey      = get_username();
            $id                 = I('id',0);
            if ($id){
                $list           = $db -> where(array('id'=>$id))->find();
                $this->list     = $list;
                $this->processIds = M('process')->where(array('status'=>array('neq','-1')))->getField('id,title',true);
            }
            $this->types        = M('process_type')->where(array('status'=>array('neq','-1')))->getField('id,title',true);
            $this->display();
        }
    }

    //删除流程节点
    public function delNode(){
        $id                     = I('id',0);
        if (!$id) $this->error('获取数据失败');
        $db                     = M('process_node');
        $res                    = $db->where(array('id'=>$id))->delete();
        $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    //流程节点
    public function public_nodeList(){
        $this->title('流程节点');
        $processId              = I('id');
        if (!$processId) $this->error('获取数据错误');
        $list                   = M('process')->where(array('id'=>$processId))->find();
        $lists                  = M('process_node')->where(array('processId'=>$processId))->order('id asc')->select();

        $this->lists            = $lists;
        $this->list             = $list;
        $this->display('nodeList');
    }

    //流程状态
    public function public_status(){
        $this->title('节点状态');
        $processId              = I('id');
        if (!$processId) $this->error('获取数据错误');
        $list                   = M('process')->where(array('id'=>$processId))->find();

        $this->list             = $list;
        $this->display('status');
    }

    //设置表单url
    public function setFormUrl(){
        $db                     = M('process');
        if (isset($_POST['dosubmint'])){
            $id                 = I('id',0);
            $url                = trim(I('form_url'));
            if (!$url){ $this->error('地址不能为空'); }
            $data               = array();
            $data['form_url']   = $url;
            $res                = $db -> where(array('id'=>$id))->save($data);
            $this->msg          = $res ? '编辑成功' : '数据保存失败';
            $this->display("Index:public_audit");
        }else{
            $id                 = I('id',0);
            $list               = $db -> where(array('id'=>$id))->find();
            $this->list         = $list;
            $this->display();
        }
    }

    //创建流程表单
    public function public_form(){
        $id                     = I('id',0);
        if (!$id){ $this->error('获取数据失败'); }
        $process_db             = M('process');
        $list                   = $process_db->find($id);

        $this->list             = $list;

        $ids                    = array(); //已有表单页面的process_id
        $formView               = in_array($id,ids) ? 'form'.$id : 'formDefault';
        $this->display($formView);
    }

}
