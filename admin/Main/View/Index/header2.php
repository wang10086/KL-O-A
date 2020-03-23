<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome 4.0.3-->
        <!--<link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        <!-- font Awesome 4.7.0-->
        <link href="__HTML__/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
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
        <!--jquery.raty-->
        <script type="text/javascript" src="__HTML__/score/lib/jquery.raty.min.js"></script>
        <script type="text/javascript">
        	//laydate.skin('molv');
        </script>
        <!--jquery.qrcode-->
        <script src="__HTML__/js/jquery.qrcode.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <?php echo $__additional_js__; ?>
        <?php echo $__additional_jscode__ ?>
        <script src="__HTML__/js/artDialog.js"></script>
        <!--<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>-->
        <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript" role='reload_public'></script>
        <script src="__HTML__/js/py/app.js" type="text/javascript"></script>
        <script src="__HTML__/js/iframeTools.js"></script>
        <script src="__HTML__/comm/charts/highcharts.js" type="text/javascript"></script>
        <script src="__HTML__/comm/plupload/plupload.full.min.js" type="text/javascript"></script>
		<script src="__HTML__/comm/charts/modules/exporting.js" type="text/javascript"></script>

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="{:U('index')}" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo P::SYSTEM_NAME; ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-btn-div">
                    <a href="{:U('Index/index')}" class="btn <?php if (in_array(CONTROLLER_NAME,$controller_names)){ echo "btn-primary"; }else{ echo "btn-info"; } ?>">门户</a>
                    <a href="{:U('Zprocess/public_index')}" class="btn <?php if (!in_array(CONTROLLER_NAME,$controller_names)){ echo "btn-primary"; }else{ echo "btn-info"; } ?> navbar-btn-r">流程</a>
                    <!--<a href="{:U('Index/index')}" class="btn btn-info">门户</a>
                    <a href="{:U('Zindex/index')}" class="btn btn-info navbar-btn-r">流程</a>-->
                </div>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php  echo cookie('name'); ?> <i class="caret"></i></span>
                            </a>

                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php if(cookie('userid')==C('RBAC_SUPER_ADMIN')){  echo '__HTML__/img/avatar0.png'; }else{ echo '__HTML__/img/avatar5.png';} ?>" class="img-circle" alt="User Image" />
                                    <p><?php  echo cookie('name'); ?></p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{:U('Rbac/adduser',array('id'=>cookie('userid')))}" class="btn btn-default btn-flat">修改资料</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{:U('Rbac/password',array('id'=>cookie('userid')))}" class="btn btn-default btn-flat">修改密码</a>
                                    </div>
                                </li>
                            </ul>


                        </li>
                        <li class="dropdown messages-menu">
                        	   <a href="{:U('Index/logout')}" class="dropdown-toggle">
                                <i class="fa fa-power-off"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

<div class="wrapper row-offcanvas row-offcanvas-left">

    <?php if (in_array(CONTROLLER_NAME,$controller_names)){ ?>
        <include file="Index:menu" />
    <?php }else{ ?>
        <include file="Index:Zmenu" />
    <?php } ?>

