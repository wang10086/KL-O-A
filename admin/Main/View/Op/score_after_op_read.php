<!--对计调评价-->
<div class="box box-warning" style="margin-top:15px;">
    <div class="box-header">
        <h3 class="box-title">对计调人员评价</h3>
        <h3 class="box-title pull-right" style="font-weight: normal; margin-right: 20px;">
            <span class="green">评分状态：<?php if ($jd_score){ echo '<span class="green">已评分</span>'; }else{ echo "<span class='red'>未评分</span>"; } ?></span>
            <span style="color: #000; margin-left: 20px;"> 计调负责人：{$jidiao.user_name}</span>
        </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_jd_afterOpScore">
            <div class="content">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="savetype" value="23">
                <input type="hidden" name="opid" value="{$op.op_id}">
                <input type="hidden" name="info[type]" value="1">
                <input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->
                <div class="content" style="display:block;">
                    <input type="hidden" id="jd_AA_num" name="info[AA]" value="" />
                    <input type="hidden" id="jd_BB_num" name="info[BB]" value="" />
                    <input type="hidden" id="jd_CC_num" name="info[CC]" value="" />
                    <input type="hidden" id="jd_DD_num" name="info[DD]" value="" />
                    <input type="hidden" id="jd_EE_num" name="info[EE]" value="" />
                    <input type="hidden" name="info[account_id]" value="{$jidiao.user_id}" />
                    <input type="hidden" name="info[account_name]" value="{$jidiao.user_name}" />

                    <div style="width:100%;float:left;">
                        <div class="form-group col-md-6">
                            <label>服务态度：</label>
                            <input type="hidden" name="data[AA]" value="服务态度">
                            <div class="demo score inline-block"><div id="jd_AA"></div></div>
                            <div class="form-control no-border star_div">
                                <span class="sco-star"><input type="radio" name="info[AA]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[AA]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[AA]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[AA]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[AA]" value="1">&nbsp;非常不满意</span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>要素准备（房、餐、车、物资、导游）符合业务要求：</label>
                            <input type="hidden" name="data[BB]" value="要素准备（房、餐、车、物资、导游）符合业务要求">
                            <div class="demo score inline-block"><div id="jd_BB"></div></div>
                            <div class="form-control no-border star_div">
                                <span class="sco-star"><input type="radio" name="info[BB]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[BB]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[BB]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[BB]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[BB]" value="1">&nbsp;非常不满意</span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>业务人员培训，活动细节交接：</label>
                            <input type="hidden" name="data[CC]" value="业务人员培训，活动细节交接">
                            <div class="demo score inline-block"><div id="jd_CC"></div></div>
                            <div class="form-control no-border star_div">
                                <span class="sco-star"><input type="radio" name="info[CC]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[CC]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[CC]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[CC]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[CC]" value="1">&nbsp;非常不满意</span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>采购性价比：</label>
                            <input type="hidden" name="data[DD]" value="采购性价比">
                            <div class="demo score inline-block"><div id="jd_DD"></div></div>
                            <div class="form-control no-border star_div">
                                <span class="sco-star"><input type="radio" name="info[DD]" value="5">&nbsp;非常高</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[DD]" value="4">&nbsp;较高</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[DD]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[DD]" value="2">&nbsp;较低</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[DD]" value="1">&nbsp;非常低</span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>对活动实施过程中突发事件，应急处理稳妥、及时：</label>
                            <input type="hidden" name="data[EE]" value="对活动实施过程中突发事件，应急处理稳妥、及时">
                            <div class="demo score inline-block"><div id="jd_EE"></div></div>
                            <div class="form-control no-border star_div">
                                <span class="sco-star"><input type="radio" name="info[EE]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[EE]" value="4">&nbsp;满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[EE]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[EE]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                <span class="sco-star"><input type="radio" name="info[EE]" value="1">&nbsp;非常不满意</span>
                            </div>
                        </div>

                        <div class="form-group col-md-12"></div>
                        <label class="lit-title" style="width: 98%;margin: 0 1%">评价内容</label>
                        <textarea name="info[content]" class="form-control no-border" id="jd_content"  rows="2" placeholder="请输入对教务评价内容"></textarea>
                        <div class="form-group col-md-12"></div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--对教务评价-->
<?php if ($jiaowu['user_id']){ ?>
    <div class="box box-warning" style="margin-top:15px;">
        <div class="box-header">
            <h3 class="box-title">对教务人员评价</h3>
            <h3 class="box-title pull-right" style="font-weight: normal; color: #000; margin-right: 20px;">
                <span class="green">评分状态：<?php if ($jw_score){ echo '<span class="green">已评分</span>'; }else{ echo "<span class='red'>未评分</span>"; } ?></span>
                <span style="color: #000; margin-left: 20px;"> 教务负责人：{$jiaowu.user_name}</span>
            </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_jw_afterOpScore">
                <div class="content">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="savetype" value="23">
                    <input type="hidden" name="opid" value="{$op.op_id}">
                    <input type="hidden" name="info[type]" value="2">
                    <input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->
                    <div class="content" style="display:block;">
                        <input type="hidden" id="jw_AA_num" name="info[AA]" value="" />
                        <input type="hidden" id="jw_BB_num" name="info[BB]" value="" />
                        <input type="hidden" id="jw_CC_num" name="info[CC]" value="" />
                        <input type="hidden" id="jw_DD_num" name="info[DD]" value="" />
                        <input type="hidden" id="jw_EE_num" name="info[EE]" value="" />
                        <input type="hidden" name="info[account_id]" value="{$jiaowu.user_id}" />
                        <input type="hidden" name="info[account_name]" value="{$jiaowu.user_name}" />

                        <div style="width:100%;float:left;">
                            <div class="form-group col-md-6">
                                <label>迟到早退(准时性五颗星)：</label>
                                <input type="hidden" name="data[AA]" value="迟到早退(准时性五颗星)">
                                <div class="demo score inline-block"><div id="jw_AA"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name="info[AA]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[AA]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[AA]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[AA]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[AA]" value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>组织管理能力(组织好五颗星)：</label>
                                <input type="hidden" name="data[BB]" value="组织管理能力(组织好五颗星)">
                                <div class="demo score inline-block"><div id="jw_BB"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name="info[BB]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[BB]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[BB]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[BB]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[BB]" value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>课程质量(质量高五颗星)：</label>
                                <input type="hidden" name="data[CC]" value="课程质量(质量高五颗星)">
                                <div class="demo score inline-block"><div id="jw_CC"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name="info[CC]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[CC]" value="4">&nbsp;较满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[CC]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[CC]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[CC]" value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>师德仪表（无投诉五颗星）：</label>
                                <input type="hidden" name="data[DD]" value="师德仪表（无投诉五颗星）">
                                <div class="demo score inline-block"><div id="jw_DD"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name="info[DD]" value="5">&nbsp;非常高</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[DD]" value="4">&nbsp;较高</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[DD]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[DD]" value="2">&nbsp;较低</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[DD]" value="1">&nbsp;非常低</span>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>岗位执行(个人无私自调课、代课五颗星)：</label>
                                <input type="hidden" name="data[EE]" value="岗位执行(个人无私自调课、代课五颗星)">
                                <div class="demo score inline-block"><div id="jw_EE"></div></div>
                                <div class="form-control no-border star_div">
                                    <span class="sco-star"><input type="radio" name="info[EE]" value="5">&nbsp;非常满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[EE]" value="4">&nbsp;满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[EE]" value="3">&nbsp;一般</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[EE]" value="2">&nbsp;不满意</span>&emsp;&emsp;
                                    <span class="sco-star"><input type="radio" name="info[EE]" value="1">&nbsp;非常不满意</span>
                                </div>
                            </div>

                            <div class="form-group col-md-12"></div>
                            <label class="lit-title" style="width: 98%;margin: 0 1%">评价内容</label>
                            <textarea name="info[content]" class="form-control no-border" id="jw_content"  rows="2" placeholder="请输入对教务评价内容"></textarea>
                            <div class="form-group col-md-12"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>

<!--<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php /*echo $pingfen?$pingfen:0; */?>;
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
        public_save('save_afterOpScore','<?php /*echo U('Op/public_save'); */?>');
    }

    function in_array(search,array){
        for(var i in array){
            if(array[i]==search){
                return true;
            }
        }
        return false;
    }
</script>-->