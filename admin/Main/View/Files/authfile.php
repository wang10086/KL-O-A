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
        <script src="__HTML__/comm/plupload/plupload.full.min.js" type="text/javascript"></script>
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
		<script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>
    </head>
    <body style="padding:0 15px 40px 15px;">

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			var rolse = '';
			$('.roles_check').each(function(index, element) {
				var checked = $(this).parent().attr('aria-checked');
				if(checked=="true"){
					rolse += '[' + $(this).attr('value') + '].';
				}
			});	
			
			var users = '';
			$('.users_check').each(function(index, element) {
				var checked = $(this).parent().attr('aria-checked');
				if(checked=="true"){
					users += '[' + $(this).attr('value') + '].';
				}
			});	
			
			var obj = {};
				obj.files     = '{$fid}';
				obj.rolse     = rolse;
				obj.users     = users;
				rs.push(obj);
			return rs;	
		 } 
        </script>
       
        <div style="width:100%; height:auto !important; float:left; overflow:hidden;">
        	<h3 style="font-size:14px; color:#e08e0b"><input type="checkbox" id="select_a"> 选择开放访问权限的部门</h3>
        	<div class="checkboxlist">
            	<foreach name="roles" item="row">
            	<div class="unlist"><input type="checkbox" value="{$row.id}" class="roles_check"> <span>{$row.role_name}</span></div>
                </foreach>
            </div>
        </div>
        
         <div style="width:100%; height:auto !important; float:right; overflow:hidden; border-top:1px solid #dedede; margin-top:20px;">
        	<h3 style="font-size:14px; color:#e08e0b""><input type="checkbox" id="select_b"> 选择开放访问权限的用户</h3>
        	<div class="checkboxlist">
            	<foreach name="users" item="row">
            		<if condition="$row['nickname']"><div class="uslist"><input type="checkbox" value="{$row.id}"  class="users_check"> <span>{$row.nickname}</span></div></if>
                </foreach>
            </div>
        </div>


        <include file="Index:footer" />
        
        <script type="text/javascript">
        $(document).ready(function(e) {
			//选择
			$('#select_a').on('ifChecked', function() {
				$('.roles_check').iCheck('check');
			});
			$('#select_a').on('ifUnchecked', function() {
				$('.roles_check').iCheck('uncheck');
			});
			
			//选择
			$('#select_b').on('ifChecked', function() {
				$('.users_check').iCheck('check');
			});
			$('#select_b').on('ifUnchecked', function() {
				$('.users_check').iCheck('uncheck');
			});
		});
        </script>
        
       