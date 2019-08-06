<!--预算审核人-->
<?php if ($audit_userinfo['ys_audit_status'] == 0 && $audit_usertype ==1){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="op_id" value="{$op.op_id}">
        <input type="hidden" name="jk_id" value="{$jiekuan.id}">
        <input type="hidden" name="jkd_id" value="{$jiekuan.jkd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="3">
        <div class="content">
            <div class="form-group col-md-12">
                <label>预算审批人审核：</label>
                <input type="radio" name="info[ys_audit_status]" value="1" <?php if ($audit_userinfo['ys_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[ys_audit_status]" value="2" <?php if ($audit_userinfo['ys_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea class="form-control"  name="info[ys_remark]">{$audit_userinfo['ys_remark']}</textarea>
            </div>

            <div class="form-group col-md-12" id="shr_qianzi">
                <label>签字：</label>
                <input type="button" onclick="show_qianzi()" value="签字">
            </div>

        </div>

        <div style="width:100%; text-align:center;">
            <input type="submit" class="btn btn-info btn-lg" value = '提交'>
        </div>
    </form>
<?php } ?>

<!--财务主管签字-->
<?php if ($audit_userinfo['ys_audit_status'] == 1 && $jiekuan['audit_status'] == 0 && $audit_usertype ==2){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="op_id" value="{$op.op_id}">
        <input type="hidden" name="jk_id" value="{$jiekuan.id}">
        <input type="hidden" name="jkd_id" value="{$jiekuan.jkd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="4">
        <div class="content">
            <div class="form-group col-md-12">
                <label>财务主管审核：</label>
                <input type="radio" name="info[cw_audit_status]" value="1" <?php if ($audit_userinfo['cw_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[cw_audit_status]" value="2" <?php if ($audit_userinfo['cw_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea class="form-control"  name="info[cw_remark]">{$audit_userinfo['cw_remark']}</textarea>
            </div>

            <div class="form-group col-md-12" id="shr_qianzi">
                <label>签字：</label>
                <input type="button" onclick="show_qianzi()" value="签字">
            </div>

        </div>

        <div style="width:100%; text-align:center;">
            <input type="submit" class="btn btn-info btn-lg" value = '提交'>
        </div>
    </form>
<?php } ?>