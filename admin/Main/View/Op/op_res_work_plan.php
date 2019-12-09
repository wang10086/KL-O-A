
<?php if($work_plan){ ?>
    <div class="box-body" id="work_plan" >
        <div class="row"><!-- right column -->
            <div class="form-group col-md-12">
                <div class="form-group col-md-12" style="align: center;">
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

                <div class="content no-print">
                    <!--<button class="btn btn-default" onclick="print_design();"><i class="fa fa-print"></i> 打印</button>-->
                    <button class="btn btn-default" onclick="print_part('work_plan');"><i class="fa fa-print"></i> 打印</button>
                </div>
            </div>
        </div><!--/.col (right) -->
    </div>
<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  暂未填写业务实施计划单!</div>
<?php } ?>

