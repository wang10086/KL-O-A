<include file="Index:header_mini" />


		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <form action="{:U('ScienceRes/resaudit')}" method="post" name="myform" id="myform">

    				<input type="hidden" name="dosubmit" value="1" />
    				<input type="hidden" name="id"    value="{$id}" />
                    <div class="form-group box-float-12">
                        <label>审批</label>
                        <select name="info[status]" class="form-control">
                            <option value="0">请选择</option>
                            <option value="1">通过</option>
                            <option value="2">不通过</option>
                        </select>
                    </div>
                    
                    <div class="form-group box-float-12">
                        <label>备注</label>
                        <textarea class="form-control" name="info[audit_remark]" style="height:100px;">{$row.remarks}</textarea>
                    </div>
                </form>
            
            </div>
        </section>
        

<include file="Index:footer" />