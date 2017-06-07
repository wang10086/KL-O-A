<include file="Index:header2" />





            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>编辑固定资产</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Material/asset')}"><i class="fa fa-gift"></i> 固定资产</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Material/addasset')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑资产</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-4">
                                        <label>资产名称</label>
                                        <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>资产编号</label>
                                        <input type="text" name="info[mid]" id="mid" value="{$row.mid}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>分期</label>
                                        <input type="text" name="info[stages]" id="stages" value="{$row.stages}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>资产类型</label>
                                        <select  class="form-control" name="info[kind]">
                                        <option value="0">请选择</option>
                                        <foreach name="material_class" item="v">
                                            <option value="{$v.id}" <?php if ($row['kind'] && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{$v.name}</option>
                                        </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>资产规格</label>
                                        <input type="text" name="info[spec]" id="spec"   value="{$row.spec}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>单位(个/件)</label>
                                        <input type="text" name="info[unit]" id="unit" value="{$row.unit}"  class="form-control" />
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注</label>
                                        <input type="text" name="info[remark]" id="remark" value="{$row.remark}"  class="form-control" />
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

	$(document).ready(function() {	
		wz_type();
	})
	
	function wz_type(){
		var type = $('#wzlx').val();
		if(type==2){
			$('.weixian').show();	
		}else{
			$('.weixian').hide();	
		}	
	}
</script>	


     


