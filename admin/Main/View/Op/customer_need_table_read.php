
<div class="content">
    <div class="form-group col-md-6">
        <label>申请人： {$cneed_edit.input_user_name}</label>
    </div>

    <div class="form-group col-md-6">
        <label>活动名称： {$cneed_edit.title}</label>
    </div>

    <div class="form-group col-md-6">
        <label>实际出发时间：{$cneed_edit['dep_time'] ? $cneed_edit['dep_time']|date='Y-m-d',### : ''}</label>
    </div>

    <div class="form-group col-md-6">
        <label>实际返回时间：{$cneed_edit['ret_time'] ? $cneed_edit['ret_time']|date='Y-m-d',### : ''}</label>
    </div>

    <div class="form-group col-md-12">
        <label>说明原因：{$cneed_edit.why}</label>
    </div>

    <div class="form-group col-md-12">
        <label>变更后的影响：{$cneed_edit.ffect}</label>
    </div>

    <div class="form-group col-md-12">
        <label>变更后的纠正措施：{$cneed_edit.right}</label>
    </div>

    <div class="form-group col-md-12">
        <label>变更前要素：{$cneed_edit.before}</label>
    </div>

    <div class="form-group col-md-12">
        <label>变更后要素：{$cneed_edit.after}</label>
    </div>

    <if condition="$cneed_edit['audit_status']">
        <div class="form-group col-md-6">
            <label>审核人：{$cneed_edit.audit_uname}</label>
        </div>
    </if>

    <if condition="$cneed_edit['audit_status']">
        <div class="form-group col-md-6">
            <label>审核时间：{$cneed_edit.audit_time|date='Y-m-d',###}</label>
        </div>
    </if>

    <if condition="$cneed_edit['audit_remark']">
        <div class="form-group col-md-12">
            <label>审核时间：{$cneed_edit.audit_remark}</label>
        </div>
    </if>

    <?php if ($cneed_edit && $cneed_edit['audit_status'] != 1 && in_array(cookie('userid'), array($cneed_edit['audit_uid'],1))){  ?>
        <P class="border-bottom-line"> 审核</P>
        <form method="post" action="{:U('Op/public_save')}" id="cneed_audit_form">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="savetype" value="25">
            <input type="hidden" name="opid" value="{$op.op_id}">

            <div class="form-group box-float-12">
                <label class="">审核意见：</label>
                <input type="radio" name="status" value="1" <?php if ($cneed_edit['audit_status']==1) echo 'checked'; ?>> &#8194;审核通过 &#12288;&#12288;&#12288;
                <input type="radio" name="status" value="2" <?php if ($cneed_edit['audit_status']==2) echo 'checked'; ?>> &#8194;审核不通过
            </div>

            <div class="form-group box-float-12">
                <label>备注</label>
                <textarea class="form-control" name="audit_remark">{$cneed_edit.audit_remark}</textarea>
            </div>

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#cneed_audit_form').submit()">保存</button>
            </div>
        </form>
    <?php }  ?>
</div>
