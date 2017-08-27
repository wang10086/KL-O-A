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
            	<h4>{$row.title}</h4>
                <span class="fr">执行月份：{$row.month}</span>
                <span class="fr">类型：{$row.statusstr}</span>
                <span class="fr">分数：{$row.score}</span>
				<span class="fr">发布者：{:username($row['ins_user_id'])}</span>
                <span class="fr" style="border:none;">发布时间：{$row.ins_time|date='Y-m-d H:i',###}</span>
            </div>
        </div>
       
        
        <div class="fromlist nobor">
            <div class="fromtitle">奖惩原因：</div> 
            <div class="formtexts">{$row.reason}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">连带责任：</div>
            <div class="formtexts">{$row.joint}</div>
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       