<include file="Index:header2" />





            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>资产领用</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Material/asset')}"><i class="fa fa-gift"></i> 资产列表</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Material/asset_out')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">资产领用</h3>
                                    <div class="pull-right box-tools">
                                        <if condition="rolemenu(array('Material/asset_out_record'))">
                                        <a href="{:U('Material/asset_out_record',array('material'=>$row['id']))}" class="btn btn-info btn-sm"><i class="fa fa-bars"></i> 领用记录</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <!-- text input -->
                                        
                                        <div class="form-group col-md-12">
                                            <label>资产名称</label>
                                            <input type="text" name="material" id="material_name"  class="form-control" value="{$row.material}" />
                                        </div>
                                        
                                        

                                        <div class="form-group col-md-4">
                                            <label>团号</label>
                                            <input type="text" name="info[order_id]" id="order_id" value="{$row.order_id}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>领取人</label>
                                            <input type="text" name="info[receive_liable]" id="receive_liable" value="{$row.receive_liable}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>库房负责人</label>
                                            <input type="text" name="info[storehouse_liable]" id="storehouse_liable" value="{$row.storehouse_liable}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>数量</label>
                                            <input type="text" name="info[amount]" id="amount" value="{$row.amount}"  class="form-control"  onBlur="javascript:sum();"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>折合价格</label>
                                            <input type="text" name="info[unit_price]" id="unit_price" value="{$price}"  class="form-control" readonly onBlur="javascript:sum();"  />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>合计</label>
                                            <input type="text" name="info[total]" id="total" value="{$row.total}"  class="form-control" readonly />
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <label>备注</label>
                                            <input type="text" name="info[remarks]" id="remarks" value="{$row.remarks}"  class="form-control" />
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group">&nbsp;</div>

                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-success btn-lg" id="lrpd">申请出库</button>
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
		selectmate();
		
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
	
	function sum(){
		var amount = $('#amount').val();
		var unit_price = $('#unit_price').val();
		var total = amount*unit_price;
		$('#total').val(total.toFixed(2));
	}
	
	function selectmate(){
			var id = $('#material_id').val();
			$.ajax({
               type: "POST",
               url: "<?php echo U('Material/mateinfo'); ?>",
			   dataType:'json', 
               data: {id:id},
               success:function(data){
                   if(data.id){
	                  $('#unit_price').val(data.price);
					  $('#materialname').val(data.material);
					  $('#stock').val(data.stock);
					  sum();
				   }
               }
           });	
		}
</script>	


     


