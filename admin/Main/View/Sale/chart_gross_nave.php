<div class="btn-group" id="catfont">
    <a href="{:U('Sale/chart_gross')}" class="btn <?php if(ACTION_NAME=='chart_gross'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司毛利率</a>
    <a href="{:U('Sale/chart_jd_gross')}" class="btn <?php if(ACTION_NAME=='chart_jd_gross'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">各计调毛利率</a>
</div>

<div class="btn-group" id="catfont" style="float: right; clear: right;">
    <?php for ($i = 2018; $i <= date('Y'); $i++){ ?>
        <a href="<?php echo U('Sale/'.ACTION_NAME , array('year'=>$i)) ?>" class="btn <?php if($year==$i){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$i}年</a>
    <?php } ?>
</div>
