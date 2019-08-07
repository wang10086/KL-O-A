<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目评价</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/confirm')}"><i class="fa fa-gift"></i> 项目结算</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                        	 
                             <div class="btn-group no-print" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Op/confirm'))"><a href="{:U('Op/confirm',array('opid'=>$op['op_id']))}" class="btn btn-default">成团确认</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default ">项目结算</a></if>
                                <if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a></if>
                                <if condition="rolemenu(array('Op/evaluate'))"><a href="{:U('Op/evaluate',array('opid'=>$op['op_id']))}" class="btn btn-info">项目评价</a></if>
                            </div>

                            <?php if(cookie('roleid')==10 || cookie('userid')==$op['create_user'] || C('RBAC_SUPER_ADMIN')==cookie('username') ){ ?>
                            <include file="score_after_op_edit" />
                            <?php }else{ ?>
                            <include file="score_after_op_read" />
                            <?php }?>
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
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


     


