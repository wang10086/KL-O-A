<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/editkpi')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="editid" value="{$row.id}">
        <input type="hidden" name="info[kpiid]" value="{$kpi.id}">
        <input type="hidden" name="info[month]" value="{$kpi.month}">
        <div class="form-group box-float-12">
            <label>指标名称 <font color="#FF3300">[必填]</font></label>
            <input type="text" name="info[quota_title]" id="quota_title" value="{$row.quota_title}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>指标内容</label>
            <input type="text" name="info[quota_content]" id="quota_content" value="{$row.quota_content}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-6">
            <label>目标 <font color="#FF3300">[必填]</font></label> 
            <input type="text"  class="form-control"  name="info[target]" value="{$row.target}">
        </div>
        
        <div class="form-group box-float-6">
            <label>权重 <font color="#FF3300">[必填]</font> <font color="#999">剩余权重分:</font><font color="#f30">{$shengyu}分</font></label>
            <input type="text" name="info[weight]" id="title" value="{$row.weight}"  class="form-control" />
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       