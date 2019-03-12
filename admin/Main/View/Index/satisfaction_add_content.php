
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
                    <div class="demo score">
                        <div id="AA"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>支撑服务效果：</label>
                    <div class="demo score">
                        <div id="BB"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>支撑服务及时性：</label>
                    <div class="demo score">
                        <div id="CC"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>公正及合理性：</label>
                    <div class="demo score">
                        <div id="DD"></div>
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
    });


    function pingfen(id,score) {
        $('#'+id+'_num').val(score);
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score);
            }
        });
    }

    $('#account_id').change(function(){
        var account_id  = $('#account_id').val();
        var noBodyHtml  = '<div class="form-group col-md-12"> <div class="form-group mt20">暂无该员工的考核内容！</div> </div>';
        if (account_id){
            var html        = '';
            var arr1        = ['26']; //安全品控部 26=>李岩
            var textarea    = '<textarea name="content" class="form-control" id="content"  rows="2" placeholder="请输入评价内容"></textarea> <div class="form-group col-md-12"></div>';
            if (arr1.indexOf(account_id) == '-1'){
                $('#satisfaction_content').html(noBodyHtml);
                return false;
            }else{
                var content = '<input type="hidden" name="info[dimension]" value="4"> <!--考核维度-->'+
                    '<div class="form-group col-md-6"> <label>支撑服务态度：</label> <div class="demo score"> <div id="AA"></div> </div> </div>'+
                    '<div class="form-group col-md-6"> <label>支撑服务效果：</label> <div class="demo score"> <div id="BB"></div> </div> </div>'+
                    '<div class="form-group col-md-6"> <label>支撑服务及时性：</label> <div class="demo score"> <div id="CC"></div> </div> </div>'+
                    '<div class="form-group col-md-6"> <label>公正及合理性：</label> <div class="demo score"> <div id="DD"></div> </div> </div>';
            }
            var html = content + textarea;
            $('#satisfaction_content').html(html);
            init_score();
        }else{
            var unRightHtml = '<div class="form-group col-md-12"> <div class="form-group mt20">请输入正确的员工信息！</div> </div>';
            $('#satisfaction_content').html(unRightHtml);
            return false;
        }
    });

    //初始化评分显示
    function init_score() {
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