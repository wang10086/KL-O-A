<include file="Index:header_mini" />

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="score-tit">
                <h1>{$title}</h1>
            </div>
            <form method="post" action="<?php echo U('Inspect/satisfaction_add'); ?>" id="myForm" onsubmit="return submitBefore()">
                <div class="content">
                    <input type="hidden" name="dosubmint" value="1">
                    <div class="content">
                        <input type="hidden" id="AA_num" name="info[AA]" value="" />
                        <input type="hidden" id="BB_num" name="info[BB]" value="" />
                        <input type="hidden" id="CC_num" name="info[CC]" value="" />
                        <input type="hidden" id="DD_num" name="info[DD]" value="" />
                        <input type="hidden" id="EE_num" name="info[EE]" value="" />

                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->
                            <input type="hidden" name="data[AA]" value="支撑服务及时性">
                            <label>客户培训：</label>
                            <div class="demo score inline-block"><div id="AA"></div></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" name="data[BB]" value="支撑服务态度">
                            <label>业务支持度：</label>
                            <div class="demo score inline-block"><div id="BB"></div></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>意见建议：</label>
                            <textarea name="content" class="form-control"  rows="2" placeholder="请输入意见建议"></textarea>
                        </div>

                    </div>

                    <div align="center" class="form-group col-md-12">
                        <input type="submit" class="btn btn-info" value="提交">
                    </div>

                </div>
            </form>
        </div><!-- /.col -->
    </div>
</section><!-- /.content -->


<script type="text/javascript">
    var uid         = <?php echo $uid?$uid:0; ?>;
    var quota_id    = <?php echo $quota_id?$quota_id:0; ?>;
    var year        = {$year};
    var month       = "{$month}";
    var type        = {$type};
    var scoreMobile = <?php echo $scoreMobile?$scoreMobile:0; ?>;
    var host        = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    $(function () {
        init_score_5();
        //check_login(scoreMobile,host);
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
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=login&uid='+uid+'&quota_id='+quota_id+'&year='+year+'&month='+month+'&type='+type;
        }else{
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=noScore';
        }
    }

    //初始化评分显示(5各维度)
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
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
            pingfen('EE',5);
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


    function init_radio(){
        $('.star_div').find('input').each(function (index,ele) {
            $(this).click(function () {
                var score   = $(this).val();
                var id      = $(this).parent('span').parent('.star_div').prev('.score').children('div').attr('id');
                $(this).siblings().attr('checked',false)
                $(this).siblings().removeClass('checked');
                pingfen(id,score); //改变星星
            })
        })
    }


    function submitBefore() {
        var account_id      = $('#account_id').val();
        if (!account_id){
            art_show_msg('人员信息错误');
            return false;
        }else{
            $('#myForm').submit();
        }
    }


</script>


        
        
<include file="footer" />
		 
