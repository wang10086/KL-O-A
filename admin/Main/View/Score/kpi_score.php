<include file="Index:header_mini" />

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <form method="post" action="<?php echo U('Inspect/satisfaction_add'); ?>" id="myForm" onsubmit="return submitBefore()">
                <div class="content">
                    <input type="hidden" name="dosubmint" value="1">
                    <div class="content">
                        <input type="hidden" id="AA_num" name="info[AA]" value="" />
                        <input type="hidden" id="BB_num" name="info[BB]" value="" />
                        <input type="hidden" id="CC_num" name="info[CC]" value="" />
                        <input type="hidden" id="DD_num" name="info[DD]" value="" />
                        <input type="hidden" id="EE_num" name="info[EE]" value="" />

                        <div id="satisfaction_content">
                            <div class="form-group col-md-6">
                                <input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->
                                <input type="hidden" name="data[AA]" value="支撑服务及时性">
                                <label>客户培训：</label>
                                <div class="demo score inline-block"><div id="AA"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="hidden" name="data[BB]" value="支撑服务态度">
                                <label>业务支持度：</label>
                                <div class="demo score inline-block"><div id="BB"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div align="center" class="form-group col-md-12" style="alert:cennter;margin-bottom: 20px;" id="submit-btn">
                        <input type="submit" class="btn btn-info" value="提交">
                    </div>

                </div>
            </form>
        </div><!-- /.col -->
    </div>
</section><!-- /.content -->

<!--<script>
    var confirm_id  = <?php /*echo $confirm_id?$confirm_id:0; */?>;
    var opid        = <?php /*echo $opid?$opid:0; */?>;
    var scoreMobile = <?php /*echo $scoreMobile?$scoreMobile:''; */?>;
    var host        = "<?php /*echo $_SERVER['SERVER_NAME']; */?>";

    $(function () {
        check_login(opid,scoreMobile,host,confirm_id);
    });

    function check_login(opid,scoreMobile,host,confirm_id) {  //辅导员满意度测评登录/答题
        if (scoreMobile == 0) {
            window.onload = function(){
                con_sure(host,opid,confirm_id);
            }
        }
    }

    function con_sure(host,opid,confirm_id){
        var a       = confirm('为了防止刷票,请您先使用手机号注册登陆!');
        if (a==true){
            window.location.href = 'http://'+host+'/op.php?m=Main&c=Score&a=login&opid='+opid+'&confirm_id='+confirm_id;
        }else{
            window.location.href = 'http://'+host+'/op.php?m=Main&c=Score&a=noScore';
        }
    }
</script>-->

<!--<script type="text/javascript" src="__HTML__/js/satisfaction.js?v=1.1"></script>-->
<script type="text/javascript">
    $('#submit-btn').hide();

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

    function init_score_4() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            pingfen('DD',res.DD);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
        }
    }

    function submitBefore(){
        var AA_num      = parseInt($('#AA_num').val());
        var BB_num      = parseInt($('#BB_num').val());
        var CC_num      = parseInt($('#CC_num').val());
        var DD_num      = parseInt($('#DD_num').val());
        var EE_num      = parseInt($('#EE_num').val());
        var content     = $('#content').val();
        var arr         = Array(1,2,3);
        var AA_res      = in_array(AA_num,arr);
        var BB_res      = in_array(BB_num,arr);
        var CC_res      = in_array(CC_num,arr);
        var DD_res      = in_array(DD_num,arr);
        var EE_res      = in_array(EE_num,arr);
        if ((AA_res || BB_res || CC_res || DD_res || EE_res) && !content){
            art_show_msg('单项评分低于3分时,必须填写评价内容',3);
            return false;
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
		 
