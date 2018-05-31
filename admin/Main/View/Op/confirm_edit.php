<form method="post" action="{:U('Op/confirm')}" name="myform" id="appsubmint">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<div class="content" style="padding-bottom:20px;">
	
    <div style="width:100%; float:left;">
        <div class="form-group col-md-4">
            <label>项目团号：</label>
            <input type="text" name="info[group_id]" id="renshu" class="form-control" value="<?php if($confirm['group_id']){ echo $confirm['group_id'];}else{ echo $op['group_id'];} ?>" />
        </div>
        
        <div class="form-group col-md-4">
            <label>实际出团成人数：</label>
            <input type="text" name="info[num_adult]" id="shouru" class="form-control" value="{$confirm.num_adult}"/> 
        </div>
        <div class="form-group col-md-4">
            <label>实际出团儿童数：</label>
            <input type="text" name="info[num_children]" id="shouru" class="form-control" value="{$confirm.num_children}"/> 
        </div>
    </div>
    <div style="width:100%;float:left;">
        <div class="form-group col-md-4">
            <label>实际出发时间：</label>
            <input type="text" name="info[dep_time]" id="shouru" class="form-control inputdate" value="<if condition="$confirm['dep_time']">{$confirm.dep_time|date='Y-m-d',###}</if>"/> 
        </div>
        <div class="form-group col-md-4">
            <label>实际返回时间：</label>
            <input type="text" name="info[ret_time]" id="shouru" class="form-control inputdate" value="<if condition="$confirm['ret_time']">{$confirm.ret_time|date='Y-m-d',###}</if>"/> 
        </div>
        
        <div class="form-group col-md-4">
            <label>实际天数：</label>
            <input type="text" name="info[days]"  class="form-control" value="{$confirm.days}" />  
        </div>
    </div>
    <div style="width:100%;float:left;">
        <div class="form-group col-md-6">
            <label>活动时间(请填写具体时间)：</label>
            <input type="text" name="info[tcs_time]" class="form-control inputdate_a" value="<if condition="$confirm['tcs_time']">{$confirm.tcs_time|date='Y-m-d H:i:s',###}</if>"/>
        </div>

        <div class="form-group col-md-6">
            <label>活动地点：</label>
            <input type="text" name="info[address]"  class="form-control" value="{$confirm.address}" />
        </div>
    </div>

    <div class="form-group col-md-12"  style="margin-top:20px;">
        <label class="lit-title" >辅导员/教师、专家需求</label>
    </div>
    <div class="form-group col-md-12"></div>
    <div style="width:100%;float:left;">

        <include file="op_tcs_need_edit" />

    </div>

</div>

<div id="formsbtn" style="padding-bottom:10px;margin-top:0;">
    <div class="content" style="margin-top:0;">
        <div id="formsbtn" style="padding-bottom:20px; color:#ff3300;">请确认该项目已经出团，认真填写相关数据，不可反复修改</div>
                                    
        <button type="s" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存确认</button>
    </div>
</div>

</form>
    