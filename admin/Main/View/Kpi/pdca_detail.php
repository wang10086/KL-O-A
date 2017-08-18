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
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$row.work_plan}</h4>
                <span class="fr">完成时间：{$row.complete_time}</span>
                <span class="fr">权重：{$row.weight}&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
        </div>
       
        
        <div class="fromlist">
            <label class="fromtitle">细项及标准：</label> 
           <span class="formtexts">{$row.standard}</span>
        </div>
        
        <div class="fromlist">
            <label class="fromtitle">执行方法：</label>
            <span class="formtexts">{$row.method}</span>
        </div>
        
        <div class="fromlist">
            <label class="fromtitle">应急问题处理：</label>
            <span class="formtexts">{$row.emergency}</span>
        </div>
        
        <div class="fromlist">
            <label class="fromtitle">新策略：</label>
            <span class="formtexts">{$row.newstrategy}</span>
        </div>
        
        <div class="fromlist">
            <label class="fromtitle">新策略完成情况完成情况：</label>
            <span class="formtexts">{$row.complete}</span>
        </div>
        
        <div class="fromlist">
            <label class="fromtitle">新策略未完成情况：</label>
            <span class="formtexts">{$row.nocomplete}</span>
        </div>
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       