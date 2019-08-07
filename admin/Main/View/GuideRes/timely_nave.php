<div class="btn-group" id="catfont">
    <a href="{:U('GuideRes/timely',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='timely'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
    <a href="{:U('GuideRes/operator_timely',array('year'=>$year,'month'=>$month))}" class="btn <?php if(ACTION_NAME=='operator_timely'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">各教务</a>
</div>