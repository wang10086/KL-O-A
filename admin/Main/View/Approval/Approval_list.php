<include file="Index:header2" />


            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件审批</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                        <li><a href="{:U('Approval/Approval_list',array('file_id'=>$file_id))}">文件列表</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="tip">
                                        <a href="javascript:;"  class="btn btn-danger Approval_file_delete" style="padding:6px 12px;">
                                            <i class="fa fa-trash-o"></i> 删除
                                        </a>
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);" style="float:right;padding:7px 12px;margin:0.7em 0em 0em 4em;" >
                                            <i class="fa fa-search"></i> 搜索
                                        </a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <table class="table table-bordered dataTable"  style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th style="text-align:center;width:6em;"/>
                                            <input type="checkbox" id="Approval_check"/>
                                        </th>
                                        <th style="text-align:center;width:6em;"><b>文件ID </b></th>
                                        <th style="text-align:center;width:10em;"><b>创建人姓名</b></th>
                                        <th style="text-align:center;width:10em;"><b>文件名称</b></th>
                                        <th style="text-align:center;width:10em;"><b>创建时间</b></th>
                                        <th style="text-align:center;width:10em;"><b>文件大小</b></th>
                                        <th style="text-align:center;width:9em;"><b>修改后拟稿名称</b></th>
                                        <th style="text-align:center;width:9em;"><b>修改拟稿人姓名</b></th>
                                        <th style="text-align:center;width:9em;"><b>修改后文件大小</b></th>
                                        <th style="text-align:center;width:9em;"><b>修改后上传时间</b></th>
                                        <th style="text-align:center;width:9em;"><b>状态</b></th>
                                        <th style="text-align:center;width:10em;"><b>操作</b></th>
                                    </tr>
                                    <foreach name="approval" item="app">
                                        <tr>
                                            <td align="center">
                                                <input type="checkbox" class="Approval_check" value="{$app['Approval']['id']}"/>
                                            </td>
                                            <td style="text-align:center;">{$app['Approval']['id']}</td>
                                            <td style="text-align:center;">{$app['Approval']['account_name']}</a></td>
                                            <td style="text-align:center;color:#3399FF;"><a href="{$app['Approval']['file_url']}">{$app['Approval']['file_name']}</a></td>
                                            <td style="text-align:center;"><?php if(is_numeric($app['Approval']['createtime'])){echo date('Y-m-d H:i:s',$app['Approval']['createtime']);}else{echo'';}?></td>
                                            <td style="text-align:center;color:#3399FF;">{$app['Approval']['file_size']}</td>
                                            <td style="text-align:center;">{$app['Approval']['modify_filename']}</td>
                                            <td style="text-align:center;">{$app['Approval']['modify_name']}</td>
                                            <td style="text-align:center;">{$app['Approval']['modify_size']}</td>
                                            <td style="text-align:center;"><?php if(is_numeric($app['Approval']['createtime'])){echo date('Y-m-d H:i:s',$app['Approval']['createtime']);}else{echo'';}?></td>
                                            <td style="text-align:center;">
                                                <?php if($app['Approval']['status']==1){echo"待上级审核";}elseif($app['Approval']['status']==2){echo"待综合审核";}elseif($app['Approval']['status']==3){echo"待各级领导审核";}elseif($app['Approval']['status']==4){echo"待最终审核";}elseif($app['Approval']['status']==5){echo"审核通过";}elseif($app['Approval']['status']==6){echo"审核驳回";}?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a href="{:U('Approval/Approval_Update',array('id'=>$app['Approval']['id']))}">
                                                    文件详情
                                                </a>
                                            </td>
                                        </tr>
                                     </foreach>

                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


<div id="searchtext">
    <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

    <form action="{:U('Approval/Approval_list')}" method="post">

        <div class="form-group col-md-6">
            文档名称： <input type="text" style="margin-top:1em;" class="form-control"  name="file_name">
        </div>
        <div class="form-group col-md-6">
            拟稿人姓名：
            <input type="text" class="form-control" style="margin-top:1em;" name="username" placeholder="" />
        </div>
    </form>
</div>

<include file="Index:footer2" />

<script type="text/javascript">

    // 文件选择
    $(document).ready(function(e) {
        //选择
        $('#Approval_check').on('ifChecked', function() {
            $('.Approval_check').iCheck('check');
        });
        $('#Approval_check').on('ifUnchecked', function() {
            $('.Approval_check').iCheck('uncheck');
        });
    });


    // 删除选择文件
    $('.Approval_file_delete').click(function(){
        var id          = '';
        $(".Approval_check:checkbox:checked").each(function(){
            var content = $(this).val();
                id      += content+',';
            $(this).parents('tr').remove();
        });
        var status      = 2;
        $.ajax({
            url:"{:U('Ajax/Ajax_file_delete')}",
            type:"POST",
            data:{'fileid':id,'status':status},
            dataType:"json",
            success:function(date){
                if(date.sum==1){
                    alert(date.msg);
                }else{
                    alert(date.msg);
                }
            }
        });
    });


</script>
