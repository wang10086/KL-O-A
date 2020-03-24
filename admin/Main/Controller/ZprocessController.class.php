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
            $res ? $this->success($msg.'数据成功') : $this->error($msg.'数据失败');
        }else{
            $this->title('新建流程');
            $type_db            = M('process_type');
            $typeLists          = $type_db ->where(array('status'=>array('neq', '-1'))) -> select();
            $this->typeLists    = $typeLists;
            $this->display('addProcess');
        }
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
            $res ? $this->success('编辑成功') : $this->error('数据保存失败');
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

}
