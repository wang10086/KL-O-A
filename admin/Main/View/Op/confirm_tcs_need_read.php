<div class="content" style="padding: 0; margin-bottom: 20px;">
    <div class="col-md-12">
        <label class="lit-title" >需求记录</label>
        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
            <tr role="row" class="orders" >
                <th class="taskOptions">活动时间</th>
                <th class="taskOptions">活动地点</th>
                <th class="taskOptions">职务信息</th>
                <th class="taskOptions">所属领域</th>
                <th class="taskOptions" width="80">人数</th>
                <th class="taskOptions" width="80">单次价格</th>
                <th class="taskOptions" width="80">合计价格</th>
                <th class="taskOptions">备注</th>
            </tr>
            <foreach name="{guide_price}" item="row">
                <tr>
                    <input type="hidden" name="price_id" value="{$row.id}">
                    <input type="hidden" name="confirm_id" value="{$row.confirm_id}">
                    <td class="taskOptions">{$row.in_begin_day|date='Y-m-d',###}--{$row.in_day|date='Y-m-d',###}</td>
                    <td class="taskOptions">{$row.address}</td>
                    <td class="taskOptions">{$row.gkname}</td>
                    <td class="taskOptions">{$fields[$row['field']]}</td>
                    <td class="taskOptions">{$row.num}</td>
                    <td class="taskOptions">&yen;{$row.price}</td>
                    <td class="taskOptions">&yen;{$row.total}</td>
                    <td class="taskOptions">{$row.remark}</td>
                </tr>
            </foreach>
        </table>
    </div>
</div>




