<?php use Sys\P; ?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php //echo P::SYSTEM_NAME; ?>登录</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <!-- staff style 员工心声-->
        <link href="__HTML__/css/staff.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header"><?php echo P::SYSTEM_NAME; ?>登录</div>
            <form id="loginform" method="post" class="form-vertical" action="{:U('Index/login')}" />
            <input type="hidden" name="dosubmit" value="1" />
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="用户名"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="密码"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">进入系统</button>  
                </div>
            </form>
  
        </div>

        <a href="{:U('Staff/login')}"><div class="employee-aspirations"><i class="fa fa-hand-o-right"></i>&emsp14;员工心声</div></a>

        <div class="unbox copy">
            版权所有 &copy; 中科教科学教育平台 <a href="http://www.miitbeian.gov.cn">京ICP备12018327号</a>  &nbsp; <!--京公网安备110402500027号-->
        </div>

        <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.11.1.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>