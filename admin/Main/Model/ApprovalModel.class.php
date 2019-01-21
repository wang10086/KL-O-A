<?php
namespace Main\Model;
use Think\Model;
use Sys\P;
class ApprovalModel extends Model
{
    /**
     * submit_file 提交保存文件
     */
    public function submit_file()
    {
        $id =array();
        if(!empty($_POST['file_name'])){
            //主文件保存
            $add['createtime']              = time();//创建时间
            $add['account_id']              = $_SESSION['userid'];//提交人员id
            $add['file_name']               = $_POST['file_name'];//文件名称
            $add['file_size']               = $_POST['file_size'];//文件大小
            $add['file_url']                = $_POST['file_url'];//文件路径
            $submit                         = M('approval_addfile')->add($add);//保存文件信息\
            if($submit){$id['mianid']       = $submit;}else{return 0 ;die;}
        }
        //副文件保存
        $add1['createtime']             = time();//创建时间
        $add1['account_id']             = $_SESSION['userid'];//提交人员id
        $file_name                      = $_POST['file_name1'];//文件名称
        if(!empty($file_name)){
            $file_size                  = $_POST['file_size1'];//文件大小
            $file_url                   = $_POST['file_url1'];//文件路径
            $add1['statu']              = 2;//创建状态
            foreach($file_name as $key =>$val){
                $add1['file_name']      = $val;
                $add1['file_size']      = $file_size[$key];
                $add1['file_url']       = $file_url[$key];
                $submit1                = M('approval_addfile')->add($add1);//保存文件信息
                if($submit1){$id['vice'] .= $submit1.',';}else{return 0 ;die;}
            }
            $id['vice']                 = substr($id['vice'],0,-1);
            //文件主表储存
            $increase['createtime']     = time();
            $increase['account_id']     = $_SESSION['userid'];//提交人员id
            $increase['account_name']   = username($_SESSION['userid']);
            $increase['pid']            = $_POST['user_id'];
            $increase['file_describe']  = trim($_POST['describe']);
            $increase['main_addfile_id']= $id['mianid'];
            $increase['vice_addfile_id']= $id['vice'];
            $increase['file_date']      = $_POST['days'];
            $increase_add               = M('approval_flie')->add($increase);
            if($increase_add){return 1;die;}else{return 0;die;}
        }else{
            return 1;die;
        }
    }

    /**
     * update_file 修改文件
     * $id 文件id
     */
    public function update_file($id,$file)
    {
        $viceid                                 = array();
        if($file['account_id'] !== $_SESSION['userid']){return 0 ;die;}
        $add['file_name']                       = $_POST['file_name'];//文件名称
        if(!empty($add['file_name'])){ //是否有主文件保存
            $add['file_size']                   = $_POST['file_size'];//文件大小
            $add['file_url']                    = $_POST['file_url'];//文件路径
            $where['id']                        = $file['main_addfile_id'];
            $where['statu']                     = 1;
            $submit                             = M('approval_addfile')->where($where)->save($add);//保存文件信息
            if(!$submit){
                $add['createtime']              = time();
                $add['account_id']              = $_SESSION['userid'];
                $add['statu']                   = 1;
                $add['id']                      = $file['main_addfile_id'];
                $submit1                        = M('approval_addfile')->add($add);//保存文件信息
                if(!$submit1){
                    return 0 ;die;
                }else{
                    $upsave['main_addfile_id']  = $submit1;
                    M('approval_flie')->where('id='.$id)->save($upsave);//保存文件信息
                }
            }
        }

        $file_name                              = $_POST['file_name1'];//文件名称
        if(!empty($file_name)){//是否有副文件保存
            //副文件保存
            $add1['createtime']                 = time();//创建时间
            $add1['account_id']                 = $_SESSION['userid'];//提交人员id
            $file_size                          = $_POST['file_size1'];//文件大小
            $file_url                           = $_POST['file_url1'];//文件路径
            $add1['statu']                      = 2;//创建状态
            foreach($file_name as $key =>$val){
                $add1['file_name']              = $val;
                $add1['file_size']              = $file_size[$key];
                $add1['file_url']               = $file_url[$key];
                $submit1                        = M('approval_addfile')->add($add1);//保存文件信息
                if($submit1){$viceid['vice']    .= $submit1.',';}else{return 0 ;die;}
            }
            $viceid['vice']                     = substr($viceid['vice'],0,-1);
            //文件主表储存
            if(!empty($_POST['user_id'])){$increase['pid'] = $_POST['user_id'];}
            if(!empty($viceid['vice'])){
                $ex_file                        = explode(",", $file['vice_addfile_id']);//附文件id
                $save_add                       = '';
                foreach($ex_file as $key => $val){//查询主附 文件id 是否还在
                   $query                       =  M('approval_addfile')->where('id='.$val)->find();
                   if($query){$save_add .= $val.',';}
                }
                $save_add                       = substr($save_add,0,-1);
                $increase['vice_addfile_id']    = $save_add.','.$viceid['vice'];
            }
            $increase_add                       = M('approval_flie')->where('id='.$id)->save($increase);
            if($increase_add){}else{return 0;die;}
        }

        $pid['pid']                             = I('user_id');
        if(!empty($pid['pid'])  && $file['pid']!==$pid['pid']){ //没有有主副文件保存 有上级领导修改
            $increase_add                       = M('approval_flie')->where('id='.$id)->save($pid);
            if($increase_add){}else{return 0;die;}
        }
        //判断有没有标注
        $file_id['file_id']                 = $id;
        $annotation                         = M('approval_annotation')->where($file_id)->find();
        if ($annotation) {
            $uup['statu']                   = 1;
            $sav                            = M('approval_annotation')->where($file_id)->save($uup);
        }

            return 1;die;
    }

    //编辑文件  查询上级领导
    public function Angements()
    {
        $user                     = M('account')->where(array('status=0'))->select();
        //整理关键字
        $role                     = M('role')->GetField('id,role_name', true);
        $key                      = array();
        foreach ($user as $k => $v) {
            $text                 = $v['nickname'] . '-' . $role[$v['roleid']];
            $key[$k]['id']        = $v['id'];
            $key[$k]['user_name'] = $v['nickname'];
            $key[$k]['pinyin']    = strtopinyin($text);
            $key[$k]['text']      = $text;
            $key[$k]['role']      = $v['roleid'];
            $key[$k]['role_name'] = $role[$v['roleid']];
        }
        $app['key']               = $key;
        return $app;
    }

    /**
     * select_sql 查询表
     * $approval 条件数组
     */
    public function select_sql($approval)
    {
        $table                          = array();
        foreach($approval as $key =>$val ){
            $table[$key]['id']          = $val['id'];//文件id
            $table[$key]['userid']      = $val['account_id'];//用户id
            $table[$key]['username']    = $val['account_name'];//用户名
            $table[$key]['file_date']   = $val['file_date'];//审批天数
            $table[$key]['createtime']  = $val['createtime'];//创建时间
            $table[$key]['pid']         = $val['pid'];//上级id
            $sql['account_id']          = $val['account_id'];
            $sql['statu']               = array('neq',3);
            $sql['id']                  = $val['main_addfile_id'];
            $addfile                    = $this->table_sql('approval_addfile',$sql,1);//文件
            $table[$key]['file_name']   = $addfile['file_name'];//文件名
            $table[$key]['file_url']    = $addfile['file_url'];//文件路径
            $table[$key]['describe']    = $val['file_describe'];//文件描述

            //判断文件状态e;
            $where['file_id']           = $val['id'];
            $m                          = M('approval_annotation')->where($where)->find();
            if($m){$table[$key]['statu']= $m['statu'];}else{$table[$key]['statu']   = 1;}
        }
        return $table;
    }

    /**
     * table_sql 查询表
     * $table 表名 $where 条件
     * $type 1 查一条 2 查所有
     */
    public function table_sql($table,$where,$type)
    {
        if($type==1){
            $tab    = M($table)->where($where)->find();
        }elseif($type==2){
            $tab    = M($table)->where($where)->select();
        }
        return $tab;
    }

    /**
     * filedelete 删除文件
     * $id 文件id
     */
    public function filedelete($id)
    {
        $where['id']     = $id;
        $delete          = M('approval_flie')->where($where)->delete();
        if($delete){$num = 1;}else{$num = 0;}
        return $num;
    }

    /**
     * Approval_detele_file 删除（主、附）文件
     * $where 条件
     */
    public function Approval_detele_file($where)
    {
        $userid         = $_SESSION['userid'];
        $info           = M('approval_addfile')->where($where)->find();
        if($userid==$info['account_id']){
            $addfile    = M('approval_addfile')->where($where)->delete();
            if($addfile){$num = 1;}else{$num = 2;}
        }else{
            $num        = 3;
        }
        return $num;
    }

    /**
     * file_details 查询详情
     * $id 文件id
     */
    public function file_details($id)
    {
        $where['id']            = $id;
        $where['type']          = 1;
        $sql                    = $this->table_sql('approval_flie',$where,1);//查询文件信息
        $addfile                = explode(',', $sql['vice_addfile_id']);
        array_unshift($addfile,$sql['main_addfile_id']);
        foreach($addfile as $key => $val){
            $query['id']        = $val;
            $query['statu']     = array('neq',3);
            $date[$key]         = $this->table_sql('approval_addfile',$query,1);//查询文件信息
        }
        $list[0] = $sql;
        $list[1] = $date;
        return $list;
    }

    /**
     * Approver 选择审议人员
     */
    public function Approver()
    {
        $account['status']                          = 0;
        $info                                       = M('account')->where($account)->order('id ASC')->select();
        foreach($info as $key => $val){
            if($val['id']==196 || $val['id']==42 || $val['id'] ==41 || $val['id']==43) {
            }else{
                $where['id']                        = $val['postid'];
                $where['post_name']                 = array('like',"%经理%");
                $posts                              = M('posts')->where($where)->find();//查找岗位
                if($posts){
                    $user[$key]['id']               = $val['id'];
                    $user[$key]['employee_member']  = $val['employee_member'];
                    $user[$key]['departmentid']     = $val['departmentid'];
                    $user[$key]['nickname']         = $val['nickname'];
                    $user[$key]['postid']           = $val['postid'];
                }
            }
        }
        return $user;
    }

    /**
     * finaljudgment 选择终审人员
     * $where 条件  $type 查询用户 1 查询一个 2 查询符合条件的
     */
    public function finaljudgment($where,$type)
    {
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

    /**
     * add_judgment 添加审议、终审人员信息
     * $judgment 终审人员   审议人员 $consider
     */
    public function add_judgment($file,$judgment,$consider)
    {
        $arr                        = '';
        $array                      = '';
        foreach($judgment as $key => $val){
            $arr                   .= $val.',';
        }
        foreach($consider as $key => $val){
            $array                 .= $val.',';
        }
        $save['file_judgment']      = substr($arr, 0, strlen($arr) - 1);
        $save['file_consider']      = substr($array, 0, strlen($array) - 1);
        $file_save                  = M('approval_flie')->where($file)->save($save);
        if($file_save){
            $add['statu']           = 3;
            $quer['file_id']        = $file['id'];
            $file_save1             = M('approval_annotation')->where($quer)->save($add);
            if($file_save1){return 1;die;}else{return 1;die;}
        }else{
            return 0;die;
        }
    }

    /**
     * Approval_Upload_save 查询将要修改文件信息
     * $where 文件条件
     */
    public function Approval_Upload_save($where)
    {
        $vice           = array();
        $file           = M('approval_flie')->where($where)->find();
        $main           = M('approval_addfile')->where('id='.$file['main_addfile_id'])->find();
        $addfile        = explode(',', $file['vice_addfile_id']);
        foreach($addfile as $k => $v){
            $vice[$k]   = M('approval_addfile')->where('id='.$v)->find();
        }
        $table[0]       = $main;
        $table[1]       = $vice;
        return $table;
    }
    /**
     * 添加批注信息 驳回
     * $file 文件id  $comment 内容
     * $status 状态
     */
    public function add_file_annotation($file,$comment,$status)
    {
        if($status=='不同意'){
            $save['statu'] = 6;//驳回
            $table         = M('approval_annotation')->where($file)->save($save);
            if($table){return '驳回成功！';die;}else{return '驳回失败！';die;}
        }elseif($status=='同意') {
            $userid        = $_SESSION['userid'];
            $fileid        = M('approval_flie')->where('id=' . $file['file_id'])->find();
            $annotation    = M('approval_annotation')->where($file)->find();
            if($annotation){
                $sta       = $this->add_table($file,$fileid,$comment,$userid,$annotation,1);//此文件有过批注
            }else{
                $sta       = $this->add_table($file,$fileid,$comment,$userid,$annotation,2);
            }//没有过此文件批注
            return $sta;
        }
    }

    /**
     * add_table 添加批注数据
     * $file 批注条件 $fileid文件信息
     * $comment 批注内容 $type 状态 1 修改 2添加
     * $userid 用户id $annotation 文件有过批注信息
     */
    public function add_table($file,$fileid,$comment,$userid,$annotation,$type)
    {

        if($type==1){ //此文件有过批注
            if($annotation['statu'] == 1){ //上级
                $file['account_id']     = $userid;
                $file['statu']          = $annotation['statu'];
                $annotati_w             = $this->annotation_r($file,$userid,$comment,$annotation,$fileid,1);
            }elseif($annotation['statu'] == 2){ //综合
                $file['account_id']     = 13;
                $file['statu']          = $annotation['statu'];
                $annotati_w             = $this->annotation_r($file,$userid,$comment,$annotation,$fileid,1);
            }elseif($annotation['statu'] == 3){//各级领导
                $file['account_id']     = $userid;
                $file['statu']          = $annotation['statu'];
                $annotati_w             = $this->annotation_r($file,$userid,$comment,$annotation,$fileid,2);
            }elseif($annotation['statu'] == 4){ //终审
                $file['account_id']     = $userid;
                $file['statu']          = $annotation['statu'];
                $annotati_w             = $this->annotation_r($file,$userid,$comment,$annotation,$fileid,2);
            }
            return $annotati_w;die;
        }elseif($type==2 && $userid==$fileid['pid']){ //没有过此文件批注
            $add['createtime']          = time();
            $add['account_id']          = $userid;
            $add['username']            = username($userid);
            $add['file_id']             = $file['file_id'];
            $add['annotation']          = $comment;
            $add['statu']               = 2;
            $add['type']                = 1;
            $increase = M('approval_annotation')->add($add);
            if($increase){return '添加提交成功！';die;}else{return '添加提交失败！';die;}
        }else{return '添加提交失败！您暂时不在添加批准的状态！';die;}
    }

    /**
     * annotation_r 查询修改数据
     * $file 批注条件 $fileid文件信息
     * $comment 批注内容 $type 状态 1 修改 2添加
     * $userid 用户id $annotation 文件有过批注信息
     */
    public function annotation_r($file,$userid,$comment,$annotation,$fileid,$type)
    {
        $file['type']                           = $annotation['statu'];
        $table                                  = M('approval_annotation')->where($file)->find();
        if($type==1){
            if($table){//有批注过
                $add['annotation']              = $comment;
                $add['statu']                   = $annotation['statu']+1;
                $save                           = M('approval_annotation')->where($file)->save($add);
                if($save){return '添加提交成功！';die;}else{return '添加提交失败！';die;}
            }
            if($annotation['statu'] == 1){$account_userid = $fileid['pid'];//上级领导id
            }elseif($annotation['statu'] == 2){$account_userid  = 13;}//综合部id

            if($userid==$account_userid){ //没有批注过 但是是批注权限人
                $add['createtime']              = time();
                $add['account_id']              = $userid;
                $add['username']                = username($userid);
                $add['file_id']                 = $file['file_id'];
                $add['annotation']              = $comment;
                $add['statu']                   = $annotation['statu']+1;
                $add['type']                    = $annotation['statu'];
                $save                           = M('approval_annotation')->add($add);
                if($save){return '添加提交成功！';die;}else{return '添加提交失败！';die;}
            }else{return '添加提交失败！您暂时不在添加批准的状态！';die;}
        }
        if($annotation['statu']==3){$arr        = explode(',',$fileid['file_consider']);$pid = count($arr);
        }elseif($annotation['statu']==4){$arr   = explode(',',$fileid['file_judgment']);$pid = count($arr);}
        if($type==2){ //审议人员专用
            if($table){//有批注过
                $add['annotation']              = $comment;
                $add['statu']                   = $annotation['statu'];
                $save                           = M('approval_annotation')->where($file)->save($add);
                if($save){
                    unset($file['account_id']); unset($file['type']);
                    $count                      = M('approval_annotation')->where($file)->count();
                    if($count==$pid){
                        $table_r['statu']       = $annotation['statu']+1;
                        $save1                  = M('approval_annotation')->where($file)->save($table_r);
                        if($save1){ return '添加提交成功！';die;}else{ return '添加提交失败！';die;}
                    }else{return '添加提交成功！';die;}
                }else{return '添加提交失败！';die;}
            }elseif(in_array($userid,$arr)){ //没有批注过 但是是批注权限人
                $add['createtime']              = time();
                $add['account_id']              = $userid;
                $add['username']                = username($userid);
                $add['file_id']                 = $file['file_id'];
                $add['annotation']              = $comment;
                $add['statu']                   = $annotation['statu'];
                $add['type']                    = $annotation['statu'];
                $save                           = M('approval_annotation')->add($add);
                if($save){
                    unset($file['account_id']);
                    $count                      = M('approval_annotation')->where($file)->count();
                    if($count==$pid){
                        $table_r['statu']       = $annotation['statu']+1;
                        unset($file['type']);
                        $save1                  = M('approval_annotation')->where($file)->save($table_r);
                        if($save1){ return '添加提交成功！';die;}else{ return '添加提交失败！';die;}
                    }else{return '添加提交成功！';die;}
                }else{return '添加提交失败！';die;}
            }else{return '添加提交失败！您暂时不在添加批准的状态！';die;}
        }else{return '数据不存在！';die;}
    }

    /**
     * printing_info 打印单 数据详细信息
     * $list 文件详细信息
     */
    public function printing_info($list)
    {
        $file['file_name']       = $list[1][0]['file_name'];//拟稿文件名称
        $where['id']             = $list[1][0]['account_id'];
        $file['file_department'] = userinfo($where)[0]['department']['department'];//拟稿人部门
        $file['file_username']   = username($list[1][0]['account_id']);//拟稿人名字
        return $file;
    }

    /**
     * judgment_name 显示审议人员名称
     * $judgment 终审人员  $id 文件id
     * $consider 审议人员
     */
    public function judgment_name($judgment,$id,$consider){

        foreach($judgment as $key => $val){//显示终审人员名称
            $judgment_name[$key]['name']       = username($where['id']=$val);
            $wher['account_id']                = $val;
            $wher['type']                      = 4;
            $wher['file_id']                   = $id;
            $approval                          = $this->table_sql('approval_annotation',$wher,2);
            if(!empty($approval)){
                $judgment_name[$key]['status'] = 1;
            }else{
                $judgment_name[$key]['status'] = 2;
            }
        }
        foreach($consider as $k => $v){//审议人员
            $consider_name[$k]['name']         = username($where['id']=$v);
            $whe['account_id']                 = $v;
            $whe['type']                       = 3;
            $whe['file_id']                    = $id;
            $approval                          = $this->table_sql('approval_annotation',$whe,2);

            if(!empty($approval)){
                $consider_name[$k]['status'] = 1;
            }else{
                $consider_name[$k]['status'] = 2;
            }
        }
        $table[0]                              = $judgment_name;//终审人员
        $table[1]                              = $consider_name;//审议人员
        return $table;
    }

    /**
     * auto_auditing 自动审核
     */
    public  function auto_auditing(){
        $where['statu']         = array('neq',5);
        $table                  = M('approval_annotation')->group('file_id')->where($where)->select();
        foreach($table as $key => $val){
           $id['id']            =  $val['file_id'];
           $file                = M('approval_flie')->where($id)->find();
           $time                = time();
           $endtime             = $file['createtime']+($file['file_date']*86400);
           if($endtime < $time){
               $sav['file_id']  = $val['file_id'];
               $up['statu']     = 5;
               M('approval_annotation')->where($sav)->save($up);
           }
        }
    }

}