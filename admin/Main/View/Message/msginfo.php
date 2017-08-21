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
                <span><font color="#999999">发送时间：{$row.send_time|date='Y-m-d H:i:s',###} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;来自：{$row.send_user}</font> </span>
            </div>
        </div>
       
        
        <div class="fromlist nobor">
            
            <div class="formtexts">{$row.content}</div>
            <if condition="$row['msg_url']">
            <div class="formtexts" style="margin-top:10px;"><a href="{$row.msg_url}" target="_blank">查看详情</a></div>
            </if>
        </div>
       
                             
    </div>                  
    
    <include file="Index:footer" />
        
       