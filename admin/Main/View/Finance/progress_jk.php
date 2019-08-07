
<div class="progress-box">
    <span class="pro-tit black">审核进度：</span>
    <font color="green">{$jiekuan.jk_user}</font>
    <?php if ($audit_userinfo['manager_username']){ ?>
        <?php if ($audit_userinfo['manager_audit_status'] == 1){ ?>
            <span class="progress-line-box-green ml10 mr10"></span> <font color="green">{$audit_userinfo.manager_username}</font>
        <?php }elseif($audit_userinfo['manager_audit_status'] == 2){ ?>
            <span class="progress-line-box-red ml10 mr10"></span> <font color="red">{$audit_userinfo.manager_username}</font>
        <?php }else{ ?>
            <span class="progress-line-box-gray ml10 mr10"></span> <font color="#E0E0E0">{$audit_userinfo.manager_username}</font>
    <?php } } ?>

    <?php if ($audit_userinfo['ys_audit_username']){ ?>
        <?php if ($audit_userinfo['ys_audit_status'] == 1){ ?>
            <span class="progress-line-box-green ml10 mr10"></span> <font color="green">{$audit_userinfo.ys_audit_username}</font>
        <?php }elseif($audit_userinfo['ys_audit_status'] == 2){ ?>
            <span class="progress-line-box-red ml10 mr10"></span> <font color="red">{$audit_userinfo.ys_audit_username}</font>
        <?php }else{ ?>
            <span class="progress-line-box-gray ml10 mr10"></span> <font color="#E0E0E0">{$audit_userinfo.ys_audit_username}</font>
    <?php } } ?>

    <?php if ($audit_userinfo['cw_audit_username']){ ?>
        <?php if ($audit_userinfo['cw_audit_status'] == 1){ ?>
            <span class="progress-line-box-green ml10 mr10"></span> <font color="green">{$audit_userinfo.cw_audit_username}</font>
        <?php }elseif($audit_userinfo['cw_audit_status'] == 2){ ?>
            <span class="progress-line-box-red ml10 mr10"></span> <font color="red">{$audit_userinfo.cw_audit_username}</font>
        <?php }else{ ?>
            <span class="progress-line-box-gray ml10 mr10"></span> <font color="#E0E0E0">{$audit_userinfo.cw_audit_username}</font>
    <?php } } ?>
</div>

