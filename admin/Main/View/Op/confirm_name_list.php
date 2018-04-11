
<div class="content" id="print_2">
    <table width="60%" rules="none" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <th width="20%" class="taskOptions">学生姓名</th>
            <th width="20%" class="taskOptions">家长姓名</th>
            <th width="20%" class="taskOptions">家长电话</th>
            <th width="20%" class="taskOptions">备注</th>
        </tr>
        <foreach name="stu_list" item="v">
            <tr>
                <td class="taskOptions">{$v.name}</td>
                <td class="taskOptions">{$v.ecname}</td>
                <td class="taskOptions">{$v.ecmobile}</td>
                <td class="taskOptions">{$v.remark}</td>
            </tr>
        </foreach>
    </table>
</div>

<div class="content no-print">
    <button class="btn btn-default" onclick="print_part();"><i class="fa fa-print"></i> 打印</button>
    <a href="{:U('Export/member',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>
</div>

<script type="text/javascript">
    function print_part(){
        document.body.innerHTML=document.getElementById('print_1').innerHTML+'<br/>'+document.getElementById('print_2').innerHTML;
        window.print();
    }
</script>