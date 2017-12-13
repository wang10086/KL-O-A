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
                            <form method="post" action="{:U('Contract/add')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <input type="hidden" name="info[op_id]" id="op_id">
                                        <!-- text input -->
                                        
                                        <div class="col-md-4">
                                        	<label>项目团号</label>
                                            <div class="input-group">
                                                <input type="text"  name="info[group_id]" placeholder="团号" class="form-control" value="{$row.group_id}" id="groupid">
                                                <span class="input-group-addon" style="width:32px;"><a href="javascript:;" onClick="getop();" >获取</a></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group  col-md-4">
                                            <label>项目名称</label>
                                            <input type="text" name="info[pro_name]" class="form-control" id="proname" value="{$row.pro_name}"/>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4">
                                            <label>出团人数</label>
                                            <input type="text" name="info[number]" id="number"   value="{$row.number}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>出团时间</label>
                                            <input type="text" name="info[dep_time]" id="dep_time"   value="{$row.dep_time}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>结束时间</label>
                                            <input type="text" name="info[end_time]" id="end_time"   value="{$row.end_time}" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>合同金额</label>
                                            <input type="text" name="info[contract_amount]" id="contract_amount"   value="{$row.contract_amount}" class="form-control" />
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <label>备注</label>
                                            <textarea class="form-control" name="info[remarks]">{$row.remarks}</textarea>
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
            
<include file="Index:footer2" />
<script type="text/javascript">
function getop(){
	var gid = $('#groupid').val();
	if(gid){
		$.ajax({
			type: "GET",
			url: "<?php echo U('Ajax/getop'); ?>",
			dataType:'json', 
			data: {gid:gid},
			success:function(data){
				$('#proname').val(data.project);
				$('#number').val(data.renshu);
				$('#op_id').val(data.op_id);
				$('#dep_time').val(data.departure);
				$('#contract_amount').val(data.shouru);
			}
		});	
   }else{
	   art_show_msg('请输入团号');  
   }
}
</script>