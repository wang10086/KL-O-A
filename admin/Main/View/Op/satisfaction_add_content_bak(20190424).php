
<form method="post" action="<?php echo U('Op/satisfaction_add'); ?>" id="save_satisfaction">
    <div class="content">
        <input type="hidden" name="dosubmint" value="1">
        <div class="content">
            <input type="hidden" name="info[dimension]" value="5"> <!--考核维度-->
            <input type="hidden" id="timely_num" name="info[timely]" value="" />
            <input type="hidden" id="accord_num" name="info[accord]" value="" />
            <input type="hidden" id="cost_num" name="info[cost]" value="" />
            <input type="hidden" id="train_num" name="info[train]" value="" />
            <input type="hidden" id="service_num" name="info[service]" value="" />

            <div style="width:100%;float:left;">
            <?php if ($has_rd == 1){ ?>
                <!--有研发人员-->
                <input type="hidden" name="has_rd" value="1">
                <div class="form-group col-md-6">
                    <label>对相关法规、政策、制度、标准化产品培训情况：</label>
                    <div class="demo score">
                        <div id="timely"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>公司产品标准及标准化产品情况：</label>
                    <div class="demo score">
                        <div id="accord"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>专业支持、指导情况：</label>
                    <div class="demo score">
                        <div id="cost"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>研发部人员服务支持及时性：</label>
                    <div class="demo score">
                        <div id="train"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>研发部人员工作态度情况：</label>
                    <div class="demo score">
                        <div id="service"></div>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label id="ctrq">评分月份：</label><input type="text" name="monthly"  class="form-control monthly"  style="width: 50%;" required />
                </div>
            <?php }else{ ?>
                <!--无研发人员-->
                <input type="hidden" name="has_rd" value="0">
                <div class="form-group col-md-4">
                    <label>及时性：</label>
                    <div class="demo score">
                        <div id="timely"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>产品及文件对需求的符合性：</label>
                    <div class="demo score">
                        <div id="accord"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>成本控制情况：</label>
                    <div class="demo score">
                        <div id="cost"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>培训支持及可操作性：</label>
                    <div class="demo score">
                        <div id="train"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>研发部人员的服务态度：</label>
                    <div class="demo score">
                        <div id="service"></div>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label id="ctrq">评分月份：</label><input type="text" name="monthly"  class="form-control monthly" style="width: 50%;" required />
                </div>
            <?php } ?>
            </div>
            <textarea name="content" class="form-control" id="content"  rows="2" placeholder="请输入对研发评价内容"></textarea>
            <div class="form-group col-md-12"></div>
        </div>

        <div align="center" class="form-group col-md-12" style="alert:cennter;margin-bottom: 20px;">
            <input type="submit" class="btn btn-info" value="提交">
        </div>

    </div>
</form>

<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);

            pingfen('timely',res.timely);       //及时性
            pingfen('accord',res.accord);    //产品及文件对需求的符合性
            pingfen('cost',res.cost);        //研发成本控制
            pingfen('train',res.train);        //培训支持及可操作性
            pingfen('service',res.service);        //研发部人员的服务态度
        }else{
            pingfen('timely',5);       //及时性
            pingfen('accord',5);    //产品及文件对需求的符合性
            pingfen('cost',5);        //研发成本控制
            pingfen('train',5);        //培训支持及可操作性
            pingfen('service',5);        //研发部人员的服务态度
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