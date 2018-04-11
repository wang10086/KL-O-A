<?php
namespace Main\Controller;
use Think\Controller;
use Sys\P;


class ExportController extends BaseController {
	

	
	/*导出物资清单*/
	public function material(){
		
		$db = M('material');

		$where = array();
		$where['asset'] = 0;
		
		$data = array();
        $mk = M('material_kind')->getField('id,name',true);
		$lists = $db->field('id,material,kind,stock,price,stages')->where($where)->order($this->orders('id'))->select();
		foreach($lists as $k=>$v){
			$data[$k]['id'] = $v['id'];
			$data[$k]['material'] = $v['material'];
			$data[$k]['kind'] = $mk[$v['kind']];
			$data[$k]['stock'] = $v['stock'];
			$data[$k]['price'] = $v['price'];
			$data[$k]['total'] = sprintf("%.2f", $v['price']*$v['stock']);
			$data[$k]['stages'] = $v['stages'];
			//最新出库日期
			$m_out  = M('material_out')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('out_time DESC')->find();
			$data[$k]['out_time'] = $m_out['out_time'] ? date('Y-m-d H:i:s',$m_out['out_time']) : '';
			//最新入库日期
			$m_into = M('material_into')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('into_time DESC')->find();
			$data[$k]['into_time'] = $m_into['into_time'] ? date('Y-m-d H:i:s',$m_into['into_time']) : '';
		}	
			 
		$title = array('物资编号','物资名称','物资类型','当前库存','最近入库价','金额','分期','最新出库时间','最近入库时间');
		
		exportexcel($data,$title,'物资库存'.date('YmdHis'));
		
    }
	
	
	/*导出预算数据*/
	public function budget(){
		
		$opid = I('opid');
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$budget       = M('op_budget')->where(array('op_id'=>$opid))->find();
		$budget['xz'] = explode(',',$budget['xinzhi']);	
		
		if(!$budget || $budget['audit_status']!=1 ) $this->error('预算未审批通过');	
		
		$op           = M('op')->where($where)->find();
		$costcc       = M('op_costacc')->field('title,unitcost,amount,total')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();

		$filename = $op['group_id'].'预算表';
		
		$data = array();
		$data['B2']   = $op['group_id'];  //团号
		$data['F2']   = $op['customer'];  //客户单位
		$data['J2']   = $op['sale_user'];  //销售人员
		$data['L2']   = '';  //研发人员
		$data['B3']   = $op['days'];  //天数
		$data['D3']   = '';  //成人人数
		$data['F3']   = '';  //儿童人数
		$data['H3']   = $budget['renshu'];  //合计人数
		$data['J3']   = '';  //免费人数
		$data['L3']   = $budget['maolilv'];  //毛利率
		
		
		$i = 6;
		$j = 1;
		foreach($costcc as $k=>$v){
			$data['A'.$i]  = $j;  //编号
			$data['B'.$i]  = $v['title'];  //费用项
			$data['E'.$i]  = $v['amount'];  //数量
			$data['F'.$i]  = $v['unitcost'];  //单价
			$data['G'.$i]  = $v['total'];  //合计
			$i++;
			$j++;
		}
		
		if($j<=30){
			$data['B37'] = $budget['budget'];  //合计成本价格
			$data['G37'] = $budget['shouru'];  //合计报价
			$data['K37'] = $budget['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/yusuan_30.xls';
		}else if($j>30 && $j<=60){
			$data['B67'] = $budget['budget'];  //合计成本价格
			$data['G67'] = $budget['shouru'];  //合计报价
			$data['K67'] = $budget['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/yusuan_60.xls';
		}else if($j>60){
			$data['B107'] = $budget['budget'];  //合计成本价格
			$data['G107'] = $budget['shouru'];  //合计报价
			$data['K107'] = $budget['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/yusuan_100.xls';
		}

        model_exportexcel($data,$filename,$model);
		
	}
	
	
	
	
	/*导出结算数据*/
    public function settlement(){

        $opid = I('opid');
        if(!$opid) $this->error('项目不存在');

        $where = array();
        $where['op_id'] = $opid;

        $settlement       = M('op_settlement')->where(array('op_id'=>$opid))->find();

        if(!$settlement || $settlement['audit_status']!=1 ) $this->error('结算未审批通过');

        $op           = M('op')->where($where)->find();
        $costacc         = M('op_costacc')->field('title,unitcost,amount,total,remark')->where(array('op_id'=>$opid,'status'=>2))->order('id')->select();

        $filename = $op['group_id'].'结算表';


        $data = array();
        $data['B2']   = $op['group_id'];  //团号
        $data['E2']   = $op['customer'];  //客户单位
        $data['J2']   = $op['sale_user'];  //销售人员
        $data['L2']   = '';  //研发人员
        $data['B3']   = $op['days'];  //天数
        $data['D3']   = '';  //成人人数
        $data['F3']   = '';  //儿童人数
        $data['H3']   = $op['number'];  //合计人数
        $data['J3']   = '';  //免费人数
        $data['L3']   = $settlement['maolilv'];  //毛利率

        $data['B5']   = '';  //报价
        $data['D5']   = $settlement['renshu'];  //实际人数
        $data['F5']   = $settlement['shouru'];  //实际应收款项
        $data['J5']   = '';  //备注

        $i = 8;
        $j = 1;
        foreach($costacc as $k=>$v){
            //$data['A'.$i]  = $j;  //编号
            $data['A'.$i]  = $v['title'];  //费用项
            $data['C'.$i]  = $v['amount'];  //数量
            $data['D'.$i]  = $v['unitcost'];  //单价
            $data['E'.$i]  = $v['total'];  //合计
            $data['k'.$i]  = $v['remark'];  //备注
            $i++;
            $j++;
        }

        if($j<=30){
            $data['B39'] = $settlement['budget'];  //合计成本价格
            $data['F39'] = $settlement['shouru'];  //合计报价
            $data['K39'] = $settlement['maoli'];  //合计毛利润
            $model = 'admin/assets/xls/jiesuan_30.xls';
        }else if($j>30 && $j<=60){
            $data['B69'] = $settlement['budget'];  //合计成本价格
            $data['F69'] = $settlement['shouru'];  //合计报价
            $data['K69'] = $settlement['maoli'];  //合计毛利润
            $model = 'admin/assets/xls/jiesuan_60.xls';
        }else if($j>60){
            $data['B109'] = $settlement['budget'];  //合计成本价格
            $data['F109'] = $settlement['shouru'];  //合计报价
            $data['K109'] = $settlement['maoli'];  //合计毛利润
            $model = 'admin/assets/xls/jiesuan_100.xls';
        }

        model_exportexcel($data,$filename,$model);

    }

	/*public function settlement(){
		
		$opid = I('opid');
		if(!$opid) $this->error('项目不存在');	
		
		$where = array();
		$where['op_id'] = $opid;
		
		$settlement       = M('op_settlement')->where(array('op_id'=>$opid))->find();
		
		if(!$settlement || $settlement['audit_status']!=1 ) $this->error('结算未审批通过');	
		
		$op           = M('op')->where($where)->find();
		$costacc         = M('op_costacc')->field('title,unitcost,amount,total')->where(array('op_id'=>$opid,'status'=>2))->order('id')->select();
		
		$filename = $op['group_id'].'结算表';
		
		
		$data = array();
		$data['B2']   = $op['group_id'];  //团号
		$data['E2']   = $op['customer'];  //客户单位
		$data['J2']   = $op['sale_user'];  //销售人员
		$data['L2']   = '';  //研发人员
		$data['B3']   = $op['days'];  //天数
		$data['D3']   = '';  //成人人数
		$data['F3']   = '';  //儿童人数
		$data['H3']   = $op['number'];  //合计人数
		$data['J3']   = '';  //免费人数
		$data['L3']   = $settlement['maolilv'];  //毛利率
		
		$data['B5']   = '';  //报价
		$data['D5']   = $settlement['renshu'];  //实际人数
		$data['F5']   = $settlement['shouru'];  //实际应收款项
		$data['J5']   = '';  //备注
		
		$i = 8;
		$j = 1;
		foreach($costacc as $k=>$v){
			//$data['A'.$i]  = $j;  //编号
			$data['A'.$i]  = $v['title'];  //费用项
			$data['E'.$i]  = $v['amount'];  //数量
			$data['F'.$i]  = $v['unitcost'];  //单价
			$data['G'.$i]  = $v['total'];  //合计
			$i++;
			$j++;
		}
		
		if($j<=30){
			$data['B39'] = $settlement['budget'];  //合计成本价格
			$data['F39'] = $settlement['shouru'];  //合计报价
			$data['K39'] = $settlement['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/jiesuan_30.xls';
		}else if($j>30 && $j<=60){
			$data['B69'] = $settlement['budget'];  //合计成本价格
			$data['F69'] = $settlement['shouru'];  //合计报价
			$data['K69'] = $settlement['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/jiesuan_60.xls';
		}else if($j>60){
			$data['B109'] = $settlement['budget'];  //合计成本价格
			$data['F109'] = $settlement['shouru'];  //合计报价
			$data['K109'] = $settlement['maoli'];  //合计毛利润
			$model = 'admin/assets/xls/jiesuan_100.xls';
		}
		
        model_exportexcel($data,$filename,$model);
		
	}*/
	
	
	
	//导出结算统计表
	public function chart_settlement(){
		
		$db = M('op_settlement');
		$kind = M('project_kind')->GetField('id,name',true);
		
		//获取月份和部门
		$st    = I('st',0);
		$et    = I('et',0);
		$xs    = I('xs');
		$dept  = I('dept',0);
		
		$yue   = I('month');
		$moon  = month_phase($yue);
		
		$where = array();
		$where['b.audit'] = 1;
		if($st && $et){
			$where['b.create_time'] = array('between',array(strtotime($st),strtotime($et)));	
			$this->onmoon    = $st.'至'.$et.'结算报表';
		}else if($st){
			$where['b.create_time'] = array('gt',strtotime($st));		
			$this->onmoon    = $st.'之后结算报表';
		}else if($et){
			$where['b.create_time'] = array('lt',strtotime($et));	
			$this->onmoon    = $et.'之前结算报表';	
		}else if($yue){
			$where['b.create_time'] = array('between',array($moon['start'],$moon['end']));
			$this->onmoon    = date('Y年m月份',$moon['start']).'结算报表';
		}else{
			$this->onmoon    = '结算报表';	
		}
		if($xs)   $where['o.create_user_name'] = array('like','%'.$xs.'%');
		if($dept) $where['o.create_user'] = array('in',Rolerelation($dept,1));
		
		$expdata  = array();
		$datalist = $db->table('__OP_SETTLEMENT__ as b')->field('b.*,o.kind,o.op_create_user,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->where($where)->order('b.create_time DESC')->select();
		foreach($datalist as $k=>$v){
			$title    = array();
			//部门
			$title[] = '部门';
			$expdata[$k]['op_create_user'] = $v['op_create_user'];
			
			//销售
			$title[] = '销售';
			$expdata[$k]['create_user_name'] = $v['create_user_name'];
			
			//计调
			$title[] = '计调';
			$jd = M('op_record')->where(array('op_id'=>$v['op_id'],'explain'=>'保存成本核算'))->order('id DESC')->find();
			$expdata[$k]['jidiao'] = $jd['uname'];
			
			//类型
			$title[] = '类型';
			$expdata[$k]['leixing'] = $kind[$v['kind']];
			
			//团号
			$title[] = '团号';
			$expdata[$k]['group_id'] = $v['group_id'];
			
			//项目名称
			$title[] = '项目名称';
			$expdata[$k]['project'] = $v['project'];
			
			//客户性质
			$title[] = '客户性质';
			$ys = M('op_budget')->where(array('op_id'=>$v['op_id']))->find();
			$expdata[$k]['xinzhi'] = $ys['xinzhi'];
			
			//人数
			$title[] = '人数';
			$expdata[$k]['renshu'] = $v['renshu'];
			
			//收入
			$title[] = '收入';
			$expdata[$k]['shouru'] = $v['shouru'];
			
			//毛利
			$title[] = '毛利';
			$expdata[$k]['maoli'] = $v['maoli'];
			
			//毛利率
			$title[] = '毛利率';
			$expdata[$k]['maolilv'] = $v['maolilv'];
			
			//人均毛利
			$title[] = '人均毛利';
			$expdata[$k]['renjunmaoli'] = $v['renjunmaoli'];
			
			//结算时间
			$title[] = '结算时间';
			$expdata[$k]['create_time'] = date('Y-m-d',$v['create_time']);
			
		}
		
		
		exportexcel($expdata,$title,'结算统计表'.date('YmdHis'));
		
	}
	
	
	
	public function chart_finance(){
		
		$db = M('op_settlement');
		
		//获取月份和部门
		$st    = I('st',0);
		$et    = I('et',0);
		$xs    = I('xs');
		$dept  = I('dept',0);
		
		$yue   = I('month');
		$moon  = month_phase($yue);
		
		$where = array();
		$where['b.audit'] = 1;
		$where['l.req_type']	= 801;
		if($st && $et){
			$where['l.audit_time'] = array('between',array(strtotime($st),strtotime($et)));	
			$this->onmoon    = $st.'至'.$et.'结算报表';
		}else if($st){
			$where['l.audit_time'] = array('gt',strtotime($st));		
			$this->onmoon    = $st.'之后结算报表';
		}else if($et){
			$where['l.audit_time'] = array('lt',strtotime($et));	
			$this->onmoon    = $et.'之前结算报表';	
		}else if($yue){
			$where['l.audit_time'] = array('between',array($moon['start'],$moon['end']));
			$this->onmoon    = date('Y年m月份',$moon['start']).'结算报表';
		}else{
			$this->onmoon    = '结算报表';	
		}
		if($xs)   $where['o.create_user_name']	= array('like','%'.$xs.'%');
		if($dept) $where['a.group_role']		= array('like','%['.$dept.']%');
		
		
		
		$expdata  = array();
		$datalist = $db->table('__OP_SETTLEMENT__ as b')->field('b.*,o.project,o.group_id,o.number,o.customer,o.create_user_name,o.destination,o.days,o.remark,l.audit_time')->join('__OP__ as o on b.op_id = o.op_id','LEFT')->join('__AUDIT_LOG__ as l on l.req_id = b.id','LEFT')->join('__ACCOUNT__ as a on a.id = o.create_user','LEFT')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('l.audit_time DESC')->select();
		foreach($datalist as $k=>$v){
			
			$title    = array();
			//团号
			$title[] = '团号';
			$expdata[$k]['group_id'] = $v['group_id'];
			
			
			//线路名称
			$title[] = '线路名称';
			$expdata[$k]['name'] = $v['name'];
			
			//实际人数
			$title[] = '实际人数';
			$expdata[$k]['renshu'] = $v['renshu'];
			
			//目的地
			$title[] = '目的地';
			$expdata[$k]['destination'] = $v['destination'];
			
			//天数
			$title[] = '天数';
			$expdata[$k]['days'] = $v['days'];
			
			/*
			//人数
			$title[] = '人数';
			$expdata[$k]['number'] = $v['number'];
			*/
			
			//团款
			$title[] = '结算收入';
			$expdata[$k]['shouru'] = $v['shouru'];
			
			//税前毛利
			$title[] = '结算毛利';
			$expdata[$k]['maoli'] = $v['maoli'];
			
			/*
			//税后毛利
			$title[] = '税后毛利';
			$expdata[$k]['shuihou'] = $v['maoli'] -  sprintf("%.2f", ($v['maoli']*0.06));
			*/
			
			//销售人员
			$title[] = '销售人员';
			$expdata[$k]['create_user_name'] = $v['create_user_name'];
			
			//结算时间
			$title[] = '结算时间';
			$expdata[$k]['create_time'] = date('Y-m-d',$v['create_time']);
			
			
		}
		
		exportexcel($expdata,$title,'财务结算统计表'.date('YmdHis'));
		
	}

    /*导出人员列表*/
    public function member(){

        $opid = I('opid');
        if(!$opid) $this->error('项目不存在');

        $where = array();
        $where['op_id'] = $opid;

        /*$settlement       = M('op_settlement')->where(array('op_id'=>$opid))->find();

        if(!$settlement || $settlement['audit_status']!=1 ) $this->error('结算未审批通过');*/

        $op           = M('op')->where($where)->find();
        $member       = M('op_member')->where(array('op_id'=>$opid))->select();

        $filename = $op['group_id'].'人员名单表';


        $data = array();
        $data['B2']   = $op['group_id'];  //团号
        $data['E2']   = $op['customer'];  //客户单位
        $data['J2']   = $op['number'];  //合计人数

        $i = 4;
        $j = 1;
        foreach($member as $k=>$v){
            //$data['A'.$i]  = $j;  //编号
            $data['A'.$i]  = $v['name'];  //姓名
            $data['C'.$i]  = $v['sex'];  //性别
            $data['D'.$i]  = $v['number'];  //证件号
            $data['E'.$i]  = $v['ecname'];  //家长姓名
            $data['F'.$i]  = $v['ecmobile'];  //家长电话
            $data['G'.$i]  = $v['remark'];  //备注
            $i++;
            $j++;
        }

        if($j<=30){
            $model = 'admin/assets/xls/member_30.xls';
        }else if($j>30 && $j<=60){
            $model = 'admin/assets/xls/member_60.xls';
        }else if($j>60){
            $model = 'admin/assets/xls/member_100.xls';
        }

        model_exportexcel($data,$filename,$model);

    }
	
}
	