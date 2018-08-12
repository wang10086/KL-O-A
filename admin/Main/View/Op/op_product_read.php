<div class="box-body" style="margin-bottom: -40px;">
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
                <th width="50">数量</th>
                <th width="100">参考费用</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="product_need" item="v">
                <tr class="expense" id="product_id_{$v.id}">
                    <td>
                    <a href="javascript:;" onClick="open_product({$v.product_id},{$v.product.title})">{$v.title}</a></td>
                    <td>{$product_type[$v[ptype]]}</td>
                    <td>{$subject_fields[$v[subject_field]]}</td>
                    <td>{$product_from[$v[from]]}</td>
                    <td>{$v.age_list}</td>
                    <td>{$reckon_mode[$v[reckon_mode]]}</td>
                    <td>{$v.unitcost}</td>
                    <td>{$v.amount}</td>
                    <td class="red">&yen;{$v.total}</td>
                </tr>
            </foreach>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="11">
                <!--<a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="selectproduct(56)"><i class="fa fa-fw  fa-plus"></i> 选择产品模块</a>
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_product','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>
                    <input type="submit" value="提交AAA">-->
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
</div><!-- /.box-body -->