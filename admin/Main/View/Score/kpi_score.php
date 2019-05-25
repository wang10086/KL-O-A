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
                    <div class="contentAA">
                        <input type="hidden" id="AA_num" name="info[AA]" value="" />
                        <input type="hidden" id="BB_num" name="info[BB]" value="" />
                        <input type="hidden" id="CC_num" name="info[CC]" value="" />
                        <input type="hidden" id="DD_num" name="info[DD]" value="" />
                        <input type="hidden" id="EE_num" name="info[EE]" value="" />

                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->
                            <input type="hidden" name="info[AA_title]" value="客户沟通（我方人员服务态度、及时性；方案、价格传递的及时性、准确性）">
                            <label>1、客户沟通（我方人员服务态度、及时性；方案、价格传递的及时性、准确性）：</label>
                            <div class="demo score inline-block"><div id="AA"></div></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[BB_title]" value="产品培训（产品核心价值、亮点准确传达给合作方，使合作方深入了解产品特性）">
                            <label>2、产品培训（产品核心价值、亮点准确传达给合作方，使合作方深入了解产品特性）：</label>
                            <div class="demo score inline-block"><div id="BB"></div></div>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[CC_title]" value="推广支撑（宣传推广、市场开拓等方面给予合作方支持，是否利于合作方销售产品）">
                            <label>3、推广支撑（宣传推广、市场开拓等方面给予合作方支持，是否利于合作方销售产品）：</label>
                            <div class="demo score inline-block"><div id="CC"></div></div>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[DD_title]" value="业务实施（房、餐、车、辅导员、专家、中科院资源等要素的满意度）">
                            <label>4、业务实施（房、餐、车、辅导员、专家、中科院资源等要素的满意度）：</label>
                            <div class="demo score inline-block"><div id="DD"></div></div>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="info[EE_title]" value="持续合作（我方提供的服务能够满足长期、深入合作的需要，有意愿建立持续合作关系）">
                            <label>5、持续合作（我方提供的服务能够满足长期、深入合作的需要，有意愿建立持续合作关系）：</label>
                            <div class="demo score inline-block"><div id="EE"></div></div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>意见建议：</label>
                            <textarea name="content" class="form-control"  rows="2" placeholder="请输入意见建议"></textarea>
                        </div>

                    </div>

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
    var scoreMobile = <?php echo $scoreMobile?$scoreMobile:0; ?>;
    var host        = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    $(function () {
        init_score_5();
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
            window.location.href = 'http://'+host+'/index.php?m=Main&c=Score&a=login&uid='+uid;
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
		 
