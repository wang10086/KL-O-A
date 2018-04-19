<script type="text/javascript">
    $(document).ready(function() {
        $("#res_need_table").hide();
    })
</script>

<div class="box-body" id="res_need_table" >
    <form method="post" action="<?php echo U('Op/public_save'); ?>" id="">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="11">
    <input type="hidden" name="info[ini_user_id]" value="{:session('userid')}" readonly>
    <input type="hidden" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                        <div class="content">

                            <div class="form-group col-md-4">
                                <label>需求部门：</label><input type="text" name="info[department]" value="{$resource['department']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>客户单位：</label><input type="text" name="info[client]" value="{$resource['client']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>业务人员：</label><input type="text" name="info[service_name]" value="{$resource['service_name']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>实施对象：</label><input type="text" name="info[imp_obj]" value="{$resource['imp_obj']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>需求时间.周期：</label><input type="text" name="info[use_time]" value="{$resource['use_time']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>专业领域：</label><input type="text" name="info[major]" value="{$resource['major']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>活动人数：</label><input type="text" name="info[number]" value="{$resource['number']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>参考费用：</label><input type="text" name="info[money]" value="{$resource['money']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$resource['exe_user_name']}" id="exe_u_name" />
                                <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$resource['exe_user_id']}" />
                            </div>

                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2">业务类型</h2>
                            </div>

                            <div class="form-group col-md-12">
                                <foreach name="service_type" key="k" item="v">
                                    <span class="checkboxs_255"><input type="checkbox" name="service_type[]" <?php if(in_array($v,$service_types)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                </foreach>
                            </div>


                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2">院所、场馆、场地</h2>
                            </div>

                            <div class="form-group col-md-12">
                                <label>活动需求：</label>
                                <foreach name="act_need" key="k" item="v">
                                <span class="checkboxs_100"><input type="checkbox" name="act_need[]" <?php if(in_array($v,$act_needs)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                </foreach>
                            </div>

                            <div class="form-group col-md-12">
                                <label>资源需求：</label><input type="text" name="info[res_need]" value="{$resource['res_need']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-12">
                                <label>特殊需求描述：</label><textarea class="form-control" value="{$resource['res_special_need']}"  name="info[res_special_need]">{$resource['res_special_need']}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2">专家、教师</h2>
                            </div>

                            <div class="form-group col-md-12">
                                <div>需求:</div>
                                <foreach name="job_name" key="k" item="v">
                                    <!--<span class="checkboxs_400"><input type="checkbox" name="data[{$k}][job_name]" <?php /*if(in_array($v,$job_names)){ echo 'checked';} */?>  value="{$v}">&nbsp; {$v} &#12288;-->
                                    <span class="checkboxs_400"><input type="checkbox" name="data[{$k}][job_name]" <?php if($v != null){ echo 'checked';} ?>  value="{$k}">&nbsp; {$k} &#12288;
                                        费用 :&nbsp;<input class="act_input_100" name="data[{$k}][job_money]" value="{$v}" type="text" />
                                    </span>&#12288;&#12288;
                                </foreach>
                            </div>

                            <div class="form-group col-md-12">
                                <label>特殊需求描述（专业、职称、上课时间、学历、性别、实施活动等）：</label><textarea class="form-control"  name="info[zj_special_need]">{$resource['zj_special_need']}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2">辅导员</h2>
                            </div>

                            <div class="form-group col-md-6">
                                <label>人数：</label><input type="text" name="info[cou_num]" value="{$resource['cou_num']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-6">
                                <label>业务时间：</label><input type="text" name="info[cou_time]" value="{$resource['cou_time']}" class="form-control inputdate" />
                            </div>

                            <div class="form-group col-md-12">
                                <label>特殊需求描述（具体活动如科技节项目数量、学趣班班次、夏令营营期等）：</label><textarea class="form-control"  name="info[cou_special_need]">{$resource['cou_special_need']}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2" >课程与活动</h2>
                            </div>

                            <div class="form-group col-md-12">
                                <div>课程领域</div>
                                <foreach name="les_field" key="k" item="v">
                                    <span class="checkboxs_255"><input type="checkbox" name="les_field[]" <?php if(in_array($v,$les_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                </foreach>
                            </div>

                            <div class="form-group col-md-12">
                                <div>活动类型</div>
                                <foreach name="act_field" key="k" item="v">
                                    <span class="checkboxs_255"><input type="checkbox" name="act_field[]" <?php if(in_array($v,$act_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                </foreach>
                            </div>

                            <div class="form-group col-md-6">
                                <label>学科（如动物、植物、微生物、天文、地质等）：</label><input type="text" name="info[les_name]" value="{$resource['les_name']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-6">
                                <label>时间要求（每周几、几点至几点、多少周）：</label><input type="text" name="info[les_time]" value="{$resource['les_time']}" class="form-control" />
                            </div>



                            <!--<div class="form-group col-md-6">
                                <label>学科（如动物、植物、微生物、天文、地质等）：</label><input type="text" name="info[act_name]" class="form-control" />
                            </div>

                            <div class="form-group col-md-6">
                                <label>时间要求（每周几、几点至几点、多少周）：</label><input type="text" name="info[act_time]" class="form-control" />
                            </div>-->

                            <div class="form-group col-md-12">
                                <label>特殊需求描述：</label><textarea class="form-control"  name="info[act_special_need]">{$resource['act_special_need']}</textarea>
                            </div>



                        </div>

                <div style="width:100%; text-align:center;">
                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">提交</button>
                </div>
            </div><!--/.col (right) -->
        </div>
    </form> 
</div><!-- /.box-body -->

<script type="text/javascript">
    $(document).ready(function(e){
        var keywords = <?php echo $userkey; ?>;
        $("#exe_u_name").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#exe_u_id").val(item.id);
        });
    });

</script>