<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			
			var rs = new Array();
		
			var obj = {};
			obj.id           = $("#material_id").val();
			obj.amount       = $("input[name=amount]").val();
			obj.materialname = $("input[name=materialname]").val();
			obj.stock        = $("input[name=stock]").val();
			obj.unit_price   = $("input[name=unit_price]").val();
			obj.total        = $("input[name=total]").val();
			obj.remarks      = $("input[name=remarks]").val();
			rs.push(obj);

			return rs;		
			
		 } 
        </script>
       
        <section class="content">
        	
            <div class="form-group box-float-12">
                <label>物资名称</label>
                <input type="text" name="materialname" id="material_name"  class="form-control" />
                <input type="hidden" name="material" id="material_id" value="">
                <input type="hidden" name="stock" id="stock" value="">
            </div>
            
            <div class="form-group box-float-4">
                <label>申请数量</label>
                <input type="text" name="amount" id="amount" class="form-control"  onBlur="javascript:selectmate();"/>
            </div>
            
            <div class="form-group box-float-4">
                <label>单价</label>
                <input type="text" name="unit_price" id="unit_price" class="form-control"  onBlur="javascript:sum();"  value="0.00" />
            </div>
            
            <div class="form-group box-float-4">
                <label>合计</label>
                <input type="text" name="total" id="total" class="form-control" readonly value="0.00" />
            </div>
            
            <div class="form-group box-float-12">
                <label>备注</label>
                <input type="text" name="remarks" id="remarks" class="form-control" />
            </div>
            
            
        </section>


        <include file="Index:footer" />
        <script type="text/javascript"> 
        
		$(document).ready(function() {	
			
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
            $('#total').val(total);
        }
		
		
		function selectmate(){
			var material = $('#material_name').val();
			var amount = $('#amount').val();
			$.ajax({
               type: "POST",
               url: "<?php echo U('Material/mateinfo'); ?>",
			   dataType:'json', 
               data: {material:material},
               success:function(data){
                   if(data.id){
	                  $('#unit_price').val(data.price);
					  $('#material_id').val(data.id);
					  $('#stock').val(data.stock);
					  var total = amount*data.price;
            		  $('#total').val(total);
				   }
               }
           });	
		}
        </script>	