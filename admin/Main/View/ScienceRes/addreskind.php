<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>
				
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form role="form" method="post" action="{:U('ScienceRes/addreskind')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">科普资源类型</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <input type="hidden" name="info[type]" value="<?php echo Sys\P::RES_TYPE_SCIENCE; ?>" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        
                                        <input type="hidden" name="info[level]" readonly value="<?php echo $father['level'] + 1; ?>"/>
                                        <input type="hidden" name="info[pid]" value="{$father.id}" />
                                        <!-- text input -->
                                        <!--
                                        <div class="form-group col-md-6">
                                            <label>上级分类</label>
                                            <input type="text" disabled value="{$father.name}"  class="form-control" />
                    						<input type="hidden" name="info[pid]" value="{$father.id}" />
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>级别</label>
                                            
                                        </div>
                                        -->
                                        
                                        <div class="form-group col-md-12">
                                            <label>分类名称</label>
                                            <input type="text" name="info[name]" value="{$row.name}" class="form-control" />
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