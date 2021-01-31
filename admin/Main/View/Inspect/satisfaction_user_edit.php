<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Inspect/public_save')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="2">
        <input type="hidden" name="savetype" value="2">
        <input type="hidden" name="id" value="{$list.id}">
        
        <div class="form-group box-float-12"></div>
        <div class="form-group box-float-12">
            <label>姓名<font color="#999">（请点击匹配到的内容）</font>：</label>
            <input type="text" name="account_name" class="form-control" value="{$list.account_name}" id="account_name">
            <input type="hidden" name="account_id" class="form-control" value="{$list.account_id}" id="account_id">
        </div>
        <div class="form-group box-float-12">
            <label>所属岗位（注：此岗位信息只在内部人员满意度页面使用，不做他用！）</label>
            <select name="type" class="form-control">
                <option value="1" <?php if ($list['type'] == 1){ echo "selected"; } ?>>管理岗</option>
                <option value="2" <?php if ($list['type'] == 2){ echo "selected"; } ?>>其他岗位</option>
            </select>
        </div>
        </form>
    </div>                  
    
    <include file="Index:footer" />
<script type="text/javascript">
    const userkey = {$userkey};
    autocomplete_id('account_name','account_id',userkey)
</script>