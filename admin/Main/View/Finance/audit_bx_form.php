<!--证明验收人-->
<?php if ($audit_userinfo['zm_audit_status'] == 0 && ($audit_usertype ==1 || cookie('userid')==11)){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="6">
        <div class="content">
            <div class="form-group col-md-12">
                <label>证明验收人审核：</label>
                <input type="radio" name="info[zm_audit_status]" value="1" <?php if ($audit_userinfo['zm_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[zm_audit_status]" value="2" <?php if ($audit_userinfo['zm_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea class="form-control"  name="info[zm_remark]">{$audit_userinfo['zm_remark']}</textarea>
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

<!--预算审核人签字-->
<?php if ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 0 && $baoxiao['audit_status'] == 0 && ($audit_usertype ==2 || cookie('userid')==11)){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="7">
        <div class="content">
            <div class="form-group col-md-12">
                <label>预算审核人审核：</label>
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
<?php if ($audit_userinfo['ys_audit_status'] == 1 && $baoxiao['audit_status'] == 0 && $audit_usertype ==3){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="8">
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