<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/kpi_unitscore')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$team.id}">
        <input type="hidden" name="kpiid" value="{$team.kpi_id}">
        
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$team.quota_title}</h4>
                
            </div>
        </div>
        
        
        <div class="form-group box-float-6" style="margin-top:15px;">
            <label>权重</label>
            <input type="text" name="info[weight]" id="title" value="{$team.weight}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-6" style="margin-top:15px;">
            <label>评分 <font color="#999999">建议评分不大于权重分</font></label>
            <input type="text" name="info[score]" id="title" value="{$team.score}"  class="form-control" />
        </div>
        
        
        <div class="form-group box-float-12">
            <label>考评人意见</label> 
            <textarea class="form-control" style="height:90px;" name="info[view]">{$team.view}</textarea>
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       