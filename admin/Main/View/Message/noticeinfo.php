<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
       
        <div class="fromlist fromlistbrbr">
            <div class="formtexts">
            	<h4>{$row.title}</h4>
                <span><font color="#999999">公布时间：{$row.send_time|date='Y-m-d H:i:s',###}</font></span>
            </div>
        </div>
       
        
        <div class="fromlist nobor">
            
            <div class="formtexts">{$row.content}</div>
        </div>
       
                             
    </div>                  
    
    <include file="Index:footer" />
        
       