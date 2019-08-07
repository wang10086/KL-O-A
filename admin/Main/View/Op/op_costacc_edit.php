<form method="post" action="" name="myform" id="save_costacc">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="savetype" value="10">
<input type="hidden" name="costacctotal" id="costaccsumval" value="0">
<div class="content" style="padding-top:0px;">
    <div id="costacc">
    	<div class="userlist">
            <div class="unitbox">费用项</div>
            <div class="unitbox">单价</div>
            <div class="unitbox">数量</div>
            <div class="unitbox">合计</div>
            <div class="unitbox longinput">备注</div>
        </div>
    	<?php if($costacc){ ?>
        <foreach name="costacc" key="k" item="v">
        <div class="userlist cost_expense" id="costacc_id_{$v.id}">
            <span class="title"><?php echo $k+1; ?></span>
            <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" >
            <input type="text" class="form-control" name="costacc[888{$v.id}][title]" value="{$v.title}">
            <input type="text" class="form-control cost" name="costacc[888{$v.id}][unitcost]" value="{$v.unitcost}">
            <input type="text" class="form-control amount" name="costacc[888{$v.id}][amount]" value="{$v.amount}">
            <input type="text" class="form-control totalval" name="costacc[888{$v.id}][total]" value="{$v.total}">
            <input type="text" class="form-control longinput" name="costacc[888{$v.id}][remark]" value="{$v.remark}">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_{$v.id}')">删除</a>
        </div>
        </foreach>
        <?php }else{ ?>
        <div class="userlist cost_expense" id="costacc_id">
            <span class="title">1</span>
            <input type="text" class="form-control" name="costacc[888{$v.id}][title]" value="">
            <input type="text" class="form-control cost" name="costacc[888{$v.id}][unitcost]" value="0">
            <input type="text" class="form-control amount" name="costacc[888{$v.id}][amount]" value="1">
            <input type="text" class="form-control totalval" name="costacc[888{$v.id}][total]" value="0">
            <input type="text" class="form-control longinput" name="costacc[888{$v.id}][remark]" value="">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id')">删除</a>
        </div>
        <?php } ?>
    </div>
    <div id="costacc_sum">
    	<div class="userlist">
            <div class="unitbox"></div>
            <div class="unitbox"></div>
            <div class="unitbox" style="  text-align:right;">合计</div>
            <div class="unitbox" id="costaccsum"></div>
            <div class="unitbox longinput"></div>
        </div>
    </div>
    <div id="costacc_val">1</div>
    <div class="form-group col-md-12" id="useraddbtns">
        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增成本项</a> 
         <a href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_costacc','<?php echo U('Op/public_save_costacc'); ?>',{$op.op_id});">保存</a>
    </div>
    <div class="form-group">&nbsp;</div>
</div>
</form>