<include file="Index:header2" />





            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>资产入库</h1>
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
                            <form method="post" action="{:U('Material/asset_in')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">资产入库</h3>
                                    <div class="pull-right box-tools">
                                        <if condition="rolemenu(array('Material/into_record'))">
                                        <a href="{:U('Material/into_record',array('material'=>$row['id']))}" class="btn btn-info btn-sm"><i class="fa fa-bars"></i> 入库记录</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-12">
                                        <label>资产</label>
                                        <input type="text" name="material" id="material_name" value="{$row.material}"  class="form-control"  />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>入库类型</label>
                                        <select  class="form-control" name="info[type]" id="intotype" onChange="selecttype();">
                                            <option value="0">采购入库</option>
                                            <option value="1">资产归还</option>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label>团号</label>
                                        <input type="text" name="info[order_id]" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label><span class="typename">采购</span>部门</label>
                                        <select  class="form-control" name="info[department]">
                                        <option value="">请选择</option>
                                        <foreach name="rolelist"  item="v">
                                            <option value="{$v.id}">{$v.role_name}</option>
                                        </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>数量</label>
                                        <input type="text" name="info[amount]" id="amount" value="{$row.amount}"  class="form-control" onBlur="javascript:sum();" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>采购价格</label>
                                        <input type="text" name="info[unit_price]" id="unit_price" value="{$row.unit_price}"  class="form-control"  onBlur="javascript:sum();"  />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>合计</label>
                                        <input type="text" name="info[total]" id="total" value="{$row.total}"  class="form-control" readonly />
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label><span class="typename">采购</span>负责人</label>
                                        <input type="text" name="info[purchase_liable]" id="purchase_liable" value="{$row.purchase_liable}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>计调负责人</label>
                                        <input type="text" name="info[op_liable]" id="op_liable" value="{$row.op_liable}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>库房负责人</label>
                                        <input type="text" name="info[storehouse_liable]" id="storehouse_liable" value="{$row.storehouse_liable}"  class="form-control" />
                                    </div>
                                    
                                    
                                    <div class="form-group">&nbsp;</div>

                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-success btn-lg" id="lrpd">申请入库</button>
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
		sum();
		
		var keywords = <?php echo $keywords; ?>;
		$("#material_name").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
			 	 return '<span style=" display:none">'+row.pinyin+'</span>'+row.material;
			 },
			 formatResult: function(row) {
				 return row.material;
			 }
		});
		
	})
	
	function selecttype(){
		var type = $('#intotype').val();
		if(type=='1'){
			$('.typename').text('归还');
		}else{
			$('.typename').text('采购');
		}
	}
	
	function sum(){
		var amount = $('#amount').val();
		var unit_price = $('#unit_price').val();
		var total = amount*unit_price;
		$('#total').val(total.toFixed(2));
	}
	
	
	

        
</script>	


     


