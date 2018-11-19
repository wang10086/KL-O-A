<include file="Index:header2" />


            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>文件审批</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/Approval_Index')}">文件审批</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="tip">
                                        <a href="javascript:;"  class="btn btn-danger Approval_file_delete" style="padding:6px 12px;"><i class="fa fa-trash-o"></i> 删除</a>
<!--                                        <a href="{:U('Approval/Approval_Upload')}" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> 上传文件</a>-->
                                    </div>
                                    <a class="btn btn-info btn-sm" id="salary_create_file" onclick="javascript:salry_opensearch('searchtext',650,380,'创建文件');" style="float:right;margin:1em 2em 0em 0em;background-color:#f4543c"><b>+</b> 创建文件</a>
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
                                        <th style="text-align:center;width:5em;"><b>审批天数</b></th>
                                        <th style="text-align:center;width:5em;"><b>文件类别 </b></th>
                                        <th style="text-align:center;width:10em;"><b>操作</b></th>
                                    </tr>
                                    <foreach name="approval" item="app">
                                        <tr>
                                            <td align="center">
                                                <input type="checkbox" class="Approval_check" value="{$app['id']}"/>
                                            </td>
                                            <td style="text-align:center;">{$app['Approval']['id']}</td>
                                            <td style="text-align:center;color:#3399FF;">{$app['Approval']['account_name']}</td>
                                            <td style="text-align:center;"><a href="{:U('Approval/Approval_list',array('file_id'=>$app['Approval']['id']))}">{$app['Approval']['file_primary']}</a></td>
                                            <td style="text-align:center;"><?php if(is_numeric($app['Approval']['createtime'])){echo date('Y-m-d H:i:s',$app['Approval']['createtime']);}else{echo'';}?></td>
                                            <td style="text-align:center;">{$app['Approval']['file_date']} ( 天 )</td>
                                            <td style="text-align:center;"><?php if($app['Approval']['category']==1){echo "新建";}else{echo "修改";}?></td>
                                            <td style="text-align:center;">
                                                <a href="{:U('Approval/Approval_Upload',array('id'=>$app['Approval']['id']))}">
                                                    编辑文件
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

    <form action="{:U('Approval/create_file')}" method="post">

        <div class="form-group col-md-6">
            创建文件名称： <input type="text" style="margin-top:1em;" class="form-control"  name="file_name">
        </div>
        <div class="form-group col-md-6">
            审批完结天数：
            <input type="text" class="form-control" style="margin-top:1em;" name="file_date" placeholder="例：5" />
        </div>
        <div class="form-group col-md-6" >
            文件状态：
            <select name="status" style="margin-top:1em;" class="form-control">
                <option value="1" selected>新建</option>
                <option value="2">修改</option>
            </select>
        </div>
        <div class="form-group col-md-6" >
            创建人：
            <input type="text" class="form-control" style="margin-top:1em;" name="file_user" value="<?php echo $_SESSION['name']?>" disabled="disabled" />
        </div>
        <div class="form-group col-md-12">
            <a>审核描述：</a>
            <textarea rows="4" cols="70" style="margin-top:1em;"> </textarea>
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
        var id = '';
        $(".Approval_check:checkbox:checked").each(function(){
            var content = $(this).val();
                id += content+',';
            $(this).parents('tr').remove();
        });
        var status = 1;
        $.ajax({
            url:"{:U('Ajax/Ajax_file_delete')}",
            type:"POST",
            data:{'fileid':id,'status':status,},
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

    function salry_opensearch(obj,w,h,t){ //自制弹窗
        art.dialog({
            content:$('#'+obj).html(),
            lock:true,
            title: t,
            width:w,
            height:h,
            okValue: t,
            ok: function () {
                var file_name = $("input[name='file_name']").val();
                var file_date = $("input[name='file_date']").val();
                var status    = $(".aui_content option:selected").val();;
                var file_user = $("input[name='file_user']").val();
                var textarea  = $("textarea").val();
                $.ajax({
                    url:"{:U('Ajax/create_file')}",
                    type:"POST",
                    data:{
                        'file_name':file_name,
                        'file_date':file_date,
                        'status':status,
                        'file_user':file_user,
                        'textarea':textarea,
                    },
                    dataType:"json",
                    success:function(date){
                        if(date.sum==1){
                            alert(date.msg);
                        }else{
                            alert(date.msg);
                        }
                        window.location.reload();
                    }
                });
                $('.aui_content').remove()
            },
            cancelValue:'取消',
            cancel: function () {
            }
        }).show();
        $('.aui_buttons').find("aui_state_highlight").first().css("background-color","#00acd6");
    }
</script>
