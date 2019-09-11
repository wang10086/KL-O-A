<div class="content mt20" style="padding: 0">
    <label class="lit-title" >需求记录</label>
    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
        <tr role="row" class="orders" >
            <th class="sorting" data="" width="">活动时间</th>
            <th class="sorting" data="">活动地点</th>
            <th class="sorting" data="">职务信息</th>
            <!--<th class="sorting" data="">职能类型</th>-->
            <th class="sorting" data="">所属领域</th>
            <th class="sorting" data="" width="80">人数</th>
            <th class="sorting" data="" width="80">单次价格</th>
            <th class="sorting" data="" width="80">合计价格</th>
            <th class="sorting" data="">备注</th>
        </tr>
        <foreach name="{guide_price}" item="row">
            <tr>
                <input type="hidden" name="price_id" value="{$row.id}">
                <input type="hidden" name="confirm_id" value="{$row.confirm_id}">
                <td>{$row.in_begin_day|date='Y-m-d',###}--{$row.in_day|date='Y-m-d',###}</td>
                <td>{$row.address}</td>
                <td>{$row.gkname}</td>
                <!--<td>{$row.gpkname}</td>-->
                <td>{$fields[$row['field']]}</td>
                <td>{$row.num}</td>
                <td>&yen;{$row.price}</td>
                <td>&yen;{$row.total}</td>
                <td>{$row.remark}</td>
            </tr>
        </foreach>
    </table>
</div>




