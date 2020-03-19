<include file="Index:header2" />

<script type="text/javascript">
    window.onload = function(){
        $('#dept').hide();
    }
</script>

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>审核记录</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Work/record')}"><i class="fa fa-gift"></i> 工作记录</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                     
                     
                     
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">
                             记录信息
                            </h3>
                            <?php /*if($row['contract_id']){ */?><!--
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">工单编号：{$row.contract_id}</span></h3>
                            --><?php /*} */?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                            	<div class="form-group col-md-12">
                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">记录信息</h2>
                                </div>
                                <div class="form-group col-md-12">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                    <tr>
                                        <td colspan="3">记录标题：{$info.title}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">姓名：{$info.user_name}</td>
                                        <td width="33.33%">所在部门：{$info.dept_name}</td>
                                        <td width="33.33%">记录月份: {$info.month}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">纪录性质：{$info.type_name}</td>
                                        <td width="33.33%">详细分类：{$info.kf_name}</td>
                                        <td width="33.33%">记录状态：{$info.sta}</td>
                                    </tr>
                                </table>
                                </div>

                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">发起者信息</h2>
                                </div>
                                <div class="form-group col-md-12">
                                    <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                        <tr>
                                            <td width="33.33%">发起者姓名：{$info.rec_user_name}</td>
                                            <td width="33.33%">发起者职务：{$info.rec_dept_name}</td>
                                            <td width="33.33%">记录生成时间：{$info.rec_time|date='Y-m-d H:i:s',###}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">记录内容</h2>
                                </div>
                                <div class="form-group col-md-12">
                                    {$info.content}
                                </div>

                            </div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->

                <div class="col-md-12">
                    <?php if(rolemenu(array('Worder/verify_record')) || cookie('roleid')== 10){ ?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">审核工作记录</h3>
                        </div>
                        <form method="post" action="{:U('Worder/verify_record')}" name="myform1" >
                        <input type="hidden" name="dosubmint" value="1">
                        <input type="hidden" name="id" value="{$info.id}">
                        <div class="box-body">
                            <div class="form-group col-md-12" style="margin-top:10px; ">
                                <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                    <input type="radio" name="info[status]" value="0" <?php if($info['status'] == 0){echo "checked";} ?> > 审核通过
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="info[status]" value="1" <?php if($info['status'] == 1){echo "checked";} ?> > 审核不通过
                                </div>
                            </div>
                            <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                <button class="btn btn-success btn-lg">确认提交</button>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>


            </div>   <!-- /.row -->
            
        </section><!-- /.content -->
        
    </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
