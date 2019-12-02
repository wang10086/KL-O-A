<include file="Index:header_art" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="callout callout-danger">
                        <h4>提示！</h4>
                        <p>客户信息一旦交接，将不可恢复，请谨慎操作！</p>
                    </div>
                </div>

                <form action="{:U('Customer/public_GEC_transfer')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmint" value="1" />
    				<input type="hidden" name="id"    value="{$list.id}" />
                    <div class="form-group box-float-12">客户名称：{$list['company_name']}</div>
                    <div class="form-group box-float-6">招募人：{$list['create_user_name']}</div>
                    <div class="form-group box-float-6">原维护人：{$list['cm_name']?$list['cm_name']:'<font color="#999">暂无维护人</font>'}</div>
                    <div class="form-group box-float-12">
                        <label>接收人员</label>
                        <input type="text" name="info[cm_name]" class="form-control" id="cm_name" />
                        <input type="hidden" name="info[cm_id]" class="form-control" id="cm_id" />
                    </div>
                </form>

            </div>
        </section>
        

<include file="Index:footer" />
<script>
    $(document).ready(function(e){
        var keywords = {$userkey};
        autocomplete_id('cm_name','cm_id',keywords);
    });

</script>