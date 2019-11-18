<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('ScienceRes/province_edit')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="id" value="{$list.id}">
        
        <div class="form-group box-float-12">
            <label>省份/城市：</label>{$list.name}
        </div>
        <div class="form-group box-float-12">
            <label>所属部门</label>
            <select name="departmentid" class="form-control">
                <foreach name="departments" key="k" item="v">
                    <option value="{$k}" <?php if ($list['departmentid'] == $k){ echo "selected"; } ?>>{$v}</option>
                </foreach>
            </select>
        </div>
        </form>
    </div>                  
    
    <include file="Index:footer" />