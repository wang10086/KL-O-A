<!--
<div class="box box-warning" id="chengtuan">
    <div class="box-header">
        <h3 class="box-title">成团确认</h3>
    </div>
    <div class="box-body">
        <div class="content">
        	<?php if(count($pretium)>0){ ?>
            <form method="post" action="" id="save_op">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="opid" value="{$op.op_id}">
            <input type="hidden" name="savetype" value="9">
            <div class="form-group col-md-4">
                <label>是否成团：</label>
                <select  class="form-control" name="status" id="opstatus" onChange="ctselect()">
                    <option value="1">成团</option>
                    <option value="2">不成团</option>
                </select>
            </div>
            <div class="form-group col-md-4" id="chengtuala">
                <label>项目团号：</label>
                <input type="text" name="gid" id="gid" placeholder="请填写规范团号，如：JQXW20151030" class="form-control" value="{$tuanhao}" />
            </div>
            <div class="form-group col-md-4" id="buchengtuan" style="display:none;">
                <label>原因</label>
                <input type="text" name="nogroup" id="nogroup"   class="form-control" />
            </div>
            <div class="form-group col-md-4">
                <a href="javascript:;" class="btn btn-info btn-flat" style="margin-top:25px;padding:6px 40px;" onClick="javascript:ConfirmOp('save_op','<?php echo U('Op/public_save'); ?>');">确认操作</a>
            </div>
            </form>
            <?php }else{
			echo '<div class="form-group col-md-12">请对项目标价后再确认是否成团！</div>';	
			} ?>
        </div>
    </div>
</div>
-->