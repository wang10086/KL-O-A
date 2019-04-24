
<form method="post" action="<?php echo U('Index/public_satisfaction_add'); ?>" id="myForm" onsubmit="return submitBefore()">
    <div class="content">
        <input type="hidden" name="dosubmint" value="1">
        <div class="content">
            <input type="hidden" id="AA_num" name="info[AA]" value="" />
            <input type="hidden" id="BB_num" name="info[BB]" value="" />
            <input type="hidden" id="CC_num" name="info[CC]" value="" />
            <input type="hidden" id="DD_num" name="info[DD]" value="" />

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

        <div align="center" class="form-group col-md-12" style="alert:cennter;margin-bottom: 20px;">
            <input type="submit" class="btn btn-info" value="提交">
        </div>

    </div>
</form>

<script type="text/javascript">
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


        init_score_4();
        init_score_5();
        //init_radio();
    });


    function pingfen(id,score) {
        $('#'+id+'_num').val(score);
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score); //改变星星

                $('#'+id).parent('.score').next('.star_div').find('input').each(function (index,ele) {
                    var input_val = $(this).val();
                    if (input_val == score){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                });
            }
        });
    }

    $('#account_id').change(function(){
        var account_id  = $('#account_id').val();
        var noBodyHtml  = '<div class="form-group col-md-12"> <div class="form-group mt20">暂无该员工的考核内容！</div> </div>';
        if (account_id){
            var html        = '';
            var arr1        = ['13','26','39','77']; //安全品控部 13=>杜莹,26=>李岩, 39=>孟华, 77=>王茜
            var textarea    = '<textarea name="content" class="form-control" id="content"  rows="2" placeholder="请输入评价内容"></textarea> <div class="form-group col-md-12"></div>';
            if (arr1.indexOf(account_id) == '-1'){
                $('#satisfaction_content').html(noBodyHtml);
                return false;
            }else{
                if (account_id == 26){ //李岩
                    var content = '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->'+
                        '<input type="hidden" name="data[AA]" value="及时性">'+
                        '<label>及时性：</label>'+
                        '<div class="demo score inline-block"><div id="AA"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[BB]" value="态度">'+
                        '<label>态度：</label>'+
                        '<div class="demo score inline-block"><div id="BB"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[CC]" value="品控公正性及合理性">'+
                        '<label>品控公正性及合理性：</label>'+
                        '<div class="demo score inline-block"><div id="CC"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="5">&nbsp;非常公正合理</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;较公正合理</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;不公正合理</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="1">&nbsp;非常不公正合理</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[DD]" value="流程优化有效性">'+
                        '<label>流程优化有效性：</label>'+
                        '<div class="demo score inline-block"><div id="DD"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="5">&nbsp;非常有效</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;有效</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;无效</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="1">&nbsp;负效果</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[EE]" value="培训与指导">'+
                        '<label>培训与指导：</label>'+
                        '<div class="demo score inline-block"><div id="EE"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>';
                    var html = content + textarea;
                    $('#satisfaction_content').html(html);
                    init_score_5();
                    init_radio();
                    return false;
                }else if(account_id == 39){ //孟华(查看评分人部门有无计调信息)
                    $.ajax({
                        type : 'POST',
                        dataType : 'JSON',
                        url : "{:U('Ajax/check_has_jd')}",
                        success:function (msg) {
                            if (msg == 1){ //有自己计调
                                var content = '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->'+
                                    '<input type="hidden" name="data[AA]" value="及时性">'+
                                    '<label>及时性：</label>'+
                                    '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[BB]" value="态度">'+
                                    '<label>态度：</label>'+
                                    '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[CC]" value="集中采购性价比">'+
                                    '<label>集中采购性价比：</label>'+
                                    '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="5">&nbsp;很高</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;高</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;低</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="1">&nbsp;很低</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[DD]" value="培训及指导">'+
                                    '<label>培训及指导：</label>'+
                                    '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>';
                                var html = content + textarea;
                                $('#satisfaction_content').html(html);
                                init_score_4();
                                init_radio();
                                return false;
                            }else{ //无自己部门计调
                                var content = '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->'+
                                    '<input type="hidden" name="data[AA]" value="及时性">'+
                                    '<label>及时性：</label>'+
                                    '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[BB]" value="态度">'+
                                    '<label>态度：</label>'+
                                    '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[CC]" value="集中采购性价比">'+
                                    '<label>集中采购性价比：</label>'+
                                    '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="5">&nbsp;很高</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;高</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;低</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[CC] value="1">&nbsp;很低</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[DD]" value="培训及指导">'+
                                    '<label>培训及指导：</label>'+
                                    '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[DD] value="1">&nbsp;非常不满意</span>'+
                                    '</div></div>'+
                                    '<div class="form-group col-md-6">'+
                                    '<input type="hidden" name="data[EE]" value="预算准确度">'+
                                    '<label>预算准确度：</label>'+
                                    '<div class="demo score inline-block"><div id="EE"></div></div>'+
                                    '<div class="form-control no-border star_div">'+
                                    '<span class="sco-star"><input type="radio" name=info[EE] value="5">&nbsp;非常准确</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;准确</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[EE] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;不准确</span>&emsp;&emsp;'+
                                    '<span class="sco-star"><input type="radio" name=info[EE] value="1">&nbsp;很不准确</span>'+
                                    '</div></div>';
                                var html = content + textarea;
                                $('#satisfaction_content').html(html);
                                init_score_5();
                                init_radio();
                                return false;
                            }
                        }
                    })
                }else if(account_id == 77){ //人事经理(王茜)
                    var content = '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                        '<input type="hidden" name="data[AA]" value="及时性">'+
                        '<label>及时性：</label>'+
                        '<div class="demo score inline-block"><div id="AA"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[BB]" value="态度">'+
                        '<label>态度：</label>'+
                        '<div class="demo score inline-block"><div id="BB"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[CC]" value="培训及指导">'+
                        '<label>培训及指导：</label>'+
                        '<div class="demo score inline-block"><div id="CC"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[DD]" value="招聘人员符合度">'+
                        '<label>招聘人员符合度：</label>'+
                        '<div class="demo score inline-block"><div id="DD"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="5">&nbsp;很高</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;高</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;低</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="1">&nbsp;很低</span>'+
                        '</div></div>';
                    var html = content + textarea;
                    $('#satisfaction_content').html(html);
                    init_score_4();
                    init_radio();
                    return false;
                }else if(account_id == 13){ //综合部经理(杜莹)
                    var content = '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->'+
                        '<input type="hidden" name="data[AA]" value="及时性">'+
                        '<label>及时性：</label>'+
                        '<div class="demo score inline-block"><div id="AA"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[AA] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[BB]" value="态度">'+
                        '<label>态度：</label>'+
                        '<div class="demo score inline-block"><div id="BB"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;较满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[BB] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[CC]" value="培训及指导">'+
                        '<label>培训及指导：</label>'+
                        '<div class="demo score inline-block"><div id="CC"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="5">&nbsp;很高</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;高</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;低</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[CC] value="1">&nbsp;很低</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[DD]" value="办公环境及条件符合度">'+
                        '<label>办公环境及条件符合度：</label>'+
                        '<div class="demo score inline-block"><div id="DD"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="5">&nbsp;超出需求</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;满足需求</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;满足部分需求</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[DD] value="1">&nbsp;完全不满足需求</span>'+
                        '</div></div>'+
                        '<div class="form-group col-md-6">'+
                        '<input type="hidden" name="data[EE]" value="企业文化及氛围">'+
                        '<label>企业文化及氛围：</label>'+
                        '<div class="demo score inline-block"><div id="EE"></div></div>'+
                        '<div class="form-control no-border star_div">'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="5">&nbsp;非常满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="3">&nbsp;一般</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;不满意</span>&emsp;&emsp;'+
                        '<span class="sco-star"><input type="radio" name=info[EE] value="1">&nbsp;非常不满意</span>'+
                        '</div></div>';
                    var html = content + textarea;
                    $('#satisfaction_content').html(html);
                    init_score_5();
                    init_radio();
                    return false;
                }
            }
        }else{
            var unRightHtml = '<div class="form-group col-md-12"> <div class="form-group mt20">请输入正确的员工信息！</div> </div>';
            $('#satisfaction_content').html(unRightHtml);
            return false;
        }
    });

    /*function init_radio(){
     $('.star_div').find('ins').each(function (index,ele) {
     $(this).click(function () {
     var score       = $(this).prev('input').val();
     var id          = $(this).parent('div').parent('span').parent('.star_div').prev('.score').children('div').attr('id');
     pingfen(id,score); //改变星星
     })
     })
     }*/
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