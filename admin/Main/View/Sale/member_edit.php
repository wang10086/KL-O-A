<form method="post" action="" id="save_member">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$order.op_id}">
<input type="hidden" name="order_id" value="{$order.order_id}">
<div class="content" style="padding-top:10px;" id="orderxx">
	<h3>订单人数：<?php echo $fornum*$order['amount']; ?>人 (含<?php echo $pretium['adult']*$order['amount']; ?>成人，<?php echo $pretium['children']*$order['amount']; ?>儿童)</h3>
    <div id="mingdan">
        <foreach name="member" key="k" item="v">
        <div class="userlist" id="user_id_{$v.id}">
            <span class="title"><?php echo $k+1; ?></span>
            <input type="hidden" name="resid[90000{$v.id}][id]" value="{$v.id}" >
            <input type="text" placeholder="姓名" class="form-control mem-name" name="member[90000{$v.id}][name]" value="{$v.name}">
            <div class="input-group">
                <span class="input-group-addon">男<input type="radio" name="member[90000{$v.id}][sex]" <?php if($v['sex']=='男'){ echo 'checked';} ?> value="男"></span>
                <span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member[90000{$v.id}][sex]" <?php if($v['sex']=='女'){ echo 'checked';} ?> value="女"></span>
            </div>
            <input type="text" placeholder="证件号码" class="form-control mem-number" name="member[90000{$v.id}][number]" value="{$v.number}">
            <input type="text" placeholder="联系电话" class="form-control mem-tel" name="member[90000{$v.id}][mobile]" value="{$v.mobile}">
            <input type="text" placeholder="家长姓名" class="form-control mem-name" name="member[90000{$v.id}][ecname]" value="{$v.ecname}">
            <input type="text" placeholder="家长电话" class="form-control mem-tel" name="member[90000{$v.id}][ecmobile]" value="{$v.ecmobile}">
            <input type="text" placeholder="单位" class="form-control mem-remark" name="member[90000{$v.id}][remark]" value="{$v.remark}">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('user_id_{$v.id}')">删除</a>
        </div>
        </foreach>
    </div>
    <div id="user_val">1</div>
    <div class="form-group col-md-12" id="useraddbtns" >
        <a href="javascript:;" class="btn btn-success btn-sm" onClick="adduser()" style="margin-left:15px;"><i class="fa fa-fw fa-plus"></i> 新增</a> 
        <a href="javascript:;" class="btn btn-warning btn-sm" onClick="importuser()"><i class="fa fa-sign-in fa-plus"></i> 导入</a>  
        <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_member','<?php echo U('Sale/edit_order'); ?>');">保存</a>
    </div>
    <div class="form-group">&nbsp;</div>
</div>
</form>