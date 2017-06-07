<form method="post" action="{:U('Finance/save_appcost')}" name="myform" id="save_appcost">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
<div class="content" style="padding-top:0px;">
    <div id="costacc">
        <div class="userlist">
            <div class="unitbox">费用项</div>
            <div class="unitbox">单价</div>
            <div class="unitbox">数量</div>
            <div class="unitbox">合计</div>
            <div class="unitbox">类型</div>
            <div class="unitbox longinput">备注</div>
        </div>
        
        <foreach name="costacc" key="k" item="v">
        <div class="userlist cost_expense" id="costacc_id_b_{$k}">
            <span class="title"><?php echo $k+1; ?></span>
            <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
            <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
            <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
            <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.amount}">
            <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
            <select class="form-control"  name="costacc[888{$k}][type]" >
                <option value="1" <?php if($v['type']==1){ echo 'selected';} ?> >物资</option>
                <option value="2" <?php if($v['type']==2){ echo 'selected';} ?> >专家辅导员</option>
                <option value="3" <?php if($v['type']==3){ echo 'selected';} ?> >合格供方</option>
                <option value="4" <?php if($v['type']==4){ echo 'selected';} ?> >其他</option>
            </select>
            <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$v.remark}">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_b_{$k}')">删除</a>
        </div>
        </foreach>
        
    </div>
    <div id="costacc_sum">
        <div class="userlist">
            <div class="unitbox"></div>
            <div class="unitbox"></div>
            <div class="unitbox" style="  text-align:right;">合计</div>
            <div class="unitbox" id="costaccsum"></div>
            <div class="unitbox longinput"></div>
        </div>
    </div>
    <div id="costacc_val">1</div>
    <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增预算项</a> 
        
    </div>
    <div class="form-group">&nbsp;</div>
</div>




<div class="content">
    <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
    <input type="hidden" name="info[name]" value="{$op.project}" />
    <input type="hidden" name="info[budget]" id="costaccsumval" value="{$op.costacc}" />
    <input type="hidden" name="budget" value="{$budget.id}" />
    <div style="width:100%; float:left;">
        <div class="form-group col-md-4">
            <label>人数：</label>
            <input type="text" name="info[renshu]" id="renshu" class="form-control" value="<?php if($budget['renshu']){ echo $budget['renshu'];}else{ echo $op['number'];} ?>" onBlur="lilv()" />
        </div>
        
        <div class="form-group col-md-4">
            <label>预算收入：</label>
            <input type="text" name="info[shouru]" id="shouru" class="form-control" value="<?php if($budget['shouru']){ echo $budget['shouru'];}else{ echo 0;} ?>" onBlur="lilv()"/> 
        </div>
        
        <div class="form-group col-md-4">
            <label>收入性质：</label>
            <div style="margin-top:5px;">
                <input type="checkbox" name="xinzhi[]" <?php if(in_array('单位',$budget['xz'])){ echo 'checked';} ?> value="单位"> 单位 &nbsp;&nbsp;
                <input type="checkbox" name="xinzhi[]" <?php if(in_array('个人',$budget['xz'])){ echo 'checked';} ?> value="个人"> 个人 &nbsp;&nbsp;
                <input type="checkbox" name="xinzhi[]" <?php if(in_array('政府',$budget['xz'])){ echo 'checked';} ?> value="政府"> 政府 &nbsp;&nbsp;
            </div>
            
        </div>
    </div>
    <div style="width:100%;float:left; padding-bottom:50px;">
        <div class="form-group col-md-4">
            <label>毛利：</label>
            <input type="text" name="info[maoli]" id="maoli" class="form-control" value="{$budget.maoli}" />
        </div>
        
        <div class="form-group col-md-4">
            <label>毛利率：</label>
            <input type="text" name="info[maolilv]" id="maolilv" class="form-control" value="{$budget.maolilv}" />
        </div>
        
        <div class="form-group col-md-4">
            <label>人均毛利：</label>
            <input type="text" name="info[renjunmaoli]" id="renjunmaoli" class="form-control" value="{$budget.renjunmaoli}" />  
        </div>
    </div>
    
     <div class="content"  style="border-top:2px solid #f39c12; padding-bottom:20px;">
        
        <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                
            <tr>
                <td width="33.33%">审批状态：{$op.showstatus}</td>
                <td width="33.33%">审批人：{$op.show_user}</td>
                <td width="33.33%">审批时间：{$op.show_time}</td>
            </tr>
            <?php if($op['show_reason']){ ?>
            <tr>
                <td colspan="3">审批说明：{$op.show_reason}</td>
            </tr>
            <?php } ?>
        </table>
        
       
    </div>

</div>
</form>          
                            