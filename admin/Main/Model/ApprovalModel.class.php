<?php
    namespace Main\Model;
    use Think\Model;
    use Sys\P;
    class ApprovalModel extends Model
    {

        //文件详情
        public function Approval_details($id)
        {
            $approval_url = M('approval_flie_url')->where($id)->find();
            return $approval_url;
        }

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

    }