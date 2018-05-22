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
class AjaxController extends Controller {
	
	public function material(){
		
		$db = M('material_into');
		
		$keywords = I('keywords');
		
		if($keywords){
			$data = $db->field('unit_price as cost')->where(array('material'=>$keywords,'audit_status'=>1))->order('into_time DESC')->find();
			$mate = M('material')->field('id,stock')->where(array('material'=>$keywords))->find();
			$data['stock'] = $mate['stock'];
			$data['id'] = $mate['id'];
			
			echo  json_encode($data);
		}
		
	}
    
	
	public function userkey(){
		//整理关键字
		$role = M('role')->GetField('id,role_name',true);
		$user =  M('account')->select();
		$key = array();
		foreach($user as $k=>$v){
			
			$text = $v['nickname'].'-'.$role[$v['roleid']];
			
			$key[$k]['id']         = $v['id'];
			$key[$k]['user_name']  = $v['nickname'];
			$key[$k]['pinyin']     = strtopinyin($text);
			$key[$k]['text']       = $text;
			$key[$k]['role']       = $v['roleid'];
			$key[$k]['role_name']  = $role[$v['roleid']];
			//$key[$k]['post']       = $post;
		}
		
		echo json_encode($key);	
	}
   
  	
	
	public function customer(){
		
		$nm = I('nm');
		
		$db = M('customer_gec');
		
		$where = array();
		$where['cm_name']  = $nm;
		
        $lists = $db->where($where)->select();
		
		$html = '';
		foreach($lists as $k=>$v){
			
			$html .= '<tr>';
			$html .= '<td><input type="checkbox" checked name="gec[]" value="'.$v['id'].'"></td>';
			$html .= '<td>'.$v['id'].'</td>';
			$html .= '<td>'.$v['company_name'].'</td>';
			$html .= '<td>'.$v['type'].'</td>';
			$html .= '<td>'.$v['contacts'].'</td>';
			$html .= '<td>'.$v['contacts_tel'].'</td>';
			$html .= '<td>'.$v['province'].'-'.$v['city'].'-'.$v['county'].'</td>';
			$html .= '<td>'.$v['qianli'].'</td>';
			$html .= '<td>'.$v['level'].'</td>';
			$html .= '</tr>';
			
		}
		
		echo $html;	
	}
    
	
	// @@@NODE-3###updatekpi###更新KPI数据###
	public function updatekpi(){
		
		$month  = I('month','');
		$user   = I('uid',cookie('userid'));
		
		if($month && $user){
			updatekpi($month,$user);
			$this->success('获取完毕!');
		}else{
			$this->error('请求数据不正确');			
		}
		
	}
	
	
	
	// @@@NODE-3###getop###获取项目数据###
	public function getop(){
		
		$gid	= I('gid','');
		
		$where	= array();
		$where['o.group_id']	= trim($gid);
		
		$op = M()->table('__OP__ as o')->field('o.*,s.renshu,s.shouru')->join('__OP_SETTLEMENT__ as s on s.op_id = o.op_id','LEFT')->where($where)->find();
		
		echo json_encode($op,true);
		
	}

	//工单管理获取当前worder_dept工单项信息
    public function dept(){
        $id             = I('id');
        $data           = M('worder_dept')->where("id = '$id'")->find();
        if ($data['type'] == 0){$data['type_res'] = '成熟产品';}
        if ($data['type'] == 1){$data['type_res'] = '新产品';}
        if ($data['type'] == 2){$data['type_res'] = '定制产品';}
        $this->ajaxReturn($data,"JSON");
    }

    //工单获取所有的用户组信息
    public function member(){
        $id             = I('id');
        $ids            = array_unique(M('worder_dept')->getfield("dept_id",true));
        $depts          = M('worder_dept')->field('id,dept_id,pro_title')->where("dept_id = '$id'")->select();
        if (in_array($id,$ids)){
            $this->ajaxReturn($depts,"JSON");
        }else{
            echo 0;
        }
    }

    //获取所有的学科领域信息
    public function fields(){
        $id             = I('id');
        $data           = M('op_field')->where("k_id = '$id'")->select();
        $this->ajaxReturn($data,"JSON");

    }

    //获取学科分类
    public function types(){
        $kid            = I('kid');
        $fid            = I('fid');
        if ($fid){
            $data       = M('op_type')->where(array('f_id'=>$fid))->select();
        }else{
            $data       = M('op_type')->where(array('k_id'=>$kid))->select();
        }
        $this->ajaxReturn($data,"JSON");
    }

    //立项
    public function line_or_lession(){
        $id             = I('id');
        $db             = M('project_kind');
        $lession_db     = M('op_lession');
        $field_db       = M('op_field');
        $line_db        = M('product_line');
        $line           = $db->where("id='1' or pid='1'")->getField('id',true);
        $cgly           = M('project_kind')->where("name like '%常规旅游%'")->getField('id',true); //从'其他'栏目中提取 '常规旅游'放入线路中
        $lines          = array_merge($line,$cgly);
        $lession        = $db->where("id='2' or pid='2'")->getField('id',true);
        if (in_array($id,$lines)){
            $data['line'] = $line_db->field("id,title")->where(array('kind'=>$id))->select();
            $data['type'] = 1;
            $this->ajaxReturn($data,"JSON");
        }elseif (in_array($id,$lession)){
            //$data['lession'] = $lession_db->field('id,name')->where(array('kind_id'=>$id))->select();
            $data['field'] = $field_db->field('id,fname')->where(array('k_id'=>$id))->select();
            $data['type']    = 2;
            $this->ajaxReturn($data,"JSON");
        }
    }

    public function lession(){
        $db             = M('op_lession');
        $fid            = I('fid');
        $tid            = I('tid');
        if ($tid){
            $data       = $db->field('id,name')->where(array('type_id'=>$tid))->select();
        }else{
            $data       = $db->field('id,name')->where(array('field_id'=>$fid))->select();
        }
        $this->ajaxReturn($data,"JSON");
    }

    public function gui_price(){
        $db             = M('guide_pricekind');
        $pk_id          = I('kid');
        $data           = $db->where(array('pk_id'=>$pk_id))->select();
        $this->ajaxReturn($data,'JSON');
    }

    public function get_gpk(){
        $opid           = I('opid');
        $data           = M('guide_pricekind as gp')->field('gp.id,gp.name')->join("left join __OP__ as op on op.op_id = $opid")->where("op.kind = gp.pk_id")->select();
        $this->ajaxReturn($data,'JSON');
    }

    public function getPrice(){
        $opid           = I('opid');
        $guide_kind_id  = I('guide_kind_id');
        $gpk_id         = I('gpk_id');
        $kind_id        = M('op')->where(array('op_id'=>$opid))->getField('kind');
        $priceinfo      = M('guide_price')->field('id,price')->where(array('gk_id'=>$guide_kind_id,'kid'=>$kind_id))->find(); //没有详细分类从guide_price表取数据
        $price_a        = $priceinfo['price'];
        $gp_id          = $priceinfo['id'];
        $price_b        = M('guide_priceinfo')->where(array('guide_price_id'=>$gp_id,'price_kind_id'=>$gpk_id))->getField('price'); //有详细分类从guide_priceinfo表取数据
        if($price_a == '0.00') $price_a = null;
        $price_b = $price_b?$price_b:'0.00';
        $price = $price_a?$price_a:$price_b;
        $this->ajaxReturn($price,'JSON');

    }
}