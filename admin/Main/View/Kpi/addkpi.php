<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/addkpi')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="editid" value="{$row.id}">
        <div class="form-group box-float-6">
            <label>月份</label>
            <input type="text" name="info[month]" id="month" value="<?php if($row){ echo $row['month']; }else{ echo date('Ym');} ?>"  class="form-control monthly" />
        </div>
        <div class="form-group box-float-6">
            <label>编制人</label>
            <input type="text" value="<?php if($row){ echo username($row['user_id']); }else{ echo cookie('name');} ?>"  class="form-control" readonly />
        </div>
        
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
       