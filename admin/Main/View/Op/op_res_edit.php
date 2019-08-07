<div class="box-body">
    
    
    
    <form method="post" action="" id="save_wuzi">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="4">
    <div class="content" id="opmaterial" style="display:block;">
    <!-- <h3>物资申请</h3> -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">物资名称</th>
                <th width="80">单价</th>
                <th width="20">&nbsp;</th>
                <th width="80">数量</th>
                <th width="100">合计</th>
                <th width="160">备注</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            
            <foreach name="wuzi" item="v">
            <tr class="expense" id="wuzi_id_{$v.id}">
                <td>
                <input type="hidden" name="cost[60002{$v.id}][item]" value="物资费">
                <input type="hidden" name="cost[60002{$v.id}][cost_type]" value="4">
                <input type="hidden" name="cost[60002{$v.id}][relevant_id]" value="{$v.material_id}">
                <input type="hidden" name="cost[60002{$v.id}][remark]" value="{$v.material}">
                <input type="hidden" name="resid[60002{$v.id}][id]" value="{$v.id}">
                <input type="hidden" name="wuzi[60002{$v.id}][material]" value="{$v.material}">
                <input type="hidden" name="wuzi[60002{$v.id}][material_id]" value="{$v.material_id}">
                {$v.material}
                </td>
                <td><input type="text" name="cost[60002{$v.id}][cost]" value="{$v.cost}" placeholder="价格" class="form-control min_input cost"></td>
                <td><span>X</span></td>
                <td><input type="text" name="cost[60002{$v.id}][amount]" value="{$v.amount}" placeholder="数量" class="form-control min_input amount"></td>
                <td class="total">¥<?php echo $v['cost']*$v['amount']; ?></td>
                <td><input type="text" name="wuzi[60002{$v.id}][remarks]" value="{$v.remarks}" class="form-control"></td>
                
                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('wuzi_id_{$v.id}')">删除</a></td>
                
            </tr>
            
            </foreach>
            
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="7">
                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;" onClick="selectmaterial()"><i class="fa fa-fw  fa-plus"></i> 物资申请</a> 
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_wuzi','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a></td>
            </tr>
        </tfoot>
    </table>
    </div>
    <div id="wuzi_val">0</div>
    </form>
    
    
</div><!-- /.box-body -->