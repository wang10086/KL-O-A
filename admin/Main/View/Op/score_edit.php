<!--<link type="text/css" rel="stylesheet" href="__HTML__/score/demo/css/application.css">-->
<script type="text/javascript" src="__HTML__/score/lib/jquery.raty.min.js"></script>

<form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_score">
    <label class="lit-title">对前期研发评价</label>
    <div class="content">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="savetype" value="21">
        <input type="hidden" name="opid" value="{$op.op_id}">
        <div class="content" id="guidelist" style="display:block;">
            <input type="hidden" class="default_score" id="match_num" name="info[match]" value="" />
            <input type="hidden" class="default_score" id="innovate_num" name="info[innovate]" value="" />
            <input type="hidden" class="default_score" id="cost_num" name="info[cost]" value="" />
            <input type="hidden" class="default_score" id="safe_num" name="info[safe]" value="" />
            <input type="hidden" class="default_score" id="ptfa_num" name="info[ptfa]" value="" />
            <input type="hidden" name="info[yf_uid]" value="{$yanfa.userid}" />
            <input type="hidden" name="info[yf_uname]" value="{$yanfa.username}" />

            <div style="width:100%;float:left;">

                <div class="form-group col-md-4">
                    <label>客户需求匹配度：</label>
                    <div class="demo score">
                        <div id="match"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>产品创新性(含特色和亮点)：</label>
                    <div class="demo score">
                        <div id="innovate"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>研发成本控制：</label>
                    <div class="demo score">
                        <div id="cost"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>产品可行性及安全性：</label>
                    <div class="demo score">
                        <div id="safe"></div>
                    </div>
                </div>

                <div class="form-group col-md-8">
                    <label>配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)：</label>
                    <div class="demo score">
                        <div id="ptfa"></div>
                    </div>
                </div>

                <textarea name="info[yf_content]" class="form-control"  rows="2" placeholder="请输入对研发评价内容"></textarea>
                <div class="form-group col-md-12"></div>

            </div>
        </div>
    </div>

    <label class="lit-title">对前期资源配置评价<span style="float: right;clear: both;">资源负责人</span></label>
    <div class="content">
        <div class="content" id="" style="display:block;">
            <input type="hidden" class="default_score" id="times_num" name="info[times]" value="">
            <input type="hidden" class="default_score" id="finish_num" name="info[finish]" value="">
            <input type="hidden" class="default_score" id="site_num" name="info[site]" value="">
            <input type="hidden" name="info[zy_uid]" value="{$ziyuan.userid}" />
            <input type="hidden" name="info[zy_uname]" value="{$ziyuan.username}" />

            <div style="width:100%;float:left;">

                <div class="form-group col-md-4">
                    <label>满足时长：</label>
                    <div class="demo score">
                        <div id="times"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>项目完成度：</label>
                    <div class="demo score">
                        <div id="finish"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>场地服务(讲解、停车接待等，不含科研院所)：</label>
                    <div class="demo score">
                        <div id="site"></div>
                    </div>
                </div>

                <textarea name="info[zy_content]" class="form-control"  rows="2" placeholder="请输入对资源评价内容"></textarea>
                <div class="form-group col-md-12"></div>

            </div>

        </div>
        <div align="center" class="form-group col-md-12" style="alert:cennter;margin-bottom: 20px;">
            <!--<a  href="javascript:;" class="btn btn-info" onClick="javascript:save('save_score','<?php /*echo U('Op/public_save'); */?>');" style="width:60px;">保存</a>-->
            <input type="submit" class="btn btn-info" value="提交">
        </div>
    </div>
</form>



<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        $('.default_score').val(5);

        pingfen('match');       //客户需求匹配度
        pingfen('innovate');    //产品创新性(含特色和亮点)
        pingfen('cost');        //研发成本控制
        pingfen('safe');        //产品可行性及安全性
        pingfen('ptfa');        //配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)

        pingfen('times');        //满足时长
        pingfen('finish');       //项目完成度
        pingfen('site');         //场地服务(讲解、停车接待等，不含科研院所)
    });

    function pingfen(id) {
        $('#'+id).raty({
            score: 5,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score);
            }
        });
    }

    //保存信息
    function save(id,url){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data)>0){
                    art.dialog.alert('保存成功','success');
                    window.top.location.reload();
                    top.art.dialog({id:"score"}).close();
                }else{
                    art.dialog.alert('保存失败','warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);
    }

</script>