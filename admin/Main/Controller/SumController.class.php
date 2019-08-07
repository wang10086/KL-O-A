<?php
namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;

class SumController extends Controller {
	
	//月度汇总
	public function month(){
		
		//获取月份开始时间和结束时间时间戳
		$date = I('month',date('Ymd'));
		$month = month_phase($date);
		
		//查询条件
		$where = array('between',array($month['start'],$month['end']));
		
		//统计数据
		$info = array();
		
		//新建项目数
		$info['pro_new_sum']  = M('op')->where(array('create_time'=>$where))->count();
		
		//成团项目数
		$info['pro_trip_sum'] = M('op')->where(array('create_time'=>$where,'status'=>1))->count();
		
		//结算项目数
		$info['pro_settlement_sum'] = M('op_settlement')->where(array('create_time'=>$where,'audit_status'=>1))->count();
		
		//项目总收入
		$pro_income = M('op_settlement')->where(array('create_time'=>$where,'audit_status'=>1))->sum('shouru');
		$info['pro_income'] = $pro_income ? $pro_income : 0;
		
		//项目总支出
		$pro_exp = M('op_settlement')->where(array('create_time'=>$where,'audit_status'=>1))->sum('budget');
		$info['pro_exp'] = $pro_exp ? $pro_exp : 0;
		
		//项目总利润
		$info['pro_profit'] = $info['pro_income']-$info['pro_exp'];
		
		//项目支出明细
		$set       = M('op_settlement')->where(array('create_time'=>$where,'audit_status'=>1))->GetField('op_id',true);
		$set_opid  = array('in',implode(',',$set));
		
		//项目合格供方支出
		$pro_exp_supplier = M('op_costacc')->where(array('type'=>3,'status'=>2,'op_id'=>$set_opid))->sum('total');
		$info['pro_exp_supplier'] = $pro_exp_supplier ? $pro_exp_supplier : 0;
		
		//项目专家辅导员支出
		$pro_exp_guide = M('op_costacc')->where(array('type'=>2,'status'=>2,'op_id'=>$set_opid))->sum('total');
		$info['pro_exp_guide'] = $pro_exp_guide ? $pro_exp_guide : 0;
		
		//项目物资支出
		$pro_exp_material = M('op_costacc')->where(array('type'=>1,'status'=>2,'op_id'=>$set_opid))->sum('total');
		$info['pro_exp_material'] = $pro_exp_material ? $pro_exp_material : 0;
		
		//新增产品模块数量
		$info['add_pro_sum'] = M('product')->where(array('input_time'=>$where))->count();
		
		//新增行程方案数量
		$info['add_line_sum'] = M('product_line')->where(array('input_time'=>$where))->count();
		
		//新增行产品模板数量
		$info['add_model_sum'] = M('product_model')->where(array('input_time'=>$where))->count();
		
		//新增合格供方数量
		$info['add_supplier_sum'] = M('supplier')->where(array('input_time'=>$where))->count();
		
		//新增专家辅导员数量
		$info['add_guide_sum'] = M('guide')->where(array('input_time'=>$where))->count();
		
		//新增政企客户数量
		$info['add_customer_gec_sum'] = M('customer_gec')->where(array('create_time'=>$where))->count();
		
		//新增跟团客户数量
		$info['add_customer_member_sum'] = M('customer_member')->where(array('create_time'=>$where))->count();
		
		//物资采购总支出
		$material_purchase = M('material_into')->where(array('type'=>0,'audit_status'=>1,'into_time'=>$where))->sum('total');
		$info['material_purchase'] = $material_purchase ? $material_purchase : 0;
		
		//判断该月份是否统计过
		if(array_sum($info)){
			$chart = M('month_report')->where(array('month'=>$month['month']))->find();
			if(!$chart){
				$info['month'] = $month['month'];
				$isok = M('month_report')->add($info);	
			}else{
				$isok = M('month_report')->data($info)->where(array('id'=>$chart['id']))->save();	
			}
		}
		if($isok){
			echo 'Save success!';	
		}else{
			echo 'Save failed!';	
		}
		
	}
	
	
	
	
	
	
}
	