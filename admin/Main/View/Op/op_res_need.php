<script type="text/javascript">
    $(document).ready(function() {
        $('#res_need_table').hide();
        $('#after_lession').hide();
        $('#design').hide();

        var op_kind     = <?php echo $op_kind;?>;
        if (op_kind == 60) {
            $('#res_need_table').html('');
        }else{
            $('#after_lession').html('');
        }
    })
</script>

<!--业务实施需求单 (一)-->
    <form method="post" action="<?php echo U('Op/public_save'); ?>" id="res_need_table">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="11">
    <input type="hidden" name="info[ini_user_id]" value="{:session('userid')}" readonly>
    <input type="hidden" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
        <div class="row">
            <!-- right column -->
            <div class="form-group col-md-12">

                        <div class="content">

                            <div class="form-group col-md-4">
                                <label>需求部门：</label><input type="text" name="info[department]" value="{$resource['department']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>客户单位：</label><input type="text" name="info[client]" value="<?php echo $resource['client']?$resource['client']:$op['customer'] ?>" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>业务人员：</label><input type="text" name="info[service_name]" value="{$op['sale_user']}" class="form-control" readonly />
                            </div>

                            <div class="form-group col-md-4">
                                <label>实施对象：</label><input type="text" name="info[imp_obj]" value="<?php echo $resource['imp_obj']?$resource['imp_obj']:$apply_to[$op['apply_to']] ; ?>" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>活动人数：</label><input type="text" name="info[number]" value="{$resource['number']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>实施时间：</label><input type="text" name="info[in_time]" value="<?php echo $resource['in_time']?date('Y-m-d H:i',$resource['in_time']): date('Y-m-d H:i:s',$confirm['dep_time']); ?>" class="form-control inputdatetime" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>活动时长（天）：</label><input type="text" name="info[use_time]" value="<?php echo $resource['use_time']?$resource['use_time']:$confirm['days'] ; ?>" class="form-control" />
                            </div>

                            <div class="form-group col-md-4">
                                <label>活动地点：</label><input type="text" name="info[addr]" value="<?php echo $resource['addr']?$resource['addr']:$confirm['address']; ?>" class="form-control" />
                            </div>

                            <!--<div class="form-group col-md-4">
                                <label>提交时间：</label><input type="text" name="info[money]" value="{$resource['money']}" class="form-control" />
                            </div>-->

                            <div class="form-group col-md-4">
                                <!--<label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$resource['exe_user_name']}" id="exe_u_name" />
                                <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$resource['exe_user_id']}" />-->
                                <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$men['nickname']}" id="exe_u_name" />
                                <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$men['id']}" />
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
                                <label>具体需求描述：</label><textarea class="form-control" value="{$resource['res_special_need']}"  name="info[res_special_need]">{$resource['res_special_need']}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2" >课程与活动</h2>
                            </div>

                            <div class="form-group col-md-6">
                                <label>课程活动名称：</label><input type="text" name="info[les_name]" value="{$resource['les_name']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-6">
                                <label>学科（如动物、植物、微生物、天文、地质等）：</label><input type="text" name="info[subject]" value="{$resource['subject']}" class="form-control" />
                            </div>

                            <div class="form-group col-md-12">
                                <label>具体需求描述（课程描述、是否有动手活动及预算；集合时间、集合地点等）：</label><textarea class="form-control"  name="info[les_special_need]">{$resource['les_special_need']}</textarea>
                            </div>


                            <div class="form-group col-md-12">
                                <h2 class="res_need_h2" >小课题</h2>
                            </div>

                            <div class="form-group col-md-12">
                                <div>小课题领域</div>
                                <foreach name="task_field" key="k" item="v">
                                    <span class="checkboxs_255"><input type="checkbox" name="task_field[]" <?php if(in_array($v,$task_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                </foreach>
                            </div>

                            <div class="form-group col-md-12">
                                <div>资源方性质 :</div>
                                <span class="checkboxs_255"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==1){ echo 'checked';} ?>  value="1">&nbsp; 中科院院内</span>&#12288;&#12288;
                                <span class="checkboxs_255"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==2){ echo 'checked';} ?>  value="2">&nbsp; 中科院院外</span>&#12288;&#12288;
                                <span class="checkboxs_255"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==3){ echo 'checked';} ?>  value="3">&nbsp; 均可</span>&#12288;&#12288;
                            </div>

                            <div class="form-group col-md-12" id="is_custom">
                                <label>是否制定资源方：</label>
                                <span class="checkboxs_400"><input type="radio" name="info[custom]" <?php if($resource['custom']==1){ echo 'checked';} ?>  value="1">&nbsp; 是<span id="custom">，资源方名称：<input type="text" name="info[res_name]" value="{$resource['res_name']}" style="border: none; border-bottom: solid 1px;"></span></span>&#12288;&#12288;
                                <span class="checkboxs_255"><input type="radio" name="info[custom]" <?php if($resource['custom']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                            </div>

                            <div class="form-group col-md-12">
                                <label>具体需求描述（课题周期、是否参赛、预算价格等）：</label><textarea class="form-control"  name="info[task_special_need]">{$resource['task_special_need']}</textarea>
                            </div>
                        </div>

                <div style="width:100%; text-align:center;">
                    <!--<button type="submit" class="btn btn-info btn-lg" id="lrpd">提交</button>-->
                    <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('res_need_table','<?php echo U('Op/public_save'); ?>');">保存</a>
                </div>
            </div><!--/.col (right) -->
        </div>
    </form>

<!--业务实施需求单 (二)-->
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="after_lession">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="11">
    <input type="hidden" name="info[ini_user_id]" value="{:session('userid')}" readonly>
    <input type="hidden" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
    <div class="row">
        <!-- right column -->
        <div class="form-group col-md-12">

            <div class="content">

                <div class="form-group col-md-8">
                    <label>学校名称：</label><input type="text" name="info[client]" value="<?php echo $resource['client']?$resource['client']:$op['customer'] ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>上课地点：</label><input type="text" name="info[addr]" value="<?php echo $resource['addr']?$resource['addr']:$confirm['address']; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>课程周期：</label><input type="text" name="info[use_time]" value="<?php echo $resource['use_time']; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>上课时间：</label><input type="text" name="info[lession_time]" value="<?php echo $resource['lession_time']?$resource['lession_time']:$confirm['days'] ; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>课程名称：</label><input type="text" name="info[lession_name]" value="{$resource['lession_name']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>面向年级：</label><input type="text" name="info[lession_grade]" value="{$resource['lession_grade']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$men['nickname']}" id="exe_u_name" />
                    <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$men['id']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>填表人：</label><input type="text" name="info[service_name]" value="{$op['sale_user']}" class="form-control" readonly />
                </div>

                <div class="form-group col-md-12" id="is_handson">
                    <label>动手实践：</label>
                    <span class="checkboxs_400"><input type="radio" name="info[handson]" <?php if($resource['handson']==1){ echo 'checked';} ?>  value="1">&nbsp; 是<span id="handson">，费用标准：<input type="text" name="info[lession_price]" value="{$resource['lession_price']}" style="border: none; border-bottom: solid 1px;"></span></span>&#12288;&#12288;
                    <span class="checkboxs_255"><input type="radio" name="info[handson]" <?php if($resource['handson']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>如有更多需求,请具体描述：</label><textarea class="form-control"  name="info[lession_special_need]">{$resource['lession_special_need']}</textarea>
                </div>

            </div>

            <div style="width:100%; text-align:center;">
                <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('after_lession','<?php echo U('Op/public_save'); ?>');">保存</a>
            </div>
        </div>
    </div>
</form>

<!--委托设计工作交接单 设计部-->
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="design">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="16">
    <div class="row">
        <!-- right column -->
        <div class="form-group col-md-12">
            <div class="content">

                <div class="form-group col-md-4">
                    <label>项目名称：</label><input type="text" name="info[project]" value="<?php echo $design['project']?$design['project']:$op['project'] ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>考核编码：</label><input type="text" name="info[check_coding]" value="{$design['check_coding']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>交稿时间：</label><input type="text" name="info[finish_time]" value="<?php echo $design['finish_time']; ?>" class="form-control inputdate" />
                </div>

                <div class="form-group col-md-4">
                    <label>成品尺寸：</label><input type="text" name="info[goods_size]" value="{$design['goods_size']}" class="form-control" placeholder="展开尺寸" />
                </div>

                <div class="form-group col-md-4">
                    <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$design['exe_user_name']}" id="exe_user_name" />
                    <input type="hidden" name="info[exe_user_id]" id="exe_user_id"  value="{$design['exe_user_id']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>填表人：</label><input type="text" name="info[ini_user_name]" value="{:session('nickname')}" class="form-control" readonly />
                    <input type="hidden" name="info[ini_user_id]" value="{:session('userid')}" class="form-control" readonly />
                </div>

                <div class="form-group col-md-12" id="is_pingban">
                    <label>是否拼版：</label>
                    <span class="checkboxs_100"><input type="radio" name="info[pingban]" <?php if($design['pingban']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                    <span class="checkboxs_500"><input type="radio" name="info[pingban]" <?php if($design['pingban']==1){ echo 'checked';} ?>  value="1">&nbsp; 是
                        <span id="pingban">，拼版尺寸：<input type="text" name="info[pinban_size]" value="{$design['pinban_size']}" style="border: none; border-bottom: solid 1px;"> &#12288;&#12288;
                        <input type="radio" name="info[chuxue]" value="含出血" <?php if($design['chuxue']=='含出血'){ echo 'checked';} ?>>&nbsp;含出血 &#12288;&#12288;
                        <input type="radio" name="info[chuxue]" value="不含出血" <?php if($design['chuxue']=='不含出血'){ echo 'checked';} ?>>&nbsp;不含出血
                        </span>
                    </span>&#12288;&#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>输出要求：</label>
                    <input type="radio" name="info[output]" value="1" <?php if($design['output']==1){ echo 'checked';} ?> >&nbsp;出片打样 &#12288;&#12288;
                    <input type="radio" name="info[output]" value="2" <?php if($design['output']==2){ echo 'checked';} ?> >&nbsp;喷绘&#12288;&#12288;
                    <input type="radio" name="info[output]" value="3" <?php if($design['output']==3){ echo 'checked';} ?> >&nbsp;只提供电子文件&#12288;文件格式：<input type="text" name="info[file_type]" value="{$design['file_type']}" style="border: none; border-bottom: solid 1px;"> &#12288;&#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>提供内容：</label>
                    <input type="text" name="info[give_con]" value="{$design['give_con']}" style="border: none; border-bottom: solid 1px; min-width: 200px;"  placeholder="文字(文件名称)"> &#12288;&#12288;
                    图片：<input type="text" name="info[give_pic]" value="{$design['give_pic']}" style="border: none; border-bottom: solid 1px; width: 80px">张&nbsp;(&nbsp;
                    <input type="radio" name="info[pic_type]" value="印刷品">&nbsp;印刷品 &#12288;&#12288;
                    <input type="radio" name="info[pic_type]" value="电子文件">&nbsp;电子文件) &#12288;
                </div>

                <div class="form-group col-md-12">
                    <label>设计要求及内容：</label><textarea class="form-control"  name="info[pecial_need]">{$design['pecial_need']}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <label>备注：</label><textarea class="form-control"  name="info[remark]">{$design['remark']}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <label>提示：</label><p>成稿后部门负责人最终确认签字(部门负责人审核通过后该需求单才能到达相关人员手中)。</p>
                </div>

            </div>

            <div style="width:100%; text-align:center;">
                <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('design','<?php echo U('Op/public_save'); ?>');">保存</a>
                <!--<input type="submit" value="提交AAA">-->
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    var keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
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

        $("#exe_user_name").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#exe_user_id").val(item.id);
        });
    });

</script>