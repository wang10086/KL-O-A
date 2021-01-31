<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Finance/set_line_blame')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$list.id}">
        <input type="hidden" name="info[line_blame_uid]" id="line_blame_uid" value="">
        
        <div class="form-group box-float-12">
            <label>部门</label>
            <input type="text" class="form-control" value="{$list.department}">
        </div>
        <div class="form-group box-float-12">
            <label>评分人<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text" name="info[line_blame_name]" value="{$list.line_blame_name}"  class="form-control keywords" />
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
		   $('#line_blame_uid').val(item.id);
		});
			
	})
    
    </script>