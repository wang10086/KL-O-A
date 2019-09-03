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
                        <p>项目交接后,该项目该项目所有的收入将转入被交接人员!</p>
                    </div>
                </div>

                <form action="{:U('Customer/change_cm')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="id"    value="{$list.id}" />
                    <div class="form-group box-float-12">
                        <label>接收人员</label>
                        <input type="text" name="info[cm_name]" class="form-control" id="cm_name" value="{$list.cm_name}" />
                        <input type="hidden" name="info[cm_id]" class="form-control" id="cm_id" value="{$list.cm_id}" />
                    </div>
                </form>

            </div>
        </section>
        

<include file="Index:footer" />
<script>
    $(document).ready(function(e){
        var keywords = <?php echo $userkey; ?>;
        autocomplete_id('cm_name','cm_id',keywords);
    });

</script>