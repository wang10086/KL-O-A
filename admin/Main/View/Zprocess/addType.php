<include file="Index:header_art" />
		<script type="text/javascript">
        window.gosubmint= function(){
			$('#myform').submit();
		 }
        </script>


        <div class="form-group col-md-12"></div>
        <section class="content">
            <div class="row">
                <form action="{:U('Zprocess/addType')}" method="post" name="myform" id="myform">
    				<input type="hidden" name="dosubmint" value="1" />
    				<input type="hidden" name="id"    value="{$list.id}" />
                    <div class="form-group box-float-12">
                        <label>类型</label>
                        <input type="text" name="title" value="{$list.title}" class="form-control" />
                    </div>
                </form>

            </div>
        </section>


<include file="Index:footer" />
