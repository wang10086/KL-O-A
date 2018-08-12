<div class="box-body" style="margin-bottom: -40px;">
    <form method="post" action="<?php echo U('Op/public_save'); ?>" id="save_product">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="14">
    <div class="content" id="productlist" style="display:block;">
        <table class="table table-striped">
        <thead>
            <tr>
                <th width="100">模块</th>
                <th width="80">类别</th>
                <th width="120">科学领域</th>
                <th width="80">来源</th>
                <th width="120">适合年龄</th>
                <th width="100">核算方式</th>
                <th width="100">参考价</th>
                <th width="20">&nbsp;</th>
                <th width="50">数量</th>
                <th width="100">参考费用</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="product_need" item="v">
                <tr class="expense" id="product_id_{$v.id}">
                    <td><input type="hidden" name="resid[2000{$v.id}][id]" value="{$v.id}" >
                    <input type="hidden" name="costacc[20000{$v.id}][type]" value="{$v.type}">
                    <input type="hidden" name="costacc[20000{$v.id}][title]" value="{$v.title}">
                    <input type="hidden" name="costacc[20000{$v.id}][product_id]" value="{$v.product_id}">
                    <a href="javascript:;" onClick="open_product({$v.product_id},{$v.product.title})">{$v.title}</a></td>
                    <td>{$product_type[$v[ptype]]}</td>
                    <td>{$subject_fields[$v[subject_field]]}</td>
                    <td>{$product_from[$v[from]]}</td>
                    <td>{$v.age_list}</td>
                    <td>{$reckon_mode[$v[reckon_mode]]}</td>
                    <td><input type="text" name="costacc[20000{$v.id}][unitcost]" placeholder="价格" value="{$v.unitcost}" class="form-control min_input cost" readonly /></td>
                    <td><span>X</span></td>
                    <td><input type="text" name="costacc[20000{$v.id}][amount]" placeholder="数量" value="{$v.amount}" class="form-control min_input amount" /></td>
                    <td class="total">&yen;{$v.total}</td>
                    <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('product_id_{$v.id}')">删除</a></td></tr>
                </tr>
            </foreach>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="11">
                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="selectproduct(56)"><i class="fa fa-fw  fa-plus"></i> 选择产品模块</a>
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_product','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    </form> 
</div><!-- /.box-body -->