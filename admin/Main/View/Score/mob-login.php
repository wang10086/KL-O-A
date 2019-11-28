<?php use Sys\P; ?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?>登录评分</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="bg-black">
    <span id="a"></span>
        <div class="form-box" id="mob-registe-box">
            <div class="header">登录评分</div>
            <form method="post" action="{:U('Score/login')}" name="myform" id="myform">
            <input type="hidden" name="dosubmit" value="1" />
            <input type="hidden" name="uid" value="{$uid}">
            <input type="hidden" name="kpi_quota_id" value="{$quota_id}">
            <input type="hidden" name="yearMonth" value="{$yearMonth}">
            <input type="hidden" name="opid" value="{$opid}">
            <div class="sco-box-body">
                <div class="mob-loginfrom gbg">
                    <ul>
                        <li>
                            <label>手机号</label>
                            <input type="text" class="text mobile-input" id="mobile" name="mobile" placeholder="请输入手机号" datatype="m" nullmsg="" errormsg="" />
                            <span class="Validform_checktip"></span>
                        </li>
                        <li>
                            <label>校验码</label>
                            <input type="text" name="mobile_code" class="code mobile-code" placeholder="请输入验证码" datatype="n4-4" maxlength="4" />
                            <button class="verification-desc sendcode" onclick="send()">获取验证码</button>
                        </li>
                    </ul>
                </div>

                <div class="footer" style="margin-top:0;">
                    <button type="submit" class="btn bg-olive btn-block" style="width:80px; margin:0 auto 10px auto;">提交</button>
                    <!--<button type="submit" class="btn" style="width:80px; margin:0 auto 10px auto;">提交</button>-->
                    <!--<div style="text-align:center"><a href="{:U('Index/login')}">已有账号</a> &nbsp;&nbsp;|&nbsp;&nbsp;<a href="{:U('Index/backpwd')}">找回密码</a>--></div>
                </div>

            </div><!-- /.box-body -->
            </form>

        <!-- jQuery 1.11.1 -->
        <script src="__HTML__/js/jquery-1.11.1.min.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>      
        <script type="text/javascript" src="__HTML__/js/Validform_v5.3.2.js"></script>
        <script src="__HTML__/js/commen.js"></script>

        <script type="text/javascript">
            uid             = <?php echo $uid?$uid:0; ?>;
            quota_id        = <?php echo $quota_id?$quota_id:0; ?>;
            ym              = <?php echo $ym?$ym:0; ?>;
            guide_id        = <?php echo $guide_id?$guide_id:0; ?>;
            opid            = <?php echo $opid?$opid:0; ?>;
            title           = "<?php echo $title; ?>";

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
                    if(obj.status == 'y'){
                        showmsg('提示', obj.info);
                        setTimeout("window.location.href='/index.php?m=Main&c=Score&a=kpi_score&uid='+uid+'&kpi_quota_id='+quota_id+'&tit='+title+'&ym='+ym+'&guide_id='+guide_id+'&opid='+opid",1500);
                    }else{
                        showmsg('提示',obj.info);
                    }
                }
            });
        });

        /* function goback(){
            window.location.href="{:U('Index/reg')}";
        }*/

        //重发验证码
        var wait=60;
        function time() {
            if (wait == 0) {
                $('.sendcode').removeAttr('disabled').removeClass('send').html('获取验证码');
                wait = 60;
            } else {
                $('.sendcode').attr("disabled", true).addClass('send').html("稍后，[" + wait + "s]");
                wait--;
                setTimeout(function() {
                        time()
                    },
                    1000)
            }
        }

        //发送验证码
        function send(){
            var  mobile = $("#mobile").val();
            var  token  = "<?php echo $token; ?>";
            if(mobile){
                //提交表单
                $.ajax({
                    type: "POST",
                    url: "{:U('Ajax/send_code')}",
                    dataType:'json',
                    data:{mobile:mobile,rand:parseInt(10000*Math.random()),token:token},
                    success:function(data){
                        showmsg('提示',data.info);
                        if(data.status=='n'){ return false; }
                        time();
                    },
                    error:function () {
                        showmsg('提示','失败');
                    }
                });

            }else{
                showmsg('提示','请输入手机号码');
            }
        }

        function showmsg(title,content){
            var html = '<div class="mob-showbox">';
            html += '<div class="showwin">';
            html += '<div class="showcontent">';
            html += '<div class="showtitle">'+title+'</div>';
            html += '<div class="showclose" onClick="close_msg()">X</div>';
            html += '<div class="showtext">'+content+'</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#a').append(html);
            $('.mob-showbox').show();
        }

        function close_msg(){
            $('.mob-showbox').remove();
        }
    </script>
    </body>
</html>