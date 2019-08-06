<include file="Index:header2" />


            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        编辑线路分类
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/kind')}"><i class="fa fa-gift"></i> 线路分类列表</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">线路类型</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form role="form" method="post" action="{:U('Product/addkind')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <!-- text input -->
                                        
                                        <div class="form-group col-md-6">
                                            <label>上级分类</label>
                                            <input type="text" disabled value="{$father.name}"  class="form-control" />
                    						<input type="hidden" name="info[pid]" value="{$father.id}" />
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>级别</label>
                                            <input type="text" name="info[level]" readonly value="<?php echo $father['level'] + 1; ?>" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>分类名称</label>
                                            <input type="text" name="info[name]" value="{$row.name}" class="form-control" />
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12">
                                        	<button type="submit" class="btn btn-success">保存</button>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                        

                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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