<?php
namespace Main\Controller;
use Think\Controller;
use Think\Upload;
use Sys\P;
ulib('Page');
use Sys\Page;
class ApprovalController extends BaseController {

    /**
     * _initialize() 自动检测调用
     */
    public function _initialize()
    {
        $this->file_remind_number();//触发文件审核处理信息条数提醒
        D('Approval')->auto_auditing();//自动审核
    }

    /**
     * Approval_upload_file 默认上传文件
     * upload 上传文件方法
     */
    public function Approval_upload_file()
    {
        $db                 = M('attachment');
        $upload             = new Upload(C('UPLOAD_FILE_CFG'));
        $info               = $upload->upload();
        $att                = array();
        $rs                 = array();
        if ($info) {
            foreach ($info as $row) {
            $rs['rs']       = 'ok';
            $rs['fileurl']  = $upload->rootPath . $row['savepath'] . $row['savename'];
            $rs['msg']      = '上传成功';
                break;
            }
            echo json_encode($rs);
        } else {
            $rs['rs']       = 'err';
            $rs['msg']      = '上传失败';
            echo json_encode($rs);
        }
    }
    /**
     * Approval_file 保存文件
     * file_id 文件id
     */
    public function Approval_file()
    {
        $app            = D('Approval');
        $id             = I('file_id');
        $where['id']    = $id;
        $where['type']  = 1;
        $file           = M('approval_flie')->where($where)->find();
        if(!$file){unset($id);}
        if(empty($id)){
            $submit     = $app->submit_file();
        }else{
            $submit     = $app->update_file($id,$file);
        }
        if($submit==1){
            $this->success('保存成功！');
        }else{
            $this->error('数据错误!请重新打开！');
        }
    }

    /**
     * Approval_Upload 编辑文件 修改文件
     * id 文件id
     */
    public function Approval_Upload()
    {
        $where['id']        = I('id');
        if(is_numeric($where['id'])){ //判断是否有传值id

            $where['type']  = 1;
            $approval       = $this->approval_table('approval_flie',$where,1);//文件信息

            if(empty($approval['approval'][0]['id'])){
                $this->error('文件不存在！');
            }
            if($approval['approval'][0]['userid']!==$_SESSION['userid']){
                $this->error('您不是上传文件用户！不能编辑！');
            }
            $save           =  D('Approval')->Approval_Upload_save($where);//查询修改文件数据信息
            $this->save     = $save;
        }
        $key                = D('Approval')->Angements();//查询上级领导
        if($key==3){$this->error('数据错误!请重新打开！');}
        $this->userkey 	    = json_encode($key['key']);
        $this->userid       = $key['userid'];
        $this->approval     = $approval['approval'][0];
        $this->display();
    }

    /**
     * Approval_Index 首页显示
     * approval 列表信息
     * pages 分页
     */
    public function Approval_Index()
    {
        $where['type']     = 1;
        $approval          = $this->approval_table('approval_flie',$where,1);//获取首页信息
        $this->approval    = $approval['approval'];
        $this->pages       = $approval['pages'];
        $this->display();
    }
    /**
     * approval_table 优化查询
     * $approval_table 表名 $where 条件
     * $type 1 首页
     */
    public function approval_table($approval_table,$where,$type)
    {
        if ($type == 1) {
            $where['type']      = 1;
            $count              = M($approval_table)->where($where)->count();
            $page               = new Page($count, 10);
            $pages              = $page->show();
            $approval           = M($approval_table)->where($where)->limit("$page->firstRow", "$page->listRows")->order('createtime desc')->select();
        }
        $approval_w['approval'] = D('Approval')->select_sql($approval);
        $approval_w['pages']    = $pages;
        return $approval_w;
    }

    /**
     * file_delete 删除选中的文件
     * $fileid 文件id
     */
    public function file_delete()
    {
        $id         = I('id');
        if(is_numeric($id)){
            $delete = D('Approval')->filedelete($id);
        }else{
            $delete = 0;
        }
        if($delete==1){
            $this->success('删除成功！');die;
        }else{
            $this->error('删除失败！');die;
        }
    }
    /**
     * Approval_detele_file 删除 主件 附件
     * $id 文件id
     */
    public function Approval_detele_file()
    {
        $where['id'] =  I('id');
        $del         =  D('Approval')->Approval_detele_file($where);
        if($del==1){
            echo json_encode(array('msg' => '删除成功！'));die;
        }elseif($del==2){
            echo json_encode(array('msg' => '删除失败！'));die;
        }elseif($del==3){
            echo json_encode(array('msg' => '只能上传者本人删除！'));die;
        }
    }

    /**
     * Approval_Update 详情列表
     * $id 文件id
     */
    public function Approval_Update()
    {
        $id                     = trim(I('id'));
        if(is_numeric($id)){}else{$this->error('数据错误！');die;}
        $judge                  = M('approval_flie')->where('id='.$id)->find();
        if(!$judge){$this->error('您查看的数据不存在！请重新查看！');}
        $list                   = D('Approval')->file_details($id);//列表展示
        $approver               = D('Approval')->Approver(); // 选择审议人员
        $sql['employee_member'] = array('like',"A%");//查询 终审条件
        $office                 = D('Approval')->finaljudgment($sql,2); //选择终审人员

        $judgment               = explode(',', $list[0]['file_judgment']);//显示终审人员id
        $consider               = explode(',', $list[0]['file_consider']);//显示审议人员id
        $judgment_name          = D('Approval')->judgment_name($judgment,$id,$consider);//显示审议人员名称
        $query['file_id']       = $id;
        $annotation             = D('Approval')->table_sql('approval_annotation',$query,2);//批注信息
        $Printing               = D('Approval')->printing_info($list);//打印单 数据详细信息
        $this->statu            = D('Approval')->status($annotation,$judge,$consider,$judgment);//1显示0不显示批注框

        $this->printing         = $Printing;;//打印单 数据详细信息
        $this->annotation       = $annotation;//批注信息
        $this->approver         = $approver;// 选择审议人员
        $this->office           = $office;//选择终审人员
        $this->judgment         = $judgment_name;//显示终审人员名称、显示审议人员名称
        $this->sercer           = $_SERVER['SERVER_NAME'].'/';//路径前缀
        $this->list             = $list;//列表展示
        $this->display();
    }

    /**
     * add_final_judgment 添加终审和审批人员
     * check 审批人员id  judgment终审人员 id
     * file_id 文件id   file_url_id 文档id
     */
    public function add_final_judgment()
    {
        $file['id']   = trim($_POST['file_id']);
        $judgment     = $_POST['judgment'];
        $consider     = $_POST['consider'];
        if(!empty($consider) && !empty($judgment)){
            $type     = D('Approval')->add_judgment($file,$judgment,$consider);
        }
        if($type==1){
            $this->success('添加审批人成功！');
        }elseif($type==2){
            $this->error('请不要重复提交！');
        }else{
            $this->error('添加审批人失败！请重新提交！');
        }
    }

    /**
     * add_annotation 提交批注
     */
    public function add_annotation()
    {
        $status          = trim($_POST['status']);
        $comment         = trim($_POST['comment']);
        $file['file_id'] = trim($_POST['file_id']);
        $state           = D('Approval')->add_file_annotation($file,$comment,$status);
        if(strpos($state,'成功')){
            $this->success($state);
        }else{
            $this->error($state);
        }
    }
}










