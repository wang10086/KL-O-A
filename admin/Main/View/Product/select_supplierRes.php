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
        <script src="__HTML__/js/artDialog.js"></script>
        <script src="__HTML__/js/public.js" type="text/javascript"></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/iframeTools.js"></script>
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
		 <script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>

    </head>
    <body style="background:#ffffff;">

		<script type="text/javascript">
        window.gosubmint= function(){
			//var rs = new Array();
            var obj = {};
            $('.supplierRes').each(function(index, element) {
				if ($(element).find(".iradio_minimal").attr('aria-checked')=='true') {
					obj.id             = $(element).find("input[name=id]").val();
					obj.name           = $(element).find("input[name=name]").val();
					//rs.push(obj);
				}
			});
            return obj;
		 }
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Product/public_select_supplierRes')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="public_select_supplierRes">
            <input type="hidden" name="kind" value="{$kind}">
            <input type="text" class="form-control" name="name"  placeholder="合格供方名称">
            <input type="text" class="form-control" name="city"  placeholder="所在城市">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="40" style="text-align:center">选择</th>
                    <th width="40" class="sorting" data="p.id">编号</th>
                    <th class="sorting" data="p.name">名称</th>
                    <th class="sorting" data="p.city">城市</th>
                    <th class="sorting" data="p.kind">类型</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="supplierRes">
                    	<td align="center">
                        <input type="radio"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="name" value="{$row.name}">
                        </td>
                        <td>{$row.id}</td>
                        <td><a href="{:U('SupplierRes/res_view', array('id'=>$row['id']))}" title="{$row.name}" target="_blank">{$row.name}</a></td>
                        <td>{$row.prov} - {$row.city}</td>
                        <td>{$supplierkind[$row['kind']]}</td>
                    </tr>
                </foreach>										
            </table>
            </form>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        