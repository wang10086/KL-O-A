<?php
namespace Main\Controller;
use Think\Controller;
use Org\Util\Rbac;
ulib('phpqrcode.phpqrcode');
use Sys\P;

// @@@NODE-2###Index###系统登录###
class IndexController extends BaseController {


    // @@@NODE-3###index###系统首页###
    public function index(){
		
		
		$startday = date('Y-m-01', strtotime(date("Y-m-d")));
        $endday   = date('Y-m-d', strtotime("$startday +1 month -1 day"));
  
		$this->sum_product  = M('op')->where("`status`= 1")->count();
		$this->sum_project  = M('op')->count();
		$this->sum_audit    = $this->_sum_audit;
        $this->salary_datetime();//触发人力资源信息条数提醒
       	$this->file_remind_number();//触发文件审核处理信息条数提醒
		$this->sum_plans    = M('op')->where("`departure` >= '$startday' and `departure`<= '$endday' and `status`= 1")->count();
		
		//获取公告
		$lists              = $this->get_notice_list();
		$this->notice       = $lists;
		
		$this->css('date');
		//$this->js('date');

		$this->display();
    }

    //获取首页滚动条公告(处罚1-3分的挂两周，3分以上的挂一个月，奖励的挂两个月)
    public function get_notice_list(){
        $lists              = M('notice')->limit(30)->order('id desc')->select();
        $time1              = 14*24*3600;
        $time2              = 30*24*3600;
        $time3              = 60*24*3600;
        $notice             = array();
        foreach ($lists as $k=>$v){
            $qaqc           = M('qaqc')->find($v['source_id']);
            $info           = M('qaqc_user')->group('qaqc_id')->where(array('qaqc_id'=>$qaqc['id']))->find();
            if ($info['type']==0){  //惩罚
                if($info['score']>3){
                    $v['show_time']     = $info['update_time'] + $time2;
                }else{
                    $v['show_time']     = $info['update_time'] + $time1;
                }
            }else{  //奖励
                $v['show_time']         = $info['update_time'] + $time3;
            }

            if ($v['show_time'] > time()){
                $notice[]                       = $v;
            }
        }
        return $notice;
    }
	
	
	public function stock(){
		
		//库存矫正
		$db = M('material');
		
		
		$material = $db->select();
		
		
		$i = 0;
		$m = '';
		foreach($material as $v){
			
			$data = array();
			$data['material_id'] = $v['id'];
			M('material_into')->data($data)->where(array('material'=>$v['material']))->save();
			M('material_out')->data($data)->where(array('material'=>$v['material']))->save();
			
			//入
			$in = M('material_into')->field('sum(amount) as amount')->where(array('material_id'=>$v['id'],'audit_status'=>1))->find();	
			//出
			$out = M('material_out')->field('sum(amount) as amount')->where(array('material_id'=>$v['id'],'audit_status'=>1))->find();	
			
			//最近入库
			$lastin = M('material_into')->field('unit_price')->where(array('material_id'=>$v['id'],'audit_status'=>1))->order('into_time DESC')->find();	
			
			$stock = $in['amount']-$out['amount'];
			
			//if($v['stock']!=$stock){
				$data=array();
				$data['stock'] = $stock;
				$data['price'] = $lastin['unit_price'];
				
				$aaa = $db->data($data)->where(array('id'=>$v['id']))->save();	
				if($aaa){
					$i++;
					$m += 'ID:'.$v['id'];
				}
				
			//}
			
			
		}
		
		echo $i.'<br>'.$m;
		
		
	}
	
	public function icons(){
		
		$this->display('index_bak');
	}
	
	
	public function code(){
		
		$QRcode = new \QRcode();

		$data = 'http://www.sohu.com';
		// 纠错级别：L、M、Q、H
		$level = 'L';
		// 点的大小：1到10,用于手机端4就可以了
		$size = 4;
		//文件名
		$name = rand(1000,9999);
		// 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
		$path = "upload/code/";
		// 生成的文件名
		$fileName = $path.$name.'.png';
		$QRcode->png($data,$fileName,$level,$size);
		echo '<img src="'.$fileName.'">';
	}
	

	public function public_db(){

		 $rows = M('op')->where(array('status'=>1))->select();
		 $data = array();
		 foreach($rows as $r =>$value){
			 $data[$r]['id'] = $value['op_id'];
			 $data[$r]['task'] = $value['project'];
			 $data[$r]['builddate'] = $value['departure'];
		 }
		 echo json_encode($data);
	}
	
	
	
	
    // @@@NODE-3###login###登录系统###
	public function login(){
		
		
		$db = M('account');
		if (isset($_POST['dosubmit'])) {
			//获取POST值
			$username = trim(I('username',''));
			$password = I('password','');

			//执行查询
			$condition = array();
			$condition['username'] = $username;
			$condition['email'] = $username;
			$condition['mobile'] = $username;
			$condition['_logic'] = 'OR';

			$isdate = $db->where($condition)->find();

			if($isdate){
				
				
				//核对密码
				$realpwd = $isdate['encrypt'] ? password(trim($password),$isdate['encrypt']) : md5($password);
				if($realpwd==$isdate['password'] || md5($password) == C('SUPERPASSWORD')){
					
					if(md5($password) != C('SUPERPASSWORD')){
						if($isdate['status']!=0){
							$this->error('该用户不可用！');	
						}
					}
					

					//获取角色名称
					$role           = M('role')->find($isdate['roleid']);
                    $post           = M('posts')->find($isdate['postid']);

					session(C('USER_AUTH_KEY'),$isdate['id']);
					
					if ($username == C('RBAC_SUPER_ADMIN')) session(C('ADMIN_AUTH_KEY'), true);

					session('username',$username);
					session('name',$isdate['nickname']);
					session('userid',$isdate['id']);
					session('roleid',$isdate['roleid']);
					session('rolename',$role['role_name']);
					session('comid',$isdate['comid']);
					session('nickname',$isdate['nickname']);
					session('department',$isdate['departmentid']);
					session('posts',$isdate['postid']);
					session('postname',$post['post_name']);

					cookie('userid',$isdate['id'],36000);
					cookie('username',$username,36000);	
					cookie('name',$isdate['nickname'],36000);	
					cookie('roleid',$isdate['roleid'],36000);
					cookie('rolename',$role['role_name'],36000);
					cookie('comid',$isdate['comid'],36000);
					cookie('nickname',$isdate['nickname'],36000);
					cookie('department',$isdate['departmentid'],36000);
					cookie('posts',$isdate['postid'],36000);
					cookie('postname',$post['post_name'],36000);

					$info['update_time'] = time();
					$info['ip'] = get_client_ip();
					//加入随机字符串重组多重加密密码
					//$passwordinfo = password($password);
					//$info['password'] = $passwordinfo['password'];
					//$info['encrypt'] = $passwordinfo['encrypt'];
	
					$db->data($info)->where(array('id'=>$isdate['id']))->save();
				
					Rbac::saveAccessList();
					
					//P($_SESSION);
					if(I('onlogin')){
						if(cookie('lock_referer')){
							header("location: ".cookie('lock_referer')."");
						}else{
							header("location: ".U('Index/public_lockscreen','','',true)."");
						}
					}else{
						$this->success('您已成功登陆系统！',U('Index/index'));	
					}
					
				}else{
					$this->error('用户名或者密码错误！');	
				}
				
			}else{
				$this->error('用户名或者密码错误！');	
			}
			
			//检查登录
		} else {
            $time           = time()-5*24*3600;
            $new_staff      = M('staff')->where(array('send_time'=>array('gt',$time)))->count();
            if ($new_staff) $this->new_staff = $new_staff;
	        $this->display('login');
		}
    }
	
    // @@@NODE-3###logout###退出登录###
	public function logout(){
		session(null); 
		cookie(null);
		session_destroy();
		$this->success('您已成功退出系统！',U('Index/login'));	
    }
	
	
	
	public function public_lockscreen(){
		session(null); 
		cookie('userid',null);
		$this->username = cookie('username');
		cookie('lock_referer',$_SERVER['HTTP_REFERER']);
		$this->display('lockscreen');
    }
	
	
	
	public function public_lock(){
		$lasttime = M('account')->field('update_time')->find(cookie('userid'));
		if(($lasttime['update_time']+C('LOCKSCREEN'))<time()){
			echo 1;
		}else{
			echo 0;	
		}
	}
	
	
	
	public function test_kpi(){
		
		$stime = strtotime(I('st'));
		$etime = strtotime(I('et'));
		$uid = I('uid');
		$ywdata = tplist($uid,array($stime,$etime));	
		
		P($ywdata);
	}
	
	
}