<include file="Index:header_art" />

	<script type="text/javascript">
	window.gosubmint= function(){
		$('#gosub').submit();
	} 
	</script>
    
    <div class="box-body art_box-body">
        <form method="post" action="{:U('Kpi/editpdca')}" name="myform" id="gosub">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="info[user_id]" id="user_id" value="{$row.user_id}">

        <div class="form-group box-float-6">
            <label>被考核人员 </label>
            <input type="text" name="info[user_name]" id="user_name" value="{$row.user_name}"  class="form-control" />
        </div>
        
        <div class="form-group box-float-6">
            <label>考核周期</label>
            <input type="text" name="info[complete_time]" id="complete_time" value="{$row.complete_time}"  class="form-control" />
        </div>
        
        <!--<div class="form-group box-float-4">
            <label>权重 <font color="#FF3300">[必填]</font> <font color="#999">剩余权重分:</font><font color="#f30">{$shengyu}分</font></label>
            <input type="text" name="info[weight]" id="title" value="{$row.weight}"  class="form-control" />
        </div>-->
        
        <div class="form-group box-float-12">
            <label>考核名称</label>
            <textarea class="form-control" style="height:90px;" name="info[standard]">{$row.standard}</textarea>
        </div>
        
        <div class="form-group box-float-12">
            <label>考核内容</label>
            <textarea class="form-control" style="height:90px;" name="info[method]">{$row.method}</textarea>
        </div>
        </form>
        
                             
    </div>                  
    
    <include file="Index:footer" />

<script type="text/javascript">
    let keywords    = <?php echo $userkey; ?>;
    $(function () {
        autocomplete_id('user_name','user_id',keywords);
    })


</script>