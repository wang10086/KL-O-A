<include file="Index:header2" />

<style>
    .file {
        position: relative;
        display: inline-block;
        background: #D0EEFF;
        border: 1px solid #99D3F5;
        border-radius: 4px;
        padding: 8px 15px;
        overflow: hidden;
        color: #1E88C7;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
    }
    .file input {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .file:hover {
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }
</style>
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                        <li><a href="">文件详情</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="tip" style="padding: 5px 12px;">
                                        <form method="post" action="{:U('Approval/Approval_file')}" enctype="multipart/form-data">
                                            <a href="javascript:;" class="file" style="float:left;background-color:#00acd6;color:#FFFFFF;"><i class="fa fa-upload"></i> 上传修改后文件
                                                <input type="file" name="file" id="approval_file">
                                                <input type="hidden" name="user_id" value="{$approval_file['id']}">
                                                <input type="hidden" name="style" value="1">
                                            </a>
                                            <button type="submit" id="approval_file_upload" style="width:6em;height:2.8em;background-color:#00acd6;border-radius:7px;font-size:1em;color:#ffffff;margin-left:1em;margin-top:1em;margin-top:-1em;">保 存</button>
                                            </form>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">


                                    <div >
                                        <table class="table table-bordered">
                                            <tr class="orders">
                                                <th class="sorting">ID</th>
                                                <th class="sorting">上传者</th>
                                                <th class="sorting">文件名称</th>
                                                <th class="sorting">文件大小</th>
                                                <th class="sorting">文件格式</th>
                                                <th class="sorting">上传时间</th>
                                            </tr>
                                            <tr>
                                                <td>{$approval_file['account_id']}</td>
                                                <td>{$approval_file['account_name']}</td>
                                                <td>{$approval_file['file_name']}.{$approval_file['file_format']}</td>
                                                <td>{$approval_file['file_size']}</td>
                                                <td>{$approval_file['file_format']}</td>
                                                <td><?php echo date('Y-m-d',$approval_file['createtime'])?></td>
                                            </tr>


                                    </div>



                                </div><!-- /.box-body -->
                              
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


<include file="Index:footer2" />


