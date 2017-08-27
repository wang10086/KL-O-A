<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/addqa')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="editid" value="{$row.id}">
        <input type="hidden" name="info[rp_user_id]" id="rp_user_id" value="{$row.rp_user_id}">
        <input type="hidden" name="info[rp_role]" id="rp_role" value="{$row.rp_role}">
        <input type="hidden" name="info[rp_role_name]" id="rp_role_name" value="{$row.rp_role_name}">
        <div class="form-group box-float-12">
            <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
            <input type="radio" name="info[status]" value="0" <?php if($row['status']==0){ echo 'checked';} ?> > 奖励 &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="info[status]" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 处罚
            </div>
        </div>
        
        <div class="form-group box-float-6">
            <label>接受奖惩人员<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text" name="info[rp_user_name]" value="{$row.rp_user_name}" id="rp_user_name"  class="form-control keywords" />
        </div>
        
        <div class="form-group box-float-3">
            <label>执行月份</label>
            <input type="text" name="info[month]" id="month" value="{$row.month}"  class="form-control monthly" />
        </div>
        
        <div class="form-group box-float-3">
            <label>奖惩分数<font color="#999999">(整数不允许+-符号)</font></label>
            <input type="text" name="score" id="score" value="{$row.score}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>标题</label>
            <input type="text" name="info[title]" value="{$row.title}" class="form-control" />
        </div>
        
        <div class="form-group box-float-12">
            <label>奖惩原因简述</label> 
            <textarea class="form-control" style="height:90px;" name="info[reason]">{$row.reason}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>连带责任</label>
            <textarea class="form-control" style="height:90px;" name="info[joint]">{$row.joint}</textarea>
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
		   $('#rp_user_id').val(item.id);
		   $('#rp_role').val(item.role);
		   $('#rp_role_name').val(item.role_name);
		});
			
	})
    
    </script>
        
       