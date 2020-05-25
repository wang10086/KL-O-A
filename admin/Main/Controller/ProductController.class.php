<?php
namespace Main\Controller;
use Sys\P;
ulib('Pinyin');
ulib('Page');
use Sys\Page;
use Sys\Pinyin;

// @@@NODE-2###Product###产品管理###
class ProductController extends BaseController {

    protected $_pagetitle_ = '产品模块管理';
    protected $_pagedesc_  = '';


    // @@@NODE-3###index###产品列表###
    public function index(){
        $this->title('产品模块列表');

		$key                                    = I('key');
		$pro                                    = I('pro');
        $type                                   = I('type');
        $fields                                 = I('subject_field');
        $from                                   = I('from');
		$age                                    = I('age');

		$db                                     = M('product');
		$this->pro                              = $pro;
		$where                                  = array();
        $where['standard']                      = 2; //非标准化
        if($key)    $where['p.title']           = array('like','%'.$key.'%');
        if($pro)    $where['p.business_dept']   = array('like','%'.$pro.'%');
        if($age)    $where['p.age']             = array('like','%'.$age.'%');
        if($type)   $where['p.type']            = array('eq',$type);
        if($from)   $where['p.from']            = array('eq',$from);
        if($fields) $where['p.subject_field']   = array('eq',$fields);
        //$where['p.disting']                     = 0; //0=>老数据, 1=>新数据

		$business_depts                         = C('BUSINESS_DEPT');
        $page                                   = new Page($db->table('__PRODUCT__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages                            = $page->show();
		$lists                                  = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
        $kinds                                  = M('project_kind')->getField('id,name');
        $ages                                   = C('AGE_LIST');
        foreach($lists as $k=>$v){
			$depts                              = explode(',',$v['business_dept']);
			$deptval                            = array();
			foreach($depts as $kk=>$vv){
				$deptval[]                      = $kinds[$vv];
			}
            $age                                = explode(',',$v['age']);
            $in_ages                            = array();
            foreach($age as $kk=>$vv){
                $in_ages[]                      = $ages[$vv];
            }
			$lists[$k]['dept']                  = implode(',',$deptval);
			$lists[$k]['in_ages']               = implode(',',$in_ages);
		}

		$this->lists                            = $lists;
        $this->ptype                            = C('PRODUCT_TYPE');
        $this->pfrom                            = C('PRODUCT_FROM');
        $this->kinds                            = $kinds;
        $this->ages                             = C('AGE_LIST');
        $this->reckon_mode                      = C('RECKON_MODE');
        $this->subject_fields                   = C('SUBJECT_FIELD');

        //导航栏
        $kind_ids                               = array(54,55,56,60,61,62);
        $where                                  = array();
        $where['id']                            = array('in',$kind_ids);
        $this->business_dept                    = M('project_kind')->where($where)->getField('id,name');

		$this->display('index');
    }


    // @@@NODE-3###del###删除产品模块###
    public function del(){
        $this->title('删除产品');
		$db                     = M('product');
        $product_material_db    = M('product_material');
        $product_module_db      = M('product_module');
        $id                     = I('id') ? I('id') : $this->error('删除数据失败');
		$del                    = $db->delete($id);
        if ($del){
            //M('product_use')->where(array('pid'=>$id))->delete();
            $product_material_db->where(array('product_id'=>$id))->delete();
            $product_module_db->where(array('product_id'=>$id))->delete();
            $this->success('删除成功');
        }
    }

    // @@@NODE-3###add###添加产品###
    public function add() {
        $this->title('添加产品');

        if (isset($_POST['dosubmit'])) {

            $attdb              = M('attachment');
            $info               = I('info');
            $referer            = I('referer');
            $material           = I('material');
            $resid              = I('resid');
            $business_dept      = I('business_dept');   //模块类型
            $age                = I('age');
            $res                = I('res');
            $info['content']    = stripslashes($_POST['content']);
            $info['business_dept'] = $business_dept;
            $info['age']        = implode(',',array_unique($age));
            $info['supplier']   = implode(',',array_unique($res));
            //$info['disting']    = 0;
            $id                 = I('id');

            //上传文件
            $theory     = I('theory');  //原理及实施要求
            $pic        = I('pic');     //图片
            $video      = I('video');   //视频
            $theory_ids = $theory['id'];
            $pic_ids    = $pic['id'];
            $video_ids  = $video['id'];
            //$resfiles   = array_merge($theory_ids,$pic_ids,$video_ids);
            $resfiles   = array();
            foreach ($theory_ids as $k=>$v){
                $resfiles[] = $v;
            }
            foreach ($pic_ids as $k=>$v){
                $resfiles[]   = $v;
            }
            foreach ($video_ids as $k=>$v){
                $resfiles[]   = $v;
            }
            $aids               = implode(',', $resfiles);
            $info['att_id']     = $aids?$aids:'';

            if ($id) {
                $isadd = $id;
                //修改
                M('product')->where("id=$id")->data($info)->save();

                //修改物资信息
                $delid = array();
                foreach($material as $k=>$v){
                    $data = array();
                    $data = $v;
                    $data['material'] = trim($v['material']);
                    if($data['material']){
                        if($resid && $resid[$k]['id']){
                            $edits = M('product_material')->data($data)->where(array('id'=>$resid[$k]['id']))->save();
                            $delid[] = $resid[$k]['id'];
                        }else{
                            $data['product_id'] = $id;
                            $delid[] = M('product_material')->add($data);
                        }
                    }
                }

                $where = array();
                $where['product_id'] = $id;
                if($delid) $where['id'] = array('not in',$delid);
                $del = M('product_material')->where($where)->delete();

            } else {

                //保存
                $info['input_user'] = session('userid');
                $info['input_uname'] = session('nickname');
                $info['input_time']  = time();

                $isadd = M('product')->add($info);
                $this->request_audit(P::REQ_TYPE_PRODUCT_NEW, $isadd);

                //保存物资信息
                foreach($material as $k=>$v){
                    $data = array();
                    $data = $v;
                    $data['product_id'] = $isadd;
                    if($data['material']){
                        M('product_material')->add($data);
                    }
                }

            }

            if ($isadd){
                //保存上传标题图片
                save_res(P::UPLOAD_PIC,$isadd,$pic,1);
                //保存上传附件(原理及实施要求)
                save_res(P::UPLOAD_THEORY,$isadd,$theory,1);
                //保存视频文件
                save_res(P::UPLOAD_VIDEO,$isadd,$video,1);

                $this->success('保存成功！', $referer);
            }else{
                $this->success('保存失败！');
            }
        } else {
            $id                  = I('id');
            $business_dept       = I('business_dept');
            $this->row           = M('product')->find($id);
            $this->business_dept = $business_dept?$business_dept:$this->row['business_dept'];
            if (($business_dept != $this->row['business_dept'] && $this->row['business_dept']) || (!$this->row['business_dept'] && !$business_dept)){
                $this->pro_kind  = 1;
            }

            if($this->row){
                if ($this->row['att_id']) {
                    $theory       = get_res(P::UPLOAD_THEORY,$id);
                    $pic          = get_res(P::UPLOAD_PIC,$id);
                    $video        = get_res(P::UPLOAD_VIDEO,$id);
                    $this->theory = array_column($theory,'id');
                    $this->pic    = array_column($pic,'id');
                    $this->video  = array_column($video,'id');
                } else {
                    $this->theory = false;
                    $this->pic    = false;
                    $this->video  = false;
                }

                $this->material = M('product_material')->where(array('product_id'=>$id))->select();

                $depts = explode(',',$this->row['business_dept']);
                $kinds = M('project_kind')->getField('id,name');
                $deptlist = array();
                foreach($depts as $k=>$v){
                    $deptlist[$k]['id'] = $v;
                    $deptlist[$k]['name'] = $kinds[$v];
                }

                $ages = explode(',',$this->row['age']);
                $ageval = C('AGE_LIST');
                $agelist = array();
                foreach($ages as $k=>$v){
                    $agelist[$k]['id'] = $v;
                    $agelist[$k]['name'] = $ageval[$v];
                }


                $sp = array();
                $sp['id'] = array('IN',$this->row['supplier']);
                $this->supplier = M('cas_res')->where($sp)->select();
                $this->reskind = M('reskind')->getField('id,name', true);
                $this->deptlist = unique_arr($deptlist);
                $this->agelist  = unique_arr($agelist);


            }

            //物料关键字
            $key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
            if($key) $this->keywords =  json_encode($key);

            $this->product_from   = C('PRODUCT_FROM');
            $this->product_type   = C('PRODUCT_TYPE');
            $this->subject_fields = C('SUBJECT_FIELD');
            $this->projects       = M('project')->where(array('status'=>1))->select();
            //$this->kinds          = M('project_kind')->field('id,name')->where(array('pid'=>array('neq',0)))->select();
            $this->kinds          = M('project_kind')->field('id,name')->select();

            $this->display('add');
        }
    }

    // @@@NODE-3###select_ages###模板选择适用年龄###
	public function select_ages(){
    	$this->ages = C('AGE_LIST');
		$this->display('select_ages');
	}

    // @@@NODE-3###select_kinds###模板选择适用项目类型###
	public function select_kinds(){
    	$this->kinds  = get_project_kinds();
		$this->display('select_kinds');
	}



    // @@@NODE-3###tpl###产品模板列表###
    public function tpl () {
    	$key          = I('key');
		$status       = I('status','-1');
		$pro          = I('pro');
		$bus          = I('bus');
		$sub          = I('sub');
		$age          = I('age');

		$db = M('product_model');
		$this->status = $status;
		$where = array();
		if($this->status != '-1') $where['p.audit_status'] = $this->status;
		if($key)    $where['p.title'] = array('like','%'.$key.'%');
		//if($pro)    $where['p.project_id'] = $pro;
		if($bus)    $where['p.business_dept'] = $bus;
		//if($sub)    $where['p.subject_field'] = $sub;
		if($age)    $where['p.age'] = $age;

		$business_depts = M('project_kind')->getField('id,name');
        $page = new Page($db->table('__PRODUCT_MODEL__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages = $page->show();
		$lists = $db->table('__PRODUCT_MODEL__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
		foreach($lists as $k=>$v){

			$lists[$k]['dept'] = $business_depts[$v['business_dept']];
		}

		$this->lists = $lists;

		$this->business_depts = M('project_kind')->getField('id,name');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');

		$this->display('model');
    }

    // @@@NODE-3###deltpl###删除产品模板###
    public function deltpl () {

        $id = I('id', 0);
        if ($id) {
            M('product_model')->where("id=$id")->delete();
        }

        $this->success('删除成功！');
    }

    // @@@NODE-3###addtpl###添加或修改产品模板###
    public function addtpl() {

    	$this->title('产品模板');
		if (isset($_POST['dosubmit'])) {

             $info = I('info');
			 $referer = I('referer');
			 $business_dept = I('business_dept');
			 $age = I('age');
			 $info['content'] = stripslashes($_POST['content']);
			 $info['business_dept'] = implode(',',$business_dept);
			 $info['age'] = implode(',',$age);
             $id = I('id');

             $aids = join(',', I('resfiles'));

             $newname = I('newname', null);

             if ($aids) {
                 $info['att_id'] = $aids;
             } else {
                 $info['att_id'] = '';
             }

			 //修改附件文件名
             $attdb = M('attachment');
             foreach ($newname as $k => $v) {
                 $attdb->where("id=$k")->setField('filename', $v);
             }


            if ($id) {
				//修改
				M('product_model')->where("id=$id")->data($info)->save();
				if ($aids) {
					$attdb->where("id in ($aids)")->setField(array('rel_id'=>$id,'catid'=>2));
				}



				$this->success('修改成功！', $referer);
			} else {

				//保存
				$info['input_user'] = session('userid');
				$info['input_uname'] = session('nickname');
				$info['input_time']  = time();

				$rel_id = M('product_model')->add($info);
				if ($aids) {
					$attdb->where("id in ($aids)")->setField(array('rel_id'=>$rel_id,'catid'=>2));
				}

				$this->request_audit(P::REQ_TYPE_PRODUCT_MODEL, $rel_id);
				$this->success('保存成功！', $referer);
			}
		} else {
            $id = I('id');

			$this->row = M('product_model')->find($id);

			if($this->row){
				if ($this->row['att_id']) {
				$this->atts = M('attachment')->where("catid=2 and id in (" . $this->row['att_id']. ")")->select();
				} else {
				$this->atts = false;
				}

				$depts = explode(',',$this->row['business_dept']);
				$kinds = M('project_kind')->getField('id,name');
				$deptlist = array();
				foreach($depts as $k=>$v){
					$deptlist[$k]['id'] = $v;
					$deptlist[$k]['kind'] = $kinds[$v];
				}

				$ages = explode(',',$this->row['age']);
				$ageval = C('AGE_LIST');
				$agelist = array();
				foreach($ages as $k=>$v){
					$agelist[$k]['id'] = $v;
					$agelist[$k]['age'] = $ageval[$v];
				}

				$this->deptlist = $deptlist;
				$this->agelist  = $agelist;


			}

			$this->subject_fields = C('SUBJECT_FIELD');
			$this->projects       = M('project')->where(array('status'=>1))->select();

			$this->business_depts = M('project_kind')->getField('id,name');
			$this->display('add_model');
		}
    }

    // @@@NODE-3###select_product###建模板时选择产品###
    public function select_product(){

		$key                                    = I('key');
		$status                                 = I('status','-1');
		$pro                                    = I('pro');
		$zj                                     = I('zj');
		$age                                    = I('age');

		$db                                     = M('product');
		$this->status                           = $status;
		$where                                  = array();
		if($this->status != '-1') $where['p.audit_status'] = $this->status;
		if($key)    $where['p.title']           = array('like','%'.$key.'%');
		if($pro)    $where['p.business_dept']   = array('like','%'.$pro.'%');
		if($age)    $where['p.age']             = array('like','%'.$age.'%');
		if($zj)     $where['p.input_uname']     = array('like','%'.$zj.'%');
        //$where['disting']                       = 0;

		$business_depts                         = C('BUSINESS_DEPT');
        $page                                   = new Page($db->table('__PRODUCT__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages                            = $page->show();
		$lists                                  = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
		$kinds                                  = M('project_kind')->getField('id,name');
		foreach($lists as $k=>$v){
			$depts                              = explode(',',$v['business_dept']);
			$deptval                            = array();
			foreach($depts as $kk=>$vv){
				$deptval[]                      = $kinds[$vv];
			}

			$lists[$k]['dept']                  = implode(',',$deptval);
		}
		$this->lists                            = $lists;

		$this->ages                             = C('AGE_LIST');
		$this->kinds                            = $kinds;
    	$this->display('select_product');
    }


	// @@@NODE-3###view###产品模块详情###
    public function view () {
        $this->title('产品模块详情');
        $db                                     = M('product');
        $id                                     = I('id', -1);
		$where                                  = array();
		$where['p.id']                          = $id;
		$row                                    =  $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->find();
        if ($row['standard'] == 1){ $this->standard_product_detail($id); die;}

		if($row){
			$where                              = array();
			$where['req_type']                  = P::REQ_TYPE_PRODUCT_NEW;
			$where['req_id']                    = $id;
			$audit                              = M('audit_log')->where($where)->find();
			if($audit['dst_status']==0){
				$show                           = '未审批';
				$show_user                      = '未审批';
				$show_time                      = '等待审批';
			}else if($audit['dst_status']==1){
				$show                           = '已通过';
				$show_user                      = $audit['audit_uname'];
				$show_time                      = date('Y-m-d H:i:s',$audit['audit_time']);
			}else if($audit['dst_status']==2){
				$show                           = '未通过';
				$show_user                      = $audit['audit_uname'];
				$show_time                      = date('Y-m-d H:i:s',$audit['audit_time']);
			}
			$row['showstatus']                  = $show;
			$row['show_user']                   = $show_user;
			$row['show_time']                   = $show_time;

			$depts                              = explode(',',$row['business_dept']);
			$kinds                              = M('project_kind')->getField('id,name');
			$deptlist                           = array();
			foreach($depts as $k=>$v){
				$deptlist[]                     = $kinds[$v];
			}
			$row['dept']                        = implode('，',$deptlist);

			$ages                               = explode(',',$row['age']);
			$ageval                             = C('AGE_LIST');
			$agelist                            = array();
			foreach($ages as $k=>$v){
				$agelist[]                      = $ageval[$v];
			}
			$row['ages']                        = implode('，',$agelist);

			//获取附件
			if($row['att_id']){
				$atts                           = M('attachment')->where("catid=1 and id in (" . $row['att_id']. ")")->select();
                $this->theory                   = get_res(P::UPLOAD_THEORY,$id);
                $this->pic                      = get_res(P::UPLOAD_PIC,$id);
                $this->theory                   = get_res(P::UPLOAD_VIDEO,$id);
			}else{
				$this->atts                     = false;
			}

            foreach ($atts as $k=>$v){
                if ($v['module']==P::UPLOAD_PIC)    $atts[$k]['type'] = "<span class='green'>图片文件</span>";
                if ($v['module']==P::UPLOAD_THEORY) $atts[$k]['type'] = "<span class='yellow'>原理及实施要求</span>";
                if ($v['module']==P::UPLOAD_VIDEO)  $atts[$k]['type'] = "<span class='red'>视频文件</span>";
            }

            $modules                            = M('product_module')->where(array('product_id'=>$id))->select();
            foreach ($modules as $kk=>$vv){
                $modules[$kk]['implement_furl'] = M('files')->where(array('id'=>$vv['implement_fid']))->getField('file_path');
                $modules[$kk]['res_furl']       = M('files')->where(array('id'=>$vv['res_fid']))->getField('file_path');
            }

            $this->atts                         = $atts;
			$sp                                 = array();
			$sp['id']                           = array('IN',$row['supplier']);
			$this->supplier                     = M('cas_res')->where($sp)->select();
			$this->reskind                      = M('reskind')->getField('id,name', true);

		}else{
			$this->error('产品模块不存在' . $db->getError());
		}


		$this->row                              = $row;
		$this->material                         = M('product_material')->where(array('product_id'=>$id))->select();
        $this->modules                          = $modules;
		$this->business_depts                   = C('BUSINESS_DEPT');
		$this->subject_fields                   = C('SUBJECT_FIELD');
		$this->ages                             = C('AGE_LIST');
        $this->reckon_mode                      = C('RECKON_MODE');
        $this->type                             = C('PRODUCT_TYPE');
        $this->from                             = C('PRODUCT_FROM');

		$this->display('pro_viwe');



    }




	// @@@NODE-3###model_view###产品模板详情###
    public function model_view () {
        $this->title('产品模板详情');
        $db = M('product_model');
        $id = I('id', -1);

		$where = array();
		$where['p.id'] = $id;
		$row =  $db->table('__PRODUCT_MODEL__ as p')->field('p.*')->where($where)->find();

		if($row){
			$where = array();
			$where['req_type'] = P::REQ_TYPE_PRODUCT_MODEL;
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




			$depts = explode(',',$row['business_dept']);
			$kinds = M('project_kind')->getField('id,name');
			$deptlist = array();
			foreach($depts as $k=>$v){
				$deptlist[] = $kinds[$v];
			}
			$row['dept'] = implode('，',$deptlist);

			$ages = explode(',',$row['age']);
			$ageval = C('AGE_LIST');
			$agelist = array();
			foreach($ages as $k=>$v){
				$agelist[] = $ageval[$v];
			}
			$row['ages'] = implode('，',$agelist);

			//获取附件
			if($row['att_id']){
				$this->atts = M('attachment')->where("catid=2 and id in (" . $row['att_id']. ")")->select();
			}else{
				$this->atts = false;
			}


		}else{
			$this->error('产品模板不存在' . $db->getError());
		}

		$this->row = $row;
		$this->material = $material;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');

		$this->display('pro_viwe_model');



    }



	 // @@@NODE-3###delkind###删除线路分类###
    public function delkind(){
        $this->title('删除线路分类');

        $db = M('product_kind');
        $id = I('id', -1);

        $kinds = get_project_kinds();

        $where = "id in ($id";
        $flag = 99;
        for ($i = 0; $i < count($kinds); $i++ ) {
            if ($kinds[$i]['id'] == $id) {
                $flag = $kinds[$i]['level'];
                continue;
            }
            if ($kinds[$i]['level'] > $flag) {
                $where .= ',' . $kinds[$i]['id'];
            } else {
                break;
            }
        }
        $where .= ')';
        $iddel = $db->where($where)->delete();
        $this->success('删除成功！', U('Product/kind'));
    }


    // @@@NODE-3###addkind###添加修改线路分类###
    public function addkind() {
        $this->title('添加/修改线路分类');

        $db = M('product_kind');
        $pid  = I('pid', 0);

        $id = I('id',0);
        if ($pid <= 0) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = '顶级分类';

        } else {
            $father = $db->find($pid);
        }

        $this->father = $father;

        if(isset($_POST['dosubmit'])){

            $info = I('info','');

            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('Product/kind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('Product/kind'));
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
                    $this->error('无此数据！', U('Product/kind'));
                }
            }
            $this->display('addkind');
        }
    }


    // @@@NODE-3###kind###线路分类列表###
    public function kind() {
        $this->title('线路分类列表');

        $this->lists = get_product_kinds();
        $this->pages = '';
        $this->display('kind');
    }




	// @@@NODE-3###line###线路行程###
    public function line(){
        $this->title('项目方案列表');

		$key          = I('key');
		$status       = I('status','-1');
		$kind         = I('kind','-1');
		$mdd          = I('mdd');

		$db = M('product_line');
		$this->status = $status;
		$this->kind   = $kind;
		$where = array();
		if($this->status != '-1') $where['audit_status'] = $this->status;
		if($this->kind != '-1')   $where['kind'] = $this->kind;
		if($key)    $where['title'] = array('like','%'.$key.'%');
		if($mdd)    $where['dest']  = array('like','%'.$mdd.'%');



        $page = new Page($db->where($where)->count(), P::PAGE_SIZE);
        $this->pages = $page->show();
		$this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
		$this->kindlist = M('project_kind')->select();


		$this->display('line');
    }



	// @@@NODE-3###del_line###删除线路###
    public function del_line(){
        $this->title('删除产品');
		$db = M('product_line');
		$id = I('id', -1);
		M('product_line')->delete($id);
		M('product_line_days')->where(array('line_id'=>$id))->delete();
		M('product_line_tpl')->where(array('line_id'=>$id))->delete();
		$this->success('删除成功！');
    }




	// @@@NODE-3###add_line###新增线路###
    public function add_line() {
        $this->title('新增线路');
        $PinYin = new Pinyin();
         if (isset($_POST['dosubmit'])) {
             $info      = I('info');
			 $referer   = I('referer');
             $pro       = I('pro');
			 $pro_model = I('pro_model');
			 $days      = I('days');
             $title     = iconv("utf-8","gb2312",trim($info['title']));
             $info['pinyin'] = strtolower($PinYin->getFirstPY($title));

			 $aids      = join(',', I('resfiles'));
			 $newname   = I('newname', null);
             $cost      = I('cost');  //固定线路价格信息
             $carHotel  = I('carHotel');

             if ($aids) {
                 $info['att_id'] = $aids;
             } else {
                 $info['att_id'] = '';
             }

			 //修改附件文件名
             $attdb = M('attachment');
             foreach ($newname as $k => $v) {
                 $attdb->where("id=$k")->setField('filename', $v);
             }


			 $info['input_user'] = session('userid');
			 $info['input_uname'] = session('nickname');
			 $info['input_time']  = time();
			 $line_id = M('product_line')->add($info);
			 if($line_id){

				 if ($aids) {
					$attdb->where("id in ($aids)")->setField(array('rel_id'=>$line_id,'catid'=>3));
				}

				 $this->request_audit(P::REQ_TYPE_PRODUCT_LINE, $line_id);
				 if($pro){
				     foreach($pro as $v){
					     $data = array();
						 $data['line_id'] = 	$line_id;
						 $data['pro_id']  =  $v;
						 $data['type']    =  1;
						 if(!M('product_line_tpl')->where($data)->find()){
							 M('product_line_tpl')->add($data);
						 }
					 }
			     }
				 if($pro_model){
				     foreach($pro_model as $v){
					     $data = array();
						 $data['line_id'] = 	$line_id;
						 $data['pro_id']  =  $v;
						 $data['type']    =  2;
						 if(!M('product_line_tpl')->where($data)->find()){
							 M('product_line_tpl')->add($data);
						 }
					 }
			     }
				 if($days){
				     foreach($days as $v){
					     $data = array();
						 $data['line_id']  =  $line_id;
						 $data['citys']    =  $v['citys'];
						 $data['content']  =  $v['content'];
						 $data['remarks']  =  $v['remarks'];
						 M('product_line_days')->add($data);
					 }
			     }
			     if($cost){
                     //固定线路价格信息
                     foreach($cost as $v){
                         $data = array();
                         $data['line_id']   = $line_id;
                         $data['pname']     = $v['pname'];
                         $data['price']     = $v['price'];
                         $data['num']       = $v['num'];
                         $data['sum']       = $v['sum'];
                         $data['remark']    = $v['remark'];
                         M('product_line_price')->add($data);
                     }
                 }

                 if($carHotel){
                     foreach($carHotel as $v){
                         $data = array();
                         $data['line_id']   = $line_id;
                         $data['start']     = $v['start'];
                         $data['num']       = $v['num'];
                         $data['price']     = $v['price'];
                         $data['remark']    = $v['remark'];
                         M('product_line_carhotel')->add($data);
                     }
                 }
			 }


             $this->success('保存成功！', $referer);

         } else {

			 //$this->kindlist = M('project_kind')->select();
             $this->line_type= C('LINE_TYPE');
             $this->hotel_start = C('HOTEL_START');
             $this->kindlist = get_project_kinds();
             $this->display('add_line');
         }
    }




	// @@@NODE-3###edit_line###修改线路###
    public function edit_line() {
         $this->title('修改线路');
        $PinYin = new Pinyin();
         if (isset($_POST['dosubmit'])) {
             $info      = I('info');
			 $referer   = I('referer');
             $pro       = I('pro');
			 $pro_model = I('pro_model');
			 $days      = I('days');
			 $line_id   = I('line_id');
             $cost      = I('cost');
             $carHotel  = I('carHotel');
             $title     = iconv("utf-8","gb2312",trim($info['title']));
             $info['pinyin'] = strtolower($PinYin->getFirstPY($title));

             $aids      = join(',', I('resfiles'));
			 $newname   = I('newname', null);

             if ($aids) {
                 $info['att_id'] = $aids;
             } else {
                 $info['att_id'] = '';
             }

			 //修改附件文件名
             $attdb = M('attachment');
             foreach ($newname as $k => $v) {
                 $attdb->where("id=$k")->setField('filename', $v);
             }

			 $isok = M('product_line')->data($info)->where(array('id'=>$line_id))->save();

		     if ($aids) {
				 $attdb->where("id in ($aids)")->setField(array('rel_id'=>$line_id,'catid'=>3));
			 }


			 M('product_line_tpl')->where(array('line_id'=>$line_id,'type'=>1))->delete();
			 if($pro){
				 foreach($pro as $v){
					 $data = array();
					 $data['line_id'] = 	$line_id;
					 $data['pro_id']  =  $v;
					 $data['type']    =  1;
					 M('product_line_tpl')->add($data);
				 }
			 }

			 M('product_line_tpl')->where(array('line_id'=>$line_id,'type'=>2))->delete();
			 if($pro_model){
				 foreach($pro_model as $v){
					 $data = array();
					 $data['line_id'] = 	$line_id;
					 $data['pro_id']  =  $v;
					 $data['type']    =  2;
					 M('product_line_tpl')->add($data);
				 }
			 }

			 M('product_line_days')->where(array('line_id'=>$line_id))->delete();
			 if($days){
				 foreach($days as $v){
					 $data = array();
					 $data['line_id']  =  $line_id;
					 $data['citys']    =  $v['citys'];
					 $data['content']  =  $v['content'];
					 $data['remarks']  =  $v['remarks'];
					 M('product_line_days')->add($data);
				 }
			 }
             M('product_line_price')->where(array('line_id'=>$line_id))->delete();
			 if ($cost){
                 foreach ($cost as $v){
                     $data = array();
                     $data['line_id']   = $line_id;
                     $data['pname']     = $v['pname'];
                     $data['price']     = $v['price'];
                     $data['num']       = $v['num'];
                     $data['sum']       = $v['sum'];
                     $data['remark']    = $v['remark'];
                     M('product_line_price')->add($data);
                 }
             }
             M('product_line_carhotel')->where(array('line_id'=>$line_id))->delete();
             if ($carHotel){
                 foreach ($carHotel as $v){
                     $data = array();
                     $data['line_id']   = $line_id;
                     $data['start']     = $v['start'];
                     $data['num']       = $v['num'];
                     $data['price']     = $v['price'];
                     $data['remark']    = $v['remark'];
                     M('product_line_carhotel')->add($data);
                 }
             }

             $this->success('保存成功！', $referer);

         } else {

			 $id = I('id',0);
			 $this->row =  M('product_line')->find($id);
			 if($this->row){

				if ($this->row['att_id']) {
					$this->atts = M('attachment')->where("catid=3 and id in (" . $this->row['att_id']. ")")->select();
				} else {
					$this->atts = false;
				}

				 $this->pro_list = M()->field('t.*,p.*')->table('__PRODUCT_LINE_TPL__ as t')->join('__PRODUCT__ as p on p.id=t.pro_id')->where(array('t.line_id'=>$id,'t.type'=>1))->select();
				 $this->pro_model_list = M()->field('t.*,p.*')->table('__PRODUCT_LINE_TPL__ as t')->join('__PRODUCT_MODEL__ as p on p.id=t.pro_id')->where(array('t.line_id'=>$id,'t.type'=>2))->select();

				 $this->days_list = M('product_line_days')->where(array('line_id'=>$id))->select();
			 }

			 $this->business_depts = C('BUSINESS_DEPT');
		     $this->subject_fields = C('SUBJECT_FIELD');
		     $this->ages           = C('AGE_LIST');
			 //$this->kindlist = M('product_kind')->select();
			 $this->kindlist       = get_project_kinds();
             $this->line_type      = C('LINE_TYPE');
             $this->cost           = M('product_line_price')->where(array('line_id'=>$id))->select();
             $this->carHotel       = M('product_line_carhotel')->where(array('line_id'=>$id))->select();
             $this->hotel_start    = C('HOTEL_START');
             $this->display('edit_line');
         }
    }



	public function view_line(){
        $this->title('项目方案跟进');
		 $id = I('id',0);
		 $row =  M('product_line')->find($id);
		 if($row){

			 $kind = M('project_kind')->find($row['kind']);
			 $row['kind_name'] = $kind['name'];

			 $this->pro_list = M()->field('t.*,p.*')->table('__PRODUCT_LINE_TPL__ as t')->join('__PRODUCT__ as p on p.id=t.pro_id')->where(array('t.line_id'=>$id,'t.type'=>1))->select();

			 $this->pro_model_list = M()->field('t.*,p.*')->table('__PRODUCT_LINE_TPL__ as t')->join('__PRODUCT_MODEL__ as p on p.id=t.pro_id')->where(array('t.line_id'=>$id,'t.type'=>2))->select();

			 //获取附件
			if($row['att_id']){
				$this->atts = M('attachment')->where("catid=3 and id in (" . $row['att_id']. ")")->select();
			}else{
				$this->atts = false;
			}

			 $this->days_list   = M('product_line_days')->where(array('line_id'=>$id))->select();
             $this->price_list  = M('product_line_price')->where(array('line_id'=>$id))->select();
             $hotel_start       = C('HOTEL_START');
             $carhotel_list     = M('product_line_carhotel')->where(array('line_id'=>$id))->select();
             foreach ($carhotel_list as $key=>$value){
                 foreach ($hotel_start as $k=>$v){
                     if($value['start'] == $k){
                         $carhotel_list[$key]['start_name'] = $v;
                     }
                 }
             }
             $this->count_price = array_sum(array_map(function($val){return $val['sum'];}, $this->price_list));
             $this->count_carhotel = array_sum(array_map(function($val){return $val['price'];}, $carhotel_list));
             $this->carhotel_list  = $carhotel_list;
			 $this->business_depts = C('BUSINESS_DEPT');
		 	 $this->subject_fields = C('SUBJECT_FIELD');
			 $this->ages           = C('AGE_LIST');
			 $this->row = $row;
		 	 $this->display('view_line');

		 }else{
			 $this->error('线路不存在：' . $db->getError());
	     }


	}

    // @@@NODE-3###select_line###选择产品模块###
    public function select_line(){

        $key          = I('key');
        $status       = I('status','-1');
        $kind         = I('kind','-1');
        $mdd          = I('mdd');

        $db           = M('product_line');
        $this->status = $status;
        $this->kind   = $kind;
        $where        = array();
        if($this->status != '-1') $where['audit_status'] = $this->status;
        if($this->kind != '-1')   $where['kind'] = $this->kind;
        if($key)    $where['title'] = array('like','%'.$key.'%');
        if($mdd)    $where['dest']  = array('like','%'.$mdd.'%');

        $pagecount   = $db->where($where)->count();
        $page        = new Page($pagecount,25);
        $this->pages = $pagecount>25 ? $page->show():'';
        $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();
        $this->kindlist = M('project_kind')->select();

        $this->display('select_line');
    }



	// @@@NODE-3###select_tpl###线路选择模板###
	public function select_tpl(){
		/*
		$key  = I('key');

		$where = array();
		//$where['1'] = priv_where(P::REQ_TYPE_SUPPLIER_RES_U);
		if($key)  $where['tpl_name'] = array('like','%'.$key.'%');

		$db = M('product_model');
    	$prdb = M('product');

    	$page = new Page($db->where($where)->count(), P::PAGE_SIZE);
    	$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
    	foreach ($lists as $k => $v) {
    		$lists[$k]['product'] = $prdb->where("id in (". $v['pids'].")")->field('id,title')->select();
    	}
    	$this->lists = $lists;
    	$this->pages = $page->show();
		*/

		$key          = I('key');
		$status       = I('status','-1');
		$bus          = I('bus');

		$db = M('product_model');
		$this->status = $status;
		$where = array();
		if($this->status != '-1') $where['p.audit_status'] = $this->status;
		if($key)    $where['p.title'] = array('like','%'.$key.'%');
		if($bus)    $where['p.business_dept'] = $bus;

		$business_depts = M('project_kind')->getField('id,name');
        $page = new Page($db->table('__PRODUCT_MODEL__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages = $page->show();
		$lists = $db->table('__PRODUCT_MODEL__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
		foreach($lists as $k=>$v){

			$lists[$k]['dept'] = $business_depts[$v['business_dept']];
		}

		$this->lists = $lists;

		$this->business_depts = M('project_kind')->getField('id,name');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
		$this->display('select_tpl');
	}


	// @@@NODE-3###public_info###获取模块信息###
	public function public_info(){
		$pids = I('pids');
		$tpl  = I('tpl');

		$business_depts = C('BUSINESS_DEPT');
		$subject_fields = C('SUBJECT_FIELD');
		$ages           = C('AGE_LIST');

		$list = M('product')->where(array('id'=>array('in',$pids)))->select();
		foreach($list as $row){
			echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$business_depts[$row['business_dept']].'</td><td>'.$subject_fields[$row['subject_field']].'</td><td>'.$ages[$row['age']].'</td><td>'.$row['input_uname'].'</td><td>'.$row['sales_price'].'</td><td>'.$row['peer_price'].'</td><td class="taskOptions"><button onClick="javascript:del_timu(\'tpl_'.$tpl.$row['id'].'\')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td></tr>';
		}


	}


	// @@@NODE-3###add_supplier###关联科普资源###
	public function add_supplier(){
		$key          = I('key');
		$type         = I('type');
		$pro          = I('pro');

		$where = array();
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
        $this->display('res_supplier');
	}

	//标准化产品
    public function standard_product(){
        $this->pageTitle                = '标准化产品';
        $month                          = date('m');
        $pin                            = I('pin',0);
        $year                           = I('year',date('Y'));
        $ltit                           = get_little_title($year,$month);
        $db                             = M('producted');
        $tit                            = trim(I('key'));
        $kind                           = I('kind');
        $app_time                       = get_apply_time($ltit,$pin);
        $apply_year                     = $app_time['ayear'];
        $apply_time                     = $app_time['atime'];

        $where                          = array();
        //if ($apply_year) $where['apply_year'] = $apply_year;
        //if ($apply_time) $where['apply_time'] = $apply_time;
        if ($apply_year) $where['apply_year'] = array('in',array(0,$apply_year));
        if ($apply_time) $where['apply_time'] = array('in',array(0,$apply_time));
        if ($tit) $where['title']       = array('like','%'.$tit.'%');
        if ($kind) $where['business_dept'] = array('like','%'.$kind.'%');

        $count                          = $db->where($where)->count();
        $page                           = new Page($count, P::PAGE_SIZE);
        $this->pages                    = $count > P::PAGE_SIZE ? $page->show() : '';
        $lists                          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
        $kinds                          = M('project_kind')->getField('id,name');

        foreach ($lists as $k=>$v){
            $str                        = array();
            $business_dept              = explode(',',$v['business_dept']);
            foreach ($kinds as $kk=>$vv){
                if (in_array($kk,$business_dept)){
                    $str[]              = $vv;
                }
            }
            $lists[$k]['kinds']         = implode(',',$str);
        }

        $this->lists                    = $lists;
        $this->pfrom                    = C('PRODUCT_FROM');
        $this->kinds                    = $kinds;
        $this->apply                    = C('APPLY_TO');
        $this->subject_fields           = C('SUBJECT_FIELD');
        $this->ayear                    = $apply_year;
        $this->atime                    = $apply_time;

        $this->year                     = $year;
        $this->pin                      = $pin;
        $this->ltitle                   = $ltit;
        $this->title('标准化产品');
        $this->display();
    }

    //新增/编辑标准化产品
    public function add_standard_product(){
        $id                             = I('id');
        $this->title('标准化产品');
        $year                           = date('Y');
        $apply_times                    = get_little_title($year);

        if ($id){
            $this->id                   = $id;
            $list                       = M('producted')->where(array('id'=>$id))->find();
            $this->row                  = $list;
            $atts                       = get_res(0,0,explode(',',$list['att_id']));
            $this->atts                 = $atts;
            $this->apply_time           = $list['apply_year'].'-'.$list['apply_time'];
        }

        //物料关键字
        $key                            =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
        if($key) $this->material_key    =  json_encode($key);
        $standard_ids                   = C('STANDARD_PRODUCT_KIND_IDS');
        $this->kinds                    = get_standard_project_kinds($standard_ids);
        $this->apply_times              = $apply_times;

        $citys_db                       = M('citys');
        $default_province               = $citys_db->where(array('pid'=>0))->getField('id,name',true);
        $default_citys                  = $list['province'] ? $citys_db->where(array('pid'=>$list['province']))->getField('id,name',true) : '';

        $this->product                  = M('producted_module')->where(array('producted_id'=>$id))->select();
        $this->material                 = M('producted_material')->where(array('producted_id'=>$id))->select();
        $this->userkey                  = get_username();
        $this->provinces                = $default_province;
        $this->citys                    = $default_citys;
        //$this->cost_type                = C('COST_TYPE');
        $this->cost_type                = M('supplierkind')->getField('id,name',true);
        $this->title('标准化产品');
        $this->display();
    }

    //标准化模块(详情)
    public function standard_product_detail($id=0){
        $this->title('标准化模块详情');
        $id                             = I('id')?I('id'):$id;
        $db                             = M('product');
        $list                           = $db->find($id);
        $module_lists                   = M('product_module')->where(array('product_id'=>$id))->select(); //模块内容
        $material_lists                 = M('product_material')->where(array('product_id'=>$id))->select(); // 模块成本核算
        $audit_data                     = $list['audit_status'] != '-1' ? M('audit_log')->where(array('req_id'=>$id,'req_type'=>P::REQ_TYPE_PRODUCT_NEW))->find() : '';
        $project_kinds                  = get_project_kinds();
        $age_lists                      = C('AGE_LIST');
        $business_depts                 = explode(',',$list['business_dept']);
        $ages                           = explode(',',$list['age']);
        $dept_data                      = array();
        $age_data                       = array();
        foreach ($project_kinds as $k=>$v){
            if (in_array($v['id'],$business_depts)){
                $dept_data[]            = $v['name'];
            }
        }
        foreach ($age_lists as $ak=>$av){
            if (in_array($ak,$ages)){
                $age_data[]             = $av;
            }
        }
        foreach ($module_lists as $k=>$v){
            $resFileIds                 = explode(',',$v['res_fid']);
            $resFiles                   = M('files')->where(array('id'=>array('in',$resFileIds)))->select();
            $module_lists[$k]['resFiles']= $resFiles;
        }
        $list['dept']                   = implode(',',$dept_data);
        $list['ages']                   = implode(',',$age_data);
        $list['audit_uname']            = !in_array($list['audit_status'],array('-1',0)) ? $audit_data['audit_uname'] :'<font color="#999">暂未审核</font>';
        $list['audit_time']             = !in_array($list['audit_status'],array('-1',0)) ? date('Y-m-d H:i',$audit_data['audit_time']) :'<font color="#999">暂未审核</font>';
        $audit_status                   = array(
            '-1'                        => "<span class='yellow'>未提交审核</span>",
            '0'                         => "<span class=''>待审核</span>",
            '1'                         => "<span class='green'>审核通过</span>",
            '2'                         => "<span class='red'>审核不通过</span>"
        );
        $atts                           = get_res(0,0,explode(',',$list['att_id']));
        $this->files                    = M('files')->getField('id,file_path',true);
        $this->atts                     = $atts;
        $this->row                      = $list;
        $this->module_lists             = $module_lists;
        $this->material_lists           = $material_lists;
        $this->reckon_mode              = C('RECKON_MODE'); //核算方式
        $this->subject_fields           = C('SUBJECT_FIELD'); //科学领域
        $this->audit_status             = $audit_status;
        //$this->cost_type                = C('COST_TYPE');
        $this->cost_type                = M('supplierkind')->getField('id,name',true);
        $this->display('standard_product_detail');
    }

    //标准化产品(详情)
    public function standard_producted_detail($id=0){
        $this->title('标准化产品详情');
        $id                             = I('id')?I('id'):$id;
        $db                             = M('producted');
        $list                           = $db->find($id);
        $module_lists                   = M('producted_module')->where(array('producted_id'=>$id))->select(); //模块内容
        $material_lists                 = M('producted_material')->where(array('producted_id'=>$id))->select(); // 模块成本核算
        $audit_data                     = $list['audit_status'] != '-1' ? M('audit_log')->where(array('req_id'=>$id,'req_type'=>P::REQ_TYPE_PRODUCT_NEW))->find() : '';
        $project_kinds                  = get_project_kinds();
        $business_depts                 = explode(',',$list['business_dept']);
        $dept_data                      = array();
        $age_data                       = array();
        foreach ($project_kinds as $k=>$v){
            if (in_array($v['id'],$business_depts)){
                $dept_data[]            = $v['name'];
            }
        }
        $list['dept']                   = implode(',',$dept_data);
        $list['ages']                   = implode(',',$age_data);
        $list['audit_uname']            = !in_array($list['audit_status'],array('-1',0)) ? $audit_data['audit_uname'] :'<font color="#999">暂未审核</font>';
        $list['audit_time']             = !in_array($list['audit_status'],array('-1',0)) ? date('Y-m-d H:i',$audit_data['audit_time']) :'<font color="#999">暂未审核</font>';
        $audit_status                   = array(
            '-1'                        => "<span class='yellow'>未提交审核</span>",
            '0'                         => "<span class=''>待审核</span>",
            '1'                         => "<span class='green'>审核通过</span>",
            '2'                         => "<span class='red'>审核不通过</span>"
        );
        $atts                           = get_res(0,0,explode(',',$list['att_id']));
        $this->files                    = M('files')->getField('id,file_path',true);
        $this->atts                     = $atts;
        $this->row                      = $list;
        $this->module_lists             = $module_lists;
        $this->material_lists           = $material_lists;
        $this->reckon_mode              = C('RECKON_MODE'); //核算方式
        $this->audit_status             = $audit_status;
        $this->display('standard_producted_detail');
    }

    //选择科普资源(弹框)
    public function public_select_res(){
        $db                             = M('cas_res');
        $title                          = trim(I('tit'));
        $content                        = trim(I('content'));
        $where                          = array();
        $where['audit_status']          = 1;
        if ($title) $where['title']     = array('like','%'.$title.'%');
        if ($content) $where['content'] = array('like','%'.$content.'%');
        $pageCount                      = $db->where($where)->count();
        $page                           = new page($pageCount,P::PAGE_SIZE);
        $this->pages                    = $pageCount > P::PAGE_SIZE ? $page->show() : '';
        $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('id'))->select();
        $this->lists                    = $lists;
        $this->in_cas                   = array(
            0                           => '院外',
            1                           => '院内',
        );
        $this->display('select_res');
    }

    //标准化模块
    public function standard_module(){
        $this->pageTitle                        = '标准化管理';
        $this->title('标准化模块');

        $key                                    = I('key');
        $fields                                 = I('subject_field');
        $age                                    = I('age');

        $db                                     = M('product');
        $where                                  = array();
        $where['standard']                      = 1; //标准化
        if($key)    $where['p.title']           = array('like','%'.$key.'%');
        if($age)    $where['p.age']             = array('like','%'.$age.'%');
        if($fields) $where['p.subject_field']   = array('eq',$fields);
        //$where['p.disting']                     = 0; //0=>老数据, 1=>新数据

        $pageCount                              = $db->table('__PRODUCT__ as p')->where($where)->count();
        $page                                   = new Page($pageCount, P::PAGE_SIZE);
        $this->pages                            = $pageCount > P::PAGE_SIZE ? $page->show():'';
        $lists                                  = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
        $kinds                                  = M('project_kind')->getField('id,name');
        $ages                                   = C('AGE_LIST');
        foreach($lists as $k=>$v){
            $depts                              = explode(',',$v['business_dept']);
            $deptval                            = array();
            foreach($depts as $kk=>$vv){
                $deptval[]                      = $kinds[$vv];
            }
            $age                                = explode(',',$v['age']);
            $in_ages                            = array();
            foreach($age as $kk=>$vv){
                $in_ages[]                      = $ages[$vv];
            }
            $lists[$k]['dept']                  = implode(',',$deptval);
            $lists[$k]['in_ages']               = implode(',',$in_ages);
            $time_length_lists                  = M('product_module')->where(array('product_id'=>$v['id']))->getField('length',true);
            $lists[$k]['time_length']           = array_sum($time_length_lists);
        }

        $this->lists                            = $lists;
        $this->kinds                            = $kinds;
        $this->ages                             = C('AGE_LIST');
        $this->subject_fields                   = C('SUBJECT_FIELD');
        $this->display();
    }


    public function add_standard_module(){
        $this->title('标准化模块');
        $id                             = I('id');
        $business_dept                  = I('business_dept');
        $this->row                      = M('product')->find($id);
        $this->business_dept            = $business_dept?$business_dept:$this->row['business_dept'];
        if (($business_dept != $this->row['business_dept'] && $this->row['business_dept']) || (!$this->row['business_dept'] && !$business_dept)){
            $this->pro_kind             = 1;
        }

        if($this->row){
            if ($this->row['att_id']) {
                $theory                 = get_res(P::UPLOAD_THEORY,$id);
                $pic                    = get_res(P::UPLOAD_PIC,$id);
                $video                  = get_res(P::UPLOAD_VIDEO,$id);
                $this->theory           = array_column($theory,'id');
                $this->pic              = array_column($pic,'id');
                $this->video            = array_column($video,'id');
            } else {
                $this->theory           = false;
                $this->pic              = false;
                $this->video            = false;
            }

            $this->material             = M('product_material')->where(array('product_id'=>$id))->select();
            $this->modules              = M('product_module')->where(array('product_id'=>$id))->select();
            $depts                      = explode(',',$this->row['business_dept']);
            $kinds                      = M('project_kind')->getField('id,name');
            $deptlist                   = array();
            foreach($depts as $k=>$v){
                $deptlist[$k]['id']     = $v;
                $deptlist[$k]['name']   = $kinds[$v];
            }

            $ages                       = explode(',',$this->row['age']);
            $ageval                     = C('AGE_LIST');
            $agelist                    = array();
            foreach($ages as $k=>$v){
                $agelist[$k]['id']      = $v;
                $agelist[$k]['name']    = $ageval[$v];
            }

            $sp = array();
            $sp['id']                   = array('IN',$this->row['supplier']);
            $this->supplier             = M('cas_res')->where($sp)->select();
            $this->reskind              = M('reskind')->getField('id,name', true);
            $this->deptlist             = unique_arr($deptlist);
            $this->agelist              = unique_arr($agelist);
        }

        //物料关键字
        $key                            =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
        if($key) $this->material_key    =  json_encode($key);
        $standard_ids                   = C('STANDARD_PRODUCT_KIND_IDS');
        $this->kinds                    = get_standard_project_kinds($standard_ids);
        $this->userkey                  = get_username();
        $this->product_from             = C('PRODUCT_FROM');
        $this->product_type             = C('PRODUCT_TYPE');
        $this->subject_fields           = C('SUBJECT_FIELD');
        //$this->cost_type                = C('COST_TYPE');
        $this->cost_type                = M('supplierkind')->getField('id,name',true);
        $this->projects                 = M('project')->where(array('status'=>1))->select();
        $this->display();
    }

    //选择产品模块(单选)
    public function select_product_module(){
        $opid                                       = I('opid');
        $key                                        = I('key');
        $type                                       = I('type');
        $subject_field                              = I('subject_field');
        $from                                       = I('from');
        $kind                                       = M('op')->where(array('op_id'=>$opid))->getField('kind');

        $db                                         = M('product');
        $this->opid                                 = $opid;
        $where                                      = array();
        $where['audit_status']                      = 1;
        $where['standard']                          = 2; //非标准化
        if($kind)   $where['business_dept']         = $kind;
        if($key)    $where['title']                 = array('like','%'.$key.'%');
        if ($type)  $where['type']                  = array('eq',$type);
        if ($from)  $where['from']                  = array('eq',$type);
        if ($subject_field)  $where['subject_field']= array('eq',$subject_field);

        $pagecount                                  = $db->where($where)->count();
        $page                                       = new Page($pagecount,25);
        $this->pages                                = $pagecount>25 ? $page->show():'';
        $lists                                      = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();

        $ageval                                     = C('AGE_LIST');
        $reckon_mode                                = C('RECKON_MODE');
        foreach ($lists as $k=>$v){
            $agelist                                = array();
            $ages                                   = explode(',',$v['age']);

            foreach($ageval as $key=>$value){
                if (in_array($key,$ages)){
                    $agelist[]                      = $value;
                }
            }
            $lists[$k]['agelist']                   = implode(',',$agelist);
            $lists[$k]['reckon_modelist']           = $reckon_mode[$v['reckon_mode']]?$reckon_mode[$v['reckon_mode']]:"<span class='red'>未定</span>";
            if (!$v['sales_price']) $lists[$k]['sales_price'] = '0.00';
        }

        $this->lists                                = $lists;
        $this->product_type                         = C('PRODUCT_TYPE');
        $this->subject_fields                       = C('SUBJECT_FIELD');
        $this->product_from                         = C('PRODUCT_FROM');
        $this->ages                                 = C('AGE_LIST');
        $this->kindlist                             = M('project_kind')->select();

        $this->display('select_product_module');
    }

    //选择文件(单选)
    public function public_select_implement_file(){
        $db                                         = M('files');
        $pid                                        = I('pid',0); //304=>业务规范 304=>产品资料
        $key                                        = trim(I('key'));
        $uname                                      = trim(I('uname'));
        $where                                      = array();
        $where['pid']                               = $pid;
        if ($key) $where['file_name']               = array('like','%'.$key.'%');
        if ($uname) $where['est_user']              = $uname;
        $lists                                      = $db->where($where)->select();

        $this->lists                                = $lists;
        $this->pid                                  = $pid;
        $this->display('select_implement_file');
    }

    //选择文件(多选)
    public function public_select_implement_file_checkBox(){
        $db                                         = M('files');
        $pid                                        = I('pid',0); //304=>业务规范 304=>产品资料
        $key                                        = trim(I('key'));
        $uname                                      = trim(I('uname'));
        $where                                      = array();
        $where['pid']                               = $pid;
        if ($key) $where['file_name']               = array('like','%'.$key.'%');
        if ($uname) $where['est_user']              = $uname;
        $lists                                      = $db->where($where)->select();

        $this->lists                                = $lists;
        $this->pid                                  = $pid;
        $this->display('select_implement_file_checkBox');
    }

    //选择科普资源(弹框)
    public function public_select_supplierRes(){
        $db                                 = M('supplier');
        $name                               = trim(I('name'));
        $city                               = trim(I('city'));
        //$costType                           = I('costType',0);
        //$kind                               = I('kind') ? I('kind') : get_supplierkind($costType);
        $kind                               = I('kind',0);

        if ($kind ==6){ //研究所台站不从合格供方取值 , 从资源库取值 cas_res
            $where                          = array();
            $where['audit_status']          = 1;
            if ($name) $where['title']      = array('like','%'.$name.'%');
            if ($city) $where['_string']    = "(diqu like '%$city%') or (address like '%$city%')";
            $pageCount                      = M('cas_res')->where($where)->count();
            $page                           = new page($pageCount,P::PAGE_SIZE);
            $this->pages                    = $pageCount > P::PAGE_SIZE ? $page->show() : '';
            $field                          = 'id,title as name, diqu as prov,address as city';
            $lists                          = M('cas_res')->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('id'))->field($field)->select();
            foreach ($lists as $k=>$v){     $lists[$k]['kind'] = 6; } //研究所台站
            $add_res_url                    = U('ScienceRes/addres');
        }else{
            $where                          = array();
            $where['audit_status']          = 1;
            if ($name) $where['name']       = array('like','%'.$name.'%');
            if ($city) $where['_string']    = "(prov like '%$city%') or (city like '%$city%')";
            if ($kind) $where['kind']       = $kind;
            $pageCount                      = $db->where($where)->count();
            $page                           = new page($pageCount,P::PAGE_SIZE);
            $this->pages                    = $pageCount > P::PAGE_SIZE ? $page->show() : '';
            $lists                          = $db->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('id'))->select();
            $add_res_url                    = U('SupplierRes/addres');
        }
        $this->add_res_url                  = $add_res_url;
        $this->lists                        = $lists;
        $this->supplierkind                 = M('supplierkind')->getField('id,name',true);
        $this->kind                         = $kind;
        $this->display('select_supplierRes');
    }

    //选择标准化模块
    public function public_select_standard_module(){
        $db                                         = M('product');
        $key                                        = trim(I('key',''));
        $subject_field                              = I('subject_field');
        $projectKind                                = I('projectKind');
        $where                                      = array();
        $where['audit_status']                      = P::AUDIT_STATUS_PASS;
        $where['standard']                          = 1; //标准化
        if($key)            $where['title']         = array('like','%'.$key.'%');
        if ($subject_field) $where['subject_field'] = array('eq',$subject_field);
        if ($projectKind)   $where['business_dept'] = array('like','%'.$projectKind.'%');
        $pagecount                                  = $db->where($where)->count();
        $page                                       = new Page($pagecount,25);
        $this->pages                                = $pagecount>25 ? $page->show():'';
        $lists                                      = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('input_time'))->select();

        $ageval                                     = C('AGE_LIST');
        foreach ($lists as $k=>$v){
            $agelist                                = array();
            $ages                                   = explode(',',$v['age']);
            foreach($ageval as $key=>$value){
                if (in_array($key,$ages)){
                    $agelist[]                      = $value;
                }
            }
            $lists[$k]['agelist']                   = implode(',',$agelist);
        }
        $this->lists                                = $lists;
        $this->projectKind                          = $projectKind;
        $this->subject_fields                       = C('SUBJECT_FIELD');
        $this->kindlist                             = M('project_kind')->select();
        $this->display('select_standard_module');
    }

    //删除标准化产品
    public function del_prodected(){
        $id                                         = I('id');
        if (!$id){ $this->error('删除数据失败'); }
        M('producted')->where(array('id'=>$id))->delete();
        M('producted_material')->where(array('producted_id'=>$id))->delete();
        M('producted_module')->where(array('producted_id'=>$id))->delete();
        $this->success('删除成功');
    }

    //标准化产品使用率
    public function public_product_chart(){
        $this->title('标准化产品使用统计');
        $year                                       = I('year',date("Y"));
        $month                                      = date('m');
        $quarter                                    = I('quarter',get_quarter($month));
        $standard_kind_ids                          = C('STANDARD_PRODUCT_KIND_IDS');
        $data                                       = get_standard_product_use_avg($year,$quarter,$standard_kind_ids);
        $sum_data                                   = get_standard_product_use_sum_avg($data);

        $this->lists                                = $data;
        $this->sum                                  = $sum_data;
        $this->year                                 = $year;
        $this->quarter                              = $quarter;
        $this->prveyear                             = $year-1;
        $this->nextyear                             = $year+1;
        $this->display('product_chart');
    }

    //标准化产品使用率详情
    public function public_product_chart_detail(){
        $this->title('标准化使用率详情');
        $this->pageTitle                            = '产品标准化';
        $year                                       = I('year');
        $quarter                                    = I('quarter');
        $kind_id                                    = I('kid',0);
        $quarter_cycle                              = get_quarter_cycle_time($year,$quarter);
        $data                                       = get_standard_settlement_data($kind_id,$quarter_cycle['begin_time'],$quarter_cycle['end_time']);
        $lists                                      = $data['sum_lists'];

        $this->lists                                = $lists;
        $this->kinds                                = M('project_kind')->getField('id,name' , true);
        $this->display('product_chart_detail');
    }

    //门户页面
    public function public_view(){
        $type                       = P::FILE_DOWNLOAD_YWJCP_PPT; //业务季产品培训PPT下载
        $customer_files             = get_download_files($type);


        $this->customer_files       = $customer_files;

        $this->display();
    }

    //产品方案需求
    public function public_pro_need(){
        $this->title('产品方案需求');
        //$db                             = M('product_pro_need');
        $db                             = M('op');
        $title                          = trim(I('title'));
        $where                          = array();
        $where['id']                    = array('gt',3604);
        if ($title) $where['project']   = array('like','%'.$title.'%');
        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

        $this->lists                    = $lists;
        $this->kinds                    = M('project_kind')->getField('id,name',true);
        $this->provinces                = M('provinces')->getField('id,name',true);
        //$this->status                   = get_submit_audit_status();
        $this->op_process               = C('OP_PROCESS'); //方案进程
        $this->departments              = M('salary_department')->getField('id,department',true);
        $this->display('pro_need');
    }

    public function public_pro_need_add(){
        $this->title('产品方案需求');
        $PinYin                         = new Pinyin();
        $id                             = I('id');
        if ($id){
            $db                         = M('op');
            $list                       = $db -> find($id);
            $this->list                 = $list;
            $detail_db                  = $this->get_product_pro_need_tetail_db($list['kind']);
            $detail                     = $detail_db ? $detail_db->where(array('product_pro_need_id'=>$id))->find() : '';
            $this->detail               = $detail;
            $this->yard_arr             = $detail['yard'] ? explode(',',$detail['yard']) : '';
            $this->detail_expert_level  = $detail['expert_level'] ? explode(',',$detail['expert_level']) : '';
            $this->selfOpNeeds          = $detail['selfOpNeed'] ? explode(',',$detail['selfOpNeed']) : '';
            $this->addOpNeeds           = $detail['addOpNeed'] ? explode(',',$detail['addOpNeed']) : '';
            $this->yards                = $detail['yard'] ? explode(',',$detail['yard']) : '';
        }

        $this->provinces                = M('provinces')->getField('id,name',true);
        $geclist                        = get_customerlist(1,$PinYin); //客户名称关键字
        $this->geclist                  = $geclist;
        $this->geclist_str              = json_encode($geclist,true);
        $this->kinds                    = get_project_kinds();
        $this->apply_to                 = C('APPLY_TO');
        $this->dijie_data               = get_dijie_department_data();
        $this->teacher_level            = C('TEACHER_LEVEL'); //教师级别
        $this->expert_level             = C('EXPERT_LEVEL'); //专家级别
        $this->producted_list           = $list['producted_id'] ? M('producted')->find($list['producted_id']) : ''; //标准化产品
        $this->departments              =  M('salary_department')->getField('id,department',true);
        $this->display('pro_need_add');
    }

    //详情页 / 审核页
    public function public_pro_need_detail(){
        $this->title('产品方案需求');
        $id                             = I('id');
        if (!$id) $this->error('获取数据失败');
        //$need_db                        = M('product_pro_need');
        $need_db                        = M('op');
        $list                           = $need_db -> find($id);
        $detail_db                      = $this->get_product_pro_need_tetail_db($list['kind']);
        $detail                         = $detail_db ? $detail_db->where(array('product_pro_need_id'=>$id))->find() : '';

        $this->list                     = $list;
        $this->detail                   = $detail;
        $this->provinces                = M('provinces')->getField('id,name',true);
        $this->kinds                    = M('project_kind')->getField('id,name',true);
        $this->departments              =  M('salary_department')->getField('id,department',true);
        $this->apply_to                 = C('APPLY_TO');
        $this->status                   = get_submit_audit_status();
        $this->producted_list           = $list['producted_id'] ? M('producted')->find($list['producted_id']) : ''; //标准化产品
        $this->selfOpNeeds              = $detail['selfOpNeed'] ? explode(',',$detail['selfOpNeed']) : '';
        $this->addOpNeeds               = $detail['addOpNeed'] ? explode(',',$detail['addOpNeed']) : '';
        $this->yards                    = $detail['yard'] ? explode(',',$detail['yard']) : '';
        $this->op_process               = C('OP_PROCESS'); //方案进程
        $this->display('pro_need_detail');
    }

    //获取详细信息数据表
    private function get_product_pro_need_tetail_db($kind){
        switch ($kind){
            case 60: //60=>科学课程
                $db         = M('product_pro_need_kxkc');
                break;
            case 82: //82=> 科学博物园
                $db         = M('product_pro_need_kxbwy');
                break;
            case 54: //54=> 研学旅行
                $db         = M('product_pro_need_yxlx');
                break;
            case 90: //90=> 背景提升
                $db         = M('product_pro_need_bjts');
                break;
            case 67: //67=> 实验室建设
                $db         = M('product_pro_need_sysjs');
                break;
            case 69: //69=> 科学快车 product_pro_need_xykjj
                $db         = M('product_pro_need_bus');
                break;
            case 56: //56=> 科学快车
                $db         = M('product_pro_need_xykjj');
                break;
            case 61: //61=> 科学快车
                $db         = M('product_pro_need_xkt');
                break;
            case 87: //87=> 单进院所
                $db         = M('product_pro_need_djys');
                break;
            case 64: //64=>专场讲座
                $db         = M('product_pro_need_zcjz');
                break;
            case 57: //57=>综合实践
                $db         = M('product_pro_need_zhsj');
                break;
            case 65: //65=>教师培训
                $db         = M('product_pro_need_jspx');
                break;
            default:
                $db         = '';
        }
        return $db;
    }

    public function del_pro_need(){
        $id                             = I('id');
        if (!$id){ $this->error('获取数据错误'); }
        $num                            = 0;
        $db                             = M('product_pro_need');
        $kind                           = $db->where(array('id'=>$id))->getField('kind');
        $detail_db                      = $this->get_product_pro_need_tetail_db($kind);
        $res1                           = $db->where(array('id'=>$id))->delete();
        $res2                           = $detail_db ? $detail_db->where(array('product_pro_need_id'=>$id))->delete() : '';
        if ($res1) $num++;
        if ($res2) $num++;
        $num > 0 ? $this->success('删除成功') : $this->error('删除失败');
    }

    //产品实施方案  scheme
    public function public_scheme(){
        $this->title('产品实施方案');
        $title                          = I('tit');
        $db                             = M('op_scheme');
        $where                          = array();
        if ($title) $where['project']   = array('like','%'.$title.'%');
        $pagecount                      = $db->where($where)->count();
        $page                           = new Page($pagecount,P::PAGE_SIZE);
        $this->pages                    = $pagecount>P::PAGE_SIZE ? $page->show():'';
        $lists                          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

        $this->lists                    = $lists;
        $this->audit_status             = get_submit_audit_status();
        $this->display('scheme');
    }

    //添加实施方案
    public function add_scheme(){
        $this->title('产品实施方案');
        $db                                 = M('op_scheme');
        if (isset($_POST['dosubmit'])){
            $id                             = I('id');
            $op_id                          = I('op_id');
            $new_model                      = I('new_model');
            $pro                            = I('pro'); //产品模块
            $pro_model                      = I('pro_model'); //产品模板
            $line                           = I('line'); //参考产品实施方案  线路
            //$newname                        = I('newname'); //上传文件信息
            $resfiles                       = I('resfiles'); //文件ID
            if (!$op_id){ $this->error('项目名称不能为空'); }
            $oplist                         = M('op')->where(array('op_id'=>$op_id))->find();
            $data                           = array();
            $data['project']                = $oplist['project'];
            $data['group_id']               = $oplist['group_id'];
            $data['op_id']                  = $op_id;
            $data['new_model']              = $new_model;
            $data['audit_user_id']          = $oplist['create_user'];
            $data['audit_user_name']        = $oplist['create_user_name'];
            $data['pro_ids']                = $pro ? implode(',',$pro) : '';
            $data['pro_model_ids']          = $pro_model ? implode(',',$pro_model) : '';
            $data['line_ids']               = $line ? implode(',',$line) : '';
            $data['atta_ids']               = $resfiles ? implode(',',$resfiles) : '';
            if($id){
                $res                        = $db->where(array('id'=>$id))->save($data);
                $record_msg                 = '编辑产品实施方案';
            }else{
                $data['create_user_id']     = cookie('userid');
                $data['create_user_name']   = cookie('nickname');
                $data['create_time']        = NOW_TIME;
                $res                        = $db->add($data);
                $record_msg                 = '新增产品实施方案';
            }
            if ($res){
                $record                     = array();
                $record['op_id']            = $op_id;
                $record['optype']           = 1;
                $record['explain']          = $record_msg;
                op_record($record);
                $this->success('数据保存成功');
            }else{
                $this->error('数据保存失败');
            }
        }else{
            $id                             = I('id');
            if ($id){
                $oplist                     = M()->table('__OP__ as o')->join('__OP_SCHEME__ as s on s.op_id = o.op_id','left')->where(array('s.id'=>$id))->field('s.id as scheme_id, s.pro_ids, s.pro_model_ids, s.line_ids, s.audit_status as scheme_audit_status, s.atta_ids, s.new_model, o.*')->find();
                $apply_to                   = C('APPLY_TO');
                $oplist['apply_to']         = $apply_to[$oplist['apply_to']];
                $departments                = M('salary_department')->getField('id,department',true);
                $oplist['dijie_department'] = $departments[$oplist['dijie_department_id']];
                $kinds                      = M('project_kind')->getField('id,name',true);
                $oplist['kind']             = $kinds[$oplist['kind']];
                $this->oplist               = $oplist;
                $pro_ids                    = $oplist['pro_ids'] ? explode(',',$oplist['pro_ids']) : '';
                $pro_model_ids              = $oplist['pro_model_ids'] ? explode(',',$oplist['pro_model_ids']) : '';
                $line_ids                   = $oplist['line_ids'] ? explode(',',$oplist['line_ids']) : '';
                $atta_ids                   = $oplist['atta_ids'] ? explode(',',$oplist['atta_ids']) : '';
                if ($pro_ids) $this->pro_lists              = M('product')->where(array('id'=>array('in',$pro_ids)))->select();
                if ($pro_model_ids) $this->pro_model_lists  = M('product_model')->where(array('id'=>array('in',$pro_model_ids)))->select();
                if ($line_ids) $this->line_lists            = M('product_line')->where(array('id'=>array('in',$line_ids)))->select();
                if ($atta_ids) $this->atta_lists            = M('attachment')->where(array('id'=>array('in',$atta_ids)))->select();
            }
            $where                          = array();
            $where['id']                    = array('gt',3604);
            $projects                       = M('op')->where($where)->order($this->orders('id'))->limit(100)->getField('op_id,project',true);
            $this->projects                 = $projects;
            $this->display();
        }
    }

    public function public_view_scheme(){
        $id                                 = I('id');
        if (!$id){ $this->error('获取数据错误'); }
        $list                               = M()->table('__OP__ as o')->join('__OP_SCHEME__ as s on s.op_id = o.op_id','left')->where(array('s.id'=>$id))->field('s.id as scheme_id, s.pro_ids, s.pro_model_ids, s.line_ids, s.audit_status as scheme_audit_status, s.atta_ids , s.audit_user_id as scheme_audit_user_id, s.new_model, o.*')->find();
        $apply_to                           = C('APPLY_TO');
        $list['apply_to']                   = $apply_to[$list['apply_to']];
        $departments                        = M('salary_department')->getField('id,department',true);
        $list['dijie_department']           = $departments[$list['dijie_department_id']];
        $kinds                              = M('project_kind')->getField('id,name',true);
        $list['kind']                       = $kinds[$list['kind']];
        $this->list                         = $list;
        $pro_ids                            = $list['pro_ids'] ? explode(',',$list['pro_ids']) : '';
        $pro_model_ids                      = $list['pro_model_ids'] ? explode(',',$list['pro_model_ids']) : '';
        $line_ids                           = $list['line_ids'] ? explode(',',$list['line_ids']) : '';
        $atta_ids                           = $list['atta_ids'] ? explode(',',$list['atta_ids']) : '';
        if ($pro_ids) $this->pro_lists              = M('product')->where(array('id'=>array('in',$pro_ids)))->select();
        if ($pro_model_ids) $this->pro_model_lists  = M('product_model')->where(array('id'=>array('in',$pro_model_ids)))->select();
        if ($line_ids) $this->line_lists            = M('product_line')->where(array('id'=>array('in',$line_ids)))->select();
        if ($atta_ids) $this->atta_lists            = M('attachment')->where(array('id'=>array('in',$atta_ids)))->select();

        $this->audit_status                 = get_submit_audit_status();
        $this->display('view_scheme');
    }

    public function public_save(){
        $savetype                                   = I('savetype');
        $num                                        = 0;
        if (isset($_POST['dosubmit']) && $savetype){
            //保存标准化产品
            if ($savetype == 1){
                $db                                     = M('producted');
                $producted_module_db                    = M('producted_module');
                $producted_material_db                  = M('producted_material');
                $info                                   = I('info');
                $product                                = I('product');
                $material                               = I('material');
                $respid                                 = I('respid');
                $resmid                                 = I('resmid');
                $newname                                = I('newname');
                $resfiles                               = I('resfiles');
                $id                                     = I('id') ? I('id') : 0;
                $apply_time                             = I('apply_time') ? I('apply_time') :0;
                $business_dept                          = I('business_dept');
                $content                                = trim(I('content'));
                $info['apply_year']                     = strlen($apply_time) > 4 ? substr($apply_time,0,4) : 0;
                $info['apply_time']                     = strlen($apply_time) > 4 ? substr($apply_time,-1) : 0;
                $info['business_dept']                  = $business_dept;
                $info['content']                        = $content;
                $info['att_id']                         = $resfiles ? implode(',',$resfiles) : '';

                if ($id){
                    $producted_id                       = $id;
                    $res                                = $db->where(array('id'=>$id))->save($info);
                    if ($res) $num++;
                    $delpid                             = array();
                    foreach ($product as $k=>$v){ //修改产品内容
                        $data                           = array();
                        $data['date']                   = trim($v['date']);
                        $data['title']                  = trim($v['title']);
                        $data['content']                = trim($v['content']);
                        $data['module_id']              = $v['module_id'] ? $v['module_id'] : 0 ;
                        $data['module']                 = trim($v['module']);
                        $data['remark']                 = trim($v['remark']);
                        if ($data['title']){
                            if ($respid && $respid[$k]['id']){
                                $res                    = $producted_module_db->where(array('id'=>$respid[$k]['id']))->save($data);
                                $delpid[]               = $respid[$k]['id'];
                                if ($res) $num++;
                            }else{
                                $data['producted_id']   = $id;
                                $res                    = $producted_module_db->add($data);
                                $delpid[]               = $res;
                                if ($res) $num++;
                            }
                        }
                    }
                    $where                              = array();
                    $where['id']                        = array('not in',$delpid);
                    $where['producted_id']              = $id;
                    $res                                = $producted_module_db->where($where)->delete();
                    if ($res) $num++;
                    $delmid                             = array();
                    foreach ($material as $mk=>$mv){ //修改成本核算
                        $data                           = array();
                        $data['material_id']            = $mv['material_id'] ? $mv['material_id'] : 0;
                        $data['material']               = trim($mv['material']);
                        $data['spec']                   = trim($mv['spec']); //规格
                        $data['unitprice']              = $mv['unitprice'];
                        $data['amount']                 = $mv['amount'];
                        $data['total']                  = $mv['total'];
                        $data['type']                   = $mv['type'];
                        $data['supplierRes_id']         = $mv['supplierRes_id'] ? $mv['supplierRes_id'] : 0;
                        $data['channel']                = $mv['channel'];
                        $data['remark']                 = $mv['remark'];
                        if ($data['material']){
                            if ($resmid && $resmid[$mk]['id']){
                                $res                    = $producted_material_db->where(array('id'=>$resmid[$mk]['id']))->save($data);
                                $delmid[]               = $resmid[$mk]['id'];
                                if ($res) $num++;
                            }else{
                                $data['producted_id']   = $id;
                                $res                    = $producted_material_db->add($data);
                                $delmid[]               = $res;
                                if ($res) $num++;
                            }
                        }
                    }
                    $where                              = array();
                    $where['id']                        = array('not in',$delmid);
                    $where['producted_id']              = $id;
                    $res                                = $producted_material_db->where($where)->delete();
                    if ($res) $num++;

                }else{
                    $info['audit_status']               = '-1';
                    $info['input_uname']                = session('nickname');
                    $info['input_user']                 = session('userid');
                    $info['input_time']                 = NOW_TIME;
                    $producted_id                       = $db->add($info);
                    if ($producted_id){
                        $num++;
                        foreach ($product as $k =>$v){  //保存产品内容
                            if (trim($v['title'])){
                                $data                   = array();
                                $data['producted_id']   = $producted_id;
                                $data['date']           = trim($v['date']);
                                $data['title']          = trim($v['title']);
                                $data['content']        = trim($v['content']);
                                $data['module_id']      = $v['module_id'] ? $v['module_id'] : 0 ;
                                $data['module']         = trim($v['module']);
                                $data['remark']         = trim($v['remark']);
                                $pres                   = $producted_module_db->add($data);
                                if ($pres) $num++;
                            }
                        }

                        foreach ($material as $mk=>$mv){
                            if (trim($mv['material'])){ //保存成本核算
                                $data                   = array();
                                $data['producted_id']   = $producted_id;
                                $data['material_id']    = $mv['material_id'] ? $mv['material_id'] : 0;
                                $data['material']       = trim($mv['material']);
                                $data['spec']           = trim($mv['spec']); //规格
                                $data['unitprice']      = $mv['unitprice'];
                                $data['amount']         = $mv['amount'];
                                $data['total']          = $mv['total'];
                                $data['type']           = $mv['type'];
                                $data['supplierRes_id'] = $mv['supplierRes_id'];
                                $data['channel']        = $mv['channel'];
                                $data['remark']         = $mv['remark'];
                                $mres                   = $producted_material_db->add($data);
                                if ($mres) $num++;
                            }
                        }
                    }
                }

                set_files_new_name($newname); //更改文件名
                if ($num){
                    $this->success('保存成功', U('Product/add_standard_product',array('id'=>$producted_id)));
                }else{
                    $this->error('数据保存失败');
                }
            }

            //保存标准化模块
            if ($savetype == 2){
                $attdb                          = M('attachment');
                $info                           = I('info');
                $material                       = I('material');
                $resid                          = I('resid');
                $mresid                         = I('mresid');
                $business_dept                  = I('business_dept');   //模块类型

                $age                            = I('age');
                $res                            = I('res');
                $product                        = I('product'); //模块内容
                $info['title']                  = trim($info['title']);
                $info['content']                = stripslashes(trim($_POST['content']));
                $info['business_dept']          = $business_dept;
                $info['age']                    = implode(',',array_unique($age));
                $info['supplier']               = implode(',',array_unique($res));
                //$info['disting']                = 0;
                $info['business_dept']          = implode(',',$business_dept);;
                $id                             = I('id');
                if (!$info['title']){           $this->error('模块名称不能为空!'); }

                //上传文件
                $theory                         = I('theory');  //原理及实施要求
                $pic                            = I('pic');     //图片
                $video                          = I('video');   //视频
                $theory_ids                     = $theory['id'];
                $pic_ids                        = $pic['id'];
                $video_ids                      = $video['id'];
                //$resfiles                     = array_merge($theory_ids,$pic_ids,$video_ids);
                $resfiles                       = array();
                foreach ($theory_ids as $k=>$v){
                    $resfiles[]                 = $v;
                }
                foreach ($pic_ids as $k=>$v){
                    $resfiles[]                 = $v;
                }
                foreach ($video_ids as $k=>$v){
                    $resfiles[]                 = $v;
                }
                $aids                           = implode(',', $resfiles);
                $info['att_id']                 = $aids?$aids:'';

                if ($id) {
                    $isadd                      = $id;
                    //修改
                    M('product')->where("id=$id")->data($info)->save();

                    //修改物资信息
                    $delid                      = array();
                    foreach($material as $mk=>$mv){
                        $data                   = array();
                        $data                   = $mv;
                        $data['material']       = trim($mv['material']);
                        if($data['material']){
                            if($resid && $resid[$mk]['id']){
                                $edits          = M('product_material')->data($data)->where(array('id'=>$resid[$mk]['id']))->save();
                                $delid[]        = $resid[$mk]['id'];
                            }else{
                                $data['product_id']     = $id;
                                $delid[]        = M('product_material')->add($data);
                            }
                        }
                    }

                    $where                      = array();
                    $where['product_id']        = $id;
                    if($delid) $where['id']     = array('not in',$delid);
                    $del                        = M('product_material')->where($where)->delete();

                    //保存所包含模块信息
                    $mdel_id                    = array();
                    foreach ($product as $kk=>$vv){
                        $data                   = array();
                        $data                   = $vv;
                        $data['title']          = trim($data['title']);
                        $data['length']         = trim($data['length']);
                        $data['content']        = trim($data['content']);
                        $data['implement_fname']= trim($data['implement_fname']);
                        $data['res_fname']      = trim($data['res_fname']);
                        $data['remark']         = trim($data['remark']);
                        if ($data['title']){
                            if($mresid && $mresid[$kk]['id']){
                                $edits          = M('product_module')->data($data)->where(array('id'=>$mresid[$kk]['id']))->save();
                                $mdel_id[]      = $mresid[$kk]['id'];
                            }else{
                                $data['product_id']             = $id;
                                $mdel_id[]      = M('product_module')->add($data);
                            }
                        }
                    }
                    $where                      = array();
                    $where['product_id']        = $id;
                    if($mdel_id) $where['id']   = array('not in',$mdel_id);
                    $del                        = M('product_module')->where($where)->delete();

                } else {
                    //保存
                    $info['input_user']         = session('userid');
                    $info['input_uname']        = session('nickname');
                    $info['input_time']         = time();
                    $info['audit_status']       = '-1'; //未提交审核
                    $isadd                      = M('product')->add($info);

                    //保存物资信息
                    foreach($material as $k=>$v){
                        $data                   = array();
                        $data                   = $v;
                        $data['product_id']     = $isadd;
                        if($data['material']){
                            M('product_material')->add($data);
                        }
                    }

                    //保存所包含模块内容
                    foreach ($product as $kk=>$vv){
                        $data                   = $vv;
                        $data['title']          = trim($data['title']);
                        $data['length']         = trim($data['length']);
                        $data['content']        = trim($data['content']);
                        $data['implement_fname']= trim($data['implement_fname']);
                        $data['res_fname']      = trim($data['res_fname']);
                        $data['remark']         = trim($data['remark']);
                        $data['product_id']     = $isadd;
                        if ($data['title']){
                            M('product_module')->add($data);
                        }
                    }

                }

                if ($isadd){
                    //保存上传标题图片
                    save_res(P::UPLOAD_PIC,$isadd,$pic,1);
                    //保存上传附件(原理及实施要求)
                    save_res(P::UPLOAD_THEORY,$isadd,$theory,1);
                    //保存视频文件
                    save_res(P::UPLOAD_VIDEO,$isadd,$video,1);

                    $this->success('保存成功！', U('Product/add_standard_module',array('id'=>$isadd)));
                }else{
                    $this->success('保存失败！');
                }
            }

            //审核标准化产品
            if ($savetype == 3){
                $producted_id                   = I('producted_id');
                if (!$producted_id){            $this->error('获取数据失败'); }
                $data                           = array();
                $data['audit_status']           = 0; //已提交,待审核
                $res                            = M('producted')->where(array('id'=>$producted_id))->save($data);
                $where                          = array();
                $where['req_type']              = P::REQ_TYPE_PRODUCTED;
                $where['req_id']                = $producted_id;
                $list                           = M('audit_log')->where($where)->find();
                if ($list){                     $this->error('您已经提交审核过了,请勿重复提交'); }
                $res                            = $this->request_audit(P::REQ_TYPE_PRODUCTED, $producted_id) ;
                $res ? $this->success('提交成功') : $this->error('提交申请失败');
            }

            //标准化模块申请审批
            if ($savetype == 4){
                $product_id                     = trim(I('product_id'));
                if (!$product_id){              $this->error('获取数据失败'); }
                $data                           = array();
                $data['audit_status']           = 0; //已提交,待审核
                $res                            = M('product')->where(array('id'=>$product_id))->save($data);
                $where                          = array();
                $where['req_type']              = P::REQ_TYPE_PRODUCT_NEW;
                $where['req_id']                = $product_id;
                $list                           = M('audit_log')->where($where)->find();
                if ($list){                     $this->error('您已经提交审核过了,请勿重复提交'); }
                $res                            = $this->request_audit(P::REQ_TYPE_PRODUCT_NEW, $product_id) ;
                $res ? $this->success('提交成功') : $this->error('提交申请失败');
            }

            /*//保存产品方案需求
            if ($savetype == 5){
                $db                             = M('product_pro_need');
                $id                             = I('id');
                $info                           = I('info');
                $info['title']                  = trim($info['title']);
                $info['customer']               = trim($info['customer']);
                $info['remark']                 = trim($info['remark']);
                $info['addr']                   = trim($info['addr']);
                $info['time']                   = strtotime($info['time']);
                $info['departure']              = strtotime($info['departure']);
                $manager_data                   = M('salary_department')->where(array('id'=>$info['dijie_department_id']))->find();
                //$info['dijie_manager_id']       = $manager_data['manager_id'];
                //$info['line_blame_uid']         = $manager_data['line_blame_uid'];
                //$info['line_blame_name']        = $manager_data['line_blame_name'];
                $info['in_dijie']               = 0; //是否为内部地接团
                $info['audit_uid']              = $info['line_blame_uid'];
                $info['audit_uname']            = $info['line_blame_name'];

                if (!$info['title']) $this->error('需求标题不能为空');
                if ($id){
                    $res                        = $db->where(array('id'=>$id))->save($info);
                }else{
                    $info['create_time']        = NOW_TIME;
                    $info['create_user']        = cookie('userid');
                    $info['create_user_name']   = cookie('nickname');
                    $res                        = $db -> add($info);
                    $id                         = $res;
                }
                $res ? $this->success('保存成功',U('Product/public_pro_need_add',array('id'=>$id))) : $this->error('数据保存失败');
            }*/

            //保存产品方案需求
            if ($savetype == 5){
                $db                             = M('op');
                $id                             = I('id');
                $info                           = I('info');
                $info['project']                = trim($info['project']);
                $info['customer']               = trim($info['customer']);
                $info['remark']                 = trim($info['remark']);
                $info['destination']            = trim($info['destination']);
                $info['time']                   = strtotime($info['time']);
                if (!$info['project']) $this->error('需求标题不能为空');
                if (!$info['line_blame_uid'] || !$info['line_blame_name']) $this->error('线控负责人信息错误');
                if ($id){
                    $res                        = $db->where(array('id'=>$id))->save($info);
                    $record_msg                 = '编辑产品方案需求基本信息';
                }else{
                    $info['create_time']        = time();
                    $info['create_user']        = cookie('userid');
                    $info['create_user_name']   = cookie('name');
                    //$info['sale_user']          = $info['create_user_name'];
                    $info['op_create_user']     = cookie('rolename');
                    $info['audit_status']       = 1; //项目不用审核,默认通过
                    $info['create_user_department_id'] = cookie('department');
                    $info['op_id']              = opid();
                    $res                        = $db -> add($info);
                    $id                         = $res;
                    $record_msg                 = '填写产品方案需求基本信息';
                }
                $record                         = array();
                $record['op_id']                = $info['op_id'];
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $res ? $this->success('保存成功',U('Product/public_pro_need_add',array('id'=>$id))) : $this->error('数据保存失败');
            }

            //保存科学课程详情
            if ($savetype == 6){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_kxkc'); //科学课程详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                //$producted_title                = I('producted_title'); //模块名称
                $in_time                        = I('in_time');
                if (!$need_id){ $this->error('数据错误'); }
                $data['title']                  = trim($data['title']);
                $data['addr']                   = trim($data['addr']);
                $data['teacher_condition']      = trim($data['teacher_condition']);
                $data['other_res_condition']    = trim($data['other_res_condition']);
                $data['remark']                 = trim($data['remark']);
                $data['product_pro_need_id']    = $need_id;
                $data['lession_time']           = strtotime($data['lession_time']);
                $data['st_time']                = strtotime(substr($in_time,0,8));
                $data['et_time']                = strtotime(substr($in_time,-8));
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //提交审核
            if ($savetype == 7){
                $id                             = I('id');
                $db                             = M('op'); //需求表
                $list                           = $db->find($id);
                if (!$id) $this->error('获取数据失败');
                $data                           = array();
                $data['process']                = 1; //已提交产品方案需求
                $res                            = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $process_node1              = 36; //接受客户对产品实施方案需求信息
                    $pro_status1                = 1; // 未读
                    $process_node2              = 38; //组织编制产品实施方案
                    $pro_status2                = 2; // 事前提醒
                    save_process_log($process_node1,$pro_status1,$list['project'],$list['id'],'',$list['line_blame_uid'],$list['line_blame_name']); //保存待办事宜
                    save_process_log($process_node2,$pro_status2,$list['project'],$list['id'],'',$list['line_blame_uid'],$list['line_blame_name']); //保存待办事宜
                    $this->success('提交成功',U('Product/public_pro_need'));
                }else{
                    $this->error('提交申请失败');
                }
            }

            //审核
            if ($savetype == 8){
                $id                             = I('id');
                $status                         = I('status');
                $audit_remark                   = I('audit_remark');
                $db                             = M('product_pro_need');
                if (!$id){ $this->error('获取数据错误'); }
                $data                           = array();
                $data['status']                 = $status;
                $data['audit_time']             = NOW_TIME;
                $data['audit_remark']           = trim($audit_remark);
                $data['audit_uid']              = cookie('userid');
                $data['audit_uname']            = cookie('nickname');
                $res                            = $db->where(array('id'=>$id))->save($data);
                $res ? $this->success('审核成功',U('Product/public_pro_need')) : $this->error('审核失败');
            }

            //保存科学博物院需求详情
            if ($savetype == 9){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_kxbwy'); //科学博物园详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $in_time                        = I('in_time');
                $yard                           = I('yard');
                if (!$need_id){ $this->error('数据错误'); }
                $data['other_yf_condition']     = trim($data['other_yf_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_jd_condition']     = trim($data['other_jd_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['product_pro_need_id']    = $need_id;
                $data['time']                   = strtotime($data['time']);
                $data['time1']                  = strtotime($data['time1']);
                $data['time2']                  = strtotime($data['time2']);
                $data['time3']                  = strtotime($data['time3']);
                $data['st_time']                = strtotime(substr($in_time,0,8));
                $data['et_time']                = strtotime(substr($in_time,-8));
                $data['yard']                   = implode(',',$yard);
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存研学旅行需求详情
            if ($savetype == 10){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_yxlx'); //研学旅行详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $in_time                        = I('in_time');
                //$yard                           = I('yard');
                if (!$need_id){ $this->error('数据错误'); }
                $data['other_line_condition']   = trim($data['other_line_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_jd_condition']     = trim($data['other_jd_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['product_pro_need_id']    = $need_id;
                $data['lecture_time']           = strtotime($data['lecture_time']);
                $data['st_time']                = strtotime(substr($in_time,0,10));
                $data['et_time']                = strtotime(substr($in_time,-10));
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存背景提升需求详情
            if ($savetype == 11){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_bjts'); //背景提升详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $expert_level                   = I('expert_level');
                if (!$need_id){ $this->error('数据错误'); }
                $data['other_yf_condition']     = trim($data['other_yf_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['product_pro_need_id']    = $need_id;
                $data['expert_level']           = implode(',',$expert_level);
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存实验室建设需求详情
            if ($savetype == 12){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_sysjs'); //实验室建设详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                if (!$need_id){ $this->error('数据错误'); }
                $data['pro_time']               = strtotime($data['pro_time']);
                $data['costacc_time']           = strtotime($data['costacc_time']);
                $data['other']                  = trim($data['other']);
                $data['content']                = trim($data['content']);
                $data['other_condition']        = trim($data['other_condition']);
                $data['product_pro_need_id']    = $need_id;
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存科学快车详情
            if ($savetype == 13){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_bus'); //科学快车详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $selfOpNeed                     = I('selfOpNeed');
                $addOpNeed                      = I('addOpNeed');
                if (!$need_id){ $this->error('数据错误'); }
                $data['title']                  = trim($data['title']);
                $data['company']                = trim($data['company']);
                $data['company1']               = trim($data['company1']);
                $data['time']                   = trim($data['time']);
                $data['addr']                   = trim($data['addr']);
                $data['area']                   = trim($data['area']);
                $data['post']                   = trim($data['post']);
                $data['content']                = trim($data['content']);
                $data['selfOpNeed']             = implode(',',$selfOpNeed);
                $data['addOpNeed']              = implode(',',$addOpNeed);
                $data['product_pro_need_id']    = $need_id;
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存校园科技节详情
            if ($savetype == 14){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_xykjj'); //校园科技节详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $in_time                        = I('in_time');
                $yard                           = I('yard');
                if (!$need_id){ $this->error('数据错误'); }
                $data['addr']                   = trim($data['addr']);
                $data['yard_more']              = trim($data['yard_more']);
                $data['content']                = trim($data['content']);
                $data['gift_condition']         = trim($data['gift_condition']);
                $data['other_yf_condition']     = trim($data['other_yf_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_jd_condition']     = trim($data['other_jd_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['yard']                   = implode(',',$yard);
                $data['product_pro_need_id']    = $need_id;
                $data['time']                   = strtotime($data['time']);
                $data['st_time']                = strtotime(substr($in_time,0,8));
                $data['et_time']                = strtotime(substr($in_time,-8));
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存小课题详情
            if ($savetype == 15){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_xkt'); //校园科技节详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $pro_type                       = I('pro_type');
                $pro_addr                       = I('pro_addr');
                $expert_level                   = I('expert_level');
                $resulted                       = I('resulted');
                $match                          = I('match');
                if (!$need_id){ $this->error('数据错误'); }
                $data['customer']               = trim($data['customer']);
                $data['other_condition']        = trim($data['other_condition']);
                $data['in_time']                = trim($data['in_time']);
                $data['pro_type']               = implode(',',$pro_type);
                $data['pro_addr']               = implode(',',$pro_addr);
                $data['expert_level']           = implode(',',$expert_level);
                $data['resulted']               = implode(',',$resulted);
                $data['match']                  = implode(',',$match);
                $data['product_pro_need_id']    = $need_id;
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存单进院所详情
            if ($savetype == 16){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_djys'); //单进院所详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                if (!$need_id){ $this->error('数据错误'); }
                $data['institutes']             = trim($data['institutes']);
                $data['content']                = trim($data['content']);
                $data['long']                   = trim($data['long']);
                $data['other_condition']        = trim($data['other_condition']);
                $data['time']                   = strtotime($data['time']);
                $data['product_pro_need_id']    = $need_id;
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存专场讲座详情
            if ($savetype == 17){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_zcjz'); //专场讲座详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $expert_level                   = I('expert_level');
                if (!$need_id){ $this->error('数据错误'); }
                $data['addr']                   = trim($data['addr']);
                $data['equipment']              = trim($data['equipment']);
                $data['field']                  = trim($data['field']);
                $data['expert_type']            = trim($data['expert_type']);
                $data['type']                   = trim($data['type']);
                $data['other_condition']        = trim($data['other_condition']);
                $data['expert_level']           = implode(',',$expert_level);
                $data['time']                   = strtotime($data['time']);
                $data['product_pro_need_id']    = $need_id;
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存综合实践需求详情
            if ($savetype == 18){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_zhsj'); //综合实践详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                if (!$need_id){ $this->error('数据错误'); }
                $data['other_yf_condition']     = trim($data['other_yf_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_jd_condition']     = trim($data['other_jd_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['product_pro_need_id']    = $need_id;
                $data['time']                   = strtotime($data['time']);
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //保存教师培训需求详情
            if ($savetype == 19){
                $need_db                        = M('product_pro_need'); //需求表
                $detail_db                      = M('product_pro_need_jspx'); //研学旅行详情表
                $need_id                        = I('need_id');
                $id                             = I('id');
                $opid                           = I('opid');
                $data                           = I('data'); //详情
                $info                           = I('info'); //需求
                $in_time                        = I('in_time');
                if (!$need_id){ $this->error('数据错误'); }
                $data['other_line_condition']   = trim($data['other_line_condition']);
                $data['other_zy_condition']     = trim($data['other_zy_condition']);
                $data['other_jd_condition']     = trim($data['other_jd_condition']);
                $data['other_sj_condition']     = trim($data['other_sj_condition']);
                $data['product_pro_need_id']    = $need_id;
                $data['lecture_time']           = strtotime($data['lecture_time']);
                $data['leader_time']            = strtotime($data['leader_time']);
                $data['st_time']                = strtotime(substr($in_time,0,10));
                $data['et_time']                = strtotime(substr($in_time,-10));
                if ($id){
                    $res                        = $detail_db->where(array('id'=>$id))->save($data);
                    $record_msg                 = '编辑产品方案需求详细信息';
                }else{
                    $res                        = $detail_db->add($data);
                    $record_msg                 = '添加产品方案需求详细信息';
                }
                $record                         = array();
                $record['op_id']                = $opid;
                $record['optype']               = 1;
                $record['explain']              = $record_msg;
                op_record($record);
                $need_res                       = $need_db->where(array('id'=>$need_id))->save($info);
                if ($res) $num++;
                if ($need_res) $num++;
                $num > 0 ? $this->success('数据保存成功',U('Product/public_pro_need_add',array('id'=>$need_id))) : $this->error('数据保存失败');
            }

            //提交审核 产品实施方案
            if ($savetype == 20){
                $id                             = I('id');
                $db                             = M('op_scheme'); //产品实施方案
                $list                           = $db->find($id);
                if (!$id) $this->error('获取数据失败');
                $data                           = array();
                $data['audit_status']           = 3; //已提交,未审核
                $res                            = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $record                     = array();
                    $record['op_id']            = $opid;
                    $record['optype']           = 1;
                    $record['explain']          = '提交产品实施方案';
                    op_record($record);

                    $process_node               = 39; //确认产品实施方案
                    $pro_status                 = 2; // 事前提醒
                    save_process_log($process_node,$pro_status,$list['project'],$list['id'],'',$list['audit_user_id'],$list['audit_user_name']); //保存待办事宜

                    //消除待办事宜
                    $ok_node                    = 38; //组织编制产品实施方案
                    save_process_ok($ok_node);
                    $this->success('提交成功',U('Product/public_scheme'));
                }else{
                    $this->error('提交申请失败');
                }
            }

            //审核  产品实施方案
            if ($savetype == 21){
                $id                             = I('id');
                $status                         = I('status');
                $audit_remark                   = trim(I('status'));
                if (!$id) $this->error('获取数据失败');
                if (!$status) $this->error('请选择审核结果');
                $db                             = M('op_scheme');
                $list                           = $db->where(array('id'=>$id))->find();
                $data                           = array();
                $data['audit_status']           = $status;
                $data['audit_remark']           = $audit_remark;
                $data['audit_time']             = NOW_TIME;
                $res                            = $db->where(array('id'=>$id))->save($data);
                if ($res){
                    $record                     = array();
                    $record['op_id']            = $list['op_id'];
                    $record['optype']           = 1;
                    $record['explain']          = '审核产品实施方案：审核状态：'.$status==1 ? '审核通过' : '审核不通过';
                    op_record($record);

                    //生成待办事宜
                    if ($status==2){ //审核未通过
                        $process_node           = 40; //修改产品实施方案
                        $pro_status             = 3; // 反馈
                        save_process_log($process_node,$pro_status,$list['project'],$list['id'],'',$list['create_user_id'],$list['create_user_name']); //保存待办事宜
                    }

                    //消除待办事宜
                    $ok_node                    = 39; //确认产品实施方案
                    save_process_ok($ok_node,$audit_remark);

                    $this->success('数据保存成功');
                }else{
                    $this->error('保存数据失败');
                }
            }
        }
    }

}
