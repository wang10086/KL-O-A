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
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <?php echo PHP_EOL . $__additional_css__ ?>

    </head>
    <body>

		<script type="text/javascript">
        window.gosubmint= function(){
			$('#gosub').submit();
		 } 
        </script>
       
        <section class="content">
            <form method="post" action="{:U('Finance/addcost')}" name="myform" id="gosub">
            <input type="hidden" name="dosubmit"  value="1">
            <input type="hidden" name="info[op_id]"  value="{$opid}">
            <div class="form-group box-float-12">
                <label>费用项目</label>
                <input type="text" name="info[item]"  class="form-control" />
            </div>
            
            <div class="form-group box-float-4">
                <label>数量</label>
                <input type="text" name="info[amount]"  id="amount" class="form-control"  onBlur="javascript:cost_sum();" />
            </div>
            
            <div class="form-group box-float-4">
                <label>单价</label>
                <input type="text" name="info[cost]" id="unit_price" class="form-control"  onBlur="javascript:cost_sum();"  value="0.00" />
            </div>
            
            <div class="form-group box-float-4">
                <label>合计</label>
                <input type="text" name="info[total]" id="total" class="form-control" readonly value="0.00" />
            </div>
            
            <div class="form-group box-float-12">
                <label>备注</label>
                <input type="text" name="info[remark]" class="form-control" />
            </div>
            </form>
            
        </section>


        <include file="Index:footer" />
        
        <script>
        function cost_sum(){
			var amount = $('#amount').val();
			var price = $('#unit_price').val();
			$('#total').val(amount*price);
		}
        </script>
       