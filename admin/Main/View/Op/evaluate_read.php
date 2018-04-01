<?php 
if($zyv){
?>
<div class="content" style="padding-bottom:20px;">
	
    <div class="form-group col-md-12">
        <h2 class="brh3r">产品评分结果
        <if condition="$cp['uname']">
        <span style="font-weight:normal; color:#333; float:right;">产品负责人：{$cp.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input id="range_1" type="text" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" style=" height:100px;" placeholder="评价内容" readonly>{$cpv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">计调评分结果 
        <if condition="$jd['uname']">
        <span style="font-weight:normal; color:#333; float:right;">计调负责人：{$jd.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input id="range_2" type="text" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" style=" height:100px;" placeholder="评价内容" readonly>{$jdv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">资源评分结果 
        <if condition="$zy['uname']">
        <span style="font-weight:normal; color:#333; float:right;">资源负责人：{$zy.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input id="range_3" type="text" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" style=" height:100px;" placeholder="评价内容" readonly>{$zyv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">物资评分结果 
        <if condition="$wz['uname']">
        <span style="font-weight:normal; color:#333; float:right;">物资负责人：{$wz.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input id="range_4" type="text" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" style=" height:100px;" placeholder="评价内容" readonly>{$wzv.evaluate}</textarea>
            
        </div>
    </div>
    
</div>
<?php }else{ ?>
<div class="content">
	<span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">尚未评分</span>
</div>
<?php } ?>


<script type="text/javascript">
	$(document).ready(function(e) {
        $("#range_1").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$cps},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false,
			from_fixed:false
		});
		$("#range_2").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$jds},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false,
			from_fixed:true
		});
		$("#range_3").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$zys},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false,
			from_fixed:true
		});
		$("#range_4").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$wzs},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false,
			from_fixed:true
		});
    });
</script>    

<!--
<div class="content" style="padding-bottom:20px;">
	
    <div class="form-group col-md-12">
        <h2 class="brh3">产品评分结果</h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	打分结果：{$cpv.score} 分
        </div>    
        <div class="form-group col-md-12">
        	评价内容：{$cpv.evaluate}
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3">计调评分结果 <span style="font-weight:normal; color:#333; float:right;">计调负责人：{$jd.uname}</span></h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	打分结果：{$jdv.score} 分
        </div>    
        <div class="form-group col-md-12">
        	评价内容：{$jdv.evaluate}
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3">资源评分结果 <span style="font-weight:normal; color:#333; float:right;">资源负责人：{$zy.uname}</span></h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	打分结果：{$zyv.score} 分
        </div>    
        <div class="form-group col-md-12">
        	评价内容：{$zyv.evaluate}
            
        </div>
    </div>
    
</div>
-->