<div class="btn-group" id="catfont">
    <a href="{:U('Sale/timely',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='timely'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
    <a href="{:U('Sale/operator_timely',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='operator_timely'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">各计调</a>
</div>