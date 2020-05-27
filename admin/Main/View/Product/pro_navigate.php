
<div class="btn-group" id="catfont">
<?php if (($list['process'] == 0 && cookie('userid')==$list['create_user']) || in_array(cookie('userid'), array(1,11))){ ?>
    <a href="{:U('Product/public_pro_need_follow')}" class="btn <?php if(in_array(ACTION_NAME, array('public_pro_need_follow','public_pro_need_detail'))){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品方案需求</a>
<?php }else{ ?>
    <a href="{:U('Product/public_pro_need_detail')}" class="btn <?php if(in_array(ACTION_NAME, array('public_pro_need_follow','public_pro_need_detail'))){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品方案需求</a>
<?php } ?>
    <a href="{:U('Op/public_pro_index')}" class="btn <?php if(ACTION_NAME=='public_pro_index'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目方案跟进</a>
    <a href="{:U('Product/public_scheme')}" class="btn <?php if(ACTION_NAME=='public_scheme'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品实施方案</a>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME==''){ echo 'btn-info';}else{ echo 'btn-default';} ?>">客户需求详情</a>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME==''){ echo 'btn-info';}else{ echo 'btn-default';} ?>">业务实施方案</a>
</div>
