<include file="Index:header_mini" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <form action="{:U('Worder/audit_resure')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="id"    value="{$id}" />
                    <div class="form-group box-float-12">
                        
                        <input type="radio" name="info[status]" value="3"> 工单已执行 &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="info[status]" value=""> 工单未执行
                        
                    </div>
                </form>
            
            </div>
        </section>
        

<include file="Index:footer" />