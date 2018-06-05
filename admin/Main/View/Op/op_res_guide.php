<div class="box-body">
    <div class="content" id="guidelist" style="display:block;">
    <!--<h3 style="float:left; width:100px;">专家辅导员</h3>-->
    <?php if($guide){ ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">姓名</th>
                <th width="100">联系方式</th>
                <th width="130">职务类型</th>
                <th width="120">职能类型</th>
                <th width="100">性别</th>
                <th width="100">费用</th>
                <th width="100">数量</th>
                <th width="100">合计</th>
                <th width="160">备注</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="guide" item="v">
            <tr class="expense" >
                <td><a href="javascript:;" onClick="open_guide({$v.guide_id},'{$v.name}')">{$v.name}</a> <i class="fa  fa-calendar" style="color:#3CF; margin-left:8px; cursor:pointer;" onClick="course({$v.guide_id},{$op.op_id})"></i></td>
                <td>{$v.tel}</td>
                <td>{$v.kind}</td>
                <td>{$v.gpk_name}</td>
                <td>{$v.sex}</td>
                <td>&yen;{$v.cost}</td>
                <td>{$v.amount}</td>
                <!--<td class="total">&yen;{$v.total}</td>-->
                <td class="total">&yen;<?php echo $v['cost']*$v['amount']; ?></td>
                <td>{$v.remark}</td>
            </tr>
            </foreach>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="total">&yen;{$sum_cost}</td>
                <td></td>
            </tr>

        </tbody>
    </table>
    <?php }else{ 
		if($budget['audit_status']!=1){
			echo '<div class="form-group" style="padding:20px 0;">预算尚未审批！</div>';
		}else{
			echo '<div class="form-group" style="padding:20px 0;">暂未调度任何专家或者辅导员！</div>';
		}
	} ?>
    </div>
</div><!-- /.box-body -->