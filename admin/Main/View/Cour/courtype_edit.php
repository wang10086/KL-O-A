<include file="Index:header_art" />

		 <script type="text/javascript">
        window.gosubmint= function(){
			$('#gosub').submit();
		 } 
        </script>
       
        <section class="content">
            <div class="row">
                <form method="post" action="{:U('Cour/courtype_edit')}" name="myform" id="gosub">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="editid" value="{$row.type_id}">
                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="form-group box-float-12">
                        <input type="text" name="info[type_name]" placeholder="类型名称" value="{$row.type_name}" class="form-control"/>
                    </div>
                    
                    
                </form>
            
            </div>
        </section>


        <include file="Index:footer2" />