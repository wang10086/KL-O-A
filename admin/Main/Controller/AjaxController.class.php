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
		
		$gid	                = I('gid','');
		
		$where	                = array();
		$where['o.group_id']	= trim($gid);

        //$op                   = M()->table('__OP__ as o')->field('o.*,s.renshu,s.shouru')->join('__OP_SETTLEMENT__ as s on s.op_id = o.op_id','LEFT')->where($where)->find();
        $field                  = 'o.id,o.project,o.group_id,o.op_id,o.number,o.departure,o.create_user,o.create_user_name,c.dep_time,c.ret_time,s.renshu,s.shouru';
		$op                     = M()->table('__OP__ as o')->field($field)->join('__OP_TEAM_CONFIRM__ as c on c.op_id=o.op_id','left')->join('__OP_SETTLEMENT__ as s on s.op_id = o.op_id','LEFT')->where($where)->find();
        $op['dep_time']         = $op['dep_time']?date('Y-m-d',$op['dep_time']):'';
        $op['ret_time']         = $op['ret_time']?date('Y-m-d',$op['ret_time']):'';

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
        $guide_id       = I('guide_id');
        $guide_kind_id  = I('guide_kind_id')?I('guide_kind_id'):M('guide')->where(array('id'=>$guide_id))->getField('kind');
        $gpk_id         = I('gpk_id');
        $kind_id        = I('pro_kind')?I('pro_kind'):M('op')->where(array('op_id'=>$opid))->getField('kind');
        $priceinfo      = M('guide_price')->field('id,price')->where(array('gk_id'=>$guide_kind_id,'kid'=>$kind_id))->find(); //没有详细分类从guide_price表取数据
        $price_a        = $priceinfo['price'];
        $gp_id          = $priceinfo['id'];
        $price_b        = M('guide_priceinfo')->where(array('guide_price_id'=>$gp_id,'price_kind_id'=>$gpk_id))->getField('price'); //有详细分类从guide_priceinfo表取数据
        if($price_a == '0.00') $price_a = null;
        $price_b = $price_b?$price_b:'0.00';
        $price = $price_a?$price_a:$price_b;
        $this->ajaxReturn($price,'JSON');

    }

    /*public function get_guide_price(){
        //$opid           = I('opid');
       // $kind_id        = I('pro_kind')?I('pro_kind'):M('op')->where(array('op_id'=>$opid))->getField('kind');    //kind_id
        //$gpk_id         = I('gpk_id');    //$gpk_id
        //$guide_id       = I('guide_id');
       // $guide_kind_id  = I('guide_kind_id')?I('guide_kind_id'):M('guide')->where(array('id'=>$guide_id))->getField('kind');
        $priceinfo      = M('guide_price')->field('id,price')->where(array('gk_id'=>$guide_kind_id,'kid'=>$kind_id))->find(); //没有详细分类从guide_price表取数据
        $price_a        = $priceinfo['price'];
        $gp_id          = $priceinfo['id'];
        $price_b        = M('guide_priceinfo')->where(array('guide_price_id'=>$gp_id,'price_kind_id'=>$gpk_id))->getField('price'); //有详细分类从guide_priceinfo表取数据
        if($price_a == '0.00') $price_a = null;
        $price_b = $price_b?$price_b:'0.00';
        $price = $price_a?$price_a:$price_b;
        $this->ajaxReturn($price,'JSON');
    }*/

    public function get_tcs_need(){
        $opid       = I('op_id');
        $confirm_id = I('confirm_id');
        $lists      = M()->table('__OP_GUIDE_CONFIRM__ as c')->join('left join __OP_GUIDE_PRICE__ as p on p.confirm_id = c.id')->where(array('p.op_id'=>$opid,'c.op_id'=>$opid,'c.id'=>$confirm_id))->select();
        $a = M()->getlastsql();

        $this->ajaxReturn($lists,'JSON');
    }
    public function department(){//职位 判断
        $name               = $_POST['name'];
        $post               = $_POST['post'];
        $substrr            = mb_substr($post,-5,4,"UTF-8");
        $substr             = mb_substr($post,-4,4,"UTF-8");
        $subst              = mb_substr($post,-3,4,"UTF-8");
        $subs               = mb_substr($post,-2,4,"UTF-8");
        for($i=1;$i<100000;$i++){

            if($substrr == "总经理助理"){
                $count      = $i+3;
            }elseif($substrr !=="总经理助理" && $substr == "副总经理"){
                $count      = $i+1;
            }elseif($substrr !=="总经理助理" && $substr !== "副总经理" && $subst =="总经理"){
                $count      = $i;
            }elseif($substrr !=="总经理助理" && $substr !== "副总经理" && $subst !=="总经理" && $subst =="副经理"){
                $count      = $i+1;
            }elseif($substrr !=="总经理助理" && $substr !== "副总经理" && $subst !=="总经理" && $subst !== "副经理" && $subs == "经理"){

                if($name == 'H'){//资源管理部 and 安全品控部  判断
                    $data   = array('result'=>'0','msg' =>"此职位暂时空置,请联系管理员!");
                    $this->ajaxReturn($data);
//                    return json_encode($date);die;
                }
                $count      = $i;
            }elseif($substrr !=="总经理助理" && $substr !== "副总经理" && $subst !=="总经理" && $subst !== "副经理" && $subs !== "经理" && $subs == "主管"){
                $count      = $i+3;
            }else{
                $count      = $i+4;
            }
            $new_member     = $name.sprintf("%03d",$count);
            $member         = M('account')->where("employee_member='$new_member'")->find();
            if(!$member){
                $data       = array('result'=>'1','msg' =>$new_member);
                //return json_encode($data);die;
                return $this->ajaxReturn($data);
            }
        }
    }

    public function staff(){
        $db                 = M('staff');
        $zan_db             = M('staff_zan');
        $id                 = I('id');
        $good_num           = $db->where(array('id'=>$id))->getField('good_num');

        $info               = array();
        $info['good_num']   = $good_num+1;
        $db->where(array('id'=>$id))->save($info);
        //return $this->ajaxReturn($info['good_num']);
        $data               = array();
        $data['staff_id']   = $id;
        $data['youke']      = cookie('staff_youke');
        $data['zan_time']   = NOW_TIME;
        $res                = $zan_db->add($data);
        if ($res) $this->ajaxReturn($res);
    }


    /**
     * salary_add 添加岗位工资 基效比例
     * $status 1 入职   2 转正 3 调岗 4 离职 5 调薪
     */
    public function salary_add(){
        if(IS_POST){
                $add['type']                    = (int)(code_number(trim($_POST['type'])));
                $add['account_id']              = (int)(code_number(trim($_POST['account_id'])));
            if($add['type'] == 3){
                $aid['id']                      = $add['account_id'];
                $account['departmentid']        = code_number(trim($_POST['department']));//部门
                $account['postid']              = code_number(trim($_POST['posts']));//岗位

                $query                          = M('account')->where($aid)->save($account);
                if(!$query){
                    $sum                        = 0;
                    $msg                        = "信息添加失败!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }

            if($add['type'] == 4){
                $salary['id']                   = $add['account_id'];
                $account['end_time']            = strtotime(trim($_POST['data']));
                $account                        = array_filter($account);

                $query                          = M('account')->where($salary)->save($account);
                if($query){
                    $sum                        = 0;
                    $msg                        = "信息添加失败!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }else{
                    $cont                       = "添加离职信息, 离职日期: ".$_POST['data'];
                    $info                       = salary_info(11,$cont);
                    $sum                        = 1;
                    $msg                        = "恭喜你添加成功!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }

            $add['standard_salary']             = code_number(trim($_POST['standard_salary']));
            $add['basic_salary']                = code_number(trim($_POST['basic_salary']));
            $add['performance_salary']          = code_number(trim($_POST['performance_salary']));
            $add['createtime']                  = time();
            $add                                = array_filter($add);

            $id['account_id']                   = $add['account_id'];
            $salar_r                            = M('salary')->field('id,type,status')->where($id)->order('id desc')->find();
            if($salar_r){

                if(strlen($add['type']) !== 1 || strlen($add['basic_salary'])!==1 || strlen($add['performance_salary'])!==1){
                    $sum = 0;
                    $msg = "数据有误!请查证后提交!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
                if($salar_r['status'] == 1){
                    $id['id']                   = $salar_r['id'];
                    $save['standard_salary']    = $add['standard_salary'];
                    $save['basic_salary']       = $add['basic_salary'];
                    $save['performance_salary'] = $add['performance_salary'];
                    $salary_w                   = M('salary')->where($id)->save($save);
                    $uecont                     = "修改";
                }
                if($salar_r['status'] == 2){
                    $salary_w                   = M('salary')->add($add);
                    $uecont                     = "添加";
                }
            }else{
                $salary_w                       = M('salary')->add($add);
                $uecont                         = "添加";
            }
            if($salary_w){
                if($add['type'] == 1){
                    $cot                        = "入职";
                }
                if($add['type'] == 2){
                    $cot                        = "转正";
                }
                if($add['type'] == 3){
                    $cot                        = "调岗";
                }
                if($add['type'] == 5){
                    $cot                        = "调薪";
                }
                $cont                           = $uecont.$cot."信息: 岗位薪酬=".$add['standard_salary'].";绩效比=".$add['basic_salary'].":".$add['performance_salary'];
                $info                           = salary_info(11,$cont);
                $sum                            = 1;
                $msg                            = "恭喜你".$uecont."成功!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }else{
                $sum                            = 0;
                $msg                            = "您".$uecont."数据失败!请重新".$uecont."!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
        }
    }

    /**
     * salaryattendance 添加考勤录入
     * $account_r 查询工资标准
     * strip_tags 去掉php 和html 标签
     */
    public function salaryattendance(){

        if(IS_POST){
            $user['account_id']         = (int)(code_number(trim($_POST['account_id'])));//用户id
            $add['late1']               = code_number(trim($_POST['late1']));//15分钟以内
            $add['late2']               = code_number(trim($_POST['late2']));//15~2小时以内
            $add['leave_absence']       = code_number(trim($_POST['leave_absence']));//事假
            $add['sick_leave']          = code_number(trim($_POST['sick_leave']));//病假
            $add['absenteeism']         = code_number(trim($_POST['absenteeism']));//矿工
            $add['entry_data']          = trim($_POST['salary_date']);//离职天数
            $add['lowest_wage']         = code_number(trim($_POST['money']));//北京最低工资标准
            $add['year_leave']          = code_number(trim($_POST['year_leave']));//北京最低工资标准;//年假
            $add['createtime']          = time();
            $withdrawing                = code_number(trim($_POST['withdrawing']));//传过来的总价格
            
            $account_r                  = M('salary_attendance')->field('id,status')->where($user)->order('id desc')->find();
            $salary                     = M('salary')->where($user)->order('id desc')->find();

            $add['withdrawing']         = round(($add['late1']*10+$add['late2']*30+($salary['standard_salary']*$salary['basic_salary']/10/21.75)*$add['leave_absence']+(($salary['standard_salary']*$salary['basic_salary']/10)-$add['lowest_wage']*0.8)/21.75*$add['sick_leave']+($salary['standard_salary']*$salary['basic_salary']/10/21.75)*$add['absenteeism']*2+($salary['standard_salary']/21.75*$add['entry_data'])),2);

            if($account_r && $salary){// 15分钟以内 15~2小时以内  事假
                if((int)$account_r['status'] == 1){
                    $id['id']           = $account_r['id'];
                    $cot                = "添加";
                    $account_w          = M('salary_attendance')->where($id)->save($add);
                }
                if((int)$account_r['status'] == 2){
                    $add['account_id']  = $user['account_id'];
                    $cot = "修改";
                    $account_w          = M('salary_attendance')->add($add);
                }
                if(!$account_w){
                    $sum                = 0;
                    $msg                = "考勤添加失败!请重新添加!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }else{
                if($salary){
                    $add['account_id']  = $user['account_id'];
                    $cot                = "添加";
                    $account_w          = M('salary_attendance')->add($add);
                }else{
                    $sum                = 0;
                    $msg                = "考勤数据编辑失败!请先编辑薪酬标准信息!";
                    echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
                }
            }
            if($account_w){
                $cont                   = $cot."考勤信息,扣款：".$add['withdrawing']." （元）" ;
                $info                   = salary_info(12,$cont);
                $sum                    = 1;
                $msg                    = "考勤数据编辑成功!";
                echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
            }
            $sum                        = 0;
            $msg                        = "考勤数据编辑失败!";
            echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
        }
    }


    /**
     *Ajax_subsidy_Query 补贴 |提成
     *$type 1 提成 2 补贴
     * salary_bonus提成
     * salary_subsidy补贴
     */
    public function Ajax_subsidy_Query(){
        $type                               = (int)(code_number(trim($_POST['statu'])));
        $uid['account_id']                  = (int)(code_number(trim($_POST['account_id'])));
        if($type == 1){//提成/奖金
            $where['extract']               = trim($_POST['housing_subsidy']);//带团补助
            $where['bonus']                 = trim($_POST['foreign_subsidies']);//其他人员提成
            $where['annual_bonus']          = trim($_POST['computer_subsidy']);//年终奖
            $where['foreign_bonus']         = trim($_POST['foreign_bonus']);//奖金
            $where['year_end_tax']          = trim($_POST['yearend']);//年终奖计税
            $subsidy_r                      = M('salary_bonus')->where($uid)->order('id desc')->find();
        }
        if($type == 2){//补贴
            $where['housing_subsidy']       = trim($_POST['housing_subsidy']);//住房补贴
            $where['foreign_subsidies']     = trim($_POST['foreign_subsidies']);//外地补贴
            $where['computer_subsidy']      = trim($_POST['computer_subsidy']);//电脑补贴
            $subsidy_r                      = M('salary_subsidy')->where($uid)->order('id desc')->find();
        }

        if($subsidy_r){

            if($subsidy_r['status'] == 1){
                $uid['id']                  = $subsidy_r['id'];
                if($type == 1){$subsidy_W   = M('salary_bonus')->where($uid)->save($where);}
                if($type == 2){$subsidy_W   = M('salary_subsidy')->where($uid)->save($where);}
                $content = "修改";
            }
            if($subsidy_r['status'] == 2){
                $uid['id']                  = $subsidy_r['id'];
                $where['createtime']        = time();
                $where['account_id']        = $uid['account_id'];
                if($type == 1){$subsidy_W   = M('salary_bonus')->add($where);}
                if($type == 2){$subsidy_W   = M('salary_subsidy')->add($where);}
                $content = "添加";
            }
        }else{
            $where['account_id']            = $uid['account_id'];
            $where['createtime']            = time();
            if($type == 1){$subsidy_W       = M('salary_bonus')->add($where);}
            if($type == 2){$subsidy_W       = M('salary_subsidy')->add($where);}
            $content = "添加";
        }

        if($subsidy_W){

            if($type == 1){
                $cont                       = $content."：提成:".$where['extract'].";奖金:".$where['bonus'].";年终:".$where['annual_bonus']." （元）" ;
            }
            if($type == 2){
                $cont                       = $content."：房补:".$where['housing_subsidy'].";外地补:".$where['foreign_subsidies'].";电脑补:".$where['computer_subsidy']." （元）" ;
            }
            $info                           = salary_info(11,$cont);
            $sum                            = 1;
            $msg                            = "编辑数据成功!";
            echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
        }else{
            $sum                            = 0;
            $msg                            = "编辑数据失败!请重新编辑!";
            echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
        }
    }

    /**
     * Ajax_Insurance_Query
     * 举例: company_birth 生育保险 金额 (公司)
     *  birth 生育保险 金额 (个人)
     * $statu 1 调整社保/医保基数 2调整员工社保/公积金比例 3调整员工医保比例
     * 4调整公司社保/公积金比例 5调整公司医保比例
     */
    public function Ajax_Insurance_Query(){

        $statu                                      = (int)(code_number(trim($_POST['statu'])));//状态
        $where['account_id']                        = (int)(code_number(trim($_POST['account_id'])));//用户id
        $injury_base                                = code_number(trim($_POST['injury_base']));
        $pension_base                               = code_number(trim($_POST['pension_base']));
        if($statu == 3){//当状态是3时,有两个值
        }else{
            $accumulation_fund_base                 = code_number(trim($_POST['accumulation_fund_base']));
            if($statu == 5){
                $big_price                          = code_number(trim($_POST['big_price']));
            }
        }
        $this->salary_statu($statu,$where,$injury_base,$pension_base,$accumulation_fund_base,$big_price);

    }

    /**
     * salary_type 五险一金操作历史数据添加
     */
    protected function salary_type($statu,$cont,$add){
        if($statu == 1){//调整社保/医保基数

            $content        = $cont."：生育/工伤/医疗:".$add['birth_base'].";养老/失业:".$add['pension_base'].";公积金:".$add['accumulation_fund_ratio']." （元）" ;

        }
        if($statu == 2){//调整员工社保/公积金比例

            $content        = $cont."：个人养老比例:".$add['pension_ratio'].";个人失业比例:".$add['unemployment_ratio'].";个人公积金比例:".$add['accumulation_fund_care']." （元）" ;

        }
        if($statu == 3){//调整员工社保/公积金比例

            $content        = $cont."：医疗个人比例:".$add['medical_care_ratio'].";大额医疗个人比例:".$add['big_price']. "（元）" ;

        }
        if($statu == 4){//调整员工社保/公积金比例

            $content        = $cont."：公司养老比例:".$add['company_pension_ratio'].";公司失业比例:".$add['company_unemployment_ratio'].";公司公积金比例:".$add['company_accumulation_fund_ratio']." （元）" ;

        }
        if($statu == 5){//调整员工社保/公积金比例

            $content        = $cont."：公司医疗比例:".$add['company_medical_care_ratio'].";公司生育比例:".$add['company_birth_ratio'].";公司工伤比例:".$add['company_injury_ratio'].";公司大额比例:".$add['company_big_price']." （元）" ;

        }
        $info               = salary_info(11,$content);
        $sum                = 1;
        $msg                = $cont."数据成功!";
        echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
    }


    /**
     * salary_statu 五险一金判断是否要更改还是添加
     */
    protected function salary_statu($statu,$where,$injury_base,$pension_base,$accumulation_fund_base,$big_price){
        if($statu == 1){
            $add['birth_base']                      = $injury_base;//生育 基数(个人)
            $add['company_birth_base']              = $injury_base;//生育 基数(公司)
            $add['injury_base']                     = $injury_base;//工伤 基数(个人)
            $add['company_injury_base']             = $injury_base;//工伤 基数(公司)
            $add['medical_care_base']               = $injury_base;//医疗 基数(个人)
            $add['company_medical_care_base']       = $injury_base;//医疗 基数(公司)
            $add['pension_base']                    = $pension_base;//养老 基数(个人)
            $add['company_pension_base']            = $pension_base;//养老 基数(公司)
            $add['unemployment_base']               = $pension_base;//失业 基数(个人)
            $add['company_unemployment_base']       = $pension_base;//失业 基数(公司)
            $add['accumulation_fund_base']          = $accumulation_fund_base;//公积金 基数(个人)
            $add['company_accumulation_fund_base']  = $accumulation_fund_base;//公积金 基数(公司)
        }
        if($statu == 2){
            $add['pension_ratio']                   = $injury_base;//养老 比例(个人)
            $add['unemployment_ratio']              = $pension_base;//失业 比例(个人)
            $add['accumulation_fund_ratio']         = $accumulation_fund_base;//公积金 比例(个人)
        }
        if($statu == 3){
            $add['medical_care_ratio']              = $injury_base;//医疗 比例(个人)
            $add['big_price']                       = $pension_base;//大额医疗 比例(个人)
        }
        if($statu == 4){
            $add['company_pension_ratio']           = $injury_base;//养老 比例(公司)
            $add['company_unemployment_ratio']      = $pension_base;//失业 比例(公司)
            $add['company_accumulation_fund_ratio'] = $accumulation_fund_base;//公积金 比例(公司)
        }
        if($statu == 5){
            $add['company_medical_care_ratio']      = $injury_base;//医疗 比例(公司)
            $add['company_birth_ratio']             = $pension_base;//生育 比例(公司)
            $add['company_injury_ratio']            = $accumulation_fund_base;//工伤 比例(公司)
            $add['company_big_price']               = $big_price;//大额 比例(公司)
        }
        $insurance                                  = M('salary_insurance')->where($where)->order('id desc')->find();

        if($insurance){
            $data                                   = array();
            $data['birth_base']                     = $add['birth_base']?$add['birth_base']:$insurance['birth_base'];
            $data['company_birth_base']             = $add['company_birth_base']?$add['company_birth_base']:$insurance['company_birth_base'];
            $data['injury_base']                    = $add['injury_base']?$add['injury_base']:$insurance['injury_base'];
            $data['company_injury_base']            = $add['company_injury_base']?$add['company_injury_base']:$insurance['company_injury_base'];
            $data['medical_care_base']              = $add['medical_care_base']?$add['medical_care_base']:$insurance['medical_care_base'];
            $data['company_medical_care_base']      = $add['company_medical_care_base']?$add['company_medical_care_base']:$insurance['company_medical_care_base'];
            $data['pension_base']                   = $add['pension_base']?$add['pension_base']:$insurance['pension_base'];
            $data['company_pension_base']           = $add['company_pension_base']?$add['company_pension_base']:$insurance['company_pension_base'];
            $data['unemployment_base']              = $add['unemployment_base']?$add['unemployment_base']:$insurance['unemployment_base'];
            $data['company_unemployment_base']      = $add['company_unemployment_base']?$add['company_unemployment_base']:$insurance['company_unemployment_base'];
            $data['accumulation_fund_base']         = $add['accumulation_fund_base']?$add['accumulation_fund_base']:$insurance['accumulation_fund_base'];
            $data['company_accumulation_fund_base'] = $add['company_accumulation_fund_base']?$add['company_accumulation_fund_base']:$insurance['company_accumulation_fund_base'];
            $data['pension_ratio']                  = $add['pension_ratio']?$add['pension_ratio']:$insurance['pension_ratio'];
            $data['unemployment_ratio']             = $add['unemployment_ratio']?$add['unemployment_ratio']:$insurance['unemployment_ratio'];
            $data['accumulation_fund_ratio']        = $add['accumulation_fund_ratio']?$add['accumulation_fund_ratio']:$insurance['accumulation_fund_ratio'];
            $data['medical_care_ratio']             = $add['medical_care_ratio']?$add['medical_care_ratio']:$insurance['medical_care_ratio'];
            $data['big_price']                      = $add['big_price']?$add['big_price']:$insurance['big_price'];
            $data['company_pension_ratio']          = $add['company_pension_ratio']?$add['company_pension_ratio']:$insurance['company_pension_ratio'];
            $data['company_unemployment_ratio']     = $add['company_unemployment_ratio']?$add['company_unemployment_ratio']:$insurance['company_unemployment_ratio'];
            $data['company_accumulation_fund_ratio']= $add['company_accumulation_fund_ratio']?$add['company_accumulation_fund_ratio']:$insurance['company_accumulation_fund_ratio'];
            $data['company_medical_care_ratio']     = $add['company_medical_care_ratio']?$add['company_medical_care_ratio']:$insurance['company_medical_care_ratio'];
            $data['company_birth_ratio']            = $add['company_birth_ratio']?$add['company_birth_ratio']:$insurance['company_birth_ratio'];
            $data['company_injury_ratio']           = $add['company_injury_ratio']?$add['company_injury_ratio']:$insurance['company_injury_ratio'];
            $data['company_big_price']              = $add['company_big_price']?$add['company_big_price']:$insurance['company_big_price'];
            $data['birth_ratio']                    = $add['birth_ratio']?$add['birth_ratio']:$insurance['birth_ratio'];
            $data['injury_ratio']                   = $add['injury_ratio']?$add['injury_ratio']:$insurance['injury_ratio'];
            if((int)$insurance['status'] ==  1){ //判断能否修改
                $cont                               = "修改";
                $id['id']                           = $insurance['id'];
                $oinsurance_w                       = M('salary_insurance')->where($id)->save($data);
            }
            if((int)$insurance['status'] ==  2){ //添加
                $cont                               = "添加";
                $data['account_id']                 = $where['account_id'];
                $data['createtime']                 = time();
                $oinsurance_w                       = M('salary_insurance')->add($data);
            }
        }else{
            if($statu<6 && 0<$statu){
                $cont                               = "添加";
                $add['account_id']                  = $where['account_id'];
                $add['createtime']                  = time();
                $oinsurance_w                       = M('salary_insurance')->add($add);
            }
        }
        if($oinsurance_w){//添加/修改 成功
            if(!empty($cont)){
                $this->salary_type($statu,$cont,$add);
            }
        }
        $sum                                        = 0;
        $msg                                        = "编辑数据失败!请重新编辑!";
        echo json_encode(array('sum'=>$sum,'msg'=>$msg));die;
    }

    /**
     * withholding_income_add 添加数据和操作记录
     */
    protected function withholding_income_add($table,$add,$conten,$type,$status){
        foreach($add as $k =>$v) {//循环数据
            $str                    = explode(",", $v);//分隔字符串
            $str                    = array_filter($str);//去除空数组空字段
            if($str[0]!=="" && $str[1]!=="" && $str[2]!=="" && $str[0]!=="undefined" && $str[1]!=="undefined" && $str[2]!=="undefined") {
                $add_w              = M($table)->add($v);
                if ($add_w) {
                    if ($status == 1) {
                        $content    = $conten . ":" . $type . "项目名称:" . $v['project_name'] . ";金额:" . $v['money'] . ";（元）";
                    }
                    if ($status == 2) {
                        $content    = $conten . ":" . $type . "项目名称:" . $v['income_name'] . ";金额:" . $v['income_money'] . ";（元）";
                    }
                    $info           = salary_info(11, $content);
                } else {
                    $sum            = 0;
                    $msg            = "编辑数据失败!请重新编辑!";
                    echo json_encode(array('sum' => $sum, 'msg' => $msg));
                    die;
                }
            }
        }
        $sum                        = 1;
        $msg                        = $type."数据成功!";
        echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
    }

    /**
     * withholding_income_addstr 添加数据字段
     */
    protected function withholding_income_addstr($status,$content,$time){
        foreach($content as $key => $val){
            $str                                = explode(",", $val);//分隔字符串
            $str                                = array_filter($str);//去除空数组空字段
            $where['account_id']                = $str[2];
            if($str[0]!=="" && $str[1]!=="" && $str[2]!=="" && $str[0]!=="undefined" && $str[1]!=="undefined" && $str[2]!=="undefined"){
                if($status == 1){//代扣代缴
                    $add[$key]['project_name']  = $str[0]?trim($str[0]):$str[0];
                    $add[$key]['money']         = $str[1]?trim($str[1]):$str[1];
                    $add[$key]['account_id']    = $str[2]?trim($str[2]):$str[2];
                    $add[$key]['token']         = $time.$str[2]?trim($time.$str[2]):$time.$str[2];
                    $add[$key]['createtime']    = time();
                }
                if($status == 2){//其他收入
                    $add[$key]['income_name']   = $str[0]?trim($str[0]):$str[0];
                    $add[$key]['income_money']  = $str[1]?trim($str[1]):$str[1];
                    $add[$key]['account_id']    = $str[2]?trim($str[2]):$str[2];
                    $add[$key]['income_token']  = $time.$str[2]?trim($time.$str[2]):$time.$str[2];
                    $add[$key]['createtime']    = time();
                }
            }
        }
        $table[0]                               = $add;
        $table[1]                               = $where;
        return $table;
    }


    /**
     * Ajax_withholding_income 添加 代扣代缴/其他收入
     * $status 1代扣代缴变动  2其他收入变动
     */
    /*public function Ajax_withholding_income(){
        if(IS_POST){
            $userid                         = I('userid');
            $arr                            = trim($_POST['arr']);//数据数组
            $status                         = (int)(code_number(trim($_POST['status'])));//状态
            $content                        = array_filter(explode("|", $arr));//去除空数组+分隔字符串
            $time                           = time();
            if($status == 1){//代扣代缴状态
                $conten                     = "代扣代缴";
                $table                      =  'salary_withholding';//代扣代缴状态
            }
            if($status == 2) {//其他收入
                $conten                     = "其他收入";
                $table                      = 'salary_income';//其他收入
            }
            $reg                            = $this->withholding_income_addstr($status,$content,$time);
            $add                            = $reg[0];
            $where                          = $reg[1];
            $where['status']                = 1;
            $where['account_id']            = $userid;
            $with                           = M($table)->where($where)->order('id desc')->find();//查询 代扣代缴状态/其他收入
            if($with){
                if ($status == 1) {
                    $save['token']          = trim($with['token']);
                }
                if ($status == 2) {
                    $save['income_token']   = trim($with['income_token']);
                }
                if($with['status'] == 1){
                    $with_add               = M($table)->where($save)->delete();//添加新的数据
                    $cot                    = "修改";
                    if ($with_add) {
                        $this->withholding_income_add($table,$add,$conten,$cot,$status);
                    }else{
                        $sum                = 0;
                        $msg                = "编辑数据失败!请重新编辑!";
                        echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
                    }
                }
                if ($with['status'] == 2) {
                    $cot                    = "添加";
                    $this->withholding_income_add($table,$add,$conten,$cot,$status);
                }
            }else{
                if($status == 1 || $status == 2){
                    foreach($add as $k =>$v) {//循环数据
                        $str                = explode(",", $v);//分隔字符串
                        $str                = array_filter($str);//去除空数组空字段
                        if ($str[0]!=="" && $str[1]!=="" && $str[2]!=="" && $str[0]!=="undefined" && $str[1]!=="undefined" && $str[2]!=="undefined") {
                            $cot            = "添加";
                            $this->withholding_income_add($table, $add, $conten, $cot, $status);
                        }
                    }
                    $sum                    = 0;
                    $msg                    = "编辑数据失败!请重新编辑!";
                    echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
                }
            }
        }
    }*/
    public function Ajax_withholding_income(){
        if(IS_POST){
            $userid                         = I('userid');
            $arr                            = trim($_POST['arr']);//数据数组
            $status                         = (int)(code_number(trim($_POST['status'])));//状态
            $content                        = array_filter(explode("|", $arr));//去除空数组+分隔字符串
            $time                           = time();
            if($status == 1){//代扣代缴状态
                $conten                     = "代扣代缴";
                $table                      =  'salary_withholding';//代扣代缴状态
            }
            if($status == 2) {//其他收入
                $conten                     = "其他收入";
                $table                      = 'salary_income';//其他收入
            }
            $reg                            = $this->withholding_income_addstr($status,$content,$time);
            $add                            = $reg[0];
            $where                          = $reg[1];
            $where['status']                = 1;
            $where['account_id']            = $userid;
            $data                           = array();
            $data['status']                 = 2;
            M($table)->where($where)->save($data);

            foreach($add as $k =>$v) {//循环数据
                $str                = explode(",", $v);//分隔字符串
                $str                = array_filter($str);//去除空数组空字段
                if ($str[0]!=="" && $str[1]!=="" && $str[2]!=="" && $str[0]!=="undefined" && $str[1]!=="undefined" && $str[2]!=="undefined") {
                    $cot            = "添加";
                    $this->withholding_income_add($table, $add, $conten, $cot, $status);
                }
            }
            $sum                    = 0;
            $msg                    = "编辑数据失败!请重新编辑!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;

        }
    }

    public function get_posts(){//获取部门
        $departmentids  = I('departmentids');
        $arr            = array_filter(explode(',',$departmentids));
        $arr            = str_replace('[','',$arr);
        $arr            = str_replace(']','',$arr);
        $db             = M('posts');
        $lists          = $db->field('id,post_name')->where(array('departmentid'=>array('in',$arr)))->select();
        $this->ajaxReturn($lists);
    }

    public function get_this_posts(){//获取部门
        $departmentid   = I('departmentid');
        $db             = M('posts');
        $lists          = $db->field('id,post_name')->where(array('departmentid'=>$departmentid))->select();
        $this->ajaxReturn($lists);
    }

    //保存人事提交数据
    public function Ajax_salary_details_add(){

        $personLists                = json_decode(htmlspecialchars_decode(I('personLists')),true);
        $departmentLists            = json_decode(htmlspecialchars_decode(I('departmentLists')),true);
        $companyLists               = json_decode(htmlspecialchars_decode(I('companyLists')),true);
        $datetime                   = trim(I('datetime'));

        $remsg                      = array();
        if (!in_array(session('userid'),array(1,11,77))){
            $remsg['num']           = 0;
            $remsg['msg']           = '您的权限不足!请联系管理员！';
            $this->ajaxReturn($remsg);
        }
        if (!$datetime){
            $remsg['num']           = 0;
            $remsg['msg']           = '数据错误!';
            $this->ajaxReturn($remsg);
        }

        //保存员工基本工资信息
        $p_num                      = 0;
        $d_num                      = 0;
        $c_num                      = 0;


        foreach ($personLists as $v){
            $v['createtime']        = NOW_TIME;
            $v['status']            = 2;
            $dres                   = M('salary_wages_month')->add($v);

            if ($dres){
                $stu_data           = array();
                $stu_data['status'] = 2;
                M('salary')->where(array('id'=>$v['salary_id']))->save($stu_data); //基本工资 status
                M('salary_attendance')->where(array('id'=>$v['attendance_id']))->save($stu_data); //考勤 status
                M('salary_bonus')->where(array('id'=>$v['bonus_id']))->save($stu_data); //提成/奖金/年终奖 status
                M('individual_tax')->where(array('id'=>$v['individual_id']))->save($stu_data); //个税 status
                M('salary_insurance')->where(array('id'=>$v['insurance_id']))->save($stu_data); //五险一金 status
                M('salary_labour')->where(array('id'=>$v['labour_id']))->save($stu_data); //工会会费 status
                M('salary_specialdeduction')->where(array('id'=>$v['specialdeduction_id']))->save($stu_data); //专项附加扣除 status
                M('salary_subsidy')->where(array('id'=>$v['subsidy_id']))->save($stu_data); //补贴 status
                M('salary_income')->where(array('income_token'=>$v['income_token']))->save($stu_data); //其他收入 status
                M('salary_withholding')->where(array('token'=>$v['withholding_token']))->save($stu_data); //代扣代缴 status
                $p_num++;
            }
        }

        //保存部门合计信息
        foreach ($departmentLists as $v){
            $v['datetime']      = $datetime;
            $v['createtime']    = NOW_TIME;
            $v['status']        = 2;
            $res                = M('salary_departmen_count')->add($v);
            if ($res) $d_num++;
        }

        //保存公司合计信息
        $companyLists['datetime']           = $datetime;
        $companyLists['createtime']         = NOW_TIME;
        $companyLists['examine_user_id']    = session('userid');
        $companyLists['status']             = 2;
        $cres                   = M('salary_count_money')->add($companyLists);
        if ($cres) $c_num++;
        if ($p_num && $d_num && $c_num){
            $remsg['num']       = 1;
            $remsg['msg']       = '保存成功!';
        }else{
            $remsg['num']       = 0;
            $remsg['msg']       = '保存失败!';
        }
        $this->ajaxReturn($remsg);
    }

    //保存提交审核数据(刘金垒)
    /*public function Ajax_salary_details_add(){

        $user_id = $_SESSION['userid'];
        if($user_id==77 || $user_id==1){
        }else{
            $sum                            = 0;
            $msg                            = "您的权限不足!请联系管理员！";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }
        $datetime                           = trim($_POST['datetime']);//表数据时间
        if($datetime=="" || $datetime ==null || $datetime==false){
            $datetime                       = datetime(date('Y'),date('m'),date('d'),1);
        }
        $content                        = trim($_POST['content']);//去除左右空字符 提交申请表数据
        $coutdepartment                 = trim($_POST['coutdepartment']);//去除左右空字符 提交申请表部门数据
        $total                          = trim($_POST['totals_num']);//去除左右空字符 提交申请表所有数据
        $count                          = explode(",",str_replace(array("¥"),"",$content));//去除特殊字符并分隔
        $partment                       = explode(",",str_replace(array("¥"),"",$coutdepartment));//去除特殊字符并分隔
        $tol                            = explode(",",str_replace(array("¥"),"",$total));//去除特殊字符并分隔
        array_pop($count);                array_pop($partment);        array_pop($tol);
        $cont                           = count($count);//计算数量
        $partment_num                   = count($partment);//计算数量
        $pan = M('salary_wages_month')->where('datetime='.$datetime)->find();
        if($pan){
            $sum                        = 0;
            $msg                        = "$datetime!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }
        for($i=0;$i<$cont/42;$i++){//计算没多少条一个数组
            for($num=$i*42;$num<42*$i+42;$num++){//计算分组字段的长度
                $array[$i][$num%42] = $count[$num];//[数组数量][多少条的数据]
            }
        }
        foreach($array as $key => $val){
            trim($val);
            $add['account_id']          = $val[0];      $add['user_name']           = $val[1];      $add['post_name']       = $val[2];      $add['department']          = $val[3];
            $add['standard']            = $val[4];      $add['basic_salary']        = $val[5];      $add['withdrawing']     = $val[6];      $add['performance_salary']  = $val[7];
            $add['Achievements_withdrawing']= $val[8];  $add['total']               = $val[9];      $add['bonus']           = $val[10];     $add['housing_subsidy']     = $val[11];
            $add['Other']               = $val[12];     $add['Should_distributed']  = $val[13];     $add['medical_care']    = $val[14];     $add['pension_ratio']       = $val[15];
            $add['unemployment']        = $val[16];     $add['accumulation_fund']   = $val[17];     $add['insurance_Total'] = $val[18];     $add['tax_counting']        = $val[20];
            $add['personal_tax']        = $val[21];     $add['summoney']            = $val[22];     $add['Labour']          = $val[23];     $add['real_wages']          = $val[24];
            $add['salary_id']           = $val[25];     $add['attendance_id']       = $val[26];     $add['bonus_id']        = $val[27];     $add['income_token']        = $val[28];
            $add['insurance_id']        = $val[29];     $add['subsidy_id']          = $val[30];     $add['withholding_token']= $val[31];    $add['total_score_show']    = $val[32];
            $add['show_qa_score']       = $val[33];     $add['sum_total_score']     = $val[34];     $add['target']          = $val[35];     $add['complete']            = $val[36];
            $add['yearend']             = $val[37];     $add['Subsidy']             = $val[38];     $add['datetime']        = $datetime;    $add['welfare']             = $val[39];
            $add['labour_id']           = $val[40];     $add['specialdeduction_id'] = $val[41];     $add['specialdeduction']= $val[19];
            $add['status']              = 2;            $add['createtime']          = time();
            $add                            = array_filter($add);
            $month = M('salary_wages_month')->add($add);
            if(!$month){
                $sum                        = 0;
                $msg                        = "数据提交失败!请重新提交!";
                echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
            }else{
                $status['status'] = 2;
                $salary_w                   = M('salary')->where(array('id='.$add['salary_id']))->save($status);
                $attendance_w               = M('salary_attendance')->where(array('id='.$add['attendance_id']))->save($status);

                $generate_month             = datetime(date('Y'),date('m'),date('d'),1);//获取当前年月
                $guide_id                   = user_table($add['account_id']);
                $bonus_extract              = Acquisition_Team_Subsidy($generate_month,$guide_id['guide_id']);//带团补助
                $bonussave['status']        = 2;
                $bonussave['extract']       = $bonus_extract;
                $bonus_w                    = M('salary_bonus')->where(array('id='.$add['bonus_id']))->save($bonussave);

                $income_w                   = M('salary_income')->where(array('income_token='.$add['income_token']))->save($status);
                $insurance_w                = M('salary_insurance')->where(array('id='.$add['insurance_id']))->save($status);
                $subsidy_w                  = M('salary_subsidy')->where(array('id='.$add['subsidy_id']))->save($status);
                $labour_w                   = M('salary_labour')->where(array('id='.$add['labour_id']))->save($status);
                $withholding_w              = M('salary_withholding')->where(array('token='.$add['withholding_token']))->save($status);
                $specialdeduction           = M('salary_specialdeduction')->where(array('id'=>$add['specialdeduction_id']))->save($status);
            }
        }
        for($n=0;$n<$partment_num/23;$n++){//计算没多少条一个数组
            for($sum=$n*23;$sum<23*$n+23;$sum++){//计算分组字段的长度
                $arr[$n][$sum%23] = $partment[$sum];//[数组数量][多少条的数据]
            }
        }
        foreach($arr as $k => $v){
            $where['name']           = $v[0]; $where['department']        = $v[1]; $where['standard_salary']= $v[2];    $where['basic']       = $v[3];
            $where['withdrawing']    = $v[4]; $where['performance_salary']= $v[5]; $where['count_money']    = $v[6];    $where['total']       = $v[7];
            $where['bonus']          = $v[8]; $where['housing_subsidy']   = $v[9]; $where['Other']          = $v[10];   $where['Should']      = $v[11];
            $where['care']           = $v[12];$where['pension']           = $v[13];$where['unemployment']   = $v[14];   $where['accumulation']= $v[15];
            $where['insurance_Total']= $v[16];$where['specialdeduction']  = $v[17];$where['tax_counting']   = $v[18];   $where['personal_tax']= $v[19];
            $where['summoney']      = $v[20]; $where['Labour']            = $v[21];$where['real_wages']     = $v[22];   $where['datetime']    = $datetime;
            $where['createtime']    = time(); $where['status']         = 2;
            $depart_tol              = M('salary_departmen_count')->add($where);
            if(!$depart_tol){
                $sum                 = 0;
                $msg                 = "数据提交失败!请重新提交!";
                echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
            }
        }
        $save['name']               = $tol[0]; $save['standard_salary']   = $tol[1];  $save['basic']       = $tol[2];  $save['withdrawing']    = $tol[3];
        $save['performance_salary'] = $tol[4]; $save['count_money']       = $tol[5];  $save['total']       = $tol[6];  $save['bonus']          = $tol[7];
        $save['housing_subsidy']    = $tol[8]; $save['Other']             = $tol[9];  $save['Should']      = $tol[10]; $save['care']           = $tol[11];
        $save['pension']            = $tol[12];$save['unemployment']      = $tol[13]; $save['accumulation']= $tol[14]; $save['insurance_Total']= $tol[15];
        $save['specialdeduction']   = $tol[16];$save['tax_counting']      = $tol[17]; $save['personal_tax']= $tol[18]; $save['summoney']       = $tol[19];
        $save['Labour']             = $tol[20];$save['real_wages']        = $tol[21]; $save['datetime']    = $datetime;
        $save['createtime']         = time();  $save['status']            = 2;
        $save['examine_user_id']    = $user_id;
        $money = M('salary_count_money')->add($save);
        if($money){
            $_SESSION['salary_satus'] = '';
            $sum                    = 1;
            $msg                    = "提交审核成功!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }
        $sum                        = 0;
        $msg                        = "数据提交失败!请重新提交!";
        echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
    }*/

    /**
     * Ajax_salary_sign 签字验证(刘金垒)
     */
    /*public function Ajax_salary_sign(){
        $userid['password']                 = md5(trim($_POST['pwd']));
        $status                             = trim($_POST['status']);
        $userid['user_id']                  = $_SESSION['userid'];
        $datetime                           = trim($_POST['datetime']);
        $sign                               = M('user_sign')->where($userid)->find();
        if($sign){
            if($status==0){
                $add['createtime']          = time();
                $add['submission_user_id']  = $userid['user_id'];
                $add['datetime']            = $datetime;
                $add['submission_status']   = 2;
            }elseif($status==1){
                $add['examine_user_id']     = $userid['user_id'];
                $add['examine_status']      = 2;
            }elseif($status==2){
                $time                       = M('salary_sign')->where('datetime='.$datetime)->delete();
                if($time){
                    echo json_encode(array('sum' => 1));die;
                }else{
                    echo json_encode(array('sum' => 0));die;
                }
            }elseif($status==3){
                $add['approval_user_id']    = $userid['user_id'];
                $add['approval_status']     = 2;
            }
            $time                           = M('salary_sign')->where('datetime='.$datetime)->find();

            if($time){
                $sign1                      = M('salary_sign')->where('id='.$time['id'])->save($add);
            }else{
                $sign1                      = M('salary_sign')->add($add);
            }
            if($sign1){
                echo json_encode(array('sum' => 1));die;
            }else{
                echo json_encode(array('sum' => 0));die;
            }
        }else{
            echo json_encode(array('sum' => 0));die;
        }
    }*/

    //财务审核通过签字（刘金垒）
    /*public function Ajax_salary_details_upgrade(){
        $user_id = (int)$_SESSION['userid'];
        if($user_id==11 ||$user_id==55 || $user_id==1){
        }else{
            $sum                            = 0;
            $msg                            = "您的权限不足!请联系管理员！";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }
        $wages_month_id                     = explode(',',trim($_POST['wages_month_id']));
        $departmen_id                       = explode(',',trim($_POST['departmen_id']));
        $count_money_id                     = trim($_POST['count_money_id']);
        $status ['status']                  = trim($_POST['status']);
        array_pop($wages_month_id);array_pop($departmen_id);
        foreach($wages_month_id as $key =>$val ){
            $id ['id']                      = $val;
            $oa_salary_wages_month          = M('salary_wages_month')->where($id)->save($status);
            //修改个税
            $wages_mont1                    = M('salary_wages_month')->where($id)->find();
            if($wages_mont1 && $user_id==11){
                $user_table                  = M('salary_individual_tax')->where('account_id='.$wages_mont1['account_id'])->order('id DESC')->find();
                if($user_table && $user_table['statu']==1){
                    $save1['statu']         = 2;
                    M('salary_individual_tax')->where('id='.$user_table['id'])->save($save1);
                }
            }
        }
        foreach($departmen_id as $k => $v ){
            $where ['id']                   = $v;
            $departmen_count                = M('salary_departmen_count')->where($where)->save($status);
        }
        if($user_id==11){
            $status['approval_time']        = time();
            $status['approval_user_id']     = $user_id;
        }elseif($user_id==55){
            $status['submission_time']      = time();
            $status['submission_user_id']   = $user_id;
        }
        $count_money                        = M('salary_count_money')->where('id='.$count_money_id)->save($status);
        if($count_money){
            $sum                            = 1;
            $_SESSION['salary_satus']       = '';
            if($user_id==11){$msg = "批准成功!";}elseif($user_id==55){$msg = "提交批准成功!";}
        }else{
            if($user_id==11){$msg = "批准失败!";}elseif($user_id==55){$msg = "提交批准失败!";}
            $sum                            = 0;
        }
        echo json_encode(array('sum' =>1, 'msg' => $msg));die;
    }*/

    //驳回(刘金垒)
    /*
     public function post_error(){
        $datetime['datetime']           = trim($_POST['datetime']);
        $status ['status']              = $_POST['status'];
        $wages_query                    =  M('salary_wages_month')->where($datetime)->select();
        foreach($wages_query as $key => $val){
            $att['id']                  =  $val['attendance_id'];
            $stat['status']             = 1;
            $bonus['id']                = $val['bonus_id'];
            $income['income_token']     = $val['income_token'];
            $labou['id']                = $val['labour_id'];
            $subsid['id']               = $val['subsidy_id'];
            $withh['withholding_token'] = $val['withholding_token'];
            $specialdeduction_id        = $val['specialdeduction_id'];

            if(!empty($att['id'])){
                $table1 = M('salary_attendance')->where($att)->save($stat);
                if(!$table1){}else{}
            }
            if(!empty($bonus['id'])){
                $table2 = M('oa_salary_bonus')->where($bonus)->save($stat);
                if(!$table2){}else{}
            }
            if(!empty($income['income_token'])){
                $table3 = M('oa_salary_income')->where($income)->save($stat);
                if(!$table3){}else{}
            }
            if(!empty($labou['id'])){
                $table4 = M('oa_salary_labour')->where($labou)->save($stat);
                if(!$table4){}else{}
            }
            if(!empty($subsid['id'])){
                $table5 = M('oa_salary_subsidy')->where($subsid)->save($stat);
                if(!$table5){}else{}
            }
            if(!empty($withh['withholding_token'])){
                $table6 = M('oa_salary_withholding')->where($withh)->save($stat);
                if(!$table6){}else{}
            }
            if ($specialdeduction_id){
                M('salary_specialdeduction')->where(array('id'=>$specialdeduction_id))->save($stat);
            }
        }
        $wages_month_del                = M('salary_wages_month')->where($datetime)->delete();
        $departmen_count                = M('salary_departmen_count')->where($datetime)->delete();
        $count_money                    = M('salary_count_money')->where($datetime)->delete();
        if($count_money && $departmen_count && $wages_month_del){
            $sum                        = 1;
            $msg                        = "驳回成功!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }else{
            $sum                        = 0;
            $msg                        = "驳回失败!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }
    }
     */

    /**
     * 工资签字审核
     */
    public function Ajax_salary_sign(){
        $db                                     = M('salary_sign');
        $userid['password']                     = md5(trim($_POST['pwd']));
        $status                                 = trim($_POST['status']);
        $userid['user_id']                      = $_SESSION['userid'];
        $datetime                               = trim($_POST['datetime']);
        $sign                                   = M('user_sign')->where($userid)->find();
        if($sign){
            if ($status==2){ //驳回
                $res                            = $db->where(array('datetime'=>$datetime))->delete();
            }else{ //批准
                $data                           = array();
                if ($status==0){ //人事提交
                    $data['examine_user_id']    = $userid['user_id'];
                    $data['examine_status']     = 2;
                }elseif ($status==1){ //财务审核通过
                    $data['submission_user_id'] = $userid['user_id'];
                }elseif ($status==3){
                    $data['approval_user_id']   = $userid['user_id'];
                }

                $list                           = $db->where(array('datetime'=>$datetime))->find();
                if ($list){
                    $res                        = $db->where(array('datetime'=>$datetime))->save($data);
                }else{
                    $data['createtime']         = NOW_TIME;
                    $data['datetime']           = $datetime;
                    $res                        = $db->add($data);
                }
            }
            if ($res){
                $sum                            = 1;
            }else{
                $sum                            = 0;
            }
        }else{
            $sum                                = 0;
        }
        $this->ajaxReturn($sum);
    }

    //财务审核通过签字
    public function Ajax_salary_details_upgrade(){
        $user_id                        = session('userid');
        $datetime                       = trim(I('datetime'));
        $status                         = trim(I('status'));
        $data                           = array();
        if (!$datetime){
            $data['num']                = 0;
            $data['msg']                = "数据错误";
        }
        if(!in_array($user_id,array(1,11,55))){
            $data['num']                = 0;
            $data['msg']                = "您的权限不足!请联系管理员！";
        }
        $where                          = array();
        $where['datetime']              = $datetime;
        $save                           = array();
        $save['status']                 = $status; //3=>财务审核;4=>总经理审核

        $res1                           = M('salary_wages_month')->where($where)->save($save); //个人
        $res2                           = M('salary_departmen_count')->where($where)->save($save); //部门合计
        if ($status==3){ //财务审核
            $save['submission_user_id'] = session('userid');
            $save['submission_time']    = NOW_TIME;
        }elseif ($status==4){ //总经理审核
            $save['approval_user_id']   = session('userid');
            $save['approval_time']      = NOW_TIME;
        }
        $res3                           = M('salary_count_money')->where($where)->save($save); //公司合计
        $sign                           = array();
        if ($status==3) { //财务审核
            $sign['submission_user_id'] = session('userid');
            $sign['submission_status']  = 2;
        }elseif ($status==4) { //总经理审核
            $sign['approval_user_id']   = session('userid');
            $sign['approval_status']    = 2;
        }
        $res4                           = M('salary_sign')->where(array('datetime'=>$datetime))->save($sign); //签字
        if ($res1 && $res2 && $res3 && $res4){
            $_SESSION['salary_satus']   = '';
            $data['num']                = 1;
            $data['msg']                = "审核成功!";
        }
        $this->ajaxReturn($data);
    }


    /**
     * 驳回
     */
    public function post_error(){
        $datetime['datetime']           = trim($_POST['datetime']);
        $status ['status']              = $_POST['status'];
        $lists                          =  M('salary_wages_month')->where($datetime)->select();
        $arr_attendance_ids             = array_column($lists,'attendance_id'); //考勤
        $arr_bonus_ids                  = array_column($lists,'bonus_id'); //提成/奖金/年终奖
        $arr_individual_ids             = array_column($lists,'individual_id'); //个税
        //$arr_insurance_ids              = array_column($lists,'insurance_id'); //五险一金
        //$arr_labour_ids                 = array_column($lists,'labour_id'); //工会会费
        //$arr_specialdeduction_ids       = array_column($lists,'specialdeduction_id'); //专项附加扣除
        //$arr_subsidy_ids                = array_column($lists,'subsidy_id'); //补贴(住房/电脑/外地补贴)
        //$arr_withholding_tokens         = array_column($lists,'withholding_token'); //代扣代缴
        //$arr_income_tokens              = array_column($lists,'income_token'); //其他收入

        $stu_data                       = array();
        $stu_data['status']             = 1;
        M('salary_attendance')->where(array('id'=>array('in',$arr_attendance_ids)))->save($stu_data); //考勤
        M('salary_bonus')->where(array('id'=>array('in',$arr_bonus_ids)))->save($stu_data); //提成/奖金/年终奖
        M('individual_tax')->where(array('id'=>array('in',$arr_individual_ids)))->save($stu_data); //个税
        //M('salary_insurance')->where(array('id'=>array('in',$arr_insurance_ids)))->save($stu_data); //五险一金
        //M('salary_labour')->where(array('id'=>array('in',$arr_labour_ids)))->save($stu_data); //工会会费
        //M('salary_specialdeduction')->where(array('id'=>array('in',$arr_specialdeduction_ids)))->save($stu_data); //专项附加扣除
        //M('salary_subsidy')->where(array('id'=>array('in',$arr_subsidy_ids)))->save($stu_data); //补贴
        //M('salary_withholding')->where(array('token'=>array('in',$arr_withholding_tokens)))->save($stu_data); //代扣代缴
        //M('salary_income')->where(array('income_token'=>array('in',$arr_income_tokens)))->save($stu_data); //其他收入

        $wages_month_del                = M('salary_wages_month')->where($datetime)->delete();
        $departmen_count                = M('salary_departmen_count')->where($datetime)->delete();
        $count_money                    = M('salary_count_money')->where($datetime)->delete();
        $sign_res                       = M('salary_sign')->where($datetime)->delete();
        $data                           = array();
        if($count_money && $departmen_count && $wages_month_del & $sign_res){
            $data['num']                        = 1;
            $data['msg']                        = "驳回成功!";
        }else{
            $data['num']                        = 0;
            $data['msg']                        = "驳回失败!";
        }

        //系统消息
        $uid     = cookie('userid');
        $title   = '您的'.$datetime['datetime'].'月的系统工资被'.cookie('nickname').'驳回，请及时处理!';
        $content = '您的'.$datetime['datetime'].'月的系统工资被'.cookie('nickname').'驳回，请及时处理!';
        $url     = U('Salary/salary_excel_list',array('datetime'=>$datetime['datetime']));
        $user    = 77; //王茜
        $roleid  = '';
        send_msg($uid,$title,$content,$url,$user,$roleid);

        $this->ajaxReturn($data);
    }

    public function salary_list_Labour(){//添加工会会费

        $where['account_id']                = code_number(trim(I('uid')));
        $Labour_money                       = trim(I('money'));
        $status                             = trim(I('status'));
        if($status==1){$cot = "合并计税";}elseif($status==2){$cot = "工会会费";}
        if(empty($Labour_money)){
            $sum                            = 0;
            $msg                            = "添加".$cot."失败!";
            echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
        }else{
            $where['status']                = 1;
            $Labour                         = M('salary_labour')->where($where)->find();
            if($Labour){
                $id['id']                   = $Labour['id'];
                if($status==1){
                    $save['merge_counting'] = $Labour_money;
                    $save['Labour_money']   = $Labour['Labour_money'];
                }elseif($status==2){
                    $save['merge_counting'] = $Labour['merge_counting'];
                    $save['Labour_money']   = $Labour_money;
                }
                $Labour_w                   =  M('salary_labour')->where($id)->save($save);

                if($Labour_w){
                    $sum                    = 1;
                    $msg                    = "修改".$cot."成功!";
                    $cot = $cot.' : '.$Labour_money;
                    salary_info(11,$cot);
                    echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
                }
            }else{
                $list                       = M('salary_labour')->where(array('account_id'=>I('uid'),'status'=>2))->find();
                if($status==1){
                    $where['merge_counting'] = $Labour_money;
                    $where['Labour_money']   = $list['Labour_money']?$list['Labour_money']:0;
                }elseif($status==2){
                    $where['Labour_money']   = $Labour_money;
                    $where['merge_counting'] = $list['merge_counting']?$list['merge_counting']:0;
                }
                $where['createtime']        = time();

                $add                        =  M('salary_labour')->add($where);
                if($add){
                    $cot = $cot.' : '.$Labour_money;
                    salary_info(11,$cot);
                    $sum                    = 1;
                    $msg                    = "修改".$cot."成功!";
                    echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
                }else{
                    $sum                    = 0;
                    $msg                    = "添加".$cot."失败!";
                    echo json_encode(array('sum' => $sum, 'msg' => $msg));die;
                }
            }
        }
    }

    /**
     * create_file 创建文件
     * $file_name 文件名称 $file_date 审批天数
     * $status 1 新建 2 修改
     * $file_user 用户名称  $textarea 文件描述
     */
     function create_file(){
         $file['createtime']        = time();
         $file['account_id']        = $_SESSION['userid'];
         $file['account_name']      = trim($_POST['file_user']);
         $file['file_primary']      = trim($_POST['file_name']);
         $file['file_describe']     = trim($_POST['textarea']);
         $file['file_date']         = trim($_POST['file_date']);
         $file['category']          = trim($_POST['status']);
         $user                      = user_table($file['account_id']);
         $file                      = array_filter($file);
         if(empty($file['account_name'])){
             echo json_encode(array('sum' => 0, 'msg' => "创建失败!请完善后提交"));die;
         }
         if(!empty($file['file_describe'])){
             $file['file_describe'] = htmlspecialchars($file['file_describe']);
         }
         $add                       = M('approval_flie')->add($file);
         if($add){
             echo json_encode(array('sum' => 1, 'msg' =>"创建成功!"));die;
         }else{
             echo json_encode(array('sum' => 0, 'msg' => "创建失败!请完善后提交！"));die;
         }
    }

    /**
     * Ajax_file_delete 删除选中的文件
     * $fileid 文件id
     */
    function Ajax_file_delete(){

        $arr                    = array("11", "55", "77", "32","38","1","12","13");
        if(in_array($_SESSION['userid'],$arr)){
        }else{
            echo json_encode(array('sum' => 0, 'msg' => "删除失败！您没有权限删除！"));die;
        }
        $status                 = trim($_POST['status']);
        $fileid                 = trim($_POST['fileid']);
        $file_id                = array_filter(explode(',',$fileid));
        foreach($file_id as $key => $val){
            $save['type']       = 2;
            if($status==1){
                $approval_flie  = M('approval_flie')->where('id='.$val)->save($save);
            }elseif($status==2){
                $approval_flie  = M('approval_flie_url')->where('id='.$val)->save($save);
            }
        }
    }

    /**
     *printing_content 打印
     * $time 打印数据的工资表时间
     * $moneyid 工资表 id
     */
    function printing_content(){
        $time                       = code_number(trim($_POST['time']));
        $moneyid                    = trim($_POST['moneyid']);
        $money                      = M('salary_count_money')->where('id='.$moneyid)->find();
        if($money){
            $botton['status']       = 2; //没有提交和审核批准人
            $url1                   = M('user_sign')->where('user_id='.$money['examine_user_id'])->find();
            $url2                   = M('user_sign')->where('user_id='.$money['submission_user_id'])->find();
            $url3                   = M('user_sign')->where('user_id='.$money['approval_user_id'])->find();
            $botton['submitter_url']= $url1['file_url'];
            $botton['examine_url']  = $url2['file_url'];
            $botton['approval_url'] = $url3['file_url'];
            $botton['content']      = '制表日期 : ';
            $botton['time']         = date('Y-m-d H:i:s',$money['approval_time']);
        }else{
            $botton['status']       = 1; //没有提交和审核批准人
            $botton['submitter']    = $_SESSION['name'];
            $botton['content']      = '打印日期 : ';
            $botton['time']         = date('Y-m-d H:i:s',time());
        }
        echo json_encode(array('sum'=>1, 'msg'=>$botton));die;
    }

    //人民币小写转换成大写
    function numTrmb(){
        $num    = I('num');
        $d = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖");
        $e = array('元', '拾', '佰', '仟', '万', '拾万', '佰万', '仟万', '亿', '拾亿', '佰亿', '仟亿');
        $p = array('分', '角');
        $zheng = "整";
        $final = array();
        $inwan = 0;//是否有万
        $inyi = 0;//是否有亿
        $len = 0;//小数点后的长度
        $y = 0;
        $num = round($num, 2);//精确到分
        if(strlen($num) > 15){
            return "金额太大";
            die();
        }
        if($c = strpos($num, '.')){//有小数点,$c为小数点前有几位
            $len=strlen($num)-strpos($num,'.')-1;//小数点后有几位数
        }else{//无小数点
            $c = strlen($num);
            $zheng = '整';
        }
        for($i = 0; $i < $c; $i++){
            $bit_num = substr($num, $i, 1);
            if ($bit_num != 0 || substr($num, $i + 1, 1) != 0) {
                @$low = $low . $d[$bit_num];
            }
            if ($bit_num || $i == $c - 1) {
                @$low = $low . $e[$c - $i - 1];
            }
        }
        if($len!=1){
            for ($j = $len; $j >= 1; $j--) {
                $point_num = substr($num, strlen($num) - $j, 1);
                @$low = $low . $d[$point_num] . $p[$j - 1];
            }
        }else{
            $point_num = substr($num, strlen($num) - $len, 1);
            $low=$low.$d[$point_num].$p[$len];
        }
        $chinses = str_split($low, 3);//字符串转化为数组
        for ($x = count($chinses) - 1; $x >= 0; $x--) {
            if ($inwan == 0 && $chinses[$x] == $e[4]) {//过滤重复的万
                $final[$y++] = $chinses[$x];
                $inwan = 1;
            }
            if ($inyi == 0 && $chinses[$x] == $e[8]) {//过滤重复的亿
                $final[$y++] = $chinses[$x];
                $inyi = 1;
                $inwan = 0;
            }
            if ($chinses[$x] != $e[4] && $chinses[$x] !== $e[8]) {
                $final[$y++] = $chinses[$x];
            }
        }
        $newstr = (array_reverse($final));
        $nstr = join($newstr);
        if((substr($num, -2, 1) == '0') && (substr($num, -1) <> 0)){
            $nstr = substr($nstr, 0, (strlen($nstr) -6)).'零'. substr($nstr, -6, 6);
        }
        $nstr=(strpos($nstr,'零角')) ? substr_replace($nstr,"",strpos($nstr,'零角'),6) : $nstr;
        $nstr = (substr($nstr,-3,3)=='元') ? $nstr . $zheng : $nstr;
        $this->ajaxReturn($nstr);
    }


    //检查该团是否已创建合同
    public function get_contract(){
        $group_id               = trim(I('gid'));
        $data                   = array();
        $op                     = M('op')->where(array('group_id'=>$group_id))->getField('op_id,project');
        if (!$op){
            $data['stu']        = 1;
            $data['msg']        = '暂无该团信息';
            $this->ajaxReturn($data);
        }
        $contract               = M()->table('__CONTRACT__ as c')->field('c.*')->join('__OP__ as o on o.op_id = c.op_id')->where(array('o.group_id'=>$group_id))->find();
        if ($contract){
            $data['stu']        = 2;
            $data['msg']        = '该项目合同已存在';
        }
        $this->ajaxReturn($data);
    }

    //检查用户签字密码
    public function check_pwd(){
        $pwd            = I('pwd');
        $password       = md5($pwd);
        $res            = M('user_sign')->where(array('user_id'=>cookie('userid'),'password'=>$password))->find();
        $data            = array();
        if ($res){
            if ($res['file_url']){
                $data['stu']        = 1;
                $data['message']    = '获取数据成功';
                $data['file_url']   = $res['file_url'];
            }else{
                $data['stu'] = 2;
                $data['message']    = '签字信息有误';
                $data['file_url']   = '';
            }
        }else{
            $data['stu']        = -1;
            $data['message']    = '账号和密码信息不匹配';
            $data['file_url']   = '';
        }

        $this->ajaxReturn($data);
    }

    //获取部门名称
    public function get_department(){
        $id         = I('department_id');
        $department = M('salary_department')->where(array('id'=>$id))->getField('department');
        $this->ajaxReturn($department);
    }

    public function get_opid(){
        $group_id   = I('group_id');
        $opid       = M('op')->where(array('group_id'=>$group_id))->getField('op_id');
        $this->ajaxReturn($opid);
    }

    //查询该团是否有借款信息
    public function has_jiekuan(){
        $op_id          = I('opid');
        $id             = I('id');
        $count          = M('jiekuan')->where(array('op_id'=>$op_id))->count();
        $data           = array();
        if ($count ==0){
            $data['msg']= '真的要删除吗？';
        }else{
            $data['msg']= "<span class='red'>该团有过借款信息</span><br/>你确定要删除该团吗?";
        }
        $data['url']    = U('Op/delpro',array('id'=>$id));
        $this->ajaxReturn($data);
    }

    //查询预算列表
    public function get_yslist(){
        $group_id       = trim(I('group_id'));
        $op             = M('op')->where(array('group_id'=>$group_id))->find();
        $opid           = $op['op_id'];
        $data           = array();
        if ($op){
            //$list               = M('op_costacc')->field('id,op_id,title,unitcost,amount,total as ctotal,remark')->where(array('op_id'=>$opid,'status'=>1))->order('id')->select();
            $list               = M('op_budget')->where(array('op_id'=>$opid,'audit_status'=>1))->find();
            if ($list){
                $data['status'] = 1;
                $data['msg']    = $opid;
            }else{
                $data['status'] = -2;
                $data['msg']    = '暂无预算信息';
            }
        }else{
            $data['status']     = -1;
            $data['msg']        = '团号输入有误';
        }

        $this->ajaxReturn($data);
    }

    /**
     * get_salary_content 工资生成 个人计税
     *  $individual_tax 个人计税金额 $uid 用户id
     */
    public function get_salary_content(){
        $individual_tax             = trim(I('individual_tax'));//个人计税金额
        $account_id                 = trim(I('uid'));//用户
        $datetime                   = trim(I('datetime'));//保存年月
        $info                       = array();
        $info['individual_tax']     = $individual_tax;//个人计税金额
        $info['account_id']         = $account_id;//用户
        $info['createtime']         = time();//创建时间
        $info['datetime']           = $datetime;//保存年月
        $where                      = array();
        $where['account_id']        = $account_id;//用户
        $where['datetime']          = $datetime;//保存年月
        $where['status']            = array('eq',1);
        $list                       = M('salary_individual_tax')->where($where)->order('id DESC')->find();
        if($list){
            $res                    = M('salary_individual_tax')->where('id='.$list['id'])->save($info);
        }else{
            $res                    = M('salary_individual_tax')->add($info);
        }
        $data                       = array();
        if($res){
            $data['num']            = 1;
            $data['msg']            = '保存数据成功！';
        }else{
            $data['num']            = 0;
            $data['msg']            = '保存数据失败！请重新保存数据！';
        }
        $this->ajaxReturn($data);
    }

    //批量确认报销单
    public function batch_sure(){
        M()->startTrans();          //开启事务
        $bxids                      = I('bxids');
        if (!$bxids) $msg           = '请选择报销单信息';
        $bxids                      = explode(',',$bxids);
        $db                         = M('baoxiao');
        $audit_db                   = M('baoxiao_audit');
        $bx_data                    = array();
        $bx_data['audit_status']    = 1;
        $res                        = $db->where(array('id'=>array('in',$bxids)))->save($bx_data);
        if ($res){
            $data                   = array();
            $data['cw_audit_userid']= cookie('userid');
            $data['cw_audit_username']= cookie('nickname');
            $data['cw_audit_file']  = M('user_sign')->where(array('user_id'=>cookie('userid')))->getField('file_url');
            $data['cw_audit_status']= 1;
            $data['cw_audit_time']  = NOW_TIME;
            $save                   = $audit_db->where(array('bx_id'=>array('in',$bxids)))->save($data);
            if ($save){
                M()->commit();      //提交
                $msg                = '操作成功';

                foreach ($bxids as $v){
                    $bxd_id          = $db->where(array('id'=>$v))->getField('bxd_id');
                    $record = array();
                    $record['bill_id']  = $bxd_id;
                    $record['type']     = 2;
                    $record['explain']  = '财务主管审核报销申请单，报销单号：'.$bxd_id.'，审核结果：审核通过';
                    jkbx_record($record);
                }

            }else{
                M()->rollback();    //回滚
                $msg                = '操作失败';
            }

        }else{
            $msg                = '操作失败';
        }

        $this->ajaxReturn($msg);
    }

    //保存专项附加扣除
    public function save_spacialDeduction(){
        $num                                = 0;
        $userid                             = I('uid');
        $nickname                           = trim(I('nickname'));
        $info                               = I('info');
        $db                                 = M('salary_specialdeduction');
        if ($userid){
            $where                          = array();
            $where['account_id']            = $userid;
            $info['account_id']             = $userid;
            $info['account_name']           = $nickname;
            $list                           = $db->where($where)->order('id desc')->find();
            if ($list && $list['status']==1){
                $res                        = $db->where(array('id'=>$list['id']))->save($info);
            }else{
                $res                            = $db->add($info);
            }
            $content                        = '编辑'.$nickname.'专项扣除';

            if ($res){
                $num++;

                //保存操作记录
                salary_info(11,$content);
            }
        }
        $this->ajaxReturn($num);
    }

    //获取报销单类型
    public function get_bxd_kind(){
        $pid                                = I('bxdkind');
        $db                                 = M('bxd_kind');
        $data                               = $db->field('id,name')->where(array('pid'=>$pid))->select();
        $this->ajaxReturn($data);
    }

    //获取KPI季度月份
    public function get_kpi_info(){
        $cycle                              = I('cycle');
        $year                               = I('year');
        $month                              = I('month');
        if (strlen($month) <2) $month       = str_pad($month,2,'0',STR_PAD_LEFT);
        $kpi_month                          = $this->kpi_info($year,$month,$cycle);
        $this->ajaxReturn($kpi_month);
    }

    /** 求考核周期开始及结束时间
     * @param $year     年
     * @param $month    月份
     * @param $cycle    考核周期
     */
    public function kpi_info($year,$month,$cycle){
        $data                   = array();
        if ($cycle==1){ //月度
            $yearmonth          = $year.$month;
            $times              = get_cycle($yearmonth);
            $data['beginTime']  = date('Y-m-d',$times['begintime']);
            $data['endTime']    = date('Y-m-d',$times['endtime']);
            $data['yearMonths'] = $yearmonth;
        }elseif ($cycle==2){    //季度
            $times              = getQuarterlyCicle($year,$month);
            $data['beginTime']  = date('Y-m-d',$times['begin_time']);
            $data['endTime']    = date('Y-m-d',$times['end_time']);
        }elseif ($cycle==3){    //半年度
            $times              = get_half_year_cycle($year,$month);
            $data['beginTime']  = date('Y-m-d',$times['beginTime']);
            $data['endTime']    = date('Y-m-d',$times['endTime']);
        }elseif ($cycle==4){    //年度
            $times              = get_year_cycle($year);
            $data['beginTime']  = date('Y-m-d',$times['beginTime']);
            $data['endTime']    = date('Y-m-d',$times['endTime']);
        }
        return $data;
    }

    //获取满意度二维码
    public function get_code(){
        header("Content-type: text/html; charset=utf-8");
        $url_info               = I('url_info');
        $change                 = array('&amp;'=>'&');
        $url_info               = strtr($url_info,$change);
        $QR_Code                = QR_code($url_info);
        $this->ajaxReturn($QR_Code);
        $this->ajaxReturn($QR_Code,'json');
    }

    //获取预算信息
    public function get_plans_manage(){
        $db                     = M('manage_input');
        $year                   = trim(I('year'));
        $type                   = trim(I('type'));
        $department             = trim(I('department'));
        $where                  = array();
        $where['datetime']      = $year;
        $where['type']          = $type;
        $where['logged_department'] = $department;
        $where['statu']         = array('in',array(1,3)); //1=>未审核, 3=>审核不通过
        $list                   = $db->where($where)->find();
        $this->ajaxReturn($list);
    }

    //获取季度考核KPI周期信息
    public function get_crux_kpi_cycle(){
        $user_id                = I('user_id');
        $year                   = I('year');
        $where                  = array();
        $where['user_id']       = $user_id;
        $where['year']          = $year;
        $where['quota_id']      = 216; //上级领导组织对本季度关键事项绩效评价
        $cycle                  = M('kpi_more')->where($where)->order('id desc')->getField('cycle');
        $select_html            = $this->get_select_html($year,$cycle);
        $msg                    = array();
        $msg['cycle']           = $cycle;
        $msg['select']          = $select_html;
        $this->ajaxReturn($msg);
    }

    //获取select内容
    public function get_select_html($year,$cycle){
        if ($cycle == 1){ //月度考核
            $html               = '<label>考核周期<span class="red">（月度）</span></label><select class="form-control" name="info[month]" onchange="get_crux_remainder_weight($(this).val())"> <option value="" disabled selected>请选择</option>';
            for ($i=1;$i<13;$i++){
                $mon            = str_pad($i,2,0,STR_PAD_LEFT);
                $ym             = $year.$mon;
                $html           .= '<option value="'.$ym.'">'.$i.'月</option>';
            }
            $html               .= '</select>';
        }elseif ($cycle==2){ //季度考核
            $q1                 = $year.'01,'.$year.'02,'.$year.'03';
            $q2                 = $year.'04,'.$year.'05,'.$year.'06';
            $q3                 = $year.'07,'.$year.'08,'.$year.'09';
            $q4                 = $year.'10,'.$year.'11,'.$year.'12';
            $html               = '<label>考核周期<span class="red">（季度）</span></label><select class="form-control" name="info[month]" onchange="get_crux_remainder_weight($(this).val())">';
            $html               .= '<option value="" disabled selected>请选择</option>';
            $html               .= '<option value="'.$q1.'">一季度</option>';
            $html               .= '<option value="'.$q2.'">二季度</option>';
            $html               .= '<option value="'.$q3.'">三季度</option>';
            $html               .= '<option value="'.$q4.'">四季度</option>';
            $html               .= '</select>';
        }
        return $html;
    }

    //获取剩余的权重分
    public function get_crux_remainder_weight(){
        $db                     = M('kpi_crux');
        $user_id                = I('user_id');
        $month                  = I('month');
        $id                     = I('id');
        $where                  = array();
        $where['user_id']       = $user_id;
        $where['month']         = $month;
        $weight                 = $db->where($where)->sum('weight'); //当月合计已用权重
        if ($id){
            $this_id_weight     = $db->where(array('id'=>$id,'month'=>$month))->getField('weight');
            $this_id_weight     = $this_id_weight?$this_id_weight:0; //本条记录权重
            $remainder_weight   = 100 - $weight + $this_id_weight;
        }else{
            $remainder_weight   = 100 - $weight;
        }
        $this->ajaxReturn($remainder_weight);
    }

    //检查当前人员部门是否有自己的计调
    public function check_has_jd(){
        //有自己计调的部门
        $has_jd_department      = array(6,12); //6=>京区业务中心;12=>南京项目部
        $user_id                = session('userid');
        $department_id          = M('account')->where(array('id'=>$user_id))->getField('departmentid');
        if (in_array($department_id,$has_jd_department)){
            $res                = 1; //有
        }else{
            $res                = 0; //无
        }
        $this->ajaxReturn($res);
    }

    //检查当前人员部门是否有自己的研发
    public function check_has_yf(){
        //有自己研发的部门
        $has_jd_department      = array(6,12); //6=>京区业务中心;12=>南京项目部
        $user_id                = session('userid');
        $department_id          = M('account')->where(array('id'=>$user_id))->getField('departmentid');
        if (in_array($department_id,$has_jd_department)){
            $res                = 1; //有
        }else{
            $res                = 0; //无
        }
        $this->ajaxReturn($res);
    }

    /**
     * 检查人员信息
     * (防止模糊匹配后有误再次更改名字而不点击下拉框)
     */
    public function check_userinfo(){
        $account_id             = I('account_id');
        $account_name           = trim(I('account_name'));
        $db                     = M('account');
        if ($account_id){
            $list               = $db->where(array('id'=>$account_id))->find();
            if ($account_name == $list['nickname']){
                $msg            = 1;
            }else{
                $msg            = 0;
            }
        }else{
            $msg                = 0;
        }
        $this->ajaxReturn($msg);
    }

    //省市二级联动
    public function get_city(){
        $db                     = M('citys');
        $province               = trim(I('province'));
        $citys                  = $db->field('id,name')->where(array('pid'=>$province))->select();
        $this->ajaxReturn($citys);
    }

    //市县二级联动
    public function get_country(){
        $db                     = M('citys');
        $city                   = trim(I('city'));
        $country                = $db->field('id,name')->where(array('pid'=>$city))->select();
        $this->ajaxReturn($country);
    }

    //发送验证码
    public function send_code(){
        //获取传递手机号码
        $mobile = trim(I('mobile'));
        $token  = I('token');
        if ($mobile && session('token')==$token){
            $begin_time         = NOW_TIME-24*3600;
            $end_time           = NOW_TIME;
            $where              = array();
            $where['mobile']    = $mobile;
            $where['send_time'] = array('between',"$begin_time,$end_time");
            $times  = M('sms_send_record')->where($where)->count();
            if ($times >= 10){
                $data = array();
                $data['status'] = 'n';
                $data['info']  = '已超过单日发送数量！';
            }else{
                session_start();
                $code = rand(1000, 9999);
                $_SESSION['code'] = $code;
                //设置session过期时间
                $time = 5*60;
                setcookie(session_name(),session_id(),time()+$time);
                $res = sendTemplateSMS($mobile, array($code,5), "219482"); //手机号码，替换内容数组，模板ID
                if ($res==0) {
                    $data = array();
                    $data['status'] = 'y';
                    $data['info']  = '发送成功！';
                } else {
                    $data = array();
                    $data['status'] = 'n';
                    $data['info']  = '发送失败！';
                }
            }
        }else{
            $data           = array();
            $data['status'] = 'n';
            $data['info']   = '非法数据！';
        }
        $this->ajaxReturn($data);
    }
}

