<?php
/**
 * Date: 2018/2/26
 * Time: 11:07
 */

namespace Main\Controller;
use Think\Controller;
ulib('Page');
use Sys\Page;
use Sys\P;


class WorderController extends BaseController{

    //发起工单
    public function new_worder(){
        if (isset($_POST['dosubmint'])){

            $info           = I('info');
            $exe_info       = I('exe_info');

            $info['status']         = 0;
            $info['ini_user_id']    = $_SESSION['userid'];
            $info['ini_dept_id']    = $_SESSION['roleid'];
            $info['ini_dept_name']  = $_SESSION['rolename'];
            $info['create_time']    = NOW_TIME;
            $attr                   = I('attr'); //获取上传文件

            foreach($exe_info as $v){
                $exe_user_id            = $v['exe_user_id'];
                $exe_user_name          = $v['exe_user_name'];
                if ($exe_user_id == ''){
                    $wheres             = array();
                    $where['nickname']  = array('like',"%.$exe_user_name.%");
                    $exe_user_id        = M('account')->where(array('nickname'=>array('like','%'.$exe_user_name.'%')))->getField('id');
                }
                if (!$exe_user_id){
                    $this->error('请输入正确的执行人信息!');
                }

                $data                   = M('account')->where(array('id'=>$exe_user_id))->find();
                $info['exe_user_id']    = $exe_user_id;
                $info['exe_user_name']  = $data[nickname];
                $roleid                 = $data['roleid'];
                $info['exe_dept_name']  = M('role')->where(array('id'=>$roleid))->getField('role_name');
                $info['exe_dept_id']    = $roleid;
                $u_time                 = 5;    //默认5个工作日
                //计划完成时间 $u_time为工作日
                $info['plan_complete_time']= strtotime(getAfterWorkDay($u_time));

                $res = M('worder')->add($info);

                if ($res){
                    //保存附件信息
                    save_res(P::WORDER_INI,$res,$attr);

                    //发送信息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.$info['ini_dept_name'].'--'.$info['ini_user_name'].']的工单待执行!';
                    $content = $info['worder_content'];
                    $url     = U('worder/worder_info',array('id'=>$res));
                    $user    = '['.$info['exe_user_id'].']';
                    send_msg($uid,$title,$content,$url,$user,'');
                    $this->success("发起工单成功!");
                }else{
                    $this->error('保存失败!');
                }
            }

        }else{
            $this->title('发起工单');
            $this->group            =  get_roles();
            $this->worder_type      = C('WORDER_TYPE');

            //整理关键字
            $role = M('role')->GetField('id,role_name',true);
            $user =  M('account')->where(array('status'=>0))->select();
            $key = array();
            foreach($user as $k=>$v){
                $text = $v['nickname'].'-'.$role[$v['roleid']];
                $key[$k]['id']         = $v['id'];
                $key[$k]['user_name']  = $v['nickname'];
                $key[$k]['pinyin']     = strtopinyin($text);
                $key[$k]['text']       = $text;
                $key[$k]['role']       = $v['roleid'];
                $key[$k]['role_name']  = $role[$v['roleid']];
            }
            $this->userkey =  json_encode($key);

            $this->display('new_worder');
        }
    }


    //ajax获取每组用户信息
    /*public function member(){
        $id     = I('id');
        $users  = M('account')->where("roleid = '$id'")->select();
        $this->ajaxReturn($users,"JSON");
    }*/
    /*public function member(){
        $id             = I('id');
        $ids            = array_unique(M('worder_dept')->getfield("dept_id",true));
        $depts          = M('worder_dept')->field('id,dept_id,pro_title')->where("dept_id = '$id'")->select();
        if (in_array($id,$ids)){
            $this->ajaxReturn($depts,"JSON");
        }else{
            echo 0;
        }
    }

    public function dept(){
        $id             = I('id');
        $data           = M('worder_dept')->where("id = '$id'")->find();
        if ($data['type'] == 0){$data['type_res'] = '成熟产品';}
        if ($data['type'] == 1){$data['type_res'] = '新产品';}
        if ($data['type'] == 2){$data['type_res'] = '定制产品';}
        $this->ajaxReturn($data,"JSON");
    }*/

    //管理工单(工单列表)
    public function worder_list(){
        $this->title('工单管理');
        $db                         = M('worder');
        $worder_title               = I('worder_title');
        $worder_content             = I('worder_content');
        $pin                        = I('pin')?I('pin'):0;

        $where                      = array();
        $where['worder_type']       = array('neq',P::WORDER_PROJECT);

        if ($worder_title)          $where['worder_title']        = array('like','%'.$worder_title.'%');
        if ($worder_content)        $where['worder_content']      = array('like','%'.$worder_content.'%');
        if ($pin==1)			    $where['o.create_user']		  = cookie('userid');

        //分页
        $pagecount		= $db->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        foreach($lists as $k=>$v){
            //判断工单类型
            if($v['worder_type']==0) $lists[$k]['type'] = '维修工单';
            if($v['worder_type']==1) $lists[$k]['type'] = '管理工单';
            if($v['worder_type']==2) $lists[$k]['type'] = '质量工单';

            //判断工单状态
            if($v['status']==0)     $lists[$k]['sta'] = '<span class="red">未响应</span>';
            if($v['status']==1)     $lists[$k]['sta'] = '<span class="yellow">执行部门已响应</span>';
            if($v['status']==2)     $lists[$k]['sta'] = '<span class="yellow">执行部门已确认完成</span>';
            if($v['status']==3)     $lists[$k]['sta'] = '发起人已确认完成';
            if($v['status']==-1)    $lists[$k]['sta'] = '拒绝或无效工单';
            if($v['status']==-2)    $lists[$k]['sta'] = '已撤销';
            if($v['status']==-3)    $lists[$k]['sta'] = '<span class="red">需要做二次修改</span>';
        }
        $this->lists    = $lists;
        $this->pin      = $pin;
        $this->display();
    }

    //执行工单
    /*public function exe_worder(){
        if (isset($_POST['dosubmint'])){
            $pin                            = I('pin');
            if ($pin == 102){$pin = 101;};
            $id                             = I('id');
            $ini_user_id                    = I('ini_user_id');
            $info['exe_complete_content']   = I('exe_complete_content');  //审核意见
            $refuse                         = I('refuse');
            $info['status']                 = $refuse?$refuse:2; //执行部门确认完成
            $info['complete_time']          = NOW_TIME;
            $attr                           = I('attr');
            $res = M('worder')->where("id = '$id'")->save($info);
            if ($res){
                //保存上传附件
                save_res(P::WORDER_INI,$res,$attr);

                //向工单发起人推送消息
                $uid     = cookie('userid');
                $exe_dept_name = $_SESSION['rolename'];
                $exe_user_name = $_SESSION['nickname'];
                $title   = '您有来自['.$exe_dept_name.'--'.$exe_user_name.']的工单执行反馈!';
                $content = '';
                $url     = U('worder/my_worder',array('id'=>$_SESSION['userid'],'pin'=>$pin));
                $user    = '['.$ini_user_id.']';
                send_msg($uid,$title,$content,$url,$user,'');
                $this->success("执行成功!",U('Worder/worder_list'));
            }else{
                $this->error("执行失败!");
            }
        }else{
            $this->title('执行工单');
            $id                 = I('id');
            $pin                = I('pin');
            $data               = M('worder')->where("id = '$id'")->find();
            //判断工单类型
            if($data['worder_type']==0) $data['type'] = '维修工单';
            if($data['worder_type']==1) $data['type'] = '管理工单';
            if($data['worder_type']==2) $data['type'] = '质量工单';
            if($data['worder_type']==100)$data['type']= '项目工单';
            $this->data         = $data;
            $this->id           = $id;
            $this->pin          = $pin;
            //获取上传文件
            $this->atts         = get_res(P::WORDER_INI,$id);
            $this->display();
        }
    }*/

    public function exe_worder(){
        if (isset($_POST['dosubmint'])){
            $db                     = M('worder');
            $id                     = I('id');
            $ini_user_id            = $db->where(array('id'=>$id))->getField('ini_user_id');
            $info                   = I('info');
            $info['complete_time']  = 0;
            $res = $db->where(array('id'=>$id))->save($info);
            if($res){
                //向工单发起人推送消息
                $uid     = cookie('userid');
                $exe_dept_name = $_SESSION['rolename'];
                $exe_user_name = $_SESSION['nickname'];
                $title   = '您有来自['.$exe_dept_name.'--'.$exe_user_name.']的工单执行反馈!';
                $content = '';
                $url     = U('worder/worder_info',array('id'=>$id));
                $user    = '['.$ini_user_id.']';
                send_msg($uid,$title,$content,$url,$user,'');
                $this->success("操作成功");
            }else{
                $this->error("数据保存失败");
            }
        }
    }

    //我的工单
    public function my_worder(){
        if (isset($_POST['dosubmint'])){

        }else{
            $db                     = M('worder');
            $pin                    = I('pin',1);
            if ($pin == 0){$pin = 1;};
            $userid                 = cookie('userid');
            $where                  = array();
            if ($pin == 1){
                $where['worder_type']   = array('neq',P::WORDER_PROJECT);   //排除项目工单
                $where['ini_user_id']   = $userid;                          //我申请的工单
            }elseif ($pin == 2){
                $where['worder_type']   = array('neq',P::WORDER_PROJECT);
                $where['exe_user_id']   = $userid;                          //我的待执行工单
                $st                     = array(0,1,2);
                $where['status']        = array('in',$st);
            }elseif ($pin == 101){
                $where['worder_type']   = array('eq',P::WORDER_PROJECT);   //项目工单
                $where['ini_user_id']   = $userid;                         //我指派的项目工单
            }elseif ($pin == 102){
                $where['worder_type']   = array('eq',P::WORDER_PROJECT);
                $where['exe_user_id']   = $userid;                          //我的待执行项目工单
                $st                     = array(0,1,2);
                $where['status']        = array('in',$st);
            }
            //分页
            $pagecount		= $db->where($where)->count();
            $page			= new Page($pagecount, P::PAGE_SIZE);
            $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

            $lists                  = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
            foreach($lists as $k=>$v){
                //判断工单类型
                if($v['worder_type']==0) $lists[$k]['type'] = '维修工单';
                if($v['worder_type']==1) $lists[$k]['type'] = '管理工单';
                if($v['worder_type']==2) $lists[$k]['type'] = '质量工单';
                if($v['worder_type']==100)$lists[$k]['type']= '项目工单';

                //判断工单状态
                if($v['status']==0)     $lists[$k]['sta'] = '<span class="red">未响应</span>';
                if($v['status']==1)     $lists[$k]['sta'] = '<span class="yellow">执行部门已响应</span>';
                if($v['status']==2)     $lists[$k]['sta'] = '<span class="yellow">执行部门已确认完成</span>';
                if($v['status']==3)     $lists[$k]['sta'] = '发起人已确认完成';
                if($v['status']==-1)    $lists[$k]['sta'] = '拒绝或无效工单';
                if($v['status']==-2)    $lists[$k]['sta'] = '已撤销';
                if($v['status']==-3)    $lists[$k]['sta'] = '<span class="red">需要做二次修改</span>';
            }
            $this->lists            = $lists;
            $this->pin              = $pin;
            if ($pin == 1 or $pin == 2){
                $this->display('my_worder');
            }elseif ($pin ==101 or $pin == 102){
                $this->display('my_pro_worder');
            }
        }
    }

    //查看工单详情
    public function worder_info(){

        if (isset($_POST['dosubmint'])){

        }else{
            $id             = I('id');
            $db             = M('worder');
            //$this->info     = $db->alias('w')->where(array('w.id'=>$id))->join("left join oa_worder_dept as d on d.id = w.wd_id")->find();
            $info           = $db->where(array('id'=>$id))->find();
            $roleid         = cookie('roleid');
            $this->dept_list= M('worder_dept')->field("id,pro_title")->where("dept_id = '$roleid'")->select();

            //判断工单类型
            if($info['worder_type']==0) $info['type'] = '维修工单';
            if($info['worder_type']==1) $info['type'] = '管理工单';
            if($info['worder_type']==2) $info['type'] = '质量工单';
            if($info['worder_type']==100)$info['type']= '项目工单';

            //判断工单状态
            if($info['status']==0)      $info['sta'] = '<span class="red">未响应</span>';
            if($info['status']==1)      $info['sta'] = '<span class="yellow">执行部门已响应</span>';
            if($info['status']==2)      $info['sta'] = '<span class="yellow">执行部门已确认完成</span>';
            if($info['status']==3)      $info['sta'] = '发起人已确认完成';
            if($info['status']==-1)     $info['sta'] = '拒绝或无效工单';
            if($info['status']==-2)     $info['sta'] = '已撤销';
            if($info['status']==-3)     $info['sta'] = '<span class="red">需要做二次修改</span>';

            $this->ids      = array_unique(M('worder_dept')->getfield("dept_id",true));
            $this->info     = $info;
            $this->atts     = get_res(P::WORDER_INI,$id);
            $wd_id          = $info['wd_id'];
            if ($wd_id != 0){
                $dept           = M('worder_dept')->where(array('id'=>$wd_id))->find();
                if ($dept['type']==0) $dept['n_type'] = '成熟产品';
                if ($dept['type']==1) $dept['n_type'] = '新产品';
                if ($dept['type']==2) $dept['n_type'] = '定制产品';
                $this->dept     = $dept;
            }
            $this->display();
        }
    }

    //执行人响应工单并指派工单
    public function assign_user(){

        $opid       = I('id');
        $info       = I('info');
        $user       =  M('account')->getField('id,nickname', true);

        if(isset($_POST['dosubmit']) && $info){

            $assign_name        = M('account')->where(array('id'=>$info))->getField('nickname');
            $data               = array();
            $data['assign_id']  = $info;
            $data['assign_name']= $assign_name;
            $data['response_time'] = NOW_TIME;
            $data['status']     = 0;//执行部门已响应

            $res = M('worder')->where(array('id'=>$opid))->save($data);
            if ($res){
                //发送系统通知消息
                $uid     = cookie('userid');
                $title   = '您有来自['.cookie('rolename').'--'.cookie('name').']指派的负责项目工单待执行!';
                $content = '';
                $url     = U('Worder/worder_info',array('id'=>$opid));
                $user    = '['.$info.']';
                send_msg($uid,$title,$content,$url,$user,'');
                $this->success('已指派负责人!');
                echo '<script>setTimeout(window.top.art.dialog({id:"closeart"}).close(),2000);</script>';
                //echo '<script>window.top.art.dialog({id:"closeart"}).close();</script>';
            }

        }elseif (isset($_POST['do_exe'])){

            $info                   = I('info');
            $info['response_time']  = NOW_TIME;
            $info['complete_time']  = NOW_TIME;
            $res = M('worder')->where(array('id'=>$opid))->save($info);
            if ($res){
                $this->success("已响应该工单");
            }else{
                $this->error("保存数据失败");
            }

        }else{

            //用户列表
            $key = I('key');
            $db = M('account');
            $where = array();
            $where['id'] = array('gt',3);
            if($key) $where['nickname'] = array('like','%'.$key.'%');
            $pagecount = $db->where($where)->count();
            $page = new Page($pagecount,6);
            $this->pages = $pagecount>6 ? $page->show():'';
            $this->lists = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('roleid'))->select();
            $this->role  = M('role')->getField('id,role_name', true);
            $this->opid  = $opid;
            $this->display();
        }
    }

    public function del_worder(){

        $id = I('id');
        $res = M('worder')->where("id = '$id'")->delete();
        if($res){
            $this->success('删除工单成功!');
        }else{
            $this->error('删除数据失败!');
        }
    }

    //撤销工单
    public function revoke(){

        $id             = I('id');
        $info           = I('info');
        $db             = M("worder");
        $where          = array();
        $where['id']    = $id;
        $info['complete_time'] = NOW_TIME;
        $res    = $db->where($where)->save($info);
        if ($res){
            $this->success('撤销工单成功!');
        }else{
            $this->error('撤销工单失败!请稍后重试!');
        }
    }

    //发起人确认工单执行
    public function audit_resure(){
        if (isset($_POST['dosubmint'])) {
            $id     = I('id');
            $info   = I('info');
            $info['ini_confirm_time']  = NOW_TIME;
            $exe_user_id    = M('worder')->where(array('id'=>$id))->getfield('exe_user_id');
            if ($info['status'] == 3){
                $res    = M('worder')->where("id = '$id'")->save($info);
                if ($res){
                    $this->success('操作成功!');
                }else{
                    $this->error('保存数据失败!请稍后重试!');
                }
            }else{
                //需要再次执行
                $info['response_time']  = 0;
                $info['complete_time']  = 0;
                $info['assign_id']      = 0;
                $info['assign_name']    = null;
                $res    = M('worder')->where("id = '$id'")->save($info);
                if ($res){
                    //发送系统通知消息
                    $uid     = cookie('userid');
                    $title   = '您有来自['.cookie('rolename').'--'.cookie('name').']返回的需要修改的工单!';
                    $content = '';
                    $url     = U('Worder/worder_info',array('id'=>$id));
                    $user    = '['.$exe_user_id.']';
                    send_msg($uid,$title,$content,$url,$user,'');
                    $this->success('操作成功!');
                }else{
                    $this->error('保存数据失败!请稍后重试!');
                }
            }
        }
    }

    //项目工单
    public function project(){
        $this->title('工单管理');
        $db                         = M('worder');
        $worder_title               = I('worder_title');
        $worder_content             = I('worder_content');
        $pin                        = I('pin')?I('pin'):0;

        $where                      = array();
        $where['worder_type']       = array('eq',P::WORDER_PROJECT);

        if ($worder_title)          $where['worder_title']        = array('like','%'.$worder_title.'%');
        if ($worder_content)        $where['worder_content']      = array('like','%'.$worder_content.'%');
        if ($pin==101)			    $where['o.create_user']		  = cookie('userid');

        //分页
        $pagecount		= $db->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        foreach($lists as $k=>$v){
            //判断工单类型
            if($v['worder_type']==0) $lists[$k]['type'] = '维修工单';
            if($v['worder_type']==1) $lists[$k]['type'] = '管理工单';
            if($v['worder_type']==2) $lists[$k]['type'] = '质量工单';
            if($v['worder_type']==100)$lists[$k]['type']= '项目工单';

            //判断工单状态
            if($v['status']==0)     $lists[$k]['sta'] = '<span class="red">未响应</span>';
            if($v['status']==1)     $lists[$k]['sta'] = '<span class="yellow">执行部门已响应</span>';
            if($v['status']==2)     $lists[$k]['sta'] = '<span class="yellow">执行部门已确认完成</span>';
            if($v['status']==3)     $lists[$k]['sta'] = '发起人已确认完成';
            if($v['status']==-1)    $lists[$k]['sta'] = '拒绝或无效工单';
            if($v['status']==-2)    $lists[$k]['sta'] = '已撤销';
            if($v['status']==-3)    $lists[$k]['sta'] = '<span class="red">需要做二次修改</span>';
        }
        $this->lists    = $lists;
        $this->pin      = $pin;
        $this->display();
    }

    //各部门工单项列表
    public function dept_worder_list(){
        $this->title('各部门工单项管理');
        $db                         = M('worder_dept');
        $dept                       = I('dept');
        $pro_title                  = I('pro_title');

        $where                      = array();
        if ($dept)              $where['dept']          = array('like','%'.$dept.'%');
        if ($pro_title)         $where['pro_title']     = array('like','%'.$pro_title.'%');

        //分页
        $pagecount		= $db->where($where)->count();
        $page			= new Page($pagecount, P::PAGE_SIZE);
        $this->pages	= $pagecount>P::PAGE_SIZE ? $page->show():'';

        $lists          = $db->where($where)->limit($page->firstRow . ',' . $page->listRows)->order($this->orders('create_time'))->select();
        foreach($lists as $k=>$v){
            //判断工单类型
            if($v['type']==0) $lists[$k]['type'] = '成熟产品';
            if($v['type']==1) $lists[$k]['type'] = '新品';
            if($v['type']==2) $lists[$k]['type'] = '定制产品';
        }
        $this->lists    = $lists;
        $this->display();
    }

    //增加各部门工单项列表
    public function dept_worder_add(){
        if (isset($_POST['dosubmint'])){
            $db                     = M('worder_dept');
            $info                   = I('info');
            $info['dept']           = M('role')->where("id = $info[dept_id]")->getfield('role_name');
            $info['create_time']    = NOW_TIME;
            $info['use_time']       = intval($info['use_time']);
            if ($info['use_time'] == 0){
                $this->error('完成时间格式填写错误');
            }
            $res = $db -> add($info);
            if ($res){
                $this->success('保存数据成功');
            }else{
                $this->error('保存数据失败');
            }
        }else{
            $this->title('新增各部门工单项');
            $this->group            =  get_roles();
            $this->type             = C('WORDER_DEPT_TYPE');
            $this->display();
        }
    }

    //修改各部门工单项
    public function dept_worder_upd(){
        if (isset($_POST['dosubmint'])){
            $db                     = M('worder_dept');
            $id                     = I('id');
            $info                   = I('info');
            $info['dept']           = M('role')->where("id = $info[dept_id]")->getfield('role_name');
            $info['use_time']       = intval($info['use_time']);
            if ($info['use_time'] == 0){
                $this->error('完成时间格式填写错误');
            }
            $res = $db ->where("id = '$id'")-> save($info);
            if ($res){
                $this->success('保存数据成功',U('Worder/dept_worder_list'));
            }else{
                $this->error('保存数据失败');
            }
        }else{
            $this->title('修改各部门工单项');
            $db         = M('worder_dept');
            $id         = I('id');
            $info       = $db->where("id = '$id'")->find();
            $this->group=  get_roles();
            $this->type = C('WORDER_DEPT_TYPE');
            $this->info = $info;
            $this->display();
        }
    }

    //删除各部门工单项
    public function dept_worder_del(){
        $id  = I('id');
        $res = M('worder_dept')->where("id = '$id'")->delete();
        if($res){
            $this->success('删除工单项成功!');
        }else{
            $this->error('删除数据失败!');
        }
    }


}