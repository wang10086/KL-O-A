<form method="post" action="{:U('Op/evaluate')}" name="myform" id="appsubmint">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<div class="content" style="padding-bottom:20px;">
	
    <div class="form-group col-md-12">
        <h2 class="brh3r">您对项目中产品进行打分
        <if condition="$cp['uname']">
        <span style="font-weight:normal; color:#333; float:right;">产品负责人：{$cp.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input type="hidden" name="info[1][op_id]" value="{$op.op_id}"/>
        	<input type="hidden" name="info[1][eval_type]" value="1"/>
            <input type="hidden" name="info[1][liable_uid]" value="{$cp.uid}"/>
            <input type="hidden" name="info[1][liable_uname]" value="{$cp.uname}"/>
        	<input id="range_1" type="text" name="info[1][score]" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" name="info[1][evaluate]" style=" height:100px;" placeholder="评价内容">{$cpv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">您对项目中计调进行打分 
        <if condition="$jd['uname']">
        <span style="font-weight:normal; color:#333; float:right;">计调负责人：{$jd.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input type="hidden" name="info[2][op_id]" value="{$op.op_id}"/>
        	<input type="hidden" name="info[2][eval_type]" value="2"/>
            <input type="hidden" name="info[2][liable_uid]" value="{$jd.uid}"/>
            <input type="hidden" name="info[2][liable_uname]" value="{$jd.uname}"/>
        	<input id="range_2" type="text" name="info[2][score]" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" name="info[2][evaluate]" style=" height:100px;" placeholder="评价内容">{$jdv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">您对项目中资源进行打分 
        <if condition="$zy['uname']">
        <span style="font-weight:normal; color:#333; float:right;">资源负责人：{$zy.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input type="hidden" name="info[3][op_id]" value="{$op.op_id}"/>
        	<input type="hidden" name="info[3][eval_type]" value="3"/>
            <input type="hidden" name="info[3][liable_uid]" value="{$zy.uid}"/>
            <input type="hidden" name="info[3][liable_uname]" value="{$zy.uname}"/>
        	<input id="range_3" type="text" name="info[3][score]" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" name="info[3][evaluate]" style=" height:100px;" placeholder="评价内容">{$zyv.evaluate}</textarea>
            
        </div>
    </div>
    
    
    <div class="form-group col-md-12">
        <h2 class="brh3r">您对项目中物资进行打分 
        <if condition="$wz['uname']">
        <span style="font-weight:normal; color:#333; float:right;">物资负责人：{$wz.uname}</span>
        </if>
        </h2>
    </div>
    <div style="width:100%; float:left;">
    	<div class="form-group col-md-12">
        	<input type="hidden" name="info[4][op_id]" value="{$op.op_id}"/>
        	<input type="hidden" name="info[4][eval_type]" value="4"/>
            <input type="hidden" name="info[4][liable_uid]" value="{$wz.uid}"/>
            <input type="hidden" name="info[4][liable_uname]" value="{$wz.uname}"/>
        	<input id="range_4" type="text" name="info[4][score]" value=""/>
        </div>    
        <div class="form-group col-md-12">
        	<textarea class="form-control" name="info[4][evaluate]" style=" height:100px;" placeholder="评价内容">{$wzv.evaluate}</textarea>
            
        </div>
    </div>
    
</div>

<div id="formsbtn" style="padding-bottom:50px;margin-top:0;">
    <div class="content" style="margin-top:0;">
        <button type="s" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存确认</button>
    </div>
</div>

</form>


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
			onChange: function(obj){ 
				//console.log(obj.fromNumber);
			}
		});
		$("#range_2").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$jds},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false
		});
		$("#range_3").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$zys},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false
		});
		$("#range_4").ionRangeSlider({
			min: 0,
			max: 100,
			from: {$wzs},
			type: 'single',
			step: 1,
			postfix: "分",
			prettify: false,
			hasGrid: false
		});
    });
</script>    