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
        
        <!--
        <div class="form-group box-float-12">
            <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
            <input type="radio" name="info[status]" value="0" <?php if($row['status']==0){ echo 'checked';} ?> > 奖励 &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="info[status]" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 处罚
            </div>
        </div>
        -->
        <div class="form-group box-float-4">
            <label>责任人员<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text"   name="info[rp_user_name]" value="{$row.rp_user_name}" onClick="selectuser('rp',this)"  class="form-control" />
            <input type="hidden" name="info[rp_user_id]" id="rp_user_id" value="{$row.rp_user_id}">
        	<input type="hidden" name="info[rp_role]" id="rp_role" value="{$row.rp_role}">
       		<input type="hidden" name="info[rp_role_name]" id="rp_role_name" value="{$row.rp_role_name}">
        </div>
        
        <div class="form-group box-float-4">
            <label>所在部门</label>
            <input type="text" name="info[rp_post]" value=""  class="form-control" />
        </div>
        
        <div class="form-group box-float-4">
            <label>直接领导</label>
            <input type="text" name="info[dl]" id="score" value="{$row.dl}"  class="form-control" />
        </div>
        
        
        <div class="form-group box-float-4">
            <label>发现人员<font color="#999999">（可通过姓名拼音快速检索）</font></label>
            <input type="text"   name="info[rp_user_name]" value="{$row.rp_user_name}" onClick="selectuser('rp',this)"  class="form-control" />
            <input type="hidden" name="info[rp_user_id]" id="rp_user_id" value="{$row.rp_user_id}">
        	<input type="hidden" name="info[rp_role]" id="rp_role" value="{$row.rp_role}">
       		<input type="hidden" name="info[rp_role_name]" id="rp_role_name" value="{$row.rp_role_name}">
        </div>
        
        <div class="form-group box-float-4">
            <label>发现时间</label>
            <input type="text" name="info[month]" id="month" value=""  class="form-control monthly" />
        </div>
        
        <div class="form-group box-float-4">
            <label>陪同人员</label>
            <input type="text" name="score" id="score" value="{$row.score}"  class="form-control" />
        </div>
        
        
        <div class="form-group box-float-12">
            <label>不合格事实陈序及违反规定条款</label> 
            <textarea class="form-control" style="height:90px;" name="info[reason]">{$row.reason}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>原因分析</label>
            <textarea class="form-control" style="height:90px;" name="info[joint]">{$row.joint}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>纠正措施的验证</label>
            <textarea class="form-control" style="height:90px;" name="info[joint]">{$row.joint}</textarea>
        </div>
       
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />
    
    <script>
	
	function selectuser(str,obj){
		var keywords = <?php echo $userkey; ?>;	
		$(obj).autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#'+str+'_user_id').val(item.id);
		   $('#'+str+'_role').val(item.role);
		   $('#'+str+'_role_name').val(item.role_name);
		});
		
	}
    $(document).ready(function(e) {
		
		
		
			
	})
    
    </script>
        
       