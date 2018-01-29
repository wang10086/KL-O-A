
<div class="content">
    <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">       
        <tr>
            <td width="33.33%">项目团号：{$confirm.group_id}</td>
            <td width="33.33%">实际出团成人数：{$confirm.num_adult}</td>
            <td width="33.33%">实际出团儿童数：{$confirm.num_children}</td>
        </tr>
        <tr>
            <td width="33.33%">实际出发时间：<if condition="$confirm['dep_time']">{$confirm.dep_time|date='Y-m-d',###}</if></td>
            <td width="33.33%">实际返回时间：<if condition="$confirm['ret_time']">{$confirm.ret_time|date='Y-m-d',###}</if></td>
            <td width="33.33%">实际天数：{$confirm.days}</td>
        </tr>
    </table>
</div>
