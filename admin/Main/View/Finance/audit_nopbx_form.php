<!--证明验收人-->
<?php if ($audit_userinfo['zm_audit_status'] == 0 && $audit_usertype ==1 && (in_array(cookie('userid'),array($audit_userinfo['zm_audit_userid'],1,11)))){ ?>
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
<?php if ($audit_usertype ==2 && (in_array(cookie('userid'),array($audit_userinfo['manager_userid'],1,11))) && $audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 0 && $baoxiao['audit_status'] == 0){ ?>
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
<?php if ($audit_usertype ==3 && (in_array(cookie('userid'),array($audit_userinfo['ys_audit_userid'],1,11))) && $audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 0 && $baoxiao['audit_status'] == 0){ ?>
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
<?php if ($audit_usertype ==4 && in_array(cookie('userid'),array($audit_userinfo['cw_audit_userid'],1,11)) && $audit_userinfo['zm_audit_status'] == 1 && $audit_userinfo['manager_audit_status'] == 1 && $audit_userinfo['ys_audit_status'] == 1 && $baoxiao['audit_status'] == 0){ ?>
    <form method="post" action="{:U('Finance/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="bx_id" value="{$baoxiao.id}">
        <input type="hidden" name="bxd_id" value="{$baoxiao.bxd_id}">
        <input type="hidden" name="audit_id" value="{$audit_userinfo.id}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="17">
        <div class="content">
            <div class="form-group col-md-4" id="cy_audit">
                <p><label>财务主管审核：</label></p>
                <input type="radio" name="info[cw_audit_status]" value="1" <?php if ($audit_userinfo['cw_audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[cw_audit_status]" value="2" <?php if ($audit_userinfo['cw_audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-4">
                <label>报销单类型：</label>
                <select class="form-control requir" name="bxdKind" onchange="get_bxd_kind()" required>
                    <option value="">==请选择==</option>
                    <foreach name="bxdkind" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>报销单分类：</label>
                <select class="form-control requir" name="bxd_kind" id="bxd_kind" required>
                    <option value="">==请先选择报销单类型==</option>
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

<script type="text/javascript">
    $(function () {
        $('#cy_audit').find('ins').each(function (index,element) {
            $(this).click(function () {
                stu         = $(this).prev("input[name='info[cw_audit_status]']").val();
                if(stu ==1){ //审核通过
                   $('.requir').attr('required',true);
                }else{
                    $('.requir').attr('required',false);
                }
            })
        })
    })

    function get_bxd_kind() {
        var bxdKind = $("select[name='bxdKind']").val();
        if (!bxdKind){
            art_show_msg('请选择报销单类型');
            return false;
        }else{
            $.ajax({
                type: 'POST',
                url:  "{:U('Ajax/get_bxd_kind')}",
                data: {bxdkind:bxdKind},
                success:function (msg) {
                    var html = '';
                    var i = 0;
                    var count = msg.length;
                    if (msg){
                        html += '<option value="">==请选择==</option>';
                        for(i=0;i<count;i++){
                            html += '<option value="'+ msg[i].id +'">'+ msg[i].name +'</option>';
                        }
                    }else{
                        html += '<option value="">暂无数据</option>';
                    }
                    $('#bxd_kind').html(html);
                }
            })
        }
    }
</script>
