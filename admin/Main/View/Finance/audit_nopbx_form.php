<!--证明验收人-->
<?php if ($audit_userinfo['zm_audit_status'] == 0 && ($audit_usertype ==1 || cookie('userid')==11 || C('RBAC_SUPER_ADMIN')==cookie('username'))){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="14">
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

<!--部门主管-->
<?php if ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 0 && $baoxiao['audit_status'] == 0 && ($audit_usertype ==2 || cookie('userid')==11 || C('RBAC_SUPER_ADMIN')==cookie('username'))){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="15">
        <div class="content">
            <div class="form-group col-md-12">
                <label>部门主管：</label>
                <input type="radio" name="info[manager_audit_status]" value="1" <?php if ($audit_userinfo['manager_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[manager_audit_status]" value="2" <?php if ($audit_userinfo['manager_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea class="form-control"  name="info[manager_remark]">{$audit_userinfo['manager_remark']}</textarea>
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

<!--部门分管领导-->
<?php if ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 0 && $baoxiao['audit_status'] == 0 && ($audit_usertype ==3 || cookie('userid')==11 || C('RBAC_SUPER_ADMIN')==cookie('username'))){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="16">
        <div class="content">
            <div class="form-group col-md-12">
                <label>部门分管领导：</label>
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
<?php if ($audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 1 && $baoxiao['audit_status'] == 0 && ($audit_usertype ==4 || C('RBAC_SUPER_ADMIN')==cookie('username'))){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="17">
        <div class="content">
            <div class="form-group col-md-6">
                <p><label>财务主管审核：</label></p>
                <input type="radio" name="info[cw_audit_status]" value="1" <?php if ($audit_userinfo['cw_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[cw_audit_status]" value="2" <?php if ($audit_userinfo['cw_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-6">
                <label>报销单分类：</label>
                <select class="form-control" name="" id="" required>
                    <option value="">==请选择==</option>
                    <option value="1">住宿</option>
                    <option value="2">用车</option>
                    <option value="3">采买</option>
                </select>
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