<include file="Index:header_mini" />

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="score-tit">
                <h1>{$title}</h1>
            </div>

            <form method="post" action="<?php echo U('Score/save_score'); ?>" id="myForm" onsubmit="return submitBefore()">
                <div class="content" style="padding: 5px;">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="token" value="{$token}">
                    <input type="hidden" name="info[partner_id]" value="{$partner_id}">
                    <!--<input type="hidden" name="info[quota_id]" value="{$quota_id}">-->

                    <?php if ($quota_id == 180){ ?>
                        <!--李徵红-->
                        <include file="quota_180" />
                    <?php }elseif($quota_id == 184){ ?>
                        <!--赵冬--讲座联络服务满意度-老科学家演讲团教务专员-->
                        <include file="quota_184" />
                    <?php }elseif($quota_id == 185){ ?>
                        <!--赵冬--日常服务工作满意度-老科学家演讲团教务专员 -->
                        <include file="quota_185" />
                    <?php }elseif($quota_id == 227){ ?>
                        <!--王丹--城市合伙人-满意度-->
                        <include file="quota_227" />
                    <?php }elseif($quota_id == 252){ ?>
                        <!--王茜--城市合伙人满意度-->
                        <include file="quota_252" />
                    <?php } ?>

                    <div align="center" class="form-group col-md-12">
                        <input type="button" class="btn btn-info" onclick="javascript:save('myForm',`<?php echo U('Score/save_score'); ?>`)" value="提交">
                    </div>

                </div>
            </form>
        </div><!-- /.col -->
    </div>
</section><!-- /.content -->


<script type="text/javascript">
    var uid         = <?php echo $uid?$uid:0; ?>;
    var quota_id    = <?php echo $quota_id?$quota_id:0; ?>;
    var title       = "<?php echo $title; ?>";
    var ym          = <?php echo $ym?$ym:0; ?>;
    var guide_id    = <?php echo $guide_id?$guide_id:0; ?>;
    var opid        = <?php echo $opid?$opid:0; ?>;
    var scoreMobile = <?php echo $scoreMobile?$scoreMobile:0; ?>;
    var host        = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    let partner_id  = <?php echo $partner_id?$partner_id:0; ?>;
    var dimension   = $('input[name="info[dimension]"]').val();
    $(function () {
        if(dimension == 5) { init_score_5(); }
        if(dimension == 4) { init_score_4(); }
        if(dimension == 3) { init_score_3(); }
        check_login(scoreMobile,host);
    })

    function check_login(scoreMobile,host) {  //辅导员满意度测评登录/答题
        if (scoreMobile == 0) {
            window.onload = function(){
                con_sure(host);
            }
        }
    }

    function con_sure(host){
        var a       = confirm('为了防止刷票,请您先使用手机号注册登陆!');
        if (a==true){
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=login&uid='+uid+'&kpi_quota_id='+quota_id+'&tit='+title+'&ym='+ym+'&guide_id='+guide_id+'&opid='+opid+'&partner_id='+partner_id;
        }else{
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=noScore';
        }
    }

    //初始化评分显示(5个维度)
    function init_score_5() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            pingfen('DD',res.DD);
            pingfen('EE',res.EE);
            $('#AA_num').val(res.AA);
            $('#BB_num').val(res.BB);
            $('#CC_num').val(res.CC);
            $('#DD_num').val(res.DD);
            $('#EE_num').val(res.EE);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
            pingfen('EE',5);
            $('#AA_num').val(5);
            $('#BB_num').val(5);
            $('#CC_num').val(5);
            $('#DD_num').val(5);
            $('#EE_num').val(5);
        }
    }

    //初始化评分显示(4个维度)
    function init_score_4() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            pingfen('DD',res.DD);
            $('#AA_num').val(res.AA);
            $('#BB_num').val(res.BB);
            $('#CC_num').val(res.CC);
            $('#DD_num').val(res.DD);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
            $('#AA_num').val(5);
            $('#BB_num').val(5);
            $('#CC_num').val(5);
            $('#DD_num').val(5);
        }
    }

    //初始化评分显示(3个维度)
    function init_score_3() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            $('#AA_num').val(res.AA);
            $('#BB_num').val(res.BB);
            $('#CC_num').val(res.CC);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            $('#AA_num').val(5);
            $('#BB_num').val(5);
            $('#CC_num').val(5);
        }
    }

    function pingfen(id,score) {
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score);
            }
        });
    }

    function submitBefore() {
        var AA_num      = $('#AA_num').val();
        var BB_num      = $('#BB_num').val();
        var CC_num      = $('#CC_num').val();
        var DD_num      = $('#DD_num').val();
        var EE_num      = $('#EE_num').val();
        var content     = $('textarea[name="content"]').val()
        var arr         = Array(1,2,3);
        var AA_res      = in_array(AA_num,arr);
        var BB_res      = in_array(BB_num,arr);
        var CC_res      = in_array(CC_num,arr);
        var DD_res      = in_array(DD_num,arr);
        var EE_res      = in_array(EE_num,arr);
        if ((AA_res || BB_res || CC_res || DD_res || EE_res) && !content){
            art_show_msg('请输入您的意见建议',3);
            return false;
        }else{
            $('#myForm').submit();
        }
    }

    function in_array(search,array){
        for(var i in array){
            if(array[i]==search){
                return true;
            }
        }
        return false;
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

