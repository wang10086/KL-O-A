
<div class="btn-group" id="catfont">
<?php if ($list['process'] == 0 && in_array(cookie('userid'), array(1,11,$list['create_user']))){ ?>
    <a href="{:U('Product/public_pro_need_follow',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(in_array(ACTION_NAME, array('public_pro_need_follow','public_pro_need_detail'))){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品方案需求</a>
<?php }else{ ?>
    <a href="{:U('Product/public_pro_need_detail',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(in_array(ACTION_NAME, array('public_pro_need_follow','public_pro_need_detail'))){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品方案需求</a>
<?php } ?>
    <a href="{:U('Op/plans_follow',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='plans_follow'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目方案跟进</a>
    <a href="{:U('Product/public_scheme',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='public_scheme'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品实施方案</a>
    <a href="{:U('Product/public_customer_need',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='public_customer_need'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">客户需求详情</a>
    <a href="{:U('Op/public_project',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='public_project'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">业务实施方案</a>
    <if condition="rolemenu(array('Op/handover'))">
        <a href="{:U('Op/handover',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='handover'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目交接</a>
    </if>
    <a href="{:U('Op/public_eval',array('opid'=>$opid,'fa'=>1))}" class="btn <?php if(ACTION_NAME=='public_eval'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目评价</a>
</div>
