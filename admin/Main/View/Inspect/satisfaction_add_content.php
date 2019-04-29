
<form method="post" action="<?php echo U('Inspect/satisfaction_add'); ?>" id="myForm" onsubmit="return submitBefore()">
    <div class="content">
        <input type="hidden" name="dosubmint" value="1">
        <div class="form-group col-md-12">
            <div class="callout callout-info">
                <h4>提示！</h4>
                <p>1、请您客观评价，被评分人不会看到您的具体评分内容，只会看到所有人的总评分结果！</p>
                <p>2、目前可搜索评分人员：秦鸣、王丹、李徴红、孟华、程小平、王茜、杜莹、李岩、魏春竹。</p>
            </div>
        </div>
        <div class="content">
            <input type="hidden" id="AA_num" name="info[AA]" value="" />
            <input type="hidden" id="BB_num" name="info[BB]" value="" />
            <input type="hidden" id="CC_num" name="info[CC]" value="" />
            <input type="hidden" id="DD_num" name="info[DD]" value="" />
            <input type="hidden" id="EE_num" name="info[EE]" value="" />

            <div class="form-group col-md-6">
                <label>被评价人员姓名：</label>
                <input type="text" name="info[account_name]"  class="form-control" id="account_name"  style="width: 50%;" required  />
                <input type="hidden" name="info[account_id]" id="account_id">
            </div>

            <div class="form-group col-md-6">
                <label id="ctrq">评分月份：</label><input type="text" name="monthly"  class="form-control monthly"  style="width: 50%;" required />
            </div>

            <div id="satisfaction_content">
                <div class="form-group col-md-12">
                    <div class="form-group mt20">请先选择被考评人员！</div>
                </div>
                <!--<div class="form-group col-md-6">
                    <label>支撑服务态度：</label>
                    <div class="demo score inline-block"><div id="AA"></div></div>
                    <div class="form-control no-border star_div">
                        <span class="sco-star"><input type="radio" name="info[AA]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[AA]" value="4">&nbsp;满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[AA]" value="3">&nbsp;较满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[AA]" value="2">&nbsp;一般</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[AA]" value="1">&nbsp;不满意</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>支撑服务效果：</label>
                    <div class="demo score inline-block"><div id="BB"></div></div>
                    <div class="form-control no-border star_div">
                        <span class="sco-star"><input type="radio" name="info[BB]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[BB]" value="4">&nbsp;满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[BB]" value="3">&nbsp;较满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[BB]" value="2">&nbsp;一般</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[BB]" value="1">&nbsp;不满意</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>支撑服务及时性：</label>
                    <div class="demo score inline-block"><div id="CC"></div></div>
                    <div class="form-control no-border star_div">
                        <span class="sco-star"><input type="radio" name="info[CC]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[CC]" value="4">&nbsp;满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[CC]" value="3">&nbsp;较满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[CC]" value="2">&nbsp;一般</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[CC]" value="1">&nbsp;不满意</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>公正及合理性：</label>
                    <div class="demo score inline-block"><div id="DD"></div></div>
                    <div class="form-control no-border star_div">
                        <span class="sco-star"><input type="radio" name="info[DD]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[DD]" value="4">&nbsp;满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[DD]" value="3">&nbsp;较满意</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[DD]" value="2">&nbsp;一般</span>&emsp;&emsp;
                        <span class="sco-star"><input type="radio" name="info[DD]" value="1">&nbsp;不满意</span>
                    </div>
                </div>-->
            </div>
        </div>

        <div align="center" class="form-group col-md-12" style="alert:cennter;margin-bottom: 20px;" id="submit-btn">
            <input type="submit" class="btn btn-info" value="提交">
        </div>

    </div>
</form>

<script type="text/javascript" src="__HTML__/js/satisfaction.js?v=1.1"></script>
<script type="text/javascript">
    $('#submit-btn').hide();
    var user_keywords   = <?php echo $userkey; ?>;

    $(function() {
        $("#account_name").autocomplete(user_keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#account_id").val(item.id);
            $('#account_id').change();
        });

    });

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
        var arr         = Array(1,2,3,);
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


</script>