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
		
		$key          = I('key');
		$pro          = I('pro',54);//默认研学旅行
		$zj           = I('zj');
		$age          = I('age');

		$db           = M('product');
		$this->pro    = $pro;
		$where        = array();
		if($key)    $where['p.title'] = array('like','%'.$key.'%');
		if($pro)    $where['p.business_dept'] = array('like','%'.$pro.'%');
		if($age)    $where['p.age'] = array('like','%'.$age.'%');
		if($zj)     $where['p.input_uname'] = array('like','%'.$zj.'%');
		
		$business_depts = C('BUSINESS_DEPT');
        $page = new Page($db->table('__PRODUCT__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages = $page->show();
		$lists = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
        $kinds = M('project_kind')->getField('id,name');
        foreach($lists as $k=>$v){
			$depts = explode(',',$v['business_dept']);
			$deptval = array();
			foreach($depts as $kk=>$vv){
				$deptval[] = $kinds[$vv];
			}
			
			$lists[$k]['dept'] = implode(',',$deptval);	
		}
		$this->lists    = $lists;
		$this->ages     = C('AGE_LIST');
        $this->kinds    = $kinds;

        //导航栏
        $kind_ids       = array(54,55,56,60,61,62);
        $where          = array();
        $where['id']    = array('in',$kind_ids);
        $this->business_dept = M('project_kind')->where($where)->getField('id,name');

		$this->display('index');
    }
	
    
    // @@@NODE-3###del###删除产品###
    public function del(){
        $this->title('删除产品');
		$db = M('product');
		$id = I('id', -1);
		$iddel = $db->delete($id);
		$this->success('删除成功！');	
    }
    
	
    // @@@NODE-3###add###添加产品###
    /***********************bak_start**************************/
    public function add__bak() {
        $this->title('添加产品');
		if (isset($_POST['dosubmit'])) {

             $info = I('info');
			 $referer = I('referer');
			 $material = I('material');
			 $resid = I('resid');
			 $business_dept = I('business_dept');
			 $age = I('age');
			 $res = I('res');
			 $info['content'] = stripslashes($_POST['content']);
			 $info['business_dept'] = implode(',',array_unique($business_dept));
			 $info['age'] = implode(',',array_unique($age));
			 $info['supplier'] = implode(',',array_unique($res));
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
				M('product')->where("id=$id")->data($info)->save();
				if ($aids) {
					$attdb->where("id in ($aids)")->setField('rel_id', $id);
				}
				
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
				
				$this->success('修改成功！', $referer);   
			} else {
				 
				//保存
				$info['input_user'] = session('userid');
				$info['input_uname'] = session('nickname');
				$info['input_time']  = time();
				
				$rel_id = M('product')->add($info);
				if ($aids) {
					$attdb->where("id in ($aids)")->setField('rel_id', $rel_id);
				}
				
				$this->request_audit(P::REQ_TYPE_PRODUCT_NEW, $rel_id);
				
				//保存物资信息
				foreach($material as $k=>$v){
					$data = array();
					$data = $v;
					$data['product_id'] = $rel_id;
					if($data['material']){
						M('product_material')->add($data);
					}
				}	
				
				$this->success('保存成功！', $referer); 
			}
		} else {
            $id = I('id');
             
			$this->row = M('product')->find($id);
			
			if($this->row){
				if ($this->row['att_id']) {
				$this->atts = M('attachment')->where("catid=1 and id in (" . $this->row['att_id']. ")")->select();
				} else {
				$this->atts = false;
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

			$this->subject_fields = C('SUBJECT_FIELD');
			$this->projects       = M('project')->where(array('status'=>1))->select();
				
			$this->display('add');
		}
    }
    /***********************bak_end**************************/

    //新增资讯
    public function pic_add(){

        if(isset($_POST['dosubmit'])){

            $info   = I('info','');
            $infos  = I('attr');
            $lm		= I('lm');
            $conpic = I("daypic");
            /*$daypic = I('daypic');*/

            $info['col']			= implode(',',$lm);
            $info['pic']			= $infos['filepath'][0];
            $info['pic_id']			= $infos['id'][0];
            $info['create_time']	= time();
            $info['update_time']	= time();
            $info['type']			= 0;
            $info['module']         = P::TYPE_PIC_NEWS;
            /*$info['content']		= stripslashes($_POST['content']);*/
            if(!$info['title']){
                $this->error('标题不能为空！');
            }else{

                $isadd = M('article')->add($info);
                if($isadd){

                    //保存上传标题图片
                    save_res(P::TYPE_NEWS,$isadd,$infos);
                    //保存上传内容大图片
                    save_res(P::TYPE_PIC_NEWS,$isadd,$conpic);

                    $this->success('添加成功！',I('referer',''));
                }else{
                    $this->error('添加失败！',I('referer',''));
                }
            }

        }else{

            $this->display('pic_add');
        }
    }

    public function add() {
        $this->title('添加产品');

        if (isset($_POST['dosubmit'])) {

            $attdb = M('attachment');
            $info = I('info');
            $referer = I('referer');
            $material = I('material');
            $resid = I('resid');
            $business_dept = I('business_dept');
            $age = I('age');
            $res = I('res');
            $info['content'] = stripslashes($_POST['content']);
            $info['business_dept'] = $business_dept;
            $info['age'] = implode(',',array_unique($age));
            $info['supplier'] = implode(',',array_unique($res));
            $id = I('id');

            //上传文件
            $theory     = I('theory');  //原理及实施要求
            $pic        = I('pic');     //图片
            $video      = I('video');   //视频
            $theory_ids = $theory['id'];
            $pic_ids    = $pic['id'];
            $video_ids  = $video['id'];
            $resfiles   = array_merge($theory_ids,$pic_ids,$video_ids);

            $aids = implode(',', $resfiles);
            var_dump($aids);die('sss');

            $newname = I('newname', null);

            if ($aids) {
                $info['att_id'] = $aids;
            } else {
                $info['att_id'] = '';
            }

            //保存上传标题图片
            save_res(P::UPLOAD_PIC,$isadd,$theory);
            //保存上传内容大图片
            save_res(P::UPLOAD_THEORY,$isadd,$pic);
            //保存视频文件
            save_res(P::UPLOAD_VIDEO,$isadd,$video);

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

                $this->success('修改成功！', $referer);
            } else {

                //保存
                $info['input_user'] = session('userid');
                $info['input_uname'] = session('nickname');
                $info['input_time']  = time();

                $isadd = M('product')->add($info);

                $this->request_audit(P::REQ_TYPE_PRODUCT_NEW, $rel_id);

                //保存物资信息
                foreach($material as $k=>$v){
                    $data = array();
                    $data = $v;
                    $data['product_id'] = $rel_id;
                    if($data['material']){
                        M('product_material')->add($data);
                    }
                }

                $this->success('保存成功！', $referer);
            }
        } else {
            $id                  = I('id');
            $business_dept       = I('business_dept');
            $this->business_dept = $business_dept;
            $this->row           = M('product')->find($id);

            if($this->row){
                if ($this->row['att_id']) {
                    $this->atts = M('attachment')->where("catid=1 and id in (" . $this->row['att_id']. ")")->select();
                } else {
                    $this->atts = false;
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
    	
		$key          = I('key');
		$status       = I('status','-1');
		$pro          = I('pro');
		$zj           = I('zj');
		$age          = I('age');
		
		$db = M('product');
		$this->status = $status;
		$where = array();
		if($this->status != '-1') $where['p.audit_status'] = $this->status;
		if($key)    $where['p.title'] = array('like','%'.$key.'%');
		if($pro)    $where['p.business_dept'] = array('like','%'.$pro.'%');
		if($age)    $where['p.age'] = array('like','%'.$age.'%');
		if($zj)     $where['p.input_uname'] = array('like','%'.$zj.'%');
		
		$business_depts = C('BUSINESS_DEPT');
        $page = new Page($db->table('__PRODUCT__ as p')->where($where)->count(), P::PAGE_SIZE);
        $this->pages = $page->show();
		$lists = $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('p.id'))->select();
		$kinds = M('project_kind')->getField('id,name');
		foreach($lists as $k=>$v){
			$depts = explode(',',$v['business_dept']);
			$deptval = array();
			foreach($depts as $kk=>$vv){
				$deptval[] = $kinds[$vv];
			}
			
			$lists[$k]['dept'] = implode(',',$deptval);	
		}
		$this->lists = $lists;
		
		$this->ages           = C('AGE_LIST');
		$this->kinds  = $kinds;
    	$this->display('select_product');
    	
    }
	// @@@NODE-3###view###产品模块详情###
    public function view () {
        $this->title('产品模块详情');
        $db = M('product');
        $id = I('id', -1);
		
		$where = array();
		$where['p.id'] = $id;
		$row =  $db->table('__PRODUCT__ as p')->field('p.*')->where($where)->find();
		
		if($row){
			$where = array();
			$where['req_type'] = P::REQ_TYPE_PRODUCT_NEW;
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
				$this->atts = M('attachment')->where("catid=1 and id in (" . $row['att_id']. ")")->select();
			}else{
				$this->atts = false;
			}

			$material = M('product_material')->where(array('product_id'=>$id))->select();
			
			$sp = array();
			$sp['id'] = array('IN',$row['supplier']);
			$this->supplier = M('cas_res')->where($sp)->select();
			$this->reskind = M('reskind')->getField('id,name', true);
			
		}else{
			$this->error('产品模块不存在' . $db->getError());	
		}
		
		$this->row = $row;
		$this->material = $material;
		$this->business_depts = C('BUSINESS_DEPT');
		$this->subject_fields = C('SUBJECT_FIELD');
		$this->ages           = C('AGE_LIST');
			 
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
	
    
}