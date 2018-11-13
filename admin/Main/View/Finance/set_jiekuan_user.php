<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Finance/set_jiekuan_user')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$list.id}">
        <input type="hidden" name="info[jk_audit_user_id]" id="jk_audit_user_id" value="{$row.jk_audit_user_id}">
        
        <div class="form-group box-float-12">
            <label>部门</label>
            <input type="text" class="form-control" value="{$list.department}">
        </div>
        <div class="form-group box-float-12">
            <label>评分人<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text" name="info[jk_audit_user_name]" value="{$row.jk_audit_user_name}"  class="form-control keywords" />
        </div>
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
        
    <script>
    $(document).ready(function(e) {
		var keywords = <?php echo $userkey; ?>;
		
		$(".keywords").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#jk_audit_user_id').val(item.id);
		});
			
	})
    
    </script>