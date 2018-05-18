<div id="task_title">{$linetext}</div>
<div id="task_timu">
	<?php if($days){ ?>
    <foreach name="days" key="k" item="v">
    <div class="daylist">
         <div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">{$xuhao++}</span>天&nbsp;&nbsp;&nbsp;&nbsp;{$v.citys}</strong></label><div class="input-group pads">{$v.content}</div><div class="input-group">{$v.remarks}</div></div>
    </div>
    </foreach>
     <?php }else{ echo '<div class="content"><div class="form-group col-md-12">暂无线路行程信息！</div></div>';} ?>
</div>