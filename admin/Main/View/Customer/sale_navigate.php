<div class="btn-group" id="catfont">
    <a href="{:U('Customer/public_sale_detail',array('id'=>$list['id']))}" class="btn <?php if(ACTION_NAME=='public_sale_detail'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">销售支持计划</a>
    <a href="{:U('Customer/public_salePro_add',array('id'=>$list['id']))}" class="btn <?php if(ACTION_NAME=='public_salePro_add'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">销售支持方案</a>
</div>
