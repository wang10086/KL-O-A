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
        <input type="hidden" name="info[kpi_id]" value="{$kpi.id}">
        <input type="hidden" name="info[month]" value="{$kpi.month}">
        <div class="form-group box-float-12">
            <label>指标名称</label>
            <input type="text" name="info[quota_title]" id="quota_title" value="{$row.quota_title}" disabled class="form-control" />
        </div>
        
        <div class="form-group box-float-6">
            <label>权重</label>
            <input type="text" name="info[weight]" id="title" value="{$row.weight}" disabled class="form-control" />
        </div>
        
        
        <div class="form-group box-float-6">
            <label>目标</label> 
            <input type="text"  class="form-control"  name="info[target]" disabled value="{$row.target}">
        </div>
        
        <div class="form-group box-float-12">
            <label>完成</label> 
            <input type="text"  class="form-control"  name="info[complete]" value="{$row.complete}">
        </div>
        
       
        
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       