<?php
namespace Main\Controller;
use Think\Controller;
use Org\Util\Rbac;
ulib('phpqrcode.phpqrcode');
use Sys\P;
ulib('Page');
use Sys\Page;

// @@@NODE-2###Index###系统登录###
class ZindexController extends BasepubController {


    // @@@NODE-3###index###系统首页###
    public function index(){


		$startday = date('Y-m-01', strtotime(date("Y-m-d")));
        $endday   = date('Y-m-d', strtotime("$startday +1 month -1 day"));

		/*$this->sum_product  = M('op')->where("`status`= 1")->count();
		$this->sum_project  = M('op')->count();
		$this->sum_audit    = $this->_sum_audit;
        $this->salary_datetime();//触发人力资源信息条数提醒
       	//$this->file_remind_number();//触发文件审核处理信息条数提醒
		$this->sum_plans    = M('op')->where("`departure` >= '$startday' and `departure`<= '$endday' and `status`= 1")->count();
        $this->sum_partner  = M('customer_partner')->where(array('del_stu'=>array('neq','-1')))->count();
        $cycle_data         = get_cycle(date('Y').date('m'));
        $this->new_partner  = M('customer_partner')->where(array('del_stu'=>array('neq','-1'),'create_time'=>array('between',"$cycle_data[begintime],$cycle_data[endtime]")))->count();
        HR_notice(); //查询超过3个月未转正的人员信息,并且给人力资源发送系统通知

		//获取公告
		//$lists              = $this->get_notice_list();
		$this->notice       = $lists;*/

		$this->css('date');
		//$this->js('date');

		$this->display();
    }


}
