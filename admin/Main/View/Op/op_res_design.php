
<?php if($design){ ?>
    <div class="box-body" id="design" >
        <div class="row"><!-- right column -->
            <div class="form-group col-md-12">
                <div class="form-group col-md-12" style="align: center;">
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
                    <button class="btn btn-default" onclick="print_part('design');"><i class="fa fa-print"></i> 打印</button>
                </div>
            </div>
        </div><!--/.col (right) -->
    </div>
<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  暂未填写委托设计工作交接单!</div>
<?php } ?>

