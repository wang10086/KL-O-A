
<?php if($resource){ ?>
    <?php if ($op_kind == 60){ ?>
        <div class="box-body" id="after_lession" >
            <div class="row"><!-- right column -->
                <div class="form-group col-md-12">
                    <div class="form-group col-md-12" style="align: center;">
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td class="td_title" colspan="6">
                                    <div class="form-group col-md-12">
                                        <h4>资源需求单(项目编号:{$resource.op_id})</h4>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_title td">项目名称</td>
                                <td colspan="2" class="td_con td">{$op.project}</td>
                                <td class="td_title td">业务人员</td>
                                <td colspan="2" class="td_con td">{$resource.service_name}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">客户单位</td>
                                <td colspan="2" class="td_con td">{$resource.client}</td>
                                <td class="td_title td">上课地点</td>
                                <td colspan="2" class="td_con td">{$resource.addr}</td>

                            </tr>
                            <tr>
                                <td class="td_title td">课程周期</td>
                                <td colspan="2" class="td_con td">{$resource.use_time}</td>
                                <td class="td_title td">上课时间</td>
                                <td colspan="2" class="td_con td">{$resource['lession_time']}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">填写时间</td>
                                <td colspan="2" class="td_con td">{$resource['create_time']|date='Y-m-d H:i:s',###}</td>
                                <td class="td_title td">接收人员</td>
                                <td colspan="2" class="td_con td">{$resource.exe_user_name}</td>
                            </tr>

                            <tr>
                                <td  rowspan="3" class="td_title td"<strong>课程信息</strong></td>
                                <td class="td_title td">课程名称</td>
                                <td colspan="1" class="td_con td">{$resource['lession_name']}</td>
                                <td class="td_title td">面向年级</td>
                                <td colspan="1" class="td_con td">{$resource['lession_grade']}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">动手实践</td>
                                <td colspan="4" class="td_con td">
                                    <span class="checkboxs_255"><input type="radio" name="info[handson]" <?php if($resource['handson']==1){ echo 'checked';} ?>  value="1">&nbsp; 是<span id="handson">，资源方名称：<input type="text" name="info[lession_price]" value="{$resource['lession_price']}" style="border: none; border-bottom: solid 1px;" readonly></span></span>&#12288;&#12288;
                                    <span class="checkboxs_255"><input type="radio" name="info[handson]" <?php if($resource['handson']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>具体需求描述（课程描述、是否有动手活动及预算；集合时间、集合地点等）：</label><textarea class="form-control no-border-textarea"  name="info[lession_special_need]" readonly>{$resource['lession_special_need']}</textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="td_title td">资源配置反馈</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control no-border-textarea"  name="info[res_feedback]" readonly>{$resource['res_feedback']}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="content no-print">
                        <!--<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>-->
                        <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
                        <!--<a href="{:U('Export/member',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>-->
                    </div>
                </div>
            </div><!--/.col (right) -->
        </div>
    <?php }else{ ?>
        <div class="box-body" id="res_need_table" >
            <div class="row"><!-- right column -->
                <div class="form-group col-md-12">
                    <div class="form-group col-md-12" style="align: center;">
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td class="td_title" colspan="6">
                                    <div class="form-group col-md-12">
                                        <h4>资源需求单(项目编号:{$resource.op_id})</h4>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_title td">需求部门</td>
                                <td colspan="2" class="td_con td">{$resource.department}</td>
                                <td class="td_title td">客户单位</td>
                                <td colspan="2" class="td_con td">{$resource.client}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">业务人员</td>
                                <td colspan="2" class="td_con td">{$resource.service_name}</td>
                                <td class="td_title td">实施对象</td>
                                <td colspan="2" class="td_con td">{$resource.imp_obj}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">活动人数</td>
                                <td colspan="2" class="td_con td">{$resource.number}</td>
                                <td class="td_title td">实施时间</td>
                                <td colspan="2" class="td_con td"><?php echo $resource['in_time']?date('Y-m-d',$resource['in_time']):''; ?></td>
                            </tr>
                            <tr>
                                <td class="td_title td">活动时长（天）</td>
                                <td colspan="2" class="td_con td">{$resource.use_time}</td>
                                <td class="td_title td">活动地点</td>
                                <td colspan="2" class="td_con td">{$resource.addr}</td>
                            </tr>
                            <tr>
                                <td class="td_title td">提交时间</td>
                                <td colspan="2" class="td_con td">{$resource.create_time|date='Y-m-d H:i:s',###}</td>
                                <td class="td_title td">接收人员</td>
                                <td colspan="2" class="td_con td">{$resource.exe_user_name}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td_title td"> <strong>需求描述</strong></td>
                            </tr>

                            <tr>
                                <td  rowspan="2" class="td_title td">院所、场馆、场地</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>资源需求：</label><span ><input class="act_input_500" type="text" name="info[res_need]" value="{$resource['res_need']}" class="form-control" readonly /></span>
                                        <div>
                                            <div>活动需求：</div>
                                            <foreach name="act_need" key="k" item="v">
                                                <span class="checkboxs_100"><input type="checkbox" name="act_need[]" <?php if(in_array($v,$act_needs)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;
                                            </foreach>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>具体需求描述（课程描述、是否有动手活动及预算；集合时间、集合地点等）：</label><textarea class="form-control no-border-textarea" value="{$resource['res_special_need']}"  name="info[res_special_need]" readonly>{$resource['res_special_need']}</textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td  rowspan="3" class="td_title td">课程、活动</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12 tdline">
                                        <label>课程、活动名称：</label><span ><input class="act_input_500" type="text" name="info[les_name]" value="{$resource['les_name']}" class="form-control" readonly /></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12 tdline">
                                        <label>学科：</label> <span ><input class="act_input_500" type="text" name="info[subject]" value="{$resource['subject']}" class="form-control" readonly /></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>具体需求描述（课题周期、是否参赛、预算价格等）：</label><textarea class="form-control no-border-textarea"  name="info[les_special_need]" readonly>{$resource['les_special_need']}</textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td  rowspan="4" class="td_title td">小课题</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <div>小课题领域</div>
                                        <foreach name="task_field" key="k" item="v">
                                            <span class="checkboxs_212"><input type="checkbox" name="task_field[]" <?php if(in_array($v,$task_fields)){ echo 'checked';} ?>  value="{$v}">&nbsp; {$v}</span>&#12288;&#12288;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <div>资源方性质</div>
                                        <span class="checkboxs_212"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==1){ echo 'checked';} ?>  value="1">&nbsp; 中科院院内</span>&#12288;&#12288;
                                        <span class="checkboxs_212"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==2){ echo 'checked';} ?>  value="2">&nbsp; 中科院院外</span>&#12288;&#12288;
                                        <span class="checkboxs_212"><input type="radio" name="info[task_type]" <?php if($resource['task_type']==3){ echo 'checked';} ?>  value="3">&nbsp; 均可</span>&#12288;&#12288;
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>是否制定资源方：</label>&nbsp;
                                        <span class="checkboxs_400"><input type="radio" name="info[custom]" <?php if($resource['custom']==1){ echo 'checked';} ?>  value="1">&nbsp; 是<span id="custom">，资源方名称：<input type="text" name="info[res_name]" value="{$resource['res_name']}" style="border: none; border-bottom: solid 1px;" readonly></span></span>&#12288;&#12288;
                                        <span class="checkboxs_255"><input type="radio" name="info[custom]" <?php if($resource['custom']==0){ echo 'checked';} ?>  value="0">&nbsp; 否</span>&#12288;&#12288;
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <label>具体需求描述（课题周期、是否参赛、预算价格等）：</label><textarea class="form-control no-border-textarea"  name="info[task_special_need]" readonly>{$resource['task_special_need']}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_title td">资源配置反馈</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control no-border-textarea"  name="info[res_feedback]" readonly>{$resource['res_feedback']}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="content no-print">
                        <!--<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>-->
                        <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
                        <!--<a href="{:U('Export/member',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>-->
                    </div>
                </div>
            </div><!--/.col (right) -->
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  暂未填写物资需求单!</div>
<?php } ?>

