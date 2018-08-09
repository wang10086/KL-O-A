<div class="box-body">
    <form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_product">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="2">
    <div class="content" id="productlist" style="display:block;">
    <!--<h3 style="float:left; width:100px;">选择产品模块</h3>-->
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="100">模块</th>
                <th width="80">类别</th>
                <th width="80">科学领域</th>
                <th width="80">来源</th>
                <th width="80">适合年龄</th>
                <th width="80">核算方式</th>
                <th width="100">参考价</th>
                <th width="20">&nbsp;</th>
                <th width="160">数量</th>
                <th width="160">参考费用</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="product" item="v">
            <tr class="expense" id="product_id_{$v.id}">
                <td>
                <input type="hidden" name="cost[20000{$v.id}][item]" value="{$v.kind}">
                <input type="hidden" name="cost[20000{$v.id}][cost_type]" value="2">
                <input type="hidden" name="cost[20000{$v.id}][remark]" value="{$v.name}">
                <input type="hidden" name="cost[20000{$v.id}][relevant_id]" value="{$v.product_id}">
                <input type="hidden" name="resid[20000{$v.id}][id]" value="{$v.id}">
                <input type="hidden" name="product[20000{$v.id}][product_id]" value="{$v.product_id}">
                <input type="hidden" name="product[20000{$v.id}][name]" value="{$v.name}">
                <input type="hidden" name="product[20000{$v.id}][kind]" value="{$v.kind}">
                <input type="hidden" name="product[20000{$v.id}][sex]" value="{$v.sex}">
                <a href="javascript:;" onClick="open_product({$v.product_id},'{$v.name}')">{$v.name}</a>
                <i class="fa  fa-calendar" style="color:#3CF; margin-left:8px; cursor:pointer;" onClick="course({$v.product_id},{$op.op_id})"></i>
                </td>
                <td>{$v.kind}</td>
                <td>{$v.sex}</td>
                <td><input type="text" name="cost[20000{$v.id}][cost]" placeholder="价格" value="{$v.cost}" class="form-control min_input cost"></td>
                <td><span>X</span></td>
                <td><input type="text" name="cost[20000{$v.id}][amount]" placeholder="数量" value="{$v.amount}" class="form-control min_input amount" ></td>
                <td class="total">&yen;<?php echo $v['cost']*$v['amount']; ?></td>
                <td><input type="text" name="product[20000{$v.id}][remark]" value="{$v.remark}" class="form-control"></td>
                <td><input type="text" name="product[20000{$v.id}][remark]" value="{$v.remark}" class="form-control"></td>
                <td></td>
                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('product_id_{$v.id}')">删除</a></td></tr>
            </foreach>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="9">
                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="selectproduct(56)"><i class="fa fa-fw  fa-plus"></i> 选择产品模块</a>
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_product','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
               
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    </form> 
</div><!-- /.box-body -->