<include file="Index:header_art" />

<div class="content">
    <div class="row"><!-- right column -->
        <div class="form-group col-md-12" id="print_box" style="align: center;">
            <table style="width: 94%; margin: 0 3%;">
                <tr>
                    <td class="td_title" colspan="6">
                        <div class="form-group col-md-12">
                            <h4>文件审批单</h4>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td_title td">文件名称</td>
                    <td colspan="5" class="td_con td">{$file_list.newFileName}</td>
                </tr>
                <tr>
                    <td class="td_title td">起草部门</td>
                    <td class="td_con td">{$department.department}</td>
                    <td class="td_title td" style="width: 80px;">拟稿人</td>
                    <td class="td_con td">{$list.create_user_name}</td>
                    <td class="td_title td" style="width: 100px;">新编/修改</td>
                    <td class="td_con td"><?php echo $list['type'] == 1 ? '新编' : '修改'; ?></td>
                </tr>

                <tr>
                    <td class="td_title td">相关人员修改意见</td>
                    <td colspan="5" class="td_con td">
                        <div style="min-height: 300px">
                            <foreach name="record_list" key="k" item="v">
                                <div class="mt10 record_detail_box">
                                    <P class="record_detail_title"><span class="black">{$k+1}</span>、审核人：{$v['create_user_name']} | 审核时间：{$v['create_time']|date='Y-m-d H:i',###}</P>
                                    <P><span class="black">原文件内容：</span>{$v['file_content']}</P>
                                    <P><span class="black">建议修改内容：</span>{$v['suggest']}</P>
                                </div>
                            </foreach>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="td_title td">文件审核</td>
                    <td colspan="2" class="td_con td">&emsp;{$list.audited_time|date='Y-m-d',###}</td>
                    <td class="td_title td">文件批准</td>
                    <td colspan="2" class="td_con td">&emsp;{$list.sure_time|date='Y-m-d',###}</td>
                </tr>
                <tr>
                    <td class="td_title td">备注</td>
                    <td colspan="5" class="td_con td">{$list.content}</td>
                </tr>
            </table>
        </div>

        <!--<div class="content no-print">
            <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
        </div>-->
    </div>
</div>

 <include file="Index:footer2" />


<script type="text/javascript">
    $(function () {
        //document.body.innerHTML=document.getElementById('print_box').innerHTML;
        window.print();
    });

</script>



