<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        员工考勤编辑
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">员工考勤编辑</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form role="form" method="post" action="{:U('Salary/salary_edtior')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">信息修改</h3>
                                </div><!-- /.box-header -->
                                <br>
                                    <div class="box-body">

                                        <div class="form-group col-md-2">
                                            <label>扣款：{$list.withdrawing}</label>
                                            <input type="hidden" name="info[withdrawing]" value="{$list.withdrawing}">
                                            <input type="hidden" name="id" value="{$list.id}">
                                        </div>
<br><br><br>

                                    <div class="form-group col-md-6">
                                        <label>病假天数</label>
                                        <input type="text" name="info[sick_leave]" id="rolename" value="{$list.sick_leave}"  class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>迟到/早退(15min以内)</label>
                                        <input type="text" name="info[late1]" value="{$list.late1}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>迟到/早退(15min以上)</label>
                                        <input type="text" name="info[late2]" id="rolename" value="{$list.late2}"  class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>事假天数</label>
                                        <input type="text" name="info[leave_absence]" value="{$list.leave_absence}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>旷工天数</label>
                                        <input type="text" name="info[absenteeism]" id="rolename" value="{$list.absenteeism}"  class="form-control" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        &nbsp;
                                    </div>


                                    <div class="form-group">&nbsp;</div>


                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                             </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript"> 

	$().ready(function(e) {
		$('#myform').validate();
	});
</script>	
            
<include file="Index:footer2" />