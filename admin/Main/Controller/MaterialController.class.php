<?php
namespace Main\Controller;
use Think\Controller;
use Org\Util\Rbac;
use Sys\P;
ulib('Page');
use Sys\Page;
ulib('Pinyin');
use Sys\Pinyin;
// @@@NODE-2###Material###物资管理###
class MaterialController extends BaseController {

	public function add_wz(){
		$PinYin = new Pinyin();
		$wz = M('material_into')->where('material_id is null')->select();
		foreach($wz as $v){
			$m = M('material')->where(array('material'=>trim($v['material'])))->find();
			if(!$m){
				$info = array();
				$material = iconv("utf-8","gb2312",trim($v['material']));
				$info['pinyin'] = strtolower($PinYin->getFirstPY($material));
				$info['material'] = trim($v['material']);
				$info['stock'] = $v['amount'];
				$isadd = M('material')->add($info);
				if($isadd){
					 M('material_into')->data(array('material_id'=>$isadd))->where(array('id'=>$v['id']))->save();
				}
			}
		}
		P($wz);
	}


    // @@@NODE-3###add###新增物资###
    public function add(){
		$db = M('material');
		$id = I('id');

		if (isset($_POST['dosubmit'])) {

			$PinYin = new Pinyin();
			$info = I('info');
			$referer = I('referer');

			//名称转拼音
			$material = iconv("utf-8","gb2312",trim($info['material']));
			$info['pinyin'] = strtolower($PinYin->getFirstPY($material));
			if($id){
				$isok = $db->data($info)->where(array('id'=>$id))->save();
			}else{
				if(!$db->where(array('material'=>trim($info['material'])))->find()){
					$isok = $db->add($info);
				}else{
					 $this->error('物资已存在，无需重复添加' . $db->getError());
				}
			}
			if($isok){
				 $this->success('保存成功！',$referer);
			}else{
				 $this->error('保存失败' . $db->getError());
			}

		}else{
			$this->row = $db->find($id);
			$this->material_type = C('MATERIAL_TYPE');
			$this->material_class = M('material_kind')->select();
			$this->display('add');
		}


    }


	// @@@NODE-3###stock###物资库存###
	public function stock(){


		$where = array();

		$db = M('material');
		$keywords = I('keywords');
		$type     = I('kind');

		$where = array();
		$where['asset'] = 0;
		if($keywords) $where['material'] = array('like','%'.$keywords.'%');
		if($type)     $where['kind']     = $type;

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
		foreach($lists as $k=>$v){
			//最新出库日期
			$m_out  = M('material_out')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('out_time DESC')->find();
			$lists[$k]['out_time'] = $m_out['out_time'];
			//最新入库日期
			$m_into = M('material_into')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('into_time DESC')->find();
			$lists[$k]['into_time'] = $m_into['into_time'];
		}

		$this->material = M('material')->select();
		$this->material_type = C('MATERIAL_TYPE');
		$this->material_class = M('material_kind')->select();
		$material_class = M('material_kind')->select();
		foreach($material_class as $v){
			$kind[$v['id']] = $v['name'];
		}
		//物料关键字
		$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
		if($key) $this->keywords =  json_encode($key);
		$this->kind = $kind;
		$this->lists = $lists;
		$this->display('stock');
	}

	//删除物资
    public function del_material(){
        $id     = I('id');
        $db     = M('material');
        $res    = $db->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


	// @@@NODE-3###into_record###物资入库记录###
	public function into_record(){

		$where = array();
		$keywords = I('keywords');
		$type = I('type','-1');

		$db = M('material_into');

		$id = trim(I('id'));
		if($id){
			$wz = M('material_into')->find($id);
			$material = $wz['material_id'];
		}else{
			$material = trim(I('material'));
		}


		$where = array();
		if($material) $where['material_id'] = $material;
		if($type!='-1') $where['type'] = $type;
		if($keywords) $where['material'] = array('like','%'.$keywords.'%');

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('into_time'))->select();

		$this->lists = $lists;
		$rolelist = M('role')->where(array('id'=>array('gt',3)))->select();
		$bumen = array();
		foreach($rolelist as $v){
			$bumen[$v['id']] = $v['role_name'];
		}

		$this->material = M('material')->select();
		$this->rolelist = $bumen;
		$this->display('material_into');
	}


	// @@@NODE-3###into###物资入库###
	public function into(){

		$db = M('material_into');
		//$id = I('id',0);
		$pur_id = I('pur_id',0);
		$opid   = I('opid');

		if (isset($_POST['dosubmit'])) {

			$info = I('info');
			$referer = I('referer');
			$material = I('material');
			$purid = I('purid');
			if($info && $material){
				/*
				if(!$opid){
					$where['group_id'] = trim($info['order_id']);
					$op = M('op')->field('op_id')->where($where)->find();
					$opid = $op['op_id'];
				}
				*/

				$info['into_time'] = time();
				$batch = $info;
				$count = count($material);
				if($count>1){
					$batch['name'] = $material[0]['material'].'等'.$count.'种物资';
				}else{
					$batch['name'] = $material[0]['material'];
				}
				$batch['op_id'] = $opid;
				$batch_id = M('material_into_batch')->add($batch);

				if($batch_id){
					$this->request_audit(P::REQ_TYPE_GOODS_IN, $batch_id);
					foreach($material as $k=>$v){
						$data = array_merge($info,$v);
						$data['batch_id'] = $batch_id;
						$data['op_id'] = $opid;
						$isnull = M('material')->where(array('material'=>$data['material']))->find();
						if(!$isnull){
							$PinYin = new Pinyin();
							$materialpy = iconv("utf-8","gb2312",trim($data['material'])); //名称转拼音
							$materialinfo = array();
							$materialinfo['material'] = trim($data['material']);
							$materialinfo['pinyin'] = strtolower($PinYin->getFirstPY($materialpy));
							$mid = M('material')->add($materialinfo);
							$data['material_id']=$mid;
						}
						$db->add($data);

					}

					if($purid){
						M('material_purchase_batch')->data(array('op_into'=>1))->where(array('id'=>$purid))->save();
					}
					$this->success('申请已提交！',$referer);
				}else{
					$this->error('申请失败' . $db->getError());
				}
			}

		}else{

			$row = array();
			if($pur_id){
				$pur = M('material_purchase_batch')->find($pur_id);
				$this->material = M('material_purchase')->where(array('batch_id'=>$pur_id))->select();
				$this->countmaterial = count($this->material);
				$row['order_id'] = $pur['order_id'];
				$row['purid'] = $pur_id;
				$row['ontype'] = 0;
				$row['department'] = $pur['department'];
			}


			if($opid){
				$where = array();
				$where['op_id'] = $opid;
				$op = M('op')->where($where)->find();

				$matelist       = M()->table('__OP_MATERIAL__ as m')->field('c.*,m.*')->join('__OP_COST__ as c on m.id=c.link_id')->where('m.op_id='.$opid.' and  c.op_id ='.$opid.' and c.cost_type=4 and m.outsum>m.returnsum and m.outsum>0')->order('m.id')->select();


				foreach($matelist as $k=>$v){
					//获取物资库存
					$stock = M('material')->where(array('material'=>$v['material']))->find();
					$matelist[$k]['stock']  = $stock['stock'] ?$stock['stock']:0;
					$matelist[$k]['stages'] = $stock['stages']?$stock['stages']:0;
					$matelist[$k]['lastcost'] = $stock ? $stock['price'] : 0;
					$matelist[$k]['amount'] = $v['outsum']-$v['returnsum'];
				}
				$this->material = $matelist;
				$this->countmaterial = count($this->material);
				$row['order_id'] = $op['group_id'];
				$row['ontype'] = 1;
				$row['opid'] = $opid;
				$row['department_nm'] = $op['op_create_user'];

			}


			$this->rolelist = M('role')->where(array('id'=>array('gt',3)))->select();
			$this->row = $row;
			//物料关键字
			$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
			if($key) $this->keywords =  json_encode($key);

			$this->display('into');
		}
	}


	// @@@NODE-3###into_viwe###物资入库申请单###
	public function into_view(){
		$db = M('material_into_batch');

		$id = I('id');

		$this->bumen = M('role')->where(array('id'=>array('gt',3)))->Getfield('id,role_name',true);
		$this->row = M('material_into_batch')->find($id);
		$material = M('material_into')->where(array('batch_id'=>$id))->select();
		$this->material = $material;
		$this->leixing = array('0'=>'采购入库','1'=>'物资归还');
		$this->display('into_viwe');
	}


	// @@@NODE-3###out###物资出库###
	public function out(){
		$db = M('material_out');
		$id = I('id',0);

		if (isset($_POST['dosubmit'])) {

			$info = I('info');
			$referer = I('referer');
			$material = I('material');

			if($info['order_id']){
				$op = M('op')->where(array('group_id'=>trim($info['order_id'])))->find();
				$info['op_id'] = $op['op_id'];
			}



			if($info && $material){
				$info['out_time'] = time();
				$batch = $info;
				$count = count($material);
				if($count>1){
					$batch['name'] = $material[0]['material'].'等'.$count.'种物资';
				}else{
					$batch['name'] = $material[0]['material'];
				}

				$batch_id = M('material_out_batch')->add($batch);
				if($batch_id){
					$this->request_audit(P::REQ_TYPE_GOODS_OUT, $batch_id);
					foreach($material as $k=>$v){
						$data = array_merge($info,$v);
						$data['batch_id'] = $batch_id;
						//获取物资信息
						$db->add($data);
					}

					$this->success('申请已提交！',$referer);
				}else{
					$this->error('申请失败' . $db->getError());
				}

			}

		}else{


			//物料关键字
			$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
			if($key) $this->keywords =  json_encode($key);

			$this->display('out');
		}


	}

	// @@@NODE-3###out_viwe###物资出库申请单###
	public function out_viwe(){
		$db = M('material_out_batch');

		$id = I('id');

		$this->row = M('material_out_batch')->find($id);
		$material = M()->field('o.*,m.stock,m.unit,m.price')->table('__MATERIAL_OUT__ as o')->join('__MATERIAL__ as m on m.id=o.material_id','LEFT')->where(array('o.batch_id'=>$id))->select();

		$this->ontype = array('0'=>'正常出库','1'=>'物资报废','2'=>'赠送物资');
		$this->material = $material;
		$this->display('out_viwe');
	}


	// @@@NODE-3###out_record###物资出库记录###
	public function out_record(){

		$id = trim(I('id'));
		$oid = trim(I('oid'));
		$lqr = trim(I('lqr'));
		$material = I('material');

		$where = array();
		if($id)   $where['id'] = $id;
		if($oid)  $where['order_id'] = array('like','%'.$oid.'%');
		if($lqr)  $where['receive_liable'] = array('like','%'.$lqr.'%');

		if($material){

			$where['material_id'] = $material;

			$db = M('material_out');
			//分页
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount, P::PAGE_SIZE);
			$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

			$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('out_time'))->select();

			$this->lists = $lists;

			$this->display('material_unit_out');
		}else{

			$db = M('material_out_batch');


			//分页
			$pagecount = $db->where($where)->count();
			$page = new Page($pagecount, P::PAGE_SIZE);
			$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

			$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('out_time'))->select();
			foreach($lists as $k=>$v){
				$lists[$k]['total'] = M('material_out')->where(array('batch_id'=>$v['id']))->sum('total');
			}

			$this->lists = $lists;
			$this->display('material_out');
		}

	}


	// @@@NODE-3###mateinfo###获取物资价格###
	public  function mateinfo(){
		$id = I('id');
		$material = I('material');

		if($id || $material){

			$where = array();
			if($id)       $where['id'] = $id;
			if($material) $where['material'] = trim($material);

			$material =  M('material')->field('id,material,stock,price')->where($where)->find();
			if($material){
				echo json_encode($material);
			}
		}

	}



	// @@@NODE-3###delkind###删除物资分类###
    public function delkind(){
        $this->title('删除物资分类');

        $db = M('material_kind');
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
        $this->success('删除成功！', U('Material/kind'));
    }


    // @@@NODE-3###addkind###添加修改物资分类###
    public function addkind() {
        $this->title('添加/修改物资分类');

        $db = M('material_kind');
        $pid  = I('pid', 0);

        $id = I('id',0);
        if ($pid <= 0) {
            $father = array();
            $father['level'] = 0;
            $father['id'] = 0;
            $father['name'] = '顶级分类';

        } else {
            $father = M('material_kind')->find($pid);
        }

        $this->father = $father;

        if(isset($_POST['dosubmit'])){

            $info = I('info','');

            if(!$id){
                $isadd = $db->add($info);
                if($isadd) {
                    $this->success('添加成功！',U('Material/kind'));
                } else {
                    $this->error('添加失败：' . $db->getError());
                }
            }else{
                $isedit = $db->data($info)->where(array('id'=>$id))->save();
                if($isedit) {
                    $this->success('修改成功！',U('Material/kind'));
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
                    $this->error('无此数据！', U('Material/kind'));
                }
            }
            $this->display('addkind');
        }
    }


    // @@@NODE-3###kind###物资分类列表###
    public function kind() {
        $this->title('项目分类');

        $this->lists = get_material_kinds();
        $this->pages = '';
        $this->display('kind');
    }






	// @@@NODE-3###purchase_record###物资采购记录###
	public function purchase_record(){

		$where = array();

		$db = M('material_purchase_batch');

		$id = trim(I('id'));
		$oid = trim(I('oid'));
		$dep = I('dep');

		$where = array();
		if($id)   $where['id'] = $id;
		if($oid)  $where['order_id'] = array('like','%'.$oid.'%');
		if($dep)  $where['department'] = $dep;

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
		foreach($lists as $k=>$v){
			$lists[$k]['total'] = M('material_purchase')->where(array('batch_id'=>$v['id']))->sum('total');
		}

		$this->lists = $lists;
		$this->rolelist = M('role')->where(array('id'=>array('gt',3)))->Getfield('id,role_name',true);
		$this->display('material_purchase');
	}


	// @@@NODE-3###purchase###物资采购申请###
	public function purchase(){

		$db = M('material_purchase');
		$id = I('id',0);

		if (isset($_POST['dosubmit'])) {

			$info = I('info');
			$referer = I('referer');
			$material = I('material');
			if($info && $material){
				$info['create_time'] = time();
				$batch = $info;
				$count = count($material);
				if($count>1){
					$batch['name'] = $material[0]['material'].'等'.$count.'种物资';
				}else{
					$batch['name'] = $material[0]['material'];
				}
				$batch['app_user']    = cookie('nickname');
				$batch_id = M('material_purchase_batch')->add($batch);
				if($batch_id){
					$this->request_audit(P::REQ_TYPE_GOODS_PURCHASE, $batch_id);
					foreach($material as $k=>$v){
						$data = array_merge($info,$v);
						$data['batch_id'] = $batch_id;
						$data['app_user'] = cookie('nickname');
						//获取物资信息
						$db->add($data);
					}
					$this->success('申请已提交！',$referer);
				}else{
					$this->error('申请失败' . $db->getError());
				}

			}

		}else{

			$this->row = $db->find($id);
			$this->material = M('material')->select();
			$this->rolelist = M('role')->where(array('id'=>array('gt',3)))->select();

			//物料关键字
			$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>0))->select();
			if($key) $this->keywords =  json_encode($key);

			$this->display('purchase');
		}
	}



	// @@@NODE-3###purchase_viwe###物资采购申请单###
	public function purchase_viwe(){
		$db = M('material_purchase_batch');

		$id = I('id');

		$this->bumen = M('role')->where(array('id'=>array('gt',3)))->Getfield('id,role_name',true);
		$this->row = M('material_purchase_batch')->find($id);
		$material = M('material_purchase')->where(array('batch_id'=>$id))->select();
		$this->material = $material;
		$this->display('purchase_viwe');
	}



	// @@@NODE-3###addasset###新增固定资产###
    public function addasset(){
		$db = M('material');
		$id = I('id');

		if (isset($_POST['dosubmit'])) {

			$PinYin = new Pinyin();
			$info = I('info');
			$referer = I('referer');

			//名称转拼音
			$material = iconv("utf-8","gb2312",trim($info['material']));
			$info['pinyin'] = strtolower($PinYin->getFirstPY($material));
			if($id){
				$isok = $db->data($info)->where(array('id'=>$id))->save();
			}else{
				if(!$db->where(array('material'=>trim($info['material'])))->find()){
					$info['asset'] = 1;
					$isok = $db->add($info);
				}else{
					 $this->error('资产已存在，无需重复添加' . $db->getError());
				}
			}

			if($isok){
				 $this->success('保存成功！',$referer);
			}else{
				 $this->error('保存失败' . $db->getError());
			}

		}else{
			$this->row = $db->find($id);
			$this->material_type = C('MATERIAL_TYPE');
			$this->material_class = M('material_kind')->select();
			$this->display('addasset');
		}


    }


	// @@@NODE-3###asset###固定资产###
	public function asset(){


		$where = array();

		$db = M('material');
		$keywords = I('keywords');
		$type     = I('kind');

		$where = array();
		$where['asset'] = 1;
		if($keywords) $where['material'] = array('like','%'.$keywords.'%');
		if($type)     $where['kind']     = $type;

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();
		foreach($lists as $k=>$v){
			//最新出库日期
			$m_out  = M('material_out')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('out_time DESC')->find();
			$lists[$k]['out_time'] = $m_out['out_time'];
			//最新入库日期
			$m_into = M('material_into')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('into_time DESC')->find();
			$lists[$k]['into_time'] = $m_into['into_time'];
			$lists[$k]['price'] = $m_into['unit_price']? '&yen; '.$m_into['unit_price'] : '';
		}

		$this->material = M('material')->select();
		$this->material_type = C('MATERIAL_TYPE');
		$this->material_class = M('material_kind')->select();
		$material_class = M('material_kind')->select();
		foreach($material_class as $v){
			$kind[$v['id']] = $v['name'];
		}
		//物料关键字
		$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>1))->select();
		if($key) $this->keywords =  json_encode($key);
		$this->kind = $kind;
		$this->lists = $lists;
		$this->display('asset');
	}



	// @@@NODE-3###asset_in_record###固定资产入库记录###
	public function asset_in_record(){

		$where = array();

		$db = M('material_into');

		$material = trim(I('material'));
		$where = array();
		$where['asset'] = 1;
		if($material){
			$where['material_id'] = $material;
			$this->material_id = $material;
		}

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('into_time'))->select();

		$this->lists = $lists;
		$rolelist = M('role')->where(array('id'=>array('gt',3)))->select();
		$bumen = array();
		foreach($rolelist as $v){
			$bumen[$v['id']] = $v['role_name'];
		}

		$this->material = M('material')->select();

		$this->rolelist = $bumen;
		$this->display('asset_in_record');
	}


	// @@@NODE-3###asset_in###固定资产入库###
	public function asset_in(){

		$db = M('material_into');
		$id = I('id',0);

		if (isset($_POST['dosubmit'])) {

			$info = I('info');
			$referer = I('referer');
			$material = trim(I('material'));
			$info['into_time'] = time();
			$info['asset'] = 1;

			if($info['amount'] && $info['amount']>=1){
				//获取物资信息
				$m = M('material')->field('id,material,stock')->where(array('material'=>$material))->find();
				$info['material_id'] = $m['id'];
				$info['material'] = $material;
				$isok = $db->add($info);
				if($isok){
					 $this->request_audit(P::REQ_TYPE_GOODS_IN, $isok);
					 $this->success('申请已提交！',$referer);
				}else{
					 $this->error('申请失败' . $db->getError());
				}
			}else{
				 $this->error('请填写入库数量' . $db->getError());
			}

		}else{


			$this->row = M('material')->find($id);

			$this->rolelist = M('role')->where(array('id'=>array('gt',3)))->select();

			//物料关键字
			$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>1))->select();
			if($key) $this->keywords =  json_encode($key);

			$this->display('asset_in');
		}
	}


	// @@@NODE-3###asset_in###固定资产领用###
	public function asset_out(){
		$db = M('material_out');
		$id = I('id',0);

		if (isset($_POST['dosubmit'])) {

			$info = I('info');
			$referer = I('referer');
			$material = trim(I('material'));
			$info['out_time'] = time();
			$info['asset'] = 1;
			if($info['amount'] && $info['amount']>=1){
				//获取物资信息
				$m = M('material')->field('id,material,stock')->where(array('material'=>$material))->find();
				$info['material_id'] = $m['id'];
				$info['material'] = $material;
				$isok = $db->add($info);
				if($isok){
					 $this->request_audit(P::REQ_TYPE_GOODS_OUT, $isok);
					 $this->success('申请已提交！',$referer);
				}else{
					 $this->error('申请失败' . $db->getError());
				}
			}else{
				 $this->error('请填写领用数量' . $db->getError());
			}

		}else{

			$row =  M('material')->find($id);
			if($row && $row['asset']==1){

				//获取入库记录
				$into =  M('material_into')->where(array('type'=>0,'material_id'=>$id))->order('into_time DESC')->find();
				$this->price = sprintf("%.2f",  $into['unit_price'] / $row['stages']);
			}



			//物料关键字
			$key =  M('material')->field('id,pinyin,material')->where(array('asset'=>1))->select();
			if($key) $this->keywords =  json_encode($key);

			$this->row = $row;
			$this->display('asset_out');
		}


	}


	// @@@NODE-3###asset_out_record###固定资产领用记录###
	public function asset_out_record(){

		$material = trim(I('material'));

		$where = array();
		$where['asset'] = 1;
		if($material){
			$where['material_id'] = $material;
			$this->material_id = $material;
		}

		$db = M('material_out');

		//分页
		$pagecount = $db->where($where)->count();
		$page = new Page($pagecount, P::PAGE_SIZE);
		$this->pages = $pagecount>P::PAGE_SIZE ? $page->show():'';

		$lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('id'))->select();

		$this->lists = $lists;
		$rolelist = M('role')->where(array('id'=>array('gt',3)))->select();
		$bumen = array();
		foreach($rolelist as $v){
			$bumen[$v['id']] = $v['role_name'];
		}
		$this->rolelist = $bumen;
		$this->display('asset_out_record');
	}

    /*//集中采购执行率-采购主管 KPI
    public function public_focus_buy(){
        $this->title('集中采购执行率');
        $year                               = I('year',date('Y'));
        $month                              = I('month',date('m'));
        $month                              = strlen($month) < 2 ? str_pad($month,2,'0',STR_PAD_LEFT) : $month;
        $yearMonth                          = $year.$month;
        $cycle                              = get_cycle($yearMonth);

        $lists                              = get_timely(4);

        $this->lists                        = $lists;
        $this->year                         = $year;
        $this->month                        = $month;
        $this->display('focus_buy');
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
    }*/


}
