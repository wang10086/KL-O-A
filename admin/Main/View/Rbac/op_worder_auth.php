<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Rbac/op_worder_auth')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="info[worder_auth]" id="worder_auth" value="{$row.worder_auth}">
        
        <div class="form-group box-float-12">
            <label>部门</label>
            <select class="form-control" name="info[role_id]">
                <foreach name="roles" item="v">
                <option value="{$v.id}" <?php if($role['id'] == $v['id']){ echo 'selected';} ?> >{:tree_pad($v['level'])} {$v.role_name}</option>
                </foreach>
            </select>
        </div>
        <div class="form-group box-float-12">
            <label>评分人<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text" value="{$row.worder_auth_name}"  class="form-control keywords" />
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
		   $('#worder_auth').val(item.id);
		});
			
	})
    
    </script>