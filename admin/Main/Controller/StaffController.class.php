<?php
/**
 * Date: 2018/8/15
 * Time: 15:47
 */

namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;
use Think\Verify;

//员工心声
class StaffController extends Controller{

    public function index(){

        if (!cookie('staff_youke')){
            $youke  = md5(NOW_TIME.rand(0,1000));
            cookie('staff_youke',$youke);
        }

        $db         = M('staff');
        //分页
        $pagecount  = $db->count();
        $page       = new Page($pagecount, 6);
        $this->pages= $pagecount>6 ? $page->show():'';

        $list       = M()->field('s.*,u.nickname')->table('__STAFF__ as s')->join('left join __STAFF_USER__ as u on s.userid= u.id')->limit($page->firstRow . ',' . $page->listRows)->order('s.send_time desc')->where(array('s.pid'=>array('eq',0)))->select();
        foreach ($list as $k=>$v){
            $list[$k]['content'] = htmlspecialchars_decode($v['content']);
            $list[$k]['username']= $v['nickname']?$v['nickname']:'匿名游客';
        }

        $hot_tiezi  = $this->get_hot_tiezi(10);
        $this->hot_tiezi = $hot_tiezi;
        $this->list = $list;

        $this->display();
    }

    public function add(){

        if (isset($_POST['dosubmit']) && isset($_POST['token'])){
            $token          = I('token');
            $arr_ip         = C('ARR_IP');
            $ip             = get_client_ip();
            $filename       = I('newname','');
            $fileid         = I('fileid','');

            if (in_array($ip,$arr_ip)){
                if ($token == $_SESSION['token']){
                    $info           = array();
                    $info['title']  = stripslashes(trim(I('title')));
                    $info['content']= stripslashes(trim(I('content')));
                    $info['send_time']= NOW_TIME;
                    $info['userid'] = cookie('staff_userid')?cookie('staff_userid'):0;
                    $info['youke']  = cookie('staff_youke');
                    $info['fileids'] = $fileid?implode(',',$fileid):'';
                    $res = M('staff')->add($info);
                    if ($res){
                        $this->success('发布成功',U('Staff/index'));
                    }else{
                        $this->error('数据保存失败');
                    }
                }else{

                    $this->error('非法数据');
                }
            }else{
                $this->error('请在公司网络环境下填写!');
            }
        }else{
            $token = md5(uniqid(rand(), true));
            $_SESSION['token']  = $token;
            $this->token        = $token;

            $hot_tiezi  = $this->get_hot_tiezi(6);
            $this->hot_tiezi = $hot_tiezi;

            $this->display();
        }
    }

    public function get_hot_tiezi($a){
        $hot_tiezi  = M('staff')->where(array('pid'=>array('eq',0)))->order('good_num desc,send_time desc')->limit($a)->select();
        foreach ($hot_tiezi as $k=>$v){
            $hot_tiezi[$k]['content'] = htmlspecialchars_decode($v['content']);
        }
        return $hot_tiezi;
    }

    public function info(){
        $id                 = I('id');
        $list               = M()->field('s.*,u.nickname')->table('__STAFF__ as s')->join('left join __STAFF_USER__ as u on s.userid=u.id')->where(array('s.id'=>$id))->find();
        $list['content']    = htmlspecialchars_decode($list['content']);
        $list['username']   = $list['nickname']?$list['nickname']:'匿名游客';
        $zan                = M('staff_zan')->where(array('staff_id'=>$id,'youke'=>array('eq',cookie('staff_youke'))))->order('id desc')->find();
        $time               = NOW_TIME - $zan['zan_time'];
        if (!$zan || $time>3600*24){
            //没有点赞或点赞时间大于24小时
            $list['zan']    = 1;
        }
        $this->list         = $list;

        $fileids_str        = trim($list['fileids']);
        if ($fileids_str) $fileids = explode(',',$fileids_str);
        $files              = M('attachment')->where(array('id'=>array('in',$fileids)))->select();
        $this->files        = $files;

        $token              = md5(uniqid(rand(), true));
        $_SESSION['token']  = $token;
        $this->token        = $token;

        $hot_tiezi          = $this->get_hot_tiezi(6);
        $this->hot_tiezi    = $hot_tiezi;

        $huifu              = M()->field('s.*,u.nickname')->table('__STAFF__ as s')->join('left join __STAFF_USER__ as u on s.userid=u.id')->where(array('s.pid'=>$id))->order('s.send_time desc, s.good_num desc')->select();
        foreach ($huifu as $k=>$v){
            $huifu[$k]['content'] = htmlspecialchars_decode($v['content']);
            $huifu[$k]['username']= $v['nickname']?$v['nickname']:'匿名游客';
            $zan         = M('staff_zan')->where(array('staff_id'=>$v['id'],'youke'=>array('eq',cookie('staff_youke'))))->order('id desc')->find();
            $time        = NOW_TIME - $zan['zan_time'];
            if (!$zan || $time>3600*24){
                //没有点赞或点赞时间大于24小时
                $huifu[$k]['zan']= 1;
            }
        }
        $this->huifu    = $huifu;

        $this->display();
    }

    public function save_staff(){
        $db             = M('staff');
        $id             = I('id');

        if (isset($_POST['dosubmit']) && isset($_POST['token'])){
            $token              = I('token');
            $arr_ip             = C('ARR_IP');
            $ip                 = get_client_ip();
            if (in_array($ip,$arr_ip)){
                if ($token == $_SESSION['token']){
                    $info           = array();
                    $info['pid']    = $id;
                    $info['content']= stripslashes(I('content'));
                    $info['send_time']= NOW_TIME;
                    $info['userid'] = cookie('staff_userid')?cookie('staff_userid'):0;
                    $info['youke']  = cookie('staff_youke');
                    $res = $db->add($info);

                    $data           = array();
                    $com_num        = $db->where(array('id'=>$id))->getField('com_num');
                    $data['com_num']= $com_num + 1;
                    $db->where(array('id'=>$id))->save($data);
                    if ($res){
                        $this->success('发布成功',U('Staff/info',array('id'=>$id)));
                    }else{
                        $this->error('数据保存失败');
                    }
                }else{

                    $this->error('非法数据');
                }
            }else{
                $this->error('请在公司网络环境下填写!');
            }
        }
    }

    public function del_staff(){
        $id     = I('id');
        $res    = M('staff')->where(array('id'=>$id))->delete();
        M('staff')->where(array('pid'=>$id))->delete();
        if ($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function login(){
        if (isset($_POST['dosubmit'])){
            $db                 = M('staff_user');
            $username           = trim(I('username',''));
            $password           = I('password','');

            $isdate = $db->where(array('username'=>$username))->find();
            if ($isdate){
                //核对密码
                $realpwd = $isdate['encrypt'] ? password(trim($password),$isdate['encrypt']) : md5($password);
                if($realpwd==$isdate['password']){

                    cookie(null);
                    cookie('staff_userid',$isdate['id'],36000);
                    cookie('staff_nickname',$isdate['nickname'],36000);
                    cookie('staff_username',$isdate['username'],36000);
                    cookie('staff_youke',$isdate['nickname'],36000);

                    $info                   = array();
                    $info['last_login_ip']  = get_client_ip();
                    $db->where(array('id'=>$isdate['id']))->save($info);
                    $this->success('登陆成功',U('Staff/index'));

                }else{
                    $this->error('用户名或者密码错误！');
                }
            }else{
                $this->error('用户名或密码错误');
            }
        }else{
            $this->display();
        }
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

    public function reg(){

        if (isset($_POST['dosubmit'])){
            $db         = M('staff_user');
            $info       = I('info');
            $password_1 = I('password_1');
            $password_2 = I('password_2');
            $yzm        = I('yzm_code');

            //校验验证码
            $verify     = new Verify();
            if(!$verify->check($yzm)){
                $this->error('验证码有误,请重新输入');
            }
            //验证两次输入密码一致性
            if ($password_1 != $password_2 || $password_1 == ''){
                $this->error('两次密码输入有误,请重新输入');
            }

            $username               = $info['username'];
            $res                    = $db->where(array('username'=>$username))->find();
            if ($res){
                $this->error('该登陆账号已被使用');
            }

            //密码
            $passwordinfo           = password($password_1);
            $info['password']       = $passwordinfo['password'];
            $info['encrypt']        = $passwordinfo['encrypt'];
            $info['reg_time']       = NOW_TIME;
            $info['last_login_ip']  = get_client_ip();
            $res    = $db->add($info);
            if ($res){
                $this->success('注册成功',U('Staff/login'));
            }else{
                $this->error('数据保存失败');
            }
        }else{

            $this->display();
        }
    }

    public function check_username(){
        $username   = I('username');
        $db         = M('staff_user');
        $res        = $db->where(array('username'=>$username))->find();
        if ($res){
            $this->ajaxReturn('nnn','JSON');
        }else{
            $this->ajaxReturn('yyy','JSON');
        }

    }

}