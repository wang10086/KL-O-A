<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

class CourController extends BaseController {

    protected $_pagetitle_ = '培训管理';
    protected $_pagedesc_  = '';

	//课件列表
	public function courlist(){

		$db 			= M('cour');
		$type 		= I('type','-1');
		$keywords 	= I('keywords');

		$where 		= '`del` = 0 ';
		if($type!='-1') $where .= 'and `cour_type` = '.$type;
		if($keywords)   $where .= 'and ((`subject` like "%'.$keywords.'%")  OR (`create_uname` like "%'.$keywords.'%")) ';


		$typelist    = M('cour_type')->GetField('type_id,type_name',true);

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$datalist = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('cour_id'))->select();
		foreach($datalist as $k=>$v){
			$datalist[$k]['courtype'] = 	$typelist[$v['cour_type']];
		}


		$this->typelist    	= $typelist;
		$this->datalist 		= $datalist;

		$this->display('cour');

	}




	//课件类型
	public function courtype(){

		$db 		= M('cour_type');
		$where 	= array();

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';



		//查询分类列表
		$typelist = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('type_id'))->select();
		foreach($typelist as $k=>$v){
			$typelist[$k]['cnt'] = M('cour')->where(array('cour_type'=>$v['type_id'],'del'=>0))->count();
		}


		$this->datalist = $typelist;
		$this->display('cour_type');

	}



	//编辑分类
	public function courtype_edit(){



		if(isset($_POST['dosubmint'])){

			$info 	= I('info');
			$editid = I('editid');

			if($editid){
				M('cour_type')->data($info)->where(array('type_id'=>$editid))->save();
			}else{
				$info['create_time'] = time();
				M('cour_type')->add($info);
			}
			echo '<script>window.top.location.reload();</script>';


		}else{

			$id = I('id',0);
			$this->row = M('cour_type')->find($id);

			$this->display('courtype_edit');
		}



	}





	//新增课件
	public function cour_add(){

		if(isset($_POST['dosubmint'])){

			$info      = I('info');
			$tag       = I('tag');
			$score     = I('score');
			$work      = I('work');
			$matter    = I('attr');
			$res       = I('fac');

			if($info){

				//新增主表信息
				$info['create_time'] 	= time();
				$info['update_time'] 	= time();
				$info['create_uid']     	= cookie('userid');
				$info['create_uname']  	= cookie('name');
				$info['tag']         	= trim(implode(',',$tag),',');

				$add = M('cour')->add($info);
				if($add){

					//保存课件材料
					if($matter){

						foreach($matter['id'] as $k=>$v){
							$data = array();
							$data['catid']  		= 317;
							$data['rel_id'] 		= $add;
							$data['filename']  	= $matter['filename'][$k];
							M('attachment')->data($data)->where(array('id'=>$v))->save();
						}
					}


					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));
				}
			}

		}else{
			$this->typelist    = M('cour_type')->GetField('type_id,type_name',true);
			$this->display('cour_add');
		}
	}





	//修改课件
	function cour_edit(){

		if(isset($_POST['dosubmint'])){

			$cour_id     = I('cour_id');
			$info        = I('info');
			$tag         = I('tag');
			$score       = I('score');
			$work        = I('work');
			$matter      = I('attr');
			$res         = I('fac');

			if($info){
				$info['update_time'] = time();
				$info['tag']         = trim(implode(',',$tag),',');
				$edit = M('cour')->data($info)->where(array('cour_id'=>$cour_id))->save();
				if($edit){

					//保存课件材料
					M('attachment')->data(array('rel_id'=>0))->where(array('catid'=>317,'rel_id'=>$cour_id))->save();

					if($matter){
						foreach($matter['id'] as $k=>$v){
							$data = array();
							$data['catid']    	= 317;
							$data['rel_id']    	= $cour_id;
							$data['filename']  	= $matter['filename'][$k];
							M('attachment')->data($data)->where(array('id'=>$v))->save();
						}
					}

					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));
				}

			}

		}else{
			$id = I('id',-1);
			$row = M('cour')->find($id);

			//获取默认素材
			$attid = array();
			$this->attachment = M('attachment')->field('id')->where(array('catid'=>317,'rel_id'=>$id))->select();  //
			foreach($this->attachment as $v){
				$attid[] = 	$v['id'];
			}



			$this->row         = $row;
			$this->atts        = implode(',',$attid);
			$this->taglist     = explode(",",$row['tag']);
			$this->typelist    = M('cour_type')->GetField('type_id,type_name',true);

			$this->display('cour_edit');
		}

	}




	//删除课程
	public function delcourse(){
		$id = I('id');
		if($id){
			M('cour')->where(array('cour_id'=>$id))->data(array('del'=>'1'))->save();
			$this->success('删除成功！',I('referer',''));
		}else{
			$this->error('删除失败！',I('referer',''));
		}


	}


	//培训记录
	public function pptlist(){

		$db 			    = M('cour_ppt');
		$type 		        = I('type','-1');
		$keywords 	        = I('keywords');
        $kpiUrl             = trim(I('kpiUrl'));
        $kpi_cour_ids       = explode(',',trim(I('kpi_cour_ids')));
		if ($kpiUrl){
            $where          = array();
            $where['del']   = 0;
            $where['id']    = array('in',$kpi_cour_ids);
        }else{
            $where 	        = '`del`=0 ';
		    if($keywords)   $where .= 'and ((`ppt_title` like "%'.$keywords.'%")  OR (`lecturer_uname` like "%'.$keywords.'%")  OR (`lecture_address` like "%'.$keywords.'%")) ';
        }


        //分页
		$pagecount          = $db->where($where)->count();
		$page               = new Page($pagecount, P::PAGE_SIZE);
		$this->pages        = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$datalist           = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

		$this->datalist 	= $datalist;
		$this->display('pptlist');

	}



	//新增记录
	public function ppt_add(){

		if(isset($_POST['dosubmint'])){

			$info      = I('info');
			$matter    = I('attr');

			if($info){

				//新增主表信息
				$info['create_time'] 	= time();
				$info['update_time'] 	= time();
				$info['lecturer_uid']   = cookie('userid');
				$info['lecturer_uname'] = $info['lecturer_uname'] ? $info['lecturer_uname'] : cookie('name');
				$info['lecture_date'] 	= $info['lecture_date'] ? strtotime($info['lecture_date']) : 0;

				$add = M('cour_ppt')->add($info);
				if($add){

					//保存课件材料
					if($matter){
						foreach($matter['id'] as $k=>$v){
							$data = array();
							$data['catid']  		= 318;
							$data['rel_id'] 		= $add;
							$data['filename']  	= $matter['filename'][$k];
							M('attachment')->data($data)->where(array('id'=>$v))->save();
						}
					}


					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));
				}
			}

		}else{
			$this->courlist    = M('cour')->GetField('cour_id,subject',true);
			$this->display('ppt_add');
		}
	}





	//修改记录
	function ppt_edit(){

		if(isset($_POST['dosubmint'])){

			$ppt_id 		= I('ppt_id');
			$info 		= I('info');
			$matter 		= I('attr');

			if($info){
				$info['update_time'] 	= time();
				$info['lecture_date'] 	= $info['lecture_date'] ? strtotime($info['lecture_date']) : 0;
				$edit = M('cour_ppt')->data($info)->where(array('id'=>$ppt_id))->save();
				if($edit){

					//保存课件材料
					if($matter){
						foreach($matter['id'] as $k=>$v){
							$data = array();
							$data['catid']    	= 318;
							$data['rel_id']    	= $ppt_id;
							$data['filename']  	= $matter['filename'][$k];
							M('attachment')->data($data)->where(array('id'=>$v))->save();
						}
					}

					$this->success('保存成功！',I('referer',''));
				}else{
					$this->error('保存失败！',I('referer',''));
				}

			}

		}else{
			$id = I('id',-1);
			$row = M('cour_ppt')->find($id);


			//获取默认素材
			$attid = array();
			$this->attachment = M('attachment')->field('id')->where(array('catid'=>318,'rel_id'=>$id))->select();  //
			foreach($this->attachment as $v){
				$attid[] = 	$v['id'];
			}



			$this->row         = $row;
			$this->atts        = implode(',',$attid);
			$this->courlist    = M('cour')->GetField('cour_id,subject',true);

			$this->display('ppt_edit');
		}

	}



	//删除记录
	public function delppt(){
		$id = I('id');
		if($id){
			M('cour_ppt')->where(array('id'=>$id))->data(array('del'=>'1'))->save();
			$this->success('删除成功！',I('referer',''));
		}else{
			$this->error('删除失败！',I('referer',''));
		}
	}

	//培训计划
    public function courPlan(){
	    $this->title('培训计划');
        $db                         = M('cour_plan');
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

	    $this->display('cour_plan');
    }

    public function add_plan(){
	    $this->title('编辑培训计划');
	    $id                         = I('id');
	    if ($id){
	        $db                     = M('cour_plan');
	        $this->list             = $db->find($id);
        }

        $this->process_data     = get_process_data(); //流程
        $this->userkey          = get_username(); //人员名单关键字
	    $this->display();
    }

    //培训需求
    public function courNeed(){
	    $this->title('培训需求');

	    $this->display('cour_need');
    }

    //培训方案
    public function courPro(){
        $this->title('培训方案');
        $pro_need_lists         = M('cour_plan')->field('id,title')->order('id desc')->select();

        $this->pro_need_lists   = $pro_need_lists;
        $this->process_data     = get_process_data(); //流程
        $this->userkey          = get_username(); //人员名单关键字
        $this->display('cour_pro');
    }

    //培训记录
    public function courRecord(){
        $this->title('培训记录');

        $this->display('cour_record');
    }

    //新增培训记录
    public function add_cour_record(){
	    $this->title('新增培训记录');

        //人员名单关键字
        $this->userkey          = get_username();
        $this->users            = M('account')->where(array('status'=>0,'id'=>array('gt',10),'nickname'=>array('notlike','%1')))->order('id asc')->field('id,nickname')->select();
	    $this->display();
    }

    //删除培训记录
    public function del_cour_record(){
	    $db                     = M('');
	    $id                     = I('id');
	    if (!$id) $this->error('获取数据错误');
	    $res                    = $db->where(array('id'=>$id))->delete();
	    $res ? $this->success('删除成功') : $this->error('删除失败');
    }

    public function public_save_process(){
        $saveType                   = I('saveType');
        if (isset($_POST['dosubmint'])){
            if ($saveType == 1){ //保存培训计划
                $db                     = M('cour_plan');
                $id                     = I('id');
                $info                   = I('info');
                $info['title']          = trim($info['title']);
                $info['in_time']        = strtotime($info['in_time']);
                if (!$info['title']) $this->error('培训标题不能为空');
                if (!$info['blame_name'] || !$info['blame_uid']) $this->error('提交人信息输入有误');
                $process_node_data      = get_process_node_data(7); //7=>制定业务季产品培训方案
                $info['audit_uid']      = $process_node_data['blame_uid'] ? $process_node_data['blame_uid'] : 0;
                $info['audit_uname']    = $process_node_data['blame_name'] ? $process_node_data['blame_name'] : '';
                if ($id){
                    $res                = $db->where(array('id'=>$id))->save($info);
                }else{
                    $info['create_time']= NOW_TIME;
                    $info['create_user_name'] = cookie('nickname');
                    $info['create_user_id'] = cookie('userid');
                    $res                = $db->add($info);
                    $id                 = $res;
                }
                $res ? $this->success('保存成功',U('Cour/add_plan',array('id'=>$id))) : $this->error('保存失败');
            }
            if ($saveType == 2){ //提交审核市场营销计划
                $db                 = M('cour_plan');
                $id                 = I('id');
                $data               = array();
                $data['status']     = 3;
                $res                = $db->where(array('id'=>$id))->save($data);
                $res ? $this->success('数据保存成功',U('Cour/courPlan')) : $this->error('数据保存失败');
            }
        }
    }


}
