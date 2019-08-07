<form method="post" action="" name="myform" id="save_info_price">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="savetype" value="7">
<div class="content" style="padding-top:0px;">
    <div id="pretium">
    	<div class="userlist">
            <div class="unitbox">价格名称</div>
            <div class="unitbox">销售价</div>
            <div class="unitbox">同行价</div>
            <div class="unitbox">包含成人人数</div>
            <div class="unitbox">包含儿童人数</div>
            <div class="unitbox">备注</div>
        </div>
    	<?php if($pretium){ ?>
        <foreach name="pretium" key="k" item="v">
        <div class="userlist" id="pretium_id_{$v.id}">
            <span class="title"><?php echo $k+1; ?></span>
            <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" >
            <input type="text" class="form-control" name="pretium[888{$v.id}][pretium]" value="{$v.pretium}">
            <input type="text" class="form-control" name="pretium[888{$v.id}][sale_cost]" value="{$v.sale_cost}">
            <input type="text" class="form-control" name="pretium[888{$v.id}][peer_cost]" value="{$v.peer_cost}">
            <input type="text" class="form-control" name="pretium[888{$v.id}][adult]" value="{$v.adult}">
            <input type="text" class="form-control" name="pretium[888{$v.id}][children]" value="{$v.children}">
            <input type="text" class="form-control" name="pretium[888{$v.id}][remark]" value="{$v.remark}">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id_{$v.id}')">删除</a>
        </div>
        </foreach>
        <?php }else{ ?>
        <div class="userlist" id="pretium_id">
            <span class="title">1</span>
            <input type="text" class="form-control" name="pretium[888{$v.id}][pretium]" value="基础价">
            <input type="text" class="form-control" name="pretium[888{$v.id}][sale_cost]" value="">
            <input type="text" class="form-control" name="pretium[888{$v.id}][peer_cost]" value="">
            <input type="text" class="form-control" name="pretium[888{$v.id}][adult]" value="">
            <input type="text" class="form-control" name="pretium[888{$v.id}][children]" value="">
            <input type="text" class="form-control" name="pretium[888{$v.id}][remark]" value="">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
        </div>
        <?php } ?>
    </div>
    <div id="pretium_val">1</div>
    <div class="form-group col-md-12" id="useraddbtns">
        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_pretium()"><i class="fa fa-fw fa-plus"></i> 新增价格政策</a> 
         <a href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_info_price','<?php echo U('Op/public_save_price'); ?>',{$op.op_id});">保存</a>
    </div>
    <div class="form-group">&nbsp;</div>
</div>
</form>