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
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <?php echo PHP_EOL . $__additional_css__ ?>

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
					obj.kind           = $(element).find("input[name=kind]").val();
					obj.diqu           = $(element).find("input[name=diqu]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Product/add_supplier')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="add_supplier">
            
            <input type="text" class="form-control" name="key"  placeholder="关键字" >
            <select class="form-control" name="type">
                <option value="0">资源类型</option>
                <foreach name="reskind" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <select class="form-control" name="pro">
                <option value="0">适用业务类型</option>
                <foreach name="kinds" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="50" style="text-align:center">选择</th>
                    <th width="80" class="sorting" data="id">编号</th>
                    <th class="sorting" data="title">资源名称</th>
                    <th class="sorting" data="kind">类型</th>
                    <th class="sorting" data="diqu">所在地</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <input type="checkbox"  name="product[]" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                        <input type="hidden" name="kind" value="<?php echo $reskind[$row['kind']]; ?>">
                        <input type="hidden" name="diqu" value="{$row.diqu}">
                        </td>
                        <td>{$row.id}</td>
                        <td><a href="{:U('ScienceRes/res_view', array('id'=>$row['id']))}" target="_blank">{$row.title}</a></td>
                        <td><?php echo $reskind[$row['kind']]; ?></td>
                        <td>{$row.diqu}</td>
                        
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
        