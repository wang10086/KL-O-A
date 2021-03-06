
function pingfen(id,score) {
    $('#'+id+'_num').val(score);
    $('#'+id).raty({
        number: 10, //星星数量
        score: score ,
        click: function(score, evt) {
            //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
            $('#'+id+'_num').val(score); //改变星星
            $('#'+id).parent('.score').next('.star_div').find('input').each(function (index,ele) {
                var input_val = $(this).val();
                /*if (input_val == score){
                    $(this).attr('checked',true);
                    $(this).addClass('checked');
                }else{
                    $(this).attr('checked',false);
                    $(this).removeClass('checked');
                }*/
                if (in_array(score, Array(1,2))){
                    if (in_array(input_val, Array(1,2))){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                        $(this).val(score);
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                }else if (in_array(score, Array(3,4))){
                    if (in_array(input_val, Array(3,4))){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                        $(this).val(score);
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                }else if (in_array(score, Array(5,6))){
                    if (in_array(input_val, Array(5,6))){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                        $(this).val(score);
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                }else if (in_array(score, Array(7,8))){
                    if (in_array(input_val, Array(7,8))){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                        $(this).val(score);
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                }else if (in_array(score, Array(9,10))){
                    if (in_array(input_val, Array(9,10))){
                        $(this).attr('checked',true);
                        $(this).addClass('checked');
                        $(this).val(score);
                    }else{
                        $(this).attr('checked',false);
                        $(this).removeClass('checked');
                    }
                }
            });
        }
    });
}

$('#account_id').change(function(){
    change_score_content();
});

$('#account_name').change(function () {
    change_score_content();
})

function change_score_content() {
    var account_id  = $('#account_id').val();
    var account_name= $('#account_name').val();
    var noBodyHtml  = '<div class="form-group col-md-12"> <div class="form-group mt20">暂无该员工的考核内容！</div> </div>';
    if (account_id){
        $.ajax({
            type : 'POST',
            dataType : 'JSON',
            url : "/index.php?m=Main&c=Ajax&a=check_userinfo",
            data : {account_id:account_id,account_name:account_name},
            success: function (msg) {
                if (msg == 1){ //名字和id匹配
                    var html        = '';
                    var arr1        = ['12','13','16','18','26','31','39','55','77','114','204','82','106']; //12=>秦鸣,13=>杜莹,16=>黄鑫磊,18=>戴明,26=>李岩,31=>魏春竹, 39=>孟华,55=>程小平,77=>王茜,114=>王丹,204=>李徵红,82=>'吕严',106=>杨晓旺
                    var textarea    = '<div class="form-group col-md-12"> <label>相关问题</label> <input class="form-control" id="problem" name="problem" type="text" placeholder="请输入具体问题"> </div>'+
                        '<div class="form-group col-md-12"> <label>改进建议</label> <textarea name="content" class="form-control" id="content"  rows="2" placeholder="请输入改进建议，要具体，可量化"></textarea> </div>'+
                        '<div class="form-group col-md-12"></div>';
                    if (arr1.indexOf(account_id) == '-1'){
                        $('#satisfaction_content').html(noBodyHtml);
                        $('#submit-btn').hide();
                        return false;
                    }else{
                        if (account_id == 26){ //李岩
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="及时性">'+
                                '<label>及时性：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="态度">'+
                                '<label>态度：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="品控公正性及合理性">'+
                                '<label>品控公正性及合理性：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常公正合理</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;较公正合理</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不公正合理</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不公正合理</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="流程优化有效性">'+
                                '<label>流程优化有效性：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常有效</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;有效</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;无效</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;负效果</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[EE]" value="培训与指导">'+
                                '<label>培训与指导：</label>'+
                                '<div class="demo score inline-block"><div id="EE"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_5();
                            init_radio();
                            return false;
                        }else if(account_id == 39){ //孟华(查看评分人部门有无计调信息)
                            var url   = "/index.php?m=Main&c=Ajax&a=check_has_jd";
                            $.ajax({
                                type : 'POST',
                                dataType : 'JSON',
                                url : url,
                                success:function (msg) {
                                    if (msg == 1){ //有自己计调
                                        var content = '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                            '<input type="hidden" name="data[AA]" value="及时性">'+
                                            '<label>及时性：</label>'+
                                            '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[BB]" value="态度">'+
                                            '<label>态度：</label>'+
                                            '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[CC]" value="集中采购性价比">'+
                                            '<label>集中采购性价比：</label>'+
                                            '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;很高</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;高</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;低</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;很低</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[DD]" value="培训及指导">'+
                                            '<label>培训及指导：</label>'+
                                            '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>';
                                        var html = content + textarea;
                                        $('#satisfaction_content').html(html);
                                        $('#submit-btn').show();
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
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[BB]" value="态度">'+
                                            '<label>态度：</label>'+
                                            '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[CC]" value="集中采购性价比">'+
                                            '<label>集中采购性价比：</label>'+
                                            '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;很高</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;高</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;低</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;很低</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[DD]" value="培训及指导">'+
                                            '<label>培训及指导：</label>'+
                                            '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[EE]" value="预算准确度">'+
                                            '<label>预算准确度：</label>'+
                                            '<div class="demo score inline-block"><div id="EE"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[EE] value="10">&nbsp;非常准确</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[EE] value="8">&nbsp;准确</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[EE] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;不准确</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;很不准确</span>'+
                                            '</div></div>';
                                        var html = content + textarea;
                                        $('#satisfaction_content').html(html);
                                        $('#submit-btn').show();
                                        init_score_5();
                                        init_radio();
                                        return false;
                                    }
                                }
                            })
                        }else if(account_id == 77){ //人事经理(王茜)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="6"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="工作及时性">'+
                                '<label>工作及时性：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="工作态度">'+
                                '<label>工作态度：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                '<label>培训及指导：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="招聘人员符合度">'+
                                '<label>招聘人员符合度：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[EE]" value="办公环境需求符合度">'+
                                '<label>办公环境需求符合度：</label>'+
                                '<div class="demo score inline-block"><div id="EE"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[EE] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[FF]" value="企业文化及氛围">'+
                                '<label>企业文化及氛围：</label>'+
                                '<div class="demo score inline-block"><div id="FF"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[FF] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[FF] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[FF] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[FF] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[FF] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_6();
                            init_radio();
                            return false;
                        }else if(account_id == 13){ //综合部经理(杜莹)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="对外销售资料发布">'+
                                '<label>对外销售资料发布：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="宣传及品牌建设">'+
                                '<label>宣传及品牌建设：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="市场调研分析">'+
                                '<label>市场调研分析：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="市场营销及推广">'+
                                '<label>市场营销及推广：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 55){ //财务经理(程小平)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="服务与支持">'+
                                '<label>服务与支持：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="工作态度">'+
                                '<label>工作态度：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                '<label>培训及指导：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="工作要求准确性">'+
                                '<label>工作要求准确性：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常准确</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;准确</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不准确</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;多次反复</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 114){ //市场经理(王丹)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="及时性">'+
                                '<label>及时性：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="态度">'+
                                '<label>态度：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                '<label>培训及指导：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="宣传及文案需求符合度">'+
                                '<label>宣传及文案需求符合度：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 204){ //资源经理(李徵红)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="及时性">'+
                                '<label>及时性：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="态度">'+
                                '<label>态度：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                '<label>培训及指导：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="资源提供符合度">'+
                                '<label>资源提供符合度：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 12){ //研发经理(秦鸣)
                            var url     = "/index.php?m=Main&c=Ajax&a=check_has_yf";
                            $.ajax({
                                type : 'POST',
                                dataType : 'JSON',
                                url : url,
                                success : function (msg) {
                                    if (msg ==1){ //有自己研发
                                        var content = '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                            '<input type="hidden" name="data[AA]" value="支撑服务及时性">'+
                                            '<label>支撑服务及时性：</label>'+
                                            '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[BB]" value="支撑服务态度">'+
                                            '<label>支撑服务态度：</label>'+
                                            '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                            '<label>培训及指导：</label>'+
                                            '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[DD]" value="标准化产品需求符合度">'+
                                            '<label>标准化产品需求符合度：</label>'+
                                            '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                            '</div></div>';
                                        var html = content + textarea;
                                        $('#satisfaction_content').html(html);
                                        $('#submit-btn').show();
                                        init_score_4();
                                        init_radio();
                                        return false;
                                    }else{ //无自己研发
                                        var content = '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                            '<input type="hidden" name="data[AA]" value="支撑服务及时性">'+
                                            '<label>支撑服务及时性：</label>'+
                                            '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[BB]" value="支撑服务态度">'+
                                            '<label>支撑服务态度：</label>'+
                                            '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[CC]" value="培训及指导">'+
                                            '<label>培训及指导：</label>'+
                                            '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                            '</div></div>'+
                                            '<div class="form-group col-md-6">'+
                                            '<input type="hidden" name="data[DD]" value="产品研发符合度">'+
                                            '<label>产品研发符合度：</label>'+
                                            '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                            '<div class="form-control no-border star_div">'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                            '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                            '</div></div>';
                                        var html = content + textarea;
                                        $('#satisfaction_content').html(html);
                                        $('#submit-btn').show();
                                        init_score_4();
                                        init_radio();
                                        return false;
                                    }
                                }
                            })
                        }else if(account_id == 31){ //京区研发主管(魏春竹)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="支撑服务质量">'+
                                '<label>支撑服务质量：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="成本要素性价比">'+
                                '<label>成本要素性价比：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="支撑服务及时性">'+
                                '<label>支撑服务及时性：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="产品需求符合度">'+
                                '<label>产品需求符合度：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不符合</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;很差</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 82){ //资源专员(吕严)
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="3"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="资源对接及时性">'+
                                '<label>资源对接及时性：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="困难及问题协调效果">'+
                                '<label>困难及问题协调效果：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="资源培训及辅导效果">'+
                                '<label>资源培训及辅导效果：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_3();
                            init_radio();
                            return false;
                        }else if(account_id == 106){ //采购主管(杨晓旺)
                            //包括：；；；
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="采购质量">'+
                                '<label>采购质量：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="采购价格">'+
                                '<label>采购价格：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="及时性">'+
                                '<label>及时性：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="交接及问题处理">'+
                                '<label>交接及问题处理：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }else if(account_id == 16 || account_id ==18){ //16黄鑫磊,18戴明
                            var content = '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                                '<input type="hidden" name="data[AA]" value="产品中专业内容质量">'+
                                '<label>产品中专业内容质量：</label>'+
                                '<div class="demo score inline-block"><div id="AA"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[AA] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[BB]" value="及时性">'+
                                '<label>及时性：</label>'+
                                '<div class="demo score inline-block"><div id="BB"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="8">&nbsp;较满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[BB] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[CC]" value="服务态度">'+
                                '<label>服务态度：</label>'+
                                '<div class="demo score inline-block"><div id="CC"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[CC] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>'+
                                '<div class="form-group col-md-6">'+
                                '<input type="hidden" name="data[DD]" value="专业培训支持">'+
                                '<label>专业培训支持：</label>'+
                                '<div class="demo score inline-block"><div id="DD"></div></div>'+
                                '<div class="form-control no-border star_div">'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="10">&nbsp;非常满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="8">&nbsp;满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="6">&nbsp;一般</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="4">&nbsp;不满意</span>&emsp;&emsp;'+
                                '<span class="sco-star"><input type="radio" name=info[DD] value="2">&nbsp;非常不满意</span>'+
                                '</div></div>';
                            var html = content + textarea;
                            $('#satisfaction_content').html(html);
                            $('#submit-btn').show();
                            init_score_4();
                            init_radio();
                            return false;
                        }
                    }
                }else{
                    var unRightHtml = '<div class="form-group col-md-12"> <div class="form-group mt20">请输入正确的员工信息！</div> </div>';
                    $('#satisfaction_content').html(unRightHtml);
                    $('#submit-btn').hide();
                    return false;
                }
            }
        })
        return false;
    }else{
        var unRightHtml = '<div class="form-group col-md-12"> <div class="form-group mt20">请输入正确的员工信息！</div> </div>';
        $('#satisfaction_content').html(unRightHtml);
        $('#submit-btn').hide();
        return false;
    }
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


