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

    /*public function login(){
        $db                 = M('tcs_score_user');
        if (isset($_POST['dosubmit'])) {
            $mobile         = I('mobile');
            $mobile_code    = I('mobile_code');
            $confirm_id     = I('confirm_id',0);
            $opid           = I('opid',0);

            //验证手机验证码
            if ($mobile_code != session('code')) {
                die(return_msg('n','您输入的手机验证码有误,请重新输入'));
            }else{
                $referer        = I('referer')?str_replace('&amp;','&',I('referer')):'';
                if (!$confirm_id && !$opid) {
                    die(return_msg('n','获取活动信息失败'));
                }

                //查看是否已经评价过该项目
                if ($opid){
                    $scored = M()->table('__TCS_SCORE_USER__ as u')->join('left join __TCS_SCORE__ as s on s.uid=u.id')->where(array('u.mobile'=>$mobile,'u.op_id'=>$opid))->find();
                }else{
                    $scored = M()->table('__TCS_SCORE_USER__ as u')->join('left join __TCS_SCORE__ as s on s.uid=u.id')->where(array('u.mobile'=>$mobile,'u.confirm_id'=>$confirm_id))->find();
                }
                if ($scored){
                    die(return_msg('n','您已经为本次活动评分了,感谢您的参与!'));
                }

                $info               = array();
                $info['mobile']     = $mobile;
                $info['confirm_id'] = $confirm_id;
                $info['op_id']      = $opid?$opid:M('op_guide_confirm')->where(array('id'=>$confirm_id))->getField('op_id');
                $info['time']       = NOW_TIME;
                $res = $db->add($info);
                if ($res) {
                    cookie('scoreMobile',$mobile,7200);
                    cookie('score_uid',$res,7200);
                    die(return_msg('y','登录成功'));
                    //die(return_msg('y', "登录成功<script type='text/javascript'> setTimeout('location=\"$referer\"',1000);</script>"));
                }else{
                    die(return_msg('n','登录失败'));
                }
            }
        }else{
            $confirm_id             = I('confirm_id',0);
            $this->confirm_id       = $confirm_id;
            $opid                   = I('opid',0);
            $this->opid             = $opid;
            $token                  = md5(uniqid(rand(), true));
            $_SESSION['token']      = $token;
            $this->token            = $token;
            $this->display('mob-login');
        }
    }

    public function save_score(){
        if (isset($_POST['dosubmit'])) {
            $db                 = M('tcs_score');
            $info               = I('info');
            $info['uid']        = cookie('score_uid');
            $info['input_time'] = NOW_TIME;
            $res = $db->add($info);
            if ($res){
                $list       = M()->table('__OP_GUIDE_CONFIRM__ as c')->field('c.id,c.op_id,c.score_num')->join('left join __TCS_SCORE_USER__ as u on c.id=u.confirm_id')->where(array('u.id'=>cookie('score_uid')))->find();
                $confirm_id = $list['id'];
                $score_num  = $list['score_num'];
                $data       = array();
                $data['score_num'] = $score_num+1;
                M('op_guide_confirm')->where(array('id'=>$confirm_id))->save($data);

                $this->success('感谢您的评价',U('Score/scored'));
            }else{
                $this->error('数据保存失败');
            }
        }
    }

    public function noScore(){
        $this->display();
    }

    public function scored(){
        $this->display();
    }

    function verify(){
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
    }

    //注册答题
    public function registerExam(){
        if (isset($_POST['dosubmit'])){
            $name           = trim(I('uname'));
            $mobile         = trim(I('mobile'));
            $mobile_code    = trim(I('mobile_code'));
            $type           = trim(I('type'));
            $opid           = trim(I('opid'));

            //验证手机验证码
            if ($mobile_code != session('code')) {
                die(return_msg('n','您输入的手机验证码有误,请重新输入'));
            }else {
                $db                 = M('tcs_exam_user');
                $info               = array();
                $info['op_id']      = $opid;
                $info['name']       = $name;
                $info['mobile']     = $mobile;
                $info['type']       = $type;
                $info['input_time'] = NOW_TIME;
                $res = $db->add($info);
                if ($res) {
                    cookie('examName',$name,7200);
                    cookie('examMobile',$mobile,7200);
                    cookie('exam_uid',$res,7200);
                    session('examName',$name,7200);
                    session('examMobile',$mobile,7200);
                    session('exam_uid',$res,7200);
                    die(return_msg($type,'登录成功'));
                }else{
                    die(return_msg('n','登录失败'));
                }
            }
        }else{
            $this->type         = trim(I('tp'));
            $this->opid         = trim(I('opid'));
            $this->display();
        }
    }

    public function save_exam(){
        $token      = I('token');
        $info       = I('info');
        $db         = M('tcs_exam');
        $num        = 0;

        foreach ($info as $k=>$v){
            if (is_array($v['answer'])){
                $answer     = implode(',',$v['answer']);
                $v['answer']= $answer;
            }

            $data           = array();
            $data['uid']    = cookie('exam_uid');
            $data['name']   = cookie('examName');
            $data['mobile'] = cookie('examMobile');
            $data['question_id']= $k;
            $data['answer'] = $v['answer'];
            $data['type']   = $v['type'];
            $data['input_time'] = NOW_TIME;
            $res = $db->add($data);
            if ($res) $num++;
        }
        if ($num !=0){
            die(return_msg('y','保存成功'));
        }else{
            die(return_msg('n','数据保存失败'));
        }
    }

    public function QRcode(){
        $type           = I('tp');
        $opid           = I('opid');
        $host           = $_SERVER['SERVER_NAME'];
        $op             = M('op')->where(array('op_id'=>$opid))->find();

        if ($type == 1) {
            //辅导员测评系统
            $url_info   = 'http://'.$host.'/op.php?m=Main&c=Score&a=exam&tp=1&opid='.$opid;
        }else{
            //对教务测评系统
            $url_info   = 'http://'.$host.'/op.php?m=Main&c=Score&a=teacherExam&tp=2&opid='.$opid;
        }
        $this->url_info = $url_info;
        $this->op       = $op;

        $this->display();
    }*/


    /*******************************************************start****************************************************/

    //城市合伙人满意度KPI
    public function kpi_score(){
        $uid                = I('uid');
        $quota_id           = I('quota_id');
        $year               = I('year');
        $month              = I('month');
        $type               = I('type');
        $title              = I('tit');



        $this->title        = $title;
        $this->display('kpi_score');
    }


}