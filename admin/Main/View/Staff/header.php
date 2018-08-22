<?php use Sys\P; ?>
<!DOCTYPE html>
<html style="min-height: 100%">
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
        <link href="__HTML__/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
        <!-- Ion Slider -->
        <link href="__HTML__/css/ionslider/ion.rangeSlider.css" rel="stylesheet" type="text/css" />
        <!-- ion slider Nice -->
        <link href="__HTML__/css/ionslider/ion.rangeSlider.skinNice.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap slider -->
        <link href="__HTML__/css/bootstrap-slider/slider.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/comm/liMarquee/liMarquee.css" rel="stylesheet" type="text/css"  />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css?v=1.0.8" rel="stylesheet" type="text/css" />
        <link href="__HTML__/comm/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/css/staff.css?v=1.0.0" rel="stylesheet" type="text/css" />
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
        
        <script src="__HTML__/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="__HTML__/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
       	<script src="__HTML__/js/plugins/ionslider/ion.rangeSlider.min.js" type="text/javascript"></script>
        <script src="__HTML__/js/plugins/bootstrap-slider/bootstrap-slider.js" type="text/javascript"></script>
        <!-- FORM -->
        <script src="__HTML__/js/plugins/form/formvalidator.js" type="text/javascript"></script>
        <script src="__HTML__/js/plugins/form/formvalidatorregex.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="__HTML__/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="__HTML__/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script src="__HTML__/comm/liMarquee/jquery.liMarquee.js" type="text/javascript"></script>
        <script src="__HTML__/comm/laydate/laydate.js"></script>
        <script src="__HTML__/comm/jquery.autocomplete.min.js"></script>
		<script type="text/javascript">
        	//laydate.skin('molv');
        </script>

        <!-- AdminLTE App -->
        <?php echo $__additional_js__; ?>
        <?php echo $__additional_jscode__ ?>
        <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/artDialog.js"></script> 
        <script src="__HTML__/js/iframeTools.js"></script> 
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
        <script src="__HTML__/comm/plupload/plupload.full.min.js" type="text/javascript"></script>
		<script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>

    </head>
    <body class="skin-blue" style="height: 100%">
        <header class="header">
            <a href="{:U('index')}" class="logo">
                科学国旅员工心声
            </a>

            <nav class="navbar navbar-static-top" role="navigation">

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                        	   <a href="{:U('Index/login')}" class="dropdown-toggle">
                                返回OA系统
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

