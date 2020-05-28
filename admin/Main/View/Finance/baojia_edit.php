
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">项目报价</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="{:U('Finance/save_baojia')}" name="baojiaform" id="baojiaform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="opid" value="{$op.op_id}">
            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />

        <div class="content">
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
        </div>
        </form>

        <div id="formsbtn">
            <button type="button" class="btn btn-info <!--btn-sm-->" onclick="$('#baojiaform').submit()">保存</button>
        </div>
    </div>
</div>

<!--<div id="formsbtn" style="padding-bottom:10px;">
    <a type="button" onclick="submintform()" class="btn btn-info btn-lg" id="lrpd">保存</a>
    <a type="button" onclick="" class="btn btn-warning btn-lg" id="lrpd">提交</a>
</div>-->