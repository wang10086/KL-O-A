<div class="box-body">

    <form method="post" action="" id="save_supplier">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="3">
    <div class="content" id="supplierlist" style="display:block;">
    <!--<h3 style="float:left; width:100px;">合格供方</h3>-->
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">名称</th>
                <th width="80">类型</th>
                <th width="80">地区</th>
                <th width="80">单价</th>
                <th width="20">&nbsp;</th>
                <th width="80">数量</th>
                <th width="100">合计</th>
                <th width="160">备注</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="supplier" item="v">
            <tr class="expense" id="supplier_id_{$v.sid}">
                <td style="vertical-align:middle">
                <input type="hidden" name="cost[30000{$v.sid}][item]" value="{$v.kind}">
                <input type="hidden" name="cost[30000{$v.sid}][remark]" value="{$v.supplier_name}">
                <input type="hidden" name="cost[30000{$v.sid}][cost_type]" value="3">
                <input type="hidden" name="cost[30000{$v.sid}][relevant_id]" value="{$v.supplier_id}">
                <input type="hidden" name="resid[30000{$v.sid}][id]" value="{$v.sid}">
                <input type="hidden" name="supplier[30000{$v.sid}][supplier_id]" value="{$v.supplier_id}">
                <input type="hidden" name="supplier[30000{$v.sid}][supplier_name]" value="{$v.supplier_name}">
                <input type="hidden" name="supplier[30000{$v.sid}][kind]" value="{$v.kind}">
                <input type="hidden" name="supplier[30000{$v.sid}][city]" value="{$v.city}">
                <div class="tdbox"><a href="javascript:;" onClick="open_supplier({$v.supplier_id},'{$v.supplier_name}')">{$v.supplier_name}</a></div>
                </td>
                <td>{$v.kind}</td>
                <td>{$v.city}</td>
                <td><input type="text" name="cost[30000{$v.sid}][cost]" placeholder="价格" value="{$v.cost}" class="form-control min_input cost"></td>
                <td><span>X</span></td>
                <td><input type="text" name="cost[30000{$v.sid}][amount]" placeholder="数量" value="{$v.amount}" class="form-control min_input amount" ></td>
                <td class="total">&yen;<?php echo $v['cost']*$v['amount']; ?></td>
                <td><input type="text" name="supplier[30000{$v.sid}][remark]" value="{$v.sremark}" class="form-control"></td>
                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('supplier_id_{$v.sid}')">删除</a></td>
            </tr>
            </foreach>
            
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="9">
                <a href="javascript:;" class="btn btn-success btn-sm" style=" margin-left:-8px;" onClick="selectsupplier()"><i class="fa fa-fw  fa-plus"></i> 增加合格供方</a> 
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_supplier','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    </form>
  
</div><!-- /.box-body -->