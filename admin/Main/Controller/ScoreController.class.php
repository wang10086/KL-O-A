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

class ScoreController extends Controller{
    protected $_pagetitle_  = '评分系统';
    protected $_pagedesc_   = '';


    public function login(){
        $db                             = M('tcs_score_user');
        if (isset($_POST['dosubmit'])) {
            $db                         = M('partner_satisfaction');
            $mobile                     = trim(I('mobile'));
            $mobile_code                = I('mobile_code');
            $uid                        = I('uid');
            $monthly                    = date('Ym');

            //验证手机验证码
            if ($mobile_code != session('code')) {
                die(return_msg('n','您输入的手机验证码有误,请重新输入'));
            }else{
                if (!$mobile) { die(return_msg('n','手机号码错误')); }
                if (!$uid) { die(return_msg('n','获取信息失败')); }
                $score_record           = $db->where(array('account_id'=>$uid,'mobile'=>$mobile,'monthly'=>$monthly,'status'=>1))->find();
                if ($score_record){ die(return_msg('n','您本月已完成满意度评价,感谢您的参与!')); }

                $register_record        = $db->where(array('account_id'=>$uid,'mobile'=>$mobile,'monthly'=>$monthly))->find(); //已注册,未评分
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
            $this->uid              = $uid;
            $this->token            = make_token();
            $this->display('mob-login');
        }
    }

    //城市合伙人满意度KPI
    public function kpi_score(){
        $uid                        = I('uid');
        $title                      = I('tit');

        $this->token                = make_token();
        $this->scoreMobile          = session('scoreMobile');
        $this->title                = $title;
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
            if (session('partner_satisfaction')){
                $msg                = '请勿重复提交数据';
                $data['num']            = $num;
                $data['msg']            = $msg;
                $this->ajaxReturn($data);
            }
            if ($token == session('token')){
                $info['content']    = $content;
                $info['create_time']= NOW_TIME;
                $info['status']     = 1;
                $res                = $db ->where(array('id'=>$id))->save($info);
                if ($res) {
                    $num++;
                    $msg            = '保存成功';
                    session('partner_satisfaction',1);
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

}