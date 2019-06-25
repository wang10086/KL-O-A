<div class="btn-group" id="catfont">
    <a href="{:U('Sale/timely',array('pin'=>0))}" class="btn <?php if($pin=='0'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司</a>
    <a href="{:U('Sale/timely',array('pin'=>1))}" class="btn <?php if($pin=='1'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">各计调</a>
</div>