
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
                        <label>预算、报价（及时性）：</label>
                        <div class="demo score">
                            <div id="ysjsx"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>要素准备（房、餐、车、物资、导游）符合业务要求：</label>
                        <div class="demo score">
                            <div id="zhunbei"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>业务人员培训，活动细节交接：</label>
                        <div class="demo score">
                            <div id="peixun"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>活动实施效果跟进及改进：</label>
                        <div class="demo score">
                            <div id="genjin"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label>对活动实施过程中突发事件，应 急处理稳妥、及时：</label>
                        <div class="demo score">
                            <div id="yingji"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-12"></div>
                    <textarea name="info[jd_content]" class="form-control" id="jd_content"  rows="2" placeholder="请输入对计调评价内容"></textarea>
                    <div class="form-group col-md-12"></div>

                </div>
            </div>
            <div align="center" class="form-group col-md-12" style="alert:cennter;margin-top: 20px;">
                <a  href="javascript:;" class="btn btn-info" onClick="javascript:save('save_afterOpScore','<?php echo U('Op/public_save'); ?>');" style="width:60px;">保存</a>
            </div>
        </div>
    </div>
</form>



<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#jd_content').html(res.jd_content);
            /*$('#zy_content').html(res.zy_content);*/

            pingfen('ysjsx',res.ysjsx);       //客户需求匹配度
            pingfen('zhunbei',res.zhunbei);    //产品创新性(含特色和亮点)
            pingfen('peixun',res.peixun);        //研发成本控制
            pingfen('genjin',res.genjin);        //产品可行性及安全性
            pingfen('yingji',res.yingji);        //配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)
            pingfen('times',res.times);        //满足时长
            pingfen('finish',res.finish);       //项目完成度
            pingfen('site',res.site);         //场地服务(讲解、停车接待等，不含科研院所)
        }else{
            pingfen('ysjsx',5);       //客户需求匹配度
            pingfen('zhunbei',5);    //产品创新性(含特色和亮点)
            pingfen('peixun',5);        //研发成本控制
            pingfen('genjin',5);        //产品可行性及安全性
            pingfen('yingji',5);        //配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)
            pingfen('times',5);        //满足时长
            pingfen('finish',5);       //项目完成度
            pingfen('site',5);         //场地服务(讲解、停车接待等，不含科研院所)
        }

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


</script>