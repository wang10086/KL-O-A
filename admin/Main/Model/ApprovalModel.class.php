<?php
    namespace Main\Model;
    use Think\Model;
    use Sys\P;
    class ApprovalModel extends Model{

        //文件上传审批
        public function approval_upload($table,$user_id,$style){
            if($style==1){
                $table                                      = 'approval_flie_update';
                $add_approval['update_time']                = time();
                $userid                                     = $user_id;
                $add_approval['file_id']                    = $userid;
            }else{
                $userid                                     ='';
                foreach($user_id as $key =>$val){
                    if(!is_numeric($val)){
                        return 0;die;
                    }
                    $userid                                 .= $val.',';
                }
                $userid                                     = substr($userid,0,-1);
                $add_approval['file_account_id']            = $userid;
            }
            if(empty($userid)){
                return 0;die;
            }
            $upload                                         = new \Think\Upload();// 实例化上传类
            $upload->maxSize                                = 31457280000 ;// 设置附件上传大小
            $upload->exts                                   = array('doc','docx','pdf');// 设置附件上传类型
            $upload->rootPath                               = './upload/'; // 设置附件上传根目录
            $upload->subName                                = array('date', 'Ym');//文件upload下的文件名
            $info                                           =  $upload->upload();//上传文件
            if($info){
                //文件信息保存
                $add_approval['createtime']                 = time();
                $add_approval['account_id']                 = $_SESSION['userid'];
                $add_approval['account_name']               = user_table($_SESSION['userid'])['nickname'];
                $add_approval['file_size']                  = $info['file']['size'];
                $add_approval['file_format']                = $info['file']['ext'];
                $add_approval['file_name']                  = substr($info['file']['savename'],0,strlen($info['file']['savename'])-4);
                $add_approval['file_url']                   = substr($upload->rootPath,2).$info['file']['savepath'].$info['file']['savename'];
//print_r($add_approval);die;
                $upload                                     = M($table)->add($add_approval);

                if($upload){
                    if(empty($_COOKIE['xuequ_approval'])){
                        $approval                           = $add_approval['createtime'].','.$add_approval['file_size'].','.$add_approval['file_format'].','.$info['file']['savename'];
                    }else{
                        $approval                           =  $_COOKIE['xuequ_approval'].','.$add_approval['createtime'].','.$add_approval['file_size'].','.$add_approval['file_format'].','.$info['file']['savename'];
                    }
                    cookie('approval',$approval,18000);
                    return 1;die;
                }
            }
           return 0;die;
        }

        public function approval_update($id){
            return M('approval_flie')->where('id='.$id)->find();
        }
    }
