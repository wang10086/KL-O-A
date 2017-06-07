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
    <body>

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.guidelist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id         = $(element).find("input[name=id]").val();
					obj.name       = $(element).find("input[name=name]").val();
					obj.kind       = $(element).find("input[name=kind]").val();
					obj.sex        = $(element).find("input[name=sex]").val();
					obj.birthday   = $(element).find("input[name=birthday]").val();
					obj.fee        = $(element).find("input[name=fee]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Op/select_guide')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Op">
            <input type="hidden" name="a" value="select_guide">
            <select class="form-control" name="kind">
                <option value="0">类型</option>
                <foreach name="reskind" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <select class="form-control" name="sex">
                <option value="">性别</option>
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
            <input type="text" class="form-control" name="key"  placeholder="关键字" value="">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            
            </div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th class="sorting" data="name">姓名</th>
                    <th class="sorting" data="kind">类型</th>
                    <th class="sorting" data="sex">性别</th>
                    <th class="sorting" data="birthday">出生日期</th>
                    <th class="sorting" data="fee">费用</th>
                   	<th>擅长领域</th>
                </tr>
                <foreach name="lists" item="row">                      
                <tr class="guidelist">
                	<td align="center">
                    <input type="checkbox" value="{$row.id}">
                    <input type="hidden" name="id" value="{$row.id}">
                    <input type="hidden" name="name" value="{$row.name}">
                    <input type="hidden" name="kind" value="<?php echo $reskind[$row['kind']]; ?>">
                    <input type="hidden" name="sex" value="{$row.sex}">
                    <input type="hidden" name="birthday" value="{$row.birthday}">
                    <input type="hidden" name="fee" value="{$row.fee}">
                    </td>
                    <td><a href="{:U('GuideRes/res_view', array('id'=>$row['id']))}">{$row.name}</a></td>
                    <td><?php echo $reskind[$row['kind']]; ?></td>
                    <td>{$row.sex}</td>
                    <td>{$row.birthday}</td>
                    <td>{$row.fee}</td>
                    <td>{$row.field}</td>
                </tr>
                </foreach>		
                
            </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        