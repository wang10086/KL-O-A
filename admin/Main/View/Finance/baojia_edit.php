
<form method="post" action="{:U('Finance/save_baojia')}" name="baojiaform" id="baojiaform">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
    <div class="form-group col-md-4">
        <label>成本价格：</label>
        <div style=" width:100%;">
            <span style="width:65%; float:left;"><input type="text" name="info[real_costacc]" value="<?php echo $costacc_res['real_costacc'] ? $costacc_res['real_costacc'] : $costacc_res['costacc']; ?>" class="form-control" /></span>
            <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" class="form-control" value="{$op.costacc_unit}" placeholder="元" readonly /></span>
        </div>
    </div>

    <div class="form-group col-md-4">
        <label>最低报价：</label>
        <div style=" width:100%;">
            <span style="width:65%; float:left;"><input type="text" name="info[real_min_price]" value="{$costacc_res.real_min_price}" class="form-control" required /></span>
            <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" class="form-control" value="元" placeholder="元" readonly /></span>
        </div>
    </div>

    <div class="form-group col-md-4">
        <label>最高报价：</label>
        <div style=" width:100%;">
            <span style="width:65%; float:left;"><input type="text" name="info[real_max_price]" value="{$costacc_res.real_max_price}"  class="form-control" required /></span>
            <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" value="元"  class="form-control" placeholder="元" readonly /></span>
        </div>
    </div>

    <div class="form-group col-md-12">
        <label>备注：</label><textarea class="form-control"  name="info[remark]">{$costacc_res.remark}</textarea>
    </div>
</form>
<div id="formsbtn">
    <button type="button" class="btn btn-info " onclick="$('#baojiaform').submit()">保存</button>
</div>