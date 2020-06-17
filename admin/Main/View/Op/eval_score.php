<include file="Index:header_mini" />

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="score-tit">
                <h1>{$list.project}</h1>
            </div>

            <form method="post" action="<?php echo U('Op/public_eval_score'); ?>" id="myForm" onsubmit="return submitBefore()">
                <div class="content" style="padding: 5px;">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="opid" value="{$list.op_id}">
                    <input type="hidden" name="id" value="{$id}">
                    <input type="hidden" name="token" value="{$token}">

                    <div class="form-group col-md-12">
                        <label>活动问题反馈：</label>
                        <textarea name="problem" class="form-control"  rows="5" placeholder="问题反馈"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>意见建议：</label>
                        <textarea name="content" class="form-control"  rows="5" placeholder="请输入意见建议"></textarea>
                    </div>

                    <div align="center" class="form-group col-md-12">
                        <input type="button" class="btn btn-info" onclick="javascript:save('myForm',`<?php echo U('Op/public_eval_score'); ?>`)" value="提交">
                    </div>

                </div>
            </form>
        </div><!-- /.col -->
    </div>
</section><!-- /.content -->


<script type="text/javascript">
    var opid        = <?php echo $list['op_id']?$list['op_id']:0; ?>;
    var mobile      = <?php echo $mobile?$mobile:0; ?>;
    var host        = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    $(function () {
        if (mobile == 0) {
            window.onload = function(){
                con_sure(host);
            }
        }
    })


    function con_sure(host){
        var a       = confirm('为了防止刷票,请您先使用手机号注册登陆!');
        if (a==true){
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Op&a=public_eval_login&opid='+opid;
        }else{
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=noScore';
        }
    }

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };


    //保存信息
    function save(id,url){
        var host            = "{$_SERVER['SERVER_NAME']}";
        var success_url     = "http://"+host+"/index.php?m=Main&c=Score&a=scored";
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data.num)>0){
                    art.dialog.alert(data.msg,'success');
                    window.location.href = success_url;
                }else{
                    art.dialog.alert(data.msg,'warning');
                    setTimeout("history.go(0)",1000);
                }
                return false;
            }
        });


    }

</script>




<include file="footer" />

