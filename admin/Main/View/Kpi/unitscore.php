<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/unitscore')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$team.id}">
        <input type="hidden" name="pdcaid" value="{$team.pdcaid}">
        
        <div class="form-group box-float-12">
            <span class="biaoti">新学期业务整体实施策划</span>
            
        </div>
        
        <div class="form-group box-float-4">
            <label>评分</label>
            <input type="text" name="info[score]" id="title" value="{$team.score}"  class="form-control" />
        </div>
        
        
        <div class="form-group box-float-12">
            <label>考评人意见</label> 
            <textarea class="form-control" style="height:90px;" name="info[view]">{$team.view}</textarea>
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       