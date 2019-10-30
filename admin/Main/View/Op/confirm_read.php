
<div class="content">
    <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
        <!--<tr colspan="3">项目团号：{$confirm.group_id}</tr>-->
        <tr>
            <td width="33.33%">实际出团成人数：{$confirm.num_adult}</td>
            <td width="33.33%">实际出团儿童数：{$confirm.num_children}</td>
            <td width="33.33%">实际出发时间：<if condition="$confirm['dep_time']">{$confirm.dep_time|date='Y-m-d',###}</if></td>
        </tr>
        <tr>
            <td width="33.33%">实际返回时间：<if condition="$confirm['ret_time']">{$confirm.ret_time|date='Y-m-d',###}</if></td>
            <td width="33.33%">实际天数：{$confirm.days}</td>
            <td width="33.33%">是否拼团：<?php echo $op['add_group']==1 ? '拼团' : '不拼团'; ?></td>
        </tr>
    </table>

    <?php if ($op['add_group']==1){ ?>
        <div class="col-md-12" style="padding: 0">
            <label class="lit-title">拼团信息</label>
            <table class="table table-bordered dataTable fontmini" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="taskOptions" width="100">员工姓名</th>
                    <th class="taskOptions">所属部门</th>
                    <th class="taskOptions" width="100">出团人数</th>
                    <th class="taskOptions">备注</th>
                </tr>
                <foreach name="{groups}" item="row">
                    <tr>
                        <td class="taskOptions">{$row.username}</td>
                        <td class="taskOptions">{$businessDep[$row['code']]}</td>
                        <td class="taskOptions">{$row.num}</td>
                        <td class="taskOptions">{$row.remark}</td>
                    </tr>
                </foreach>
            </table>
        </div>
    <?php } ?>
</div>
