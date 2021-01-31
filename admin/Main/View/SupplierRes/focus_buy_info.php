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
            	<h4>{$list.title}</h4>
               <!-- <span class="fr">指标值：{$row.quota_value}</span>
				<span class="fr">考核周期：{$row.cycle}</span>-->
            </div>
        </div>

        <div class="fromlist nobor">
            <div class="fromtitle">指标内容：</div> 
            <div class="formtexts">{$list.content}</div>
        </div>
        
        <div class="fromlist">
            <div class="fromtitle">衡量方法：</div>
            <div class="formtexts">{$list.rules}</div>
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       