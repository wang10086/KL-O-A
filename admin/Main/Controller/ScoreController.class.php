<?php
/**
 * Date: 2018/5/18
 * Time: 10:09
 */

namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;
use Think\Verify;

class ScoreController extends BasepubController {
    protected $_pagetitle_  = '评分系统';
    protected $_pagedesc_   = '';


    public function login(){
        $db                             = M('tcs_score_user');
        if (isset($_POST['dosubmit'])) {
            $db                         = M('partner_satisfaction');
            $mobile                     = trim(I('mobile'));
            $mobile_code                = I('mobile_code');
            $uid                        = I('uid');
            $quota_id                   = I('kpi_quota_id');
            $yearMonth                  = I('yearMonth','');
            $monthly                    = $yearMonth ? $yearMonth : get_kpi_yearMonth(date('Y'),date('m'));
            $guide_id                   = I('guide_id',0);
            $opid                       = I('opid','');

            //验证手机验证码
            if ($mobile_code != session('code')) {
                die(return_msg('n','您输入的手机验证码有误,请重新输入'));
            }else{
                if (!$mobile) { die(return_msg('n','手机号码错误')); }
                if (!$uid) { die(return_msg('n','获取被评分人信息失败')); }
                $score_record           = $db->where(array('account_id'=>$uid,'quota_id'=>$quota_id,'mobile'=>$mobile,'monthly'=>$monthly,'status'=>1))->find();
                if ($score_record && !$opid){ die(return_msg('n','您本月已完成满意度评价,感谢您的参与!')); }

                $register_record        = $this->get_score_record($uid,$mobile,$monthly,$quota_id,$opid,$guide_id); //已注册,未评分
                if ($register_record){
                    $register_id        = $register_record['id'];
                    $info               = array();
                    $info['reg_time']   = NOW_TIME;
                    $db->where(array('id'=>$register_id))->save($info);
                }else{
                    $info               = array();
                    $info['account_id'] = $uid;
                    $info['mobile']     = $mobile;
                    $info['monthly']    = $monthly;
                    $info['reg_time']   = NOW_TIME;
                    $info['quota_id']   = $quota_id;
                    $info['guide_id']   = $guide_id;
                    $info['op_id']      = $opid;
                    $res = $db->add($info);
                    $register_id        = $res;
                }

                if ($register_id) {
                    session('scoreMobile',$mobile);
                    session('score_uid',$register_id);
                    die(return_msg('y','登录成功'));
                    //die(return_msg('y', "登录成功<script type='text/javascript'> setTimeout('location=\"$referer\"',1000);</script>"));
                }else{
                    die(return_msg('n','登录失败'));
                }
            }
        }else{
            $uid                    = I('uid');
            $quota_id               = I('kpi_quota_id');
            $title                  = trim(I('tit'));
            $ym                     = I('ym');
            $guide_id               = I('guide_id');
            $opid                   = I('opid');
            $this->uid              = $uid;
            $this->quota_id         = $quota_id;
            $this->ym               = $ym;
            $this->guide_id         = $guide_id;
            $this->opid             = $opid;
            $this->title            = $title;
            $this->token            = make_token();
            $this->display('mob-login');
        }
    }

    private function get_score_record($uid,$mobile,$monthly,$quota_id=0,$opid='',$guide_id=0){
        $db                         = M('partner_satisfaction');
        $where                      = array();
        $where['account_id']        = $uid;
        $where['mobile']            = $mobile;
        $where['monthly']           = $monthly;
        $where['quota_id']          = $quota_id;
        if ($opid) $where['op_id']  = $opid;
        if ($guide_id) $where['guide_id'] = $guide_id;
        $list                       = $db->where($where)->find();
        return $list;
    }

    //城市合伙人满意度KPI
    public function kpi_score(){
        $uid                        = I('uid');
        $title                      = I('tit');
        $quota_id                   = I('kpi_quota_id');
        $ym                         = I('ym','');
        $guide_id                   = I('guide_id',0);
        $opid                       = I('opid','');

        $this->uid                  = $uid;
        $this->token                = make_token();
        $this->scoreMobile          = session('scoreMobile');
        $this->title                = strpos($title,'-')?trim(substr($title,0,strrpos($title,"-"))):$title ;
        $this->quota_id             = $quota_id;
        $this->ym                   = $ym;
        $this->guide_id             = $guide_id;
        $this->opid                 = $opid;
        $this->SYSTEM_NAME          = '客户满意度';
        $this->display('kpi_score');
    }

    //保存合伙人满意度评价
    public function save_score(){
        $num                        = 0;
        $data                       = array();
        if (isset($_POST['dosubmint'])){
            $db                     = M('partner_satisfaction');
            $token                  = I('token');
            $info                   = I('info');
            $content                = trim(I('content'));
            $id                     = session('score_uid');
            /*if (session('partner_satisfaction')){
                $msg                = '请勿重复提交数据';
                $data['num']        = $num;
                $data['msg']        = $msg;
                $this->ajaxReturn($data);
            }*/
            if ($token == session('token')){
                $info['content']    = $content;
                $info['create_time']= NOW_TIME;
                $info['status']     = 1;
                $res                = $db ->where(array('id'=>$id))->save($info);
                if ($res) {
                    $num++;
                    $msg            = '保存成功';
                    //session('partner_satisfaction',1);
                    session(null);
                    cookie(null);
                }else{
                    $msg            = '保存失败';
                }
            }else{
                $msg                = '非法数据';
            }
            $data['num']            = $num;
            $data['msg']            = $msg;
        }else{
            $data['num']            = $num;
            $data['msg']            = '保存失败';
        }
        $this->ajaxReturn($data);
    }

    public function noScore(){
        $this->display();
    }

    public function scored(){
        $this->display();
    }

    /*function verify(){
        //自定义配置项
        $config = array(
            'fontSize'  => 16,
            'length'    => 4,
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  true,            // 是否添加杂点
            'imageH'    =>  40,              // 验证码图片高度
            'imageW'    =>  120,             // 验证码图片宽度
        );
        ob_clean();
        $verify = new Verify($config);
        $verify->entry();
    }*/

    //城市合伙人满意度评分详情
    public function public_partner_satisfaction(){
        $uid                        = I('uid');
        $month                      = I('month');
        $quota_id                   = I('kpi_quota_id');
        $tit                        = I('tit') ? trim(I('tit')) :'客户满意度';
        $data                       = get_partner_satisfaction($uid,$month,$quota_id);
        $lists                      = $data['lists'];
        $number                     = $data['number']; //评分次数
        $average                    = $data['average'];

        $this->month                = $month;
        $this->account              = M('account')->where(array('id'=>$uid))->find();
        $this->lists                = $lists;
        $this->number               = $number;
        $this->complete             = ($average*100).'%';
        $this->title($tit);
        $this->display('partner_satisfaction');
    }

}
