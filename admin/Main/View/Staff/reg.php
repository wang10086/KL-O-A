
<?php use Sys\P; ?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>员工心声注册</title>
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
          <script src="__HTML__/js/html5shiv.min.js"></script>
          <script src="__HTML__/js/respond.min.js"></script>

        <![endif]-->
    </head>
    <body class="bg-black">
        <header class="header" style="background-color: #3C8DBC; ">
            <a href="javascript:;" class="logo" style="background-color: #367FA9;color: #ffffff;">
                {:P::SYS_NAME}员工心声
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

        <span id="a"></span>
        <div class="form-box" id="registe-box">
            <div class="header">注册</div>
            <form method="post" action="{:U('Staff/reg')}" name="myform" id="myform">
                <input type="hidden" name="dosubmit" value="1" />
                <div class="box-body">
                    <div class="loginfrom gbg">
                        <ul>
                            <li>
                                <label>昵称</label>
                                <input type="text" class="text" name="info[nickname]" id="nickname" placeholder="请输入用户名" datatype="*2-8" nullmsg="请输入用户名！" >
                                <span class="Validform_checktip"></span>
                            </li>
                            <li>
                                <label>登录账号</label>
                                <input type="text" class="text" id="username" name="info[username]" placeholder="请输入登录账号" datatype="*2-8" nullmsg="请输入登录账号！" onblur="check_username()" />
                                <span class="Validform_checktip"></span>
                            </li>
                            <li  class="need">
                                <label>密码</label>
                                <input type="password" class=" text" name="password_1" placeholder="请输入6-16位长度密码" datatype="*6-16" nullmsg="请输入密码" maxlength="16" />
                                <span class="Validform_checktip"></span>
                            </li>
                            <li  class="need">
                                <label>确认密码</label>
                                <input type="password" class="text" name="password_2" placeholder="请输入确认密码" datatype="*6-16" recheck="password_1" nullmsg="请输入确认密码"  maxlength="16"/>
                                <span class="Validform_checktip"></span>
                            </li>
                            <li>
                                <label>验证码</label>
                                <input type="text" class="code" name="yzm_code" placeholder="请输入验证码" datatype="*4-4" maxlength="4" nullmsg="请输入验证码">
                                <img src="{:U('Staff/verify')}" class="yzmcode" onclick="this.src='{:U('Staff/verify')}'+'&'+Math.random()"  title="点击刷新">
                                <span class="Validform_checktip"></span>
                            </li>
                        </ul>
                    </div>

                    <div class="footer" style="margin-top:0;">
                        <button type="submit" class="btn bg-olive btn-block" style="width:200px; margin:0 auto 10px auto;">提交</button>
                        <div style="text-align:center"><a href="{:U('Staff/login')}">已有账号</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="{:U('Staff/index')}">游客登录</a></div>
                    </div>

                </div><!-- /.box-body -->
            </form>
        </div>


        <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.11.1.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="__HTML__/js/Validform_v5.3.2.js"></script>
        <script src="__HTML__/js/commen.js"></script>
        <script type="text/javascript">

            $(function(){
                $("#myform").Validform({
                    tiptype:function(msg,o,cssctl){
                        if(!o.obj.is("form")){
                            var objtip=o.obj.siblings(".Validform_checktip");
                            cssctl(objtip,o.type);
                            objtip.text(msg);
                        }
                    },
                    btnSubmit : ".btn-block",
                    ajaxPost:true,
                    callback:function(data){
                        var obj = eval(data);
                        if(obj.status == '1'){
                            showmsg('提示',obj.info);
                            setTimeout("window.location.href='{:U('Staff/login')}'",1500);
                        }else{
                            showmsg('提示',obj.info);
                        }
                    }
                });
            });

            function goback(){
                window.location.href="{:U('Index/reg')}";
            }

            function check_username(){
                var username = $('#username').val();
                if (username){
                    //验证用户名
                    $.ajax({
                        type: "POST",
                        url: "{:U('Staff/check_username')}",
                        dataType:'json',
                        data:{username:username},
                        success:function(msg){
                            if(msg=='nnn'){
                                showmsg('提示','该用户名已被使用');
                            }
                        },
                    });
                }else{
                    showmsg('提示','请输入用户名');
                }
            }

            function showmsg(title,content){
                var html = '<div class="showbox">';
                html += '<div class="showwin">';
                html += '<div class="showcontent">';
                html += '<div class="showtitle">'+title+'</div>';
                html += '<div class="showclose" onClick="closemsg()">X</div>';
                html += '<div class="showtext">'+content+'</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#a').append(html);
                $('.showbox').show();
            }
        </script>

    </body>
</html>