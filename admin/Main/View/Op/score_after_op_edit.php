
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_afterOpScore">
    <div class="content" >
        <label class="lit-title" style="width: 98%;margin: 0 1%">请对计调人员作出评价
            <if condition="$jidiao['user_name']">
                <span style="float: right;clear: both;font-weight: normal;">计调负责人：{$jidiao.user_name}</span>
            </if>
        </label>
        <div class="content">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="savetype" value="22">
            <input type="hidden" name="opid" value="{$op.op_id}">
            <div class="content" id="guidelist" style="display:block;">
                <input type="hidden" id="ysjsx_num" name="info[ysjsx]" value="" />
                <input type="hidden" id="zhunbei_num" name="info[zhunbei]" value="" />
                <input type="hidden" id="peixun_num" name="info[peixun]" value="" />
                <input type="hidden" id="genjin_num" name="info[genjin]" value="" />
                <input type="hidden" id="yingji_num" name="info[yingji]" value="" />
                <input type="hidden" name="info[jd_uid]" value="{$jidiao.user_id}" />
                <input type="hidden" name="info[jd_uname]" value="{$jidiao.user_name}" />

                <div style="width:100%;float:left;">

                    <div class="form-group col-md-6">
                        <label>服务态度：</label>
                        <div class="demo score inline-block"><div id="ysjsx"></div></div>
                        <div class="form-control no-border star_div">
                            <span class="sco-star"><input type="radio" name="info[ysjsx]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[ysjsx]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[ysjsx]" value="3">&nbsp;一般</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[ysjsx]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[ysjsx]" value="1">&nbsp;非常不满意</span>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>要素准备（房、餐、车、物资、导游）符合业务要求：</label>
                        <div class="demo score inline-block"><div id="zhunbei"></div></div>
                        <div class="form-control no-border star_div">
                            <span class="sco-star"><input type="radio" name="info[zhunbei]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[zhunbei]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[zhunbei]" value="3">&nbsp;一般</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[zhunbei]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[zhunbei]" value="1">&nbsp;非常不满意</span>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>业务人员培训，活动细节交接：</label>
                        <div class="demo score inline-block"><div id="peixun"></div></div>
                        <div class="form-control no-border star_div">
                            <span class="sco-star"><input type="radio" name="info[peixun]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[peixun]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[peixun]" value="3">&nbsp;一般</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[peixun]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[peixun]" value="1">&nbsp;非常不满意</span>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>采购性价比：</label>
                        <div class="demo score inline-block"><div id="genjin"></div></div>
                        <div class="form-control no-border star_div">
                            <span class="sco-star"><input type="radio" name="info[genjin]" value="5">&nbsp;非常高</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[genjin]" value="4">&nbsp;较高</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[genjin]" value="3">&nbsp;一般</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[genjin]" value="2">&nbsp;较低</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[genjin]" value="1">&nbsp;非常低</span>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>对活动实施过程中突发事件，应急处理稳妥、及时：</label>
                        <div class="demo score inline-block"><div id="yingji"></div></div>
                        <div class="form-control no-border star_div">
                            <span class="sco-star"><input type="radio" name="info[yingji]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[yingji]" value="4">&nbsp;满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[yingji]" value="3">&nbsp;一般</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[yingji]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                            <span class="sco-star"><input type="radio" name="info[yingji]" value="1">&nbsp;非常不满意</span>
                        </div>
                    </div>

                    <div class="form-group col-md-12"></div>
                    <textarea name="info[jd_content]" class="form-control" id="jd_content"  rows="2" placeholder="请输入对计调评价内容"></textarea>
                    <div class="form-group col-md-12"></div>

                </div>
            </div>
            <div align="center" class="form-group col-md-12" style="alert:cennter;margin-top: 20px;">
                <a  href="javascript:;" class="btn btn-info" onClick="javascript:submitBefore();" style="width:60px;">保存</a>
            </div>
        </div>
    </div>
</form>



<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;
        init_score_5(res);  //初始化星星图标
        init_radio_checked(res); //初始化单选
        init_radio();
    });

    //初始化评分显示(5各维度)
    function init_score_5(res) {
        if (res){
            $('#jd_content').html(res.jd_content);

            pingfen('ysjsx',res.ysjsx);
            pingfen('zhunbei',res.zhunbei);
            pingfen('peixun',res.peixun);
            pingfen('genjin',res.genjin);
            pingfen('yingji',res.yingji);
        }else{
            pingfen('ysjsx',5);
            pingfen('zhunbei',5);
            pingfen('peixun',5);
            pingfen('genjin',5);
            pingfen('yingji',5);
        }
    }

    //页面初始化下面的内容自动选中
    function init_radio_checked(res){
        if (res){
            $('#save_afterOpScore').find('.star_div').each(function () {
                $(this).find('input[name="info[ysjsx]"][value="'+res.ysjsx+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[zhunbei]"][value="'+res.zhunbei+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[peixun]"][value="'+res.peixun+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[genjin]"][value="'+res.genjin+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[yingji]"][value="'+res.yingji+'"]').parent('div').addClass('checked');
            })
        }else{
            $('#save_afterOpScore').find('.star_div').each(function () {
                $(this).find('input[name="info[ysjsx]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[zhunbei]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[peixun]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[genjin]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[yingji]"][value="5"]').parent('div').addClass('checked');
            })
        }
    }

    function pingfen(id,score) {
        $('#'+id+'_num').val(score);
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score); //改变星星

                $('#'+id).parent('.score').next('.star_div').find('input').each(function (index,ele) { //改变下面的radio
                    var input_val = $(this).val();
                    if (input_val == score){
                        $(this).parent('div[class="iradio_minimal"]').addClass('checked');
                    }else{
                        $(this).parent('div').removeClass('checked')
                    }
                });
            }
        });
    }

    function init_radio(){
        $('.star_div').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var score   = $(this).prev('input').val();
                var id      = $(this).parents('.star_div').prev('.score').children('div').attr('id');
                $(this).siblings().attr('checked',false);
                $(this).siblings().removeClass('checked');
                pingfen(id,score); //改变星星
            })
        })
    }

    function submitBefore(){
        var ysjsx_num       = parseInt($('#ysjsx_num').val());
        var zhunbei_num     = parseInt($('#zhunbei_num').val());
        var peixun_num      = parseInt($('#peixun_num').val());
        var genjin_num      = parseInt($('#genjin_num').val());
        var yingji_num      = parseInt($('#yingji_num').val());
        var content         = $('#jd_content').val();
        var arr             = Array(1,2,3);
        var ysjsx_res       = in_array(ysjsx_num,arr);
        var zhunbei_res     = in_array(zhunbei_num,arr);
        var peixun_res      = in_array(peixun_num,arr);
        var genjin_res      = in_array(genjin_num,arr);
        var yingji_res      = in_array(yingji_num,arr);
        if ((ysjsx_res || zhunbei_res || peixun_res || genjin_res || yingji_res) && !content){
            art_show_msg('单项评分低于3分时,必须填写相关问题及改进意见',3);
            return false;
        }
        public_save('save_afterOpScore','<?php echo U('Op/public_save'); ?>');
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