
<?php if($resource || $design || $work_plan){ ?>
    <div class="box-body">
        <div class="row"><!-- right column -->
            <div class="form-group col-md-12">
                <div class="btn-group no-print" id="catfont">
                    <a href="javascript:;" onclick="ziyuan()" class="btn btn-info" id="btn_1">资源需求单</a>
                    <a href="javascript:;" onclick="yewu()" class="btn btn-default" id="btn_2">业务实施计划单</a>
                    <a href="javascript:;" onclick="sheji()" class="btn btn-default" id="btn_3">委托设计工作交接单 </a>
                    <input type="hidden" id="print_part_id" value="res_need">
                </div>
            </div>

            <!--资源需求单-->
        <?php if ($op_kind == 60){ ?>
            <div class="form-group col-md-12" id="res_need" style="align: center;">
                <!--课后一小时开课需求表-->
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td class="td_title" colspan="6">
                                    <div class="form-group col-md-12">
                                        <h4>资源需求单(项目团号:{$op.group_id})</h4>
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
                                <td class="td_title td">支撑服务反馈</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control no-border-textarea"  name="info[res_feedback]" readonly>{$resource['res_feedback']}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
        <?php }else{ ?>
            <div class="form-group col-md-12" id="res_need" style="align: center;">
                <table style="width: 100%; margin-top: 20px;">
                    <tr>
                        <td class="td_title" colspan="6">
                            <div class="form-group col-md-12">
                                <h4>资源需求单(项目团号:{$op.group_id})</h4>
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
                        <td colspan="2" class="td_con td">{$province[$resource[province]]}{$resource.addr}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">提交时间</td>
                        <td colspan="2" class="td_con td"><?php echo $resource['create_time']?date("Y-m-d H:i:s",$resource['create_time']):''; ?></td>
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
                        <td class="td_title td">支撑服务反馈</td>
                        <td colspan="5" class="td_con td">
                            <div class="form-group col-md-12">
                                <textarea class="form-control no-border-textarea"  name="info[res_feedback]" readonly>{$resource['res_feedback']}</textarea>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php } ?>

            <!--业务实施计划单-->
            <div class="form-group col-md-12" id="plans" style="align: center;">
                <table style="width: 100%; margin-top: 20px;">
                    <tr>
                        <td class="td_title" colspan="6">
                            <div class="form-group col-md-12">
                                <h4>业务实施计划单(项目团号:{$op.group_id})</h4>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title" colspan="6" style="text-align: left">委托部门：{$user_info['department']}&emsp;&emsp;&emsp;项目负责人：{$user_info['create_user_name']}&emsp;&emsp;&emsp;联系方式：{$user_info['mobile']}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">项目名称</td>
                        <td colspan="5" class="td_con td">{$work_plan.project}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">执行人</td>
                        <td colspan="2" class="td_con td">{$work_plan.exe_user_name}</td>
                        <td class="td_title td">实施时间</td>
                        <td colspan="2" class="td_con td">{$work_plan.begin_time|date='Y-m-d',###} - {$work_plan.end_time|date='Y-m-d',###}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">填表人</td>
                        <td colspan="2" class="td_con td">{$work_plan.ini_user_name}</td>
                        <td class="td_title td">填写时间</td>
                        <td colspan="2" class="td_con td">{$work_plan.create_time|date='Y-m-d H:i:s',###}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">人数</td>
                        <td class="td_con td">{$work_plan.num}&emsp;人</td>
                        <td class="td_title td">向顾客报价</td>
                        <td class="td_con td">&yen;{$work_plan.price}</td>
                        <td class="td_title td">估计毛利</td>
                        <td class="td_con td">&yen;{$work_plan.maoli}</td>

                    </tr>
                    <tr>
                        <td colspan="6" class="td_title td">业务实施需计调操作具体内容</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td_title td">需计调操作具体内容</td>
                        <td colspan="2" class="td_title td">标准</td>
                        <td colspan="2" class="td_title td">备注</td>
                    </tr>
                    <foreach name="plan_lists" item="v">
                        <tr>
                            <td colspan="2" class="td_con td">{$v.content}</td>
                            <td colspan="2" class="td_con td">{$v.standard}</td>
                            <td colspan="2" class="td_con td">{$v.remark}</td>
                        </tr>
                    </foreach>

                    <tr>
                        <td class="td_title td">后附</td>
                        <td colspan="5" class="td_con td">
                            <foreach name="additive_con" key="k" item="v">
                                <span style="margin:0 10px 0 20px;"><input type="checkbox" <?php if (in_array($k,$additive)){echo 'checked';} ?> >&emsp;{$v}</span>
                            </foreach>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title" colspan="6" style="text-align: left">审核状态：{$audit_status[$work_plan['audit_status']]}&emsp;&emsp;审核人：{$work_plan['audit_user_name']}&emsp;&emsp;审核时间：{$work_plan['audit_time']|date='Y-m-d H:i:s',###}</td>
                    </tr>
                </table>
            </div>

            <!--委托设计工作交接单-->
            <div class="form-group col-md-12" id="design" style="align: center;">
                <table style="width: 100%; margin-top: 20px;">
                    <tr>
                        <td class="td_title" colspan="6">
                            <div class="form-group col-md-12">
                                <h4>委托设计工作交接单(项目团号:{$op.group_id})</h4>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title" colspan="6" style="text-align: left">委托部门：{$user_info['department']}&emsp;&emsp;&emsp;项目负责人：{$user_info['create_user_name']}&emsp;&emsp;&emsp;联系方式：{$user_info['mobile']}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">项目名称</td>
                        <td colspan="2" class="td_con td">{$design.project}</td>
                        <td class="td_title td">考核编号</td>
                        <td colspan="2" class="td_con td">{$design.check_coding}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">填表人</td>
                        <td colspan="2" class="td_con td">{$design.ini_user_name}</td>
                        <td class="td_title td">填写时间</td>
                        <td colspan="2" class="td_con td">{$design.create_time|date='Y-m-d H:i:s',###}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">执行人</td>
                        <td colspan="2" class="td_con td">{$design.exe_user_name}</td>
                        <td class="td_title td">计划交稿时间</td>
                        <td colspan="2" class="td_con td">{$design.need_time|date='Y-m-d',###}</td>

                    </tr>
                    <tr>
                        <td class="td_title td">成品尺寸</td>
                        <td colspan="2" class="td_con td">{$design.goods_size}</td>
                        <td class="td_title td">是否拼版</td>
                        <td class="td_con td"><?php if($design['pingban'] == 1){echo '拼版';}else{echo '不拼版';} ?></td>
                        <td class="td_con td">拼版尺寸：{$design['chuxue']}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">输出要求</td>
                        <td colspan="5" class="td_con td">{$output_info[$design['output']]} &emsp;&emsp;文件格式：{$design.file_type}</td>
                    </tr>
                    <tr>
                        <td class="td_title td">提供内容</td>
                        <td colspan="3" class="td_con td">文字(文件名称)：{$design['give_con']}</td>
                        <td colspan="2" class="td_con td">图片：{$design['give_pic']} &emsp;&emsp;张({$design.pic_type})</td>
                    </tr>

                    <tr>
                        <td class="td_title td"<strong>设计要求及内容</strong></td>
                        <td colspan="5" class="td_con td">
                            <div class="form-group col-md-12">
                                <textarea class="form-control no-border-textarea"  name="info[pecial_need]" readonly>{$design['pecial_need']}</textarea>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="td_title td">备注</td>
                        <td colspan="5" class="td_con td">
                            <div class="form-group col-md-12">
                                <textarea class="form-control no-border-textarea"  name="info[remark]" readonly>{$design['remark']}</textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title" colspan="6" style="text-align: left">审核状态：{$audit_status[$design['audit_status']]}&emsp;&emsp;审核人：{$design['audit_user_name']}&emsp;&emsp;审核时间：<?php echo $design['audit_time']?date('Y-m-d H:i:s',$design['audit_time']):'未审核'; ?></td>
                    </tr>
                </table>
            </div>

                <div class="content no-print">
                    <!--<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>-->
                    <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
                </div>
        </div><!--/.col (right) -->
    </div>
<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  暂未填写物资需求单!</div>
<?php } ?>

<script type="text/javascript">
    $(function () {
        $('#res_need').show();
        $('#plans').hide();
        $('#design').hide();
        $('#print_part_id').val('res_need');
    })
    
    function ziyuan() {
        $('#res_need').show();
        $('#plans').hide();
        $('#design').hide();
        $('#btn_1').removeClass('btn-default');
        $('#btn_1').addClass('btn-info');
        $('#btn_2').removeClass('btn-info');
        $('#btn_2').addClass('btn-default');
        $('#btn_3').removeClass('btn-info');
        $('#btn_3').addClass('btn-default');
        $('#print_part_id').val('res_need');
    }
    
    function yewu() {
        $('#res_need').hide();
        $('#plans').show();
        $('#design').hide();
        $('#btn_1').removeClass('btn-info');
        $('#btn_1').addClass('btn-default');
        $('#btn_2').removeClass('btn-default');
        $('#btn_2').addClass('btn-info');
        $('#btn_3').removeClass('btn-info');
        $('#btn_3').addClass('btn-default');
        $('#print_part_id').val('plans');
    }

    function sheji() {
        $('#res_need').hide();
        $('#plans').hide();
        $('#design').show();
        $('#btn_1').removeClass('btn-info');
        $('#btn_1').addClass('btn-default');
        $('#btn_2').removeClass('btn-info');
        $('#btn_2').addClass('btn-default');
        $('#btn_3').removeClass('btn-default');
        $('#btn_3').addClass('btn-info');
        $('#print_part_id').val('design');
    }
</script>
