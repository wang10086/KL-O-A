<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/qa')}"><i class="fa fa-gift"></i> 品质报告</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Kpi/public_save')}" name="myform" id="myform">
                	<input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="savetype" value="3">
                    <input type="hidden" name="id" value="{$row.id}">

                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑品质报告</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">

                                        <div class="form-group col-md-6">
                                            <label>巡检标题：</label><input type="text" name="info[title]" class="form-control" value="{$row.title}" required />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>巡检类型：</label>
                                            <select class="form-control" name="info[type]" required>
                                                <option value="" selected disabled>==请选择==</option>
                                                <foreach name="qaqc_type" item="v" key="k">
                                                    <option value="{$k}" <?php if($k==$row['type']){ echo 'selected';} ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>发现日期：</label><input type="text" name="info[fd_date]" class="form-control inputdate"  value="<?php if($row['fd_date']){ echo date('Y-m-d',$row['fd_date']);} ?>" required />
                                        </div>

                                        <div class="form-group box-float-6">
                                            <label>陪同人员</label>
                                            <input type="text" name="info[ac_user_name]" value="{$row.ac_user_name}" id="ac_user_name" class="form-control" />
                                            <input type="hidden" name="info[ac_user_id]" value="{$row.ac_user_id}"  id="ac_user_id" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>问题描述：</label>
                                            <textarea name="info[fd_content]"  class="form-control" style="height:100px;" required>{$row.fd_content}</textarea>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                        <!--{:upload_m('uploadfile','files',$atts,'上传巡检资料')}-->
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div style="width:100%; text-align:center; margin-top:30px;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	$(document).ready(function(e) {
		var keywords = <?php echo $userkey; ?>;
        autocomplete_id('ac_user_name','ac_user_id',keywords);
	});

</script>
		