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

        //文件详情
        public function Approval_details($id)
        {
            $approval_url = M('approval_flie_url')->where($id)->find();
            return $approval_url;
        }

        //修改文件及路径 $table表名 $where条件 $save 修改内容
        public function save_approval($table,$where,$save){

            $sql = M($table)->where($where)->find();
            if($sql){
                if($sql['account_id'] !== $_SESSION['userid']){
                    return 2;
                }
            }
            $sql_w = M($table)->where($where)->save($save);
            if($sql_w){
                return 1;
            }else{
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
                $where['account_id']        = $_SESSION['userid'];
            }
            return $where;
        }

        // 添加审批人员信息
        public function add_judgment($file,$judgment,$check){
            $arr                            = '';
            $array                          = '';
            foreach($judgment as $key => $val){
                $arr                        .= $val.',';
            }
            foreach($check as $key => $val){
                $array                      .= $val.',';
            }
            $where['file_id']               = $file['file_id'];
            $where['id']                    = $file['file_url_id'];
            $query = M('approval_flie_url')->where($where)->find();
            if($query){
                $update['status']           = 4;
                $save =  M('approval_flie_url')->where($where)->save($update);
                if($save){
                    $file['final_account_id']   = substr($arr,0,strlen($arr)-1);
                    $file['judgment_account_id']= substr($array,0,strlen($array)-1);
                    $file['createtime']         = time();
                    $file['account_id']         = $_SESSION['userid'];
                    $file['account_name']       = $_SESSION['name'];
                    $file['status']             = 4;
                    $add = M('approval_judgment')->add($file);
                    if($add){
                        return 1;die;
                    }
                }
            }
            return 0;
        }
    }