<!--对计调评价-->
<div class="box box-warning" style="margin-top:15px;">
    <div class="box-header">
        <h3 class="box-title">对计调人员评价</h3>
        <h3 class="box-title pull-right" style="font-weight: normal; color: #000; margin-right: 20px;">计调负责人：{$jidiao.user_name}</h3>
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
                        <textarea name="info[content]" class="form-control" id="jd_content"  rows="2" placeholder="请输入对计调评价内容"></textarea>
                        <div class="form-group col-md-12"></div>

                    </div>
                </div>
                <div align="center" class="form-group col-md-12" style="alert:cennter;margin-top: 20px;">
                    <a  href="javascript:;" class="btn btn-info" onClick="javascript:submitBefore('save_jd_afterOpScore');" style="width:60px;">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!--对教务评价-->
<div class="box box-warning" style="margin-top:15px;">
    <div class="box-header">
        <h3 class="box-title">对教务人员评价</h3>
        <h3 class="box-title pull-right" style="font-weight: normal; color: #000; margin-right: 20px;">教务负责人：{$jiaowu.user_name}</h3>
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
                        <textarea name="info[content]" class="form-control" id="jw_content"  rows="2" placeholder="请输入对教务评价内容"></textarea>
                        <div class="form-group col-md-12"></div>

                    </div>
                </div>
                <div align="center" class="form-group col-md-12" style="alert:cennter;margin-top: 20px;">
                    <a  href="javascript:;" class="btn btn-info" onClick="javascript:submitBefore('save_jw_afterOpScore');" style="width:60px;">保存</a>
                </div>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var jd_res = <?php echo $jd_score ? $jd_score : 0; ?>; //计调评分结果
        var jw_res = <?php echo $jw_score ? $jw_score : 0; ?>; //教务评分结果
        init_score('save_jd_afterOpScore',jd_res,'jd_'); //初始化计调星星图标
        init_score('save_jw_afterOpScore',jw_res,'jw_'); //初始化教务星星
        init_radio_checked('save_jd_afterOpScore',jd_res); //初始化计调单选
        init_radio_checked('save_jw_afterOpScore',jw_res); //初始化教务单选
        init_radio();
    });

    //初始化评分显示(计调)
    function init_score(id,res,prefix) {
        if (res){
            $('#'+id).find('textarea[name="info[content]"]').html(res.content);
            $('#'+id).find('input[name="info[type]"]').val(res.type);

            pingfen(prefix+'AA',res.AA);
            pingfen(prefix+'BB',res.BB);
            pingfen(prefix+'CC',res.CC);
            pingfen(prefix+'DD',res.DD);
            pingfen(prefix+'EE',res.EE);
        }else{
            pingfen(prefix+'AA',5);
            pingfen(prefix+'BB',5);
            pingfen(prefix+'CC',5);
            pingfen(prefix+'DD',5);
            pingfen(prefix+'EE',5);
        }
    }

    /*//初始化评分显示(计调)
    function init_score_jw(id,res) {
        if (res){
            $('#jw_content').html(res.content);

            pingfen('jw_AA',res.AA);
            pingfen('jw_BB',res.BB);
            pingfen('jw_CC',res.CC);
            pingfen('jw_DD',res.DD);
            pingfen('jw_EE',res.EE);
        }else{
            pingfen('jw_AA',5);
            pingfen('jw_BB',5);
            pingfen('jw_CC',5);
            pingfen('jw_DD',5);
            pingfen('jw_EE',5);
        }
    }*/

    //页面初始化下面的内容自动选中
    function init_radio_checked(id,res){
        if (res){
            $('#'+id).find('.star_div').each(function () {
                $(this).find('input[name="info[AA]"][value="'+res.AA+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[BB]"][value="'+res.BB+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[CC]"][value="'+res.CC+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[DD]"][value="'+res.DD+'"]').parent('div').addClass('checked');
                $(this).find('input[name="info[EE]"][value="'+res.EE+'"]').parent('div').addClass('checked');
            })
        }else{
            $('#'+id).find('.star_div').each(function () {
                $(this).find('input[name="info[AA]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[BB]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[CC]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[DD]"][value="5"]').parent('div').addClass('checked');
                $(this).find('input[name="info[EE]"][value="5"]').parent('div').addClass('checked');
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

    function submitBefore(id){
        var AA_num          = parseInt($('#'+id).find('input[name="info[AA]"]').val());
        var BB_num          = parseInt($('#'+id).find('input[name="info[BB]"]').val());
        var CC_num          = parseInt($('#'+id).find('input[name="info[CC]"]').val());
        var DD_num          = parseInt($('#'+id).find('input[name="info[DD]"]').val());
        var EE_num          = parseInt($('#'+id).find('input[name="info[EE]"]').val());
        var content         = $('#'+id).find('textarea[name="info[content]"]').val();
        var arr             = Array(1,2,3);
        var AA_res          = in_array(AA_num,arr);
        var BB_res          = in_array(BB_num,arr);
        var CC_res          = in_array(CC_num,arr);
        var DD_res          = in_array(DD_num,arr);
        var EE_res          = in_array(EE_num,arr);
        if ((AA_res || BB_res || CC_res || DD_res || EE_res) && !content){
            art_show_msg('单项评分低于3分时,必须填写相关问题及改进意见',3);
            return false;
        }
        public_save(id,'<?php echo U('Op/public_save'); ?>');
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