<form method="post" action="" name="myform" id="save_line_days">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="savetype" value="6">
<div id="task_title">{$linetext}</div>
<div id="task_timu">
    <foreach name="days" key="k" item="v">
    <div class="daylist" id="task_ti_id_{$k}">
        <a class="aui_close" href="javascript:;" style="right:25px;" onclick="del_timu('task_ti_id_{$k}')">×</a>
        <div class="col-md-12 pd">
            <label class="titou"><strong>第<span class="tihao"><?php echo $k+1; ?></span>天</strong></label>
            <div class="input-group"><input type="text" placeholder="所在城市" name="days[1000{$v.id}][citys]" value="{$v.citys}" class="form-control"></div>
            <div class="input-group pads"><textarea class="form-control" placeholder="行程安排" name="days[1000{$v.id}][content]">{$v.content}</textarea></div>
            <div class="input-group"><input type="text" placeholder="房餐车安排" name="days[1000{$v.id}][remarks]" value="{$v.remarks}" class="form-control"></div>
         </div>
    </div>
    </foreach>
   
    
</div>

<div style="display:none" id="task_val"><?php echo count($days_list); ?></div>

<div class="form-group col-md-12" id="addti_btn">
    
    <a href="javascript:;" class="btn btn-warning btn-sm" onClick="selectmodel()" style="margin-left:15px;"><i class="fa fa-sign-in fa-plus"></i> 选择行程线路</a>
    <a href="javascript:;" class="btn btn-success btn-sm" onClick="task(1)" ><i class="fa fa-fw  fa-plus"></i> 加一天</a> 
    <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_line_days','<?php echo U('Op/public_save_line'); ?>',{$op.op_id});">保存</a>
</div>
</form>



