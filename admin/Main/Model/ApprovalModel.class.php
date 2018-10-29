<?php
    namespace Main\Model;
    use Think\Model;
    use Sys\P;
    class ApprovalModel extends Model{


        /**
         * 文件上传审批
         * $table 上传文件表名 $user_id 审批人
         * $style 状态 1 approval_flie_update表添加 默认 approval_flie 表
         */
        public function approval_upload($table,$user_id,$style){
            if($style==1){
                $table                                = 'approval_flie_update';
                $add_approval['update_time']          = time();
                $userid                               = $user_id;
                $add_approval['file_id']              = $user_id;

            }else{
                $userid                               ='';
                foreach($user_id as $key =>$val){
                    $userid                           .= $val.',';
                }
                $userid                               = substr($userid,0,-1);
                $add_approval['file_account_id']      = $userid;
            }
            $upload                                   = new \Think\Upload();// 实例化上传类
            $upload->maxSize                          = 31457280000 ;// 设置附件上传大小
            $upload->exts                             = array('doc','docx','pdf');// 设置附件上传类型
            $upload->rootPath                         = './upload/'; // 设置附件上传根目录
            $upload->subName                          = array('date', 'Ym');//文件upload下的文件名
            $info                                     =  $upload->upload();//上传文件
            if($info){
                //文件信息保存
                $add_approval['createtime']           = time();
                $add_approval['account_id']           = $_SESSION['userid'];
                $add_approval['account_name']         = user_table($_SESSION['userid'])['nickname'];
                $add_approval['file_size']            = $info['file']['size'];
                $add_approval['file_format']          = $info['file']['ext'];
                $add_approval['file_name']            = substr($info['file']['savename'],0,strlen($info['file']['savename'])-4);
                $add_approval['file_url']             = substr($upload->rootPath,2).$info['file']['savepath'].$info['file']['savename'];
                if($style==1){//判断是否已经有数据
                    $where['file_id']                 = $user_id;
                    $files                            = M($table)->where($where)->find();
                    if($files){
                        unset($add_approval['createtime']);
                        $update                       = M($table)->where($where)->save($add_approval);
                        if($update){
                            return 1;die;
                        }
                        return 0;die;
                    }
                }
                $upload                                = M($table)->add($add_approval);
                if($upload){
                    if(empty($_COOKIE['xuequ_approval'])){
                        $approval                      = $add_approval['createtime'].','.$add_approval['file_size'].','.$add_approval['file_format'].','.$info['file']['savename'];
                    }else{
                        $approval                      =  $_COOKIE['xuequ_approval'].','.$add_approval['createtime'].','.$add_approval['file_size'].','.$add_approval['file_format'].','.$info['file']['savename'];
                    }
                    cookie('approval',$approval,18000);
                    return 1;die;
                }
            }
           return 0;die;
        }
        /**
         * 查询 approval_flie_update 文件修改表
         * $approval 文件的信息 二维数组
         */
        public function approval_update_sql($approval){
            foreach($approval as $key => $val){
                $where['file_id']                   = $val['id'];
                $update[$key]['file']               = $val;
                $update[$key]['flie_update']        = M('approval_flie_update')->where($where)->find();
                $update[$key]['flie_annotation']    = M('annotation_file')->where($where)->select();
            }
            return $update;
        }
        /**
         * 查询 approval_flie表的文件信息
         * $id 文件 id
         */
        public function approval_update($id){
            $file                                   = M('approval_flie')->where('id='.$id)->find();
            $user_id                                = explode(',',$file['file_account_id']);
            foreach($user_id as $key => $val){
                $userinfo['user'][$key]['username'] = username($val);
            }
            $file                                   = array_merge($file,$userinfo);
            return $file;
        }


        /**
         * 查询选取人员信息
         * $id 文件 id
         */
        public function user_info($file){

            $user_info = explode(',',$file['file_account_id']);

        }
    }