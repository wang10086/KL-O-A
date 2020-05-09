<div class="btn-group" id="catfont">
    <?php if ($id){ ?>
        <a href="{:U('Product/edit_line',array('id'=>$id))}" class="btn <?php if(ACTION_NAME=='edit_line'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目方案跟进</a>
    <?php }else{ ?>
        <a href="{:U('Product/add_line')}" class="btn <?php if(ACTION_NAME=='add_line'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">项目方案跟进</a>
    <?php } ?>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME=='widely'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品方案需求</a>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME==''){ echo 'btn-info';}else{ echo 'btn-default';} ?>">产品实施方案</a>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME==''){ echo 'btn-info';}else{ echo 'btn-default';} ?>">客户需求详情</a>
    <a href="{:U('')}" class="btn <?php if(ACTION_NAME==''){ echo 'btn-info';}else{ echo 'btn-default';} ?>">业务实施方案</a>
</div>
