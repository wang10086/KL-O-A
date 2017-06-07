<include file="Index:header_mini" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <form action="{:U('Rights/audit_req')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="id"    value="{$id}" />
    				<input type="hidden" name="req_type"    value="{$req_type}" />
                    <div class="form-group box-float-12">
                        <label>申请</label>
                    </div>
                    
                    <div class="form-group box-float-12">
                        <label>申请说明</label>
                        <textarea class="form-control" name="info[req_reason]" style="height:100px;"></textarea>
                    </div>
                </form>
            
            </div>
        </section>
        

<include file="Index:footer" />