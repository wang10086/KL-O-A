
<?php use Sys\P; ?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>员工心声登录</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/css/staff.css?v=1.0.0" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <header class="header" style="background-color: #3C8DBC; ">
            <a href="javascript:;" class="logo" style="background-color: #367FA9;color: #ffffff;">
                科学国旅员工心声
            </a>

            <nav class="navbar navbar-static-top" role="navigation">

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown messages-menu">
                            <a href="{:U('Index/login')}" class="dropdown-toggle" style="color: #ffffff;">
                                返回OA系统
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="form-box" id="login-box">
            <div class="header">员工心声</div>
            <form id="loginform" method="post" class="form-vertical" action="{:U('Staff/login')}" />
            <input type="hidden" name="dosubmit" value="1" />
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="用户名或注册手机号"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="密码"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">进入系统</button>  
                    <div style="text-align:center"><a href="{:U('Staff/reg')}">注册账号</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="{:U('Staff/index')}">游客登录</a></div>
                </div>
            </form>
  
        </div>
        <!--<div style="width:100%; height:20px; position:fixed; left:0; bottom:20px; text-align:center; color:#ffffff;"><?php /*echo P::SYSTEM_NAME; */?> &copy; 版权所有</div>-->
        <div class="unbox copy">
            版权所有 &copy; 中科教科学教育平台 <a href="http://www.miitbeian.gov.cn" target="_blank">京ICP备12018327号</a>  &nbsp; <!--京公网安备110402500027号-->
        </div>

        <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.11.1.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>