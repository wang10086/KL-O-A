<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="__HTML__/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- jquery-ui style -->
        <link href="__HTML__/css/jQueryUI/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <!-- ArtDialog -->
        <link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
        <link href="__HTML__/css/artdialog/ui-dialog.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/comm/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="__HTML__/js/html5shiv.min.js"></script>
          <script src="__HTML__/js/respond.min.js"></script>
        <![endif]-->
        <?php echo PHP_EOL . $__additional_css__ ?>
         <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <!--JqueryUI-->
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui.js" type="text/javascript"></script>       
        <!--timepicker-->
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui-slide.min.js" type="text/javascript"></script>   
        <script src="__HTML__/js/plugins/jqueryui/jquery-ui-timepicker-addon.js" type="text/javascript"></script>     
        <!--artdialog-->
       
        <!-- FORM -->
        <script src="__HTML__/js/plugins/form/formvalidator.js" type="text/javascript"></script>
        <script src="__HTML__/js/plugins/form/formvalidatorregex.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="__HTML__/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="__HTML__/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        
        <script src="__HTML__/comm/laydate/laydate.js"></script>
        <script src="__HTML__/comm/jquery.autocomplete.min.js"></script>
		 <script type="text/javascript">
        	//laydate.skin('molv');
        </script>

        <!-- AdminLTE App -->
        <?php echo $__additional_js__; ?>
        <?php echo $__additional_jscode__ ?>
        <script src="__HTML__/js/public.js" type="text/javascript"></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/artDialog.js"></script> 
        <script src="__HTML__/js/iframeTools.js"></script> 
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
		 <script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>

    </head>
    <body>

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