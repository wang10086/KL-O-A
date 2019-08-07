<div class="box-body">
    <div class="content" id="opmaterial" style="display:block;">
    <!--<h3>物资申请</h3>-->
    <?php if($wuzi){ ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">物资名称</th>
                <th width="100">单价</th>
                <th width="100">数量</th>
                <th width="100">合计</th>
                <th width="160">备注</th>                                            </tr>
        </thead>
        <tbody>
            
            <foreach name="wuzi" item="v">
            <tr class="expense" id="wuzi_id_{$v.id}">
                <td>{$v.material}</td>
                <td>&yen;{$v.cost}</td>
                <td>{$v.amount}</td>
                <td class="total">¥<?php echo $v['cost']*$v['amount']; ?></td>
                <td>{$v.remarks}</td>
            </tr>
            
            </foreach>
            
        </tbody>
        
    </table>
    <?php }else{ 
		if($budget['audit_status']!=1){
			echo '<div class="form-group" style="padding:20px 0;">预算尚未审批！</div>';
		}else{
			echo '<div class="form-group" style="padding:20px 0;">暂未调度任何物资！</div>';
		}
	} ?>
    </div>
    
    
</div><!-- /.box-body -->