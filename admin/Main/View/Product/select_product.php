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
        <script src="__HTML__/js/public.js" type="text/javascript"></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/artDialog.js"></script> 
        <script src="__HTML__/js/iframeTools.js"></script> 
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
		 <script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>

    </head>
    <body style="background:#ffffff;">

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.productlist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id             = $(element).find("input[name=id]").val();
					obj.title          = $(element).find("input[name=title]").val();
					obj.input_uname    = $(element).find("input[name=input_uname]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Product/select_product')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="select_product">
            
            <input type="text" class="form-control" name="key"  placeholder="关键字" value="{$keywords}">
            <select class="form-control" name="pro">
                <option value="0">适用业务类型</option>
                <foreach name="kinds" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <select class="form-control" name="age">
                <option value="0">适用年龄</option>
                <foreach name="ages" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <input type="text" class="form-control" name="zj" placeholder="专家">
            
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="40" style="text-align:center">选择</th>
                    <th width="40" class="sorting" data="id">编号</th>
                    <th class="sorting" data="p.title">模块名称</th>
                    <th class="sorting" data="p.input_uname">专家</th>
                    <th class="sorting" data="p.sales_price">参考成本价</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <input type="checkbox"  name="product[]" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                       
                        <input type="hidden" name="input_uname" value="{$row.input_uname}">
                        </td>
                        <td>{$row.id}</td>
                        <td><div style="width:180px;display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><a href="{:U('Product/view', array('id'=>$row['id']))}" target="_blank" title="{$row.title}">{$row.title}</a></div></td>
                        
                        <td>{$row.input_uname}</td>
                        <td>{$row.sales_price}</td>
                        
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
        