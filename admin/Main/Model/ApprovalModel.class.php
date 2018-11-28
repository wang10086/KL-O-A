<?php
    namespace Main\Model;
    use Think\Model;
    use Sys\P;
    class ApprovalModel extends Model
    {

        //编辑文件
        public function Arrangement($fileid)
        {
            if (!is_numeric($fileid)) {
                $this->error('数据错误!请重新打开！');//最后一次错误
            }
            $flie = M('approval_flie')->where('id=' . $fileid)->find();
            //整理关键字
            $role = M('role')->GetField('id,role_name', true);
            $user = M('account')->where(array('status' => 0))->select();
            $key  = array();
            foreach ($user as $k => $v) {
                $text                 = $v['nickname'] . '-' . $role[$v['roleid']];
                $key[$k]['id']        = $v['id'];
                $key[$k]['user_name'] = $v['nickname'];
                $key[$k]['pinyin']    = strtopinyin($text);
                $key[$k]['text']      = $text;
                $key[$k]['role']      = $v['roleid'];
                $key[$k]['role_name'] = $role[$v['roleid']];
            }
            $app['flie'] = $flie;
            $app['key']  = $key;
            return $app;
        }

        //文件首次上传
        public function add_approval($file){
            if (empty($file['file_url']) || !is_numeric($file['pid_account_id'])) {
                return 0;
            }
            $file = array_filter($file);
            $add  = M('approval_flie_url')->add($file);
            if ($add) {
                return 1;
            } else {
                return 0;
            }
        }
        //查询文件和修改文件 $type 1 判断是文件修改表 默认是文件表
        public function query_table($approval,$type){
            foreach($approval as $key => $val){
                if($type==1){
                    $app['id']                  = $val['id'];
                }else{
                    $app['file_id']             = $val['id'];
                }
                $appro[$key]['Approval_url']    = $this->Approval_details($app);
                $appro[$key]['Approval']        = $val;
            }

            return $appro;
        }

        //到天数自动审核通过
        public function datetime_approval(){
            $sql                    = M('approval_flie')->where('type=1')->select();
            foreach($sql as $key =>$val){
                $file['file_id']    = array('eq',$val['id']);
                $file['type']       = array('eq',1);
                $file['status']     = array('lt',5);
                $tim = time();
                if(($val['createtime']+$val['file_date']*86400)<$tim){
                    $save['status'] = 5;
                    $file_url       = M('approval_flie_url')->where($file)->save($save);
                }
            }
        }

        //文件详情
        public function Approval_details($id)
        {
            $id['type']         = 1;
            $approval_url       = M('approval_flie_url')->where($id)->find();
            return $approval_url;
        }
        // 审批人员
        public function Approval_userinfo($where){
            $judgmen                                    =  M('approval_judgment')->where($where)->find();
            if($judgmen){
                $arr                                    = explode(',',$judgmen['judgment_account_id']);
            foreach($arr as $key =>$val){
                $info['annotation1'][$key]['username']  = user_table($val,3)['nickname'];
                $where['account_id']                    = $val;

                $annotation1                            = M('approval_annotation')->where($where)->find();
                if($annotation1){
                    $info['annotation1'][$key]['steta'] = 2;//有批注
                }else{
                    $info['annotation1'][$key]['steta'] = 1;//无批注
                }
            }
            $arr2                                       = explode(',',$judgmen['final_account_id']);

            foreach($arr2 as $k =>$v){
                $info['annotation2'][$k]['username']    = user_table($v,3)['nickname'];
                $where['account_id']                    = $v;
                $annotation2                            = M('approval_annotation')->where($where)->find();
                if($annotation2){
                    $info['annotation2'][$k]['steta']   = 2;//有批注
                }else{
                    $info['annotation2'][$k]['steta']   = 1;//无批注
                }
            }
            }
            
            return $info;
        }

        //修改文件及路径 $table表名 $where条件 $save 修改内容
        public function save_approval($table,$where,$save){
            $sql                                  = M($table)->where($where)->find();
            if($sql){
                if($sql['account_id'] !== $_SESSION['userid']){
                    return 2;
                }else{
                    if($sql['status']==6){ //判断是否驳回后提交
                        $userid                   = $_SESSION['userid'];
                        $up['file_id']            = $where['file_id'];
                        $up['file_url_id']        = $where['id'];
                        $judgment                 = M('approval_judgment')->where($up)->find();
                        $arr                      = explode(",",$judgment['judgment_account_id']);
                        $arr2                     = explode(",",$judgment['final_account_id']);
                        if(($sql['pid_account_id'] ==$sql['last_account_id'] && $sql['last_state']==2) || ($judgment['account_id']==$sql['last_account_id'] && $sql['last_state']==3) || (in_array($sql['last_account_id'],$arr) && $sql['last_state']==4 ) || (in_array($sql['last_account_id'],$arr2) && $sql['last_state']==5)){
                            $save['status']       = $sql['last_state']-1;
                            $save_update['status']= $sql['last_state']-1;
                            $sql_w                = M($table)->where($where)->save($save);
                            if($sql_w){
                                $judgment1        = M('approval_judgment')->where($up)->save($save_update);
                                if($judgment1){ return 1; }
                            }
                            $sql_w                = M($table)->where($where)->save($save);
                        }elseif(($sql['pid_account_id'] ==$sql['last_account_id'] && $sql['last_state']==1) || ($judgment['account_id']==$sql['last_account_id'] && $sql['last_state']==2) || (in_array($sql['last_account_id'],$arr) && $sql['last_state']==3) || (in_array($sql['last_account_id'],$arr2) && $sql['last_state']==4)){
                            $save['status']       = $sql['last_state'];
                            $save_update['status']= $sql['last_state'];

                            $sql_w                = M($table)->where($where)->save($save);
                            if($sql_w){
                                $judgment1        = M('approval_judgment')->where($up)->save($save_update);
                                if($judgment1){ return 1; }
                            }
                        }
                       return 0;
                    }
                    //不是驳回提交
                    $sql_w                       = M($table)->where($where)->save($save);
                    if($sql_w){ return 1;}else{return 0;}
                }
                return 0;
            }
        }

        // 选择审批人员
        public function Approver($where){
            $posts                                  = query_posts($where);//查找岗位
            $account['status']                      = 0;
            $sum = 0;
            foreach($posts as $key => $val){
                $account['postid']                  = $val['id'];
                $info                               = M('account')->where($account)->order('id ASC')->select();
                foreach($info as $k => $v){
                    $user[$sum]['id']               = $v['id'];
                    $user[$sum]['employee_member']  = $v['employee_member'];
                    $user[$sum]['departmentid']     = $v['departmentid'];
                    $user[$sum]['nickname']         = $v['nickname'];
                    $user[$sum]['postid']           = $v['postid'];
                    $sum++;
                }
            }
            return $user;
        }

        //选择终审人员
        public function finaljudgment($where,$type){
            $office                             = user_table($where,$type);
            foreach($office as $key => $val){
                $info[$key]['id']               = $val['id'];
                $info[$key]['employee_member']  = $val['employee_member'];
                $info[$key]['departmentid']     = $val['departmentid'];
                $info[$key]['nickname']         = $val['nickname'];
                $info[$key]['postid']           = $val['postid'];
            }
            return $info;
        }

        // 文件审批权限查询
        public function Jurisdiction(){
            $arr                            = array("11", "55", "77", "32","38","1","12","13");
            if(in_array($_SESSION['userid'],$arr)){
                $where                      = 1;
            }else{
                $userid                     = $_SESSION['userid'];
                $map['judgment_account_id'] = array('like',"%userid%");
                $info                       =  M('approval_judgment')->where($map)->count();
                if(!$info){
                    $where                  = 2;
                }else{
                     $where                 = 3;
                }
            }
            return $where;
        }

        // 添加审批人员信息
        public function add_judgment($file,$judgment,$check){
            $arr             = '';
            $array           = '';
            foreach($judgment as $key => $val){
                $arr         .= $val.',';
            }
            foreach($check as $key => $val){
                $array       .= $val.',';
            }
            $where['file_id']                   = $file['file_id'];
            $where['id']                        = $file['file_url_id'];
            $query                              = M('approval_flie_url')->where($where)->find();
            if($query['status']==3){ return 2;die;}
            if($query){
                $update['status']               = 3;
                $update['type']                 = 1;
                $where['type']                  = 1;
                $save                           = M('approval_flie_url')->where($where)->save($update);
                if($save){
                    $sta['status']              = 3;
                    $judgment_save              = M('approval_judgment')->where($file)->save($sta);
                    if($judgment_save){
                        return 1;die;
                    }
                    $file['final_account_id']   = substr($arr,0,strlen($arr)-1);
                    $file['judgment_account_id']= substr($array,0,strlen($array)-1);
                    $file['account_id']         = $_SESSION['userid'];
                    $file['createtime']         = time();
                    $file['account_name']       = $_SESSION['name'];
                    $file['status']             = 3;
                    $add                        = M('approval_judgment')->add($file);
                    if($add){
                        return 1;die;
                    }
                }
            }
            return 0;
        }

        //添加批注信息 驳回
        public function add_file_annotation($file,$comment,$status){
            $userid                                         = (int)$_SESSION['userid'];
            $query['file_id']                               = $file['file_id'];
            $query['file_url_id']                           = $file['file_url_id'];
            $judgment                                       = M('approval_judgment')->where($query)->find();
            $arr                                            = explode(",",$judgment['judgment_account_id']);
            $arr2                                           = explode(",",$judgment['final_account_id']);
            $url['file_id']                                 = $file['file_id'];
            $url['id']                                      = $file['file_url_id'];
            $roval_flie                                     = M('approval_flie_url')->where($url)->find();
//            if(in_array($userid,$arr) || in_array($userid,$arr2) || $userid==$judgment['account_id'] || $userid==1 || $userid==2 || in_array($userid,$roval_flie['pid_account_id'])){
//
//            }
            if($status=="审批驳回"){ //审批驳回
                $update['status']                           = 6;
                if($roval_flie['status']==6){ return 7;die;}
                $update['last_state']                       = $roval_flie['status'];
                $update['last_account_id']                  = $userid;
                $url_save                                   = M('approval_flie_url')->where($url)->save($update);
                if($url_save){
                    $save['status']                         = 6;
                    $url_judgment                           = M('approval_judgment')->where($query)->save($save);
                    if($url_judgment){return 4;die; }
                }
                return 5;die;
            }
            if(empty($comment)){ return 3; die; }//空
            //批注提交
            $file['account_id']                             = $_SESSION['userid'];
            $file['account_name']                           = $_SESSION['name'];
            $file_state                                     = M('approval_annotation')->where($file)->find(); 
            if($file_state){
                $update['annotation_content']               = $comment;
                $save                                       = M('approval_annotation')->where($file)->save($update);
                if($save){ return 1;die;}else{ return 2;die;}//1 成功 2//失败
            }else{
                $file['createtime']                         = time();
                $file['annotation_content']                 = trim($_POST['comment']);
                $file_add                                   = M('approval_annotation')->add($file);
                if($file_add){
                    if($roval_flie['status'] ==1){
                        $up['status']                   = 2;
                        if( in_array($userid,$arr2)){
                            $up['status']               = 5;
                        }
                        $url_save                       = M('approval_flie_url')->where($url)->save($up);
                        if($url_save){ return 1;die;}else{ return 2;die; }
                    }
                    if($roval_flie['status'] ==3){
                         foreach($arr as $key =>$val){
                            $query['account_id']        = $val;
                            $file_nnot                  = M('approval_annotation')->where($query)->find();
                            if(!$file_nnot){
                                return 1;die;//失败
                            }
                         }
                        unset($query['account_id']);
                        $up['status']                   = 4;
                        if(in_array($userid,$arr2)){
                            $up['status']               = 5;
                        }
                         $url_save1                     = M('approval_flie_url')->where($url)->save($up);
                         $url_judgment1                 = M('approval_judgment')->where($query)->save($up);
                    }
                    if($roval_flie['status'] ==4){
                        foreach($arr2 as $k =>$v){
                            $query['account_id']        = $v;
                            $file_nnot                  = M('approval_annotation')->where($query)->find();
                            if(!$file_nnot){
                                return 1;die;//失败
                            }
                         }
                         unset($query['account_id']);
                         $up['status']                  = 5;
                         $url_save1                     = M('approval_flie_url')->where($url)->save($up);
                         $url_judgment1                 = M('approval_judgment')->where($query)->save($up);
                    }
                    return 1;die;//失败
                }
                return 2;die;
            }
        }
        
}