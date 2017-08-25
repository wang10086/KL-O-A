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
                <span class="fr">权重：{$row.weight}</span>
				<span class="fr">考评人：{:username($pdca['eva_user_id'])}</span>
                <span class="fr">考评得分：{$row.score}</span>
                
                <span class="fr" style="border:none;">编制时间：{$row.create_time|date='Y-m-d H:i:s',###}</span>
            </div>
        </div>
       
        
        <div class="fromlist nobor">
            <div class="fromtitle">细项及标准：</div> 
            <div class="formtexts">{$row.standard}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">执行方法：</div>
            <div class="formtexts">{$row.method}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">应急问题处理：</div>
            <div class="formtexts">{$row.emergency}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">完成情况及未完成原因：</div>
            <div class="formtexts">{$row.newstrategy}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">新策略：</div>
            <div class="formtexts">{$row.complete}</div>
        </div>
        <!--
        <div class="fromlist">
            <div class="fromtitle">新策略未完成情况：</div>
            <div class="formtexts">{$row.nocomplete}</div>
        </div>
        -->
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       