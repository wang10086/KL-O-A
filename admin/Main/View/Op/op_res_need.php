<script type="text/javascript">
    $(document).ready(function() {
        $('#res_need_table').hide();
        $('#after_lession').hide();
        $('#design').hide();
        $('#work_plan').hide();

        var op_kind     = <?php echo $op_kind;?>;
        if (op_kind == 60) {
            $('#res_need_table').html('');
        }else{
            $('#after_lession').html('');
        }
    })
</script>

<!--业务实施需求单 (一)-->
    <form method="post" action="<?php echo U('Op/public_save'); ?>" id="res_need_table" class="hideAll" onsubmit="return resSubmitBefore(1)">
    <?php if ($resource['audit_status'] != 1){ ?>
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
                        <label>需求部门：</label><input type="text" name="info[department]" value="<?php echo $resource['department']?$resource['department']:$user_info['department']; ?>" class="form-control" />
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
                        <label>实施时间：</label><input type="text" name="info[in_time]" value="<?php echo $resource['in_time']?date('Y-m-d H:i',$resource['in_time']): ''; ?>" class="form-control inputdatetime" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>活动时长（天）：</label><input type="text" name="info[use_time]" value="<?php echo $resource['use_time']?$resource['use_time']:$confirm['days'] ; ?>" class="form-control" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>活动省份</label>
                        <select class="form-control" name="info[province]">
                            <foreach name="province" key="k" item="v">
                                <option value="{$k}" <?php if ($resource['province'] == $k){ echo "selected"; } ?>>{$v}</option>
                            </foreach>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>活动地点：</label><input type="text" name="info[addr]" value="<?php echo $resource['addr']?$resource['addr']:$confirm['address']; ?>" class="form-control" />
                    </div>

                    <!--<div class="form-group col-md-4">
                        <label>接收人员aaa：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$men['nickname']}" id="exe_u_name" required />
                        <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$men['id']}" />
                    </div>-->

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
                        <label>资源需求：</label><input type="text" name="info[res_need]" value="{$resource['res_need']}" id="cas_res" class="form-control" />
                        <input type="hidden" name="info[cas_res_id]" id="cas_res_id" value="{$resource['cas_res_id']}">
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
                        <label>是否指定资源方：</label>
                        <span class="checkboxs_400"><input type="radio" name="info[custom]" <?php if($resource['custom']==1){ echo 'checked';} ?>  value="1">&nbsp; 是<span id="custom">，资源方名称：<input type="text" name="info[res_name]" value="{$resource['res_name']}" style="border: none; border-bottom: solid 1px;"></span></span>&#12288;&#12288;
                        <span class="checkboxs_255"><input type="radio" name="info[custom]" <?php if($resource['custom']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                    </div>

                    <div class="form-group col-md-12">
                        <label>具体需求描述（课题周期、是否参赛、预算价格等）：</label><textarea class="form-control"  name="info[task_special_need]">{$resource['task_special_need']}</textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>提示：</label><p class="red">请填写接收部门负责人(接收部门负责人审核通过后该需求单才能到达相关执行人员手中)。</p>
                        <input type="text" name="info[audit_user_name]" value="{$resource['audit_user_name']}" class="form-control" placeholder="审核人员" id="res_audit_user_name" required />
                        <input type="hidden" name="info[audit_user_id]" value="{$resource['audit_user_id']}" class="form-control" id="res_audit_user_id" />
                    </div>
                </div>

                <div style="width:100%; text-align:center;">
                    <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:saveResForm(1)">保存</a>
                    <!--<a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('res_need_table','<?php /*echo U('Op/public_save'); */?>');">保存</a>-->
                </div>
            </div><!--/.col (right) -->
        </div>
    <?php }else{ ?>
        <include file="op_res_nfeedback" />
    <?php } ?>
    </form>

<!--业务实施需求单 (二)-->
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="after_lession" class="hideAll">
    <?php if ($resource['audit_status'] != 1){ ?>
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="11">
    <input type="hidden" name="info[ini_user_id]" value="{:session('userid')}" readonly>
    <input type="hidden" name="info[ini_user_name]" value="{:session('nickname')}" readonly>
    <div class="row">
        <!-- right column -->
        <div class="form-group col-md-12">
            <div class="content">
                <div class="form-group col-md-12">
                    <label>学校名称：</label><input type="text" name="info[client]" value="<?php echo $resource['client']?$resource['client']:$op['customer'] ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>上课地点：</label><input type="text" name="info[addr]" value="<?php echo $resource['addr']?$resource['addr']:$confirm['address']; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>课程周期：</label><input type="text" name="info[use_time]" value="<?php echo $resource['use_time']; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>上课时间：</label><input type="text" name="info[lession_time]" value="{$resource['lession_time']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>课程名称：</label><input type="text" name="info[lession_name]" value="{$resource['lession_name']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>面向年级：</label><input type="text" name="info[lession_grade]" value="{$resource['lession_grade']}" class="form-control" />
                </div>

                <!--<div class="form-group col-md-4">
                    <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$men['nickname']}" id="exe_u_name" />
                    <input type="hidden" name="info[exe_user_id]" id="exe_u_id"  value="{$men['id']}" />
                </div>-->

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

                <div class="form-group col-md-12">
                    <label>提示：</label><p class="red">请填写接收部门负责人(接收部门负责人审核通过后该需求单才能到达相关执行人员手中)。</p>
                    <input type="text" name="info[audit_user_name]" value="{$resource['audit_user_name']}" class="form-control" placeholder="审核人员" id="lession_audit_user_name" required />
                    <input type="hidden" name="info[audit_user_id]" value="{$resource['audit_user_id']}" class="form-control" id="lession_audit_user_id" />
                </div>

            </div>

            <div style="width:100%; text-align:center;">
                <!--<a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('after_lession','<?php /*echo U('Op/public_save'); */?>');">保存</a>-->
                <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:saveResForm(2)">保存</a>
            </div>
        </div>
    </div>
    <?php }else{ ?>
        <include file="op_res_nfeedback" />
    <?php } ?>
</form>

<!--委托设计工作交接单 设计部-->
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="design" class="hideAll">
    <?php if ($design['audit_status'] != 1){ ?>
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$op.op_id}">
        <input type="hidden" name="savetype" value="16">
        <div class="row">
            <!-- right column -->
            <div class="form-group col-md-12">
                <div class="content">

                    <div class="form-group col-md-8">
                        <label>项目名称：</label><input type="text" name="info[project]" value="<?php echo $design['project']?$design['project']:$op['project'] ?>" class="form-control" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>考核编码：</label><input type="text" name="info[check_coding]" value="{$design['check_coding']}" class="form-control" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>计划交稿时间：</label><input type="text" name="info[need_time]" value="<?php echo $design['need_time']?date('Y-m-d',$design['need_time']):''; ?>" class="form-control inputdate" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>成品尺寸：</label><input type="text" name="info[goods_size]" value="{$design['goods_size']}" class="form-control" placeholder="展开尺寸" />
                    </div>

                    <!--<div class="form-group col-md-4">
                        <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$design['exe_user_name']}" id="exe_user_name" />
                        <input type="hidden" name="info[exe_user_id]" id="exe_user_id"  value="{$design['exe_user_id']}" />
                    </div>-->

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
                        <label>提示：</label><p class="red">请填写接收部门负责人(接收部门负责人审核通过后该需求单才能到达相关执行人员手中)。</p>
                        <input type="text" name="info[audit_user_name]" value="{$design['audit_user_name']}" class="form-control" placeholder="审核人员" id="audit_user_name" required />
                        <input type="hidden" name="info[audit_user_id]" value="{$design['audit_user_id']}" class="form-control" id="audit_user_id" />
                    </div>

                </div>

                <div style="width:100%; text-align:center;">
                    <!--<a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('design','<?php /*echo U('Op/public_save'); */?>');">保存</a>-->
                    <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:saveResForm(3)">保存</a>
                </div>
            </div>
        </div>
    <?php }else{ ?>
        <include file="op_res_design" />
    <?php } ?>
</form>

<!--业务实施计划单 计调部-->
<form method="post" action="<?php echo U('Op/public_save'); ?>" id="work_plan" class="hideAll" onsubmit="" >
    <?php if ($work_plan['audit_status'] != 1){ ?>
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="19">
    <div class="row">
        <!-- right column -->
        <div class="form-group col-md-12">
            <div class="content">

                <div class="form-group col-md-4">
                    <label>业务单位：</label><input type="text" value="{$user_info.department}" class="form-control" />
                    <input type="hidden" name="info[departmentid]" value="{$user_info.departmentid}">
                </div>

                <div class="form-group col-md-4">
                    <label>实施时间：</label><input type="text" name="between_time" value="{$plan_between_time}" class="form-control between_day" />
                </div>

                <div class="form-group col-md-4">
                    <label>业务名称：</label><input type="text" name="info[project]" value="<?php echo $work_plan['project']?$work_plan['project']:$op['project']; ?>" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>销售人员：</label><input type="text" name="info[sale_user]" value="<?php echo $work_plan['sale_user']?$work_plan['sale_user']:$op['sale_user']; ?>" class="form-control" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>人数：</label><input type="text" name="info[num]" value="{$work_plan['num']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>向顾客报价：</label><input type="text" name="info[price]" value="{$work_plan['price']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>估计毛利：</label><input type="text" name="info[maoli]" value="{$work_plan['maoli']}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>接收人员：</label><input type="text" class="form-control" name="info[exe_user_name]"  value="{$work_plan['exe_user_name']}" id="do_user_name" required />
                    <input type="hidden" name="info[exe_user_id]" id="do_user_id"  value="{$work_plan['exe_user_id']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>填表人：</label><input type="text" name="info[ini_user_name]" value="<?php echo $work_plan['ini_user_name']?$work_plan['ini_user_name']:session('nickname'); ?>" class="form-control" readonly />
                    <input type="hidden" name="info[ini_user_id]" value="<?php echo $work_plan['ini_user_id']?$work_plan['ini_user_id']:session('userid'); ?>" class="form-control" readonly />
                </div>

                <div class="form-group col-md-12">
                    <label>后附：</label>
                    <span><input type="checkbox" name="additive[]" <?php if(in_array(1,$additive)){ echo 'checked';} ?>  value="1">&nbsp; 行程或方案</span>&#12288;&#12288;
                    <span class="ml50"><input type="checkbox" name="additive[]" <?php if(in_array(2,$additive)){ echo 'checked';} ?>  value="2">&nbsp; 需解决大交通的《人员信息表》</span>
                    <span class="ml50"><input type="checkbox" name="additive[]" <?php if(in_array(3,$additive)){ echo 'checked';} ?>  value="3">&nbsp; 其他</span>
                </div>

                <div class="form-group col-md-12">
                    <h2 class="tcs_need_h2">业务实施需计调操作具体内容：</h2>

                    <include file="work_plans_edit" />

                </div>

                <div class="form-group col-md-12">
                    <label>提示：</label><p class="red">请填写接收部门负责人(接收部门负责人审核通过后该需求单才能到达相关执行人员手中)。</p>
                    <input type="text" name="info[audit_user_name]" value="{$work_plan['audit_user_name']}" class="form-control" placeholder="审核人员" id="plans_audit_user_name" required />
                    <input type="hidden" name="info[audit_user_id]" value="{$work_plan['audit_user_id']}" class="form-control" id="plans_audit_user_id" />
                </div>
            </div>

            <div style="width:100%; text-align:center;">
                <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:saveResForm(4)">保存</a>
            </div>
        </div>
    </div>
    <?php }else{ ?>
        <include file="op_res_work_plan" />
    <?php } ?>
</form>

<script type="text/javascript">
    var keywords = <?php echo $userkey; ?>;
    var res_keywords = <?php echo $scienceRes; ?>;
    $(document).ready(function(e){
        /*autocom('exe_u_name','exe_u_id');
        * autocom('exe_user_name','exe_user_id');
         */
        autocom('do_user_name','do_user_id',keywords);
        autocom('res_audit_user_name','res_audit_user_id',keywords);
        autocom('lession_audit_user_name','lession_audit_user_id',keywords);
        autocom('audit_user_name','audit_user_id',keywords);
        autocom('plans_audit_user_name','plans_audit_user_id',keywords);
        autocom('cas_res','cas_res_id',res_keywords);
    })

    function saveResForm(pin) {
        if (pin ==1){
            let uid = $('#res_audit_user_id').val();
            if (uid){
                save('res_need_table','<?php echo U('Op/public_save'); ?>');
            }else{
                art_show_msg('请正确填写审核人员信息');
                return false;
            }
        }else if(pin ==2){
            let uid = $('#lession_audit_user_id').val();
            if (uid){
                save('after_lession','<?php echo U('Op/public_save'); ?>');
            }else{
                art_show_msg('请正确填写审核人员信息');
                return false;
            }
        }else if(pin ==3){
            let uid = $('#audit_user_id').val();
            if (uid){
                save('design','<?php echo U('Op/public_save'); ?>');
            }else{
                art_show_msg('请正确填写审核人员信息');
                return false;
            }
        }else if(pin ==4){
            let uid     = $('#plans_audit_user_id').val();
            let douid   = $('#do_user_id').val();
            if (uid && douid){
                save('work_plan','<?php echo U('Op/public_save'); ?>');
            }else{
                if (!uid){
                    art_show_msg('请正确填写审核人员信息');
                }else{
                    art_show_msg('请正确填写接收人员信息');
                }
                return false;
            }
        }
    }

    function autocom(username,userid,keywords){
        $("#"+username+"").autocomplete(keywords, {
            matchContains: true,
            highlightItem: false,
            formatItem: function(row, i, max, term) {
                return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
            },
            formatResult: function(row) {
                return row.text;
            }
        }).result(function (event, item) {
            $("#"+userid+"").val(item.id);
        });
    }

    //新增
    function add_plans(){
        var i = parseInt($('#plans_val').text())+1;

        var html = '<div class="userlist cost_expense" id="plans_'+i+'">';
        html += '<span class="title"></span>';
        html += '<input type="text" class="form-control" name="plans['+i+'][content]">';
        html += '<input type="text" class="form-control totalval" name="plans['+i+'][standard]" >';
        html += '<input type="text" class="form-control" name="plans['+i+'][remark]">';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'plans_'+i+'\')">删除</a>';
        html += '</div>';
        $('#plans').append(html);
        $('#plans_val').html(i);
        orderno();
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

</script>