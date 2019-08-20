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
            $this->kinds          = M('project_kind')->field('id,name')->where(array('pid'=>array('neq',0)))->select();

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
		if($pro)    $where['p.project_id'] = $pro;
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
        $this->title('线路行程列表');
		
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
        $this->pageTitle                = '标准化管理';
        $month                          = date('m');
        $pin                            = I('pin',0);
        $year                           = I('year',date('Y'));
        $ltit                           = get_little_title($year,$month);
        $db                             = M('product');
        $tit                            = trim(I('key'));
        $kind                           = I('kind');
        $age                            = I('age');
        $app_time                       = get_apply_time($ltit,$pin);
        $apply_year                     = $app_time['ayear'];
        $apply_time                     = $app_time['atime'];

        $where                          = array();
        //$where['disting']               = 1;
        if ($apply_year) $where['apply_year'] = $apply_year;
        if ($apply_time) $where['apply_time'] = $apply_time;
        if ($tit) $where['title']       = array('like','%'.$tit.'%');
        if ($kind) $where['business_dept'] = array('like','%'.$kind.'%');
        if ($age) $where['age']         = $age;

        $count                          = $db->table('__PRODUCT__ as p')->where($where)->count();
        $page                           = new Page($count, P::PAGE_SIZE);
        $this->pages                    = $page->show();
        $lists                          = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
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

        //$this->lists                    = $lists;
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
        $this->pageTitle                = '标准化管理';
        $id                             = I('id');
        $this->title('标准化产品');
        $year                           = date('Y');
        $apply_times                    = get_little_title($year);

        if ($id){
            $list                       = M('product')->where(array('id'=>$id))->find();
            $this->row                  = $list;
            //$model_lists                = M('product_use')->where(array('pid'=>$id))->select();
            //$res_ids                    = explode(',',$list['cas_res_ids']);
            //$res_need                   = M('cas_res')->where(array('id'=>array('in',$res_ids)))->select();
            //$this->res_need             = $res_need;
            //$this->product_need         = $model_lists;
            $this->business_dept        = explode(',',$list['business_dept']);
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
        $this->id                       = $id;

        $citys_db                       = M('citys');
        $arr_citys                      = $citys_db->getField('id,name',true);
        $default_province               = $citys_db->where(array('pid'=>0))->getField('id,name',true);

        $this->userkey                  = get_username();
        $this->provinces                = $default_province;
        $this->citys                    = $arr_citys;
        $this->cost_type                = C('COST_TYPE');
        $this->title('标准化产品');
        $this->display();
    }

    //标准化产品(详情)
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
        $this->display('standard_product_detail');
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
        $this->cost_type                = C('COST_TYPE');
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

    //选择文件
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

    //选择科普资源(弹框)
    public function public_select_supplierRes(){
        $db                                 = M('supplier');
        $name                               = trim(I('name'));
        $city                               = trim(I('city'));
        $costType                           = I('costType',0);
        $kind                               = I('kind') ? I('kind') : get_supplierkind($costType);
        if ($kind ==8){ //研究所台站不从合格供方取值 , 从资源库取值 cas_res
            $where                          = array();
            $where['audit_status']          = 1;
            if ($name) $where['title']      = array('like','%'.$name.'%');
            if ($city) $where['_string']    = "(diqu like '%$city%') or (address like '%$city%')";
            $pageCount                      = $db->where($where)->count();
            $page                           = new page($pageCount,P::PAGE_SIZE);
            $this->pages                    = $pageCount > P::PAGE_SIZE ? $page->show() : '';
            $field                          = 'id,title as name, diqu as prov,address as city';
            $lists                          = M('cas_res')->where($where)->limit($page->firstRow.','.$page->listRows)->order($this->orders('id'))->field($field)->select();
            foreach ($lists as $k=>$v){     $lists[$k]['kind'] = 8; } //研究所台站
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
        }
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

    public function public_save(){
        $savetype                               = I('savetype');
        if (isset($_POST['dosubmit'])){
            //保存标准化产品
            if ($savetype == 1){
                $db                             = M('product');
                $id                             = I('id',0);
                $info                           = I('info');
                $apply_time                     = trim(I('apply_time'));
                $info['age']                    = I('age');
                $business_dept                  = I('business_dept');
                $info['business_dept']          = implode(',',$business_dept);
                $info['content']                = trim(I('content'));
                $product_model                  = I('costacc'); //包含产品模块
                $cas_res_ids                    = I('res_ids'); //包含资源模块
                $resfiles                       = I('resfiles');
                $resetid                        = I('resetid');
                $info['att_id']                 = implode(',',$resfiles);
                $info['apply_year']             = $apply_time?substr($apply_time,0,4):0;
                $info['apply_time']             = $apply_time?substr($apply_time,-1):0;
                //$info['disting']                = 1; //标准化数据

                $cas                            = array();
                foreach ($cas_res_ids as $k=>$v){
                    $cas[]                      = $v['res_id'];
                }
                $info['cas_res_ids']            = implode(',',$cas);
                if ($id){
                    $where                      = array();
                    $where['id']                = $id;
                    $res                        = $db->where($where)->save($info);
                    $pid                        = $id;
                }else{
                    $info['input_time']         = NOW_TIME;
                    $info['input_user']         = session('userid');
                    $info['input_uname']        = session('nickname');
                    $res                        = $db ->add($info);
                    $pid                        = $res;
                    $this->request_audit(P::REQ_TYPE_PRODUCT_NEW, $pid);
                }

                if ($res){
                    if ($product_model){ //保存相关产品模块
                        $product_use_db         = M('product_use');
                        $del_ids                = array();
                        foreach ($product_model as $k=>$v){
                            $data               = array();
                            $data['pid']        = $pid;
                            $data['product_id'] = $v['product_id'];
                            $data['title']      = $v['title'];
                            $data['unitcost']   = $v['unitcost'];
                            $data['amount']     = $v['amount'];
                            $data['total']      = $v['total'];
                            if ($v['id']){
                                $res            = $product_use_db->where(array('id'=>$v['id']))->save($data);
                                $del_ids[]      = $v['id'];
                            }else{
                                $res            = $product_use_db->add($data);
                                $del_ids[]      = $res;
                            }
                        }
                        $product_use_db->where(array('pid'=>$pid,'id'=>array('not in',$del_ids)))->delete();
                    }
                    $this->success('数据保存成功');
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
                            if($resid && $resid[$k]['id']){
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

            //保存标准化产品
            if ($savetype == 3){
                echo '加班开发中...';
            }
        }
    }
    
}