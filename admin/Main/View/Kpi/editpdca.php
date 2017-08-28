<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/editpdca')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="editid" value="{$row.id}">
        <input type="hidden" name="info[pdcaid]" value="{$pdca.id}">
        <input type="hidden" name="info[month]" value="{$pdca.month}">
        <div class="form-group box-float-6">
            <label>计划工作项目 <font color="#FF3300">[必填]</font></label>
            <input type="text" name="info[work_plan]" id="work_plan" value="{$row.work_plan}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-3">
            <label>完成时间</label>
            <input type="text" name="info[complete_time]" id="complete_time" value="{$row.complete_time}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-3">
            <label>权重 <font color="#FF3300">[必填]</font> <font color="#999">剩余权重分:</font><font color="#f30">{$shengyu}分</font></label>
            <input type="text" name="info[weight]" id="title" value="{$row.weight}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>细项及标准 <font color="#FF3300">[必填]</font></label> 
            <textarea class="form-control" style="height:90px;" name="info[standard]">{$row.standard}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>执行方法</label>
            <textarea class="form-control" style="height:90px;" name="info[method]">{$row.method}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>应急问题处理</label>
            <textarea class="form-control" style="height:90px;" name="info[emergency]">{$row.emergency}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>完成情况及未完成原因 <font color="#FF3300">[必填]</font></label>
            <textarea class="form-control" style="height:90px;" name="info[complete]">{$row.complete}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>新策略</label>
            <textarea class="form-control" style="height:90px;" name="info[newstrategy]">{$row.newstrategy}</textarea>
        </div>
        <!--
        <div class="form-group box-float-12">
            <label>新策略未完成情况</label>
            <textarea class="form-control" style="height:90px;" name="info[nocomplete]">{$row.nocomplete}</textarea>
        </div>
        -->
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       