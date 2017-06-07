<div class="box-body">

    <div class="content" id="supplierlist" style="display:block;">
    <!--<h3 style="float:left; width:100px;">合格供方</h3>-->
    <?php if($supplier){ ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">名称</th>
                <th width="100">类型</th>
                <th width="100">地区</th>
                <th width="100">单价</th>
                <th width="100">数量</th>
                <th width="100">合计</th>
                <th width="160">备注</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="supplier" item="v">
            <tr class="expense" id="supplier_id_{$v.id}">
                <td><a href="javascript:;" onClick="open_supplier({$v.supplier_id},'{$v.supplier_name}')">{$v.supplier_name}</a></td>
                <td>{$v.kind}</td>
                <td>{$v.city}</td>
                <td>&yen;{$v.cost}</td>
                <td>{$v.amount}</td>
                <td class="total">&yen;<?php echo $v['cost']*$v['amount']; ?></td>
                <td>{$v.sremark}</td>
            </tr>
            </foreach>
            
        </tbody>
    </table>
    <?php }else{ 
		if($budget['audit_status']!=1){
			echo '<div class="form-group" style="padding:20px 0;">预算尚未审批！</div>';
		}else{
			echo '<div class="form-group" style="padding:20px 0;">暂未调度任何合格供方！</div>';
		}
	} ?>
    </div>
  
    
</div><!-- /.box-body -->