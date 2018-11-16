<?php if ($pingfen){ ?>
    <label class="lit-title">对前期研发评价<span style="float: right;clear: both;font-weight: normal;">资源负责人：<?php echo $yanfa['assign_name']?$yanfa['assign_name']:$yanfa['exe_user_name']; ?></span></label>
    <div class="content">
        <div class="content" id="guidelist" style="display:block;">

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

                <div class="form-group col-md-12">
                    <label>评价信息：</label>
                    <textarea name="info[yf_content]" class="form-control" id="yf_content" ></textarea>
                </div>

            </div>
        </div>
    </div>

    <label class="lit-title">对前期资源配置评价<span style="float: right;clear: both;font-weight: normal;">资源负责人：<?php echo $ziyuan['assign_name']?$ziyuan['assign_name']:$ziyuan['exe_user_name']; ?></span></label>
    <div class="content">
        <div class="content" id="" style="display:block;">

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

                <div class="form-group col-md-12">
                    <label>评价信息：</label>
                    <textarea name="info[zy_content]" class="form-control" id="zy_content"></textarea>
                </div>

            </div>

        </div>
    </div>

<?php }else{ ?>
<div class="content"><div class="form-group col-md-12">未评分！</div></div>
<?php } ?>



<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#yf_content').html(res.yf_content);
            $('#zy_content').html(res.zy_content);

            pingfen('match',res.match);       //客户需求匹配度
            pingfen('innovate',res.innovate);    //产品创新性(含特色和亮点)
            pingfen('cost',res.cost);        //研发成本控制
            pingfen('safe',res.safe);        //产品可行性及安全性
            pingfen('ptfa',res.ptfa);        //配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)
            pingfen('times',res.times);        //满足时长
            pingfen('finish',res.finish);       //项目完成度
            pingfen('site',res.site);         //场地服务(讲解、停车接待等，不含科研院所)
        }else{
            pingfen('match',5);       //客户需求匹配度
            pingfen('innovate',5);    //产品创新性(含特色和亮点)
            pingfen('cost',5);        //研发成本控制
            pingfen('safe',5);        //产品可行性及安全性
            pingfen('ptfa',5);        //配套方案标准化清单的完成性(含材料单、手册、任务卡、折页等)
            pingfen('times',5);        //满足时长
            pingfen('finish',5);       //项目完成度
            pingfen('site',5);         //场地服务(讲解、停车接待等，不含科研院所)
        }

    });

    function pingfen(id,score) {
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score);
            }
        });
    }


</script>